<?php require_once 'app/views/layouts/header.php'; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/vn.js"></script>

<style>
    /* ========================================================
       CSS GIAO DIỆN CHUNG TRANG CHỦ
       ======================================================== */
    body { background-color: #FCFDF9; font-family: 'Quicksand', sans-serif; }

    /* 1. Nền Xanh Lá (Cho Tour Nổi Bật) */
    .highlight-section-green {
        background: linear-gradient(135deg, #2e7a54 0%, #1A5336 100%);
        border-radius: 20px;
        padding: 35px;
        margin-top: 20px;
        margin-bottom: 50px;
        position: relative;
        box-shadow: 0 10px 30px rgba(26, 83, 54, 0.25);
    }
    
    /* 2. Nền Vàng Cam (Cho Tour Yêu Thích) */
    .highlight-section-orange {
        background: linear-gradient(135deg, #F9A826 0%, #E67E22 100%);
        border-radius: 20px;
        padding: 35px;
        margin-top: 20px;
        margin-bottom: 50px;
        position: relative;
        box-shadow: 0 10px 30px rgba(230, 126, 34, 0.25);
    }

    /* 3. Nền Xanh Dương (Cho Kinh Nghiệm Đi Tour) */
    .highlight-section-blue {
        background: linear-gradient(135deg, #1565C0 0%, #1E88E5 100%);
        border-radius: 20px;
        padding: 35px;
        margin-top: 20px;
        margin-bottom: 50px;
        position: relative;
        box-shadow: 0 10px 30px rgba(21, 101, 192, 0.25);
    }

    /* Tiêu đề Promo */
    .promo-header { margin-bottom: 20px; color: white; display: flex; align-items: center;}
    .promo-header h4 { font-weight: 800; font-size: 1.5rem; margin-bottom: 5px; color: white !important;}
    .promo-header h4 i { color: #FFD166 !important; margin-right: 8px;}
    .promo-subtitle { font-weight: 500; opacity: 0.9; font-size: 0.95rem; }
    .btn-view-more { color: white; border: 1px solid rgba(255,255,255,0.5); padding: 8px 20px; border-radius: 30px; text-decoration: none; font-weight: 700; transition: 0.3s; background: rgba(255,255,255,0.1);}
    .btn-view-more:hover { background: white; color: #111; border-color: white;}

    /* Wrapper Slider ngang */
    .tour-slider-wrapper {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        scroll-behavior: smooth;
        scroll-snap-type: x mandatory;
        padding: 10px 5px;
        scrollbar-width: none; 
    }
    .tour-slider-wrapper::-webkit-scrollbar { display: none; } 

    /* Nút mũi tên chuyển slide */
    .slider-arrow {
        position: absolute;
        top: 55%;
        transform: translateY(-50%);
        width: 45px; height: 45px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255,255,255,0.5);
        color: white;
        z-index: 10;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: 0.3s; font-size: 1.2rem;
    }
    .highlight-section-green .slider-arrow:hover { background: white; color: #1A5336; }
    .highlight-section-orange .slider-arrow:hover { background: white; color: #E67E22; }
    .highlight-section-blue .slider-arrow:hover { background: white; color: #1565C0; }
    .slider-arrow.prev { left: -20px; }
    .slider-arrow.next { right: -20px; }

    /* -------------------------------------
       CARD TOUR V2 
       ------------------------------------- */
    .tour-card-v2 {
        min-width: 340px; 
        max-width: 340px;
        scroll-snap-align: start;
        background: #fff;
        border-radius: 16px;
        display: flex; flex-direction: column;
        overflow: hidden;
        border: none !important;
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        transition: transform 0.3s;
    }
    .tour-card-v2:hover { transform: translateY(-5px); }
    
    .tour-card-img-wrap { position: relative; height: 200px; }
    .cover-img { width: 100%; height: 100%; object-fit: cover; }
    .tour-price-badge {
        position: absolute; top: 15px; right: 15px;
        background: rgba(0, 0, 0, 0.7); color: white;
        padding: 5px 12px; border-radius: 8px; font-weight: 700; font-size: 0.95rem; backdrop-filter: blur(5px);
    }
    
    .tour-card-body { padding: 20px; display: flex; flex-direction: column; flex-grow: 1; }
    .tour-meta-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; font-size: 0.85rem; font-weight: 700;}
    .tour-location { color: #666; text-transform: uppercase;}
    .tour-likes { color: #777; cursor: pointer; transition: 0.2s;}
    .tour-likes:hover { opacity: 0.7; }
    
    .tour-title { font-weight: 800; font-size: 1.15rem; color: #111; margin-bottom: 12px; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
    .tour-meta-mid { color: #E67E22; font-size: 0.85rem; font-weight: 700; margin-bottom: 12px; }
    .tour-desc { color: #666; font-size: 0.9rem; line-height: 1.5; margin-bottom: 20px; flex-grow: 1; }
    
    .tour-meta-bottom { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f0f0f0; padding-top: 15px; }
    .tour-rating { font-weight: 700; color: #333; font-size: 0.9rem; }
    .btn-detail-outline { border: 1px solid #ccc; background: white; color: #333; padding: 6px 16px; border-radius: 20px; font-weight: 700; transition: 0.3s;}
    .highlight-section-green .btn-detail-outline:hover { background: #1A5336; border-color: #1A5336; color: white;}
    .highlight-section-orange .btn-detail-outline:hover { background: #E67E22; border-color: #E67E22; color: white;}

    /* -------------------------------------
       CARD REVIEW (Đồng bộ với TourDetail)
       ------------------------------------- */
    .review-card-home {
        background: white;
        border-radius: 16px;
        padding: 20px;
        min-width: 320px;
        max-width: 320px;
        scroll-snap-align: start;
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        display: flex;
        flex-direction: column;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
    }
    .review-card-home:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.25);
    }
    .review-header-home {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    .reviewer-info-home { display: flex; align-items: center; gap: 12px; }
    .reviewer-avatar-box-home {
        width: 45px; height: 45px;
        border-radius: 50%;
        overflow: hidden;
        background-color: #EBF6E0; color: #00712D;
        display: flex; align-items: center; justify-content: center;
        font-weight: bold; font-size: 1.2rem;
        border: 2px solid #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .reviewer-avatar-box-home img { width: 100%; height: 100%; object-fit: cover; }
    .reviewer-name-home { font-weight: 800; color: #222; margin: 0; font-size: 0.95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 130px;}
    .review-date-home { font-size: 0.75rem; color: #888; margin-top: 4px; font-weight: 600;}
    .review-rating-home {
        color: #f6ab2f;
        font-size: 1.0rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .review-tour-name-home {
        font-size: 0.95rem; font-weight: 800; color: #1565C0; margin-bottom: 12px; line-height: 1.3;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .review-content-box-home {
        background: white;
        border: 1px solid #f0f0f0;
        border-radius: 12px;
        padding: 14px 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        margin-bottom: 15px;
        flex-grow: 1;
    }
    .text-clamp-3-home {
        color: #555;
        line-height: 1.6;
        font-size: 0.9rem;
        text-align: justify;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        font-style: italic;
    }
    .review-images-container-home {
        display: flex; gap: 8px; margin-bottom: 10px;
        overflow-x: auto; padding-bottom: 4px;
    }
    .review-images-container-home::-webkit-scrollbar { display: none; }
    .review-img-home {
        width: 65px; height: 65px;
        object-fit: cover; border-radius: 8px;
        flex-shrink: 0;
    }
    .placeholder-img-home {
        width: 65px; height: 65px;
        border-radius: 8px;
        background: #e9ecef;
        display: flex; align-items: center; justify-content: center;
        color: #adb5bd;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    
    /* CÁC LỚP CSS CHO THẺ TAGS */
    .review-tags-container-home {
        display: flex; flex-wrap: wrap; gap: 6px; margin-top: auto;
    }
    .review-tag-pill-home {
        display: inline-flex; align-items: center; gap: 4px;
        border: 1px solid #00712D; 
        background-color: transparent; 
        color: #00712D;
        padding: 3.5px 8px; 
        border-radius: 30px;
        font-size: 0.65rem; 
        font-weight: 700;
    }
</style>

<!-- SLIDESHOW BANNER TỰ ĐỘNG CHẠY -->
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

<!-- THANH TÌM KIẾM -->
<div class="search-bar-wrapper" style="position: relative; z-index: 10; margin-top: -15px; padding-bottom: 20px;">
    <div class="container">
        <div class="search-container shadow-lg" style="border-radius: 50px; background: white;">
            <form id="searchForm" action="index.php" method="GET" class="d-flex align-items-center flex-nowrap w-100 bg-white" style="border-radius: 50px;">
                <input type="hidden" name="controller" value="searchtour">
                <div class="search-input-group position-relative">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="destination" name="search" placeholder="Bạn muốn đi đâu ?" class="form-control border-0 shadow-none bg-transparent">
                    <div id="destError" class="error-tooltip d-none">Bạn phải nhập thông tin này <i class="fa-solid fa-circle-exclamation text-danger ms-2"></i></div>
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


<div class="container">
    
    <!-- 1. KHU VỰC TOUR TRẢI NGHIỆM NỔI BẬT (NỀN XANH LÁ) -->
    <div class="highlight-section-green">
        <div class="promo-header row">
            <div class="promo-title-wrap col-md-9 mb-3 mb-md-0">
                <h4><i class="fa-solid fa-fire"></i> Tour Trải Nghiệm Nổi Bật</h4>
                <div class="promo-subtitle">Khám phá những điểm đến độc đáo nhất trên khắp Việt Nam.</div>
            </div>
            <div class="col-md-3 text-md-end">
                <a href="index.php?controller=tour&sort=moi_nhat" class="btn-view-more">Xem tất cả <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
        </div>

        <div style="position: relative;">
            <button class="slider-arrow prev" onclick="scrollSlider('slider-noibat', -1)"><i class="fa-solid fa-chevron-left"></i></button>
            
            <div class="tour-slider-wrapper" id="slider-noibat">
                <?php if(!empty($toursNoiBat)): ?>
                    <?php foreach($toursNoiBat as $tour): ?>
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
                                        <span style="text-decoration: line-through; font-size: 0.75rem; color: #ffbba1; margin-right: 5px;"><?= number_format($giaGoc, 0, ',', '.') ?>đ</span>
                                    <?php endif; ?>
                                    <?= number_format($giaThucTe, 0, ',', '.') ?> VNĐ
                                </div>
                            </div>
                            <div class="tour-card-body">
                                <div class="tour-meta-top">
                                    <span class="tour-location"><i class="fa-solid fa-location-dot text-danger"></i> <?= htmlspecialchars($tour['DiaDiem'] ?? $tour['VungDiaLy']) ?></span>
                                    <span class="tour-likes" onclick="toggleHeartHome(this, '<?= $tour['MaTour'] ?>')">
                                        <i class="<?= ($tour['IsLiked'] > 0) ? 'fa-solid' : 'fa-regular' ?> fa-heart text-danger"></i> 
                                        <span class="like-count"><?= $tour['SoLuotThich'] ?? 0 ?></span>
                                    </span>
                                </div>
                                <h5 class="tour-title" title="<?= htmlspecialchars($tour['TenTour']) ?>"><?= htmlspecialchars($tour['TenTour']) ?></h5>
                                <div class="tour-meta-mid">
                                    <span><i class="fa-solid fa-user-group"></i> Tối đa <?= $tour['SoKhachToiDa'] ?> người</span>
                                    <span class="ms-3"><i class="fa-regular fa-clock"></i> <?= $tour['SoNgay'] ?> ngày</span>
                                </div>
                                <p class="tour-desc"><?= mb_substr($tour['MoTa'], 0, 70) ?>...</p>
                                <div class="tour-meta-bottom">
                                    <span class="tour-rating">
                                        <i class="fa-solid fa-star" style="color: #FF9F00;"></i> 
                                        <?= ($tour['SaoTrungBinh'] > 0) ? round($tour['SaoTrungBinh'], 1) : '5.0' ?> 
                                        <span style="color:#888; font-weight:500;">(<?= $tour['SoDanhGia'] > 0 ? $tour['SoDanhGia'] : 0 ?>)</span>
                                    </span>
                                    <button class="btn-detail-outline" onclick="window.location.href='index.php?controller=tourdetail&id=<?= $tour['MaTour'] ?>'">Chi tiết</button>                    
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-white">Chưa có dữ liệu Tour Nổi bật.</p>
                <?php endif; ?>
            </div>
            
            <button class="slider-arrow next" onclick="scrollSlider('slider-noibat', 1)"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
    </div>


    <!-- 2. KHU VỰC TOUR ĐƯỢC YÊU THÍCH (NỀN VÀNG CAM) -->
    <div class="highlight-section-orange">
        <div class="promo-header row">
            <div class="promo-title-wrap col-md-9 mb-3 mb-md-0">
                <h4><i class="fa-solid fa-heart" style="color: #fff !important;"></i> Tour Được Yêu Thích Nhất</h4>
                <div class="promo-subtitle">Những hành trình được du khách đánh giá cao và đặt nhiều nhất.</div>
            </div>
            <div class="col-md-3 text-md-end">
                <a href="index.php?controller=tour&sort=yeu_thich" class="btn-view-more">Xem tất cả <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
        </div>

        <div style="position: relative;">
            <button class="slider-arrow prev" onclick="scrollSlider('slider-yeuthich', -1)"><i class="fa-solid fa-chevron-left"></i></button>
            
            <div class="tour-slider-wrapper" id="slider-yeuthich">
                <?php if(!empty($toursYeuThich)): ?>
                    <?php foreach($toursYeuThich as $tour): ?>
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
                                        <span style="text-decoration: line-through; font-size: 0.75rem; color: #ffbba1; margin-right: 5px;"><?= number_format($giaGoc, 0, ',', '.') ?>đ</span>
                                    <?php endif; ?>
                                    <?= number_format($giaThucTe, 0, ',', '.') ?> VNĐ
                                </div>
                            </div>
                            <div class="tour-card-body">
                                <div class="tour-meta-top">
                                    <span class="tour-location"><i class="fa-solid fa-location-dot text-danger"></i> <?= htmlspecialchars($tour['DiaDiem'] ?? $tour['VungDiaLy']) ?></span>
                                    <span class="tour-likes" onclick="toggleHeartHome(this, '<?= $tour['MaTour'] ?>')">
                                        <i class="<?= ($tour['IsLiked'] > 0) ? 'fa-solid' : 'fa-regular' ?> fa-heart text-danger"></i> 
                                        <span class="like-count"><?= $tour['SoLuotThich'] ?? 0 ?></span>
                                    </span>
                                </div>
                                <h5 class="tour-title" title="<?= htmlspecialchars($tour['TenTour']) ?>"><?= htmlspecialchars($tour['TenTour']) ?></h5>
                                <div class="tour-meta-mid">
                                    <span><i class="fa-solid fa-user-group"></i> Tối đa <?= $tour['SoKhachToiDa'] ?> người</span>
                                    <span class="ms-3"><i class="fa-regular fa-clock"></i> <?= $tour['SoNgay'] ?> ngày</span>
                                </div>
                                <p class="tour-desc"><?= mb_substr($tour['MoTa'], 0, 70) ?>...</p>
                                <div class="tour-meta-bottom">
                                    <span class="tour-rating">
                                        <i class="fa-solid fa-star" style="color: #FF9F00;"></i> 
                                        <?= ($tour['SaoTrungBinh'] > 0) ? round($tour['SaoTrungBinh'], 1) : '5.0' ?> 
                                        <span style="color:#888; font-weight:500;">(<?= $tour['SoDanhGia'] > 0 ? $tour['SoDanhGia'] : 0 ?>)</span>
                                    </span>
                                    <button class="btn-detail-outline" onclick="window.location.href='index.php?controller=tourdetail&id=<?= $tour['MaTour'] ?>'">Chi tiết</button>                    
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-white">Chưa có dữ liệu Tour Yêu Thích.</p>
                <?php endif; ?>
            </div>
            
            <button class="slider-arrow next" onclick="scrollSlider('slider-yeuthich', 1)"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
    </div>


    <!-- 3. KHU VỰC KINH NGHIỆM ĐI TOUR (NỀN XANH DƯƠNG) -->
    <div class="highlight-section-blue">
        <div class="promo-header row">
            <!-- Đổi thành col-12 để full dòng, XÓA NÚT XEM TẤT CẢ -->
            <div class="col-12 mb-2">
                <h4><i class="fa-solid fa-comments"></i> Kinh Nghiệm Đi Tour</h4>
                <div class="promo-subtitle">Lắng nghe những chia sẻ chân thực nhất từ các du khách đã trải nghiệm.</div>
            </div>
        </div>

        <div style="position: relative;">
            <button class="slider-arrow prev" onclick="scrollSlider('slider-review', -1)"><i class="fa-solid fa-chevron-left"></i></button>
            
            <div class="tour-slider-wrapper" id="slider-review">
                <?php if(!empty($latestReviews)): ?>
                    <?php foreach($latestReviews as $review): ?>
                        <?php 
                            // Ép kiểu mảng ảnh để JS dễ đọc
                            $imgArr = [];
                            if (!empty($review['HinhAnh']) && is_array($review['HinhAnh'])) {
                                foreach ($review['HinhAnh'] as $ip) { if (trim($ip)) $imgArr[] = trim($ip); }
                            } elseif (!empty($review['HinhAnh']) && is_string($review['HinhAnh'])) {
                                $decoded = json_decode($review['HinhAnh'], true);
                                if(is_array($decoded)) {
                                    foreach ($decoded as $ip) { if (trim($ip)) $imgArr[] = trim($ip); }
                                } else {
                                    $imgArr[] = trim($review['HinhAnh']);
                                }
                            }
                            $avatar = !empty($review['AnhDaiDien']) ? htmlspecialchars($review['AnhDaiDien'], ENT_QUOTES, 'UTF-8') : '';
                            $name = htmlspecialchars($review['HoTen'], ENT_QUOTES, 'UTF-8');
                            $content = htmlspecialchars($review['NoiDung'], ENT_QUOTES, 'UTF-8');
                            $tourName = htmlspecialchars($review['TenTour'], ENT_QUOTES, 'UTF-8');
                            $maTour = $review['MaTour'] ?? '';
                        ?>
                        <!-- THAY ĐỔI TẠI ĐÂY: Click vào thẻ sẽ chuyển thẳng trang -->
                        <div class="review-card-home" onclick="window.location.href='index.php?controller=tourdetail&id=<?= $maTour ?>'" title="Bấm để xem chi tiết tour <?= $tourName ?>">
                            
                            <div class="review-header-home">
                                <div class="reviewer-info-home">
                                    <div class="reviewer-avatar-box-home">
                                        <?php if (!empty($review['AnhDaiDien'])): ?>
                                            <img src="<?= htmlspecialchars($review['AnhDaiDien']) ?>" alt="Avatar" onerror="this.style.display='none'">
                                        <?php else: ?>
                                            <?php $firstChar = mb_substr(htmlspecialchars($review['HoTen']), 0, 1, "UTF-8"); ?>
                                            <?= mb_strtoupper($firstChar, "UTF-8") ?>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <h5 class="reviewer-name-home" title="<?= $name ?>"><?= $name ?></h5>
                                        <div class="review-date-home"><?= date('H:i - d/m/Y', strtotime($review['NgayDG'])) ?></div>
                                    </div>
                                </div>
                                <!-- Ngôi sao -->
                                <div class="review-rating-home">
                                    <i class="fa-solid fa-star"></i> <?= $review['SoSao'] ?? 5 ?>
                                </div>
                            </div>

                            <div class="review-tour-name-home" title="<?= $tourName ?>">
                                <i class="fa-solid fa-map-location-dot me-1 text-danger"></i> <?= $tourName ?>
                            </div>

                            <div class="review-content-box-home">
                                <div class="text-clamp-3-home">
                                    "<?= $content ?>"
                                </div>
                            </div>

                            <div class="review-images-container-home">
                                <?php if (!empty($imgArr)): ?>
                                    <?php foreach ($imgArr as $img): ?>
                                        <img src="<?= htmlspecialchars($img) ?>" class="review-img-home" alt="Ảnh đánh giá" onerror="this.style.display='none'">
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="placeholder-img-home"><i class="fa-regular fa-image"></i></div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- KHU VỰC THẺ TAGS (Điều Ấn Tượng) -->
                            <?php if(!empty($review['DieuAnTuong'])): ?>
                                <div class="review-tags-container-home">
                                    <?php 
                                        $tags = explode(',', $review['DieuAnTuong']);
                                        foreach ($tags as $tag):
                                            $tag = trim($tag);
                                            if (!empty($tag)):
                                                // Gán Icon tự động dựa vào nội dung tag
                                                $icon = '📌'; 
                                                if (stripos($tag, 'tiền') !== false) $icon = '💸';
                                                elseif (stripos($tag, 'thân thiện') !== false) $icon = '🙋';
                                                elseif (stripos($tag, 'an toàn') !== false) $icon = '🛡️';
                                                elseif (stripos($tag, 'dịch vụ') !== false) $icon = '👏';
                                                elseif (stripos($tag, 'đẹp') !== false) $icon = '✨';
                                                elseif (stripos($tag, 'ngon') !== false) $icon = '🍲';
                                    ?>
                                        <div class="review-tag-pill-home">
                                            <span><?= $icon ?></span> <?= htmlspecialchars($tag) ?>
                                        </div>
                                    <?php 
                                            endif;
                                        endforeach; 
                                    ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-white">Hiện tại chưa có bài đánh giá nào từ khách hàng.</p>
                <?php endif; ?>
            </div>
            
            <button class="slider-arrow next" onclick="scrollSlider('slider-review', 1)"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
    </div>

</div> <!-- ĐÓNG THẺ CONTAINER -->

<script>
    // JS Cho Mũi Tên Trượt Ngang Custom Slider
    function scrollSlider(sliderId, direction) {
        const container = document.getElementById(sliderId);
        const scrollAmount = 360 * direction; 
        container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }

    // Logic lịch & khách
    flatpickr("#datePicker", {
        dateFormat: "d/m/Y",
        locale: "vn",
        minDate: "today"
    });

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
        if (children > 0) text += ", " + children + " Trẻ em";
        guestInput.value = text;
    }

    document.addEventListener('click', function(event) {
        if (!document.getElementById('guestDropdownWrapper').contains(event.target)) {
            guestPopup.classList.add('d-none');
            guestIcon.classList.remove('fa-chevron-up');
            guestIcon.classList.add('fa-chevron-down');
        }
    });

    // Validate form search
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

    // AJAX Xử lý thả tim
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