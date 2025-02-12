<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Accounts Management Page - AU TECHNICAL SUPPORT MANAGEMENT SYSTEM</title>
</head>
<body>
    <?php 
        session_start();
        //check if session is recorded
        if($_SESSION['username']){
            echo "<h1>Welcome, " .$_SESSION['username'] . "</h1>";
            echo "<h1> Account type: " . $_SESSION['usertype'] . "</h1>";
        }else{
            header("location: login.php");
        }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
        <a href="create-account.php">Create new Account</a>
        <a href="logout.php">Logout</a>
        <br>Search: <input type="text" name="txtsearch">
        <input type="submit" value="Search" name="btnsearch">
    </form>
</body>
</html>