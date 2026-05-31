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
            'pending' => $this->conn->query("SELECT COUNT(*) FROM ChuyenDi WHERE TrangThai = 'Chưa hoàn thành'")->fetchColumn(),
            'completed' => $this->conn->query("SELECT COUNT(*) FROM ChuyenDi WHERE TrangThai = 'Đã hoàn thành'")->fetchColumn(),
            'cancel_req' => $this->conn->query("SELECT COUNT(*) FROM YeuCauHuy WHERE TrangThai = 'Chưa xử lý'")->fetchColumn()
        ];
        return $stats;
    }

    // Lấy danh sách chuyến đi có phân trang và tìm kiếm
    public function getTrips($tab, $search, $page, $limit) {
        $sql = "SELECT c.MaChuyenDi, c.NgayBatDau, c.NgayKetThuc, c.TrangThai, 
                       tk.HoTen, t.TenTour, 
                       y.TrangThai as HuyTrangThai 
                FROM ChuyenDi c
                JOIN DuKhach dk ON c.MaTK_DK = dk.MaTK_DK
                JOIN TaiKhoan tk ON dk.MaTK_DK = tk.MaTK
                JOIN Tour t ON c.MaTour = t.MaTour
                LEFT JOIN YeuCauHuy y ON c.MaChuyenDi = y.MaChuyenDi AND y.TrangThai = 'Chưa xử lý'
                WHERE 1=1";
        
        $params = [];

        // Lọc theo Tab
        if ($tab === 'pending') {
            $sql .= " AND c.TrangThai = 'Chưa hoàn thành'";
        } elseif ($tab === 'completed') {
            $sql .= " AND c.TrangThai = 'Đã hoàn thành'";
        } elseif ($tab === 'cancel_req') {
            $sql .= " AND y.MaYeuCauHuy IS NOT NULL";
        }

        // Tìm kiếm theo Mã, Tên Khách, Tên Tour
        if (!empty($search)) {
            $sql .= " AND (c.MaChuyenDi LIKE :search OR tk.HoTen LIKE :search OR t.TenTour LIKE :search)";
            $params[':search'] = "%$search%";
        }

       // Đếm tổng số record để phân trang
        $fromPos = strpos($sql, 'FROM');
        $countSql = "SELECT COUNT(*) " . substr($sql, $fromPos);
        $stmtCount = $this->conn->prepare($countSql);
        $stmtCount->execute($params);
        $total = $stmtCount->fetchColumn();

        // Lấy dữ liệu phân trang
        $offset = ($page - 1) * $limit;
        $sql .= " ORDER BY c.NgayBatDau DESC LIMIT $limit OFFSET $offset";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $data = $stmt->fetchAll();

        return ['data' => $data, 'total' => $total];
    }
}
?>