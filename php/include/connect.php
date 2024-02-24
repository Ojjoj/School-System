<?php

$db_name = "localhost";
$user_name = "root";
$user_password = "";

$connection = mysqli_connect($db_name, $user_name, $user_password);
mysqli_select_db($connection, "school_system");
