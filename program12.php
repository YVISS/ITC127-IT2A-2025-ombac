<!--Create a program (program 12) that will accept inputs for your name, your birthyear and the year today and will compute for your age, 
age in months, days, hours, minutes, and seconds where 1 year = 12 months, 1 month = 30 days, 1 day = 24 hours, 1 hour = 60 minutes, 
1 minute = 60 seconds. Birth year input should be from 1950 to 2050 only while year today input should be from 1950 to 2050 only, and year today must always be larger than birthyear. 
Use either POST or GET method and checkboxes for the age in years, months, days, hours, minutes, and seconds.-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/modern-normalize.css">
    <link rel="stylesheet" href="css/p7.css">
    <title>Activity #4</title>
</head>
<body>
    <h1>
        <?php echo "Activity 4"; ?>
    </h1>

    <form action="" method="GET">

        Name: <input type="text" name="txtInputName">
        Birth Year: <input type="text" name="txtInputBirthYear">
        Year Today: <input type="text" name="txtInputYearToday"><br>
        <input type="checkbox" name="chkAgeInYears">Age In Years<br>
        <input type="checkbox" name="chkAgeInMonths">Age In Months<br>
        <input type="checkbox" name="chkAgeInDays">Age In Days<br>
        <input type="checkbox" name="chkAgeInHrs">Age In Hours<br>
        <input type="checkbox" name="chkAgeInMins">Age In Minutes<br>
        <input type="checkbox" name="chkAgeInSecs">Age In Seconds<br>
        <br><br><input type="submit" name="btnCompute" value="Submit">


    </form>

</body>
</html>

<?php 
//validations
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
    }else if($_GET['txtInputBirthYear'] < $_GET['txtInputBirthYear']){
        echo "<br><font color ='red'>Year Today should be greater than Birth Year</font>";
       $errorBirthYear++;
    }else {
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
    }else if($_GET['txtInputBirthYear'] < $_GET['txtInputBirthYear']){
        echo "<br><font color ='red'>Year Today should be greater than Birth Year</font>";
       $errorYearToday++;
    }
    else{
        $errorYearToday = 0;
    }

    return $errorYearToday;
}

if(isset($_GET["btnCompute"])){
    $error = validateBirthYear() + validateYearToday();
    $name = $_GET["txtInputName"];
    $birthYear = $_GET["txtInputBirthYear"];
    $yearToday = $_GET["txtInputYearToday"];
    $msg = "";
    if($error == 0){
        $msg .="<br>Name: " . $name . "<br>Birth Year: ". $birthYear . "<br>Year Today: " . $yearToday;    
        $age = $yearToday - $birthYear;
        $ageInMonths = $age * 12;
        $ageInDays = $age * 365;
        $ageInHours = $ageInDays * 24;
        $ageInMinutes = $ageInHours * 60;
        $ageInSeconds = $ageInMinutes * 60;
        
        if(isset($_GET["chkAgeInYears"])){
            $msg .= "<br>Age in Years: " .$age;
        }
        if(isset($_GET["chkAgeInMonths"])){
            $msg .= "<br>Age in Months: " .$ageInMonths ." months";
        }
        if(isset($_GET["chkAgeInDays"])){
            $msg .= "<br>Age in Days: " .$ageInDays ." days";
        }
        if(isset($_GET["chkAgeInHours"])){
            $msg .= "<br>Age in Hours: " .$ageInHours ." hrs";
        }
        if(isset($_GET["chkAgeInMins"])){
            $msg .= "<br>Age in Minutes: " .$ageInMinutes ." mins";
        }
        if(isset($_GET["chkAgeInSecs"])){
            $msg .= "<br>Age in Seconds: " .$ageInSeconds ." secs";
        }

    }
    echo $msg;

}

?>