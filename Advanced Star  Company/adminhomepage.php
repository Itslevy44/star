<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "star";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination setup
$results_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $results_per_page;

// Fetch withdrawal statistics
$stats_query = "SELECT 
    COUNT(*) AS total_requests,
    SUM(CASE WHEN withdrawalRequestID = 'pending' THEN 1 ELSE 0 END) AS pending_requests,
    SUM(CASE WHEN withdrawalRequestID = 'approved' THEN 1 ELSE 0 END) AS approved_requests,
    SUM(amount) AS total_withdrawal_amount
FROM withdrawal_requests";
$stats_result = $conn->query($stats_query);

if ($stats_result) {
    $stats = $stats_result->fetch_assoc();
} else {
    $stats = [
        'total_requests' => 0,
        'pending_requests' => 0,
        'approved_requests' => 0,
        'total_withdrawal_amount' => 0.00,
    ];
}

// Filter options
$status = isset($_GET['status']) ? $_GET['status'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Modify query based on filters
$where_clause = [];
if (!empty($status)) {
    $where_clause[] = "withdrawalRequestID = '" . $conn->real_escape_string($status) . "'";
}
if (!empty($search)) {
    $where_clause[] = "phone LIKE '%" . $conn->real_escape_string($search) . "%'";
}
$where_sql = !empty($where_clause) ? "WHERE " . implode(" AND ", $where_clause) : "";

$query = "SELECT 
    withdrawalID AS id, 
    phone AS username, 
    amount, 
    withdrawalRequestID AS status, 
    'Bank Transfer' AS payment_method, 
    request_date AS created_at 
FROM 
    withdrawal_requests 
$where_sql
ORDER BY 
    request_date DESC
LIMIT $results_per_page OFFSET $offset";

$result = $conn->query($query);
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Calculate total pages
$total_query = "SELECT COUNT(*) AS total FROM withdrawal_requests $where_sql";
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_pages = ceil($total_row['total'] / $results_per_page);
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action']; // 'approve' or 'reject'
    $id = (int)$_GET['id'];    // The withdrawal ID

    if ($action == 'approve' || $action == 'reject') {
        // Sanitize inputs and perform the update based on action
        $status = ($action == 'approve') ? 'approved' : 'rejected';

        // Update query to change the withdrawal status
        $update_query = "UPDATE withdrawal_requests SET withdrawalRequestID = '$status' WHERE withdrawalID = $id";
        
        // Execute the update query
        if ($conn->query($update_query)) {
            // Redirect to refresh the page after the action
            header("Location: adminhomepage.php");
            exit; // Make sure no further code runs after the redirect
        } else {
            echo "Error updating status: " . $conn->error;
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Withdrawal Dashboard</title>
    <link rel="icon" href="logo.png" type="x-image icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .dashboard-card { transition: transform 0.3s; }
        .dashboard-card:hover { transform: scale(1.05); }
        @media (max-width: 768px) {
            .dashboard-card .card-body { padding: 10px; }
            .dashboard-card .card-text { font-size: 24px; }
        }
    </style>
</head>
<body>
    
<div class="container-fluid">
    <!-- Navigation -->
    <nav class="gradient-bg shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <img src="logo.png" alt="logo"width="80px" class="rounded-full">
                    <h1 class="text-2xl font-bold text-gold">Star Bitcoin Mining</h1>
                </div>
                <h2>ADMIN DASHBOARD</h2>
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 bg-light sidebar">
            <div class="position-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link active" href="#">Withdrawal Requests</a></li>
                    <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="generatereward.php">Generate Reward</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Settings</a></li>
                   
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto">
            <div class="row my-4">
                <!-- Summary Cards -->
                <div class="col-md-3">
                    <div class="card text-white bg-primary dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Requests</h5>
                            <p class="card-text display-4"><?php echo $stats['total_requests']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title">Pending Requests</h5>
                            <p class="card-text display-4"><?php echo $stats['pending_requests']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title">Approved Requests</h5>
                            <p class="card-text display-4"><?php echo $stats['approved_requests']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-danger dashboard-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Withdrawn</h5>
                            <p class="card-text display-4">Ksh 
                                <br>
                                <?php echo number_format($stats['total_withdrawal_amount'], 2); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Form -->
            <form method="GET" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            <option value="pending" <?php echo $status == 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="approved" <?php echo $status == 'approved' ? 'selected' : ''; ?>>Approved</option>
                            <option value="rejected" <?php echo $status == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Search by username" value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>

            <!-- Withdrawal Requests Table -->
            <div class="card mt-4">
                <div class="card-header"><h3>Withdrawal Requests</h3></div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Payment Method</th>
                                <th>Requested At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td>ksh<?php echo number_format($row['amount'], 2); ?></td>
                                <td>
                                    <span class="badge 
                                    <?php 
                                    echo $row['status'] === 'pending' ? 'bg-warning' : 
                                         ($row['status'] === 'approved' ? 'bg-success' : 'bg-danger');
                                    ?>">
                                        <?php echo ucfirst($row['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                                <td><?php echo date('Y-m-d H:i', strtotime($row['created_at'])); ?></td>
                                <td>
                                    <div class="btn-group">
                                    <td>
    <div class="btn-group">
        <a href="?action=approve&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success">Approve</a>
        <a href="?action=reject&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Reject</a>
    </div>
</td>
                                </td>
                            </tr>
                           


                            <!-- User Detail Modal -->
<div class="modal fade" id="userDetailModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="modalTitle<?php echo $row['id']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle<?php echo $row['id']; ?>">User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Username:</strong> <?php echo htmlspecialchars($row['username'] ?? 'Not provided'); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email'] ?? 'Not provided'); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($row['phone'] ?? 'Not provided'); ?></p>
                <p><strong>Withdrawal Amount:</strong> $<?php echo number_format($row['amount'], 2); ?></p>
            </div>
        </div>
    </div>
</div>

                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
