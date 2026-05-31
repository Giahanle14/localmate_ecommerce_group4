<?php
require_once 'app/config/db_connect.php';

class TourModel {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // --- HÀM CŨ CỦA BẠN: HÀM THẢ TIM ĐƯỢC GIỮ NGUYÊN ---
    public function toggleFavorite($maTK_DK, $maTour) {
        $checkSql = "SELECT * FROM DanhSachYeuThich WHERE MaTK_DK = :ma_tk AND MaTour = :ma_tour";
        $stmt = $this->conn->prepare($checkSql);
        $stmt->execute([':ma_tk' => $maTK_DK, ':ma_tour' => $maTour]);
        
        if ($stmt->rowCount() > 0) {
            $delSql = "DELETE FROM DanhSachYeuThich WHERE MaTK_DK = :ma_tk AND MaTour = :ma_tour";
            $this->conn->prepare($delSql)->execute([':ma_tk' => $maTK_DK, ':ma_tour' => $maTour]);
            return 'removed';
        } else {
            $insertSql = "INSERT INTO DanhSachYeuThich (MaTK_DK, MaTour) VALUES (:ma_tk, :ma_tour)";
            $this->conn->prepare($insertSql)->execute([':ma_tk' => $maTK_DK, ':ma_tour' => $maTour]);
            return 'added';
        }
    }

    // --- HÀM ĐÃ ĐƯỢC CẬP NHẬT: GỘP LỌC VÀ TÌM KIẾM ---
    public function getFilteredTours($params, $maTK_DK = null, $limit = 9, $offset = 0) {
        $sql = "SELECT t.*, 
                (SELECT COUNT(*) FROM DanhSachYeuThich d WHERE d.MaTour = t.MaTour) as SoLuotThich,
                (SELECT COUNT(*) FROM PhieuDanhGia p JOIN ChuyenDi c ON p.MaChuyenDi = c.MaChuyenDi WHERE c.MaTour = t.MaTour) as SoDanhGia,
                (SELECT AVG(SoSao) FROM PhieuDanhGia p JOIN ChuyenDi c ON p.MaChuyenDi = c.MaChuyenDi WHERE c.MaTour = t.MaTour) as SaoTrungBinh";
        
        if ($maTK_DK) {
            $sql .= ", (SELECT COUNT(*) FROM DanhSachYeuThich d2 WHERE d2.MaTour = t.MaTour AND d2.MaTK_DK = :ma_tk) as IsLiked";
        } else {
            $sql .= ", 0 as IsLiked";
        }

        // Bổ sung giới hạn phạm vi truy vấn chỉ trong 20 tour mới nhất nếu cần
        if (!empty($params['is_latest_20'])) {
            $sql .= " FROM (SELECT * FROM Tour ORDER BY NgayTao DESC LIMIT 20) t WHERE 1=1";
        } else {
            $sql .= " FROM Tour t WHERE 1=1";
        }
        
        $binds = [];

        // 1. Lọc từ khóa tìm kiếm từ Trang chủ
        if (!empty($params['search'])) {
            $sql .= " AND (t.TenTour LIKE :search OR t.DiaDiem LIKE :search OR t.VungDiaLy LIKE :search)";
            $binds[':search'] = '%' . $params['search'] . '%';
        }

        // 2. Lọc số khách từ Trang chủ
        if (!empty($params['guests_count']) && $params['guests_count'] > 0) {
            $sql .= " AND t.SoKhachToiDa >= :guests_count";
            $binds[':guests_count'] = $params['guests_count'];
        }

        // 3. Lọc vùng
        if (!empty($params['vung'])) {
            $sql .= " AND t.VungDiaLy = :vung";
            $binds[':vung'] = $params['vung'];
        }

        // 4. Lọc số ngày
        if (!empty($params['ngay'])) {
            if ($params['ngay'] == '1-2') $sql .= " AND t.SoNgay BETWEEN 1 AND 2";
            elseif ($params['ngay'] == '2-3') $sql .= " AND t.SoNgay BETWEEN 2 AND 3";
            elseif ($params['ngay'] == '3-5') $sql .= " AND t.SoNgay BETWEEN 3 AND 5";
        }

        // 5. Lọc giá
        if (!empty($params['gia_max'])) {
            $sql .= " AND (t.Gia * (1 - IFNULL(t.UuDai, 0))) <= :gia_max";
            $binds[':gia_max'] = $params['gia_max'];
        }

        // 6. Lọc loại trải nghiệm
        if (!empty($params['loai']) && is_array($params['loai'])) {
            $loaiConditions = [];
            foreach ($params['loai'] as $key => $loai) {
                $paramKey = ':loai_' . $key;
                $loaiConditions[] = "FIND_IN_SET($paramKey, t.LoaiTraiNghiem)";
                $binds[$paramKey] = $loai;
            }
            $sql .= " AND (" . implode(" OR ", $loaiConditions) . ")";
        }

        // 7. Sắp xếp
        $sort = $params['sort'] ?? 'moi_nhat';
        if ($sort == 'yeu_thich') {
            $sql .= " ORDER BY SoLuotThich DESC, t.NgayTao DESC";
        } elseif ($sort == 'gia_thap') {
            $sql .= " ORDER BY (t.Gia * (1 - IFNULL(t.UuDai, 0))) ASC";
        } elseif ($sort == 'gia_cao') {
            $sql .= " ORDER BY (t.Gia * (1 - IFNULL(t.UuDai, 0))) DESC";
        } else { 
            $sql .= " ORDER BY t.NgayTao DESC";
        }

        $sql .= " LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($sql);
        
        if ($maTK_DK) $stmt->bindParam(':ma_tk', $maTK_DK, PDO::PARAM_STR);
        foreach ($binds as $key => &$val) {
            $stmt->bindParam($key, $val);
        }
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- HÀM CẬP NHẬT: Đếm số lượng để phân trang ---
    public function countFilteredTours($params) {
        if (!empty($params['is_latest_20'])) {
            $sql = "SELECT COUNT(*) FROM (SELECT * FROM Tour ORDER BY NgayTao DESC LIMIT 20) t WHERE 1=1";
        } else {
            $sql = "SELECT COUNT(*) FROM Tour t WHERE 1=1";
        }
        
        $binds = [];

        if (!empty($params['search'])) {
            $sql .= " AND (t.TenTour LIKE :search OR t.DiaDiem LIKE :search OR t.VungDiaLy LIKE :search)";
            $binds[':search'] = '%' . $params['search'] . '%';
        }
        if (!empty($params['guests_count']) && $params['guests_count'] > 0) {
            $sql .= " AND t.SoKhachToiDa >= :guests_count";
            $binds[':guests_count'] = $params['guests_count'];
        }
        if (!empty($params['vung'])) {
            $sql .= " AND t.VungDiaLy = :vung";
            $binds[':vung'] = $params['vung'];
        }
        if (!empty($params['ngay'])) {
            if ($params['ngay'] == '1-2') $sql .= " AND t.SoNgay BETWEEN 1 AND 2";
            elseif ($params['ngay'] == '2-3') $sql .= " AND t.SoNgay BETWEEN 2 AND 3";
            elseif ($params['ngay'] == '3-5') $sql .= " AND t.SoNgay BETWEEN 3 AND 5";
        }
        if (!empty($params['gia_max'])) {
            $sql .= " AND (t.Gia * (1 - IFNULL(t.UuDai, 0))) <= :gia_max";
            $binds[':gia_max'] = $params['gia_max'];
        }
        if (!empty($params['loai']) && is_array($params['loai'])) {
            $loaiConditions = [];
            foreach ($params['loai'] as $key => $loai) {
                $paramKey = ':loai_' . $key;
                $loaiConditions[] = "FIND_IN_SET($paramKey, t.LoaiTraiNghiem)";
                $binds[$paramKey] = $loai;
            }
            $sql .= " AND (" . implode(" OR ", $loaiConditions) . ")";
        }

        $stmt = $this->conn->prepare($sql);
        foreach ($binds as $key => &$val) {
            $stmt->bindParam($key, $val);
        }
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // --- HÀM CŨ ĐƯỢC GIỮ NGUYÊN ---
    public function getLatestTours($maTK_DK = null, $limit = 6) {
        return $this->getFilteredTours(['sort' => 'moi_nhat'], $maTK_DK, $limit, 0);
    }
}
?>