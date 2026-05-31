<?php
class AdminTourModel {
    private $conn;

    public function __construct() {
        global $conn;
        if (!$conn) {
            require_once __DIR__ . '/../config/db_connect.php';
        }
        $this->conn = $conn;
    }

    public function getAllTours() {
        // Lấy danh sách tour kèm theo tổng số lượt khách đã đăng ký từ bảng ChuyenDi
        $sql = "SELECT t.*, 
                COALESCE((SELECT SUM(c.SoLuongKhach) FROM ChuyenDi c WHERE c.MaTour = t.MaTour AND c.TrangThai != 'Đã hủy'), 0) as SoLuotDangKy
                FROM Tour t 
                ORDER BY t.NgayTao DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTourById($maTour) {
        $stmt = $this->conn->prepare("SELECT * FROM Tour WHERE MaTour = :maTour");
        $stmt->execute([':maTour' => $maTour]);
        return $stmt->fetch();
    }

    private function getNextMaTour() {
        $stmt = $this->conn->query("SELECT MaTour FROM Tour ORDER BY MaTour DESC LIMIT 1");
        $lastId = $stmt->fetchColumn();
        if (!$lastId) return 'TOUR000001';
        $num = intval(substr($lastId, 4)) + 1;
        return 'TOUR' . str_pad($num, 6, '0', STR_PAD_LEFT);
    }

    public function addTour($data) {
        $maTour = $this->getNextMaTour();
        $sql = "INSERT INTO Tour (MaTour, TenTour, DiaDiem, MoTa, Gia, SoNgay, SoKhachToiDa, VungDiaLy, HinhAnh, MaTK_QTV) 
                VALUES (:maTour, :tenTour, :diaDiem, :moTa, :gia, :soNgay, :soKhach, :vungDiaLy, :hinhAnh, :maQTV)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':maTour' => $maTour,
            ':tenTour' => $data['TenTour'],
            ':diaDiem' => $data['DiaDiem'],
            ':moTa' => $data['MoTa'],
            ':gia' => $data['Gia'],
            ':soNgay' => $data['SoNgay'],
            ':soKhach' => $data['SoKhachToiDa'],
            ':vungDiaLy' => $data['VungDiaLy'],
            ':hinhAnh' => $data['HinhAnh'],
            ':maQTV' => $data['MaTK_QTV']
        ]);
    }

    public function updateTour($data) {
        $sql = "UPDATE Tour SET 
                TenTour = :tenTour, DiaDiem = :diaDiem, MoTa = :moTa, 
                Gia = :gia, SoNgay = :soNgay, SoKhachToiDa = :soKhach, 
                VungDiaLy = :vungDiaLy";
        
        if (!empty($data['HinhAnh'])) {
            $sql .= ", HinhAnh = :hinhAnh";
        }
        $sql .= " WHERE MaTour = :maTour";

        $stmt = $this->conn->prepare($sql);
        $params = [
            ':tenTour' => $data['TenTour'],
            ':diaDiem' => $data['DiaDiem'],
            ':moTa' => $data['MoTa'],
            ':gia' => $data['Gia'],
            ':soNgay' => $data['SoNgay'],
            ':soKhach' => $data['SoKhachToiDa'],
            ':vungDiaLy' => $data['VungDiaLy'],
            ':maTour' => $data['MaTour']
        ];
        
        if (!empty($data['HinhAnh'])) {
            $params[':hinhAnh'] = $data['HinhAnh'];
        }

        return $stmt->execute($params);
    }

    public function deleteTour($maTour) {
        $stmt = $this->conn->prepare("DELETE FROM Tour WHERE MaTour = :maTour");
        return $stmt->execute([':maTour' => $maTour]);
    }
}
?>