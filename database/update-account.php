<?php
require_once "config.php";
include "session-checker.php";
include "errors.php";

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
                $errormsg = "<font color ='red'>ERROR: Inserting logs</font>";
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
    <title>Update Account Page - AU Technical Support Management System</title>
</head>

<body>
    <p>Change the value on this form and submit to update the account</p>
    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST">
        Username: <?php echo $account['username']; ?><br>
        Password: <input id="password" type="password" name="txtpassword" value="<?php echo $account['password']; ?>" required><br>
        <span class="toggle-password" onclick="togglePassword()">
            <div id="togglePassIcon">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EEEEE">
                    <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z" />
                </svg>
            </div>

        </span>
        Current Usertype: <?php echo $account['usertype']; ?><br>
        Change Usertype To: <select name="cmbtype" id="cmbtype" required>
            <option value="">--Select Account Type--</option>
            <option value="ADMINISRTATOR">Administrator</option>
            <option value="TECHNICAL">Technical</option>
            <option value="STAFF">Staff</option>
        </select><br>
        Status: <br>
        <?php
        $status = $account['status'];
        if ($status == 'ACTIVE') {
        ?><input type="radio" name="rbstatus" value="ACTIVE" checked>Active<br>
            <input type="radio" name="rbstatus" value="INACTIVE">Inactive<br> <?php
                                                                            } else {
                                                                                ?><input type="radio" name="rbstatus" value="ACTIVE">Active<br>
            <input type="radio" name="rbstatus" value="INACTIVE" checked>Inactive<br> <?php
                                                                                    }
                                                                                        ?>
        <input type="submit" name="btnsubmit" value="Submit">
        <a href="accounts-management.php">Cancel</a>

    </form>
</body>

<script>
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