package org.example.librarysystem.dao;

import org.example.librarysystem.config.DBConnection;
import org.example.librarysystem.model.Transaction;

import java.sql.*;
import java.time.LocalDate;
import java.util.ArrayList;
import java.util.List;

public class TransactionDAO {
    private int nextId = 1;

    private String generateId() {
        return "TXN" + String.format("%03d", nextId++);
    }

    // ─── Insert Transaction ───────────────────────────────────────────────────
    public boolean insertTransaction(String bookId, String userId, Connection conn) throws SQLException {
        String id  = generateId();
        String sql = "INSERT INTO Transactions (transaction_id, book_id, user_id, borrow_date, status) " +
                     "VALUES (?, ?, ?, ?, 'BORROWED')";
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setString(1, id);            
            ps.setString(2, bookId);        
            ps.setString(3, userId);       
            ps.setDate(4, Date.valueOf(LocalDate.now()));
            return ps.executeUpdate() > 0;
        }
    }

    // ─── Return Transaction ───────────────────────────────────────────────────
    public boolean returnTransaction(String bookId, String userId, Connection conn) throws SQLException {
        String sql = "UPDATE Transactions SET return_date=?, status='RETURNED' " +
                     "WHERE book_id=? AND user_id=? AND status='BORROWED' " +  // only active borrows — can't return what's already returned
                     "ORDER BY borrow_date DESC LIMIT 1";       // user borrowed the same book multiple times
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setDate(1, Date.valueOf(LocalDate.now()));
            ps.setString(2, bookId);       
            ps.setString(3, userId);       
            return ps.executeUpdate() > 0;
        }
    }

    // ─── Get All Transactions ─────────────────────────────────────────────────
    public List<Transaction> getAllTransactions() {
        List<Transaction> list = new ArrayList<>();
        String sql = "SELECT * FROM Transactions ORDER BY borrow_date DESC";
        try (Connection conn = DBConnection.getConnection();
             Statement st = conn.createStatement();
             ResultSet rs = st.executeQuery(sql)) {
            while (rs.next()) list.add(mapRow(rs));
        } catch (SQLException e) {
            System.out.println("Error fetching transactions: " + e.getMessage());
        }
        return list;
    }

    // ─── Check Active Borrow ──────────────────────────────────────────────────
    public boolean hasActiveBorrow(String bookId, String userId) {
        String sql = "SELECT COUNT(*) FROM Transactions " +
                     "WHERE book_id=? AND user_id=? AND status='BORROWED'";
        try (Connection conn = DBConnection.getConnection();
             PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setString(1, bookId);       
            ps.setString(2, userId);       
            ResultSet rs = ps.executeQuery();
            if (rs.next()) return rs.getInt(1) > 0;  // reads column 1 — the count value
        } catch (SQLException e) {
            System.out.println("Error checking borrow status: " + e.getMessage());
        }
        return false;
    }

    // ─── Row Mapper ───────────────────────────────────────────────────────────
    private Transaction mapRow(ResultSet rs) throws SQLException {
        Date returnDate = rs.getDate("return_date");
        String statusStr = rs.getString("status");

        // Safe enum conversion
        Transaction.Status status;
        try {
            status = Transaction.Status.valueOf(statusStr.toUpperCase());
        } catch (IllegalArgumentException e) {
            status = Transaction.Status.BORROWED;   // safe fallback
            System.out.println("Unknown status: " + statusStr + " — defaulting to BORROWED");
        }

        return new Transaction(
            rs.getString("transaction_id"),
            rs.getString("book_id"),
            rs.getString("user_id"),
            rs.getDate("borrow_date").toLocalDate(),
            returnDate != null ? returnDate.toLocalDate() : null,
            status
        );
    }
}