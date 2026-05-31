<?php
require_once 'app/views/layouts/header.php';
/**
 * @var array $userInfo
 * @var array $userStats
 * @var string $tierColor
 * @var bool $isMaxTier
 * @var int $chuyenConLai
 * @var array $tierInfo
 * @var int $phanTramHang
 * @var string $avatarUrl
 * @var bool $missingInfo
 */
?>
<style>
    body { font-family: 'Quicksand', sans-serif; background-color: #F8FAF5; }
    .breadcrumb-custom { padding: 10px 40px; font-weight: 500; color: #0d5c2c; background: white; border-bottom: 1px solid #eee; }
    .profile-container { padding: 40px; max-width: 1200px; margin: auto; }
    .sidebar-card { background: white; border-radius: 20px; padding: 30px 20px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #f0f0f0; }
    .avatar-wrapper { position: relative; width: 120px; height: 120px; margin: 0 auto 15px; cursor: pointer; transition: transform 0.3s ease; }
    .avatar-wrapper:hover { transform: scale(1.05); }
    .avatar-wrapper img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; border: 4px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .camera-btn { position: absolute; bottom: 5px; right: 5px; background: #0d5c2c; color: white; border-radius: 50%; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border: 2px solid white; font-size: 15px; transition: background-color 0.2s; }
    .avatar-wrapper:hover .camera-btn { background-color: #E88D39; }
    .user-name { color: #0d5c2c; font-weight: 700; font-size: 22px; margin-bottom: 5px; }
    .member-since { color: #666; font-size: 14px; margin-bottom: 20px; }
    .stats-row { display: flex; justify-content: center; gap: 10px; font-size: 14px; font-weight: 600; color: #555; margin-bottom: 25px; }
    .stats-row div { white-space: nowrap; }
    .stats-row span { color: #E88D39; }
    .tier-section { border-top: 1px solid #eee; padding-top: 25px; }
    .tier-icon { font-size: 55px; margin-bottom: 15px; } 
    .tier-name { font-weight: 800; font-size: 20px; text-transform: uppercase;}
    .tier-desc { font-size: 13px; color: #0d5c2c; font-weight: 500; margin-top: 12px; line-height: 1.6; padding: 0; }
    .progress-custom { height: 6px; border-radius: 10px; background: #e0e0e0; margin: 15px auto; width: 85%; }
    .progress-custom .progress-bar { border-radius: 10px; }
    .btn-logout { background-color: #D6E8D8; color: #0d5c2c; font-weight: 700; border-radius: 30px; padding: 10px 0; margin-top: 20px; width: 70%; border: none; transition: 0.3s; }
    .btn-logout:hover { background-color: #b5d5b9; }
    .main-card { background: white; border-radius: 20px; padding: 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #f0f0f0; }
    .section-title { color: #0d5c2c !important; font-weight: 700; font-size: 24px; margin-bottom: 30px; background-color: transparent !important; padding: 0 !important; display: block !important;}
    .form-label { font-weight: 700; color: #0d5c2c; margin-bottom: 8px; font-size: 15px; }
    .form-control, .form-select { border-radius: 8px; padding: 12px 15px; border: 1px solid #7DA27E; color: #4A7C59; font-weight: 600; background-color: #FDFBF4; }
    .form-control:focus, .form-select:focus { border-color: #0d5c2c; box-shadow: 0 0 0 0.2rem rgba(13, 92, 44, 0.1); background-color: #FDFBF4; }
    .form-control[readonly], .form-control:disabled, .form-select:disabled { background-color: #E9ECEF; color: #6C757D; border-color: #CED4DA; cursor: not-allowed; opacity: 1; }    input[type="password"]::-ms-reveal, input[type="password"]::-ms-clear { display: none; }
    .password-wrapper { position: relative; }
    .password-wrapper input { padding-right: 40px; }
    .toggle-eye { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #7DA27E; opacity: 0; transition: opacity 0.2s, color 0.2s; font-size: 16px; }
    .password-wrapper input:focus + .toggle-eye, .password-wrapper.has-text .toggle-eye { opacity: 1; }
    .toggle-eye:hover { color: #0d5c2c; }
    .password-toggle-box { border: 1px solid #7DA27E; border-radius: 8px; padding: 12px 15px; display: flex; align-items: center; cursor: pointer; user-select: none; background: #FDFBF4; }
    .custom-checkbox { width: 22px; height: 22px; border: 2px solid #7DA27E; border-radius: 4px; margin-right: 12px; display: flex; align-items: center; justify-content: center; color: white; transition: 0.2s; }
    .password-toggle-box.active .custom-checkbox { background-color: #0d5c2c; border-color: #0d5c2c; }
    .password-toggle-box span { font-weight: 600; color: #0d5c2c; font-size: 15px; }
    .btn-save { background-color: #0d5c2c; color: white; font-weight: 700; border-radius: 30px; padding: 12px 40px; border: none; letter-spacing: 1px; transition: 0.3s; }
    .btn-save:hover { background-color: #09401f; color: white;}
    .modal-avatar-btn { display: flex; align-items: center; gap: 15px; width: 100%; padding: 16px; border: 1px solid #d1d5db; border-radius: 12px; background-color: white; color: #333; font-weight: 500; font-size: 16px; text-align: left; transition: all 0.2s; margin-bottom: 12px; white-space: nowrap; }
    .modal-avatar-btn:hover { border-color: #0d5c2c; background-color: #f8faf5; color: #0d5c2c; }
    .modal-avatar-btn i.icon-left { font-size: 24px; color: #0d5c2c; width: 30px; text-align: center; }
    #cameraStream { width: 100%; border-radius: 12px; display: none; margin-bottom: 15px; background: #000;}
    #btnCapture { display: none; }
    .illustration-item { width: 100%; aspect-ratio: 1/1; object-fit: cover; border-radius: 50%; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 4px 10px rgba(0,0,0,0.08); border: 3px solid transparent; }
    .illustration-item:hover { transform: scale(1.1); border-color: #0d5c2c; }
</style>

<div class="breadcrumb-custom">
    <a href="index.php?controller=home"><i class="fa-solid fa-house me-1"></i>Trang chủ</a> 
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <a href="index.php?controller=profile">Hồ sơ cá nhân</a>
</div>

<main class="profile-container">

    <?php if (isset($missingInfo) && $missingInfo && empty($message)): ?>
        <div class="alert alert-warning alert-dismissible fade show mb-4 fw-bold" role="alert" style="color: #856404; background-color: #fff3cd; border-color: #ffeeba;">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> Bạn chưa cập nhật đầy đủ thông tin hồ sơ. Vui lòng bổ sung để có trải nghiệm đặt tour tốt nhất!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($message)): ?>
        <div class="alert alert-<?= $msg_type ?> alert-dismissible fade show mb-4" role="alert">
            <?= $message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-4 col-xl-3">
            <div class="sidebar-card">
                <div class="avatar-wrapper" data-bs-toggle="modal" data-bs-target="#avatarModal" title="Đổi ảnh đại diện">
                    <img src="<?= htmlspecialchars($avatarUrl) ?>" alt="Avatar" id="mainAvatarImg">
                    <div class="camera-btn"><i class="fa-solid fa-camera"></i></div>
                </div>
                
                <h4 class="user-name"><?= htmlspecialchars($userInfo['HoTen'] ?? '') ?></h4>
                
                <div class="stats-row">
                    <div><span><?= $userStats['chuyen'] ?></span> Chuyến</div>
                    <div><span><?= $userStats['danh_gia'] ?></span> Đánh giá</div>
                    <div><span><?= $userStats['yeu_thich'] ?></span> Yêu thích</div>
                </div>

                <div class="tier-section">
                    <i class="fa-solid fa-medal tier-icon" style="color: <?= $tierColor ?>;"></i>
                    <div class="tier-name" style="color: <?= $tierColor ?>;">Thành viên <?= mb_strtolower($userInfo['HangThanhVien'], 'UTF-8') ?></div>
                    
                    <?php if(!$isMaxTier): ?>
                        <div class="tier-desc" title="Bạn còn <?= $chuyenConLai ?> chuyến đi nữa để thăng hạng <?= $tierInfo['next'] ?>!">
                            Bạn còn <b style="font-size: 14px; font-weight: 600; color: #E88D39;"><?= $chuyenConLai ?> chuyến đi</b> nữa để thăng hạng <?= $tierInfo['next'] ?> và nhận voucher giảm giá <?= $tierInfo['discount'] ?>!
                        </div>
                    <?php else: ?>
                        <div class="tier-desc">Bạn đã đạt hạng cao nhất! Tận hưởng đặc quyền giảm giá 20% cho mọi chuyến đi.</div>
                    <?php endif; ?>

                    <div class="progress progress-custom">
                        <div class="progress-bar" role="progressbar" style="width: <?= $phanTramHang ?>%; background-color: #0d5c2c;"></div>
                    </div>
                </div>

                <a href="index.php?controller=auth&action=logout" class="btn btn-logout mt-4 d-block w-75 mx-auto">
                    <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Đăng xuất
                </a>
            </div>
        </div>

        <div class="col-lg-8 col-xl-9">
            <div class="main-card">
                <h3 class="section-title">Tài khoản</h3>
                <form action="index.php?controller=profile" method="POST" id="profileForm">
                    <input type="hidden" name="action" value="update_profile">
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="<?= htmlspecialchars($userInfo['Gmail'] ?? '') ?>" readonly disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label d-none d-md-block">&nbsp;</label>
                            <div class="password-toggle-box w-100" id="togglePasswordBtn">
                                <input type="checkbox" name="doiMatKhau" id="chkDoiMatKhau" class="d-none">
                                <div class="custom-checkbox"><i class="fa-solid fa-check d-none" id="checkIcon"></i></div>
                                <span>Đổi mật khẩu</span>
                            </div>
                        </div>

                        <div class="col-12 d-none" id="passwordFieldsRow">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Mật khẩu cũ <span class="text-danger">*</span></label>
                                    <div class="password-wrapper">
                                        <input type="password" class="form-control" name="matKhauCu" id="matKhauCu">
                                        <i class="fa-regular fa-eye-slash toggle-eye"></i>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Mật khẩu mới <span class="text-danger">*</span></label>
                                    <div class="password-wrapper">
                                        <input type="password" class="form-control" name="matKhauMoi" id="matKhauMoi" 
                                               pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}" 
                                               title="Tối thiểu 8 ký tự, bao gồm số, chữ thường, chữ hoa và ký tự đặc biệt.">
                                        <i class="fa-regular fa-eye-slash toggle-eye"></i>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
                                    <div class="password-wrapper">
                                        <input type="password" class="form-control" name="xacNhanMK" id="xacNhanMK">
                                        <i class="fa-regular fa-eye-slash toggle-eye"></i>
                                    </div>
                                </div>
                                <div class="col-12 mt-1">
                                    <small class="text-muted"><i class="fa-solid fa-circle-info me-1"></i> <b>Quy định mật khẩu:</b> Sử dụng tối thiểu 8 ký tự, bao gồm số, chữ thường, chữ in hoa và ký tự đặc biệt.</small>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($userInfo['HoTen'] ?? '') ?>" readonly disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="sdt" value="<?= htmlspecialchars(($userInfo['SDT'] === 'Chưa cập nhật') ? '' : ($userInfo['SDT'] ?? '')) ?>" required placeholder="Nhập số điện thoại">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Ngày sinh <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="ngaySinh" id="ngaySinhInput"
                                value="<?= htmlspecialchars($userInfo['NgaySinh'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Giới tính</label>
                            <select class="form-select" name="gioiTinh">
                                <option value="" <?= empty($userInfo['GioiTinh']) ? 'selected' : '' ?>>--Chọn--</option>
                                <option value="Nữ" <?= (isset($userInfo['GioiTinh']) && $userInfo['GioiTinh'] == 'Nữ') ? 'selected' : '' ?>>Nữ</option>
                                <option value="Nam" <?= (isset($userInfo['GioiTinh']) && $userInfo['GioiTinh'] == 'Nam') ? 'selected' : '' ?>>Nam</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Số điện thoại khẩn cấp <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="sdtKhanCap" value="<?= htmlspecialchars(($userInfo['SDTKhanCap'] === 'Chưa cập nhật') ? '' : ($userInfo['SDTKhanCap'] ?? '')) ?>" required placeholder="SĐT người thân">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="diaChi" value="<?= htmlspecialchars($userInfo['DiaChi'] ?? '') ?>" required placeholder="Nhập địa chỉ của bạn">
                        </div>
                    </div>

                    <div class="text-center mt-5">
                        <button type="button" id="btnEditSave" class="btn btn-save px-5">
                            <i class="fa-regular fa-pen-to-square me-2"></i>CHỈNH SỬA
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>


<div class="modal fade" id="avatarModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 385px;">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
            <div class="modal-header border-0 pb-0 pt-3 px-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button type="button" class="btn border-0 p-0 me-3 d-none" id="btnBackToOptions">
                        <i class="fa-solid fa-arrow-left fs-5 text-muted"></i>
                    </button>
                    <h5 class="modal-title fw-bold" style="color: #0d5c2c; font-size: 18px; margin: 0;">Thay đổi ảnh đại diện</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="margin: 0;"></button>
            </div>
            
            <div class="modal-body p-4 text-center">
                <video id="cameraStream" autoplay playsinline></video>
                <button id="btnCapture" class="btn btn-save w-100 mb-3"><i class="fa-solid fa-camera"></i> Chụp ảnh ngay</button>
                
                <div id="avatarOptions">
                    <button class="modal-avatar-btn" data-bs-target="#illustrationsModal" data-bs-toggle="modal" data-bs-dismiss="modal">
                        <i class="fa-solid fa-face-smile-wink icon-left"></i> Chọn hình ảnh mặc định
                    </button>
                    <input type="file" id="fileUploadInput" accept="image/*" class="d-none">
                    <button class="modal-avatar-btn" onclick="document.getElementById('fileUploadInput').click();">
                        <i class="fa-solid fa-image icon-left"></i> Tải ảnh từ thiết bị
                    </button>
                    <button class="modal-avatar-btn mb-0" id="btnOpenCamera">
                        <i class="fa-solid fa-camera-retro icon-left"></i> Chụp ảnh trực tiếp
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="illustrationsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 16px; border: none; height: 75vh;">
            <div class="modal-header border-0 align-items-center pb-2 pt-3 px-4 d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <button type="button" class="btn border-0 p-0 me-3" data-bs-target="#avatarModal" data-bs-toggle="modal" data-bs-dismiss="modal">
                        <i class="fa-solid fa-arrow-left fs-5 text-muted"></i>
                    </button>
                    <h5 class="modal-title fw-bold" style="color: #0d5c2c; font-size: 18px; margin: 0;">Chọn hình ảnh mặc định</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="margin: 0;"></button>
            </div>
            <div class="modal-body p-4 pt-2">
                <div class="row g-3" id="illustrationsGrid"></div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const alertElement = document.querySelector('.alert');
        if (alertElement) {
            setTimeout(() => {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alertElement);
                if (bsAlert) bsAlert.close();
            }, 3000);
        }

        const toggleBox = document.getElementById('togglePasswordBtn');
        const checkbox = document.getElementById('chkDoiMatKhau');
        const checkIcon = document.getElementById('checkIcon');
        const passwordRow = document.getElementById('passwordFieldsRow');
        const mkCu = document.getElementById('matKhauCu');
        const mkMoi = document.getElementById('matKhauMoi');
        const xacNhan = document.getElementById('xacNhanMK');

        toggleBox.addEventListener('click', function() {
            checkbox.checked = !checkbox.checked;
            if(checkbox.checked) {
                toggleBox.classList.add('active'); checkIcon.classList.remove('d-none'); passwordRow.classList.remove('d-none');
                mkCu.setAttribute('required', 'true'); mkMoi.setAttribute('required', 'true'); xacNhan.setAttribute('required', 'true');
                setTimeout(() => mkCu.focus(), 100);
            } else {
                toggleBox.classList.remove('active'); checkIcon.classList.add('d-none'); passwordRow.classList.add('d-none');
                mkCu.removeAttribute('required'); mkMoi.removeAttribute('required'); xacNhan.removeAttribute('required');
                mkCu.value = ''; mkMoi.value = ''; xacNhan.value = '';
                document.querySelectorAll('.password-wrapper').forEach(w => w.classList.remove('has-text'));
            }
        });
        
        const pwWrappers = document.querySelectorAll('.password-wrapper');
        pwWrappers.forEach(wrapper => {
            const input = wrapper.querySelector('input');
            const icon = wrapper.querySelector('.toggle-eye');
            input.addEventListener('input', () => {
                if (input.value.length > 0) wrapper.classList.add('has-text');
                else wrapper.classList.remove('has-text');
            });
            icon.addEventListener('mousedown', function(e) {
                e.preventDefault(); 
                if (input.type === 'password') {
                    input.type = 'text'; icon.classList.replace('fa-eye-slash', 'fa-eye'); icon.style.color = '#0d5c2c'; 
                } else {
                    input.type = 'password'; icon.classList.replace('fa-eye', 'fa-eye-slash'); icon.style.color = '#7DA27E'; 
                }
            });
        });

        xacNhan.addEventListener('input', function() {
            if (mkMoi.value !== xacNhan.value) xacNhan.setCustomValidity('Mật khẩu xác nhận không khớp.');
            else xacNhan.setCustomValidity('');
        });

        const btnEditSave = document.getElementById('btnEditSave');
        const profileForm = document.getElementById('profileForm');
        const editableInputs = profileForm.querySelectorAll('input[name="sdt"], input[name="ngaySinh"], select[name="gioiTinh"], input[name="sdtKhanCap"], input[name="diaChi"]');
        let isEditing = false;

        function setEditMode(active) {
            isEditing = active;
            if (active) {
                editableInputs.forEach(input => { input.removeAttribute('readonly'); input.removeAttribute('disabled'); });
                btnEditSave.innerHTML = '<i class="fa-solid fa-floppy-disk me-2"></i>LƯU';
                btnEditSave.type = 'submit'; 
                toggleBox.style.pointerEvents = 'auto'; toggleBox.style.opacity = '1';
            } else {
                editableInputs.forEach(input => {
                    if (input.tagName === 'SELECT') input.setAttribute('disabled', 'true');
                    else input.setAttribute('readonly', 'true');
                });
                btnEditSave.innerHTML = '<i class="fa-regular fa-pen-to-square me-2"></i>CHỈNH SỬA';
                btnEditSave.type = 'button'; 
                toggleBox.style.pointerEvents = 'none'; toggleBox.style.opacity = '0.6';
                if (checkbox.checked) toggleBox.click(); 
            }
        }

        setEditMode(false);
        btnEditSave.addEventListener('click', function(e) {
            if (!isEditing) { e.preventDefault(); setEditMode(true); }
        });

        
        const mainImg = document.getElementById('mainAvatarImg');
        const fileInput = document.getElementById('fileUploadInput');
        const btnOpenCamera = document.getElementById('btnOpenCamera');
        const btnCapture = document.getElementById('btnCapture');
        const video = document.getElementById('cameraStream');
        const avatarModal = document.getElementById('avatarModal');
        const illustrationsModal = document.getElementById('illustrationsModal');
        let stream = null;

        function saveAvatarInstantly(base64OrUrl) {
        const formData = new FormData();
        formData.append('action', 'update_avatar');
        formData.append('avatar_data', base64OrUrl);

        fetch('index.php?controller=profile', {
            method: 'POST',
            body: formData
        })
        .then(async response => {
            const text = await response.text(); 
            try {
                const data = JSON.parse(text);
                if (data.status === 'success') {
                    window.location.reload();
                }
            } catch (e) {
                console.error("Lỗi Server trả về:", text);
                window.location.reload(); 
            }
        })
        .catch(error => {
            console.error("Lỗi Fetch:", error);
            alert("Lỗi kết nối mạng, vui lòng thử lại!");
        });
    }

        const illustrationsGrid = document.getElementById('illustrationsGrid');
        const googleAnimals = [
            'alligator', 'axolotl', 'badger', 'bat', 'grizzly', 'camel',
            'capybara', 'chameleon', 'cheetah', 'chinchilla', 'chipmunk', 'cormorant',
            'coyote', 'crow', 'dingo', 'dinosaur', 'dolphin', 'duck',
            'elephant', 'ferret', 'fox', 'frog', 'giraffe', 'gopher',
            'hedgehog', 'hippo', 'hyena', 'iguana', 'kangaroo', 'koala',
            'kraken', 'lemur', 'leopard', 'llama', 'monkey', 'moose',
            'narwhal', 'orangutan', 'otter', 'panda', 'penguin', 'platypus',
            'quagga', 'rabbit', 'raccoon', 'rhino', 'sheep', 'shrew',
            'skunk', 'squirrel', 'tiger', 'turtle', 'walrus', 'wolf'
        ];
        
        const bgColors = [ '#F48FB1', '#CE93D8', '#B39DDB', '#9FA8DA', '#90CAF9', 
            '#81D4FA', '#80DEEA', '#80CBC4', '#A5D6A7', '#C5E1A5', '#E6EE9C', 
            '#FFE082', '#FFCC80', '#FFAB91', '#BCAAA4', '#B0BEC5' 
        ];

        const selectedAnimals = googleAnimals.sort(() => 0.5 - Math.random()).slice(0, 24);

        selectedAnimals.forEach(animal => {
            const col = document.createElement('div');
            col.className = 'col-4 col-sm-3 col-md-4 col-lg-3';
            
            const imgUrl = `https://ssl.gstatic.com/docs/common/profile/${animal}_lg.png`;
            const randomColor = bgColors[Math.floor(Math.random() * bgColors.length)];
            
            col.innerHTML = `<img src="${imgUrl}" alt="${animal}" class="illustration-item" style="background-color: ${randomColor}; padding: 15px;" onclick="selectIllustration('${imgUrl}', '${randomColor}')">`;
            illustrationsGrid.appendChild(col);
        });

        window.selectIllustration = function(imgUrl, bgColor) {
            const canvas = document.createElement('canvas');
            canvas.width = 150;
            canvas.height = 150;
            const ctx = canvas.getContext('2d');
            ctx.fillStyle = bgColor;
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            const img = new Image();
            img.crossOrigin = "Anonymous";
            
            img.onload = function() {
                ctx.drawImage(img, 25, 25, 100, 100);
                try {
                    const base64Image = canvas.toDataURL('image/png');
                    saveAvatarInstantly(base64Image); 
                } catch (e) {
                    console.error("Lỗi xuất ảnh:", e);
                    alert("Trình duyệt chặn xử lý ảnh, vui lòng thử lại!");
                }
            };
            
            img.onerror = function() {
                ctx.fillStyle = "white";
                ctx.font = "bold 65px 'Quicksand', sans-serif";
                ctx.textAlign = "center";
                ctx.textBaseline = "middle";
                const initial = "<?= htmlspecialchars($userInfo['HoTen'] ?? 'U') ?>".charAt(0).toUpperCase();
                ctx.fillText(initial, canvas.width / 2, canvas.height / 2 + 5);
                saveAvatarInstantly(canvas.toDataURL('image/png'));
            };
            
            const cleanUrl = imgUrl.replace(/^https?:\/\//, '');
            img.src = "https://wsrv.nl/?url=" + encodeURIComponent(cleanUrl);
        };

        fileInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) { saveAvatarInstantly(event.target.result); }
                reader.readAsDataURL(e.target.files[0]);
                bootstrap.Modal.getInstance(avatarModal).hide();
            }
        });

        const avatarOptions = document.getElementById('avatarOptions');
        const btnBackToOptions = document.getElementById('btnBackToOptions');

        function stopCamera() {
            if (stream) { stream.getTracks().forEach(track => track.stop()); stream = null; }
            video.style.display = 'none'; 
            btnCapture.style.display = 'none';
        }

        btnOpenCamera.addEventListener('click', async function() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ video: true });
                video.srcObject = stream; 
                video.style.display = 'block'; 
                btnCapture.style.display = 'block';
                
                avatarOptions.style.display = 'none';
                btnBackToOptions.classList.remove('d-none');
            } catch (err) { 
                alert("Không thể truy cập Camera. Vui lòng kiểm tra quyền trên trình duyệt của bạn!"); 
            }
        });

        btnBackToOptions.addEventListener('click', function() {
            stopCamera(); 
            avatarOptions.style.display = 'block'; 
            this.classList.add('d-none'); 
        });

        btnCapture.addEventListener('click', function() {
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth; canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            saveAvatarInstantly(canvas.toDataURL('image/jpeg')); 
            bootstrap.Modal.getInstance(avatarModal).hide();
        });

        avatarModal.addEventListener('hidden.bs.modal', function () {
            stopCamera();
            avatarOptions.style.display = 'block'; 
            btnBackToOptions.classList.add('d-none'); 
            fileInput.value = ''; 
        });

        const ngaySinhInput = document.getElementById('ngaySinhInput');
        if (ngaySinhInput) {
            ngaySinhInput.addEventListener('change', function() {
                if (this.value) {
                    const selectedDate = new Date(this.value);
                    const today = new Date();
                    const maxAllowedDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
                    
                    if (selectedDate > maxAllowedDate) {
                        this.setCustomValidity('Ngày sinh không hợp lệ. Bạn phải đủ 18 tuổi trở lên.');
                        this.reportValidity();
                        this.value = ''; 
                    } else {
                        this.setCustomValidity(''); 
                    }
                }
            });
        }

    });
</script>

<?php require_once 'app/views/layouts/footer.php'; ?>