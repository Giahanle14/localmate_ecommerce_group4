<?php
// app/controllers/aboutcontroller.php

class AboutController {
    // Hàm index() là hàm mặc định sẽ chạy khi gọi đến controller này
    public function index() {
        // 1. Gọi Header
        require_once __DIR__ . '/../views/layouts/header.php';
        
        // 2. Gọi View (Phần thân trang)
        require_once __DIR__ . '/../views/aboutview.php';
        
        // 3. Gọi Footer
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>