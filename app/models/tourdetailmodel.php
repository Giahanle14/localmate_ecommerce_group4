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

    // Lấy lịch trình từ bảng lichtrinhtour và sắp xếp theo ThuTu
    public function getItinerary($maTour) {
        $sql = "SELECT * FROM lichtrinhtour WHERE MaTour = :matour ORDER BY ThuTu ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':matour' => $maTour]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
}
?>