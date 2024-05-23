<?php
include("auth.php");
include("db_connection.php");

if (!isset($_GET['course_id'])) {
    die("Course ID is required.");
}

$course_id = $_GET['course_id'];
$instructor_id = $_SESSION['user_id'];

// Fetch course details
$sql = "SELECT * FROM courses WHERE course_id = ? AND instructor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $course_id, $instructor_id);
$stmt->execute();
$result = $stmt->get_result();
$course = $result->fetch_assoc();
$stmt->close();

// Fetch materials for the course
$sql = "SELECT * FROM materials WHERE course_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();
$materials = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Fetch announcements for the course
$sql = "SELECT * FROM announcements WHERE course_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();
$announcements = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Course Detail</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Course Detail</a>
  </div>
</nav>

<div class="container mt-3">
    <h2><?php echo htmlspecialchars($course['course_name']); ?></h2>
    <p>Course ID: <?php echo htmlspecialchars($course['course_id']); ?></p>

    <h3>Materials</h3>
<?php if (!empty($materials)): ?>
    <ul class="list-group">
        <?php foreach ($materials as $material): ?>
            <li class="list-group-item">
                <?php echo htmlspecialchars($material['material_content']); ?>
                <?php if (!empty($material['material_file'])): ?>
                    <a href="<?php echo htmlspecialchars($material['material_file']); ?>" target="_blank">Download</a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No materials available for this course.</p>
<?php endif; ?>


    <hr>
    <h3>Post New Material</h3>
<form method="post" action="post_material.php" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="material_content" class="form-label">Material Content</label>
        <textarea class="form-control" id="material_content" name="material_content" rows="3" required></textarea>
    </div>
    <div class="mb-3">
        <label for="material_file" class="form-label">Upload File</label>
        <input type="file" class="form-control" id="material_file" name="material_file">
    </div>
    <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_id); ?>">
    <button type="submit" class="btn btn-primary">Post Material</button>
</form>


    <hr>
    <h3>Announcements</h3>
    <?php if (!empty($announcements)): ?>
        <ul class="list-group">
            <?php foreach ($announcements as $announcement): ?>
                <li class="list-group-item"><?php echo htmlspecialchars($announcement['announcement_content']); ?> <span class="text-muted">- Posted on <?php echo htmlspecialchars($announcement['created_at']); ?></span></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No announcements available for this course.</p>
    <?php endif; ?>

    <hr>
    <h3>Post New Announcement</h3>
    <form method="post" action="post_announcement.php">
        <div class="mb-3">
            <label for="announcement_content" class="form-label">Announcement Content</label>
            <textarea class="form-control" id="announcement_content" name="announcement_content" rows="3" required></textarea>
        </div>
        <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_id); ?>">
        <button type="submit" class="btn btn-primary">Post Announcement</button>
    </form>
</div>

<footer class="py-4 bg-dark text-light">
  <div class="container">
    <p class="text-center mb-0">&copy; 2024 PUNZILANI. All rights reserved.</p>
    <p class="text-center mb-0">Designed by <a href="#" class="text-light">Osei Mupeta, Euritah Musole & Daniel Ngosa</a></p>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
