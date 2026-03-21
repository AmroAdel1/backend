package org.example.librarysystem.config;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

// Singleton DB connection
public class DBConnection {
  private static final String URL = "jdbc:mysql://localhost:your-port/db_name";
  private static final String USER = "";       // your MySQL username
  private static final String PASSWORD = "";   // your MySQL password

  private static Connection connection;

  // Singleton — reuse the same connection
  public static Connection getConnection() throws SQLException {
    if (connection == null || connection.isClosed()) {
      connection = DriverManager.getConnection(URL, USER, PASSWORD);
    }
    return connection;
  }

  public static void closeConnection() {
    try {
      if (connection != null && !connection.isClosed()) {
        connection.close();
        System.out.println("Database connection closed.");
      }
    } catch (SQLException e) {
      System.out.println("Error closing connection: " + e.getMessage());
    }
  }
}