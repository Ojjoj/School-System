<?php
include_once '../include/connect.php';
session_start();


$alert = isset($_GET['added']) ? '' : 'd-none';

if (isset($_POST['submit'])) {
    $sql = "INSERT INTO `assistant` (`first_name`, `last_name`, `email`) VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sss', $first_name, $last_name, $email);

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = isset($_POST['email']) ? $_POST['email'] : NULL;

        $success = mysqli_stmt_execute($stmt);

        if ($success) {
            header('Location: assistant.php?added=true');
            exit;
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($connection);
    }
}

if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];

    $sql_delete_assistant = "DELETE FROM assistant WHERE assistant_id = ?";
    $stmt_delete_assistant = mysqli_prepare($connection, $sql_delete_assistant);
    mysqli_stmt_bind_param($stmt_delete_assistant, "i", $delete_id);
    mysqli_stmt_execute($stmt_delete_assistant);
    mysqli_stmt_close($stmt_delete_assistant);

    header('location:assistant.php');
    exit;
}

$sql = "SELECT assistant_id, first_name, last_name, email FROM assistant";


if (isset($_GET['search'])) {
    $search_query = mysqli_real_escape_string($connection, $_GET['search']);
    $sql .= " WHERE first_name LIKE '%$search_query%' OR last_name LIKE '%$search_query%' OR email LIKE '%$search_query%'";
    // $sql_total_students .= " WHERE first_name LIKE '%$search_query%' OR last_name LIKE '%$search_query%' OR country LIKE '%$search_query%'";
}

if ($stmt = mysqli_prepare($connection, $sql)) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    echo "Error in preparing SQL statement: " . mysqli_error($connection);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Assistant</title>
    <link href="../../external/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../../external/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="../../external/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="../../css/assistant.css" rel="stylesheet">
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
            <div class="table-responsive">
                <div class="container mt-3">
                    <div class="table-wrapper">
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
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="table-title">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h2><b>Assistants</b></h2>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="search-box">
                                                <form id="searchForm" action="assistant.php" method="GET">
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
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $assistant_id = $row['assistant_id'];
                                            $first_name = $row['first_name'];
                                            $last_name = $row['last_name'];
                                            $email = $row['email'];
                                            echo "<tr>";
                                            echo "<td>$assistant_id</td>";
                                            echo "<td>$first_name</td>";
                                            echo "<td>$last_name</td>";
                                            echo "<td>$email</td>";
                                            echo "<td>";
                                            echo '   <a href="view_assistant.php?view=' . $assistant_id . '" class="view" title="View" name="view" data-toggle="tooltip"><i class="fa-solid fa-eye"></i></a>';
                                            echo '   <a href="edit_assistant.php?edit=' . $assistant_id . '" class="edit" title="Edit" name="edit" data-toggle="tooltip"><i class="fa-solid fa-pencil"></i></a>';
                                            echo '   <a href="assistant.php?delete=' . $assistant_id . '" class="delete" title="Delete" name="delete" data-toggle="tooltip" onclick="return confirm(\'Delete this assistant?\');"><i class="fa-solid fa-trash"></i></a>';
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                        echo '  </tbody>';
                                        echo '</table>';
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-5">
                                <form action="" method="POST">
                                    <div class="container mt-3">
                                        <div class="row me-3">
                                            <div class="alert alert-success alert-dismissible fade show <?php echo $alert; ?>" role="alert">
                                                Assistant was added successfully
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                            <div class="mb-3">
                                                <center>
                                                    <h2>Add Assistant</h2>
                                                </center>
                                                <hr>
                                                <label for="first_name" class="form-label">First Name</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" required>

                                                <label for="last_name" class="form-label">Last Name</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" required>

                                                <label for="email" class="form-label">email</label>
                                                <input type="email" class="form-control" id="email" name="email">
                                            </div>
                                        </div>
                                    </div>
                                    <center>
                                        <button type="submit" class="btn btn-primary" name="submit">Add Assistant</button>
                                    </center>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../external/bootstrap/bootstrap.min.js"></script>
    <script src="../../js/assistant.js"></script>
</body>

</html>