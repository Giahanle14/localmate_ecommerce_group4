<?php
// app/controllers/favoritecontroller.php
require_once __DIR__ . '/../models/favoritemodel.php';

class FavoriteController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Bắt request AJAX để xử lý thao tác gỡ tim/thả tim
        if (isset($_POST['action']) && $_POST['action'] === 'toggle_heart') {
            header('Content-Type: application/json');
            $maDK = isset($_SESSION['user']['MaTK']) ? $_SESSION['user']['MaTK'] : '';
            $maTour = isset($_POST['ma_tour']) ? $_POST['ma_tour'] : '';

            if (empty($maTour) || empty($maDK)) {
                echo json_encode(['success' => false, 'message' => 'Lỗi dữ liệu hoặc chưa đăng nhập']);
                exit;
            }

            try {
                $modelAjax = new FavoriteModel();
                $resultAction = $modelAjax->toggleHeart($maDK, $maTour);
                echo json_encode(['success' => true, 'action' => $resultAction]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Lỗi server']);
            }
            exit; // Dừng thực thi script cho AJAX
        }

        // 1. KIỂM TRA BẢO MẬT: Phải đăng nhập và có vai trò là Du khách
        if (!isset($_SESSION['user']) || $_SESSION['user']['LoaiTK'] !== 'Du khách') {
            // Nạp header trước để có bộ source HTML của loginModal
            require_once __DIR__ . '/../views/layouts/header.php';
            
            // Render giao diện phụ
            echo "<main class='container py-4' style='min-height: 65vh;'>
                  </main>";
            
            // Chạy Script show modal lập tức VÀ lắng nghe sự kiện đóng modal để chuyển hướng
            echo "<script>
                alert('Vui lòng đăng nhập tài khoản du khách để xem danh sách yêu thích.');
                document.addEventListener('DOMContentLoaded', function() {
                    var modalElement = document.getElementById('loginModal');
                    if (modalElement) {
                        var loginModal = new bootstrap.Modal(modalElement);
                        loginModal.show();
                        
                        // Lắng nghe sự kiện khi cửa sổ modal bị đóng/thoát
                        modalElement.addEventListener('hidden.bs.modal', function () {
                            window.location.href = 'index.php?controller=home';
                        });
                    }
                });
            </script>";
            
            // Nạp footer để giao diện trang không bị khuyết
            require_once __DIR__ . '/../views/layouts/footer.php';
            exit();
        }

        // Khởi tạo model
        $model = new FavoriteModel();

        // 2. Lấy mã tài khoản tự động từ Session của người dùng hiện tại
        $currentUser = $_SESSION['user']['MaTK'];
        
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