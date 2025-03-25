<?php

require_once '../core/config.php';
include '../core/session-checker.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btncreate'])) {
    // Check existing user
    $sql = "SELECT * FROM tblaccounts WHERE username = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        $param_username = $_POST['txtusername'];
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 0) {
                $sql = "INSERT INTO tblaccounts (username, password, usertype, status, createdby, datecreated) VALUES (?, ?, ?, ?, ?, ?)";
                if ($stmt = mysqli_prepare($link, $sql)) {
                    $username = $_POST['txtusername'];
                    $password = $_POST['txtpassword'];
                    $usertype = $_POST['cmbtype'];
                    $createdby = $_SESSION['username'];
                    $status = "ACTIVE";
                    $datecreated = date("d/m/Y");

                    mysqli_stmt_bind_param($stmt, "ssssss", $username, $password, $usertype, $status, $createdby, $datecreated);
                    if (mysqli_stmt_execute($stmt)) {
                        $msg = "Account created successfully";
                        header("Location: accounts-management.php?updatemsg=" . urlencode($msg));
                        exit();
                    } else {
                        $msg = "Error creating account";
                    }
                }
            } else {
                $msg = "Username already exists";
            }
        }
    } else {
        $msg = "Error on Create accounts statement: " . mysqli_connect_error();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/general/modern-normalize.css">
    <link rel="stylesheet" href="../../css/accounts/create-account.css">
    <title>Create Account - AU TECHNICAL SUPPORT MANAGEMENT SYSTEM</title>
</head>
<body>
    <div class="wrapper">
        <header>
            <h1>AU TSMS</h1>
            <div class="session section">
                <?php
                if ($_SESSION['username']) {
                    echo $_SESSION['username'] . " | ";
                    echo $_SESSION['usertype'];
                } else {
                    header("location: login.php");
                }
                ?>
            </div>
        </header>
        <div class="main-content">
            <div class="page-title">
                <h1>Create Account</h1><br>
                <p style="text-align: center;">Fill in the details to create a new account</p>
            </div>
            <div id="php_error" class="error">
                <?php
                if (!empty($msg)) {
                    echo "<div class='msg' style='color: red;'>$msg</div>";
                }
                ?>
            </div>
            <div class="form section">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <h2>Username</h2>
                    <input type="text" name="txtusername" placeholder="Username" required><br>
                    <div style="position: relative;">
                        
                        <h2>Password</h2>
                        <input type="password" name="txtpassword" id="password" placeholder="Password" required>
                        <span class="toggle-password" onclick="togglePassword()">
                            <div id="togglePassIcon">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EEEEE"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/>
                            </svg>
                            </div>
                        </span>
                    </div>
                    <select name="cmbtype" id="cmbtype" required>
                        <option value="">--Select Account Type--</option>
                        <option value="ADMINISTRATOR">Administrator</option>
                        <option value="TECHNICAL">Technical</option>
                        <option value="USER">User</option>
                    </select><br>
                    <button name="btncreate" type="submit">Create Account</button>
                    <a href="accounts-management.php">Cancel</a>
                </form>
            </div>
        </div>
        <footer>
            <p>&copy; <span id="year"></span> AU Technical Support Management System. All Rights Reserved.</p>
        </footer>
    </div>
    <script>
        document.getElementById("year").textContent = new Date().getFullYear();

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
    </script>
</body>
</html>