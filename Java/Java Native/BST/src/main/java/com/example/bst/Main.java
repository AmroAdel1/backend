package com.example.bst;

import com.example.bst.tree.BST;
import com.example.bst.util.TreePrinter;

import java.util.Scanner;

public class Main {
    static BST bst = new BST();
    static Scanner scanner  = new Scanner(System.in);

    // ─── Operations ───────────────────────────────────────────────────────────
    static void insertNode() {
        int val = getIntInput("Enter value to insert: ");
        if (bst.insert(val)) { 
            System.out.println("Value " + val + " inserted successfully.");
        } else {
            System.out.println("Duplicate value: " + val + " BST does not allow duplicates.");
        }
    }

    static void deleteNode() {
        if (bst.isEmpty()) { 
            System.out.println("Tree is empty."); 
            return; 
        }
        int val = getIntInput("Enter value to delete: ");
        if (bst.delete(val)) {
            System.out.println("Value " + val + " deleted successfully.");
        } else {
            System.out.println("Value " + val + " not found in the tree.");
        }
    }

    static void searchNode() {
        if (bst.isEmpty()) { 
            System.out.println("Tree is empty."); 
            return; 
        }
        int val = getIntInput("Enter value to search: ");
        if (bst.search(val)) {
            System.out.println("Value " + val + " found in the tree.");
        } else {
            System.out.println("Value " + val + " not found in the tree.");
        }
    }

    static void printTraversals() {
        if (bst.isEmpty()) { 
            System.out.println("Tree is empty."); 
            return; 
        }
        System.out.println("\n── Traversals ──────────────────────────");
        TreePrinter.printTraversal("In-Order   (L -> Root -> R)", bst.inOrder());
        TreePrinter.printTraversal("Pre-Order  (Root -> L -> R)", bst.preOrder());
        TreePrinter.printTraversal("Post-Order (L -> R -> Root)", bst.postOrder());
        TreePrinter.printTraversal("Level-Order (BFS)", bst.levelOrder());
        System.out.println("────────────────────────────────────────");
    }

    static void printStats() {
        if (bst.isEmpty()) { 
            System.out.println("Tree is empty."); 
            return; 
        }
        System.out.println("\n── Tree Statistics ─────────────────────");
        System.out.println("  Total Nodes : " + bst.countNodes());
        System.out.println("  Height      : " + bst.height());
        System.out.println("  Minimum     : " + bst.findMin());
        System.out.println("  Maximum     : " + bst.findMax());
        System.out.println("────────────────────────────────────────");
    }

    static void bulkInsert() {
        System.out.print("Enter values separated by spaces: ");
        String[] tokens = scanner.nextLine().trim().split("\\s+");   // splits on one or more whitespace
        int inserted = 0;
        for (String token : tokens) {
            try {
                bst.insert(Integer.parseInt(token.trim()));
                inserted++;
            } catch (NumberFormatException e) {
                System.out.println("Skipping invalid value: " + token);
            }
        }
        System.out.println("Inserted " + inserted + " values.");
    }

    // ─── Input Helper ─────────────────────────────────────────────────────────
    static int getIntInput(String prompt) {
        while (true) {
            System.out.print(prompt);
            String input = scanner.nextLine().trim();
            try {
                return Integer.parseInt(input);
            } catch (NumberFormatException e) {
                System.out.println("Invalid input. Please enter a number: ");
            }
        }
    }

    // ─── Menu ─────────────────────────────────────────────────────────────────
    static void printMenu() {
        System.out.println("\n╔══════════════════════════════════════╗");
        System.out.println("║              BST Menu                ║");
        System.out.println("╠══════════════════════════════════════╣");
        System.out.println("║  1. Insert Node                      ║");
        System.out.println("║  2. Delete Node                      ║");
        System.out.println("║  3. Search Node                      ║");
        System.out.println("║  4. Print All Traversals             ║");
        System.out.println("║  5. Tree Statistics                  ║");
        System.out.println("║  6. Bulk Insert                      ║");
        System.out.println("║  7. Exit                             ║");
        System.out.println("╚══════════════════════════════════════╝");
    }

    public static void main(String[] args) {
        System.out.println("╔══════════════════════════════════════╗");
        System.out.println("║      Binary Search Tree (BST)        ║");
        System.out.println("╚══════════════════════════════════════╝");

        while (true) {
            printMenu();
            int choice = getIntInput("Choose an option: ");

            switch (choice) {
                case 1 -> insertNode();
                case 2 -> deleteNode();
                case 3 -> searchNode();
                case 4 -> printTraversals();
                case 5 -> printStats();
                case 6 -> bulkInsert();
                case 7 -> { System.out.println("Goodbye!"); scanner.close(); return; }
                default -> System.out.println("Invalid option. Choose between 1 and 7.");
            }
        }
    }
}

/*
    static int getIntInput(String prompt) {
        while (true) {
            System.out.print(prompt);
            if (sc.hasNextInt()) { int v = sc.nextInt(); sc.nextLine(); return v; }
            System.out.println("Invalid input. Please enter a number.");
            sc.nextLine();
        }
    }
 */