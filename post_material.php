<?php
// Include authentication and database connection files
include("auth.php");
include("db_connection.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $course_id = $_POST['course_id'];
    $material_content = $_POST['material_content'];
    
    // Handle file upload
    $material_file = ""; // Initialize variable to store file path
    if ($_FILES['material_file']['error'] === UPLOAD_ERR_OK) {
        $material_file = "uploads/" . basename($_FILES["material_file"]["name"]);
        move_uploaded_file($_FILES["material_file"]["tmp_name"], $material_file);
    }
    
    // Insert the material into the database
    $sql = "INSERT INTO materials (course_id, material_content, material_file) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $course_id, $material_content, $material_file);
    $stmt->execute();
    $stmt->close();
    
    // Redirect back to the course detail page
    header("Location: course_detail.php?course_id=$course_id");
    exit();
}
?>
