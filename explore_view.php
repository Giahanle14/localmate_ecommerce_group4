<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LocalMate - Khám Phá</title>
    <link href="https://fonts.googleapis.com/css?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --color-primary: #1A5336;
            --color-primary-dark: #123C27;
            --color-sidebar: #F9FBE7;
            --color-tag-bg: #F0F4C3;
            --color-tag-text: #829D64;
            --color-tag-active: #7A9F5A;
        }
        body { font-family: 'Quicksand', sans-serif; background-color: #FCFDF9; }
        .main-header { background-color: var(--color-primary); }
        
        .sidebar-filter { background-color: var(--color-sidebar); border-radius: 12px; padding: 20px; border: 1px solid #E6EECA; }
        .filter-tag { cursor: pointer; color: var(--color-tag-text); background: var(--color-tag-bg); transition: 0.2s; border: none; font-weight: 600; user-select: none; }
        .filter-tag:hover, .filter-tag.active, .filter-tag.bg-success { background-color: var(--color-tag-active) !important; color: white !important; }
        
        .section-title { background-color: var(--color-primary); color: white; display: inline-block; padding: 8px 24px; border-radius: 8px; font-weight: 600; font-size: 1.1rem;}
        
        .tour-card { border: 1px solid #eee; border-radius: 12px; overflow: hidden; transition: 0.3s ease; height: 100%; box-shadow: 0 2px 10px rgba(0,0,0,0.03); }
        .tour-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
        .tour-img-wrapper { position: relative; height: 180px; overflow: hidden; padding: 8px 8px 0 8px; }
        .tour-img-wrapper img { width: 100%; height: 100%; object-fit: cover; border-radius: 10px; }
        .price-badge { position: absolute; top: 16px; right: 16px; background-color: var(--color-primary); color: white; padding: 4px 12px; border-radius: 20px; font-weight: 700; font-size: 0.85rem; }
        .tour-card-body { padding: 15px 20px; }
        .tour-title { font-weight: 700; font-size: 1.1rem; color: #333; margin-bottom: 8px; }
        .hr-dashed { border-top: 2px dashed #ddd; margin: 15px 0; opacity: 1; }
        .heart-btn { cursor: pointer; user-select: none; }
        
        .carousel-container { position: relative; padding: 0 20px; }
        .carousel-track { display: flex; gap: 20px; overflow-x: auto; scroll-behavior: smooth; scroll-snap-type: x mandatory; scrollbar-width: none; }
        .carousel-track::-webkit-scrollbar { display: none; }
        .carousel-item-box { min-width: calc(33.333% - 14px); scroll-snap-align: start; position: relative; border-radius: 12px; overflow: hidden; height: 160px;}
        .carousel-item-box img { width: 100%; height: 100%; object-fit: cover; }
        .carousel-overlay { position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.6), transparent); padding: 15px; text-align: center; color: white; font-weight: bold; text-transform: uppercase; }
        .carousel-btn { position: absolute; top: 50%; transform: translateY(-50%); background: white; border: none; width: 35px; height: 35px; border-radius: 50%; box-shadow: 0 2px 5px rgba(0,0,0,0.2); color: var(--color-primary); z-index: 10; cursor: pointer;}
        .btn-prev { left: -5px; } .btn-next { right: -5px; }
    </style>
</head>
<body>

    <?php include 'partial/header.php'; ?>

    <main class="container-fluid px-4 py-4">
        <div class="mb-3">
            <a href="explore_controller.php" class="text-decoration-none" style="color: var(--color-tag-active);"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
        </div>

        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="sidebar-filter">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="filter-title"><i class="fa-solid fa-filter"></i> Bộ lọc tìm kiếm</span>
                        <a href="#" onclick="resetFilters(event)" class="text-success text-decoration-none small"><i class="fa-solid fa-rotate-right"></i> Làm mới</a>
                    </div>
                    
                    <form action="explore_controller.php" method="GET" id="filterForm">
                        <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort); ?>">
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Bạn muốn đi đâu?</label>
                            <select class="form-select text-muted" name="vung" onchange="this.form.submit()">
                                <option value="">Chọn vùng địa lý...</option>
                                <option value="Tây Bắc" <?php echo ($vung == 'Tây Bắc') ? 'selected' : ''; ?>>Tây Bắc</option>
                                <option value="Đông Nam Bộ" <?php echo ($vung == 'Đông Nam Bộ') ? 'selected' : ''; ?>>Đông Nam Bộ</option>
                                <option value="Nam Trung Bộ" <?php echo ($vung == 'Nam Trung Bộ') ? 'selected' : ''; ?>>Nam Trung Bộ</option>
                                <option value="Bắc Trung Bộ" <?php echo ($vung == 'Bắc Trung Bộ') ? 'selected' : ''; ?>>Bắc Trung Bộ</option>
                                <option value="Tây Nguyên" <?php echo ($vung == 'Tây Nguyên') ? 'selected' : ''; ?>>Tây Nguyên</option>
                                <option value="Đồng bằng sông Cửu Long" <?php echo ($vung == 'Đồng bằng sông Cửu Long') ? 'selected' : ''; ?>>Đồng bằng sông Cửu Long</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Số ngày</label>
                            <div class="d-flex gap-2">
                                <label class="badge border border-success rounded-pill py-2 px-3 <?php echo ($ngay == '1-2') ? 'bg-success text-white' : 'text-success bg-white'; ?>" style="cursor:pointer;">
                                    <input type="radio" name="ngay" value="1-2" class="d-none" onchange="this.form.submit()" <?php echo ($ngay == '1-2') ? 'checked' : ''; ?>> 1 - 2 ngày
                                </label>
                                <label class="badge border border-success rounded-pill py-2 px-3 <?php echo ($ngay == '2-3') ? 'bg-success text-white' : 'text-success bg-white'; ?>" style="cursor:pointer;">
                                    <input type="radio" name="ngay" value="2-3" class="d-none" onchange="this.form.submit()" <?php echo ($ngay == '2-3') ? 'checked' : ''; ?>> 2 - 3 ngày
                                </label>
                                <label class="badge border border-success rounded-pill py-2 px-3 <?php echo ($ngay == '3-5') ? 'bg-success text-white' : 'text-success bg-white'; ?>" style="cursor:pointer;">
                                    <input type="radio" name="ngay" value="3-5" class="d-none" onchange="this.form.submit()" <?php echo ($ngay == '3-5') ? 'checked' : ''; ?>> 3 - 5 ngày
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted small fw-bold">Loại trải nghiệm</label>
                            <div class="d-flex gap-2 flex-wrap exp-filter">
                                <?php 
                                $traiNghiemList = [
                                    'Văn hóa' => 'fa-masks-theater', 'Ẩm thực' => 'fa-utensils', 'Rừng cây' => 'fa-tree',
                                    'Chữa lành' => 'fa-heart-pulse', 'Núi non' => 'fa-mountain-sun', 'Tham quan' => 'fa-binoculars',
                                    'Biển đảo' => 'fa-umbrella-beach', 'Nông thôn' => 'fa-house-chimney-window', 'Sông nước' => 'fa-sailboat'
                                ];
                                foreach($traiNghiemList as $name => $icon): 
                                    $isActive = in_array($name, $loai);
                                ?>
                                    <label class="badge filter-tag rounded-pill py-2 px-3 <?php echo $isActive ? 'bg-success text-white' : ''; ?>">
                                        <input type="checkbox" name="loai[]" value="<?php echo $name; ?>" class="d-none" onchange="this.form.submit()" <?php echo $isActive ? 'checked' : ''; ?>>
                                        <?php echo $name; ?> <i class="fa-solid <?php echo $icon; ?> text-warning ms-1"></i>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Ngân sách tối đa</label>
                            <input type="range" name="gia_max" class="form-range" id="budgetSlider" min="0" max="5000000" step="50000" value="<?php echo htmlspecialchars($gia_max); ?>" onchange="this.form.submit()">
                            <div class="d-flex justify-content-between small text-muted mt-1 fw-bold">
                                <span>Từ 0 VNĐ</span>
                                <span id="budgetDisplay">Đến <?php echo number_format($gia_max, 0, ',', '.'); ?> VNĐ</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-9">
                
                <?php if ($is_filtering): ?>
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                        <h5 class="fw-bold mb-0 text-dark"><?php echo htmlspecialchars($page_title); ?></h5>
                        
                        <form method="GET" class="d-flex align-items-center">
                            <?php foreach($loai as $l): ?>
                                <input type="hidden" name="loai[]" value="<?php echo htmlspecialchars($l); ?>">
                            <?php endforeach; ?>
                            <input type="hidden" name="vung" value="<?php echo htmlspecialchars($vung); ?>">
                            <input type="hidden" name="ngay" value="<?php echo htmlspecialchars($ngay); ?>">
                            <input type="hidden" name="gia_max" value="<?php echo htmlspecialchars($gia_max); ?>">
                            
                            <label for="sort" class="me-2 text-muted small text-nowrap">Sắp xếp theo</label>
                            <select name="sort" id="sort" class="form-select form-select-sm rounded-pill shadow-sm" style="width: auto;" onchange="this.form.submit()">
                                <option value="yeu_thich" <?php echo $sort == 'yeu_thich' ? 'selected' : ''; ?>>Yêu thích nhất</option>
                                <option value="gia_thap" <?php echo $sort == 'gia_thap' ? 'selected' : ''; ?>>Giá thấp nhất</option>
                                <option value="gia_cao" <?php echo $sort == 'gia_cao' ? 'selected' : ''; ?>>Giá cao nhất</option>
                            </select>
                        </form>
                    </div>

                    <div class="row g-4 mb-5">
                        <?php if (count($danhSachTour) > 0): ?>
                            <?php foreach ($danhSachTour as $tour): ?>
                                <?php include 'tour_card_component.php'; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center py-5"><h5 class="text-muted">Không tìm thấy tour phù hợp.</h5></div>
                        <?php endif; ?>
                    </div>

                    <?php if ($totalPages > 1): ?>
                    <nav class="mt-4">
                        <ul class="pagination justify-content-center gap-2">
                            <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                                <a class="page-link rounded text-success fw-bold" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page-1])); ?>"><i class="fa-solid fa-chevron-left"></i></a>
                            </li>
                            <?php for($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item"><a class="page-link rounded fw-bold <?php echo $page == $i ? 'bg-success text-white' : 'text-success'; ?>" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>"><?= $i ?></a></li>
                            <?php endfor; ?>
                            <li class="page-item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
                                <a class="page-link rounded text-success fw-bold" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page+1])); ?>"><i class="fa-solid fa-chevron-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                    <?php endif; ?>

                <?php else: ?>
                    <div class="mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="section-title mb-0">Tour Mới Nhất</h4>
                            <a href="?page=1" class="text-warning text-decoration-none small fw-bold">Xem thêm ></a>
                        </div>
                        <div class="row g-4">
                            <?php foreach ($tourMoiNhat as $tour): ?>
                                <?php include 'tour_card_component.php'; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mb-5 bg-white p-4 rounded-4 shadow-sm border">
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
                                <a href="?loai[]=<?php echo urlencode($name); ?>" class="carousel-item-box text-decoration-none">
                                    <img src="<?php echo $img; ?>" alt="<?php echo $name; ?>">
                                    <div class="carousel-overlay">TOUR <?php echo mb_strtoupper($name, 'UTF-8'); ?></div>
                                </a>
                                <?php endforeach; ?>
                            </div>
                            <button class="carousel-btn btn-next" onclick="scrollCarousel('danhMucTrack', 1)"><i class="fa-solid fa-chevron-right"></i></button>
                        </div>
                    </div>

                    <div class="mb-5 bg-white p-4 rounded-4 shadow-sm border">
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
                                <a href="?vung=<?php echo urlencode($name); ?>" class="carousel-item-box text-decoration-none">
                                    <img src="<?php echo $img; ?>" alt="<?php echo $name; ?>">
                                    <div class="carousel-overlay">TOUR <?php echo mb_strtoupper($name, 'UTF-8'); ?></div>
                                </a>
                                <?php endforeach; ?>
                            </div>
                            <button class="carousel-btn btn-next" onclick="scrollCarousel('vungTrack', 1)"><i class="fa-solid fa-chevron-right"></i></button>
                        </div>
                    </div>
                    
                    <div class="mb-5 bg-white p-4 rounded-4 shadow-sm border">
                        <h4 class="section-title mb-4">Câu hỏi thường gặp</h4>
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item mb-2 border rounded">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button rounded fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                        1. Giá Tour áp dụng cho trẻ em sẽ như thế nào?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-muted small">
                                        Giá tour cho trẻ em dưới 5 tuổi thường được miễn phí (ngủ chung với bố mẹ). Trẻ em từ 5-10 tuổi tính 50% - 75% giá vé người lớn. Từ 11 tuổi trở lên sẽ được tính giá vé như người lớn.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item mb-2 border rounded">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed rounded fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                        2. Huỷ tour trước ngày đi sẽ phải chịu bao nhiêu phí?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-muted small">
                                        Tuỳ thuộc vào chính sách của từng đối tác trên LocalMate. Thông thường hủy trước 7 ngày sẽ được hoàn 100%, hủy từ 3-6 ngày hoàn 50%, và hủy dưới 3 ngày sẽ không được hoàn tiền.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item mb-2 border rounded">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed rounded fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                        3. Tôi cần chuẩn bị những gì trước khi tham gia tour?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body text-muted small">
                                        Bạn cần mang theo giấy tờ tùy thân hợp lệ (CMND/CCCD hoặc Passport). Nên chuẩn bị trang phục phù hợp với thời tiết và địa hình điểm đến, cùng với thuốc men cá nhân cơ bản.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endif; ?>

            </div>
        </div>
    </main>

    <?php include 'partial/footer.php'; ?>

    <script>
        // Xử lý mũi tên trượt ngang Carousel
        function scrollCarousel(trackId, direction) {
            const track = document.getElementById(trackId);
            const scrollAmount = track.clientWidth * 0.8; 
            track.scrollBy({ left: scrollAmount * direction, behavior: 'smooth' });
        }

        // JS: Làm mới bộ lọc - Không reload
        function resetFilters(e) {
            e.preventDefault(); 
            
            document.querySelector('select[name="vung"]').value = "";
            
            document.querySelectorAll('input[name="ngay"]').forEach(radio => {
                radio.checked = false;
                let lbl = radio.parentElement;
                lbl.classList.remove('bg-success', 'text-white');
                lbl.classList.add('bg-white', 'text-success');
            });

            document.querySelectorAll('input[name="loai[]"]').forEach(cb => {
                cb.checked = false;
                let lbl = cb.parentElement;
                lbl.classList.remove('bg-success', 'text-white');
            });

            let slider = document.getElementById('budgetSlider');
            if(slider) {
                slider.value = 5000000;
                document.getElementById('budgetDisplay').textContent = 'Đến 5.000.000 VNĐ';
            }
        }

        // Cập nhật text liên tục khi kéo thanh Slider Tiền
        const budgetSlider = document.getElementById('budgetSlider');
        const budgetDisplay = document.getElementById('budgetDisplay');
        if(budgetSlider && budgetDisplay) {
            budgetSlider.addEventListener('input', function() {
                let formattedValue = parseInt(this.value).toLocaleString('vi-VN');
                budgetDisplay.textContent = 'Đến ' + formattedValue + ' VNĐ';
            });
        }

        // Xử lý Thả tim
        function toggleHeart(element, maTour) {
            const icon = element.querySelector('i');
            const countSpan = element.querySelector('.like-count');
            let count = parseInt(countSpan.innerText);

            if (icon.classList.contains('fa-regular')) {
                icon.classList.replace('fa-regular', 'fa-solid');
                countSpan.innerText = count + 1;
            } else {
                icon.classList.replace('fa-solid', 'fa-regular');
                countSpan.innerText = count - 1;
            }

            fetch('toggle_heart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'ma_tour=' + encodeURIComponent(maTour)
            }).then(r => r.json()).catch(e => console.error(e));
        }
    </script>
</body>
</html>