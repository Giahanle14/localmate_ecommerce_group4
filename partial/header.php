<?php 
    // Lấy tên file hiện tại để xử lý active menu
    $current_page = basename($_SERVER['PHP_SELF']); 
?>
<style>
    .lm-header {
        background-color: #0d5c2c;
        padding: 10px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
    }
    .lm-logo { display: flex; align-items: center; text-decoration: none; color: white; }
    .lm-logo img { height: 45px; margin-right: 10px; }
    .lm-nav { display: flex; gap: 10px; }
    .lm-nav a {
        color: white; text-decoration: none; font-weight: bold; font-size: 14px;
        padding: 8px 16px; border-radius: 8px; display: flex; align-items: center; gap: 8px;
        transition: 0.3s;
    }
    .lm-nav a:hover { background-color: rgba(255,255,255,0.2); }
    .lm-nav a.active { background-color: #fff9e6; color: #0d5c2c; }
    .lm-actions { display: flex; gap: 20px; align-items: center; color: white; font-size: 18px; }
    .lm-actions .notification { position: relative; cursor: pointer; }
    .lm-actions .badge {
        position: absolute; top: -5px; right: -8px; background: #f39c12; 
        color: white; font-size: 10px; padding: 2px 5px; border-radius: 50%;
    }
</style>

<header class="lm-header">
    <a href="trangchu.php" class="lm-logo">
        <img src="image/logo.png" alt="LocalMate"> </a>
    
    <nav class="lm-nav">
        <a href="trangchu.php" class="<?= ($current_page == 'trangchu.php') ? 'active' : '' ?>"><i class="fa-solid fa-house"></i> TRANG CHỦ</a>
        <a href="about.php" class="<?= ($current_page == 'about.php') ? 'active' : '' ?>"><i class="fa-solid fa-hat-leaf"></i> VỀ LOCALMATE</a>
        <a href="Explorepage.php" class="<?= ($current_page == 'explore_controller.php') ? 'active' : '' ?>"><i class="fa-solid fa-suitcase"></i> TOUR</a>
        <a href="BookingTour.php" class="<?= ($current_page == 'BookingTour.php') ? 'active' : '' ?>"><i class="fa-solid fa-location-dot"></i> CHUYẾN ĐI CỦA TÔI</a>
        <a href="wishlist.php" class="<?= ($current_page == 'wishlist.php') ? 'active' : '' ?>"><i class="fa-solid fa-heart"></i> YÊU THÍCH</a>
    </nav>

    <div class="lm-actions">
        <a href="Profilepage.php" style="color:white;"><i class="fa-solid fa-user"></i></a>
        <div class="notification">
            <i class="fa-solid fa-bell"></i>
            <span class="badge">3</span>
        </div>
    </div>
</header>