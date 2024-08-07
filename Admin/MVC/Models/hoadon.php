<?php
require_once("model.php");

class Hoadon extends Model
{
    var $table = "hoadon";
    var $contens = "MaHD";

    function trangthai($id)
    {
        $query = "SELECT * FROM HoaDon WHERE TrangThai = $id ORDER BY MaHD DESC";
        require("result.php");
        return $data;
    }

    function chitiethoadon($id)
    {
        $query = "SELECT ct.*, s.TenSP as Ten FROM chitiethoadon as ct, sanpham as s WHERE ct.MaSP = s.MaSP AND ct.MaHD = $id";
        require("result.php");
        return $data;
    }

    function updateProductQuantity($MaHD)
    {
        $query = "SELECT * FROM chitiethoadon WHERE MaHD = $MaHD";
        $result = $this->conn->query($query);

        while ($row = $result->fetch_assoc()) {
            $MaSP = $row['MaSP'];
            $SoLuong = $row['SoLuong'];
            $query_update = "UPDATE sanpham SET SoLuong = SoLuong - $SoLuong WHERE MaSP = $MaSP";
            $this->conn->query($query_update);
        }
    }
}
