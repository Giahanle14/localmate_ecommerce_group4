<?php
require_once 'app/config/db_connect.php';

class PaymentModel {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // Hàm public: Sinh mã chuyến đi tự động tăng (Hiển thị trước cho khách xem)
    public function getNextMaChuyenDi() {
        $stmt = $this->conn->query("SELECT MaChuyenDi FROM ChuyenDi ORDER BY MaChuyenDi DESC LIMIT 1");
        $lastId = $stmt->fetchColumn();
        if (!$lastId) return 'CD00000001';
        $num = intval(substr($lastId, 2)) + 1;
        return 'CD' . str_pad($num, 8, '0', STR_PAD_LEFT);
    }

    // Sinh mã giao dịch tự động (GD00000001)
    private function generateMaGiaoDich() {
        $stmt = $this->conn->query("SELECT MaGiaoDich FROM GiaoDich ORDER BY MaGiaoDich DESC LIMIT 1");
        $lastId = $stmt->fetchColumn();
        if (!$lastId) return 'GD00000001';
        $num = intval(substr($lastId, 2)) + 1;
        return 'GD' . str_pad($num, 8, '0', STR_PAD_LEFT);
    }

    // Lưu dữ liệu vào 2 bảng cùng lúc bằng Transaction
    public function saveBookingAndTransaction($maTK_DK, $maTour, $ngayBatDau, $ngayKetThuc, $tongTien, $soLuongKhach, $phuongThuc, $maChuyenDi) {
        try {
            $this->conn->beginTransaction();

            $maGiaoDich = $this->generateMaGiaoDich();

            // 1. Lưu vào bảng ChuyenDi
            $sqlCD = "INSERT INTO ChuyenDi (MaChuyenDi, NgayBatDau, NgayKetThuc, TongGiaTien, SoLuongKhach, TrangThai, MaTK_DK, MaTour) 
                      VALUES (:macd, :ngaybd, :ngaykt, :tongtien, :soluong, 'Chưa hoàn thành', :matk, :matour)";
            $stmtCD = $this->conn->prepare($sqlCD);
            $stmtCD->execute([
                ':macd' => $maChuyenDi,
                ':ngaybd' => $ngayBatDau,
                ':ngaykt' => $ngayKetThuc,
                ':tongtien' => $tongTien,
                ':soluong' => $soLuongKhach,
                ':matk' => $maTK_DK,
                ':matour' => $maTour
            ]);

            // 2. Lưu vào bảng GiaoDich
            $maDoiTac = ($phuongThuc == 'MoMo') ? 'MOMO' . rand(1000, 9999) : 'FT' . rand(100000, 999999);
            
            $sqlGD = "INSERT INTO GiaoDich (MaGiaoDich, MaChuyenDi, PhuongThuc, SoTien, MaGiaoDichDoiTac, TrangThai) 
                      VALUES (:magd, :macd, :phuongthuc, :sotien, :madoitac, 'Thành công')";
            $stmtGD = $this->conn->prepare($sqlGD);
            $stmtGD->execute([
                ':magd' => $maGiaoDich,
                ':macd' => $maChuyenDi,
                ':phuongthuc' => $phuongThuc,
                ':sotien' => $tongTien,
                ':madoitac' => $maDoiTac
            ]);

            $this->conn->commit();
            return $maChuyenDi;

        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}
?>