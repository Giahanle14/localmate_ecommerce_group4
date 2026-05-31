<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once __DIR__ . '/../models/canceltripmodel.php';

class CancelTripController {
    private $model;

    public function __construct() {
        $this->model = new CancelTripModel();
    }

    public function index() {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=home");
            exit;
        }

        $maChuyenDi = $_GET['id'] ?? '';
        $maTK = $_SESSION['user']['MaTK'];

        $trip = $this->model->getTripById($maTK, $maChuyenDi);

        if (!$trip || $trip['TrangThai'] !== 'Chưa hoàn thành') {
            echo "<script>alert('Không thể thực hiện hủy chuyến đi này!'); window.location.href='index.php?controller=mytrip';</script>";
            exit;
        }

        $ngayBatDau = new DateTime($trip['NgayBatDau']);
        $ngayHienTai = new DateTime(date('Y-m-d'));
        
        $tyLeHoan = 0;
        if ($ngayHienTai < $ngayBatDau) {
            $diff = $ngayHienTai->diff($ngayBatDau)->days;
            if ($diff >= 7) { $tyLeHoan = 1.00; } 
            elseif ($diff >= 3) { $tyLeHoan = 0.50; } 
            else { $tyLeHoan = 0.00; }
        } else {
            $tyLeHoan = 0.00; 
        }
        $soTienHoan = $trip['TongGiaTien'] * $tyLeHoan;

        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/canceltripview.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    public function process() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user'])) {
            header("Location: index.php?controller=mytrip");
            exit;
        }

        $maChuyenDi = $_POST['ma_chuyen_di'];
        $maTK = $_SESSION['user']['MaTK'];
        
        $lyDoSelect = $_POST['ly_do_select'];
        $chiTiet = trim($_POST['chi_tiet_ly_do']);
        $lyDoFull = $lyDoSelect;
        if (!empty($chiTiet)) {
            $lyDoFull .= ' - ' . $chiTiet;
        }

        $trip = $this->model->getTripById($maTK, $maChuyenDi);
        if (!$trip || $trip['TrangThai'] !== 'Chưa hoàn thành') {
            echo "<script>alert('Giao dịch không hợp lệ!'); window.location.href='index.php?controller=mytrip';</script>";
            exit;
        }

        $ngayBatDau = new DateTime($trip['NgayBatDau']);
        $ngayHienTai = new DateTime(date('Y-m-d'));
        $tyLeHoan = 0;
        if ($ngayHienTai < $ngayBatDau) {
            $diff = $ngayHienTai->diff($ngayBatDau)->days;
            if ($diff >= 7) $tyLeHoan = 1.00;
            elseif ($diff >= 3) $tyLeHoan = 0.50;
        }
        $soTienHoan = $trip['TongGiaTien'] * $tyLeHoan;

        $result = $this->model->submitCancelRequest($maTK, $maChuyenDi, $lyDoFull, $tyLeHoan, $soTienHoan);

        if ($result) {
            // THAY ĐỔI: Chuyển hướng sang trang Success
            header("Location: index.php?controller=canceltrip&action=success");
            exit;
        } else {
            echo "<script>
                alert('Có lỗi xảy ra trong hệ thống, vui lòng thử lại sau!');
                history.back();
            </script>";
        }
    }

    // HÀM MỚI: Hiển thị trang thành công
    public function success() {
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/cancelsuccessview.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}

$action = $_GET['action'] ?? 'index';
$controller = new CancelTripController();
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    $controller->index();
}
?>