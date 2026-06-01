<?php
class AdminScheduleModel {
    private $conn;

    public function __construct() {
        global $conn;
        if (!$conn) {
            require_once __DIR__ . '/../config/db_connect.php';
        }
        $this->conn = $conn;
    }

    // Nhận thêm tham số $daterange
    public function getAllSchedules($search = '', $page = 1, $limit = 10, $daterange = '') {
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT l.*, t.TenTour, t.SoKhachToiDa, t.SoNgay
                FROM lichkhoihanh l
                JOIN tour t ON l.MaTour = t.MaTour
                WHERE 1=1";
                
        $countSql = "SELECT COUNT(*) FROM lichkhoihanh l JOIN tour t ON l.MaTour = t.MaTour WHERE 1=1";
        
        $params = [];

        // Lọc theo chữ
        if (!empty($search)) {
            $searchCond = " AND (t.TenTour LIKE :search OR l.MaLichKhoiHanh LIKE :search)";
            $sql .= $searchCond;
            $countSql .= $searchCond;
            $params[':search'] = "%$search%";
        }
        
        // Lọc theo khoảng thời gian
        if (!empty($daterange)) {
            // 1. Chuẩn hóa chuỗi: Dù JS gửi lên " đến ", " to ", hay " - " thì đều gom về " - "
            $daterange_clean = str_replace([' đến ', ' to '], ' - ', $daterange);
            $dates = explode(" - ", $daterange_clean);
            
            if (count($dates) == 2) {
                // Đổi định dạng từ d/m/Y sang Y-m-d chuẩn SQL
                $dt1 = DateTime::createFromFormat('d/m/Y', trim($dates[0]));
                $dt2 = DateTime::createFromFormat('d/m/Y', trim($dates[1]));
                if ($dt1 && $dt2) {
                    // 2. Dùng hàm DATE() của SQL để loại bỏ giờ:phút:giây, giúp lọc chính xác 100%
                    $dateCond = " AND DATE(l.NgayBatDau) BETWEEN :startDate AND :endDate";
                    $sql .= $dateCond;
                    $countSql .= $dateCond;
                    $params[':startDate'] = $dt1->format('Y-m-d');
                    $params[':endDate'] = $dt2->format('Y-m-d');
                }
            } elseif (count($dates) == 1) {
                $dt = DateTime::createFromFormat('d/m/Y', trim($dates[0]));
                if ($dt) {
                    // Dùng hàm DATE() tương tự cho trường hợp lọc 1 ngày
                    $dateCond = " AND DATE(l.NgayBatDau) = :date";
                    $sql .= $dateCond;
                    $countSql .= $dateCond;
                    $params[':date'] = $dt->format('Y-m-d');
                }
            }
        }

        $sql .= " ORDER BY l.NgayBatDau DESC LIMIT $limit OFFSET $offset";
        
        // Truy vấn dữ liệu
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $data = $stmt->fetchAll();

        // Truy vấn tổng số lượng
        $stmtCount = $this->conn->prepare($countSql);
        $stmtCount->execute($params);
        
        return ['data' => $data, 'total' => $stmtCount->fetchColumn()];
    }

    public function getScheduleById($id) {
        $stmt = $this->conn->prepare("SELECT l.*, t.TenTour, t.SoKhachToiDa, t.SoNgay FROM lichkhoihanh l JOIN tour t ON l.MaTour = t.MaTour WHERE l.MaLichKhoiHanh = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function getAllTours() {
        $stmt = $this->conn->query("SELECT MaTour, TenTour, SoKhachToiDa FROM tour ORDER BY NgayTao DESC");
        return $stmt->fetchAll();
    }

    private function generateId() {
        // ĐÃ CHỈNH SỬA TỪ LKC SANG LKH
        $stmt = $this->conn->query("SELECT MaLichKhoiHanh FROM lichkhoihanh WHERE MaLichKhoiHanh LIKE 'LKH%' ORDER BY MaLichKhoiHanh DESC LIMIT 1");
        $lastId = $stmt->fetchColumn();
        if (!$lastId) return 'LKH0000001';
        $num = intval(substr($lastId, 3)) + 1;
        return 'LKH' . str_pad($num, 7, '0', STR_PAD_LEFT);
    }

    public function addSchedule($data) {
        $id = $this->generateId();
        $stmt = $this->conn->prepare("INSERT INTO lichkhoihanh (MaLichKhoiHanh, NgayBatDau, SoChoDaDat, MaTour) VALUES (:id, :ngayBatDau, 0, :maTour)");
        return $stmt->execute([
            ':id' => $id,
            ':ngayBatDau' => $data['NgayBatDau'],
            ':maTour' => $data['MaTour']
        ]);
    }

    public function updateSchedule($data) {
        $stmt = $this->conn->prepare("UPDATE lichkhoihanh SET NgayBatDau = :ngayBatDau, MaTour = :maTour WHERE MaLichKhoiHanh = :id");
        return $stmt->execute([
            ':ngayBatDau' => $data['NgayBatDau'],
            ':maTour' => $data['MaTour'],
            ':id' => $data['MaLichKhoiHanh']
        ]);
    }

    public function deleteSchedule($id) {
        $stmt = $this->conn->prepare("DELETE FROM lichkhoihanh WHERE MaLichKhoiHanh = ?");
        return $stmt->execute([$id]);
    }
}
?>