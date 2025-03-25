<?php

require_once '../core/config.php';
include '../core/session-checker.php';

$updatemsg = '';
$errormsg = '';

if (isset($_POST['btnsubmit'])) {
    $sql = "DELETE FROM tbltickets WHERE ticketnumber = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $_POST['txtticketnumber']);
        if (mysqli_stmt_execute($stmt)) {
            $sql = "INSERT INTO tbllogs (datelog, timelog, action, module, performedby, performedto) VALUES (?,?,?,?,?,?)";
            if ($stmt = mysqli_prepare($link, $sql)) {
                $date = date("d/m/Y");
                $time = date("h:i:sa");
                $action = "Delete";
                $module = "Ticket Management";
                mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $_SESSION['username'], $_POST['txtticketnumber']);
                if (mysqli_stmt_execute($stmt)) {
                    $updatemsg = "Ticket Deleted";
                    header("location: ticket-management.php?updatemsg=" . urlencode($updatemsg));
                    exit();
                }
            }
        }
    }
}
?>