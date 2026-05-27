<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class MytripController {
    public function index() {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=home");
            exit();
        }

        global $conn;
        require_once __DIR__ . '/../config/db_connect.php';

        $maTK = $_SESSION['user']['MaTK'];

        // 1. Tải danh sách chuyến đi chưa hoàn thành (ĐÃ THÊM t.HinhAnh)
        $sql_chua_hoan_thanh = "SELECT c.MaChuyenDi, c.NgayBatDau, c.NgayKetThuc, c.TongGiaTien, c.SoLuongKhach, t.TenTour, t.VungDiaLy, t.HinhAnh
        FROM ChuyenDi c JOIN Tour t ON c.MaTour = t.MaTour
        WHERE c.MaTK_DK = :matk AND c.TrangThai = 'Chưa hoàn thành'";
        $stmt1 = $conn->prepare($sql_chua_hoan_thanh);
        $stmt1->execute([':matk' => $maTK]);
        $rs_chua_hoan_thanh = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        // 2. Tải danh sách chuyến đi đã hoàn thành (ĐÃ THÊM t.HinhAnh)
        $sql_da_hoan_thanh = "SELECT c.MaChuyenDi, c.NgayBatDau, c.NgayKetThuc, c.TongGiaTien, c.SoLuongKhach, t.TenTour, t.VungDiaLy, t.HinhAnh, dg.MaDG, dg.SoSao
        FROM ChuyenDi c 
        JOIN Tour t ON c.MaTour = t.MaTour
        LEFT JOIN PhieuDanhGia dg ON c.MaChuyenDi = dg.MaChuyenDi
        WHERE c.MaTK_DK = :matk AND c.TrangThai = 'Đã hoàn thành'";
        $stmt2 = $conn->prepare($sql_da_hoan_thanh);
        $stmt2->execute([':matk' => $maTK]);
        $rs_da_hoan_thanh = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        // 3. Tải danh sách các tour ngẫu nhiên gợi ý
        $sql_goi_y = "SELECT * FROM Tour ORDER BY RAND() LIMIT 3";
        $rs_goi_y = $conn->query($sql_goi_y)->fetchAll(PDO::FETCH_ASSOC);

        // 4. Tải danh sách các tour đang có ưu đãi lớn
        $sql_uu_dai = "SELECT * FROM Tour ORDER BY Gia ASC LIMIT 3";
        $rs_uu_dai = $conn->query($sql_uu_dai)->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/mytripview.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>