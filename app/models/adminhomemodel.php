<?php
class AdminHomeModel {
    private $conn;

    public function __construct() {
        global $conn;
        if (!$conn) {
            require_once __DIR__ . '/../config/db_connect.php';
        }
        $this->conn = $conn;
    }

    public function getMonthlyRevenue() {
        // Tính Ngày kết thúc bằng Lịch Khởi Hành + Số Ngày của Tour
        $sql = "SELECT SUM(cd.TongGiaTien) as DoanhThu 
                FROM chuyendi cd
                JOIN lichkhoihanh lkh ON cd.MaLichKhoiHanh = lkh.MaLichKhoiHanh
                JOIN tour t ON lkh.MaTour = t.MaTour
                WHERE MONTH(DATE_ADD(lkh.NgayBatDau, INTERVAL t.SoNgay DAY)) = MONTH(CURRENT_DATE()) 
                AND YEAR(DATE_ADD(lkh.NgayBatDau, INTERVAL t.SoNgay DAY)) = YEAR(CURRENT_DATE()) 
                AND cd.TrangThai = 'Đã hoàn thành'"; 
                
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['DoanhThu'] ?? 0;
    }

    public function getActiveToursCount() {
        $sql = "SELECT COUNT(*) as SoLuong FROM tour";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['SoLuong'] ?? 0;
    }

    public function getTotalUsersCount() {
        $sql = "SELECT COUNT(*) as SoLuong FROM taikhoan WHERE LoaiTK = 'Du khách'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['SoLuong'] ?? 0;
    }

    public function getTotalReviewsCount() {
        $sql = "SELECT COUNT(*) as SoLuong FROM phieudanhgia";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['SoLuong'] ?? 0;
    }

    public function getLatestTrips() {
        // Join thêm bảng LichKhoiHanh để lấy NgayBatDau
        $sql = "SELECT cd.MaChuyenDi, t.TenTour, lkh.NgayBatDau, cd.SoLuongKhach, cd.TongGiaTien AS TongTien, cd.TrangThai 
                FROM chuyendi cd
                JOIN lichkhoihanh lkh ON cd.MaLichKhoiHanh = lkh.MaLichKhoiHanh
                JOIN tour t ON lkh.MaTour = t.MaTour
                ORDER BY lkh.NgayBatDau DESC 
                LIMIT 10";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>