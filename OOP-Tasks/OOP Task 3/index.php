<!DOCTYPE html> 
<html> 
<head> 
    <title>Collatz Problem</title> 
    <style>
        .histogram-container {
            display: flex;
            align-items: flex-end;
            height: 300px;
            padding: 20px;
        }

        .bar {
            width: 20px;
            margin-right: 5px;
            background-color: paleturquoise;
            transition: height 0.5s;
        }

        .bar-label {
            margin-top: 5px;
            font-size: 12px;
            transform: rotate(-45deg);
        }

        .y-axis {
    margin-right: 5px;
    padding-right: 5px;
    border-right: 1px solid #000;
    text-align: right;
}

    </style>
</head> 
<body> 
 
<h1>3x + 1 Collatz Problem Calculator</h1> 
 
<h2>Calculation of Only One Number</h2> 
<form method="get" action=""> 
 
    <label for="singleNumber">Enter a Number:</label> 
    <input type="number" name="singleNumber" required>
    <input type="submit" name="submittingSingleNumber" value="Send"> 
</form> 

<br>
<hr />

<h2>Calculation of the Numbers Between Two Numbers</h2> 
 
<form action="" method="get"> 
    <label for="start">Start Number:</label> 
    <input type="number" name="start" required> 
    <label for="end">End Number:</label> 
    <input type="number" id="end" name="end" required> 
    <input type="submit" name="submittingRange" value="Send"> 
</form>

<?php
require_once 'class.php';
$calculator = new CollatzCalculator();

if (isset($_GET["submittingSingleNumber"])) {
    $singleNumber = $_GET["singleNumber"];
    $result = $calculator->calculateCollatz($singleNumber); 

    echo "<h3>Results for the Single Number:</h3>";
    echo "<p>Maximum Value: " . $result['max'] . "</p>";
    echo "<p>Iterations: " . $result['iterations'] . "</p>";
    echo "<p>Steps:</p>";
    foreach ($result['steps'] as $step) {
        echo $step . ", ";
    }
}

if (isset($_GET["submittingRange"])) {
    $first = $_GET["start"];
    $last = $_GET["end"];

    $calculator->calculateRange($first, $last);
}

$childCalculator = new CollatzCalculatorChild();
echo "<h2>Histogram</h2>";

if (isset($_GET["start"]) && isset($_GET["end"])) {
    $start = $_GET["start"];
    $end = $_GET["end"];
    $childCalculator->showHist($start, $end);

    echo "<h4>- The number which is on top of the column represents the iteration numbers for each number between two entered numbers.</h4>";
    echo "<h4>- The number which is with brackets represents how many times the iteration number repeats.</h4>";
    
} else {
    echo "(The start and end numbers must be entered to see the histogram results.)";
}
?>

<br>
<hr />

<h2>Calculation of Arithmetic Progression</h2> 
 
<form action="./" method="GET"> 
    <label for="fst">First Term:</label> 
    <input type="number" name="fst" required> 
    <label for="cd">Common Difference:</label> 
    <input type="number" name="cd" required>
    <label for="lst">Number of Term:</label> 
    <input type="number" name="lst" required> 
    <input type="submit" name="calculationOfArithProgress" value="Calculate AP" /> 
</form>

<?php
if (isset($_GET["calculationOfArithProgress"])) {
    $fst = $_GET["fst"];
    $cd = $_GET["cd"];
    $lst = $_GET["lst"];
    
    $arithSum = $calculator->calculationOfArithProgress($fst, $cd, $lst);   
    $arithSeq = $calculator->ArithmeticSeq($fst, $cd, $lst);       
    
    echo "<p>Arithmetic Sum: ".$arithSum."</p>";
    echo "<p>Arithmetic Series: ";
    foreach($arithSeq as $aS){
        echo $aS.", ";
    }
    echo "</p>";
}
?>

</body> 
</html>
