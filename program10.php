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
        <?php echo "Program 10"; ?>
    </h1>

    <h3>
        <?php echo "Description: This program shows on how to process forms with Select Option in HTML using php"; ?>
    </h3>
    <form action="" method="GET">
        Input Number: <input type="text" name="txtinput1"><br>
        Input Number: <input type="text" name="txtinput2"><br><br>
        
        Choose an operation:<br><select name="cmboperation" id="cmboperation">
            <option value="Add">Add</option>
            <option value="Subtract">Subtract</option>
            <option value="Multiply">Multiply</option>
            <option value="Divide">Divide</option>
        </select><br>
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
        //get selected operation
        if($_GET["cmboperation"] == "Add"){
            //process
            $result = $num1 + $num2;
            //response
            echo "First number: ". $num1 . "<br>Second Number: " . $num2 . "<br>Sum: " . $result;
        }
        else if($_GET["cmboperation"] == "Subtract"){
            //process
            $result = $num1 - $num2;
            //response
            echo "First number: ". $num1 . "<br>Second Number: " . $num2 . "<br>Difference: " . $result;
        }
        else if($_GET["cmboperation"] == "Multiply"){
            //process
            $result = $num1 * $num2;
            //response
            echo "First number: ". $num1 . "<br>Second Number: " . $num2 . "<br>Product: " . $result;
        }
        else{
            //process
            $result = $num1 / $num2;
            //response
            echo "First number: ". $num1 . "<br>Second Number: " . $num2 . "<br>Quotient: " . $result;
        }

    }
        

}

?>
