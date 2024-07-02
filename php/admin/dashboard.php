<?php
include_once '../include/admin_checkout.php';
include_once '../include/connect.php';

// fetch all data
$arr = [];
$sql = "SELECT * FROM `event`";
if ($stmt = mysqli_prepare($connection, $sql)) {
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            foreach ($rows as $row) {
                $row['sdate'] = date("F d, Y h:i A", strtotime($row['start_datetime']));
                $row['edate'] = date("F d, Y h:i A", strtotime($row['end_datetime']));
                $arr[$row['event_id']] = $row;
            }
        }
    }
} else {
    die("Failed to prepare SQL statement: " . mysqli_error($conn));
}

// save an event
if (isset($_POST['save'])) {
    extract($_POST);
    if (empty($_POST['id'])) {
        $sql = "INSERT INTO `event` (title, `description`, start_datetime, end_datetime) VALUES (?,?,?,?);";
        $stmt = mysqli_stmt_init($connection);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssss", $title, $description, $start_datetime, $end_datetime);
            mysqli_stmt_execute($stmt);
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        } else {
            header("location:dashboard.php?error=stmtfailed");
            exit();
        }
    } else {
        $sql = "UPDATE `event` SET title=?, `description`=?, start_datetime=?, end_datetime=? WHERE event_id=?";
        if ($stmt = mysqli_prepare($connection, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssssi", $title, $description, $start_datetime, $end_datetime, $id);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    }
}

// delete an event
if (isset($_GET['id'])) {
    $sql = 'DELETE FROM `event` where event_id = ?';
    if ($stmt = mysqli_prepare($connection, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $_GET['id']);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: dashboard.php?");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event</title>
    <link rel="stylesheet" href="../../external/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../external/calendar/main.min.css">
    <style>
        html,
        body {
            height: 100%;
            width: 100%;
        }

        .padding {
            padding: 10px;
        }

        table,
        tbody,
        td,
        tfoot,
        th,
        thead,
        tr {
            border-color: #ededed !important;
            border-style: solid;
            border-width: 1px !important;
        }

        ::-webkit-scrollbar {
            width: 0;
        }
    </style>
</head>
<?php include '../include/navbar.php'; ?>

<body class="bg-light">
    <div class="row">
        <div class="col-md-2 col-sm-0">
            <?php include '../include/sidebar.php'; ?>
        </div>
        <div class="col-md-10 col-sm-12">
            <div class="container py-5" id="page_container">
                <div class="row">
                    <div class="col-md-9">
                        <div id="calendar"></div>
                    </div>

                    <div class="col-md-3">
                        <div class="shadow">
                            <div class="bg-primary text-light bg-gradient padding">
                                <h4 class="text-center">Event form</h4>
                            </div>
                            <div class="padding">
                                <div class="container-fluid">
                                    <form method="post" id="event_form">
                                        <input type="hidden" name="id" value="">
                                        <div class="mb-2">
                                            <label for="title" class="control-label">Title</label>
                                            <input type="text" class="form-control form-control-sm rounded-0" name="title" id="title" required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="description" class="control-label">Description</label>
                                            <textarea rows="3" class="form-control form-control-sm rounded-0" name="description" id="description" required></textarea>
                                        </div>
                                        <div class="mb-2">
                                            <label for="start_datetime" class="control-label">Start</label>
                                            <input type="datetime-local" class="form-control form-control-sm rounded-0" name="start_datetime" id="start_datetime" required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="end_datetime" class="control-label">End</label>
                                            <input type="datetime-local" class="form-control form-control-sm rounded-0" name="end_datetime" id="end_datetime" required>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="padding">
                                <div class="text-center">
                                    <button class="btn btn-primary btn-sm rounded-0" name="save" type="submit" form="event_form"><i class="fa fa-save"></i> Save</button>
                                    <button class="btn btn-default border btn-sm rounded-0" type="reset" form="event_form"><i class="fa fa-reset"></i> Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Popup Model for events -->
            <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event_modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Event Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <dl>
                                    <dt>Title</dt>
                                    <dd id="title" class="text-muted"></dd>
                                    <dt>Description</dt>
                                    <dd id="description" class="text-muted"></dd>
                                    <dt>Start</dt>
                                    <dd id="start_date" class="text-muted"></dd>
                                    <dt>End</dt>
                                    <dd id="end_date" class="text-muted"></dd>
                                </dl>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="text-end">
                                <button type="button" class="btn btn-primary btn-sm rounded-0" id="edit_event" data-id="">Edit</button>
                                <button type="button" class="btn btn-danger btn-sm rounded-0" id="delete_event" data-id="">Delete</button>
                                <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="../../external/jquery/jquery-3.7.1.min.js"></script>
    <script src="../../external/bootstrap/bootstrap.js"></script>
    <script src="../../external/calendar/main.min.js"></script>
    <script src="../../external/calendar/index.global.js"></script>
    <script src="../../js/event.js"></script>
    <script>
        // convert to json string
        let event_object = $.parseJSON('<?= json_encode($arr) ?>');
    </script>

</body>

</html>


<!-- Array ( [1] => Array ( [event_id] => 1 [title] => Sample 101 [description] => This is a sample schedule only. [start_datetime] => 2022-01-10 10:30:00 [end_datetime] => 2022-01-11 18:00:00 [sdate] => January 10, 2022 10:30 AM [edate] => January 11, 2022 06:00 PM ) 
             [2] => Array ( [event_id] => 2 [title] => Sample 102 [description] => Sample Description 102 [start_datetime] => 2022-01-08 09:30:00 [end_datetime] => 2022-01-08 11:30:00 [sdate] => January 08, 2022 09:30 AM [edate] => January 08, 2022 11:30 AM ) 
             [4] => Array ( [event_id] => 4 [title] => Sample 102 [description] => Sample Description [start_datetime] => 2022-01-12 14:00:00 [end_datetime] => 2022-01-12 17:00:00 [sdate] => January 12, 2022 02:00 PM [edate] => January 12, 2022 05:00 PM ) ) -->