<?php
include("auth.php");  
include("db_connection.php");

// Getting quiz details based on ID from URL
if (isset($_GET['quiz_id'])) {
    $quiz_id = $_GET['quiz_id'];
    $stmt = $conn->prepare("SELECT * FROM quizzes WHERE id = ?");
    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $quiz = $result->fetch_assoc();

    if (!$quiz) {
        echo "Invalid quiz ID.";
        exit();
    }
} else {
    echo "Missing quiz ID.";
    exit();
}

// Getting questions for the quiz
$stmt = $conn->prepare("SELECT * FROM questions WHERE quiz_id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$result = $stmt->get_result();
$questions = $result->fetch_all(MYSQLI_ASSOC);
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
      <a href="Lessons.php"><img src="lesson-image.jpg" alt="Lessons" class="d-block w-100"></a>
      <div class="carousel-caption">
        <h3>Lessons</h3>
      </div>
    </div>
    <div class="carousel-item">
      <img src="exer.png" alt="ToDo" class="d-block w-100">
      <div class="carousel-caption">
        <h3>To-Do</h3>
      </div> 
    </div>
    <div class="carousel-item">
      <img src="calen.png" alt="Calendar" class="d-block w-100">
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
        <h1 class="text-center">Take Quiz: <?php echo htmlspecialchars($quiz['title']); ?></h1>

        <?php if (!empty($questions)): ?>
            <form method="POST" action="process_quiz.php">
                <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
                <?php foreach ($questions as $index => $question): ?>
                    <div class="card mb-3">
                        <div class="card-header">
                            <h4>Question <?php echo $index + 1; ?>: <?php echo htmlspecialchars($question['question_text']); ?></h4>
                        </div>
                        <div class="card-body">
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM choices WHERE question_id = ?");
                            $stmt->bind_param("i", $question['id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $choices = $result->fetch_all(MYSQLI_ASSOC);
                            ?>

                            <?php foreach ($choices as $choice): ?>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="questions[<?php echo $question['id']; ?>]" id="choice-<?php echo $choice['id']; ?>" value="<?php echo $choice['id']; ?>" required>
                                    <label class="form-check-label" for="choice-<?php echo $choice['id']; ?>">
                                        <?php echo htmlspecialchars($choice['choice_text']); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <button type="submit" class="btn btn-primary">Submit Quiz</button>
            </form>
        <?php else: ?>
            <p>This quiz does not have any questions.</p>
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
