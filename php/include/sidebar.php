<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="../../external/bootstrap/bootstrap.min.css" rel="stylesheet">
  <link href="../../external/fontawesome/css/all.min.css" rel="stylesheet">
  <link href="../../external/fontawesome/css/fontawesome.min.css" rel="stylesheet">

  <style>
    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }

    .nav-link:hover {
      background-color: black;
    }

    /* sidebar.css */

    .sidebar {
      width: 200px;
      height: 100vh;
      position: fixed;
      top: 70px;
      left: 0;
    }
  </style>

</head>

<body>
  <main class="sidebar text-bg-dark">

    <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark ">
      <!--
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
      logo width="40" height="32"
      <span class="fs-4">Sidebar</span>
    </a>
    <hr>
    -->
      <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
          <a href="../admin/dashboard.php" class="nav-link text-white">
            <i class="bi pe-none me-2 fa-solid fa-house"></i>
            Dashboard
          </a>
        </li>
        <li>
          <a href="#" class="nav-link text-white">
            <i class="bi pe-none me-2 fa-solid fa-chalkboard-user"></i>
            Teachers
          </a>
        </li>
        <li>
          <a href="../admin/student.php" class="nav-link text-white">
            <i class="bi pe-none me-2 fa-solid fa-user-graduate"></i>
            Students
          </a>
        </li>
        <li>
          <a href="../admin/transportation.php" class="nav-link text-white">
            <i class="bi pe-none me-2 fa-solid fa-bus"></i>
            Transportation
          </a>
        </li>
        <li>
          <a href="#" class="nav-link text-white">
            <i class="bi pe-none me-2 fa-solid fa-file-circle-check"></i>
            Marks
          </a>
        </li>
      </ul>
    </div>
    <div class="b-example-vr"></div>

  </main>
</body>

</html>