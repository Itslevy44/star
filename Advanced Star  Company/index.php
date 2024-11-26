<?php
session_start();
error_reporting(E_ALL);
include("db.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Star Bitcoin Mining Company - Advanced Platform</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="logo.png" type="x-image icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        .machine-card {
            transition: transform 0.3s ease;
        }
        .machine-card:hover {
            transform: translateY(-5px);
        }
        .mining-animation {
            animation: mine 2s infinite;
        }
        @keyframes mine {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .gradient-bg {
            background: linear-gradient(135deg, #1a237e 0%, #0d47a1 100%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
           /* backdrop-filter: blur(10px);*/
        }
        footer {
            background: #2c3e50;
            color: white;
            padding: 2rem 1rem;
            margin-top: 2rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }
    </style>
</head>
<body class="bg-gray-900 text-white min-h-screen">
    <!-- Navigation -->
    <nav class="gradient-bg shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <img src="logo.png" alt="logo"width="80px" class="rounded-full">
                    <h1 class="text-2xl font-bold text-white">Star Bitcoin Mining</h1>
                </div>
                <div class="hidden lg:flex items-center space-x-6">
                    <button onclick="showDeposit()" class="btn-nav">
                        <i class="fas fa-wallet mr-2"></i>Deposit
                    </button>
                    <button onclick="showWithdraw()" class="btn-nav">
                        <i class="fas fa-money-bill-wave mr-2"></i>Withdraw
                    </button>
                    <button onclick="showMyTeam()" class="btn-nav">
                        <i class="fas fa-users mr-2"></i>My Team
                    </button>
                    <div class="glass-effect px-4 py-2 rounded-lg">
                        <span class="text-sm">Balance:</span>
                        <span id="accountBalance" class="font-bold">KSH 0.00</span>
                    </div>
                </div>
                <button title="action" id="menuBtn" class="lg:hidden text-white">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden lg:hidden gradient-bg">
        <div class="container mx-auto px-4 py-4 space-y-4">
            <button onclick="showDeposit()" class="block w-full text-left py-2">
                <i class="fas fa-wallet mr-2"></i>Deposit
            </button>
            <button onclick="showWithdraw()" class="block w-full text-left py-2">
                <i class="fas fa-money-bill-wave mr-2"></i>Withdraw
            </button>
            <button onclick="showMyTeam()" class="block w-full text-left py-2">
                <i class="fas fa-users mr-2"></i>My Team
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Navigation Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <button onclick="showRegularMachines()" 
                class="machine-card bg-blue-600 hover:bg-blue-700 p-6 rounded-xl shadow-lg">
                <i class="fas fa-microchip text-4xl mb-4"></i>
                <h3 class="text-xl font-bold">Regular Machines</h3>
                <p class="text-sm opacity-75">Start mining with our regular machines</p>
            </button>
            <button onclick="showAdvancedLock()"
                class="machine-card bg-purple-600 hover:bg-purple-700 p-6 rounded-xl shadow-lg">
                <i class="fas fa-lock text-4xl mb-4"></i>
                <h3 class="text-xl font-bold">Advanced Lock</h3>
                <p class="text-sm opacity-75">Lock savings for higher returns</p>
            </button>
            <button onclick="showMyMachines()"
                class="machine-card bg-green-600 hover:bg-green-700 p-6 rounded-xl shadow-lg">
                <i class="fas fa-server text-4xl mb-4"></i>
                <h3 class="text-xl font-bold">My Machines</h3>
                <p class="text-sm opacity-75">View your active mining operations</p>
            </button>
        </div>

        <!-- Main Content Area -->
        <div id="mainContent" class="bg-gray-800 rounded-xl shadow-xl p-6"></div>
    </div>

    <!-- Modals -->
    <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50">
        <div class="min-h-screen px-4 text-center">
            <div class="fixed inset-0" onclick="closeModal()"></div>
            <span class="inline-block h-screen align-middle">&#8203;</span>
            <div class="inline-block w-full max-w-md p-6 my-8 text-left align-middle transition-all transform bg-gray-800 rounded-2xl shadow-xl">
                <div id="modalContent"></div>
                <button title="action" onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-white">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
    </div>
    <footer>
        <div class="footer-content">
            <div>
                <h3>About Us</h3>
                <p>Your trusted crypto mining</p>
            </div>
            <div>
                <h3>Customer Service</h3>
                <p>24/7 Support</p>
                <p>Returns Policy</p>
            </div>
            <div>
                <h3>Contact</h3>
                <p>Email: support@starbitcoinmining.com</p>
                <p>Phone: +254 718690760</p>
            </div>
        </div>
    </footer>

<script>
// Global State Management
const state = {
    userBalance: 0,
    userMachines: [],
    transactions: [],
    referrals: {
        starter: [],
        basic: [],
        advanced: [],
        pro: [],
        elite: []
    },
    phoneNumber: ''
};

// Machine Configurations
const machines = {
    starter: {
        name: "Starter Miner",
        cost: 500,
        dailyRevenue: 20,
        duration: 30,
        maxPurchase: 2,
        image: "/api/placeholder/200/200",
        description: "Perfect for beginners. Low investment, steady returns."
    },
    basic: {
        name: "Basic Miner",
        cost: 1000,
        dailyRevenue: 40,
        duration: 30,
        maxPurchase: 5,
        image: "/api/placeholder/200/200",
        description: "Upgraded mining power with better daily returns."
    },
    advanced: {
        name: "Advanced Miner",
        cost: 2500,
        dailyRevenue: 100,
        duration: 30,
        maxPurchase: 15,
        image: "/api/placeholder/200/200",
        description: "Professional grade mining machine."
    },
    pro: {
        name: "Pro Miner",
        cost: 4500,
        dailyRevenue: 170,
        duration: 30,
        maxPurchase: 20,
        image: "/api/placeholder/200/200",
        description: "High-performance mining solution."
    },
    elite: {
        name: "Elite Miner",
        cost: 10000,
        dailyRevenue: 400,
        duration: 30,
        maxPurchase: 20,
        image: "/api/placeholder/200/200",
        description: "Top-tier mining power for serious investors."
    }
};

const advancedLockMachines = {
    lock1: {
        name: "Advanced Lock Machine 1",
        cost: 20000,
        revenue: 30000,
        duration: 50,
        image: "/api/placeholder/200/200",
        description: "50-day investment lock with guaranteed returns."
    },
    lock2: {
        name: "Advanced Lock Machine 2",
        cost: 40000,
        revenue: 55000,
        duration: 50,
        image: "/api/placeholder/200/200",
        description: "Premium investment lock with maximum returns."
    }
};

// UI Functions
function showRegularMachines() {
    let content = `
        <div class="mb-6">
            <h2 class="text-2xl font-bold mb-2">Regular Mining Machines</h2>
            <p class="text-gray-400">Choose your mining power</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    `;
    
    for (const [key, machine] of Object.entries(machines)) {
        const owned = state.userMachines.filter(m => m.type === key).length;
        const canPurchase = owned < machine.maxPurchase;
        
        content += `
            <div class="machine-card bg-gray-700 rounded-xl overflow-hidden shadow-lg">
                <img src="${machine.image}" alt="${machine.name}" class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold">${machine.name}</h3>
                        <span class="bg-blue-500 rounded-full px-3 py-1 text-sm">
                            ${owned}/${machine.maxPurchase}
                        </span>
                    </div>
                    <p class="text-gray-400 text-sm mb-4">${machine.description}</p>
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between">
                            <span>Cost:</span>
                            <span class="font-bold">KSH ${machine.cost.toLocaleString()}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Daily Revenue:</span>
                            <span class="font-bold text-green-400">KSH ${machine.dailyRevenue.toLocaleString()}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Duration:</span>
                            <span>${machine.duration} days</span>
                        </div>
                    </div>
                    <button onclick="purchaseMachine('${key}')" 
                        class="w-full py-2 px-4 rounded-lg ${canPurchase ? 
                            'bg-blue-500 hover:bg-blue-600' : 'bg-gray-500 cursor-not-allowed'}"
                        ${!canPurchase ? 'disabled' : ''}>
                        ${canPurchase ? 'Purchase' : 'Max Limit Reached'}
                    </button>
                </div>
            </div>
        `;
    }
    content += '</div>';
    document.getElementById('mainContent').innerHTML = content;
}

function showAdvancedLock() {
    let content = `
        <div class="mb-6">
            <h2 class="text-2xl font-bold mb-2">Advanced Lock Machines</h2>
            <p class="text-gray-400">Lock your investment for guaranteed returns</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    `;
    
    for (const [key, machine] of Object.entries(advancedLockMachines)) {
        content += `
            <div class="machine-card bg-gray-700 rounded-xl overflow-hidden shadow-lg">
                <img src="${machine.image}" alt="${machine.name}" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-4">${machine.name}</h3>
                    <p class="text-gray-400 text-sm mb-4">${machine.description}</p>
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between">
                            <span>Investment:</span>
                            <span class="font-bold">KSH ${machine.cost.toLocaleString()}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Return:</span>
                            <span class="font-bold text-green-400">KSH ${machine.revenue.toLocaleString()}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Lock Period:</span>
                            <span>${machine.duration} days</span>
                        </div>
                    </div>
                    <button onclick="purchaseAdvancedLock('${key}')" 
                        class="w-full py-2 px-4 rounded-lg bg-purple-500 hover:bg-purple-600">
                        Lock Investment
                    </button>
                </div>
            </div>
        `;
    }
    content += '</div>';
    document.getElementById('mainContent').innerHTML = content;
}

function showMyMachines() {
    let content = `
        <div class="mb-6">
            <h2 class="text-2xl font-bold mb-2">My Mining Operations</h2>
            <p class="text-gray-400">Monitor your active machines and earnings</p>
        </div>
    `;
    
    if (state.userMachines.length === 0) {
        content += `
            <div class="text-center py-12">
                <i class="fas fa-server text-6xl text-gray-600 mb-4"></i>
                <p class="text-gray-400">You don't have any active machines yet</p>
                <button onclick="showRegularMachines()" 
                    class="mt-4 bg-blue-500 hover:bg-blue-600 py-2 px-4 rounded-lg">
                    Browse Machines
                </button>
            </div>
        `;
    } else {
        content += `
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        `;
        state.userMachines.forEach((machine, index) => {
            const machineConfig = machines[machine.type];
            const progress = ((machineConfig.duration - machine.daysRemaining) / machineConfig.duration) * 100;
            
            content += `
                <div class="bg-gray-700 rounded-xl overflow-hidden shadow-lg">
                    <div class="p-6">
    <h3 class="text-xl font-bold mb-4">${machineConfig.name}</h3>
    <div class="relative w-full h-2 bg-gray-600 rounded-full mb-4">
        <div class="absolute left-0 top-0 h-full bg-green-500 rounded-full"
            style="width: ${progress}%"></div>
    </div>
    <div class="space-y-2">
        <div class="flex justify-between">
            <span>Daily Revenue:</span>
            <span class="text-green-400">KSH ${machineConfig.dailyRevenue.toLocaleString()}</span>
        </div>
        <div class="flex justify-between">
            <span>Days Remaining:</span>
            <span>${machine.daysRemaining}</span>
        </div>
        <div class="flex justify-between">
            <span>Total Earned:</span>
            <span class="text-green-400">KSH ${machine.totalEarned.toLocaleString()}</span>
        </div>
    </div>
    <div class="mt-4 p-2 bg-gray-800 rounded-lg text-sm">
        <div class="mining-animation text-center">
            <i class="fas fa-cog spin text-blue-400 mr-2"></i>
            Mining in progress...
        </div>
    </div>
</div>
`;
        });
        content += '</div>';
    }
    document.getElementById('mainContent').innerHTML = content;
}

function showMyTeam() {
    const referralLink = generateReferralLink();
    let content = `
        <div class="mb-6">
            <h2 class="text-2xl font-bold mb-2">My Team & Referrals</h2>
            <p class="text-gray-400">Grow your team and earn rewards</p>
        </div>
        
        <div class="bg-gray-700 rounded-xl p-6 mb-6">
            <h3 class="text-xl font-bold mb-4">Your Referral Link</h3>
            <div class="flex items-center space-x-2">
                <input type="text" value="${referralLink}" 
                    class="flex-1 bg-gray-800 border border-gray-600 rounded-lg px-4 py-2 text-sm" 
                    readonly>
                <button onclick="copyReferralLink()" 
                    class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-lg">
                    <i class="fas fa-copy mr-2"></i>Copy
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-gray-700 rounded-xl p-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-400 mb-2">
                        ${state.referrals.starter.length}/5
                    </div>
                    <p class="text-sm text-gray-400">Starter Referrals</p>
                    <div class="mt-2 text-xs">
                        Reward: KSH 1,000
                    </div>
                </div>
            </div>
            <div class="bg-gray-700 rounded-xl p-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-400 mb-2">
                        ${state.referrals.basic.length}/10
                    </div>
                    <p class="text-sm text-gray-400">Basic Referrals</p>
                    <div class="mt-2 text-xs">
                        Reward: KSH 2,000
                    </div>
                </div>
            </div>
            <div class="bg-gray-700 rounded-xl p-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-400 mb-2">
                        ${state.referrals.advanced.length + state.referrals.pro.length + state.referrals.elite.length}
                    </div>
                    <p class="text-sm text-gray-400">Advanced+ Referrals</p>
                    <div class="mt-2 text-xs">
                        Reward: KSH 500 each
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-700 rounded-xl p-6">
            <h3 class="text-xl font-bold mb-4">Team Members</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left">
                            <th class="pb-4">Member</th>
                            <th class="pb-4">Machine Type</th>
                            <th class="pb-4">Purchase Date</th>
                            <th class="pb-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-400">
                        ${generateTeamMemberRows()}
                    </tbody>
                </table>
            </div>
        </div>
    `;
    document.getElementById('mainContent').innerHTML = content;
}

function showDeposit() {
    let content = `
        <h2 class="text-2xl font-bold mb-6">Deposit Funds</h2>
        <form onsubmit="handleDeposit(event)" class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-2">Phone Number</label>
                <input type="tel" id="depositPhone"  autocomplete="off" required
                    class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2"
                    placeholder="254XXXXXXXXX">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Amount (KSH)</label>
                <input type="number" id="depositAmount" required min="100"
                    class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2"
                    placeholder="Enter amount">
            </div>
            <button type="submit" 
                class="w-full bg-green-500 hover:bg-green-600 py-2 rounded-lg">
                <i class="fas fa-money-bill-wave mr-2"></i>
                Deposit via M-PESA
            </button>
        </form>
    `;
    showModal(content);
}

function showWithdraw() {
    let content = `
        <h2 class="text-2xl font-bold mb-6">Withdraw Funds</h2>
        <form onsubmit="handleWithdraw(event)" class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-2">Phone Number</label>
                <input type="tel" id="withdrawPhone" autocomlete="off" required
                    class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2"
                    placeholder="254XXXXXXXXX">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Amount (KSH)</label>
                <input type="number" id="withdrawAmount" required min="200"
                    class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2"
                    placeholder="Minimum: KSH 200">
            </div>
            <p class="text-sm text-gray-400">
                Available balance: KSH ${state.userBalance.toLocaleString()}
            </p>
            <button type="submit" 
                class="w-full bg-green-500 hover:bg-green-600 py-2 rounded-lg">
                <i class="fas fa-money-bill-wave mr-2"></i>
                Withdraw to M-PESA
            </button>
        </form>
        
        <div class="mt-6">
            <h3 class="font-bold mb-2">Recent Withdrawals</h3>
            <div class="space-y-2">
                ${generateWithdrawalHistory()}
            </div>
        </div>
    `;
    showModal(content);
}

//deposit
// Function to validate the phone number format (Kenyan format)
function validatePhoneNumber(phone) {
    const phoneRegex = /^(?:254|\+254|0)?(7\d{8})$/; // Validates '254' or '0' followed by 9 digits
    const match = phone.match(phoneRegex);
    if (!match) {
        return false;
    }
    return '254' + match[1]; // Return the valid phone number in the '254XXXXXXXXX' format
}

// Function to validate the deposit amount
function validateAmount(amount) {
    return amount >= 100 && amount <= 150000;
}

async function handleDeposit(event) {
    event.preventDefault();

    const phone = document.getElementById('depositPhone').value;
    const amount = parseFloat(document.getElementById('depositAmount').value);

    const validPhone = validatePhoneNumber(phone);
    const validAmount = validateAmount(amount);

    if (!validPhone || !validAmount) {
        showNotification('Invalid phone or amount', 'error');
        return;
    }

    try {
        // Send request to PHP Daraja script
        const response = await fetch('/mpesa-integration.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                phoneNumber: validPhone,
                amount: amount
            })
        });

        const result = await response.json();

        if (result.success) {
            // Proceed with database saving logic from previous code
            const depositData = {
                user_id: Math.floor(Math.random() * 1000),
                balance_id: Math.floor(Math.random() * 100),
                amount: amount,
                mpesaCode: result.data.CheckoutRequestID,
                transactionDate: new Date().toISOString(),
                phoneNumber: validPhone
            };

            const dbResponse = await saveDepositToDatabase(depositData);

            if (dbResponse.success) {
                showNotification('Deposit initiated successfully', 'success');
            }
        } else {
            showNotification(result.message, 'error');
        }
    } catch (error) {
        console.error('Deposit Error:', error);
        showNotification('Deposit failed', 'error');
    }
}

//withdraw


async function handleWithdraw(event) {
    event.preventDefault();
    const phone = document.getElementById('withdrawPhone').value;
    const amount = parseFloat(document.getElementById('withdrawAmount').value);

    if (amount < 200) {
        showNotification('Minimum withdrawal amount is KSH 200', 'error');
        return;
    }

    if (amount > state.userBalance) {
        showNotification('Insufficient balance', 'error');
        return;
    }

    try {
        // Generate unique withdrawal request ID
        const withdrawalRequestId = `WDR-${Date.now()}-${Math.random().toString(36).substr(2, 5)}`;

        // Prepare withdrawal data to send to server
        const withdrawalData = new FormData();
        withdrawalData.append('phone', phone);
        withdrawalData.append('amount', amount);
        withdrawalData.append('withdrawalRequestId', withdrawalRequestId);

        // Send withdrawal details to server
        const response = await fetch('process_withdrawal.php', {
            method: 'POST',
            body: withdrawalData
        });

        const result = await response.json();
        
        if (result.success) {
            updateBalance(-amount);
            state.transactions.push({
                type: 'withdrawal',
                amount: amount,
                phone: phone,
                date: new Date(),
                status: 'success'
            });
            closeModal();
            showNotification('Withdrawal submitted successfully!', 'success');
        } else {
            showNotification(result.message || 'Withdrawal submission failed', 'error');
        }
    } catch (error) {
        console.error('Withdrawal error:', error);
        showNotification('Withdrawal submission failed. Please try again.', 'error');
    }
}
// Helper Functions
function generateReferralLink() {
    const userId = Math.random().toString(36).substr(2, 9);
    return `https://starbitcoin.com/ref/${userId}`;
}

function generateTeamMemberRows() {
    const allReferrals = [
        ...state.referrals.starter,
        ...state.referrals.basic,
        ...state.referrals.advanced,
        ...state.referrals.pro,
        ...state.referrals.elite
    ];

    if (allReferrals.length === 0) {
        return `
            <tr>
                <td colspan="4" class="text-center py-4">
                    No team members yet
                </td>
            </tr>
        `;
    }

    return allReferrals.map(referral => `
        <tr class="border-t border-gray-600">
            <td class="py-4">${referral.name}</td>
            <td class="py-4">${referral.machineType}</td>
            <td class="py-4">${formatDate(referral.date)}</td>
            <td class="py-4">
                <span class="px-2 py-1 rounded-full text-xs ${
                    referral.active ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400'
                }">
                    ${referral.active ? 'Active' : 'Inactive'}
                </span>
            </td>
        </tr>
    `).join('');
}

function generateWithdrawalHistory() {
    const withdrawals = state.transactions.filter(t => t.type === 'withdrawal');
    
    if (withdrawals.length === 0) {
        return '<p class="text-gray-400 text-sm">No withdrawal history</p>';
    }

    return withdrawals.map(withdrawal => `
        <div class="flex justify-between items-center text-sm">
            <div>
                <div>${formatDate(withdrawal.date)}</div>
                <div class="text-gray-400">${withdrawal.phone}</div>
            </div>
            <div class="text-right">
                <div class="text-red-400">-KSH ${withdrawal.amount.toLocaleString()}</div>
                <div class="text-xs ${
                    withdrawal.status === 'success' ? 'text-green-400' : 'text-red-400'
                }">${withdrawal.status}</div>
            </div>
        </div>
    `).join('');
}

function showNotification(message, type = 'info') {
    // Implementation for showing notifications
}

function formatDate(date) {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

// Initialize
document.getElementById('menuBtn').addEventListener('click', () => {
    document.getElementById('mobileMenu').classList.toggle('hidden');
});

// Start with regular machines view
showRegularMachines();

// Simulate mining rewards every 24 hours
setInterval(() => {
    state.userMachines.forEach(machine => {
        if (machine.daysRemaining > 0) {
            const machineConfig = machines[machine.type];
            machine.totalEarned += machineConfig.dailyRevenue;
            machine.daysRemaining--;
            updateBalance(machineConfig.dailyRevenue);
        }
    });
    showMyMachines();
}, 24 * 60 * 60 * 1000);
// Add these functions after the existing helper functions but before initialization

// Purchase Functions
async function purchaseMachine(machineType) {
    const machine = machines[machineType];
    if (!machine) {
        showNotification('Invalid machine type', 'error');
        return;
    }

    if (state.userBalance < machine.cost) {
        showNotification('Insufficient balance. Please deposit funds.', 'error');
        showDeposit();
        return;
    }

    const owned = state.userMachines.filter(m => m.type === machineType).length;
    if (owned >= machine.maxPurchase) {
        showNotification('Maximum purchase limit reached for this machine', 'error');
        return;
    }

    // Deduct cost from balance
    updateBalance(-machine.cost);

    // Add new machine to user's collection
    state.userMachines.push({
        type: machineType,
        purchaseDate: new Date(),
        daysRemaining: machine.duration,
        totalEarned: 0
    });

    showNotification(`Successfully purchased ${machine.name}!`, 'success');
    showMyMachines();
}

async function purchaseAdvancedLock(lockType) {
    const machine = advancedLockMachines[lockType];
    if (!machine) {
        showNotification('Invalid lock machine type', 'error');
        return;
    }

    if (state.userBalance < machine.cost) {
        showNotification('Insufficient balance. Please deposit funds.', 'error');
        showDeposit();
        return;
    }

    // Deduct cost from balance
    updateBalance(-machine.cost);

    // Add new locked investment
    state.userMachines.push({
        type: lockType,
        purchaseDate: new Date(),
        daysRemaining: machine.duration,
        totalEarned: 0,
        isLocked: true,
        finalPayout: machine.revenue
    });

    showNotification(`Successfully purchased ${machine.name}!`, 'success');
    showMyMachines();
}

// Balance Management
function updateBalance(amount) {
    state.userBalance += amount;
    document.getElementById('accountBalance').textContent = `KSH ${state.userBalance.toLocaleString()}`;
}

// Modal Management
function showModal(content) {
    document.getElementById('modalContent').innerHTML = content;
    document.getElementById('modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}

// M-PESA Integration Placeholders (replace with actual Daraja API integration)
async function initiateSTKPush(phone, amount) {
    // Simulate API call
    return new Promise((resolve) => {
        setTimeout(() => {
            resolve({ success: true });
        }, 1000);
    });
}

async function initiateB2CPayment(phone, amount) {
    // Simulate API call
    return new Promise((resolve) => {
        setTimeout(() => {
            resolve({ success: true });
        }, 1000);
    });
}

// Enhanced Notification System
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg transition-all transform translate-y-0 opacity-100 ${
        type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500'
    }`;
    notification.textContent = message;

    document.body.appendChild(notification);

    // Animate out after 3 seconds
    setTimeout(() => {
        notification.style.transform = 'translateY(100%)';
        notification.style.opacity = '0';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Copy Referral Link Function
function copyReferralLink() {
    const referralLink = generateReferralLink();
    navigator.clipboard.writeText(referralLink)
        .then(() => showNotification('Referral link copied to clipboard!', 'success'))
        .catch(() => showNotification('Failed to copy referral link', 'error'));
}
function showMyMachines() {
    let content = `
        <div class="mb-6">
            <h2 class="text-2xl font-bold mb-2">My Mining Operations</h2>
            <p class="text-gray-400">Monitor your active machines and earnings</p>
        </div>
    `;
    
    if (!state.userMachines || state.userMachines.length === 0) {
        content += `
            <div class="text-center py-12 bg-gray-700 rounded-xl">
                <i class="fas fa-server text-6xl text-gray-600 mb-4"></i>
                <p class="text-gray-400 mb-4">You don't have any active machines yet</p>
                <button onclick="showRegularMachines()" 
                    class="mt-4 bg-blue-500 hover:bg-blue-600 py-2 px-4 rounded-lg">
                    Browse Machines
                </button>
            </div>
        `;
    } else {
        content += `
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        `;
        
        state.userMachines.forEach((machine, index) => {
            // Check if it's a regular machine or locked investment
            if (machine.isLocked) {
                // Handle locked investment display
                const lockMachine = advancedLockMachines[machine.type];
                const progress = ((lockMachine.duration - machine.daysRemaining) / lockMachine.duration) * 100;
                
                content += `
                    <div class="bg-gray-700 rounded-xl overflow-hidden shadow-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-4">${lockMachine.name}</h3>
                            <div class="relative w-full h-2 bg-gray-600 rounded-full mb-4">
                                <div class="absolute left-0 top-0 h-full bg-purple-500 rounded-full"
                                    style="width: ${progress}%;"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span>Investment:</span>
                                    <span>KSH ${lockMachine.cost.toLocaleString()}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Expected Return:</span>
                                    <span class="text-green-400">KSH ${lockMachine.revenue.toLocaleString()}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Days Remaining:</span>
                                    <span>${machine.daysRemaining}</span>
                                </div>
                            </div>
                            <div class="mt-4 p-2 bg-gray-800 rounded-lg text-sm">
                                <div class="mining-animation text-center">
                                    <i class="fas fa-lock text-purple-400 mr-2"></i>
                                    Locked Investment
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                // Handle regular machine display
                const machineConfig = machines[machine.type];
                const progress = ((machineConfig.duration - machine.daysRemaining) / machineConfig.duration) * 100;
                const dailyRevenue = machineConfig.dailyRevenue;
                
                content += `
                    <div class="bg-gray-700 rounded-xl overflow-hidden shadow-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-xl font-bold">${machineConfig.name}</h3>
                                <span class="text-xs bg-blue-500 px-2 py-1 rounded-full">
                                    Active
                                </span>
                            </div>
                            <div class="relative w-full h-2 bg-gray-600 rounded-full mb-4">
                                <div class="absolute left-0 top-0 h-full bg-green-500 rounded-full"
                                    style="width: ${progress}%;"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span>Daily Revenue:</span>
                                    <span class="text-green-400">KSH ${dailyRevenue.toLocaleString()}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Days Remaining:</span>
                                    <span>${machine.daysRemaining}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Total Earned:</span>
                                    <span class="text-green-400">KSH ${machine.totalEarned.toLocaleString()}</span>
                                </div>
                            </div>
                            <div class="mt-4 p-2 bg-gray-800 rounded-lg text-sm">
                                <div class="mining-animation text-center">
                                    <i class="fas fa-cog fa-spin text-blue-400 mr-2"></i>
                                    Mining in progress...
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
        });
        
        // Add summary section
        const totalDailyRevenue = state.userMachines.reduce((total, machine) => {
            if (!machine.isLocked) {
                return total + machines[machine.type].dailyRevenue;
            }
            return total;
        }, 0);
        
        content += `
            </div>
            <div class="mt-6 bg-gray-700 rounded-xl p-6">
                <h3 class="text-xl font-bold mb-4">Mining Summary</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-800 rounded-lg p-4">
                        <div class="text-sm text-gray-400">Total Machines</div>
                        <div class="text-2xl font-bold">${state.userMachines.length}</div>
                    </div>
                    <div class="bg-gray-800 rounded-lg p-4">
                        <div class="text-sm text-gray-400">Daily Revenue</div>
                        <div class="text-2xl font-bold text-green-400">KSH ${totalDailyRevenue.toLocaleString()}</div>
                    </div>
                    <div class="bg-gray-800 rounded-lg p-4">
                        <div class="text-sm text-gray-400">Total Earned</div>
                        <div class="text-2xl font-bold text-green-400">
                            KSH ${state.userMachines.reduce((total, machine) => total + (machine.totalEarned || 0), 0).toLocaleString()}
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    document.getElementById('mainContent').innerHTML = content;
    
    // Add spin animation for mining icons
    const style = document.createElement('style');
    style.textContent = `
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .fa-spin {
            animation: spin 2s linear infinite;
        }
        .mining-animation {
            transition: all 0.3s ease;
        }
        .mining-animation:hover {
            transform: scale(1.05);
        }
    `;
    document.head.appendChild(style);
}

// Add this mining simulation function
function startMiningSimulation() {
    // Simulate mining rewards every minute (for testing - change to 24 hours in production)
    setInterval(() => {
        let totalReward = 0;
        state.userMachines.forEach(machine => {
            if (machine.daysRemaining > 0) {
                if (machine.isLocked) {
                    // Handle locked investment
                    if (machine.daysRemaining === 1) {
                        // Final day - give full payout
                        totalReward += machine.finalPayout;
                    }
                } else {
                    // Regular machine
                    const machineConfig = machines[machine.type];
                    const reward = machineConfig.dailyRevenue;
                    machine.totalEarned = (machine.totalEarned || 0) + reward;
                    totalReward += reward;
                }
                machine.daysRemaining--;
            }
        });
        
        if (totalReward > 0) {
            updateBalance(totalReward);
            showNotification(`Mining Reward: KSH ${totalReward.toLocaleString()}`, 'success');
            // Refresh the display if we're on the my machines page
            if (document.querySelector('h2')?.textContent.includes('Mining Operations')) {
                showMyMachines();
            }
        }
    },10000); // Every minute for testing - change to 24 * 60 * 60 * 1000 for production
}

// Call this function during initialization
document.addEventListener('DOMContentLoaded', () => {
    startMiningSimulation();
});

</script>

</body>
</html>
