<?php

class HomeController {

    // Hàm index sẽ tự động chạy khi truy cập trang chủ
    public function index() {
        
        // 1. Nhúng file kết nối CSDL
        require_once __DIR__ . '/../config/db_connect.php';

        $toursNoiBat = [];
        $toursYeuThich = [];

        // 2. Lấy dữ liệu từ bảng 'tour'
        try {
            if(isset($conn)) {
                // Lấy 3 tour đầu tiên làm tour nổi bật
                $stmt1 = $conn->prepare("SELECT * FROM tour LIMIT 3");
                $stmt1->execute();
                $toursNoiBat = $stmt1->fetchAll(PDO::FETCH_ASSOC);

                // Lấy 3 tour tiếp theo làm tour yêu thích
                $stmt2 = $conn->prepare("SELECT * FROM tour LIMIT 3 OFFSET 3");
                $stmt2->execute();
                $toursYeuThich = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch(PDOException $e) {
            echo "<script>console.log('Lỗi DB: " . addslashes($e->getMessage()) . "');</script>";
        }

        // 3. Gọi các file giao diện (Views) ra để hiển thị
        // Biến $toursNoiBat và $toursYeuThich sẽ tự động được truyền xuống file index.php bên dưới
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/home/index.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

}

?>