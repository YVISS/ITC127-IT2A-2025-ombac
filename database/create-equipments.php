<?php
require_once 'config.php';
include 'session-checker.php';

$msg = "";

if (isset($_POST['btncreate'])) {
    // Check existing user
    $sql = "SELECT * FROM tblaccounts WHERE username = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        $param_username = $_POST['txtusername'];
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 0) {
                $sql = "INSERT INTO tblaccounts (username, password, usertype, status, createdby, datecreated) VALUES (?, ?, ?, ?, ?, ?)";
                if ($stmt = mysqli_prepare($link, $sql)) {
                    $username = $_POST['txtusername'];
                    $password = $_POST['txtpassword'];
                    $usertype = $_POST['cmbtype'];
                    $createdby = $_SESSION['username'];
                    $status = "ACTIVE";
                    $datecreated = date("d/m/Y");

                    mysqli_stmt_bind_param($stmt, "ssssss", $username, $password, $usertype, $status, $createdby, $datecreated);
                    if (mysqli_stmt_execute($stmt)) {
                        $msg = "Account created successfully";
                    } else {
                        $msg = "Error creating account";
                    }
                }
            } else {
                $msg = "<font color='red'>Username already exists</font>";
            }
        }
    } else {
        $msg = "Error on Create accounts statement: " . mysqli_connect_error();
    }
}

echo $msg;
?>