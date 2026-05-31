<?php 
    // Xử lý giá và ưu đãi
    $giaGoc = $tour['Gia'];
    $uuDai = $tour['UuDai'] ?? 0;
    $coUuDai = ($uuDai > 0);
    $giaDaGiam = $coUuDai ? $giaGoc * (1 - $uuDai) : $giaGoc;

    // Xử lý icon trái tim (Ở trang yêu thích thì mặc định đã thích, ở trang khám phá thì check IsLiked)
    $isLiked = isset($tour['IsLiked']) ? ($tour['IsLiked'] > 0) : true;

    // Xử lý link chi tiết linh hoạt theo trang đang đứng
    $detailLink = "?controller=tourdetail&id=" . urlencode($tour['MaTour']);
    if (isset($_GET['controller']) && $_GET['controller'] === 'favorite') {
        $detailLink .= "&from=favorite";
    } elseif (!empty($_GET['date'])) {
        $detailLink .= "&date=" . urlencode($_GET['date']);
    }
?>

<div class="card tour-card border-0 d-flex flex-column h-100">
    <div class="tour-img-wrapper">
        <?php if ($coUuDai): ?>
            <?php $phan_tram_giam = $uuDai * 100; ?>
            <span class="price-badge" style="background:#d35400;">
                <span style="text-decoration: line-through; font-size: 12px; color: #ffbc80; margin-right: 5px;">
                    <?= number_format($giaGoc, 0, ',', '.') ?>đ
                </span>
                <span style="font-weight: bold;">
                    <?= number_format($giaDaGiam, 0, ',', '.') ?>đ
                </span>
            </span>
            <span class="badge bg-danger position-absolute top-0 start-0 m-2 px-2 py-1 fs-6" style="z-index: 2;">
                -<?= $phan_tram_giam ?>%
            </span>
        <?php else: ?>
            <span class="price-badge"><?= number_format($giaGoc, 0, ',', '.') ?> VND</span>
        <?php endif; ?>
        <img src="<?= htmlspecialchars($tour['HinhAnh']) ?>" alt="Tour Image">
    </div>
    
    <div class="tour-card-body bg-white">
        <div class="text-danger small mb-1 fw-bold text-uppercase">
            <i class="fa-solid fa-location-dot me-1"></i> <?= htmlspecialchars($tour['DiaDiem'] ?? 'Đang cập nhật') ?>
        </div>
        
        <h5 class="tour-title" title="<?= htmlspecialchars($tour['TenTour']) ?>">
            <?= htmlspecialchars($tour['TenTour']) ?>
        </h5>
        
        <div class="d-flex text-muted small mb-3 gap-3 fw-semibold">
             <span><i class="fa-solid fa-user-group text-warning me-1"></i> Tối đa <?= $tour['SoKhachToiDa'] ?> người</span>
             <span><i class="fa-regular fa-clock text-warning me-1"></i> <?= $tour['SoNgay'] ?> ngày</span>
        </div>
        
        <p class="text-muted small" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; flex-grow: 1; margin-bottom: 0;">
            <?= htmlspecialchars($tour['MoTa']) ?>
        </p>
        
        <hr class="hr-dashed">
        
        <div class="d-flex justify-content-between align-items-center mt-auto">
            <div class="text-warning fw-bold fs-6">
                <i class="fa-solid fa-star"></i> 
                <?= $tour['SaoTrungBinh'] ? round($tour['SaoTrungBinh'], 1) : '0.0' ?>
                <span class="text-muted fw-normal small ms-1">(<?= $tour['SoDanhGia'] ?? 0 ?>)</span>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <span class="heart-btn text-muted" onclick="toggleHeart(this, '<?= $tour['MaTour'] ?>')">
                    <i class="<?= $isLiked ? 'fa-solid' : 'fa-regular' ?> fa-heart text-danger fs-5 align-middle"></i> 
                    <span class="like-count align-middle fw-semibold"><?= $tour['SoLuotThich'] ?? 0 ?></span>
                </span>
                <a href="<?= $detailLink ?>" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold">Chi tiết</a>
            </div>
        </div>
    </div>
</div>