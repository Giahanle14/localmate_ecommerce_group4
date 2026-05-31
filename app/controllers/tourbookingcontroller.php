<?php
require_once 'app/models/tourbookingmodel.php';

class TourBookingController {
    private $model;

    public function __construct() {
        $this->model = new TourBookingModel();
    }

    public function index() {
        // Lấy dữ liệu từ URL truyền từ trang Chi tiết Tour
        $maTour = $_GET['id'] ?? '';
        $ngayDi = $_GET['ngaydi'] ?? date('Y-m-d');
        $soLuong = $_GET['soluong'] ?? 1;

        if (empty($maTour)) {
            header("Location: index.php?controller=tour");
            exit;
        }

        $tour = $this->model->getTourById($maTour);
        if (!$tour) {
            header("Location: index.php?controller=tour");
            exit;
        }

        // Tính toán Ngày Kết Thúc (Dựa vào số ngày của tour)
        $soNgay = $tour['SoNgay'];
        $ngayKetThuc = date('Y-m-d', strtotime($ngayDi . ' + ' . ($soNgay - 1) . ' days'));

        // Lấy thông tin user nếu đã đăng nhập để tự động điền vào Form
        $userInfo = $_SESSION['user'] ?? null;

        // Gọi View
        require_once 'app/views/tourbookingview.php';
    }
}

$controller = new TourBookingController();
$controller->index();
?>