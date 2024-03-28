<?php

class CollatzCalculator{                    //The class which includes our functions                
    public function calculateCollatz($number) {     //a public method: calculateCollatz in the CollatzCalculator class. Our parameter is "$number".
        $count = array();                   //This empty array is to store the sequence which is created for Collatz Calculation.
        $maximum = $number;                 // It is for the maximum value we must find in the sequence from Collatz Calculation. Firstly, it is set to first number.
        $iterationCounter = 0;              //This variable is started with 0. The aim is to count the number of iterations required to reach the end of the Collatz sequence

        while ($number != 1) {  //This while loop continues to iterate as long as the value of "$number" is not equal to 1.
            if ($number % 2 == 0) {         //In this part, we separate odd and even numbers for our Collatz Calculator.
                $number = $number / 2;      //If the number is even, we divide it by 2.
            } else {
                $number = 3 * $number + 1;  //If the number is odd, we multiply it by 3, and add 1.
            }

            if ($number > $maximum) {       //This if condition updates the "$maximum" value if the current value of "$number" is greater than the current maximum value.
                $maximum = $number;
            }

            $count[] = $number;     //Here, the current value of "$number" is added to the "$count" array. In this way, we get the array created during the calculation.

            $iterationCounter++;    //And here, we increase the number of iterations until the number 1 is reached in the sequence.
        }

        return array('max' => $maximum, 'iterations' => $iterationCounter, 'steps' => $count);
        //storing the maximum value encountered -- total number of iterations to reach the last value -- storing created number sequence)

    }

    public function calculateCollatzRange($first, $last) { //First and last parameters are to create a range.
        $resultArray = array(); //Storing array of numbers in range
        $totalmax = array(); //storing the maximum value of each number in the range
        $allIterations = array(); //storing the number array of each number in the range
        

        $maxIterNumber = 0; //number with maximum number of iterations
        $maxIter = 0;       //maximum number of iterations
        $minIterNumber = 0; //number with minimum number of iterations
        $minIter = 1000000; //minimum number of iterations. By setting it to a large number, we ensure that the first value encountered is considered the minimum and can be updated.

        for ($i = $first; $i <= $last; $i++) {              //It starts with the value $first and continues until it reaches the value $last.
            $result = $this->calculateCollatz($i);          //It calls the "calculateCollatz()" method with the current number "i" within the loop.

            $totalmax[$i] = $result['max'];             //It stores the maximum value encountered for number i in the $totalmax array.

            if ($result['iterations'] > $maxIter) {
                $maxIter = $result['iterations'];
                $maxIterNumber = $i;
            }
            
            // (above)-- If the number of iterations for number i is greater than the maximum number of iterations encountered so far, it updates the value with the new maximum number of iterations and with a new number i. It is same logic for the minimum number. -- (below)

            if ($result['iterations'] < $minIter) {
                $minIter = $result['iterations'];
                $minIterNumber = $i;
            }

            $allIterations[$i] = $result['steps'];  //storing the iterations 
        }

        //storing all of the obtained values
        
        $resultArray['max'] = max($totalmax);
        $resultArray['minIterNum'] = $minIterNumber;
        $resultArray['minIter'] = $minIter;
        $resultArray['maxIterNum'] = $maxIterNumber;
        $resultArray['maxIter'] = $maxIter;
        $resultArray['maxNumValue'] = $totalmax;
        $resultArray['allIterations'] = $allIterations;

        return $resultArray;
    }

    public function calculateRange($start, $end) {
        
        $result = $this->calculateCollatzRange($start, $end);       //Calling the Collatz Range method to calculate the required operations for numbers in the specified range -- storing them in the array.
        
        //Printing results
        
        echo "<h3>Min and Max Iterations:</h3>";
        echo "<p>Number which has maximum iterations and total number of iteration: " . $result['maxIterNum'] . " (Iterations: " . $result['maxIter'] . ")</p>";
        echo "<p>Number which has minimum iterations and its total number of iteration: " . $result['minIterNum'] . " (Iterations: " . $result['minIter'] . ")</p>";
        
        echo "<h3> Numbers in this range</h3>";
        foreach ($result['maxNumValue'] as $number => $highest) { 
            echo "<p>Number: " . $number . ", Maximum Number: " . $highest . " (Iterations: " . count($result['allIterations'][$number]) . ")" . "</p>";
        }
    }
    
    public function calculationOfArithProgress($firstTerm, $commonDifference, $numberOfTerms){      //These  three parameters are for first term of the arithmetic progress, common difference between two numbers, and total terms.
        $sum = ($numberOfTerms / 2) * (2 * $firstTerm + ($numberOfTerms - 1) * $commonDifference); //Arithmetic Formula to find sum of the numbers 
        
        return $sum;
    }
    
    public function ArithmeticSeq($a, $d, $n){      //a is for first number, d is for difference, n is for number of terms 
        $sequence = array();                        //storing the number sequence in the array
        $current_term = $a;                         //initializing the current term with the first number
        
        for($i = 0; $i < $n; $i++){
            $sequence[] = $current_term;   //$current_term is added to the "sequence" array and the current term is added to the sequence.

            $current_term += $d;            //finding next number in sequence by adding common difference
        }
        return $sequence;
    }
}

?>