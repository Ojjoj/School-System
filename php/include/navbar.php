<?php
  if(isset($_GET['admin'])){
    session_start();
    $username=$_SESSION['username'];
    if($username === 'johndeo@gmail.com'){
      header("location:../admin/main_admin_profile.php");
      exit();
    }
    else{
      header("location:../admin/admin_profile.php");
      exit();
    }
  }
  if(isset($_GET['logout'])){ 
    // session_start(); // Start the session
    // session_unset(); // Unset all session variables
    // session_destroy(); // Destroy the session

  header("Location:../admin/login.php");
  exit();
    
  }
?>

<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="../../external/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../../external/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="../../external/fontawesome/css/fontawesome.min.css" rel="stylesheet">

    <style>
      body {
        padding-top: 70px;
      }

      .bi {
        vertical-align: -.125em;
        text-align: center;
        fill: currentColor;
        border-radius: 10px;
      }

      .nav-link:hover {
        background-color: black;
      }

      .nav-link {
        border-radius: 10px;
      }
      .logo{
        width: 76px;
        margin-left: -69px;
        margin-top: -10px;
      }
      .h1{
        font-size: 39px;
        margin-left: 19px !important;
        margin-top: 0 !important;
        margin-bottom: 0 !important;
        font-family: cursive;
      }
    </style>
    <!-- Custom styles for this template -->
  </head>

  <body>
    <header>
      <div class="px-3 py-2 text-bg-dark fixed-top">
        <div class="container">
          <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <div class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
              <!-- logo -->
               <img src="../../media/images/output-onlinepngtools.png" class="logo">
               <h1 class="h1">HORIZON</h1>
            </div>

            <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0">
              <li>
                <a href="../include/navbar.php?admin=true" class="nav-link text-white">
                  <i class="bi d-block mx-auto mb-1 fa-solid fa-user"></i>
                  Profile
                </a>
              </li>
              <li>
                <a href="../admin/login.php?logout=true" class="nav-link text-white">
                  <i class="bi d-block mx-auto mb-1 fa-solid fa-power-off"></i>
                  Logout
                </a>
              </li>
            </ul>
          </div>
        </div>
    </header>
  </body>
</html>