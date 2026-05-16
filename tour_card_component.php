<div class="col-md-4">
    <div class="card tour-card border-0">
        <div class="tour-img-wrapper">
            <img src="<?php echo htmlspecialchars($tour['HinhAnh']); ?>" alt="Tour Image">
            <span class="price-badge"><?php echo number_format($tour['Gia'], 0, ',', '.'); ?> VND</span>
        </div>
        <div class="tour-card-body bg-white">
            <div class="text-danger small mb-1 fw-bold text-uppercase"><i class="fa-solid fa-location-dot me-1"></i> <?php echo htmlspecialchars($tour['VungDiaLy']); ?></div>
            <h5 class="tour-title"><?php echo htmlspecialchars($tour['TenTour']); ?></h5>
            
            <div class="d-flex text-muted small mb-3 gap-3">
                <span><i class="fa-solid fa-user-group text-warning me-1"></i> Tối đa <?php echo $tour['SoKhachToiDa']; ?> người</span>
                <span><i class="fa-regular fa-clock text-warning me-1"></i> <?php echo $tour['SoNgay']; ?> ngày</span>
            </div>
            
            <p class="text-muted small" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?php echo htmlspecialchars($tour['MoTa']); ?></p>
            
            <hr class="hr-dashed">
            
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-warning fw-bold fs-6">
                    <i class="fa-solid fa-star"></i> 
                    <?php echo $tour['SaoTrungBinh'] ? round($tour['SaoTrungBinh'], 1) : '0'; ?>
                    <span class="text-muted fw-normal small ms-1">(<?php echo $tour['SoDanhGia']; ?>)</span>
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    <span class="heart-btn text-muted" onclick="toggleHeart(this, '<?php echo $tour['MaTour']; ?>')">
                        <i class="<?php echo ($tour['IsLiked'] > 0) ? 'fa-solid' : 'fa-regular'; ?> fa-heart text-danger fs-5 align-middle"></i> 
                        <span class="like-count align-middle"><?php echo $tour['SoLuotThich']; ?></span>
                    </span>
                    <a href="#" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold">Chi tiết</a>
                </div>
            </div>
        </div>
    </div>
</div>