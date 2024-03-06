<?php
include_once '../include/admin_checkout.php'; 

if($_SESSION['username'] !== 'johndeo@gmail.com'){
    header("location:admin_profile.php");
    exit();
}

//get the admin username
$username = $_SESSION['username'];
include_once '../include/connect.php';

// select data for the admin
$sql = "SELECT * FROM admins WHERE username = ?";
if ($stmt = mysqli_prepare($connection, $sql)) {
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt); // Get the result set
    $row = mysqli_fetch_assoc($result);
    $first_name = $row['first_name'];    
    $last_name = $row['last_name'];    
} 
else {
    echo "Error in preparing SQL statement: " . mysqli_error($connection);
}

$alert = 'd-none';
// update personal information
if(isset($_POST['update'])){
    $sql = "UPDATE admins set first_name=?, last_name=? WHERE username=?";
    if($stmt = mysqli_prepare($connection, $sql)){
        mysqli_stmt_bind_param($stmt, "sss", $_POST['first_name'], $_POST['last_name'],$username);
        if(mysqli_stmt_execute($stmt)){
            $first_name = $_POST['first_name'];    
            $last_name = $_POST['last_name']; 
            $alert = '';
        }
        else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
}   

// update the password
if(isset($_POST['update_password'])){
    $sql3 = "SELECT id, username, passwrd FROM admins WHERE username = ?";
    if($stmt = mysqli_prepare($connection, $sql3)){
        mysqli_stmt_bind_param($stmt, "s", $username);
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
            mysqli_stmt_fetch($stmt);
            if(password_verify($_POST['current_password'], $hashed_password)) {
                mysqli_stmt_free_result($stmt);
                $sql4 = "UPDATE admins set passwrd=? WHERE username=?";
                if($stmt2 = mysqli_prepare($connection, $sql4)){
                    $hashed_password = password_hash($_POST['new_password'], PASSWORD_ARGON2ID);
                    mysqli_stmt_bind_param($stmt2, "ss",$hashed_password, $username);
                    if(!mysqli_stmt_execute($stmt2)){
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    else{
                        $alert = '';
                    }
                }
            }
            else{
                $incorrect_password = "incorrect password";
            }
        }
    }
} 

// select the data for the whole admins
// $sql2 = "SELECT * FROM admins";
// $response = mysqli_query($connection, $sql2);

// delete admin
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    if($delete_id != 23){
        $sql = "DELETE FROM admins WHERE id = ?";
        if ($stmt = mysqli_prepare($connection, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $delete_id);
            mysqli_stmt_execute($stmt);
        }
        header('location:main_admin_profile.php');
    }
    
}

?>

<!DOCTYPE html>
<head lang="en">
    <title>Profile</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" href="../../external/bootstrap/bootstrap.min.css">
    <link rel="sylesheet"  href="../../external/fontawesome/css/all.min.css">
    <link rel="sylesheet"  href="../../external/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../../css/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
            <div class="container">
                <h1>Hello <?php echo $first_name. " " . $last_name;?></h1>

                <div class="alert alert-danger alert-dismissible fade show warning_msg" role="alert" id="warning" 
                <?php if(isset($incorrect_password)) echo"style='display:block';";?>>
                    <p id="warning_message"><?php if(isset($incorrect_password)) echo $incorrect_password; ?></p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

                <div class="alert alert-success alert-dismissible fade show <?php echo $alert; ?>" role="alert">
                personal information was updated successfully
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

                <div class="row">
                    <div class="col-lg-5 col-md-12 col-sm-12 ">
                        <div class="update_info">
                            <form method="post" onsubmit="return check_input()">
                                <fieldset>
                                    <legend>Personal Inforamtion</legend> 
                                    <input type="text" name="first_name" value="<?php echo isset($_POST['first_name']) ? $_POST['first_name'] : $first_name;?>" class="form-control" id="first_name">
                                    <input type="text" name="last_name" value="<?php echo isset($_POST['last_name']) ? $_POST['last_name'] : $last_name;?>"  class="form-control" id="last_name">
                                    <div class="button_position">
                                        <button name="update" class="btn btn-primary pos">Update</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-7 col-md-12 col-sm-12">
                        <div class="update_info">
                            <form method="post" onsubmit="return check_password()">
                                <fieldset>
                                    <legend>Change Password</legend>
                                    <input type="text" name="current_password" placeholder="Current Password" class="form-control" id="current_password">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="text" name="new_password" placeholder="New Password" class="form-control" id="new_password">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="confirm_password" placeholder="Confirm Password" class="form-control" id="confirm_password">
                                        </div>
                                    </div>
                                    <div class="button_position">
                                        <button name="update_password" class="btn btn-primary pos">Update</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row separator">
                    <div class="col-sm-9">
                        <h2>Admins Information</h2>
                    </div>
                    <form method="post" class="col-sm-3">
                        <div class="search-box search">
                            <button type="submit" class="search_button" name="search"><i class="fa-solid fa-magnifying-glass"></i></button>
                            <input type="text" class="form-control search_input" placeholder="Search&hellip;" name="search_text">
                        </div>
                    </form>
                </div>
                <?php
                // select admins by search
                $sql5 = "SELECT * FROM admins";
                if(isset($_POST['search'])){
                    $search_text = $_POST['search_text'];
                    $sql5 = "SELECT * FROM admins WHERE id = ? OR username=? OR first_name=? OR last_name=?";
                }
                if($stmt = mysqli_prepare($connection, $sql5)){
                    if(isset($_POST['search'])){
                        mysqli_stmt_bind_param($stmt, "ssss", $search_text, $search_text, $search_text, $search_text);
                    }
                    if(mysqli_stmt_execute($stmt)){
                        $result = mysqli_stmt_get_result($stmt);
                        if (mysqli_num_rows($result) > 0) { ?>
                            <table class="table table-bordered table-striped table-hover"> 
                            <thead>
                                <tr>
                                    <th scope="col" width="4%">#</th>
                                    <th scope="col">First Name</th>
                                    <th scope="col">Last Name</th>
                                    <th scope="col">Username</th>                
                                    <th scope="col" width="10%">Actions</th>                
                                </tr>
                            </thead>
                            <tbody>
                        <?php
                            while($data = mysqli_fetch_array($result)){
                                echo '<tr>
                                    <td>' . $data["id"] . '</td>
                                    <td>' . $data["first_name"] . '</td>
                                    <td>' . $data["last_name"] . '</td>
                                    <td>' . $data["username"] . '</td>'. 
                                    '<td>
                                    <a href="edit_admin.php?edit='.$data["id"].'" title="Edit" data-toggle="tooltip"><i class="fa-solid fa-pencil edit"></i></a>
                                    <a href="main_admin_profile.php?delete='.$data["id"].'" title="Delete" data-toggle="tooltip" onclick="return confirm(\'Are you sure you want to delete this admin?\');"><i class="fa-solid fa-trash delete"></i></a>
                                    </td>
                                </tr>';
                                
                            };
                        }
                        else{
                            echo '<div class="no_data">Data Not Found</div>';
                        }
                    }
                }
                ?>
                    </tbody>
                </table>
            </div>
            <div class="add_admin">
        <button type="submit" name="add_admin" class="btn btn-primary"><a href="add_admin.php" class="add_link"> Add Admin</a></button>
    </div>
        </div>
    
    <script src="../../external/bootstrap/bootstrap.min.js"></script>
    <script src="../../js/prof.js"></script>
</body>