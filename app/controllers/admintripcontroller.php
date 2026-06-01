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
        $daterange = isset($_GET['daterange']) ? trim($_GET['daterange']) : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10; 

        // Gọi dữ liệu
        $result = $model->getTrips($tab, $search, $daterange, $page, $limit);
        $trips = $result['data'];
        $total = (int)$result['total'];
        $totalPages = ceil($total / $limit);

        $viewMode = 'list';
        require_once 'app/views/admintripview.php';
    }

    public function detail() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=admintrip");
            exit;
        }
        $model = new AdminTripModel();
        $tripData = $model->getTripDetail($_GET['id']);
        
        if (!$tripData) {
            echo "<script>alert('Không tìm thấy dữ liệu chuyến đi!'); window.location.href='index.php?controller=admintrip';</script>";
            exit;
        }

        $viewMode = 'detail';
        require_once 'app/views/admintripview.php';
    }

    public function approve_cancel() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['maChuyenDi'])) {
            $model = new AdminTripModel();
            $maQTV = $_SESSION['user']['MaTK']; 
            
            if ($model->approveCancelRequest($_POST['maChuyenDi'], $maQTV)) {
                echo json_encode(['status' => 'success', 'message' => 'Đã xác nhận hủy chuyến đi thành công!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Có lỗi xảy ra, vui lòng thử lại!']);
            }
            exit;
        }
    }
}
?>