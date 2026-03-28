package com.example.bst.tree;

import com.example.bst.model.TreeNode;

import java.util.ArrayList;
import java.util.LinkedList;
import java.util.List;
import java.util.Queue;

public class BST {
    private TreeNode root;

    // ── INSERT ─────────────────────────────────────────────────────────────────────────────────
    public boolean insert(int data) {
        boolean[] inserted = {false};           // flag to track if inserted   // passed by reference   
        root = insertRecursive(root, data, inserted);  // update tree
        return inserted[0];
    }

    private TreeNode insertRecursive(TreeNode node, int data, boolean[] inserted) {
        if (node == null) {
            inserted[0] = true;
            return new TreeNode(data);  // empty tree  // insert new node reached destination
        }
        if (data < node.data) {
            node.left = insertRecursive(node.left, data, inserted);
        } else if (data > node.data) {
            node.right = insertRecursive(node.right, data, inserted);
        }
        return node;
    }

    // ── SEARCH ─────────────────────────────────────────────────────────────────────────────────
    public boolean search(int data) {
        return searchRecursive(root, data);
    }

    private boolean searchRecursive(TreeNode node, int data) {
        if (node == null) return false;                               // base case   // not found
        if (data < node.data) {
            return searchRecursive(node.left, data);                  // go left
        } else if (data > node.data) {
            return searchRecursive(node.right, data);                 // go right
        } else {
            return true;                                              // found — equal
        }
    }

    // ── DELETE ─────────────────────────────────────────────────────────────────────────────────
    public boolean delete(int data) {
        boolean[] deleted = {false};            // flag to track if deleted
        root = deleteRecursive(root, data, deleted);
        return deleted[0];
    }

    private TreeNode deleteRecursive(TreeNode node, int data, boolean[] deleted) {
        if (node == null) return null;   // empty tree   // not found
        if (data < node.data) {  // find node first
            node.left = deleteRecursive(node.left, data, deleted);
        } else if (data > node.data) {
            node.right = deleteRecursive(node.right, data, deleted);
        } else {
            deleted[0] = true;                  // only set when actually deleted

            // Case 1: Leaf node (no children)
            if (node.left == null && node.right == null) {   // remove directly
                return null;
            }
            // Case 2a: Only right child
            else if (node.left == null) {
                return node.right;   // return right child value
            }
            // Case 2b: Only left child
            else if (node.right == null) {
                return node.left;
            }
            // Case 3: Two children — replace with in-order successor (smallest in right subtree)
            int successorValue = findMin(node.right);
            node.data = successorValue;  // replace node found with its successor
            node.right = deleteRecursive(node.right, successorValue, deleted);   // delete successor node
        }
        return node;  // unchanged
    }

    // ── TRAVERSALS ─────────────────────────────────────────────────────────────────────────────────

    // ── In-Order: Left → Root → Right (produces sorted output) ───────────────   // ascending sorted order.
    public List<Integer> inOrder() {
        List<Integer> result = new ArrayList<>();
        inOrderRecursive(root, result); 
        return result;
    }

    private void inOrderRecursive(TreeNode node, List<Integer> result) {
        if (node == null) return;
        inOrderRecursive(node.left, result);
        result.add(node.data);
        inOrderRecursive(node.right, result);
    }

    // ── Pre-Order: Root → Left → Right (useful for copying/serializing tree) ─
    public List<Integer> preOrder() {
        List<Integer> result = new ArrayList<>();
        preOrderRecursive(root, result);
        return result;
    }

    private void preOrderRecursive(TreeNode node, List<Integer> result) {
        if (node == null) return;
        result.add(node.data);
        preOrderRecursive(node.left, result);
        preOrderRecursive(node.right, result);
    }

    // ── Post-Order: Left → Right → Root (useful for deleting/freeing tree) ───
    public List<Integer> postOrder() {
        List<Integer> result = new ArrayList<>();
        postOrderRecursive(root, result);
        return result;
    }

    private void postOrderRecursive(TreeNode node, List<Integer> result) {
        if (node == null) return;
        postOrderRecursive(node.left, result);
        postOrderRecursive(node.right, result);
        result.add(node.data);
    }

    // ── Level-Order (BFS): Level by level, left to right ─────────────────────
    public List<Integer> levelOrder() {
        List<Integer> result = new ArrayList<>();
        if (root == null) return result;

        Queue<TreeNode> queue = new LinkedList<>();
        queue.offer(root);   // insert root first

        while (!queue.isEmpty()) {
            TreeNode current = queue.poll();
            result.add(current.data);
            if (current.left != null) queue.offer(current.left);
            if (current.right != null) queue.offer(current.right);
        }
        return result;
    }

    // ── UTILITY METHODS ─────────────────────────────────────────────────────────────────────────────────

    // ── Find minimum value ────────────────────────────────────────────────────
    public int findMin() {
        if (root == null) throw new IllegalStateException("Tree is empty.");
        return findMin(root);
    }

    private int findMin(TreeNode node) {
        while (node.left != null) node = node.left;
        return node.data;
    }

    // ── Find maximum value ────────────────────────────────────────────────────
    public int findMax() {
        if (root == null) throw new IllegalStateException("Tree is empty.");
        TreeNode node = root;
        while (node.right != null) node = node.right;
        return node.data;
    }

    // ── Tree height ───────────────────────────────────────────────────────────
    public int height() {
        return heightRecursive(root);
    }

    private int heightRecursive(TreeNode node) {
        if (node == null) return 0;
        return 1 + Math.max(heightRecursive(node.left), heightRecursive(node.right));
    }

    // ── Count total nodes ─────────────────────────────────────────────────────
    public int countNodes() {
        return countRecursive(root);
    }

    private int countRecursive(TreeNode node) {
        if (node == null) return 0;
        return 1 + countRecursive(node.left) + countRecursive(node.right);
    }

    // ── Check if tree is empty ────────────────────────────────────────────────
    public boolean isEmpty() { return root == null; }

    // ── Get root (for TreePrinter) ────────────────────────────────────────────
    public TreeNode getRoot() { return root; }
}