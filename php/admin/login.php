<?php
if(isset($_POST['submit'])){
    include_once '../include/connect.php';

    $username = strtolower($_POST['username']);
    $password = $_POST['password'];
    $sql = "SELECT id, username, passwrd FROM users WHERE username = ?";
    if($stmt = mysqli_prepare($connection, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $username);
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1){
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                if(mysqli_stmt_fetch($stmt)){
                    if(password_verify($password, $hashed_password)){
                        session_start();
                        $_SESSION["username"] = $username;                         
                        header("location:dashboard.php");
                    } 
                    else{
                        $login_error = "Invalid username or password";
                    }
                }
            } 
            else{
                $login_error = "Invalid username or password.";
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<head lang="en">
    <title>Sing In</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="../../external/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/logina.css">
</head>
<body>
    <div class="container">
      <form action="" method="post" onsubmit="return checkInputs()">
        
        <div>
          <h2>Sign In</h2 >
          <hr>
        </div>

        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" name="username" id="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
          <span id="username_error"></span>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="password"  value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>">
          <span id="password_error"></span>
          <div class="center"><span><?php if(isset($login_error)) echo $login_error; ?></span></div>
        </div>

        <div>
          <button type="submit" name="submit" class="btn btn-primary pos">Submit</button>
        </div>
        
      </form>
    </div>

    <script src="../../js/login.js"></script>  
</body>
</html>

