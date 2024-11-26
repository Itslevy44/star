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

if (isset($_GET['token'])) {
    $reset_token = mysqli_real_escape_string($conn, $_GET['token']);
    
    // Check if the token exists in the database
    $query = "SELECT * FROM users WHERE reset_token = '$reset_token'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        if (isset($_POST['reset_password'])) {
            $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            // Update the password in the database and remove the reset token
            $update_query = "UPDATE users SET user_password = '$hashed_password', reset_token = NULL WHERE reset_token = '$reset_token'";
            
            if (mysqli_query($conn, $update_query)) {
                echo "Your password has been successfully reset!";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Invalid or expired token.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Your Password</h2>
    
    <form method="POST" action="">
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required placeholder="Enter new password">
        
        <button type="submit" name="reset_password">Reset Password</button>
    </form>
</body>
</html>
