<?php
include_once '../include/admin_checkout.php';
include_once '../include/connect.php';

$alert = 'd-none';
if (isset($_POST['submit'])) {
    $sql = "INSERT INTO `teacher` (`first_name`, `last_name`, `email`, `job_description`) 
        VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ssss', $first_name, $last_name, $email, $job_description);

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = isset($_POST['email']) ? $_POST['email'] : null;
        $job_description = isset($_POST['job_description']) ? $_POST['job_description'] : null;

        $success = mysqli_stmt_execute($stmt);

        if ($success) {
            $alert = '';
        } else {
            $alert = 'd-none';
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($connection);
    }
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Teacher</title>
    <link href="../../external/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../../external/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="../../external/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="../../css/add_teacher.css" rel="stylesheet">
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
            <form action="" method="POST">
                <div class="container mt-3">
                    <div class="row me-3">
                        <div class="alert alert-success alert-dismissible fade show <?php echo $alert; ?>" role="alert">
                            Teacher was added successfully
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="mb-3">
                            <h2>General Information</h2>
                            <hr>
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>

                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <br>
                        <div class="mb-6">
                            <h2>Contact Information</h2>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                            </div>
                        </div>
                        <div class="row me-3">
                            <div class="mb-6">
                                <br>
                                <h2>Job Description</h2>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="job_description" class="form-label">Job Description</label>
                                            <textarea class="form-control" id="job_description" name="job_description" rows="6"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <center>
                            <br>
                            <button type="submit" class="btn btn-primary" name="submit">Add Teacher</button>
                            <a href="teacher.php" class="btn btn-danger" name="submit">Cancel</a>
                        </center>
                    </div>
            </form>
        </div>
    </div>

    <script src="../../external/bootstrap/bootstrap.min.js"></script>
</body>

</html>