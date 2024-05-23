<?php
// Include authentication and database connection files
include("auth.php");
include("db_connection.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $course_id = $_POST['course_id'];
    $announcement_content = $_POST['announcement_content'];
    
    // Insert the announcement into the database
    $sql = "INSERT INTO announcements (course_id, announcement_content) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $course_id, $announcement_content);
    $stmt->execute();
    $stmt->close();
    
    // Redirect back to the course detail page
    header("Location: course_detail.php?course_id=$course_id");
    exit();
}
?>
