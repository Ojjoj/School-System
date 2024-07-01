<?php
include_once '../include/connect.php';
session_start();

$alert = isset($_GET['added']) ? '' : 'd-none';
$alert2 = isset($_GET['assistant_updated']) ? '' : 'd-none';

if (isset($_POST['edit_assistant']) && isset($_GET['edit'])) {
    $assistant_id = $_GET["edit"];
    $new_first_name = $_POST['first_name'];
    $new_last_name = $_POST['last_name'];
    $new_email = $_POST['email'];

    $sql = "UPDATE assistant SET first_name = ?, last_name = ?, email = ? WHERE assistant_id = ?";
    $stmt_update_assistant = mysqli_prepare($connection, $sql);
    if ($stmt_update_assistant) {
        mysqli_stmt_bind_param($stmt_update_assistant, 'sssi', $new_first_name, $new_last_name, $new_email, $assistant_id);
        $success_update_assistant = mysqli_stmt_execute($stmt_update_assistant);
        if ($success_update_assistant) {
            header("Location: edit_assistant.php?edit=$assistant_id&assistant_updated=true");
            exit;
        } else {
            echo "Error updating assistant";
        }
    } else {
        echo "Error preparing statement: " . mysqli_error($connection);
    }
}

if (isset($_GET["edit"])) {
    $assistant_id = $_GET["edit"];
    $sql = "SELECT assistant_id, first_name, last_name, email FROM assistant WHERE assistant_id = ?";
    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $assistant_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_bind_result($stmt, $assistant_id, $first_name, $last_name, $email);
        $row = mysqli_fetch_assoc($result);
        $assistant_id = $row["assistant_id"];
        $first_name = $row["first_name"];
        $last_name = $row["last_name"];
        $email = $row["email"];
    } else {
        echo "Error preparing statement: " . mysqli_error($connection);
    }

    // $sql_teacher_assistant = "SELECT t.teacher_id, t.first_name, t.last_name FROM teacher t INNER JOIN teacher_assistant ta ON t.teacher_id = ta.teacher_id WHERE ta.assistant_id = ?";
    $sql_teacher_assistant = "SELECT t.teacher_id, t.first_name, t.last_name FROM assistant a, course_assistants ca, course c, teacher t WHERE t.teacher_id = c.teacher_id AND c.course_id = ca.course_id AND ca.assistant_id = a.assistant_id AND a.assistant_id = ?";
    $stmt_teacher_assistant = mysqli_prepare($connection, $sql_teacher_assistant);
    if ($stmt_teacher_assistant) {
        mysqli_stmt_bind_param($stmt_teacher_assistant, 'i', $assistant_id);
        mysqli_stmt_execute($stmt_teacher_assistant);
        $result_teacher_assistant = mysqli_stmt_get_result($stmt_teacher_assistant);
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
    <title>Edit Assistant</title>
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
            <div class="container mt-3">
                <div class="table-wrapper">
                    <div class="alert alert-success alert-dismissible fade show <?php echo $alert2; ?>" role="alert">
                        Assistant was edited successfully
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <form action="" method="POST">
                        <div class="table-title">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5><b>First Name</b></h5>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $first_name; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <h5><b>Last Name</b></h5>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $last_name; ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <br>
                                    <h5><b>Email</b></h5>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                                </div>
                            </div>
                        </div>
                        <center>
                            <br>
                            <button type="submit" class="btn btn-primary" name="edit_assistant">Edit Assistant</button>
                            <a href="add_assistant.php" class="btn btn-danger">Cancel</a>
                        </center>
                    </form>
                    <hr>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-title">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h2><b>Teachers Assisted</b></h2>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result_teacher_assistant)) {
                                        $teacher_id = $row['teacher_id'];
                                        $first_name = $row['first_name'];
                                        $last_name = $row['last_name'];
                                        echo "<tr>";
                                        echo "<td>$teacher_id</td>";
                                        echo "<td>$first_name</td>";
                                        echo "<td>$last_name</td>";
                                        echo "<td class='delete-td'>";
                                        echo '   <a href="edit_assistant.php?edit=' . $assistant_id . '&delete=' . $teacher_id . '" class="delete" title="Delete" name="delete" data-toggle="tooltip" onclick="return confirm(\'Delete this student?\');"><i class="fa-solid fa-trash"></i></a>';
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <form action="" method="POST" onsubmit="return validateForm()">
                                <div class="container mt-3">
                                    <div class="row me-3">
                                        <div class="alert alert-success alert-dismissible fade show <?php echo $alert; ?>" role="alert">
                                            Teacher was added successfully
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        <div class="mb-3">
                                            <center>
                                                <h2>Add Teacher</h2>
                                            </center>
                                            <hr>
                                            <select class="form-select" name="student_id" id="student_id">
                                                <option value="" selected>Select a teacher</option>
                                                <?php
                                                $sql_select_teachers =
                                                    "SELECT teacher_id, first_name, last_name 
                                                    FROM teacher    
                                                    WHERE teacher_id NOT IN (
                                                        SELECT t.teacher_id 
                                                        FROM assistant a, course_assistants ca, course c, teacher t 
                                                        WHERE t.teacher_id = c.teacher_id 
                                                            AND c.course_id = ca.course_id 
                                                            AND ca.assistant_id = a.assistant_id 
                                                            AND a.assistant_id = ?)";
                                                $stmt_select_teachers = mysqli_prepare($connection, $sql_select_teachers);
                                                if ($stmt_select_teachers) {
                                                    mysqli_stmt_bind_param($stmt_teacher_assistant, 'i', $assistant_id);
                                                    mysqli_stmt_execute($stmt_select_teachers);
                                                    $result_select_teachers = mysqli_stmt_get_result($stmt_select_teachers);
                                                    while ($row_select_teachers = mysqli_fetch_assoc($result_select_teachers)) {
                                                        $teacher_id = $row_select_teachers['teacher_id'];
                                                        $first_name = $row_select_teachers['first_name'];
                                                        $last_name = $row_select_teachers['last_name'];
                                                        echo "<option value='$teacher_id'>$first_name $last_name</option>";
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
                                    <button type="submit" class="btn btn-primary" name="submit">Add Teacher</button>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>
    <script src="../../external/bootstrap/bootstrap.min.js"></script>
    <script src="../../js/edit_assistant.js"></script>
</body>

</html>