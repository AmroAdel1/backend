import java.util.Scanner;

// UI
public class Main {
    private Bank bank;
    private Account currentAccount;
    private Scanner scanner;
    private boolean isRunning;

    public Main() {
        this.bank = new Bank();
        this.scanner = new Scanner(System.in);
        this.isRunning = true;
    }

    private void showLoginMenu() {
        System.out.println("\n----- ATM Login -----");
        System.out.println("1. Login");
        System.out.println("2. Exit");
        System.out.print("Choose option: ");

        int choice = getIntInput();

        switch (choice) {
            case 1 -> login();
            case 2 -> isRunning = false;
            default -> System.out.println("Invalid option. Please try again.");
        }
    }

    private void login() {
        System.out.print("Enter Account Number: ");
        String accountNumber = scanner.nextLine().trim();

        System.out.print("Enter PIN: ");
        String pin = scanner.nextLine().trim();

        currentAccount = bank.authenticate(accountNumber, pin);

        if (currentAccount != null) {
            System.out.println("\nLogin successful! Welcome, " +
                    currentAccount.getAccountHolderName() + "!");
        } else {
            System.out.println("Login failed. Please try again.");
        }
    }

    private void showMainMenu() {
        System.out.println("\n===== MAIN MENU =====");
        System.out.println("1. Check Balance");
        System.out.println("2. Deposit");
        System.out.println("3. Withdraw");
        System.out.println("4. Change PIN");
        System.out.println("5. View Account Info");
        System.out.println("6. Logout");
        System.out.println("=====================");
        System.out.print("Choose option: ");

        int choice = getIntInput();

        switch (choice) {
            case 1 -> checkBalance();
            case 2 -> deposit();
            case 3 -> withdraw();
            case 4 -> changePin();
            case 5 -> viewAccountInfo();
            case 6 -> logout();
            default -> System.out.println("Invalid option. Please try again.");
        }
    }

    private void checkBalance() {
        System.out.println("\n----- Balance Inquiry -----");
        System.out.printf("Current Balance: $%.2f%n", currentAccount.getBalance());
    }

    private void deposit() {
        System.out.println("\n----- Deposit -----");
        double amount = getDoubleInput("Enter amount to deposit: $");

        if (currentAccount.deposit(amount)) {
            System.out.printf("Successfully deposited $%.2f%n", amount);
            System.out.printf("New Balance: $%.2f%n", currentAccount.getBalance());
        } else {
            System.out.println("Invalid amount. Deposit must be greater than $0.");
        }
    }

    private void withdraw() {
        System.out.println("\n----- Withdraw -----");
        double amount = getDoubleInput("Enter amount to withdraw: $");

        if (amount > 0) {
            if (currentAccount.withdraw(amount)) {
                System.out.printf("Successfully withdrew $%.2f%n", amount);
                System.out.printf("New Balance: $%.2f%n", currentAccount.getBalance());
            } else {
                System.out.println("Insufficient funds or invalid amount.");
            }
        } else {
            System.out.println("Invalid amount. Withdrawal must be greater than $0.");
        }
    }

    private void changePin() {
        System.out.println("\n----- Change PIN -----");

        // Verify current PIN first
        System.out.print("Enter current PIN: ");
        String currentPin = scanner.nextLine().trim();

        if (!currentAccount.validatePin(currentPin)) {
            System.out.println("Incorrect current PIN.");
            return;
        }

        // Get new PIN with validation
        System.out.print("Enter new PIN (4 digits): ");
        String newPin = scanner.nextLine().trim();

        if (newPin.matches("\\d{4}")) {
            System.out.print("Confirm new PIN: ");
            String confirmPin = scanner.nextLine().trim();

            if (newPin.equals(confirmPin)) {
                currentAccount.changePin(newPin);
                System.out.println("PIN changed successfully!");
            } else {
                System.out.println("PINs do not match.");
            }
        } else {
            System.out.println("PIN must be exactly 4 digits.");
        }
    }

    private void viewAccountInfo() {
        System.out.println("\n----- Account Information -----");
        System.out.println(currentAccount);
    }

    private void logout() {
        System.out.println("\nLogging out... Goodbye, " +
                currentAccount.getAccountHolderName() + "!");
        currentAccount = null;
        bank.resetLoginAttempts();
    }

    // Utility methods
    private int getIntInput(String prompt) {
        while (true) {
            System.out.print(prompt);
            try {
                return Integer.parseInt(scanner.nextLine());
            } catch (NumberFormatException e) {
                System.out.print("Please enter a valid number: ");
            }
        }
    }

    private double getDoubleInput(String prompt) {
        while (true) {
            System.out.print(prompt);
            try {
                return Double.parseDouble(scanner.nextLine());
            } catch (NumberFormatException e) {
                System.out.print("Please enter a valid amount: ");
            }
        }
    }

    private double getDoubleInput(String prompt) {
        while (true) {
            System.out.print(prompt);
            String input = scanner.nextLine().trim();
            try {
                double value = Double.parseDouble(input);
                if (value < 0) {
                    System.out.println("Salary cannot be negative.");
                    continue;
                }
                return value;
            } catch (NumberFormatException e) {
                System.out.println("Invalid input. Please enter a valid salary.");
            }
        }
    }

    private String getStringInput(String prompt) {
        while (true) {
            System.out.print(prompt);
            String input = scanner.nextLine().trim();
            if (!input.isEmpty()) {
                return input;
            }
            System.out.println("Input cannot be empty. Please try again.");
        }
    }

    // Demonstration method to show all accounts (for testing)
    public void displayAllAccounts() {
        System.out.println("\n=== All Accounts (For Demonstration) ===");
        // This would typically not be in a real ATM
    }

    public static void main(String[] args) {
        Main atm = new Main();
        System.out.println("=== Welcome to Simple Banking App ===");

        while (atm.isRunning) {
            if (atm.currentAccount == null) {
                atm.showLoginMenu();
            } else {
                atm.showMainMenu();
            }
        }

        System.out.print("\nPress Enter to continue...");
        atm.scanner.nextLine();

        System.out.println("Thank you for using Our Banking App. Goodbye!");
        atm.scanner.close();
    }
}