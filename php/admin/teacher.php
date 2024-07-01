<?php
include_once '../include/admin_checkout.php';
include_once '../include/connect.php';

$teachersPerPage = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $teachersPerPage;

$sql = "SELECT teacher_id, first_name, last_name, job_description FROM teacher";
$sql_total_teachers = "SELECT COUNT(*) AS total FROM teacher";

$filters = [];

if (isset($_GET['search'])) {
    $search_query = mysqli_real_escape_string($connection, $_GET['search']);
    array_push($filters, "first_name LIKE '%$search_query%' OR last_name LIKE '%$search_query%' OR job_description LIKE '%$search_query%'");
}

if (isset($_GET['status']) && $_GET['status'] != '') {
    $status = mysqli_real_escape_string($connection, $_GET['status']);
    if ($status == 'Active') {
        array_push($filters, "teacher_id IN (SELECT teacher_id FROM course)");
    } else if ($status == 'Inactive') {
        array_push($filters, "teacher_id NOT IN (SELECT teacher_id FROM course)");
    }
}

if (count($filters) > 0) {
    $sql .= " WHERE " . implode(' AND ', $filters);
    $sql_total_teachers .= " WHERE " . implode(' AND ', $filters);
}

$sorts = [];
if (isset($_SESSION['sortFN'])) {
    $_SESSION['sortFN'] = ($_SESSION['sortFN'] == 'ASC') ? 'DESC' : 'ASC';
} else {
    $_SESSION['sortFN'] = 'ASC';
}
if (isset($_SESSION['sortLN'])) {
    $_SESSION['sortLN'] = ($_SESSION['sortLN'] == 'ASC') ? 'DESC' : 'ASC';
} else {
    $_SESSION['sortLN'] = 'ASC';
}

if (isset($_GET['sortFN']) && $_GET['sortFN'] != '') {
    $sort = mysqli_real_escape_string($connection, $_GET['sortFN']);
    $sortOrder = $_SESSION['sortFN'];
    array_push($sorts, "$sort $sortOrder");
}

if (isset($_GET['sortLN']) && $_GET['sortLN'] != '') {
    $sort = mysqli_real_escape_string($connection, $_GET['sortLN']);
    $sortOrder = $_SESSION['sortLN'];
    array_push($sorts, "$sort $sortOrder");
}
if (count($sorts) > 0) {
    $sql .= " ORDER BY " . implode(' , ', $sorts);
    $sql_total_teachers .= " ORDER BY " . implode(' , ', $sorts);
}

$sql .= " LIMIT $offset, $teachersPerPage";

if ($stmt = mysqli_prepare($connection, $sql)) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    echo "Error in preparing SQL statement: " . mysqli_error($connection);
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $sql_delete = "DELETE FROM teacher WHERE teacher_id = ?";
    if ($stmt_delete = mysqli_prepare($connection, $sql_delete)) {
        mysqli_stmt_bind_param($stmt_delete, "i", $delete_id);
        mysqli_stmt_execute($stmt_delete);
        header('location:teacher.php');
    } else {
        echo "Error deleting record: " . mysqli_error($connection);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teachers</title>
    <link href="../../external/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../../external/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="../../external/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="../../css/teacher.css" rel="stylesheet">
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
                    $resultTotalTeachers = mysqli_query($connection, $sql_total_teachers);
                    $rowTotalTeachers = mysqli_fetch_assoc($resultTotalTeachers);
                    $total_teachers = $rowTotalTeachers['total'];
                    mysqli_free_result($resultTotalTeachers);
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
                            <form id="statusForm" action="teacher.php" method="GET">
                                <select class="form-select" name="status" onchange="submit_form('statusForm')">
                                    <option value="">All</option>
                                    <option value="Active" <?php if (isset($_GET['status']) && $_GET['status'] == 'Active') echo 'selected'; ?>>Active</option>
                                    <option value="Inactive" <?php if (isset($_GET['status']) && $_GET['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                                </select>
                            </form>
                        </div>
                    </div>
            </div>
            <div class="table-responsive">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-8">
                                <h2><b>Teachers</b></h2>
                            </div>
                            <div class="col-sm-4">
                                <div class="search-box">
                                    <form id="searchForm" action="teacher.php" method="GET">
                                        <i class="fa-solid fa-magnifying-glass" onclick="submit_form('searchForm')"></i>
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
                                <form id="sortFormFN" action="teacher.php" method="GET">
                                    <th>First Name <i class="fa fa-sort" onclick="submit_form('sortFormFN')"></i></th>
                                    <input type="hidden" id="sortInput" name="sortFN" value="first_name">
                                </form>
                                <form id="sortFormLN" action="teacher.php" method="GET">
                                    <th>Last Name <i class="fa fa-sort" onclick="submit_form('sortFormLN')"></i></th>
                                    <input type="hidden" id="sortInput" name="sortLN" value="last_name">
                                </form>
                                <th>Job Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                <tr>
                                    <td><?php echo $row['teacher_id']; ?></td>
                                    <td><?php echo $row['first_name']; ?></td>
                                    <td><?php echo $row['last_name']; ?></td>
                                    <td><?php echo $row['job_description']; ?></td>
                                    <td>
                                        <a href="view_teacher.php?view=<?php echo $row['teacher_id']; ?>" class="view" title="View" name="view" data-toggle="tooltip">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="edit_teacher.php?edit=<?php echo $row['teacher_id']; ?>" class="edit" title="Edit" name="edit" data-toggle="tooltip">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <a href="teacher.php?delete=<?php echo $row['teacher_id']; ?>" class="delete" title="Delete" name="delete" data-toggle="tooltip" onclick="return confirm('Delete this teacher?');">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <?php

                    $totalPages = ceil($total_teachers / $teachersPerPage);
                    $current_entries_start = min($total_teachers, $offset + 1);
                    $current_entries_end = min($total_teachers, $offset + $teachersPerPage);

                    if ($current_entries_end < $offset + $teachersPerPage) {
                        $teachersPerPage = $current_entries_end - $offset;
                    } ?>

                    <div class='clearfix'>
                        <div class='hint-text'>Showing <b><?php echo $teachersPerPage ?></b> out of <b><?php echo $total_teachers ?></b> entries</div>

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
                    <a href="add_teacher.php" class="btn btn-primary rounded-pill px-3">Add Teacher</a>
                </div>
                </div>
            </div>
            <script src="../../js/teacher.js"></script>
            <script src="../../external/bootstrap/bootstrap.min.js"></script>
</body>

</html>