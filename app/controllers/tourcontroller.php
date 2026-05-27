<?php
class TourController {
    public function index() {
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/tourview.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>