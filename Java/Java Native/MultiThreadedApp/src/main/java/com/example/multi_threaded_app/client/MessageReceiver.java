package com.example.multi_threaded_app.client;

import java.io.BufferedReader;
import java.io.IOException;

// listens for incoming messages from server    // Thread
public class MessageReceiver implements Runnable {
    private final BufferedReader in;
    private volatile boolean running = true;

    public MessageReceiver(BufferedReader in) {
        this.in = in;
    }

    @Override
    public void run() {
        try {
            String message;
            while (running && (message = in.readLine()) != null) {
                System.out.println(message);
            }
        } catch (IOException e) {
            if (running) {
                System.out.println("\n[Disconnected from server]");
            }
        }
    }

    public void stop() { running = false; }
}