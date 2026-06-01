<?php
require_once 'app/config/db_connect.php';

class PaymentModel {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getNextMaChuyenDi() {
        $stmt = $this->conn->query("SELECT MaChuyenDi FROM ChuyenDi ORDER BY MaChuyenDi DESC LIMIT 1");
        $lastId = $stmt->fetchColumn();
        if (!$lastId) return 'CD00000001';
        $num = intval(substr($lastId, 2)) + 1;
        return 'CD' . str_pad($num, 8, '0', STR_PAD_LEFT);
    }

    private function generateMaGiaoDich() {
        $stmt = $this->conn->query("SELECT MaGiaoDich FROM GiaoDich ORDER BY MaGiaoDich DESC LIMIT 1");
        $lastId = $stmt->fetchColumn();
        if (!$lastId) return 'GD00000001';
        $num = intval(substr($lastId, 2)) + 1;
        return 'GD' . str_pad($num, 8, '0', STR_PAD_LEFT);
    }

    // ĐÃ SỬA: Cập nhật tham số nhận vào (Thay MaTour, Ngay bằng MaLichKhoiHanh và GhiChu)
    public function saveBookingAndTransaction($maTK_DK, $maLichKhoiHanh, $tongTien, $soLuongKhach, $phuongThuc, $maChuyenDi, $ghiChu) {
        try {
            $this->conn->beginTransaction();

            $maGiaoDich = $this->generateMaGiaoDich();

            // 1. Lưu vào bảng ChuyenDi theo cấu trúc Database mới
            $sqlCD = "INSERT INTO ChuyenDi (MaChuyenDi, MaLichKhoiHanh, TongGiaTien, SoLuongKhach, GhiChu, TrangThai, MaTK_DK) 
                      VALUES (:macd, :malich, :tongtien, :soluong, :ghichu, 'Chưa hoàn thành', :matk)";
            $stmtCD = $this->conn->prepare($sqlCD);
            $stmtCD->execute([
                ':macd' => $maChuyenDi,
                ':malich' => $maLichKhoiHanh,
                ':tongtien' => $tongTien,
                ':soluong' => $soLuongKhach,
                ':ghichu' => $ghiChu,
                ':matk' => $maTK_DK
            ]);

            // 2. CẬP NHẬT TRỪ CHỖ: Cộng số khách vừa đặt vào cột SoChoDaDat của Lịch Khởi Hành
            $sqlLKH = "UPDATE LichKhoiHanh SET SoChoDaDat = SoChoDaDat + :soluong WHERE MaLichKhoiHanh = :malich";
            $stmtLKH = $this->conn->prepare($sqlLKH);
            $stmtLKH->execute([
                ':soluong' => $soLuongKhach,
                ':malich' => $maLichKhoiHanh
            ]);

            // 3. Lưu vào bảng GiaoDich
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