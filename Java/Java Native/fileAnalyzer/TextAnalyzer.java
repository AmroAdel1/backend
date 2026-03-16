import java.io.*;
import java.util.*;
import java.util.regex.Pattern;

// Analysis Logic
public class TextAnalyzer {
    private static final Pattern WORD_PATTERN = Pattern.compile("[^a-zA-Z0-9']");       // compiled once, reused many times
    private static final Pattern SENTENCE_PATTERN = Pattern.compile("[.!?]");
    private static final Pattern PARAGRAPH_PATTERN = Pattern.compile("\n\\s*\n");

    public TextStatistics analyzeText(String content, String filename) {
        TextStatistics stats = new TextStatistics(filename);

        if (content == null || content.trim().isEmpty()) {
            return stats;
        }

        // Basic counts
        stats.setCharacterCount(content.length());
        stats.setCharacterCountNoSpaces(content.replaceAll("\\s", "").length());

        // Line count
        String[] lines = content.split("\n");
        stats.setLineCount(lines.length);

        stats.setSentenceCount(countSentences(content));                    // Sentence count
        stats.setParagraphCount(countParagraphs(content));                  // Paragraph count

        // Word analysis
        analyzeWords(content, stats);

        return stats;
    }

    private int countSentences(String content) {
        if (content.trim().isEmpty()) return 0;

        String[] sentences = SENTENCE_PATTERN.split(content);
        int count = 0;
        for (String sentence : sentences) {
            if (sentence.trim().length() > 0) {
                count++;
            }
        }
        return count;
    }

    private int countParagraphs(String content) {
        if (content.trim().isEmpty()) return 0;

        String[] paragraphs = PARAGRAPH_PATTERN.split(content);
        int count = 0;
        for (String paragraph : paragraphs) {
            if (paragraph.trim().length() > 0) {
                count++;
            }
        }
        return count;
    }

    private void analyzeWords(String content, TextStatistics stats) {
        String[] words = WORD_PATTERN.split(content.toLowerCase());
        int totalWordLength = 0;
        int wordCount = 0;
        String longestWord = "";

        for (String word : words) {
            word = word.trim();
            if (word.length() > 0 && !isCommonNoise(word)) {
                wordCount++;                                // Update word count
                totalWordLength += word.length();           // Update total word length for average calculation
                if (word.length() > longestWord.length()) { // Check for longest word
                    longestWord = word;
                }
                stats.addWord(word);                        // Add to frequency map
            }
        }

        stats.setWordCount(wordCount);
        stats.setLongestWord(longestWord);
        stats.setAverageWordLength(wordCount > 0 ? (double) totalWordLength / wordCount : 0);

        // Find most frequent word
        String mostFrequent = findMostFrequentWord(stats.getWordFrequency());
        stats.setMostFrequentWord(mostFrequent);
    }

    private boolean isCommonNoise(String word) {    // any stand alone number/s or a single letter except a/i, remove
        return word.matches("\\d+") || // numbers only
                word.length() == 1 && !word.equals("a") && !word.equals("i"); // single letters except a/i
    }

    private String findMostFrequentWord(Map<String, Integer> wordFrequency) {
        return wordFrequency.entrySet()             // Converts Map into Set of key-value pairs so we can iterate over both key and value together
                .stream()                           // Converts EntrySet into stream so we can use pipeline operations on it.
                .max(Map.Entry.comparingByValue())  // Finds entry with highest value (count) by comparing all entries by their Integer value.
                .map(Map.Entry::getKey)             // Transforms Optional<Entry> into Optional<String> by extracting just key (word) from entry — we don't need count anymore, just word itself.
                .orElse("");                 // Unwraps Optional — returns word if present, or an empty string as fallback if map was empty.
    }

    public void generateReport(TextStatistics stats, String outputFilePath) throws IOException {
        StringBuilder report = new StringBuilder();

        // Basic statistics
        report.append(stats.toString()).append("\n\n");

        // Word frequency section
        report.append(formatTopWords(stats));

        report.append("\nDetailed Word Frequency:\n");
        report.append("------------------------\n");

        // Sort words alphabetically for detailed view
        List<String> sortedWords = new ArrayList<>(stats.getWordFrequency().keySet());
        Collections.sort(sortedWords);

        for (String word : sortedWords) {
            int frequency = stats.getWordFrequency().get(word);
            report.append(String.format("%-20s : %d\n", word, frequency));
        }

        // Write to file
        FileManager.writeToFile(outputFilePath, report.toString());
    }

    public void displayStatistics(TextStatistics stats) {
        System.out.println("\n" + stats.toString());
        System.out.print(formatTopWords(stats));
    }

    // Method to format top Most Frequent Words
    private String formatTopWords(TextStatistics stats) {
        StringBuilder sb = new StringBuilder();
        sb.append("\nTop 10 Most Frequent Words:\n");
        sb.append("---------------------------\n");

        List<Map.Entry<String, Integer>> topWords = stats.getTopWords(10);
        for (int i = 0; i < topWords.size(); i++) {
            Map.Entry<String, Integer> entry = topWords.get(i);
            sb.append(String.format("%2d. %-15s : %d times\n",
                    i + 1, entry.getKey(), entry.getValue()));
        }
        return sb.toString();
    }
}