<?php
include 'connect.php';

session_start();
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
}
else{
    header("location:login.php");
    exit();
}