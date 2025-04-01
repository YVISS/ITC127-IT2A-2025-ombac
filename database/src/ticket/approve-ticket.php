<?php
// filepath: /Applications/XAMPP/xamppfiles/htdocs/ITC127-IT2A-2025-ombac/database/src/ticket/approve-ticket.php

require_once '../core/config.php';
include '../core/session-checker.php';

// Ensure the user is an administrator
if ($_SESSION['usertype'] !== 'ADMINISTRATOR') {
    header("Location: ../../core/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ticketnumber'])) {
    $ticketnumber = $_POST['ticketnumber'];
    $dateApproved = date("Y-m-d H:i:s");
    $approvedBy = $_SESSION['username'];

    // Update the ticket status to CLOSED and set dateApproved and approvedBy
    $sql = "UPDATE tbltickets SET status = 'CLOSED', dateApproved = ?, approvedBy = ? WHERE ticketnumber = ? AND status = 'FOR APPROVAL'";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sss", $dateApproved, $approvedBy, $ticketnumber);
        if (mysqli_stmt_execute($stmt)) {
            // Log the approval action
            $logSql = "INSERT INTO tbllogs (datelog, timelog, action, module, performedby, performedto) VALUES (?, ?, ?, ?, ?, ?)";
            if ($logStmt = mysqli_prepare($link, $logSql)) {
                $datelog = date("Y-m-d");
                $timelog = date("H:i:s");
                $action = "Approved";
                $module = "Approve Ticket";
                mysqli_stmt_bind_param($logStmt, "ssssss", $datelog, $timelog, $action, $module, $approvedBy, $ticketnumber);
                mysqli_stmt_execute($logStmt);
            }

            // Redirect back to ticket management with a success message
            $updatemsg = "Ticket #$ticketnumber has been approved successfully.";
            header("Location: ticket-management.php?updatemsg=" . urlencode($updatemsg));
            exit();
        } else {
            // Redirect back with an error message if the update fails
            $errormsg = "Error updating ticket: " . mysqli_error($link);
            header("Location: ticket-management.php?errormsg=" . urlencode($errormsg));
            exit();
        }
    } else {
        // Redirect back with an error message if the query preparation fails
        $errormsg = "Error preparing query: " . mysqli_error($link);
        header("Location: ticket-management.php?errormsg=" . urlencode($errormsg));
        exit();
    }
} else {
    // Redirect back if the request is invalid
    header("Location: ticket-management.php");
    exit();
}
?>