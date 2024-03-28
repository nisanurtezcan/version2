<?php

function CalculationCollatz($number) {
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

function CalculationCollatzRange($first, $last) {
    $resultArray = array();
    $totalmax = array();
    $allIterations = array();

    $maxIterNumber = 0;
    $maxIter = 0;
    $minIterNumber = 0;
    $minIter = 1000000;

    for ($i = $first; $i <= $last; $i++) {
        $result = CalculationCollatz($i);

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

function CalculateRange($start, $end) {
    $result = CalculationCollatzRange($start, $end);

    echo "<h3>Min and Max Iterations:</h3>";
    echo "<p>Number which has maximum iterations and total number of iteration: " . $result['maxIterNum'] . " (Iterations: " . $result['maxIter'] . ")</p>";
    echo "<p>Number which has minimum iterations and its total number of iteration: " . $result['minIterNum'] . " (Iterations: " . $result['minIter'] . ")</p>";

    echo "<h3> Numbers in this range</h3>";
    foreach ($result['maxNumValue'] as $number => $highest) {
        echo "<p>Number: " . $number . ", Maximum Number: " . $highest . "</p>";
    }

    echo "<h3>All Iterations:</h3>";
    foreach ($result['allIterations'] as $number => $iterations) {
        echo "<p>Number: " . $number . " (Iterations: " . count($iterations) . ")" . "</p>";
        foreach ($iterations as $iteration) {
            echo $iteration . "<br>";
        }
    }
}
