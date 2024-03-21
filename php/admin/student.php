<?php
include_once '../include/admin_checkout.php';
include_once '../include/connect.php';

function calculate_age($dateOfBirth) {
    $dob = new DateTime($dateOfBirth);
    $now = new DateTime();
    $age = $now->diff($dob);
    return $age->y;
}

$studentsPerPage = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $studentsPerPage;


$sql = "SELECT student_id, first_name, last_name, date_of_birth, gender, country FROM student";
$sql_total_students = "SELECT COUNT(*) AS total FROM student";

if (isset($_GET['search'])) {
    $search_query = mysqli_real_escape_string($connection, $_GET['search']);
    $sql .= " WHERE first_name LIKE '%$search_query%' OR last_name LIKE '%$search_query%' OR country LIKE '%$search_query%'";
    $sql_total_students .= " WHERE first_name LIKE '%$search_query%' OR last_name LIKE '%$search_query%' OR country LIKE '%$search_query%'";
}

$sql .= " LIMIT $offset, $studentsPerPage";

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student</title>
    <link href="../../external/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../../external/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="../../external/fontawesome/css/fontawesome.min.css" rel="stylesheet">
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
                ?>
                    <div class="row">
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
                                    <form id="searchForm" action="student.php" method="GET">
                                        <i class="fa-solid fa-magnifying-glass" onclick="submit_form()"></i>
                                        <input type="text" class="form-control" name="search" id="searchInput" placeholder="Search&hellip;" value=<?php echo $_GET["search"] ?? ""; ?>>
                                    </form>
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
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
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
                                        <a href="edit_student.php?edit=<?php echo $row['student_id'];?>" class="edit" title="Edit" name="edit" data-toggle="tooltip">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <a href="student.php?delete=<?php echo $row['student_id']; ?>" class="delete" title="Delete" name="delete" data-toggle="tooltip" onclick="return confirm('Delete this student?');">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>

                        </tbody>
                    </table>
                    <?php

                    $totalPages = ceil($total_students / $studentsPerPage);
                    $current_entries_start = min($total_students, $offset + 1);
                    $current_entries_end = min($total_students, $offset + $studentsPerPage);

                    if ($current_entries_end < $offset + $studentsPerPage) {
                        $studentsPerPage = $current_entries_end - $offset;
                    } ?>

                    <div class='clearfix'>
                        <div class='hint-text'>Showing <b><?php echo $studentsPerPage ?></b> out of <b><?php echo $total_students ?></b> entries</div>

                        <?php
                        // Calculate start and end pages for pagination sliding window
                        $maxVisiblePages = 5;
                        $startPage = max(1, $page - floor($maxVisiblePages / 2));
                        $endPage = min($totalPages, $startPage + $maxVisiblePages - 1);
                        $startPage = max(1, $endPage - $maxVisiblePages + 1);
                        ?>

                        <!-- Output the pagination links -->
                        <ul class="pagination">
                            <!-- Previous page link -->
                            <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?php echo $page > 1 ? "?page=" . ($page - 1) : "#"; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>

                            <!-- Page links within the sliding window -->
                            <?php for ($i = $startPage; $i <= $endPage; $i++) : ?>
                                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Next page link -->
                            <li class="page-item <?php echo $page == $totalPages || $totalPages == 0 ? 'disabled' : ''; ?>">
                                <a class="page-link" href="<?php echo $page < $totalPages ? "?page=" . ($page + 1) : "#"; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                <?php } ?>
                <div class="text-center">
                    <a href="add_student.php" class="btn btn-primary rounded-pill px-3">Add Student</a>
                </div>
                </div>
            </div>
</body>

<script src="../../js/student.js"></script>

</html>