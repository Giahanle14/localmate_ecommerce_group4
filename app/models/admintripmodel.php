<?php
class AdminTripModel {
    private $conn;

    public function __construct() {
        global $conn;
        if (!$conn) {
            require_once __DIR__ . '/../config/db_connect.php';
        }
        $this->conn = $conn;
    }

    // Lấy số lượng thống kê cho các Tab
    public function getTripStats() {
        $stats = [
            'all' => $this->conn->query("SELECT COUNT(*) FROM ChuyenDi")->fetchColumn(),
            'pending' => $this->conn->query("SELECT COUNT(*) FROM ChuyenDi WHERE TrangThai != 'Đã hủy' AND NgayKetThuc >= CURDATE()")->fetchColumn(),
            'completed' => $this->conn->query("SELECT COUNT(*) FROM ChuyenDi WHERE TrangThai != 'Đã hủy' AND NgayKetThuc < CURDATE()")->fetchColumn(),
            'cancel_req' => $this->conn->query("SELECT COUNT(*) FROM YeuCauHuy WHERE TrangThai = 'Chưa xử lý'")->fetchColumn()
        ];
        return $stats;
    }

    // Lấy danh sách (Lọc theo tab, ngày kết thúc và khoảng thời gian)
    public function getTrips($tab, $search, $daterange, $page, $limit) {
        $sql = "SELECT c.MaChuyenDi, c.NgayBatDau, c.NgayKetThuc, c.TrangThai, 
                       tk.HoTen, t.TenTour, 
                       y.TrangThai as HuyTrangThai 
                FROM ChuyenDi c
                JOIN DuKhach dk ON c.MaTK_DK = dk.MaTK_DK
                JOIN TaiKhoan tk ON dk.MaTK_DK = tk.MaTK
                JOIN Tour t ON c.MaTour = t.MaTour
                LEFT JOIN YeuCauHuy y ON c.MaChuyenDi = y.MaChuyenDi
                WHERE 1=1";
        
        $params = [];

        // Lọc Tab tự động
        if ($tab === 'pending') {
            $sql .= " AND c.TrangThai != 'Đã hủy' AND c.NgayKetThuc >= CURDATE()";
        } elseif ($tab === 'completed') {
            $sql .= " AND c.TrangThai != 'Đã hủy' AND c.NgayKetThuc < CURDATE()";
        } elseif ($tab === 'cancel_req') {
            // CHỈ lấy các chuyến đi CÓ TỒN TẠI dữ liệu trong bảng YeuCauHuy
            $sql .= " AND y.MaYeuCauHuy IS NOT NULL";
        }

        // Lọc Search
        if (!empty($search)) {
            $sql .= " AND (c.MaChuyenDi LIKE :search OR tk.HoTen LIKE :search OR t.TenTour LIKE :search)";
            $params[':search'] = "%$search%";
        }

        // Lọc theo khoảng ngày khởi hành
        if (!empty($daterange)) {
            preg_match_all('/(\d{2}\/\d{2}\/\d{4})/', $daterange, $matches);
            
            if (!empty($matches[1])) {
                $startStr = $matches[1][0]; 
                $endStr = isset($matches[1][1]) ? $matches[1][1] : $startStr; 
                
                $startObj = DateTime::createFromFormat('d/m/Y', $startStr);
                $endObj = DateTime::createFromFormat('d/m/Y', $endStr);
                
                if ($startObj && $endObj) {
                    $startDate = $startObj->format('Y-m-d');
                    $endDate = $endObj->format('Y-m-d');
                    
                    $sql .= " AND (c.NgayBatDau >= :start AND c.NgayKetThuc <= :end)";
                    $params[':start'] = $startDate;
                    $params[':end'] = $endDate;
                }
            }
        }

        $fromPos = strpos($sql, 'FROM');
        $countSql = "SELECT COUNT(*) " . substr($sql, $fromPos);
        $stmtCount = $this->conn->prepare($countSql);
        $stmtCount->execute($params);
        $total = $stmtCount->fetchColumn();

        $offset = ($page - 1) * $limit;
        
        // Sắp xếp chuyến đi
        if ($tab === 'cancel_req') {
            // TỰ ĐỘNG GHIM: Đưa các yêu cầu 'Chưa xử lý' lên đầu danh sách để ưu tiên duyệt
            $sql .= " ORDER BY CASE WHEN y.TrangThai = 'Chưa xử lý' THEN 0 ELSE 1 END, c.MaChuyenDi DESC LIMIT $limit OFFSET $offset";
        } else {
            $sql .= " ORDER BY c.MaChuyenDi DESC LIMIT $limit OFFSET $offset";
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $data = $stmt->fetchAll();

        return ['data' => $data, 'total' => $total];
    }

    // Lấy thông tin chi tiết của chuyến đi
    public function getTripDetail($maChuyenDi) {
        $sql = "SELECT c.*, 
                       tk.HoTen, tk.Gmail, tk.SDT, dk.DiaChi, dk.SDTKhanCap, dk.AnhDaiDien, dk.HangThanhVien,
                       t.TenTour, t.HinhAnh as AnhTour, t.Gia as GiaTour, t.SoNgay, t.VungDiaLy,
                       y.LyDoHuy, y.TrangThai as HuyTrangThai, y.NgayYeuCau
                FROM ChuyenDi c
                JOIN DuKhach dk ON c.MaTK_DK = dk.MaTK_DK
                JOIN TaiKhoan tk ON dk.MaTK_DK = tk.MaTK
                JOIN Tour t ON c.MaTour = t.MaTour
                LEFT JOIN YeuCauHuy y ON c.MaChuyenDi = y.MaChuyenDi
                WHERE c.MaChuyenDi = :maChuyenDi";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':maChuyenDi' => $maChuyenDi]);
        return $stmt->fetch();
    }

    // Xử lý Hủy
    public function approveCancelRequest($maChuyenDi, $maQTV) {
        try {
            $this->conn->beginTransaction();
            $stmt1 = $this->conn->prepare("UPDATE ChuyenDi SET TrangThai = 'Đã hủy' WHERE MaChuyenDi = ?");
            $stmt1->execute([$maChuyenDi]);

            $stmt2 = $this->conn->prepare("UPDATE YeuCauHuy SET TrangThai = 'Đã xử lý', NgayHoanTat = NOW(), MaTK_QTV = ? WHERE MaChuyenDi = ?");
            $stmt2->execute([$maQTV, $maChuyenDi]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}
?>