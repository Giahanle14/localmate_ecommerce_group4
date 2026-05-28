<?php
class MytripModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * 1. Lấy danh sách chuyến đi theo trạng thái (Chưa hoàn thành / Đã hoàn thành)
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

    /**
     * 2. LẤY TOUR GỢI Ý: Dựa trên các loại trải nghiệm của các tour du khách ĐÃ ĐI NHẤT
     */
    public function getSuggestedTours($maTK, $limit = 3) {
        // Bước 2.1: Lấy tất cả danh sách LoaiTraiNghiem từ những tour khách đã từng đặt
        $sql_history = "SELECT DISTINCT t.LoaiTraiNghiem 
                        FROM ChuyenDi c 
                        JOIN Tour t ON c.MaTour = t.MaTour 
                        WHERE c.MaTK_DK = :matk";
        $stmt_hist = $this->conn->prepare($sql_history);
        $stmt_hist->execute([':matk' => $maTK]);
        $history_rows = $stmt_hist->fetchAll(PDO::FETCH_ASSOC);

        // Nếu khách hàng mới tinh, chưa từng đi tour nào -> Gợi ý ngẫu nhiên 3 tour
        if (empty($history_rows)) {
            $sql_random = "SELECT * FROM Tour ORDER BY RAND() LIMIT :limit";
            $stmt_rand = $this->conn->prepare($sql_random);
            $stmt_rand->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt_rand->execute();
            return $stmt_rand->fetchAll(PDO::FETCH_ASSOC);
        }

        // Gom tất cả các trải nghiệm đã đi thành một mảng các từ khóa (ví dụ: ['Văn hóa', 'Ẩm thực', 'Biển đảo'])
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

        // Bước 2.2: Tạo câu truy vấn động sử dụng LIKE để tìm các tour chứa các tag này
        // Đồng thời loại trừ các tour khách đang hoặc đã đi (để không gợi ý trùng)
        $where_clauses = [];
        $params = [];
        foreach ($tags_played as $index => $tag) {
            $where_clauses[] = "t.LoaiTraiNghiem LIKE :tag" . $index;
            $params[":tag" . $index] = "%" . $tag . "%";
        }
        
        $where_sql = implode(' OR ', $where_clauses);
        $sql_suggest = "SELECT t.* FROM Tour t 
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

        // Phòng hờ nếu lọc gắt quá không đủ số lượng -> Bù thêm tour ngẫu nhiên cho đủ limit
        if (count($result) < $limit) {
            $needed = $limit - count($result);
            $sql_fallback = "SELECT * FROM Tour WHERE MaTour NOT IN (SELECT MaTour FROM ChuyenDi WHERE MaTK_DK = :matk) ORDER BY RAND() LIMIT :needed";
            $stmt_fall = $this->conn->prepare($sql_fallback);
            $stmt_fall->bindValue(':needed', (int)$needed, PDO::PARAM_INT);
            $stmt_fall->bindValue(':matk', $maTK);
            $stmt_fall->execute();
            $fallback_tours = $stmt_fall->fetchAll(PDO::FETCH_ASSOC);
            $result = array_merge($result, $fallback_tours);
        }

        return $result;
    }

    public function getTopPromotionalTours($limit = 3) {
        // Lấy ngẫu nhiên các tour có ưu đãi (UuDai > 0 và không bị NULL)
        $sql = "SELECT * FROM tour 
                WHERE UuDai IS NOT NULL AND UuDai > 0 
                ORDER BY RAND() 
                LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>