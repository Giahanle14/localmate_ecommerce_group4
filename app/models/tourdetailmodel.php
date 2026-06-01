<?php
class TourDetailModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getTourById($maTour) {
        $sql = "SELECT t.*, 
                    (SELECT IFNULL(ROUND(AVG(dg.SoSao), 1), 0) 
     FROM phieudanhgia dg 
     JOIN chuyendi c ON dg.MaChuyenDi = c.MaChuyenDi 
     JOIN lichkhoihanh lkh ON c.MaLichKhoiHanh = lkh.MaLichKhoiHanh
     WHERE lkh.MaTour = t.MaTour) AS TrungBinhSao,
                    (SELECT COUNT(dg.MaDG) 
     FROM phieudanhgia dg 
     JOIN chuyendi c ON dg.MaChuyenDi = c.MaChuyenDi 
     JOIN lichkhoihanh lkh ON c.MaLichKhoiHanh = lkh.MaLichKhoiHanh
     WHERE lkh.MaTour = t.MaTour) AS SoLuotDanhGia
                FROM Tour t 
                WHERE t.MaTour = :matour";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':matour' => $maTour]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getAvailableSchedules($maTour) {
        // Lấy lịch khởi hành từ hôm nay trở đi, tính luôn số chỗ còn trống
        $sql = "SELECT lkh.MaLichKhoiHanh, lkh.NgayBatDau, lkh.SoChoDaDat, t.SoKhachToiDa,
                       (t.SoKhachToiDa - lkh.SoChoDaDat) AS ChoTrong
                FROM lichkhoihanh lkh
                JOIN tour t ON lkh.MaTour = t.MaTour
                WHERE lkh.MaTour = :matour AND lkh.NgayBatDau >= CURDATE()
                ORDER BY lkh.NgayBatDau ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':matour' => $maTour]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Hàm kiểm tra xem khách đã lưu tour này chưa (trả về true/false)
    public function checkIsFavorited($maTK_DK, $maTour) {
        if (strpos($maTK_DK, 'DK') === 0) {
            $stmtDK = $this->conn->prepare("SELECT MaTK_DK FROM DuKhach WHERE MaDK = :maDK");
            $stmtDK->execute([':maDK' => $maTK_DK]);
            $res = $stmtDK->fetch(PDO::FETCH_ASSOC);
            if ($res) {
                $maTK_DK = $res['MaTK_DK'];
            }
        }
        
        $sql = "SELECT 1 FROM DanhSachYeuThich WHERE MaTK_DK = :maTK_DK AND MaTour = :maTour";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':maTK_DK' => $maTK_DK, ':maTour' => $maTour]);
        
        return $stmt->rowCount() > 0;
    }
    public function getReviewsByTour($maTour, $sort = 'newest') {
        
        $orderBy = "ORDER BY dg.NgayDG DESC"; 
        
        if ($sort === 'sao_tang') {
            $orderBy = "ORDER BY dg.SoSao ASC, dg.NgayDG DESC";
        } elseif ($sort === 'sao_giam') {
            $orderBy = "ORDER BY dg.SoSao DESC, dg.NgayDG DESC";
        }

        $sql = "SELECT 
                    dg.MaDG,
                    tk.HoTen AS TenKhachHang, 
                    dk.AnhDaiDien, 
                    dg.NgayDG AS NgayDanhGia, 
                    dg.SoSao, 
                    dg.NoiDung, 
                    dg.DieuAnTuong AS AnTuong,
                    GROUP_CONCAT(ha.DuongDan SEPARATOR '||') AS HinhAnh
                FROM phieudanhgia dg
                JOIN chuyendi cd ON dg.MaChuyenDi = cd.MaChuyenDi
                JOIN lichkhoihanh lkh ON cd.MaLichKhoiHanh = lkh.MaLichKhoiHanh
                JOIN taikhoan tk ON dg.MaTK_DK = tk.MaTK
                LEFT JOIN dukhach dk ON tk.MaTK = dk.MaTK_DK 
                LEFT JOIN hinhanhdanhgia ha ON dg.MaDG = ha.MaDG
                WHERE lkh.MaTour = :matour
                GROUP BY dg.MaDG, tk.HoTen, dk.AnhDaiDien, dg.NgayDG, dg.SoSao, dg.NoiDung, dg.DieuAnTuong
                $orderBy"; 
                
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':matour' => $maTour]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>