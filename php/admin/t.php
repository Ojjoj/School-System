<?php 
if(isset($_POST['add'])){
    $file = $_FILES['image'];

    $file_name      = $_FILES['image']['name'];
    $file_temp_name = $_FILES['image']['tmp_name'];
    $file_size      = $_FILES['image']['size'];
    $file_error     = $_FILES['image']['error'];
    $file_type      = $_FILES['image']['type'];

    $file_extension = explode('.', $file_name);
    $file_actual_extension = strtolower(end($file_extension));

    $extenions = array('jpg','jpeg', 'png');

    if(in_array($file_actual_extension, $extenions)){
        if($file_error === 0){
            if($file_size < 1000000){
                $file_new_name = uniqid('',true).'.'. $file_actual_extension;
                $file_destination = '../../media/course_image/'. $file_new_name;
                move_uploaded_file($file_temp_name, $file_destination);
            }
            else{
                echo "The image is too big";
            }
        }
        else{
            echo "there was an error uploading the image";
        }

    }
    else{
        echo "you can't upload files of this type";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Course Page</title>
  <link rel="stylesheet" href="../../external/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../external/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../external/fontawesome/css/fontawesome.min.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Custom CSS to control image size */
    .course-image {
      width: 100%; /* Ensure image fills its container */
      height: auto; /* Maintain aspect ratio */
      object-fit: cover; /* Scale the image while maintaining its aspect ratio */
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <img src="../../media/course_image/flower1.jpg" class="card-img-top course-image" alt="Course 1 Image">
        <div class="card-body">
          <h5 class="card-title">Course 1</h5>
          <p class="card-text">Description of Course 1.</p>
          <a href="#" class="btn btn-primary">Enroll</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card">
        <img src="../../media/course_image/car.png" class="card-img-top course-image" alt="Course 2 Image">
        <div class="card-body">
          <h5 class="card-title">Course 2</h5>
          <p class="card-text">Description of Course 2.</p>
          <a href="#" class="btn btn-primary">Enroll</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card">
        <img src="../../media/course_image/flower1.jpg" class="card-img-top course-image" alt="Course 3 Image">
        <div class="card-body">
          <h5 class="card-title">Course 3</h5>
          <p class="card-text">Description of Course 3.</p>
          <a href="#" class="btn btn-primary">Enroll</a>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>

