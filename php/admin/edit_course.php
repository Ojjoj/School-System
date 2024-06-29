    <?php
include_once '../include/connect.php';
include_once '../include/admin_checkout.php';


if(isset($_GET['edit_course'])){
    $course_id = $_GET['edit_course'];
    $assistant = '';

    $sql = "SELECT course.*, teacher.* 
            FROM course 
            INNER JOIN teacher ON course.teacher_id=teacher.teacher_id 
            WHERE course.course_id = ? ";

    if ($stmt = mysqli_prepare($connection, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $course_id);
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0)
                $data = mysqli_fetch_array($result);
        }
    } 
    mysqli_stmt_close($stmt);
}
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
        <div class="col-md-10" style="margin: 30px 0 10px 0;">
            <form action="" method="POST" enctype="multipart/form-data">
                <h2>Course Information</h2>
                <hr>
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-6 col-sm-12">
                        <div class="space">
                            <label for="course_name" class="form-label">Course Name</label>
                            <input type="text" class="form-control" id="course_name" name="course_name" value="<?php echo $data['course_name'] ?>" required>
                        </div>
                        <div class="space">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $data['start_date'] ?>" required>
                        </div>
                        <div class="space">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $data['end_date'] ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 image_div" >
                        <div class="card" style="height: 200px; width:300px;">
                            <img src='<?php echo $data['image_path']; ?>' id="course_image">
                        </div>
                        <label for="image_file">Upload</label>
                        <input type="file" name="image" id="image_file" class="image_file" onchange="change_image()">
                    </div>
                </div>

                <h2>Add Teacher</h2>
                <hr>
                <div class="row teacher" style="margin-bottom: 30px;">
                    <div class="col-md-6 col-sm-12">
                        <label class="form-label" for="select_teacher">Choose Teacher</label>
                        <div class="teacher">
                            <input type="text" class="form-control" id="select_teacher" name="select_teacher" value='<?php echo $data['first_name'].' '.$data['last_name'] ; ?>' placeholder="select a teacher">
                            <div class="select" id="select_teacher_options"></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label class="form-label" for="select_assistant">Choose Assistant</label>
                        <div class="select_assistant">
                            <div class="assistant">
                                <input type="text" class="form-control" id="select_assistant" name="select_assistant" placeholder="select an assistant">
                                <div class="select" id="select_assistant_options"></div>
                            </div>
                            <div>
                                <i class="fa-solid fa-plus" id="add_assistant" onclick="add_assistant(this)"></i>
                            </div>
                        </div>
                        <div id="selected_assistant">
                            <?php 
                                $sql = "SELECT assistant.* 
                                FROM assistant
                                INNER JOIN course_assistants ON assistant.assistant_id = course_assistants.assistant_id
                                WHERE course_assistants.course_id = ?";
                                if ($stmt = mysqli_prepare($connection, $sql)) {
                                    mysqli_stmt_bind_param($stmt, "s", $course_id);
                                    if(mysqli_stmt_execute($stmt)){
                                        $result = mysqli_stmt_get_result($stmt);
                                        if (mysqli_num_rows($result) > 0)
                                            while($row = mysqli_fetch_array($result)){
                                            ?>
                                            <div class="added_assistant" id='<?php echo "assistant".$row['assistant_id'];?>'>
                                                <div><?php  $row['first_name']. ' ' . $row['last_name'] ?></div>
                                                <i class="fa-solid fa-minus"></i>
                                            </div>
                                            <?php
                                            }
                                    }
                                }
                                mysqli_stmt_close($stmt);
                            ?>
                        </div>
                    </div>
                </div>             

                <h2>Add Student</h2>
                <hr>
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-6 col-sm-12">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First name</th>
                                    <th>Last name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="select_student">
                            <div class="student">
                                <input type="text" class="form-control" id="select_student" name="select_student" placeholder="select a student">
                                <div class="select" id="select_student_options"></div>
                            </div>
                            <div>
                                <i class="fa-solid fa-plus" id="add_student" onclick="add_student(this)"></i>
                            </div>
                        </div>

                    </div>
                </div>             
                <div class="add_course">
                    <button name="add_course" onclick="save_to_databse()">Add Course</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../../external/bootstrap/bootstrap.min.js"></script>
    <script src="../../js/add_course.js"></script>
    <script src="../../external/jquery/jquery-3.7.1.min.js"></script>
    <script src="../../js/live_search.js"></script>
    </body>
</html>