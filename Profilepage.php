<?php
// Profilepage.php
session_start();
require_once 'db_connect.php'; 
require_once 'ProfileModel.php';

// ÉP GÁN TRỰC TIẾP ĐỂ DỄ DÀNG TEST (BỎ QUA ISSET)
// Lưu ý: Khi nào làm chức năng Đăng Nhập thật thì bạn xóa dòng này đi nhé!
$_SESSION['MaDK'] = 'KH00000046'; // Bạn có thể đổi thành KH00000001, KH00000002... ở đây

$currentUser = $_SESSION['MaDK'];
$model = new ProfileModel();

// --- XỬ LÝ LƯU ẢNH ĐẠI DIỆN QUA AJAX ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_avatar') {
    $avatarData = $_POST['avatar_data'];
    $_SESSION['avatar_' . $currentUser] = $avatarData; // Lưu ảnh đại diện mới vào Session để không bị mất khi reload
    
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success']);
    exit;
}

$message = '';
$msg_type = '';

// Xử lý khi Form được Submit lưu thông tin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_profile') {
    $hoTen = trim($_POST['hoTen']);
    $sdt = trim($_POST['sdt']);
    $ngaySinh = $_POST['ngaySinh'];
    $gioiTinh = $_POST['gioiTinh'];
    $sdtKhanCap = trim($_POST['sdtKhanCap']);
    $diaChi = trim($_POST['diaChi']);
    
    $userInfo = $model->getUserInfo($currentUser);

    // Xử lý đổi mật khẩu
    $doiMatKhau = isset($_POST['doiMatKhau']) ? true : false;
    $password_updated = false;
    $password_error = false;

    if ($doiMatKhau) {
        $matKhauCu = $_POST['matKhauCu'];
        $matKhauMoi = $_POST['matKhauMoi'];
        $xacNhanMK = $_POST['xacNhanMK'];

        if ($matKhauCu === $userInfo['MatKhau']) {
            if ($matKhauMoi === $xacNhanMK && !empty($matKhauMoi)) {
                $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
                
                if (preg_match($passwordRegex, $matKhauMoi)) {
                    $model->updatePassword($userInfo['MaTK'], $matKhauMoi);
                    $password_updated = true;
                } else {
                    $message = "Mật khẩu mới không đạt yêu cầu bảo mật!";
                    $msg_type = "danger";
                    $password_error = true;
                }
            } else {
                $message = "Mật khẩu mới không khớp hoặc bị trống!";
                $msg_type = "danger";
                $password_error = true;
            }
        } else {
            $message = "Mật khẩu cũ không chính xác!";
            $msg_type = "danger";
            $password_error = true;
        }
    }

    if (!$password_error) {
        if(empty($hoTen) || empty($sdt) || empty($ngaySinh) || empty($sdtKhanCap) || empty($diaChi)){
             $message = "Vui lòng điền đầy đủ các thông tin bắt buộc!";
             $msg_type = "danger";
        } else {
            $update_success = $model->updateProfile($currentUser, $hoTen, $ngaySinh, $gioiTinh, $sdt, $diaChi, $sdtKhanCap);
            if ($update_success) {
                $message = "Đã lưu thông tin cá nhân thành công!" . ($password_updated ? " Kèm mật khẩu đã được cập nhật." : "");
                $msg_type = "success";
            } else {
                $message = "Có lỗi xảy ra khi lưu thông tin.";
                $msg_type = "danger";
            }
        }
    }
}

// Lấy lại dữ liệu mới nhất để hiển thị ra View
$userInfo = $model->getUserInfo($currentUser);

// THÊM LỚP BẢO VỆ 1: Xử lý khi gõ sai mã khách hàng
if (!$userInfo) {
    die("<div style='text-align:center; padding: 50px; font-family: sans-serif;'><h2>LỖI KHÔNG TÌM THẤY DỮ LIỆU</h2><p>Không tìm thấy khách hàng có mã <b>{$currentUser}</b>. Bạn hãy kiểm tra lại xem gõ đúng mã chưa nhé (VD: KH00000003).</p></div>");
}

$userStats = $model->getUserStats($currentUser);

// ==========================================
// THIẾT LẬP LUẬT VÀ TỰ ĐỘNG ĐỒNG BỘ HẠNG
// ==========================================
$soChuyen = (int)$userStats['chuyen'];

// Tự động tính hạng chuẩn dựa trên số chuyến đi
$calculatedTier = 'Đồng';
if ($soChuyen >= 20) {
    $calculatedTier = 'Kim cương';
} elseif ($soChuyen >= 10) {
    $calculatedTier = 'Vàng';
} elseif ($soChuyen >= 5) {
    $calculatedTier = 'Bạc';
}

// Nếu CSDL bị sai lệch, tự động UPDATE lại CSDL
if ($userInfo['HangThanhVien'] !== $calculatedTier) {
    // THÊM LỚP BẢO VỆ 2: Tránh sập web nếu quên thêm hàm updateTier vào ProfileModel.php
    if (method_exists($model, 'updateTier')) {
        $model->updateTier($currentUser, $calculatedTier);
    }
    $userInfo['HangThanhVien'] = $calculatedTier;
}

$currentTier = $calculatedTier;

// Định nghĩa dữ liệu hiển thị cho từng hạng
$tierData = [
    'Đồng' => ['color' => '#E8B923', 'next' => 'Bạc', 'target' => 5, 'discount' => '10%'],
    'Bạc' => ['color' => '#A6A9B6', 'next' => 'Vàng', 'target' => 10, 'discount' => '15%'],
    'Vàng' => ['color' => '#F2A900', 'next' => 'Kim cương', 'target' => 20, 'discount' => '20%'],
    'Kim cương' => ['color' => '#51C4D3', 'next' => '', 'target' => 0, 'discount' => '']
];

$tierInfo = isset($tierData[$currentTier]) ? $tierData[$currentTier] : $tierData['Đồng'];
$tierColor = $tierInfo['color'];
$isMaxTier = ($currentTier == 'Kim cương');

$phanTramHang = 100;
$chuyenConLai = 0;

if (!$isMaxTier) {
    $chuyenConLai = $tierInfo['target'] - $soChuyen;
    if ($chuyenConLai < 0) $chuyenConLai = 0;
    
    // Tính phần tăng trưởng của chặng hiện tại
    $phanTramHang = ($soChuyen / $tierInfo['target']) * 100;
    if ($phanTramHang > 100) $phanTramHang = 100;
}

// Xác định nguồn ảnh đại diện hiện tại (Lấy từ Session lưu tạm nếu có, nếu không lấy theo MaDK mặc định)
$avatarUrl = isset($_SESSION['avatar_' . $currentUser]) ? $_SESSION['avatar_' . $currentUser] : "https://i.pravatar.cc/150?u=" . $userInfo['MaDK'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ sơ cá nhân - LocalMate</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Quicksand', sans-serif; background-color: #F8FAF5; }
        
        .breadcrumb-custom {
            padding: 15px 40px; font-weight: 500; color: #0d5c2c;
            background: white; border-bottom: 1px solid #eee;
        }

        .profile-container { padding: 40px; max-width: 1200px; margin: auto; }

        .sidebar-card {
            background: white; border-radius: 20px; padding: 30px 20px;
            text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #f0f0f0;
        }

        /* --- CSS HOVER ẢNH ĐẠI DIỆN VÀ NÚT CAMERA --- */
        .avatar-wrapper { 
            position: relative; width: 120px; height: 120px; margin: 0 auto 15px; 
            cursor: pointer; 
            transition: transform 0.3s ease; 
        }
        
        .avatar-wrapper:hover {
            transform: scale(1.05); 
        }

        .avatar-wrapper img {
            width: 100%; height: 100%; object-fit: cover; border-radius: 50%;
            border: 4px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .camera-btn {
            position: absolute; bottom: 5px; right: 5px; background: #0d5c2c; color: white;
            border-radius: 50%; width: 34px; height: 34px; display: flex;
            align-items: center; justify-content: center; border: 2px solid white;
            font-size: 15px; transition: background-color 0.2s;
        }

        .avatar-wrapper:hover .camera-btn {
            background-color: #E88D39; 
        }

        .user-name { color: #0d5c2c; font-weight: 700; font-size: 22px; margin-bottom: 5px; }
        .member-since { color: #666; font-size: 14px; margin-bottom: 20px; }

        .stats-row { display: flex; justify-content: center; gap: 10px; font-size: 14px; font-weight: 600; color: #555; margin-bottom: 25px; }
        .stats-row div { white-space: nowrap; }
        .stats-row span { color: #E88D39; }

        .tier-section { border-top: 1px solid #eee; padding-top: 25px; }
        .tier-icon { font-size: 55px; margin-bottom: 15px; } 
        .tier-name { font-weight: 800; font-size: 20px; text-transform: uppercase;}
        
        .tier-desc { 
            font-size: 13px; 
            color: #0d5c2c; 
            font-weight: 500; 
            margin-top: 12px; 
            line-height: 1.6; 
            padding: 0;
        }
        
        .progress-custom { height: 6px; border-radius: 10px; background: #e0e0e0; margin: 15px auto; width: 85%; }
        .progress-custom .progress-bar { border-radius: 10px; }

        .btn-logout {
            background-color: #D6E8D8; color: #0d5c2c; font-weight: 700;
            border-radius: 30px; padding: 10px 0; margin-top: 20px; width: 70%;
            border: none; transition: 0.3s;
        }
        .btn-logout:hover { background-color: #b5d5b9; }

        .main-card {
            background: white; border-radius: 20px; padding: 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #f0f0f0;
        }

        .section-title { color: #0d5c2c; font-weight: 700; font-size: 24px; margin-bottom: 30px; }

        .form-label { font-weight: 700; color: #0d5c2c; margin-bottom: 8px; font-size: 15px; }

        .form-control, .form-select {
            border-radius: 8px; padding: 12px 15px; border: 1px solid #7DA27E; 
            color: #4A7C59; font-weight: 600; background-color: #FDFBF4; 
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #0d5c2c; box-shadow: 0 0 0 0.2rem rgba(13, 92, 44, 0.1); background-color: #FDFBF4;
        }
        
        .form-control[readonly], .form-control:disabled { 
            background-color: #E9ECEF; color: #6C757D; border-color: #CED4DA; cursor: not-allowed; opacity: 1; 
        }

        input[type="password"]::-ms-reveal, input[type="password"]::-ms-clear { display: none; }
        .password-wrapper { position: relative; }
        .password-wrapper input { padding-right: 40px; }
        .toggle-eye {
            position: absolute; right: 15px; top: 50%; transform: translateY(-50%);
            cursor: pointer; color: #7DA27E; opacity: 0; transition: opacity 0.2s, color 0.2s; font-size: 16px;
        }
        .password-wrapper input:focus + .toggle-eye, .password-wrapper.has-text .toggle-eye { opacity: 1; }
        .toggle-eye:hover { color: #0d5c2c; }

        .password-toggle-box {
            border: 1px solid #7DA27E; border-radius: 8px; padding: 12px 15px; display: flex;
            align-items: center; cursor: pointer; user-select: none; background: #FDFBF4;
        }
        .custom-checkbox {
            width: 22px; height: 22px; border: 2px solid #7DA27E; border-radius: 4px;
            margin-right: 12px; display: flex; align-items: center; justify-content: center;
            color: white; transition: 0.2s;
        }
        .password-toggle-box.active .custom-checkbox { background-color: #0d5c2c; border-color: #0d5c2c; }
        .password-toggle-box span { font-weight: 600; color: #0d5c2c; font-size: 15px; }

        .btn-save {
            background-color: #0d5c2c; color: white; font-weight: 700; border-radius: 30px;
            padding: 12px 40px; border: none; letter-spacing: 1px; transition: 0.3s;
        }
        .btn-save:hover { background-color: #09401f; color: white;}
        .form-control:invalid { box-shadow: none; }

        /* --- CSS CHO MODAL THAY ĐỔI ẢNH ĐẠI DIỆN --- */
        .modal-avatar-btn {
            display: flex; align-items: center; gap: 15px; width: 100%;
            padding: 16px; border: 1px solid #d1d5db; border-radius: 12px;
            background-color: white; color: #333; font-weight: 500; font-size: 16px; text-align: left;
            transition: all 0.2s; margin-bottom: 12px;
            white-space: nowrap; /* Giữ chữ thẳng hàng, không bị rớt xuống */
        }
        .modal-avatar-btn:hover {
            border-color: #0d5c2c; background-color: #f8faf5; color: #0d5c2c;
        }
        .modal-avatar-btn i.icon-left { 
            font-size: 24px; color: #0d5c2c; width: 30px; text-align: center;
        }
        
        #cameraStream { width: 100%; border-radius: 12px; display: none; margin-bottom: 15px; background: #000;}
        #btnCapture { display: none; }

        /* --- CSS CHO DANH SÁCH ẢNH MINH HỌA --- */
        .illustration-item {
            width: 100%; aspect-ratio: 1/1; object-fit: cover;
            border-radius: 50%; cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            border: 3px solid transparent;
        }
        .illustration-item:hover {
            transform: scale(1.1);
            border-color: #0d5c2c;
        }
    </style>
</head>
<body>

    <?php include 'partial/header.php'; ?>

    <div class="breadcrumb-custom">
        Trang chủ > Hồ sơ cá nhân
    </div>

    <main class="profile-container">
        
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?= $msg_type ?> alert-dismissible fade show mb-4" role="alert">
                <?= $message ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Cột trái: Sidebar -->
            <div class="col-lg-4 col-xl-3">
                <div class="sidebar-card">
                    <!-- GẮN SỰ KIỆN CLICK ĐỂ MỞ MODAL THAY ĐỔI ẢNH -->
                    <div class="avatar-wrapper" data-bs-toggle="modal" data-bs-target="#avatarModal" title="Đổi ảnh đại diện">
                        <img src="<?= htmlspecialchars($avatarUrl) ?>" alt="Avatar" id="mainAvatarImg">
                        <div class="camera-btn"><i class="fa-solid fa-camera"></i></div>
                    </div>
                    
                    <h4 class="user-name"><?= htmlspecialchars($userInfo['HoTen']) ?></h4>
                    <div class="member-since">Thành viên từ 2024</div>
                    
                    <div class="stats-row">
                        <div><span><?= $userStats['chuyen'] ?></span> Chuyến</div>
                        <div><span><?= $userStats['danh_gia'] ?></span> Đánh giá</div>
                        <div><span><?= $userStats['yeu_thich'] ?></span> Yêu thích</div>
                    </div>

                    <div class="tier-section">
                        <i class="fa-solid fa-medal tier-icon" style="color: <?= $tierColor ?>;"></i>
                        <div class="tier-name" style="color: <?= $tierColor ?>;">Thành viên <?= mb_strtolower($userInfo['HangThanhVien'], 'UTF-8') ?></div>
                        
                        <?php if(!$isMaxTier): ?>
                            <div class="tier-desc" title="Bạn còn <?= $chuyenConLai ?> chuyến đi nữa để thăng hạng <?= $tierInfo['next'] ?> và nhận voucher giảm giá <?= $tierInfo['discount'] ?>!">
                                Bạn còn <b style="font-size: 14px; font-weight: 600; color: #E88D39;"><?= $chuyenConLai ?> chuyến đi</b> nữa để thăng hạng <?= $tierInfo['next'] ?> và nhận voucher giảm giá <?= $tierInfo['discount'] ?>!
                            </div>
                        <?php else: ?>
                            <div class="tier-desc">Bạn đã đạt hạng cao nhất! Tận hưởng đặc quyền giảm giá 20% cho mọi chuyến đi.</div>
                        <?php endif; ?>

                        <div class="progress progress-custom">
                            <div class="progress-bar" role="progressbar" style="width: <?= $phanTramHang ?>%; background-color: #0d5c2c;"></div>
                        </div>
                    </div>

                    <button class="btn btn-logout">
                        <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Đăng xuất
                    </button>
                </div>
            </div>

            <!-- Cột phải: Form Tài Khoản -->
            <div class="col-lg-8 col-xl-9">
                <div class="main-card">
                    <h3 class="section-title">Tài khoản</h3>
                    
                    <form action="Profilepage.php" method="POST" id="profileForm">
                        <input type="hidden" name="action" value="update_profile">
                        
                        <div class="row g-4 mb-4">
                            <!-- Hàng 1 -->
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="<?= htmlspecialchars($userInfo['Gmail']) ?>" readonly disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label d-none d-md-block">&nbsp;</label>
                                <!-- Toggle mật khẩu chỉ tương tác khi ở chế độ edit -->
                                <div class="password-toggle-box w-100" id="togglePasswordBtn">
                                    <input type="checkbox" name="doiMatKhau" id="chkDoiMatKhau" class="d-none">
                                    <div class="custom-checkbox"><i class="fa-solid fa-check d-none" id="checkIcon"></i></div>
                                    <span>Đổi mật khẩu</span>
                                </div>
                            </div>

                            <!-- Hàng Mật khẩu -->
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

                            <!-- Hàng 2 -->
                            <div class="col-md-6">
                                <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="hoTen" value="<?= htmlspecialchars($userInfo['HoTen']) ?>" required title="Vui lòng điền họ và tên.">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" name="sdt" value="<?= htmlspecialchars($userInfo['SDT']) ?>" required title="Vui lòng điền số điện thoại.">
                            </div>

                            <!-- Hàng 3 -->
                            <div class="col-md-4">
                                <label class="form-label">Ngày sinh <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="ngaySinh" value="<?= htmlspecialchars($userInfo['NgaySinh']) ?>" required title="Vui lòng chọn ngày sinh.">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Giới tính</label>
                                <select class="form-select" name="gioiTinh">
                                    <option value="Nữ" <?= ($userInfo['GioiTinh'] == 'Nữ') ? 'selected' : '' ?>>Nữ</option>
                                    <option value="Nam" <?= ($userInfo['GioiTinh'] == 'Nam') ? 'selected' : '' ?>>Nam</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Số điện thoại khẩn cấp <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" name="sdtKhanCap" value="<?= htmlspecialchars($userInfo['SDTKhanCap']) ?>" required title="Vui lòng điền số điện thoại khẩn cấp.">
                            </div>

                            <!-- Hàng 4 -->
                            <div class="col-12">
                                <label class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="diaChi" value="<?= htmlspecialchars($userInfo['DiaChi']) ?>" required title="Vui lòng điền địa chỉ hiện tại.">
                            </div>
                        </div>

                        <!-- CẬP NHẬT: Nút chỉnh sửa / lưu thông minh -->
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

    <!-- MODAL 1: ĐỔI ẢNH ĐẠI DIỆN -->
    <div class="modal fade" id="avatarModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 385px;">
            <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
                <div class="modal-header border-0 pb-0 pt-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="modal-title fw-bold" style="color: #0d5c2c; font-size: 18px; margin: 0;">Thay đổi ảnh đại diện</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="margin: 0;"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    
                    <!-- Vùng hiển thị camera -->
                    <video id="cameraStream" autoplay playsinline></video>
                    <button id="btnCapture" class="btn btn-save w-100 mb-3"><i class="fa-solid fa-camera"></i> Chụp ảnh ngay</button>

                    <!-- Lựa chọn hình ảnh có sẵn (Chuyển sang Modal 2) -->
                    <button class="modal-avatar-btn" data-bs-target="#illustrationsModal" data-bs-toggle="modal" data-bs-dismiss="modal">
                        <i class="fa-solid fa-face-smile-wink icon-left"></i> 
                        <span>Chọn hình ảnh mặc định</span>
                    </button>
                    
                    <!-- Lựa chọn tải ảnh từ máy tính (ẩn thẻ input) -->
                    <input type="file" id="fileUploadInput" accept="image/*" class="d-none">
                    <button class="modal-avatar-btn" onclick="document.getElementById('fileUploadInput').click();">
                        <i class="fa-solid fa-image icon-left"></i> 
                        <span>Tải ảnh từ thiết bị</span>
                    </button>

                    <!-- Lựa chọn mở camera chụp -->
                    <button class="modal-avatar-btn mb-0" id="btnOpenCamera">
                        <i class="fa-solid fa-camera-retro icon-left"></i> 
                        <span>Chụp ảnh trực tiếp</span>
                    </button>

                </div>
            </div>
        </div>
    </div>

    <!-- MODAL 2: CHỌN HÌNH ẢNH MẶC ĐỊNH (ILLUSTRATIONS) -->
    <div class="modal fade" id="illustrationsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="border-radius: 16px; border: none; height: 75vh;">
                <div class="modal-header border-0 align-items-center pb-2 pt-3 px-4 d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <button type="button" class="btn border-0 p-0 me-3" data-bs-target="#avatarModal" data-bs-toggle="modal" data-bs-dismiss="modal" title="Quay lại">
                            <i class="fa-solid fa-arrow-left fs-5 text-muted"></i>
                        </button>
                        <h5 class="modal-title fw-bold" style="color: #0d5c2c; font-size: 18px; margin: 0;">Chọn hình ảnh mặc định</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="margin: 0;"></button>
                </div>
                
                <div class="modal-body p-4 pt-2">
                    <div class="row g-3" id="illustrationsGrid">
                        <!-- Danh sách ảnh được render bằng JavaScript bên dưới -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'partial/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ==========================================
            // TỰ ĐỘNG TẮT THÔNG BÁO SAU 5 GIÂY (5000ms)
            // ==========================================
            const alertElement = document.querySelector('.alert');
            if (alertElement) {
                setTimeout(() => {
                    // Sử dụng lớp Alert của Bootstrap 5 để đóng thông báo có kèm hiệu ứng tắt mượt mà
                    const bsAlert = bootstrap.Alert.getOrCreateInstance(alertElement);
                    if (bsAlert) {
                        bsAlert.close();
                    }
                }, 3000);
            }

            // Xử lý bật tắt form Đổi Mật Khẩu
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
                    toggleBox.classList.add('active');
                    checkIcon.classList.remove('d-none');
                    passwordRow.classList.remove('d-none');
                    mkCu.setAttribute('required', 'true');
                    mkMoi.setAttribute('required', 'true');
                    xacNhan.setAttribute('required', 'true');
                    setTimeout(() => mkCu.focus(), 100);
                } else {
                    toggleBox.classList.remove('active');
                    checkIcon.classList.add('d-none');
                    passwordRow.classList.add('d-none');
                    mkCu.removeAttribute('required');
                    mkMoi.removeAttribute('required');
                    xacNhan.removeAttribute('required');
                    mkCu.value = '';
                    mkMoi.value = '';
                    xacNhan.value = '';
                    document.querySelectorAll('.password-wrapper').forEach(w => w.classList.remove('has-text'));
                }
            });
            
            // Logic Con Mắt hiển thị mật khẩu
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
                        input.type = 'text';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                        icon.style.color = '#0d5c2c'; 
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                        icon.style.color = '#7DA27E'; 
                    }
                });
            });

            xacNhan.addEventListener('input', function() {
                if (mkMoi.value !== xacNhan.value) xacNhan.setCustomValidity('Mật khẩu xác nhận không khớp.');
                else xacNhan.setCustomValidity('');
            });

            // ==========================================
            // LOGIC BẬT TẮT TRẠNG THÁI EDIT/READ-ONLY CHO FORM
            // ==========================================
            const btnEditSave = document.getElementById('btnEditSave');
            const profileForm = document.getElementById('profileForm');
            
            // Lấy tất cả các ô nhập liệu được phép chỉnh sửa
            const editableInputs = profileForm.querySelectorAll('input[name="hoTen"], input[name="sdt"], input[name="ngaySinh"], select[name="gioiTinh"], input[name="sdtKhanCap"], input[name="diaChi"]');
            
            let isEditing = false;

            function setEditMode(active) {
                isEditing = active;
                if (active) {
                    // Chuyển sang chế độ chỉnh sửa: Mở khóa các input
                    editableInputs.forEach(input => {
                        input.removeAttribute('readonly');
                        input.removeAttribute('disabled');
                    });
                    // Đổi nút thành nút "Lưu"
                    btnEditSave.innerHTML = '<i class="fa-solid fa-floppy-disk me-2"></i>LƯU';
                    btnEditSave.type = 'submit'; 
                    btnEditSave.classList.remove('btn-secondary');
                    
                    // Cho phép click hộp đổi mật khẩu
                    toggleBox.style.pointerEvents = 'auto';
                    toggleBox.style.opacity = '1';
                } else {
                    // Chuyển về chế độ chỉ đọc: Khóa các input
                    editableInputs.forEach(input => {
                        if (input.tagName === 'SELECT') {
                            input.setAttribute('disabled', 'true');
                        } else {
                            input.setAttribute('readonly', 'true');
                        }
                    });
                    // Đổi nút thành nút "Chỉnh sửa"
                    btnEditSave.innerHTML = '<i class="fa-regular fa-pen-to-square me-2"></i>CHỈNH SỬA';
                    btnEditSave.type = 'button'; 
                    
                    // Khóa đổi mật khẩu khi đang không ở chế độ chỉnh sửa
                    toggleBox.style.pointerEvents = 'none';
                    toggleBox.style.opacity = '0.6';
                    
                    // Nếu đang mở form đổi mật khẩu mà thoát edit thì ẩn đi
                    if (checkbox.checked) {
                        toggleBox.click(); 
                    }
                }
            }

            // Thiết lập chế độ Ban đầu là Read-Only khi tải trang
            setEditMode(false);

            btnEditSave.addEventListener('click', function(e) {
                if (!isEditing) {
                    // Nếu đang ở Read-only, nhấn vào sẽ chuyển sang Edit mode
                    e.preventDefault();
                    setEditMode(true);
                }
                // Nếu đang ở Edit mode, nút có type="submit" sẽ tự gửi form đi
            });

            // ==========================================
            // LOGIC XỬ LÝ ẢNH ĐẠI DIỆN VÀ MODAL 1 & 2 (LƯU TỨC THÌ QUA AJAX)
            // ==========================================
            const mainImg = document.getElementById('mainAvatarImg');
            const fileInput = document.getElementById('fileUploadInput');
            const btnOpenCamera = document.getElementById('btnOpenCamera');
            const btnCapture = document.getElementById('btnCapture');
            const video = document.getElementById('cameraStream');
            const avatarModal = document.getElementById('avatarModal');
            const illustrationsModal = document.getElementById('illustrationsModal');
            let stream = null;

            // Hàm gửi AJAX lưu dữ liệu ảnh lên Session/Database tức thì
            function saveAvatarInstantly(base64OrUrl) {
                const formData = new FormData();
                formData.append('action', 'update_avatar');
                formData.append('avatar_data', base64OrUrl);

                fetch('Profilepage.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Cập nhật thành công ảnh hiển thị trên trang hiện tại
                        mainImg.src = base64OrUrl;
                    } else {
                        console.error('Không thể lưu ảnh đại diện mới.');
                    }
                })
                .catch(error => console.error('Lỗi khi gửi yêu cầu lưu ảnh:', error));
            }

            // Render danh sách ảnh mặc định (Modal 2)
            const illustrationsGrid = document.getElementById('illustrationsGrid');
            const seedNames = ['Mimi', 'Lola', 'Leo', 'Kitty', 'Jack', 'Max', 'Sam', 'Milo', 'Luna', 'Bella', 'Simba', 'Chloe', 'Oliver', 'Lucy', 'Charlie', 'Daisy', 'Toby', 'Lily'];
            
            seedNames.forEach(seed => {
                const col = document.createElement('div');
                col.className = 'col-4 col-sm-3 col-md-4 col-lg-3';
                const imgUrl = `https://api.dicebear.com/7.x/fun-emoji/svg?seed=${seed}&backgroundColor=e2e8f0,b6e3f4,c0aede,d1d4f9,ffdfbf`;
                
                col.innerHTML = `<img src="${imgUrl}" alt="${seed}" class="illustration-item bg-white" onclick="selectIllustration('${imgUrl}')">`;
                illustrationsGrid.appendChild(col);
            });

            // Hàm chọn ảnh minh họa mặc định
            window.selectIllustration = function(url) {
                saveAvatarInstantly(url); // Gửi lưu ảnh ngay lập tức
                bootstrap.Modal.getInstance(illustrationsModal).hide();
            };

            // Tải ảnh từ thiết bị
            fileInput.addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(event) { 
                        saveAvatarInstantly(event.target.result); // Gửi lưu ảnh ngay lập tức
                    }
                    reader.readAsDataURL(e.target.files[0]);
                    bootstrap.Modal.getInstance(avatarModal).hide();
                }
            });

            // Mở camera chụp ảnh trực tiếp
            btnOpenCamera.addEventListener('click', async function() {
                try {
                    stream = await navigator.mediaDevices.getUserMedia({ video: true });
                    video.srcObject = stream;
                    video.style.display = 'block';
                    btnCapture.style.display = 'block';
                    
                    // Tạm ẩn các nút tùy chọn khác
                    this.style.display = 'none';
                    this.previousElementSibling.style.display = 'none'; 
                    this.previousElementSibling.previousElementSibling.style.display = 'none'; 
                } catch (err) {
                    alert("Không thể truy cập Camera. Vui lòng kiểm tra quyền trên trình duyệt của bạn!");
                }
            });

            // Nút Chụp ảnh
            btnCapture.addEventListener('click', function() {
                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                const capturedBase64 = canvas.toDataURL('image/jpeg');
                
                saveAvatarInstantly(capturedBase64); // Gửi lưu ảnh chụp ngay lập tức
                bootstrap.Modal.getInstance(avatarModal).hide();
            });

            // Reset camera khi đóng Modal 1
            avatarModal.addEventListener('hidden.bs.modal', function () {
                if (stream) { stream.getTracks().forEach(track => track.stop()); stream = null; }
                video.style.display = 'none';
                btnCapture.style.display = 'none';
                
                // Trả lại các nút nguyên trạng ban đầu
                const buttons = this.querySelectorAll('.modal-avatar-btn');
                buttons.forEach(b => b.style.display = 'flex');
                fileInput.value = ''; 
            });
        });
    </script>
</body>
</html>