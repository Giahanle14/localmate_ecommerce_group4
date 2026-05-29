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
                (SELECT COUNT(*) FROM PhieuDanhGia p JOIN ChuyenDi c ON p.MaChuyenDi = c.MaChuyenDi WHERE c.MaTour = t.MaTour) as SoDanhGia,
                (SELECT AVG(SoSao) FROM PhieuDanhGia p JOIN ChuyenDi c ON p.MaChuyenDi = c.MaChuyenDi WHERE c.MaTour = t.MaTour) as SaoTrungBinh
                FROM Tour t WHERE t.MaTour = :id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $maTour]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>