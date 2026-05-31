<?php
require_once 'app/config/db_connect.php'; 
require_once 'app/models/admintripmodel.php';

class AdmintripController {
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['LoaiTK'] !== 'Quản trị viên') {
            header("Location: index.php?controller=home");
            exit;
        }
    }

    public function index() {
        $model = new AdminTripModel();
        
        // Thống kê số lượng
        $stats = $model->getTripStats();

        // Xử lý Request
        $tab = isset($_GET['tab']) ? $_GET['tab'] : 'all';
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10; // Hiển thị 10 chuyến đi 1 trang

        // Gọi dữ liệu
        $result = $model->getTrips($tab, $search, $page, $limit);
        $trips = $result['data'];
        $total = (int)$result['total'];
        $totalPages = ceil($total / $limit);

        require_once 'app/views/layouts/header.php';
        require_once 'app/views/admintripview.php';
        require_once 'app/views/layouts/footer.php';
    }
}
?>