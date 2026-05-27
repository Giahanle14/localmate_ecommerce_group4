<?php
class AdminTourController {
    public function index() {
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/admintourview.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>