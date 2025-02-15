<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\modern-normalize.css">
    <link rel="stylesheet" href="css\accounts-management.css">
    <title>Accounts Management Page - AU TECHNICAL SUPPORT MANAGEMENT SYSTEM</title>
</head>
<body>
    <div class="wrapper">
        <header>
            <h1>AU Techincal Support Management System</h1>
        </header>
        <div class="main-content">
            <div class="session section">
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
            </div>
            <div class="form section">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
                    <div class="form__btns">
                        <button><a href="create-account.php">Create Account</a></button>
                        <button><a href="logout.php">Logout</a></button>
                    </div>
                    <br>Search: <input type="text" name="txtsearch">
                    <input type="submit" value="Search" name="btnsearch">
                </form>
            </div>
        </div>
        <footer><p>&copy; <span id="year"></span> AU Techincal Support Management System. All Rights Reserved.</p></footer>
    </div>
</body>
<script>
    document.getElementById("year").textContent = new Date().getFullYear();

</script>
</html>