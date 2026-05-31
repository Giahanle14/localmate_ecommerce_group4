<?php include 'app/views/layouts/header.php'; ?>

<style>
    :root {
        --primary: #1A5336;
        --primary-light: #2e7a54;
        --accent: #F29A2E; 
        --bg-color: #F8FAF5; 
        --text-main: #333;
    }

    body { background-color: var(--bg-color); font-family: 'Quicksand', sans-serif; }

    /* Tiêu đề trang */
    .page-main-title { font-family: 'Quicksand', sans-serif; font-weight: 800; font-size: 2.8rem; color: #0d5c2c; text-align: center; margin-bottom: 30px; text-shadow: 2px 2px 4px rgba(0,0,0,0.05); }

    /* Stepper Nét Đứt - BƯỚC 3 (Sáng toàn bộ thanh) */
    .stepper-wrapper { display: flex; justify-content: space-between; position: relative; margin: 30px auto 50px; max-width: 600px; }
    .stepper-wrapper::before { 
        content: ''; position: absolute; top: 30px; left: 16.66%; width: 66.66%; 
        border-top: 3px dashed #cbd5e1; z-index: 1; 
    }
    .stepper-wrapper.step-3::after {
        content: ''; position: absolute; top: 30px; left: 16.66%; width: 66.66%; /* Sáng đến bước 3 */
        border-top: 3px dashed var(--primary); z-index: 1;
    }
    
    .step { position: relative; z-index: 2; display: flex; flex-direction: column; align-items: center; width: 33.33%; }
    .step-circle { 
        width: 60px; height: 60px; background: #fff; border: 3px solid #cbd5e1; 
        border-radius: 50%; display: flex; align-items: center; justify-content: center; 
        font-size: 1.4rem; color: #cbd5e1; transition: 0.3s; 
    }
    
    /* Trạng thái Active (Hiện tại) - Áp dụng cho Bước 3 */
    .step.active .step-circle { 
        border-color: var(--primary); background: var(--primary); color: #fff; 
        box-shadow: 0 4px 15px rgba(26, 83, 54, 0.3); 
    }
    
    /* Trạng thái Completed (Xong) - Áp dụng cho Bước 1 & 2 */
    .step.completed .step-circle { 
        border-color: var(--primary); background: #fff; color: var(--primary); 
    }
    
    .step-text { margin-top: 12px; font-weight: 600; color: #94a3b8; font-size: 0.95rem; }
    .step.active .step-text { color: var(--primary); font-weight: 800; }
    .step.completed .step-text { color: var(--primary); font-weight: 700; }

    /* Main Container Box */
    .payment-container {
        background-color: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 20px;
        padding: 60px 40px;
        max-width: 800px;
        margin: 0 auto 100px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        text-align: center;
    }

    .success-icon {
        font-size: 5rem;
        color: var(--primary);
        margin-bottom: 20px;
        animation: scaleIn 0.5s ease-out forwards;
    }

    .success-title {
        font-weight: 800;
        color: var(--primary);
        font-size: 2rem;
        margin-bottom: 15px;
    }

    .success-message {
        font-size: 1.1rem;
        color: #555;
        max-width: 600px;
        margin: 0 auto 30px;
        line-height: 1.6;
        font-weight: 500;
    }

    .booking-id-box {
        background-color: #f8fafc;
        border: 2px dashed #cbd5e1;
        padding: 15px 30px;
        border-radius: 12px;
        display: inline-block;
        margin-bottom: 40px;
    }

    .btn-view-trip {
        background: linear-gradient(135deg, var(--accent), #ff7f50);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 16px 40px;
        font-size: 1.2rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: 0.3s;
        box-shadow: 0 8px 15px rgba(242, 154, 46, 0.25);
        text-decoration: none;
        display: inline-block;
    }

    .btn-view-trip:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 12px 20px rgba(242, 154, 46, 0.35); 
        color: #fff; 
    }

    @keyframes scaleIn {
        0% { transform: scale(0); opacity: 0; }
        60% { transform: scale(1.1); opacity: 1; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>

<div class="breadcrumb-custom">
    <a href="index.php?controller=home"><i class="fa-solid fa-house me-1"></i>Trang chủ</a> 
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <a href="index.php?controller=tour">Tour</a> 
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <span class="text-dark fw-bold">Hoàn thành</span>
</div>

<div class="container" style="max-width: 1200px; padding-bottom: 80px;">

    <h1 class="page-main-title">Thanh toán</h1>
    
    <div class="stepper-wrapper step-3">
        <div class="step completed">
            <div class="step-circle"><i class="fa-solid fa-clipboard-user"></i></div>
            <div class="step-text">Nhập thông tin</div>
        </div>
        <div class="step completed">
            <div class="step-circle"><i class="fa-regular fa-credit-card"></i></div>
            <div class="step-text">Thanh toán</div>
        </div>
        <div class="step active">
            <div class="step-circle"><i class="fa-solid fa-check-double"></i></div>
            <div class="step-text">Hoàn tất</div>
        </div>
    </div>

    <div class="payment-container">
        <div class="success-icon">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        
        <h2 class="success-title">Hoàn tất đặt Tour!</h2>
        
        <p class="success-message">
            Cảm ơn bạn đã tin tưởng và lựa chọn dịch vụ của LocalMate. Chúc bạn có một chuyến đi thật tuyệt vời và nhiều kỷ niệm đáng nhớ!
        </p>

        <div class="booking-id-box">
            <span style="font-weight: 600; color: #555; font-size: 1.05rem;">Mã chuyến đi của bạn: </span>
            <span style="font-weight: 800; color: var(--primary); font-size: 1.3rem; margin-left: 8px;">
                <?= htmlspecialchars($maChuyenDi) ?>
            </span>
        </div>
        <br>
        
        <a href="index.php?controller=mytrip" class="btn-view-trip">
            <i class="fa-solid fa-plane-departure me-2"></i> XEM NGAY CHUYẾN ĐI
        </a>
    </div>

</div>

<?php include 'app/views/layouts/footer.php'; ?>