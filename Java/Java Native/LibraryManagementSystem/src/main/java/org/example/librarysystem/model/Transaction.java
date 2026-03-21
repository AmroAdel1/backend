package org.example.librarysystem.model;

import java.time.LocalDate;

public class Transaction {
    private String transactionId;
    private String bookId;
    private String userId;
    private LocalDate borrowDate;
    private LocalDate returnDate;
    private Status status;

    public enum Status { BORROWED, RETURNED }

    public Transaction(String transactionId, String bookId, String userId, LocalDate borrowDate, LocalDate returnDate, Status status) {
      this.transactionId = transactionId;
      this.bookId = bookId;
      this.userId = userId;
      this.borrowDate = borrowDate;
      this.returnDate = returnDate;
      this.status = status;
    }

    // Getters
    public String getTransactionId() { return transactionId; }
    public String getBookId() { return bookId; }
    public String getUserId() { return userId; }
    public LocalDate getBorrowDate() { return borrowDate; }
    public LocalDate getReturnDate() { return returnDate; }
    public Status getStatus() { return status; }

    // Setters
    public void setReturnDate(LocalDate returnDate) { this.returnDate = returnDate; }
    public void setStatus(Status status) { this.status = status; }

    @Override
    public String toString() {
        return String.format("| %-4s | %-7s | %-7s | %-12s | %-12s | %-10s |",
                transactionId, bookId, userId, borrowDate,
                returnDate != null ? returnDate : "N/A", status);
    }
}
