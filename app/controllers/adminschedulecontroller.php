<?php
require_once 'app/config/db_connect.php';
require_once 'app/models/adminschedulemodel.php';

class AdminScheduleController {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['LoaiTK'] !== 'Quản trị viên') {
            header("Location: index.php?controller=home");
            exit;
        }
    }

    public function index() {
    $model = new AdminScheduleModel();
    
    // 1. Lấy dữ liệu từ URL (phải lấy đúng tên 'daterange')
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $daterange = isset($_GET['daterange']) ? trim($_GET['daterange']) : '';
    
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10;

    // 2. Truyền $daterange xuống cho Model (Code Model ở tin nhắn trước đã có sẵn logic xử lý rồi)
    $result = $model->getAllSchedules($search, $page, $limit, $daterange);
    
    $schedules = $result['data'];
    $total = (int)$result['total'];
    $totalPages = ceil($total / $limit);

    $viewMode = 'list';
    require_once 'app/views/adminscheduleview.php';
}

    public function add() {
        $model = new AdminScheduleModel();
        $tours = $model->getAllTours();
        $viewMode = 'add';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'MaTour' => $_POST['maTour'],
                'NgayBatDau' => $_POST['ngayBatDau']
            ];

            if ($model->addSchedule($data)) {
                echo "<script>alert('Thêm lịch khởi hành thành công!'); window.location.href='index.php?controller=adminschedule';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra!'); history.back();</script>";
            }
            exit;
        }

        require_once 'app/views/adminscheduleview.php';
    }

    public function edit() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=adminschedule");
            exit;
        }

        $model = new AdminScheduleModel();
        $schedule = $model->getScheduleById($_GET['id']);
        $tours = $model->getAllTours();
        
        if (!$schedule) {
            echo "<script>alert('Không tìm thấy lịch khởi hành!'); window.location.href='index.php?controller=adminschedule';</script>";
            exit;
        }
        $viewMode = 'edit';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maTourMoi = $_POST['maTour'];
            if ($schedule['SoChoDaDat'] > 0 && $schedule['MaTour'] !== $maTourMoi) {
                echo "<script>alert('Không thể đổi Tour vì lịch khởi hành này đã có khách đặt/liên kết với chuyến đi!'); history.back();</script>";
                exit;
            }

            $data = [
                'MaLichKhoiHanh' => $_GET['id'],
                'MaTour' => $maTourMoi,
                'NgayBatDau' => $_POST['ngayBatDau']
            ];

            if ($model->updateSchedule($data)) {
                echo "<script>alert('Cập nhật thành công!'); window.location.href='index.php?controller=adminschedule';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra!'); history.back();</script>";
            }
            exit;
        }

        require_once 'app/views/adminscheduleview.php';
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $model = new AdminScheduleModel();
            if ($model->deleteSchedule($_GET['id'])) {
                echo "<script>alert('Xóa lịch khởi hành thành công!'); window.location.href='index.php?controller=adminschedule';</script>";
            } else {
                echo "<script>alert('Không thể xóa! Lịch khởi hành này đã được liên kết với chuyến đi của khách hàng.'); window.location.href='index.php?controller=adminschedule';</script>";
            }
        }
    }
}
?>