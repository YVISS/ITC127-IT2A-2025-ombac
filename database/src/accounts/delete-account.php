<?php

require_once '../core/config.php';
include '../core/session-checker.php';
include "../core/errors.php";

$updatemsg = '';
$errormsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnsubmit'])) {
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
