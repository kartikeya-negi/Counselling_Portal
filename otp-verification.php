<?php
session_start();

// Check if OTP and phone number are set in session
if (!isset($_SESSION['otp']) || !isset($_SESSION['phone_number'])) {
    header('Location: student-detail.php'); // Redirect to the student detail form if session data is not set
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otpEntered = $_POST['otp'];

    // Verify OTP
    if ($otpEntered == $_SESSION['otp']) {
        // OTP is correct, proceed to student registration
        // Here you can add your code to insert student details into the database
        // After successful registration, you can redirect the user to a success page or any other page as needed
        unset($_SESSION['otp']); // Clear OTP from session
        unset($_SESSION['phone_number']); // Clear phone number from session
        header('Location: registration-success.php'); // Redirect to success page
        exit();
    } else {
        // Incorrect OTP, show error message
        $error = "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>
    <div class="main">
        <div class="form-container">
            <h1>OTP Verification</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-group">
                    <label for="otp">Enter OTP sent to <?php echo $_SESSION['phone_number']; ?>:</label>
                    <input type="text" id="otp" name="otp" required>
                    <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
                </div>
                <button type="submit" class="btn">Verify OTP</button>
            </form>
        </div>
    </div>
</body>
</html>
