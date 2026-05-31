<?php
if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
}

class TripDetailController {
    public function index() {
        // 1. Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=home");
            exit();
        }

        // 2. Lấy mã chuyến đi từ URL
        $maChuyenDi = $_GET['id'] ?? '';
        if (empty($maChuyenDi)) {
            header("Location: index.php?controller=mytrip");
            exit();
        }

        // 3. Kết nối CSDL và Model
        global $conn;
        require_once __DIR__ . '/../config/db_connect.php';
        require_once __DIR__ . '/../models/mytripmodel.php'; 
        
        $tripModel = new MytripModel($conn);
        $maTK = $_SESSION['user']['MaTK'];

        // 4. Lấy chi tiết chuyến đi
        $trip = $tripModel->getTripDetail($maTK, $maChuyenDi);

        // Nếu không tìm thấy chuyến đi, báo lỗi và quay về
        if (!$trip) {
            echo "<script>
                    alert('Không tìm thấy chuyến đi hoặc bạn không có quyền xem chuyến đi này!'); 
                    window.location.href='index.php?controller=mytrip';
                  </script>";
            exit();
        }

        // 5. Gọi View hiển thị
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/mytripdetailview.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}

// Logic định tuyến cho Controller
$action = $_GET['action'] ?? 'index';
$controller = new TripDetailController();
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    $controller->index();
}
?>