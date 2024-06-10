<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counselling Portal</title>

    <!-- Style CSS -->
    <link rel="stylesheet" href="./assets/styles.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Include reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/enterprise.js?render=6LfD-sQpAAAAAB6xO5MOqUSOVdXvvUfyFT7AVcuZ" async defer></script>

    <style>
        /* Additional styling for counselling instructions */
        .counselling-instructions {
            min-height: 70vh;
            text-align: justify;
            font-size: 16px;
            line-height: 1.6;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border: 2px solid #0077b6;
            border-radius: 20px;
            padding: 50px;
            background-color: #f5faff;
            margin-top: 100px;
        }

        /* Style for title */
        .navbar {
            background-color: #0077b6;
        }

        .navbar-brand {
            color: #fff;
            font-size: 24px;
            font-weight: bold;
            align-items:center;
        }

        /* Style for form container */
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            margin: auto; /* Center the form horizontally */
        }

        /* Style for form */
        .login-form {
            width: 100%;
            max-width: 500px;
            padding: 20px;
            border-radius: 10px;
            background-color: #f8f9fa;
        }

        /* Increase input field size */
        .form-control {
            height: 50px;
            font-size: 18px;
        }

        /* Style for links */
        .registrationForm {
            display: block;
            text-align: center;
            margin-top: 10px;
        }

        /* Style for options box */
        .options-box {
            position: absolute;
            top: 0;
            right: 0;
            width: 250px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f8f9fa;
            margin-top: 100px;
        }

        .options-box a {
            display: block;
            margin-bottom: 10px;
            text-decoration: none;
            color: #0077b6;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">Counselling Portal</a>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Form Area -->
            <div class="col-lg-6 form-container" id="formContainer">
                <div class="login" id="loginForm">
                    <h2 class="text-center"><u>Admin Login</u></h2>
                    <div class="login-form">
                        <form action="./endpoint/login.php" method="POST">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" id="username" name="username">
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <button type="submit" class="btn login-btn form-control mt-4" style="background-color:#0077b6; color:#fff;">Login</button>
                        </form>
                    </div>
                </div>

                <!-- Registration Area -->
                <div class="registration" id="registrationForm" style="display:none;">
                    <h2 class="text-center">Registration Form</h2>
                    <div class="registration-form">
                        <form action="./endpoint/add-user.php" method="POST">
                            <!-- Form fields for registration -->
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Options Box -->
            <div class="options-box">
                <a href="student-detail.php">Student Form</a>
                <a href="student-login.php">Student Login</a>
                <a href="student-list.php">Final List</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap Js -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
