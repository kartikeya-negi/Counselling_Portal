<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include_once('./conn/conn.php');

    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute SQL query to insert admin details into the database
    $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);

    // Close database connection
    $conn = null;

    // Redirect to home page or wherever appropriate
    header("Location: home.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./assets/styles.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Counselling Portal</a>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h2 class="text-center">Admin Signup</h2>
                <form action="./endpoint/admin_signup.php" method="POST">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <!-- Add more fields specific to admin signup if needed -->
                    <button type="submit" class="btn btn-primary btn-block">Signup</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap Js -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
