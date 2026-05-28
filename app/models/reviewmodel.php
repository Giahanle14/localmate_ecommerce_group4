<?php
class ReviewModel {
    public static function generateNextMaDG() {
        global $conn;
        require_once __DIR__ . '/../config/db_connect.php';
        $sql = "SELECT MaDG FROM PhieuDanhGia WHERE MaDG LIKE 'DG%' ORDER BY MaDG DESC LIMIT 1";
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

    public static function getTripDetails($maChuyenDi) {
        global $conn;
        require_once __DIR__ . '/../config/db_connect.php'; 
        // Lấy đúng tên cột TongGiaTien và MaTK_DK
        $sql = "SELECT c.MaChuyenDi, c.NgayBatDau, c.NgayKetThuc, c.TongGiaTien, t.TenTour, t.DiaDiem, t.HinhAnh, c.MaTK_DK 
                FROM ChuyenDi c 
                JOIN Tour t ON c.MaTour = t.MaTour 
                WHERE c.MaChuyenDi = :machuyendi";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':machuyendi' => $maChuyenDi]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function saveRating($maDG, $noiDung, $soSao, $dieuAnTuong, $maTK_DK, $maChuyenDi) {
        global $conn;
        require_once __DIR__ . '/../config/db_connect.php';
        $sql = "INSERT INTO PhieuDanhGia (MaDG, NoiDung, SoSao, NgayDG, DieuAnTuong, MaTK_DK, MaChuyenDi) 
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
        $sql = "SELECT * FROM PhieuDanhGia WHERE MaChuyenDi = :machuyendi";
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
        $sql = "UPDATE PhieuDanhGia 
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
        $sql = "DELETE FROM PhieuDanhGia WHERE MaDG = :madg";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':madg' => $maDG]);
    }
}
?>