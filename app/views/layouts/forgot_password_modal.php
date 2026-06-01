<style>
    .forgot-otp-box { width: clamp(35px, 10vw, 45px) !important; height: clamp(40px, 12vw, 55px) !important; font-size: 1.2rem; }
    @media (min-width: 576px) { .btn-modal-step { width: 50% !important; } }
    @media (max-width: 575px) { .btn-modal-step { width: 100% !important; } }
</style>

<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 680px;">
        <div class="modal-content login-modal-content">
            
            <div class="modal-header login-modal-header border-0">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="z-index: 10;"></button>
                <img src="public/image/decor/earth.png" alt="LocalMate Globe" class="login-earth-icon">
                <div class="login-header-text">
                    <h3 class="login-title mb-1" id="forgotTitle">QUÊN MẬT KHẨU</h3>
                    <p class="login-subtitle" id="forgotSubtitle">Nhập email của bạn để nhận mật khẩu mới từ LocalMate</p>
                </div>
            </div>

            <div class="modal-body login-modal-body pt-2">
                <form id="forgotPasswordForm">
                    
                    <div id="forgotStep1" class="register-step">
                        <div class="mb-4">
                            <label class="form-label auth-label">Email <span class="text-danger">*</span></label>
                            <input type="email" id="forgotEmailInput" class="form-control auth-input" placeholder="Nhập email của bạn" required 
                                   oninvalid="this.setCustomValidity('Vui lòng nhập email hợp lệ.')" 
                                   oninput="this.setCustomValidity('')">
                        </div>
                        
                        <div class="d-flex flex-column flex-sm-row gap-2 mt-5">
                            <button type="button" class="btn btn-outline-secondary btn-modal-step fw-bold" style="border-radius: 25px;" onclick="backToLogin()">QUAY LẠI</button>
                            <button type="button" class="btn btn-auth-submit btn-modal-step text-white m-0" onclick="goToForgotStep(2)">LẤY LẠI MẬT KHẨU</button>
                        </div>
                    </div>

                    <div id="forgotStep2" class="register-step" style="display: none;">
                        <div class="mb-4 text-center">
                            <label class="form-label auth-label d-block text-start mb-2" style="font-size: 1.05rem;">Xác thực OTP <span class="text-danger">*</span></label>
                            <p class="mb-0 text-start" style="font-size: 0.95rem; color: #555;">
                                Nhập mã 6 số đã gửi đến <b id="forgotDisplayEmail" style="color: var(--color-primary-dark);"></b>
                            </p>
                        </div>
                        
                        <div class="d-flex justify-content-center gap-1 gap-sm-3 mb-5 mt-2">
                            <input type="text" class="form-control auth-input text-center otp-box forgot-otp-box" maxlength="1" oninput="moveForgotNext(this, 1)" onkeydown="moveForgotPrev(event, this, 0)" required>
                            <input type="text" class="form-control auth-input text-center otp-box forgot-otp-box" maxlength="1" oninput="moveForgotNext(this, 2)" onkeydown="moveForgotPrev(event, this, 1)" required>
                            <input type="text" class="form-control auth-input text-center otp-box forgot-otp-box" maxlength="1" oninput="moveForgotNext(this, 3)" onkeydown="moveForgotPrev(event, this, 2)" required>
                            <input type="text" class="form-control auth-input text-center otp-box forgot-otp-box" maxlength="1" oninput="moveForgotNext(this, 4)" onkeydown="moveForgotPrev(event, this, 3)" required>
                            <input type="text" class="form-control auth-input text-center otp-box forgot-otp-box" maxlength="1" oninput="moveForgotNext(this, 5)" onkeydown="moveForgotPrev(event, this, 4)" required>
                            <input type="text" class="form-control auth-input text-center otp-box forgot-otp-box" maxlength="1" oninput="moveForgotNext(this, 6)" onkeydown="moveForgotPrev(event, this, 5)" required>
                        </div>
                        
                        <div class="text-center auth-register-text mb-4">
                                Chưa nhận được mã? <a href="javascript:void(0)" id="forgotResendOtp" class="text-muted text-decoration-none pointer-events-none" onclick="startForgotOtpTimer()">Gửi lại (<span id="forgotTimer">60</span>s)</a>
                        </div>
                        
                        <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
                            <button type="button" class="btn btn-outline-secondary btn-modal-step fw-bold" style="border-radius: 25px;" onclick="goToForgotStep(1, true)">QUAY LẠI</button>
                            <button type="button" class="btn btn-auth-submit btn-modal-step text-white m-0" onclick="goToForgotStep(3)">TIẾP TỤC</button>
                        </div>
                    </div>

                    <div id="forgotStep3" class="register-step" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label auth-label">Mật khẩu <span class="text-danger">*</span></label>
                            <div class="password-input-wrapper">
                                <input type="password" id="forgotNewPassword" class="form-control auth-input w-100" 
                                    placeholder="Nhập mật khẩu của bạn (Ít nhất 8 ký tự)" required>
                                <span class="toggle-password" onclick="togglePassword('forgotNewPassword', this)">
                                    <i class="fa-solid fa-eye-slash text-muted"></i>
                                </span>
                            </div>
                            <small id="forgot-password-error" class="text-danger mt-1" style="display:none; font-size: 0.85rem; font-weight: 600;"></small>
                        </div>
                        
                        <div class="mb-2">
                            <label class="form-label auth-label">Xác thực mật khẩu <span class="text-danger">*</span></label>
                            <div class="password-input-wrapper">
                                <input type="password" id="forgotConfirmPassword" class="form-control auth-input w-100" 
                                    placeholder="Nhập lại mật khẩu của bạn" required>
                                <span class="toggle-password" onclick="togglePassword('forgotConfirmPassword', this)">
                                    <i class="fa-solid fa-eye-slash text-muted"></i>
                                </span>
                            </div>
                            <small id="forgot-confirm-error" class="text-danger mt-1" style="display:none; font-size: 0.85rem; font-weight: 600;">Mật khẩu xác nhận không khớp!</small>
                        </div>

                        <div class="mt-3 mb-4 text-start" style="font-size: 0.85rem; color: #333;">
                            <p class="mb-1">Lưu ý:</p>
                            <ul class="mb-0 ps-3" style="line-height: 1.6;">
                                <li>Sử dụng tối thiểu 8 ký tự.</li>
                                <li>Bao gồm số, chữ thường, chữ in hoa và ký tự đặc biệt.</li>
                            </ul>
                        </div>
                        
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-modal-step fw-bold" style="border-radius: 25px;" onclick="goToForgotStep(2, true)">QUAY LẠI</button>
                            <button type="button" class="btn btn-auth-submit btn-modal-step text-white m-0" onclick="submitForgotPassword()">HOÀN TẤT</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let forgotTimerInterval;

    function startForgotOtpTimer() {
        clearInterval(forgotTimerInterval);
        let timeLeft = 60;
        const resendLink = document.getElementById('forgotResendOtp');
        
        resendLink.classList.add('pointer-events-none', 'text-muted');
        resendLink.classList.remove('auth-register-link');
        resendLink.innerHTML = `Gửi lại (<span id="forgotTimer">${timeLeft}</span>s)`;

        forgotTimerInterval = setInterval(() => {
            timeLeft--;
            const timerSpan = document.getElementById('forgotTimer');
            if(timerSpan) timerSpan.innerText = timeLeft;
            
            if (timeLeft <= 0) {
                clearInterval(forgotTimerInterval);
                resendLink.classList.remove('pointer-events-none', 'text-muted');
                resendLink.classList.add('auth-register-link');
                resendLink.innerHTML = 'Gửi lại mã';
            }
        }, 1000);
    }

    function moveForgotNext(current, nextFieldIndex) {
        current.value = current.value.replace(/[^0-9]/g, '');
        if (current.value.length === 1) {
            const boxes = document.querySelectorAll('.forgot-otp-box');
            if (nextFieldIndex < boxes.length) boxes[nextFieldIndex].focus();
        }
    }

    function moveForgotPrev(e, current, prevFieldIndex) {
        if (e.key === 'Backspace' && current.value === '') {
            const boxes = document.querySelectorAll('.forgot-otp-box');
            if (prevFieldIndex >= 0) boxes[prevFieldIndex].focus();
        }
    }

    function backToLogin() {
        let forgotModal = bootstrap.Modal.getInstance(document.getElementById('forgotPasswordModal'));
        if(forgotModal) forgotModal.hide();
        let loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
    }

    async function goToForgotStep(stepNumber, isBack = false) {
        const modalTitle = document.getElementById('forgotTitle');
        const modalSubtitle = document.getElementById('forgotSubtitle');

        if (stepNumber === 3) {
            modalTitle.innerText = "TẠO MẬT KHẨU MỚI";
            modalSubtitle.innerText = "Đăng nhập để nhận được các ưu đãi và quyền lợi hấp dẫn!";
            modalSubtitle.style.display = "block"; 
        } else {
            modalTitle.innerText = "QUÊN MẬT KHẨU";
            modalSubtitle.innerText = "Nhập email của bạn để nhận mật khẩu mới từ LocalMate";
            modalSubtitle.style.display = "block";
        }

        if (stepNumber === 2 && !isBack) {
            const emailInput = document.getElementById('forgotEmailInput');
            if (!emailInput.checkValidity()) { emailInput.reportValidity(); return; }

            document.getElementById('forgotDisplayEmail').innerText = emailInput.value;
            
            document.getElementById('forgotStep1').style.display = 'none';
            document.getElementById('forgotStep3').style.display = 'none';
            document.getElementById('forgotStep2').style.display = 'block';
            startForgotOtpTimer();
            document.querySelectorAll('.forgot-otp-box').forEach(box => box.value = '');

            let formData = new FormData();
            formData.append('email', emailInput.value);

            try {
                let response = await fetch('index.php?controller=auth&action=send_forgot_otp', { method: 'POST', body: formData });
                let data = await response.json();
                
                if (data.status !== 'success') {
                    alert(data.message); 
                    goToForgotStep(1, true);
                    return; 
                }
            } catch (error) {
                alert("Lỗi kết nối máy chủ!"); 
                goToForgotStep(1, true);
                return;
            }
            return;
        }

        if (stepNumber === 3 && !isBack) {
            let otpValue = '';
            document.querySelectorAll('.forgot-otp-box').forEach(box => { otpValue += box.value; });
            if (otpValue.length < 6) { alert("Vui lòng nhập đủ 6 số mã OTP!"); return; }
            
            let formData = new FormData();
            formData.append('otp', otpValue);

            try {
                let response = await fetch('index.php?controller=auth&action=verify_otp', { method: 'POST', body: formData });
                let data = await response.json();

                if (data.status === 'success') {
                    clearInterval(forgotTimerInterval); 
                } else {
                    alert(data.message); return;
                }
            } catch (error) {
                alert("Lỗi kết nối máy chủ!"); return;
            }
        }

        document.getElementById('forgotStep1').style.display = 'none';
        document.getElementById('forgotStep2').style.display = 'none';
        document.getElementById('forgotStep3').style.display = 'none';
        document.getElementById('forgotStep' + stepNumber).style.display = 'block';
        
        if (stepNumber === 2 && !isBack) document.querySelector('.forgot-otp-box').focus();
        if (stepNumber === 3) document.getElementById('forgotNewPassword').focus();
    }

    async function submitForgotPassword() {
        const pass = document.getElementById('forgotNewPassword').value;
        const confirm = document.getElementById('forgotConfirmPassword').value;
        const passError = document.getElementById('forgot-password-error');
        const confirmError = document.getElementById('forgot-confirm-error');
        const email = document.getElementById('forgotEmailInput').value;

        const complexityRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\\$%\\^&\\*])");
        let isValid = true;

        passError.style.display = 'none';
        confirmError.style.display = 'none';

        if (pass.length < 8) {
            passError.innerText = "Mật khẩu phải có ít nhất 8 ký tự.";
            passError.style.display = 'block'; isValid = false;
        } else if (!complexityRegex.test(pass)) {
            passError.innerText = "Mật khẩu phải bao gồm số, chữ thường, chữ in hoa và ký tự đặc biệt.";
            passError.style.display = 'block'; isValid = false;
        }

        if (pass !== confirm || confirm === "") {
            confirmError.style.display = 'block'; isValid = false;
        }

        if (isValid) {
            let formData = new FormData();
            formData.append('email', email);
            formData.append('new_password', pass);

            try {
                let response = await fetch('index.php?controller=auth&action=reset_password', { method: 'POST', body: formData });
                let data = await response.json();

                if (data.status === 'success') {
                    alert('Đổi mật khẩu thành công! Vui lòng đăng nhập lại.');
                    
                    let forgotModal = bootstrap.Modal.getInstance(document.getElementById('forgotPasswordModal'));
                    if(forgotModal) forgotModal.hide();
                    
                    document.getElementById('forgotStep3').style.display = 'none';
                    document.getElementById('forgotStep1').style.display = 'block';
                    document.getElementById('forgotTitle').innerText = "QUÊN MẬT KHẨU";
                    document.getElementById('forgotSubtitle').innerText = "Nhập email của bạn để nhận mật khẩu mới từ LocalMate";
                    document.getElementById('forgotPasswordForm').reset();

                    let loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                    loginModal.show();
                } else {
                    alert(data.message);
                }
            } catch (error) {
                alert("Lỗi kết nối máy chủ!");
            }
        }
    }

    document.addEventListener('keydown', function(event) {
        if (document.getElementById('forgotPasswordModal').classList.contains('show')) {
            if (event.key === 'Enter') {
                event.preventDefault();
                
                const step1 = document.getElementById('forgotStep1');
                const step2 = document.getElementById('forgotStep2');
                const step3 = document.getElementById('forgotStep3');

                if (step1.style.display !== 'none') {
                    if (document.getElementById('forgotEmailInput').checkValidity()) goToForgotStep(2);
                    else document.getElementById('forgotEmailInput').reportValidity();
                } 
                else if (step2.style.display !== 'none') goToForgotStep(3);
                else if (step3.style.display !== 'none') submitForgotPassword();
            }

            if (event.key === 'Backspace' && event.target.classList.contains('forgot-otp-box')) {
                if (event.target.value === '') {
                    const boxes = document.querySelectorAll('.forgot-otp-box');
                    const index = Array.from(boxes).indexOf(event.target);
                    if (index > 0) boxes[index - 1].focus();
                }
            }
        }
    });
</script>