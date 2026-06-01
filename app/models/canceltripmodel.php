<?php
require_once 'app/config/db_connect.php';

class CancelTripModel {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // ĐÃ SỬA: Bẻ lái câu lệnh JOIN qua bảng LichKhoiHanh để lấy NgayBatDau và TenTour
    public function getTripById($maTK, $maChuyenDi) {
        $sql = "SELECT c.MaChuyenDi, lkh.NgayBatDau, c.TongGiaTien, t.TenTour, c.TrangThai
                FROM ChuyenDi c
                JOIN LichKhoiHanh lkh ON c.MaLichKhoiHanh = lkh.MaLichKhoiHanh
                JOIN Tour t ON lkh.MaTour = t.MaTour
                WHERE c.MaChuyenDi = :macd AND c.MaTK_DK = :matk";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':macd' => $maChuyenDi, ':matk' => $maTK]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Sinh mã yêu cầu hủy tự động
    private function generateMaYeuCauHuy() {
        $stmt = $this->conn->query("SELECT MaYeuCauHuy FROM YeuCauHuy ORDER BY MaYeuCauHuy DESC LIMIT 1");
        $lastId = $stmt->fetchColumn();
        if (!$lastId) return 'HUY0000001';
        $num = intval(substr($lastId, 3)) + 1;
        return 'HUY' . str_pad($num, 7, '0', STR_PAD_LEFT);
    }

    // Thực thi Transaction lưu yêu cầu hủy
    public function submitCancelRequest($maTK, $maChuyenDi, $lyDo, $tyLeHoan, $soTienHoan) {
        try {
            $this->conn->beginTransaction();

            // 0. BỔ SUNG: Lấy thông tin chuyến đi để tính toán trả lại ghế trống
            $sqlGetInfo = "SELECT MaLichKhoiHanh, SoLuongKhach FROM ChuyenDi WHERE MaChuyenDi = :macd AND MaTK_DK = :matk";
            $stmtGetInfo = $this->conn->prepare($sqlGetInfo);
            $stmtGetInfo->execute([':macd' => $maChuyenDi, ':matk' => $maTK]);
            $cdInfo = $stmtGetInfo->fetch(PDO::FETCH_ASSOC);

            // 1. Cập nhật bảng ChuyenDi thành 'Đã hủy'
            $sqlUpdate = "UPDATE ChuyenDi SET TrangThai = 'Đã hủy' WHERE MaChuyenDi = :macd AND MaTK_DK = :matk";
            $stmtUpdate = $this->conn->prepare($sqlUpdate);
            $stmtUpdate->execute([':macd' => $maChuyenDi, ':matk' => $maTK]);

            // 1.5. BỔ SUNG LOGIC: Hoàn trả lại số chỗ đã đặt cho bảng LichKhoiHanh
            if ($cdInfo && $cdInfo['MaLichKhoiHanh']) {
                $sqlLKH = "UPDATE LichKhoiHanh SET SoChoDaDat = SoChoDaDat - :soluong WHERE MaLichKhoiHanh = :malich";
                $stmtLKH = $this->conn->prepare($sqlLKH);
                $stmtLKH->execute([
                    ':soluong' => $cdInfo['SoLuongKhach'],
                    ':malich' => $cdInfo['MaLichKhoiHanh']
                ]);
            }

            // 2. Thêm vào bảng YeuCauHuy
            $maYeuCau = $this->generateMaYeuCauHuy();
            $sqlInsert = "INSERT INTO YeuCauHuy (MaYeuCauHuy, LyDoHuy, TyLeHoanTien, SoTienHoan, NgayYeuCau, TrangThai, MaChuyenDi, MaTK_DK)
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