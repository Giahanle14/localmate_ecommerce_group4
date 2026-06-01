<?php include 'app/views/layouts/header.php'; ?>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    body, .review-page-bg { background-color: #FDF9ED !important; }
    .review-container { font-family: 'Quicksand', sans-serif; padding-bottom: 100px; }

    .review-title { color: #F89B29; font-weight: 700; text-align: center; font-size: clamp(1.5rem, 4vw, 2rem); margin-bottom: 30px; }
    
    .review-card { background: #FFFFFF; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); max-width: 650px; margin: auto; overflow: hidden; }
    
    /* Gỡ bỏ CSS cứng, nhường lại cho class bootstrap quản lý */
    .tour-info-box { background: #EBF6E0; border-bottom: 1px solid #E2EEDB; }
    
    /* Hình ảnh cho phép full chiều ngang trên mobile, cố định trên PC */
    .tour-info-img { width: 100%; max-width: 150px; height: 100px; object-fit: cover; border-radius: 10px; flex-shrink: 0; }
    @media (max-width: 767px) {
        .tour-info-img { max-width: 100%; height: 180px; }
    }

    .tour-title { font-weight: 700; color: #1B3B2B; font-size: 1.2rem; margin-bottom: 8px; }
    .tour-meta { font-size: 0.9rem; color: #555; font-weight: 600; margin-bottom: 5px;}
    
    .form-body { background-color: #FFFFFF; }
    .section-title { 
        color: #333; 
        font-weight: 700; 
        font-size: 1.05rem; 
        margin-bottom: 12px; 
        display: block; 
        background: transparent; 
        padding: 0; 
    }
    
    .star-rating i { font-size: clamp(1.8rem, 5vw, 2.2rem); color: #888; cursor: pointer; margin: 0 5px; font-weight: 400; transition: 0.2s;} 
    .star-rating i.active { color: #FF9F00; font-weight: 900;} 
    
    .tag-checkbox { display: none !important; }
    .tag-label { border: 1px solid #00712D; border-radius: 25px; padding: 8px 18px; margin: 0 10px 15px 0; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; background: white; color: #00712D; font-weight: 600; font-size: 0.9rem; transition: all 0.3s;}
    .tag-checkbox:checked + .tag-label { border-color: #00712D; background-color: #F9E68F; color: #00712D; }
    
    .custom-textarea { border-radius: 12px; border: 1px solid #00712D; padding: 15px; font-weight: 500; width: 100%; margin-bottom: 30px; background-color: #ffffff; color: #00712D;}
    .custom-textarea:focus { outline: none; box-shadow: 0 0 5px rgba(0, 113, 45, 0.2); }
    
    .img-upload-box { border: 1px dashed #ccc; border-radius: 10px; padding: 15px; text-align: center; cursor: pointer; background: #fff; width: 90px; height: 90px; display: flex; flex-direction: column; justify-content: center; align-items: center; }
    
    .img-wrapper { position: relative; display: inline-block; margin-right: 10px; margin-bottom: 10px; }
    .preview-img { width: 90px; height: 90px; object-fit: cover; border-radius: 10px; border: 2px solid #00712D; }
    .btn-remove-img { position: absolute; top: -8px; right: -8px; background: #dc3545; color: white; border: none; border-radius: 50%; width: 22px; height: 22px; font-size: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; }

    /* CSS CHO TRẠNG THÁI "CHỈ ĐỌC" (READ-ONLY) */
    .readonly-form .star-rating { pointer-events: none; }
    .readonly-form .tag-label { pointer-events: none; cursor: default; }
    .readonly-form .custom-textarea { pointer-events: none; opacity: 0.8; }
    .readonly-form #upload_wrapper { display: none !important; }
    .readonly-form .btn-remove-img { display: none !important; }
</style>
<div class="breadcrumb-custom px-3">
    <a href="index.php?controller=home"><i class="fa-solid fa-house me-1"></i>Trang chủ</a> 
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <a href="index.php?controller=mytrip">Chuyến đi của tôi</a> 
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <span class="text-dark fw-bold">Đánh giá</span>
</div>
<div class="review-page-bg px-3">
    <div class="review-container pt-4">
        
        <h1 class="review-title">Đánh giá trải nghiệm</h1>

        <div class="review-card">
            <div class="tour-info-box d-flex flex-column flex-md-row gap-3 p-3 p-md-4 align-items-md-center">
            <?php 
                $hinhAnh = !empty($trip['HinhAnh']) ? $trip['HinhAnh'] : 'image/default-tour.png';
                $imgSrc = (strpos($hinhAnh, 'public/') === 0) ? $hinhAnh : 'public/' . $hinhAnh; 
            ?>
            <img src="<?= htmlspecialchars($imgSrc ?? '') ?>" class="tour-info-img" alt="Hình ảnh tour" onerror="this.src='public/image/default-tour.png'">
            
            <div class="d-flex flex-column justify-content-center">
                <p class="tour-meta mb-1" style="color: #d32f2f; text-transform: uppercase; font-size: 0.85rem; font-weight: 700;">
                    <i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($trip['DiaDiem'] ?? 'Đang cập nhật') ?>
                </p>
                <h5 style="color: #1B3B2B; font-weight: 800; margin-bottom: 8px; font-size: 1.2rem;">
                    <?= htmlspecialchars($trip['TenTour'] ?? '') ?>
                </h5>
                <p class="tour-meta mb-1" style="color: #555; font-size: 0.9rem; font-weight: 500;">
                    <i class="fa-regular fa-calendar-days" style="color: #888;"></i> 
                    <?= !empty($trip['NgayBatDau']) ? date('d/m/Y', strtotime($trip['NgayBatDau'])) : 'Đang cập nhật' ?> - 
                    <?= !empty($trip['NgayKetThuc']) ? date('d/m/Y', strtotime($trip['NgayKetThuc'])) : 'Đang cập nhật' ?>
                </p>
                <p class="tour-meta mb-0" style="color: #555; font-size: 0.9rem;">
                    Đã thanh toán: <strong style="color: #00712D; font-weight: 700;"><?= number_format($trip['TongGiaTien'] ?? 0, 0, ',', '.') ?> VNĐ</strong>
                </p>
            </div>
        </div>

            <div class="form-body p-3 p-md-4 p-lg-5">
                <?php $isReadOnly = !empty($review) ? 'readonly-form' : ''; ?>
                
                <form id="review_form" class="<?= $isReadOnly ?>" action="index.php?controller=review&action=<?= !empty($review) ? 'update' : 'store' ?>" method="POST" enctype="multipart/form-data">
                    
                    <?php if(!empty($review)): ?>
                        <input type="hidden" name="ma_dg" value="<?= htmlspecialchars($review['MaDG']) ?>">
                    <?php endif; ?>
                    <input type="hidden" name="ma_chuyen_di" value="<?= htmlspecialchars($trip['MaChuyenDi']) ?>">
                    <input type="hidden" name="ma_dk" value="<?= htmlspecialchars($trip['MaTK_DK'] ?? '') ?>">
                    <input type="hidden" name="so_sao" id="so_sao_input" value="<?= $review['SoSao'] ?? 0 ?>">
                    <div id="deleted_images_container"></div>

                    <div class="text-center mb-4">
                        <span class="section-title text-center">Bạn cảm thấy chuyến đi thế nào?</span>
                        <div class="star-rating" id="star_container">
                            <?php 
                            $soSao = $review['SoSao'] ?? 0;
                            for ($i = 1; $i <= 5; $i++) {
                                $class = ($i <= $soSao) ? 'fa-solid active' : 'fa-regular';
                                $color = ($i <= $soSao) ? '' : 'style="color: #888;"';
                                echo "<i class=\"$class fa-star\" data-val=\"$i\" $color></i>";
                            }
                            ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <span class="section-title">Điều gì làm bạn ấn tượng nhất?</span>
                        <div class="d-flex flex-wrap justify-content-center">
                            <?php 
                            $savedTags = explode(',', $review['DieuAnTuong'] ?? '');
                            $tags = [['Con người thân thiện', '🧑‍🤝‍🧑 Con người thân thiện'],['Cảnh quan đẹp', '🌱 Cảnh quan đẹp'],['Đáng tiền', '💸 Đáng tiền'],['Thức ăn ngon', '😋 Thức ăn ngon'],['Sự an toàn', '🛡️ Sự an toàn'],['Chất lượng dịch vụ', '🤝 Chất lượng dịch vụ']];
                            foreach($tags as $tag): 
                                $isChecked = in_array($tag[0], $savedTags) ? 'checked' : '';
                            ?>
                                <input type="checkbox" name="dieu_an_tuong[]" value="<?= $tag[0] ?>" id="<?= $tag[0] ?>" class="tag-checkbox" <?= $isChecked ?>>
                                <label for="<?= $tag[0] ?>" class="tag-label"><?= $tag[1] ?></label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mb-4">
                        <span class="section-title">Nhận xét (Tùy chọn)</span>
                        <textarea class="form-control custom-textarea" name="noi_dung" rows="4" placeholder="Hãy nhận xét về chuyến đi của bạn"><?= htmlspecialchars($review['NoiDung'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-2">
                        <span class="section-title">Thêm hình ảnh (Tùy chọn)</span>
                        
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end mt-3 gap-3">
                            <div class="d-flex flex-wrap gap-2">
                                <?php if (!empty($images)): ?>
                                    <?php foreach ($images as $img): ?>
                                        <img src="<?= htmlspecialchars($img['DuongDan']) ?>" onerror="this.style.display='none'" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;" title="Ảnh đã tải lên">
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                
                                <div id="preview_container" class="d-flex flex-wrap gap-2"></div>
                                
                                <label class="img-upload-box mb-0" for="file_upload" style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 80px; height: 80px; border: 2px dashed #ccc; border-radius: 8px; cursor: pointer; background: #fafafa; transition: 0.3s;">
                                    <i class="fa-regular fa-image" style="font-size: 1.5rem; color: #999;"></i>
                                    <span style="font-size: 0.65rem; color: #888; margin-top: 5px; font-weight: 600; text-align: center;">Thêm ảnh<br>mới</span>
                                </label>
                                <input type="file" name="hinh_anh[]" id="file_upload" style="display:none;" multiple accept="image/*">
                            </div>
                            
                            <div class="d-flex flex-sm-column gap-2" style="width: 100%; max-width: 200px;">
                                <button type="submit" class="btn fw-bold shadow-sm w-100" style="background-color: #00A32A; color: white; padding: 10px; border-radius: 8px; border: none;">
                                    <?= !empty($review) ? 'Cập nhật' : 'Gửi đánh giá' ?>
                                </button>
                                
                                <?php if(!empty($review)): ?>
                                    <a href="index.php?controller=review&action=delete&id=<?= $trip['MaChuyenDi'] ?>" class="btn fw-bold shadow-sm w-100" style="background-color: #FF0000; color: white; padding: 10px; border-radius: 8px; border: none; text-decoration: none; text-align: center;" onclick="return confirm('Bạn có chắc chắn muốn xóa bài đánh giá này?');">
                                        Xóa
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function enableEditMode() {
        document.getElementById('review_form').classList.remove('readonly-form'); 
        document.getElementById('btn_enable_edit').classList.add('d-none'); 
        document.getElementById('btn_submit').classList.remove('d-none');
    }

    function deleteExistingImage(maHA) {
        document.getElementById('img_' + maHA).style.display = 'none';
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'delete_images[]';
        input.value = maHA;
        document.getElementById('deleted_images_container').appendChild(input);
    }

    function confirmDelete(url) {
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: "Bạn có chắc chắn muốn xóa bài đánh giá này?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#a8d5ba',
            confirmButtonText: 'OK',
            cancelButtonText: 'Huỷ',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        })
    }

    const stars = document.querySelectorAll('#star_container i');
    const ratingInput = document.getElementById('so_sao_input');
    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            if (!document.getElementById('review_form').classList.contains('readonly-form')) {
                ratingInput.value = index + 1;
                stars.forEach((s, idx) => {
                    if (idx <= index) {
                        s.classList.remove('fa-regular');
                        s.classList.add('fa-solid', 'active');
                        s.style.color = ''; 
                    } else {
                        s.classList.remove('fa-solid', 'active');
                        s.classList.add('fa-regular');
                        s.style.color = '#888'; 
                    }
                });
            }
        });
    });

    document.getElementById('file_upload').addEventListener('change', function() {
        const container = document.getElementById('preview_container');
        Array.from(this.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const wrapper = document.createElement('div');
                wrapper.className = 'img-wrapper';
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'preview-img';
                
                wrapper.appendChild(img);
                container.appendChild(wrapper);
            }
            reader.readAsDataURL(file);
        });
    });
</script>
<?php include 'app/views/layouts/footer.php'; ?>