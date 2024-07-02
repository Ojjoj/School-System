<?php
include_once '../include/admin_checkout.php';
include_once '../include/connect.php';

if (isset($_GET['view'])) {
    $student_id = $_GET['view'];

    $sql = "SELECT * FROM student WHERE student_id = ?";
    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $student_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $student_id, $real_id, $first_name, $last_name, $gender, $date_of_birth, $country, $date_of_admission, $father_name, $father_phone, $father_email, $mother_name, $mother_phone, $mother_email, $diagnosis, $medication, $transportation, $bus_id, $other, $status);
        mysqli_stmt_fetch($stmt);

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($connection);
    }
} else {
    header("Location: student.php");
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
    <link href="../../css/view_student.css" rel="stylesheet">
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
                                <td><strong>Student ID</strong></td>
                                <td><?php echo $real_id ? $real_id : "<span class='text-danger'>Not available</span>"; ?></td>
                            </tr>
                            <tr>
                                <td><strong>First Name:</strong></td>
                                <td><?php echo $first_name ? $first_name : "<span class='text-danger'>Not available</span>"; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Last Name:</strong></td>
                                <td><?php echo $last_name ? $last_name : "<span class='text-danger'>Not available</span>"; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Gender:</strong></td>
                                <td><?php echo $gender ? $gender : "<span class='text-danger'>Not available</span>"; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Date of Birth:</strong></td>
                                <td><?php echo $date_of_birth ? $date_of_birth : "<span class='text-danger'>Not available</span>"; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Country:</strong></td>
                                <td><?php echo $country ? $country : "<span class='text-danger'>Not available</span>"; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Date of Admission:</strong></td>
                                <td><?php echo $date_of_admission ? $date_of_admission : "<span class='text-danger'>Not available</span>"; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td><?php echo $status ? $status : "<span class='text-danger'>Not available</span>"; ?></td>
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
                                <td><strong>Father Name:</strong></td>
                                <td><?php echo $father_name ? $father_name : "<span class='text-danger'>Not available</span>"; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Mother Name:</strong></td>
                                <td><?php echo $mother_name ? $mother_name : "<span class='text-danger'>Not available</span>"; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Father Phone:</strong></td>
                                <td><?php echo $father_phone ? $father_phone : "<span class='text-danger'>Not available</span>"; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Mother Phone:</strong></td>
                                <td><?php echo $mother_phone ? $mother_phone : "<span class='text-danger'>Not available</span>"; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Father Email:</strong></td>
                                <td><?php echo $father_email ? $father_email : "<span class='text-danger'>Not available</span>"; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Mother Email:</strong></td>
                                <td><?php echo $mother_email ? $mother_email : "<span class='text-danger'>Not available</span>"; ?></td>
                            </tr>
                        </table>

                    </div>
                </div>

                <div class="row me-3">
                    <div class="mb-3">
                        <h2>Transportation Information</h2>
                        <hr>
                        <table class="info-table">
                            <tr>
                                <td>
                                    <strong>Transportation:</strong>
                                </td>
                                <td>
                                    <?php echo $transportation ? $transportation : "Not available";
                                    if ($transportation == "school_bus") {
                                    ?>
                                        <p><strong>Bus: </strong><?php echo $bus_id ? $bus_id : "Not available" ?></p>
                                    <?php } ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row me-3">
                    <div class="mb-3">
                        <h2>Medical Information</h2>
                        <hr>
                        <table class="info-table">
                            <tr>
                                <td><strong>Diagnosis:</strong></td>
                                <td><?php echo $diagnosis ? $diagnosis : "<span class='text-danger'>Not available</span>"; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Medication:</strong></td>
                                <td><?php echo $medication ? $medication : "<span class='text-danger'>Not available</span>"; ?></td>
                            </tr>
                        </table>

                    </div>
                </div>

                <div class="row me-3">
                    <div class="mb-3">
                        <h2>Other Information</h2>
                        <hr>
                        <p class="info"><?php echo $other ? $other : "Not available"; ?></p>
                    </div>
                </div>
                <br>
                <center>
                    <a href="student.php" class="btn btn-primary">Back to Students List</a>
                </center>
                <br>
            </div>
        </div>
    </div>

    <script src="../../external/bootstrap/bootstrap.min.js"></script>
    <script src="../../js/edit_student.js"></script>
</body>

</html>