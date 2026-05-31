<?php
class AdminHomeModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Lấy Doanh thu trong tháng hiện tại (Đã sửa theo cột TongGiaTien và NgayBatDau)
    public function getMonthlyRevenue() {
        // Tạm thời bỏ điều kiện TrangThaiThanhToan vì database của bạn không có cột này
        // Nếu muốn chỉ tính các tour đã xong, bạn có thể thêm: AND TrangThai = 'Hoàn thành'
        $sql = "SELECT SUM(TongGiaTien) as DoanhThu 
                FROM chuyendi 
                WHERE MONTH(NgayBatDau) = MONTH(CURRENT_DATE()) 
                AND YEAR(NgayBatDau) = YEAR(CURRENT_DATE())";
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