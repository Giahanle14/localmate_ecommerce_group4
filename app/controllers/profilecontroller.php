<?php
require_once 'app/config/db_connect.php'; 
require_once 'app/models/profilemodel.php';

class ProfileController {
    
    public function index() {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=home");
            exit;
        }

        if (isset($_SESSION['MaDK'])) {
            $currentUser = $_SESSION['MaDK'];
        } elseif (isset($_SESSION['user']['MaDK'])) {
            $currentUser = $_SESSION['user']['MaDK'];
        } else {
            die("<h3 style='text-align:center; padding: 50px;'>Lỗi: Phiên đăng nhập hợp lệ nhưng không tìm thấy Mã Du Khách (MaDK). Vui lòng kiểm tra lại Controller Đăng Nhập!</h3>");
        }

        $model = new ProfileModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_avatar') {
            ob_clean();
            
            $avatarData = $_POST['avatar_data'];
            
            if (strpos($avatarData, 'data:image') === 0) {
                $image_parts = explode(";base64,", $avatarData);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);

                $fileName = $currentUser . '_' . time() . '.' . $image_type;
                $filePath = 'public/image/HinhDaiDien/' . $fileName;

                if (!is_dir('public/image/HinhDaiDien/')) {
                    mkdir('public/image/HinhDaiDien/', 0777, true);
                }

                file_put_contents($filePath, $image_base64);
                $avatarToSave = $filePath;
            } else {
                $avatarToSave = $avatarData;
            }

            $model->updateAvatar($currentUser, $avatarToSave);
            
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success', 'url' => $avatarToSave]);
            exit;
        }

        $message = '';
        $msg_type = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_profile') {
            $sdt = trim($_POST['sdt']);
            $ngaySinh = $_POST['ngaySinh'];
            $gioiTinh = !empty($_POST['gioiTinh']) ? $_POST['gioiTinh'] : null;
            $sdtKhanCap = trim($_POST['sdtKhanCap']);
            $diaChi = trim($_POST['diaChi']);
            
            $userInfo = $model->getUserInfo($currentUser);
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
                            $message = "Mật khẩu mới không đạt yêu cầu bảo mật!"; $msg_type = "danger"; $password_error = true;
                        }
                    } else {
                        $message = "Mật khẩu mới không khớp hoặc bị trống!"; $msg_type = "danger"; $password_error = true;
                    }
                } else {
                    $message = "Mật khẩu cũ không chính xác!"; $msg_type = "danger"; $password_error = true;
                }
            }

            if (!$password_error) {
                if(empty($sdt) || empty($ngaySinh) || empty($sdtKhanCap) || empty($diaChi)){
                    $message = "Vui lòng điền đầy đủ các thông tin bắt buộc!"; $msg_type = "danger";
                } else {
                    $maxDateAllowed = date('Y-m-d', strtotime('-18 years'));
                    
                    if ($ngaySinh > $maxDateAllowed) {
                        $message = "Bạn phải từ đủ 18 tuổi trở lên để cập nhật hồ sơ!"; 
                        $msg_type = "warning";
                    } else {
                        $update_success = $model->updateProfile($userInfo['MaTK'], $currentUser, $ngaySinh, $gioiTinh, $sdt, $diaChi, $sdtKhanCap);
                        
                        if ($update_success) {
                            $message = "Đã lưu thông tin thành công!" . ($password_updated ? " Kèm mật khẩu đã được cập nhật." : "");
                            $msg_type = "success";
                        } else {
                            $message = "Có lỗi xảy ra khi lưu thông tin."; $msg_type = "danger";
                        }
                    }
                }
            }
        }

        $userInfo = $model->getUserInfo($currentUser);

        if (!$userInfo) {
            die("<div style='text-align:center; padding: 50px; font-family: sans-serif;'><h2>LỖI KHÔNG TÌM THẤY DỮ LIỆU</h2><p>Không tìm thấy khách hàng có mã <b>{$currentUser}</b>.</p></div>");
        }

        $missingInfo = false;
        if (empty($userInfo['SDT']) || $userInfo['SDT'] === 'Chưa cập nhật' || empty($userInfo['NgaySinh']) || empty($userInfo['DiaChi'])) {
            $missingInfo = true;
        }

        $userStats = $model->getUserStats($userInfo['MaTK_DK']);
        $soChuyen = (int)$userStats['chuyen'];

        $calculatedTier = 'Đồng';
        if ($soChuyen >= 20) $calculatedTier = 'Kim cương';
        elseif ($soChuyen >= 10) $calculatedTier = 'Vàng';
        elseif ($soChuyen >= 5) $calculatedTier = 'Bạc';

        $userInfo['HangThanhVien'] = $calculatedTier;
        $currentTier = $calculatedTier;
        
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
            $phanTramHang = ($soChuyen / $tierInfo['target']) * 100;
            if ($phanTramHang > 100) $phanTramHang = 100;
        }

        $hoTen = urlencode($userInfo['HoTen']);
        $defaultAvatar = "https://ui-avatars.com/api/?name=" . $hoTen . "&background=546E7A&color=fff&size=150&font-size=0.4&bold=true";
        $avatarUrl = $defaultAvatar;

        if (!empty($userInfo['AnhDaiDien'])) {
            $dbAvatar = $userInfo['AnhDaiDien'];
            if (strpos($dbAvatar, 'http') === 0) {
                $avatarUrl = $dbAvatar;
            } else {
                if (strpos($dbAvatar, 'public/') !== 0) {
                    $dbAvatar = 'public/' . $dbAvatar;
                }
                if (file_exists($dbAvatar)) {
                    $avatarUrl = $dbAvatar;
                } 
            }
        }

        require_once 'app/views/profileview.php';
    }
}
?>