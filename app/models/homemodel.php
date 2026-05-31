<?php
// BỔ SUNG: Nhúng file kết nối CSDL để biến $conn được khởi tạo trước khi Class gọi đến
require_once 'app/config/db_connect.php';

class HomeModel {
    private $conn;

    public function __construct() {
        global $conn; // Lấy biến kết nối từ app/config/db_connect.php
        $this->conn = $conn;
    }

    // Hàm lấy danh sách Tour Nổi Bật (Lấy 6 tour mới nhất)
    public function getToursNoiBat($maTK_DK = null) {
        $sql = "SELECT t.*, 
                (SELECT COUNT(*) FROM DanhSachYeuThich d WHERE d.MaTour = t.MaTour) as SoLuotThich,
                (SELECT COUNT(*) FROM PhieuDanhGia p JOIN ChuyenDi c ON p.MaChuyenDi = c.MaChuyenDi WHERE c.MaTour = t.MaTour) as SoDanhGia,
                (SELECT AVG(SoSao) FROM PhieuDanhGia p JOIN ChuyenDi c ON p.MaChuyenDi = c.MaChuyenDi WHERE c.MaTour = t.MaTour) as SaoTrungBinh";
        
        if ($maTK_DK) {
            $sql .= ", (SELECT COUNT(*) FROM DanhSachYeuThich d2 WHERE d2.MaTour = t.MaTour AND d2.MaTK_DK = :ma_tk) as IsLiked";
        } else {
            $sql .= ", 0 as IsLiked";
        }

        $sql .= " FROM Tour t ORDER BY t.NgayTao DESC LIMIT 6";

        $stmt = $this->conn->prepare($sql);
        if ($maTK_DK) {
            $stmt->bindParam(':ma_tk', $maTK_DK, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hàm lấy danh sách Tour Yêu Thích (Lấy 6 tour có nhiều lượt thả tim nhất)
    public function getToursYeuThich($maTK_DK = null) {
        $sql = "SELECT t.*, 
                (SELECT COUNT(*) FROM DanhSachYeuThich d WHERE d.MaTour = t.MaTour) as SoLuotThich,
                (SELECT COUNT(*) FROM PhieuDanhGia p JOIN ChuyenDi c ON p.MaChuyenDi = c.MaChuyenDi WHERE c.MaTour = t.MaTour) as SoDanhGia,
                (SELECT AVG(SoSao) FROM PhieuDanhGia p JOIN ChuyenDi c ON p.MaChuyenDi = c.MaChuyenDi WHERE c.MaTour = t.MaTour) as SaoTrungBinh";
        
        if ($maTK_DK) {
            $sql .= ", (SELECT COUNT(*) FROM DanhSachYeuThich d2 WHERE d2.MaTour = t.MaTour AND d2.MaTK_DK = :ma_tk) as IsLiked";
        } else {
            $sql .= ", 0 as IsLiked";
        }

        $sql .= " FROM Tour t ORDER BY SoLuotThich DESC, t.NgayTao DESC LIMIT 6";

        $stmt = $this->conn->prepare($sql);
        if ($maTK_DK) {
            $stmt->bindParam(':ma_tk', $maTK_DK, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hàm xử lý Thả tim / Bỏ tim (Dùng chung cho AJAX)
    public function toggleFavorite($maTK_DK, $maTour) {
        // Kiểm tra xem đã tim chưa
        $checkSql = "SELECT * FROM DanhSachYeuThich WHERE MaTK_DK = :ma_tk AND MaTour = :ma_tour";
        $stmt = $this->conn->prepare($checkSql);
        $stmt->execute([':ma_tk' => $maTK_DK, ':ma_tour' => $maTour]);
        
        if ($stmt->rowCount() > 0) {
            // Đã tim -> Xóa (Bỏ tim)
            $delSql = "DELETE FROM DanhSachYeuThich WHERE MaTK_DK = :ma_tk AND MaTour = :ma_tour";
            $this->conn->prepare($delSql)->execute([':ma_tk' => $maTK_DK, ':ma_tour' => $maTour]);
            return 'removed';
        } else {
            // Chưa tim -> Thêm
            $insertSql = "INSERT INTO DanhSachYeuThich (MaTK_DK, MaTour) VALUES (:ma_tk, :ma_tour)";
            $this->conn->prepare($insertSql)->execute([':ma_tk' => $maTK_DK, ':ma_tour' => $maTour]);
            return 'added';
        }
    }

    // Hàm lấy danh sách Đánh giá mới nhất (Kinh nghiệm đi tour)
    public function getLatestReviews($limit = 4) {
        // 1. Join 5 bảng: PhieuDanhGia, DuKhach, TaiKhoan, ChuyenDi, Tour để lấy đủ thông tin
        $sql = "SELECT p.MaDG, p.NoiDung, p.SoSao, p.NgayDG,p.DieuAnTuong, 
                       tk.HoTen, dk.AnhDaiDien, t.TenTour, t.MaTour
                FROM PhieuDanhGia p
                JOIN DuKhach dk ON p.MaTK_DK = dk.MaTK_DK
                JOIN TaiKhoan tk ON dk.MaTK_DK = tk.MaTK
                JOIN ChuyenDi c ON p.MaChuyenDi = c.MaChuyenDi
                JOIN Tour t ON c.MaTour = t.MaTour
                ORDER BY p.NgayDG DESC
                LIMIT :limit";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 2. Lấy hình ảnh đính kèm cho từng bài đánh giá
        foreach ($reviews as &$review) {
            $sqlImg = "SELECT DuongDan FROM HinhAnhDanhGia WHERE MaDG = :ma_dg LIMIT 3";
            $stmtImg = $this->conn->prepare($sqlImg);
            $stmtImg->execute([':ma_dg' => $review['MaDG']]);
            // Lưu thành 1 mảng các đường dẫn ảnh
            $review['HinhAnh'] = $stmtImg->fetchAll(PDO::FETCH_COLUMN); 
        }

        return $reviews;
    }
}
?>