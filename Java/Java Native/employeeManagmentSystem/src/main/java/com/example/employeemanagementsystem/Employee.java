package com.example.employeemanagementsystem;

public class Employee {
    private String id;
    private String name;
    private int age;
    private String department;
    private double salary;  

    // Constructor
    public Employee(String id, String name, int age, String department, double salary) {
        this.id = id;
        this.name = name;
        this.age = age;
        this.department = department;
        this.salary = salary;
    }

    // Getters and Setters
    public String getId() { return id; }
    public void setId(String id) { this.id = id; }

    public String getName() { return name; }
    public void setName(String name) { this.name = name; }

    public String getDepartment() { return department; }
    public void setDepartment(String department) { this.department = department; }

    public int getAge() { return age; }
    public void setAge(int age) { this.age = age; }

    public double getSalary() { return salary; }
    public void setSalary(double salary) { this.salary = salary; }

    @Override
    public String toString() {   // for printing employee details
        return String.format("ID: %-5s | Name: %-15s | Age: %-3d | Department: %-15s | Salary: %-10.2f", 
        id, name, age, department, salary);
    }
}