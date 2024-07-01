<?php
include_once '../include/admin_checkout.php';
include_once '../include/connect.php';

$alert1 = 'd-none';
$alert2 = 'd-none';
$fail = '';
$check_password = false;

if(isset($_POST['update'])){
    $username = $_SESSION['username'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
        
    $sql = "SELECT id, username, passwrd FROM admins WHERE username = ?";
    if($stmt = mysqli_prepare($connection, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $username);
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1){  
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                mysqli_stmt_fetch($stmt);
                if(password_verify($old_password, $hashed_password)) {
                    $check_password = true;
                } 
                else {
                    $alert2 = '';
                    $fail = 'Old password is incorrect. Please try again.';
                }       
            } 
            else{
                header("location:admin_profile1.php?error=usernamedoesn'texist");
                exit();
            }
        } 
        else{
            header("location:admin_profile1.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}

if($check_password){
    $hashed_password = password_hash($new_password, PASSWORD_ARGON2ID);
    $sql = "UPDATE admins set passwrd=? WHERE username=?";

    if($stmt = mysqli_prepare($connection, $sql)){
        mysqli_stmt_bind_param($stmt, "ss", $hashed_password,$username);
        if(mysqli_stmt_execute($stmt)){
            $alert1='';
        }
        else{
            $alert2 = '';
            $fail = 'Oops! Something went wrong. Please try again later.';
        }
    }   
}
?>


<!DOCTYPE html>
<head lang="en">
    <title>Admin Profile</title>
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
            Password updated successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>

          <div class="alert alert-danger alert-dismissible fade show <?php echo $alert2; ?>" role="alert" id="warning">
            <?php echo $fail; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        </div>

        <div class="content">
          <form action="" method="post" onsubmit="return check_passwords()">
            
            <div>
              <h2>Change Password</h2 >
              <hr>
            </div>

            <div class="mb-3">
              <label for="oldpassword" class="form-label">Current Password</label>
              <div class="password_field">
                <input type="password" class="form-control" name="old_password" id="old_password">
                <i class="fa-regular fa-eye password_icon" id="password_icon1" onclick="toggle_password('old_password','password_icon1')"></i>
              </div>
              <span id="old_password_error"></span>
            </div>

            <div class="mb-3">
              <label for="new_password" class="form-label">New Password</label>
              <div class="password_field">
                <input type="password" class="form-control" name="new_password" id="new_password">
                <i class="fa-regular fa-eye password_icon" id="password_icon2" onclick="toggle_password('new_password','password_icon2')"></i>
              </div>
              <span id="new_password_error"></span>
            </div>

            <div class="mb-3">
              <label for="confirm_password" class="form-label">Confirm Password</label>
              <div class="password_field">
                <input type="password" class="form-control" name="confirm_password" id="confirm_password">
                <i class="fa-regular fa-eye password_icon" id="password_icon3" onclick="toggle_password('confirm_password','password_icon3')"></i>
              </div>
              <span id="confirm_password_error"></span>
              <span id="matching_password_error"></span>
              <span><?php if(isset($password_error)) {echo $password_error;} ?></span>
            </div>

            <div id="align_button">
              <button type="submit" class="space btn btn-primary" name="update">Update</button>
              <button class="btn btn-danger" name="cancel"><a href="dashboard.php" class="cancel">Cancel</a></button>
            </div>
            <?php  ?>
            
          </form>
        </div>
      </div>
    </div>
  </div>
    
    <script src="../../external/bootstrap/bootstrap.min.js"></script>
    <script src="../../js/admin_profile.js"></script>
</body>