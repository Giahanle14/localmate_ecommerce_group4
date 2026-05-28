<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

class TourDetailController {
    public function index() {
        // Kiểm tra id tour
        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=home");
            exit();
        }

        $maTour = $_GET['id'];
        global $conn;
        require_once __DIR__ . '/../config/db_connect.php';
        require_once __DIR__ . '/../models/tourdetailmodel.php';
        
        $model = new TourDetailModel($conn);
        $tour = $model->getTourById($maTour);
        $itinerary = $model->getItinerary($maTour);
        
        if (!$tour) {
            echo "Không tìm thấy thông tin tour!";
            exit();
        }

        // 1. Tính năng yêu thích tạm thời tắt để chờ thành viên khác ghép code
        $isFavorite = false;

        // 2. XỬ LÝ BREADCRUMB ĐỘNG (Trang chủ > Chuyến đi của tôi / Yêu thích / Tour > Chi tiết tour)
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $from = isset($_GET['from']) ? $_GET['from'] : ''; // Ưu tiên bắt tham số from trên URL nếu có
        
        $breadcrumb = [['name' => 'Trang chủ', 'url' => 'index.php?controller=home']];
        
        if ($from === 'favorite' || strpos($referer, 'controller=favorite') !== false) {
            $breadcrumb[] = ['name' => 'Yêu thích', 'url' => 'index.php?controller=favorite'];
        } 
        else if (strpos($referer, 'controller=mytrip') !== false) {
            $breadcrumb[] = ['name' => 'Chuyến đi của tôi', 'url' => 'index.php?controller=mytrip'];
        } 
        else if (strpos($referer, 'controller=tour') !== false && strpos($referer, 'action=detail') === false) {
            $breadcrumb[] = ['name' => 'Tour', 'url' => 'index.php?controller=tour'];
        } 
        else {
            // Mặc định nếu không rõ từ đâu tới
            $breadcrumb[] = ['name' => 'Tour', 'url' => 'index.php?controller=tour'];
        }
        
        $breadcrumb[] = ['name' => 'Chi tiết tour', 'url' => '#'];

        // Gọi View hiển thị giao diện
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/tourdetailview.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>