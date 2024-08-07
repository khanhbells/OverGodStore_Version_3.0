<?php
require_once("MVC/models/nguoidung.php");

class NguoiDungController
{
    var $nguoidung_model;

    public function __construct()
    {
        $this->nguoidung_model = new nguoidung();
    }

    public function list()
    {
        $data = $this->nguoidung_model->All();
        require_once("MVC/Views/Admin/index.php");
    }

    public function detail()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 1;
        $data = $this->nguoidung_model->find($id);
        require_once("MVC/Views/Admin/index.php");
    }

    public function add()
    {
        require_once("MVC/Views/Admin/index.php");
    }

    public function store()
    {

        // Lấy dữ liệu từ form
        $taiKhoan = $_POST['TaiKhoan'];
        $email = $_POST['Email'];

        // Kiểm tra sự tồn tại của tên tài khoản và email
        if ($this->nguoidung_model->isTaiKhoanExist($taiKhoan)) {
            setcookie('msg', 'Tên tài khoản đã tồn tại.', time() + 5, '/');
            header("Location: index.php?mod=nguoidung&act=add");
            exit();
        }

        if ($this->nguoidung_model->isEmailExist($email)) {
            setcookie('msg', 'Email đã tồn tại.', time() + 5, '/');
            header("Location: index.php?mod=nguoidung&act=add");
            exit();
        }

        $data = array(
            'Ho' => $_POST['Ho'],
            'Ten' => $_POST['Ten'],
            'GioiTinh' => $_POST['GioiTinh'],
            'SDT' => $_POST['SDT'],
            'Email' => $_POST['Email'],
            'DiaChi' => $_POST['DiaChi'],
            'TaiKhoan' => $_POST['TaiKhoan'],
            'MatKhau' => password_hash($_POST['MatKhau'], PASSWORD_BCRYPT),
            'MaQuyen' => $_POST['MaQuyen'],
            'TrangThai' => '1'
        );

        $this->nguoidung_model->store($data);
    }

    public function delete()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $this->nguoidung_model->delete($id);
    }

    public function edit()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 1;
        $data = $this->nguoidung_model->find($id);
        require_once("MVC/Views/Admin/index.php");
    }

    public function update()
    {
        // Lấy dữ liệu từ form
        $taiKhoan = $_POST['TaiKhoan'];
        $email = $_POST['Email'];
        $id = $_POST['MaND']; // ID của người dùng hiện tại

        // Kiểm tra sự tồn tại của tên tài khoản
        if ($this->nguoidung_model->isTaiKhoanExist($taiKhoan, $id)) {
            setcookie('msg', 'Tên tài khoản đã tồn tại.', time() + 5, '/');
            header("Location: index.php?mod=nguoidung&act=edit&id=" . $id);
            exit();
        }

        // Kiểm tra sự tồn tại của email
        if ($this->nguoidung_model->isEmailExist($email, $id)) {
            setcookie('msg', 'Email đã tồn tại.', time() + 5, '/');
            header("Location: index.php?mod=nguoidung&act=edit&id=" . $id);
            exit();
        }

        // Cập nhật thông tin người dùng
        $data = array(
            'MaND' => $_POST['MaND'],
            'Ho' => $_POST['Ho'],
            'Ten' => $_POST['Ten'],
            'GioiTinh' => $_POST['GioiTinh'],
            'SDT' => $_POST['SDT'],
            'Email' => $_POST['Email'],
            'DiaChi' => $_POST['DiaChi'],
            'TaiKhoan' => $_POST['TaiKhoan'],
            'MaQuyen' => $_POST['MaQuyen'],
            'TrangThai' => $_POST['TrangThai']
        );

        // Cập nhật dữ liệu
        $this->nguoidung_model->update($data);

        // Thông báo thành công
        setcookie('msg', 'Cập nhật thành công.', time() + 5, '/');
        header("Location: index.php?mod=nguoidung&act=list");
        exit();
    }
}
