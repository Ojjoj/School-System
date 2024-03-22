  <?php
include_once '../include/admin_checkout.php'; 

if(isset($_POST['add'])){
    include_once '../include/connect.php';

    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];  
    $username   = strtolower($_POST['username']);
    $password   = $_POST['password'];
      

    $result = false;
    $sql = "SELECT * FROM admins WHERE username=?;";
    $stmt = mysqli_stmt_init($connection);
    if(mysqli_stmt_prepare($stmt,$sql)){
        mysqli_stmt_bind_param($stmt,"s",$username);
        mysqli_stmt_execute($stmt);
        $result_data = mysqli_stmt_get_result($stmt);
        if(mysqli_fetch_assoc($result_data)){
            $result=true;
            header("location:add_admin.php?error=alreadyexist");
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
      }
          
      else{
        header("location:add_admin.php?error=stmtfailed");
        exit();
      }
  
      
      mysqli_stmt_close($stmt);
      header("location:main_admin_profile.php?error=none");
      exit();
    }
}

?>
<!DOCTYPE html>
<head lang="en">
    <title>Add Admin</title>
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
          <h2>Add Admin</h2 >
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

        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" class="form-control" name="username" id="username">
          <span id="username_error"></span>
          <span>
            <?php 
            if(isset($_GET['error'])){
              if($_GET['error']=='alreadyexist'){
                echo "a username already exists";
              }
            } ?>
            </span>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="password">
          <span id="password_error"></span>
        </div>

        <div>
          <button type="submit" class="btn btn-primary pos" name="add">Add</button>
        </div>
      </form>
    </div>

    <script src="../../js/add_admin.js"></script>
</body>