<?php

require_once '../core/config.php';
include '../core/session-checker.php';
include "../core/errors.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


$updatemsg = '';
$errormsg = '';
if (isset($_POST['btnsubmit'])) {
    $sql = "UPDATE tblaccounts SET password =?, usertype =?, status = ? WHERE username=?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssss", $_POST['txtpassword'], $_POST['cmbtype'], $_POST['rbstatus'], $_GET['username']);
        if (mysqli_stmt_execute($stmt)) {
            $sql = "INSERT INTO tbllogs (datelog, timelog, action, module, performedby, performedto) VALUES (?,?,?,?,?,?)";
            if ($stmt = mysqli_prepare($link, $sql)) {
                $date = date('d/m/Y');
                $time = date("h:i:sa");
                $action = "Update";
                $module = "Accounts Management";
                mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $_SESSION['username'], $_GET['username']);
                if (mysqli_stmt_execute($stmt)) {
                    $updatemsg = "User Account Updated";
                    header("location: accounts-management.php?updatemsg=" . urlencode($updatemsg));
                    exit();
                }
            } else {
                $errormsg = "ERROR: Inserting logs";
                header("location: accounts-management.php?errormsg=" . urlencode($errormsg));
                exit();
            }
        }
    } else {
        $errormsg = "<font color = 'red'>ERROR: Updating Account</font>";
        header("location: accounts-management.php?errormsg=" . urlencode($errormsg));
        exit();
    }
} else { //load current data
    if (isset($_GET['username']) && !empty(trim($_GET['username']))) {
        $sql = "SELECT * FROM tblaccounts WHERE username = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $_GET['username']);
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                $account = mysqli_fetch_array($result, MYSQLI_ASSOC);
            }
        } else {
            echo "<font color = 'red'>ERROR: Loading Account</font>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/general/modern-normalize.css">
    <link rel="stylesheet" href="../../css/general/session.css">
    <link rel="stylesheet" href="../../css/general/wrapper.css">
    <link rel="stylesheet" href="../../css/accounts/update-account.css">
    <title>Accounts Management Page - AU TECHNICAL SUPPORT MANAGEMENT SYSTEM</title>
</head>

<body>
    <div class="wrapper">
        <div class="wrapper-container">
            <header class="wrapper_header">
                <div class="page-title">
                    <img src="../../src/images/au_logo.png" alt="Arellano University Logo">

                    <h1>AU Technical Support Management System</h1>
                </div>
            </header>
            <div class="main-content">
                <div class="card">
                    <div class="page-title">
                        <h1>Update Account</h1><br>
                        <p style="text-align: center;">Change the value on this form and submit to update the account</p>
                    </div>

                    <div class="form">
                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST">
                            <div class="form__username">
                                <h2>Username</h2>
                                <input type="text" name="txtusername" id="username" value="<?php echo $account['username']; ?>" readonly>
                            </div>

                            
                            <div class="form__password">
                                <h2>Password</h2>
                                <input type="password" name="txtpassword" id="password" placeholder="Password" value="<?php echo $account['password']; ?>" required>
                                <span class="toggle-password" onclick="togglePassword()">
                                    <div id="togglePassIcon">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EEEEE">
                                            <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z" />
                                        </svg>
                                    </div>
                                    Show Password
                                </span>
                            </div>
                            <div class="form__type">
                                <h2>User Types</h2>
                                <div class="changeType">
                                    <select name="cmbtype" id="cmbtype" required>
                                        <option value="">Current: <?php echo $account['usertype']; ?></option>
                                        <option value="ADMINISTRATOR">Administrator</option>
                                        <option value="TECHNICAL">Technical</option>
                                        <option value="STAFF">Staff</option>
                                    </select>
                                </div>
                                <div class="form__status">
                                    <h2>Status</h2>
                                    <?php
                                    $status = $account['status'];
                                    if ($status == 'ACTIVE') {
                                    ?><input type="radio" name="rbstatus" value="ACTIVE" checked><p>Active</p><br>
                                        <input type="radio" name="rbstatus" value="INACTIVE"><p>Inactive</p><br> <?php
                                                                                                        } else {
                                                                                                            ?><input type="radio" name="rbstatus" value="ACTIVE">Active<br>
                                        <input type="radio" name="rbstatus" value="INACTIVE" checked>Inactive<br> <?php
                                                                                                                }
                                                                                                                    ?>
                                </div>
                            </div>
                            <div class="form__btns">
                                <button type="submit" name="btnsubmit" value="">Update Account</button>
                                <a href="accounts-management.php">Cancel</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <footer>
                <p>&copy; Copyright <span id="year"> </span> AU Technical Support Management System. All Rights Reserved.
                </p>
            </footer>
        </div>

    </div>
</body>
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

</html>