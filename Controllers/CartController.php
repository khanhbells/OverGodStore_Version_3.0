<?php
require_once("Models/cart.php");
class CartController
{
    var $cart_model;
    public function __construct()
    {
        $this->cart_model = new Cart();
    }
    function list_cart()
    {
        $data_danhmuc = $this->cart_model->danhmuc();

        $data_chitietDM = array();

        for ($i = 1; $i <= count($data_danhmuc); $i++) {
            $data_chitietDM[$i] = $this->cart_model->chitietdanhmuc($i);
        }

        $count = 0;
        if (isset($_SESSION['sanpham'])) {
            foreach ($_SESSION['sanpham'] as $value) {
                $count += $value['ThanhTien'];
            }
        }
        require_once('Views/index.php');
    }
    function add_cart()
    {
        $id = $_GET['id'];
        $data = $this->cart_model->detail_sp($id);

        if (isset($_SESSION['sanpham'][$id])) {
            // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
            $arr = $_SESSION['sanpham'][$id];
            $newQuantity = $arr['SoLuong'] + 1;

            // Lấy thông tin sản phẩm
            $productDetails = $this->cart_model->detail_sp($id);
            $availableQuantity = $productDetails['SoLuong'];

            if ($newQuantity > $availableQuantity) {
                // Thông báo cho người dùng rằng số lượng không đủ
                setcookie('msg', 'Số lượng sản phẩm không đủ trong kho.', time() + 5);
            } else {
                $arr['SoLuong'] = $newQuantity;
                $arr['ThanhTien'] = $arr['SoLuong'] * $arr['DonGia'];
                $_SESSION['sanpham'][$id] = $arr;
            }
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới
            $arr['MaSP'] = $data['MaSP'];
            $arr['TenSP'] = $data['TenSP'];
            $arr['DonGia'] = $data['DonGia'];
            $arr['SoLuong'] = 1;
            $arr['ThanhTien'] = $data['DonGia'];
            $arr['HinhAnh1'] = $data['HinhAnh1'];
            $_SESSION['sanpham'][$id] = $arr;
        }

        // Cập nhật tổng giá trị của giỏ hàng
        $count = 0;
        foreach ($_SESSION['sanpham'] as $value) {
            $count += $value['ThanhTien'];
        }

        header('Location:?act=cart#dxd');
    }
    function applyCoupon()
    {
        $couponCode = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : '';

        // Danh sách mã giảm giá hợp lệ
        $validCoupons = array(
            'DISCOUNT10' => 10,
            'DISCOUNT20' => 20,
            'DISCOUNT30' => 30,
            'DISCOUNT40' => 40,
            'DISCOUNT50' => 50,
            'DISCOUNT60' => 60,
            'DISCOUNT70' => 70,
            'DISCOUNT80' => 80,
            'DISCOUNT90' => 90,
            'DISCOUNT100' => 100,
        );

        if (isset($validCoupons[$couponCode])) {
            // Kiểm tra mã giảm giá đã được áp dụng chưa
            if (!isset($_SESSION['used_coupons'])) {
                $_SESSION['used_coupons'] = array();
            }

            // Nếu mã giảm giá chưa được áp dụng, cộng dồn
            if (!in_array($couponCode, $_SESSION['used_coupons'])) {
                $_SESSION['used_coupons'][] = $couponCode;

                // Tính tổng giảm giá
                $discounts = array();
                foreach ($_SESSION['used_coupons'] as $code) {
                    if (isset($validCoupons[$code])) {
                        $discounts[] = $validCoupons[$code];
                    }
                }
                // Cộng dồn giảm giá
                $totalDiscount = array_sum($discounts);

                $_SESSION['discount'] = $totalDiscount;

                setcookie('msg', 'Mã giảm giá hợp lệ. Đã áp dụng ' . $totalDiscount . '% giảm giá.', time() + 5);
            } else {
                setcookie('msg', 'Mã giảm giá đã được sử dụng.', time() + 5);
            }
        } else {
            // Kiểm tra mã miễn phí vận chuyển
            $validFreeShipCodes = array('FREESHIP');

            if (in_array($couponCode, $validFreeShipCodes)) {
                $_SESSION['freeship'] = true;
                setcookie('msg', 'Mã miễn phí vận chuyển hợp lệ.', time() + 5);
            } else {
                setcookie('msg', 'Mã giảm giá hoặc mã miễn phí vận chuyển không hợp lệ.', time() + 5);
            }
        }

        header('Location: ?act=cart#dxd');
    }

    function removeCoupons()
    {
        unset($_SESSION['discount']);
        unset($_SESSION['freeship']);
        // unset($_SESSION['used_coupons']);
        setcookie('msg', 'Đã xóa mã giảm giá.', time() + 5);
        header('Location: ?act=cart#dxd');
    }




    function update_cart()
    {
        $id = $_GET['id'];
        $newQuantity = $_SESSION['sanpham'][$id]['SoLuong'] + 1;

        // Lấy thông tin sản phẩm
        $productDetails = $this->cart_model->detail_sp($id);
        $availableQuantity = $productDetails['SoLuong'];

        if ($newQuantity > $availableQuantity) {
            // Thông báo cho người dùng rằng số lượng không đủ
            setcookie('msg', 'Số lượng sản phẩm không đủ trong kho.', time() + 5);
        } else {
            // Cập nhật số lượng trong giỏ hàng
            $arr = $_SESSION['sanpham'][$id];
            $arr['SoLuong'] = $newQuantity;
            $arr['ThanhTien'] = $arr['SoLuong'] * $arr['DonGia'];
            $_SESSION['sanpham'][$id] = $arr;
        }

        header('Location: ?act=cart#dxd');
    }

    function delete_cart()
    {
        $id = $_GET['id'];

        // Lấy thông tin sản phẩm
        $productDetails = $this->cart_model->detail_sp($id);
        $availableQuantity = $productDetails['SoLuong'];

        $currentQuantity = $_SESSION['sanpham'][$id]['SoLuong'];

        if ($currentQuantity > 1) {
            // Giảm số lượng trong giỏ hàng
            $arr = $_SESSION['sanpham'][$id];
            $arr['SoLuong'] = $currentQuantity - 1;
            $arr['ThanhTien'] = $arr['SoLuong'] * $arr['DonGia'];
            $_SESSION['sanpham'][$id] = $arr;
            unset($_SESSION['used_coupons']);
        } else {
            // Xóa sản phẩm nếu số lượng còn lại là 1
            unset($_SESSION['sanpham'][$id]);
        }

        header('Location: ?act=cart#dxd');
    }

    function deleteall_cart()
    {
        unset($_SESSION['sanpham'][$_GET['id']]);
        header('Location: ?act=cart#dxd');
    }
}
