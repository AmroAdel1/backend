
// data model & business logic
public class Account {
    private String accountNumber;
    private String pin;
    private double balance;
    private String accountHolderName;

    // each account locks independently
    private int failedAttempts = 0;
    private boolean isLocked = false;
    private static final int MAX_ATTEMPTS = 3;

    public Account(String accountNumber, String pin, double balance, String accountHolderName) {
        this.accountNumber = accountNumber;
        this.pin = pin;
        this.balance = balance;
        this.accountHolderName = accountHolderName;
    }

    // Getters
    public String getAccountNumber() { return accountNumber; }
    public double getBalance() { return balance; }
    public String getAccountHolderName() { return accountHolderName; }

    // Business logic methods
    public boolean validatePin(String inputPin) {
        if (isLocked) {
            System.out.println("Account is locked. Contact your bank.");
            return false;
        }
        if (this.pin.equals(inputPin)) {
            failedAttempts = 0;       // reset on success
            return true;
        }
        failedAttempts++;
        if (failedAttempts >= MAX_ATTEMPTS) {
            isLocked = true;
            System.out.println("Account locked after too many failed attempts.");
        }
        return false;
    }
    public boolean isLocked() { return isLocked; }

    public boolean withdraw(double amount) {
        if (amount > 0 && amount <= balance) {
            balance -= amount;
            return true;
        }
        return false;
    }

    public boolean deposit(double amount) {
        if (amount <= 0) return false;
        balance += amount;
        return true;
    }

    public boolean changePin(String newPin) {
        if (newPin == null || !newPin.matches("\\d{4}")) return false;
        this.pin = newPin;
        return true;
    }

    @Override
    public String toString() {
        return String.format("Account: %s | Holder: %s | Balance: $%.2f",
                accountNumber, accountHolderName, balance);
    }
}