<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "star";

// Response array
$response = [
    'success' => false,
    'message' => 'Unknown error occurred'
];

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Sanitize and validate input
    $phone = $conn->real_escape_string($_POST['phone'] ?? '');
    $amount = floatval($_POST['amount'] ?? 0);
    $withdrawalRequestId = $conn->real_escape_string($_POST['withdrawalRequestId'] ?? '');

    // Validate input
    if (empty($phone) || $amount <= 0 || empty($withdrawalRequestId)) {
        throw new Exception("Invalid withdrawal details");
    }

    // Prepare SQL to insert withdrawal request
    $sql = "INSERT INTO withdrawal_requests (amount, phone, withdrawalRequestid) 
            VALUES (?, ?, ?)";
    
    // Prepare statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dss", $amount, $phone, $withdrawalRequestId);

    // Execute statement
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Withdrawal request submitted successfully';
    } else {
        throw new Exception("Failed to submit withdrawal request");
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

// Send JSON response
echo json_encode($response);
?>