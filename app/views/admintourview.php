<?php require_once 'app/views/layouts/header.php'; ?>
<style>
    body { background-color: #F8FAF5; font-family: 'Quicksand', sans-serif; }
    .admin-container { max-width: 1300px; margin: 40px auto; padding: 0 20px; }
    
    .admin-title { color: #0d5c2c; font-weight: 800; font-size: 28px; text-transform: uppercase; margin-bottom: 30px; display: inline-block; }
    .btn-orange-pill { background-color: #F29A2E; color: white; border-radius: 30px; font-weight: 700; padding: 10px 25px; border: none; float: right; transition: 0.3s; }
    .btn-orange-pill:hover { background-color: #d18222; color: white; transform: translateY(-2px); }

    /* Thanh Filter */
    .filter-bar { background: white; border-radius: 50px; padding: 10px 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; align-items: center; margin-bottom: 40px; gap: 15px; flex-wrap: wrap;}
    .filter-input-group { display: flex; align-items: center; border-right: 1px solid #eee; padding-right: 15px; flex-grow: 1; }
    .filter-input-group:last-child { border: none; }
    .filter-input-group i { color: #0d5c2c; margin-right: 10px; font-size: 1.1rem; }
    .filter-input-group input { border: none; outline: none; width: 100%; font-weight: 500; }
    .btn-search-green { background: #0d5c2c; color: white; border-radius: 30px; padding: 8px 25px; font-weight: 600; border: none; }
    .filter-tags { display: flex; gap: 10px; align-items: center; border-left: 1px solid #eee; padding-left: 15px; }
    .tag-pill { background: #EAF9DE; color: #0d5c2c; padding: 5px 15px; border-radius: 20px; font-size: 13px; font-weight: 600; cursor: pointer; border: 1px solid transparent;}
    .tag-pill.active { background: #0d5c2c; color: white; }

    /* Card Tour */
    .admin-tour-card { background: white; border-radius: 16px; overflow: hidden; border: 1px solid #f0f0f0; box-shadow: 0 4px 15px rgba(0,0,0,0.03); transition: 0.3s; display: flex; flex-direction: column; height: 100%; position: relative; }
    .admin-tour-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
    .atc-img-wrap { height: 200px; position: relative; }
    .atc-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
    
    .btn-edit-top { position: absolute; top: 0; left: 0; background: #0d5c2c; color: white; padding: 10px 15px; border-bottom-right-radius: 16px; font-size: 18px; z-index: 10; transition: 0.2s;}
    .btn-edit-top:hover { background: #F29A2E; color: white; }
    
    .badge-verified { position: absolute; top: 15px; right: 15px; background: #EAF9DE; color: #0d5c2c; font-weight: 700; font-size: 12px; padding: 5px 12px; border-radius: 20px; z-index: 10; display: flex; align-items: center; gap: 5px;}
    
    .atc-body { padding: 20px; display: flex; flex-direction: column; flex-grow: 1; }
    .atc-title-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 5px; }
    .atc-title { font-weight: 800; color: #222; font-size: 18px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;}
    .atc-rating { color: #FFB800; font-weight: 700; font-size: 14px; white-space: nowrap; }
    .atc-location { color: #777; font-size: 13px; margin-bottom: 20px; }
    
    .atc-stats { display: flex; justify-content: space-between; border-top: 1px solid #eee; padding-top: 15px; margin-top: auto; }
    .atc-stat-col { display: flex; flex-direction: column; }
    .atc-stat-label { font-size: 12px; color: #666; margin-bottom: 4px; }
    .atc-stat-val { font-weight: 800; color: #222; font-size: 16px; }

    /* Nút thêm mới bự */
    .add-new-card { border: 2px dashed #B4D6B5; background: #FAFAF5; display: flex; flex-direction: column; justify-content: center; align-items: center; color: #0d5c2c; cursor: pointer; }
    .add-new-card:hover { background: #EAF9DE; border-color: #0d5c2c; }
    .add-new-card i { font-size: 50px; margin-bottom: 15px; }
    .add-new-card span { font-weight: 800; font-size: 20px; }

    /* Form UI */
    .admin-form-subtitle { color: #666; font-size: 15px; margin-bottom: 30px; }
    .cover-upload-box { background: #EAECE8; border-radius: 16px; height: 250px; display: flex; flex-direction: column; justify-content: center; align-items: center; color: #666; cursor: pointer; position: relative; overflow: hidden; margin-bottom: 30px; transition: 0.3s;}
    .cover-upload-box:hover { background: #dfe1dc; }
    .cover-upload-box img { position: absolute; width: 100%; height: 100%; object-fit: cover; z-index: 1; display: none; }
    .cover-upload-content { position: relative; z-index: 2; text-align: center; }
    .cover-upload-content i { font-size: 35px; color: #0d5c2c; background: #EAF9DE; padding: 15px; border-radius: 50%; margin-bottom: 15px; }
    .cover-upload-content h5 { font-weight: 700; color: #333; margin-bottom: 5px; }
    .cover-upload-content p { font-size: 13px; color: #777; }

    .form-label-bold { font-weight: 800; color: #0d5c2c; font-size: 15px; text-transform: uppercase; margin-bottom: 10px; }
    .admin-input { background: #F4F5F0; border: 1px solid transparent; border-radius: 10px; padding: 12px 20px; font-weight: 500; transition: 0.3s; width: 100%; }
    .admin-input:focus { background: white; border-color: #0d5c2c; box-shadow: 0 0 0 3px rgba(13, 92, 44, 0.1); outline: none; }
    .admin-textarea { background: #F4F5F0; border: none; border-radius: 10px; padding: 20px; font-weight: 500; height: 180px; resize: none; width: 100%; }

    .right-panel { background: #FAFAF5; border-radius: 16px; padding: 30px; }
    .grid-2col { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px; }
    
    .gallery-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px; }
    .gallery-slot { background: #EAECE8; border-radius: 12px; aspect-ratio: 1/1; display: flex; justify-content: center; align-items: center; color: #999; font-size: 24px; cursor: pointer; transition: 0.2s;}
    .gallery-slot:hover { background: #dfe1dc; color: #0d5c2c;}

    .btn-submit-orange { background: #F29A2E; color: white; border-radius: 10px; padding: 12px; font-weight: 700; font-size: 16px; border: none; width: 100%; transition: 0.3s; margin-bottom: 15px;}
    .btn-submit-orange:hover { background: #d18222; }
    .btn-outline-action { background: transparent; color: #0d5c2c; border: 1px solid #B4D6B5; border-radius: 10px; padding: 12px; font-weight: 700; font-size: 16px; width: 100%; transition: 0.3s; }
    .btn-outline-action:hover { background: #EAF9DE; }
    .btn-outline-danger { background: transparent; color: #dc3545; border: 1px solid #dc3545; border-radius: 10px; padding: 12px; font-weight: 700; font-size: 16px; width: 100%; transition: 0.3s; }
    .btn-outline-danger:hover { background: #dc3545; color: white; }
</style>

<div class="breadcrumb-custom">
    <a href="index.php?controller=adminhome"><i class="fa-solid fa-house me-1"></i>Trang chủ</a> 
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <a href="index.php?controller=admintour">Quản lý tour</a>
    
    <?php if ($viewMode !== 'list'): ?>
        <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
        <span class="text-muted fw-bold">
            <?= ($viewMode === 'edit') ? 'Chỉnh sửa: ' . htmlspecialchars($tourData['TenTour']) : 'Thêm tour mới' ?>
        </span>
    <?php endif; ?>
</div>

<div class="admin-container">

<?php if ($viewMode === 'list'): ?>
    <div>
        <h2 class="admin-title">QUẢN LÝ TOUR</h2>
        <a href="index.php?controller=admintour&action=add" class="btn btn-orange-pill">Thêm tour mới</a>
    </div>

    <div class="filter-bar">
        <div class="filter-input-group" style="flex: 2;">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Bạn muốn tìm gì ?">
        </div>
        <div class="filter-input-group">
            <i class="fa-regular fa-calendar"></i>
            <input type="text" placeholder="Thời gian">
        </div>
        <div class="filter-input-group">
            <i class="fa-solid fa-location-dot"></i>
            <input type="text" placeholder="Địa điểm">
        </div>
        <button class="btn-search-green">Tìm Kiếm</button>
        
        <div class="filter-tags">
            <span class="tag-pill active">Chọn tất cả</span>
            <span class="tag-pill">Đang mở</span>
            <span class="tag-pill">Đã đóng</span>
            <span class="tag-pill bg-transparent border-0 text-muted ps-0">More Filters</span>
        </div>
    </div>

    <div class="row g-4">
        <?php foreach ($tours as $tour): ?>
            <div class="col-md-6 col-lg-4">
                <div class="admin-tour-card">
                    <a href="index.php?controller=admintour&action=edit&id=<?= $tour['MaTour'] ?>" class="btn-edit-top" title="Chỉnh sửa Tour">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <div class="badge-verified">Đã xác thực <i class="fa-solid fa-circle-check"></i></div>
                    
                    <div class="atc-img-wrap">
                        <img src="<?= htmlspecialchars(!empty($tour['HinhAnh']) && strpos($tour['HinhAnh'], 'public/') === 0 ? $tour['HinhAnh'] : 'public/' . $tour['HinhAnh']) ?>" alt="<?= htmlspecialchars($tour['TenTour']) ?>">
                    </div>
                    
                    <div class="atc-body">
                        <div class="atc-title-row">
                            <div class="atc-title"><?= htmlspecialchars($tour['TenTour']) ?></div>
                            <div class="atc-rating"><i class="fa-solid fa-star"></i> 5.0 (120)</div>
                        </div>
                        <div class="atc-location"><?= htmlspecialchars($tour['DiaDiem']) ?></div>
                        
                        <div class="atc-stats">
                            <div class="atc-stat-col">
                                <span class="atc-stat-label">Giá</span>
                                <span class="atc-stat-val"><?= number_format($tour['Gia'], 0, ',', '.') ?> VNĐ</span>
                            </div>
                            <div class="atc-stat-col text-end">
                                <span class="atc-stat-label">Số lượt đăng ký</span>
                                <span class="atc-stat-val"><?= $tour['SoLuotDangKy'] ?>/<?= $tour['SoKhachToiDa'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="col-md-6 col-lg-4">
            <a href="index.php?controller=admintour&action=add" class="text-decoration-none">
                <div class="admin-tour-card add-new-card">
                    <i class="fa-solid fa-circle-plus"></i>
                    <span>Thêm tour mới</span>
                </div>
            </a>
        </div>
    </div>

<?php else: ?>
    <?php 
        $isEdit = ($viewMode === 'edit');
        $title = $isEdit ? htmlspecialchars($tourData['TenTour']) : "Thêm tour mới";
        $subtitle = $isEdit ? "Hãy chỉnh sửa thông tin cho trải nghiệm du lịch thật hoàn hảo!" : "Hãy chia sẻ những góc nhìn của bạn về thế giới, tạo một trải nghiệm du lịch thật thú vị nào!";
        $actionUrl = $isEdit ? "index.php?controller=admintour&action=edit&id={$tourData['MaTour']}" : "index.php?controller=admintour&action=add";
    ?>

    <div class="mb-2" style="font-size: 13px; font-weight: 700; color: #666; text-transform: uppercase;">QUẢN LÝ TOUR</div>
    <h2 class="admin-title mb-1" style="font-size: 32px;"><?= $title ?></h2>
    <p class="admin-form-subtitle"><?= $subtitle ?></p>

    <form action="<?= $actionUrl ?>" method="POST" enctype="multipart/form-data">
        <div class="cover-upload-box" onclick="document.getElementById('coverImageInput').click();">
            <?php if ($isEdit && !empty($tourData['HinhAnh'])): ?>
                <img src="<?= strpos($tourData['HinhAnh'], 'public/') === 0 ? $tourData['HinhAnh'] : 'public/' . $tourData['HinhAnh'] ?>" id="coverPreview" style="display: block;">
                <div class="cover-upload-content" style="background: rgba(255,255,255,0.85); padding: 15px; border-radius: 12px; display: none;" id="coverOverlay">
            <?php else: ?>
                <img src="" id="coverPreview">
                <div class="cover-upload-content" id="coverOverlay">
            <?php endif; ?>
                <i class="fa-solid fa-camera-retro"></i>
                <h5>Upload Cover Image</h5>
                <p>Những bức ảnh phong cảnh hoặc hoạt động trải nghiệm thú vị là một lựa chọn không tồi cho background đấy!</p>
            </div>
            <input type="file" name="coverImage" id="coverImageInput" accept="image/*" class="d-none" onchange="previewCover(this)">
        </div>

        <div class="row g-5">
            <div class="col-lg-7">
                <div class="mb-4">
                    <label class="form-label-bold">TÊN TOUR</label>
                    <input type="text" name="tenTour" class="admin-input" placeholder="Ví dụ: Tham quan Đồi thông hai mộ ở Đà Lạt" value="<?= $isEdit ? htmlspecialchars($tourData['TenTour']) : '' ?>" required>
                </div>
                
                <div class="mb-4">
                    <label class="form-label-bold">ĐỊA ĐIỂM</label>
                    <div class="position-relative">
                        <i class="fa-solid fa-location-dot position-absolute" style="top: 15px; left: 18px; color: #0d5c2c;"></i>
                        <input type="text" name="diaDiem" class="admin-input" style="padding-left: 45px;" placeholder="Đà Lạt, Lâm Đồng, Việt Nam" value="<?= $isEdit ? htmlspecialchars($tourData['DiaDiem']) : '' ?>" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label-bold">MÔ TẢ CHUYẾN ĐI</label>
                    <textarea name="moTa" class="admin-textarea" placeholder="Nhập mô tả..." required><?= $isEdit ? htmlspecialchars($tourData['MoTa']) : '' ?></textarea>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="right-panel">
                    <div class="grid-2col">
                        <div>
                            <label class="form-label-bold">GIÁ (VNĐ)</label>
                            <div class="position-relative">
                                <span class="position-absolute" style="top: 13px; left: 15px; color: #666; font-weight: 700;">đ</span>
                                <input type="text" name="gia" class="admin-input text-end fw-bold" value="<?= $isEdit ? number_format($tourData['Gia'], 0, ',', '.') : '' ?>" required oninput="formatCurrency(this)">
                            </div>
                        </div>
                        <div>
                            <label class="form-label-bold">THỜI LƯỢNG</label>
                            <div class="position-relative">
                                <span class="position-absolute" style="top: 13px; right: 15px; color: #666; font-weight: 600;">Ngày</span>
                                <input type="number" name="soNgay" class="admin-input text-center fw-bold" value="<?= $isEdit ? $tourData['SoNgay'] : '1' ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="grid-2col">
                        <div>
                            <label class="form-label-bold" style="font-size: 13px;">KHÁCH TỐI ĐA</label>
                            <div class="position-relative">
                                <i class="fa-solid fa-users position-absolute" style="top: 15px; left: 15px; color: #0d5c2c;"></i>
                                <input type="number" name="soKhachToiDa" class="admin-input text-center fw-bold" value="<?= $isEdit ? $tourData['SoKhachToiDa'] : '10' ?>" required>
                            </div>
                        </div>
                        <div>
                            <label class="form-label-bold" style="font-size: 13px;">VÙNG ĐỊA LÝ</label>
                            <select name="vungDiaLy" class="admin-input fw-bold" style="cursor: pointer;">
                                <?php 
                                    $vungMien = ['Tây Bắc', 'Đông Bắc', 'Đồng bằng sông Hồng', 'Bắc Trung Bộ', 'Nam Trung Bộ', 'Tây Nguyên', 'Đông Nam Bộ', 'Đồng bằng sông Cửu Long'];
                                    $currentVung = $isEdit ? $tourData['VungDiaLy'] : 'Đông Nam Bộ';
                                    foreach ($vungMien as $vung) {
                                        $sel = ($vung == $currentVung) ? 'selected' : '';
                                        echo "<option value=\"$vung\" $sel>$vung</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <label class="form-label-bold">ẢNH MINH HỌA CHUYẾN ĐI</label>
                    <div class="gallery-grid">
                        <div class="gallery-slot"><i class="fa-solid fa-plus"></i></div>
                        <div class="gallery-slot"><i class="fa-solid fa-plus"></i></div>
                        <div class="gallery-slot"><i class="fa-solid fa-plus"></i></div>
                        <div class="gallery-slot"><i class="fa-solid fa-plus"></i></div>
                    </div>
                    <p style="font-size: 12px; color: #777; margin-bottom: 25px;">Úp ít nhất 4 bức ảnh để minh hoạ cho chuyến đi nhé!</p>

                    <?php if ($isEdit): ?>
                        <button type="submit" class="btn-submit-orange">Lưu sửa đổi <i class="fa-solid fa-arrow-right ms-2"></i></button>
                        <a href="index.php?controller=admintour&action=delete&id=<?= $tourData['MaTour'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa Tour này? Toàn bộ dữ liệu liên quan sẽ bị mất!');" class="btn btn-outline-danger d-block text-center text-decoration-none">Xóa chuyến đi</a>
                    <?php else: ?>
                        <button type="submit" class="btn-submit-orange">Tạo chuyến đi <i class="fa-solid fa-arrow-right ms-2"></i></button>
                        <button type="button" class="btn-outline-action" onclick="window.location.href='index.php?controller=admintour'">Hủy bỏ</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </form>

    <script>
        function previewCover(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var img = document.getElementById('coverPreview');
                    img.src = e.target.result;
                    img.style.display = 'block';
                    
                    var box = document.querySelector('.cover-upload-box');
                    box.style.border = 'none';
                    
                    document.getElementById('coverOverlay').style.display = 'none';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        // Hiện overlay khi di chuột vào ảnh đã upload để báo hiệu có thể đổi ảnh
        document.querySelector('.cover-upload-box').addEventListener('mouseenter', function() {
            if (document.getElementById('coverPreview').src !== "") {
                document.getElementById('coverOverlay').style.display = 'block';
            }
        });
        document.querySelector('.cover-upload-box').addEventListener('mouseleave', function() {
            if (document.getElementById('coverPreview').src !== "" && document.getElementById('coverPreview').style.display !== 'none') {
                document.getElementById('coverOverlay').style.display = 'none';
            }
        });

        function formatCurrency(input) {
            let val = input.value.replace(/\D/g, '');
            if(val !== '') {
                input.value = parseInt(val, 10).toLocaleString('en-US');
            }
        }
    </script>
<?php endif; ?>

</div>

<?php require_once 'app/views/layouts/footer.php'; ?>