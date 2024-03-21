<?php
include_once '../include/connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Course</title>
    <link rel="stylesheet" href="../../external/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../external/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../external/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../../css/course.css">
</head>


<?php
include '../include/navbar.php';
?>

<body>
    <div class="row">
        <div class="col-md-2 d-md-block d-non">
            <?php include '../include/sidebar.php'; ?>
        </div>

        <div class="col-md-10 content">
            <div>
                <div class="row" id="title">
                    <div class="col-sm-3">
                        <h2><b>Courses</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <form id="searchForm" action="" method="GET">
                            <div class="search-box">
                                <i class="fa-solid fa-magnifying-glass" onclick="submit_form()"></i>
                                <input type="text" class="form-control" name="search" placeholder="Search&hellip;">
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-select" id="select_year">
                            <option value="0">ALL</option>
                            <option value="1">2022-2023</option>
                            <option value="2">2023-2024</option>
                        </select>
                    </div>
                </div>
            </div>
            

            <div class="row" id="courses">
                <?php
                $sql = "SELECT course.*, teacher.* FROM course INNER JOIN teacher ON course.teacher_id=teacher.teacher_id ";

                if(isset($_GET['search'])){
                    $search_query = mysqli_real_escape_string($connection, $_GET['search']);
                    $sql.="WHERE course_id LIKE '%$search_query%' OR course_name LIKE '%$search_query%' OR first_name LIKE '%$search_query%' OR last_name LIKE '%$search_query%'";
                }

                if($stmt = mysqli_prepare($connection, $sql)){
                    if(mysqli_stmt_execute($stmt)){
                        $result = mysqli_stmt_get_result($stmt);
                        if (mysqli_num_rows($result) > 0) {
                            while($data = mysqli_fetch_array($result)){
                ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 ">
                    <a href="view_course.php">
                        <div class="course">
                            <div class="card" style="height: 250px;">
                                <img src="<?php echo $data['image_path']?>" alt="image not found" class="img-fluid">
                            </div>
                            <div class="course_info">
                                <div class="course_name">
                                    <h6><?php echo $data['course_name']?></h6>
                                    <div class="modification">
                                        <a href="edit_course.php" class="edit" title="Edit" name="edit" data-toggle="tooltip">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <a href="course.php" class="delet" title="Delete" name="delete" data-toggle="tooltip">
                                            <i class="fa-solid fa-circle-minus"></i>                            
                                        </a>
                                    </div>
                                </div>
                                <div class="course_teacher">
                                    <p><?php echo $data['first_name'].' '.$data['last_name']; ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
                            }}}}
                            mysqli_stmt_close($stmt);

                ?> 
                
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 ">
                    <a href="add_course.php">
                        <div class="course">
                            <div class="card" style="height: 250px;" id="add_course">
                                <div class="add_course">
                                        <i class="fa-solid fa-plus"></i><span>New</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script src="../../js/course.js"></script>
</body>
</html>