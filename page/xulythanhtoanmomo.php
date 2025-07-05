<?php
function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
}

// Kết nối database
require_once '../backend/database.php';
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";


$partnerCode = 'MOMOBKUN20180529';
$accessKey = 'klm05TvNBzhg7h7j';
$secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
$orderInfo = "Thanh toán qua MoMo";
$amount = isset($_POST['total_amount']) ? (int)$_POST['total_amount'] : 10000;
$orderId = time() ."";
$redirectUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
$ipnUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
$extraData = "";



// Lưu đơn hàng vào database trước khi chuyển sang MoMo
$status = 'pending';
$created_at = date('Y-m-d H:i:s');
$conn = $GLOBALS['conn'];
$stmt = $conn->prepare("INSERT INTO orders (user_id, amount, order_id, status, created_at) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iisss", $user_id, $amount, $orderId, $status, $created_at);
$stmt->execute();
$stmt->close();

    $requestId = time() . "";
    $requestType = "captureWallet";
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    $signature = hash_hmac("sha256", $rawHash, $secretKey);
    $data = array('partnerCode' => $partnerCode,
        'partnerName' => "Test",
        "storeId" => "MomoTestStore",
        'requestId' => $requestId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl' => $ipnUrl,
        'lang' => 'vi',
        'extraData' => $extraData,
        'requestType' => $requestType,
        'signature' => $signature);
    $result = execPostRequest($endpoint, json_encode($data));
    $jsonResult = json_decode($result, true);  // decode json

    if (isset($jsonResult['payUrl'])) {
        header('Location: ' . $jsonResult['payUrl']);
        exit();
    } else {
        echo '<h2 style="color:red;text-align:center;">Lỗi khi tạo thanh toán MoMo!</h2>';
        if (isset($jsonResult['message'])) {
            echo '<p style="text-align:center;">' . htmlspecialchars($jsonResult['message']) . '</p>';
        }
       
    }
?>