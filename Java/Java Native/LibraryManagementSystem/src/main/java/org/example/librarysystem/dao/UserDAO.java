package org.example.librarysystem.dao;

import org.example.librarysystem.config.DBConnection;
import org.example.librarysystem.model.User;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class UserDAO {
    private int nextId = 1;

    private String generateId() {
        return "USR" + String.format("%03d", nextId++);
    }

    // ─── Add User ─────────────────────────────────────────────────────────────
    public boolean addUser(User user) {
        String id  = generateId();
        String sql = "INSERT INTO Users (user_id, name, email, phone) VALUES (?, ?, ?, ?)";
        try (Connection conn = DBConnection.getConnection();
            PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setString(1, id);
            ps.setString(2, user.getName());
            ps.setString(3, user.getEmail());
            ps.setString(4, user.getPhone());
            boolean success = ps.executeUpdate() > 0;
            if (success) user.setUserId(id);            // sync ID back to object
            return success;
        } catch (SQLIntegrityConstraintViolationException e) {
            System.out.println(e.getMessage());
            System.out.println("Email already exists: " + user.getEmail());
            return false;
        } catch (SQLException e) {
            System.out.println("Error adding user: " + e.getMessage());
            return false;
        }
    }

    // ─── Get All Users ────────────────────────────────────────────────────────
    public List<User> getAllUsers() {
        List<User> users = new ArrayList<>();
        String sql = "SELECT * FROM Users";
        try (Connection conn = DBConnection.getConnection();
             Statement st = conn.createStatement();
             ResultSet rs = st.executeQuery(sql)) {
            while (rs.next()) users.add(mapRow(rs));
        } catch (SQLException e) {
            System.out.println("Error fetching users: " + e.getMessage());
        }
        return users;
    }

    // ─── Get User by ID ───────────────────────────────────────────────────────
    public User getUserById(String userId) {
        String sql = "SELECT * FROM Users WHERE user_id = ?";
        try (Connection conn = DBConnection.getConnection();
             PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setString(1, userId);                
            ResultSet rs = ps.executeQuery();
            if (rs.next()) return mapRow(rs);
        } catch (SQLException e) {
            System.out.println("Error fetching user: " + e.getMessage());
        }
        return null;
    }

    // ─── Update User ──────────────────────────────────────────────────────────
    public boolean updateUser(User user) {
        String sql = "UPDATE Users SET name=?, email=?, phone=? WHERE user_id=?";
        try (Connection conn = DBConnection.getConnection();
             PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setString(1, user.getName());
            ps.setString(2, user.getEmail());
            ps.setString(3, user.getPhone());
            ps.setString(4, user.getUserId());
            return ps.executeUpdate() > 0;
        } catch (SQLException e) {
            System.out.println("Error updating user: " + e.getMessage());
            return false;
        }
    }

    // ─── Delete User ──────────────────────────────────────────────────────────
    public boolean deleteUser(String userId) {
        String sql = "DELETE FROM Users WHERE user_id = ?";
        try (Connection conn = DBConnection.getConnection();
             PreparedStatement ps = conn.prepareStatement(sql)) {
            ps.setString(1, userId);
            return ps.executeUpdate() > 0;
        } catch (SQLException e) {
            System.out.println("Error deleting user: " + e.getMessage());
            return false;
        }
    }

    // ─── Row Mapper ───────────────────────────────────────────────────────────
    private User mapRow(ResultSet rs) throws SQLException {
        return new User(
            rs.getString("user_id"),
            rs.getString("name"),
            rs.getString("email"),
            rs.getString("phone")
        );
    }
}