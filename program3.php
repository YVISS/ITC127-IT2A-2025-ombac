<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecture 3: Operators in PHP</title>
    <link rel="stylesheet" href="css/modern-normalize.css">
    <link rel="stylesheet" href="css/p2.css">
    
</head>
<body>
    <h1>
        <?php echo "Program 3";?>
    </h1>
    
    <h3>
        <?php echo "Description: This program shows on how to use operators in PHP.";?>
    </h3>
    
    <?php 
        $num1 = 10;
        $num2 = 5;
        $sum = $num1 + $num2;
        $differnce = $num1 - $num2;
        $product = $num1 * $num2;
        $quotient = $num1 / $num2;
        $gt = $num1 > $num2;
        $lt = $num1 < $num2;

        echo "First Number: " . $num1;
        echo "<br>Second Number: ". $num2;
        echo "<br>Sum: " . $sum;
        echo "<br>Difference: " . $differnce;
        echo "<br>Product: ". $product;
        echo "<br>Quiotient: ". $quotient;
        echo "<br>Is the First number greater than the second number? " . $gt;
        echo "<br>Is the First number less than the second number?"  . $lt;
    ?>
</body>
</html>