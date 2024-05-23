<?php
include("auth.php");  

// Include the database connection
include("db_connection.php");

// Fetch the courses, their materials, and announcements
$sql = "
    SELECT 
        courses.course_id, 
        courses.course_name, 
        materials.material_id, 
        materials.material_name, 
        materials.material_content, 
        materials.material_file, 
        announcements.announcement_id, 
        announcements.announcement_content, 
        announcements.created_at 
    FROM courses
    LEFT JOIN materials ON courses.course_id = materials.course_id
    LEFT JOIN announcements ON courses.course_id = announcements.course_id
    ORDER BY courses.course_id, materials.material_id, announcements.announcement_id";

$result = $conn->query($sql);
$courses = []; 
while ($row = $result->fetch_assoc()) {
    $course_id = $row['course_id'];
    
    if (!isset($courses[$course_id])) {
        $courses[$course_id] = [
            'course_name' => $row['course_name'],
            'materials' => [],
            'announcements' => []
        ];
    }

    if (!empty($row['material_id'])) {
        $courses[$course_id]['materials'][] = [
            'material_id' => $row['material_id'],
            'material_name' => $row['material_name'],
            'material_content' => $row['material_content'],
            'material_file' => $row['material_file']
        ];
    }

    if (!empty($row['announcement_id'])) {
        $courses[$course_id]['announcements'][] = [
            'announcement_id' => $row['announcement_id'],
            'announcement_content' => $row['announcement_content'],
            'created_at' => $row['created_at']
        ];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Courses</title>
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
    .card {
        transition: transform 0.3s ease-in-out;
    }
    .card:hover {
        transform: scale(1.05);
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
    <form class="d-flex">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
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
      <li><a href="calendar.php">Calendar</a></li>
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

<div class="container mt-4">
    <h1 class="text-center">Available Courses</h1>
    <?php if (!empty($courses)): ?>
        <div class="row">
            <?php foreach ($courses as $course_id => $course): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card mt-3">
                        <div class="card-header bg-primary text-white">
                            <h2><?php echo htmlspecialchars($course['course_name']); ?></h2>
                        </div>
                        <div class="card-body">
                            <h3>Materials</h3>
                            <?php if (!empty($course['materials'])): ?>
                                <ul class="list-group">
                                    <?php foreach ($course['materials'] as $material): ?>
                                        <li class="list-group-item">
                                            <h5><?php echo htmlspecialchars($material['material_name']); ?></h5>
                                            <p><?php echo nl2br(htmlspecialchars($material['material_content'])); ?></p>
                                            <?php if (!empty($material['material_file'])): ?>
                                              <a href="<?php echo htmlspecialchars($material['material_file']); ?>" target="_blank" class="btn btn-secondary">Download</a>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p>No materials available for this course.</p>
                            <?php endif; ?>

                            <h3>Announcements</h3>
                            <?php if (!empty($course['announcements'])): ?>
                                <ul class="list-group">
                                    <?php foreach ($course['announcements'] as $announcement): ?>
                                        <li class="list-group-item">
                                            <p><?php echo nl2br(htmlspecialchars($announcement['announcement_content'])); ?></p>
                                            <span class="text-muted">- Posted on <?php echo htmlspecialchars($announcement['created_at']); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p>No announcements available for this course.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center">No courses available at the moment.</p>
    <?php endif; ?>
</div>

<footer class="py-4 bg-dark text-light mt-5">
  <div class="container">
    <p class="text-center mb-0">&copy; 2024 PUNZILANI. All rights reserved.</p>
    <p class="text-center mb-0">Designed by <a href="#" class="text-light">Osei Mupeta, Euritah Musole & Daniel Ngosa</a></p>
    <a href="logout.php" class="btn btn-outline-light mt-3">LOGOUT</a>
  </div>
</footer>
</body>
</html>
