package com.example.multi_threaded_app.util;

import java.time.LocalTime;
import java.time.format.DateTimeFormatter;

public class MessageFormatter {
    private static final DateTimeFormatter TIME_FORMAT = DateTimeFormatter.ofPattern("HH:mm:ss");

    // Format a regular chat message
    public static String chatMessage(String sender, String message) {
        return String.format("[%s] %s: %s", timestamp(), sender, message);
    }

    // Format a server announcement
    public static String serverMessage(String message) {
        return String.format("[%s] [SERVER] %s", timestamp(), message);
    }

    // Format a private message
    public static String privateMessage(String sender, String message) {
        return String.format("[%s] [PM from %s] %s", timestamp(), sender, message);
    }

    // Separator line
    public static String separator() {
        return "─".repeat(60);
    }

    private static String timestamp() {
        return LocalTime.now().format(TIME_FORMAT);
    }
}