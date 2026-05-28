<?php include 'app/views/layouts/header.php'; ?>

<style>
    body { background-color: #FCFDF9; font-family: 'Quicksand', sans-serif; }
    
    /* Breadcrumb */
    .breadcrumb-custom { padding: 15px 0; font-weight: 700; font-size: 1.05rem; }
    .breadcrumb-custom a { color: #0d5c2c; text-decoration: none; transition: 0.2s;}
    .breadcrumb-custom a:hover { opacity: 0.7; }
    .breadcrumb-custom span { color: #6c757d; }
    
    /* Stepper (Thanh tiến trình) */
    /* ĐÃ SỬA FONT THÀNH QUICKSAND */
    .booking-title { font-family: 'Quicksand', sans-serif; font-weight: 800; font-size: 2.8rem; color: #0d5c2c; text-align: center; margin-bottom: 30px; text-shadow: 2px 2px 4px rgba(0,0,0,0.05);}
    
    .stepper-container { display: flex; justify-content: center; align-items: center; margin-bottom: 50px; gap: 15px;}
    .step-item { display: flex; flex-direction: column; align-items: center; width: 120px;}
    .step-circle { width: 75px; height: 75px; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 2rem; color: white; margin-bottom: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);}
    .step-circle.active { background-color: #0d5c2c; }
    .step-circle.inactive { background-color: #d1d5db; }
    .step-text { font-weight: 700; color: #0d5c2c; font-size: 1rem; text-align: center; white-space: nowrap;}
    .step-arrow { color: #0d5c2c; font-size: 1.5rem; font-weight: 900; margin-top: -30px;}

    /* Bảng thông tin Form bên trái */
    .booking-form-card { background-color: #FDFEF5; border-radius: 25px; padding: 40px; }
    .section-header { color: #0d5c2c; font-weight: 800; font-size: 1.4rem; margin-bottom: 20px; margin-top: 10px;}
    .form-label { color: #0d5c2c; font-weight: 700; font-size: 1.05rem;}
    .form-control { border: 1.5px solid #E8A855; border-radius: 10px; padding: 12px 15px; background: white; font-weight: 600; color: #333;}
    .form-control:focus { box-shadow: none; border-color: #0d5c2c; }
    
    /* Box đếm số lượng khách */
    .pax-box { border: 1.5px solid #E8A855; background: white; border-radius: 10px; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;}
    .pax-title { font-weight: 800; color: #111; font-size: 1.1rem; margin-bottom: 2px;}
    .pax-subtitle { font-size: 0.8rem; color: #666; font-weight: 600;}
    .pax-controls { display: flex; align-items: center; gap: 15px; font-size: 1.3rem; font-weight: 800;}
    .pax-btn { background: none; border: none; font-size: 1.5rem; font-weight: 900; color: #111; cursor: pointer; padding: 0 10px;}
    
    /* Tóm tắt chuyến đi bên phải */
    .summary-card { background-color: white; border-radius: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border: 1px solid #f0f0f0; overflow: hidden; padding-bottom: 30px;}
    .summary-img { width: 100%; height: 200px; object-fit: cover;}
    .summary-body { padding: 25px 30px; }
    .summary-title { font-weight: 800; font-size: 1.3rem; color: #111; margin-bottom: 8px;}
    .summary-location { color: #d32f2f; font-weight: 600; font-size: 0.9rem; margin-bottom: 15px;}
    .summary-desc { color: #666; font-size: 0.9rem; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 20px;}
    
    .summary-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; font-weight: 600; color: #333;}
    .summary-label { color: #555; }
    .hr-divider { border-top: 1px solid #e0e0e0; margin: 20px 0; opacity: 1;}
    
    /* ĐÃ SỬA FONT THÀNH QUICKSAND CHO BUTTON THANH TOÁN */
    .btn-payment { background-color: #F28C28; color: white; font-family: 'Quicksand', sans-serif; font-weight: 800; font-size: 1.6rem; border-radius: 20px; padding: 15px; width: 100%; border: none; box-shadow: 0 6px 15px rgba(242, 140, 40, 0.3); transition: 0.3s;}
    
    .btn-payment:hover { background-color: #e67e22; transform: translateY(-3px);}
    .terms-check { font-weight: 600; font-size: 0.9rem; color: #111;}
    .terms-check a { color: #0275d8; text-decoration: none;}
</style>

<div class="container" style="max-width: 1200px;">
    <div class="breadcrumb-custom">
        <a href="?controller=home">Trang chủ</a> > 
        <a href="?controller=tour">Tour</a> > 
        <a href="?controller=tourdetail&id=<?= htmlspecialchars($tour['MaTour']) ?>">Chi tiết tour</a> > 
        <span>Đặt tour</span>
    </div>

    <h1 class="booking-title">Đặt Tour</h1>
    <div class="stepper-container">
        <div class="step-item">
            <div class="step-circle active"><i class="fa-solid fa-clipboard-list"></i></div>
            <div class="step-text">Nhập thông tin</div>
        </div>
        <div class="step-arrow">>></div>
        <div class="step-item">
            <div class="step-circle inactive"><i class="fa-regular fa-credit-card"></i></div>
            <div class="step-text">Thanh toán</div>
        </div>
        <div class="step-arrow">>></div>
        <div class="step-item">
            <div class="step-circle inactive"><i class="fa-solid fa-check"></i></div>
            <div class="step-text">Hoàn tất</div>
        </div>
    </div>

    <form action="index.php?controller=tourbooking&action=process" method="POST" id="bookingForm">
        <input type="hidden" name="ma_tour" value="<?= htmlspecialchars($tour['MaTour']) ?>">
        <input type="hidden" name="ngay_bat_dau" value="<?= htmlspecialchars($ngayDi) ?>">
        <input type="hidden" name="ngay_ket_thuc" value="<?= htmlspecialchars($ngayKetThuc) ?>">

        <div class="row g-5 mb-5">
            <div class="col-lg-7">
                <div class="booking-form-card shadow-sm">
                    <h3 class="section-header">Thông tin liên lạc</h3>
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Họ tên</label>
                            <input type="text" name="ho_ten" class="form-control" value="<?= htmlspecialchars($userInfo['HoTen'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Điện thoại</label>
                            <input type="tel" name="dien_thoai" class="form-control" value="<?= htmlspecialchars($userInfo['SDT'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($userInfo['Gmail'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Địa chỉ</label>
                            <input type="text" name="dia_chi" class="form-control" value="<?= htmlspecialchars($userInfo['DiaChi'] ?? '') ?>" required>
                        </div>
                    </div>

                    <h3 class="section-header mt-5">Du khách</h3>
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="pax-box">
                                <div>
                                    <div class="pax-title">Người lớn</div>
                                    <div class="pax-subtitle">Từ 12 tuổi trở lên</div>
                                </div>
                                <div class="pax-controls">
                                    <button type="button" class="pax-btn" onclick="updatePax('adult', -1)">-</button>
                                    <span id="val_adult"><?= htmlspecialchars($soLuong) ?></span>
                                    <button type="button" class="pax-btn" onclick="updatePax('adult', 1)">+</button>
                                    <input type="hidden" name="sl_nguoi_lon" id="input_adult" value="<?= htmlspecialchars($soLuong) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pax-box">
                                <div>
                                    <div class="pax-title">Trẻ em</div>
                                    <div class="pax-subtitle">Từ 2 - 11 tuổi</div>
                                </div>
                                <div class="pax-controls">
                                    <button type="button" class="pax-btn" onclick="updatePax('child', -1)">-</button>
                                    <span id="val_child">0</span>
                                    <button type="button" class="pax-btn" onclick="updatePax('child', 1)">+</button>
                                    <input type="hidden" name="sl_tre_em" id="input_child" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pax-box">
                                <div>
                                    <div class="pax-title">Em bé</div>
                                    <div class="pax-subtitle">Dưới 2 tuổi</div>
                                </div>
                                <div class="pax-controls">
                                    <button type="button" class="pax-btn" onclick="updatePax('infant', -1)">-</button>
                                    <span id="val_infant">0</span>
                                    <button type="button" class="pax-btn" onclick="updatePax('infant', 1)">+</button>
                                    <input type="hidden" name="sl_em_be" id="input_infant" value="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3 class="section-header mt-5">Ghi chú</h3>
                    <textarea class="form-control" name="ghi_chu" rows="4"></textarea>
                </div>
            </div>

            <div class="col-lg-5">
                <h3 class="section-header" style="margin-top: 0;">Tóm tắt chuyến đi</h3>
                <div class="summary-card">
                    <img src="<?= htmlspecialchars($tour['HinhAnh']) ?>" class="summary-img" alt="Tour Image">
                    
                    <div class="summary-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <h4 class="summary-title w-75"><?= htmlspecialchars($tour['TenTour']) ?></h4>
                            <div class="text-warning fw-bold"><i class="fa-solid fa-star"></i> <?= $tour['SaoTrungBinh'] ? round($tour['SaoTrungBinh'],1) : '5.0' ?> <span class="text-muted fw-normal small">(<?= $tour['SoDanhGia'] ?>)</span></div>
                        </div>
                        <div class="summary-location"><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($tour['DiaDiem'] ?? $tour['VungDiaLy']) ?></div>
                        
                        <div class="summary-desc"><?= htmlspecialchars($tour['MoTa']) ?></div>
                        
                        <h5 class="fw-bold mt-4 mb-3" style="color: #333; font-size: 1.1rem;">Thời gian</h5>
                        <div class="p-3 bg-light rounded text-center fw-bold" style="color: #444; border: 1px solid #eee;">
                            07:00 | <?= date('d/m/Y', strtotime($ngayDi)) ?> - 17:00 | <?= date('d/m/Y', strtotime($ngayKetThuc)) ?>
                        </div>
                        
                        <div class="hr-divider"></div>
                        
                        <div class="summary-row">
                            <span class="summary-label text-dark fw-bold" style="font-size: 1.1rem;">Khách hàng + Phụ thu</span>
                            <span class="fs-5" id="sum_subtotal"><?= number_format($tour['Gia'] * $soLuong, 0, ',', '.') ?> đ</span>
                        </div>
                        <div class="summary-row small text-muted mb-4">
                            <span id="sum_pax_text">Người lớn</span>
                            <span id="sum_calc_text"><?= $soLuong ?> x <?= number_format($tour['Gia'], 0, ',', '.') ?> đ</span>
                        </div>

                        <div class="summary-row">
                            <span class="summary-label text-dark fw-bold" style="font-size: 1.1rem;">Mã giảm giá</span>
                            <?php if(!empty($tour['UuDai']) && $tour['UuDai'] > 0): ?>
                                <span class="text-secondary">Có sẵn ưu đãi</span>
                            <?php else: ?>
                                <span class="text-secondary">Không có</span>
                            <?php endif; ?>
                        </div>
                        <div class="summary-row small text-muted mb-4">
                            <?php if(!empty($tour['UuDai']) && $tour['UuDai'] > 0): ?>
                                <span>Đã áp dụng <b class="text-danger">1</b> mã giảm giá</span>
                                <div class="text-end">
                                    Bạn đã tiết kiệm được <br>
                                    <b class="text-danger" id="sum_discount_amt">0 đ</b>
                                </div>
                            <?php else: ?>
                                <span>Không áp dụng mã</span>
                                <span>0 đ</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="hr-divider border-2 border-dark" style="opacity: 0.1;"></div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-bold fs-4" style="color: #111;">Tổng cộng</span>
                            <span class="fw-bold fs-3 text-danger" id="sum_final_total"><?= number_format($tour['Gia'] * $soLuong, 0, ',', '.') ?> đ</span>
                        </div>
                        
                        <div class="form-check mb-4 d-flex align-items-center gap-2">
                            <input class="form-check-input mt-0" type="checkbox" id="termsCheck" required style="width: 20px; height: 20px; border: 2px solid #111;">
                            <label class="form-check-label terms-check" for="termsCheck">
                                Tôi đồng ý với <a href="#">Chính sách</a> và <a href="#">Các điều khoản</a>
                            </label>
                        </div>
                        
                        <button type="submit" class="btn-payment">Thanh toán</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Logic Javascript tính toán giá tiền tự động khi chọn số lượng khách
    const basePrice = <?= $tour['Gia'] ?>;
    const discountRate = <?= $tour['UuDai'] ?? 0 ?>;
    
    let pax = {
        adult: <?= $soLuong ?>,
        child: 0,
        infant: 0
    };

    function formatCurrency(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " đ";
    }

    function updatePax(type, delta) {
        if (type === 'adult') {
            pax.adult = Math.max(1, pax.adult + delta); // Tối thiểu 1 người lớn
        } else {
            pax[type] = Math.max(0, pax[type] + delta); // Trẻ em/em bé tối thiểu 0
        }

        // Cập nhật lên UI form
        document.getElementById(`val_${type}`).innerText = pax[type];
        document.getElementById(`input_${type}`).value = pax[type];
        
        calculateTotal();
    }

    function calculateTotal() {
        // Trẻ em tính 75% giá, em bé miễn phí (Logic chuẩn du lịch)
        const childPrice = basePrice * 0.75;
        const subtotal = (pax.adult * basePrice) + (pax.child * childPrice);
        const discountAmt = subtotal * discountRate;
        const finalTotal = subtotal - discountAmt;

        // Cập nhật UI Card Tóm tắt
        document.getElementById('sum_subtotal').innerText = formatCurrency(subtotal);
        document.getElementById('sum_final_total').innerText = formatCurrency(finalTotal);
        
        let calcText = `${pax.adult} x ${formatCurrency(basePrice)}`;
        if (pax.child > 0) {
            calcText += `<br>${pax.child} x ${formatCurrency(childPrice)}`;
        }
        document.getElementById('sum_calc_text').innerHTML = calcText;

        let paxText = "Người lớn";
        if (pax.child > 0) paxText += "<br>Trẻ em";
        document.getElementById('sum_pax_text').innerHTML = paxText;

        const discountElem = document.getElementById('sum_discount_amt');
        if (discountElem) {
            discountElem.innerText = formatCurrency(discountAmt);
        }
    }

    // Chạy tính toán lần đầu khi vừa vào trang
    calculateTotal();
    
    // Validate trước khi submit
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        const terms = document.getElementById('termsCheck');
        if (!terms.checked) {
            e.preventDefault();
            alert('Vui lòng đồng ý với Chính sách và Các điều khoản để tiếp tục!');
        }
    });
</script>

<?php include 'app/views/layouts/footer.php'; ?>