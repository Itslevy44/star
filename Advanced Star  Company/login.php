<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "star";

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['signup'])) {
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $user_password = mysqli_real_escape_string($conn, $_POST['user_password']);
    $user_phoneno = mysqli_real_escape_string($conn, $_POST['user_phoneno']);
    
    // Check if email already exists
    $check_email = "SELECT * FROM users WHERE user_email='$user_email'";
    $result = mysqli_query($conn, $check_email);
    
    if(mysqli_num_rows($result) > 0) {
        $error = "Email already exists!";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO users (user_name, user_email, user_password, user_phoneno) 
                  VALUES ('$user_name', '$user_email', '$hashed_password', '$user_phoneno')";
        
        if(mysqli_query($conn, $query)) {
            $success = "Registration successful!";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}

// Login processing
if(isset($_POST['login'])) {
    $user_email = mysqli_real_escape_string($conn, $_POST['login_email']);
    $user_password = $_POST['login_password'];
    
    $query = "SELECT * FROM users WHERE user_email='$user_email'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if(password_verify($user_password, $user['user_password'])) {
            session_start();
            $_SESSION['user_name'] = $user['user_name'];
            header("Location: homepage.php");
        } else {
            $login_error = "Invalid password!";
        }
    } else {
        $login_error = "Invalid email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo.png" type="x-image icon">
    <title>User Authentication</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            width: 100%;
            max-width: 400px;
        }

        .tab-container {
            display: flex;
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
        }

        .tab {
            flex: 1;
            padding: 12px;
            text-align: center;
            background-color: #f8f9fa;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
        }

        .tab.active {
            background-color: #667eea;
            color: white;
        }

        .form-container {
            display: none;
        }

        .form-container.active {
            display: block;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #5a6fd6;
            transform: translateY(-1px);
        }

        .error {
            color: #dc3545;
            font-size: 14px;
            margin-bottom: 15px;
            padding: 10px;
            background-color: rgba(220, 53, 69, 0.1);
            border-radius: 6px;
        }

        .success {
            color: #28a745;
            font-size: 14px;
            margin-bottom: 15px;
            padding: 10px;
            background-color: rgba(40, 167, 69, 0.1);
            border-radius: 6px;
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
                    <input type="text" name="user_name"  autocomplete="off" required placeholder="Enter your name">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="user_email" autocomplete="off" required placeholder="Enter your email">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="user_password" autocomplete="off" required placeholder="Enter your password">
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="user_phoneno" autocomplete="off" required placeholder="Enter your phone number">
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
                    <input type="email" name="login_email" autocomplete="off" required placeholder="Enter your email">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="login_password" autocomplete="off"  required placeholder="Enter your password">
                </div>
                <button type="submit" name="login">Login</button>
                <a href="reset-password.php">Forgot password</a>
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