<?php
include_once '../include/connect.php';

if(isset($_POST['teacher_name'])){
    $teacher_name = $_POST['teacher_name'];
    $input_parts = explode(' ', $teacher_name);
    $first_name = $input_parts[0];
    $last_name = $input_parts[count($input_parts) - 1];

    $sql = 'SELECT * FROM teacher';
    if(!empty($teacher_name)){
        $input_param = mysqli_real_escape_string($connection, $teacher_name);
        $sql.= " WHERE first_name LIKE '%$input_param%' OR last_name LIKE '%$input_param%' OR (first_name LIKE '%$first_name%' AND last_name LIKE '%$last_name%')";
    }
    if ($stmt = mysqli_prepare($connection, $sql)){
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $data = []; 

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $data[] = array(
                    'id' => $row['teacher_id'],
                    'full_name' => $row['first_name'] . ' ' . $row['last_name']
                );            
            }
        } 
        else {
            $data[] = array(
                'id' => ' ',
                'full_name' => 'no result found'
            );         
        }
        mysqli_stmt_close($stmt);

        echo json_encode($data);
        
    } 
}

//-------------------------------------------------------------------------------
if (isset($_POST['assistant_name'])) {
    $assistant_name = $_POST['assistant_name'];
    $input_parts = explode(' ', $assistant_name);
    $first_name = $input_parts[0];
    $last_name = $input_parts[count($input_parts) - 1];

    $sql = 'SELECT * FROM assistant';
    if (!empty($assistant_name)) {
        $input_param = mysqli_real_escape_string($connection, $assistant_name);
        $sql.= " WHERE first_name LIKE '%$input_param%' OR last_name LIKE '%$input_param%' OR (first_name LIKE '%$first_name%' AND last_name LIKE '%$last_name%')";
    }

    if ($stmt = mysqli_prepare($connection, $sql)) {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $data = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = array(
                    'id' => $row['assistant_id'],
                    'full_name' => $row['first_name'] . ' ' . $row['last_name']
                );
            }
        } else {
            $data[] = array(
                'id' => ' ',
                'full_name' => 'no result found'
            );        
        }

        mysqli_stmt_close($stmt);

        echo json_encode($data);
    }
}


if(isset($_POST['student_name'])){
    $student_name = $_POST['student_name'];
    $input_parts = explode(' ', $student_name);
    $first_name = $input_parts[0];
    $last_name = $input_parts[count($input_parts) - 1];

    $sql = 'SELECT student_id, first_name, last_name FROM student';
    if(!empty($student_name)){
        $input_param = mysqli_real_escape_string($connection, $student_name);
        $sql.= " WHERE first_name LIKE '%$input_param%' OR last_name LIKE '%$input_param%' OR (first_name LIKE '%$first_name%' AND last_name LIKE '%$last_name%')";
    }
    if ($stmt = mysqli_prepare($connection, $sql)){
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $data = []; 

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $data[] = array(
                    'id' => $row['student_id'],
                    'full_name' => $row['first_name'] . ' ' . $row['last_name']
                );            
            }
        } 
        else {
            $data[] = array(
                'id' => ' ',
                'full_name' => 'no result found'
            );        
        }
        mysqli_stmt_close($stmt);

        echo json_encode($data);
    } 
}
?>
