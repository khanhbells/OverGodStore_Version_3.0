<?php
require_once("Models/momoATM.php");

class ATMMomoController
{
    var $momoATM_model;

    public function __construct()
    {
        $this->momoATM_model = new momoATM();
    }

    public function processPayment()
    {
        // Retrieve POST data
        $amount = $_POST['amount'];
        $NguoiNhan = $_POST['NguoiNhan'];
        $SDT = $_POST['SDT'];
        $DiaChi = $_POST['DiaChi'];

        // Lưu thông tin vào session
        $_SESSION['payment_info'] = [
            'NguoiNhan' => $NguoiNhan,
            'SDT' => $SDT,
            'DiaChi' => $DiaChi
        ];

        // Generate orderId and other necessary parameters
        $orderId = time() . "";
        $orderInfo = "Thanh toán qua MoMo ATM";
        $redirectUrl = "http://localhost:81/closthingstore/index.php?act=checkout&xuli=save";
        $ipnUrl = "http://localhost:81/closthingstore/index.php?act=checkout&xuli=save";
        $extraData = ""; // You can include additional data here if necessary

        // Create payment
        $result = $this->momoATM_model->createPayment($amount, $orderInfo, $orderId, $redirectUrl, $ipnUrl, $extraData);

        // Redirect to MoMo payment URL
        if (isset($result['payUrl'])) {
            header('Location: ' . $result['payUrl']);
        } else {
            echo "Có lỗi xảy ra khi tạo thanh toán.";
        }
    }
}
