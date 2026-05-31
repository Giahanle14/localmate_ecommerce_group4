<?php
// =====================================================================
// XỬ LÝ AJAX: NÚT ĐÁNH DẤU ĐÃ ĐỌC THÔNG BÁO
// =====================================================================
if (session_status() === PHP_SESSION_NONE) session_start();
if (isset($_POST['ajax_action']) && $_POST['ajax_action'] === 'mark_notif_read') {
    $_SESSION['notif_read_status'] = true; // Lưu cờ vào session
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
    exit;
}
// =====================================================================

// Đảm bảo có kết nối CSDL để lấy thông báo
global $conn;
if (!$conn) {
    require_once 'app/config/db_connect.php';
}
?>
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
    <style>
        /* Tùy chỉnh thanh cuộn cho hộp thông báo */
        .notif-scroll::-webkit-scrollbar { width: 6px; }
        .notif-scroll::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        .notif-scroll::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 10px; }
        .notif-scroll::-webkit-scrollbar-thumb:hover { background: #a8a8a8; }
        .notif-item:hover { background-color: #f8faf5; }
        .notif-read-btn { cursor: pointer; transition: 0.2s; }
        .notif-read-btn:hover { color: #F29A2E !important; }
    </style>
</head>
<body>

<?php
    $current_controller = isset($_GET['controller']) ? strtolower($_GET['controller']) : 'home';
    $user_role = isset($_SESSION['user']['LoaiTK']) ? $_SESSION['user']['LoaiTK'] : 'Du khách'; 

    // =====================================================================
    // LOGIC TỔNG HỢP THÔNG BÁO (TỪ DATABASE + FAKE)
    // =====================================================================
    $notifications = [];
    $is_read = isset($_SESSION['notif_read_status']) ? $_SESSION['notif_read_status'] : false;

    if (isset($_SESSION['user'])) {
        if ($user_role === 'Quản trị viên') {
            // 1. DỮ LIỆU THẬT - QUẢN TRỊ VIÊN
            try {
                $stmt = $conn->prepare("SELECT COUNT(*) FROM YeuCauHuy WHERE TrangThai = 'Chưa xử lý'");
                $stmt->execute();
                $cancelCount = $stmt->fetchColumn();

                if ($cancelCount > 0) {
                    $notifications[] = [
                        'title' => 'Yêu cầu hủy cần duyệt',
                        'time' => 'Hệ thống',
                        'desc' => "Có $cancelCount đơn yêu cầu hủy chuyến đang chờ bạn xử lý.",
                        'icon' => 'fa-triangle-exclamation',
                        'color' => 'text-danger'
                    ];
                    // Ép hiện lại số đếm nếu có đơn chưa xử lý (dù đã bấm đọc trước đó)
                    $is_read = false; 
                    $_SESSION['notif_read_status'] = false;
                }
            } catch (Exception $e) {}

            // 2. DỮ LIỆU FAKE - QUẢN TRỊ VIÊN
            $notifications[] = ['title' => 'Cảnh báo bảo trì', 'time' => '10 phút trước', 'desc' => 'Hệ thống sẽ bảo trì định kỳ lúc 00:00. Vui lòng lưu lại công việc.', 'icon' => 'fa-screwdriver-wrench', 'color' => 'text-warning'];
            $notifications[] = ['title' => 'Tính năng mới sắp ra mắt', 'time' => '2 giờ trước', 'desc' => 'Module Thống kê doanh thu nâng cao đang được team DEV phát triển.', 'icon' => 'fa-rocket', 'color' => 'text-info'];

        } else {
            // 1. DỮ LIỆU THẬT - DU KHÁCH
            try {
                $maTK = $_SESSION['user']['MaTK'];
                // Lấy 2 chuyến đi gần nhất của khách này
                $stmt = $conn->prepare("SELECT c.MaChuyenDi, t.TenTour, c.TrangThai 
                                        FROM ChuyenDi c 
                                        JOIN Tour t ON c.MaTour = t.MaTour 
                                        WHERE c.MaTK_DK = ? 
                                        ORDER BY c.MaChuyenDi DESC LIMIT 2");
                $stmt->execute([$maTK]);
                $recentTrips = $stmt->fetchAll();

                foreach ($recentTrips as $trip) {
                    if ($trip['TrangThai'] === 'Chưa hoàn thành') {
                        $notifications[] = [
                            'title' => 'Xác nhận chuyến đi',
                            'time' => 'Hệ thống',
                            'desc' => 'Chuyến đi "' . htmlspecialchars($trip['TenTour']) . '" của bạn đã được đặt thành công.',
                            'icon' => 'fa-check-circle',
                            'color' => 'text-success'
                        ];
                    } elseif ($trip['TrangThai'] === 'Đã hủy') {
                        $notifications[] = [
                            'title' => 'Đã hủy chuyến',
                            'time' => 'Hệ thống',
                            'desc' => 'Chuyến đi "' . htmlspecialchars($trip['TenTour']) . '" của bạn đã bị hủy theo yêu cầu.',
                            'icon' => 'fa-circle-xmark',
                            'color' => 'text-danger'
                        ];
                    }
                }

                // Lấy 1 tour mới nhất được thêm vào hệ thống để thông báo
                $stmtNewTour = $conn->prepare("SELECT TenTour, NgayTao FROM Tour ORDER BY NgayTao DESC LIMIT 1");
                $stmtNewTour->execute();
                $newestTour = $stmtNewTour->fetch();

                if ($newestTour) {
                    // Tính thời gian trôi qua để hiển thị cho đẹp (Hôm nay, 2 ngày trước,...)
                    $ngayTao = strtotime($newestTour['NgayTao']);
                    $diffDays = floor((time() - $ngayTao) / 86400);
                    
                    if ($diffDays == 0) {
                        $timeStr = "Hôm nay";
                    } elseif ($diffDays < 30) {
                        $timeStr = $diffDays . " ngày trước";
                    } else {
                        $timeStr = date('d/m/Y', $ngayTao);
                    }

                    $notifications[] = [
                        'title' => 'Tour mới toanh! 🎉',
                        'time' => $timeStr,
                        'desc' => 'Hệ thống vừa cập nhật tour mới: "' . htmlspecialchars($newestTour['TenTour']) . '". Khám phá ngay kẻo lỡ!',
                        'icon' => 'fa-map-location-dot',
                        'color' => 'text-primary'
                    ];
                }

            } catch (Exception $e) {}

            // 2. DỮ LIỆU FAKE - DU KHÁCH
            $notifications[] = ['title' => 'Tặng bạn mã giảm 20%', 'time' => 'Vừa xong', 'desc' => 'Tri ân khách hàng, nhập mã LOCAL20 để giảm 20% cho chuyến đi tiếp theo!', 'icon' => 'fa-gift', 'color' => 'text-danger'];
        }
    }

    $notif_count = $is_read ? 0 : count($notifications);
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
                        
                        <li class="nav-item d-lg-none mt-2 pt-2" style="border-top: 1px solid rgba(255,255,255,0.2);">
                            <a class="nav-link text-warning fw-bold" href="index.php?controller=auth&action=logout">
                                <i class="fa-solid fa-right-from-bracket"></i> ĐĂNG XUẤT
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

                        <li class="nav-item d-lg-none mt-2 pt-2" style="border-top: 1px solid rgba(255,255,255,0.2);">
                            <?php if (isset($_SESSION['user'])): ?>
                                <a class="nav-link text-white fw-bold mb-1" href="index.php?controller=profile">
                                    <!-- ĐÃ SỬA: XÓA STYLE MÀU CỦA ICON NÀY -->
                                    <i class="fa-solid fa-id-badge"></i> HỒ SƠ CỦA TÔI
                                </a>
                                <a class="nav-link text-warning fw-bold" href="index.php?controller=auth&action=logout">
                                    <i class="fa-solid fa-right-from-bracket"></i> ĐĂNG XUẤT
                                </a>
                            <?php else: ?>
                                <a href="#" class="nav-link fw-bold" style="color: #FFB800;" data-bs-toggle="modal" data-bs-target="#loginModal">
                                    <i class="fa-solid fa-right-to-bracket"></i> ĐĂNG NHẬP / ĐĂNG KÝ
                                </a>
                            <?php endif; ?>
                        </li>
                    <?php endif; ?>
                    
                </ul>
            </div>

            <!-- NHÓM ICON TÀI KHOẢN VÀ THÔNG BÁO (ĐÃ TRẢ LẠI VỊ TRÍ GỐC: TÀI KHOẢN TRÁI, CHUÔNG PHẢI) -->
            <div class="d-flex align-items-center gap-4">
                
                <!-- 1. KHU VỰC TÀI KHOẢN CHÍNH -->
                <?php if (isset($_SESSION['user'])): ?>
                    <?php if ($user_role === 'Quản trị viên'): ?>
                        <div class="dropdown d-none d-lg-flex align-items-center">
                            <a href="#" class="text-white text-decoration-none dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false" style="height: 40px;">
                                <i class="fa-solid fa-user-circle" style="font-size: 1.5rem;"></i>
                                <span class="fw-bold d-none d-md-inline" style="line-height: 1;"><?= htmlspecialchars($_SESSION['user']['HoTen']) ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3" style="border-radius: 12px; min-width: 160px;">
                                <li><a class="dropdown-item text-danger fw-bold py-2" href="index.php?controller=auth&action=logout"><i class="fa-solid fa-right-from-bracket me-2"></i>Đăng xuất</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <div class="dropdown d-none d-lg-flex align-items-center">
                            <a href="#" class="text-white text-decoration-none dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false" style="height: 40px;">
                                <i class="fa-solid fa-user-circle" style="font-size: 1.5rem;"></i>
                                <span class="fw-bold d-none d-md-inline" style="line-height: 1;"><?= htmlspecialchars($_SESSION['user']['HoTen']) ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3" style="border-radius: 12px; min-width: 200px;">
                                <li><a class="dropdown-item fw-bold text-success py-2" href="index.php?controller=profile"><i class="fa-solid fa-id-badge me-2"></i>Hồ sơ của tôi</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger fw-bold py-2" href="index.php?controller=auth&action=logout"><i class="fa-solid fa-right-from-bracket me-2"></i>Đăng xuất</a></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="#" class="text-white text-decoration-none user-dropdown-toggle d-none d-lg-flex align-items-center" data-bs-toggle="modal" data-bs-target="#loginModal" style="height: 40px;">
                        <i class="fa-solid fa-user" style="font-size: 1.35rem;"></i>
                    </a>
                <?php endif; ?>

                <!-- 2. KHU VỰC CHUÔNG THÔNG BÁO -->
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="dropdown d-flex align-items-center">
                        <a href="#" class="text-white text-decoration-none position-relative d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" style="height: 40px; padding: 0 5px;">
                            <i class="fa-solid fa-bell" style="font-size: 1.35rem;"></i>
                            <?php if($notif_count > 0): ?>
                                <span id="notifBadge" class="position-absolute translate-middle badge rounded-pill bg-danger border border-light" style="top: 8px; left: 85%; font-size: 0.65rem; padding: 0.25em 0.5em;">
                                    <?= $notif_count ?>
                                </span>
                            <?php endif; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 p-0" style="border-radius: 16px; width: 340px; overflow: hidden;">
                            <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light">
                                <h6 class="m-0 fw-bold" style="color: #0d5c2c;">Thông báo của bạn</h6>
                                <?php if($notif_count > 0): ?>
                                    <span id="notifMenuBadge" class="badge bg-danger rounded-pill"><?= $notif_count ?> MỚI</span>
                                <?php endif; ?>
                            </div>
                            <div class="notif-scroll" style="max-height: 320px; overflow-y: auto;">
                                <?php foreach ($notifications as $notif): ?>
                                    <a href="#" class="dropdown-item notif-item d-flex align-items-start py-3 border-bottom text-wrap" style="white-space: normal; transition: 0.2s;">
                                        <div class="me-3 mt-1 <?= $notif['color'] ?>">
                                            <i class="fa-solid <?= $notif['icon'] ?> fs-4"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.95rem;"><?= htmlspecialchars($notif['title']) ?></h6>
                                                <small class="text-secondary fw-bold" style="font-size: 0.7rem;"><?= $notif['time'] ?></small>
                                            </div>
                                            <p class="mb-0 text-muted" style="font-size: 0.85rem; line-height: 1.4;"><?= htmlspecialchars($notif['desc']) ?></p>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                            <div class="p-2 text-center bg-light">
                                <span class="notif-read-btn fw-bold" style="color: #0d5c2c; font-size: 0.9rem;" onclick="markNotificationsAsRead()">
                                    Đánh dấu đã đọc tất cả
                                </span>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="#" class="text-white text-decoration-none position-relative d-flex align-items-center" style="height: 40px; padding: 0 5px;" onclick="return requireLoginPopup(event, 'xem các thông báo mới nhất')">
                        <i class="fa-solid fa-bell" style="font-size: 1.35rem;"></i>
                    </a>
                <?php endif; ?>

            </div>
        </nav>
    </div>
    
    <script>
    const IS_LOGGED_IN = <?= isset($_SESSION['user']) ? 'true' : 'false' ?>;

    // AJAX Xử lý Đánh dấu đã đọc
    function markNotificationsAsRead() {
        fetch(window.location.href, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'ajax_action=mark_notif_read'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Ẩn dấu chấm đỏ và nhãn đếm đi
                let badge = document.getElementById('notifBadge');
                let menuBadge = document.getElementById('notifMenuBadge');
                if (badge) badge.style.display = 'none';
                if (menuBadge) menuBadge.style.display = 'none';
            }
        });
    }

    // Modal Yêu cầu đăng nhập
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