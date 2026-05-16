<?php
// TourModel.php
require_once 'db_connect.php';

class TourModel {
    public function getDanhSachTour($loaiTraiNghiemArr, $vungDiaLy, $soNgay, $giaMax, $sortBy, $limit, $offset, $currentUser) {
        global $conn;
        
        $params = [':currentUser' => $currentUser];
        $sql = "SELECT t.*, 
                    (SELECT COUNT(*) FROM DanhSachYeuThich WHERE MaTour = t.MaTour) as SoLuotThich,
                    (SELECT AVG(pdg.SoSao) FROM PhieuDanhGia pdg JOIN ChuyenDi cd ON pdg.MaChuyenDi = cd.MaChuyenDi WHERE cd.MaTour = t.MaTour) as SaoTrungBinh,
                    (SELECT COUNT(*) FROM PhieuDanhGia pdg JOIN ChuyenDi cd ON pdg.MaChuyenDi = cd.MaChuyenDi WHERE cd.MaTour = t.MaTour) as SoDanhGia,
                    (SELECT COUNT(*) FROM DanhSachYeuThich WHERE MaTour = t.MaTour AND MaDK = :currentUser) as IsLiked
                FROM Tour t 
                WHERE 1=1";

        // Xử lý Lọc nhiều Loại trải nghiệm
        if (!empty($loaiTraiNghiemArr) && is_array($loaiTraiNghiemArr)) {
            $loaiKeys = [];
            foreach ($loaiTraiNghiemArr as $k => $v) {
                $key = ':loai' . $k;
                $loaiKeys[] = $key;
                $params[$key] = $v;
            }
            $sql .= " AND t.LoaiTraiNghiem IN (" . implode(',', $loaiKeys) . ")";
        }

        // Xử lý Vùng địa lý
        if (!empty($vungDiaLy)) {
            $sql .= " AND t.VungDiaLy = :vung";
            $params[':vung'] = $vungDiaLy;
        }

        // Xử lý khoảng Số ngày
        if (!empty($soNgay)) {
            if ($soNgay == '1-2') $sql .= " AND t.SoNgay BETWEEN 1 AND 2";
            elseif ($soNgay == '2-3') $sql .= " AND t.SoNgay BETWEEN 2 AND 3";
            elseif ($soNgay == '3-5') $sql .= " AND t.SoNgay BETWEEN 3 AND 5";
        }

        // Xử lý Mức giá (Ngân sách tối đa)
        if (!empty($giaMax)) {
            $sql .= " AND t.Gia <= :giaMax";
            $params[':giaMax'] = $giaMax;
        }

        // Xử lý Sắp xếp
        if ($sortBy == 'yeu_thich') {
            $sql .= " ORDER BY SoLuotThich DESC, t.NgayTao DESC";
        } elseif ($sortBy == 'gia_thap') {
            $sql .= " ORDER BY t.Gia ASC, t.NgayTao DESC";
        } elseif ($sortBy == 'gia_cao') {
            $sql .= " ORDER BY t.Gia DESC, t.NgayTao DESC";
        } 

        $sql .= " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        
        $stmt = $conn->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Hàm đếm tổng số tour cho Phân trang
    public function getTotalTours($loaiTraiNghiemArr, $vungDiaLy, $soNgay, $giaMax) {
        global $conn;
        $params = [];
        $sql = "SELECT COUNT(*) FROM Tour t WHERE 1=1";
        
        if (!empty($loaiTraiNghiemArr) && is_array($loaiTraiNghiemArr)) {
            $loaiKeys = [];
            foreach ($loaiTraiNghiemArr as $k => $v) {
                $key = ':loai' . $k;
                $loaiKeys[] = $key;
                $params[$key] = $v;
            }
            $sql .= " AND t.LoaiTraiNghiem IN (" . implode(',', $loaiKeys) . ")";
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
        
        $stmt = $conn->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
?>