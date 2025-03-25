<?php 
//define database connection
define('DB_SERVER','127.0.0.1');
define('DB_USERNAME', 'leweeaaron');
define('DB_PASSWORD', 'ombac');
define('DB_NAME', 'ITC127-IT2A-2025');

//ATTEMPT TO CONNECT

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($link === false){
    die("ERROR: CANNOT CONNECT ". mysqli_connect_error());
}
//set timezome
date_default_timezone_set('Asia/Manila');



?>