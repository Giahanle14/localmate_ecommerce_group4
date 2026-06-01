<?php
require_once 'app/config/db_connect.php';

class CancelTripModel {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getTripById($maTK, $maChuyenDi) {
        $sql = "SELECT c.MaChuyenDi, lkh.NgayBatDau, c.TongGiaTien, t.TenTour, c.TrangThai
                FROM chuyendi c
                JOIN lichkhoihanh lkh ON c.MaLichKhoiHanh = lkh.MaLichKhoiHanh
                JOIN tour t ON lkh.MaTour = t.MaTour
                WHERE c.MaChuyenDi = :macd AND c.MaTK_DK = :matk";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':macd' => $maChuyenDi, ':matk' => $maTK]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function generateMaYeuCauHuy() {
        $stmt = $this->conn->query("SELECT MaYeuCauHuy FROM yeucauhuy ORDER BY MaYeuCauHuy DESC LIMIT 1");
        $lastId = $stmt->fetchColumn();
        if (!$lastId) return 'HUY0000001';
        $num = intval(substr($lastId, 3)) + 1;
        return 'HUY' . str_pad($num, 7, '0', STR_PAD_LEFT);
    }

    public function submitCancelRequest($maTK, $maChuyenDi, $lyDo, $tyLeHoan, $soTienHoan) {
        try {
            $this->conn->beginTransaction();

            $maYeuCau = $this->generateMaYeuCauHuy();
            $sqlInsert = "INSERT INTO yeucauhuy (MaYeuCauHuy, LyDoHuy, TyLeHoanTien, SoTienHoan, NgayYeuCau, TrangThai, MaChuyenDi, MaTK_DK)
                          VALUES (:mayc, :lydo, :tyle, :sotien, NOW(), 'Chưa xử lý', :macd, :matk)";
            $stmtInsert = $this->conn->prepare($sqlInsert);
            $stmtInsert->execute([
                ':mayc' => $maYeuCau,
                ':lydo' => $lyDo,
                ':tyle' => $tyLeHoan,
                ':sotien' => $soTienHoan,
                ':macd' => $maChuyenDi,
                ':matk' => $maTK
            ]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}
?>