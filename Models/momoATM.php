<?php
class momoATM
{
    private $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
    private $partnerCode = 'MOMOBKUN20180529';
    private $accessKey = 'klm05TvNBzhg7h7j';
    private $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function createPayment($amount, $orderInfo, $orderId, $redirectUrl, $ipnUrl, $extraData = "")
    {
        $requestId = time() . "";
        $requestType = "payWithATM";

        $rawHash = "accessKey=" . $this->accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $this->partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $this->secretKey);

        $data = array(
            'partnerCode' => $this->partnerCode,
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
            'signature' => $signature,

        );

        $result = $this->execPostRequest($this->endpoint, json_encode($data));
        return json_decode($result, true); // decode json
    }
}
