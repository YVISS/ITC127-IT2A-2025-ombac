<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecture 4: Form Processing Using PHP Post Method</title>
    <link rel="stylesheet" href="css/modern-normalize.css">
    <link rel="stylesheet" href="css/p4.css">

</head>

<body>
    <h1>
        <?php echo "Program 4"; ?>
    </h1>

    <h3>
        <?php echo "Description: This program shows on how to use aceept input using HTML FORM and PHP Post Method"; ?>
    </h3>
    <form action="" method="POST">
        Input Number: <input type="text" name="txtinput1"><br>
        Input Number: <input type="text" name="txtinput2"><br>
        <input type="submit" name="btnAdd" value="Add">
        <input type="submit" name="btnSub" value="Subtract">
        <input type="submit" name="btnDivide" value="Divide">
        <input type="submit" name="btnMult" value="Multiply">

    </form>


</body>

</html>
<?php

    if (isset($_POST["btnAdd"])) { //check for the object that requested buttons
        //request inputs
        $input1 = $_POST['txtinput1'];
        $input2 = $_POST['txtinput2'];

        //process
        $res = $input1 + $input2;

        //output
        echo "First Number: " . $input1;
        echo "<br>Second Number: " . $input2;
        echo "<br>Result: " . $res;
    }
    if (isset($_POST["btnSub"])) { //check for the object that requested buttons
        //request inputs
        $input1 = $_POST['txtinput1'];
        $input2 = $_POST['txtinput2'];

        //process
        $res = $input1 - $input2;

        //output
        echo "First Number: " . $input1;
        echo "<br>Second Number: " . $input2;
        echo "<br>Result: " . $res;
    }
    if (isset($_POST["btnDivide"])) { //check for the object that requested buttons
        //request inputs
        $input1 = $_POST['txtinput1'];
        $input2 = $_POST['txtinput2'];

        //process
        $res = $input1 / $input2;

        //output
        echo "First Number: " . $input1;
        echo "<br>Second Number: " . $input2;
        echo "<br>Result: " . $res;
    }
    if (isset($_POST["btnMult"])) { //check for the object that requested buttons
        //request inputs
        $input1 = $_POST['txtinput1'];
        $input2 = $_POST['txtinput2'];

        //process
        $res = $input1 * $input2;

        //output
        echo "First Number: " . $input1;
        echo "<br>Second Number: " . $input2;
        echo "<br>Result: " . $res;
    }
    
?>