<?php

require_once '../core/config.php';
include '../core/session-checker.php';
include "../core/errors.php";

$updatemsg = '';
$errormsg = '';
if (isset($_POST['btnsubmit'])) {
    $sql = "DELETE FROM tblaccounts WHERE username =?";
    if ($stmt = mysqli_prepare($link, $sql)) {

        mysqli_stmt_bind_param($stmt, "s", $_POST['txtusername']);
        if (mysqli_stmt_execute($stmt)) {
            $sql = "INSERT INTO tbllogs (datelog, timelog, action, module, performedby, performedto) VALUES (?,?,?,?,?,?)";
            if ($stmt = mysqli_prepare($link, $sql)) {
                $date = date("d/m/Y");
                $time = date("h:i:sa");
                $action = "Delete";
                $module = "Accounts Management";
                mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $_SESSION['username'], $_POST['txtusername']);
                if (mysqli_stmt_execute($stmt)) {
                    $updatemsg = "User Account Deleted";
                    header("location: accounts-management.php?updatemsg=" . urlencode($updatemsg));
                    exit();
                }
            } else {
                $errormsg = "ERROR: Inserting on Logs";
                header("location: accounts-management.php?errormsg=" . urlencode($errormsg));
                exit();
            }
        }
    } else {
        $errormsg = "ERROR: Deleting Account";
        header("location: accounts-management.php?errormsg=" . urlencode($errormsg));
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/modern-normalize.css">
    <link rel="stylesheet" href="css/delete-account.css">
    <title>Delete Account Page - AU Technical Support Management System</title>
</head>

<body>
    <div class="wrapper">
        <header>
            <h1>AU TSMS</h1>
            <div class="session section">
                <?php
                //check if session is recorded
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
                <h1>Delete Account</h1><br>
                <div class="form">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                        <input type="hidden" name="txtusername" value="<?php echo trim($_GET['username']); ?>" />
                        <p>Are you sure you want to delete this account?</p>
                        <div class="form__btns">
                            <input type="submit" value="Yes" name="btnsubmit">
                            <a href="accounts-management.php">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <footer>
            <p>&copy; <span id="year"></span> AU Technical Support Management System. All Rights Reserved.</p>
        </footer>
    </div>
    <script>
        document.getElementById("year").textContent = new Date().getFullYear();
    </script>
</body>

</html>