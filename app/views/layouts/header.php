<?php
// Đoạn PHP này dùng để bắt xem trình duyệt đang ở Controller nào
$current_page = isset($_GET['controller']) ? strtolower($_GET['controller']) : 'home';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LocalMate - Khám phá Việt Nam theo cách của người bản địa</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="public/css/style.css?v=<?= time(); ?>">
</head>
<body>

    <header class="main-header" style="background-color: var(--color-primary-dark);">
        <nav class="navbar navbar-expand-xl navbar-dark py-3">
            <div class="container-fluid px-4">
                
                <a class="navbar-brand me-4" href="index.php">
                    <img src="public/image/logo/logo.png" alt="LocalMate Logo" height="45">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="mainNavbar">
                    <ul class="navbar-nav align-items-center gap-2">
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == 'home') ? 'active-nav-pill' : 'text-white' ?>" href="index.php?controller=home">
                                <i class="fa-solid fa-house"></i> TRANG CHỦ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == 'about') ? 'active-nav-pill' : 'text-white' ?>" href="index.php?controller=about">
                                <img src="public/image/icon/nonla.png" alt="Nón lá" class="icon-nonla"> VỀ LOCALMATE
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == 'tour') ? 'active-nav-pill' : 'text-white' ?>" href="index.php?controller=tour">
                                <i class="fa-solid fa-suitcase-rolling"></i> TOUR
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == 'chuyendi') ? 'active-nav-pill' : 'text-white' ?>" href="#">
                                <i class="fa-solid fa-location-dot"></i> CHUYẾN ĐI CỦA TÔI
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_page == 'yeuthich') ? 'active-nav-pill' : 'text-white' ?>" href="#">
                                <i class="fa-solid fa-heart"></i> YÊU THÍCH
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="d-flex align-items-center gap-4 ms-auto">
                    
                    <div class="dropdown d-flex align-items-center">
                        <a class="text-white text-decoration-none user-dropdown-toggle p-0 d-flex justify-content-center align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user fs-4"></i>
                            <div class="bg-white rounded-circle dropdown-indicator-container d-flex align-items-center justify-content-center" style="width: 16px; height: 16px;">
                                <i class="fa-solid fa-chevron-up" style="font-size: 0.6rem; color: var(--color-primary-dark);"></i>
                            </div>
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-end custom-dropdown-menu">
                            <button class="btn w-100 btn-dropdown-login d-flex align-items-center justify-content-center fw-bold" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="fa-solid fa-arrow-right-to-bracket fs-4 me-2"></i> Đăng nhập
                            </button>
                            <p class="mb-0 text-center dropdown-text">
                                Bạn chưa có tài khoản? <a href="#" class="dropdown-link">Đăng ký</a> ngay
                            </p>
                        </div>
                    </div>

                    <div class="position-relative d-flex align-items-center justify-content-center" style="cursor: pointer;">
                        <i class="fa-solid fa-bell text-white fs-4"></i>
                    </div>

                </div>
            </div>
        </nav>
    </header>

    <main class="main-content">