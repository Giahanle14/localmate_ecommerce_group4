<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/vn.js"></script>

<section class="hero-section"></section>

<div class="search-bar-wrapper">
    <div class="container">
        <div class="search-container">
            <form id="searchForm" action="" method="GET" class="d-flex align-items-center flex-nowrap w-100 bg-white" style="border-radius: 50px;">
                <div class="search-input-group position-relative">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="destination" name="destination" placeholder="Bạn muốn đi đâu ?" class="form-control border-0 shadow-none bg-transparent">
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

                    <div id="guestPopup" class="guest-popup d-none">
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
                <div class="px-2">
                    <button type="submit" class="btn btn-search">Tìm Kiếm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container mt-5 mb-5 pb-2">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <h3 class="section-title">Tour Trải Nghiệm Nổi Bật <i class="fa-solid fa-fire text-warning" style="font-size: 1.2rem;"></i></h3>
        <a href="javascript:void(0)" class="view-more" onclick="slideTours('sliderNoiBat')">Xem thêm <i class="fa-solid fa-angle-right ms-1"></i></a>
    </div>

    <div class="tour-slider-container" id="sliderNoiBat">
        <?php if(!empty($toursNoiBat)): ?>
            <?php foreach($toursNoiBat as $tour): ?>
            <div class="tour-slider-item">
                <div class="card custom-card favorite-card">
                    <div class="card-img-wrapper">
                        <img src="public/image/location/<?= htmlspecialchars($tour['HinhAnh']) ?>" class="card-banner" alt="<?= htmlspecialchars($tour['TenTour']) ?>">
                        <span class="price-tag"><?= number_format($tour['Gia'], 0, ',', '.') ?> VNĐ</span>
                    </div>
                    <div class="card-body-tour">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h5 class="tour-title pe-2 mb-0"><?= htmlspecialchars($tour['TenTour']) ?></h5>
                            <div class="tour-rating"><i class="fa-solid fa-star"></i> 5.0 (120)</div>
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                            <div class="tour-location mb-0 pe-2 border-end">
                                <i class="fa-solid fa-location-dot text-danger"></i> <?= htmlspecialchars($tour['VungDiaLy']) ?>
                            </div>
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
                            </div>
                        </div>
                        <p class="tour-desc"><?= htmlspecialchars($tour['MoTa']) ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12"><p class="text-center text-muted">Chưa load được dữ liệu Database Tour Nổi bật.</p></div>
        <?php endif; ?>
    </div>
</div>

<div class="container mb-5 pb-2">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <h3 class="section-title">Tour Được Yêu Thích Nhất <span style="background-color: #FFB800; color: white; width: 28px; height: 28px; border-radius: 50%; display: inline-flex; justify-content: center; align-items: center; font-size: 0.9rem;"><i class="fa-solid fa-heart"></i></span></h3>
        <a href="javascript:void(0)" class="view-more" onclick="slideTours('sliderYeuThich')">Xem thêm <i class="fa-solid fa-angle-right ms-1"></i></a>
    </div>

    <div class="tour-slider-container" id="sliderYeuThich">
        <?php if(!empty($toursYeuThich)): ?>
            <?php foreach($toursYeuThich as $tour): ?>
            <div class="tour-slider-item">
                <div class="card custom-card favorite-card">
                    <div class="card-img-wrapper">
                        <img src="public/image/location/<?= htmlspecialchars($tour['HinhAnh']) ?>" class="card-banner" alt="<?= htmlspecialchars($tour['TenTour']) ?>">
                        <span class="price-tag"><?= number_format($tour['Gia'], 0, ',', '.') ?> VNĐ</span>
                    </div>
                    <div class="card-body-tour">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h5 class="tour-title pe-2 mb-0"><?= htmlspecialchars($tour['TenTour']) ?></h5>
                            <div class="tour-rating" style="color: #F29A2E;"><i class="fa-solid fa-heart"></i> 210 lượt</div>
                        </div>
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                            <div class="tour-location mb-0 pe-2 border-end">
                                <i class="fa-solid fa-location-dot text-danger"></i> <?= htmlspecialchars($tour['VungDiaLy']) ?>
                            </div>
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
                            </div>
                        </div>
                        <p class="tour-desc"><?= htmlspecialchars($tour['MoTa']) ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
             <div class="col-12"><p class="text-center text-muted">Chưa load được dữ liệu Database Tour Yêu Thích.</p></div>
        <?php endif; ?>
    </div>
</div>

<div class="container mb-5 pb-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <h3 class="section-title">Kinh Nghiệm Đi Tour <span style="background-color: #FFB800; color: white; width: 28px; height: 28px; border-radius: 50%; display: inline-flex; justify-content: center; align-items: center; font-size: 1rem;"><i class="fa-solid fa-check"></i></span></h3>
        <a href="#" class="view-more">Xem thêm <i class="fa-solid fa-angle-right ms-1"></i></a>
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
                        <p class="review-desc">Tour này gặp người bản địa thân thiện mà hỗ trợ mình nhiệt tình lắm luôn á, chuyến đi rất đáng nhớ, có cơ hội sẽ quay lại lần nữa. Mình đã ăn nhiều món ăn ở đây ...</p>
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
                        <p class="review-desc">Mình với nhỏ cot đã có một chuyến đi siêu duiii ở chợ nổi Cái Răng. Theo kinh nghiệm của tui thì mọi người không cần mang gì chỉ cần mang cái bụng đói tới ăn...</p>
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
                        <p class="review-desc">Hai vợ chồng mình sống ở thành thị bao năm nay mới được trải nghiệm hoạt động thú vị tới vậy. Thì ra làm nông cũng có cái vui. Mình được thử gọt lúa, hái rau, ...</p>
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
                        <p class="review-desc">Tour này thiệt sự giúp mình chữa lành rất là nhiều. Cứ nghĩ ngồi làm gốm bình thường thôi nhưng mà cảm giác rất thư giãn. Mình còn được mang cả gốm về ...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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

    function slideTours(containerId) {
        const container = document.getElementById(containerId);
        const scrollAmount = container.clientWidth; 
        
        if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 10) {
            container.scrollTo({ left: 0, behavior: 'smooth' });
        } else {
            container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
    }
</script>