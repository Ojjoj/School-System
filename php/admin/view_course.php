<?php 
include_once '../include/connect.php';
include_once '../include/admin_checkout.php';


function calculate_age($dateOfBirth)
{
    $dob = new DateTime($dateOfBirth);
    $now = new DateTime();
    $age = $now->diff($dob);
    return $age->y;
}

if(isset($_GET['view_course'])){
    $course_id = $_GET['view_course'];
    $assistant = '';

    $sql = "SELECT course.*, teacher.* 
            FROM course 
            INNER JOIN teacher ON course.teacher_id=teacher.teacher_id 
            WHERE course.course_id = ? ";

    if ($stmt = mysqli_prepare($connection, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $course_id);
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0)
                $data = mysqli_fetch_array($result);
        }
    } 
    mysqli_stmt_close($stmt);

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
                    $assistant .= $row['first_name']. ' ' . $row['last_name']. ' - ';
                }
            $assistant = substr($assistant, 0, -2); 
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
    <title>View student</title>
    <link rel="stylesheet" href="../../external/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../external/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../external/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../../css/view_course.css">
</head>


<?php
include '../include/navbar.php';
?>

<body>
    <div class="row">
        <div class="col-md-2 d-md-block d-non" style="width:13.5%">
            <?php include '../include/sidebar.php'; ?>
        </div>

        <div class="col-md-10" style="width:86%">
            <div class="course_image"><img src='<?php echo $data['image_path']; ?>'></div>
            <div class="course">
                <h1><?php echo $data['course_name']; ?></h1>
                <div class="course_information">
                    <table>
                        <colgroup>
                            <col style="width:2.5%;">
                            <col style="width:10%;">
                            <col style="width:85%;">
                        </colgroup>
                        <tbody>
                            <tr>
                                <td><i class="fa-solid fa-user"></i></td>
                                <td>Teacher</td>
                                <td><?php echo $data['first_name'].' '.$data['last_name'] ; ?></td>
                            </tr>
                            <tr>
                                <td><i class="fa-solid fa-user-group"></i></td>
                                <td>Assistant</td>
                                <td><?php echo $assistant ?></td>
                            </tr>
                            <tr>
                                <td><i class="fa-solid fa-calendar"></i></td>
                                <td>Start-Date</td>
                                <td><?php echo $data['start_date']; ?></td>
                            </tr>
                            <tr>
                                <td><i class="fa-solid fa-calendar"></i></td>
                                <td>End-Date</td>
                                <td><?php echo $data['end_date']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3>Students Registered</h3>
                <div>
                       <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name <i class="fa fa-sort"></i></th>
                                <th>Last Name</th>
                                <th>Age <i class="fa fa-sort"></i></th>
                                <th>Gender</th>
                                <th>Country <i class="fa fa-sort"></i></th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(isset($_GET['view_course'])){
                                $sql = "SELECT student.* 
                                        FROM student
                                        INNER JOIN course_students ON student.student_id = course_students.student_id
                                        WHERE course_students.course_id = ?";

                                if ($stmt = mysqli_prepare($connection, $sql)) {
                                    mysqli_stmt_bind_param($stmt, "i", $course_id);
                                    if(mysqli_stmt_execute($stmt)){
                                        $result = mysqli_stmt_get_result($stmt);
                                        if (mysqli_num_rows($result) > 0)
                                            while($row = mysqli_fetch_array($result)){
                                        ?>
                                        <tr>
                                        <td><?php echo $row['student_id']; ?></td>
                                        <td><?php echo $row['first_name']; ?></td>
                                        <td><?php echo $row['last_name']; ?></td>
                                        <td><?php echo calculate_age($row['date_of_birth']); ?></td>
                                        <td><?php echo $row['gender']; ?></td>
                                        <td><?php echo $row['country']; ?></td>
                                        <td>
                                            <a href="view_student.php?view=<?php echo $row['student_id']; ?>" class="view" title="View" name="view" data-toggle="tooltip">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                        }
                                    }
                                }
                                mysqli_stmt_close($stmt);
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>