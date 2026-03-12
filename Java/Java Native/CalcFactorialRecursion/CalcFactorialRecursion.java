package CalcFactorialRecursion;

import java.util.Scanner;

// Calculate factorial using recursion
public class CalcFactorialRecursion {

  static int CalcFactorialUsingRecursion(int num) {
    if(num == 1) {
      return 1;
    } else {
      return num * CalcFactorialUsingRecursion(num - 1);
    }
  }

  public static void main(String[] args) {
    try (Scanner sc = new Scanner(System.in)) {

      // Keeps prompting the user until a valid input is given.
      while (true) {
        System.out.println("Enter a number: ");
        
        if (!sc.hasNextInt()) {
          System.out.println("Invalid input. Please enter a number, not a character.");
          sc.next();
          continue;    // re-prompt
        }

        int num = sc.nextInt();

        if (num <= 0) {
          System.out.println("Invalid input. Can't calculate the factorial of a Negative Number or Zero.");
          continue;
        }

        int factorialResult = CalcFactorialUsingRecursion(num);
        System.out.println("The Factorial of " + num + " is " + factorialResult);
        break;
      }
    }
  }
}
