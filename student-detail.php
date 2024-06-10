<?php
include ('./conn/conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $contactNumber = $_POST['contact_number'];
    $email = $_POST['email'];
    $tenthPercentage = $_POST['tenth_percentage'];
    $twelfthPercentage = $_POST['twelfth_percentage'];
    $physicsMarks = $_POST['physics_marks'];
    $chemistryMarks = $_POST['chemistry_marks'];
    $mathsMarks = $_POST['maths_marks'];
    $course = $_POST['course'];

    try {
        $conn->beginTransaction();

        $stmt = $conn->prepare("INSERT INTO `tbl_student` (`first_name`, `last_name`, `contact_number`, `email`, `tenth_percentage`, `twelfth_percentage`, `physics_marks`, `chemistry_marks`, `maths_marks`, `course`) VALUES (:first_name, :last_name, :contact_number, :email, :tenth_percentage, :twelfth_percentage, :physics_marks, :chemistry_marks, :maths_marks, :course)");
        $stmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':contact_number', $contactNumber, PDO::PARAM_INT);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':tenth_percentage', $tenthPercentage, PDO::PARAM_STR);
        $stmt->bindParam(':twelfth_percentage', $twelfthPercentage, PDO::PARAM_STR);
        $stmt->bindParam(':physics_marks', $physicsMarks, PDO::PARAM_STR);
        $stmt->bindParam(':chemistry_marks', $chemistryMarks, PDO::PARAM_STR);
        $stmt->bindParam(':maths_marks', $mathsMarks, PDO::PARAM_STR);
        $stmt->bindParam(':course', $course, PDO::PARAM_STR);
        $stmt->execute();

        $conn->commit();

        echo "
        <script>
            alert('Student Details Added Successfully');
            window.location.href = 'student-detail.php';
        </script>
        ";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.7">
    <title>Student Detail Form</title>
    <link rel="stylesheet" href="./assets/final.css">
    <style>
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
    <div class="main">
    <a href="index.php" class="back-button">Back</a>
        <div class="form-container">
            <h1>Student Detail Form</h1>
            <form action="student-detail.php" method="POST">
                <div class="form-group">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" required>
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" required>
                    <label for="contact_number">Contact Number:</label>
                    <input type="tel" minlength="10" maxlength="10" id="contact_number" name="contact_number" required>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <label for="tenth_percentage">10th Percentage:</label>
                    <input type="number" id="tenth_percentage" name="tenth_percentage" required>
                    <label for="twelfth_percentage">12th Percentage:</label>
                    <input type="number" id="twelfth_percentage" name="twelfth_percentage" required>
                    <label for="physics_marks">Physics Marks:</label>
                    <input type="number" id="physics_marks" name="physics_marks" required>
                    <label for="chemistry_marks">Chemistry Marks:</label>
                    <input type="number" id="chemistry_marks" name="chemistry_marks" required>
                    <label for="maths_marks">Maths Marks:</label>
                    <input type="number" id="maths_marks" name="maths_marks" required>
                    <label for="course">Select a course:</label>
                    <select id="course" name="course">
                        <option value="CSE">Computer Science and Engineering</option>
                        <option value="ECE">Electronics and Communication Engineering</option>
                        <option value="MCA">Master of Computer Applications</option>
                    </select>
                </div>
                <button type="submit" class="btn">Submit</button>
            </form>
        </div>
        <div class="col-lg-6 counselling-instructions form-container" id="counsellingInstructions form-container" style="margin-left:50px;">
                <h2><u>Instructions</u></h2>
                <p>Welcome to our counselling portal. Here you can find assistance and support for your needs. Please read the instructions below:</p>
                <ul>
                    <li>Ensure all information provided is accurate.</li>
                    <li>Keep your username and password secure.</li>
                    <li>Contact the support team for any assistance.</li>
                </ul>
            </div>
    </div>
</body>
</html>