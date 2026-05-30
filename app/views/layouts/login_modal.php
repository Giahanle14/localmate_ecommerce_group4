<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 680px;"> 
        <div class="modal-content login-modal-content">
            
            <div class="modal-header login-modal-header border-0">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="z-index: 10;"></button>
                <img src="public/image/decor/earth.png" alt="LocalMate Globe" class="login-earth-icon">
                <div class="login-header-text">
                    <h3 class="login-title mb-1">ĐĂNG NHẬP</h3>
                    <p class="login-subtitle">Đăng nhập để nhận được các ưu đãi và quyền lợi hấp dẫn!</p>
                </div>
            </div>

            <div class="modal-body login-modal-body p-4">
                <form action="index.php?controller=auth&action=login" method="POST">
                    <div class="mb-4">
                        <label class="form-label auth-label">Số điện thoại hoặc email <span class="text-danger">*</span></label>
                        <input type="text" name="email" class="form-control auth-input" placeholder="Nhập email của bạn" required>
                    </div>
                    
                    
                    <div class="mb-2">
                        <label class="form-label auth-label">Mật khẩu <span class="text-danger">*</span></label>
                        <div class="password-input-wrapper">
                            <input type="password" name="password" id="loginPassword" class="form-control auth-input w-100" placeholder="Nhập mật khẩu của bạn" required>
                            <span class="toggle-password" onclick="togglePassword('loginPassword', this)">
                                <i class="fa-solid fa-eye-slash text-muted"></i>
                            </span>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end mb-4">
                        <a href="#" class="auth-forgot text-decoration-none" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" data-bs-dismiss="modal">Quên mật khẩu?</a>
                    </div>

                    <div class="text-center auth-register-text mb-2">
                        Chưa có tài khoản? <a href="#" class="auth-register-link text-decoration-none" data-bs-toggle="modal" data-bs-target="#registerModal">Đăng ký ngay</a>
                    </div>
                    
                    <div class="auth-terms">
                        Bằng cách tiếp tục, bạn đồng ý với <a href="#">Điều khoản và Điều kiện</a> này và bạn đã được thông báo<br>về <a href="#">Chính sách bảo mật dữ liệu</a> của chúng tôi.
                    </div>
                    
                    <button type="submit" class="btn btn-auth-submit text-white">ĐĂNG NHẬP</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(inputId, iconSpan) {
        const input = document.getElementById(inputId);
        const icon = iconSpan.querySelector('i');
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
            icon.classList.add('text-success'); 
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye');
            icon.classList.remove('text-success');
            icon.classList.add('fa-eye-slash');
        }
    }
</script>