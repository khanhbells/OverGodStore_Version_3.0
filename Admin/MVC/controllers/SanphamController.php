<?php
require_once("MVC/Models/sanpham.php");

class SanphamController
{
    var $sanpham_model;

    public function __construct()
    {
        $this->sanpham_model = new sanpham();
    }

    public function list()
    {
        $data = $this->sanpham_model->All();
        require_once("MVC/Views/Admin/index.php");
        // require_once("MVC/Views/posts/list.php");
    }

    public function detail()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : 1;
        $data = $this->sanpham_model->find($id);
        require_once("MVC/Views/Admin/index.php");
        // require_once("MVC/Views/posts/detail.php");
    }

    public function add()
    {
        $data_km = $this->sanpham_model->khuyenmai();
        $data_lsp = $this->sanpham_model->loaisp();
        $data_dm = $this->sanpham_model->danhmuc();
        require_once("MVC/Views/Admin/index.php");
        // require_once("MVC/Views/posts/add.php");
    }

    public function store()
    {
        // Validate required fields
        $requiredFields = [
            'MaLSP' => 'Loại sản phẩm',
            'TenSP' => 'Tên sản phẩm',
            'MaDM' => 'Danh mục',
            'DonGia' => 'Đơn giá',
            'SoLuong' => 'Số lượng',
            'MaKM' => 'Khuyến mãi',
            'KichThuoc' => 'Kích thước',
            'MauSac' => 'Màu sắc',
            'ManHinh' => 'ManHinh',
            'HDH' => 'HDH',
            'CamTruoc' => 'CamTruoc',
            'CamSau' => 'CamSau',
            'MoTa' => 'Mô tả'
        ];

        foreach ($requiredFields as $field => $fieldName) {
            if (empty($_POST[$field])) {
                echo "<script>alert('Không được để trống $fieldName'); window.history.back();</script>";
                return;
            }
        }

        $target_dir = "../public/img/products/";
        $HinhAnh1 = $this->uploadFile($target_dir, "HinhAnh1");
        $HinhAnh2 = $this->uploadFile($target_dir, "HinhAnh2");
        $HinhAnh3 = $this->uploadFile($target_dir, "HinhAnh3");

        $TrangThai = isset($_POST['TrangThai']) ? $_POST['TrangThai'] : 0;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $ThoiGian = date('Y-m-d H:i:s');

        $data = [
            'MaLSP' =>    $_POST['MaLSP'],
            'TenSP'  =>   $_POST['TenSP'],
            'MaDM' => $_POST['MaDM'],
            'DonGia' => $_POST['DonGia'],
            'SoLuong' => $_POST['SoLuong'],
            'HinhAnh1' => $HinhAnh1,
            'HinhAnh2' => $HinhAnh2,
            'HinhAnh3' => $HinhAnh3,
            'MaKM' =>  $_POST['MaKM'],
            'KichThuoc' =>  $_POST['KichThuoc'],
            'MauSac' =>  $_POST['MauSac'],
            'ManHinh' =>  $_POST['ManHinh'],
            'HDH' => $_POST['HDH'],
            'CamSau' =>  $_POST['CamSau'],
            'CamTruoc' =>  $_POST['CamTruoc'],
            'SoSao' =>  0,
            'SoDanhGia' => 0,
            'TrangThai' => $TrangThai,
            'MoTa' =>  $_POST['MoTa'],
            'ThoiGian' => $ThoiGian
        ];

        $data = $this->sanitizeData($data);
        $this->sanpham_model->store($data);
    }

    public function delete()
    {
        $id = $_GET['id'];
        $this->sanpham_model->delete($id);
    }

    public function edit()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : 1;
        $data_km = $this->sanpham_model->khuyenmai();
        $data_lsp = $this->sanpham_model->loaisp();
        $data_dm = $this->sanpham_model->danhmuc();
        $data = $this->sanpham_model->find($id);
        require_once("MVC/Views/Admin/index.php");
        // require_once("MVC/Views/posts/edit.php");
    }

    public function update()
    {
        // Validate required fields
        $requiredFields = [
            'MaLSP' => 'Loại sản phẩm',
            'TenSP' => 'Tên sản phẩm',
            'MaDM' => 'Danh mục',
            'DonGia' => 'Đơn giá',
            'SoLuong' => 'Số lượng',
            'MaKM' => 'Khuyến mãi',
            'KichThuoc' => 'Kích thước',
            'MauSac' => 'Màu sắc',
            'ManHinh' => 'ManHinh',
            'HDH' => 'HDH',
            'CamTruoc' => 'CamTruoc',
            'CamSau' => 'CamSau',
            'MoTa' => 'Mô tả'
        ];

        foreach ($requiredFields as $field => $fieldName) {
            if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                setcookie('msg', "Không được để trống $fieldName", time() + 1);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                return;
            }
        }

        $target_dir = "../public/img/products/";
        $HinhAnh1 = $this->uploadFile($target_dir, "HinhAnh1");
        $HinhAnh2 = $this->uploadFile($target_dir, "HinhAnh2");
        $HinhAnh3 = $this->uploadFile($target_dir, "HinhAnh3");

        $TrangThai = isset($_POST['TrangThai']) ? $_POST['TrangThai'] : 0;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $ThoiGian = date('Y-m-d H:i:s');

        $data = [
            'MaSP' => $_POST['MaSP'],
            'MaLSP' =>    $_POST['MaLSP'],
            'MaDM' => $_POST['MaDM'],
            'TenSP'  =>   $_POST['TenSP'],
            'DonGia' => $_POST['DonGia'],
            'SoLuong' => $_POST['SoLuong'],
            'HinhAnh1' => $HinhAnh1,
            'HinhAnh2' => $HinhAnh2,
            'HinhAnh3' => $HinhAnh3,
            'MaKM' =>  $_POST['MaKM'],
            'KichThuoc' =>  $_POST['KichThuoc'],
            'MauSac' =>  $_POST['MauSac'],
            'ManHinh' =>  $_POST['ManHinh'],
            'HDH' => $_POST["HDH"],
            'CamSau' =>  $_POST['CamSau'],
            'CamTruoc' =>  $_POST['CamTruoc'],
            'SoSao' =>  0,
            'SoDanhGia' => 0,
            'TrangThai' => $TrangThai,
            'MoTa' =>  $_POST['MoTa'],
            'ThoiGian' => $ThoiGian
        ];

        $data = $this->sanitizeData($data);

        if (empty($HinhAnh1)) unset($data['HinhAnh1']);
        if (empty($HinhAnh2)) unset($data['HinhAnh2']);
        if (empty($HinhAnh3)) unset($data['HinhAnh3']);

        $this->sanpham_model->update($data);
    }

    private function uploadFile($target_dir, $input_name)
    {
        $target_file = $target_dir . basename($_FILES[$input_name]["name"]);
        if (move_uploaded_file($_FILES[$input_name]["tmp_name"], $target_file)) {
            return "img/products/" . basename($_FILES[$input_name]["name"]);
        }
        return "";
    }

    private function sanitizeData($data)
    {
        foreach ($data as $key => $value) {
            if (strpos($value, "'") !== false) {
                $data[$key] = str_replace("'", "\'", $value);
            }
        }
        return $data;
    }
}
