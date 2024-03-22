<?php
include_once '../include/admin_checkout.php'; 
include_once '../include/connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Course</title>
    <link rel="stylesheet" href="../../external/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../external/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../external/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../../css/add_course.css">
</head>


<?php
include '../include/navbar.php';
?>

<body>
    <div class="row">
        <div class="col-md-2">
            <?php include '../include/sidebar.php'; ?>
        </div>
        <div class="col-md-10" style="margin: 30px 0 30px 0;">
            <form action="" method="POST" enctype="multipart/form-data">
                <h2>Course Information</h2>
                <hr>
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-6 col-sm-12">
                        <div class="space">
                            <label for="course_name" class="form-label">Course Name</label>
                            <input type="text" class="form-control" id="course_name" name="course_name" required>
                        </div>
                        <div class="space">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="space">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 image_div" >
                        <div class="card" style="height: 200px; width:300px;">
                            <img src="../../media/course_image/flower1.jpg" id="course_image">
                        </div>
                        <label for="image_file">Upload</label>
                        <input type="file" name="image" id="image_file" class="image_file" onchange="change_image()">
                    </div>
                </div>

                <h2>Add Teacher</h2>
                <hr>
                <div class="row teacher_info" style="margin-bottom: 3   0px;">
                    <div class="col-md-6 col-sm-12">
                        <label class="form-label">Choose Teacher</label>
                        <select class="form-select" id="teacher" name="teacher">
                            <option value="0" disabled selected>Select Teacher</option>
                            <?php 
                                $sql = "SELECT * FROM teacher";
                                if($stmt = mysqli_prepare($connection, $sql)){
                                    if(mysqli_stmt_execute($stmt)){
                                        $result = mysqli_stmt_get_result($stmt);
                                        if (mysqli_num_rows($result) > 0) {
                                            while($data = mysqli_fetch_array($result)){
                                                echo "<option value='".$data['teacher_id']."'>".$data['teacher_name']."</option>";
                                            }
                                        }
                                    }
                                }
                                mysqli_stmt_close($stmt);
                            ?>
                        </select>
                    </div>
                    <div class="row col-md-6 col-sm-12">
                        <div>
                            <label class="form-label">Choose Assistant</label>
                            <div class="add_assistant">
                                <select class="form-select" id="assistant" name="assistant">
                                    <option value="0" disabled selected>Select Assistant</option>
                                    <?php 
                                        $sql = "SELECT * FROM assistant";
                                        if($stmt = mysqli_prepare($connection, $sql)){
                                            if(mysqli_stmt_execute($stmt)){
                                                $result = mysqli_stmt_get_result($stmt);
                                                if (mysqli_num_rows($result) > 0) {
                                                    while($data = mysqli_fetch_array($result)){
                                                        echo "<option value='".$data['assistant_id']."'>".$data['assistant_name']."</option>";
                                                    }
                                                }
                                            }
                                        }
                                        mysqli_stmt_close($stmt);
                                    ?>
                                </select>
                                <div>
                                    <i class="fa-solid fa-plus"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h2>Add Student</h2>
                <hr>
                <div style="margin-bottom: 20px;">

                </div>
                
                
            </form>
        </div>
    </div>

    <script src="../../external/bootstrap/bootstrap.min.js"></script>
    <script src="../../js/add_course.js"></script>
</body>

</html>