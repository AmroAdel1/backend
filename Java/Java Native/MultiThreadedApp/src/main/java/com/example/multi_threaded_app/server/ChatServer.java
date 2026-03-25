package com.example.multi_threaded_app.server;

import java.io.IOException;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.ArrayList;
import java.util.List;
import java.util.concurrent.CopyOnWriteArrayList;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;

import com.example.multi_threaded_app.util.MessageFormatter;

public class ChatServer {
    private static final int PORT = 12345;
    private static final int MAX_THREADS = 50;

    // Thread-safe list of connected clients   // client list
    private static final CopyOnWriteArrayList<ClientHandler> clients = new CopyOnWriteArrayList<>();  // Multiple threads read/write clients simultaneously
    private static final ExecutorService threadPool = Executors.newFixedThreadPool(MAX_THREADS);

    // Broadcast to all (or all except sender)
    public void broadcast(String message, ClientHandler excludedClient) {
        for (ClientHandler client : clients) {
            if (client != excludedClient) {
                client.sendMessage(message);
            }
        }
    }

    // Get client by username
    public ClientHandler getClientByUsername(String username) {
        return clients.stream()
                .filter(c -> username.equalsIgnoreCase(c.getUsername()))
                .findFirst()
                .orElse(null);
    }

    // Get all connected usernames
    public List<String> getConnectedUsernames() {
        List<String> names = new ArrayList<>();
        for (ClientHandler c : clients) {
            if (c.getUsername() != null) names.add(c.getUsername());
        }
        return names;
    }

    // Remove client on disconnect
    public void removeClient(ClientHandler client) {
        clients.remove(client);
    }

    public static void main(String[] args) {
        ChatServer chatServer = new ChatServer();
        System.out.println(MessageFormatter.separator());
        System.out.println("  Chat Server started on port " + PORT);
        System.out.println("  Max concurrent clients: " + MAX_THREADS);
        System.out.println(MessageFormatter.separator());

        // Accepting connections
        try (ServerSocket serverSocket = new ServerSocket(PORT)) {
            while (true) {
                Socket clientSocket = serverSocket.accept();                            // blocks until client connects  // blocks here waiting, client connects, returns Socket
                ClientHandler handler = new ClientHandler(clientSocket, chatServer);    // create ClientHandler
                clients.add(handler);                                                   // add to list
                threadPool.execute(handler); // assign thread from pool                 // execute in thread pool
                System.out.println(MessageFormatter.serverMessage(                      // loop back, wait for next client
                        "New connection from: " + clientSocket.getInetAddress() +  " | Total clients: " + clients.size()));  // chat client socket
            }
        } catch (IOException e) {
            System.out.println("Server error: " + e.getMessage());
        } finally {
            threadPool.shutdown();
        }
    }
}