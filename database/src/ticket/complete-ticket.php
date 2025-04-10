<?php
require_once '../core/config.php';
include '../core/session-checker.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnsubmit'])) {
    $ticketnumber = $_POST['ticketnumber'];
    $dateCompleted = date("Y-m-d H:i:s");

    // Update ticket status and dateCompleted
    $sql = "UPDATE tbltickets SET status = 'FOR APPROVAL', dateCompleted = ?, assignedto = ? WHERE ticketnumber = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sss", $dateCompleted, $_SESSION['username'], $ticketnumber);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: ticket-management.php?updatemsg=Ticket marked as completed.");
            exit();
        } else {
            echo "Error updating ticket: " . mysqli_error($link);
        }
    } else {
        echo "Error preparing query: " . mysqli_error($link);
    }
}
?>