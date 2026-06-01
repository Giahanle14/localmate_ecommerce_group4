<?php
// BỔ SUNG: Nhúng file kết nối CSDL để biến $conn được khởi tạo trước khi Class gọi đến
require_once 'app/config/db_connect.php';

class HomeModel {
    private $conn;

    public function __construct() {
        global $conn; 
        $this->conn = $conn;
    }

    public function getToursNoiBat($maTK_DK = null) {
        $sql = "SELECT t.*, 
                (SELECT COUNT(*) FROM danhsachyeuthich d WHERE d.MaTour = t.MaTour) as SoLuotThich,
                (SELECT COUNT(*) 
                 FROM phieudanhgia p 
                 JOIN chuyendi c ON p.MaChuyenDi = c.MaChuyenDi 
                 JOIN lichkhoihanh lkh ON c.MaLichKhoiHanh = lkh.MaLichKhoiHanh 
                 WHERE lkh.MaTour = t.MaTour) as SoDanhGia,
                (SELECT IFNULL(ROUND(AVG(p.SoSao), 1), 0) 
                 FROM phieudanhgia p 
                 JOIN chuyendi c ON p.MaChuyenDi = c.MaChuyenDi 
                 JOIN lichkhoihanh lkh ON c.MaLichKhoiHanh = lkh.MaLichKhoiHanh 
                 WHERE lkh.MaTour = t.MaTour) as SaoTrungBinh";
        
        if ($maTK_DK) {
            $sql .= ", (SELECT COUNT(*) FROM danhsachyeuthich d2 WHERE d2.MaTour = t.MaTour AND d2.MaTK_DK = :ma_tk) as IsLiked";
        } else {
            $sql .= ", 0 as IsLiked";
        }

        $sql .= " FROM tour t ORDER BY t.NgayTao DESC LIMIT 6";

        $stmt = $this->conn->prepare($sql);
        if ($maTK_DK) {
            $stmt->bindParam(':ma_tk', $maTK_DK, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getToursYeuThich($maTK_DK = null) {
        $sql = "SELECT t.*, 
                (SELECT COUNT(*) FROM danhsachyeuthich d WHERE d.MaTour = t.MaTour) as SoLuotThich,
                (SELECT COUNT(*) 
                 FROM phieudanhgia p 
                 JOIN chuyendi c ON p.MaChuyenDi = c.MaChuyenDi 
                 JOIN lichkhoihanh lkh ON c.MaLichKhoiHanh = lkh.MaLichKhoiHanh 
                 WHERE lkh.MaTour = t.MaTour) as SoDanhGia,
                (SELECT IFNULL(ROUND(AVG(p.SoSao), 1), 0) 
                 FROM phieudanhgia p 
                 JOIN chuyendi c ON p.MaChuyenDi = c.MaChuyenDi 
                 JOIN lichkhoihanh lkh ON c.MaLichKhoiHanh = lkh.MaLichKhoiHanh 
                 WHERE lkh.MaTour = t.MaTour) as SaoTrungBinh";
        
        if ($maTK_DK) {
            $sql .= ", (SELECT COUNT(*) FROM danhsachyeuthich d2 WHERE d2.MaTour = t.MaTour AND d2.MaTK_DK = :ma_tk) as IsLiked";
        } else {
            $sql .= ", 0 as IsLiked";
        }

        $sql .= " FROM tour t ORDER BY SoLuotThich DESC, t.NgayTao DESC LIMIT 6";

        $stmt = $this->conn->prepare($sql);
        if ($maTK_DK) {
            $stmt->bindParam(':ma_tk', $maTK_DK, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function toggleFavorite($maTK_DK, $maTour) {
        $checkSql = "SELECT * FROM danhsachyeuthich WHERE MaTK_DK = :ma_tk AND MaTour = :ma_tour";
        $stmt = $this->conn->prepare($checkSql);
        $stmt->execute([':ma_tk' => $maTK_DK, ':ma_tour' => $maTour]);
        
        if ($stmt->rowCount() > 0) {
            $delSql = "DELETE FROM danhsachyeuthich WHERE MaTK_DK = :ma_tk AND MaTour = :ma_tour";
            $this->conn->prepare($delSql)->execute([':ma_tk' => $maTK_DK, ':ma_tour' => $maTour]);
            return 'removed';
        } else {
            $insertSql = "INSERT INTO danhsachyeuthich (MaTK_DK, MaTour) VALUES (:ma_tk, :ma_tour)";
            $this->conn->prepare($insertSql)->execute([':maTK_DK' => $maTK_DK, ':ma_tour' => $maTour]);
            return 'added';
        }
    }

    public function getLatestReviews($limit = 12) {
        $sql = "SELECT p.MaDG, p.NoiDung, p.SoSao, p.NgayDG, p.DieuAnTuong, 
                       tk.HoTen, dk.AnhDaiDien, t.TenTour, t.MaTour
                FROM phieudanhgia p
                JOIN dukhach dk ON p.MaTK_DK = dk.MaTK_DK
                JOIN taikhoan tk ON dk.MaTK_DK = tk.MaTK
                JOIN chuyendi c ON p.MaChuyenDi = c.MaChuyenDi
                JOIN lichkhoihanh lkh ON c.MaLichKhoiHanh = lkh.MaLichKhoiHanh
                JOIN tour t ON lkh.MaTour = t.MaTour
                ORDER BY p.NgayDG DESC
                LIMIT :limit";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($reviews as &$review) {
            $maDG = $review['MaDG'];
            $sqlImg = "SELECT DuongDan FROM hinhanhdanhgia WHERE MaDG = :madg";
            $stmtImg = $this->conn->prepare($sqlImg);
            $stmtImg->execute([':madg' => $maDG]);
            $review['HinhAnh'] = $stmtImg->fetchAll(PDO::FETCH_COLUMN);
        }

        return $reviews;
    }
}
?>