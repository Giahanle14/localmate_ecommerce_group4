<?php include 'app/views/layouts/header.php'; ?>

<main class="container" style="padding-top: 40px; padding-bottom: 80px;">
    <h2 class="page-title">Chuyến đi của tôi</h2>

    <ul class="nav nav-pills custom-nav-pills" id="mytripTabs" role="tablist">
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
    </ul>

    <div class="tab-content" id="mytripTabsContent">
        
        <div class="tab-pane fade show active" id="chuahoanthanh">
            <div class="booked-trips-grid">
                <?php if (count($rs_chua_hoan_thanh) > 0): ?>
                    <?php foreach ($rs_chua_hoan_thanh as $row): ?>
                    <div class="booked-trip-card">
                        <div class="btc-img-wrap">
                            <img src="https://images.unsplash.com/photo-1596422846543-74c6fc1e01b1" class="cover-img" alt="Tour Cover">
                        </div>
                        <div class="btc-body">
                            <div class="btc-location-row">
                                <div class="btc-location"><i class="fa-solid fa-location-dot text-danger"></i> <?= htmlspecialchars($row['VungDiaLy'] ?? 'Việt Nam') ?></div>
                            </div>
                            <div class="btc-title"><?= htmlspecialchars($row['TenTour']) ?></div>
                            <div class="btc-details">
                                <div class="btc-col" style="border-right: 1px solid #ddd; padding-right: 15px;">
                                    <h6>Thời gian</h6>
                                    <div class="btc-text"><span>Bắt đầu:</span> <span><?= date('d/m/Y', strtotime($row['NgayBatDau'])) ?></span></div>
                                    <div class="btc-text"><span>Kết thúc:</span> <span><?= date('d/m/Y', strtotime($row['NgayKetThuc'])) ?></span></div>
                                </div>
                                <div class="btc-col" style="padding-left: 15px;">
                                    <h6>Tổng phí <span class="float-end btc-text price"><?= number_format($row['TongGiaTien'], 0, ',', '.') ?> đ</span></h6>
                                    <div style="font-size: 11px; color: #00712D; text-align: right; margin-bottom: 10px;"><i class="fa-solid fa-circle-check"></i> Đã thanh toán</div>
                                    <h6>Số lượng <span class="float-end" style="font-weight:normal; font-size:14px;"><?= $row['SoLuongKhach'] ?>x Người lớn <i class="fa-solid fa-user-group"></i></span></h6>
                                </div>
                            </div>
                            <div class="btc-status-row">
                                <div class="btc-status status-wait">Trạng thái: Chưa hoàn thành</div>
                                <button class="btn-action-green">Chi tiết</button>
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
                            <img src="https://images.unsplash.com/photo-1559592413-7cec4d0cae2b" class="cover-img" alt="Tour Cover">
                        </div>
                        <div class="btc-body">
                            <div class="btc-location-row">
                                <div class="btc-location"><i class="fa-solid fa-location-dot text-danger"></i> <?= htmlspecialchars($row['VungDiaLy'] ?? 'Việt Nam') ?></div>
                            </div>
                            <div class="btc-title"><?= htmlspecialchars($row['TenTour']) ?></div>
                            <div class="btc-details">
                                <div class="btc-col" style="border-right: 1px solid #ddd; padding-right: 15px;">
                                    <h6>Thời gian</h6>
                                    <div class="btc-text"><span>Bắt đầu:</span> <span><?= date('d/m/Y', strtotime($row['NgayBatDau'])) ?></span></div>
                                    <div class="btc-text"><span>Kết thúc:</span> <span><?= date('d/m/Y', strtotime($row['NgayKetThuc'])) ?></span></div>
                                </div>
                                <div class="btc-col" style="padding-left: 15px;">
                                    <h6>Tổng phí <span class="float-end btc-text price"><?= number_format($row['TongGiaTien'], 0, ',', '.') ?> đ</span></h6>
                                    <div style="font-size: 11px; color: #00712D; text-align: right; margin-bottom: 10px;"><i class="fa-solid fa-circle-check"></i> Đã thanh toán</div>
                                    <h6>Số lượng <span class="float-end" style="font-weight:normal; font-size:14px;"><?= $row['SoLuongKhach'] ?>x Người lớn <i class="fa-solid fa-user-group"></i></span></h6>
                                </div>
                            </div>
                            <div class="btc-status-row">
                                <div class="btc-status status-done">Trạng thái: Đã hoàn thành</div>
                                <button class="btn-action-orange" onclick="window.location.href='index.php?controller=rate&action=create&id=<?= $row['MaChuyenDi'] ?>'">Đánh giá</button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-muted w-100 mt-4" style="grid-column: span 2;">Bạn chưa hoàn thành chuyến đi nào.</p>
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
                <img src="https://images.unsplash.com/photo-1583417319070-4a69db38a482" alt="Tour">
                <div class="tour-price-badge"><?= number_format($tour['Gia'], 0, ',', '.') ?> VNĐ</div>
            </div>
            <div class="tour-card-body">
                <div class="tour-meta-top">
                    <span class="tour-location"><i class="fa-solid fa-location-dot text-danger"></i> <?= htmlspecialchars($tour['VungDiaLy'] ?? 'Toàn Quốc') ?></span>
                    <span class="tour-likes"><i class="fa-solid fa-heart text-danger opacity-75"></i> <?= rand(30, 200) ?></span>
                </div>
                <h5 class="tour-title"><?= htmlspecialchars($tour['TenTour']) ?></h5>
                <div class="tour-meta-mid">
                    <span><i class="fa-solid fa-user-group"></i> Tối đa <?= $tour['SoKhachToiDa'] ?> người</span>
                    <span class="ms-3"><i class="fa-regular fa-clock"></i> <?= $tour['SoNgay'] ?> ngày</span>
                </div>
                <p class="tour-desc"><?= mb_substr($tour['MoTa'], 0, 70) ?>...</p>
                <div class="tour-meta-bottom">
                    <span class="tour-rating"><i class="fa-solid fa-star"></i> 4.9 (110)</span>
                    <button class="btn-detail-outline">Chi tiết</button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <h4 class="section-heading">Ưu đãi không thể bỏ lỡ 🔥</h4>
    <div class="tour-grid">
        <?php foreach ($rs_uu_dai as $tour): ?>
        <div class="tour-card-v2" style="border: 2px solid #f39c12;">
            <div class="tour-card-img-wrap">
                <img src="https://images.unsplash.com/photo-1540206395-68808572332f" alt="Tour">
                <div class="tour-price-badge" style="background:#d35400;"><?= number_format($tour['Gia'], 0, ',', '.') ?> VNĐ</div>
                <span class="badge bg-danger position-absolute top-0 start-0 m-2 px-2 py-1 fs-6">Giảm giá sốc</span>
            </div>
            <div class="tour-card-body">
                <div class="tour-meta-top">
                    <span class="tour-location"><i class="fa-solid fa-location-dot text-danger"></i> <?= htmlspecialchars($tour['VungDiaLy'] ?? 'Toàn Quốc') ?></span>
                    <span class="tour-likes"><i class="fa-solid fa-heart text-danger opacity-75"></i> <?= rand(50, 300) ?></span>
                </div>
                <h5 class="tour-title"><?= htmlspecialchars($tour['TenTour']) ?></h5>
                <div class="tour-meta-mid">
                    <span><i class="fa-solid fa-user-group"></i> Tối đa <?= $tour['SoKhachToiDa'] ?> người</span>
                    <span class="ms-3"><i class="fa-regular fa-clock"></i> <?= $tour['SoNgay'] ?> ngày</span>
                </div>
                <p class="tour-desc"><?= mb_substr($tour['MoTa'], 0, 70) ?>...</p>
                <div class="tour-meta-bottom">
                    <span class="tour-rating"><i class="fa-solid fa-star"></i> 5.0 (95)</span>
                    <button class="btn-detail-outline">Chi tiết</button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include 'app/views/layouts/footer.php'; ?>