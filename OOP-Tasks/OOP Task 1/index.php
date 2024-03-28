<!DOCTYPE html>
<html>
<head>
    <title>Collatz Problem</title>
</head>
<body>

<h1>3x + 1 Collatz Problem Calculator</h1>

<h2>Calculation of Only One Number</h2>
<form method="get" action="">

    <label for="singleNumber">Enter a Number:</label>
    <input type="number" name="singleNumber" required>
    <input type="submit" name="submittingSingleNumber" value="Send">

</form>

<h2>Calculation of the Numbers Between Two Numbers</h2>

<form action="" method="get">
    <label for="start">Start Number:</label>
    <input type="number" name="start" required>
    <label for="end">End Number:</label>
    <input type="number" id="end" name="end" required>
    <input type="submit" name="submittingRange" value="Send">

</form>

<?php

include('functions.php');

if (isset($_GET["submittingSingleNumber"])) {

    $singleNumber = $_GET["singleNumber"];
    $result = CalculationCollatz($singleNumber);

    echo "<h3>Results for the Single Number:</h3>";
    echo "<p>Maximum Value: " . $result['max'] . "</p>";
    echo "<p>Iterations: " . $result['iterations'] . "</p>";
    echo "<p>Steps:</p>";
    foreach ($result['steps'] as $step) {
        echo $step . "<br>";
    }
}

if (isset($_GET["submittingRange"])) {

    $first = $_GET["start"];
    $last = $_GET["end"];

    CalculateRange($first, $last);
}
?>
</body>
</html>
