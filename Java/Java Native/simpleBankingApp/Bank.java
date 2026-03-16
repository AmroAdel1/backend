import java.util.HashMap;
import java.util.Map;

// authentication & account management
public class Bank {
    private Map<String, Account> accounts;
    private int nextId = 1;

    public Bank() {
        this.accounts = new HashMap<>();
        initializeSampleAccounts();
    }

    private void initializeSampleAccounts() {
        // Add some sample accounts
        addAccount("1234", 1000.00, "John Doe");
        addAccount("4321", 2500.50, "Jane Smith");
        addAccount("5555", 500.75, "Bob Johnson");
    }

    private String generateId() {           // formats nextId as zero-padded 3-digit integer
        return "ACC" + String.format("%03d", nextId++);
    }

    public Account authenticate(String accountNumber, String pin) {
        Account account = accounts.get(accountNumber);

        if (account == null) {
            System.out.println("Account not found.");
            return null;
        }
        if (!account.validatePin(pin)) {  // Account handles locking internally     // Account.validatePin() handles lock + error messages
            return null;
        }
        return account;
    }

    public boolean accountExists(String accountNumber) {
        return accounts.containsKey(accountNumber);
    }

    public Account addAccount(String pin, double balance, String holderName) {
        String id = generateId();
        Account account = new Account(id, pin, balance, holderName);
        accounts.put(id, account);
        return account;
    }
}

/*
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

    private int loginAttempts;
    private static final int MAX_LOGIN_ATTEMPTS = 3;
    this.loginAttempts = 0;

    public void resetLoginAttempts() {
        this.loginAttempts = 0;
    }
*/