<?php
include("auth.php");
include("db_connection.php");

$answers = $_POST['answers'];
$score = 0;

foreach ($answers as $question_id => $choice_id) {
    $stmt = $conn->prepare("SELECT is_correct FROM choices WHERE id = ?");
    $stmt->bind_param("i", $choice_id);
    $stmt->execute();
    $stmt->bind_result($is_correct);
    $stmt->fetch();
    if ($is_correct) {
        $score++;
    }
    $stmt->close();
}

$total_questions = count($answers);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Quiz Results</h1>
    <p>Your score: <?php echo $score; ?> out of <?php echo $total_questions; ?></p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
