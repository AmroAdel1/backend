import java.io.*;
import java.util.*;

public class TextAnalysisApp {
    private TextAnalyzer analyzer;
    private Scanner scanner;

    public TextAnalysisApp() {
        this.analyzer = new TextAnalyzer();
        this.scanner = new Scanner(System.in);
    }

    private void analyzeFile() {
        System.out.println("\n----- Analyze Text File -----");
        System.out.print("Enter file path: ");
        String filePath = scanner.nextLine().trim();

        if (!FileManager.fileExists(filePath)) {
            System.out.println("Error: File does not exist!");
            return;
        }

        try {
            // Read file content
            String content = FileManager.readFile(filePath);

            // Analyze text
            String filename = FileManager.getFileNameWithoutExtension(filePath);
            TextStatistics stats = analyzer.analyzeText(content, filename);

            // Display results
            analyzer.displayStatistics(stats);

            // Ask to save report
            if (getYesNoInput("\nWould you like to save this report? (y/n): ")) {
                String outputPath = generateOutputPath(filePath);
                analyzer.generateReport(stats, outputPath);
                System.out.println("Report saved to: " + outputPath);
            }

        } catch (IOException e) {
            System.out.println("Error reading file: " + e.getMessage());
        } catch (Exception e) {
            System.out.println("Error analyzing file: " + e.getMessage());
        }
    }

    private void compareFiles() {
        System.out.println("\n----- Compare Two Files -----");
        System.out.print("Enter first file path: ");
        String filePath1 = scanner.nextLine().trim();
        System.out.print("Enter second file path: ");
        String filePath2 = scanner.nextLine().trim();

        if (!FileManager.fileExists(filePath1) || !FileManager.fileExists(filePath2)) {
            System.out.println("Error: One or both files do not exist!");
            return;
        }

        try {
            // Analyze both files
            String content1 = FileManager.readFile(filePath1);
            String content2 = FileManager.readFile(filePath2);

            TextStatistics stats1 = analyzer.analyzeText(content1,
                    FileManager.getFileNameWithoutExtension(filePath1));
            TextStatistics stats2 = analyzer.analyzeText(content2,
                    FileManager.getFileNameWithoutExtension(filePath2));

            // Display comparison
            displayComparison(stats1, stats2);

        } catch (IOException e) {
            System.out.println("Error reading files: " + e.getMessage());
        }
    }

    private void viewFileContent() {
        System.out.println("\n----- View File Content -----");
        System.out.print("Enter file path: ");
        String filePath = scanner.nextLine().trim();

        if (!FileManager.fileExists(filePath)) {
            System.out.println("Error: File does not exist!");
            return;
        }

        try {
            List<String> lines = FileManager.readFileLines(filePath);
            System.out.println("\nFile Content:");
            System.out.println("=============");

            for (int i = 0; i < lines.size(); i++) {
                System.out.printf("%4d: %s\n", i + 1, lines.get(i));
            }

        } catch (IOException e) {
            System.out.println("Error reading file: " + e.getMessage());
        }
    }

    private void displayComparison(TextStatistics stats1, TextStatistics stats2) {
        System.out.println("\n===== FILE COMPARISON =====");
        System.out.printf("%-30s %-15s %-15s\n", "METRIC", stats1.getFilename(), stats2.getFilename());
        System.out.println("------------------------------------------------");
        System.out.printf("%-30s %-15d %-15d\n", "Characters (with spaces)",
                stats1.getCharacterCount(), stats2.getCharacterCount());
        System.out.printf("%-30s %-15d %-15d\n", "Characters (no spaces)",
                stats1.getCharacterCountNoSpaces(), stats2.getCharacterCountNoSpaces());
        System.out.printf("%-30s %-15d %-15d\n", "Words",
                stats1.getWordCount(), stats2.getWordCount());
        System.out.printf("%-30s %-15d %-15d\n", "Lines",
                stats1.getLineCount(), stats2.getLineCount());
        System.out.printf("%-30s %-15d %-15d\n", "Sentences",
                stats1.getSentenceCount(), stats2.getSentenceCount());
        System.out.printf("%-30s %-15d %-15d\n", "Paragraphs",
                stats1.getParagraphCount(), stats2.getParagraphCount());
        System.out.printf("%-30s %-15.2f %-15.2f\n", "Avg Word Length",
                stats1.getAverageWordLength(), stats2.getAverageWordLength());
    }

    private String generateOutputPath(String inputPath) {
        File file = new File(inputPath);
        String parent = file.getParent();
        String name = FileManager.getFileNameWithoutExtension(inputPath);
        String outputFile = name + "_analysis_report.txt";

        return (parent != null) ? parent + File.separator + outputFile : outputFile;
    }

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

    private boolean getYesNoInput(String prompt) {
        while (true) {
            System.out.print(prompt);
            String input = scanner.nextLine().trim().toLowerCase();
            if (input.equals("y") || input.equals("yes")) return true;
            if (input.equals("n") || input.equals("no"))  return false;
            System.out.println("✘ Please enter 'y' or 'n'.");
        }
    }

    public static void main(String[] args) {
        TextAnalysisApp app = new TextAnalysisApp();
        System.out.println("=== File Manager & Text Analyzer ===");

        while (true) {
            System.out.println("\n===== MAIN MENU =====");
            System.out.println("1. Analyze Text File");
            System.out.println("2. Compare Two Files");
            System.out.println("3. View File Content");
            System.out.println("4. Exit");
            System.out.println("=====================");

            int choice = app.getIntInput("Enter your choice: ");

            switch (choice) {
                case 1 -> app.analyzeFile();
                case 2 -> app.compareFiles();
                case 3 -> app.viewFileContent();
                case 4 -> {
                    System.out.println("Thank you for using Text Analyzer!");
                    return;
                }
                default -> System.out.println("Invalid choice! Please try again.");
            }

            System.out.println("\nPress Enter to continue...");
            app.scanner.nextLine();
        }
    }
}