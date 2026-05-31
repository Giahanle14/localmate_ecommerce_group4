<link href="https://fonts.googleapis.com/css2?family=Quantico:wght@700&family=Quicksand:wght@500;600;700&family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Pacifico&display=swap');
        .tour-title {
        font-family: 'Pacifico', cursive !important; 
        font-weight: 400 !important; 
        font-size: 3.5rem !important; 
        color: #00712D !important; 
        text-shadow: 3px 3px 5px rgba(0, 113, 45, 0.25) !important;
        
        /* Nới lỏng khoảng cách dòng và đẩy các phần tử bên dưới ra xa */
        line-height: 1.6 !important; 
        padding-bottom: 10px !important;
        margin-bottom: 15px !important; 
        
        /* Bắt buộc khung phải giãn nở chiều cao vô hạn để chứa hết chữ */
        height: auto !important;
        max-height: none !important;
        display: block !important;
        
        /* Ép bẻ từ xuống dòng */
        white-space: normal !important;
        word-wrap: break-word !important;
        overflow-wrap: break-word !important;
        
        flex: 1; 
        min-width: 0 !important; 
        margin-right: 20px; 
    }
    .heading-quicksand { font-family: 'Quicksand', sans-serif; font-weight: 700; color: #333; font-size: 1.6rem; margin-bottom: 20px; }
    .tour-desc-text { color: #555; line-height: 1.8; font-size: 1.05rem; font-family: 'Quicksand', sans-serif; font-weight: 500; }
    .tour-detail-banner { width: 100%; height: 400px; object-fit: cover; object-position: center; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    .tour-meta i { color: #00712D; margin-right: 5px; }
    .tour-meta span { margin-right: 25px; font-weight: 600; font-size: 1.05rem; color: #444; font-family: 'Quicksand', sans-serif; }
    .sticky-booking-box { position: sticky; top: 90px; z-index: 10; }
    .booking-card { background: #FCFBF7; border-radius: 15px; padding: 25px; box-shadow: 0 8px 25px rgba(0,0,0,0.06); border: 1px solid #f0eee9; font-family: 'Quicksand', sans-serif;}
    .price-main-tag { 
        color: #FF9F00; 
        font-size: 1.8rem; 
        font-weight: 800; 
        font-family: 'Montserrat', sans-serif; 
    }
    .custom-input, .qty-selector { border: 1px solid #00712D; border-radius: 8px; color: #555; font-weight: 600;}
    .qty-selector { padding: 8px 15px; background: #fff; }
    .btn-book-custom { background: #FF9E8E; color: #fff; font-weight: 700; border-radius: 25px; width: 60%; margin: 20px auto 0; display: block; border: none; padding: 12px; transition: 0.3s; font-size: 1.1rem; }
    .btn-book-custom:hover { background: #ff8672; }
    .timeline-item { position: relative; padding-left: 20px; border-left: 2px solid #00712D; margin-bottom: 25px; font-family: 'Quicksand', sans-serif;}
    .timeline-item::before { content: ''; position: absolute; left: -8px; top: 0; width: 14px; height: 14px; border-radius: 50%; background: #f39c12; }
    .timeline-time { color: #00712D; font-weight: 700; }
    .timeline-title { font-weight: 700; font-size: 1.1rem; }
   
    /* KHU VỰC ĐÁNH GIÁ TRẢI NGHIỆM */
    .review-section {
        margin-top: 50px;
        margin-bottom: 50px;
    }
    .review-main-title {
        font-family: 'Quicksand', sans-serif;
        font-weight: 800;
        color: #123e30; 
        font-size: 2rem;
        margin-bottom: 25px;
        display: inline-block;
    }
    .review-container-outer {
        background-color: #fdfae9; 
        border: 2px solid #c9d8c9; 
        border-radius: 20px;
        padding: 40px 30px; /* Tăng lề trái phải lên 50px */
        position: relative;
    }
    .review-slider {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding-bottom: 15px; 
    }
    .review-slider::-webkit-scrollbar {
        display: none; /* Ẩn thanh cuộn để vuốt mượt mà */
    }
    .review-card {
        background: white;
        border-radius: 16px;
        padding: 20px !important; /* Ép lề trong rộng ra */
        min-width: 250px; /* Thu nhỏ từ 350px xuống 260px */
        max-width: 250px;
        flex: 0 0 auto;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        display: flex;
        flex-direction: column;
        CURSOR: POINTER; 
        TRANSITION: ALL 0.2S EASE;
    }
    .review-card:hover {
        TRANSFORM: TRANSLATEY(-3PX); 
        BOX-SHADOW: 0 8PX 20PX RGBA(0,113,45,0.1);
    }
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    .reviewer-info { display: flex; align-items: center; gap: 12px; }
    .reviewer-avatar-box {
        width: 40px; height: 40px;
        border-radius: 50%;
        overflow: hidden;
        background-color: #EBF6E0; color: #00712D;
        display: flex; align-items: center; justify-content: center;
        font-weight: bold; font-size: 1.2rem;
    }
    .reviewer-avatar-box img { width: 100%; height: 100%; object-fit: cover; }
    .reviewer-name { font-weight: 700; color: #222; margin: 0; font-size: 0.80rem;white-space: nowrap;overflow: hidden; text-overflow: ellipsis; }
    .review-date { font-size: 0.70rem; color: #888; margin-top: 4px; }
    
    .review-rating {
        color: #f6ab2f; /* Màu vàng cam của Sao */
        font-size: 1.0rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    /* 1. Class chỉ chịu trách nhiệm tạo khung nền trắng và đệm lề */
    .review-content-box {
        background: white;
        border: 1px solid #f0f0f0;
        border-radius: 12px;
        padding: 14px 16px !important; 
        box-shadow: 0 4px 12px rgba(0,0,0,0.05); 
        margin-bottom: 15px;
    }

    /* 2. Class: Chỉ chịu trách nhiệm quản lý font chữ */
    .text-clamp-3 {
        color: #555;
        line-height: 1.6;
        font-family: 'Quicksand', sans-serif;
        font-weight: 600;
        font-size: 0.65rem; 
        text-align: justify;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .review-images-container {
        display: flex; gap: 8px; margin-bottom: 18px;
        overflow-x: auto; padding-bottom: 4px;
    }
    .review-img {
        width: 60px; height: 60px; 
        object-fit: cover; border-radius: 8px;
        flex-shrink: 0; /* Chống bị bóp méo ảnh */
    }
    .placeholder-img {
        width: 60px; height: 60px;
        border-radius: 10px;
        background: #e9ecef;
        display: flex; align-items: center; justify-content: center;
        color: #adb5bd; 
        font-size: 1.5rem; 
        flex-shrink: 0; 
    }
    .review-tags-container {
        display: flex; flex-wrap: wrap; gap: 8px; margin-top: auto;
    }
    .review-tag-pill {
        display: inline-flex; align-items: center; gap: 4px;
        border: 1px solid #00712D; 
        background-color: transparent; 
        color: #00712D;
        padding: 3.5px 8px; /* Thu nhỏ đệm viền trái/phải/trên/dưới */
        border-radius: 30px;
        font-size: 0.50rem; /* Thu nhỏ cỡ chữ của tag */
        font-weight: 700;
    }
    /* Nút mũi tên vuốt trái phải */
    .nav-arrow-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px; height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid #ddd;
        display: flex; align-items: center; justify-content: center;
        color: #888;
        font-size: 1.2rem;
        cursor: pointer;
        z-index: 10;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: 0.3s;
    }
    .nav-arrow-btn:hover { background: white; color: #333; }
    .nav-arrow-btn.prev { left: -15px; } 
    .nav-arrow-btn.next { right: -15px; }
</style>
<div class="breadcrumb-custom px-3 px-lg-5">
    <a href="index.php?controller=home"><i class="fa-solid fa-house me-1"></i>Trang chủ</a> 
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <a href="index.php?controller=tour">Tour</a>
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <a href="index.php?controller=tourdetail&id=<?= htmlspecialchars($tour['MaTour'] ?? '') ?>"><?= htmlspecialchars($tour['TenTour'] ?? 'Chi tiết tour') ?></a>
</div>
<div class="container" style="padding-top: 30px; padding-bottom: 80px;">

    <div class="row">
        <div class="col-lg-8 pe-lg-4">
            <img src="<?= htmlspecialchars($tour['HinhAnh']) ?>" class="tour-detail-banner" alt="Banner">
            
            <div class="d-flex justify-content-between align-items-start mb-4 mt-4">
                <h1 class="tour-title"><?= htmlspecialchars($tour['TenTour']) ?></h1>
                
                <button class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center mt-3" 
                    onclick="toggleFavoriteDetail(this, '<?= $tour['MaTour'] ?>')" 
                        style="width: 45px; height: 45px; border: 1px solid #ddd; flex-shrink: 0;">
                    <i class="<?= !empty($isFavorited) ? 'fa-solid text-danger' : 'fa-regular' ?> fa-heart fs-5"></i>
                </button>
            </div>

            <div class="tour-meta mb-5 d-flex flex-wrap">
                <span><i class="fa-solid fa-location-dot text-danger"></i> <?= htmlspecialchars($tour['DiaDiem'] ?? $tour['VungDiaLy']) ?></span>
                <span class="ms-3 me-3">
    <i class="fa-solid fa-star" style="color: #FF9F00;"></i> 
    <?= (!empty($tour['TrungBinhSao']) && $tour['TrungBinhSao'] > 0) ? $tour['TrungBinhSao'] : 'Chưa có' ?> 
    <?php if (!empty($tour['SoLuotDanhGia']) && $tour['SoLuotDanhGia'] > 0) echo "(" . $tour['SoLuotDanhGia'] . ")"; ?>
</span>
                <span><i class="fa-solid fa-user-group"></i> Tối đa <?= $tour['SoKhachToiDa'] ?> người</span>
                <span><i class="fa-solid fa-clock"></i> <?= $tour['SoNgay'] ?> ngày</span>
            </div>

            <h4 class="heading-quicksand">Tổng quan chuyến đi</h4>
            <p class="tour-desc-text"><?= nl2br(htmlspecialchars($tour['MoTa'])) ?></p>

            <h4 class="heading-quicksand mt-5">Lịch trình chi tiết</h4>
            <div class="mt-4">
                <?php if(!empty($itinerary)): ?>
                    <?php foreach($itinerary as $item): ?>
                        <div class="timeline-item">
                            <div class="timeline-time"><?= htmlspecialchars($item['ThoiGian']) ?></div>
                            <div class="timeline-title"><?= htmlspecialchars($item['TieuDe']) ?></div>
                            <div class="text-secondary"><?= htmlspecialchars($item['NoiDung']) ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <!-- KHU VỰC ĐÁNH GIÁ TỪ KHÁCH HÀNG -->
    <div class="review-section" id="reviewSection">
        <!-- KHỐI TIÊU ĐỀ + BỘ LỌC ĐÁNH GIÁ -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="review-main-title mb-0">Đánh giá trải nghiệm</h4>
        
        <select class="form-select w-auto fw-bold" style="border-radius: 30px; color: #00712D; border: 2px solid #00712D; cursor: pointer;" onchange="sortReviewsSmooth(this.value, '<?= $tour['MaTour'] ?>')">
            <option value="newest">⏳ Mới nhất</option>
            <option value="sao_giam">⭐ Sao giảm dần</option>
            <option value="sao_tang">⭐ Sao tăng dần</option>
        </select>
    </div>

        <div class="review-container-outer">
            <!-- Nút điều hướng Carousel -->
            <button class="nav-arrow-btn prev" onclick="scrollReview(-1)"><i class="fa-solid fa-chevron-left"></i></button>
            <button class="nav-arrow-btn next" onclick="scrollReview(1)"><i class="fa-solid fa-chevron-right"></i></button>

            <div class="review-slider" id="reviewSlider">
               <?php if (!empty($danhGiaList)): ?>
                    <?php foreach ($danhGiaList as $review): ?>
                        <?php 
                            // Ép kiểu mảng ảnh để JS dễ đọc
                            $imgArr = [];
                            if (!empty($review['HinhAnh'])) {
                                $imgParts = explode('||', $review['HinhAnh']);
                                foreach ($imgParts as $ip) { if (trim($ip)) $imgArr[] = trim($ip); }
                            }
                            $imgJson = htmlspecialchars(json_encode($imgArr), ENT_QUOTES, 'UTF-8');
                            $avatar = !empty($review['AnhDaiDien']) ? htmlspecialchars($review['AnhDaiDien'], ENT_QUOTES, 'UTF-8') : '';
                            $name = htmlspecialchars($review['TenKhachHang'], ENT_QUOTES, 'UTF-8');
                            $content = htmlspecialchars($review['NoiDung'], ENT_QUOTES, 'UTF-8');
                            $tags = !empty($review['AnTuong']) ? htmlspecialchars($review['AnTuong'], ENT_QUOTES, 'UTF-8') : '';
                        ?>
                        
                        <div class="review-card" onclick="openReviewModal(this)"
                             data-name="<?= $name ?>" data-avatar="<?= $avatar ?>"
                             data-date="<?= date('d/m/Y', strtotime($review['NgayDanhGia'])) ?>"
                             data-rating="<?= $review['SoSao'] ?? 5 ?>" data-content="<?= $content ?>"
                             data-images="<?= $imgJson ?>" data-tags="<?= $tags ?>">
                             

                            <div class="review-header">
                                <div class="reviewer-info">
                                    <div class="reviewer-avatar-box">
                                        <?php if (!empty($review['AnhDaiDien'])): ?>
                                            <img src="<?= htmlspecialchars($review['AnhDaiDien']) ?>" alt="Avatar" onerror="this.style.display='none'">
                                        <?php else: ?>
                                            <?php $firstChar = mb_substr(htmlspecialchars($review['TenKhachHang']), 0, 1, "UTF-8"); ?>
                                            <?= mb_strtoupper($firstChar, "UTF-8") ?>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <h5 class="reviewer-name"><?= htmlspecialchars($review['TenKhachHang']) ?></h5>
                                        <div class="review-date"><?= date('d/m/Y', strtotime($review['NgayDanhGia'])) ?></div>
                                    </div>
                                </div>
                            <!-- Ngôi sao -->
                                <div class="review-rating">
                                    <i class="fa-solid fa-star"></i> <?= $review['SoSao'] ?? 5 ?>
                                </div>
                            </div>

                            <!-- Box chứa nội dung riêng biệt -->
                            <div class="review-content-box">
                                <div class="text-clamp-3">
                                    <?= htmlspecialchars($review['NoiDung']) ?>
                                </div>
                            </div>

                            <div class="review-images-container">
                                <?php if (!empty($review['HinhAnh'])): ?>
                                    <?php 
                                        $images = explode('||', $review['HinhAnh']);
                                        foreach ($images as $img): 
                                            $imgPath = trim($img);
                                            if (!empty($imgPath)):
                                    ?>
                                        <img src="<?= htmlspecialchars($imgPath) ?>" class="review-img" alt="Ảnh đánh giá" onerror="this.style.display='none'">
                                    <?php 
                                            endif;
                                        endforeach; 
                                    ?>
                                <?php else: ?>
                                    <!-- Khung ảnh trống mặc định nếu không có hình -->
                                    <div class="placeholder-img"><i class="fa-regular fa-image"></i></div>
                                <?php endif; ?>
                            </div>

                            <!-- Xử lý tách riêng từng tag Ấn tượng -->
                            <?php if(!empty($review['AnTuong'])): ?>
                                <div class="review-tags-container">
                                    <?php 
                                        // Tách các ấn tượng cách nhau bằng dấu phẩy
                                        $tags = explode(',', $review['AnTuong']);
                                        foreach ($tags as $tag):
                                            $tag = trim($tag);
                                            if (!empty($tag)):
                                                // Tự động gán Icon dựa vào từ khóa
                                                $icon = '📌'; 
                                                if (stripos($tag, 'tiền') !== false) $icon = '💸';
                                                elseif (stripos($tag, 'thân thiện') !== false) $icon = '🙋';
                                                elseif (stripos($tag, 'an toàn') !== false) $icon = '🛡️';
                                                elseif (stripos($tag, 'dịch vụ') !== false) $icon = '👏';
                                                elseif (stripos($tag, 'đẹp') !== false) $icon = '✨';
                                                elseif (stripos($tag, 'ngon') !== false) $icon = '🍲';
                                    ?>
                                        <div class="review-tag-pill">
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
                    <p class="text-center w-100 text-muted">Chưa có đánh giá nào cho tour này.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
        </div>

        <div class="col-lg-4">
            <div class="sticky-booking-box">
                <div class="booking-card">
                    <p class="mb-1 text-dark" style="font-weight: 500;">Giá từ</p>
                    <div class="mb-4">
                        <span class="price-main-tag"><?= number_format($tour['Gia'], 0, ',', '.') ?> VNĐ</span>
                        <span style="color:#888; font-size: 1rem;"> / khách</span>
                    </div>
                    
                    <form action="index.php" method="GET">
                        <input type="hidden" name="controller" value="tourbooking">
                        <input type="hidden" name="action" value="index">
                        <input type="hidden" name="id" value="<?= $tour['MaTour'] ?>">

                        <div class="mb-4">
                            <label class="form-label text-success fw-bold">Chọn ngày</label>
                            <input type="date" name="ngaydi" class="form-control custom-input" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-success fw-bold">Số lượng khách</label>
                            <div class="d-flex align-items-center justify-content-between qty-selector">
    <button type="button" class="btn p-0 border-0" onclick="updateTourQty(-1)">
        <i class="fa-solid fa-circle-chevron-left fs-4" style="color: #799580;"></i>
    </button>
    
    <span id="qty_display" class="fw-bold fs-5 text-success">1</span>
    
    <button type="button" class="btn p-0 border-0" onclick="updateTourQty(1)">
        <i class="fa-solid fa-circle-chevron-right fs-4" style="color: #799580;"></i>
    </button>
    
    <input type="hidden" name="soluong" id="soluong_input" value="1">
</div>
                        </div>

                        <hr style="border-color: #ddd; margin: 25px 0;">

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-secondary"><span id="calc_price"><?= number_format($tour['Gia'], 0, ',', '.') ?></span> x <span id="calc_qty">1</span></span>
                            <span class="text-secondary" id="calc_subtotal"><?= number_format($tour['Gia'], 0, ',', '.') ?> VNĐ</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4 mt-3">
                            <span class="text-success fw-bold fs-5">Tổng cộng</span>
                            <span class="text-success fw-bold fs-5" id="calc_total"><?= number_format($tour['Gia'], 0, ',', '.') ?> VNĐ</span>
                        </div>

                        <button type="submit" class="btn w-100 py-3 fw-bold rounded-pill" style="background-color: #fc8d81; color: white; transition: 0.3s;" onmouseover="this.style.backgroundColor='#e8776b'" onmouseout="this.style.backgroundColor='#fc8d81'" onclick="return requireLoginPopup(event, 'tiến hành đặt tour này')">
                            Đặt ngay
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reviewDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 20px; background-color: #fdfae9; border: 2px solid #c9d8c9;">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-0 pb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <div id="modalReviewAvatar" class="reviewer-avatar-box" style="width: 55px; height: 55px; font-size: 1.5rem;"></div>
                        <div>
                            <h4 id="modalReviewName" class="mb-1" style="font-weight: 700; color: #222;"></h4>
                            <div id="modalReviewDate" style="color: #888; font-size: 0.95rem;"></div>
                        </div>
                    </div>
                    <div class="review-rating" style="font-size: 1.4rem;">
                        <i class="fa-solid fa-star"></i> <span id="modalReviewRating"></span>
                    </div>
                </div>
                
                <div id="modalReviewContent" class="mb-4 p-3 bg-white" style="border-radius: 12px; border: 1px solid #f0f0f0; color: #444; line-height: 1.7; font-family: 'Quicksand', sans-serif; font-size: 1.05rem; text-align: justify; box-shadow: 0 4px 12px rgba(0,0,0,0.03);"></div>
                
                <div id="modalReviewImages" class="row g-3 mb-3"></div>
                
                <div id="modalReviewTags" class="d-flex flex-wrap gap-2"></div>
            </div>
        </div>
    </div>
    <!-- LỚP PHỦ XEM ẢNH PHÓNG TO (FULLSCREEN) -->
<div id="imageZoomOverlay" onclick="closeZoom()" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.85); z-index: 10000; align-items: center; justify-content: center; cursor: zoom-out; opacity: 0; transition: opacity 0.3s ease;">
    <!-- Nút X tắt (có thể bấm ra ngoài ảnh để tắt luôn cũng được) -->
    <span style="position: absolute; top: 20px; right: 40px; color: white; font-size: 45px; font-weight: bold; cursor: pointer;">&times;</span>
    
    <!-- Ảnh được phóng to -->
    <img id="zoomedImageSrc" src="" style="max-width: 90%; max-height: 90%; object-fit: contain; border-radius: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); transform: scale(0.9); transition: transform 0.3s ease;">
</div>
</div>

</div>

<script>
    // JS tính số lượng, đổi lại cách bắt event onclick cho button
    // Ép kiểu về số nguyên (parseInt) để an toàn tuyệt đối, tránh JS hiểu nhầm là chuỗi
    const basePrice = <?= isset($giaThucTe) ? $giaThucTe : $tour['Gia'] ?>;
    const maxQty = parseInt('<?= $tour['SoKhachToiDa'] ?>', 10);
    let currentQty = 1;

    function formatCurrency(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // TÊN HÀM MỚI (updateTourQty) để không bị đụng hàng với code cũ
    function updateTourQty(amount) {
        let newQty = currentQty + amount;
        if (newQty >= 1 && newQty <= maxQty) {
            currentQty = newQty;
            document.getElementById('qty_display').innerText = currentQty;
            document.getElementById('soluong_input').value = currentQty;
            document.getElementById('calc_qty').innerText = currentQty;
            
            let total = basePrice * currentQty;
            let formattedTotal = formatCurrency(total) + " VNĐ";
            document.getElementById('calc_subtotal').innerText = formattedTotal;
            document.getElementById('calc_total').innerText = formattedTotal;
        } else if (newQty > maxQty) {
            Swal.fire({ icon: 'warning', title: 'Giới hạn', text: 'Chỉ còn tối đa ' + maxQty + ' chỗ!'});
        }
    }

    // JS Xử lý thả tim đã nâng cấp
    function toggleFavoriteDetail(btnElement, maTour) {
        // KIỂM TRA BẰNG POPUP XỊN TRƯỚC KHI GỌI AJAX
        if (!requireLoginPopup(null, 'lưu tour vào danh sách yêu thích')) {
            return; // Dừng luôn nếu chưa đăng nhập
        }

        const icon = btnElement.querySelector('i');
        
        // Gọi đến API có sẵn (Các phần dưới giữ nguyên như bạn đang có)
        fetch('index.php?controller=favorite', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'action=toggle_heart&ma_tour=' + encodeURIComponent(maTour)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.action === 'added') {
                    icon.classList.remove('fa-regular');
                    icon.classList.add('fa-solid', 'text-danger');
                } else if (data.action === 'removed') {
                    icon.classList.remove('fa-solid', 'text-danger');
                    icon.classList.add('fa-regular');
                }
            } 
        })
        .catch(error => console.error('Lỗi:', error));
    }
    function scrollReview(direction) {
        const slider = document.getElementById('reviewSlider');
        // Chiều rộng thẻ (260px) + gap (20px) = 280
        const scrollAmount = 280; 
        slider.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
    }
    // HÀM MỚI: Sắp xếp đánh giá ngầm (Không load lại trang)
    function sortReviewsSmooth(sortType, maTour) {
        const slider = document.getElementById('reviewSlider');
        
        // Tạo hiệu ứng mờ nhẹ để khách hàng biết web đang xử lý
        slider.style.transition = "opacity 0.3s ease";
        slider.style.opacity = "0.4";

        // Thêm tham số '&t=' + Date.now() để CHỐNG TRÌNH DUYỆT LƯU CACHE
        const fetchUrl = 'index.php?controller=tourdetail&id=' + maTour + '&sort_review=' + sortType + '&t=' + Date.now();

        // Dùng Fetch tải dữ liệu ngầm
        fetch(fetchUrl)
            .then(response => response.text())
            .then(html => {
                // Tạo một "trình duyệt ảo" đọc HTML trả về
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Cắt lấy đúng phần ruột của danh sách đánh giá mới và đắp vào
                slider.innerHTML = doc.getElementById('reviewSlider').innerHTML;
                
                // Trả lại độ sáng và cuộn thẻ về vị trí đầu tiên
                slider.style.opacity = "1";
                slider.scrollLeft = 0;
            })
            .catch(error => {
                console.error('Lỗi khi sắp xếp:', error);
                slider.style.opacity = "1"; 
            });
    }
    // HÀM MỚI: MỞ POPUP CHI TIẾT ĐÁNH GIÁ
    function openReviewModal(cardElement) {
        // Lấy toàn bộ dữ liệu đang giấu trong thẻ card
        const name = cardElement.getAttribute('data-name');
        const avatar = cardElement.getAttribute('data-avatar');
        const date = cardElement.getAttribute('data-date');
        const rating = cardElement.getAttribute('data-rating');
        const content = cardElement.getAttribute('data-content');
        const images = JSON.parse(cardElement.getAttribute('data-images') || '[]');
        const tagsStr = cardElement.getAttribute('data-tags');

        // Bơm thông tin text vào Modal
        document.getElementById('modalReviewName').innerText = name;
        document.getElementById('modalReviewDate').innerText = date;
        document.getElementById('modalReviewRating').innerText = rating;
        document.getElementById('modalReviewContent').innerText = content;

        // Bơm Avatar
        const avatarBox = document.getElementById('modalReviewAvatar');
        if (avatar) {
            avatarBox.innerHTML = `<img src="${avatar}" style="width:100%; height:100%; object-fit:cover;">`;
        } else {
            avatarBox.innerHTML = name.charAt(0).toUpperCase();
        }

        // Bơm lưới Hình ảnh (Sắp xếp dạng cột cực đẹp)
        const imagesBox = document.getElementById('modalReviewImages');
        imagesBox.innerHTML = '';
        if (images.length > 0) {
            images.forEach(img => {
                imagesBox.innerHTML += `
                    <div class="col-6 col-md-4">
                        <!-- ĐÃ THÊM: cursor: pointer và onclick="zoomImage(this.src)" -->
                        <img src="${img}" class="img-fluid rounded-3 w-100" 
                             style="height: 160px; object-fit: cover; border: 2px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1); cursor: pointer; transition: 0.2s;" 
                             onerror="this.style.display='none'" 
                             onclick="zoomImage(this.src)"
                             onmouseover="this.style.opacity='0.8'"
                             onmouseout="this.style.opacity='1'">
                    </div>
                `;
            });
        }

        // Bơm Tags (Tự động cấp lại Icon)
        const tagsBox = document.getElementById('modalReviewTags');
        tagsBox.innerHTML = '';
        if (tagsStr) {
            const tags = tagsStr.split(',');
            tags.forEach(tag => {
                let t = tag.trim();
                if (t) {
                    let icon = '📌'; 
                    if (t.toLowerCase().includes('tiền')) icon = '💸';
                    else if (t.toLowerCase().includes('thân thiện')) icon = '🙋';
                    else if (t.toLowerCase().includes('an toàn')) icon = '🛡️';
                    else if (t.toLowerCase().includes('dịch vụ')) icon = '👏';
                    else if (t.toLowerCase().includes('đẹp')) icon = '✨';
                    else if (t.toLowerCase().includes('ngon')) icon = '🍲';
                    
                    tagsBox.innerHTML += `
                        <div class="review-tag-pill" style="font-size: 0.95rem; padding: 6px 16px;">
                            <span>${icon}</span> ${t}
                        </div>
                    `;
                }
            });
        }

        // Kích hoạt bật Popup lên
        const modal = new bootstrap.Modal(document.getElementById('reviewDetailModal'));
        modal.show();
    }
    // HÀM MỚI: PHÓNG TO ẢNH FULL MÀN HÌNH
    function zoomImage(imageSrc) {
        const overlay = document.getElementById('imageZoomOverlay');
        const zoomedImg = document.getElementById('zoomedImageSrc');
        
        // Đưa đường dẫn ảnh vào thẻ img lớn
        zoomedImg.src = imageSrc;
        
        // Bật lớp phủ và tạo hiệu ứng bung nở (scale)
        overlay.style.display = 'flex';
        setTimeout(() => {
            overlay.style.opacity = '1';
            zoomedImg.style.transform = 'scale(1)';
        }, 10); // Đợi 10ms để trình duyệt kịp nhận diện display: flex
    }

    // HÀM MỚI: TẮT ẢNH PHÓNG TO
    function closeZoom() {
        const overlay = document.getElementById('imageZoomOverlay');
        const zoomedImg = document.getElementById('zoomedImageSrc');
        
        // Hiệu ứng mờ dần và thu nhỏ lại
        overlay.style.opacity = '0';
        zoomedImg.style.transform = 'scale(0.9)';
        
        // Sau 300ms (bằng thời gian transition) thì ẩn hẳn đi
        setTimeout(() => {
            overlay.style.display = 'none';
        }, 300);
    }
</script>