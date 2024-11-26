<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "star";

// Create a connection
$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);

    // Check if the email exists in the database
    $query = "SELECT * FROM users WHERE user_email = '$user_email'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Generate a unique token for password reset
        $reset_token = bin2hex(random_bytes(32));  // 64 characters
        
        // Save token to the database (you may also set an expiration time for the token)
        $user_id = $user['user_id'];
        $update_query = "UPDATE users SET reset_token = '$reset_token' WHERE user_id = $user_id";
        mysqli_query($conn, $update_query);
        
        // Send an email with the reset token (in real application, make sure to use a proper mail function)
        $reset_link = "http://localhost/reset-password.php?token=$reset_token";
        
        // You can use mail() function to send an email (make sure to configure SMTP in PHP for real use)
        $subject = "Password Reset Request";
        $message = "Hello, \n\nTo reset your password, please click on the following link:\n\n$reset_link";
        $headers = "From: no-reply@yourwebsite.com";
        
        if (mail($user_email, $subject, $message, $headers)) {
            header("Location: forgot-password.html?success=Password reset link has been sent to your email.");
        } else {
            header("Location: forgot-password.html?error=Failed to send reset email.");
        }
    } else {
        header("Location: forgot-password.html?error=Email not found in our system.");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <style>::afterbody {
    font-family: Arial, sans-serif;
    background: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

input {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
}

button:hover {
    background-color: #45a049;
}

.error {
    color: #ff0000;
    background-color: #ffcccc;
    padding: 10px;
    border-radius: 5px;
    margin-top: 10px;
}

.success {
    color: #4CAF50;
    background-color: #e6ffe6;
    padding: 10px;
    border-radius: 5px;
    margin-top: 10px;
}

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <p>Please enter your email address to reset your password.</p>
        
        <form method="POST" action="forgot-password.php">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="user_email" required placeholder="Enter your email">
            </div>
            <button type="submit" name="submit">Submit</button>
        </form>

        <?php if(isset($_GET['error'])) { ?>
            <div class="error"><?php echo $_GET['error']; ?></div>
        <?php } ?>

        <?php if(isset($_GET['success'])) { ?>
            <div class="success"><?php echo $_GET['success']; ?></div>
        <?php } ?>
    </div>
</body>
</html>
