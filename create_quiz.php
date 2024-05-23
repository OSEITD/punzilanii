<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Calendar</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <h1 class="text-center">Create Quiz</h1>
    <form method="POST" action="" id="quizForm">
        <div class="mb-3">
            <label for="quiz_title" class="form-label">Quiz Title</label>
            <input type="text" class="form-control" id="quiz_title" name="quiz_title" required>
        </div>
        <div id="questions">
            <div class="question mb-3">
                <label class="form-label">Question</label>
                <input type="text" class="form-control" name="questions[0][question]" required>
                <div class="choices mt-2">
                    <label class="form-label">Choices</label>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" name="questions[0][choices][0][choice_text]" required>
                        <div class="input-group-text">
                            <input type="checkbox" name="questions[0][choices][0][is_correct]">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary add-choice">Add Choice</button>
            </div>
        </div>
        <button type="button" class="btn btn-secondary add-question">Add Question</button>
        <button type="submit" class="btn btn-primary mt-3">Create Quiz</button>
    </form>

    <!-- Success Alert -->
    <div class="alert alert-success mt-3 d-none" role="alert" id="successMessage">
        Quiz created successfully!
    </div>
</div>

<script>
let questionIndex = 1;

document.querySelector('.add-question').addEventListener('click', function() {
    let questionHtml = `
    <div class="question mb-3">
        <label class="form-label">Question</label>
        <input type="text" class="form-control" name="questions[${questionIndex}][question]" required>
        <div class="choices mt-2">
            <label class="form-label">Choices</label>
            <div class="input-group mb-2">
                <input type="text" class="form-control" name="questions[${questionIndex}][choices][0][choice_text]" required>
                <div class="input-group-text">
                    <input type="checkbox" name="questions[${questionIndex}][choices][0][is_correct]">
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-secondary add-choice">Add Choice</button>
    </div>`;
    document.getElementById('questions').insertAdjacentHTML('beforeend', questionHtml);
    questionIndex++;
});

document.getElementById('questions').addEventListener('click', function(e) {
    if (e.target.classList.contains('add-choice')) {
        let choicesDiv = e.target.previousElementSibling;
        let choiceIndex = choicesDiv.querySelectorAll('.input-group').length;
        let choiceHtml = `
        <div class="input-group mb-2">
            <input type="text" class="form-control" name="${choicesDiv.previousElementSibling.name.replace('][question]', '')}[choices][${choiceIndex}][choice_text]" required>
            <div class="input-group-text">
                <input type="checkbox" name="${choicesDiv.previousElementSibling.name.replace('][question]', '')}[choices][${choiceIndex}][is_correct]">
            </div>
        </div>`;
        choicesDiv.insertAdjacentHTML('beforeend', choiceHtml);
    }
});

document.getElementById('quizForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    // Simulate form submission
    // Here, you can perform AJAX submission if needed
    setTimeout(function() {
        document.getElementById('successMessage').classList.remove('d-none'); // Show success message
    }, 1000);
});



</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<pre>



</pre>
<footer class="py-4 bg-dark text-light mt-5">
    <div class="container">
        <p class="text-center mb-0">&copy; 2024 PUNZILANI. All rights reserved.</p>
        <p class="text-center mb-0">Designed by <a href="#" class="text-light">Osei Mupeta, Euritah Musole & Daniel Ngosa</a></p>
        <a href="logout.php" class="btn btn-outline-light mt-3">LOGOUT</a>
    </div>
</footer>
</body>
</html>
