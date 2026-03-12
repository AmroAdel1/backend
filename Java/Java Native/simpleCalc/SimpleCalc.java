package simpleCalc;
import java.util.InputMismatchException;
import java.util.Scanner;

/* Simple Calculator */
public class SimpleCalc {
  public static void main(String[] args) {
    System.out.println("Welcome to the Simple Calculator!");

    try(Scanner scanner = new Scanner(System.in);){

      System.out.print("Enter the first number: ");
      double num1 = scanner.nextDouble();  

      System.out.print("Enter the second number: ");
      double num2 = scanner.nextDouble();

      System.out.print("Enter the operation (+, -, *, /): ");
      char operation = scanner.next().charAt(0);

      double result = 0;

      switch (operation) {
        case '+' -> result = num1 + num2;
        case '-' -> result = num1 - num2;
        case '*' -> result = num1 * num2;
        case '/' -> {
            if (num2 != 0) { result = num1 / num2; } 
            else { throw new ArithmeticException("Error: Division by zero is not allowed."); } 
          }
        default -> {
            System.out.println("Error: Invalid operation.");
            return;
          }
      }
      System.out.println("Result: " + result);
    }
    catch (ArithmeticException | InputMismatchException e) {
      System.out.println(e.getMessage());
    }
  }
}