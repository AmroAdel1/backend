package com.example.student_management_system;

import java.util.InputMismatchException;
import java.util.List;
import java.util.Scanner;

public class StudentManagementSystem {
    private StudentManager studentManager;
    private Scanner scanner;

    public StudentManagementSystem() {
        this.studentManager = new StudentManager();
        this.scanner = new Scanner(System.in);
    }

    private void addStudent() {
        System.out.println("\n----- Add New Student -----");

        String name = getNameInput("Enter student name: ");
        int age = getAgeInput("Enter student age: ");
        String grade = getGradeInput("Enter student grade: ");
        String email = getEmailInput("Enter student email: ");

        Student student = new Student("", name, age, grade, email);

        if (studentManager.addStudent(student)) {
            System.out.println("Student added successfully!");
        } else {
            System.out.println("Failed to add student. Email might already exist.");
        }
    }

    private void viewAllStudents() {
        System.out.println("\n----- All Students -----");
        List<Student> students = studentManager.getAllStudents();
        
        if (students.isEmpty()) {
            System.out.println("No students found.");
        } else {
            System.out.printf("Total Students: %d\n", studentManager.getStudentCount());
            System.out.println("=" .repeat(80));
            students.forEach(System.out::println);
            //students.forEach(e -> System.out.println(e));     // called toString() method
        }
    }

    private void updateStudent() {
        System.out.println("\n----- Update Student -----");
        String id = getStringInput("Enter student ID to update: ");
        
        Student student = studentManager.getStudentById(id);
        if (student == null) {
            System.out.println("Student with ID " + id + " not found.");
            return;
        }

        System.out.println("Current Student details:");
        System.out.println(student);
        System.out.println("(Press Enter to keep current value)");

        String name = getNameInputWithDefault("Enter new name (current: " + student.getName() + "): ", student.getName());
        int age = getAgeInputWithDefault("Enter new age (current: " + student.getAge() + "): ", student.getAge());
        String grade = getGradeInputWithDefault("Enter new grade (current: " + student.getGrade() + "): ",  student.getGrade());
        String email = getEmailInputWithDefault("Enter new email (current: " + student.getEmail() + "): ", student.getEmail());

        if (studentManager.updateStudent(id, name, age, grade, email)) {
            System.out.println("Student updated successfully!");
        } else {
            System.out.println("Failed to update student. Email might already exist.");
        }
    }

    private void deleteStudent() {
        System.out.println("\n----- Delete Student -----");
        String id = getStringInput("Enter student ID to delete: ");
        
        Student student = studentManager.getStudentById(id);
        if (student == null) {
            System.out.println("Student with ID " + id + " not found.");
            return;
        }

        System.out.println("Student to delete:");
        System.out.println(student);
        
        if (getConfirmationInput("Are you sure you want to delete this student? (yes/no): ")) {
            if (studentManager.deleteStudent(id)) {
                System.out.println("Student deleted successfully!");
            } else {
                System.out.println("Failed to delete student.");
            }
        } else {
            System.out.println("Deletion cancelled.");
        }
    }

    private void searchStudent() {
        System.out.println("\n----- Search Student -----");
        System.out.println("1. Search by ID");
        System.out.println("2. Search by Name");
        int searchChoice = getIntInput("Choose search option: ");
        
        List<Student> results;
        switch (searchChoice) {
            case 1 -> {
                String id = getStringInput("Enter student ID to search: ");
                results = studentManager.searchStudentsById(id);
            }
            case 2 -> {
                String name = getStringInput("Enter student name to search: ");
                results = studentManager.searchStudentsByName(name);
            }
            default -> {
                System.out.println("Invalid search option.");
                return;
            }
        }
        
        if (results.isEmpty()) {
            System.out.println("No students found.");
        } else {
            System.out.println("Search Results (" + results.size() + " found):");
            System.out.println("=" .repeat(80));
            results.forEach(System.out::println);
            //results.forEach(e -> System.out.println(e)); // Fixed ambiguous method ref
        }
    }

    // Utility methods for input handling
    private int getIntInput(String prompt) {
        while (true) {
            try {
                System.out.print(prompt);
                return Integer.parseInt(scanner.nextLine());
            } catch (NumberFormatException e) {
                System.out.println("Please enter a valid number.");
            }
        }
    }

//    private int getIntInputWithDefault(String prompt, int defaultValue) {
//        System.out.print(prompt);
//        String input = scanner.nextLine().trim();
//        if (input.isEmpty()) return defaultValue;
//        try {
//            return Integer.parseInt(input);
//        } catch (NumberFormatException e) {
//            System.out.println("Invalid input. Using default value: " + defaultValue);
//            return defaultValue;
//        }
//    }

    private String getStringInput(String prompt) {
        while (true) {
            System.out.print(prompt);
            String input = scanner.nextLine().trim();
            if (!input.isEmpty()) {
                return input;
            }
            System.out.println("Input cannot be empty. Please try again.");
        }
    }

    private String getNameInput(String prompt) {
        while (true) {
            System.out.print(prompt);
            String input = scanner.nextLine().trim();
            try {
                if (input.isEmpty()) {
                    throw new IllegalArgumentException("Input cannot be empty. Please try again.");
                }

                if (!input.matches("[a-zA-Z ]+")) {
                    throw new InputMismatchException("Name cannot contain numbers or special characters.");
                }

                // Capitalize first letter of each word
                String[] words = input.split(" ");
                StringBuilder capitalizedName = new StringBuilder();
                for (String word : words) {
                    if (!word.isEmpty()) {
                        capitalizedName
                                .append(Character.toUpperCase(word.charAt(0)))
                                .append(word.substring(1).toLowerCase())
                                .append(" ");
                    }
                }

                return capitalizedName.toString().trim();
            }
            catch (IllegalArgumentException e) {
                System.out.println(e.getMessage());
            } catch (InputMismatchException e) {
                System.out.println(e.getMessage());
            }
        }
    }

    private String getNameInputWithDefault(String prompt, String defaultValue) {
        while (true) {
            System.out.print(prompt);
            String input = scanner.nextLine().trim();

            if (input.isEmpty()) return defaultValue;       // Press Enter to keep current value

            try {
                if (!input.matches("[a-zA-Z ]+")) {
                    throw new InputMismatchException("Name cannot contain numbers or special characters.");
                }

                String[] words = input.split(" ");
                StringBuilder capitalizedName = new StringBuilder();
                for (String word : words) {
                    if (!word.isEmpty()) {
                        capitalizedName
                                .append(Character.toUpperCase(word.charAt(0)))
                                .append(word.substring(1).toLowerCase())
                                .append(" ");
                    }
                }
                return capitalizedName.toString().trim();
            } catch (InputMismatchException e) {
                System.out.println(e.getMessage());
            }
        }
    }

    private String getEmailInput(String prompt) {
        while (true) {
            System.out.print(prompt);
            String input = scanner.nextLine().trim();
            try {
                if (input.isEmpty()) {
                    throw new IllegalArgumentException("Input cannot be empty. Please try again.");
                }

                if (!input.matches("[a-zA-Z0-9._\\-]+@[a-zA-Z0-9._\\-]+\\.[a-zA-Z]{2,}")) {
                    throw new InputMismatchException("Invalid email format. (e.g. user@example.com)");
                }

                return input;
            }
            catch (IllegalArgumentException e) {
                System.out.println(e.getMessage());
            } catch (InputMismatchException e) {
                System.out.println(e.getMessage());
            }
        }
    }

    private String getEmailInputWithDefault(String prompt, String defaultValue) {
        while (true) {
            System.out.print(prompt);
            String input = scanner.nextLine().trim();

            if (input.isEmpty()) return defaultValue;       // Press Enter to keep current value

            try {
                if (!input.matches("[a-zA-Z0-9._\\-]+@[a-zA-Z0-9._\\-]+\\.[a-zA-Z]{2,}")) {
                    throw new InputMismatchException("Invalid email format. (e.g. user@example.com)");
                }

                return input;
            } catch (InputMismatchException e) {
                System.out.println(e.getMessage());
            }
        }
    }

    private String getGradeInput(String prompt) {
        while (true) {
            System.out.print(prompt);
            String input = scanner.nextLine().trim();
            try {
                if (input.isEmpty()) {
                    throw new IllegalArgumentException("Input cannot be empty. Please try again.");
                }

                if (!input.matches("[a-zA-Z+]+")) {
                    throw new InputMismatchException("Invalid input. Grade must contain letters only, no numbers or special characters.");
                }

                if (input.matches("(?i)A\\+?|B\\+?|C\\+?|D\\+?|F")) {
                    return input.toUpperCase();
                }
                System.out.println("Please enter a valid grade (A, A+, B, B+, C, C+, D, D+, F).");
            }
            catch (IllegalArgumentException e) {
                System.out.println(e.getMessage());
            } catch (InputMismatchException e) {
                System.out.println(e.getMessage());
            }
        }
    }

    private String getGradeInputWithDefault(String prompt, String defaultValue) {
        while (true) {
            System.out.print(prompt);
            String input = scanner.nextLine().trim();

            if (input.isEmpty()) return defaultValue;            // Press Enter to keep current value

            try {
                if (!input.matches("[a-zA-Z+]+")) {
                    throw new InputMismatchException("Invalid input. Grade must contain letters only, no numbers or special characters.");
                }

                if (input.matches("(?i)A\\+?|B\\+?|C\\+?|D\\+?|F")) {
                    return input.toUpperCase();
                }
                System.out.println("Please enter a valid grade (A, A+, B, B+, C, C+, D, D+, F).");

            } catch (InputMismatchException e) {
                System.out.println(e.getMessage());
            }
        }
    }

    private int getAgeInput(String prompt) {
        while (true) {
            System.out.print(prompt);
            String input = scanner.nextLine().trim();
            if (input.isEmpty()) {
                System.out.println("Input cannot be empty. Please try again.");
                continue;
            }
            try {
                int value = Integer.parseInt(input);
                if (value > 0 && value < 100) {
                    return value;
                }
                System.out.println("Invalid input. Age must be between 0 and 100.");
            } catch (NumberFormatException e) {
                System.out.println("Invalid input. Enter a number.");
            }
        }
    }

    private int getAgeInputWithDefault(String prompt, int defaultValue) {
        while (true) {
            System.out.print(prompt);
            String input = scanner.nextLine().trim();

            if (input.isEmpty()) return defaultValue;                   // Press Enter to keep current value

            try {
                int value = Integer.parseInt(input);
                if (value > 0 && value < 100) {
                    return value;
                }
                System.out.println("Invalid input. Age must be between 0 and 100.");

            } catch (NumberFormatException e) {
                System.out.println("Invalid input. Enter a number.");
            }
        }
    }

    private boolean getConfirmationInput(String prompt) {
        while (true) {
            System.out.print(prompt);
            String input = scanner.nextLine().trim();

            if (input.equalsIgnoreCase("yes")) return true;
            if (input.equalsIgnoreCase("no"))  return false;

            System.out.println("Invalid input. Please enter 'yes' or 'no'.");
        }
    }

    private void displayMenu() {
        System.out.println("\n===== MAIN MENU =====");
        System.out.println("1. Add Student");
        System.out.println("2. View All Students");
        System.out.println("3. Update Student");
        System.out.println("4. Delete Student");
        System.out.println("5. Search Student");
        System.out.println("6. Exit");
        System.out.println("=====================");
    }

    public static void main(String[] args) {
        StudentManagementSystem system = new StudentManagementSystem();
        System.out.println("=== Student Management System ===");

        while (true) {
            system.displayMenu();
            int choice = system.getIntInput("Enter your choice: ");

            switch (choice) {
                case 1 -> system.addStudent();
                case 2 -> system.viewAllStudents();
                case 3 -> system.updateStudent();
                case 4 -> system.deleteStudent();
                case 5 -> system.searchStudent();
                case 6 -> {
                    System.out.println("Thank you for using Student Management System!");
                    return;
                }
                default -> System.out.println("Invalid choice! Please try again.");
            }

            System.out.println("\nPress Enter to continue...");
            system.scanner.nextLine();
        }
    }
}