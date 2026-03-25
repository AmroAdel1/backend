package com.example.multi_threaded_app.client;

import java.io.*;
import java.net.Socket;
import java.net.UnknownHostException;

import com.example.multi_threaded_app.util.MessageFormatter;

public class ChatClient {
    private static final String SERVER_HOST = "localhost";
    private static final int SERVER_PORT = 12345;

    public static void main(String[] args) {
        System.out.println(MessageFormatter.separator());
        System.out.println("  Connecting to chat server...");
        System.out.println(MessageFormatter.separator());

        try (Socket socket = new Socket(SERVER_HOST, SERVER_PORT)) {
            BufferedReader in = new BufferedReader(new InputStreamReader(socket.getInputStream()));
            PrintWriter out = new PrintWriter(socket.getOutputStream(), true);

            System.out.println("Connected to server at " + SERVER_HOST + ":" + SERVER_PORT);

            // Launch receiver and sender threads
            MessageReceiver receiver = new MessageReceiver(in);
            MessageSender sender = new MessageSender(out);

            Thread receiverThread = new Thread(receiver);
            Thread senderThread = new Thread(sender);

            receiverThread.setDaemon(true); // receiver dies when sender exits
            receiverThread.start();
            senderThread.start();

            senderThread.join(); // wait for user to /quit      // main thread waits here until sender exits
            receiver.stop();      // then stop receiver
            System.out.println("Disconnected from server.");
        } catch (UnknownHostException e) {
            System.out.println("Host not found: " + SERVER_HOST);
        } catch (IOException e) {
            System.out.println("Could not connect to server: " + e.getMessage());
            System.out.println("  Make sure the server is running on port " + SERVER_PORT);
        } catch (InterruptedException e) {
            System.out.println("Connection interrupted.");
            Thread.currentThread().interrupt();
        }
    }
}