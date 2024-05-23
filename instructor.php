<?php
include("auth.php");  
include("db_connection.php");  

//  message variables
$message = "";
$message_type = "";

if (isset($_GET['message']) && isset($_GET['message_type'])) {
    $message = $_GET['message'];
    $message_type = $_GET['message_type'];
}

// Checking if the form is submitted to add or edit a course
if (isset($_POST['add_course'])) {
    $course_name = $_POST['course_name'];
    $course_id = $_POST['course_id'];
    $instructor_id = $_SESSION['user_id'];  

    
    if (!empty($course_id)) {
        // Edit course
        $sql = "UPDATE courses SET course_name = ?, instructor_id = ? WHERE course_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $course_name, $instructor_id, $course_id);
        if ($stmt->execute()) {
            $message = "Course updated successfully!";
            $message_type = "success";
        } else {
            $message = "Failed to update course.";
            $message_type = "danger";
        }
        $stmt->close();
    } else {
        // Add new course
        $sql = "INSERT INTO courses (course_name, instructor_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $course_name, $instructor_id);
        if ($stmt->execute()) {
            $message = "Course added successfully!";
            $message_type = "success";
        } else {
            $message = "Failed to add course.";
            $message_type = "danger";
        }
        $stmt->close();
    }
}

// Check if the form is submitted to add a material
if (isset($_POST['add_material'])) {
    $course_id = $_POST['course_id'];
    $material_content = $_POST['material_content'];

    // Validate that the course_id exists
    $sql = "SELECT course_id FROM courses WHERE course_id = ? AND instructor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $course_id, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();

        $sql = "INSERT INTO materials (course_id, material_content) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $course_id, $material_content);
        if ($stmt->execute()) {
            $message = "Material added successfully!";
            $message_type = "success";
        } else {
            $message = "Failed to add material.";
            $message_type = "danger";
        }
        $stmt->close();
    } else {
        $message = "Invalid course ID.";
        $message_type = "danger";
        $stmt->close();
    }
}

// Fetch the courses added by the instructor
$sql = "SELECT * FROM courses WHERE instructor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$courses = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add/Edit Course and Materials</title>
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
        footer {
            background-color: #343a40;
            color: #ffffff;
        }
        .carousel-item img {
            height: 300px;
            object-fit: cover;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#"><img src="lo.png" class="round-image" alt="IMG"></a>
        <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-light" type="submit">Search</button>
        </form>
    </div>
</nav>

<h1 class="text-center">WELCOME TO INSTRUCTOR'S PAGE</h1>

<div class="text-center">
<div class="btn-group">
<a href="manage_calendar.php"><button type="button"  class="btn btn-primary"><h2>Manage Calendar</h2></button></a>
<pre>

</pre>
<a href="create_quiz.php"><button type="button" class="btn btn-primary"><h2>Manage Exercises</h2></button></a>
</div>
</div>
<?php if ($message): ?>
<div class="container mt-3">
    <div class="alert alert-<?php echo $message_type; ?>" role="alert">
        <?php echo $message; ?>
    </div>
</div>
<?php endif; ?>

<hr>
<div class="container mt-3">
    <h2>Upload/Update Course</h2>
    <form method="post" action="instructor.php">
        <div class="mb-3">
            <label for="course_name" class="form-label">Course Name</label>
            <input type="text" class="form-control" id="course_name" name="course_name" required>
        </div>
        <div class="mb-3">
            <label for="course_id" class="form-label">Course ID (Leave blank to add new course)</label>
            <input type="text" class="form-control" id="course_id" name="course_id">
        </div>
        <button type="submit" name="add_course" class="btn btn-primary">Submit</button>
    </form>
</div>
<hr>
<div class="container mt-3">
    <h2>Upload Material</h2>
    <form method="post" action="instructor.php">
        <div class="mb-3">
            <label for="course_id_material" class="form-label">Course ID</label>
            <input type="text" class="form-control" id="course_id_material" name="course_id" required>
        </div>
        <div class="mb-3">
            <label for="material_content" class="form-label">Material Content</label>
            <textarea class="form-control" id="material_content" name="material_content" rows="3" required></textarea>
        </div>
        <button type="submit" name="add_material" class="btn btn-primary">Submit</button>
    </form>
</div>

<div class="container mt-4">
    <h2>Your Courses</h2>
    <?php if (!empty($courses)): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Course ID</th>
                    <th>Course Name</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($course['course_id']); ?></td>
                        <td><a href="course_detail.php?course_id=<?php echo htmlspecialchars($course['course_id']); ?>"><?php echo htmlspecialchars($course['course_name']); ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">No courses available at the moment.</p>
    <?php endif; ?>
</div>

<footer class="py-4 bg-dark text-light">
    <div class="container">
        <p class="text-center mb-0">&copy; 2024 PUNZILANI. All rights reserved.</p>
        <p class="text-center mb-0">Designed by <a href="#" class="text-light">Osei Mupeta, Euritah Musole & Daniel Ngosa</a></p>
        <a href="logout.php" class="btn btn-outline-light mt-3">LOGOUT</a>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
