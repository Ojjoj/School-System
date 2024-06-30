  <?php
include_once '../include/admin_checkout.php'; 

$alert1 = 'd-none';
$alert2 = 'd-none';
$result = true;


if(isset($_POST['add'])){
    include_once '../include/connect.php';

    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];  
    $username   = strtolower($_POST['username']);
    $password   = $_POST['password'];
      

    $sql = "SELECT * FROM admins WHERE username=?;";
    $stmt = mysqli_stmt_init($connection);
    if(mysqli_stmt_prepare($stmt,$sql)){
        mysqli_stmt_bind_param($stmt,"s",$username);
        mysqli_stmt_execute($stmt);
        $result_data = mysqli_stmt_get_result($stmt);
        if(mysqli_fetch_assoc($result_data)){
            $alert2 = '';
        }
        else{
            $result=false; 
        }   
    }
    else{
        header("location:add_admin.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_close($stmt);

    if(!$result){
      $sql = "INSERT INTO admins (first_name, last_name, username, passwrd) VALUES (?,?,?,?);";
      $stmt = mysqli_stmt_init($connection);
      if(mysqli_stmt_prepare($stmt,$sql)){
        $hashed_password = password_hash($password, PASSWORD_ARGON2ID);
        mysqli_stmt_bind_param($stmt,"ssss",$first_name, $last_name, $username, $hashed_password);
        mysqli_stmt_execute($stmt);
        $alert1 = '';
      }   
      else{
        header("location:add_admin.php?error=stmtfailed");
        exit();
      }      
    }
}

?>
<!DOCTYPE html>
<head lang="en">
    <title>Add Admin</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="../../external/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../external/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../external/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../../css/admin.css">
</head>
<?php
    include '../include/navbar.php';
?>
<body class="body">
  <div class="row">
    <div class="col-md-2">
        <?php  include '../include/sidebar.php';?>
    </div>
    <div class="col-md-10">
      <div class="container">

        <div class="success">
          <div class="alert alert-success alert-dismissible fade show <?php echo $alert1; ?>" role="alert">
            Admin added successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>

          <div class="alert alert-danger alert-dismissible fade show <?php echo $alert2; ?>" role="alert" id="warning">
            Username already exists!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        </div>
      
        <div class="content">
          <form action="" method="post" onsubmit="return checkInputs()">

            <div><h2>Add Admin</h2 ><hr></div>

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

            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" class="form-control" name="username" id="username">
              <span id="username_error"></span>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <div class="password_field">
                <input type="password" class="form-control" name="password" id="password">
                <i class="fa-regular fa-eye" id="password_icon" onclick="toggle_password('password','password_icon')"></i>
              </div>
              <span id="password_error"></span>
            </div>

            <div id="align_button">
              <button type="submit" class="space btn btn-primary" name="add">Add</button>
              <button class="btn btn-danger" name="cancel"><a href="main_admin_profile.php" class="cancel">Cancel</a></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="../../external/bootstrap/bootstrap.min.js"></script>
  <script src="../../js/add_admin.js"></script>
</body>