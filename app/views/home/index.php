<?php require_once 'app/views/layouts/header.php'; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/vn.js"></script>

<style>
    /* ========================================================
       CSS DÀNH RIÊNG CHO CARD TOUR TRANG CHỦ
       ======================================================== */
    .tour-new-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #eaeaea;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }
    .tour-new-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    }
    .tour-new-img-wrap {
        position: relative;
        height: 220px;
        width: 100%;
    }
    .tour-new-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .badge-discount {
        position: absolute;
        top: 12px;
        left: 12px;
        background-color: #E74C3C;
        color: white;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 5px 12px;
        border-radius: 6px;
        z-index: 2;
    }
    .badge-price {
        position: absolute;
        top: 12px;
        right: 12px;
        color: white;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 6px;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .badge-price.normal-price {
        background-color: #167A3B; 
        font-size: 0.95rem;
    }
    .badge-price.discount-price {
        background-color: #E67E22; 
    }
    .badge-price .old-price {
        text-decoration: line-through;
        font-size: 0.75rem;
        opacity: 0.8;
        font-weight: 500;
    }
    .badge-price .new-price {
        font-size: 0.95rem;
    }

    .tour-new-body {
        padding: 16px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .tour-meta-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        font-size: 0.85rem;
    }
    .tour-location-text {
        color: #777;
        font-weight: 600;
        text-transform: uppercase;
    }
    .tour-location-text i {
        color: #D32F2F;
        margin-right: 4px;
    }
    .tour-heart {
        color: #777;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .tour-heart i.fa-solid { color: #E74C3C; } 
    
    .tour-new-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #167A3B;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .tour-pax-time {
        color: #E67E22;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 12px;
        display: flex;
        gap: 15px;
    }
    .tour-pax-time i { margin-right: 5px; }
    .tour-new-desc {
        color: #777;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex-grow: 1;
    }
    .tour-new-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #f0f0f0;
        padding-top: 12px;
    }
    .tour-rating-stars {
        color: #333;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .tour-rating-stars i {
        color: #F1C40F;
        margin-right: 5px;
    }
    .btn-chi-tiet {
        background-color: #fff;
        color: #167A3B;
        border: 1px solid #167A3B;
        border-radius: 6px;
        padding: 5px 15px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: 0.2s;
    }
    .btn-chi-tiet:hover {
        background-color: #167A3B;
        color: #fff;
    }
</style>

<section class="hero-section position-relative p-0">
    <div id="homeBannerCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3500">
        <div class="carousel-indicators">
            <?php for($i = 0; $i < 6; $i++): ?>
                <button type="button" data-bs-target="#homeBannerCarousel" data-bs-slide-to="<?= $i ?>" class="<?= $i == 0 ? 'active' : '' ?>" aria-current="<?= $i == 0 ? 'true' : 'false' ?>"></button>
            <?php endfor; ?>
        </div>
        
        <div class="carousel-inner">
            <?php for($i = 1; $i <= 6; $i++): ?>
                <div class="carousel-item <?= $i == 1 ? 'active' : '' ?>">
                    <img src="public/image/banner/Banner_LocalMate_<?= $i ?>.png" class="d-block w-100" alt="Banner LocalMate <?= $i ?>" style="height: 500px; object-fit: cover; object-position: center;">
                    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, transparent 60%, rgba(0,0,0,0.4) 100%); pointer-events: none;"></div>
                </div>
            <?php endfor; ?>
        </div>
        
        <button class="carousel-control-prev" type="button" data-bs-target="#homeBannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#homeBannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<div class="search-bar-wrapper" style="position: relative; z-index: 10; margin-top: -15px; padding-bottom: 20px;">
    <div class="container">
        <div class="search-container shadow-lg" style="border-radius: 50px; background: white;">
            <form id="searchForm" action="index.php" method="GET" class="d-flex align-items-center flex-nowrap w-100 bg-white" style="border-radius: 50px;">
                <input type="hidden" name="controller" value="tour">
                <div class="search-input-group position-relative">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="destination" name="search" placeholder="Bạn muốn đi đâu ?" class="form-control border-0 shadow-none bg-transparent">
                    <div id="destError" class="error-tooltip d-none">
                        Bạn phải nhập thông tin này <i class="fa-solid fa-circle-exclamation text-danger ms-2"></i>
                    </div>
                </div>
                <div class="search-input-group">
                    <i class="fa-regular fa-calendar"></i>
                    <input type="text" id="datePicker" name="date" placeholder="Thời gian" class="form-control border-0 shadow-none bg-transparent" readonly style="cursor: pointer; background-color: transparent !important;">
                </div>
                <div class="search-input-group border-end-0 position-relative" id="guestDropdownWrapper">
                    <i class="fa-solid fa-user-group"></i>
                    <input type="text" id="guestInput" name="guests" placeholder="Số lượng khách" value="1 Người lớn" class="form-control border-0 shadow-none bg-transparent" readonly style="cursor: pointer;">
                    <i class="fa-solid fa-chevron-down ms-2" id="guestIcon" style="font-size: 0.8rem; cursor: pointer;"></i>

                    <div id="guestPopup" class="guest-popup d-none shadow">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="fw-bold text-dark"><i class="fa-solid fa-user-tie me-2" style="color: var(--color-primary-dark)"></i>Người lớn</div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-circle-minus text-muted guest-btn" onclick="updateGuest('adult', -1)"></i>
                                <span id="adultCount" class="fw-bold px-2 bg-light rounded" style="font-size: 1.1rem; min-width: 25px; text-align: center;">1</span>
                                <i class="fa-solid fa-circle-plus guest-btn" style="color: var(--color-primary-dark)" onclick="updateGuest('adult', 1)"></i>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="fw-bold text-dark"><i class="fa-solid fa-baby me-2" style="color: var(--color-primary-dark)"></i>Trẻ em</div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-circle-minus text-muted guest-btn" onclick="updateGuest('child', -1)"></i>
                                <span id="childCount" class="fw-bold px-2 bg-light rounded" style="font-size: 1.1rem; min-width: 25px; text-align: center;">0</span>
                                <i class="fa-solid fa-circle-plus guest-btn" style="color: var(--color-primary-dark)" onclick="updateGuest('child', 1)"></i>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-sm px-3 fw-bold" style="background-color: var(--color-primary-light); color: var(--color-primary-dark); border: 1px solid var(--color-primary);" onclick="toggleGuestPopup()">Xong</button>
                        </div>
                    </div>
                </div>
                <div class="px-2 py-1">
                    <button type="submit" class="btn btn-search text-white rounded-pill px-4">Tìm Kiếm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container mt-5 mb-5 pb-2">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <h3 class="section-title">Tour Trải Nghiệm Nổi Bật <i class="fa-solid fa-fire text-warning" style="font-size: 1.2rem;"></i></h3>
        <a href="index.php?controller=tour&sort=moi_nhat" class="view-more">Xem thêm <i class="fa-solid fa-angle-right ms-1"></i></a>
    </div>
<<<<<<< HEAD
<<<<<<< HEAD

=======
>>>>>>> dc02dda3b25d0ce58ade747657d6bf8bd69ef6cb
=======

>>>>>>> fe6d93f9adc736ba760c7c7881473756fc788b53
    <div class="row g-4">
        <?php if(!empty($toursNoiBat)): ?>
            <?php foreach($toursNoiBat as $tour): ?>
                <?php 
                    $giaGoc = $tour['Gia'];
                    $uuDai = $tour['UuDai'] ?? 0;
                    $coUuDai = ($uuDai > 0);
                    $giaDaGiam = $coUuDai ? $giaGoc * (1 - $uuDai) : $giaGoc;
                    $phanTramGiam = $coUuDai ? round($uuDai * 100) : 0;
                    $locationText = !empty($tour['DiaDiem']) ? htmlspecialchars($tour['DiaDiem']) : htmlspecialchars($tour['VungDiaLy']);
                ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="tour-new-card">
                        <div class="tour-new-img-wrap">
                            <?php if($coUuDai): ?>
                                <span class="badge-discount">-<?= $phanTramGiam ?>%</span>
                                <div class="badge-price discount-price">
                                    <span class="old-price"><?= number_format($giaGoc, 0, ',', '.') ?>đ</span>
                                    <span class="new-price"><?= number_format($giaDaGiam, 0, ',', '.') ?>đ</span>
                                </div>
                            <?php else: ?>
                                <div class="badge-price normal-price">
                                    <?= number_format($giaGoc, 0, ',', '.') ?> VNĐ
                                </div>
                            <?php endif; ?>
                            
                            <img src="<?= htmlspecialchars($tour['HinhAnh']) ?>" alt="<?= htmlspecialchars($tour['TenTour']) ?>">
                        </div>
<<<<<<< HEAD
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                            <div class="tour-location mb-0 pe-2 border-end">
<<<<<<< HEAD
                                <i class="fa-solid fa-location-dot text-danger"></i> <?= htmlspecialchars($tour['VungDiaLy']) ?>
                            </div>
=======
    <i class="fa-solid fa-location-dot text-danger"></i> <?= htmlspecialchars($tour['DiaDiem'] ?? 'Đang cập nhật') ?>
</div>
>>>>>>> dc02dda3b25d0ce58ade747657d6bf8bd69ef6cb
                            <div class="tour-tags mb-0">
                                <?php 
                                if(!empty($tour['LoaiTraiNghiem'])):
                                    $tags = explode(',', $tour['LoaiTraiNghiem']);
                                    foreach($tags as $tag): 
                                        $tag = trim($tag);
                                        if($tag != ''):
                                ?>
                                    <span class="tour-tag-item"><?= htmlspecialchars($tag) ?></span>
                                <?php 
                                        endif; 
                                    endforeach; 
                                endif; 
                                ?>
=======
                        
                        <div class="tour-new-body">
                            <div class="tour-meta-top">
                                <span class="tour-location-text"><i class="fa-solid fa-location-dot"></i> <?= $locationText ?></span>
                                <span class="tour-heart" onclick="toggleHeartHome(this, '<?= $tour['MaTour'] ?>')">
                                    <i class="<?= ($tour['IsLiked'] > 0) ? 'fa-solid' : 'fa-regular' ?> fa-heart fs-6"></i> 
                                    <span class="like-count"><?= $tour['SoLuotThich'] ?></span>
                                </span>
                            </div>
                            
                            <h3 class="tour-new-title"><?= htmlspecialchars($tour['TenTour']) ?></h3>
                            
                            <div class="tour-pax-time">
                                <span><i class="fa-solid fa-user-group"></i> Tối đa <?= $tour['SoKhachToiDa'] ?> người</span>
                                <span><i class="fa-regular fa-clock"></i> <?= $tour['SoNgay'] ?> ngày</span>
                            </div>
                            
                            <p class="tour-new-desc"><?= htmlspecialchars($tour['MoTa']) ?></p>
                            
                            <div class="tour-new-footer">
                                <div class="tour-rating-stars">
                                    <i class="fa-solid fa-star"></i> 
                                    <?= $tour['SaoTrungBinh'] ? round($tour['SaoTrungBinh'], 1) : '5.0' ?> 
                                    <span style="color:#777; font-weight: 500;">(<?= $tour['SoDanhGia'] > 0 ? $tour['SoDanhGia'] : '0' ?>)</span>
                                </div>
                                <a href="index.php?controller=tourdetail&id=<?= $tour['MaTour'] ?>" class="btn-chi-tiet">Chi tiết</a>
>>>>>>> fe6d93f9adc736ba760c7c7881473756fc788b53
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
<<<<<<< HEAD
<<<<<<< HEAD
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card custom-card">
                    <div class="card-img-wrapper">
                        <img src="public/image/location/Hội An.jpg" class="card-banner" alt="Hội An">
                        <span class="price-tag">1.299.000 VNĐ</span>
                    </div>
                    <div class="card-body-tour">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h5 class="tour-title pe-2 mb-0">Lạc bước Phố Cổ</h5>
                            <div class="tour-rating"><i class="fa-solid fa-star"></i> 5.0 (120)</div>
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                            <div class="tour-location mb-0 pe-2 border-end">
                                <i class="fa-solid fa-location-dot text-danger"></i> Hội An
                            </div>
                            <div class="tour-tags mb-0">
                                <span class="tour-tag-item">Khám phá 🚶</span>
                                <span class="tour-tag-item">Văn hóa 🏮</span>
                            </div>
                        </div>
                        <p class="tour-desc">Cùng đạp xe xuyên qua những cánh đồng lúa chín, tự tay chuốt gốm cùng nghệ nhân bản địa và kết thúc ngày dài bằng ổ bánh mì Phượng.</p>
                    </div>
                </div>
            </div>
=======
            <div class="col-12"><p class="text-center text-muted">Chưa load được dữ liệu Database Tour Nổi bật.</p></div>
>>>>>>> dc02dda3b25d0ce58ade747657d6bf8bd69ef6cb
=======
            <div class="col-12"><p class="text-center text-muted">Chưa có dữ liệu Tour Nổi bật.</p></div>
>>>>>>> fe6d93f9adc736ba760c7c7881473756fc788b53
        <?php endif; ?>
    </div>
</div>

<div class="container mb-5 pb-2">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <h3 class="section-title">Tour Được Yêu Thích Nhất <span style="background-color: #FFB800; color: white; width: 28px; height: 28px; border-radius: 50%; display: inline-flex; justify-content: center; align-items: center; font-size: 0.9rem;"><i class="fa-solid fa-heart"></i></span></h3>
        <a href="index.php?controller=tour&sort=yeu_thich" class="view-more">Xem thêm <i class="fa-solid fa-angle-right ms-1"></i></a>
    </div>
<<<<<<< HEAD
<<<<<<< HEAD

=======
>>>>>>> dc02dda3b25d0ce58ade747657d6bf8bd69ef6cb
=======

>>>>>>> fe6d93f9adc736ba760c7c7881473756fc788b53
    <div class="row g-4">
        <?php if(!empty($toursYeuThich)): ?>
            <?php foreach($toursYeuThich as $tour): ?>
                <?php 
                    $giaGoc = $tour['Gia'];
                    $uuDai = $tour['UuDai'] ?? 0;
                    $coUuDai = ($uuDai > 0);
                    $giaDaGiam = $coUuDai ? $giaGoc * (1 - $uuDai) : $giaGoc;
                    $phanTramGiam = $coUuDai ? round($uuDai * 100) : 0;
                    $locationText = !empty($tour['DiaDiem']) ? htmlspecialchars($tour['DiaDiem']) : htmlspecialchars($tour['VungDiaLy']);
                ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="tour-new-card">
                        <div class="tour-new-img-wrap">
                            <?php if($coUuDai): ?>
                                <span class="badge-discount">-<?= $phanTramGiam ?>%</span>
                                <div class="badge-price discount-price">
                                    <span class="old-price"><?= number_format($giaGoc, 0, ',', '.') ?>đ</span>
                                    <span class="new-price"><?= number_format($giaDaGiam, 0, ',', '.') ?>đ</span>
                                </div>
                            <?php else: ?>
                                <div class="badge-price normal-price">
                                    <?= number_format($giaGoc, 0, ',', '.') ?> VNĐ
                                </div>
                            <?php endif; ?>
                            
                            <img src="<?= htmlspecialchars($tour['HinhAnh']) ?>" alt="<?= htmlspecialchars($tour['TenTour']) ?>">
                        </div>
                        
                        <div class="tour-new-body">
                            <div class="tour-meta-top">
                                <span class="tour-location-text"><i class="fa-solid fa-location-dot"></i> <?= $locationText ?></span>
                                <span class="tour-heart" onclick="toggleHeartHome(this, '<?= $tour['MaTour'] ?>')">
                                    <i class="<?= ($tour['IsLiked'] > 0) ? 'fa-solid' : 'fa-regular' ?> fa-heart fs-6"></i> 
                                    <span class="like-count"><?= $tour['SoLuotThich'] ?></span>
                                </span>
                            </div>
                            
                            <h3 class="tour-new-title"><?= htmlspecialchars($tour['TenTour']) ?></h3>
                            
                            <div class="tour-pax-time">
                                <span><i class="fa-solid fa-user-group"></i> Tối đa <?= $tour['SoKhachToiDa'] ?> người</span>
                                <span><i class="fa-regular fa-clock"></i> <?= $tour['SoNgay'] ?> ngày</span>
                            </div>
                            
                            <p class="tour-new-desc"><?= htmlspecialchars($tour['MoTa']) ?></p>
                            
                            <div class="tour-new-footer">
                                <div class="tour-rating-stars">
                                    <i class="fa-solid fa-star"></i> 
                                    <?= $tour['SaoTrungBinh'] ? round($tour['SaoTrungBinh'], 1) : '5.0' ?> 
                                    <span style="color:#777; font-weight: 500;">(<?= $tour['SoDanhGia'] > 0 ? $tour['SoDanhGia'] : '0' ?>)</span>
                                </div>
                                <a href="index.php?controller=tourdetail&id=<?= $tour['MaTour'] ?>" class="btn-chi-tiet">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
<<<<<<< HEAD
<<<<<<< HEAD
             <div class="col-12 col-md-6 col-lg-4">
                <div class="card custom-card favorite-card">
                    <div class="card-img-wrapper">
                        <img src="public/image/location/TaySon.jpg" class="card-banner" alt="Tây Sơn">
                        <span class="price-tag">699.000 VNĐ</span>
                    </div>
                    <div class="card-body-tour">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h5 class="tour-title pe-2 mb-0">Hào khí Tây Sơn</h5>
                            <div class="tour-rating" style="color: #F29A2E;"><i class="fa-solid fa-heart"></i> 210 lượt</div>
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                            <div class="tour-location mb-0 pe-2 border-end">
                                <i class="fa-solid fa-location-dot text-danger"></i> Phú Quốc
                            </div>
                            <div class="tour-tags mb-0">
                                <span class="tour-tag-item">Biển đảo 🏝️</span>
                                <span class="tour-tag-item">Phiêu lưu 🏄</span>
                            </div>
                        </div>
                        <p class="tour-desc">Sinh ra và lớn lên ở đảo ngọc. Mình biết những bãi tắm giấu tên không có trên bản đồ và quán bún quậy ngon nhất thị trấn.</p>
                    </div>
                </div>
            </div>
=======
             <div class="col-12"><p class="text-center text-muted">Chưa load được dữ liệu Database Tour Yêu Thích.</p></div>
>>>>>>> dc02dda3b25d0ce58ade747657d6bf8bd69ef6cb
=======
             <div class="col-12"><p class="text-center text-muted">Chưa có dữ liệu Tour Yêu Thích.</p></div>
>>>>>>> fe6d93f9adc736ba760c7c7881473756fc788b53
        <?php endif; ?>
    </div>
</div>

<div class="container mb-5 pb-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <h3 class="section-title">Kinh Nghiệm Đi Tour <span style="background-color: #FFB800; color: white; width: 28px; height: 28px; border-radius: 50%; display: inline-flex; justify-content: center; align-items: center; font-size: 1rem;"><i class="fa-solid fa-check"></i></span></h3>
        <a href="#" class="view-more">Xem thêm <i class="fa-solid fa-angle-right ms-1"></i></a>
    </div>

    <div class="row g-3">
        <?php if(!empty($latestReviews)): ?>
            <?php foreach($latestReviews as $review): ?>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card custom-card review-card h-100">
                        
                        <div class="review-top">
                            <div class="review-images-grid">
                                <?php if(!empty($review['HinhAnh'])): ?>
                                    <?php 
                                    $imgCount = 0;
                                    foreach($review['HinhAnh'] as $img): 
                                        if($imgCount >= 3) break;
                                    ?>
                                        <img src="<?= htmlspecialchars($img) ?>" alt="Hình ảnh đánh giá">
                                    <?php 
                                        $imgCount++;
                                    endforeach; 
                                    ?>
                                <?php else: ?>
                                    <div style="grid-column: span 3; background: #eee; width: 100%; height: 100%; display:flex; align-items:center; justify-content:center;">
                                        <i class="fa-solid fa-image text-muted" style="font-size: 2rem; opacity: 0.3;"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="review-bottom">
                            <div class="review-author-col">
                                <?php $avatar = !empty($review['AnhDaiDien']) ? $review['AnhDaiDien'] : 'public/image/avatar/R.jpg'; ?>
                                <img src="<?= htmlspecialchars($avatar) ?>" class="review-avatar" alt="Avatar">
                                <?php 
                                    $nameParts = explode(' ', trim($review['HoTen']));
                                    $shortName = end($nameParts);
                                ?>
                                <div class="review-author-name" title="<?= htmlspecialchars($review['HoTen']) ?>">
                                    <?= htmlspecialchars($shortName) ?>
                                </div>
                            </div>
                            
                            <div class="review-content-col">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h5 class="review-title" title="<?= htmlspecialchars($review['TenTour']) ?>">
                                        <?= htmlspecialchars(mb_substr($review['TenTour'], 0, 22)) ?>...
                                    </h5>
                                    <span class="review-date"><?= date('H:i - d/m/Y', strtotime($review['NgayDG'])) ?></span>
                                </div>
                                
                                <div class="mb-1 text-warning" style="font-size: 0.8rem;">
                                    <?php for($i=1; $i<=5; $i++): ?>
                                        <i class="<?= ($i <= $review['SoSao']) ? 'fa-solid' : 'fa-regular' ?> fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                                
                                <p class="review-desc"><?= htmlspecialchars(mb_substr($review['NoiDung'], 0, 95)) ?>...</p>
                            </div>
                        </div>
                        
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12"><p class="text-center text-muted">Hiện tại chưa có bài đánh giá nào từ khách hàng.</p></div>
        <?php endif; ?>
    </div>
</div>

<script>
<<<<<<< HEAD
<<<<<<< HEAD
    // 1. Cấu hình Flatpickr
=======
>>>>>>> dc02dda3b25d0ce58ade747657d6bf8bd69ef6cb
=======
    // Khởi tạo lịch
>>>>>>> fe6d93f9adc736ba760c7c7881473756fc788b53
    flatpickr("#datePicker", {
        dateFormat: "d/m/Y",
        locale: "vn",
        minDate: "today"
    });

<<<<<<< HEAD
<<<<<<< HEAD
    // 2. Logic tính số người (Popup)
=======
>>>>>>> dc02dda3b25d0ce58ade747657d6bf8bd69ef6cb
=======
    // Logic chọn số lượng hành khách
>>>>>>> fe6d93f9adc736ba760c7c7881473756fc788b53
    let adults = 1;
    let children = 0;
    const guestInput = document.getElementById('guestInput');
    const guestIcon = document.getElementById('guestIcon');
    const guestPopup = document.getElementById('guestPopup');
    const adultCountEl = document.getElementById('adultCount');
    const childCountEl = document.getElementById('childCount');

    function toggleGuestPopup() {
        guestPopup.classList.toggle('d-none');
        guestIcon.classList.toggle('fa-chevron-down');
        guestIcon.classList.toggle('fa-chevron-up');
    }

    guestInput.addEventListener('click', toggleGuestPopup);
    guestIcon.addEventListener('click', toggleGuestPopup);

    function updateGuest(type, change) {
        if (type === 'adult') {
            adults += change;
            if (adults < 1) adults = 1; 
            adultCountEl.innerText = adults;
        } else if (type === 'child') {
            children += change;
            if (children < 0) children = 0; 
            childCountEl.innerText = children;
        }
        updateGuestInputDisplay();
    }

    function updateGuestInputDisplay() {
        let text = adults + " Người lớn";
        if (children > 0) {
            text += ", " + children + " Trẻ em";
        }
        guestInput.value = text;
    }

    document.addEventListener('click', function(event) {
        if (!document.getElementById('guestDropdownWrapper').contains(event.target)) {
            guestPopup.classList.add('d-none');
            guestIcon.classList.remove('fa-chevron-up');
            guestIcon.classList.add('fa-chevron-down');
        }
    });

<<<<<<< HEAD
<<<<<<< HEAD
    // 3. Logic check ô Tìm kiếm
=======
>>>>>>> dc02dda3b25d0ce58ade747657d6bf8bd69ef6cb
=======
    // Validation
>>>>>>> fe6d93f9adc736ba760c7c7881473756fc788b53
    const searchForm = document.getElementById('searchForm');
    const destInput = document.getElementById('destination');
    const destError = document.getElementById('destError');

    searchForm.addEventListener('submit', function(e) {
        if (destInput.value.trim() === '') {
            e.preventDefault(); 
            destError.classList.remove('d-none'); 
            destInput.focus(); 
        }
    });

    destInput.addEventListener('input', function() {
        destError.classList.add('d-none'); 
    });

    // AJAX xử lý thả tim
    function toggleHeartHome(element, maTour) {
        const icon = element.querySelector('i');
        const countSpan = element.querySelector('.like-count');
        let count = parseInt(countSpan.innerText);

        element.style.pointerEvents = 'none'; 
        element.style.opacity = '0.5';

        fetch('index.php?controller=home', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'action=toggle_heart&ma_tour=' + encodeURIComponent(maTour)
        })
        .then(r => r.json())
        .then(data => {
            element.style.pointerEvents = 'auto';
            element.style.opacity = '1';

            if (data.success) {
                if (data.action === 'added') {
                    icon.classList.replace('fa-regular', 'fa-solid');
                    countSpan.innerText = count + 1;
                } else if (data.action === 'removed') {
                    icon.classList.replace('fa-solid', 'fa-regular');
                    countSpan.innerText = count - 1;
                }
            } else {
                alert(data.message);
                if(data.message.includes("đăng nhập")) {
                    var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                    loginModal.show();
                }
            }
        })
        .catch(e => {
            element.style.pointerEvents = 'auto';
            element.style.opacity = '1';
            console.error("Lỗi fetch: ", e);
        });
    }
</script>

<?php require_once 'app/views/layouts/footer.php'; ?>