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

    // Đếm số lượng tour cho các tab
    public function getTourStats() {
        try {
            $stats = [
                'all' => $this->conn->query("SELECT COUNT(*) FROM Tour")->fetchColumn(),
                // Đang mở: Chưa qua ngày bắt đầu hoặc chưa set ngày
                'open' => $this->conn->query("SELECT COUNT(*) FROM Tour WHERE NgayBatDau >= CURDATE() OR NgayBatDau IS NULL")->fetchColumn(),
                // Đã đóng: Ngày bắt đầu đã trôi qua
                'closed' => $this->conn->query("SELECT COUNT(*) FROM Tour WHERE NgayBatDau < CURDATE()")->fetchColumn()
            ];
            return $stats;
        } catch (Exception $e) {
            // Đề phòng trường hợp bạn chưa cập nhật cột NgayBatDau trong CSDL
            $count = $this->conn->query("SELECT COUNT(*) FROM Tour")->fetchColumn();
            return ['all' => $count, 'open' => 0, 'closed' => 0];
        }
    }

    // Thêm tham số $tab vào đây
    public function getFilteredTours($filters, $tab = 'all') {
        $sql = "SELECT t.*, 
                COALESCE((SELECT SUM(c.SoLuongKhach) FROM ChuyenDi c WHERE c.MaTour = t.MaTour AND c.TrangThai != 'Đã hủy'), 0) as SoLuotDangKy,
                (SELECT IFNULL(ROUND(AVG(dg.SoSao), 1), 0) FROM phieudanhgia dg JOIN chuyendi cd ON dg.MaChuyenDi = cd.MaChuyenDi WHERE cd.MaTour = t.MaTour) AS TrungBinhSao,
                (SELECT COUNT(dg.MaDG) FROM phieudanhgia dg JOIN chuyendi cd ON dg.MaChuyenDi = cd.MaChuyenDi WHERE cd.MaTour = t.MaTour) AS SoLuotDanhGia
                FROM Tour t WHERE 1=1";
        $params = [];

        // Xử lý Tab (Lưu ý: Yêu cầu CSDL phải có cột NgayBatDau)
        try {
            if ($tab === 'open') {
                $sql .= " AND (t.NgayBatDau >= CURDATE() OR t.NgayBatDau IS NULL)";
            } elseif ($tab === 'closed') {
                $sql .= " AND t.NgayBatDau < CURDATE()";
            }
        } catch (Exception $e) {}

        if (!empty($filters['search'])) {
            $sql .= " AND (t.TenTour LIKE :search OR t.DiaDiem LIKE :search OR t.MaTour LIKE :search)";
            $params[':search'] = "%{$filters['search']}%";
        }
        if (!empty($filters['vung'])) {
            $sql .= " AND t.VungDiaLy = :vung";
            $params[':vung'] = $filters['vung'];
        }
        if (!empty($filters['trainghiem'])) {
            $sql .= " AND FIND_IN_SET(:trainghiem, t.LoaiTraiNghiem) > 0";
            $params[':trainghiem'] = $filters['trainghiem'];
        }
        if (!empty($filters['gia'])) {
            if ($filters['gia'] === 'duoi_1m') {
                $sql .= " AND t.Gia < 1000000";
            } elseif ($filters['gia'] === '1m_3m') {
                $sql .= " AND t.Gia BETWEEN 1000000 AND 3000000";
            } elseif ($filters['gia'] === 'tren_3m') {
                $sql .= " AND t.Gia > 3000000";
            }
        }
        $sql .= " ORDER BY t.NgayTao DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
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
        $sql = "INSERT INTO Tour (MaTour, TenTour, DiaDiem, MoTa, Gia, SoNgay, SoKhachToiDa, VungDiaLy, NgayBatDau, NgayKetThuc, HinhAnh, MaTK_QTV) 
                VALUES (:maTour, :tenTour, :diaDiem, :moTa, :gia, :soNgay, :soKhach, :vungDiaLy, :ngayBatDau, :ngayKetThuc, :hinhAnh, :maQTV)";
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
            ':ngayBatDau' => $data['NgayBatDau'],
            ':ngayKetThuc' => $data['NgayKetThuc'],
            ':hinhAnh' => $data['HinhAnh'],
            ':maQTV' => $data['MaTK_QTV']
        ]);
    }

    public function updateTour($data) {
        $sql = "UPDATE Tour SET 
                TenTour = :tenTour, DiaDiem = :diaDiem, MoTa = :moTa, 
                Gia = :gia, SoNgay = :soNgay, SoKhachToiDa = :soKhach, 
                VungDiaLy = :vungDiaLy, NgayBatDau = :ngayBatDau, NgayKetThuc = :ngayKetThuc";
        
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
            ':ngayBatDau' => $data['NgayBatDau'],
            ':ngayKetThuc' => $data['NgayKetThuc'],
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
    public function getReviewsByTour($maTour) {
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
                JOIN taikhoan tk ON dg.MaTK_DK = tk.MaTK
                LEFT JOIN dukhach dk ON tk.MaTK = dk.MaTK_DK
                LEFT JOIN hinhanhdanhgia ha ON dg.MaDG = ha.MaDG
                WHERE cd.MaTour = :matour
                GROUP BY dg.MaDG, tk.HoTen, dk.AnhDaiDien, dg.NgayDG, dg.SoSao, dg.NoiDung, dg.DieuAnTuong
                ORDER BY dg.NgayDG DESC";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':matour' => $maTour]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>