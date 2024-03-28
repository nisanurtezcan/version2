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

class CollatzCalculatorChild extends CollatzCalculator {  



    private $histogram;    

    

    public function histCalc($interval) {   
    
        $max = 0;       
        $histInfo = array();    

        for ($i = $interval[0]; $i <= $interval[1]; $i++) {     

            $result = $this->calculateCollatz($i); 
            $max = max($max, $result['max']);
    
            
            $iterationCount = $result['iterations'];

            if (isset($histInfo[$iterationCount])) {
                $histInfo[$iterationCount]++;
            } else {
                $histInfo[$iterationCount] = 1;
            }

        }

        
        
        ksort($histInfo);       
        
        
        $this->histogram = array_fill(0, $max + 1, 0);
    
       
        $this->histogram = $histInfo;  
                                      
    
        return $this->histogram;            }
    
    public function showHist($start, $end) {
        $interval = [$start, $end];
        $histogram = $this->histCalc($interval);
    
        $maxCount = max($histogram);        
        
        ?>

        <div class="histogram-container">
            <?php
            foreach ($histogram as $iteration => $frequency) {
                $barHeight = ($frequency / $maxCount) * 100; 
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