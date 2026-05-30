<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 680px;">
        <div class="modal-content login-modal-content">
            
            <div class="modal-header login-modal-header border-0">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="z-index: 10;"></button>
                <img src="public/image/decor/earth.png" alt="LocalMate Globe" class="login-earth-icon">
                <div class="login-header-text">
                    <h3 class="login-title mb-1" id="regTitle">TẠO TÀI KHOẢN</h3>
                    <p class="login-subtitle" id="regSubtitle">Đăng ký miễn phí để nhận được các ưu đãi và quyền lợi hấp dẫn!</p>
                </div>
            </div>

            <div class="modal-body login-modal-body pt-2">
                <form action="index.php?controller=auth&action=register" method="POST" id="registerForm">
                    
                    <div id="step1" class="register-step">
                        <div class="mb-3">
                            <label class="form-label auth-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" name="hoten" id="regHoTen" class="form-control auth-input" placeholder="Nhập họ và tên của bạn" required 
                                   oninvalid="this.setCustomValidity('Vui lòng nhập họ và tên của bạn.')" 
                                   oninput="this.setCustomValidity('')">
                        </div>
                        <div class="mb-4">
                            <label class="form-label auth-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email_sdt" id="regEmailSdt" class="form-control auth-input" placeholder="Nhập email của bạn" required 
                                   oninvalid="this.setCustomValidity(this.value === '' ? 'Vui lòng nhập email của bạn.' : 'Email không đúng định dạng hợp lệ.')" 
                                   oninput="this.setCustomValidity('')">
                        </div>
                        
                        <div class="text-center auth-register-text mb-4">
                            Đã có tài khoản? <a href="#" class="auth-register-link text-decoration-none" onclick="backToLoginFromRegister()">Đăng nhập ngay</a>
                        </div>

                        <div class="auth-terms mb-4">
                            Bằng cách tiếp tục, bạn đồng ý với <a href="#">Điều khoản và Điều kiện</a> này và bạn đã được thông báo<br>về <a href="#">Chính sách bảo mật dữ liệu</a> của chúng tôi.
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary w-50 fw-bold" style="border-radius: 25px;" onclick="backToLoginFromRegister()">QUAY LẠI</button>
                            <button type="button" class="btn btn-auth-submit text-white w-50 m-0" onclick="goToStep(2)">TIẾP TỤC</button>
                        </div>
                    </div>

                    <div id="step2" class="register-step" style="display: none;">
                        <div class="mb-4">
                            <label class="form-label auth-label d-block text-start" style="font-size: 1.05rem;">Xác thực OTP <span class="text-danger">*</span></label>
                            <p class="mb-0 text-start d-block w-100" style="font-size: 0.95rem; color: #555;">
                                Nhập mã 6 số đã gửi đến <b id="displayEmailSdt" style="color: var(--color-primary-dark);"></b>
                            </p>
                        </div>
                        
                        <div class="d-flex justify-content-center gap-3 mb-5 mt-2">
                            <input type="text" class="form-control auth-input text-center otp-box" maxlength="1" oninput="moveToNext(this, 1)" onkeydown="moveToPrev(event, this, 0)" required>
                            <input type="text" class="form-control auth-input text-center otp-box" maxlength="1" oninput="moveToNext(this, 2)" onkeydown="moveToPrev(event, this, 1)" required>
                            <input type="text" class="form-control auth-input text-center otp-box" maxlength="1" oninput="moveToNext(this, 3)" onkeydown="moveToPrev(event, this, 2)" required>
                            <input type="text" class="form-control auth-input text-center otp-box" maxlength="1" oninput="moveToNext(this, 4)" onkeydown="moveToPrev(event, this, 3)" required>
                            <input type="text" class="form-control auth-input text-center otp-box" maxlength="1" oninput="moveToNext(this, 5)" onkeydown="moveToPrev(event, this, 4)" required>
                            <input type="text" class="form-control auth-input text-center otp-box" maxlength="1" oninput="moveToNext(this, 6)" onkeydown="moveToPrev(event, this, 5)" required>
                            <input type="hidden" name="otp" id="finalOtp">
                        </div>
                        
                        <div class="text-center auth-register-text mb-4">
                             Chưa nhận được mã? <a href="javascript:void(0)" id="resendOtpLink" class="text-muted text-decoration-none pointer-events-none" onclick="startOtpTimer()">Gửi lại (<span id="otpTimer">60</span>s)</a>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary w-50 fw-bold" style="border-radius: 25px;" onclick="goToStep(1, true)">QUAY LẠI</button>
                            <button type="button" class="btn btn-auth-submit text-white w-50 m-0" onclick="goToStep(3)">TIẾP TỤC</button>
                        </div>
                    </div>

                    <div id="step3" class="register-step" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label auth-label">Mật khẩu *</label>
                            <div class="password-input-wrapper">
                                <input type="password" name="password" id="regPassword" class="form-control auth-input w-100" 
                                    placeholder="Nhập mật khẩu của bạn (Ít nhất 8 ký tự)" required>
                                <span class="toggle-password" onclick="togglePassword('regPassword', this)">
                                    <i class="fa-solid fa-eye-slash text-muted"></i>
                                </span>
                            </div>
                            <small id="password-error" class="text-danger mt-1" style="display:none; font-size: 0.85rem; font-weight: 600;"></small>
                        </div>
                        
                        <div class="mb-2">
                            <label class="form-label auth-label">Xác thực mật khẩu *</label>
                            <div class="password-input-wrapper">
                                <input type="password" name="confirm_password" id="regConfirmPassword" class="form-control auth-input w-100" 
                                    placeholder="Nhập lại mật khẩu của bạn" required>
                                <span class="toggle-password" onclick="togglePassword('regConfirmPassword', this)">
                                    <i class="fa-solid fa-eye-slash text-muted"></i>
                                </span>
                            </div>
                            <small id="confirm-error" class="text-danger mt-1" style="display:none; font-size: 0.85rem; font-weight: 600;">Mật khẩu xác nhận không khớp!</small>
                        </div>

                        <div class="mt-3 mb-4 text-start" style="font-size: 0.85rem; color: #333;">
                            <p class="mb-1">Lưu ý:</p>
                            <ul class="mb-0 ps-3" style="line-height: 1.6;">
                                <li>Sử dụng tối thiểu 8 ký tự.</li>
                                <li>Bao gồm số, chữ thường, chữ in hoa và ký tự đặc biệt.</li>
                            </ul>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary w-50 fw-bold" style="border-radius: 25px;" onclick="goToStep(2, true)">QUAY LẠI</button>
                            <button type="button" id="btnSubmitRegister" class="btn btn-auth-submit text-white w-50 m-0" onclick="submitRegisterForm()">HOÀN TẤT</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let timerInterval;

    function startOtpTimer() {
        clearInterval(timerInterval);
        let timeLeft = 60;
        const resendLink = document.getElementById('resendOtpLink');
        
        resendLink.classList.add('pointer-events-none', 'text-muted');
        resendLink.classList.remove('auth-register-link');
        resendLink.innerHTML = `Gửi lại (<span id="otpTimer">${timeLeft}</span>s)`;

        timerInterval = setInterval(() => {
            timeLeft--;
            const timerSpan = document.getElementById('otpTimer');
            if(timerSpan) timerSpan.innerText = timeLeft;
            
            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                resendLink.classList.remove('pointer-events-none', 'text-muted');
                resendLink.classList.add('auth-register-link');
                resendLink.innerHTML = 'Gửi lại mã';
            }
        }, 1000);
    }

    function moveToNext(current, nextFieldIndex) {
        current.value = current.value.replace(/[^0-9]/g, '');
        if (current.value.length === 1) {
            const boxes = document.querySelectorAll('.otp-box');
            if (nextFieldIndex < boxes.length) {
                boxes[nextFieldIndex].focus();
            }
        }
    }

    function moveToPrev(e, current, prevFieldIndex) {
        if (e.key === 'Backspace' && current.value === '') {
            const boxes = document.querySelectorAll('.otp-box');
            if (prevFieldIndex >= 0) {
                boxes[prevFieldIndex].focus();
            }
        }
    }

    function backToLoginFromRegister() {
        let registerModal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
        if(registerModal) registerModal.hide();
        let loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
    }

    async function goToStep(stepNumber, isBack = false) {
        const modalTitle = document.getElementById('regTitle');
        const modalSubtitle = document.getElementById('regSubtitle');

        if (stepNumber === 3) {
            modalTitle.innerText = "TẠO MẬT KHẨU";
        } else {
            modalTitle.innerText = "TẠO TÀI KHOẢN";
        }

        if (stepNumber === 2 && !isBack) {
            const hotenInput = document.getElementById('regHoTen');
            const emailInput = document.getElementById('regEmailSdt');

            if (!hotenInput.checkValidity()) { hotenInput.reportValidity(); return; }
            if (!emailInput.checkValidity()) { emailInput.reportValidity(); return; }

            document.getElementById('displayEmailSdt').innerText = emailInput.value;
            document.getElementById('step1').style.display = 'none';
            document.getElementById('step3').style.display = 'none';
            document.getElementById('step2').style.display = 'block';
            startOtpTimer();
            document.querySelectorAll('.otp-box').forEach(box => box.value = '');

            let formData = new FormData();
            formData.append('email', emailInput.value);

            try {
                let response = await fetch('index.php?controller=auth&action=send_otp', { method: 'POST', body: formData });
                let data = await response.json();
                
                if (data.status !== 'success') {
                    alert(data.message); 
                    goToStep(1, true); // Nếu lỗi thì trả về bước 1
                    return; 
                }
            } catch (error) {
                alert("Lỗi kết nối máy chủ khi gửi mail!"); 
                goToStep(1, true);
                return;
            }
            return;
        }

        if (stepNumber === 3 && !isBack) {
            let otpValue = '';
            document.querySelectorAll('.otp-box').forEach(box => { otpValue += box.value; });
            
            if (otpValue.length < 6) { alert("Vui lòng nhập đủ 6 số mã OTP!"); return; }
            
            let formData = new FormData();
            formData.append('otp', otpValue);

            try {
                let response = await fetch('index.php?controller=auth&action=verify_otp', { method: 'POST', body: formData });
                let data = await response.json();

                if (data.status === 'success') {
                    document.getElementById('finalOtp').value = otpValue;
                    clearInterval(timerInterval); 
                } else {
                    alert(data.message); 
                    return;
                }
            } catch (error) {
                alert("Lỗi kết nối máy chủ!"); return;
            }
        }

        document.getElementById('step1').style.display = 'none';
        document.getElementById('step2').style.display = 'none';
        document.getElementById('step3').style.display = 'none';
        document.getElementById('step' + stepNumber).style.display = 'block';
        
        if (stepNumber === 2 && !isBack) document.querySelector('.otp-box').focus();
        if (stepNumber === 3) document.getElementById('regPassword').focus();
    }

    function submitRegisterForm() {
        const pass = document.getElementById('regPassword').value;
        const confirm = document.getElementById('regConfirmPassword').value;
        const passError = document.getElementById('password-error');
        const confirmError = document.getElementById('confirm-error');

        const complexityRegex = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\\$%\\^&\\*])");
        let isValid = true;

        passError.style.display = 'none';
        confirmError.style.display = 'none';

        if (pass.length < 8) {
            passError.innerText = "Mật khẩu phải có ít nhất 8 ký tự.";
            passError.style.display = 'block';
            isValid = false;
        } else if (!complexityRegex.test(pass)) {
            passError.innerText = "Mật khẩu phải bao gồm số, chữ thường, chữ in hoa và ký tự đặc biệt.";
            passError.style.display = 'block';
            isValid = false;
        }

        if (pass !== confirm || confirm === "") {
            confirmError.style.display = 'block';
            isValid = false;
        }

        if (isValid) {
            document.getElementById('registerForm').submit();
        }
    }

    document.addEventListener('keydown', function(event) {
        if (document.getElementById('registerModal').classList.contains('show')) {
            
            if (event.key === 'Enter') {
                event.preventDefault();
                
                const step1 = document.getElementById('step1');
                const step2 = document.getElementById('step2');
                const step3 = document.getElementById('step3');

                if (step1.style.display !== 'none') {
                    if (document.getElementById('regHoTen').checkValidity() && document.getElementById('regEmailSdt').checkValidity()) {
                        goToStep(2);
                    } else {
                        document.getElementById('regHoTen').reportValidity();
                        document.getElementById('regEmailSdt').reportValidity();
                    }
                } 
                else if (step2.style.display !== 'none') {
                    goToStep(3);
                } 
                else if (step3.style.display !== 'none') {
                    submitRegisterForm();
                }
            }

            if (event.key === 'Backspace' && event.target.classList.contains('otp-box')) {
                if (event.target.value === '') {
                    const boxes = document.querySelectorAll('.otp-box');
                    const index = Array.from(boxes).indexOf(event.target);
                    if (index > 0) boxes[index - 1].focus();
                }
            }
        }
    });
</script>