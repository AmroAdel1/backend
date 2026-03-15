import java.util.Map;
import java.util.PriorityQueue;
import java.util.HashMap;
import java.util.List;
import java.util.ArrayList;
import java.util.Comparator;

// Data Model
public class TextStatistics {
    private String filename;
    private int characterCount;
    private int characterCountNoSpaces;
    private int wordCount;
    private int lineCount;
    private int sentenceCount;
    private int paragraphCount;
    private Map<String, Integer> wordFrequency;
    private String longestWord;
    private double averageWordLength;
    private String mostFrequentWord;   // can't initialize because it will be calculated later

    public TextStatistics(String filename) {
        this.filename = filename;
        this.wordFrequency = new HashMap<>();
        this.longestWord = "";
    }

    // Getters
    public String getFilename() { return filename; }
    public int getCharacterCount() { return characterCount; }
    public int getCharacterCountNoSpaces() { return characterCountNoSpaces; }
    public int getWordCount() { return wordCount; }
    public int getLineCount() { return lineCount; }
    public int getSentenceCount() { return sentenceCount; }
    public int getParagraphCount() { return paragraphCount; }
    public String getLongestWord() { return longestWord; }
    public double getAverageWordLength() { return averageWordLength; }
    public String getMostFrequentWord() { return mostFrequentWord; }
    public Map<String, Integer> getWordFrequency() { return wordFrequency; }

    // Setters
    public void setCharacterCount(int count) { this.characterCount = count; }
    public void setCharacterCountNoSpaces(int count) { this.characterCountNoSpaces = count; }
    public void setWordCount(int count) { this.wordCount = count; }
    public void setLineCount(int count) { this.lineCount = count; }
    public void setSentenceCount(int count) { this.sentenceCount = count; }
    public void setParagraphCount(int count) { this.paragraphCount = count; }
    public void setLongestWord(String word) { this.longestWord = word; }
    public void setAverageWordLength(double length) { this.averageWordLength = length; }
    public void setMostFrequentWord(String word) { this.mostFrequentWord = word; }

    public void addWord(String word) {
        wordFrequency.put(word, wordFrequency.getOrDefault(word, 0) + 1);
    }

    // Get top N most frequent words
    public List<Map.Entry<String, Integer>> getTopWords(int n) {
        PriorityQueue<Map.Entry<String, Integer>> heap =
            new PriorityQueue<>(Comparator.comparingInt(Map.Entry::getValue));      // use a min-heap, only track top N        // Creates empty heap that sorts by word count (value), smallest count at top.

        // Loop through every word
        for (Map.Entry<String, Integer> entry : wordFrequency.entrySet()) {
            heap.offer(entry);          // add word to heap
            if (heap.size() > n)        // if heap exceeds n
                heap.poll();            // remove smallest count
        }

        // Convert heap to sorted list
        List<Map.Entry<String, Integer>> result = new ArrayList<>(heap);
        result.sort((a, b) -> b.getValue().compareTo(a.getValue()));
        return result;
    }

    @Override
    public String toString() {
        return String.format(
                "Text Analysis Report for: %s\n" +
                        "========================================\n" +
                        "Basic Statistics:\n" +
                        "  Characters (with spaces): %d\n" +
                        "  Characters (no spaces):   %d\n" +
                        "  Words:                    %d\n" +
                        "  Lines:                    %d\n" +
                        "  Sentences:                %d\n" +
                        "  Paragraphs:               %d\n\n" +
                        "Word Analysis:\n" +
                        "  Longest word:            '%s' (%d characters)\n" +
                        "  Average word length:     %.2f characters\n" +
                        "  Most frequent word:      '%s' (appears %d times)",
                filename, characterCount, characterCountNoSpaces, wordCount,
                lineCount, sentenceCount, paragraphCount, longestWord,
                longestWord.length(), averageWordLength, mostFrequentWord,
                wordFrequency.getOrDefault(mostFrequentWord, 0)
        );
    }
}