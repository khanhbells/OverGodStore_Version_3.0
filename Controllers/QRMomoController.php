<?php
require_once("Models/momo.php");
require_once("Models/checkout.php"); // Thêm dòng này để sử dụng mô hình checkout

class QRMomoController
{
    var $momo_model;
    var $checkout_model; // Thêm thuộc tính này

    public function __construct()
    {
        $this->momo_model = new Momo();
        $this->checkout_model = new Checkout(); // Khởi tạo đối tượng checkout
    }

    public function processPayment()
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

        $orderInfo = "Thanh toán qua MoMo";
        $amount = isset($_POST['amount']) ? $_POST['amount'] : "10000"; // Use POST amount or default to 10000
        $orderId = time() . "";
        $redirectUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
        $ipnUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
        $extraData = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $partnerCode = $_POST["partnerCode"] ?? $partnerCode;
            $accessKey = $_POST["accessKey"] ?? $accessKey;
            $secretKey = $_POST["secretKey"] ?? $secretKey;
            $orderId = $_POST["orderId"] ?? $orderId;
            $orderInfo = $_POST["orderInfo"] ?? $orderInfo;
            $amount = $_POST["amount"] ?? $amount;
            $ipnUrl = $_POST["ipnUrl"] ?? $ipnUrl;
            $redirectUrl = $_POST["redirectUrl"] ?? $redirectUrl;
            $extraData = $_POST["extraData"] ?? $extraData;

            $requestId = time() . "";
            $requestType = "captureWallet";
            $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");

            //before sign HMAC SHA256 signature
            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
            $signature = hash_hmac("sha256", $rawHash, $secretKey);

            $data = array(
                'partnerCode' => $partnerCode,
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
                'signature' => $signature
            );

            // Save the order before redirecting to MoMo
            $this->saveOrder($amount);

            $result = $this->momo_model->execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);  // decode json

            // Redirect to MoMo payment URL
            header('Location: ' . $jsonResult['payUrl']);
        }
    }

    private function saveOrder($amount)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $ThoiGian =  date('Y-m-d H:i:s');

        $data = array(
            'MaND' => $_SESSION['login']['MaND'],
            'NgayLap' => $ThoiGian,
            'NguoiNhan' => $_POST['NguoiNhan'],
            'SDT' => $_POST['SDT'],
            'DiaChi' => $_POST['DiaChi'],
            'TongTien' => $amount,
            'TrangThai' => '0', // 0: Đang xử lý, 1: Đã xử lý
        );

        $this->checkout_model->save($data);
    }
}
