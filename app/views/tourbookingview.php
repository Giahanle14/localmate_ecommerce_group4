<?php include 'app/views/layouts/header.php'; ?>

<style>
    :root {
        --primary: #1A5336;
        --primary-light: #2e7a54;
        --accent: #F29A2E; 
        --bg-color: #F8FAF5; 
        --text-main: #333;
        --text-muted: #777;
    }
    
    body { background-color: var(--bg-color); font-family: 'Quicksand', sans-serif; }

<<<<<<< Updated upstream
<<<<<<< Updated upstream
    /* Breadcrumb */
    .breadcrumb-custom { padding: 20px 0; font-weight: 700; font-size: 1rem; }
    .breadcrumb-custom a { color: var(--primary); text-decoration: none; transition: 0.2s;}
    .breadcrumb-custom a:hover { opacity: 0.7; }
    .breadcrumb-custom span { color: #999; }
=======
=======
>>>>>>> Stashed changes
    @media (max-width: 768px) {
        .breadcrumb-custom { padding: 15px 20px; }
    }
>>>>>>> Stashed changes
    
    /* Tiêu đề trang */
    .page-main-title { font-family: 'Quicksand', sans-serif; font-weight: 800; font-size: 2.8rem; color: #0d5c2c; text-align: center; margin-bottom: 30px; text-shadow: 2px 2px 4px rgba(0,0,0,0.05);}

    /* Stepper (Thanh tiến trình nối liền) */
    .stepper-wrapper { display: flex; justify-content: space-between; position: relative; margin: 30px auto 50px; max-width: 550px; }
    .stepper-wrapper::before { content: ''; position: absolute; top: 30px; left: 10%; width: 80%; height: 3px; background: #e5e7eb; z-index: 1; }
    
    .step { position: relative; z-index: 2; display: flex; flex-direction: column; align-items: center; width: 33.33%; }
    .step-circle { width: 60px; height: 60px; background: #fff; border: 3px solid #e5e7eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: #cbd5e1; transition: 0.3s; }
    .step.active .step-circle { border-color: var(--primary); background: var(--primary); color: #fff; box-shadow: 0 4px 12px rgba(26, 83, 54, 0.25); }
    .step-text { margin-top: 10px; font-weight: 700; color: #94a3b8; font-size: 0.95rem; }
    .step.active .step-text { color: var(--primary); }

    /* Form Cards */
    .booking-card { background: #fff; border-radius: 20px; padding: 35px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #f0f0f0; margin-bottom: 30px; }
    .section-title { font-weight: 800; color: #111; font-size: 1.3rem; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; }
    .section-title i { color: var(--accent); font-size: 1.1rem;}

    /* Inputs */
    .form-label { font-weight: 700; color: #444; font-size: 0.95rem; margin-bottom: 8px;}
    .form-control { border-radius: 12px; padding: 14px 18px; border: 1.5px solid #e2e8f0; font-weight: 600; color: #333; transition: 0.3s; background-color: #f8fafc;}
    .form-control:focus { border-color: var(--primary-light); box-shadow: 0 0 0 4px rgba(46, 122, 84, 0.1); background-color: #fff;}

    /* Bảng đếm hành khách (Pax Control) */
    .pax-item { display: flex; justify-content: space-between; align-items: center; padding: 18px 22px; border: 1.5px solid #e2e8f0; border-radius: 16px; margin-bottom: 15px; transition: 0.3s; background: #fff;}
    .pax-item:hover { border-color: #A5D6A7; background: #fdfdfd; box-shadow: 0 2px 10px rgba(0,0,0,0.02);}
    .pax-info h6 { font-weight: 800; margin: 0 0 3px 0; color: #222; font-size: 1.05rem;}
    .pax-info small { color: #888; font-weight: 600; font-size: 0.85rem; }
    .pax-controls { display: flex; align-items: center; background: #f1f5f9; border-radius: 30px; padding: 4px; }
    .btn-pax { width: 32px; height: 32px; border-radius: 50%; border: none; background: #fff; color: var(--text-main); font-weight: 900; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.08); cursor: pointer; transition: 0.2s;}
    .btn-pax:hover { background: var(--primary); color: #fff; }
    .pax-val { width: 35px; text-align: center; font-weight: 800; font-size: 1.1rem; color: var(--primary); }

    /* Card Tóm tắt bên phải */
    .summary-wrapper { position: sticky; top: 90px; }
    .summary-card { background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.06); border: 1px solid #f0f0f0; overflow: hidden; }
    .summary-img { width: 100%; height: 220px; object-fit: cover; }
    .summary-body { padding: 30px; }
    
    .summary-tour-title { font-weight: 800; font-size: 1.25rem; color: #111; margin-bottom: 15px; line-height: 1.4;}
    .summary-meta { color: #555; font-size: 0.95rem; font-weight: 600; margin-bottom: 12px; display: flex; align-items: flex-start; gap: 10px;}
    .summary-meta i { color: var(--accent); font-size: 1.1rem; margin-top: 2px;}
    
    .summary-divider { border-top: 2px dashed #e2e8f0; margin: 25px 0; opacity: 1;}
    
    .price-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
    .price-label { color: #64748b; font-weight: 700; font-size: 0.95rem; }
    .price-val { font-weight: 800; color: #334155; font-size: 1.05rem; }
    
    .total-box { background: #f0fdf4; border-radius: 16px; padding: 20px; border: 1px solid #bbf7d0; margin-top: 20px;}
    .total-label { font-size: 1.1rem; font-weight: 800; color: var(--primary); }
    .total-price { font-size: 1.8rem; font-weight: 900; color: #e74c3c; }

    /* Nút thanh toán */
    .btn-submit { background: linear-gradient(135deg, var(--accent), #ff7f50); color: #fff; border: none; border-radius: 12px; padding: 16px; font-size: 1.2rem; font-family: 'Quicksand', sans-serif; font-weight: 800; width: 100%; margin-top: 25px; box-shadow: 0 8px 15px rgba(242, 154, 46, 0.25); transition: 0.3s; text-transform: uppercase; letter-spacing: 0.5px;}
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 20px rgba(242, 154, 46, 0.35); color: #fff;}
    
    .terms-check { font-weight: 600; font-size: 0.9rem; color: #475569;}
    .terms-check a { color: var(--primary); text-decoration: none; font-weight: 700;}
    .terms-check a:hover { text-decoration: underline; }
</style>

<<<<<<< Updated upstream
<<<<<<< Updated upstream
=======
=======
>>>>>>> Stashed changes
<div class="breadcrumb-custom px-3 px-lg-5">
    <a href="index.php?controller=home"><i class="fa-solid fa-house me-1"></i>Trang chủ</a> 
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <a href="index.php?controller=tour">Tour</a>
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <a href="index.php?controller=tourdetail&id=<?= htmlspecialchars($tour['MaTour'] ?? '') ?>">Chi tiết tour</a>
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <a href="javascript:void(0)">Đặt tour</a>
</div>

>>>>>>> Stashed changes
<div class="container" style="max-width: 1200px; padding-bottom: 80px;">
    <div class="breadcrumb-custom">
        <a href="?controller=home"><i class="fa-solid fa-house-chimney me-1"></i>Trang chủ</a> <span class="mx-2">></span> 
        <a href="?controller=tour">Tour</a> <span class="mx-2">></span> 
        <a href="?controller=tourdetail&id=<?= htmlspecialchars($tour['MaTour']) ?>">Chi tiết tour</a> <span class="mx-2">></span> 
        <span>Đặt tour</span>
    </div>

    <h1 class="page-main-title">Hoàn tất đặt Tour</h1>
    <div class="stepper-wrapper">
        <div class="step active">
            <div class="step-circle"><i class="fa-solid fa-clipboard-user"></i></div>
            <div class="step-text">Nhập thông tin</div>
        </div>
        <div class="step">
            <div class="step-circle"><i class="fa-regular fa-credit-card"></i></div>
            <div class="step-text">Thanh toán</div>
        </div>
        <div class="step">
            <div class="step-circle"><i class="fa-solid fa-check-double"></i></div>
            <div class="step-text">Hoàn tất</div>
        </div>
    </div>

    <form action="index.php?controller=tourbooking&action=process" method="POST" id="bookingForm" novalidate>
        <input type="hidden" name="ma_tour" value="<?= htmlspecialchars($tour['MaTour']) ?>">
        <input type="hidden" name="ngay_bat_dau" value="<?= htmlspecialchars($ngayDi) ?>">
        <input type="hidden" name="ngay_ket_thuc" value="<?= htmlspecialchars($ngayKetThuc) ?>">

        <div class="row g-4 g-lg-5">
            <div class="col-lg-7">
                
                <div class="booking-card">
                    <h3 class="section-title"><i class="fa-solid fa-address-card"></i> Thông tin liên lạc</h3>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" name="ho_ten" id="ho_ten" class="form-control" placeholder="Ví dụ: Nguyễn Văn A" value="<?= htmlspecialchars($userInfo['HoTen'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" name="dien_thoai" id="dien_thoai" class="form-control" placeholder="Nhập số điện thoại" value="<?= htmlspecialchars($userInfo['SDT'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Nhập địa chỉ email" value="<?= htmlspecialchars($userInfo['Gmail'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                            <input type="text" name="dia_chi" id="dia_chi" class="form-control" placeholder="Địa chỉ hiện tại của bạn" value="<?= htmlspecialchars($userInfo['DiaChi'] ?? '') ?>" required>
                        </div>
                    </div>
                </div>

                <div class="booking-card">
                    <h3 class="section-title"><i class="fa-solid fa-user-group"></i> Số lượng hành khách</h3>
                    
                    <div class="pax-item">
                        <div class="pax-info">
                            <h6>Người lớn</h6>
                            <small>Từ 12 tuổi trở lên</small>
                        </div>
                        <div class="pax-controls">
                            <button type="button" class="btn-pax" onclick="updatePax('adult', -1)"><i class="fa-solid fa-minus"></i></button>
                            <span id="val_adult" class="pax-val"><?= htmlspecialchars($soLuong) ?></span>
                            <button type="button" class="btn-pax" onclick="updatePax('adult', 1)"><i class="fa-solid fa-plus"></i></button>
                            <input type="hidden" name="sl_nguoi_lon" id="input_adult" value="<?= htmlspecialchars($soLuong) ?>">
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="pax-item mb-0">
                                <div class="pax-info">
                                    <h6>Trẻ em</h6>
                                    <small>Từ 2 - 11 tuổi</small>
                                </div>
                                <div class="pax-controls">
                                    <button type="button" class="btn-pax" onclick="updatePax('child', -1)"><i class="fa-solid fa-minus"></i></button>
                                    <span id="val_child" class="pax-val">0</span>
                                    <button type="button" class="btn-pax" onclick="updatePax('child', 1)"><i class="fa-solid fa-plus"></i></button>
                                    <input type="hidden" name="sl_tre_em" id="input_child" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pax-item mb-0">
                                <div class="pax-info">
                                    <h6>Em bé</h6>
                                    <small>Dưới 2 tuổi</small>
                                </div>
                                <div class="pax-controls">
                                    <button type="button" class="btn-pax" onclick="updatePax('infant', -1)"><i class="fa-solid fa-minus"></i></button>
                                    <span id="val_infant" class="pax-val">0</span>
                                    <button type="button" class="btn-pax" onclick="updatePax('infant', 1)"><i class="fa-solid fa-plus"></i></button>
                                    <input type="hidden" name="sl_em_be" id="input_infant" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="booking-card mb-0">
                    <h3 class="section-title"><i class="fa-solid fa-pen-to-square"></i> Yêu cầu đặc biệt</h3>
                    <textarea class="form-control" name="ghi_chu" rows="4" placeholder="Ví dụ: Ăn chay, phòng tầng cao, dị ứng hải sản... (Không bắt buộc)"></textarea>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="summary-wrapper">
                    <div class="summary-card">
                        <img src="<?= htmlspecialchars($tour['HinhAnh']) ?>" class="summary-img" alt="Tour Image">
                        
                        <div class="summary-body">
                            <h4 class="summary-tour-title"><?= htmlspecialchars($tour['TenTour']) ?></h4>
                            
                            <div class="summary-meta">
                                <i class="fa-solid fa-location-dot"></i>
                                <span><?= htmlspecialchars($tour['DiaDiem'] ?? $tour['VungDiaLy']) ?></span>
                            </div>
                            
                            <div class="summary-meta">
                                <i class="fa-regular fa-calendar-check"></i>
                                <div>
                                    <strong class="text-dark">Khởi hành:</strong> <?= date('d/m/Y', strtotime($ngayDi)) ?> lúc 07:00 <br>
                                    <strong class="text-dark mt-1 d-inline-block">Kết thúc:</strong> <?= date('d/m/Y', strtotime($ngayKetThuc)) ?> lúc 17:00
                                </div>
                            </div>
                            
                            <div class="summary-divider"></div>
                            
                            <h5 class="fw-bold text-dark mb-3" style="font-size: 1.1rem;">Chi tiết thanh toán</h5>
                            
                            <div class="price-row">
                                <span class="price-label">Giá tour cơ bản</span>
                                <span class="price-val" id="sum_subtotal"><?= number_format($tour['Gia'] * $soLuong, 0, ',', '.') ?> đ</span>
                            </div>
                            
                            <div class="p-3 bg-light rounded mb-3" style="border: 1px solid #e2e8f0;">
                                <div class="d-flex justify-content-between small text-muted mb-2">
                                    <span id="sum_pax_text">Người lớn</span>
                                    <span id="sum_calc_text" class="text-end fw-semibold text-dark"><?= $soLuong ?> x <?= number_format($tour['Gia'], 0, ',', '.') ?> đ</span>
                                </div>
                            </div>

                            <div class="price-row">
                                <span class="price-label">Mã giảm giá nền tảng</span>
                                <?php if(!empty($tour['UuDai']) && $tour['UuDai'] > 0): ?>
                                    <span class="discount-val">- <span id="sum_discount_amt">0 đ</span></span>
                                <?php else: ?>
                                    <span class="price-val text-muted">0 đ</span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="total-box">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="total-label">Tổng thanh toán</span>
                                    <span class="total-price" id="sum_final_total"><?= number_format($tour['Gia'] * $soLuong, 0, ',', '.') ?> đ</span>
                                </div>
                                <div class="text-end small text-success fw-bold mt-1">Đã bao gồm VAT & Thuế phí</div>
                            </div>
                            
                            <div class="form-check mt-3 text-center d-flex justify-content-center align-items-center gap-2">
                                <input class="form-check-input mt-0" type="checkbox" id="termsCheck" required style="width: 18px; height: 18px; border: 2px solid #ccc; cursor: pointer;">
                                <label class="form-check-label terms-check" for="termsCheck" style="cursor: pointer;">
                                    Đồng ý với <a href="#">Điều khoản</a> & <a href="#">Chính sách bảo mật</a>
                                </label>
                            </div>
                            
                            <button type="submit" class="btn-submit">
                                <i class="fa-solid fa-lock me-2"></i> Thanh toán an toàn
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Logic Javascript tính toán giá tiền tự động
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
        // Trẻ em tính 75% giá, em bé miễn phí
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

    calculateTotal();
    
    // VALIDATE THÔNG BÁO ALERT KHI BẤM NÚT THANH TOÁN
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        const hoTen = document.getElementById('ho_ten');
        const dienThoai = document.getElementById('dien_thoai');
        const email = document.getElementById('email');
        const diaChi = document.getElementById('dia_chi');
        const terms = document.getElementById('termsCheck');

        if (!hoTen.value.trim()) {
            e.preventDefault();
            alert('Vui lòng nhập đầy đủ Họ và tên!');
            hoTen.focus();
            return;
        }

        if (!dienThoai.value.trim()) {
            e.preventDefault();
            alert('Vui lòng nhập Số điện thoại liên lạc!');
            dienThoai.focus();
            return;
        }

        if (!email.value.trim()) {
            e.preventDefault();
            alert('Vui lòng nhập địa chỉ Email!');
            email.focus();
            return;
        }

        if (!diaChi.value.trim()) {
            e.preventDefault();
            alert('Vui lòng cung cấp Địa chỉ của bạn!');
            diaChi.focus();
            return;
        }

        if (!terms.checked) {
            e.preventDefault();
            alert('Vui lòng đánh dấu check đồng ý với Điều khoản và Chính sách của chúng tôi để tiếp tục!');
            return;
        }
    });
</script>

<?php include 'app/views/layouts/footer.php'; ?>