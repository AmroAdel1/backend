package org.example.librarysystem.model;

public class Book {
    private String bookId;
    private String title;
    private String author;
    private String genre;
    private int quantity;
    private int available;

    public Book(String bookId, String title, String author, String genre, int quantity, int available) {
        this.bookId = bookId;
        this.title = title;
        this.author = author;
        this.genre = genre;
        this.quantity = quantity;
        this.available = available;
    }

    // Getters
    public String getBookId() { return bookId; }
    public String getTitle() { return title; }
    public String getAuthor() { return author; }
    public String getGenre() { return genre; }
    public int getQuantity() { return quantity; }
    public int getAvailable() { return available; }

    // Setters
    public void setBookId(String id) { this.bookId = id; }
    public void setTitle(String title) { this.title = title; }
    public void setAuthor(String author) { this.author = author; }
    public void setGenre(String genre) { this.genre = genre; }
    public void setQuantity(int quantity) { this.quantity = quantity; }
    public void setAvailable(int available) { this.available = available; }

    @Override
    public String toString() {
        return String.format("| %-4s | %-30s | %-20s | %-15s | %-8d | %-9d |",
                bookId, title, author, genre, quantity, available);
    }
}