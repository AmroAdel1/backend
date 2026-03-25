package com.example.multi_threaded_app.client;

import java.io.PrintWriter;
import java.util.Scanner;

// reads user input and sends to server    // Thread
public class MessageSender implements Runnable {
    private final PrintWriter out;
    private final Scanner sc;
    private volatile boolean running = true;

    public MessageSender(PrintWriter out) {
        this.out = out;
        this.sc = new Scanner(System.in);
    }

    @Override
    public void run() {
        try {
            while (running) {
                if (sc.hasNextLine()) {
                    String input = sc.nextLine().trim();
//                    if (input.isEmpty()) {
//                        System.out.println("Message cannot be empty.");
//                        continue;                           // re-prompt without sending
//                    }
                    out.println(input);
                    if (input.equalsIgnoreCase("/quit")) {
                        stop();
                    }
                }
            }
        } catch (Exception e) {
            if (running) System.out.println("Sender error: " + e.getMessage());
        }
    }

    public void stop() { running = false; }
}