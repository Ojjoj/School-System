<?php
include_once '../include/admin_checkout.php';
include_once '../include/connect.php';

if (isset($_GET['view'])) {
    $assistant_id = $_GET['view'];

    $sql = "SELECT * FROM assistant WHERE assistant_id = ?";
    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $assistant_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $assistant_id, $first_name, $last_name, $email);
        mysqli_stmt_fetch($stmt);

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($connection);
    }
} else {
    header("Location: add_assistant.php");
    exit;
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Student</title>
    <link href="../../external/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../../external/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="../../external/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="../../css/view_assistant.css" rel="stylesheet">
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
                <div class="row me-3">
                    <div class="mb-3">
                        <h2>General Information</h2>
                        <hr>
                        <table class="info-table">
                            <tr>
                                <td><strong>First Name:</strong></td>
                                <td><?php echo $first_name ? $first_name : "<span class='text-danger'>Not available</span>"; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Last Name:</strong></td>
                                <td><?php echo $last_name ? $last_name : "<span class='text-danger'>Not available</span>"; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row me-3">
                    <div class="mb-3">
                        <h2>Contact Information</h2>
                        <hr>
                        <table class="info-table">
                            <tr>
                                <td><strong>Email</strong></td>
                                <td><?php echo $email ? $email : "<span class='text-danger'>Not available</span>"; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <br>
                <center>
                    <a href="add_assistant.php" class="btn btn-primary">Back to Assistants List</a>
                </center>
                <br>
            </div>
        </div>
    </div>

    <script src="../../external/bootstrap/bootstrap.min.js"></script>
</body>

</html>