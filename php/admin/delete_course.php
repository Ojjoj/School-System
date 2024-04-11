<?php
include_once '../include/connect.php';

if(isset($_POST['delete_course'])){
    $delete_course = $_POST['delete_course'];

    $sql = "DELETE FROM course WHERE course_id = ?";

    if ($stmt = mysqli_prepare($connection, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $delete_course);
        mysqli_stmt_execute($stmt);
        echo json_encode("course".$delete_course);
    } 
    else{
        echo json_encode("error");
    }
    mysqli_stmt_close($stmt);
}