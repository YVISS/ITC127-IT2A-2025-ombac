<?php 
session_start();
//check if session is recorded
if(!isset($_SESSION['username'])){
    header("location: login.php");
}
?>