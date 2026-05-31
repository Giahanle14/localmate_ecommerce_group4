<?php include 'app/views/layouts/header.php'; ?>

<div class="breadcrumb-custom px-3 px-lg-5">
    <a href="?controller=home">Trang chủ</a> > 
    <span style="color: #666;">Tour</span>
</div>
<main class="container-fluid px-3 px-lg-5 py-4" style="background-color: #FCFDF9;">

    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="sidebar-filter">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="filter-title fw-bold" style="color: #123C27;"><i class="fa-solid fa-filter me-2"></i>Bộ lọc tìm kiếm</span>
                    <a href="#" onclick="resetFilters(event)" class="text-success text-decoration-none small"><i class="fa-solid fa-rotate-right"></i> Làm mới</a>
                </div>
                
                <form action="" method="GET" id="filterForm">
                    <input type="hidden" name="controller" value="tour">
                    <?php if(!empty($_GET['view'])) echo '<input type="hidden" name="view" value="'.htmlspecialchars($_GET['view']).'">'; ?>
                    
                    <?php if(!empty($_GET['search'])): ?>
                        <input type="hidden" name="search" value="<?= htmlspecialchars($_GET['search']) ?>">
                    <?php endif; ?>
                    <?php if(!empty($_GET['guests'])): ?>
                        <input type="hidden" name="guests" value="<?= htmlspecialchars($_GET['guests']) ?>">
                    <?php endif; ?>
                    <?php if(!empty($_GET['date'])): ?>
                        <input type="hidden" name="date" value="<?= htmlspecialchars($_GET['date']) ?>">
                    <?php endif; ?>

                    <input type="hidden" name="sort" value="<?= htmlspecialchars($sort); ?>">
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Khu vực địa lý</label>
                        <select class="form-select text-muted fw-semibold" name="vung" onchange="this.form.submit()">
                            <option value="">Tất cả các vùng...</option>
                            <option value="Tây Bắc" <?= ($vung == 'Tây Bắc') ? 'selected' : ''; ?>>Tây Bắc</option>
                            <option value="Đông Nam Bộ" <?= ($vung == 'Đông Nam Bộ') ? 'selected' : ''; ?>>Đông Nam Bộ</option>
                            <option value="Nam Trung Bộ" <?= ($vung == 'Nam Trung Bộ') ? 'selected' : ''; ?>>Nam Trung Bộ</option>
                            <option value="Bắc Trung Bộ" <?= ($vung == 'Bắc Trung Bộ') ? 'selected' : ''; ?>>Bắc Trung Bộ</option>
                            <option value="Tây Nguyên" <?= ($vung == 'Tây Nguyên') ? 'selected' : ''; ?>>Tây Nguyên</option>
                            <option value="Đồng bằng sông Cửu Long" <?= ($vung == 'Đồng bằng sông Cửu Long') ? 'selected' : ''; ?>>Đồng bằng sông Cửu Long</option>
                            <option value="Đông Bắc" <?= ($vung == 'Đông Bắc') ? 'selected' : ''; ?>>Đông Bắc</option>
                            <option value="Đồng bằng sông Hồng" <?= ($vung == 'Đồng bằng sông Hồng') ? 'selected' : ''; ?>>Đồng bằng sông Hồng</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Thời lượng Tour</label>
                        <div class="d-flex gap-2 flex-wrap">
                            <label class="badge border border-success rounded-pill py-2 px-3 <?= ($ngay == '1-2') ? 'bg-success text-white' : 'text-success bg-white'; ?>" style="cursor:pointer;">
                                <input type="radio" name="ngay" value="1-2" class="d-none" onchange="this.form.submit()" <?= ($ngay == '1-2') ? 'checked' : ''; ?>> 1-2 ngày
                            </label>
                            <label class="badge border border-success rounded-pill py-2 px-3 <?= ($ngay == '2-3') ? 'bg-success text-white' : 'text-success bg-white'; ?>" style="cursor:pointer;">
                                <input type="radio" name="ngay" value="2-3" class="d-none" onchange="this.form.submit()" <?= ($ngay == '2-3') ? 'checked' : ''; ?>> 2-3 ngày
                            </label>
                            <label class="badge border border-success rounded-pill py-2 px-3 <?= ($ngay == '3-5') ? 'bg-success text-white' : 'text-success bg-white'; ?>" style="cursor:pointer;">
                                <input type="radio" name="ngay" value="3-5" class="d-none" onchange="this.form.submit()" <?= ($ngay == '3-5') ? 'checked' : ''; ?>> 3-5 ngày
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold">Loại trải nghiệm</label>
                        <div class="d-flex gap-2 flex-wrap">
                            <?php 
                            $traiNghiemList = [
                                'Văn hóa' => 'fa-masks-theater', 'Ẩm thực' => 'fa-utensils', 'Rừng cây' => 'fa-tree',
                                'Chữa lành' => 'fa-heart-pulse', 'Núi non' => 'fa-mountain-sun', 'Tham quan' => 'fa-binoculars',
                                'Biển đảo' => 'fa-umbrella-beach', 'Nông thôn' => 'fa-house-chimney-window', 'Sông nước' => 'fa-sailboat'
                            ];
                            foreach($traiNghiemList as $name => $icon): 
                                $isActive = in_array($name, $loai);
                            ?>
                                <label class="badge filter-tag rounded-pill py-2 px-3 <?= $isActive ? 'bg-success text-white' : ''; ?>">
                                    <input type="checkbox" name="loai[]" value="<?= $name; ?>" class="d-none" onchange="this.form.submit()" <?= $isActive ? 'checked' : ''; ?>>
                                    <?= $name; ?> <i class="fa-solid <?= $icon; ?> text-warning ms-1"></i>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Ngân sách tối đa</label>
                        <input type="range" name="gia_max" class="form-range" id="budgetSlider" min="0" max="5000000" step="50000" value="<?= htmlspecialchars($gia_max); ?>" onchange="this.form.submit()">
                        <div class="d-flex justify-content-between small text-muted mt-1 fw-bold">
                            <span>0đ</span>
                            <span id="budgetDisplay">Đến <?= number_format($gia_max, 0, ',', '.'); ?>đ</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-9">
            
            <?php if ($is_filtering): ?>
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 border-bottom pb-3 tour-header-mobile">
                    <h5 class="fw-bold mb-0" style="color: #123C27;"><?= htmlspecialchars($page_title); ?></h5>
                    
                    <form method="GET" class="d-flex align-items-center" action="">
                        <input type="hidden" name="controller" value="tour">
                        <?php if(!empty($_GET['view'])) echo '<input type="hidden" name="view" value="'.htmlspecialchars($_GET['view']).'">'; ?>
                        
                        <?php if(!empty($_GET['search'])) echo '<input type="hidden" name="search" value="'.htmlspecialchars($_GET['search']).'">'; ?>
                        <?php if(!empty($_GET['guests'])) echo '<input type="hidden" name="guests" value="'.htmlspecialchars($_GET['guests']).'">'; ?>
                        <?php if(!empty($_GET['date'])) echo '<input type="hidden" name="date" value="'.htmlspecialchars($_GET['date']).'">'; ?>

                        <?php foreach($loai as $l) echo '<input type="hidden" name="loai[]" value="'.htmlspecialchars($l).'">'; ?>
                        <input type="hidden" name="vung" value="<?= htmlspecialchars($vung); ?>">
                        <input type="hidden" name="ngay" value="<?= htmlspecialchars($ngay); ?>">
                        <input type="hidden" name="gia_max" value="<?= htmlspecialchars($gia_max); ?>">
                        
                        <label for="sort" class="me-2 text-muted small text-nowrap fw-bold">Sắp xếp theo</label>
                        <select name="sort" id="sort" class="form-select form-select-sm rounded-pill shadow-sm fw-semibold" style="width: auto; border-color: #E6EECA;" onchange="this.form.submit()">
                            <option value="moi_nhat" <?= $sort == 'moi_nhat' ? 'selected' : ''; ?>>Mới nhất</option>
                            <option value="yeu_thich" <?= $sort == 'yeu_thich' ? 'selected' : ''; ?>>Yêu thích nhất</option>
                            <option value="gia_thap" <?= $sort == 'gia_thap' ? 'selected' : ''; ?>>Giá thấp nhất</option>
                            <option value="gia_cao" <?= $sort == 'gia_cao' ? 'selected' : ''; ?>>Giá cao nhất</option>
                        </select>
                    </form>
                </div>

                <div class="row g-4 mb-5">
                    <?php if (count($danhSachTour) > 0): ?>
                        <?php foreach ($danhSachTour as $tour): ?>
                            <div class="col-12 col-md-6 col-lg-4">
                                <?php include 'public/component/tourcard.php'; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5">
                            <i class="fa-solid fa-magnifying-glass-location text-muted mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                            <h5 class="text-muted">Không tìm thấy tour phù hợp với tiêu chí của bạn.</h5>
                            <p class="text-muted small">Hãy thử thay đổi khu vực hoặc từ khóa tìm kiếm.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($totalPages > 1): ?>
                <nav class="mt-4">
                    <ul class="pagination justify-content-center gap-2">
                        <li class="page-item <?= $page <= 1 ? 'disabled' : ''; ?>">
                            <a class="page-link rounded text-success fw-bold" href="?<?= http_build_query(array_merge($_GET, ['page' => $page-1])); ?>"><i class="fa-solid fa-chevron-left"></i></a>
                        </li>
                        <?php for($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item"><a class="page-link rounded fw-bold <?= $page == $i ? 'bg-success text-white' : 'text-success'; ?>" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])); ?>"><?= $i ?></a></li>
                        <?php endfor; ?>
                        <li class="page-item <?= $page >= $totalPages ? 'disabled' : ''; ?>">
                            <a class="page-link rounded text-success fw-bold" href="?<?= http_build_query(array_merge($_GET, ['page' => $page+1])); ?>"><i class="fa-solid fa-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>

            <?php else: ?>
                <div class="mb-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="section-title mb-0">Tour Mới Nhất</h4>
                        <a href="?controller=tour&view=latest" class="text-warning text-decoration-none small fw-bold">Xem thêm ></a>
                    </div>
                    <div class="row g-4">
                        <?php foreach ($tourMoiNhat as $tour): ?>
                            <div class="col-12 col-md-6 col-lg-4">
                                <?php include 'public/component/tourcard.php'; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="mb-5 bg-white p-4 rounded-4 shadow-sm border" style="border-color: #E6EECA !important;">
                    <h4 class="section-title mb-4">Danh mục Tour</h4>
                    <div class="carousel-container">
                        <button class="carousel-btn btn-prev" onclick="scrollCarousel('danhMucTrack', -1)"><i class="fa-solid fa-chevron-left"></i></button>
                        <div class="carousel-track" id="danhMucTrack">
                            <?php 
                            $dmList = [
                                'Văn hóa' => 'https://dulichkhampha24.com/wp-content/uploads/2020/11/pho-co-hoi-an.jpg',
                                'Ẩm thực' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62',
                                'Rừng cây' => 'https://images.unsplash.com/photo-1555921015-5532091f6026',
                                'Chữa lành' => 'https://images.unsplash.com/photo-1528127269322-539801943592',
                                'Núi non' => 'https://images.unsplash.com/photo-1528127269322-539801943592',
                                'Tham quan' => 'https://ik.imagekit.io/tvlk/blog/2022/06/thanh-dia-my-son-18-1024x683.jpg',
                                'Biển đảo' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62',
                                'Nông thôn' => 'https://statics.vinpearl.com/du-lich-miet-vuon-2_1631758232.jpg',
                                'Sông nước' => 'https://statics.vinpearl.com/du-lich-miet-vuon-2_1631758232.jpg'
                            ];
                            foreach($dmList as $name => $img): ?>
                            <a href="?controller=tour&loai[]=<?= urlencode($name); ?>" class="carousel-item-box text-decoration-none">
                                <img src="<?= $img; ?>" alt="<?= $name; ?>">
                                <div class="carousel-overlay">TOUR <?= mb_strtoupper($name, 'UTF-8'); ?></div>
                            </a>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-btn btn-next" onclick="scrollCarousel('danhMucTrack', 1)"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>

                <div class="mb-5 bg-white p-4 rounded-4 shadow-sm border" style="border-color: #E6EECA !important;">
                    <h4 class="section-title mb-4">Tour theo vùng</h4>
                    <div class="carousel-container">
                        <button class="carousel-btn btn-prev" onclick="scrollCarousel('vungTrack', -1)"><i class="fa-solid fa-chevron-left"></i></button>
                        <div class="carousel-track" id="vungTrack">
                            <?php 
                            $vungList = [
                                'Tây Bắc' => 'https://images.unsplash.com/photo-1555921015-5532091f6026',
                                'Đông Nam Bộ' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62',
                                'Nam Trung Bộ' => 'https://dulichkhampha24.com/wp-content/uploads/2020/11/pho-co-hoi-an.jpg',
                                'Bắc Trung Bộ' => 'https://ik.imagekit.io/tvlk/blog/2022/06/thanh-dia-my-son-18-1024x683.jpg',
                                'Tây Nguyên' => 'https://cdn.baogialai.com.vn/images/f4c793ae414c7709dde37c6d2a83f82a914c029a03c23dab2d8d608c1b6e8c00472eee30008037ef92bc717341952b4b178b17c33c42f5e0c754be353b22aa31b5d063796d0a1ac7e134c2d3278545fc9c00fd9c8c03bee5ecfb436e1695f2e0481e2fc525c184ff7398ced5988bde36/le-hoi-tay-son-thuong-dao-hang-nam-dien-ra-tai-an-khe-anh-nhat-hanh.jpg',
                                'Đồng bằng sông Cửu Long' => 'https://statics.vinpearl.com/du-lich-miet-vuon-2_1631758232.jpg'
                            ];
                            foreach($vungList as $name => $img): ?>
                            <a href="?controller=tour&vung=<?= urlencode($name); ?>" class="carousel-item-box text-decoration-none">
                                <img src="<?= $img; ?>" alt="<?= $name; ?>">
                                <div class="carousel-overlay">TOUR <?= mb_strtoupper($name, 'UTF-8'); ?></div>
                            </a>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-btn btn-next" onclick="scrollCarousel('vungTrack', 1)"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                </div>

            <?php endif; ?>

        </div>
    </div>
</main>

<script>
    function scrollCarousel(trackId, direction) {
        const track = document.getElementById(trackId);
        const scrollAmount = track.clientWidth * 0.8; 
        track.scrollBy({ left: scrollAmount * direction, behavior: 'smooth' });
    }

    const budgetSlider = document.getElementById('budgetSlider');
    const budgetDisplay = document.getElementById('budgetDisplay');
    if(budgetSlider && budgetDisplay) {
        budgetSlider.addEventListener('input', function() {
            let formattedValue = parseInt(this.value).toLocaleString('vi-VN');
            budgetDisplay.textContent = 'Đến ' + formattedValue + 'đ';
        });
    }

    function resetFilters(e) {
        e.preventDefault();
        window.location.href = '?controller=tour';
    }

    function toggleHeart(element, maTour) {
        const icon = element.querySelector('i');
        const countSpan = element.querySelector('.like-count');
        let count = parseInt(countSpan.innerText);

        element.style.pointerEvents = 'none'; 
        element.style.opacity = '0.5';

        fetch(window.location.href, {
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

<?php include 'app/views/layouts/footer.php'; ?>