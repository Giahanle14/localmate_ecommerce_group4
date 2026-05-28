<?php
// app/controllers/favoritecontroller.php
require_once __DIR__ . '/../models/favoritemodel.php';

class FavoriteController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Khởi tạo model
        $model = new FavoriteModel();

        // Lấy thông tin tài khoản đang đăng nhập (Mặc định test là TK00000006)
        $currentUser = isset($_SESSION['MaTK_DK']) ? $_SESSION['MaTK_DK'] : (isset($_SESSION['MaDK']) ? $_SESSION['MaDK'] : 'TK00000006');
        
        // Nhận tham số tìm kiếm (nếu có)
        $keyword = isset($_GET['search']) ? trim($_GET['search']) : '';

        // Cấu hình phân trang
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 9; 
        $offset = ($page - 1) * $limit;

        // Lấy dữ liệu từ Model
        $totalFavorites = $model->getTotalFavorites($currentUser, $keyword);
        $totalPages = ceil($totalFavorites / $limit);
        $favoriteTours = $model->getFavoriteTours($currentUser, $keyword, $limit, $offset);

        // Gọi View để hiển thị
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/favoriteview.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>