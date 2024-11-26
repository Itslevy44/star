<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'star';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
}

// Read the request data
$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody, true);

if (!isset($data['user_id'], $data['balance_id'], $data['amount'], $data['phoneNumber'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request data.']);
    exit;
}

// Generate unique transaction ID
$transaction_id = rand(1000, 9999); // Generate a random integer ID

$user_id = $data['user_id'];
$balance_id = $data['balance_id'];
$amount = $data['amount'];
$phoneNumber = $data['phoneNumber'];
$mpesaCode = 'MPESA' . rand(10000, 99999); // Generate mock MPESA code
$transactionDate = date('Y-m-d'); // Current date

$sql = "INSERT INTO deposit (Transaction_id, user_id, balance_id, Amount, MpesaCode, TransactionDate, PhoneNumber) 
        VALUES ($transaction_id, '$user_id', $balance_id, $amount, '$mpesaCode', '$transactionDate', '$phoneNumber')";

if ($conn->query($sql) === TRUE) {
    echo json_encode([
        'success' => true, 
        'message' => 'Deposit saved successfully.',
        'transaction_id' => $transaction_id,
        'mpesa_code' => $mpesaCode
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to save deposit: ' . $conn->error]);
}

$conn->close();
?>