package org.example.librarysystem;

import org.example.librarysystem.config.DBConnection;
import org.example.librarysystem.model.Book;
import org.example.librarysystem.model.Transaction;
import org.example.librarysystem.model.User;
import org.example.librarysystem.service.LibraryService;

import java.util.List;
import java.util.Scanner;

public class Main {
    private final LibraryService service = new LibraryService();
    private final Scanner scanner = new Scanner(System.in);

    // ─── User Operations ──────────────────────────────────────────────────────
    private void addUser() {
        String name = getStringInput("Name: ");
        String email = getStringInput("Email: ");
        String phone = getStringInput("Phone: ");
        User user = new User("", name, email, phone);   // ""(for string) // 0(for int)
        System.out.println(service.getUserDAO().addUser(user) ? "User added." : "Failed.");
    }

    private void viewAllUsers() {
        List<User> users = service.getUserDAO().getAllUsers();
        if (users.isEmpty()) { System.out.println("No users found."); return; }
        System.out.println("+--------+----------------------+---------------------------+--------------+");
        System.out.println("| ID     | Name                 | Email                     | Phone        |");
        System.out.println("+--------+----------------------+---------------------------+--------------+");
        users.forEach(System.out::println);  // short for lambda   // and calls the toString() method
        System.out.println("+--------+----------------------+---------------------------+--------------+");
    }

    private void updateUser() {
        String id = getStringInput("User ID to update: ");
        String name = getStringInput("New Name: ");
        String email = getStringInput("New Email: ");
        String phone = getStringInput("New Phone: ");
        User user = new User(id, name, email, phone);
        System.out.println(service.getUserDAO().updateUser(user) ? "User updated." : "Failed.");
    }

    private void deleteUser() {
        String id = getStringInput("User ID to delete: ");
        System.out.println(service.getUserDAO().deleteUser(id) ? "User deleted." : "Not found.");
    }

    // ─── Book Operations ──────────────────────────────────────────────────────
    private void addBook() {
        String title = getStringInput("Title: ");
        String author = getStringInput("Author: ");
        String genre = getStringInput("Genre: ");
        int qty = getIntInput("Quantity: ", 0, -1);
        Book book = new Book("", title, author, genre, qty, qty);
        System.out.println(service.getBookDAO().addBook(book) ? "Book added." : "Failed.");
    }

    private void viewAllBooks() {
        List<Book> books = service.getBookDAO().getAllBooks();
        if (books.isEmpty()) { System.out.println("No books found."); return; }
        System.out.println("+--------+--------------------------------+----------------------+-----------------+----------+-----------+");
        System.out.println("| ID     | Title                          | Author               | Genre           | Quantity | Available |");
        System.out.println("+--------+--------------------------------+----------------------+-----------------+----------+-----------+");
        books.forEach(System.out::println);
        System.out.println("+--------+--------------------------------+----------------------+-----------------+----------+-----------+");
    }

    private void updateBook() {
        String id = getStringInput("Book ID to update: ");
        String title = getStringInput("New Title: ");
        String author = getStringInput("New Author: ");
        String genre = getStringInput("New Genre: ");
        int qty = getIntInput("New Quantity: ", 0, -1);       // just non-negative
        int avail = getIntInput("New Available: ", 0, qty);   // non-negative AND must not exceed quantity
        Book book = new Book(id, title, author, genre, qty, avail);
        System.out.println(service.getBookDAO().updateBook(book) ? "Book updated." : "Failed.");
    }

    private void deleteBook() {
        String id = getStringInput("Book ID to delete: ");
        System.out.println(service.getBookDAO().deleteBook(id) ? "Book deleted." : "Not found.");
    }

    // ─── Transaction View ─────────────────────────────────────────────────────
    private void viewAllTransactions() {
        List<Transaction> list = service.getTransactionDAO().getAllTransactions();
        if (list.isEmpty()) { System.out.println("No transactions found."); return; }
        System.out.println("+--------+---------+---------+--------------+--------------+------------+");
        System.out.println("| TxID   | Book ID | User ID | Borrow Date  | Return Date  | Status     |");
        System.out.println("+--------+---------+---------+--------------+--------------+------------+");
        list.forEach(System.out::println);
        System.out.println("+--------+---------+---------+--------------+--------------+------------+");
    }


    // ─── Menus ────────────────────────────────────────────────────────────────
    private void printMainMenu() {
        System.out.println("\n╔══════════════════════════════════════╗");
        System.out.println("║              Main Menu               ║");
        System.out.println("╠══════════════════════════════════════╣");
        System.out.println("║  1. Book Management                  ║");
        System.out.println("║  2. User Management                  ║");
        System.out.println("║  3. Borrow / Return                  ║");
        System.out.println("║  4. Exit                             ║");
        System.out.println("╚══════════════════════════════════════╝");
    }

    private void bookMenu() {
        System.out.println("\n╔══════════════════════════════════════╗");
        System.out.println("║         Book Management              ║");
        System.out.println("╠══════════════════════════════════════╣");
        System.out.println("║  1. Add Book                         ║");
        System.out.println("║  2. View All Books                   ║");
        System.out.println("║  3. Update Book                      ║");
        System.out.println("║  4. Delete Book                      ║");
        System.out.println("║  5. Back                             ║");
        System.out.println("╚══════════════════════════════════════╝");
        int choice = getIntInput("Choose Operation: ", 1, 5);
        switch (choice) {
            case 1 -> addBook();
            case 2 -> viewAllBooks();
            case 3 -> updateBook();
            case 4 -> deleteBook();
            case 5 -> System.out.println("Returning to Main Menu...");
        }
    }

    private void userMenu() {
        System.out.println("\n╔══════════════════════════════════════╗");
        System.out.println("║         User Management              ║");
        System.out.println("╠══════════════════════════════════════╣");
        System.out.println("║  1. Add User                         ║");
        System.out.println("║  2. View All Users                   ║");
        System.out.println("║  3. Update User                      ║");
        System.out.println("║  4. Delete User                      ║");
        System.out.println("║  5. Back                             ║");
        System.out.println("╚══════════════════════════════════════╝");
        int choice = getIntInput("Choose Operation: ", 1, 5);
        switch (choice) {
            case 1 -> addUser();
            case 2 -> viewAllUsers();
            case 3 -> updateUser();
            case 4 -> deleteUser();
            case 5 -> System.out.println("Returning to Main Menu...");
        }
    }

    private void transactionMenu() {
        System.out.println("\n╔══════════════════════════════════════╗");
        System.out.println("║         Borrow / Return              ║");
        System.out.println("╠══════════════════════════════════════╣");
        System.out.println("║  1. Borrow Book                      ║");
        System.out.println("║  2. Return Book                      ║");
        System.out.println("║  3. View All Transactions            ║");
        System.out.println("║  4. Back                             ║");
        System.out.println("╚══════════════════════════════════════╝");
        int choice = getIntInput("Choose Transaction: ", 1, 4);
        switch (choice) {
            case 1 -> {
                String bookId = getStringInput("Book ID: ");
                String userId = getStringInput("User ID: ");
                service.borrowBook(bookId, userId);
            }
            case 2 -> {
                String bookId = getStringInput("Book ID: ");
                String userId = getStringInput("User ID: ");
                service.returnBook(bookId, userId);
            }
            case 3 -> viewAllTransactions();
            case 4 -> System.out.println("Returning to Main Menu...");
        }
    }

    // ─── Input Helpers ────────────────────────────────────────────────────────
    // private int getIntInput(String prompt) {
    //     while (true) {
    //         System.out.print(prompt);
    //         if (sc.hasNextInt()) { int v = sc.nextInt(); sc.nextLine(); return v; }
    //         System.out.println("Please enter a valid number.");
    //         sc.nextLine();
    //     }
    // }
    private int getIntInput(String prompt, int min, int max) {
        while (true) {
            System.out.print(prompt);
            String input = scanner.nextLine().trim();
            try {
                int value = Integer.parseInt(input);
                if (value < min) {
                    System.out.println("Value cannot be less than " + min + ".");
                    continue;
                }
                if (max != -1 && value > max) {
                    System.out.println("Value cannot exceed " + max + ".");
                    continue;
                }
                return value;
            } catch (NumberFormatException e) {
                System.out.println("Please enter a valid number: ");
            }
        }
    }

    private String getStringInput(String prompt) {
        while (true) {
            System.out.print(prompt);
            String input = scanner.nextLine().trim();
            if (!input.isEmpty()) return input;
            System.out.println("Input cannot be empty. Please try again.");
        }
    }

    public static void main(String[] args) {
        try {
            Main main = new Main();
            DBConnection.getConnection();
            System.out.println("Connected to database successfully.");
            System.out.println("╔══════════════════════════════════════╗");
            System.out.println("║     Library Management System        ║");
            System.out.println("╚══════════════════════════════════════╝");

            while (true) {
                main.printMainMenu();
                int choice = main.getIntInput("Choose an option: ", 1, 4);
                switch (choice) {
                    case 1 -> main.bookMenu();
                    case 2 -> main.userMenu();
                    case 3 -> main.transactionMenu();
                    case 4 -> {
                        System.out.println("Thank you for using the Library Management System.");
                        System.out.println("Goodbye!");
                        main.scanner.close();
                        return;
                    }
                    default -> System.out.println("Invalid option.");
                }
            }
        } catch (Exception e) {
            System.out.println("Failed to connect to database: " + e.getMessage());
        } finally {
            DBConnection.closeConnection();
        }
    }
}