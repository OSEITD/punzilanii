<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Add any custom styles here */
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">PUNZILANI</a>
        <form class="d-flex" action="" method="GET">
            <input class="form-control me-2" type="search" name="search_query" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-light" type="submit">Search</button>
        </form>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <div class="col">
            <?php
            include("auth.php");
            include("db_connection.php");

            // Check if the search query is set and not empty
            if(isset($_GET['search_query']) && !empty($_GET['search_query'])) {
                // Sanitize the search query to prevent SQL injection
                $search_query = mysqli_real_escape_string($conn, $_GET['search_query']);
                
                // Query to search for materials containing the search query
                $query = "SELECT * FROM materials WHERE material_name LIKE '%$search_query%' OR material_content LIKE '%$search_query%'";
                
                // Perform the query
                $result = $conn->query($query);
                
                // Display search results
                if ($result) {
                    if ($result->num_rows > 0) {
                        echo "<h2>Search Results:</h2>";
                        while($row = $result->fetch_assoc()) {
                            echo "<div class='card mb-3'>";
                            echo "<div class='card-body'>";
                            echo "<h5 class='card-title'>Material Name: " . htmlspecialchars($row["material_name"]) . "</h5>";
                            echo "<p class='card-text'>Material Content: " . htmlspecialchars($row["material_content"]) . "</p>";
                            
                            echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "<div class='alert alert-info' role='alert'>No materials found matching your search.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Error executing the query: " . $conn->error . "</div>";
                }
            } else {
                echo "<div class='alert alert-warning' role='alert'>Please enter a search query.</div>";
            }

            $conn->close();
            ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
