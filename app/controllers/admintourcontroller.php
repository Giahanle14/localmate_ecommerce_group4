<?php
require_once 'app/config/db_connect.php'; 
require_once 'app/models/admintourmodel.php';

class AdminTourController {
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        // Kiểm tra quyền Admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['LoaiTK'] !== 'Quản trị viên') {
            header("Location: index.php?controller=home");
            exit;
        }
    }

    public function index() {
        $model = new AdminTourModel();
        $tours = $model->getAllTours();
        $viewMode = 'list';
        require_once 'app/views/admintourview.php';
    }

    public function add() {
        $model = new AdminTourModel();
        $viewMode = 'add';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hinhAnh = 'public/image/tour/default.jpg'; // Ảnh mặc định
            
            // Xử lý upload ảnh cover
            if (isset($_FILES['coverImage']) && $_FILES['coverImage']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'public/image/tour/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                $fileName = time() . '_' . basename($_FILES['coverImage']['name']);
                $targetFile = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['coverImage']['tmp_name'], $targetFile)) {
                    $hinhAnh = $targetFile;
                }
            }

            $data = [
                'TenTour' => trim($_POST['tenTour']),
                'DiaDiem' => trim($_POST['diaDiem']),
                'MoTa' => trim($_POST['moTa']),
                'Gia' => str_replace(',', '', $_POST['gia']),
                'SoNgay' => (int)$_POST['soNgay'],
                'SoKhachToiDa' => (int)$_POST['soKhachToiDa'],
                'VungDiaLy' => $_POST['vungDiaLy'],
                'HinhAnh' => $hinhAnh,
                'MaTK_QTV' => $_SESSION['user']['MaTK']
            ];

            if ($model->addTour($data)) {
                echo "<script>alert('Thêm Tour thành công!'); window.location.href='index.php?controller=admintour';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra!'); history.back();</script>";
            }
            exit;
        }

        require_once 'app/views/admintourview.php';
    }

    public function edit() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=admintour");
            exit;
        }

        $maTour = $_GET['id'];
        $model = new AdminTourModel();
        $tourData = $model->getTourById($maTour);
        
        if (!$tourData) {
            echo "<script>alert('Không tìm thấy Tour!'); window.location.href='index.php?controller=admintour';</script>";
            exit;
        }

        $viewMode = 'edit';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hinhAnh = '';
            
            if (isset($_FILES['coverImage']) && $_FILES['coverImage']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'public/image/tour/';
                $fileName = time() . '_' . basename($_FILES['coverImage']['name']);
                $targetFile = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['coverImage']['tmp_name'], $targetFile)) {
                    $hinhAnh = $targetFile;
                }
            }

            $data = [
                'MaTour' => $maTour,
                'TenTour' => trim($_POST['tenTour']),
                'DiaDiem' => trim($_POST['diaDiem']),
                'MoTa' => trim($_POST['moTa']),
                'Gia' => str_replace(',', '', $_POST['gia']),
                'SoNgay' => (int)$_POST['soNgay'],
                'SoKhachToiDa' => (int)$_POST['soKhachToiDa'],
                'VungDiaLy' => $_POST['vungDiaLy'],
                'HinhAnh' => $hinhAnh
            ];

            if ($model->updateTour($data)) {
                echo "<script>alert('Cập nhật Tour thành công!'); window.location.href='index.php?controller=admintour';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra!'); history.back();</script>";
            }
            exit;
        }

        require_once 'app/views/admintourview.php';
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $model = new AdminTourModel();
            if ($model->deleteTour($_GET['id'])) {
                echo "<script>alert('Xóa Tour thành công!'); window.location.href='index.php?controller=admintour';</script>";
            } else {
                echo "<script>alert('Không thể xóa Tour vì đã có chuyến đi ràng buộc!'); history.back();</script>";
            }
        }
    }
}
?>