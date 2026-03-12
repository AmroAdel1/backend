import java.util.InputMismatchException;
import java.util.Scanner;

/* Number Guessing Game */
public class NumberGuessingGame{
  public static void main(String[] args) {
    int computerNumber = (int) (Math.random() * 10) + 1;  
    int userNumber = 0;
    int attempts = 0;

    try(Scanner scanner = new Scanner(System.in);) {
      while (userNumber != computerNumber && attempts < 5) {
        System.out.print("Enter a number between 1 and 100: ");
        userNumber = scanner.nextInt();
        attempts++;

        if (userNumber < computerNumber) {
          System.out.println("Too low! Try again.");
        } else if (userNumber > computerNumber) {
          System.out.println("Too high! Try again.");
        } else if (userNumber == computerNumber) {
          System.out.println("Congratulations! You guessed the number in " + attempts + " attempts.");
          System.out.println("The Guessed Number is " + computerNumber);
          return;
        } 
      }
      if (attempts == 5) {
        System.out.println("You have reached the maximum number of attempts. The correct number was " + computerNumber);
      }
    }
    catch(InputMismatchException e){
      System.out.println("Invalid input. Please enter a number. " + e);
    }
  }
}