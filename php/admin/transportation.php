<?php
include_once '../include/admin_checkout.php';
include_once '../include/connect.php';


$alert = isset($_GET['added']) ? '' : 'd-none';

if (isset($_POST['submit'])) {
    $sql = "INSERT INTO `bus` (`bus_name`, `driver_name`) VALUES (?, ?)";

    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ss', $bus_name, $driver_name);

        $bus_name = $_POST['bus_name'];
        $driver_name = isset($_POST['driver_name']) ? $_POST['driver_name'] : null;

        $success = mysqli_stmt_execute($stmt);

        if ($success) {
            header('Location: transportation.php?added=true');
            exit;
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($connection);
    }
}

if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];

    $sql_delete_bus = "DELETE FROM bus WHERE bus_id = ?";
    $stmt_delete_bus = mysqli_prepare($connection, $sql_delete_bus);
    mysqli_stmt_bind_param($stmt_delete_bus, "i", $delete_id);
    mysqli_stmt_execute($stmt_delete_bus);
    mysqli_stmt_close($stmt_delete_bus);

    $sql_update_students = "UPDATE student SET transportation = 'own_transportation', bus_id = NULL WHERE bus_id = ?";
    $stmt_update_students = mysqli_prepare($connection, $sql_update_students);
    mysqli_stmt_bind_param($stmt_update_students, "i", $delete_id);
    mysqli_stmt_execute($stmt_update_students);
    mysqli_stmt_close($stmt_update_students);

    header('location:transportation.php');
    exit;
}

$sql = "SELECT bus_id, bus_name, driver_name FROM bus";

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
    <title>Transportation</title>
    <link href="../../external/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../../external/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="../../external/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="../../css/transportation.css" rel="stylesheet">
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
                                <div class="table-title">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <h2><b>Buses</b></h2>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Bus name</th>
                                            <th>Driver name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $bus_id = $row['bus_id'];
                                            $bus_name = $row['bus_name'];
                                            $driver_name = $row['driver_name'];
                                            echo "<tr>";
                                            echo "<td>$bus_id</td>";
                                            echo "<td>$bus_name</td>";
                                            echo "<td>$driver_name</td>";
                                            echo "<td>";
                                            echo '   <a href="edit_transportation.php?edit=' . $bus_id . '" class="edit" title="Edit" name="edit" data-toggle="tooltip"><i class="fa-solid fa-pencil"></i></a>';
                                            echo '   <a href="transportation.php?delete=' . $bus_id . '" class="delete" title="Delete" name="delete" data-toggle="tooltip" onclick="return confirm(\'Delete this bus?\');"><i class="fa-solid fa-trash"></i></a>';
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
                                <form action="" method="POST">
                                    <div class="container mt-3">
                                        <div class="row me-3">
                                            <div class="alert alert-success alert-dismissible fade show <?php echo $alert; ?>" role="alert">
                                                Bus was added successfully
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                            <div class="mb-3">
                                                <center>
                                                    <h2>Add Bus</h2>
                                                </center>
                                                <hr>
                                                <label for="bus_name" class="form-label">Bus Name</label>
                                                <input type="text" class="form-control" id="bus_name" name="bus_name" required>

                                                <label for="driver_name" class="form-label">Driver Name</label>
                                                <input type="text" class="form-control" id="driver_name" name="driver_name">
                                            </div>
                                        </div>
                                    </div>
                                    <center>
                                        <button type="submit" class="btn btn-primary" name="submit">Add Bus</button>
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
    <script src="../../js/add_student.js"></script>
</body>

</html>