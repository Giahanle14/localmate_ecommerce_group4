<?php
class AdminHomeModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Lấy Doanh thu trong tháng hiện tại (Đã đồng bộ 100% logic với trang Báo Cáo)
    public function getMonthlyRevenue() {
        $sql = "SELECT SUM(TongGiaTien) as DoanhThu 
                FROM chuyendi 
                WHERE MONTH(NgayKetThuc) = MONTH(CURRENT_DATE()) 
                AND YEAR(NgayKetThuc) = YEAR(CURRENT_DATE()) 
                AND TrangThai = 'Đã hoàn thành'"; 
                
        // 2 dòng lệnh "cứu mạng" đã được thêm lại
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['DoanhThu'] ?? 0;
    }

    // 2. Lấy số lượng Tour đang hoạt động
    public function getActiveToursCount() {
        $sql = "SELECT COUNT(*) as SoLuong FROM tour";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['SoLuong'] ?? 0;
    }

    // 3. Lấy tổng số Tài khoản du khách
    public function getTotalUsersCount() {
        $sql = "SELECT COUNT(*) as SoLuong FROM taikhoan WHERE LoaiTK = 'Du khách'";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['SoLuong'] ?? 0;
    }

    // 4. Lấy tổng số Đánh giá
    public function getTotalReviewsCount() {
        $sql = "SELECT COUNT(*) as SoLuong FROM phieudanhgia";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['SoLuong'] ?? 0;
    }

    // 5. Lấy danh sách 10 chuyến đi mới nhất (Đã đổi sang TongGiaTien và NgayBatDau)
    public function getLatestTrips() {
        // Dùng AS TongTien để View không bị lỗi khi in dữ liệu ra bảng
        $sql = "SELECT cd.MaChuyenDi, t.TenTour, cd.NgayBatDau, cd.SoLuongKhach, cd.TongGiaTien AS TongTien, cd.TrangThai 
                FROM chuyendi cd
                JOIN tour t ON cd.MaTour = t.MaTour
                ORDER BY cd.NgayBatDau DESC 
                LIMIT 10";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>