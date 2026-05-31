<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'app/models/paymentmodel.php';

class PaymentController {
    private $model;

    public function __construct() {
        $this->model = new PaymentModel();
    }

    // Hiển thị trang chọn phương thức thanh toán
    public function index() {
        // Kiểm tra bảo mật: Tránh việc gõ URL truy cập thẳng
        if (!isset($_SESSION['booking_temp']) || !isset($_SESSION['user'])) {
            header("Location: index.php?controller=tour");
            exit;
        }

        // Lấy mã chuyến đi tiếp theo từ Database
        $nextMaCD = $this->model->getNextMaChuyenDi();
        
        // Lưu mã này vào Session để lát submit dùng chính mã này (đảm bảo đồng bộ giao diện và DB)
        $_SESSION['booking_temp']['ma_chuyen_di'] = $nextMaCD; 

        require_once 'app/views/paymentview.php';
    }

    // Xác nhận thanh toán và Lưu Database
    public function confirm() {
        // Validate Request & Session
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['booking_temp']) || !isset($_SESSION['user'])) {
            header("Location: index.php?controller=tour");
            exit;
        }

        $phuongThuc = $_POST['phuong_thuc_thanh_toan']; 
        $booking = $_SESSION['booking_temp'];
        
        // Bắt buộc lấy đúng 'MaTK' từ session để lưu vào khóa ngoại MaTK_DK
        $maTK_DK = isset($_SESSION['user']['MaTK']) ? $_SESSION['user']['MaTK'] : null;
        
        // Bảo mật lớp 2: Chặn Crash Database nếu session bị rỗng
        if (empty($maTK_DK)) {
            echo "<script>
                alert('Lỗi: Không tìm thấy phiên đăng nhập hoặc phiên đã hết hạn. Vui lòng đăng xuất và đăng nhập lại!');
                window.location.href = 'index.php';
            </script>";
            exit;
        }

        $soLuongKhach = $booking['sl_nguoi_lon'] + $booking['sl_tre_em'];
        $maChuyenDi = $booking['ma_chuyen_di']; // Lấy mã đã cấp trên giao diện

        // Triệu gọi Model để lưu song song vào 2 bảng
        $result = $this->model->saveBookingAndTransaction(
            $maTK_DK,
            $booking['ma_tour'],
            $booking['ngay_bat_dau'],
            $booking['ngay_ket_thuc'],
            $booking['tong_tien'],
            $soLuongKhach,
            $phuongThuc,
            $maChuyenDi
        );

        if ($result) {
            // Xóa session tạm thời sau khi lưu thành công
            unset($_SESSION['booking_temp']);
            
            // THAY ĐỔI Ở ĐÂY: Chuyển hướng sang trang Hoàn tất thay vì alert
            header("Location: index.php?controller=payment&action=success&macd=" . $result);
            exit;
        } else {
            echo "<script>
                alert('Có lỗi hệ thống xảy ra trong quá trình lưu dữ liệu. Vui lòng thử lại!');
                history.back();
            </script>";
        }
    }

    // MỚI: Hiển thị trang thanh toán thành công
    public function success() {
        // Lấy mã chuyến đi từ URL để hiển thị cho người dùng
        $maChuyenDi = $_GET['macd'] ?? '';
        
        if (empty($maChuyenDi)) {
            header("Location: index.php?controller=mytrip");
            exit;
        }

        require_once 'app/views/paymentsuccessview.php';
    }
}

// Logic định tuyến cho Controller này
$action = $_GET['action'] ?? 'index';
$controller = new PaymentController();
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    $controller->index();
}
?>