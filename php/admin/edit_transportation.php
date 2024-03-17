<?php
include_once '../include/connect.php';
session_start();


$alert = isset($_GET['added']) ? '' : 'd-none';
$alert2 = isset($_GET['bus_updated']) ? '' : 'd-none';

if (isset($_POST['edit_bus']) && isset($_GET['edit'])) {
    $bus_id = $_GET["edit"];
    $new_bus_name = $_POST['bus_name'];
    $new_driver_name = $_POST['driver_name'];

    $sql = "UPDATE bus SET bus_name = ?, driver_name = ? WHERE bus_id = ?";
    $stmt_update_bus = mysqli_prepare($connection, $sql);
    if ($stmt_update_bus) {
        mysqli_stmt_bind_param($stmt_update_bus, 'ssi', $new_bus_name, $new_driver_name, $bus_id);
        $success_update_bus = mysqli_stmt_execute($stmt_update_bus);
        if ($success_update_bus) {
            header("Location: edit_transportation.php?edit=$bus_id&bus_updated=true");
            exit;
        } else {
            echo "Error updating bus";
        }
    } else {
        echo "Error preparing statement: " . mysqli_error($connection);
    }
}

if (isset($_POST['submit']) && isset($_GET['edit'])) {
    $student_id = $_POST['student_id'];
    $bus_id = $_GET['edit'];

    $update_student_sql = "UPDATE student SET transportation = 'school_bus', bus_id = ? WHERE student_id = ?";
    $stmt_update_student = mysqli_prepare($connection, $update_student_sql);
    if ($stmt_update_student) {
        mysqli_stmt_bind_param($stmt_update_student, 'ii', $bus_id, $student_id);
        $success_update_student = mysqli_stmt_execute($stmt_update_student);
        if ($success_update_student) {
            header("Location: edit_transportation.php?edit=$bus_id&added=true");
            exit;
        } else {
            echo "Error updating student";
        }
    } else {
        echo "Error preparing statement: " . mysqli_error($connection);
    }
}

if (isset($_GET['delete']) && isset($_GET['edit'])) {
    $bus_id = $_GET['edit'];
    $student_id = $_GET['delete'];
    $sql = "UPDATE student SET transportation = 'own_transportation', bus_id = NULL WHERE student_id = ?";
    $stmt = mysqli_prepare($connection, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $student_id);
        $success = mysqli_stmt_execute($stmt);
        if ($success) {
            header("location:edit_transportation.php?edit=$bus_id");
            exit;
        } else {
            echo "Error executing";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($connection);
    }
}


if (isset($_GET["edit"])) {
    $bus_id = $_GET["edit"];
    $sql = "SELECT bus_id, bus_name, driver_name FROM bus WHERE bus_id = ?";
    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $bus_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_bind_result($stmt, $bus_id, $bus_name, $driver_name);
        $row = mysqli_fetch_assoc($result);
        $bus_id = $row["bus_id"];
        $bus_name = $row["bus_name"];
        $driver_name = $row["driver_name"];
    } else {
        echo "Error preparing statement: " . mysqli_error($connection);
    }

    $sql = "SELECT student_id, first_name, last_name FROM student WHERE bus_id = ?";
    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $bus_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($connection);
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bus</title>
    <link href="../../external/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../../external/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="../../external/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="../../css/edit_transportation.css" rel="stylesheet">
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
                        <div class="alert alert-success alert-dismissible fade show <?php echo $alert2; ?>" role="alert">
                            Bus was edited successfully
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <form action="" method="POST">
                            <div class="table-title">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h5><b>Bus name</b></h5>
                                        <input type="text" class="form-control" id="bus_name" name="bus_name" value="<?php echo $bus_name; ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="container">
                                            <h5><b>Driver name</b></h5>
                                            <input type="text" class="form-control" id="driver_name" name="driver_name" value="<?php echo $driver_name; ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <center>
                                <button type="submit" class="btn btn-primary" name="edit_bus">Edit Bus</button>
                                <a href="transportation.php" class="btn btn-danger" name="submit">Cancel</a>
                            </center>
                        </form>
                        <hr>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="table-title">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <h2><b>Students</b></h2>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First name</th>
                                            <th>Last name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $student_id = $row['student_id'];
                                            $first_name = $row['first_name'];
                                            $last_name = $row['last_name'];
                                            echo "<tr>";
                                            echo "<td>$student_id</td>";
                                            echo "<td>$first_name</td>";
                                            echo "<td>$last_name</td>";
                                            echo "<td class='delete-td'>";
                                            echo '   <a href="edit_transportation.php?edit=' . $bus_id . '&delete=' . $student_id . '" class="delete" title="Delete" name="delete" data-toggle="tooltip" onclick="return confirm(\'Delete this student?\');"><i class="fa-solid fa-trash"></i></a>';
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                        echo '  </tbody>';
                                        echo '</table>';
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <form action="" method="POST" onsubmit="return validateForm()">
                                    <div class="container mt-3">
                                        <div class="row me-3">
                                            <div class="alert alert-success alert-dismissible fade show <?php echo $alert; ?>" role="alert">
                                                Student was added successfully
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                            <div class="mb-3">
                                                <center>
                                                    <h2>Add Student</h2>
                                                </center>
                                                <hr>
                                                <select class="form-select" name="student_id" id="student_id">
                                                    <option value="" selected>Select a student</option> 
                                                    <?php
                                                    $sql_select_students = "SELECT student_id, first_name, last_name FROM student WHERE transportation = 'own_transportation'";
                                                    $stmt_select_students = mysqli_prepare($connection, $sql_select_students);
                                                    if ($stmt_select_students) {
                                                        mysqli_stmt_execute($stmt_select_students);
                                                        $result_select_students = mysqli_stmt_get_result($stmt_select_students);
                                                        while ($row_select_students = mysqli_fetch_assoc($result_select_students)) {
                                                            $student_id = $row_select_students['student_id'];
                                                            $first_name = $row_select_students['first_name'];
                                                            $last_name = $row_select_students['last_name'];
                                                            echo "<option value='$student_id'>$first_name $last_name</option>";
                                                        }
                                                    } else {
                                                        echo "Error preparing statement: " . mysqli_error($connection);
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <center>
                                        <button type="submit" class="btn btn-primary" name="submit">Add Student</button>
                                    </center>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>
    <script src="../../external/bootstrap/bootstrap.min.js"></script>
    <script src="../../js/edit_transportation.js"></script>
</body>

</html>