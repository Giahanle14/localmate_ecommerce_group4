<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LocalMate - Trải nghiệm du lịch bản địa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="public/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php
    $current_controller = isset($_GET['controller']) ? strtolower($_GET['controller']) : 'home';
    
    // Lấy Loại Tài Khoản từ Session (Nếu chưa đăng nhập thì mặc định là Du khách)
    $user_role = isset($_SESSION['user']['LoaiTK']) ? $_SESSION['user']['LoaiTK'] : 'Du khách'; 
?>

<header class="main-header">
    <div class="container-fluid px-4">
        <nav class="navbar navbar-expand-lg navbar-dark p-0">
            <a class="navbar-brand py-0" href="index.php?controller=<?= ($user_role === 'Quản trị viên') ? 'adminhome' : 'home' ?>">
                <img src="public/image/logo/logo.png" alt="LocalMate" style="height: 45px;">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav gap-2">
                    
                    <?php if ($user_role === 'Quản trị viên'): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_controller == 'adminhome') ? 'active-nav-pill' : '' ?>" href="index.php?controller=adminhome">
                                <i class="fa-solid fa-house"></i> TRANG CHỦ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_controller == 'admintour') ? 'active-nav-pill' : '' ?>" href="index.php?controller=admintour">
                                <i class="fa-solid fa-suitcase-rolling"></i> QUẢN LÝ TOUR
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_controller == 'adminaccount') ? 'active-nav-pill' : '' ?>" href="index.php?controller=adminaccount">
                                <i class="fa-solid fa-user-shield"></i> QUẢN LÝ TÀI KHOẢN
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_controller == 'admintrip') ? 'active-nav-pill' : '' ?>" href="index.php?controller=admintrip">
                                <i class="fa-solid fa-location-dot"></i> QUẢN LÝ CHUYẾN ĐI
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_controller == 'adminreport') ? 'active-nav-pill' : '' ?>" href="index.php?controller=adminreport">
                                <i class="fa-solid fa-chart-line"></i> BÁO CÁO
                            </a>
                        </li>
                    
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_controller == 'home') ? 'active-nav-pill' : '' ?>" href="index.php?controller=home">
                                <i class="fa-solid fa-house"></i> TRANG CHỦ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_controller == 'about') ? 'active-nav-pill' : '' ?>" href="index.php?controller=about">
                                <img src="public/image/icon/nonla.png" class="icon-nonla" alt=""> VỀ LOCALMATE
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_controller == 'tour') ? 'active-nav-pill' : '' ?>" href="index.php?controller=tour">
                                <i class="fa-solid fa-suitcase-rolling"></i> TOUR
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?controller=mytrip" class="nav-link" onclick="return requireLoginPopup(event, 'xem Chuyến đi của tôi')">
                                <i class="fa-solid fa-location-dot"></i> CHUYẾN ĐI CỦA TÔI
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($current_controller == 'favorite') ? 'active-nav-pill' : '' ?>" href="index.php?controller=favorite">
                                <i class="fa-solid fa-heart"></i> YÊU THÍCH
                            </a>
                        </li>
                    <?php endif; ?>
                    
                </ul>
            </div>

            <div class="d-flex align-items-center gap-3">
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="dropdown">
                        <a href="#" class="text-white text-decoration-none dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user-circle" style="font-size: 1.4rem;"></i>
                            <span class="fw-bold d-none d-md-inline"><?= htmlspecialchars($_SESSION['user']['HoTen']) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3" style="border-radius: 12px; min-width: 200px;">
                            <li><a class="dropdown-item fw-bold text-success py-2" href="index.php?controller=profile"><i class="fa-solid fa-id-badge me-2"></i>Hồ sơ của tôi</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger fw-bold py-2" href="index.php?controller=auth&action=logout"><i class="fa-solid fa-right-from-bracket me-2"></i>Đăng xuất</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="#" class="text-white text-decoration-none user-dropdown-toggle" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="fa-solid fa-user" style="font-size: 1.2rem;"></i>
                    </a>
                <?php endif; ?>

                <a href="#" class="text-white text-decoration-none position-relative">
                    <i class="fa-solid fa-bell" style="font-size: 1.2rem;"></i>
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-warning border border-light rounded-circle" style="width: 10px; height: 10px; margin-top: 2px; margin-left: -2px;">
                        <span class="visually-hidden">New alerts</span>
                    </span>
                </a>
            </div>
        </nav>
    </div>
    <script>
    const IS_LOGGED_IN = <?= isset($_SESSION['user']) ? 'true' : 'false' ?>;

    function requireLoginPopup(event, actionName) {
        if (!IS_LOGGED_IN) {
            if (event) {
                event.preventDefault();
            }

            Swal.fire({
                title: 'Yêu cầu đăng nhập',
                html: `Vui lòng đăng nhập để <b>${actionName}</b>.<br><span style="font-size: 0.9rem; color: #666;">Đừng bỏ lỡ những trải nghiệm tuyệt vời cùng LocalMate!</span>`,
                icon: 'warning',
                iconColor: '#F89B29',
                showCancelButton: true,
                confirmButtonColor: '#00712D',
                cancelButtonColor: '#f0f0f0',
                cancelButtonText: '<span style="color: #333; font-weight: 600;">Để sau</span>',
                confirmButtonText: '<i class="fa-solid fa-right-to-bracket"></i> Đăng nhập ngay',
                background: '#F8FAF5',
                customClass: {
                    popup: 'rounded-4 shadow-lg',
                    title: 'fw-bold text-dark'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // XÓA LỆNH CHUYỂN TRANG CŨ VÀ THAY BẰNG LỆNH GỌI MODAL NÀY:
                    const loginModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('loginModal'));
                    loginModal.show();
                }
            });
            
            return false;
        }
        return true; 
    }
</script>
</header>