<?php
class MpesaDaraja {
    private $consumerKey;
    private $consumerSecret;
    private $passkey;
    private $shortcode;
    private $env; // 'sandbox' or 'live'

    public function __construct($consumerKey, $consumerSecret) {
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
        $this->env = 'live';
        $this->passkey = 'YOUR_PASSKEY'; // Replace with actual passkey
        $this->shortcode = 'YOUR_SHORTCODE'; // Replace with actual shortcode
    }

    private function generateAccessToken() {
        $url = $this->env === 'sandbox' 
            ? 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
            : 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => ['Authorization: Basic ' . base64_encode($this->consumerKey . ':' . $this->consumerSecret)],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false
        ]);
        
        $response = curl_exec($curl);
        curl_close($curl);

        $tokenData = json_decode($response, true);
        return $tokenData['access_token'] ?? null;
    }

    public function initiateSTKPush($phone, $amount) {
        $accessToken = $this->generateAccessToken();
        if (!$accessToken) {
            return ['success' => false, 'message' => 'Token generation failed'];
        }

        $timestamp = date('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        $payload = [
            'BusinessShortCode' => $this->shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => round($amount),
            'PartyA' => $phone,
            'PartyB' => $this->shortcode,
            'PhoneNumber' => $phone,
            'CallBackURL' => 'https://yourdomain.com/mpesa-callback.php',
            'AccountReference' => 'Deposit Transaction',
            'TransactionDesc' => 'User Deposit'
        ];

        $url = $this->env === 'sandbox' 
            ? 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest'
            : 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json'
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($response, true);
        
        return $result['ResponseCode'] === '0' 
            ? ['success' => true, 'data' => $result]
            : ['success' => false, 'message' => $result['ResponseDescription'] ?? 'Unknown error'];
    }

    public function queryTransactionStatus($checkoutRequestID) {
        $accessToken = $this->generateAccessToken();
        if (!$accessToken) {
            return ['success' => false, 'message' => 'Token generation failed'];
        }

        $timestamp = date('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        $payload = [
            'BusinessShortCode' => $this->shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'CheckoutRequestID' => $checkoutRequestID
        ];

        $url = $this->env === 'sandbox'
            ? 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query'
            : 'https://api.safaricom.co.ke/mpesa/stkpushquery/v1/query';

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json'
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }
}

// Usage Example
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $mpesa = new MpesaDaraja(
        'kdTQSVSbJEh9fYMh0yIbh9kgVxvuA1HvNLLyg1RsGmdzuPJ0', 
        'JKwFAHpLyadrc72SQ0H6rgyWydY56VC07gzUlzjhZTlitONjiOR9yTikJXrq9HGz'
    );

    $result = $mpesa->initiateSTKPush(
        $data['phoneNumber'], 
        $data['amount']
    );

    echo json_encode($result);
    exit;
}
?>