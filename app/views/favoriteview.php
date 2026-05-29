<style>
    /* Bổ sung class mượn từ tourview để đồng bộ giao diện card */
    .tour-card { border: 1px solid #eee; border-radius: 12px; overflow: hidden; transition: 0.3s ease; height: 100%; box-shadow: 0 2px 10px rgba(0,0,0,0.03); background: white; }
    .tour-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
    .tour-img-wrapper { position: relative; height: 180px; overflow: hidden; padding: 8px 8px 0 8px; }
    .tour-img-wrapper img { width: 100%; height: 100%; object-fit: cover; border-radius: 10px; }
    .price-badge { position: absolute; top: 16px; right: 16px; background-color: var(--color-primary); color: white; padding: 4px 12px; border-radius: 20px; font-weight: 700; font-size: 0.85rem; }
    .tour-card-body { padding: 15px 20px; display: flex; flex-direction: column; flex-grow: 1; }
    .tour-title { font-weight: 700; font-size: 1.1rem; color: #333; margin-bottom: 8px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .hr-dashed { border-top: 2px dashed #ddd; margin: 15px 0; opacity: 1; }
    .heart-btn { cursor: pointer; user-select: none; transition: 0.2s; }
    .heart-btn:hover { opacity: 0.7; }
</style>

<main class="container py-4" style="min-height: 65vh;">
    <!-- Breadcrumb -->
    <div class="mb-3 text-muted small">
        <a href="?controller=home" class="text-decoration-none text-muted">Trang chủ</a> &gt; 
        <a href="?controller=favorite" class="text-decoration-none fw-bold" style="color: #7A9F5A;">Yêu thích</a>
    </div>

    <!-- Thanh tìm kiếm -->
    <div class="mb-5 mx-auto" style="max-width: 650px;">
        <form action="" method="GET" id="searchFavoriteForm" class="d-flex bg-white border rounded-pill overflow-hidden p-1 shadow-sm m-0" style="border-color: #e0e0e0 !important;">
            <?php if(isset($_GET['controller'])): ?>
                <input type="hidden" name="controller" value="<?= htmlspecialchars($_GET['controller']) ?>">
            <?php endif; ?>
            <?php if(isset($_GET['action'])): ?>
                <input type="hidden" name="action" value="<?= htmlspecialchars($_GET['action']) ?>">
            <?php endif; ?>

            <div class="d-flex align-items-center px-4 flex-grow-1">
                <i class="fa-solid fa-magnifying-glass text-muted me-3 fs-5"></i>
                <input type="text" name="search" class="form-control border-0 shadow-none p-0 fw-semibold" placeholder="Tìm kiếm tour yêu thích..." value="<?= htmlspecialchars($keyword) ?>" style="color: #444;">
            </div>
            <button type="submit" class="btn text-white fw-bold rounded-pill px-4 py-2" style="background-color: var(--color-primary-dark); transition: 0.3s;">
                Tìm kiếm
            </button>
        </form>
    </div>

    <!-- Số lượng tour & Nút Khám phá -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <?php if (empty($keyword)): ?>
                <p class="fw-bold mb-0 text-dark" style="font-size: 1.1rem;">Bạn đang có <?= $totalFavorites ?> tour trong danh sách chờ khám phá</p>
            <?php else: ?>
                <p class="fw-bold mb-0 text-dark" style="font-size: 1.1rem;">Tìm thấy <?= $totalFavorites ?> tour khớp với từ khóa "<?= htmlspecialchars($keyword) ?>"</p>
            <?php endif; ?>
        </div>
        <a href="?controller=tour" class="btn text-white fw-bold rounded-pill px-4 py-2 d-flex align-items-center gap-2 shadow-sm" style="background-color: #F29A2E; transition: 0.3s;">
            <i class="fa-solid fa-map-location-dot"></i> Khám phá
        </a>
    </div>

    <!-- Danh sách Grid Tour Yêu thích -->
    <?php if ($totalFavorites > 0): ?>
        <div class="row g-4 mb-5">
            <?php foreach ($favoriteTours as $tour): ?>
                <div class="col-md-4">
                    <div class="card tour-card border-0">
                        <div class="tour-img-wrapper">
                            <img src="<?= htmlspecialchars($tour['HinhAnh']) ?>" alt="Tour Image">
                            
                            <?php if (!empty($tour['UuDai']) && $tour['UuDai'] > 0): ?>
                                <?php 
                                    $gia_goc = $tour['Gia'];
                                    $ti_le_giam = $tour['UuDai']; 
                                    $phan_tram_giam = $ti_le_giam * 100; 
                                    $gia_da_giam = $gia_goc * (1 - $ti_le_giam); 
                                ?>
                                <span class="price-badge" style="background:#d35400;">
                                    <span style="text-decoration: line-through; font-size: 12px; color: #ffbc80; margin-right: 5px;">
                                        <?= number_format($gia_goc, 0, ',', '.') ?>đ
                                    </span>
                                    <span style="font-weight: bold;">
                                        <?= number_format($gia_da_giam, 0, ',', '.') ?>đ
                                    </span>
                                </span>
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2 px-2 py-1 fs-6">
                                    -<?= $phan_tram_giam ?>%
                                </span>
                            <?php else: ?>
                                <span class="price-badge"><?= number_format($tour['Gia'], 0, ',', '.') ?> VND</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="tour-card-body bg-white">
                            <div class="text-danger small mb-1 fw-bold text-uppercase">
                                <i class="fa-solid fa-location-dot me-1"></i> <?= htmlspecialchars($tour['DiaDiem'] ?? 'Đang cập nhật') ?>
                            </div>
                            
                            <h5 class="tour-title" title="<?= htmlspecialchars($tour['TenTour']) ?>">
                                <?= htmlspecialchars($tour['TenTour']) ?>
                            </h5>
                            
                            <div class="d-flex text-muted small mb-3 gap-3">
                                 <span><i class="fa-solid fa-user-group text-warning me-1"></i> Tối đa <?= $tour['SoKhachToiDa'] ?> người</span>
                                 <span><i class="fa-regular fa-clock text-warning me-1"></i> <?= $tour['SoNgay'] ?> ngày</span>
                            </div>
                            
                            <p class="text-muted small" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; flex-grow: 1; margin-bottom: 0;">
                                <?= htmlspecialchars($tour['MoTa']) ?>
                            </p>
                            
                            <hr class="hr-dashed">
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-warning fw-bold fs-6">
                                    <i class="fa-solid fa-star"></i> 
                                    <?= $tour['SaoTrungBinh'] ? round($tour['SaoTrungBinh'], 1) : '0' ?>
                                    <span class="text-muted fw-normal small ms-1">(<?= $tour['SoDanhGia'] ?>)</span>
                                </div>
                                
                                <div class="d-flex align-items-center gap-3">
                                    <!-- Trạng thái luôn là tim đỏ vì đang nằm trong danh sách yêu thích -->
                                    <span class="heart-btn text-muted" onclick="toggleHeart(this, '<?= $tour['MaTour'] ?>')">
                                        <i class="fa-solid fa-heart text-danger fs-5 align-middle"></i> 
                                        <span class="like-count align-middle"><?= $tour['SoLuotThich'] ?></span>
                                    </span>
                                    <!-- Thêm parameter &from=favorite vào link -->
                                    <a href="?controller=tourdetail&id=<?= $tour['MaTour'] ?>&from=favorite" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-bold">Chi tiết</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Phân trang -->
        <?php if ($totalPages > 1): ?>
        <nav class="mt-5">
            <ul class="pagination justify-content-center gap-2">
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link rounded text-success fw-bold" href="?<?= http_build_query(array_merge($_GET, ['page' => $page-1])) ?>"><i class="fa-solid fa-chevron-left"></i></a>
                </li>
                <?php for($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item"><a class="page-link rounded fw-bold <?= $page == $i ? 'bg-success text-white' : 'text-success' ?>" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a></li>
                <?php endfor; ?>
                <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link rounded text-success fw-bold" href="?<?= http_build_query(array_merge($_GET, ['page' => $page+1])) ?>"><i class="fa-solid fa-chevron-right"></i></a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>

    <?php else: ?>
        <!-- Exception Flow: Giao diện khi chưa có Tour yêu thích -->
        <div class="text-center py-5" style="background-color: #FFFDF0; border-radius: 16px; border: 1px dashed #B4D6B5;">
            <i class="fa-regular fa-heart text-muted mb-3" style="font-size: 4rem; opacity: 0.3;"></i>
            <h4 class="text-secondary mb-2">Danh sách yêu thích trống</h4>
            <p class="text-muted small mb-4">Bạn chưa chọn bất kỳ tour nào hoặc không có tour phù hợp với từ khóa.</p>
            <a href="?controller=tour" class="btn text-white rounded-pill px-5 py-2 fw-bold" style="background-color: var(--color-primary-dark);">
                Khám phá ngay
            </a>
        </div>
    <?php endif; ?>
</main>

<script>
    // Validate tầng View: Chặn người dùng nhấn Tìm kiếm nếu chưa nhập gì
    document.getElementById('searchFavoriteForm').addEventListener('submit', function(e) {
        const inputSearch = this.querySelector('input[name="search"]');
        if (inputSearch.value.trim() === '') {
            e.preventDefault(); // Ngăn submit tải lại trang
            inputSearch.focus(); // Focus vào ô nhập liệu
        }
    });

    // JS Xử lý Thả tim (Dùng chung function để tránh lỗi khi người dùng click vào tim)
    function toggleHeart(element, maTour) {
        const icon = element.querySelector('i');
        const countSpan = element.querySelector('.like-count');
        let count = parseInt(countSpan.innerText);

        element.style.pointerEvents = 'none'; 
        element.style.opacity = '0.5';

        // Gửi ajax request tới URL hiện tại (favoritecontroller)
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
                    // Tự động load lại trang để tour vừa gỡ biến mất khỏi danh sách yêu thích
                    window.location.reload(); 
                }
            } else {
                console.error("Lỗi từ server: ", data.message);
                alert("Lỗi thả tim: " + data.message);
            }
        })
        .catch(e => {
            element.style.pointerEvents = 'auto';
            element.style.opacity = '1';
            console.error("Lỗi fetch: ", e);
        });
    }
</script>