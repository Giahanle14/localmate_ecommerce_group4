<?php
require_once 'app/models/homemodel.php';

class HomeController {
    private $homeModel;

    public function __construct() {
        $this->homeModel = new HomeModel();
    }

   public function index() {
        // Xử lý AJAX Thả tim nếu có request gửi lên
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'toggle_heart') {
            $this->handleAjaxHeart();
            return; // Dừng thực thi để chỉ trả về JSON
        }

        // Lấy mã user nếu đã đăng nhập để biết tour nào đã thả tim
        $maTK_DK = isset($_SESSION['user']['MaTK']) ? $_SESSION['user']['MaTK'] : null;

        // Lấy dữ liệu từ Model
        $toursNoiBat = $this->homeModel->getToursNoiBat($maTK_DK);
        $toursYeuThich = $this->homeModel->getToursYeuThich($maTK_DK);
        
        $latestReviews = $this->homeModel->getLatestReviews(12); 

        // Gọi View
        require_once 'app/views/home/index.php';
    }

    private function handleAjaxHeart() {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user'])) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để thực hiện chức năng này.']);
            exit;
        }

        if ($_SESSION['user']['LoaiTK'] !== 'Du khách') {
            echo json_encode(['success' => false, 'message' => 'Chức năng chỉ dành cho du khách.']);
            exit;
        }

        $maTour = $_POST['ma_tour'] ?? '';
        $maTK = $_SESSION['user']['MaTK'];

        if (empty($maTour)) {
            echo json_encode(['success' => false, 'message' => 'Thiếu thông tin tour.']);
            exit;
        }

        try {
            $action = $this->homeModel->toggleFavorite($maTK, $maTour);
            echo json_encode(['success' => true, 'action' => $action]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()]);
        }
        exit;
    }
}

// Khởi tạo và chạy Controller
$controller = new HomeController();
$controller->index();
?>