<?php
class AdminAccountController {
    public function index() {
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/adminaccountview.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>