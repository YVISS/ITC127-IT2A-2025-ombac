<?php 
if(isset($_POST['btnlogin'])){
    //require the config file
    require_once('config.php');
    //build template
    $sql = "SELECT * FROM tblaccounts WHERE username = ? AND password = ? AND status ='ACTIVE";
    //check if the sql statement is correct by preparing it to the database link
    if($stmt = mysqli_prepare($link, $sql)){
        //bind the data from the login form to the sql statement
        mysqli_stmt_bind_param($stmt, "ss",$_POST['txtusername'], $_POST['txtpassword']);
        //execute the statement
        if(mysqli_stmt_execute(($stmt))){
            //get the result of the executin
            $result = mysqli_stmt_get_result($stmt);
            //check if there are rows
            if(mysqli_num_rows($result) > 0){

                $account = mysqli_fetch_array($result, MYSQLI_ASSOC);
                //create a session
                session_start();
                //record session
                $_SESSION['username'] = $account['username'];
                $_SESSION['usertype'] = $account['usertype'];
                //redirect to accounts page
                header("location: accounts-management.php");
            }
            else{
                echo "Incorrect login details or account is inactive";
            }
        }
    
    }else{
        echo "<font color='red'> Error on login statement.</font>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\modern-normalize.css">
    <link rel="stylesheet" href="css\login.css">
    <title>Login Page - AU TECHNICAL SUPPORT MANAGEMENT SYSTEM</title>
</head>
<body>
    <div class="wrapper">
        <header>
            <h1>AU Techincal Support Management System</h1>
        </header>
        <div class="main-content">
            <div class="card">
            <h1 class="card__title">Log In</h1>
                <div class="form">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);   ?>" method="POST">
                        <div class="form__field">
                                <p class="field__title">Username:</p>
                                <input type="text" name="txtusername" placeholder="example...">
                                <p class="field__title">Password:</p>
                                <input type="password" name="txtpassword" placeholder="example123..." required>           
                                <input type="submit" name="btnlogin" value="Login">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <footer>
            <p>&copy; <span id="year"></span> AU Techincal Support Management System. All Rights Reserved.</p>
            <script>
                document.getElementById("year").textContent = new Date().getFullYear();
            </script>
        </footer>
    </div>
    
</body>
</html>