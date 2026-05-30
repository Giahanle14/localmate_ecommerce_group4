<main class="container py-4" style="min-height: 65vh;">
    <div class="mb-3 text-muted small">
        <a href="?controller=home" class="text-decoration-none text-muted">Trang chủ</a> &gt; 
        <a href="?controller=favorite" class="text-decoration-none fw-bold" style="color: #7A9F5A;">Yêu thích</a>
    </div>

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
                <input type="text" name="search" class="form-control border-0 shadow-none p-0 fw-semibold" placeholder="Tìm kiếm tour yêu thích..." value="<?= htmlspecialchars($keyword ?? '') ?>" style="color: #444;">
            </div>
            <button type="submit" class="btn text-white fw-bold rounded-pill px-4 py-2" style="background-color: var(--color-primary-dark); transition: 0.3s;">
                Tìm kiếm
            </button>
        </form>
    </div>

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

    <?php if ($totalFavorites > 0): ?>
        <div class="row g-4 mb-5">
            <?php foreach ($favoriteTours as $tour): ?>
                <div class="col-md-4">
                    <?php include __DIR__ . '/../../public/component/tourcard.php'; ?>
                </div>
            <?php endforeach; ?>
        </div>

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
    document.getElementById('searchFavoriteForm').addEventListener('submit', function(e) {
        const inputSearch = this.querySelector('input[name="search"]');
        if (inputSearch.value.trim() === '') {
            e.preventDefault(); 
            inputSearch.focus(); 
        }
    });

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