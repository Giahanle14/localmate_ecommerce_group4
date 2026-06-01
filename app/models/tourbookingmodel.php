<?php
require_once 'app/config/db_connect.php';

class TourBookingModel {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getTourById($maTour) {
        $sql = "SELECT t.*, 
                (SELECT COUNT(p.MaDG) 
                 FROM phieudanhgia p 
                 JOIN chuyendi c ON p.MaChuyenDi = c.MaChuyenDi 
                 JOIN lichkhoihanh lkh ON c.MaLichKhoiHanh = lkh.MaLichKhoiHanh 
                 WHERE lkh.MaTour = t.MaTour) as SoDanhGia,
                (SELECT IFNULL(ROUND(AVG(p.SoSao), 1), 0) 
                 FROM phieudanhgia p 
                 JOIN chuyendi c ON p.MaChuyenDi = c.MaChuyenDi 
                 JOIN lichkhoihanh lkh ON c.MaLichKhoiHanh = lkh.MaLichKhoiHanh 
                 WHERE lkh.MaTour = t.MaTour) as SaoTrungBinh
                FROM tour t 
                WHERE t.MaTour = :id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $maTour]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Hàm lấy thông tin Lịch khởi hành
    public function getScheduleById($maLichKhoiHanh) {
        $sql = "SELECT lkh.*, t.SoKhachToiDa, 
                       (t.SoKhachToiDa - lkh.SoChoDaDat) AS ChoTrong
                FROM lichkhoihanh lkh
                JOIN tour t ON lkh.MaTour = t.MaTour
                WHERE lkh.MaLichKhoiHanh = :id";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $maLichKhoiHanh]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>