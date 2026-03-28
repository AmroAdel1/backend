package com.example.bst.util;

import java.util.*;

public class TreePrinter {
    public static void printTraversal(String label, List<Integer> values) {
        System.out.printf("  %-15s : %s%n", label, values.toString());
    }
}