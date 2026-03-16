package com.example.employeemanagementsystem;

import java.util.List;
import java.util.Scanner;

public class EmployeeManagementSystem {
    private EmployeeManager employeeManager;
    private Scanner scanner;

    public EmployeeManagementSystem() {
        this.employeeManager = new EmployeeManager();
        this.scanner = new Scanner(System.in);
    }

    private void addEmployee() {
        System.out.println("\n----- Add New Employee -----");

        String name = getStringInput("Enter Employee name: ");
        int age = getIntInputWithDefault("Enter Employee age: ", 0);
        String department = getStringInput("Enter Employee department: ");
        double salary = getDoubleInput("Enter Employee salary: ");

        // Let EmployeeManager assign the ID via generateId()
        Employee employee = new Employee("", name, age, department, salary);

        if (employeeManager.addEmployee(employee)) {
            System.out.println("Employee added successfully.");
        } else {
            System.out.println("Failed to add Employee.");
        }
    }

    private void viewAllEmployees() {
        System.out.println("\n----- All Employees -----");
        List<Employee> employees = employeeManager.getAllEmployees();

        if (employees.isEmpty()) {
            System.out.println("No employees found.");
        } else {
            System.out.printf("Total Employees: %d\n", employeeManager.getEmployeeCount());
            System.out.println("=".repeat(80));
            employees.forEach(e -> System.out.println(e));     // called toString() method
        }
    }

    private void updateEmployee() {
        System.out.println("\n----- Update Employee -----");
        String id = getStringInput("Enter Employee ID to update: ");

        Employee employee = employeeManager.getEmployeeById(id);
        if (employee == null) {
            System.out.println("Employee with ID " + id + " not found.");
            return;
        }

        System.out.println("Current Employee details:");
        System.out.println(employee);
        System.out.println("(Press Enter to keep current value)");

        // ── Name ──────────────────────────────────────────────────────────────────
        System.out.print("Enter new name (current: " + employee.getName() + "): ");
        String name = scanner.nextLine();
        if (name.trim().isEmpty()) name = employee.getName();

        // ── Age ───────────────────────────────────────────────────────────────────
        int age = getIntInputWithDefault("Enter new age (current: " + employee.getAge() + "): ", employee.getAge());

        // ── Department ────────────────────────────────────────────────────────────
        System.out.print("Enter new department (current: " + employee.getDepartment() + "): ");
        String department = scanner.nextLine();
        if (department.trim().isEmpty()) department = employee.getDepartment();

        // ── Salary ────────────────────────────────────────────────────────────────
        double salary = getDoubleInput("Enter new salary (current: " + employee.getSalary() + "): ");

        if (employeeManager.updateEmployee(id, name, age, department, salary)) {
            System.out.println("Employee updated successfully.");
        } else {
            System.out.println("Failed to update Employee.");
        }
    }

    private void deleteEmployee() {
        System.out.println("\n----- Delete Employee -----");
        String id = getStringInput("Enter Employee ID to delete: ");

        Employee employee = employeeManager.getEmployeeById(id);
        if (employee == null) {
            System.out.println("Employee with ID " + id + " not found.");
            return;
        }

        System.out.println("Employee to delete:");
        System.out.println(employee);

        if (getConfirmationInput("Are you sure you want to delete this Employee? (yes/no): ")) {
            if (employeeManager.deleteEmployee(id)) {
                System.out.println("Employee deleted successfully!");
            } else {
                System.out.println("Failed to delete Employee.");
            }
        } else {
            System.out.println("Deletion cancelled.");
        }
    }

    private void searchEmployee() {
        System.out.println("\n----- Search Employee -----");
        System.out.println("1. Search by ID");
        System.out.println("2. Search by Name");
        int searchChoice = getIntInputWithDefault("Choose search option: ", -1);

        List<Employee> results;
        switch (searchChoice) {
            case 1 -> {
                String id = getStringInput("Enter Employee ID to search: ");
                results = employeeManager.searchEmployeesById(id);
            }
            case 2 -> {
                String name = getStringInput("Enter Employee name to search: ");
                results = employeeManager.searchEmployeesByName(name);
            }
            default -> {
                System.out.println("Invalid search option.");
                return;
            }
        }

        if (results.isEmpty()) {
            System.out.println("No Employees found.");
        } else {
            System.out.println("Search Results (" + results.size() + " found):");
            System.out.println("=".repeat(80));
            results.forEach(e -> System.out.println(e)); // Fixed ambiguous method ref
        }
    }

    private int getIntInputWithDefault(String prompt, int defaultValue) {
        System.out.print(prompt);
        String input = scanner.nextLine();
        if (input.trim().isEmpty()) return defaultValue;
        try {
            return Integer.parseInt(input.trim());
        } catch (NumberFormatException e) {
            System.out.println("Invalid input. Using default value: " + defaultValue);
            return defaultValue;
        }
    }

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

    private double getDoubleInput(String prompt) {
    while (true) {
        System.out.print(prompt);
        String input = scanner.nextLine().trim();
        try {
            double value = Double.parseDouble(input);
            if (value < 0) {
                System.out.println("Salary cannot be negative.");
                continue;
            }
            return value;
        } catch (NumberFormatException e) {
            System.out.println("Invalid input. Please enter a valid salary.");
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

    private void printMenu() {
        System.out.println("\n===== MAIN MENU =====");
        System.out.println("1. Add Employee");
        System.out.println("2. View All Employees");
        System.out.println("3. Update Employee");
        System.out.println("4. Delete Employee");
        System.out.println("5. Search Employee");
        System.out.println("6. Exit");
        System.out.println("=====================");
        System.out.print("Enter your choice: ");
    }

    public static void main(String[] args) {
        EmployeeManagementSystem ems = new EmployeeManagementSystem();
        System.out.println("=== Employee Management System ===");

        while (true) {
            ems.printMenu();
            int choice = ems.getIntInputWithDefault("", -1);

            switch (choice) {
                case 1 -> ems.addEmployee();
                case 2 -> ems.viewAllEmployees();
                case 3 -> ems.updateEmployee();
                case 4 -> ems.deleteEmployee();
                case 5 -> ems.searchEmployee();
                case 6 -> {
                    System.out.println("Thank you for using Employee Management System!");
                    return;
                }
                default -> System.out.println("Invalid choice! Please try again.");
            }

            System.out.println("\nPress Enter to continue...");
            ems.scanner.nextLine();
        }
    }
}