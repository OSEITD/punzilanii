<?php
include("auth.php");  


include("db_connection.php");

//  form submission for adding and editing events
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = isset($_POST['event_id']) ? $_POST['event_id'] : null;
    $event_title = $_POST['event_title'];
    $event_description = $_POST['event_description'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];

    if ($event_id) {
        // Update existing event
        $stmt = $conn->prepare("UPDATE events SET event_title = ?, event_description = ?, event_date = ?, event_time = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $event_title, $event_description, $event_date, $event_time, $event_id);
    } else {
        // Add new event
        $stmt = $conn->prepare("INSERT INTO events (event_title, event_description, event_date, event_time) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $event_title, $event_description, $event_date, $event_time);
    }
    $stmt->execute();
    $stmt->close();
}

//  deletion of events
if (isset($_GET['delete'])) {
    $event_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $stmt->close();
}

// Fetching all events for display
$events = $conn->query("SELECT * FROM events ORDER BY event_date, event_time");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Calendar</title>
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

<div class="offcanvas offcanvas-start sidebar" tabindex="-1" id="sidebar">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menu</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>

</div>

<div class="container">
    <h1 class="text-center">Manage Calendar</h1>

    <form method="post" action="manage_calendar.php">
        <input type="hidden" id="event_id" name="event_id">
        <div class="mb-3">
            <label for="event_title" class="form-label">Event Title:</label>
            <input type="text" id="event_title" name="event_title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="event_description" class="form-label">Event Description:</label>
            <textarea id="event_description" name="event_description" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="event_date" class="form-label">Event Date:</label>
            <input type="date" id="event_date" name="event_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="event_time" class="form-label">Event Time:</label>
            <input type="time" id="event_time" name="event_time" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Event</button>
    </form>

    <h2>Scheduled Events</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Date</th>
                <th>Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($event = $events->fetch_assoc()) {
                echo "<tr>
                    <td>" . htmlspecialchars($event['event_title']) . "</td>
                    <td>" . htmlspecialchars($event['event_description']) . "</td>
                    <td>" . htmlspecialchars($event['event_date']) . "</td>
                    <td>" . htmlspecialchars($event['event_time']) . "</td>
                    <td>
                        <a href='manage_calendar.php?edit=" . $event['id'] . "' class='btn btn-sm btn-warning'>Edit</a>
                        <a href='manage_calendar.php?delete=" . $event['id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<footer class="py-4 bg-dark text-light mt-5">
    <div class="container">
        <p class="text-center mb-0">&copy; 2024 PUNZILANI. All rights reserved.</p>
        <p class="text-center mb-0">Designed by <a href="#" class="text-light">Osei Mupeta, Euritah Musole & Daniel Ngosa</a></p>
        <a href="logout.php" class="btn btn-outline-light mt-3"">LOGOUT</a>
    </div>
</footer>

<script>
    // Populate the form fields if editing an event
    <?php
    if (isset($_GET['edit'])) {
        $event_id = $_GET['edit'];
        $stmt = $conn->prepare("SELECT * FROM events WHERE event_id = ?");
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $event = $result->fetch_assoc();
        $stmt->close();
        ?>
        document.getElementById('event_id').value = "<?php echo $event['event_id']; ?>";
        document.getElementById('event_title').value = "<?php echo $event['event_title']; ?>";
        document.getElementById('event_description').value = "<?php echo $event['event_description']; ?>";
        document.getElementById('event_date').value = "<?php echo $event['event_date']; ?>";
        document.getElementById('event_time').value = "<?php echo $event['event_time']; ?>";
        <?php
    }
    ?>
</script>

</body>
</html>

<?php
$conn->close();
?>
