<!--2. Create a program that will accept inputs for your name, your birthyear and the year today and will compute for your age,
age in months, days, hours, minutes, and seconds. Use either POST or GET method.-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prorgam 6</title>
    <link rel="stylesheet" href="css/modern-normalize.css">
    <link rel="stylesheet" href="css/p6.css">
</head>
<body>
    <h1>Program 6</h1>
    <form action="" method="POST">

    Name: <input type="text" name="txtInputName">
    Birth Year: <input type="text" name="txtInputBirthYear">
    Year Today: <input type="text" name="txtInputYearToday">
    <br><br><input type="submit" name="btnCompute" value="Submit">

    <?php 
    if(isset($_POST["btnCompute"])){
        $name = $_POST["txtInputName"];
        $birthYear = $_POST["txtInputBirthYear"];
        $yearToday = $_POST["txtInputYearToday"];

        $age = $yearToday - $birthYear;
        $ageInMonths = $age * 12;
        $ageInDays = $age * 365;
        $ageInHours = $ageInDays * 24;
        $ageInMinutes = $ageInHours * 60;
        $ageInSeconds = $ageInMinutes * 60;

        echo "<br>Age: ". $age;
        echo "<br>Age in Months: ". $ageInMonths;
        echo "<br>Age in Days: ". $ageInDays;
        echo "<br>Age in Hours: ". $ageInHours;
        echo "<br>Age in Minutes: ". $ageInMinutes;
        echo "<br>Age in Seconds: ". $ageInSeconds;

    }


    ?>


    </form>
</body>
</html>