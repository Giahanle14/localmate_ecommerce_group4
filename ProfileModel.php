<?php
// ProfileModel.php
class ProfileModel {
    private $conn;

    public function __construct() {
        global $conn; // Lấy biến kết nối từ db_connect.php
        $this->conn = $conn;
    }

    // Lấy thông tin cá nhân và tài khoản
    public function getUserInfo($maDK) {
        $sql = "SELECT d.*, t.Gmail, t.MatKhau 
                FROM DuKhach d 
                JOIN TaiKhoan t ON d.MaTK = t.MaTK 
                WHERE d.MaDK = :maDK";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maDK', $maDK);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Lấy các chỉ số thống kê (Số chuyến đi, số đánh giá, số yêu thích)
    public function getUserStats($maDK) {
        $stats = [
            'chuyen' => 0,
            'danh_gia' => 0,
            'yeu_thich' => 0
        ];

        // Đếm số chuyến đi
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM ChuyenDi WHERE MaDK = :maDK");
        $stmt->execute([':maDK' => $maDK]);
        $stats['chuyen'] = $stmt->fetchColumn();

        // Đếm số đánh giá
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM PhieuDanhGia WHERE MaDK = :maDK");
        $stmt->execute([':maDK' => $maDK]);
        $stats['danh_gia'] = $stmt->fetchColumn();

        // Đếm số lượt yêu thích
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM DanhSachYeuThich WHERE MaDK = :maDK");
        $stmt->execute([':maDK' => $maDK]);
        $stats['yeu_thich'] = $stmt->fetchColumn();

        return $stats;
    }

    // Cập nhật thông tin cá nhân
    public function updateProfile($maDK, $hoTen, $ngaySinh, $gioiTinh, $sdt, $diaChi, $sdtKhanCap) {
        $sql = "UPDATE DuKhach 
                SET HoTen = :hoTen, NgaySinh = :ngaySinh, GioiTinh = :gioiTinh, 
                    SDT = :sdt, DiaChi = :diaChi, SDTKhanCap = :sdtKhanCap 
                WHERE MaDK = :maDK";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':hoTen' => $hoTen,
            ':ngaySinh' => $ngaySinh,
            ':gioiTinh' => $gioiTinh,
            ':sdt' => $sdt,
            ':diaChi' => $diaChi,
            ':sdtKhanCap' => $sdtKhanCap,
            ':maDK' => $maDK
        ]);
    }

    // Cập nhật mật khẩu
    public function updatePassword($maTK, $newPassword) {
        $sql = "UPDATE TaiKhoan SET MatKhau = :matKhau WHERE MaTK = :maTK";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':matKhau' => $newPassword,
            ':maTK' => $maTK
        ]);
    }
}
?>