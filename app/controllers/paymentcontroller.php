<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'app/models/paymentmodel.php';

class PaymentController {
    private $model;

    public function __construct() {
        $this->model = new PaymentModel();
    }

    public function index() {
        if (!isset($_SESSION['booking_temp']) || !isset($_SESSION['user'])) {
            header("Location: index.php?controller=tour");
            exit;
        }
        $nextMaCD = $this->model->getNextMaChuyenDi();
        $_SESSION['booking_temp']['ma_chuyen_di'] = $nextMaCD; 
        require_once 'app/views/paymentview.php';
    }

    public function confirm() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['booking_temp']) || !isset($_SESSION['user'])) {
            header("Location: index.php?controller=tour");
            exit;
        }

        $phuongThuc = $_POST['phuong_thuc_thanh_toan']; 
        $booking = $_SESSION['booking_temp'];
        
        $maTK_DK = isset($_SESSION['user']['MaTK']) ? $_SESSION['user']['MaTK'] : null;
        if (empty($maTK_DK)) {
            echo "<script>
                alert('Lỗi: Không tìm thấy phiên đăng nhập. Vui lòng đăng nhập lại!');
                window.location.href = 'index.php';
            </script>";
            exit;
        }

        // ĐÃ SỬA: Tính tổng số lượng khách (bao gồm cả em bé) và lấy ghi chú
        $soLuongKhach = $booking['sl_nguoi_lon'] + $booking['sl_tre_em'] + $booking['sl_em_be'];
        $maChuyenDi = $booking['ma_chuyen_di']; 
        $ghiChu = $booking['ghi_chu'] ?? ''; 

        // ĐÃ SỬA: Truyền tham số mới vào Model
        $result = $this->model->saveBookingAndTransaction(
            $maTK_DK,
            $booking['ma_lich_khoi_hanh'], 
            $booking['tong_tien'],
            $soLuongKhach,
            $phuongThuc,
            $maChuyenDi,
            $ghiChu
        );

        if ($result) {
            unset($_SESSION['booking_temp']);
            header("Location: index.php?controller=payment&action=success&macd=" . $result);
            exit;
        } else {
            echo "<script>
                alert('Có lỗi hệ thống xảy ra trong quá trình lưu dữ liệu. Vui lòng thử lại!');
                history.back();
            </script>";
        }
    }

    public function success() {
        $maChuyenDi = $_GET['macd'] ?? '';
        if (empty($maChuyenDi)) {
            header("Location: index.php?controller=mytrip");
            exit;
        }
        require_once 'app/views/paymentsuccessview.php';
    }
}

$action = $_GET['action'] ?? 'index';
$controller = new PaymentController();
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    $controller->index();
}
?>