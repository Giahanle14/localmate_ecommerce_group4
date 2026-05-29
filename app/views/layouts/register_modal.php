<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 680px;">
        <div class="modal-content login-modal-content">
            
            <div class="modal-header login-modal-header border-0">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="z-index: 10;"></button>
                <img src="public/image/decor/earth.png" alt="LocalMate Globe" class="login-earth-icon">
                <div class="login-header-text">
                    <h3 class="login-title mb-1">TẠO TÀI KHOẢN</h3>
                    <p class="login-subtitle" id="regSubtitle">Đăng ký miễn phí để nhận được các ưu đãi và quyền lợi hấp dẫn!</p>
                </div>
            </div>

            <div class="modal-body login-modal-body p-4 pt-2">
                <form action="index.php?controller=auth&action=register" method="POST" id="registerForm">
                    
                    <div id="step1" class="register-step">
                        <div class="mb-3">
                            <label class="form-label auth-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" name="hoten" id="regHoTen" class="form-control auth-input" placeholder="Nhập họ và tên của bạn" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label auth-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email_sdt" id="regEmailSdt" class="form-control auth-input" placeholder="Nhập email của bạn" required>
                        </div>
                        
                        <div class="text-center auth-register-text mb-4">
                            Đã có tài khoản? <a href="#" class="auth-register-link text-decoration-none" data-bs-toggle="modal" data-bs-target="#loginModal">Đăng nhập ngay</a>
                        </div>

                        <div class="auth-terms mb-4">
                            Bằng cách tiếp tục, bạn đồng ý với <a href="#">Điều khoản và Điều kiện</a> này và bạn đã được thông báo<br>về <a href="#">Chính sách bảo mật dữ liệu</a> của chúng tôi.
                        </div>
                        
                        <button type="button" class="btn btn-auth-submit text-white" onclick="goToStep(2)">TIẾP TỤC</button>
                    </div>

                    <div id="step2" class="register-step" style="display: none;">
                        <p class="text-center mb-4" style="font-size: 0.95rem; color: #555;">
                            Mã xác thực (OTP) đã được gửi đến <br>
                            <b id="displayEmailSdt" style="color: #2e8b57;"></b>
                        </p>
                        
                        <div class="mb-4">
                            <label class="form-label auth-label text-center w-100">Nhập mã OTP <span class="text-danger">*</span></label>
                            <input type="text" name="otp" class="form-control auth-input text-center fs-4 letter-spacing-2" placeholder="• • • • • •" maxlength="6">
                        </div>
                        
                        <div class="text-center auth-register-text mb-4">
                            Chưa nhận được mã? <a href="#" class="auth-register-link text-decoration-none">Gửi lại (60s)</a>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary w-50 fw-bold" style="border-radius: 25px;" onclick="goToStep(1)">QUAY LẠI</button>
                            <button type="button" class="btn btn-auth-submit text-white w-50 m-0" onclick="goToStep(3)">XÁC NHẬN</button>
                        </div>
                    </div>

                    <div id="step3" class="register-step" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label auth-label">Mật khẩu mới <span class="text-danger">*</span></label>
                            <div class="password-input-wrapper">
                                <input type="password" name="password" id="regPassword" class="form-control auth-input w-100" placeholder="Nhập mật khẩu" required>
                                <span class="toggle-password" onclick="togglePassword('regPassword', this)">
                                    <i class="fa-solid fa-eye-slash text-muted"></i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label auth-label">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                            <div class="password-input-wrapper">
                                <input type="password" name="confirm_password" id="regConfirmPassword" class="form-control auth-input w-100" placeholder="Nhập lại mật khẩu" required>
                                <span class="toggle-password" onclick="togglePassword('regConfirmPassword', this)">
                                    <i class="fa-solid fa-eye-slash text-muted"></i>
                                </span>
                            </div>
                        </div>
                        
                        <div class="auth-terms mb-4">
                            Bằng cách hoàn tất, bạn đồng ý với <a href="#">Điều khoản và Điều kiện</a> này và bạn đã được thông báo về <a href="#">Chính sách bảo mật dữ liệu</a> của chúng tôi.
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary w-50 fw-bold" style="border-radius: 25px;" onclick="goToStep(2)">QUAY LẠI</button>
                            <button type="submit" class="btn btn-auth-submit text-white w-50 m-0">HOÀN TẤT</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS CHUẨN THEO THIẾT KẾ FIGMA */
    .login-modal-header {
        position: relative;
        padding: 40px 30px; /* Tăng khoảng cách padding cho giống Figma */
        border-radius: 20px 20px 0 0;
    }

    /* Giới hạn phần chữ bên trái để không đè lên quả địa cầu */
    .login-header-text {
        position: relative;
        z-index: 2;
        max-width: 60%; 
    }

    /* Đưa quả địa cầu sang góc phải */
    .login-earth-icon {
        position: absolute;
        right: 20px;          /* Đẩy sát lề phải */
        top: 50%;             /* Căn giữa theo chiều dọc của header */
        transform: translateY(-50%); 
        width: 170px;         /* Chỉnh kích thước quả địa cầu (bạn có thể tăng giảm số này) */
        height: auto;
        z-index: 1;           /* Nằm dưới nút X (đang có z-index: 10) */
        pointer-events: none; /* Tránh click nhầm vào hình */
    }

    /* Đảm bảo form bên dưới bo góc mượt mà */
    .login-modal-content {
        border-radius: 20px;
        border: none;
    }
</style>