import java.util.HashMap;
import java.util.Map;

// authentication & account management
public class Bank {
    private Map<String, Account> accounts;
    private int loginAttempts;
    private static final int MAX_LOGIN_ATTEMPTS = 3;

    public Bank() {
        this.accounts = new HashMap<>();
        this.loginAttempts = 0;
        initializeSampleAccounts();
    }

    private void initializeSampleAccounts() {
        // Add some sample accounts
        accounts.put("123456789", new Account("123456789", "1234", 1000.00, "John Doe"));
        accounts.put("987654321", new Account("987654321", "4321", 2500.50, "Jane Smith"));
        accounts.put("555555555", new Account("555555555", "5555", 500.75, "Bob Johnson"));
    }

    public Account authenticate(String accountNumber, String pin) {
        if (loginAttempts >= MAX_LOGIN_ATTEMPTS) {
            System.out.println("Too many failed attempts. Account temporarily locked.");
            return null;
        }

        Account account = accounts.get(accountNumber);
        if (account != null && account.validatePin(pin)) {
            loginAttempts = 0; // Reset attempts on successful login
            return account;
        } else {
            loginAttempts++;
            int remainingAttempts = MAX_LOGIN_ATTEMPTS - loginAttempts;
            System.out.println("Invalid account number or PIN. Attempts remaining: " + remainingAttempts);
            return null;
        }
    }

    public void resetLoginAttempts() {
        this.loginAttempts = 0;
    }

    public boolean accountExists(String accountNumber) {
        return accounts.containsKey(accountNumber);
    }

    public void addAccount(Account account) {
        accounts.put(account.getAccountNumber(), account);
    }
}