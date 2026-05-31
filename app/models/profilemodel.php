<?php
class ProfileModel {
    private $conn;

    public function __construct() {
        global $conn; 
        $this->conn = $conn;
    }

    public function getUserInfo($maDK) {
        $sql = "SELECT d.*, t.MaTK, t.HoTen, t.SDT, t.Gmail, t.MatKhau 
                FROM DuKhach d 
                JOIN TaiKhoan t ON d.MaTK_DK = t.MaTK 
                WHERE d.MaDK = :maDK";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maDK', $maDK);
        $stmt->execute();
        return $stmt->fetch();
    }

    
    public function getUserStats($maTK_DK) {
        $stats = ['chuyen' => 0, 'danh_gia' => 0, 'yeu_thich' => 0];

        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM ChuyenDi WHERE MaTK_DK = :maTK_DK");
        $stmt->execute([':maTK_DK' => $maTK_DK]);
        $stats['chuyen'] = $stmt->fetchColumn();

        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM PhieuDanhGia WHERE MaTK_DK = :maTK_DK");
        $stmt->execute([':maTK_DK' => $maTK_DK]);
        $stats['danh_gia'] = $stmt->fetchColumn();

        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM DanhSachYeuThich WHERE MaTK_DK = :maTK_DK");
        $stmt->execute([':maTK_DK' => $maTK_DK]);
        $stats['yeu_thich'] = $stmt->fetchColumn();

        return $stats;
    }

    public function updateProfile($maTK, $maDK, $ngaySinh, $gioiTinh, $sdt, $diaChi, $sdtKhanCap) {
        try {
            $this->conn->beginTransaction();
            $sql1 = "UPDATE TaiKhoan SET SDT = :sdt WHERE MaTK = :maTK";
            $stmt1 = $this->conn->prepare($sql1);
            $stmt1->execute([':sdt' => $sdt, ':maTK' => $maTK]);

            $sql2 = "UPDATE DuKhach SET NgaySinh = :ngaySinh, GioiTinh = :gioiTinh, DiaChi = :diaChi, SDTKhanCap = :sdtKhanCap WHERE MaDK = :maDK";
            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->execute([
                ':ngaySinh' => $ngaySinh, ':gioiTinh' => $gioiTinh, 
                ':diaChi' => $diaChi, ':sdtKhanCap' => $sdtKhanCap, ':maDK' => $maDK
            ]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack(); 
            return false;
        }
    }

    public function updatePassword($maTK, $newPassword) {
        $sql = "UPDATE TaiKhoan SET MatKhau = :matKhau WHERE MaTK = :maTK";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':matKhau' => $newPassword, ':maTK' => $maTK]);
    }

    public function updateAvatar($maDK, $duongDan) {
        $sql = "UPDATE DuKhach SET AnhDaiDien = :duongDan WHERE MaDK = :maDK";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':duongDan' => $duongDan, ':maDK' => $maDK]);
    }
}
?>