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
    @media (max-width: 768px) {
        .breadcrumb-custom { padding: 15px 20px; }
    }

    /* Tiêu đề trang */
    .page-main-title { font-family: 'Quicksand', sans-serif; font-weight: 800; font-size: 2.8rem; color: #0d5c2c; text-align: center; margin-bottom: 30px; text-shadow: 2px 2px 4px rgba(0,0,0,0.05); }

    /* Stepper Nét Đứt - BƯỚC 2 */
    .stepper-wrapper { display: flex; justify-content: space-between; position: relative; margin: 30px auto 50px; max-width: 600px; }
    .stepper-wrapper::before { 
        content: ''; position: absolute; top: 30px; left: 16.66%; width: 66.66%; 
        border-top: 3px dashed #cbd5e1; z-index: 1; 
    }
    .stepper-wrapper.step-2::after {
        content: ''; position: absolute; top: 30px; left: 16.66%; width: 33.33%; 
        border-top: 3px dashed var(--primary); z-index: 1;
    }
    .step { position: relative; z-index: 2; display: flex; flex-direction: column; align-items: center; width: 33.33%; }
    .step-circle { 
        width: 60px; height: 60px; background: #fff; border: 3px solid #cbd5e1; 
        border-radius: 50%; display: flex; align-items: center; justify-content: center; 
        font-size: 1.4rem; color: #cbd5e1; transition: 0.3s; 
    }
    .step.active .step-circle { 
        border-color: var(--primary); background: var(--primary); color: #fff; 
        box-shadow: 0 4px 15px rgba(26, 83, 54, 0.3); 
    }
    .step.completed .step-circle { 
        border-color: var(--primary); background: #fff; color: var(--primary); 
    }
    .step-text { margin-top: 12px; font-weight: 600; color: #94a3b8; font-size: 0.95rem; }
    .step.active .step-text { color: var(--primary); font-weight: 800; }
    .step.completed .step-text { color: var(--primary); font-weight: 700; }

    /* Main Container */
    .payment-container {
        background-color: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 20px;
        padding: 40px;
        max-width: 900px;
        margin: 0 auto 100px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }

    .section-title { font-weight: 800; color: #ffffff; background-color: var(--primary); padding: 12px 20px; border-radius: 12px; font-size: 1.3rem; margin-bottom: 15px; display: flex; align-items: center; gap: 10px; text-transform: uppercase; }
    .section-subtitle { font-size: 1.05rem; color: #555; margin-bottom: 30px; font-weight: 600; padding-left: 5px;}

    .payment-method { background: #fff; border: 2px solid #e2e8f0; border-radius: 16px; padding: 20px; margin-bottom: 20px; cursor: pointer; transition: all 0.3s ease; display: flex; flex-direction: column;}
    .payment-method.active { background: #f0fdf4; border-color: var(--primary); }
    .payment-header { display: flex; align-items: center; justify-content: space-between; width: 100%; }
    .payment-info { display: flex; align-items: center; gap: 20px; }
    .icon-box { width: 55px; height: 55px; background: #fff; border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0,0,0,0.05); font-size: 1.6rem; color: #333; border: 1px solid #f1f5f9;}
    .payment-info h5 { margin: 0 0 5px 0; font-weight: 800; color: #222; font-size: 1.15rem;}
    .payment-info p { margin: 0; color: #666; font-size: 0.9rem; font-weight: 600;}
    .check-icon { font-size: 1.6rem; color: var(--primary); opacity: 0; transition: 0.3s; }
    .payment-method.active .check-icon { opacity: 1; }

    .bank-form { display: none; margin-top: 20px; padding-top: 20px; border-top: 2px dashed #e2e8f0; }
    .payment-method.active .bank-form { display: flex; flex-wrap: wrap; gap: 20px; }
    .form-group { flex: 1; min-width: 45%; }
    .form-group label { font-weight: 700; color: #444; font-size: 0.95rem; margin-bottom: 8px; display: block;}
    .form-group input { width: 100%; border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 12px 15px; font-family: 'Quicksand', sans-serif; font-weight: 600; outline: none; transition: 0.3s; background-color: #f8fafc;}
    .form-group input:focus { border-color: var(--primary-light); background-color: #fff; box-shadow: 0 0 0 4px rgba(46, 122, 84, 0.1);}

    .momo-details { display: none; text-align: center; margin-top: 20px; padding-top: 20px; border-top: 2px dashed #e2e8f0; }
    .payment-method.active .momo-details { display: block; }

    .order-info-box { border: 2px solid #e2e8f0; border-radius: 16px; padding: 25px; margin-top: 40px; background: #f8fafc; }
    .order-info-box h4 { font-weight: 800; color: var(--primary); margin-bottom: 20px; font-size: 1.3rem;}
    .order-row { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 1rem; font-weight: 600; color: #555;}
    .order-row strong { font-weight: 800; color: #222; }
    .tour-detail-row { border-top: 2px dashed #cbd5e1; margin-top: 20px; padding-top: 20px; }
    .tour-detail-row strong { display: block; font-size: 1.15rem; margin-bottom: 5px; color: #111;}

    .total-price-box { background-color: #e0f2fe; border: 1px solid #bae6fd; border-radius: 16px; padding: 20px; display: flex; justify-content: space-between; align-items: center; margin-top: 30px; font-size: 1.1rem; font-weight: 700; color: #0f172a; }
    .total-price-box span { color: #e74c3c; font-size: 1.8rem; font-weight: 900; }

    .btn-checkout { background: linear-gradient(135deg, var(--accent), #ff7f50); color: white; width: 100%; border: none; border-radius: 12px; padding: 16px; font-size: 1.2rem; font-weight: 800; margin-top: 25px; text-transform: uppercase; letter-spacing: 0.5px; transition: 0.3s; box-shadow: 0 8px 15px rgba(242, 154, 46, 0.25); }
    .btn-checkout:hover { transform: translateY(-2px); box-shadow: 0 12px 20px rgba(242, 154, 46, 0.35); color: #fff; }
</style>

<?php $booking = $_SESSION['booking_temp']; ?>

<div class="breadcrumb-custom">
    <a href="index.php?controller=home"><i class="fa-solid fa-house me-1"></i>Trang chủ</a> 
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <a href="index.php?controller=tour">Tour</a> 
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <a href="index.php?controller=tourdetail&id=<?= htmlspecialchars($booking['ma_tour']) ?>">Chi tiết tour</a>
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <span class="text-dark fw-bold">Thanh toán</span>
</div>

<div class="container" style="max-width: 1200px; padding-bottom: 80px;">

    <h1 class="page-main-title">Thanh toán</h1>
    
    <div class="stepper-wrapper step-2">
        <div class="step completed">
            <div class="step-circle"><i class="fa-solid fa-clipboard-user"></i></div>
            <div class="step-text">Nhập thông tin</div>
        </div>
        <div class="step active">
            <div class="step-circle"><i class="fa-regular fa-credit-card"></i></div>
            <div class="step-text">Thanh toán</div>
        </div>
        <div class="step">
            <div class="step-circle"><i class="fa-solid fa-check-double"></i></div>
            <div class="step-text">Hoàn tất</div>
        </div>
    </div>

    <div class="payment-container">
        <h2 class="section-title"><i class="fa-solid fa-money-check-dollar" style="color: var(--accent);"></i> CHỌN PHƯƠNG THỨC THANH TOÁN</h2>
        <p class="section-subtitle">Vui lòng chọn một trong các phương thức thanh toán điện tử dưới đây để hoàn tất quá trình đặt tour.</p>

        <form action="index.php?controller=payment&action=confirm" method="POST" id="paymentForm">
            <input type="hidden" name="phuong_thuc_thanh_toan" id="paymentMethodInput" value="Ngân hàng">

            <div class="payment-method active" id="method-bank" onclick="selectPaymentMethod('Ngân hàng')">
                <div class="payment-header">
                    <div class="payment-info">
                        <div class="icon-box"><i class="fa-solid fa-building-columns"></i></div>
                        <div>
                            <h5>Thẻ Ngân hàng</h5>
                            <p>Hỗ trợ tất cả các ngân hàng nội địa (Internet Banking / Mobile Banking).</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-circle-check check-icon"></i>
                </div>
                <div class="bank-form">
                    <div class="form-group">
                        <label>Số thẻ</label>
                        <input type="text" placeholder="Nhập số thẻ" maxlength="19">
                    </div>
                    <div class="form-group">
                        <label>Tên in trên thẻ</label>
                        <input type="text" placeholder="NGUYEN VAN A" style="text-transform: uppercase;">
                    </div>
                    <div class="form-group" style="min-width: 100%;">
                        <label>Ngày hết hạn</label>
                        <input type="text" placeholder="MM/YY" style="width: 45%;">
                    </div>
                </div>
            </div>

            <div class="payment-method" id="method-momo" onclick="selectPaymentMethod('MoMo')">
                <div class="payment-header">
                    <div class="payment-info">
                        <div class="icon-box"><i class="fa-solid fa-wallet"></i></div>
                        <div>
                            <h5>Ví điện tử MoMo</h5>
                            <p>Thanh toán nhanh chóng, an toàn qua ứng dụng ví điện tử.</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-circle-check check-icon"></i>
                </div>
                <div class="momo-details">
                    <p style="font-size: 1.05rem; color: #444; font-weight: 600;">Hệ thống sẽ chuyển hướng bạn đến ứng dụng ví điện tử để hoàn tất thanh toán sau khi bấm "THANH TOÁN NGAY".</p>
                    <img src="public/image/logo/MOMO_LOGO.png" alt="MoMo" style="height: 60px; margin-top: 10px; border-radius: 10px;">
                </div>
            </div>

            <div class="order-info-box">
                <h4>Thông tin đơn hàng</h4>
                
                <div class="order-row">
                    <span>Mã chuyến đi:</span>
                    <strong style="color: var(--primary); font-size: 1.15rem;"><?= htmlspecialchars($nextMaCD) ?></strong>
                </div>
                <div class="order-row">
                    <span>Tên khách hàng:</span>
                    <strong><?= htmlspecialchars($booking['ho_ten']) ?></strong>
                </div>
                <div class="order-row">
                    <span>Du khách:</span>
                    <strong>
                        <?= $booking['sl_nguoi_lon'] ?> Người lớn
                        <?= $booking['sl_tre_em'] > 0 ? ', ' . $booking['sl_tre_em'] . ' Trẻ em' : '' ?>
                    </strong>
                </div>

                <div class="tour-detail-row">
                    <strong><?= htmlspecialchars($booking['ten_tour']) ?></strong>
                    <span>Ngày khởi hành: <b class="text-dark"><?= date('d/m/Y', strtotime($booking['ngay_bat_dau'])) ?></b></span>
                </div>
            </div>

            <div class="total-price-box">
                Số tiền cần thanh toán: <span><?= number_format($booking['tong_tien'], 0, ',', '.') ?> đ</span>
            </div>

            <button type="submit" class="btn-checkout">
                <i class="fa-solid fa-lock me-2"></i> THANH TOÁN NGAY
            </button>
        </form>

    </div>
</div>

<script>
    function selectPaymentMethod(method) {
        document.getElementById('paymentMethodInput').value = method;
        document.getElementById('method-bank').classList.remove('active');
        document.getElementById('method-momo').classList.remove('active');
        if (method === 'Ngân hàng') {
            document.getElementById('method-bank').classList.add('active');
        } else {
            document.getElementById('method-momo').classList.add('active');
        }
    }
</script>

<?php include 'app/views/layouts/footer.php'; ?>