<?php
class ReviewModel {
    public static function generateNextMaDG() {
        global $conn;
        require_once __DIR__ . '/../config/db_connect.php';
        $sql = "SELECT MaDG FROM phieudanhgia WHERE MaDG LIKE 'DG%' ORDER BY MaDG DESC LIMIT 1";
        $stmt = $conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $lastNum = (int)substr($row['MaDG'], 2);
            $nextNum = $lastNum + 1;
            return 'DG' . str_pad($nextNum, 8, '0', STR_PAD_LEFT);
        }
        return 'DG00000001';
    }

    public static function generateNextMaHinhAnh() {
        global $conn;
        require_once __DIR__ . '/../config/db_connect.php';
        $sql = "SELECT MaHinhAnhDG FROM hinhanhdanhgia ORDER BY MaHinhAnhDG DESC LIMIT 1";
        $stmt = $conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $lastNum = (int)substr($row['MaHinhAnhDG'], 2);
            $nextNum = $lastNum + 1;
            return 'HA' . str_pad($nextNum, 8, '0', STR_PAD_LEFT);
        }
        return 'HA00000001';
    }

    // ĐÃ SỬA: JOIN qua lichkhoihanh để lấy NgayBatDau và tính NgayKetThuc
    public static function getTripDetails($maChuyenDi) {
        global $conn;
        require_once __DIR__ . '/../config/db_connect.php'; 
        
        $sql = "SELECT c.MaChuyenDi, lkh.NgayBatDau, 
                       DATE_ADD(lkh.NgayBatDau, INTERVAL (t.SoNgay - 1) DAY) AS NgayKetThuc, 
                       c.TongGiaTien, t.TenTour, t.DiaDiem, t.HinhAnh, c.MaTK_DK 
                FROM chuyendi c 
                JOIN lichkhoihanh lkh ON c.MaLichKhoiHanh = lkh.MaLichKhoiHanh
                JOIN tour t ON lkh.MaTour = t.MaTour 
                WHERE c.MaChuyenDi = :machuyendi";
                
        $stmt = $conn->prepare($sql);
        $stmt->execute([':machuyendi' => $maChuyenDi]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function saveRating($maDG, $noiDung, $soSao, $dieuAnTuong, $maTK_DK, $maChuyenDi) {
        global $conn;
        require_once __DIR__ . '/../config/db_connect.php';
        $sql = "INSERT INTO phieudanhgia (MaDG, NoiDung, SoSao, NgayDG, DieuAnTuong, MaTK_DK, MaChuyenDi) 
                VALUES (:madg, :noidung, :sosao, NOW(), :dieuantuong, :matk_dk, :machuyendi)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':madg' => $maDG, ':noidung' => $noiDung, ':sosao' => $soSao,
            ':dieuantuong' => $dieuAnTuong, ':matk_dk' => $maTK_DK, ':machuyendi' => $maChuyenDi
        ]);
    }

    public static function saveReviewImage($maHinhAnhDG, $duongDan, $maDG) {
        global $conn;
        require_once __DIR__ . '/../config/db_connect.php';
        $sql = "INSERT INTO hinhanhdanhgia (MaHinhAnhDG, DuongDan, MaDG) VALUES (:mahinh, :duongdan, :madg)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':mahinh' => $maHinhAnhDG, ':duongdan' => $duongDan, ':madg' => $maDG]);
    }

    // --- CÁC HÀM MỚI ĐƯỢC BỔ SUNG ---

    // Lấy đánh giá cũ dựa vào Mã Chuyến Đi
    public static function getReviewByTripId($maChuyenDi) {
        global $conn;
        require_once __DIR__ . '/../config/db_connect.php';
        $sql = "SELECT * FROM phieudanhgia WHERE MaChuyenDi = :machuyendi";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':machuyendi' => $maChuyenDi]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách ảnh của đánh giá
    public static function getReviewImages($maDG) {
        global $conn;
        require_once __DIR__ . '/../config/db_connect.php';
        $sql = "SELECT * FROM hinhanhdanhgia WHERE MaDG = :madg";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':madg' => $maDG]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật đánh giá
    public static function updateRating($maDG, $noiDung, $soSao, $dieuAnTuong) {
        global $conn;
        require_once __DIR__ . '/../config/db_connect.php';
        $sql = "UPDATE phieudanhgia 
                SET NoiDung = :noidung, SoSao = :sosao, DieuAnTuong = :dieuantuong, NgayDG = NOW() 
                WHERE MaDG = :madg";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':noidung' => $noiDung,
            ':sosao' => $soSao,
            ':dieuantuong' => $dieuAnTuong,
            ':madg' => $maDG
        ]);
    }

    // Xóa đánh giá (Và xóa luôn ảnh liên quan)
    public static function deleteReview($maDG) {
        global $conn;
        require_once __DIR__ . '/../config/db_connect.php';
        
        // Bắt buộc xóa ảnh trước để không bị lỗi khóa ngoại (Foreign Key)
        $sqlImg = "DELETE FROM hinhanhdanhgia WHERE MaDG = :madg";
        $stmtImg = $conn->prepare($sqlImg);
        $stmtImg->execute([':madg' => $maDG]);

        // Xóa phiếu đánh giá
        $sql = "DELETE FROM phieudanhgia WHERE MaDG = :madg";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':madg' => $maDG]);
    }
    
    // Hàm xóa 1 hình ảnh dựa vào Mã Hình Ảnh
    public static function deleteReviewImage($maHinhAnh) {
        global $conn;
        require_once __DIR__ . '/../config/db_connect.php';
        
        // Lấy đường dẫn để xóa file vật lý
        $sql = "SELECT DuongDan FROM hinhanhdanhgia WHERE MaHinhAnhDG = :mahinh";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':mahinh' => $maHinhAnh]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row && file_exists($row['DuongDan'])) {
            unlink($row['DuongDan']); // Xóa file ảnh trong thư mục public/image/reviews/
        }

        // Xóa data trong CSDL
        $sqlDel = "DELETE FROM hinhanhdanhgia WHERE MaHinhAnhDG = :mahinh";
        $stmtDel = $conn->prepare($sqlDel);
        return $stmtDel->execute([':mahinh' => $maHinhAnh]);
    }
}
?>