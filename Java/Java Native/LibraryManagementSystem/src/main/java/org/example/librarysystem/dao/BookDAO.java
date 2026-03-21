package org.example.librarysystem.dao;

import org.example.librarysystem.config.DBConnection;
import org.example.librarysystem.model.Book;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class BookDAO {
    private int nextId = 1;

    private String generateId() {
        return "BK" + String.format("%03d", nextId++);
    }

    // ─── Add Book ─────────────────────────────────────────────────────────────
    public boolean addBook(Book book) {
        String id  = generateId();          // generate ID before insert
        String sql = "INSERT INTO Books (book_id, title, author, genre, quantity, available) " +
                     "VALUES (?, ?, ?, ?, ?, ?)";
        try (Connection conn = DBConnection.getConnection();
             PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setString(1, id);            // insert generated ID
            ps.setString(2, book.getTitle());
            ps.setString(3, book.getAuthor());
            ps.setString(4, book.getGenre());
            ps.setInt(5, book.getQuantity());
            ps.setInt(6, book.getAvailable());
            boolean success = ps.executeUpdate() > 0;
            if (success) book.setBookId(id); // sync ID back to object   // for use
            return success;
        } catch (SQLException e) {
            System.out.println("Error adding book: " + e.getMessage());
            return false;
        }
    }

    // ─── Get All Books ────────────────────────────────────────────────────────
    public List<Book> getAllBooks() {
        List<Book> books = new ArrayList<>();
        String sql = "SELECT * FROM Books";
        try (Connection conn = DBConnection.getConnection();
             Statement st = conn.createStatement();  // no placeholders needed
             ResultSet rs = st.executeQuery(sql)) {  // Statement doesn't automatically close ResultSet
            while (rs.next()) {   // multiple rows are expected
                books.add(mapRow(rs));
            }
        } catch (SQLException e) {
            System.out.println("Error fetching books: " + e.getMessage());
        }
        return books;
    }

    // ─── Get Book by ID ───────────────────────────────────────────────────────
    public Book getBookById(String bookId) {
        String sql = "SELECT * FROM Books WHERE book_id = ?";
        try (Connection conn = DBConnection.getConnection();
             PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setString(1, bookId);
            ResultSet rs = ps.executeQuery();   // rows of data
            if (rs.next()) return mapRow(rs);   // expects one row
        } catch (SQLException e) {
            System.out.println("Error fetching book: " + e.getMessage());
        }
        return null;
    }

    // ─── Update Book ──────────────────────────────────────────────────────────
    public boolean updateBook(Book book) {
        String sql = "UPDATE Books SET title=?, author=?, genre=?, quantity=?, available=? " +
                     "WHERE book_id=?";
        try (Connection conn = DBConnection.getConnection();
             PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setString(1, book.getTitle());
            ps.setString(2, book.getAuthor());
            ps.setString(3, book.getGenre());
            ps.setInt(4, book.getQuantity());
            ps.setInt(5, book.getAvailable());
            ps.setString(6, book.getBookId());
            return ps.executeUpdate() > 0;    // returns number of rows affected
        } catch (SQLException e) {
            System.out.println("Error updating book: " + e.getMessage());
            return false;
        }
    }

    // ─── Delete Book ──────────────────────────────────────────────────────────
    public boolean deleteBook(String bookId) {
        String sql = "DELETE FROM Books WHERE book_id = ?";
        try (Connection conn = DBConnection.getConnection();
             PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setString(1, bookId);
            return ps.executeUpdate() > 0;
        } catch (SQLException e) {
            System.out.println("Error deleting book: " + e.getMessage());
            return false;
        }
    }

    // ─── Update Availability ─────────────────────────────────────────────────
    public boolean updateAvailability(String bookId, int delta, Connection conn) throws SQLException {
        String sql = "UPDATE Books SET available = available + ? " +  // update available
                     "WHERE book_id = ? AND available + ? >= 0";      // validation
        try (PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setInt(1, delta);   // the change to apply to available count  // +1(return) or -1(borrow)
            ps.setString(2, bookId);
            ps.setInt(3, delta);
            return ps.executeUpdate() > 0;
        }
    }

    // ─── Row Mapper ───────────────────────────────────────────────────────────
    private Book mapRow(ResultSet rs) throws SQLException {   // bridges the gap between database rows and Java objects
        return new Book(
            rs.getString("book_id"),
            rs.getString("title"),
            rs.getString("author"),
            rs.getString("genre"),
            rs.getInt("quantity"),
            rs.getInt("available")
        );
    }
}