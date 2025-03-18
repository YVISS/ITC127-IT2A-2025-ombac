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
                header("location: equipment-management.php");
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
                                    <div id="togglePassIcon">  
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EEEEE"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>
                                    </div>
                                </span>
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
            let eye = document.getElementById('togglePassIcon').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EEEEE"><path d="m644-428-58-58q9-47-27-88t-93-32l-58-58q17-8 34.5-12t37.5-4q75 0 127.5 52.5T660-500q0 20-4 37.5T644-428Zm128 126-58-56q38-29 67.5-63.5T832-500q-50-101-143.5-160.5T480-720q-29 0-57 4t-55 12l-62-62q41-17 84-25.5t90-8.5q151 0 269 83.5T920-500q-23 59-60.5 109.5T772-302Zm20 246L624-222q-35 11-70.5 16.5T480-200q-151 0-269-83.5T40-500q21-53 53-98.5t73-81.5L56-792l56-56 736 736-56 56ZM222-624q-29 26-53 57t-41 67q50 101 143.5 160.5T480-280q20 0 39-2.5t39-5.5l-36-38q-11 3-21 4.5t-21 1.5q-75 0-127.5-52.5T300-500q0-11 1.5-21t4.5-21l-84-82Zm319 93Zm-151 75Z"/></svg>';
        } else {
            passwordInput.type = "password";
            let eye = document.getElementById('togglePassIcon').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EEEEE"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>';
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