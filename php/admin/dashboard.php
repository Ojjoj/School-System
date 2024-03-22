<?php
include_once '../include/admin_checkout.php';

include '../include/navbar.php';
include '../include/sidebar.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

</head>
<?php
include '../include/navbar.php';
?>

<body>
    <div class="row">
        <div class="col-md-2 col-sm-0">
            <?php include '../include/sidebar.php'; ?>
        </div>
        <div class="col-md-10 col-sm-12">
            <?php include 'event.php'; ?>
        </div>
    </div>

    <script src="../../external/bootstrap/bootstrap.min.js"></script>
</body>

</html>