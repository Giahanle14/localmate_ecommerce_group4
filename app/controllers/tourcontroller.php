<?php
// app/controllers/tourcontroller.php
require_once __DIR__ . '/../models/tourmodel.php';

class TourController {
    
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Bắt request AJAX từ nút thả tim trên trang
        if (isset($_POST['action']) && $_POST['action'] === 'toggle_heart') {
            header('Content-Type: application/json');
            
            // Sửa lại mặc định lấy TK00000006 thay vì KH00000001 không tồn tại
            $maDK = isset($_SESSION['MaTK_DK']) ? $_SESSION['MaTK_DK'] : (isset($_SESSION['MaDK']) ? $_SESSION['MaDK'] : 'TK00000006');
            $maTour = isset($_POST['ma_tour']) ? $_POST['ma_tour'] : '';

            if(empty($maTour)) {
                echo json_encode(['success' => false, 'message' => 'Lỗi dữ liệu']);
                exit;
            }

            try {
                $modelAjax = new TourModel();
                $resultAction = $modelAjax->toggleHeart($maDK, $maTour);
                echo json_encode(['success' => true, 'action' => $resultAction]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Lỗi server']);
            }
            exit; // Dừng thực thi để không load lại giao diện trang web
        }

        // KHỞI TẠO DỮ LIỆU BỘ LỌC CHO TRANG KHÁM PHÁ (EXPLORE)
        // Dùng TK00000006 làm mẫu mặc định 
        $currentUser = isset($_SESSION['MaTK_DK']) ? $_SESSION['MaTK_DK'] : (isset($_SESSION['MaDK']) ? $_SESSION['MaDK'] : 'TK00000006'); 
        $model = new TourModel();

        // Nhận tham số bộ lọc
        $loai = isset($_GET['loai']) ? (is_array($_GET['loai']) ? $_GET['loai'] : [$_GET['loai']]) : [];
        $vung = isset($_GET['vung']) ? $_GET['vung'] : '';
        $ngay = isset($_GET['ngay']) ? $_GET['ngay'] : '';
        $gia_max = isset($_GET['gia_max']) ? (int)$_GET['gia_max'] : 5000000; // Giá trị mặc định 5 triệu
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'yeu_thich';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        
        // --- XỬ LÝ NÚT XEM THÊM 20 TOUR MỚI NHẤT ---
        $view_latest = isset($_GET['view']) && $_GET['view'] === 'latest';
        
        // Luôn hiển thị tối đa 9 tour trên 1 trang
        $limit = 9; 
        $offset = ($page - 1) * $limit;

        // Xác định có đang sử dụng bộ lọc hay không
        $is_filtering = (!empty($loai) || !empty($vung) || !empty($ngay) || isset($_GET['sort']) || (isset($_GET['gia_max']) && $_GET['gia_max'] < 5000000) || isset($_GET['page']) || $view_latest);

        if ($is_filtering) {
            if ($view_latest) {
                $sort = 'moi_nhat'; // Ép kiểu sắp xếp mới nhất
                
                // Lấy tổng số tour đang có, nhưng chỉ giới hạn tối đa 20 tour
                $totalInDb = $model->getTotalTours([], '', '', 5000000);
                $totalTours = min(20, $totalInDb); 
                
                // Kích hoạt phân trang cho 20 tour này
                $totalPages = ceil($totalTours / $limit);
                
                // Tính toán limit thực tế cho truy vấn DB để không lấy dư sang tour thứ 21
                $queryLimit = max(0, min($limit, 20 - $offset));
                
                if ($queryLimit > 0) {
                    $danhSachTour = $model->getDanhSachTour([], '', '', 5000000, 'moi_nhat', $queryLimit, $offset, $currentUser);
                } else {
                    $danhSachTour = []; // Tránh lỗi nếu URL bị đổi page quá lớn
                }
                
                $page_title = "20 tour mới nhất";
            } else {
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
            }
        } else {
            // Trạng thái mặc định nếu không có bộ lọc (Chỉ giữ lại 3 tour mới nhất cho giao diện ban đầu đỡ dài)
            $tourMoiNhat = $model->getDanhSachTour([], '', '', 5000000, 'moi_nhat', 3, 0, $currentUser);
        }

        // Tích hợp luồng Route (View Layout) của nhóm
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/tourview.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>