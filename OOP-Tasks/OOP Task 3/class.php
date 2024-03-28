<?php

class CollatzCalculator {                    
    public function calculateCollatz($number) {     
        $count = array();                   
        $maximum = $number;                 
        $iterationCounter = 0;              

        while ($number != 1) {  
            if ($number % 2 == 0) {         
                $number = $number / 2;      
            } else {
                $number = 3 * $number + 1;  
            }

            if ($number > $maximum) {       
                $maximum = $number;
            }

            $count[] = $number;     
            $iterationCounter++;    
        }

        return array('max' => $maximum, 'iterations' => $iterationCounter, 'steps' => $count);
    }

    public function calculateCollatzRange($first, $last) { 
        $resultArray = array(); 
        $totalmax = array(); 
        $allIterations = array(); 

        $maxIterNumber = 0; 
        $maxIter = 0;       
        $minIterNumber = 0; 
        $minIter = 1000000; 

        for ($i = $first; $i <= $last; $i++) {              
            $result = $this->calculateCollatz($i);          

            $totalmax[$i] = $result['max'];             

            if ($result['iterations'] > $maxIter) {
                $maxIter = $result['iterations'];
                $maxIterNumber = $i;
            }

            if ($result['iterations'] < $minIter) {
                $minIter = $result['iterations'];
                $minIterNumber = $i;
            }

            $allIterations[$i] = $result['steps'];  
        }

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
        $result = $this->calculateCollatzRange($start, $end);
        
        echo "<h3>Min and Max Iterations:</h3>";
        echo "<p>Number which has maximum iterations and total number of iteration: " . $result['maxIterNum'] . " (Iterations: " . $result['maxIter'] . ")</p>";
        echo "<p>Number which has minimum iterations and its total number of iteration: " . $result['minIterNum'] . " (Iterations: " . $result['minIter'] . ")</p>";
        
        echo "<h3> Numbers in this range</h3>";
        foreach ($result['maxNumValue'] as $number => $highest) { 
            echo "<p>Number: " . $number . ", Maximum Number: " . $highest . " (Iterations: " . count($result['allIterations'][$number]) . ")" . "</p>";
        }
    }
    
    public function calculationOfArithProgress($firstTerm, $commonDifference, $numberOfTerms) {
        $sum = ($numberOfTerms / 2) * (2 * $firstTerm + ($numberOfTerms - 1) * $commonDifference);
        return $sum;
    }
    
    public function ArithmeticSeq($a, $d, $n) {
        $sequence = array();
        $current_term = $a;
        
        for($i = 0; $i < $n; $i++){
            $sequence[] = $current_term;

            $current_term += $d;
        }
        return $sequence;
    }
}

class CollatzCalculatorChild extends CollatzCalculator {  //We define a "Collatz Calculator Child".

//The child inherits properties and methods from our "CollatzCalculator".

    private $histogram;    //histogram is a private property.

    //We use this "$histogram" to fill the data that we calculate for histogram.

    public function histCalc($interval) {   //This is public function that takes "interval" as a paramater. [n;m] (range for our Collatz sequence)
    
        $max = 0;       //This "max" variable is to find maximum iteration number. (The iteration number that we are able to see for all of the numbers)
        //Knowing this information helps us to declare a range for our histogram. It means that max is gonna be the last value of our histogram.

        $histInfo = array();    //We will store the frequency of iteration counts in this array.

        for ($i = $interval[0]; $i <= $interval[1]; $i++) {     

            /* $interval[0] is to initialize the first value of our range,
            so it compares the first one with the second one... Until it reaches
            to last value of our range.
            */

            $result = $this->calculateCollatz($i); 
            $max = max($max, $result['max']);

            /*
            We call the calculate Collatz method for the number $i we have and 
            calculate the Collatz sequence for this value. 
            We iterate this with each number $i, until the end value. 
            
            With $result, we store the Collatz sequence information calculated for the number "$i".
            */
    
            
            $iterationCount = $result['iterations'];
            /*
            We get the number of iterations of the Collatz sequence
            needed to reach 1. This information is stored in the "$iterationCount".
            */

            if (isset($histInfo[$iterationCount])) {
                $histInfo[$iterationCount]++;
            } else {
                $histInfo[$iterationCount] = 1;
            }

            /*
            For the if-else part;
            if the iteration number is already in $histInfo array, so it means that this itertion 
            number was encountered before, so frequency count is increased by 1 for that number. However,
            it is not included in our array, number of iterations is assigned as value 1,
            and it represents starting frequency count.
            */
        }

        
        
        ksort($histInfo);       //The ksort function sorts the iteration numbers on the x-axis in the histogram from smallest to largest.
        
        $this->histogram = array_fill(0, $max + 1, 0);

        /*
        array_fill() function is used to fill the array with zeros. Three elements of this array is;
        firstly; first index to start -- beginning of the sequence
        secondly; number of elements to fill -- iteration number can start from 0
        untill the maximum value that we mentioned above ($max). So it is shown as 
        $max + 1. It is important to have all iterations.
        thirdly; value to fill the array -- it is set to 0, we start to fill frequencies with "0".
        */
    
       
        $this->histogram = $histInfo; //The $histInfo array is assigned to the "$this->histogram" property as an array containing the frequencies of the calculated iteration numbers. 
                                        //So this creates the array that represents the histogram.
    
        return $this->histogram;        //returning the histogram array
    }
    
    public function showHist($start, $end) {
        $interval = [$start, $end];
        $histogram = $this->histCalc($interval);

        /*
        We use $start and $end parameters for our range again. In this method,
        we make $interval array to include these parameters. So when histogram
        calculation ($histCalc) method is called with $interval, we are able to calculate
        information in histogram (for specified range). $histogram stores this information.
        */
    
        $maxCount = max($histogram); //maximum frequency count; it is necessary to normalize the height of columns

       
        
        ?>

        <div class="histogram-container">
            <?php
            foreach ($histogram as $iteration => $frequency) {
                $barHeight = ($frequency / $maxCount) * 100; // calculating the height of the bars
                ?>
                <div class="bar" style="height: 
                <?php 
                echo $barHeight; ?>%;" title="
                <?php echo $iteration . ' (' . $frequency . ')'; ?>">
                <span class="bar-label"><?php echo $iteration . ' (' . $frequency . ')'; ?></span>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
    

}