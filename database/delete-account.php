<?php
require_once 'config.php';
include 'session-checker.php';

if (isset($_GET['id'])) {
    $username = $_GET['id'];

    // Prepare a delete statement
    $sql = "DELETE FROM tblaccounts WHERE username = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $username);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Records deleted successfully. Redirect to landing page
            header("location: accounts-management.php?msg=Account deleted successfully");
            exit();
        } else {
            header("location: accounts-management.php?msg=Error deleting account: " . mysqli_error($link));
            exit();
        }
    }
} else {
    // Check if the ID parameter is missing
    header("location: accounts-management.php?msg=Missing account ID");
    exit();
}

// Close connection
mysqli_close($link);

?>