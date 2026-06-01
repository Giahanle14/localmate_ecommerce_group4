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

    public function getTripStats() {
        $stats = [
            'all' => $this->conn->query("SELECT COUNT(*) FROM chuyendi")->fetchColumn(),
            'pending' => $this->conn->query("SELECT COUNT(cd.MaChuyenDi) FROM chuyendi cd JOIN lichkhoihanh lkh ON cd.MaLichKhoiHanh = lkh.MaLichKhoiHanh JOIN tour t ON lkh.MaTour = t.MaTour WHERE cd.TrangThai != 'Đã hủy' AND DATE_ADD(lkh.NgayBatDau, INTERVAL (IFNULL(t.SoNgay, 1) - 1) DAY) >= CURDATE()")->fetchColumn(),
            'completed' => $this->conn->query("SELECT COUNT(cd.MaChuyenDi) FROM chuyendi cd JOIN lichkhoihanh lkh ON cd.MaLichKhoiHanh = lkh.MaLichKhoiHanh JOIN tour t ON lkh.MaTour = t.MaTour WHERE cd.TrangThai != 'Đã hủy' AND DATE_ADD(lkh.NgayBatDau, INTERVAL (IFNULL(t.SoNgay, 1) - 1) DAY) < CURDATE()")->fetchColumn(),
            'cancel_req' => $this->conn->query("SELECT COUNT(*) FROM yeucauhuy WHERE TrangThai = 'Chưa xử lý'")->fetchColumn()
        ];
        return $stats;
    }

    public function getTrips($tab, $search, $daterange, $page, $limit) {
        $sql = "SELECT c.MaChuyenDi, lkh.NgayBatDau, DATE_ADD(lkh.NgayBatDau, INTERVAL (IFNULL(t.SoNgay, 1) - 1) DAY) as NgayKetThuc, c.TrangThai, 
                       tk.HoTen, t.TenTour, 
                       y.TrangThai as HuyTrangThai 
                FROM chuyendi c
                JOIN dukhach dk ON c.MaTK_DK = dk.MaTK_DK
                JOIN taikhoan tk ON dk.MaTK_DK = tk.MaTK
                JOIN lichkhoihanh lkh ON c.MaLichKhoiHanh = lkh.MaLichKhoiHanh
                JOIN tour t ON lkh.MaTour = t.MaTour
                LEFT JOIN yeucauhuy y ON c.MaChuyenDi = y.MaChuyenDi
                WHERE 1=1";
        
        $params = [];

        if ($tab === 'pending') {
            $sql .= " AND c.TrangThai != 'Đã hủy' AND DATE_ADD(lkh.NgayBatDau, INTERVAL (IFNULL(t.SoNgay, 1) - 1) DAY) >= CURDATE()";
        } elseif ($tab === 'completed') {
            $sql .= " AND c.TrangThai != 'Đã hủy' AND DATE_ADD(lkh.NgayBatDau, INTERVAL (IFNULL(t.SoNgay, 1) - 1) DAY) < CURDATE()";
        } elseif ($tab === 'cancel_req') {
            $sql .= " AND y.MaYeuCauHuy IS NOT NULL";
        }

        if (!empty($search)) {
            $sql .= " AND (c.MaChuyenDi LIKE :search OR tk.HoTen LIKE :search OR t.TenTour LIKE :search)";
            $params[':search'] = "%$search%";
        }

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
                    $sql .= " AND (lkh.NgayBatDau >= :start AND DATE_ADD(lkh.NgayBatDau, INTERVAL (IFNULL(t.SoNgay, 1) - 1) DAY) <= :end)";
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
        
        if ($tab === 'cancel_req') {
            $sql .= " ORDER BY CASE WHEN y.TrangThai = 'Chưa xử lý' THEN 0 ELSE 1 END, c.MaChuyenDi DESC LIMIT $limit OFFSET $offset";
        } else {
            $sql .= " ORDER BY c.MaChuyenDi DESC LIMIT $limit OFFSET $offset";
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $data = $stmt->fetchAll();

        return ['data' => $data, 'total' => $total];
    }

    public function getTripDetail($maChuyenDi) {
        $sql = "SELECT c.*, 
                       tk.HoTen, tk.Gmail, tk.SDT, dk.DiaChi, dk.SDTKhanCap, dk.AnhDaiDien, dk.HangThanhVien,
                       t.TenTour, t.HinhAnh as AnhTour, t.Gia as GiaTour, t.SoNgay, t.VungDiaLy,
                       lkh.NgayBatDau, DATE_ADD(lkh.NgayBatDau, INTERVAL (IFNULL(t.SoNgay, 1) - 1) DAY) as NgayKetThuc,
                       y.LyDoHuy, y.TrangThai as HuyTrangThai, y.NgayYeuCau
                FROM chuyendi c
                JOIN dukhach dk ON c.MaTK_DK = dk.MaTK_DK
                JOIN taikhoan tk ON dk.MaTK_DK = tk.MaTK
                JOIN lichkhoihanh lkh ON c.MaLichKhoiHanh = lkh.MaLichKhoiHanh
                JOIN tour t ON lkh.MaTour = t.MaTour
                LEFT JOIN yeucauhuy y ON c.MaChuyenDi = y.MaChuyenDi
                WHERE c.MaChuyenDi = :maChuyenDi";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':maChuyenDi' => $maChuyenDi]);
        return $stmt->fetch();
    }

    public function approveCancelRequest($maChuyenDi, $maQTV) {
        try {
            $this->conn->beginTransaction();

            $stmtInfo = $this->conn->prepare("SELECT MaLichKhoiHanh, SoLuongKhach FROM chuyendi WHERE MaChuyenDi = ?");
            $stmtInfo->execute([$maChuyenDi]);
            $cdInfo = $stmtInfo->fetch(PDO::FETCH_ASSOC);

            $stmt1 = $this->conn->prepare("UPDATE chuyendi SET TrangThai = 'Đã hủy' WHERE MaChuyenDi = ?");
            $stmt1->execute([$maChuyenDi]);

            $stmt2 = $this->conn->prepare("UPDATE yeucauhuy SET TrangThai = 'Đã xử lý', NgayHoanTat = NOW(), MaTK_QTV = ? WHERE MaChuyenDi = ?");
            $stmt2->execute([$maQTV, $maChuyenDi]);

            if ($cdInfo && $cdInfo['MaLichKhoiHanh']) {
                $stmt3 = $this->conn->prepare("UPDATE lichkhoihanh SET SoChoDaDat = SoChoDaDat - ? WHERE MaLichKhoiHanh = ?");
                $stmt3->execute([$cdInfo['SoLuongKhach'], $cdInfo['MaLichKhoiHanh']]);
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}
?>