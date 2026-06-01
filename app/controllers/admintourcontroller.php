<?php
require_once 'app/config/db_connect.php'; 
require_once 'app/models/admintourmodel.php';

class AdminTourController {
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['LoaiTK'] !== 'Quản trị viên') {
            header("Location: index.php?controller=home");
            exit;
        }
    }

    public function index() {
        $model = new AdminTourModel();

        $filters = [
            'search' => isset($_GET['search']) ? trim($_GET['search']) : '',
            'vung' => isset($_GET['vung']) ? trim($_GET['vung']) : '',
            'trainghiem' => isset($_GET['trainghiem']) ? trim($_GET['trainghiem']) : '',
            'gia' => isset($_GET['gia']) ? trim($_GET['gia']) : ''
        ];

        $tours = $model->getFilteredTours($filters);
        $viewMode = 'list';
        require_once 'app/views/admintourview.php';
    }

    public function detail() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=admintour");
            exit;
        }
        $model = new AdminTourModel();
        $tourData = $model->getTourById($_GET['id']);
        
        if (!$tourData) {
            echo "<script>alert('Không tìm thấy Tour!'); window.location.href='index.php?controller=admintour';</script>";
            exit;
        }
        $danhGiaList = $model->getReviewsByTour($_GET['id']);

        $viewMode = 'detail';
        require_once 'app/views/admintourview.php';
    }

    public function add() {
        $model = new AdminTourModel();
        $viewMode = 'add';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $uploadDir = 'public/image/tour/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $hinhAnh = 'public/image/tour/default.jpg';
            if (isset($_FILES['coverImage']) && $_FILES['coverImage']['error'] === UPLOAD_ERR_OK) {
                $fileName = time() . '_cover_' . basename($_FILES['coverImage']['name']);
                $targetFile = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['coverImage']['tmp_name'], $targetFile)) {
                    $hinhAnh = $targetFile;
                }
            }

            $galleryPaths = [];
            if (isset($_FILES['gallery'])) {
                $fileCount = count($_FILES['gallery']['name']);
                for ($i = 0; $i < $fileCount; $i++) {
                    if ($_FILES['gallery']['error'][$i] === UPLOAD_ERR_OK) {
                        $fileName = time() . '_gal_' . $i . '_' . basename($_FILES['gallery']['name'][$i]);
                        $targetFile = $uploadDir . $fileName;
                        if (move_uploaded_file($_FILES['gallery']['tmp_name'][$i], $targetFile)) {
                            $galleryPaths[] = $targetFile;
                        }
                    }
                }
            }

            $loaiTraiNghiem = isset($_POST['loaiTraiNghiem']) ? implode(',', (array)$_POST['loaiTraiNghiem']) : 'Tham quan';
            $uuDaiRaw = isset($_POST['uuDai']) && $_POST['uuDai'] !== '' ? floatval($_POST['uuDai']) : 0;
            $uuDai = $uuDaiRaw > 0 ? $uuDaiRaw / 100 : 0;

            $data = [
                'TenTour' => trim($_POST['tenTour'] ?? ''),
                'DiaDiem' => trim($_POST['diaDiem'] ?? ''),
                'MoTa' => trim($_POST['moTa'] ?? ''),
                'LichTrinh' => trim($_POST['lichTrinh'] ?? ''), 
                'Gia' => str_replace(',', '', $_POST['gia'] ?? '0'),
                'SoNgay' => (int)($_POST['soNgay'] ?? 0),
                'SoKhachToiDa' => (int)($_POST['soKhachToiDa'] ?? 0),
                'VungDiaLy' => $_POST['vungDiaLy'] ?? '',
                'LoaiTraiNghiem' => $loaiTraiNghiem, 
                'HinhAnh' => $hinhAnh,
                'UuDai' => $uuDai,
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
            $uploadDir = 'public/image/tour/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            
            $hinhAnh = '';
            if (isset($_FILES['coverImage']) && $_FILES['coverImage']['error'] === UPLOAD_ERR_OK) {
                $fileName = time() . '_cover_' . basename($_FILES['coverImage']['name']);
                $targetFile = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['coverImage']['tmp_name'], $targetFile)) {
                    $hinhAnh = $targetFile;
                }
            }

            $galleryPaths = [];
            if (isset($_FILES['gallery'])) {
                $fileCount = count($_FILES['gallery']['name']);
                for ($i = 0; $i < $fileCount; $i++) {
                    if ($_FILES['gallery']['error'][$i] === UPLOAD_ERR_OK) {
                        $fileName = time() . '_gal_' . $i . '_' . basename($_FILES['gallery']['name'][$i]);
                        $targetFile = $uploadDir . $fileName;
                        if (move_uploaded_file($_FILES['gallery']['tmp_name'][$i], $targetFile)) {
                            $galleryPaths[] = $targetFile;
                        }
                    }
                }
            }

            $loaiTraiNghiem = isset($_POST['loaiTraiNghiem']) ? implode(',', (array)$_POST['loaiTraiNghiem']) : 'Tham quan';
            $uuDaiRaw = isset($_POST['uuDai']) && $_POST['uuDai'] !== '' ? floatval($_POST['uuDai']) : 0;
            $uuDai = $uuDaiRaw > 0 ? $uuDaiRaw / 100 : 0;

            $data = [
                'MaTour' => $maTour,
                'TenTour' => trim($_POST['tenTour'] ?? ''),
                'DiaDiem' => trim($_POST['diaDiem'] ?? ''),
                'MoTa' => trim($_POST['moTa'] ?? ''),
                'LichTrinh' => trim($_POST['lichTrinh'] ?? ''),
                'Gia' => str_replace(',', '', $_POST['gia'] ?? '0'),
                'SoNgay' => (int)($_POST['soNgay'] ?? 0),
                'SoKhachToiDa' => (int)($_POST['soKhachToiDa'] ?? 0),
                'VungDiaLy' => $_POST['vungDiaLy'] ?? '',
                'LoaiTraiNghiem' => $loaiTraiNghiem,
                'UuDai' => $uuDai,
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
                echo "<script>alert('Không thể xóa Tour vì đã có Lịch khởi hành hoặc Chuyến đi ràng buộc!'); history.back();</script>";
            }
        }
    }
}
?>