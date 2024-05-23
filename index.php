<?php
include("auth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    .round-image {
      clip-path: circle(40%);
      border-radius: 50%;
      border: 1px solid #000;
      width: 120px;
      height: 80px;
      margin-right: 50px;  
    }
    /* Custom CSS for footer */
    footer {
      background-color: #343a40;
      color: #ffffff;
    }
    .carousel-item img {
      height: 300px;
      object-fit: cover;
    }
    /* Custom CSS for ease-in-out effect on hover */
    .dashboard-item {
      transition: transform 0.3s ease-in-out;
    }
    .dashboard-item:hover {
      transform: scale(1.05);
    }
    .dashboard-item img {
      width: 100%;
      height: 150px;
      object-fit: cover;
    }
    .sidebar {
      background-color: #343a40;
      color: #ffffff;
    }
    .sidebar a {
      color: #ffffff;
      text-decoration: none;
    }
    .sidebar a:hover {
      color: #f8f9fa;
      text-decoration: underline;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <!-- Navbar content -->
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#"><img src="lo.png" class="round-image" alt="IMG"></a>
    <!-- Search bar -->
    <!-- Search bar -->
<form class="d-flex" action="search_materials.php" method="GET">
  <input class="form-control me-2" type="search" placeholder="Search Materials" aria-label="Search" name="search_query">
  <button class="btn btn-outline-light" type="submit">Search</button>
</form>

  </div>
</nav>

<div class="offcanvas offcanvas-start sidebar" tabindex="-1" id="sidebar">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">Menu</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="list-unstyled">
      <li><a href="index.php">Home</a></li>
      <li><a href="courses.php">Lessons</a></li>
      <li><a href="courses.php">Exercise</a></li>
      <li><a href="full_calendar.html">Calendar</a></li>
      <li><a href="about.html">About Us</a></li>
      <li><a href="#">Contact Us</a></li>
    </ul>
  </div>
</div>

<!-- Carousel -->
<div id="demo" class="carousel slide" data-bs-ride="carousel">
  <!-- Indicators/dots -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
    <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
  </div>
  
  <!-- The slideshow/carousel -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <a href="Lessons.php"><img src="lesson-image.jpg" alt="Lessons" class="d-block" style="width:100%"></a>
      <div class="carousel-caption">
        <h3>Lessons</h3>
      </div>
    </div>
    <div class="carousel-item">
      <img src="exer.png" alt="ToDo" class="d-block" style="width:100%">
      <div class="carousel-caption">
        <h3>To-Do</h3>
      </div> 
    </div>
    <div class="carousel-item">
      <img src="calen.png" alt="Calendar" class="d-block" style="width:100%">
      <div class="carousel-caption">
        <h3>Calendar</h3>
      </div>  
    </div>
  </div>
  
  <!-- Left and right controls/icons -->
  <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<!--DashBoard-->
<h1 class="text-center"><strong>DashBoard</strong></h1>

<div class="container text-center">
  <div class="row row-cols-1 row-cols-md-2 g-4">
    <div class="col">
      <a href="courses.php" class="text-decoration-none text-dark">
        <div class="card dashboard-item">
          <img src="courses.png" class="card-img-top img-fluid" alt="Courses">
          <div class="card-body">
            <h5 class="card-title">Courses</h5>
          </div>
        </div>
      </a>
    </div>
    <div class="col">
      <a href="courses.php" class="text-decoration-none text-dark">
        <div class="card dashboard-item">
          <img src="lesson.jpg" class="card-img-top img-fluid" alt="Lessons">
          <div class="card-body">
            <h5 class="card-title">Lessons</h5>
          </div>
        </div>
      </a>
    </div>
    <div class="col">
      <a href="course.php" class="text-decoration-none text-dark">
        <div class="card dashboard-item">
          <a href="available_quizzes.php"><img src="exercises.jpg" class="card-img-top img-fluid" alt="Exercise">
          <div class="card-body">
            <h5 class="card-title">Exercise</h5></a>
          </div>
        </div>
      </a>
    </div>
    <div class="col">
      <a href="#" class="text-decoration-none text-dark">
        <div class="card dashboard-item">
        <a href="calendar.php"> <img src="vecteezy_calendar.jpg" class="card-img-top img-fluid" alt="Calendar">
          <div class="card-body">
            <h5 class="card-title">Calendar</h5></a>
          </div>
        </div>
      </a>
    </div>
  </div>
</div>

<!-- Footer -->
<div class="container-fluid bg-dark text-light">
  <footer class="py-4">
    <div class="container">
      <p class="text-center mb-0">&copy; 2024 PUNZILANI. All rights reserved.</p>
      <p class="text-center mb-0">Designed by <a href="about.html" class="text-light">Osei Mupeta, Euritah Musole & Daniel Ngosa</a></p>
      <a href="logout.php" class="btn btn-outline-light mt-3">LOGOUT</a>
    </div>
  </footer>
</div>
</body>
</html>
