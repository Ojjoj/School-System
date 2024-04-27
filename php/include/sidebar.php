<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="../../external/bootstrap/bootstrap.min.css" rel="stylesheet">
  <link href="../../external/fontawesome/css/all.min.css" rel="stylesheet">
  <link href="../../external/fontawesome/css/fontawesome.min.css" rel="stylesheet">

  <style>
    .sidebar .btn {
      width: 100%;
      /* Set the width of all buttons to 100% */
    }

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

    .sidebar {
      width: 200px;
      height: 100vh;
      position: fixed;
      top: 70px;
      left: 0;
    }

    /*
    .btn-toggle::before {
      width: 1.25em;
      line-height: 0;
      content: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='rgba%280,0,0,.5%29' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 14l6-6-6-6'/%3e%3c/svg%3e");
      transition: transform .35s ease;
      transform-origin: .5em 50%;
    }
    */


    .btn-toggle[aria-expanded="true"]::before {
      transform: rotate(90deg);
    }

    .btn-toggle-nav a {
      padding: .1875rem .5rem;
      margin-top: .125rem;
      margin-left: 1.25rem;
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
        <li>
          <a href="../admin/dashboard.php" class="nav-link text-white">
            <i class="bi pe-none me-2 fa-solid fa-house"></i>
            Dashboard
          </a>
        </li>
        <li>
          <button class="text-white nav-link btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
            <i class="bi pe-none me-2 fa-solid fa-chalkboard-user"></i>
            Staff
          </button>
          <div class="collapse" id="account-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li><a href="../admin/teacher.php" class="nav-link text-white d-inline-flex text-decoration-none rounded">Teachers</a></li>
              <li><a href="../admin/add_assistant.php" class="nav-link text-white d-inline-flex text-decoration-none rounded">Assistants</a></li>
            </ul>
          </div>
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
          <a href="../admin/course.php" class="nav-link text-white">
            <i class="bi pe-none me-2 fa-solid fa-file-circle-check"></i>
            Courses
          </a>
        </li>
      </ul>
    </div>
    <div class="b-example-vr"></div>

  </main>
</body>

</html>