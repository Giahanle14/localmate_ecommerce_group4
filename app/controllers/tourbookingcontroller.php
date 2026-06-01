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
        // ĐÃ SỬA: Lấy mã lịch khởi hành từ URL thay vì ngày đi
        $maLichKhoiHanh = $_GET['malichkhoihanh'] ?? ''; 
        $soLuong = $_GET['soluong'] ?? 1;

        if (empty($maTour) || empty($maLichKhoiHanh)) {
            header("Location: index.php?controller=tour");
            exit;
        }

        $tour = $this->model->getTourById($maTour);
        // BỔ SUNG: Lấy thông tin lịch khởi hành và số chỗ còn trống
        $schedule = $this->model->getScheduleById($maLichKhoiHanh);

        if (!$tour || !$schedule) {
            header("Location: index.php?controller=tour");
            exit;
        }

        $ngayDi = $schedule['NgayBatDau'];
        $choTrong = $schedule['ChoTrong']; // Biến này sẽ truyền sang View
        
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
        $maLichKhoiHanh = $_POST['ma_lich_khoi_hanh'];
        
        $tour = $this->model->getTourById($maTour);
        $schedule = $this->model->getScheduleById($maLichKhoiHanh);
        
        $ngayDi = $_POST['ngay_bat_dau'];
        $ngayKetThuc = $_POST['ngay_ket_thuc'];
        $slNguoiLon = (int)$_POST['sl_nguoi_lon'];
        $slTreEm = (int)$_POST['sl_tre_em'];
        $slEmBe = (int)$_POST['sl_em_be'];
        $hoTen = $_POST['ho_ten'];
        $ghiChu = $_POST['ghi_chu'] ?? '';

        // BẢO MẬT BACKEND: Kiểm tra không cho đặt vượt quá số chỗ còn trống
        $tongHanhKhach = $slNguoiLon + $slTreEm + $slEmBe;
        if ($tongHanhKhach > $schedule['ChoTrong']) {
            echo "<script>
                    alert('Rất tiếc! Số lượng khách vượt quá số chỗ còn trống của lịch khởi hành này. Vui lòng chọn lại!');
                    window.history.back();
                  </script>";
            exit;
        }

        // 2. Tính tiền
        $giaGoc = $tour['Gia'];
        $uuDai = $tour['UuDai'] ?? 0;
        $tienNguoiLon = $slNguoiLon * $giaGoc;
        $tienTreEm = $slTreEm * ($giaGoc * 0.75);
        // Em bé (dưới 2 tuổi) thường miễn phí nên không cộng vào tiền
        $tongTienTruocGiam = $tienNguoiLon + $tienTreEm;
        $tongTienSauGiam = $tongTienTruocGiam * (1 - $uuDai);

        // 3. Lưu tạm session (Đã thêm ma_lich_khoi_hanh vào session)
        $_SESSION['booking_temp'] = [
            'ma_tour' => $maTour,
            'ma_lich_khoi_hanh' => $maLichKhoiHanh,
            'ten_tour' => $tour['TenTour'],
            'ngay_bat_dau' => $ngayDi,
            'ngay_ket_thuc' => $ngayKetThuc,
            'sl_nguoi_lon' => $slNguoiLon,
            'sl_tre_em' => $slTreEm,
            'sl_em_be' => $slEmBe,
            'ho_ten' => $hoTen,
            'tong_tien' => $tongTienSauGiam,
            'ghi_chu' => $ghiChu
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