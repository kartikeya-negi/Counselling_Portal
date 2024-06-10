<?php 
include ('./conn/conn.php');

// Handle sorting order selection
$order = "DESC"; // Default sorting order
if(isset($_GET['order']) && $_GET['order'] == 'asc') {
    $order = "ASC";
}

// Retrieve student details and sort them by 10th percentage
$stmt = $conn->prepare("SELECT *, ((physics_marks + chemistry_marks + maths_marks) / 3) AS average FROM tbl_student ORDER BY average $order");
$stmt->execute();
$result = $stmt->fetchAll();

// Handle form submission to assign courses to students
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign_course'])) {
    foreach ($_POST['assign_course'] as $student_id => $course) {
        // Update the database to assign the selected course to the student and set 'ass' column to true
        $updateStmt = $conn->prepare("UPDATE tbl_student SET course_assigned = :course, assigned = true WHERE student_id = :student_id");
        $updateStmt->bindParam(':student_id', $student_id);
        $updateStmt->bindParam(':course', $course);
        $updateStmt->execute();

        // Get the student's details for notification
        $studentDetailsStmt = $conn->prepare("SELECT * FROM tbl_student WHERE student_id = :student_id");
        $studentDetailsStmt->bindParam(':student_id', $student_id);
        $studentDetailsStmt->execute();
        $studentDetails = $studentDetailsStmt->fetch();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Allotment</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        .main{
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg" style="background-color:#0077b6;">
        <a class="navbar-brand ml-5" href="home.php" style="color: #fff;">Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav mr-auto my-2 my-lg-0 navbar-nav-scroll" style="max-height: 100px; margin-left: 80%;">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="index.php" role="button" aria-expanded="false" style="color:#fff;">Logout</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php">Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div class="main">
        <div class="content">
            <h4 style="text-align: center;">List of Students (Sorted by PCM Marks)</h4>
            <hr>
            <!-- Sorting form -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET" class="mb-3" style= "position:fixed;top: 10px !important;  right:10px; z-index: 999;">
                <label for="sortingOrder">Sort Order:</label>
                <select name="order" id="sortingOrder" onchange="this.form.submit()">
                    <option value="desc" <?php if(isset($_GET['order']) && $_GET['order'] == 'desc') echo 'selected'; ?>>High to Low</option>
                    <option value="asc" <?php if(isset($_GET['order']) && $_GET['order'] == 'asc') echo 'selected'; ?>>Low to High</option>
                </select>
            </form>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <table class="table" style="margin-top:50px;">
                    <thead>
                        <tr>
                            <th scope="col">Student ID</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Contact Number</th>
                            <th scope="col">Email</th>
                            <th scope="col">10th Percentage</th>
                            <th scope="col">12th Percentage</th>
                            <th scope="col">Physics Marks</th>
                            <th scope="col">Chemistry Marks</th>
                            <th scope="col">Maths Marks</th>
                            <th scope="col">Preference</th>
                            <th scope="col">Assign Course</th>
                            <th scope="col">Course Assigned</th>
                            <th scope="col">Assigned</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($result as $row) {
                            echo "<tr>";
                            echo "<td>{$row['student_id']}</td>";
                            echo "<td>{$row['first_name']}</td>";
                            echo "<td>{$row['last_name']}</td>";
                            echo "<td>{$row['contact_number']}</td>";
                            echo "<td>{$row['email']}</td>";
                            echo "<td>{$row['tenth_percentage']}</td>";
                            echo "<td>{$row['twelfth_percentage']}</td>";
                            echo "<td>{$row['physics_marks']}</td>";
                            echo "<td>{$row['chemistry_marks']}</td>";
                            echo "<td>{$row['maths_marks']}</td>";
                            echo "<td>";
                            if (isset($row['course'])) {
                                echo $row['course']; // Display the course if it exists
                            } else {
                                echo "N/A"; // Display 'N/A' if the course is not set
                            }
                            echo "</td>";
                            echo "<td>";
                            // Display a dropdown with available courses or 'Course Assigned' text if the course is already assigned
                            if ($row['assigned']) {
                                echo "-";
                            } else {
                                echo "<select name='assign_course[{$row['student_id']}]'>";
                                echo "<option value='course_assigned'>Choose Course</option>";
                                // Add options for each available course
                                echo "<option value='CSE'>CSE</option>";
                                echo "<option value='ECE'>ECE</option>";
                                echo "<option value='MCA'>MCA</option>";
                                echo "</select>";
                            }
                            echo "</td>";
                            echo "<td>{$row['course_assigned']}</td>"; // Display assigned course
                            echo "<td>";
                            // Display tick mark if course is assigned
                            if ($row['assigned']) {
                                echo "&#10004;";
                            } else {
                                echo "-";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary" style="margin-left:50%;margin-right:50%;">Assign Course</button>
                
                
                

            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
