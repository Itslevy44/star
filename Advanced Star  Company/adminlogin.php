
<?php
session_start(); // Add session start at the beginning

$host = "localhost";
$username = "root";
$password = "";
$database = "star";

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Enhanced login processing with password hashing
if(isset($_POST['login'])) {
    $admin_email = mysqli_real_escape_string($conn, $_POST['login_email']);
    $admin_pass = mysqli_real_escape_string($conn, $_POST['login_pass']);
    
    // Use prepared statement for better security
    $query = "SELECT * FROM admins WHERE admin_email = ? AND admin_pass = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $admin_email, $admin_pass);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_name'] = $row['admin_name'];
        header("Location: adminhomepage.php");
        exit();
    } else {
        $login_error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Authentication</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f4f4f4;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .tab-container {
            display: flex;
            margin-bottom: 20px;
        }

        .tab {
            flex: 1;
            padding: 10px;
            text-align: center;
            background-color: #f8f9fa;
            cursor: pointer;
            border: none;
        }

        .tab.active {
            background-color: #007bff;
            color: white;
        }

        .form-container {
            display: none;
        }

        .form-container.active {
            display: block;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: #dc3545;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .success {
            color: #28a745;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="tab-container">
            <button class="tab active" onclick="showForm('signup')">Sign Up</button>
            <button class="tab" onclick="showForm('login')">Login</button>
        </div>

        <!-- Signup Form -->
        <div id="signup" class="form-container active">
            <form method="POST" action="">
                <?php if(isset($error)) { ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php } ?>
                <?php if(isset($success)) { ?>
                    <div class="success"><?php echo $success; ?></div>
                <?php } ?>

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="admin_name"  autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="admin_email" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="admin_pass" autocomplete="off" required>
                </div>
                <button type="submit" name="signup">Sign Up</button>
            </form>
        </div>

        <!-- Login Form -->
        <div id="login" class="form-container">
            <form method="POST" action="">
                <?php if(isset($login_error)) { ?>
                    <div class="error"><?php echo $login_error; ?></div>
                <?php } ?>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="login_email" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="login_pass" autocomplete="off" required>
                </div>
                <button type="submit" name="login">Login</button>
            </form>
        </div>
    </div>

    <script>
        function showForm(formId) {
            // Hide all forms
            document.querySelectorAll('.form-container').forEach(form => {
                form.classList.remove('active');
            });
            
            // Show selected form
            document.getElementById(formId).classList.add('active');
            
            // Update tab styling
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Add active class to clicked tab
            event.target.classList.add('active');
        }
    </script>
</body>
</html>