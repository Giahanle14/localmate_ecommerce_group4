<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class AuthController {

    public function login() {
        require_once __DIR__ . '/../config/db_connect.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password']; // Mật khẩu thô do người dùng nhập

            try {
                // 1. Chỉ tìm tài khoản bằng Email
                $stmt = $conn->prepare("SELECT * FROM TaiKhoan WHERE Gmail = ?");
                $stmt->execute([$email]);
                $taiKhoan = $stmt->fetch(PDO::FETCH_ASSOC);

                // 2. Kiểm tra tài khoản có tồn tại và đối chiếu mật khẩu bằng password_verify
                if ($taiKhoan && password_verify($password, $taiKhoan['MatKhau'])) {
                    
                    // Nếu đúng mật khẩu, tiếp tục lấy thông tin DuKhach
                    $stmtDK = $conn->prepare("SELECT * FROM DuKhach WHERE MaTK_DK = ?");
                    $stmtDK->execute([$taiKhoan['MaTK']]);
                    $duKhach = $stmtDK->fetch(PDO::FETCH_ASSOC);

                    // Lưu thông tin vào Session
                    $_SESSION['user'] = [
                        'MaTK' => $taiKhoan['MaTK'],
                        'Gmail' => $taiKhoan['Gmail'],
                        'LoaiTK' => $taiKhoan['LoaiTK'], 
                        'HoTen' => $taiKhoan['HoTen'], 
                        'MaDK' => $duKhach ? $duKhach['MaDK'] : null
                    ];

                    // Chuyển hướng theo loại tài khoản
                    if ($taiKhoan['LoaiTK'] === 'Quản trị viên') {
                        header("Location: index.php?controller=adminhome");
                    } else {
                        header("Location: index.php?controller=home");
                    }
                    exit();
                } else {
                    // Cố tình dùng thông báo chung chung để tránh bị hacker dò thông tin
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
}
?>
