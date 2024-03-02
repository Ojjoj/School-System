<?php
include_once '../include/admin_checkout.php'; 

if(isset($_POST['edit'])){
    include_once '../include/connect.php';

    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];

    $sql = "UPDATE admins SET first_name=?, last_name=? WHERE id=?;";
    $stmt = mysqli_stmt_init($connection);
    if(mysqli_stmt_prepare($stmt,$sql)){
        mysqli_stmt_bind_param($stmt,"sss",$_POST['first_name'],$_POST['last_name'],$_GET['edit']);
        mysqli_stmt_execute($stmt);
        $result_data = mysqli_stmt_get_result($stmt);
        header("location:main_admin_profile.php");
    }
    else{
        header("location:main_admin_profile.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_close($stmt);

}

?>
<!DOCTYPE html>
<head lang="en">
    <title>edit admin</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="../../external/bootstrap/bootstrap.min.css" >
    <link rel="sylesheet"  href="../../external/fontawesome/css/all.min.css">
    <link rel="sylesheet"  href="../../external/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../../css/logina.css">
</head>
<body>
    <div class="container">
      <form action="" method="post" onsubmit="return checkInputs()">

        <div>
          <h2>Edit Admin</h2 >
          <hr>
        </div>

        <div class="mb-3">
          <label class="form-label">First Name</label>
          <input type="text" class="form-control" name="first_name" id="first_name">
          <span id="first_name_error"></span>
        </div>

        <div class="mb-3">
          <label class="form-label">Last Name</label>
          <input type="text" class="form-control" name="last_name" id="last_name">
          <span id="last_name_error"></span>
        </div>

        <div>
          <button type="submit" class="btn btn-primary pos" name="edit">Edit</button>
        </div>
      </form>
    </div>

    <script src="../../js/edit_admin.js"></script>
</body>