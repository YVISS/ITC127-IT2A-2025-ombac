<?php 
//session starts
session_start();
///destroy or unset the session
unset($_SESSION["username"]);
unset($_SESSION["usertype"]);
//redirect landing page
header("location: login.php");
?>