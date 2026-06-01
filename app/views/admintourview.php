<?php require_once 'app/views/layouts/header.php'; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/vn.js"></script>

<style>
    body { background-color: #F8FAF5; font-family: 'Quicksand', sans-serif; }
    .admin-container { max-width: 1300px; margin: 40px auto; padding: 0 20px; }
    .admin-title { color: #0d5c2c; font-weight: 800; font-size: 28px; text-transform: uppercase; margin-bottom: 30px; display: inline-block; }

    /* ---------------------------------------------------
       2. THANH TÌM KIẾM MỚI & NÚT THÊM TOUR
       --------------------------------------------------- */
    .filter-wrapper { display: flex; justify-content: space-between; align-items: center; gap: 20px; margin-bottom: 40px; flex-wrap: wrap;}
    .filter-bar-v2 { background: white; border-radius: 50px; padding: 8px 8px 8px 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; align-items: center; flex-grow: 1; border: 1px solid #eee; min-width: 700px;}
    .filter-input-group { display: flex; align-items: center; padding-right: 15px; flex-grow: 1; }
    .filter-input-group.border-end { border-right: 1px solid #e0e0e0 !important; margin-right: 15px; }
    .filter-input-group i { color: #0d5c2c; margin-right: 12px; font-size: 1.1rem; }
    .filter-input-group input { border: none; outline: none; width: 100%; font-weight: 500; color: #444; background: transparent; }
    .filter-input-group input::placeholder { color: #999; }
    .btn-search-green { background: #0d5c2c; color: white; border-radius: 30px; padding: 10px 30px; font-weight: 700; border: none; transition: 0.2s; white-space: nowrap;}
    .btn-search-green:hover { background: #0a4722; }
    .btn-orange-pill { background-color: #F29A2E; color: white; border-radius: 30px; font-weight: 700; padding: 12px 25px; border: none; transition: 0.3s; white-space: nowrap; text-decoration: none; height: fit-content;}
    .btn-orange-pill:hover { background-color: #d18222; color: white; transform: translateY(-2px); }

    /* ---------------------------------------------------
       3. BỘ LỌC NÂNG CAO
       --------------------------------------------------- */
    .filter-icon-btn { background: transparent; border: none; color: #0d5c2c; font-size: 1.2rem; padding: 10px 15px; cursor: pointer; transition: 0.2s; border-radius: 50%; display: flex; align-items: center; justify-content: center;}
    .filter-icon-btn:hover, .filter-icon-btn[aria-expanded="true"] { background: #EAF9DE; }
    .filter-popup-menu { width: 320px; border-radius: 16px; padding: 25px; border: 1px solid #e0e0e0; box-shadow: 0 10px 30px rgba(0,0,0,0.08); margin-top: 15px !important; }
    .fp-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px;}
    .fp-title { color: #0d5c2c; font-weight: 800; font-size: 16px; margin: 0; display: flex; align-items: center; gap: 8px;}
    .fp-clear { color: #0d5c2c; font-weight: 600; font-size: 14px; text-decoration: none; transition: 0.2s; display: flex; align-items: center; gap: 5px; cursor: pointer;}
    .fp-clear:hover { color: #F29A2E; }
    .fp-group { margin-bottom: 18px; }
    .fp-label { display: block; font-weight: 700; color: #555; font-size: 13px; margin-bottom: 8px; }
    .fp-select { width: 100%; border: 1px solid #ddd; border-radius: 8px; padding: 10px 15px; color: #444; font-weight: 500; outline: none; cursor: pointer; appearance: none; background: url('data:image/svg+xml;utf8,<svg fill="%23666" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>') no-repeat right 10px center; background-color: white;}
    .fp-select:focus { border-color: #0d5c2c; }
    .btn-apply-filter { background: #0d5c2c; color: white; width: 100%; border-radius: 8px; font-weight: 700; padding: 10px; border: none; margin-top: 10px; transition: 0.2s;}
    .btn-apply-filter:hover { background: #0a4722; }

    /* ---------------------------------------------------
       4. CARD TOUR VÀ THÊM TOUR MỚI
       --------------------------------------------------- */
    .admin-tour-card { background: white; border-radius: 16px; overflow: hidden; border: 1px solid #f0f0f0; box-shadow: 0 4px 15px rgba(0,0,0,0.03); transition: 0.3s; position: relative; height: 100%; display: flex; flex-direction: column;}
    .admin-tour-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
    .atc-img-wrap { height: 200px; position: relative; }
    .atc-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
    .badge-discount { position: absolute; top: 15px; right: 15px; background: #E74C3C; color: white; font-weight: 800; font-size: 13px; padding: 5px 12px; border-radius: 20px; z-index: 10; box-shadow: 0 4px 10px rgba(231, 76, 60, 0.3); }
    
    .tour-actions-top { position: absolute; top: 0; left: 0; z-index: 20; display: flex; box-shadow: 2px 2px 10px rgba(0,0,0,0.1); border-bottom-right-radius: 16px; overflow: hidden;}
    .btn-action-top { color: white; padding: 10px 15px; font-size: 16px; transition: 0.2s; text-decoration: none; display: flex; align-items: center; justify-content: center;}
    .btn-action-edit { background: #0d5c2c; }
    .btn-action-edit:hover { background: #0a4722; color: white; }
    .btn-action-schedule { background: #F29A2E; }
    .btn-action-schedule:hover { background: #d18222; color: white; }
    
    .atc-body { padding: 20px; display: flex; flex-direction: column; flex-grow: 1; }
    .atc-title-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 5px; }
    .atc-title { font-weight: 800; color: #163C24; font-size: 18px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;}
    .atc-rating { color: #FFB800; font-weight: 700; font-size: 14px; white-space: nowrap; }
    .atc-location { color: #777; font-size: 13px; margin-bottom: 10px; }
    .tour-tags-row { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 20px; }
    .tour-tag { background: #F1F8E4; color: #4A7A3A; font-weight: 700; font-size: 11px; padding: 4px 10px; border-radius: 20px; display: flex; align-items: center; gap: 4px; }
    .atc-stats { display: flex; justify-content: space-between; align-items: flex-end; border-top: 1px solid #eee; padding-top: 15px; margin-top: auto; }
    .atc-stat-col { display: flex; flex-direction: column; }
    .atc-stat-label { font-size: 12px; color: #666; margin-bottom: 4px; }
    .atc-stat-val { font-weight: 800; color: #163C24; font-size: 16px; }
    .atc-stat-val-old { font-size: 12px; color: #999; text-decoration: line-through; margin-bottom: 2px; line-height: 1;}
    .atc-stat-val-new { font-weight: 800; color: #E74C3C; font-size: 16px; line-height: 1;}
    .add-new-card { border: 2px dashed #B4D6B5; background: #FAFAF5; display: flex; flex-direction: column; justify-content: center; align-items: center; color: #0d5c2c; cursor: pointer; text-decoration: none;}
    .add-new-card:hover { background: #EAF9DE; border-color: #0d5c2c; }
    .add-new-card i { font-size: 50px; margin-bottom: 15px; }
    .add-new-card span { font-weight: 800; font-size: 20px; }

    /* ---------------------------------------------------
       5. GIAO DIỆN FORM (Thêm/Sửa/Xem Chi Tiết)
       --------------------------------------------------- */
    .input-title-tour { color: #123C27; font-weight: 800; font-size: 36px; margin-bottom: 15px; border: none; background: transparent; width: 100%; outline: none; padding: 0; font-family: inherit; transition: 0.3s; }
    .input-title-tour::placeholder { color: #a0b0a5; }
    .input-title-tour:focus:not([disabled]) { border-bottom: 2px dashed #0d5c2c; padding-bottom: 5px; }
    .cover-upload-box { background: #EAECE8; border-radius: 16px; height: 350px; width: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; color: #666; cursor: pointer; position: relative; overflow: hidden; margin-bottom: 40px; transition: 0.3s;}
    .cover-upload-box:hover { background: #dfe1dc; }
    .cover-upload-box img { position: absolute; width: 100%; height: 100%; object-fit: cover; z-index: 1; display: none; }
    .cover-upload-content { position: relative; z-index: 2; text-align: center; }
    .cover-upload-content i { font-size: 35px; color: #0d5c2c; background: #EAF9DE; padding: 15px; border-radius: 50%; margin-bottom: 15px; }
    .cover-upload-content h5 { font-weight: 700; color: #333; margin-bottom: 5px; }
    .cover-upload-content p { font-size: 13px; color: #777; margin:0;}
    .form-label-bold { font-weight: 800; color: #0d5c2c; font-size: 16px; text-transform: uppercase; margin-bottom: 8px; display: block;}
    .admin-input { background: #F4F5F0; border: 1px solid transparent; border-radius: 8px; padding: 14px 18px; font-weight: 600; color: #333; transition: 0.3s; width: 100%; font-size: 15px; }
    .admin-input:focus:not([disabled]) { background: white; border-color: #0d5c2c; box-shadow: 0 0 0 3px rgba(13, 92, 44, 0.1); outline: none; }
    .admin-input:disabled { background: #EAECE8; color: #666; cursor: not-allowed; }
    .admin-textarea { background: #F4F5F0; border: none; border-radius: 8px; padding: 16px 18px; font-weight: 500; height: 140px; resize: none; width: 100%; font-size: 15px; }
    .admin-textarea:disabled { background: #EAECE8; color: #666; cursor: not-allowed; }
    .right-panel { background: #F4F5F0; border-radius: 20px; padding: 30px; border: none; }
    .gallery-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 25px; }
    .gallery-slot { background: #EAECE8; border-radius: 12px; aspect-ratio: 1/1; display: flex; justify-content: center; align-items: center; color: #999; font-size: 24px; cursor: pointer; transition: 0.2s; overflow: hidden; position: relative;}
    .gallery-slot:hover { background: #dfe1dc; color: #0d5c2c;}
    .gallery-slot img { width: 100%; height: 100%; object-fit: cover; }
    .btn-submit-orange { background: #F29A2E; color: #1a1a1a; border-radius: 8px; padding: 14px; font-weight: 800; font-size: 16px; border: none; width: 100%; transition: 0.3s; margin-bottom: 15px; text-transform: uppercase;}
    .btn-submit-orange:hover { background: #d18222; color: white; }
    .btn-outline-action { background: transparent; color: #0d5c2c; border: 1px solid #B4D6B5; border-radius: 8px; padding: 14px; font-weight: 800; font-size: 16px; width: 100%; transition: 0.3s; text-transform: uppercase;}
    .btn-outline-action:hover { background: #EAF9DE; }
    .btn-outline-green { background: white; color: #0d5c2c; border: 1px solid #0d5c2c; border-radius: 8px; padding: 14px; font-weight: 800; font-size: 16px; width: 100%; transition: 0.3s; text-align: center; display: block; text-decoration: none;}
    .btn-outline-green:hover { background: #0d5c2c; color: white; }
    /* =========================================================
       6. RESPONSIVE CHO TRANG QUẢN LÝ TOUR (MOBILE & TABLET)
       ========================================================= */
    @media (max-width: 768px) {
        .admin-container { padding: 0 10px; margin: 20px auto; }
        .admin-title { font-size: 22px; margin-bottom: 20px; }
        
        /* Chỉnh lại thanh bộ lọc & tìm kiếm */
        .filter-wrapper { flex-direction: column; align-items: stretch; gap: 15px; margin-bottom: 25px; }
        .filter-bar-v2 { min-width: 100%; flex-direction: column; padding: 15px; border-radius: 16px; gap: 10px; }
        .filter-input-group { border-right: none !important; margin-right: 0; padding-right: 0; width: 100%; border-bottom: 1px solid #eee; padding-bottom: 15px; }
        
        .filter-bar-v2 .dropdown { width: 100%; border-left: none !important; padding-left: 0 !important; margin-top: 5px;}
        .filter-icon-btn { width: 100%; border: 1px solid #0d5c2c; border-radius: 8px; justify-content: center; gap: 8px; }
        .filter-icon-btn::after { content: " Bộ lọc nâng cao"; font-size: 14px; font-weight: 600; font-family: 'Quicksand', sans-serif;}
        .filter-popup-menu { width: 100%; max-width: 320px; } /* Tránh menu lọc tràn viền */
        
        .btn-search-green { width: 100%; border-radius: 8px; padding: 12px; }
        .btn-orange-pill { width: 100%; display: flex; justify-content: center; align-items: center; border-radius: 8px; }

        /* Chỉnh lại giao diện Form Thêm/Sửa/Chi tiết */
        .input-title-tour { font-size: 22px; line-height: 1.4; }
        .cover-upload-box { height: 220px; margin-bottom: 25px; border-radius: 12px; }
        .cover-upload-content i { font-size: 28px; padding: 12px; margin-bottom: 10px; }
        .cover-upload-content h5 { font-size: 16px; }
        
        .right-panel { padding: 20px 15px; border-radius: 16px; }
        .admin-textarea { height: 120px; }
        .admin-textarea[name="lichTrinh"] { height: 200px; }
        
        .gallery-grid { gap: 10px; }
        .gallery-slot { border-radius: 8px; }
        
        .atc-img-wrap { height: 180px; }
        .btn-action-top { padding: 8px 12px; font-size: 14px; }
    }
</style>

<div class="breadcrumb-custom">
    <a href="index.php?controller=adminhome"><i class="fa-solid fa-house me-1"></i>Tổng quan</a> 
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <a href="index.php?controller=admintour">Quản lý tour</a>
    
    <?php if ($viewMode !== 'list'): ?>
        <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
        <span class="text-dark fw-bold">
            <?php 
                if($viewMode === 'edit') {
                    echo 'Chỉnh sửa tour: ' . htmlspecialchars($tourData['TenTour']);
                } elseif($viewMode === 'detail') {
                    echo htmlspecialchars($tourData['TenTour']);
                } else {
                    echo 'Thêm tour mới';
                }
            ?>
        </span>
    <?php endif; ?>
</div>

<div class="admin-container">

<?php if ($viewMode === 'list'): ?>
    
    <?php
        $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
        $vungQuery = isset($_GET['vung']) ? $_GET['vung'] : '';
        $traiNghiemQuery = isset($_GET['trainghiem']) ? $_GET['trainghiem'] : '';
        $giaQuery = isset($_GET['gia']) ? $_GET['gia'] : '';
    ?>

    <form action="index.php" method="GET" id="searchTourForm">
        <input type="hidden" name="controller" value="admintour">

        <div class="filter-wrapper">
            <div class="filter-bar-v2">
                <div class="filter-input-group" style="flex: 2;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" placeholder="Nhập tên tour, địa điểm, mã tour..." value="<?= htmlspecialchars($searchQuery) ?>">
                </div>
                
                <div class="dropdown me-2 border-start ps-3">
                    <button class="filter-icon-btn" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" title="Bộ lọc nâng cao">
                        <i class="fa-solid fa-sliders"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end filter-popup-menu">
                        <div class="fp-header">
                            <h5 class="fp-title"><i class="fa-solid fa-filter"></i> Bộ lọc tìm kiếm</h5>
                            <span class="fp-clear" onclick="clearFilters()"><i class="fa-solid fa-rotate-right"></i> Làm mới</span>
                        </div>
                        
                        <div class="fp-group">
                            <label class="fp-label">Vùng địa lý</label>
                            <select name="vung" id="filterVung" class="fp-select">
                                <option value="" <?= $vungQuery == '' ? 'selected' : '' ?>>-- Tất cả các vùng --</option>
                                <option value="Tây Bắc" <?= $vungQuery == 'Tây Bắc' ? 'selected' : '' ?>>Tây Bắc</option>
                                <option value="Đông Bắc" <?= $vungQuery == 'Đông Bắc' ? 'selected' : '' ?>>Đông Bắc</option>
                                <option value="Đồng bằng sông Hồng" <?= $vungQuery == 'Đồng bằng sông Hồng' ? 'selected' : '' ?>>Đồng bằng sông Hồng</option>
                                <option value="Bắc Trung Bộ" <?= $vungQuery == 'Bắc Trung Bộ' ? 'selected' : '' ?>>Bắc Trung Bộ</option>
                                <option value="Nam Trung Bộ" <?= $vungQuery == 'Nam Trung Bộ' ? 'selected' : '' ?>>Nam Trung Bộ</option>
                                <option value="Tây Nguyên" <?= $vungQuery == 'Tây Nguyên' ? 'selected' : '' ?>>Tây Nguyên</option>
                                <option value="Đông Nam Bộ" <?= $vungQuery == 'Đông Nam Bộ' ? 'selected' : '' ?>>Đông Nam Bộ</option>
                                <option value="Đồng bằng sông Cửu Long" <?= $vungQuery == 'Đồng bằng sông Cửu Long' ? 'selected' : '' ?>>Đồng bằng sông Cửu Long</option>
                            </select>
                        </div>

                        <div class="fp-group">
                            <label class="fp-label">Loại trải nghiệm</label>
                            <select name="trainghiem" id="filterTraiNghiem" class="fp-select">
                                <option value="" <?= $traiNghiemQuery == '' ? 'selected' : '' ?>>-- Tất cả trải nghiệm --</option>
                                <option value="Văn hóa" <?= $traiNghiemQuery == 'Văn hóa' ? 'selected' : '' ?>>Văn hóa</option>
                                <option value="Ẩm thực" <?= $traiNghiemQuery == 'Ẩm thực' ? 'selected' : '' ?>>Ẩm thực</option>
                                <option value="Rừng cây" <?= $traiNghiemQuery == 'Rừng cây' ? 'selected' : '' ?>>Rừng cây</option>
                                <option value="Chữa lành" <?= $traiNghiemQuery == 'Chữa lành' ? 'selected' : '' ?>>Chữa lành</option>
                                <option value="Núi non" <?= $traiNghiemQuery == 'Núi non' ? 'selected' : '' ?>>Núi non</option>
                                <option value="Tham quan" <?= $traiNghiemQuery == 'Tham quan' ? 'selected' : '' ?>>Tham quan</option>
                                <option value="Biển đảo" <?= $traiNghiemQuery == 'Biển đảo' ? 'selected' : '' ?>>Biển đảo</option>
                                <option value="Sông nước" <?= $traiNghiemQuery == 'Sông nước' ? 'selected' : '' ?>>Sông nước</option>
                            </select>
                        </div>
                        
                        <div class="fp-group">
                            <label class="fp-label">Khoảng giá</label>
                            <select name="gia" id="filterGia" class="fp-select">
                                <option value="" <?= $giaQuery == '' ? 'selected' : '' ?>>-- Mọi mức giá --</option>
                                <option value="duoi_1m" <?= $giaQuery == 'duoi_1m' ? 'selected' : '' ?>>Dưới 1.000.000 VNĐ</option>
                                <option value="1m_3m" <?= $giaQuery == '1m_3m' ? 'selected' : '' ?>>Từ 1.000.000 - 3.000.000 VNĐ</option>
                                <option value="tren_3m" <?= $giaQuery == 'tren_3m' ? 'selected' : '' ?>>Trên 3.000.000 VNĐ</option>
                            </select>
                        </div>
                        <button type="button" class="btn-apply-filter" onclick="applyFilters()">Áp dụng</button>
                    </div>
                </div>

                <button type="submit" class="btn-search-green">Tìm Kiếm</button>
            </div>
            
            <a href="index.php?controller=admintour&action=add" class="btn-orange-pill">
                <i class="fa-solid fa-plus me-2"></i>Thêm tour mới
            </a>
        </div>
    </form>

    <div class="row g-4">
        <?php 
        $tagIcons = [
            'Ẩm thực' => 'fa-utensils',
            'Văn hóa' => 'fa-masks-theater',
            'Tham quan' => 'fa-camera-retro',
            'Chữa lành' => 'fa-leaf',
            'Biển đảo' => 'fa-water',
            'Rừng cây' => 'fa-tree',
            'Núi non' => 'fa-mountain',
            'Sông nước' => 'fa-ship'
        ];
        foreach ($tours as $tour): 
            $giaGoc = $tour['Gia'];
            $uuDai = isset($tour['UuDai']) ? (float)$tour['UuDai'] : 0;
            $phanTram = 0;
            $giaGiam = $giaGoc;
            
            if ($uuDai > 0) {
                $phanTram = round($uuDai * 100);
                $giaGiam = $giaGoc * (1 - $uuDai);
            }
        ?>
            <div class="col-md-6 col-lg-4">
                <div class="admin-tour-card">
                    <div class="tour-actions-top">
                        <a href="index.php?controller=admintour&action=edit&id=<?= $tour['MaTour'] ?>" class="btn-action-top btn-action-edit" title="Chỉnh sửa Tour">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <a href="index.php?controller=adminschedule&search=<?= urlencode($tour['TenTour']) ?>" class="btn-action-top btn-action-schedule" title="Xem lịch khởi hành">
                            <i class="fa-solid fa-calendar-days"></i>
                        </a>
                    </div>
                    
                    <a href="index.php?controller=admintour&action=detail&id=<?= $tour['MaTour'] ?>" class="text-decoration-none text-dark d-flex flex-column h-100" style="position: relative; z-index: 10;">
                                           
                        <div class="atc-img-wrap">
                            <img src="<?= htmlspecialchars(!empty($tour['HinhAnh']) && strpos($tour['HinhAnh'], 'public/') === 0 ? $tour['HinhAnh'] : 'public/' . $tour['HinhAnh']) ?>" alt="<?= htmlspecialchars($tour['TenTour']) ?>">
                            
                            <?php if($uuDai > 0): ?>
                                <span class="badge-discount">-<?= $phanTram ?>%</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="atc-body">
                            <div class="atc-title-row">
                                <div class="atc-title"><?= htmlspecialchars($tour['TenTour']) ?></div>
                                <div class="atc-rating">
                                    <i class="fa-solid fa-star"></i> 
                                    <?= (!empty($tour['TrungBinhSao']) && $tour['TrungBinhSao'] > 0) ? number_format($tour['TrungBinhSao'], 1) : '0' ?> 
                                    <span style="color: #888; font-size: 0.9em;">(<?= $tour['SoLuotDanhGia'] ?? 0 ?>)</span>
                                </div>
                            </div>
                            <div class="atc-location"><i class="fa-solid fa-location-dot me-1" style="color:#E74C3C;"></i> <?= htmlspecialchars($tour['DiaDiem']) ?></div>
                            
                            <div class="tour-tags-row">
                                <?php 
                                    $tags = explode(',', $tour['LoaiTraiNghiem']);
                                    foreach($tags as $tag): 
                                        $tag = trim($tag);
                                        if(!$tag) continue;
                                        $icon = isset($tagIcons[$tag]) ? $tagIcons[$tag] : 'fa-check';
                                ?>
                                    <span class="tour-tag"><i class="fa-solid <?= $icon ?>"></i> <?= htmlspecialchars($tag) ?></span>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="atc-stats">
                                <div class="atc-stat-col">
                                    <span class="atc-stat-label">Giá</span>
                                    
                                    <?php if($uuDai > 0): ?>
                                        <span class="atc-stat-val-old"><?= number_format($giaGoc, 0, ',', '.') ?> VNĐ</span>
                                        <span class="atc-stat-val-new"><?= number_format($giaGiam, 0, ',', '.') ?> VNĐ</span>
                                    <?php else: ?>
                                        <span class="atc-stat-val"><?= number_format($giaGoc, 0, ',', '.') ?> VNĐ</span>
                                    <?php endif; ?>

                                </div>
                                <div class="atc-stat-col text-end">
                                    <span class="atc-stat-label">Khách đăng ký</span>
                                    <span class="atc-stat-val"><?= $tour['SoLuotDangKy'] ?>/<?= $tour['SoKhachToiDa'] ?></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if(empty($tours)): ?>
            <div class="col-12 text-center text-muted mt-5">
                <h5>Không tìm thấy tour nào phù hợp với bộ lọc.</h5>
            </div>
        <?php endif; ?>

        <div class="col-md-6 col-lg-4">
            <a href="index.php?controller=admintour&action=add" class="text-decoration-none h-100 d-block">
                <div class="admin-tour-card add-new-card h-100">
                    <i class="fa-solid fa-circle-plus"></i>
                    <span>Thêm tour mới</span>
                </div>
            </a>
        </div>
    </div>

<?php else: ?>
    <?php 
        $isEdit = ($viewMode === 'edit');
        $isDetail = ($viewMode === 'detail');
        $disabled = $isDetail ? 'disabled' : '';
        $actionUrl = $isEdit ? "index.php?controller=admintour&action=edit&id={$tourData['MaTour']}" : "index.php?controller=admintour&action=add";
    ?>

    <form action="<?= $actionUrl ?>" method="POST" enctype="multipart/form-data">

        <div class="mb-4 mt-2">
            <input type="text" name="tenTour" class="input-title-tour" placeholder="Nhập tên tour (VD: Khám phá Thác Bản Giốc)..." value="<?= ($isEdit || $isDetail) ? htmlspecialchars($tourData['TenTour']) : '' ?>" required <?= $disabled ?>>
        </div>
        
        <div class="cover-upload-box" <?= !$isDetail ? 'onclick="document.getElementById(\'coverImageInput\').click();"' : '' ?>>
            <?php if (($isEdit || $isDetail) && !empty($tourData['HinhAnh'])): ?>
                <img src="<?= strpos($tourData['HinhAnh'], 'public/') === 0 ? $tourData['HinhAnh'] : 'public/' . $tourData['HinhAnh'] ?>" id="coverPreview" style="display: block;">
                <?php if(!$isDetail): ?>
                    <div class="cover-upload-content" style="background: rgba(255,255,255,0.85); padding: 15px; border-radius: 12px; display: none;" id="coverOverlay">
                        <i class="fa-solid fa-camera-retro"></i>
                        <h5>Upload Cover Image</h5>
                        <p>Nhấp để thay đổi ảnh bìa toàn cảnh</p>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <img src="" id="coverPreview">
                <div class="cover-upload-content" id="coverOverlay">
                    <i class="fa-solid fa-camera-retro"></i>
                    <h5>Upload Cover Image</h5>
                    <p>Thêm bức ảnh phong cảnh tuyệt đẹp vào đây</p>
                </div>
            <?php endif; ?>
            <input type="file" name="coverImage" id="coverImageInput" accept="image/*" class="d-none" onchange="previewCover(this)">
        </div>

        <div class="row g-4 mb-5">
            <div class="col-lg-7 pe-lg-4">
                
                <div class="mb-4">
                    <label class="form-label-bold">ĐỊA ĐIỂM</label>
                    <div class="position-relative">
                        <i class="fa-solid fa-location-dot position-absolute" style="top: 16px; left: 18px; color: #333;"></i>
                        <input type="text" name="diaDiem" class="admin-input" style="padding-left: 45px;" placeholder="Huế, Việt Nam" value="<?= ($isEdit || $isDetail) ? htmlspecialchars($tourData['DiaDiem']) : '' ?>" required <?= $disabled ?>>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label-bold">MÔ TẢ CHUYẾN ĐI</label>
                    <textarea name="moTa" class="admin-textarea" placeholder="Nhập mô tả..." required <?= $disabled ?>><?= ($isEdit || $isDetail) ? htmlspecialchars($tourData['MoTa']) : '' ?></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label-bold">LỊCH TRÌNH</label>
                    <textarea name="lichTrinh" class="admin-textarea" style="height: 250px;" placeholder="Ngày 1 - 11:30 - Đến bến..." required <?= $disabled ?>><?= ($isEdit || $isDetail) ? htmlspecialchars($tourData['LichTrinh']) : '' ?></textarea>
                </div>

                <?php if ($isDetail): ?>
                <div class="mb-4 mt-5">
                    <label class="form-label-bold mb-3">
                        <i class="fa-solid fa-comments me-2" style="font-size: 1.2rem;"></i> ĐÁNH GIÁ TỪ KHÁCH HÀNG
                    </label>
                    
                    <?php if (!empty($danhGiaList)): ?>
                        <div class="d-flex flex-column gap-3" style="max-height: 500px; overflow-y: auto; padding-right: 5px;">
                            <?php foreach ($danhGiaList as $review): ?>
                                <div class="p-3 border rounded-3" style="background: white; border-color: #f0f0f0 !important; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="fw-bold" style="color: #123C27;">
                                            <i class="fa-solid fa-circle-user text-success me-1"></i> 
                                            <?= htmlspecialchars($review['TenKhachHang']) ?>
                                        </div>
                                        <div class="text-warning fw-bold">
                                            <?= $review['SoSao'] ?> <i class="fa-solid fa-star"></i>
                                        </div>
                                    </div>
                                    <div class="text-muted small mb-2">
                                        <i class="fa-regular fa-clock me-1"></i> <?= date('d/m/Y', strtotime($review['NgayDanhGia'])) ?>
                                    </div>
                                    <p class="mb-2" style="font-size: 14px; color: #444; line-height: 1.6;">
                                        <?= nl2br(htmlspecialchars($review['NoiDung'])) ?>
                                    </p>
                                    
                                    <?php if (!empty($review['HinhAnh'])): ?>
                                        <div class="d-flex gap-2 mt-3 overflow-auto pb-2">
                                            <?php 
                                                $images = explode('||', $review['HinhAnh']);
                                                foreach ($images as $img): 
                                                    $imgPath = trim($img);
                                                    if (!empty($imgPath)):
                                            ?>
                                                <img src="<?= htmlspecialchars($imgPath) ?>" style="width: 65px; height: 65px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; flex-shrink: 0;">
                                            <?php 
                                                    endif;
                                                endforeach; 
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="p-4 text-center border rounded-3" style="background: #FAFAF5; color: #888; border-style: dashed !important;">
                            <i class="fa-regular fa-face-frown-open fs-2 mb-2" style="opacity: 0.5;"></i><br>
                            Chưa có đánh giá nào cho chuyến đi này.
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-5">
                <div class="right-panel">
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <label class="form-label-bold">GIÁ (VNĐ)</label>
                            <div class="position-relative">
                                <span class="position-absolute" style="top: 15px; left: 18px; color: #333; font-weight: 700;">đ</span>
                                <input type="text" name="gia" class="admin-input" style="padding-left: 40px;" value="<?= ($isEdit || $isDetail) ? number_format($tourData['Gia'], 0, ',', '.') : '' ?>" required oninput="formatCurrency(this)" <?= $disabled ?>>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label-bold">SỐ NGÀY</label>
                            <div class="position-relative">
                                <input type="number" name="soNgay" class="admin-input text-center" value="<?= ($isEdit || $isDetail) ? $tourData['SoNgay'] : '1' ?>" required <?= $disabled ?>>
                                <span class="position-absolute" style="top: 15px; right: 18px; color: #333; font-weight: 700;">Days</span>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <label class="form-label-bold">ƯU ĐÃI (%)</label>
                            <div class="position-relative">
                                <input type="number" name="uuDai" class="admin-input" placeholder="0" value="<?= ($isEdit || $isDetail) && isset($tourData['UuDai']) ? floatval($tourData['UuDai']) * 100 : '' ?>" <?= $disabled ?>>
                                <span class="position-absolute" style="top: 15px; right: 18px; color: #333; font-weight: 700;">%</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label-bold">KHÁCH TỐI ĐA</label>
                            <div class="position-relative">
                                <i class="fa-solid fa-users position-absolute" style="top: 16px; left: 18px; color: #333;"></i>
                                <input type="number" name="soKhachToiDa" class="admin-input text-center" value="<?= ($isEdit || $isDetail) ? $tourData['SoKhachToiDa'] : '10' ?>" required <?= $disabled ?>>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-bold">VÙNG ĐỊA LÝ</label>
                        <select name="vungDiaLy" class="admin-input" style="cursor: pointer;" <?= $disabled ?>>
                            <?php 
                                $vungMien = ['Tây Bắc', 'Đông Bắc', 'Đồng bằng sông Hồng', 'Bắc Trung Bộ', 'Nam Trung Bộ', 'Tây Nguyên', 'Đông Nam Bộ', 'Đồng bằng sông Cửu Long'];
                                $currentVung = ($isEdit || $isDetail) ? $tourData['VungDiaLy'] : 'Đông Nam Bộ';
                                foreach ($vungMien as $vung) {
                                    $sel = ($vung == $currentVung) ? 'selected' : '';
                                    echo "<option value=\"$vung\" $sel>$vung</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <label class="form-label-bold mt-2">ẢNH MINH HỌA CHUYẾN ĐI</label>
                    <div class="gallery-grid">
                        <?php for($i = 1; $i <= 4; $i++): ?>
                            <label class="gallery-slot" for="gallery-input-<?= $i ?>">
                                <i class="fa-solid fa-plus" id="gallery-icon-<?= $i ?>" style="color: #999;"></i>
                                <img id="gallery-preview-<?= $i ?>" src="" style="display:none; position:absolute; top:0; left:0; width:100%; height:100%; object-fit:cover;">
                                <?php if(!$isDetail): ?>
                                    <input type="file" name="gallery[]" id="gallery-input-<?= $i ?>" accept="image/*" style="display:none;" onchange="previewGallery(this, <?= $i ?>)">
                                <?php endif; ?>
                            </label>
                        <?php endfor; ?>
                    </div>

                    <?php if ($isDetail): ?>
                        <a href="index.php?controller=admintour&action=edit&id=<?= $tourData['MaTour'] ?>" class="btn btn-submit-orange d-block text-center text-decoration-none">
                            Chỉnh sửa chuyến đi <i class="fa-solid fa-pen ms-2"></i>
                        </a>
                        <a href="index.php?controller=admintour" class="btn btn-outline-action d-block text-center text-decoration-none">
                            Quay lại danh sách
                        </a>
                    <?php elseif ($isEdit): ?>
                        <button type="submit" class="btn-submit-orange">Lưu sửa đổi <i class="fa-solid fa-arrow-right ms-2"></i></button>
                        <a href="index.php?controller=admintour&action=delete&id=<?= $tourData['MaTour'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa Tour này?');" class="btn-outline-green">Xóa chuyến đi</a>
                    <?php else: ?>
                        <button type="submit" class="btn-submit-orange">Tạo chuyến đi <i class="fa-solid fa-arrow-right ms-2"></i></button>
                        <button type="button" class="btn-outline-action" onclick="window.location.href='index.php?controller=admintour'">Lưu bản nháp</button>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </form>
<?php endif; ?>

</div>

<script>
    function clearFilters() {
        window.location.href = 'index.php?controller=admintour';
    }

    function applyFilters() {
        const dropdown = bootstrap.Dropdown.getInstance(document.querySelector('.filter-icon-btn'));
        if(dropdown) dropdown.hide();
        document.getElementById('searchTourForm').submit();
    }

    function previewCover(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var img = document.getElementById('coverPreview');
                img.src = e.target.result;
                img.style.display = 'block';
                
                var box = document.querySelector('.cover-upload-box');
                box.style.border = 'none';
                
                var overlay = document.getElementById('coverOverlay');
                if(overlay) overlay.style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewGallery(input, index) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.getElementById('gallery-preview-' + index);
                img.src = e.target.result;
                img.style.display = 'block';
                var icon = document.getElementById('gallery-icon-' + index);
                if(icon) icon.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    const coverBox = document.querySelector('.cover-upload-box');
    if (coverBox && coverBox.hasAttribute('onclick')) {
        coverBox.addEventListener('mouseenter', function() {
            if (document.getElementById('coverPreview').src !== "") {
                const overlay = document.getElementById('coverOverlay');
                if(overlay) overlay.style.display = 'block';
            }
        });
        coverBox.addEventListener('mouseleave', function() {
            if (document.getElementById('coverPreview').src !== "" && document.getElementById('coverPreview').style.display !== 'none') {
                const overlay = document.getElementById('coverOverlay');
                if(overlay) overlay.style.display = 'none';
            }
        });
    }

    function formatCurrency(input) {
        let val = input.value.replace(/\D/g, '');
        if(val !== '') {
            input.value = parseInt(val, 10).toLocaleString('en-US');
        }
    }
</script>

<?php require_once 'app/views/layouts/footer.php'; ?>