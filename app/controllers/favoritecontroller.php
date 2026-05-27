<?php
class FavoriteController {
    public function index() {
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/favoriteview.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>