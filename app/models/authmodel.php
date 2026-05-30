<?php
class AuthModel {
    private $conn;

    public function __construct() {
        global $conn;
        if (!$conn) {
            require_once __DIR__ . '/../config/db_connect.php';
        }
        $this->conn = $conn;
    }

    public function checkEmailExist($email) {
        $stmt = $this->conn->prepare("SELECT MaTK FROM TaiKhoan WHERE Gmail = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->rowCount() > 0;
    }

    private function getNextMaTK() {
        $stmt = $this->conn->query("SELECT MaTK FROM TaiKhoan ORDER BY MaTK DESC LIMIT 1");
        $lastId = $stmt->fetchColumn();
        if (!$lastId) return 'TK00000001';
        $num = intval(substr($lastId, 2)) + 1;
        return 'TK' . str_pad($num, 8, '0', STR_PAD_LEFT);
    }

    private function getNextMaDK() {
        $stmt = $this->conn->query("SELECT MaDK FROM DuKhach ORDER BY MaDK DESC LIMIT 1");
        $lastId = $stmt->fetchColumn();
        if (!$lastId) return 'DK00000001';
        $num = intval(substr($lastId, 2)) + 1;
        return 'DK' . str_pad($num, 8, '0', STR_PAD_LEFT);
    }

    public function registerUser($hoTen, $email, $password) {
        try {
            $this->conn->beginTransaction();

            $maTK = $this->getNextMaTK();
            $maDK = $this->getNextMaDK();
            
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]); 

            // 1. Thêm vào bảng TaiKhoan
            $sqlTK = "INSERT INTO TaiKhoan (MaTK, HoTen, SDT, Gmail, MatKhau, LoaiTK, TrangThai) 
                      VALUES (:maTK, :hoTen, 'Chưa cập nhật', :email, :matKhau, 'Du khách', 'Hoạt động')";
            $stmtTK = $this->conn->prepare($sqlTK);
            $stmtTK->execute([
                ':maTK' => $maTK, 
                ':hoTen' => $hoTen, 
                ':email' => $email, 
                ':matKhau' => $hashedPassword
            ]);

            $sqlDK = "INSERT INTO DuKhach (MaTK_DK, MaDK, SDTKhanCap, HangThanhVien) 
                      VALUES (:maTK_DK, :maDK, 'Chưa cập nhật', 'Đồng')";
            $stmtDK = $this->conn->prepare($sqlDK);
            $stmtDK->execute([
                ':maTK_DK' => $maTK, 
                ':maDK' => $maDK
            ]);

            $this->conn->commit();

            return [
                'MaTK' => $maTK, 
                'Gmail' => $email, 
                'LoaiTK' => 'Du khách', 
                'HoTen' => $hoTen, 
                'MaDK' => $maDK
            ];
            
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function updatePassword($email, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
        $stmt = $this->conn->prepare("UPDATE TaiKhoan SET MatKhau = :matKhau WHERE Gmail = :email");
        return $stmt->execute([
            ':matKhau' => $hashedPassword,
            ':email' => $email
        ]);
    }
}
?>