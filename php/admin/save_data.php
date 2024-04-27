<?php

include_once '../include/connect.php';

if(isset($_POST['course_name']) && isset($_POST['start_date']) && isset($_POST['end_date'])){
    $course_name = $_POST['course_name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    print_r($course_name);

}

// if(isset($_POST['assistants'])){
//     $assistant_id = $_POST['assistants'];
//     if(empty($assistant_id)){
//         print_r("hoo");
//     }

//     print_r($_POST['assistants']);

//     $sql = 'INSERT INTO `try` (razan) VALUES';
    
//     $values = [];
//     foreach($assistant_id as $id){
//         $sanitized_id = mysqli_real_escape_string($connection, $id);
//         $values[] = "('$sanitized_id')";
//     }
//     $sql .= implode(",", $values);
//     print_r($sql);
//     $result = mysqli_query($connection, $sql);
//     mysqli_close($connection);

// }