<?php
include_once '../include/connect.php'; 
if(!isset($_GET['id'])){
    echo "<script> alert('Undefined Schedule ID.'); location.replace('./') </script>";
    $connection->close();
    exit;
}

$delete = $connection->query("DELETE FROM `event` where event_id = '{$_GET['id']}'");
if($delete){
    echo "<script> alert('Event has deleted successfully.'); location.replace('./') </script>";
}else{
    echo "<pre>";
    echo "An Error occured.<br>";
    echo "Error: ".$connection->error."<br>";
    echo "SQL: ".$sql."<br>";
    echo "</pre>";
}
$connection->close();

?>