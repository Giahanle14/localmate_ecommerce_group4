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
    // --- THÊM HÀM NÀY VÀO TRONG MYTRIPCONTROLLER ---
    public function detail() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=home");
            exit();
        }

        $maChuyenDi = $_GET['id'] ?? '';
        if (empty($maChuyenDi)) {
            header("Location: index.php?controller=mytrip");
            exit();
        }

        global $conn;
        require_once __DIR__ . '/../config/db_connect.php';
        require_once __DIR__ . '/../models/mytripmodel.php';
        
        $tripModel = new MytripModel($conn);
        $maTK = $_SESSION['user']['MaTK'];

        // Lấy chi tiết chuyến đi
        $trip = $tripModel->getTripDetail($maTK, $maChuyenDi);

        // Nếu không tìm thấy hoặc chuyến đi không phải của user này thì đẩy về danh sách
        if (!$trip) {
            echo "<script>alert('Không tìm thấy chuyến đi!'); window.location.href='index.php?controller=mytrip';</script>";
            exit();
        }

        // Gọi View
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/mytripdetailview.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
// Đoạn này nằm ở dưới cùng của file mytripcontroller.php
$action = $_GET['action'] ?? 'index';
$controller = new MytripController();
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    $controller->index();
}
?>