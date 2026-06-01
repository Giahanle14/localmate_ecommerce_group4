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
                    (SELECT IFNULL(ROUND(AVG(pdg.SoSao), 1), 0) 
                     FROM PhieuDanhGia pdg 
                     JOIN ChuyenDi cd ON pdg.MaChuyenDi = cd.MaChuyenDi 
                     JOIN LichKhoiHanh lkh ON cd.MaLichKhoiHanh = lkh.MaLichKhoiHanh 
                     WHERE lkh.MaTour = t.MaTour) as SaoTrungBinh,
                    (SELECT COUNT(*) 
                     FROM PhieuDanhGia pdg 
                     JOIN ChuyenDi cd ON pdg.MaChuyenDi = cd.MaChuyenDi 
                     JOIN LichKhoiHanh lkh ON cd.MaLichKhoiHanh = lkh.MaLichKhoiHanh 
                     WHERE lkh.MaTour = t.MaTour) as SoDanhGia
                FROM Tour t
                INNER JOIN DanhSachYeuThich ds ON t.MaTour = ds.MaTour
                WHERE ds.MaTK_DK = :maTK_DK";
        
        $params = [':maTK_DK' => $maTK_DK];

        if (!empty($keyword)) {
            $sql .= " AND (t.TenTour LIKE :kw OR t.VungDiaLy LIKE :kw OR t.DiaDiem LIKE :kw)";
            $params[':kw'] = '%' . $keyword . '%';
        }

        $sql .= " ORDER BY ds.NgayThem DESC LIMIT " . (int)$limit . " OFFSET " . (int)$offset;

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Hàm xử lý thả/gỡ tim
    public function toggleHeart($maTK_DK, $maTour) {
        // Chuyển đổi mã nếu Controller truyền mã bắt đầu bằng DK
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
            // Đã có trong danh sách -> Xóa (Gỡ tim)
            $delSql = "DELETE FROM DanhSachYeuThich WHERE MaTK_DK = :maTK_DK AND MaTour = :maTour";
            $this->conn->prepare($delSql)->execute([':maTK_DK' => $maTK_DK, ':maTour' => $maTour]);
            return 'removed';
        } else {
            // Chưa có -> Thêm vào (Thả tim)
            $insSql = "INSERT INTO DanhSachYeuThich(MaTK_DK, MaTour) VALUES(:maTK_DK, :maTour)";
            $this->conn->prepare($insSql)->execute([':maTK_DK' => $maTK_DK, ':maTour' => $maTour]);
            return 'added';
        }
    }
    public function checkIsFavorited($maTK_DK, $maTour) {
        if (strpos($maTK_DK, 'DK') === 0) {
            $stmtDK = $this->conn->prepare("SELECT MaTK_DK FROM DuKhach WHERE MaDK = :maDK");
            $stmtDK->execute([':maDK' => $maTK_DK]);
            $res = $stmtDK->fetch(PDO::FETCH_ASSOC);
            if ($res) {
                $maTK_DK = $res['MaTK_DK'];
            }
        }
        
        $sql = "SELECT 1 FROM DanhSachYeuThich WHERE MaTK_DK = :maTK_DK AND MaTour = :maTour";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':maTK_DK' => $maTK_DK, ':maTour' => $maTour]);
        return $stmt->rowCount() > 0;
    }
}
?>