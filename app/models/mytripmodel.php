<?php
class MytripModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * 1. Lấy danh sách chuyến đi theo trạng thái
     */
    public function getTripsByCustomer($maTK, $trangThai) {
        $sql = "SELECT c.MaChuyenDi, c.NgayBatDau, c.NgayKetThuc, c.TongGiaTien, c.SoLuongKhach, 
                       t.TenTour, t.DiaDiem, t.HinhAnh, dg.MaDG, dg.SoSao
                FROM ChuyenDi c 
                JOIN Tour t ON c.MaTour = t.MaTour
                LEFT JOIN PhieuDanhGia dg ON c.MaChuyenDi = dg.MaChuyenDi
                WHERE c.MaTK_DK = :matk AND c.TrangThai = :trangthai
                ORDER BY c.NgayBatDau DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':matk' => $maTK, ':trangthai' => $trangThai]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getStatsSql() {
        return "
            (SELECT IFNULL(ROUND(AVG(dg.SoSao), 1), 0) FROM phieudanhgia dg JOIN chuyendi cd ON dg.MaChuyenDi = cd.MaChuyenDi WHERE cd.MaTour = t.MaTour) AS TrungBinhSao,
            (SELECT COUNT(dg.MaDG) FROM phieudanhgia dg JOIN chuyendi cd ON dg.MaChuyenDi = cd.MaChuyenDi WHERE cd.MaTour = t.MaTour) AS SoLuotDanhGia,
            (SELECT COUNT(*) FROM danhsachyeuthich yt WHERE yt.MaTour = t.MaTour) AS SoLuotThich
        ";
    }

    /**
     * 2. LẤY TOUR GỢI Ý
     */
    public function getSuggestedTours($maTK, $limit = 3) {
        $statsSql = $this->getStatsSql();
        
        // 2.1: Lấy các loại trải nghiệm khách đã từng đặt
        $sql_history = "SELECT DISTINCT t.LoaiTraiNghiem 
                        FROM ChuyenDi c 
                        JOIN Tour t ON c.MaTour = t.MaTour 
                        WHERE c.MaTK_DK = :matk";
        $stmt_hist = $this->conn->prepare($sql_history);
        $stmt_hist->execute([':matk' => $maTK]);
        $history_rows = $stmt_hist->fetchAll(PDO::FETCH_ASSOC);

        // Nếu khách hàng mới tinh -> Gợi ý ngẫu nhiên
        if (empty($history_rows)) {
            $sql_random = "SELECT t.*, $statsSql FROM Tour t ORDER BY RAND() LIMIT :limit";
            $stmt_rand = $this->conn->prepare($sql_random);
            $stmt_rand->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt_rand->execute();
            return $stmt_rand->fetchAll(PDO::FETCH_ASSOC);
        }

        // Tách từ khóa trải nghiệm
        $tags_played = [];
        foreach ($history_rows as $row) {
            if (!empty($row['LoaiTraiNghiem'])) {
                $splitted = explode(',', $row['LoaiTraiNghiem']);
                foreach ($splitted as $tag) {
                    $tag_trimmed = trim($tag);
                    if (!in_array($tag_trimmed, $tags_played) && $tag_trimmed != '') {
                        $tags_played[] = $tag_trimmed;
                    }
                }
            }
        }

        // 2.2: Lọc tour có tag tương ứng
        $where_clauses = [];
        $params = [];
        foreach ($tags_played as $index => $tag) {
            $where_clauses[] = "t.LoaiTraiNghiem LIKE :tag" . $index;
            $params[":tag" . $index] = "%" . $tag . "%";
        }
        
        $where_sql = implode(' OR ', $where_clauses);
        $sql_suggest = "SELECT t.*, $statsSql FROM Tour t 
                        WHERE ($where_sql) 
                        AND t.MaTour NOT IN (SELECT MaTour FROM ChuyenDi WHERE MaTK_DK = :matk)
                        ORDER BY RAND() LIMIT :limit";

        $stmt_sug = $this->conn->prepare($sql_suggest);
        foreach ($params as $param_key => $param_val) {
            $stmt_sug->bindValue($param_key, $param_val);
        }
        $stmt_sug->bindValue(':matk', $maTK);
        $stmt_sug->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt_sug->execute();
        
        $result = $stmt_sug->fetchAll(PDO::FETCH_ASSOC);

        // Bù thêm tour nếu không đủ limit
        if (count($result) < $limit) {
            $needed = $limit - count($result);
            $sql_fallback = "SELECT t.*, $statsSql FROM Tour t WHERE t.MaTour NOT IN (SELECT MaTour FROM ChuyenDi WHERE MaTK_DK = :matk) ORDER BY RAND() LIMIT :needed";
            $stmt_fall = $this->conn->prepare($sql_fallback);
            $stmt_fall->bindValue(':needed', (int)$needed, PDO::PARAM_INT);
            $stmt_fall->bindValue(':matk', $maTK);
            $stmt_fall->execute();
            $fallback_tours = $stmt_fall->fetchAll(PDO::FETCH_ASSOC);
            $result = array_merge($result, $fallback_tours);
        }

        return $result;
    }

    /**
     * 3. LẤY TOUR ƯU ĐÃI
     */
    public function getTopPromotionalTours($limit = 3) {
        $statsSql = $this->getStatsSql();
        $sql = "SELECT t.*, $statsSql FROM tour t 
                WHERE t.UuDai IS NOT NULL AND t.UuDai > 0 
                ORDER BY RAND() 
                LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // --- THÊM HÀM NÀY VÀO TRONG MYTRIPMODEL ---
    public function getTripDetail($maTK, $maChuyenDi) {
        $sql = "SELECT c.MaChuyenDi, c.NgayBatDau, c.NgayKetThuc, c.TongGiaTien, c.SoLuongKhach, c.TrangThai, 
                       t.MaTour, t.TenTour, t.HinhAnh, t.DiaDiem, t.SoNgay,
                       g.MaGiaoDich, g.PhuongThuc, g.NgayGiaoDich, g.MaGiaoDichDoiTac, g.TrangThai as TrangThaiGD,
                       tk.HoTen, tk.SDT, tk.Gmail, dk.DiaChi,
                       y.LyDoHuy, y.SoTienHoan, y.TyLeHoanTien, y.NgayHoanTat, y.NgayYeuCau, y.TrangThai as TrangThaiHuy
                FROM ChuyenDi c
                JOIN Tour t ON c.MaTour = t.MaTour
                JOIN DuKhach dk ON c.MaTK_DK = dk.MaTK_DK
                JOIN TaiKhoan tk ON dk.MaTK_DK = tk.MaTK
                LEFT JOIN GiaoDich g ON c.MaChuyenDi = g.MaChuyenDi
                LEFT JOIN YeuCauHuy y ON c.MaChuyenDi = y.MaChuyenDi
                WHERE c.MaChuyenDi = :macd AND c.MaTK_DK = :matk";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':macd' => $maChuyenDi, ':matk' => $maTK]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>