<?php
include("db_connection.php");

$data = json_decode(file_get_contents("php://input"), true);
$event_name = $data['event_name'];
$event_start_date = $data['event_start_date'];
$event_end_date = $data['event_end_date'];

$sql = "INSERT INTO events (title, start, end) VALUES ('$event_name', '$event_start_date', '$event_end_date')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => true, 'msg' => 'Event added successfully']);
} else {
    echo json_encode(['status' => false, 'msg' => 'Failed to add event']);
}

$conn->close();
?>
