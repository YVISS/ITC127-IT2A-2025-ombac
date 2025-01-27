<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecture 6: HTML FORM VALIDATION</title>
    <link rel="stylesheet" href="css/modern-normalize.css">
    <link rel="stylesheet" href="css/p5.css">

</head>

<body>
    <h1>
        <?php echo "Program 7"; ?>
    </h1>

    <h3>
        <?php echo "Description: This program shows on how to validate form inputs using php"; ?>
    </h3>
    <form action="" method="GET">
        Input Number: <input type="text" name="txtinput1"><br>
        Input Number: <input type="text" name="txtinput2"><br>
        <input type="submit" name="btnAdd" value="Add">
        <input type="submit" name="btnSub" value="Subtract">
        <input type="submit" name="btnDivide" value="Divide">
        <input type="submit" name="btnMult" value="Multiply">
        <input type="submit" name="" value="Clear">

    </form>


</body>

</html>
<?php

    function validateInput1(){
        $errorInput1 = 0;
        //validate input 1
        if(empty($_GET['txtinput1'])){
            echo "<br><font color='red'> First Input is empty!</font><br>";
            $errorInput1++;
        }
        else if(!is_numeric($_GET['txtinput1'])){
            echo "<br><font color='red'> First Input is not a number!</font><br>";
            $errorInput1++;
        }
        else{
            $errorInput1 = 0;
        }
        return $errorInput1;
    }
    function validateInput2(){
        $errorInput2 = 0;
        //validate input 2        
        if(empty($_GET['txtinput2'])){
            echo "<br><font color='red'> Second Input is empty!</font><br>";
            $errorInput2++;
        }
        else if(!is_numeric($_GET['txtinput2'])){
            echo "<br><font color='red'> Second Input is not a number!</font><br>";
            $errorInput2++;
        }
        else{
            $errorInput2 = 0;
        }

        return $errorInput2;
    }
    
    //BTNADD
    if (isset($_GET["btnAdd"])) { //check for the object that requested buttons
        $error = validateInput1() + validateInput2();
        //validate errors
        if($error == 0){
            //request inputs
        $input1 = $_GET['txtinput1'];
        $input2 = $_GET['txtinput2'];

        //process
        $res = $input1 + $input2;

        //output
        echo "First Number: " . $input1;
        echo "<br>Second Number: " . $input2;
        echo "<br>Result: " . $res;
        }
        
    }

    //BTNSUB
    if (isset($_GET["btnSub"])) { //check for the object that requested buttons
        //validate inputs
        $error = validateInput1() + validateInput2();

        if($error == 0){
            //request inputs
            $input1 = $_GET['txtinput1'];
            $input2 = $_GET['txtinput2'];

            //process
            $res = $input1 - $input2;

            //output
            echo "First Number: " . $input1;
            echo "<br>Second Number: " . $input2;
            echo "<br>Result: " . $res;
        }

    }

    //BTNDIVIDE
    if (isset($_GET["btnDivide"])) { //check for the object that requested buttons

        $error = validateInput1() + validateInput2();

        if($error == 0){    

        //request inputs
        $input1 = $_GET['txtinput1'];
        $input2 = $_GET['txtinput2'];

        //process
        $res = $input1 / $input2;

        //output
        echo "First Number: " . $input1;
        echo "<br>Second Number: " . $input2;
        echo "<br>Result: " . $res;
        }
    }

    //BTNMULTI
    if (isset($_GET["btnMult"])) { //check for the object that requested buttons
        //validate inputs
        $error = validateInput1() + validateInput2();
        if ($error == 0) {
            //request inputs
        $input1 = $_GET['txtinput1'];
        $input2 = $_GET['txtinput2'];

        //process
        $res = $input1 * $input2;

        //output
        echo "First Number: " . $input1;
        echo "<br>Second Number: " . $input2;
        echo "<br>Result: " . $res;
        }
        
    }
    
?>