<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
<style>
    /* CSS cho tiêu đề chính */
    .page-title { 
        font-family: 'Quicksand', sans-serif !important; 
        font-weight: 700; 
        font-size: 2.2rem;
    }
    
    /* CSS cho các tiêu đề phần gợi ý & ưu đãi */
    .section-heading { 
        font-family: 'Quicksand', sans-serif !important; 
        font-weight: 700; 
        font-size: 1.8rem;
    }
</style>
<main class="container" style="padding-top: 40px; padding-bottom: 80px;">
<h2 class="page-title text-center mb-4">Chuyến đi của tôi</h2>
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
                <button class="btn-action-green"> Chi tiết </button>
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
                                        <button class="btn-action-orange" onclick="window.location.href='index.php?controller=review&action=create&id=<?= $row['MaChuyenDi'] ?>'">Đánh giá</button>
                                    <?php else: ?>
                                        <div class="d-flex align-items-center gap-2">
                                            <span style="font-size: 13px; font-weight: 700; color: #f39c12;"><i class="fa-solid fa-star"></i> <?= $row['SoSao'] ?>/5</span>
                                            <button class="btn btn-sm btn-outline-success" style="border-radius: 20px; font-weight: 600; font-size: 12px; padding: 5px 15px;" 
        onclick="window.location.href='index.php?controller=review&action=edit&id=<?= $row['MaChuyenDi'] ?>'">
    Xem lại
</button>
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
                            <button class="btn btn-outline-secondary btn-sm" style="border-radius: 20px; font-weight: 600; padding: 5px 15px;">Chi tiết</button>
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

    <h4 class="section-heading">Các tour có thể bạn quan tâm 🌍</h4>
    <div class="tour-grid">
        <?php foreach ($rs_goi_y as $tour): ?>
            <div class="tour-card-v2">
                <div class="tour-card-img-wrap">
                    <img src="<?= htmlspecialchars($tour['HinhAnh']) ?>" class="cover-img" alt="Tour">
                    <div class="tour-price-badge"><?= number_format($tour['Gia'], 0, ',', '.') ?> VNĐ</div>
                </div>
                <div class="tour-card-body">
                    <div class="tour-meta-top">
                        <span class="tour-location"><i class="fa-solid fa-location-dot text-danger"></i> <?= htmlspecialchars($tour['DiaDiem'] ?? 'Toàn Quốc') ?></span>
                        <span class="tour-likes"><i class="fa-solid fa-heart text-danger opacity-75"></i> <?= rand(30, 200) ?></span>
                    </div>
                    <h5 class="tour-title"><?= htmlspecialchars($tour['TenTour']) ?></h5>
                    <div class="tour-meta-mid">
                        <span><i class="fa-solid fa-user-group"></i> Tối đa <?= $tour['SoKhachToiDa'] ?> người </span>
                        <span class="ms-3"><i class="fa-regular fa-clock"></i> <?= $tour['SoNgay'] ?> ngày</span>
                    </div>
                    <p class="tour-desc"><?= mb_substr($tour['MoTa'], 0, 70) ?>...</p>
                    <div class="tour-meta-bottom">
                        <span class="tour-rating"><i class="fa-solid fa-star"></i> 4.9 (110)</span>
                    <button class="btn-detail-outline" onclick="window.location.href='index.php?controller=tourdetail&id=<?= $tour['MaTour'] ?>'"> Chi tiết </button>                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <h4 class="section-heading">Ưu đãi không thể bỏ lỡ 🔥</h4>
<div class="tour-grid">
    <?php foreach ($rs_uu_dai as $tour): ?>
        <div class="tour-card-v2" style="border: 2px solid #f39c12;">
            <div class="tour-card-img-wrap">
                <img src="<?= htmlspecialchars($tour['HinhAnh']) ?>" alt="<?= htmlspecialchars($tour['TenTour']) ?>">
                
                <?php if (!empty($tour['UuDai']) && $tour['UuDai'] > 0): ?>
                    <?php 
                        $gia_goc = $tour['Gia'];
                        $ti_le_giam = $tour['UuDai']; 
                        $phan_tram_giam = $ti_le_giam * 100; 
                        $gia_da_giam = $gia_goc * (1 - $ti_le_giam); 
                    ?>
                    
                    <div class="tour-price-badge" style="background:#d35400;">
                        <span style="text-decoration: line-through; font-size: 12px; color: #ffbc80; margin-right: 5px;">
                            <?= number_format($gia_goc, 0, ',', '.') ?>đ
                        </span>
                        <span style="font-weight: bold;">
                            <?= number_format($gia_da_giam, 0, ',', '.') ?>đ
                        </span>
                    </div>
                    
                    <span class="badge bg-danger position-absolute top-0 start-0 m-2 px-2 py-1 fs-6">
                        -<?= $phan_tram_giam ?>%
                    </span>

                <?php else: ?>
                    <div class="tour-price-badge" style="background:#d35400;">
                        <?= number_format($tour['Gia'], 0, ',', '.') ?> VNĐ
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="tour-card-body">
                <div class="tour-meta-top">
                    <span class="tour-location"><i class="fa-solid fa-location-dot text-danger"></i> <?= htmlspecialchars($tour['DiaDiem'] ?? 'Đang cập nhật') ?></span>
                    <span class="tour-likes"><i class="fa-solid fa-heart text-danger opacity-75"></i> <?= rand(50, 300) ?></span>
                </div>
                <h5 class="tour-title"><?= htmlspecialchars($tour['TenTour']) ?></h5>
                <div class="tour-meta-mid">
                    <span><i class="fa-solid fa-user-group"></i> Tối đa <?= $tour['SoKhachToiDa'] ?> người </span>
                    <span class="ms-3"><i class="fa-regular fa-clock"></i> <?= $tour['SoNgay'] ?> ngày</span>
                </div>
                <p class="tour-desc"><?= mb_substr($tour['MoTa'], 0, 70) ?>...</p>
                <div class="tour-meta-bottom">
                    <span class="tour-rating"><i class="fa-solid fa-star"></i> 5.0 (95)</span>
                    <button class="btn-detail-outline" onclick="window.location.href='index.php?controller=tourdetail&id=<?= $tour['MaTour'] ?>'"> Chi tiết </button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>