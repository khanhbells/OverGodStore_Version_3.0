<?php
require_once("MVC/models/hoadon.php");

class HoaDonController
{
    var $hoadon_model;

    public function __construct()
    {
        $this->hoadon_model = new Hoadon();
    }

    function list()
    {
        $data = array();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($id > 1) {
                $id = 0;
            }
            $data = $this->hoadon_model->trangthai($id);
        } else {
            $data = $this->hoadon_model->All();
        }
        require_once("MVC/Views/Admin/index.php");
    }

    function xetduyet()
    {
        $data = array(
            'MaHD' => $_GET['id'],
            'TrangThai' => 1,
        );
        $this->hoadon_model->update($data);
        $this->hoadon_model->updateProductQuantity($_GET['id']);
        setcookie('msg', 'Duyệt hóa đơn thành công', time() + 2);
        header('Location: ?mod=hoadon&act=list');
        exit();
    }

    function delete()
    {
        if (isset($_GET['id'])) {
            $this->hoadon_model->delete($_GET['id']);
            setcookie('msg', 'Xóa hóa đơn thành công', time() + 2);
        } else {
            setcookie('msg', 'Không thể xóa hóa đơn', time() + 2);
        }
        header('Location: ?mod=hoadon&act=list');
        exit();
    }

    function chitiet()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : 1;
        $data = $this->hoadon_model->chitiethoadon($id);
        require_once("MVC/Views/Admin/index.php");
    }
}
