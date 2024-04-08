<?php
include_once '../include/connect.php';

// if(isset($_POST('delete_course'))){
//     if (isset($_GET['delete'])) {
//         $delete_id = $_GET['delete'];
//     $sql = "DELETE FROM course WHERE id = ?";
//     if ($stmt = mysqli_prepare($connection, $sql)) {
//         mysqli_stmt_bind_param($stmt, "s", $delete_id);
//         mysqli_stmt_execute($stmt);
//     }
// }

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
                                    <input type="hidden" id=<?php echo $data['course_id']?>>
                                    <h6><?php echo $data['course_name']?></h6>
                                    <div class="modification">
                                        <a href="edit_course.php?edit=<?php echo $data['course_id']; ?>" class="edit" title="Edit" name="edit" data-toggle="tooltip">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <a href="#" title="Delete" name="delete" data-toggle="tooltip" id="<?php echo $data['course_id']; ?>">
                                            <i class="fa-solid fa-circle-minus" id="delete_course"></i>                            
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

    <div data-bs-toggle="modal" data-bs-target="#my_modal" style="color:black">hsdfghyjuii</div>
        <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="my_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Course</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            Are you sure you want to delete this course?
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="text-end">
                            <form method="post">
                                <button type="button" class="btn btn-danger btn-sm rounded-0" name="delete_course" data-id="">Delete</button>
                                <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../external/bootstrap/bootstrap.js"></script>
    <script src="../../external/jquery/jquery-3.7.1.min.js"></script>
    <script src="../../js/course.js"></script>
    <script src="../../js/delete_course.js"></script>
</body>
</html>