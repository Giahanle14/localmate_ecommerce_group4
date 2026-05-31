<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'app/models/tourbookingmodel.php';

class TourBookingController {
    private $model;

    public function __construct() {
        $this->model = new TourBookingModel();
    }

    public function index() {
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

        $soNgay = $tour['SoNgay'];
        $ngayKetThuc = date('Y-m-d', strtotime($ngayDi . ' + ' . ($soNgay - 1) . ' days'));
        $userInfo = $_SESSION['user'] ?? null;

        require_once 'app/views/tourbookingview.php';
    }

    // Xử lý dữ liệu từ Form nhập thông tin
    public function process() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?controller=tour");
            exit;
        }

        // 1. Lấy thông tin
        $maTour = $_POST['ma_tour'];
        $tour = $this->model->getTourById($maTour);
        
        $ngayDi = $_POST['ngay_bat_dau'];
        $ngayKetThuc = $_POST['ngay_ket_thuc'];
        $slNguoiLon = (int)$_POST['sl_nguoi_lon'];
        $slTreEm = (int)$_POST['sl_tre_em'];
        $hoTen = $_POST['ho_ten'];

        // 2. Tính tiền (Bảo mật backend)
        $giaGoc = $tour['Gia'];
        $uuDai = $tour['UuDai'] ?? 0;
        $tienNguoiLon = $slNguoiLon * $giaGoc;
        $tienTreEm = $slTreEm * ($giaGoc * 0.75);
        $tongTienTruocGiam = $tienNguoiLon + $tienTreEm;
        $tongTienSauGiam = $tongTienTruocGiam * (1 - $uuDai);

        // 3. Lưu tạm session
        $_SESSION['booking_temp'] = [
            'ma_tour' => $maTour,
            'ten_tour' => $tour['TenTour'],
            'ngay_bat_dau' => $ngayDi,
            'ngay_ket_thuc' => $ngayKetThuc,
            'sl_nguoi_lon' => $slNguoiLon,
            'sl_tre_em' => $slTreEm,
            'ho_ten' => $hoTen,
            'tong_tien' => $tongTienSauGiam
        ];

        // 4. CHUYỂN HƯỚNG SANG TRANG THANH TOÁN
        header("Location: index.php?controller=payment&action=index");
        exit;
    }
}

$action = $_GET['action'] ?? 'index';
$controller = new TourBookingController();
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    $controller->index();
}
?>