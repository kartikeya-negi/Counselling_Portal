<?php
include ('./conn/conn.php');

// Define variables and initialize with empty values
$email = $contactNumber = "";
$email_err = $contactNumber_err = "";

// Initialize the variable to store the table HTML
$tableHTML = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email is empty
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }
    
    // Check if contact number is empty
    if (empty(trim($_POST["contact_number"]))) {
        $contactNumber_err = "Please enter your contact number.";
    } else {
        $contactNumber = trim($_POST["contact_number"]);
    }
    
    // Validate credentials
    if (empty($email_err) && empty($contactNumber_err)) {
        // Prepare a select statement
        $sql = "SELECT first_name, last_name, course_assigned FROM tbl_student WHERE email = :email AND contact_number = :contact_number";
        
        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":contact_number", $param_contactNumber, PDO::PARAM_STR);
            
            // Set parameters
            $param_email = $email;
            $param_contactNumber = $contactNumber;
            
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if email and contact number exist, if yes then display the table
                if ($stmt->rowCount() == 1) {
                    // Fetch result as an associative array
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    // Construct the table HTML
                    $tableHTML = "<h2>Welcome, {$row['first_name']} {$row['last_name']}</h2>";
                    $tableHTML .= "<table border='1'>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Course Assigned</th>
                        </tr>
                        <tr>
                            <td>{$row['first_name']}</td>
                            <td>{$row['last_name']}</td>
                            <td>{$row['course_assigned']}</td>
                        </tr>
                    </table>";
                } else {
                    // Display an error message if email or contact number is incorrect
                    $tableHTML = "<p>Login failed. Invalid email or contact number.</p>";
                }
            } else {
                $tableHTML = "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            unset($stmt);
        }
    }
    // Close connection
    unset($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <style>
        .wrapper {
            width: 360px;
            padding: 20px;
            margin: auto;
        }
        .wrapper h2 {
            text-align: center;
        }
        .wrapper form, .wrapper table {
            width: 100%;
            margin-top: 20px;
        }
        .wrapper form input[type="text"],
        .wrapper form input[type="password"] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .wrapper form .btn {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
        }
        .wrapper form .btn:hover {
            opacity: 0.8;
        }
        .error-message {
            color: red;
        }
        .back-button {
            display: block;
            text-decoration: none;
            color: #007bff;
            padding: 10px 20px;
            background-color: #f8f9fa;
            border: 1px solid #007bff;
            border-radius: 5px;
            margin: 20px;
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>
</head>
<body>
    <div class="wrapper" style="border:2px solid #0077b6; border-radius:20px; margin-top: 200px;">
    <a href="index.php" class="back-button">Back</a>
        <h2>Student Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Email:</label>
                <input type="text" name="email" value="<?php echo $email; ?>">
                <span class="error-message"><?php echo $email_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password:(Contact Number)</label>
                <input type="password" minlength="10" maxlength="10" name="contact_number" value="<?php echo $contactNumber; ?>">
                <span class="error-message"><?php echo $contactNumber_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" value="Login" style="background-color:#0077b6;">
            </div>
        </form>
        
        <!-- Display the table below the form -->
        <?php echo $tableHTML; ?>
    </div>    
</body>
</html>
