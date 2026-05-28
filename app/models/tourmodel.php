<?php
// app/models/tourmodel.php
require_once __DIR__ . '/../config/db_connect.php';

class TourModel {
    private $conn;
    private $table_name = "Tour";

    // Khởi tạo connection: hỗ trợ cả truyền $db (của nhóm) hoặc lấy global $conn
    public function __construct($db = null) {
        if ($db !== null) {
            $this->conn = $db;
        } else {
            global $conn;
            $this->conn = $conn;
        }
    }

    // Hàm lấy danh sách toàn bộ các Tour đang có trong hệ thống CSDL (Của nhóm)
    public function getAllTours() {
        $query = "SELECT t.*, q.HoTen as TenQTV, q.Avatar as AvatarQTV 
                  FROM " . $this->table_name . " t
                  LEFT JOIN QTV q ON t.MaQTV = q.MaQTV 
                  ORDER BY t.NgayTao DESC";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Hàm lấy danh sách Tour có Phân trang và Lọc (Của chúng ta)
    public function getDanhSachTour($loaiTraiNghiemArr, $vungDiaLy, $soNgay, $giaMax, $sortBy, $limit, $offset, $currentUser) {
        
        // CHỈNH SỬA: Nếu currentUser lưu mã Du Khách (bắt đầu bằng DK), ta phải lấy mã TK_DK tương ứng
        if (strpos($currentUser, 'DK') === 0) {
            $stmtDK = $this->conn->prepare("SELECT MaTK_DK FROM DuKhach WHERE MaDK = :maDK");
            $stmtDK->execute([':maDK' => $currentUser]);
            $res = $stmtDK->fetch(PDO::FETCH_ASSOC);
            if ($res) {
                $currentUser = $res['MaTK_DK'];
            }
        }
        
        $params = [':currentUser' => $currentUser];
        $sql = "SELECT t.*, 
                    (SELECT COUNT(*) FROM DanhSachYeuThich WHERE MaTour = t.MaTour) as SoLuotThich,
                    (SELECT AVG(pdg.SoSao) FROM PhieuDanhGia pdg JOIN ChuyenDi cd ON pdg.MaChuyenDi = cd.MaChuyenDi WHERE cd.MaTour = t.MaTour) as SaoTrungBinh,
                    (SELECT COUNT(*) FROM PhieuDanhGia pdg JOIN ChuyenDi cd ON pdg.MaChuyenDi = cd.MaChuyenDi WHERE cd.MaTour = t.MaTour) as SoDanhGia,
                    (SELECT COUNT(*) FROM DanhSachYeuThich WHERE MaTour = t.MaTour AND MaTK_DK = :currentUser) as IsLiked
                FROM Tour t 
                WHERE 1=1";

        if (!empty($loaiTraiNghiemArr) && is_array($loaiTraiNghiemArr)) {
            $loaiConditions = [];
            foreach ($loaiTraiNghiemArr as $k => $v) {
                $key = ':loai' . $k;
                $loaiConditions[] = "t.LoaiTraiNghiem LIKE " . $key;
                $params[$key] = '%' . $v . '%';
            }
            $sql .= " AND (" . implode(' OR ', $loaiConditions) . ")";
        }

        if (!empty($vungDiaLy)) {
            $sql .= " AND t.VungDiaLy = :vung";
            $params[':vung'] = $vungDiaLy;
        }

        if (!empty($soNgay)) {
            if ($soNgay == '1-2') $sql .= " AND t.SoNgay BETWEEN 1 AND 2";
            elseif ($soNgay == '2-3') $sql .= " AND t.SoNgay BETWEEN 2 AND 3";
            elseif ($soNgay == '3-5') $sql .= " AND t.SoNgay BETWEEN 3 AND 5";
        }

        if (!empty($giaMax)) {
            $sql .= " AND t.Gia <= :giaMax";
            $params[':giaMax'] = $giaMax;
        }

        if ($sortBy == 'yeu_thich') {
            $sql .= " ORDER BY SoLuotThich DESC, t.NgayTao DESC";
        } elseif ($sortBy == 'gia_thap') {
            $sql .= " ORDER BY t.Gia ASC, t.NgayTao DESC";
        } elseif ($sortBy == 'gia_cao') {
            $sql .= " ORDER BY t.Gia DESC, t.NgayTao DESC";
        } elseif ($sortBy == 'moi_nhat') {
            $sql .= " ORDER BY t.NgayTao DESC";
        } 

        $sql .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        
        $stmt = $this->conn->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Hàm đếm tổng số tour cho Phân trang
    public function getTotalTours($loaiTraiNghiemArr, $vungDiaLy, $soNgay, $giaMax) {
        $params = [];
        $sql = "SELECT COUNT(*) FROM Tour t WHERE 1=1";
        
        if (!empty($loaiTraiNghiemArr) && is_array($loaiTraiNghiemArr)) {
            $loaiConditions = [];
            foreach ($loaiTraiNghiemArr as $k => $v) {
                $key = ':loai' . $k;
                $loaiConditions[] = "t.LoaiTraiNghiem LIKE " . $key;
                $params[$key] = '%' . $v . '%';
            }
            $sql .= " AND (" . implode(' OR ', $loaiConditions) . ")";
        }

        if (!empty($vungDiaLy)) {
            $sql .= " AND t.VungDiaLy = :vung";
            $params[':vung'] = $vungDiaLy;
        }

        if (!empty($soNgay)) {
            if ($soNgay == '1-2') $sql .= " AND t.SoNgay BETWEEN 1 AND 2";
            elseif ($soNgay == '2-3') $sql .= " AND t.SoNgay BETWEEN 2 AND 3";
            elseif ($soNgay == '3-5') $sql .= " AND t.SoNgay BETWEEN 3 AND 5";
        }

        if (!empty($giaMax)) {
            $sql .= " AND t.Gia <= :giaMax";
            $params[':giaMax'] = $giaMax;
        }
        
        $stmt = $this->conn->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Hàm xử lý Thả tim 
    public function toggleHeart($maTK_DK, $maTour) {
        // CHỈNH SỬA: Map MaDK sang MaTK_DK nếu Controller lỡ truyền chuỗi bắt đầu bằng DK...
        if (strpos($maTK_DK, 'DK') === 0) {
            $stmtDK = $this->conn->prepare("SELECT MaTK_DK FROM DuKhach WHERE MaDK = :maDK");
            $stmtDK->execute([':maDK' => $maTK_DK]);
            $res = $stmtDK->fetch(PDO::FETCH_ASSOC);
            if ($res) {
                $maTK_DK = $res['MaTK_DK'];
            }
        }
        
        $checkSql = "SELECT * FROM DanhSachYeuThich WHERE MaTK_DK = :maTK_DK AND MaTour = :maTour";
        $stmt = $this->conn->prepare($checkSql);
        $stmt->execute([':maTK_DK' => $maTK_DK, ':maTour' => $maTour]);
        
        if($stmt->rowCount() > 0) {
            $delSql = "DELETE FROM DanhSachYeuThich WHERE MaTK_DK = :maTK_DK AND MaTour = :maTour";
            $this->conn->prepare($delSql)->execute([':maTK_DK' => $maTK_DK, ':maTour' => $maTour]);
            return 'removed';
        } else {
            $insSql = "INSERT INTO DanhSachYeuThich(MaTK_DK, MaTour) VALUES(:maTK_DK, :maTour)";
            $this->conn->prepare($insSql)->execute([':maTK_DK' => $maTK_DK, ':maTour' => $maTour]);
            return 'added';
        }
    }
}
?>