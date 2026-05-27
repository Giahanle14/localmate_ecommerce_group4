<?php
class AdminMytripController {
    public function index() {
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/adminmytripview.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>