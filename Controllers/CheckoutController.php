<?php
require_once("Models/checkout.php");
class CheckoutController
{
    var $checkout_model;
    public function __construct()
    {
        $this->checkout_model = new Checkout();
    }
    function list()
    {
        if (isset($_SESSION['login'])) {
            $data_danhmuc = $this->checkout_model->danhmuc();

            $data_chitietDM = array();

            for ($i = 1; $i <= count($data_danhmuc); $i++) {
                $data_chitietDM[$i] = $this->checkout_model->chitietdanhmuc($i);
            }

            $count = 0;
            if (isset($_SESSION['sanpham'])) {
                foreach ($_SESSION['sanpham'] as $value) {
                    $count += $value['ThanhTien'];
                }
            }
            require_once('Views/index.php');
        } else {
            header('location: ?act=taikhoan');
        }
    }
    function save()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $ThoiGian = date('Y-m-d H:i:s');

        $count = 0;
        if (isset($_SESSION['sanpham'])) {
            foreach ($_SESSION['sanpham'] as $value) {
                $count += $value['ThanhTien'];
            }
        }

        // Kiểm tra xem phương thức thanh toán có phải là MoMo không
        $isMomoPayment = isset($_SESSION['payment_info']);

        if ($isMomoPayment) {
            // Lấy thông tin khách hàng từ session nếu thanh toán qua MoMo
            $NguoiNhan = isset($_SESSION['payment_info']['NguoiNhan']) ? $_SESSION['payment_info']['NguoiNhan'] : '';
            $SDT = isset($_SESSION['payment_info']['SDT']) ? $_SESSION['payment_info']['SDT'] : '';
            $DiaChi = isset($_SESSION['payment_info']['DiaChi']) ? $_SESSION['payment_info']['DiaChi'] : '';
        } else {
            // Lấy thông tin khách hàng từ POST data nếu thanh toán bằng phương thức khác
            $NguoiNhan = isset($_POST['NguoiNhan']) ? $_POST['NguoiNhan'] : '';
            $SDT = isset($_POST['SDT']) ? $_POST['SDT'] : '';
            $DiaChi = isset($_POST['DiaChi']) ? $_POST['DiaChi'] : '';
        }

        $data = array(
            'MaND' => $_SESSION['login']['MaND'],
            'NgayLap' => $ThoiGian,
            'NguoiNhan' => $NguoiNhan,
            'SDT' => $SDT,
            'DiaChi' => $DiaChi,
            'TongTien' => $count,
            'TrangThai' => '0', // 0: Đang xử lý, 1: Đã xử lý
        );

        $this->checkout_model->save($data);

        // Nếu thanh toán qua MoMo, xóa thông tin thanh toán khỏi session
        if ($isMomoPayment) {
            unset($_SESSION['payment_info']);
        }

        // Chuyển hướng đến order_complete sau khi lưu đơn hàng thành công
        header('location: ?act=checkout&xuli=order_complete');
    }


    function order_complete()
    {
        $data_danhmuc = $this->checkout_model->danhmuc();

        $data_chitietDM = array();

        for ($i = 1; $i <= count($data_danhmuc); $i++) {
            $data_chitietDM[$i] = $this->checkout_model->chitietdanhmuc($i);
        }
        $count = 0;
        if (isset($_SESSION['sanpham'])) {
            foreach ($_SESSION['sanpham'] as $value) {
                $count += $value['ThanhTien'];
            }
        }
        require_once('Views/index.php');

        // Xóa giỏ hàng sau khi hiển thị trang
        unset($_SESSION['sanpham']);
    }
}