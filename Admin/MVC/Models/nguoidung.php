<?php
require_once("model.php");

class nguoidung extends Model
{
    var $table = "nguoidung";
    var $contens = "MaND";

    // Kiểm tra sự tồn tại của tên tài khoản
    public function isTaiKhoanExist($taiKhoan, $excludeId = null)
    {
        $query = "SELECT COUNT(*) FROM $this->table WHERE TaiKhoan = ?" . ($excludeId ? " AND $this->contens != ?" : "");
        $stmt = $this->conn->prepare($query);

        if ($excludeId) {
            $stmt->bind_param("si", $taiKhoan, $excludeId);
        } else {
            $stmt->bind_param("s", $taiKhoan);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->fetch_row()[0];

        return $count > 0;
    }


    // Kiểm tra sự tồn tại của email
    public function isEmailExist($email, $excludeId = null)
    {
        // Tạo câu lệnh SQL để kiểm tra sự tồn tại của email, có thể bỏ qua ID hiện tại nếu cần
        $query = "SELECT COUNT(*) AS count FROM $this->table WHERE Email = ?" . ($excludeId ? " AND $this->contens != ?" : "");

        // Chuẩn bị câu lệnh
        $stmt = $this->conn->prepare($query);

        if ($excludeId) {
            // Nếu có excludeId, truyền thêm ID vào để bỏ qua kiểm tra ID hiện tại
            $stmt->bind_param("si", $email, $excludeId);
        } else {
            // Nếu không có excludeId, chỉ truyền email
            $stmt->bind_param("s", $email);
        }

        // Thực thi câu lệnh
        $stmt->execute();

        // Lấy kết quả
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Trả về true nếu email tồn tại, false nếu không
        return $row['count'] > 0;
    }
}
