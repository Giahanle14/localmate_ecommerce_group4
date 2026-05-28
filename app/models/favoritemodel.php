<?php
// app/models/favoritemodel.php
require_once __DIR__ . '/../config/db_connect.php';

class FavoriteModel {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // Hàm đếm tổng số tour yêu thích (có hỗ trợ tìm kiếm)
    public function getTotalFavorites($maTK_DK, $keyword = '') {
        // Chuyển đổi mã DK sang MaTK_DK nếu Controller lỡ truyền chuỗi bắt đầu bằng DK...
        if (strpos($maTK_DK, 'DK') === 0) {
            $stmtDK = $this->conn->prepare("SELECT MaTK_DK FROM DuKhach WHERE MaDK = :maDK");
            $stmtDK->execute([':maDK' => $maTK_DK]);
            $res = $stmtDK->fetch(PDO::FETCH_ASSOC);
            if ($res) {
                $maTK_DK = $res['MaTK_DK'];
            }
        }

        $sql = "SELECT COUNT(*) FROM Tour t
                INNER JOIN DanhSachYeuThich ds ON t.MaTour = ds.MaTour
                WHERE ds.MaTK_DK = :maTK_DK";
        
        $params = [':maTK_DK' => $maTK_DK];

        if (!empty($keyword)) {
            $sql .= " AND (t.TenTour LIKE :kw OR t.VungDiaLy LIKE :kw OR t.DiaDiem LIKE :kw)";
            $params[':kw'] = '%' . $keyword . '%';
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    // Hàm lấy danh sách chi tiết tour yêu thích (có phân trang và tìm kiếm)
    public function getFavoriteTours($maTK_DK, $keyword = '', $limit = 9, $offset = 0) {
        if (strpos($maTK_DK, 'DK') === 0) {
            $stmtDK = $this->conn->prepare("SELECT MaTK_DK FROM DuKhach WHERE MaDK = :maDK");
            $stmtDK->execute([':maDK' => $maTK_DK]);
            $res = $stmtDK->fetch(PDO::FETCH_ASSOC);
            if ($res) {
                $maTK_DK = $res['MaTK_DK'];
            }
        }

        // Truy vấn lấy dữ liệu tour kèm theo số sao trung bình và số lượt đánh giá
        $sql = "SELECT t.*, 
                    (SELECT COUNT(*) FROM DanhSachYeuThich WHERE MaTour = t.MaTour) as SoLuotThich,
                    (SELECT AVG(pdg.SoSao) FROM PhieuDanhGia pdg JOIN ChuyenDi cd ON pdg.MaChuyenDi = cd.MaChuyenDi WHERE cd.MaTour = t.MaTour) as SaoTrungBinh,
                    (SELECT COUNT(*) FROM PhieuDanhGia pdg JOIN ChuyenDi cd ON pdg.MaChuyenDi = cd.MaChuyenDi WHERE cd.MaTour = t.MaTour) as SoDanhGia
                FROM Tour t
                INNER JOIN DanhSachYeuThich ds ON t.MaTour = ds.MaTour
                WHERE ds.MaTK_DK = :maTK_DK";
        
        $params = [':maTK_DK' => $maTK_DK];

        // Lọc theo từ khóa tìm kiếm (Tên, Vùng, Địa điểm)
        if (!empty($keyword)) {
            $sql .= " AND (t.TenTour LIKE :kw OR t.VungDiaLy LIKE :kw OR t.DiaDiem LIKE :kw)";
            $params[':kw'] = '%' . $keyword . '%';
        }

        // Sắp xếp tour mới thêm vào yêu thích lên đầu tiên
        $sql .= " ORDER BY ds.NgayThem DESC LIMIT " . (int)$limit . " OFFSET " . (int)$offset;

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
?>