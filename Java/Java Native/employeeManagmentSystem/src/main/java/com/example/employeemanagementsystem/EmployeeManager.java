package com.example.employeemanagementsystem;

import java.util.ArrayList;
import java.util.List;
import java.util.stream.Collectors;

public class EmployeeManager {              // handles all CRUD operations
    private List<Employee> employees;
    private int nextId;

    public EmployeeManager() {
        this.employees = new ArrayList<>();
        this.nextId = 1;
        initializeSampleData();              // Add some sample data
    }

    private void initializeSampleData() {
        addEmployee(new Employee("", "Amro", 20,"IT", 2000));
        addEmployee(new Employee("", "Adel", 22, "HR", 3000));
        addEmployee(new Employee("", "Farid", 21, "CS", 4000));
    }

    private String generateId() {           // formats nextId as zero-padded 3-digit integer
        return "EMP" + String.format("%03d", nextId++);
    }

    // CREATE - Add new Employee
    public boolean addEmployee(Employee employee) {
        if (employee != null) {
            employee.setId(generateId());
            employees.add(employee);
            return true;
        }
        return false;
    }

    // READ - Get all Employees
    public List<Employee> getAllEmployees() {
        return new ArrayList<>(employees);
    }

    // READ - Get Employee by ID
    public Employee getEmployeeById(String id) {
        return employees.stream()
                .filter(employee -> employee.getId().equalsIgnoreCase(id))
                .findFirst()
                .orElse(null);
    }

    // UPDATE - Update Employee information
    public boolean updateEmployee(String id, String name, int age, String department, double salary) {
        Employee employee = getEmployeeById(id);
        if (employee != null) {
            employee.setName(name);
            employee.setAge(age);
            employee.setDepartment(department);
            employee.setSalary(salary);
            return true;
        }
        return false;
    }

    // DELETE - Remove Employee by ID
    public boolean deleteEmployee(String id) {
        Employee employee = getEmployeeById(id);
        if (employee != null) {
            employees.remove(employee);
            return true;
        }
        return false;
    }

    // SEARCH - Search Employees by name (partial match)
    public List<Employee> searchEmployeesByName(String name) {
        return employees.stream()
                .filter(employee -> employee.getName().toLowerCase().contains(name.toLowerCase()))
                .collect(Collectors.toList());
    }

    // SEARCH - Search Employee by ID
    public List<Employee> searchEmployeesById(String id) {
        return employees.stream()
                .filter(employee -> employee.getId().toLowerCase().contains(id.toLowerCase()))
                .collect(Collectors.toList());
    }

    // Get Employees count
    public int getEmployeeCount() {
        return employees.size();
    }
}