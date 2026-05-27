<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class AdminHomeController {
    public function index() {
        // 1. KIỂM TRA BẢO MẬT: Chỉ Quản trị viên mới được vào trang này
        if (!isset($_SESSION['user']) || $_SESSION['user']['LoaiTK'] !== 'Quản trị viên') {
            header("Location: index.php?controller=home");
            exit();
        }

        // 2. Gọi View
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/adminhomeview.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>