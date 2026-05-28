<?php
class TourBookingController {
    public function index() {
        // Có thể lấy các biến GET như id (MaTour), ngaydi, soluong ở đây nếu cần
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/tourbookingview.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>