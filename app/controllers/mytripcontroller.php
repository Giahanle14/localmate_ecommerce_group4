<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class MytripController {
    public function index() {
        // 1. KIỂM TRA BẢO MẬT: Nếu khách chưa đăng nhập, đá văng về trang chủ
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=home");
            exit();
        }

        // 2. Nhúng kết nối CSDL toàn cục của hệ thống
        global $conn;
        require_once __DIR__ . '/../config/db_connect.php';

        // 3. Nhúng và khởi tạo lớp Model
        require_once __DIR__ . '/../models/mytripmodel.php';

        $tripModel = new MytripModel($conn);
        // 4. Lấy mã tài khoản tự động từ Session của người dùng hiện tại
        $maTK = $_SESSION['user']['MaTK'];

        // 5. Triệu gọi dữ liệu từ Model xử lý
        // - Danh sách chuyến đi chưa hoàn thành
        $rs_chua_hoan_thanh = $tripModel->getTripsByCustomer($maTK, 'Chưa hoàn thành');
        // - Danh sách chuyến đi đã hoàn thành
        $rs_da_hoan_thanh = $tripModel->getTripsByCustomer($maTK, 'Đã hoàn thành');
        // - Danh sách chuyến đi đã đã hủy
        $rs_da_huy = $tripModel->getTripsByCustomer($maTK, 'Đã hủy');
        
        $rs_goi_y = $tripModel->getSuggestedTours($maTK, 10); 
        $rs_uu_dai = $tripModel->getTopPromotionalTours(10);

        // 6. Chuyển tiếp toàn bộ mảng dữ liệu sạch sang giao diện View hiển thị
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/mytripview.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>