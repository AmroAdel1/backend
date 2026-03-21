package org.example.librarysystem.service;

import org.example.librarysystem.config.DBConnection;
import org.example.librarysystem.dao.BookDAO;
import org.example.librarysystem.dao.TransactionDAO;
import org.example.librarysystem.dao.UserDAO;
import org.example.librarysystem.model.Book;
import org.example.librarysystem.model.User;

import java.sql.Connection;
import java.sql.SQLException;

public class LibraryService {
    private final BookDAO bookDAO = new BookDAO();
    private final UserDAO userDAO = new UserDAO();
    private final TransactionDAO transactionDAO = new TransactionDAO();

    // ─── Borrow Book (JDBC Transaction) ──────────────────────────────────────
    public void borrowBook(String bookId, String userId) {
        Book book = bookDAO.getBookById(bookId);
        User user = userDAO.getUserById(userId);

        if (book == null) { System.out.println("Book not found."); return; }
        if (user == null) { System.out.println("User not found."); return; }
        if (book.getAvailable() <= 0) {
            System.out.println("No copies available for: " + book.getTitle()); return;
        }
        if (transactionDAO.hasActiveBorrow(bookId, userId)) {
            System.out.println("User already has an active borrow for this book."); return;
        }

        // ── Begin Transaction ─────────────────────────────────────────────────
        try (Connection conn = DBConnection.getConnection()) {
            conn.setAutoCommit(false);  // don't commit until all statements succeed
            try {
                boolean availUpdated = bookDAO.updateAvailability(bookId, -1, conn);      
                boolean txInserted = transactionDAO.insertTransaction(bookId, userId, conn);

                if (availUpdated && txInserted) {
                    conn.commit();
                    System.out.printf("\"%s\" borrowed by %s successfully.%n",
                            book.getTitle(), user.getName());
                } else {
                    conn.rollback();
                    System.out.println("Borrow failed. Transaction rolled back.");
                }
            } catch (SQLException e) {
                conn.rollback();
                System.out.println("Borrow error, rolled back: " + e.getMessage());
            } finally {
                conn.setAutoCommit(true);  // resets auto-commit
            }
        } catch (SQLException e) {
            System.out.println("Connection error: " + e.getMessage());
        }
    }

    // ─── Return Book (JDBC Transaction) ──────────────────────────────────────
    public void returnBook(String bookId, String userId) {
        Book book = bookDAO.getBookById(bookId);
        User user = userDAO.getUserById(userId);

        if (book == null) { System.out.println("Book not found."); return; }
        if (user == null) { System.out.println("User not found."); return; }
        if (!transactionDAO.hasActiveBorrow(bookId, userId)) {
            System.out.println("No active borrow found for this user and book."); return;
        }

        // ── Begin Transaction ─────────────────────────────────────────────────
        try (Connection conn = DBConnection.getConnection()) {
            conn.setAutoCommit(false);
            try {
                boolean availUpdated = bookDAO.updateAvailability(bookId, +1, conn);        
                boolean txUpdated = transactionDAO.returnTransaction(bookId, userId, conn);

                if (availUpdated && txUpdated) {
                    conn.commit();
                    System.out.printf("\"%s\" returned by %s successfully.%n",
                            book.getTitle(), user.getName());
                } else {
                    conn.rollback();
                    System.out.println("Return failed. Transaction rolled back.");
                }
            } catch (SQLException e) {
                conn.rollback();
                System.out.println("Return error, rolled back: " + e.getMessage());
            } finally {
                conn.setAutoCommit(true);
            }
        } catch (SQLException e) {
            System.out.println("Connection error: " + e.getMessage());
        }
    }

    // ─── Expose DAOs to Main ────────────────────────────────────────────────────
    public BookDAO getBookDAO() { return bookDAO; }
    public UserDAO getUserDAO() { return userDAO; }
    public TransactionDAO getTransactionDAO() { return transactionDAO; }
}