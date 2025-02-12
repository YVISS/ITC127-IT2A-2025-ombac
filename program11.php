<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecture 7: HTML FORM PROCESSING</title>
    <link rel="stylesheet" href="css/modern-normalize.css">
    <link rel="stylesheet" href="css/p7.css">

</head>

<body>
    <h1>
        <?php echo "Program 11"; ?>
    </h1>

    <h3>
        <?php echo "Description: This program shows on how to process forms with Check Boxes in HTML using php"; ?>
    </h3>
    <form action="" method="GET">
        Input Number: <input type="text" name="txtinput1"><br>
        Input Number: <input type="text" name="txtinput2"><br>
        <input type="checkbox" name="cbAdd">Add<br>
        <input type="checkbox" name="cbSubtract">Subtract<br>
        <input type="checkbox" name="cbMultiply">Multiply<br>
        <input type="checkbox" name="cbDivide">Divide<br>
        <input type="submit" name="btnsubmit" value="Submit">

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
if (isset($_GET["btnsubmit"])) {
    $errors = 0;
    //validate input 1
    $errors = validateInput1() + validateInput2();
    //IPO
    if($errors == 0){
        $num1 = $_GET["txtinput1"];
        $num2 = $_GET["txtinput2"];
        $msg = "First number: ". $num1 . "<br>Second Number: " . $num2;
        //get selected operation
        if(isset($_GET["cbAdd"])){
            //process
            $result = $num1 + $num2;
            //response
            $msg .= "<br>Sum: " . $result;
        }
        if(isset($_GET["cbSubtract"])){
            //process
            $result = $num1 - $num2;
            //response
            $msg .= "<br>Difference: " . $result;
        }
        if(isset($_GET["cbMultiply"])){
            //process
            $result = $num1 * $num2;
            //response
            $msg .= "<br>Product: " . $result;
        }
        if(isset($_GET["cbDivide"])){
            //process
            $result = $num1 / $num2;
            //response
            $msg .= "<br>Quotient: " . $result;
        }
        //output msg

        echo $msg;

    }
        

}

?>
