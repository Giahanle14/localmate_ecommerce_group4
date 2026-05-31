<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
<style>
    .breadcrumb-custom { 
        padding: 15px 40px; 
        font-weight: 500; 
        color: #0d5c2c; 
        background: white; 
        border-bottom: 1px solid #eee; 
    }
    .page-title { 
        font-family: 'Quicksand', sans-serif !important; 
        font-weight: 700; 
        font-size: 2.2rem;
    }
    
    .section-heading { 
        font-family: 'Quicksand', sans-serif !important; 
        font-weight: 700; 
        font-size: 1.8rem;
    }    
    /* CSS cho các tiêu đề phần gợi ý & ưu đãi */
    .section-heading { 
        font-family: 'Quicksand', sans-serif !important; 
        font-weight: 700; 
        font-size: 1.8rem;
    }
    /* KHUNG SLIDER & NÚT BẤM */
    .tour-slider-section {
        background: #ffffff;
        border: 1px solid #00712D;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        padding: 30px;
        position: relative;
        margin-bottom: 50px;
    }
    .tour-slider-wrapper {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        scroll-behavior: smooth;
        scrollbar-width: none; /* Ẩn thanh cuộn cho Firefox */
        padding: 10px 5px; /* Tạo khoảng trống để không bị cắt bóng của card */
    }
    .tour-slider-wrapper::-webkit-scrollbar {
        display: none; /* Ẩn thanh cuộn cho Chrome/Safari */
    }
    /* Ép kích thước card để hiển thị 3 cái rưỡi (tạo hiệu ứng có phần tử phía sau) */
    /* Đoạn CSS MỚI: Ép chính xác hiển thị 3 tour */
    .tour-slider-wrapper .tour-card-v2 {
        /* Lấy 100% chiều rộng trừ đi 2 khoảng trống 20px (tổng 40px) rồi chia 3 */
        flex: 0 0 calc((100% - 40px) / 3);
        margin-bottom: 0; 
    }
    
    /* Giao diện Tablet: Hiển thị 2 tour */
    @media (max-width: 992px) {
        .tour-slider-wrapper .tour-card-v2 { 
            flex: 0 0 calc((100% - 20px) / 2); 
        }
    }
    
    /* Giao diện Mobile: Hiển thị 1 tour */
    @media (max-width: 576px) {
        .tour-slider-wrapper .tour-card-v2 { 
            flex: 0 0 100%; 
        }
    }
    .slider-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        background: #fff;
        border: 1px solid #00712D;
        color: #00712D;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        cursor: pointer;
        z-index: 10;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .slider-arrow:hover { background: #00712D; color: #fff; }
    .slider-arrow.prev { left: -20px; }
    .slider-arrow.next { right: -20px; }
    /* KHU VỰC ƯU ĐÃI NỔI BẬT (NỀN ĐỎ FLASH SALE) */
    .promo-highlight-section {
        background: linear-gradient(135deg, #E31837 0%, #B30B1F 100%);
        border-radius: 20px;
        padding: 30px;
        margin-top: 50px;
        margin-bottom: 50px;
        position: relative;
        box-shadow: 0 10px 30px rgba(227, 24, 55, 0.25);
    }
    .promo-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        color: white;
    }
    .promo-title-wrap h4 {
        font-family: 'Quicksand', sans-serif;
        font-weight: 800;
        font-size: 2.2rem;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .promo-subtitle {
        font-size: 1.05rem;
        opacity: 0.95;
        font-weight: 500;
    }
    .btn-view-more {
        background: transparent;
        color: white;
        border: 1px solid white;
        border-radius: 30px;
        padding: 8px 24px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: 0.3s;
    }
    .btn-view-more:hover {
        background: white;
        color: #E31837;
    }
    
    /* Ghi đè màu mũi tên trượt riêng cho nền đỏ */
    .promo-highlight-section .slider-arrow {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255,255,255,0.4);
        color: white;
    }
    .promo-highlight-section .slider-arrow:hover {
        background: white;
        color: #E31837;
    }
    .promo-highlight-section .tour-card-v2 {
        border: none !important; /* Xóa viền cam cũ để hợp với nền đỏ */
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }
    /* KHU VỰC TOUR GỢI Ý (NỀN VÀNG CAM) */
    .suggested-highlight-section {
        background: linear-gradient(135deg, #F9A826 0%, #E67E22 100%);
        border-radius: 20px;
        padding: 30px;
        margin-top: 20px;
        margin-bottom: 50px;
        position: relative;
        box-shadow: 0 10px 30px rgba(230, 126, 34, 0.25);
    }
    
    /* Ghi đè màu mũi tên trượt riêng cho nền vàng */
    .suggested-highlight-section .slider-arrow {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255,255,255,0.5);
        color: white;
    }
    .suggested-highlight-section .slider-arrow:hover {
        background: white;
        color: #E67E22;
    }
    .suggested-highlight-section .tour-card-v2 {
        border: none !important;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }
</style>
<div class="breadcrumb-custom">
    <a href="index.php?controller=home" style="text-decoration: none; color: inherit;">Trang chủ</a> > Chuyến đi của tôi
</div>

<main class="container" style="padding-top: 40px; padding-bottom: 80px;">
<ul class="nav nav-pills custom-nav-pills justify-content-center" id="mytripTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#chuahoanthanh" type="button">
                Chưa hoàn thành
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#dahoanthanh" type="button">
                Đã hoàn thành
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#dahuy" type="button">
                Đã hủy
            </button>
        </li>
    </ul>

    <div class="tab-content" id="mytripTabsContent">

        <div class="tab-pane fade show active" id="chuahoanthanh">
            <div class="booked-trips-grid">
                <?php if (count($rs_chua_hoan_thanh) > 0): ?>
                    <?php foreach ($rs_chua_hoan_thanh as $row): ?>
    <div class="booked-trip-card">
        <div class="btc-img-wrap">
            <img src="<?= htmlspecialchars($row['HinhAnh']) ?>" class="cover-img" alt="Tour Cover">
        </div>
        <div class="btc-body">
            <div class="btc-location"><i class="fa-solid fa-location-dot text-danger"></i> <?= htmlspecialchars($row['DiaDiem'] ?? 'Đang cập nhật') ?></div>
            
            <div class="btc-title"><?= htmlspecialchars($row['TenTour']) ?></div>
            <div class="btc-details">
                <div class="btc-col" style="border-right: 1px solid #ddd; padding-right: 15px;">
                    <h6> Thời gian </h6>
                    <div class="btc-text"><span>Bắt đầu:</span> <span><?= date('d/m/Y', strtotime($row['NgayBatDau'])) ?></span></div>
                    <div class="btc-text"><span> Kết thúc: </span> <span><?= date('d/m/Y', strtotime($row['NgayKetThuc'])) ?></span></div>
                </div>
                <div class="btc-col" style="padding-left: 15px;">
                    <h6> Tổng phí <span class="float-end btc-text price"><?= number_format($row['TongGiaTien'], 0, ',', '.') ?> đ</span></h6>
                    <div style="font-size: 11px; color: #00712D; text-align: right; margin-bottom: 10px;"><i class="fa-solid fa-circle-check"></i> Đã thanh toán</div>
                    <h6> Số lượng <span class="float-end" style="font-weight:normal; font-size:14px;"><?= $row['SoLuongKhach'] ?> x Người lớn <i class="fa-solid fa-user-group"></i></span></h6>
                </div>
            </div>
            <div class="btc-status-row">
                <div class="btc-status status-wait"> Trạng thái: Chưa hoàn thành </div>
                <button class="btn-action-green" onclick="window.location.href='index.php?controller=tripdetail&id=<?= $row['MaChuyenDi'] ?>'"> Chi tiết </button>
            </div>
        </div>
    </div>
<?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-muted w-100 mt-4" style="grid-column: span 2;">Bạn không có chuyến đi nào đang chờ khởi hành.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="tab-pane fade" id="dahoanthanh">
            <div class="booked-trips-grid">
                <?php if (count($rs_da_hoan_thanh) > 0): ?>
                    <?php foreach ($rs_da_hoan_thanh as $row): ?>
                        <div class="booked-trip-card">
                            <div class="btc-img-wrap">
                                <img src="<?= htmlspecialchars($row['HinhAnh']) ?>" class="cover-img" alt="Tour Cover">
                            </div>
                            <div class="btc-body">
                                <div class="btc-location-row">
                                    <div class="btc-location"><i class="fa-solid fa-location-dot text-danger"></i> <?= htmlspecialchars($row['DiaDiem'] ?? 'Việt Nam') ?></div>
                                </div>
                                <div class="btc-title"><?= htmlspecialchars($row['TenTour']) ?></div>
                                <div class="btc-details">
                                    <div class="btc-col" style="border-right: 1px solid #ddd; padding-right: 15px;">
                                        <h6> Thời gian </h6>
                                        <div class="btc-text"><span>Bắt đầu:</span> <span><?= date('d/m/Y', strtotime($row['NgayBatDau'])) ?></span></div>
                                        <div class="btc-text"><span> Kết thúc: </span> <span><?= date('d/m/Y', strtotime($row['NgayKetThuc'])) ?></span></div>
                                    </div>
                                    <div class="btc-col" style="padding-left: 15px;">
                                        <h6> Tổng phí <span class="float-end btc-text price"><?= number_format($row['TongGiaTien'], 0, ',', '.') ?> đ</span></h6>
                                        <div style="font-size: 11px; color: #00712D; text-align: right; margin-bottom: 10px;"><i class="fa-solid fa-circle-check"></i> Đã thanh toán</div>
                                        <h6> Số lượng <span class="float-end" style="font-weight:normal; font-size:14px;"><?= $row['SoLuongKhach'] ?> x Người lớn <i class="fa-solid fa-user-group"></i></span></h6>
                                    </div>
                                </div>
                                <div class="btc-status-row">
                                    <div class="btc-status status-done">Trạng thái: Đã hoàn thành</div>
    
                                    <?php if (empty($row['MaDG'])): ?>
                                        <div class="d-flex gap-2">
                                            <button class="btn-action-green" onclick="window.location.href='index.php?controller=tripdetail&id=<?= $row['MaChuyenDi'] ?>'">Chi tiết</button>
                                            <button class="btn-action-orange" onclick="window.location.href='index.php?controller=review&action=create&id=<?= $row['MaChuyenDi'] ?>'">Đánh giá</button>
                                        </div>
                                    <?php else: ?>
                                        <div class="d-flex align-items-center gap-2">
                                            <span style="font-size: 14px; font-weight: 700; color: #f39c12;"><i class="fa-solid fa-star"></i> <?= $row['SoSao'] ?>/5</span>
                                            <button class="btn-action-green" onclick="window.location.href='index.php?controller=tripdetail&id=<?= $row['MaChuyenDi'] ?>'">Chi tiết</button>
            
                                            <button class="btn-action-green" style="background-color: white; color: #00712D; border: 1px solid #00712D;" onclick="window.location.href='index.php?controller=review&action=edit&id=<?= $row['MaChuyenDi'] ?>'">Xem lại</button>
                                        </div>
                                        <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-muted w-100 mt-4" style="grid-column: span 2;">Bạn chưa hoàn thành chuyến đi nào.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="tab-pane fade" id="dahuy">
    <div class="booked-trips-grid">
        <?php if (count($rs_da_huy) > 0): ?>
            <?php foreach ($rs_da_huy as $row): ?>
                <div class="booked-trip-card" style="opacity: 0.8;">
                    <div class="btc-img-wrap">
                        <img src="<?= htmlspecialchars($row['HinhAnh']) ?>" class="cover-img" alt="Tour Cover">
                    </div>
                    <div class="btc-body">
                        <div class="btc-location-row">
                            <div class="btc-location"><i class="fa-solid fa-location-dot text-danger"></i> <?= htmlspecialchars($row['DiaDiem'] ?? 'Đang cập nhật') ?></div>
                        </div>
                        <div class="btc-title"><?= htmlspecialchars($row['TenTour']) ?></div>
                        <div class="btc-details">
                            <div class="btc-col" style="border-right: 1px solid #ddd; padding-right: 15px;">
                                <h6> Thời gian </h6>
                                <div class="btc-text"><span>Bắt đầu:</span> <span><?= date('d/m/Y', strtotime($row['NgayBatDau'])) ?></span></div>
                                <div class="btc-text"><span> Kết thúc: </span> <span><?= date('d/m/Y', strtotime($row['NgayKetThuc'])) ?></span></div>
                            </div>
                            <div class="btc-col" style="padding-left: 15px;">
                                <h6> Tổng phí <span class="float-end btc-text price"><?= number_format($row['TongGiaTien'], 0, ',', '.') ?> đ</span></h6>
                                <div style="font-size: 11px; color: #dc3545; text-align: right; margin-bottom: 10px;"><i class="fa-solid fa-circle-xmark"></i> Đã hủy</div>
                                <h6> Số lượng <span class="float-end" style="font-weight:normal; font-size:14px;"><?= $row['SoLuongKhach'] ?> x Người lớn <i class="fa-solid fa-user-group"></i></span></h6>
                            </div>
                        </div>
                        <div class="btc-status-row">
                            <div class="btc-status text-danger fw-bold"><i class="fa-solid fa-ban"></i> Trạng thái: Đã hủy</div>
                                <button class="btn btn-outline-secondary btn-sm" style="border-radius: 20px; font-weight: 600; padding: 5px 15px;" onclick="window.location.href='index.php?controller=tripdetail&id=<?= $row['MaChuyenDi'] ?>'">Chi tiết</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted w-100 mt-4" style="grid-column: span 2;">Bạn không có chuyến đi nào đã hủy.</p>
        <?php endif; ?>
    </div>
</div>
    </div>

    <hr class="mt-5 mb-5" style="opacity: 0.1;">

    <div class="suggested-highlight-section">
        <div class="promo-header row">
            <div class="promo-title-wrap col-md-9 mb-3 mb-md-0">
                <h4><i class="fa-solid fa-earth-americas" style="color: #00712D;"></i> Các tour có thể bạn quan tâm</h4>
                <div class="promo-subtitle">Những hành trình được chọn lọc riêng dựa trên lịch sử chuyến đi của bạn.</div>
            </div>
            <div class="col-md-3 text-md-end">
                <a href="index.php?controller=tour" class="btn-view-more">Xem tất cả <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>

        <div style="position: relative;">
            <button class="slider-arrow prev" onclick="scrollSlider('suggested-slider', -1)"><i class="fa-solid fa-chevron-left"></i></button>
            
            <div class="tour-slider-wrapper" id="suggested-slider">
                <?php foreach ($rs_goi_y as $tour): ?>
                    <?php 
                        $giaGoc = $tour['Gia']; $giaThucTe = $giaGoc;
                        $coUuDai = !empty($tour['UuDai']) && $tour['UuDai'] > 0;
                        if ($coUuDai) $giaThucTe = $giaGoc * (1 - $tour['UuDai']);
                    ?>
                    <div class="tour-card-v2">
                        <div class="tour-card-img-wrap">
                            <img src="<?= htmlspecialchars($tour['HinhAnh']) ?>" class="cover-img" alt="Tour">
                            <div class="tour-price-badge">
                                <?php if ($coUuDai): ?>
                                    <span style="text-decoration: line-through; font-size: 0.75rem; color: #c3e6cb; margin-right: 5px;"><?= number_format($giaGoc, 0, ',', '.') ?>đ</span>
                                <?php endif; ?>
                                <?= number_format($giaThucTe, 0, ',', '.') ?> VNĐ
                            </div>
                        </div>
                        <div class="tour-card-body">
                            <div class="tour-meta-top">
                                <span class="tour-location"><i class="fa-solid fa-location-dot text-danger"></i> <?= htmlspecialchars($tour['DiaDiem'] ?? 'Toàn Quốc') ?></span>
                                <span class="tour-likes"><i class="fa-solid fa-heart text-danger opacity-75"></i> <?= $tour['SoLuotThich'] ?? 0 ?></span>
                            </div>
                            <h5 class="tour-title"><?= htmlspecialchars($tour['TenTour']) ?></h5>
                            <div class="tour-meta-mid">
                                <span><i class="fa-solid fa-user-group"></i> Tối đa <?= $tour['SoKhachToiDa'] ?> người</span>
                                <span class="ms-3"><i class="fa-regular fa-clock"></i> <?= $tour['SoNgay'] ?> ngày</span>
                            </div>
                            <p class="tour-desc"><?= mb_substr($tour['MoTa'], 0, 70) ?>...</p>
                            <div class="tour-meta-bottom">
                                <span class="tour-rating"><i class="fa-solid fa-star" style="color: #FF9F00;"></i> <?= ($tour['TrungBinhSao'] > 0) ? $tour['TrungBinhSao'] : 'Chưa có' ?> <?php if ($tour['SoLuotDanhGia'] > 0) echo "(" . $tour['SoLuotDanhGia'] . ")"; ?></span>
                                <button class="btn-detail-outline" onclick="window.location.href='index.php?controller=tripdetail&id=<?= $tour['MaChuyenDi'] ?>'">Chi tiết</button>                    
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <button class="slider-arrow next" onclick="scrollSlider('suggested-slider', 1)"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
    </div>

    <div class="promo-highlight-section">
        <div class="promo-header row">
            <div class="promo-title-wrap col-md-9 mb-3 mb-md-0">
                <h4><i class="fa-solid fa-bolt" style="color: #FFD700;"></i> Ưu đãi giờ chót</h4>
                <div class="promo-subtitle">Khám phá thế giới, trải nghiệm trọn vẹn với mức giá tối ưu nhất trong ngày.</div>
            </div>
            <div class="col-md-3 text-md-end">
                <a href="index.php?controller=tour" class="btn-view-more">Xem thêm <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>

        <div style="position: relative;">
            <button class="slider-arrow prev" onclick="scrollSlider('promo-slider', -1)"><i class="fa-solid fa-chevron-left"></i></button>
            
            <div class="tour-slider-wrapper" id="promo-slider">
                <?php foreach ($rs_uu_dai as $tour): ?>
                    <div class="tour-card-v2">
                        <div class="tour-card-img-wrap">
                            <img src="<?= htmlspecialchars($tour['HinhAnh']) ?>" alt="<?= htmlspecialchars($tour['TenTour']) ?>">
                            <?php if (!empty($tour['UuDai']) && $tour['UuDai'] > 0): ?>
                                <?php 
                                    $gia_goc = $tour['Gia']; 
                                    $ti_le_giam = $tour['UuDai']; 
                                    $gia_da_giam = $gia_goc * (1 - $ti_le_giam); 
                                ?>
                                <div class="tour-price-badge" style="background:#d35400;">
                                    <span style="text-decoration: line-through; font-size: 12px; color: #ffbc80; margin-right: 5px;"><?= number_format($gia_goc, 0, ',', '.') ?>đ</span>
                                    <span style="font-weight: bold;"><?= number_format($gia_da_giam, 0, ',', '.') ?>đ</span>
                                </div>
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2 px-2 py-1 fs-6">-<?= $ti_le_giam * 100 ?>%</span>
                            <?php else: ?>
                                <div class="tour-price-badge" style="background:#d35400;"><?= number_format($tour['Gia'], 0, ',', '.') ?> VNĐ</div>
                            <?php endif; ?>
                        </div>
                        <div class="tour-card-body">
                            <div class="tour-meta-top">
                                <span class="tour-location"><i class="fa-solid fa-location-dot text-danger"></i> <?= htmlspecialchars($tour['DiaDiem'] ?? 'Đang cập nhật') ?></span>
                                <span class="tour-likes"><i class="fa-solid fa-heart text-danger opacity-75"></i> <?= $tour['SoLuotThich'] ?? 0 ?></span>
                            </div>
                            <h5 class="tour-title"><?= htmlspecialchars($tour['TenTour']) ?></h5>
                            <div class="tour-meta-mid">
                                <span><i class="fa-solid fa-user-group"></i> Tối đa <?= $tour['SoKhachToiDa'] ?> người</span>
                                <span class="ms-3"><i class="fa-regular fa-clock"></i> <?= $tour['SoNgay'] ?> ngày</span>
                            </div>
                            <p class="tour-desc"><?= mb_substr($tour['MoTa'], 0, 70) ?>...</p>
                            <div class="tour-meta-bottom">
                                <span class="tour-rating"><i class="fa-solid fa-star" style="color: #FF9F00;"></i> <?= ($tour['TrungBinhSao'] > 0) ? $tour['TrungBinhSao'] : 'Chưa có' ?> <?php if ($tour['SoLuotDanhGia'] > 0) echo "(" . $tour['SoLuotDanhGia'] . ")"; ?></span>
                                <button class="btn-detail-outline" onclick="window.location.href='index.php?controller=tripdetail&id=<?= $tour['MaChuyenDi'] ?>'">Chi tiết</button>
                            </div>button class="
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <button class="slider-arrow next" onclick="scrollSlider('promo-slider', 1)"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
    </div>

    <!-- Script Javascript xử lý việc cuộn thanh trượt (Đặt trước thẻ đóng main hoặc body) -->
    <script>
        function scrollSlider(sliderId, direction) {
            const slider = document.getElementById(sliderId);
            // Lấy chiều rộng của 1 card + khoảng cách (gap)
            const cardElement = slider.querySelector('.tour-card-v2');
            if(cardElement) {
                const scrollAmount = cardElement.offsetWidth + 20; 
                slider.scrollLeft += direction * scrollAmount;
            }
        }
    </script>