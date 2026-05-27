<?php include 'app/views/layouts/header.php'; ?>

<main class="container" style="padding-top: 60px; padding-bottom: 80px; max-width: 650px;">
    <div class="card shadow-sm" style="border-radius: var(--border-radius-lg); border: 1px solid #eee; overflow: hidden; background-color: #fff;">
        
        <div style="background-color: var(--color-primary-dark); color: white; padding: 25px; text-align: center;">
            <h3 style="margin: 0; font-weight: 700; font-family: var(--font-main);">Đánh giá chuyến đi</h3>
            <p style="margin: 6px 0 0 0; opacity: 0.85; font-size: 0.9rem;">Ý kiến của bạn sẽ giúp LocalMate cải thiện chất lượng dịch vụ tốt hơn!</p>
        </div>

        <div class="card-body" style="padding: 30px; font-family: var(--font-main);">
            
            <div class="mb-4 p-3" style="background-color: var(--color-primary-light); border-radius: var(--border-radius-md); color: var(--color-primary-dark);">
                <h5 style="font-weight: 800; margin-bottom: 10px;">
                    <i class="fa-solid fa-map-location-dot"></i> Tour: <?= htmlspecialchars($trip['TenTour']) ?>
                </h5>
                <p style="margin: 0; font-size: 0.9rem; font-weight: 600;">
                    <i class="fa-solid fa-location-dot text-danger"></i> Vùng địa lý: <?= htmlspecialchars($trip['VungDiaLy'] ?? 'Việt Nam') ?>
                </p>
                <p style="margin: 5px 0 0 0; font-size: 0.9rem; font-weight: 600;">
                    <i class="fa-regular fa-calendar-days"></i> Thời gian đi: <?= date('d/m/Y', strtotime($trip['NgayBatDau'])) ?> đến <?= date('d/m/Y', strtotime($trip['NgayKetThuc'])) ?>
                </p>
            </div>

            <form action="index.php?controller=rate&action=store" method="POST">
                <input type="hidden" name="ma_chuyen_di" value="<?= htmlspecialchars($trip['MaChuyenDi']) ?>">
                <input type="hidden" name="ma_dk" value="<?= htmlspecialchars($trip['MaDK']) ?>">

                <div class="mb-4">
                    <label class="form-label" style="font-weight: 700; color: #333;">Mức độ hài lòng</label>
                    <select name="so_sao" class="form-select" style="border-radius: 8px; font-weight: 600; max-width: 200px;">
                        <option value="5" selected>⭐⭐⭐⭐⭐ 5 - Tuyệt vời</option>
                        <option value="4">⭐⭐⭐⭐ 4 - Tốt</option>
                        <option value="3">⭐⭐⭐ 3 - Bình thường</option>
                        <option value="2">⭐⭐ 2 - Tạm được</option>
                        <option value="1">⭐ 1 - Kém</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="noi_dung" class="form-label" style="font-weight: 700; color: #333;">Nội dung nhận xét chi tiết</label>
                    <textarea class="form-control" id="noi_dung" name="noi_dung" rows="5" 
                              placeholder="Hãy chia sẻ cảm nghĩ của bạn về chuyến đi..." 
                              style="border-radius: var(--border-radius-md);" required></textarea>
                </div>

                <div class="d-flex gap-3 mt-4">
                    <a href="index.php?controller=mytrip&action=index" class="btn btn-light w-50" 
                       style="border-radius: 30px; font-weight: 700; padding: 12px; border: 1px solid #ddd;">
                        Quay lại
                    </a>
                    <button type="submit" class="btn w-50" 
                            style="background-color: var(--color-primary); color: white; border-radius: 30px; font-weight: 700; padding: 12px; border: none;">
                        Gửi đánh giá
                    </button>
                </div>
            </form>
            
        </div>
    </div>
</main>

<?php include 'app/views/layouts/footer.php'; ?>