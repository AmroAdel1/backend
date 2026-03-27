package com.example.student_management_system;

public class Student {
    private String id;
    private String name;
    private int age;
    private String grade;
    private String email;

    // Constructor
    public Student(String id, String name, int age, String grade, String email) {
        this.id = id;
        this.name = name;
        this.age = age;
        this.grade = grade;
        this.email = email;
    }

    // Getters and Setters
    public String getId() { return id; }
    public void setId(String id) { this.id = id; }

    public String getName() { return name; }
    public void setName(String name) { this.name = name; }

    public int getAge() { return age; }
    public void setAge(int age) { this.age = age; }

    public String getGrade() { return grade; }
    public void setGrade(String grade) { this.grade = grade; }

    public String getEmail() { return email; }
    public void setEmail(String email) { this.email = email; }

    @Override
    public String toString() {
        return String.format("ID: %-5s | Name: %-15s | Age: %-3d | Grade: %-5s | Email: %s", 
                  id, name, age, grade, email);
    }
}