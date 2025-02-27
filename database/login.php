<?php
$msg = "";
if (isset($_POST['btnlogin'])) {

    //require the config file
    require_once('config.php');
    //build template
    $sql = "SELECT * FROM tblaccounts WHERE username = ? AND password = ? AND status ='ACTIVE'";
    //check if the sql statement is correct by preparing it to the database link
    if ($stmt = mysqli_prepare($link, $sql)) {
        //bind the data from the login form to the sql statement
        mysqli_stmt_bind_param($stmt, "ss", $_POST['txtusername'], $_POST['txtpassword']);
        //execute the statement
        if (mysqli_stmt_execute(($stmt))) {
            //get the result of the executin
            $result = mysqli_stmt_get_result($stmt);
            //check if there are rows
            if (mysqli_num_rows($result) > 0) {

                $account = mysqli_fetch_array($result, MYSQLI_ASSOC);
                //create a session
                session_start();
                //record session
                $_SESSION['username'] = $account['username'];
                $_SESSION['usertype'] = $account['usertype'];
                //redirect to accounts page
                header("location: accounts-management.php");
            } else {
                $msg .= "Incorrect login details or account is inactive";
            }
        }
    } else {
        $msg .= "<font color='red'> Error on login statement.</font>" . mysqli_connect_error();
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
                <h1 class="card__title">Log In</h1><br>
                <div name="php_error" id="php_error">
                    <p name="error"><?php echo $msg; ?></p>
                </div>
                <div class="form">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);   ?>" method="POST">
                        <div class="form__field">
                            <p class="field__title">Username:</p>
                            <input type="text" name="txtusername" placeholder="example...">
                            <p class="field__title">Password:</p>
                            <div class="password-container">
                                <input type="password" id="password" name="txtpassword" placeholder="example123..." required>
                                <span class="toggle-password" onclick="togglePassword()">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg></span>
                            </div>
                            <input type="submit" value="Login" name="btnlogin">
                        </div>
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
<script>
    let errormsg = document.getElementById("php_error");
    errormsg.style.color = "red";
    errormsg.style.fontWeight = 400;

    //show password
    function togglePassword() {
        let passwordInput = document.getElementById("password");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }

    //errormessage fade
    setTimeout(() => {
        if (errormsg) {
            errormsg.style.transition = "opacity 1s";
            errormsg.style.opacity = "0";
            setTimeout(() => errormsg.style.display = "none", 1000);
        }
    }, 3000);
</script>

</html>