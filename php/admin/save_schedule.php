<?php
include_once '../include/connect.php'; 

if($_SERVER['REQUEST_METHOD'] !='POST'){
    echo "<script> alert('Error: No data to save.');</script>";
    $connection->close();
    exit;
}

extract($_POST);

if(empty($id)){
    $sql = "INSERT INTO `event` (`title`,`description`,`start_datetime`,`end_datetime`) VALUES ('$title','$description','$start_datetime','$end_datetime')";
}else{
    $sql = "UPDATE `event` set `title` = '{$title}', `description` = '{$description}', `start_datetime` = '{$start_datetime}', `end_datetime` = '{$end_datetime}' where `event_id` = '{$id}'";
}
$save = $connection->query($sql);
if($save){
    header("location:event.php");
    exit();
}else{
    echo "<pre>";
    echo "An Error occured.<br>";
    echo "Error: ".$connection->error."<br>";
    echo "SQL: ".$sql."<br>";
    echo "</pre>";
}
$connection->close();
?>