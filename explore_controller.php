<?php
// explore_controller.php
session_start();
require_once 'TourModel.php';

$currentUser = isset($_SESSION['MaDK']) ? $_SESSION['MaDK'] : 'KH00000001'; 
$model = new TourModel();

// Nhận tham số bộ lọc
$loai = isset($_GET['loai']) ? (is_array($_GET['loai']) ? $_GET['loai'] : [$_GET['loai']]) : [];
$vung = isset($_GET['vung']) ? $_GET['vung'] : '';
$ngay = isset($_GET['ngay']) ? $_GET['ngay'] : '';
$gia_max = isset($_GET['gia_max']) ? (int)$_GET['gia_max'] : 5000000; // Giá trị mặc định 5 triệu
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'yeu_thich';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 9; 
$offset = ($page - 1) * $limit;

// Xác định có đang sử dụng bộ lọc hay không (bao gồm cả lọc khi kéo giá)
$is_filtering = (!empty($loai) || !empty($vung) || !empty($ngay) || isset($_GET['sort']) || (isset($_GET['gia_max']) && $_GET['gia_max'] < 5000000) || isset($_GET['page']));

if ($is_filtering) {
    $totalTours = $model->getTotalTours($loai, $vung, $ngay, $gia_max);
    $totalPages = ceil($totalTours / $limit);
    $danhSachTour = $model->getDanhSachTour($loai, $vung, $ngay, $gia_max, $sort, $limit, $offset, $currentUser);
    
    // Tiêu đề động
    $page_title = "Tìm thấy $totalTours tour phù hợp";
    if (!empty($loai)) {
        $page_title = "Các tour " . implode(', ', $loai);
    } elseif ($vung) {
        $page_title = "Các tour vùng " . $vung;
    }
} else {
    // Trạng thái mặc định
    $tourMoiNhat = $model->getDanhSachTour([], '', '', 5000000, 'moi_nhat', 3, 0, $currentUser);
}

require_once 'explore_view.php';
?>