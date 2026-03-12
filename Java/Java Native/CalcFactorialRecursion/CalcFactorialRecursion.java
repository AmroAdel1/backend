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
      System.out.println("Enter a number: ");
      int num = sc.nextInt();
      int factorialResult = CalcFactorialUsingRecursion(num);
      System.out.println("The Factorial of " + num + " is " + factorialResult);
    } catch (Exception e) {
      System.out.println(e);
    }
  }
}
