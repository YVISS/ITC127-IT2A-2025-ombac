<?php


require_once 'config.php';
include "session-checker.php";
include "errors.php";
if (isset($_POST['btnsubmit'])) {
    $sql = "DELETE FROM tblaccounts WHERE username =?";
    if($stmt = mysqli_prepare($link, $sql)){

        mysqli_stmt_bind_param($stmt, "s", $_POST['txtusername']);
        if(mysqli_stmt_execute($stmt)){
            $sql = "INSERT INTO tbllogs (datelog, timelog, action, module, performedby, performedto) VALUES (?,?,?,?,?,?)";
            if($stmt = mysqli_prepare($link, $sql)){
                $date = date("d/m/Y");
                $time = date("h:i:sa");
                $action = "Delete";
                $module = "Accounts Management";
                mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $_SESSION['username'],$_POST['txtusername']);
                if(mysqli_stmt_execute($stmt)){
                    echo "User Account Deleted";
                    header("location: accounts-management.php");
                    exit();
                }
            }
            else{
                echo "<font color = 'red'>ERROR: Inserting on Logs</font>";
            }
        }
    }
    else{
        echo "<font color = 'red'>ERROR: Deleting Account</font>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account Page - AU Technical Support Management System</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
        <input type="hidden" name="txtusername" value="<?php echo trim($_GET['username']); ?>"/>
        <p>Are you sure you want to delete this account?</p>
        <input type="submit" value="Yes" name="btnsubmit">
        <a href="accounts-management.php">No</a>
    </form>
</body>
</html>