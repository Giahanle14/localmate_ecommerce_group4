<?php
require_once 'app/models/tourmodel.php';

class TourController {
    private $tourModel;

    public function __construct() {
        $this->tourModel = new TourModel();
    }

    public function index() {
        // --- Xử lý AJAX Thả tim ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'toggle_heart') {
            $this->handleAjaxHeart();
            return;
        }

        $maTK_DK = isset($_SESSION['user']['MaTK']) ? $_SESSION['user']['MaTK'] : null;

        // B1: Lấy các tham số GET (Cả search từ trang chủ + filter ở sidebar)
        $search = $_GET['search'] ?? ''; 
        $date = $_GET['date'] ?? '';
        $guests_str = $_GET['guests'] ?? '';
        
        $vung = $_GET['vung'] ?? '';
        $ngay = $_GET['ngay'] ?? '';
        $loai = isset($_GET['loai']) ? (is_array($_GET['loai']) ? $_GET['loai'] : [$_GET['loai']]) : [];
        $gia_max = $_GET['gia_max'] ?? 5000000;
        $sort = $_GET['sort'] ?? 'moi_nhat';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 9;

        // B2: Tách số khách từ chuỗi "1 Người lớn, 2 Trẻ em" -> Thành số học
        $guests_count = 0;
        if (!empty($guests_str)) {
            preg_match_all('/\d+/', $guests_str, $matches);
            if (!empty($matches[0])) {
                $guests_count = array_sum($matches[0]);
            }
        }

        // Đóng gói mảng tham số gửi cho Model
        $params = [
            'search' => $search,
            'guests_count' => $guests_count,
            'vung' => $vung,
            'ngay' => $ngay,
            'loai' => $loai,
            'gia_max' => $gia_max,
            'sort' => $sort
        ];

        // Xem người dùng có đang tìm kiếm/lọc hay không
        $is_filtering = (!empty($search) || !empty($guests_str) || !empty($vung) || !empty($ngay) || !empty($loai) || $gia_max < 5000000);

        if ($is_filtering || isset($_GET['view'])) {
            $is_filtering = true;
            $totalTours = $this->tourModel->countFilteredTours($params);
            $totalPages = ceil($totalTours / $limit);
            $offset = ($page - 1) * $limit;

            $danhSachTour = $this->tourModel->getFilteredTours($params, $maTK_DK, $limit, $offset);
            
            if (!empty($search)) {
                $page_title = "Kết quả tìm kiếm cho: \"" . htmlspecialchars($search) . "\"";
            } else {
                $page_title = "Danh sách Tour phù hợp";
            }
        } else {
            // Hiển thị mặc định
            $tourMoiNhat = $this->tourModel->getLatestTours($maTK_DK, 6);
            $danhSachTour = [];
            $totalPages = 0;
            $page_title = "Tour";
        }

        // ĐÃ SỬA: Trỏ đúng vào thư mục views theo cấu trúc hiện tại của project
        require_once 'app/views/tourview.php';
    }

    // --- Hàm AJAX Thả tim ---
    private function handleAjaxHeart() {
        header('Content-Type: application/json');
        if (!isset($_SESSION['user']) || $_SESSION['user']['LoaiTK'] !== 'Du khách') {
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập tài khoản du khách.']);
            exit;
        }

        $maTour = $_POST['ma_tour'] ?? '';
        if (empty($maTour)) exit;

        try {
            // Sử dụng hàm toggleFavorite của tourModel
            $action = $this->tourModel->toggleFavorite($_SESSION['user']['MaTK'], $maTour);
            echo json_encode(['success' => true, 'action' => $action]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()]);
        }
        exit;
    }
}

$controller = new TourController();
$controller->index();
?>