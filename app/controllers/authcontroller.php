<?php
use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/authmodel.php';

class AuthController {

    public function login() {
        require_once __DIR__ . '/../config/db_connect.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password']; 

            try {
                $stmt = $conn->prepare("SELECT * FROM TaiKhoan WHERE Gmail = ?");
                $stmt->execute([$email]);
                $taiKhoan = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($taiKhoan && password_verify($password, $taiKhoan['MatKhau'])) {
                    
                    $stmtDK = $conn->prepare("SELECT * FROM DuKhach WHERE MaTK_DK = ?");
                    $stmtDK->execute([$taiKhoan['MaTK']]);
                    $duKhach = $stmtDK->fetch(PDO::FETCH_ASSOC);

                    $_SESSION['user'] = [
                        'MaTK' => $taiKhoan['MaTK'],
                        'Gmail' => $taiKhoan['Gmail'],
                        'LoaiTK' => $taiKhoan['LoaiTK'], 
                        'HoTen' => $taiKhoan['HoTen'], 
                        'MaDK' => $duKhach ? $duKhach['MaDK'] : null
                    ];

                    if ($taiKhoan['LoaiTK'] === 'Quản trị viên') {
                        header("Location: index.php?controller=adminhome");
                    } else {
                        header("Location: index.php?controller=home");
                    }
                    exit();
                } else {
                    echo "<script>alert('Sai Email hoặc Mật khẩu!'); window.location.href='index.php';</script>";
                }
            } catch (PDOException $e) {
                echo "Lỗi truy vấn: " . $e->getMessage();
                
            }
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php?controller=home");
        exit();
    }

    public function send_otp() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $model = new AuthModel();
            
            if ($model->checkEmailExist($email)) {
                echo json_encode(['status' => 'error', 'message' => 'Email này đã được sử dụng!']);
                return;
            }
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['otp_time'] = time();
            require_once 'app/libs/PHPMailer/Exception.php';
            require_once 'app/libs/PHPMailer/PHPMailer.php';
            require_once 'app/libs/PHPMailer/SMTP.php';

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'localmate.cskh@gmail.com'; 
                $mail->Password   = 'bswkrflnrkeygpzv'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
                $mail->Port       = 465;                       
                $mail->CharSet    = 'UTF-8';

                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                $mail->setFrom('localmate.cskh@gmail.com', 'LocalMate - OTP Verification');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Mã xác thực OTP từ LocalMate';
                
                $mail->Body = "
                    <div style='font-family: Arial, sans-serif; max-width: 500px; margin: 0 auto; padding: 25px; border: 1px solid #e0e0e0; border-radius: 12px; background-color: #FAFAFA;'>
                        <div style='text-align: center; margin-bottom: 20px;'>
                            <h2 style='color: #005A24; margin: 0;'>Xác Thực Tài Khoản</h2>
                        </div>
                        <div style='background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);'>
                            <p style='color: #333; font-size: 15px;'>Chào bạn,</p>
                            <p style='color: #333; font-size: 15px; line-height: 1.6;'>Cảm ơn bạn đã lựa chọn <b>LocalMate</b>. Để hoàn tất quá trình đăng ký, vui lòng sử dụng mã OTP gồm 6 chữ số dưới đây:</p>
                            
                            <div style='text-align: center; margin: 25px 0;'>
                                <span style='font-size: 28px; font-weight: 800; background-color: #EAF9DE; color: #00712D; padding: 12px 25px; border-radius: 8px; letter-spacing: 6px; display: inline-block; border: 1px dashed #00712D;'>
                                    {$otp}
                                </span>
                            </div>
                            
                            <p style='color: #666; font-size: 13px; text-align: center; margin-bottom: 0;'>
                                <i>Mã này có hiệu lực trong vòng 5 phút.<br>Vui lòng không chia sẻ mã này cho bất kỳ ai để bảo mật tài khoản.</i>
                            </p>
                        </div>
                        <p style='color: #999; font-size: 12px; text-align: center; margin-top: 20px;'>
                            © 2026 LocalMate. Nền tảng du lịch bản địa hàng đầu.
                        </p>
                    </div>
                ";

                $mail->send();
                
                echo json_encode(['status' => 'success']);
                
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => "Hệ thống gửi mail đang gián đoạn. Vui lòng thử lại sau! Lỗi chi tiết: {$mail->ErrorInfo}"]);
            }
            exit;
        }
    }

    public function verify_otp() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_otp = trim($_POST['otp']);
            
            if (isset($_SESSION['otp']) && $user_otp == $_SESSION['otp']) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Mã OTP không chính xác!']);
            }
            exit;
        }
    }
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $hoTen = trim($_POST['hoten']);
            $email = trim($_POST['email_sdt']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if ($password !== $confirm_password) {
                echo "<script>alert('Mật khẩu không khớp!'); history.back();</script>";
                exit();
            }

            $model = new AuthModel();
            $userData = $model->registerUser($hoTen, $email, $password);

            if ($userData) {
                unset($_SESSION['otp']);
                unset($_SESSION['otp_time']);
                
                $_SESSION['user'] = $userData;
                
                echo "<script>alert('Đăng ký tài khoản thành công!'); window.location.href = 'index.php?controller=home';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra trong quá trình tạo tài khoản. Vui lòng thử lại!'); history.back();</script>";
            }
            exit();
        }
    }

    public function send_forgot_otp() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $model = new AuthModel();
            
            if (!$model->checkEmailExist($email)) {
                echo json_encode(['status' => 'error', 'message' => 'Email này chưa được đăng ký trong hệ thống!']);
                return;
            }
            
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;

            require_once 'app/libs/PHPMailer/Exception.php';
            require_once 'app/libs/PHPMailer/PHPMailer.php';
            require_once 'app/libs/PHPMailer/SMTP.php';

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'localmate.cskh@gmail.com'; 
                $mail->Password   = 'bswkrflnrkeygpzv'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;
                $mail->CharSet    = 'UTF-8';

                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                $mail->setFrom('localmate.cskh@gmail.com', 'LocalMate Support');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Yêu cầu Đặt lại Mật khẩu - LocalMate';
                
                $mail->Body = "
                    <div style='font-family: Arial, sans-serif; max-width: 500px; margin: 0 auto; padding: 25px; border: 1px solid #e0e0e0; border-radius: 12px; background-color: #FAFAFA;'>
                        <div style='text-align: center; margin-bottom: 20px;'>
                            <h2 style='color: #005A24; margin: 0;'>ĐẶT LẠI MẬT KHẨU</h2>
                        </div>
                        <div style='background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);'>
                            <p style='color: #333; font-size: 15px;'>Chào bạn,</p>
                            <p style='color: #333; font-size: 15px; line-height: 1.6;'>Chúng tôi nhận được yêu cầu khôi phục mật khẩu cho tài khoản LocalMate liên kết với email này. Vui lòng nhập mã OTP dưới đây để tạo mật khẩu mới:</p>
                            
                            <div style='text-align: center; margin: 25px 0;'>
                                <span style='font-size: 28px; font-weight: 800; background-color: #EAF9DE; color: #00712D; padding: 12px 25px; border-radius: 8px; letter-spacing: 6px; display: inline-block; border: 1px dashed #00712D;'>
                                    {$otp}
                                </span>
                            </div>
                            
                            <p style='color: #666; font-size: 13px; text-align: center; margin-bottom: 0;'>
                                <i>Mã này có hiệu lực trong vòng 5 phút. Nếu bạn không yêu cầu đổi mật khẩu, vui lòng bỏ qua email này.</i>
                            </p>
                        </div>
                    </div>
                ";

                $mail->send();
                echo json_encode(['status' => 'success']);
                
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => "Hệ thống gửi mail đang gián đoạn."]);
            }
            exit;
        }
    }

    public function reset_password() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $new_password = $_POST['new_password'];

            $model = new AuthModel();
            
            if ($model->updatePassword($email, $new_password)) {
                unset($_SESSION['otp']);
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Có lỗi xảy ra khi cập nhật mật khẩu!']);
            }
            exit;
        }
    }
}
?>