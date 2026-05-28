<link href="https://fonts.googleapis.com/css2?family=Quantico:wght@700&family=Quicksand:wght@500;600;700&family=Montserrat:wght@600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .tour-title-quantico { 
        font-family: 'Quantico', sans-serif !important; 
        font-weight: 700 !important; 
        font-size: 3.5rem !important;
        color: #00712D !important;
        text-shadow: 3px 3px 5px rgba(0, 113, 45, 0.25) !important;
    }
    .heading-quicksand { font-family: 'Quicksand', sans-serif; font-weight: 700; color: #333; font-size: 1.6rem; margin-bottom: 20px; }
    .tour-desc-text { color: #555; line-height: 1.8; font-size: 1.05rem; font-family: 'Quicksand', sans-serif; font-weight: 500; }
    .tour-detail-banner { width: 100%; height: 400px; object-fit: cover; object-position: center; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    .tour-meta i { color: #00712D; margin-right: 5px; }
    .tour-meta span { margin-right: 25px; font-weight: 600; font-size: 1.05rem; color: #444; font-family: 'Quicksand', sans-serif; }
    .sticky-booking-box { position: sticky; top: 90px; z-index: 10; }
    .booking-card { background: #FCFBF7; border-radius: 15px; padding: 25px; box-shadow: 0 8px 25px rgba(0,0,0,0.06); border: 1px solid #f0eee9; font-family: 'Quicksand', sans-serif;}
    .price-main-tag { color: #FF9F00; font-size: 2rem; font-weight: 800; font-family: 'Montserrat', sans-serif; }
    .custom-input, .qty-selector { border: 1px solid #00712D; border-radius: 8px; color: #555; font-weight: 600;}
    .qty-selector { padding: 8px 15px; background: #fff; }
    .btn-book-custom { background: #FF9E8E; color: #fff; font-weight: 700; border-radius: 25px; width: 60%; margin: 20px auto 0; display: block; border: none; padding: 12px; transition: 0.3s; font-size: 1.1rem; }
    .btn-book-custom:hover { background: #ff8672; }
    .timeline-item { position: relative; padding-left: 20px; border-left: 2px solid #00712D; margin-bottom: 25px; font-family: 'Quicksand', sans-serif;}
    .timeline-item::before { content: ''; position: absolute; left: -8px; top: 0; width: 14px; height: 14px; border-radius: 50%; background: #f39c12; }
    .timeline-time { color: #00712D; font-weight: 700; }
    .timeline-title { font-weight: 700; font-size: 1.1rem; }
</style>

<div class="container" style="padding-top: 30px; padding-bottom: 80px;">
    <div class="mb-3">
        <?php foreach($breadcrumb as $index => $b): ?>
            <?php if($index < count($breadcrumb) - 1): ?>
                <a href="<?= $b['url'] ?>" class="text-success text-decoration-none fw-bold"><?= $b['name'] ?></a> <span class="mx-1">></span>
            <?php else: ?>
                <span class="text-secondary fw-bold"><?= $b['name'] ?></span>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <div class="row">
        <div class="col-lg-8 pe-lg-4">
            <img src="<?= htmlspecialchars($tour['HinhAnh']) ?>" class="tour-detail-banner" alt="Banner">
            
            <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                <h1 class="tour-title-quantico"><?= htmlspecialchars($tour['TenTour']) ?></h1>
                
                <button id="heart_btn" class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 55px; height: 55px; border: 1px solid #eee;">
    <i id="heart_icon" class="fa-regular fa-heart fs-4" style="color: #ff7f61;"></i>
</button>
            </div>

            <div class="tour-meta mb-5 d-flex flex-wrap">
                <span><i class="fa-solid fa-location-dot text-danger"></i> <?= htmlspecialchars($tour['DiaDiem'] ?? $tour['VungDiaLy']) ?></span>
                <span><i class="fa-solid fa-star" style="color:#f39c12;"></i> 4.9 (120)</span>
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
                                <button type="button" class="btn p-0 border-0" onclick="changeQty(-1)">
                                    <i class="fa-solid fa-circle-chevron-left fs-4" style="color: #799580;"></i>
                                </button>
                                
                                <span id="qty_display" class="fw-bold fs-5 text-success">1</span>
                                
                                <button type="button" class="btn p-0 border-0" onclick="changeQty(1)">
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

                        <button type="submit" class="btn-book-custom">Đặt ngay</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // JS tính số lượng, đổi lại cách bắt event onclick cho button
    const basePrice = <?= $tour['Gia'] ?>;
    const maxQty = <?= $tour['SoKhachToiDa'] ?>;
    let currentQty = 1;

    function formatCurrency(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function changeQty(amount) {
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


</script>