<?php
class AdmintripController {
    public function index() {
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/admintripview.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>