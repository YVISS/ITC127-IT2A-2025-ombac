<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecture 2: Variable Declaration in PHP</title>
    <link rel="stylesheet" href="css/modern-normalize.css">
    <link rel="stylesheet" href="css/p2.css">
    
</head>
<body>
    <h1>
        <?php echo "Program 2";?>
    </h1>
    
    <h3>
        <?php echo "Description: This program shows on how to use variables in PHP.";?>
    </h3>
    
    <?php 
        $num = 30;
        $pi = 3.14;
        $letter = "a";
        $result = "true";
        $msg = "error";


        echo "Variable num contains ". $num;
        echo "<br>Variable pi contains ". $pi;

        echo "Variable letter contains ". $letter ."<br>Variable result contains "
            . $result. "<br>Variable msg contains ". $msg;
    ?>
    
</body>
</html>