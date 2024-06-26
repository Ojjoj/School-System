<?php
include_once '../include/connect.php';
include_once '../include/admin_checkout.php';

// course and teacher
if (isset($_GET['edit_course'])) {
    $course_id = $_GET['edit_course'];
    $assistant = '';

    $sql = "SELECT course.*, teacher.* 
            FROM course , teacher
            WHERE course.teacher_id=teacher.teacher_id 
            AND course.course_id = ? ";

    if ($stmt = mysqli_prepare($connection, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $course_id);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0)
                $data = mysqli_fetch_array($result);
        }
    }
    mysqli_stmt_close($stmt);
}

// assistants
$assistants = [];
$sql = "SELECT assistant.* 
FROM assistant, course_assistants
WHERE assistant.assistant_id = course_assistants.assistant_id
AND course_assistants.course_id = ?";
if ($stmt = mysqli_prepare($connection, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $course_id);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0)
            while ($row = mysqli_fetch_array($result)) {
                $assistants[] = array(
                    'id' => "assistant" . $row['assistant_id'],
                    'full_name' => $row['first_name'] . ' ' . $row['last_name']
                );
            }
    }
}
mysqli_stmt_close($stmt);


// students
$students = [];
$sql = "SELECT student.* 
FROM student, course_students
WHERE student.student_id = course_students.student_id
AND course_students.course_id = ?";
if ($stmt = mysqli_prepare($connection, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $course_id);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0)
            while ($row = mysqli_fetch_array($result)) {
                $students[] = array(
                    'id' => "student" . $row['student_id'],
                    'full_name' => $row['first_name'] . ' ' . $row['last_name']
                );
            }
    }
}
mysqli_stmt_close($stmt);
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
            <div id='success' class="alert alert-success alert-dismissible fade show" style="display: none;" role="alert" style="width:99%;">
                course updated successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div id='fail' class="alert alert-danger alert-dismissible fade show" style="display: none;" role="alert" style="width:99%;">
                Failed to update the course. Please try again.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

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
                    <div class="col-md-6 col-sm-12 image_div">
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
                            <input type="text" class="form-control <?php echo "teacher" . $data['teacher_id'] ?>" id="select_teacher" name="select_teacher" value='<?php echo $data['first_name'] . ' ' . $data['last_name']; ?>' placeholder="select a teacher">
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
                        <div id="selected_assistant"></div>
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
                <div id="align_button">
                    <button type="submit" class="space btn btn-primary" name="update_course" onclick="update_database(event)">Update</button>
                    <a class="btn btn-danger cancel" name="cancel" href="course.php">Cancel</a>
                    </div>
            </form>
        </div>
    </div>

    <script id="course_id">
        <?php echo $_GET['edit_course']; ?>
    </script>

    <script id="assistants-data">
        <?php echo json_encode($assistants); ?>
    </script>

    <script id="students-data">
        <?php echo json_encode($students); ?>
    </script>

    <script src="../../external/bootstrap/bootstrap.min.js"></script>
    <script src="../../js/edit_course.js"></script>
    <script src="../../external/jquery/jquery-3.7.1.min.js"></script>
    <script src="../../js/live_search.js"></script>
</body>

</html>