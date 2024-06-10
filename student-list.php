<?php 
include ('./conn/conn.php');

// Retrieve the list of available courses
$stmt = $conn->prepare("SELECT DISTINCT course_assigned FROM tbl_student");
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_COLUMN);
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
        .course-dropdown {
            width: 150px;
            margin-left: auto;
        }
        .sorting-dropdown {
            width: 180px;
            margin-right: auto;
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg" style="background-color:#0077b6;">
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav mr-auto my-2 my-lg-0 navbar-nav-scroll" style="max-height: 100px; margin-left: 80%;">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="index.php" role="button" aria-expanded="false" style="color:#fff;">Exit</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="main">
        <div class="content">
            <h4 style="text-align: center;">List of Students with Assigned Course</h4>
            <hr>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="d-flex">
                <div class="form-group course-dropdown" style="margin-right:20px;">
                    <label for="course">Select Course:</label>
                    <select id="course" name="course" class="form-control">
                        <option value="">All Courses</option>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?php echo $course; ?>"><?php echo $course; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Dropdown for sorting -->
                <div class="form-group sorting-dropdown" style="margin-right:20px;">
                    <label for="sorting">Sort Name:</label>
                    <select id="sorting" name="sorting" class="form-control">
                        <option value="">No Sorting</option>
                        <option value="ASC">Ascending</option>
                        <option value="DESC">Descending</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary" style="margin-right:20px; padding:auto;">Filter</button>
            </form>

            <table class="table" style="margin-top:50px;">
                <thead>
                    <tr>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Course Assigned</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Handle form submission to filter by course or sort the list
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $selectedCourse = $_POST['course'];
                        $selectedSorting = $_POST['sorting'] ?? '';

                        $query = "SELECT first_name, last_name, course_assigned FROM tbl_student";
                        if (!empty($selectedCourse)) {
                            $query .= " WHERE course_assigned = :course_assigned";
                        }
                        if (!empty($selectedSorting)) {
                            $query .= " ORDER BY first_name $selectedSorting, last_name $selectedSorting";
                        }
                        $stmt = $conn->prepare($query);
                        if (!empty($selectedCourse)) {
                            $stmt->bindParam(':course_assigned', $selectedCourse);
                        }
                        $stmt->execute();
                        $result = $stmt->fetchAll();
                    } else {
                        // If no course is selected, show all students
                        $stmt = $conn->prepare("SELECT first_name, last_name, course_assigned FROM tbl_student");
                        $stmt->execute();
                        $result = $stmt->fetchAll();
                    }

                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>{$row['first_name']}</td>";
                        echo "<td>{$row['last_name']}</td>";
                        echo "<td>{$row['course_assigned']}</td>"; // Display assigned course
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
