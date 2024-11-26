<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redeem Reward - Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .reward-message {
            margin-top: 20px;
        }
        .balance-info {
            font-size: 18px;
            margin-top: 20px;
        }
        .btn-redeem {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Redeem Your Reward</h2>
    
    <!-- Display current balance -->
    <div class="balance-info">
        <p>Your current balance: Ksh <span id="current-balance">0.00</span></p>
    </div>
    
    <!-- Reward redemption form -->
    <form id="redeem-form">
        <div class="mb-3">
            <label for="reward_code" class="form-label">Enter Reward Code</label>
            <input type="text" class="form-control" id="reward_code" name="reward_code" required>
        </div>
        <button type="submit" class="btn btn-primary btn-redeem">Redeem Reward</button>
    </form>

    <!-- Display reward message -->
    <div id="reward-message" class="reward-message alert" style="display: none;"></div>
    
    <!-- Display updated balance after redemption -->
    <div class="balance-info mt-3" id="new-balance" style="display: none;">
        <p>Your new balance is: Ksh <span id="updated-balance"></span></p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Initial balance
let currentBalance = 0;

// Function to simulate reward redemption
function redeemReward(event) {
    event.preventDefault();

    // Get the reward code input
    const rewardCode = document.getElementById('reward_code').value.trim();

    // Check if reward code is empty
    if (!rewardCode) {
        alert('Please enter a reward code.');
        return;
    }

    // Generate a random reward amount between Ksh 0 and Ksh 20
    let rewardAmount = Math.floor(Math.random() * 21);  // Random number between 0 and 20

    // Simulate the reward validation (in this case, all codes are valid)
    if (rewardCode.length === 6) {  // Assuming reward code is 6 characters long for simplicity
        // Update balance
        currentBalance += rewardAmount;

        // Display success message
        document.getElementById('reward-message').classList.remove('alert-danger');
        document.getElementById('reward-message').classList.add('alert-success');
        document.getElementById('reward-message').textContent = `Reward redeemed! You received Ksh ${rewardAmount}.`;

        // Update balance display
        document.getElementById('updated-balance').textContent = currentBalance.toFixed(2);
        document.getElementById('new-balance').style.display = 'block';
    } else {
        // Display error message for invalid code
        document.getElementById('reward-message').classList.remove('alert-success');
        document.getElementById('reward-message').classList.add('alert-danger');
        document.getElementById('reward-message').textContent = 'Invalid reward code. Please try again.';
        document.getElementById('new-balance').style.display = 'none';
    }

    // Show the reward message
    document.getElementById('reward-message').style.display = 'block';
    document.getElementById('redeem-form').reset();  // Reset the form after submission
}

// Listen for form submission
document.getElementById('redeem-form').addEventListener('submit', redeemReward);
</script>

</body>
</html>
