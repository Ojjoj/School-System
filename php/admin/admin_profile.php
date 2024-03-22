<?php
include_once '../include/admin_checkout.php';

if($_SESSION['username'] === 'johndeo@gmail.com'){
  header("location:dashboard.php");
  exit();
} 

$check_password = false;

if(isset($_POST['update'])){
    include_once '../include/connect.php';

    $username = $_SESSION['username'];
    echo $username;
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    $check_password = false;

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
                    $password_error = "invalid password";
                    include('admin_profile.php'); 
                }       
            } 
            else{
                $password_error = $username;
                include('admin_profile.php'); 
            }
        } 
        else{
            echo "Oops! Something went wrong. Please try again later.";
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
            $password_error = "password updated";
            include('admin_profile.php'); 
        }
        else{
            echo "Oops! Something went wrong. Please try again later.";
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
    <link rel="stylesheet" href="../../css/login.css">
</head>
<body>
    <div class="container">
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

        <div>
          <button type="submit" name="update" class="btn btn-primary pos">Update</button>
        </div>
        
      </form>
    </div>
    
    <script src="../../external/bootstrap/bootstrap.min.js"></script>
    <script src="../../js/admin_profile.js"></script>
</body>