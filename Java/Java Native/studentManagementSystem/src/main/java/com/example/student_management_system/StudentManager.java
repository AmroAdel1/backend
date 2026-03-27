package com.example.student_management_system;

import java.util.ArrayList;
import java.util.List;
import java.util.stream.Collectors;

public class StudentManager {
    private List<Student> students;
    private int nextId;

    public StudentManager() {
        this.students = new ArrayList<>();
        this.nextId = 1;
        initializeSampleData();         // Add some sample data
    }

    private void initializeSampleData() {
        addStudent(new Student("", "Amro", 20, "A", "amro@email.com"));
        addStudent(new Student("", "Adel", 22, "B", "adel@email.com"));
        addStudent(new Student("", "Farid", 21, "A", "farid@email.com"));
    }

    private String generateId() {
        return "S" + String.format("%03d", nextId++);
    }   // STD

    // CREATE - Add a new student
    public boolean addStudent(Student student) {
        if (student != null && !isEmailExists(student.getEmail())) {
            student.setId(generateId());
            students.add(student);
            return true;
        }
        return false;
    }

    // READ - Get all students
    public List<Student> getAllStudents() {
        return new ArrayList<>(students);
    }

    // READ - Get student by ID
    public Student getStudentById(String id) {
        return students.stream()
                .filter(student -> student.getId().equalsIgnoreCase(id))
                .findFirst()
                .orElse(null);
    }

    // UPDATE - Update student information
    public boolean updateStudent(String id, String name, int age, String grade, String email) {
        Student student = getStudentById(id);
        if (student != null) {
            // Check if email is being changed and if new email already exists
            if (!student.getEmail().equals(email) && isEmailExists(email)) {
                return false;
            }
            student.setName(name);
            student.setAge(age);
            student.setGrade(grade);
            student.setEmail(email);
            return true;
        }
        return false;
    }

    // DELETE - Remove student by ID
    public boolean deleteStudent(String id) {
        Student student = getStudentById(id);
        if (student != null) {
            students.remove(student);
            return true;
        }
        return false;
    }

    // SEARCH - Search students by name (partial match)
    public List<Student> searchStudentsByName(String name) {
        return students.stream()
                .filter(student -> student.getName().toLowerCase().contains(name.toLowerCase()))
                .collect(Collectors.toList());
    }

    // SEARCH - Search student by ID
    public List<Student> searchStudentsById(String id) {
        return students.stream()
                .filter(student -> student.getId().toLowerCase().contains(id.toLowerCase()))
                .collect(Collectors.toList());
    }

    // Validation method
    private boolean isEmailExists(String email) {
        return students.stream()
                .anyMatch(student -> student.getEmail().equalsIgnoreCase(email));
    }

    // Get students count
    public int getStudentCount() {
        return students.size();
    }
}