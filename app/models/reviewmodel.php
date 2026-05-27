<?php
class RateModel {
    // 1. Tự động sinh mã MaDG tăng dần tiếp theo (Ví dụ: từ DG00000031 lên DG00000032)
    public static function generateNextMaDG() {
        global $conn;
        require_once 'db_connect.php';
        
        $sql = "SELECT MaDG FROM PhieuDanhGia WHERE MaDG LIKE 'DG%' ORDER BY MaDG DESC LIMIT 1";
        $stmt = $conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $lastNum = (int)substr($row['MaDG'], 2); // Cắt bỏ chữ 'DG'
            $nextNum = $lastNum + 1;
            return 'DG' . str_pad($nextNum, 8, '0', STR_PAD_LEFT); // Bù số 0 cho đủ 8 ký tự số
        }
        return 'DG00000001'; // Nếu chưa có đánh giá nào
    }

    // 2. Lấy thông tin chuyến đi phục vụ hiển thị form
    public static function getTripDetails($maChuyenDi) {
        global $conn;
        require_once 'db_connect.php'; 

        $sql = "SELECT c.MaChuyenDi, c.NgayBatDau, c.NgayKetThuc, t.TenTour, t.VungDiaLy, c.MaDK 
                FROM ChuyenDi c 
                JOIN Tour t ON c.MaTour = t.MaTour 
                WHERE c.MaChuyenDi = :machuyendi";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([':machuyendi' => $maChuyenDi]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 3. Lấy thông tin bài đánh giá hiện tại của chuyến đi (để sửa)
    public static function getRatingByTrip($maChuyenDi) {
        global $conn;
        require_once 'db_connect.php';
        
        $sql = "SELECT * FROM PhieuDanhGia WHERE MaChuyenDi = :machuyendi";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':machuyendi' => $maChuyenDi]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 4. Lưu phiếu đánh giá mới
    public static function saveRating($maDG, $noiDung, $soSao, $maDK, $maChuyenDi) {
        global $conn;
        require_once 'db_connect.php';

        $sql = "INSERT INTO PhieuDanhGia (MaDG, NoiDung, SoSao, NgayDG, MaDK, MaChuyenDi) 
                VALUES (:madg, :noidung, :sosao, NOW(), :madk, :machuyendi)";
        
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':madg' => $maDG,
            ':noidung' => $noiDung,
            ':sosao' => $soSao,
            ':madk' => $maDK,
            ':machuyendi' => $maChuyenDi
        ]);
    }

    // 5. Cập nhật bài đánh giá cũ (Chức năng Sửa)
    public static function updateRating($maDG, $noiDung, $soSao) {
        global $conn;
        require_once 'db_connect.php';

        $sql = "UPDATE PhieuDanhGia SET NoiDung = :noidung, SoSao = :sosao, NgayDG = NOW() WHERE MaDG = :madg";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':noidung' => $noiDung,
            ':sosao' => $soSao,
            ':madg' => $maDG
        ]);
    }
}
?>