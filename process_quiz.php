<?php
include("auth.php");
include("db_connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate if quiz_id is set
    if (!isset($_POST['quiz_id'])) {
        echo "Quiz ID is missing.";
        exit();
    }

    $user_id = $_SESSION['user_id']; // Assuming the user ID is stored in the session
    $quiz_id = $_POST['quiz_id']; // The quiz_id should be passed via a hidden field in the form
    $questions = $_POST['questions'];

    // Insert quiz submission
    $stmt = $conn->prepare("INSERT INTO quiz_submissions (user_id, quiz_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $quiz_id);
    $stmt->execute();
    $submission_id = $stmt->insert_id;

    // Initialize an array to store the grading results
    $results = [];

    foreach ($questions as $question_id => $choice_id) {
        // Insert each answer
        $stmt = $conn->prepare("INSERT INTO quiz_answers (submission_id, question_id, choice_id) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $submission_id, $question_id, $choice_id);
        $stmt->execute();

        // Check if the answer is correct
        $stmt = $conn->prepare("SELECT is_correct FROM choices WHERE id = ?");
        $stmt->bind_param("i", $choice_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Store the result
        $results[$question_id] = $row['is_correct'];
    }

    // Display the results
    echo "<h1>Quiz Results</h1>";
    echo "<ul>";
    foreach ($results as $question_id => $is_correct) {
        $stmt = $conn->prepare("SELECT question_text FROM questions WHERE id = ?");
        $stmt->bind_param("i", $question_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $question = $result->fetch_assoc();

        $status = $is_correct ? "Correct" : "Wrong";
        echo "<li>" . htmlspecialchars($question['question_text']) . ": " . htmlspecialchars($status) . "</li>";
    }
    echo "</ul>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Take Quiz: <?php echo htmlspecialchars($quiz['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        

</body>
</html>
