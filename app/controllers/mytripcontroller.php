<?php
class MytripController {
    public function index() {

        // Tận dụng kết nối PDO toàn cục đã khai báo tại hệ thống
        global $conn;
        require_once 'db_connect.php';

        // Định danh tài khoản khách hàng cần lấy dữ liệu
        $maDuKhach = 'KH00000004';

        // 1. Tải danh sách chuyến đi chưa hoàn thành
        $sql_chua_hoan_thanh = "SELECT c.MaChuyenDi, c.NgayBatDau, c.NgayKetThuc, c.TongGiaTien, c.SoLuongKhach, t.TenTour, t.VungDiaLy
        FROM ChuyenDi c JOIN Tour t ON c.MaTour = t.MaTour
        WHERE c.MaDK = :madk AND c.TrangThai = 'Chưa hoàn thành'";
        $stmt1 = $conn->prepare($sql_chua_hoan_thanh);
        $stmt1->execute([':madk' => $maDuKhach]);
        $rs_chua_hoan_thanh = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        // 2. Tải danh sách chuyến đi đã hoàn thành (QUAN TRỌNG: Đã thêm LEFT JOIN PhieuDanhGia)
        $sql_da_hoan_thanh = "SELECT c.MaChuyenDi, c.NgayBatDau, c.NgayKetThuc, c.TongGiaTien, c.SoLuongKhach, t.TenTour, t.VungDiaLy, dg.MaDG, dg.SoSao
        FROM ChuyenDi c 
        JOIN Tour t ON c.MaTour = t.MaTour
        LEFT JOIN PhieuDanhGia dg ON c.MaChuyenDi = dg.MaChuyenDi
        WHERE c.MaDK = :madk AND c.TrangThai = 'Đã hoàn thành'";
        $stmt2 = $conn->prepare($sql_da_hoan_thanh);
        $stmt2->execute([':madk' => $maDuKhach]);
        $rs_da_hoan_thanh = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        // 3. Tải danh sách các tour ngẫu nhiên gợi ý
        $sql_goi_y = "SELECT * FROM Tour ORDER BY RAND() LIMIT 3";
        $rs_goi_y = $conn->query($sql_goi_y)->fetchAll(PDO::FETCH_ASSOC);

        // 4. Tải danh sách các tour đang có ưu đãi lớn (Giá thấp nhất)
        $sql_uu_dai = "SELECT * FROM Tour ORDER BY Gia ASC LIMIT 3";
        $rs_uu_dai = $conn->query($sql_uu_dai)->fetchAll(PDO::FETCH_ASSOC);

        // Chuyển tiếp toàn bộ mảng dữ liệu sang tầng giao diện View hiển thị
        require_once 'app/views/mytrip/index.php';
    }
}
?>