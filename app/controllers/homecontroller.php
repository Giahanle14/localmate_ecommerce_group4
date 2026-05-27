<?php

class HomeController {

    public function index() {
        // Nhúng file kết nối
        require_once __DIR__ . '/../config/db_connect.php';

        $toursNoiBat = [];
        $toursYeuThich = [];

        try {
            if(isset($conn)) {
                $stmt1 = $conn->prepare("SELECT * FROM tour LIMIT 3");
                $stmt1->execute();
                $toursNoiBat = $stmt1->fetchAll(PDO::FETCH_ASSOC);

                $stmt2 = $conn->prepare("SELECT * FROM tour LIMIT 3 OFFSET 3");
                $stmt2->execute();
                $toursYeuThich = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch(PDOException $e) {
            echo "<script>console.log('Lỗi DB: " . addslashes($e->getMessage()) . "');</script>";
        }
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user']) && $_SESSION['user']['LoaiTK'] === 'Quản trị viên') {
            header("Location: index.php?controller=adminhome");
            exit();
        }

        // Gọi View
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/home/index.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

}
?>