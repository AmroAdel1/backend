package com.example.multi_threaded_app.server;

import java.io.*;
import java.net.Socket;
import java.util.List;

import com.example.multi_threaded_app.util.MessageFormatter;

// One Per Client
public class ClientHandler implements Runnable {
    private final Socket socket;
    private final ChatServer server;
    private PrintWriter out;
    private BufferedReader in;
    private String username;

    private static final String PRIVATE_MSG_PREFIX = "/pm";
    private static final String QUIT_COMMAND = "/quit";
    private static final String LIST_COMMAND = "/list";

    public ClientHandler(Socket socket, ChatServer server) {
        this.socket = socket;
        this.server = server;
    }

    @Override
    public void run() {
        try {
            in  = new BufferedReader(                       // adds readLine()
                    new InputStreamReader(                  // converts bytes to characters
                            socket.getInputStream()));      // raw bytes from network
            out = new PrintWriter(                                   // adds println(), message sent immediately
                    socket.getOutputStream(), true);        // raw bytes to network

            // Prompt for username
            out.println(MessageFormatter.serverMessage("Welcome! Enter your username: "));
            username = in.readLine();

            while (username == null || username.isBlank()) {    // loop until valid  // client disconnected before entering name
                out.println(MessageFormatter.serverMessage("Username cannot be empty. Enter your username: "));
                username = in.readLine();
            }

//            if (username == null || username.isBlank()) {
//                username = "User_" + socket.getPort();   // fallback if empty
//            }

            // Announce join
            System.out.println(MessageFormatter.serverMessage(username + " connected from " + socket.getInetAddress()));
            server.broadcast(MessageFormatter.serverMessage(username + " has joined the chat!"), this);
            out.println(MessageFormatter.serverMessage("Commands: /list | /pm <username> <message> | /quit"));
            out.println(MessageFormatter.separator());

            // Listen for messages
            String message;
            while ((message = in.readLine()) != null) {
                if (message.isBlank()) {
                    sendMessage(MessageFormatter.serverMessage("Message cannot be empty."));
                    continue;
                }
                if (message.startsWith("/")) {                          // all commands start with /
                    if (message.equalsIgnoreCase(QUIT_COMMAND)) {
                        break;
                    } else if (message.equalsIgnoreCase(LIST_COMMAND)) {
                        listUsers();
                    } else if (message.startsWith(PRIVATE_MSG_PREFIX + " ")) {  // must have space after /pm
                        handlePrivateMessage(message);
                    } else {
                        sendMessage(MessageFormatter.serverMessage("Unknown command: '" + message + "'. " +    // unknown command — tell user instead of broadcasting
                                "Commands: /list | /pm <username> <message> | /quit"));
                    }
                }
                else {
                    String formatted = MessageFormatter.chatMessage(username, message);    // Regular chat message
                    System.out.println(formatted);
                    server.broadcast(formatted, null);   // null = send to ALL including sender
                }
            }
        } catch (IOException e) {
            System.out.println(MessageFormatter.serverMessage("Connection lost with: " + username));   // (username != null ? username : "unknown")
        } finally {
            disconnect();
        }
    }

    // Private Message Handler
    private void handlePrivateMessage(String message) {
        String[] parts = message.split(" ", 3);             // Format: /pm <username> <message>  // split on space

        // Check format
        if (parts.length < 3) {
            sendMessage(MessageFormatter.serverMessage("Usage: /pm <username> <message>"));
            return;
        }

        String targetUsername = parts[1].trim();
        String privateMsg = parts[2].trim();

        // Validate target username
        if (targetUsername.isBlank()) {
            sendMessage(MessageFormatter.serverMessage("Username cannot be empty. Usage: /pm <username> <message>"));
            return;
        }

        // Validate private message
        if (privateMsg.isBlank()) {
            sendMessage(MessageFormatter.serverMessage("Message cannot be empty. Usage: /pm <username> <message>"));
            return;
        }

        ClientHandler target = server.getClientByUsername(targetUsername);

        // Validate target exists
        if (target == null) {
            sendMessage(MessageFormatter.serverMessage("User '" + targetUsername + "' not found or offline."));
        } else if (target == this) {
            sendMessage(MessageFormatter.serverMessage("You can't send a PM to yourself."));
        } else {
            target.sendMessage(MessageFormatter.privateMessage(username, privateMsg));
            sendMessage(MessageFormatter.privateMessage("You → " + targetUsername, privateMsg));
        }
    }

    // List of Connected Users
    private void listUsers() {
        List<String> usernames = server.getConnectedUsernames();
        sendMessage(MessageFormatter.serverMessage("Online users (" + usernames.size() + "): " +
                String.join(", ", usernames)));
    }

    // Disconnect
    private void disconnect() {
        try {
            server.removeClient(this);
            if (username != null) {
                server.broadcast(MessageFormatter.serverMessage(username + " has left the chat."), this);
                System.out.println(MessageFormatter.serverMessage(username + " disconnected."));
            }
            if (!socket.isClosed()) socket.close();
        } catch (IOException e) {
            System.out.println("Error closing socket: " + e.getMessage());
        }
    }

    // Send message to this client
    public void sendMessage(String message) {
        out.println(message);
    }

    public String getUsername() { return username; }
}