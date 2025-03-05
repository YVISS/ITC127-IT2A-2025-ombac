<?php
require_once "config.php";
include ("session-checker.php");
$msg = "";
if(isset($_POST['btnsubmit'])) {
    
    $sql = "DELETE FROM tblaccounts WHERE username = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", trim($_POST['txtusername']));
        if (mysqli_stmt_execute($stmt)) {
            $sql = "INSERT INTO tbllogs (datelog, timelog, action, module, performedto, performedby) VALUES (?, ?, ?, ?, ?, ?)";
            
            if ($stmt = mysqli_prepare($link, $sql)) {
                $date = date("d/m/Y");
                $time = date("h:i:sa");
                $action = "Delete";
                $module = "Accounts Management";
                
                mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $_POST['txtusername'], $_SESSION['username']);

                if (mysqli_stmt_execute($stmt)) {
                    $msg.= "User account is deleted.";
                    header("Location: accounts-management.php");
                    exit();
                } else {
                    $msg.= "<font color='red'>ERROR on inserting delete log.</font>";
                }
            }
        } else {
            $msg.= "<font color='red'>ERROR on delete statement.</font>";
        }
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
        
        <input type="hidden" name="txtusername" value="<?php echo trim($_GET['username']); ?>">
        <p>Are you sure you want to delete this account?</p>
        <input type="submit" value="Yes" name="btnsubmit">
        <a href="accounts-management.php">No</a>
    </form>
</body>
</html>