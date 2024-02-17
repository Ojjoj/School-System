<?php
include '../include/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Simple Data Table</title>
    <link href="../../external/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../../external/fontawesome/css/all.min.css" rel="sylesheet">
    <link href="../../external/fontawesome/css/fontawesome.min.css" rel="sylesheet">
    <link href="../../css/student.css" rel="stylesheet">
    <style>
    </style>
</head>

<body>
    <div class="row">
        <div class="col-md-3">
            <?php include '../include/sidebar.php'; ?>
        </div>
        <div class="col-md-9">
            <div class="table-responsive">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-8">
                                <h2><b>Students</b></h2>
                            </div>
                            <div class="col-sm-4">
                                <div class="search-box">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <input type="text" class="form-control" placeholder="Search&hellip;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name <i class="fa fa-sort"></i></th>
                                <th>Last Name</th>
                                <th>Age <i class="fa fa-sort"></i></th>
                                <th>Gender</th>
                                <th>Country <i class="fa fa-sort"></i></th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Thomas Hardy</td>
                                <td>89 Chiaroscuro Rd.</td>
                                <td>Portland</td>
                                <td>97219</td>
                                <td>USA</td>
                                <td>
                                    <a href="#" class="view" title="View" data-toggle="tooltip"><i class="fa-solid fa-eye"></i></a>
                                    <a href="#" class="edit" title="Edit" data-toggle="tooltip"><i class="fa-solid fa-pencil"></i></a>
                                    <a href="#" class="delete" title="Delete" data-toggle="tooltip"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Maria Anders</td>
                                <td>Obere Str. 57</td>
                                <td>Berlin</td>
                                <td>12209</td>
                                <td>Germany</td>
                                <td>
                                    <a href="#" class="view" title="View" data-toggle="tooltip"><i class="fa-solid fa-eye"></i></a>
                                    <a href="#" class="edit" title="Edit" data-toggle="tooltip"><i class="fa-solid fa-pencil"></i></a>
                                    <a href="#" class="delete" title="Delete" data-toggle="tooltip"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Fran Wilson</td>
                                <td>C/ Araquil, 67</td>
                                <td>Madrid</td>
                                <td>28023</td>
                                <td>Spain</td>
                                <td>
                                    <a href="#" class="view" title="View" data-toggle="tooltip"><i class="fa-solid fa-eye"></i></a>
                                    <a href="#" class="edit" title="Edit" data-toggle="tooltip"><i class="fa-solid fa-pencil"></i></a>
                                    <a href="#" class="delete" title="Delete" data-toggle="tooltip"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Dominique Perrier</td>
                                <td>25, rue Lauriston</td>
                                <td>Paris</td>
                                <td>75016</td>
                                <td>France</td>
                                <td>
                                    <a href="#" class="view" title="View" data-toggle="tooltip"><i class="fa-solid fa-eye"></i></a>
                                    <a href="#" class="edit" title="Edit" data-toggle="tooltip"><i class="fa-solid fa-pencil"></i></a>
                                    <a href="#" class="delete" title="Delete" data-toggle="tooltip"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Martin Blank</td>
                                <td>Via Monte Bianco 34</td>
                                <td>Turin</td>
                                <td>10100</td>
                                <td>Italy</td>
                                <td>
                                    <a href="#" class="view" title="View" data-toggle="tooltip"><i class="fa-solid fa-eye"></i></a>
                                    <a href="#" class="edit" title="Edit" data-toggle="tooltip"><i class="fa-solid fa-pencil"></i></a>
                                    <a href="#" class="delete" title="Delete" data-toggle="tooltip"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="clearfix">
                        <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
                        <ul class="pagination">
                            <li class="page-item disabled"><a href="#"><i class="fa fa-angle-double-left"></i></a></li>
                            <li class="page-item"><a href="#" class="page-link">1</a></li>
                            <li class="page-item"><a href="#" class="page-link">2</a></li>
                            <li class="page-item active"><a href="#" class="page-link">3</a></li>
                            <li class="page-item"><a href="#" class="page-link">4</a></li>
                            <li class="page-item"><a href="#" class="page-link">5</a></li>
                            <li class="page-item"><a href="#" class="page-link"><i class="fa fa-angle-double-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-primary rounded-pill px-3" type="button">Add Student</button>
            </div>
        </div>
    </div>
</body>

</html>