<?php require_once 'app/views/layouts/header.php'; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/vn.js"></script>

<style>
    /* ========================================================
       CSS GIAO DIỆN CHUNG TRANG CHỦ
       ======================================================== */
    body { background-color: #FCFDF9; font-family: 'Quicksand', sans-serif; }

    /* ========================================================
       CSS TỪ ĐOẠN CODE BẠN CUNG CẤP (Đã bổ sung chi tiết để chạy mượt)
       ======================================================== */
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
    
    /* 2. Nền Vàng Cam (Cho Tour Yêu Thích - Từ code của bạn) */
    .highlight-section-orange {
        background: linear-gradient(135deg, #F9A826 0%, #E67E22 100%);
        border-radius: 20px;
        padding: 35px;
        margin-top: 20px;
        margin-bottom: 50px;
        position: relative;
        box-shadow: 0 10px 30px rgba(230, 126, 34, 0.25);
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
        scrollbar-width: none; /* Ẩn scrollbar Firefox */
    }
    .tour-slider-wrapper::-webkit-scrollbar { display: none; } /* Ẩn scrollbar Chrome */

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
    .slider-arrow.prev { left: -20px; }
    .slider-arrow.next { right: -20px; }

    /* Card Tour V2 */
    .tour-card-v2 {
        min-width: 340px; /* Độ rộng thẻ */
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
                                <h5 class="tour-title"><?= htmlspecialchars($tour['TenTour']) ?></h5>
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


    <div class="highlight-section-orange">
        <div class="promo-header row">
            <div class="promo-title-wrap col-md-9 mb-3 mb-md-0">
                <h4><i class="fa-solid fa-heart"></i> Tour Được Yêu Thích Nhất</h4>
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
                                <h5 class="tour-title"><?= htmlspecialchars($tour['TenTour']) ?></h5>
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

</div> <div class="container mb-5 pb-5 mt-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <h3 class="section-title">Kinh Nghiệm Đi Tour <span style="background-color: #FFB800; color: white; width: 28px; height: 28px; border-radius: 50%; display: inline-flex; justify-content: center; align-items: center; font-size: 1rem;"><i class="fa-solid fa-check"></i></span></h3>
        <a href="#" class="view-more text-success fw-bold text-decoration-none">Xem thêm <i class="fa-solid fa-angle-right ms-1"></i></a>
    </div>

    <div class="row g-3">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card custom-card review-card h-100">
                <div class="review-top">
                    <div class="review-images-grid">
                        <img src="public/image/location/hoian1.jpeg" alt="Review 1">
                        <img src="public/image/location/hoian2.png" alt="Review 2">
                        <img src="public/image/location/hoian3.jpg" alt="Review 3">
                    </div>
                </div>
                <div class="review-bottom">
                    <div class="review-author-col">
                        <img src="public/image/avatar/Xink.png" class="review-avatar" alt="Avatar">
                        <div class="review-author-name">LinhLe</div>
                    </div>
                    <div class="review-content-col">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h5 class="review-title">Lạc bước Phố Cổ</h5>
                            <span class="review-date">15:07 - 30/04/2026</span>
                        </div>
                        <p class="review-desc">Tour này gặp người bản địa thân thiện mà hỗ trợ mình nhiệt tình lắm luôn á, chuyến đi rất đáng nhớ...</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card custom-card review-card h-100">
                <div class="review-top">
                    <div class="review-images-grid">
                        <img src="public/image/location/mientay1.jpg" alt="Review 1">
                        <img src="public/image/location/mientay2.jpg" alt="Review 2">
                        <img src="public/image/location/mientay3.jpg" alt="Review 3">
                    </div>
                </div>
                <div class="review-bottom">
                    <div class="review-author-col">
                        <img src="public/image/avatar/Trâm Nguyễn.png" class="review-avatar" alt="Avatar">
                        <div class="review-author-name">Thie</div>
                    </div>
                    <div class="review-content-col">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h5 class="review-title">Khám Phá Miệt Vườn</h5>
                            <span class="review-date">13:06 - 24/03/2026</span>
                        </div>
                        <p class="review-desc">Mình với nhỏ cot đã có một chuyến đi siêu duiii ở chợ nổi Cái Răng. Không cần mang gì chỉ cần cái bụng đói...</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card custom-card review-card h-100">
                <div class="review-top">
                    <div class="review-images-grid">
                        <img src="public/image/location/nongdan1.jpg" alt="Review 1">
                        <img src="public/image/location/nongdan2.jpg" alt="Review 2">
                        <img src="public/image/location/nongdan3.jpg" alt="Review 3">
                    </div>
                </div>
                <div class="review-bottom">
                    <div class="review-author-col">
                        <img src="public/image/avatar/oanh.png" class="review-avatar" alt="Avatar">
                        <div class="review-author-name">Hiu</div>
                    </div>
                    <div class="review-content-col">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h5 class="review-title">1 ngày làm nông dân</h5>
                            <span class="review-date">12:59 - 08/03/2026</span>
                        </div>
                        <p class="review-desc">Hai vợ chồng mình sống ở thành thị bao năm nay mới được trải nghiệm thú vị tới vậy. Thì ra làm nông cũng vui...</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card custom-card review-card h-100">
                <div class="review-top">
                    <div class="review-images-grid">
                        <img src="public/image/location/battrang1.jpg" alt="Review 1">
                        <img src="public/image/location/battrang2.jpg" alt="Review 2">
                        <img src="public/image/location/battrang3.png" alt="Review 3">
                    </div>
                </div>
                <div class="review-bottom">
                    <div class="review-author-col">
                        <img src="public/image/avatar/Tuyết Nhiên.jpg" class="review-avatar" alt="Avatar">
                        <div class="review-author-name">Zang</div>
                    </div>
                    <div class="review-content-col">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h5 class="review-title">Tinh hoa Bát Tràng</h5>
                            <span class="review-date">11:37 - 14/02/2026</span>
                        </div>
                        <p class="review-desc">Tour này thiệt sự giúp mình chữa lành rất là nhiều. Mình còn được mang cả gốm về tặng bạn bè...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // JS Cho Mũi Tên Trượt Ngang Custom Slider
    function scrollSlider(sliderId, direction) {
        const container = document.getElementById(sliderId);
        // Trượt qua 1 thẻ (340px) + gap (20px)
        const scrollAmount = 360 * direction; 
        container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }

    // Logic lịch & khách (Giữ nguyên)
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