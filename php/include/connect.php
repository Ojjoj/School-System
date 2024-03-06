<?php

$db_name = "localhost";
$user_name = "root";
$user_password = "";

$connection = mysqli_connect($db_name, $user_name, $user_password, "school_system");
if(!$connection){
    die('Connection Failed'.mysqli_connect_error());
}
