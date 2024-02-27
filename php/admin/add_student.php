<?php
include_once '../include/admin_checkout.php'; 

include_once '../include/connect.php';
session_start();

$alert = 'd-none';
if (isset($_POST['submit'])) {
    $sql = "INSERT INTO `student` (`first_name`, `last_name`, `gender`, `date_of_birth`, `country`, `date_of_admission`, `father_name`, `father_phone`, `father_email`, `mother_name`, `mother_phone`, `mother_email`, `transportation`, `bus_id`, `diagnosis`, `medication`, `other`, `status`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sssssssssssssissss', $first_name, $last_name, $gender, $date_of_birth, $country, $date_of_admission, $father_name, $father_phone, $father_email, $mother_name, $mother_phone, $mother_email, $transportation, $bus, $diagnosis, $medication, $other, $status);

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $gender = $_POST['gender'];
        $date_of_birth = $_POST['date_of_birth'];
        $country = $_POST['country'];
        $date_of_admission = isset($_POST['date_of_admission']) ? $_POST['date_of_admission'] : null;

        $father_name = isset($_POST['father_name']) ? $_POST['father_name'] : null;
        $father_phone = isset($_POST['father_phone']) ? $_POST['father_phone'] : null;
        $father_email = isset($_POST['father_email']) ? $_POST['father_email'] : null;
        $mother_name = isset($_POST['mother_name']) ? $_POST['mother_name'] : null;
        $mother_phone = isset($_POST['mother_phone']) ? $_POST['mother_phone'] : null;
        $mother_email = isset($_POST['mother_email']) ? $_POST['mother_email'] : null;

        $transportation = $_POST['transportation'];
        $bus = isset($_POST['bus']) ? $_POST['bus'] : null;

        $diagnosis = $_POST['diagnosis'];
        $medication = isset($_POST['medication']) ? $_POST['medication'] : null;

        $other = isset($_POST['other']) ? $_POST['other'] : null;
        $status = "Active";

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

    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add student</title>
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
            <form action="" method="POST">
                <div class="container mt-3">
                    <div class="row me-3">
                        <div class="alert alert-success alert-dismissible fade show <?php echo $alert; ?>" role="alert">
                            Student was added successfully
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="mb-3">
                            <h2>General Information</h2>
                            <hr>
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>

                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>

                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select" id="gender" name="gender">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="date_of_birth" class="form-label">Date of birth</label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="country" class="form-label">Country</label>
                                    <select class="form-select" id="country" name="country" required>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="date_of_admission" class="form-label">Date of Admission</label>
                                    <input type="text" class="form-control" id="date_of_admission" name="date_of_admission">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row me-3">
                        <div class="mb-6">
                            <h2>Contact Information</h2>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="father_name" class="form-label">Father Name</label>
                                    <input type="text" class="form-control" id="father_name" name="father_name">
                                </div>
                                <div class="col-md-6">
                                    <label for="mother_name" class="form-label">Mother Name</label>
                                    <input type="text" class="form-control" id="mother_name" name="mother_name">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="father_phone" class="form-label">Father Phone</label>
                                    <input type="text" class="form-control" id="father_phone" name="father_phone">
                                </div>
                                <div class="col-md-6">
                                    <label for="mother_phone" class="form-label">Mother Phone</label>
                                    <input type="text" class="form-control" id="mother_phone" name="mother_phone">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="father_email" class="form-label">Father Email</label>
                                    <input type="text" class="form-control" id="father_email" name="father_email">
                                </div>
                                <div class="col-md-6">
                                    <label for="mother_email" class="form-label">Mother Email</label>
                                    <input type="text" class="form-control" id="mother_email" name="mother_email">
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="row me-3">
                        <div class="mb-6">
                            <h2>Transportation Information</h2>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Transportation</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="own_transportation" value="own_transportation" name="transportation" onclick="handleTransportationChange()" checked>
                                        <label class="form-check-label" for="own_transportation">Own transportation</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="school_bus" value="school_bus" name="transportation" onclick="handleTransportationChange()">
                                        <label class="form-check-label" for="school_bus">School Bus</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Choose Bus</label>
                                    <select class="form-select" id="bus" name="bus" disabled>
                                        <option value="1">Select Bus</option>
                                    </select>
                                </div>
                            </div>
                            <br>

                        </div>
                    </div>
                    <div class="row me-3">
                        <div class="mb-6">
                            <h2>Medical Information</h2>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="diagnosis" class="form-label">Diagnosis</label>
                                        <textarea class="form-control" id="diagnosis" name="diagnosis" rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="medication" class="form-label">Medication</label>
                                        <textarea class="form-control" id="medication" name="medication" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row me-3">
                        <div class="mb-6">
                            <h2>Other Information</h2>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="other" class="form-label">More Information</label>
                                        <textarea class="form-control" id="other" name="other" rows="6"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <center>
                        <button type="submit" class="btn btn-primary" name="submit">Add student</button>
                        <a href="student.php" class="btn btn-danger" name="submit">Cancel</a>
                    </center>
                    <br>
                </div>
            </form>
        </div>
    </div>

    <script src="../../external/bootstrap/bootstrap.min.js"></script>
    <script src="../../js/add_student.js"></script>
    <script>
        populateCountrySelect();
    </script>
</body>

</html>