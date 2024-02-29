<?php
include_once '../include/admin_checkout.php'; 

include_once '../include/connect.php';

$studentsPerPage = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $studentsPerPage;


$sql = "SELECT student_id, first_name, last_name, date_of_birth, gender, country FROM student LIMIT $offset, $studentsPerPage";
$sql_total_students = "SELECT COUNT(*) AS total FROM student";

if ($stmt = mysqli_prepare($connection, $sql)) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    echo "Error in preparing SQL statement: " . mysqli_error($connection);
}

if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];

    $sql = "DELETE FROM student WHERE student_id = $delete_id";
    mysqli_query($connection, $sql);

    header('location:student.php');
}

?>

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student</title>
    <link href="../../external/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../../external/fontawesome/css/all.min.css" rel="sylesheet">
    <link href="../../external/fontawesome/css/fontawesome.min.css" rel="sylesheet">
    <link href="../../css/student.css" rel="stylesheet">
</head>

<?php
include '../include/navbar.php';
?>

<body>
    <div class="row">
        <div class="col-md-2">
            <?php include '../include/sidebar.php'; ?>
        </div>
        <div class="col-md-10">
            <div class="container mt-3">
                <?php
                if ($result) {
                    $resultTotalStudents = mysqli_query($connection, $sql_total_students);
                    $rowTotalStudents = mysqli_fetch_assoc($resultTotalStudents);
                    $total_students = $rowTotalStudents['total'];
                    mysqli_free_result($resultTotalStudents);
                    mysqli_close($connection);

                    echo '<div class="row">
                    <div class="col-md-6">
                        <h5><b>Year</b></h5>
                        <select class="form-select">
                            <option selected="">All</option>
                            <option value="1">2023-2024</option>
                            <option value="2">2022-2023</option>
                            <option value="3">2021-2022</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <h5><b>Availability</b></h5>
                        <select class="form-select">
                            <option selected="">All</option>
                            <option value="1">Active</option>
                            <option value="2">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-8">
                                <h2><b>Students</b></h2>
                            </div>
                            <div class="col-sm-4">
                                <div class="search-box">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <input type="text" class="form-control" placeholder="Search&hellip;">
                                </div>
                            </div>
                        </div>
                    </div>
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
                        <tbody>';
                    while ($row = mysqli_fetch_assoc($result)) {
                        $student_id = $row['student_id'];
                        $first_name = $row['first_name'];
                        $last_name = $row['last_name'];
                        $date_of_birth = $row['date_of_birth'];
                        $gender = $row['gender'];
                        $country = $row['country'];
                        echo "<tr>";
                        echo "<td>$student_id</td>";
                        echo "<td>$first_name</td>";
                        echo "<td>$last_name</td>";
                        echo "<td>$date_of_birth</td>";
                        echo "<td>$gender</td>";
                        echo "<td>$country</td>";
                        echo "<td>";
                        echo '   <a href="#" class="view" title="View" name="view" data-toggle="tooltip"><i class="fa-solid fa-eye"></i></a>';
                        echo '   <a href="edit_student.php?edit=' . $student_id . '" class="edit" title="Edit" name="edit" data-toggle="tooltip"><i class="fa-solid fa-pencil"></i></a>';
                        echo '   <a href="student.php?delete=' . $student_id . '" class="delete" title="Delete" name="delete" data-toggle="tooltip" onclick="return confirm(\'Delete this student?\');"><i class="fa-solid fa-trash"></i></a>';

                        echo "</td>";
                        echo "</tr>";
                    }
                    echo '  </tbody>';
                    echo '</table>';

                    $totalPages = ceil($total_students / $studentsPerPage);
                    $current_entries_start = min($total_students, $offset + 1);
                    $current_entries_end = min($total_students, $offset + $studentsPerPage);

                    if ($current_entries_end < $offset + $studentsPerPage) {
                        $studentsPerPage = $current_entries_end - $offset;
                    }

                    echo "<div class='clearfix'>";
                    echo "<div class='hint-text'>Showing <b>$studentsPerPage</b> out of <b>$total_students</b> entries</div>";
                    echo "<ul class='pagination'>";
                    echo "<li class='page-item ";
                    if ($page == 1) {
                        echo "disabled";
                    }
                    echo "'><a href='";
                    if ($page > 1) {
                        echo "?page=" . ($page - 1);
                    }
                    echo "'><i class='fa fa-angle-double-left'></i></a></li>";
                    for ($i = 1; $i <= $totalPages; $i++) {
                        if ($i == $page) {
                            echo "<li class='page-item active'><a href='#' class='page-link'>$i</a></li>";
                        } else {
                            echo "<li class='page-item'><a href='?page=$i' class='page-link'>$i</a></li>";
                        }
                    }
                    echo "<li class='page-item ";
                    if ($page == $totalPages || $totalPages == 0) {
                        echo "disabled";
                    }
                    echo "'><a href='";
                    if ($page < $totalPages) {
                        echo "?page=" . ($page + 1);
                    }
                    echo "'><i class='fa fa-angle-double-right'></i></a></li>";
                    echo "</ul>";
                    echo "</div>";
                } else {
                    echo "Error: " . mysqli_error($connection);
                }
                ?>
                <div class="text-center">
                    <a href="add_student.php" class="btn btn-primary rounded-pill px-3">Add Student</a>
                </div>
            </div>
        </div>
</body>

</html>