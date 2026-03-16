import java.util.List;
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

        if (currentAccount.withdraw(amount)) {
            System.out.printf("Successfully withdrew $%.2f%n", amount);
            System.out.printf("New Balance: $%.2f%n", currentAccount.getBalance());
        } else {
            System.out.println("Invalid amount. Withdrawal must be greater than $0.");          //System.out.println("Insufficient funds or invalid amount.");
        }
    }

    private void changePin() {
        System.out.println("\n----- Change PIN -----");

        // Verify current PIN first
        String currentPin = getStringInput("Enter current PIN: ");

        if (!currentAccount.validatePin(currentPin)) {
            System.out.println("Incorrect current PIN.");
            return;
        }

        // Get new PIN with validation
        String newPin = getStringInput("Enter new PIN (4 digits): ");
        String confirmPin = getStringInput("Confirm new PIN: ");

        if (!newPin.equals(confirmPin)) {
            System.out.println("PINs do not match.");
            return;
        }

        if (currentAccount.changePin(newPin)) {
            System.out.println("PIN changed successfully.");
        } else {
            System.out.println("PIN must be exactly 4 digits.");
        }
    }

    private void viewAccountInfo() {
        System.out.println("\n----- Account Information -----");
        System.out.println(currentAccount);
    }

    private void viewTransactionHistory() {
        List<String> history = currentAccount.getTransactionHistory();
        if (history.isEmpty()) {
            System.out.println("No transactions yet.");
            return;
        }
        System.out.println("\n----- Transaction History -----");
        for (int i = 0; i < history.size(); i++) {
            System.out.printf("%2d. %s%n", i + 1, history.get(i));
        }
    }

    private void logout() {
        System.out.println("\nLogging out... Goodbye, " +
                currentAccount.getAccountHolderName() + "!");
        currentAccount = null;
        // bank.resetLoginAttempts();
    }

    // Utility methods
    private int getIntInput(String prompt) {
        while (true) {
            System.out.print(prompt);
            String input = scanner.nextLine().trim();
            try {
                return Integer.parseInt(input);
            } catch (NumberFormatException e) {
                System.out.println("Please enter a valid number: ");
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
                    System.out.println("Amount cannot be negative.");
                    continue;
                }
                return value;
            } catch (NumberFormatException e) {
                System.out.println("Invalid input. Please enter a valid amount.");
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
    
    private void showLoginMenu() {
        System.out.println("\n----- ATM Login -----");
        System.out.println("1. Login");
        System.out.println("2. Exit");
    }

    private void showMainMenu() {
        System.out.println("\n===== MAIN MENU =====");
        System.out.println("1. Check Balance");
        System.out.println("2. Deposit");
        System.out.println("3. Withdraw");
        System.out.println("4. Change PIN");
        System.out.println("5. View Account Info");
        System.out.println("6. View Transaction History");
        System.out.println("7. Logout");
        System.out.println("=====================");
    }

    public static void main(String[] args) {
        Main atm = new Main();
        System.out.println("=== Welcome to Simple Banking App ===");

        while (atm.isRunning) {
            if (atm.currentAccount == null) {
                atm.showLoginMenu();
                int choice = atm.getIntInput("Choose option: ");

                switch (choice) {
                    case 1 -> atm.login();
                    case 2 -> atm.isRunning = false;
                    default -> System.out.println("Invalid option. Please try again.");
                }
            } else {
                atm.showMainMenu();
                int choice = atm.getIntInput("Choose option: ");

                switch (choice) {
                    case 1 -> atm.checkBalance();
                    case 2 -> atm.deposit();
                    case 3 -> atm.withdraw();
                    case 4 -> atm.changePin();
                    case 5 -> atm.viewAccountInfo();
                    case 6 -> atm.viewTransactionHistory();
                    case 7 -> atm.logout();
                    default -> System.out.println("Invalid option. Please try again.");
                }
            }

            System.out.println("\nPress Enter to continue...");
            atm.scanner.nextLine();
        }

        System.out.println("Thank you for using Our Banking App. Goodbye!");
        atm.scanner.close();
    }
}

// private int getIntInputWithDefault(String prompt, int defaultValue) {
//     System.out.print(prompt);
//     String input = scanner.nextLine().trim();
//     if (input.isEmpty()) return defaultValue;
//     try {
//         return Integer.parseInt(input.trim());
//     } catch (NumberFormatException e) {
//         System.out.println("Invalid input. Using default value: " + defaultValue);
//         return defaultValue;
//     }
// }