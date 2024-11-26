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

// Fetch users and their purchased machines
$query = "
    SELECT users.user_name, users.user_email, users.user_phoneno, machines.machine_type 
    FROM users 
    LEFT JOIN machines ON users.user_id = machines.user_id
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-table th, .user-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .user-table th {
            background-color: #4CAF50;
            color: white;
        }

        .user-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .user-table tr:hover {
            background-color: #ddd;
        }

        .user-table td {
            color: #333;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <h1>Admin Dashboard</h1>
        
        <table class="user-table">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Machine Type</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$row['user_name']}</td>
                                <td>{$row['user_email']}</td>
                                <td>{$row['user_phoneno']}</td>
                                <td>" . ($row['machine_type'] ? $row['machine_type'] : 'No machine purchased') . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No users found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
