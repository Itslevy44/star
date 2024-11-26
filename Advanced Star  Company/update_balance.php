<?php
// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);

// Ensure the required fields are present
if (!isset($data['user_id']) || !isset($data['amount']) || !isset($data['transaction_type'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request data.']);
    exit;
}

// Extract the data
$user_id = $data['user_id'];
$amount = $data['amount'];
$transaction_type = $data['transaction_type']; // 'deposit' or 'revenue'

// Database connection (adjust these values as necessary)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "star";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get current balance for the user
$sql = "SELECT account_balance FROM balance WHERE user_id = '$user_id' LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Get the current balance
    $row = $result->fetch_assoc();
    $current_balance = $row['account_balance'];

    // Update the balance
    if ($transaction_type === 'deposit') {
        $new_balance = $current_balance + $amount;
    } else if ($transaction_type === 'revenue') {
        $new_balance = $current_balance + $amount; // Add revenue to the balance
    }

    // Update the balance in the database
    $update_sql = "UPDATE balance SET account_balance = '$new_balance' WHERE user_id = '$user_id'";
    if ($conn->query($update_sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating balance: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User not found.']);
}

$conn->close();
?>
