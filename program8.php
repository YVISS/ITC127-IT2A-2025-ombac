<!--Create a program that will accept inputs for your name, your birthyear and the year today and will compute for your age, 
age in months, days, hours, minutes, and seconds where 1 year = 12 months, 1 month = 30 days, 1 day = 24 hours, 
1 hour = 60 minutes, 1 minute = 60 seconds. Birth year input should be from 1950 to 2050 only while year today input should be 
from 1950 to 2050 only. Use either POST or GET method.-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prorgam 8</title>
    <link rel="stylesheet" href="css/modern-normalize.css">
    <link rel="stylesheet" href="css/p6.css">
</head>

<body>
    <h1>Program 8</h1>
    <form action="" method="GET">

        Name: <input type="text" name="txtInputName">
        Birth Year: <input type="text" name="txtInputBirthYear">
        Year Today: <input type="text" name="txtInputYearToday">
        <br><br><input type="submit" name="btnCompute" value="Submit">

        <?php

        function validateBirthYear(){
            $errorBirthYear = 0;
            if(empty($_GET["txtInputBirthYear"])){
                echo "<br><font color ='red'>Birth Year should not be empty!</font>";
                $errorBirthYear++;
            }else if(!is_numeric($_GET['txtInputBirthYear'])){
                echo "<br><font color='red'>Birth Year should be numeric!</font>";
                $errorBirthYear++;
            }
            else if($_GET['txtInputBirthYear'] < 1950 || $_GET['txtInputBirthYear'] > 2050){
                echo "<br><font color ='red'>Birth Year should be from from 1950 to 2050 only!</font>";
                $errorBirthYear++;
            }else{
                $errorBirthYear = 0;
            }

            return $errorBirthYear;
        }
        function validateYearToday(){
            $errorYearToday = 0;
            if(empty($_GET["txtInputBirthYear"])){
                echo "<br><font color ='red'>Year should not be empty!</font>";
                $errorYearToday++;
            }
            else if(!is_numeric($_GET["txtInputYearToday"])){
                echo "<br><font color='red'>Year should be numeric!</font>";
                $errorYearToday++;
            }
            else if($_GET["txtInputYearToday"] < 1950 || $_GET["txtInputYearToday"] > 2050){
                echo "<br><font color ='red'>Year should be from from 1950 to 2050 only</font>";
                $errorYearToday++;
            }else{
                $errorYearToday = 0;
            }
        
            return $errorYearToday;
        }

        if (isset($_GET["btnCompute"])) {

            $error = validateBirthYear() + validateYearToday();
            if($error == 0){
                $name = $_GET["txtInputName"];
                $birthYear = $_GET["txtInputBirthYear"];
                $yearToday = $_GET["txtInputYearToday"];

                $age = $yearToday - $birthYear;
                $ageInMonths = $age * 12;
                $ageInDays = $age * 365;
                $ageInHours = $ageInDays * 24;
                $ageInMinutes = $ageInHours * 60;
                $ageInSeconds = $ageInMinutes * 60;

                echo "<br>Name: " . $name;
                echo "<br>Age: " . $age. " years old";
                echo "<br>Age in Months: " . $ageInMonths." months";
                echo "<br>Age in Days: " . $ageInDays ." days";
                echo "<br>Age in Hours: " . $ageInHours ." hours";
                echo "<br>Age in Minutes: " . $ageInMinutes ." minutes";
                echo "<br>Age in Seconds: " . $ageInSeconds ." seconds";
            }
        }


        ?>
    </form>
</body>

</html>