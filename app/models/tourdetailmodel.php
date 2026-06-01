<?php
class TourDetailModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getTourById($maTour) {
        // Cập nhật câu lệnh SQL để lấy thêm TrungBinhSao và SoLuotDanhGia
        $sql = "SELECT t.*, 
                    (SELECT IFNULL(ROUND(AVG(dg.SoSao), 1), 0) 
                     FROM phieudanhgia dg 
                     JOIN chuyendi cd ON dg.MaChuyenDi = cd.MaChuyenDi 
                     WHERE cd.MaTour = t.MaTour) AS TrungBinhSao,
                    (SELECT COUNT(dg.MaDG) 
                     FROM phieudanhgia dg 
                     JOIN chuyendi cd ON dg.MaChuyenDi = cd.MaChuyenDi 
                     WHERE cd.MaTour = t.MaTour) AS SoLuotDanhGia
                FROM Tour t 
                WHERE t.MaTour = :matour";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':matour' => $maTour]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Hàm kiểm tra xem khách đã lưu tour này chưa (trả về true/false)
    public function checkIsFavorited($maTK_DK, $maTour) {
        // Chuyển đổi mã nếu Controller truyền mã bắt đầu bằng DK
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
        
        // Nếu tìm thấy ít nhất 1 dòng nghĩa là đã yêu thích
        return $stmt->rowCount() > 0;
    }
    public function getReviewsByTour($maTour, $sort = 'newest') {
        
        // 1. Logic sắp xếp động
        $orderBy = "ORDER BY dg.NgayDG DESC"; // Mặc định là mới nhất
        
        if ($sort === 'sao_tang') {
            $orderBy = "ORDER BY dg.SoSao ASC, dg.NgayDG DESC";
        } elseif ($sort === 'sao_giam') {
            $orderBy = "ORDER BY dg.SoSao DESC, dg.NgayDG DESC";
        }

        // 2. Chèn biến $orderBy vào cuối câu truy vấn
        $sql = "SELECT 
                    dg.MaDG,
                    tk.HoTen AS TenKhachHang, 
                    dk.AnhDaiDien, /* LẤY THÊM ẢNH AVATAR TỪ BẢNG DUKHACH */
                    dg.NgayDG AS NgayDanhGia, 
                    dg.SoSao, 
                    dg.NoiDung, 
                    dg.DieuAnTuong AS AnTuong,
                    GROUP_CONCAT(ha.DuongDan SEPARATOR '||') AS HinhAnh
                FROM phieudanhgia dg
                JOIN chuyendi cd ON dg.MaChuyenDi = cd.MaChuyenDi
                JOIN taikhoan tk ON dg.MaTK_DK = tk.MaTK
                LEFT JOIN dukhach dk ON tk.MaTK = dk.MaTK_DK /* KẾT NỐI ĐỂ LẤY AVATAR */
                LEFT JOIN hinhanhdanhgia ha ON dg.MaDG = ha.MaDG
                WHERE cd.MaTour = :matour
                GROUP BY dg.MaDG, tk.HoTen, dk.AnhDaiDien, dg.NgayDG, dg.SoSao, dg.NoiDung, dg.DieuAnTuong
                $orderBy"; /* <-- Bí quyết nằm ở đây */
                
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':matour' => $maTour]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>