<?php
include_once '../include/connect.php';

$file_path;

if(isset($_FILES['image'])){
  $file = $_FILES['image'];

  $file_name      = $_FILES['image']['name'];
  $file_temp_name = $_FILES['image']['tmp_name'];
  $file_size      = $_FILES['image']['size'];
  $file_error     = $_FILES['image']['error'];
  $file_type      = $_FILES['image']['type'];

  $file_extension = explode('.', $file_name);
  $file_actual_extension = strtolower(end($file_extension));

  $extensions = array('jpg','jpeg', 'png');

  if(in_array($file_actual_extension, $extensions)){
      if($file_error === 0){
          if($file_size < 1000000){
              $file_new_name = uniqid('',true).'.'. $file_actual_extension;
              $file_destination = '../../media/course_image/'. $file_new_name;
              $file_path = $file_destination;
              move_uploaded_file($file_temp_name, $file_destination);
              print_r($file_path);
          }
          else{
              print_r("The image is too big");
          }
      }
      else{
          print_r("there was an error uploading the image");
      }
  }
  else{
      print_r("you can't upload files of this type");
  }
}



if(!empty($_POST['course_name']) && !empty($_POST['start_date']) && !empty($_POST['end_date'])){
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $teacher_id = !empty($_POST['teacher_id']) ? $_POST['teacher_id'] : NULL;
    $image_path = !empty($_POST['image_path']) ? $_POST['image_path'] : '../../'.$_POST['image_source'];

    $sql = "UPDATE course SET course_name = ?, teacher_id = ?, image_path = ? , `start_date` = ?, end_date = ?
            WHERE course_id = ?";
    $stmt = mysqli_stmt_init($connection);
      if(mysqli_stmt_prepare($stmt,$sql)){
        mysqli_stmt_bind_param($stmt,"sisssi",$course_name, $teacher_id, $image_path, $start_date, $end_date, $course_id);
        mysqli_stmt_execute($stmt);
      }
      mysqli_stmt_close($stmt);   
      print_r("true");
}   

if(isset($_POST['assistants'])){
    $course_id = $_POST['course_id'];
    $assistants = json_decode($_POST['assistants'], true);

    $sql = "DELETE from course_assistants WHERE course_id = ?";
    $stmt = mysqli_stmt_init($connection);
      if(mysqli_stmt_prepare($stmt,$sql)){
        mysqli_stmt_bind_param($stmt,"i",$course_id);
        mysqli_stmt_execute($stmt);
      }
      mysqli_stmt_close($stmt);

    if (is_array($assistants)) {
        foreach ($assistants as $assistant) {
            $assistant_id = $assistant[0]; 
            $sql = "INSERT INTO course_assistants (course_id, assistant_id) VALUES (?, ?)";
            $stmt = mysqli_stmt_init($connection);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "ii", $course_id, $assistant_id);
                mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);
        }
        echo "Assistants saved successfully";
    } 
    else {
        echo "Invalid data format";
    }
} 


if(isset($_POST['students'])){
    $course_id = $_POST['course_id'];
    $students = json_decode($_POST['students'], true);

    $sql = "DELETE from course_students WHERE course_id = ?";
        $stmt = mysqli_stmt_init($connection);
        if(mysqli_stmt_prepare($stmt,$sql)){
            mysqli_stmt_bind_param($stmt,"i",$course_id);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);

    if (is_array($students)) {
        foreach ($students as $student) {
            $student_id = $student[0]; 
            $sql = "INSERT INTO course_students (course_id, student_id) VALUES (?, ?)";
            $stmt = mysqli_stmt_init($connection);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "ii", $course_id, $student_id);
                mysqli_stmt_execute($stmt);
            }
            mysqli_stmt_close($stmt);
        }
        echo "students saved successfully";
    } 
    else {
        echo "Invalid data format";
    }
} 
