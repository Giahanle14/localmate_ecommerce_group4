<?php
require_once 'app/models/homemodel.php';

class HomeController {
    private $homeModel;

<<<<<<< HEAD
<<<<<<< HEAD
    // Hàm index sẽ tự động chạy khi truy cập trang chủ
    public function index() {
        
        // 1. Nhúng file kết nối CSDL
=======
    public function index() {
        // Nhúng file kết nối
>>>>>>> dc02dda3b25d0ce58ade747657d6bf8bd69ef6cb
        require_once __DIR__ . '/../config/db_connect.php';

        $toursNoiBat = [];
        $toursYeuThich = [];

<<<<<<< HEAD
        // 2. Lấy dữ liệu từ bảng 'tour'
        try {
            if(isset($conn)) {
                // Lấy 3 tour đầu tiên làm tour nổi bật
=======
        try {
            if(isset($conn)) {
>>>>>>> dc02dda3b25d0ce58ade747657d6bf8bd69ef6cb
                $stmt1 = $conn->prepare("SELECT * FROM tour LIMIT 3");
                $stmt1->execute();
                $toursNoiBat = $stmt1->fetchAll(PDO::FETCH_ASSOC);

<<<<<<< HEAD
                // Lấy 3 tour tiếp theo làm tour yêu thích
=======
>>>>>>> dc02dda3b25d0ce58ade747657d6bf8bd69ef6cb
                $stmt2 = $conn->prepare("SELECT * FROM tour LIMIT 3 OFFSET 3");
                $stmt2->execute();
                $toursYeuThich = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch(PDOException $e) {
            echo "<script>console.log('Lỗi DB: " . addslashes($e->getMessage()) . "');</script>";
        }
<<<<<<< HEAD

        // 3. Gọi các file giao diện (Views) ra để hiển thị
        // Biến $toursNoiBat và $toursYeuThich sẽ tự động được truyền xuống file index.php bên dưới
=======
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user']) && $_SESSION['user']['LoaiTK'] === 'Quản trị viên') {
            header("Location: index.php?controller=adminhome");
            exit();
        }

        // Gọi View
>>>>>>> dc02dda3b25d0ce58ade747657d6bf8bd69ef6cb
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/home/index.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
=======
    public function __construct() {
        $this->homeModel = new HomeModel();
>>>>>>> fe6d93f9adc736ba760c7c7881473756fc788b53
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
        
        // Lấy 4 bài đánh giá mới nhất để hiển thị phần Kinh nghiệm đi tour
        $latestReviews = $this->homeModel->getLatestReviews(4); 

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
<<<<<<< HEAD
<<<<<<< HEAD

=======
>>>>>>> dc02dda3b25d0ce58ade747657d6bf8bd69ef6cb
=======

// Khởi tạo và chạy Controller
$controller = new HomeController();
$controller->index();
>>>>>>> fe6d93f9adc736ba760c7c7881473756fc788b53
?>