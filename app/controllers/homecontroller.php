<?php

class HomeController {

<<<<<<< HEAD
    // Hàm index sẽ tự động chạy khi truy cập trang chủ
    public function index() {
        
        // 1. Nhúng file kết nối CSDL
=======
    public function index() {
        // Nhúng file kết nối
>>>>>>> dc02dda3b25d0ce58ade747657d6bf8bd69ef6cb
        require_once __DIR__ . '/../config/db_connect.php';

        $toursNoiBat = [];
        $toursYeuThich = [];

<<<<<<< HEAD
        // 2. Lấy dữ liệu từ bảng 'tour'
        try {
            if(isset($conn)) {
                // Lấy 3 tour đầu tiên làm tour nổi bật
=======
        try {
            if(isset($conn)) {
>>>>>>> dc02dda3b25d0ce58ade747657d6bf8bd69ef6cb
                $stmt1 = $conn->prepare("SELECT * FROM tour LIMIT 3");
                $stmt1->execute();
                $toursNoiBat = $stmt1->fetchAll(PDO::FETCH_ASSOC);

<<<<<<< HEAD
                // Lấy 3 tour tiếp theo làm tour yêu thích
=======
>>>>>>> dc02dda3b25d0ce58ade747657d6bf8bd69ef6cb
                $stmt2 = $conn->prepare("SELECT * FROM tour LIMIT 3 OFFSET 3");
                $stmt2->execute();
                $toursYeuThich = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch(PDOException $e) {
            echo "<script>console.log('Lỗi DB: " . addslashes($e->getMessage()) . "');</script>";
        }
<<<<<<< HEAD

        // 3. Gọi các file giao diện (Views) ra để hiển thị
        // Biến $toursNoiBat và $toursYeuThich sẽ tự động được truyền xuống file index.php bên dưới
=======
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user']) && $_SESSION['user']['LoaiTK'] === 'Quản trị viên') {
            header("Location: index.php?controller=adminhome");
            exit();
        }

        // Gọi View
>>>>>>> dc02dda3b25d0ce58ade747657d6bf8bd69ef6cb
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/home/index.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

}
<<<<<<< HEAD

=======
>>>>>>> dc02dda3b25d0ce58ade747657d6bf8bd69ef6cb
?>