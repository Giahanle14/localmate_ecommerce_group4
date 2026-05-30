<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class AuthController {

    // Khi URL chỉ có ?controller=auth, nó sẽ tự động chạy vào đây và gọi hàm login
    public function index() {
        $this->login();
    }

    public function login() {
        require_once __DIR__ . '/../config/db_connect.php';

        // TRƯỜNG HỢP 1: NGƯỜI DÙNG BẤM NÚT "ĐĂNG NHẬP" (Gửi form POST)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password']; // Mật khẩu thô do người dùng nhập

            try {
                // Chỉ tìm tài khoản bằng Email
                $stmt = $conn->prepare("SELECT * FROM TaiKhoan WHERE Gmail = ?");
                $stmt->execute([$email]);
                $taiKhoan = $stmt->fetch(PDO::FETCH_ASSOC);

                // Kiểm tra tài khoản có tồn tại và đối chiếu mật khẩu
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
                    // Nếu sai pass, báo lỗi và load lại đúng trang đăng nhập
                    echo "<script>alert('Sai Email hoặc Mật khẩu!'); window.location.href='index.php?controller=auth&action=login';</script>";
                }
            } catch (PDOException $e) {
                echo "Lỗi truy vấn: " . $e->getMessage();
            }
        } 
        // TRƯỜNG HỢP 2: NGƯỜI DÙNG VỪA CHUYỂN TRANG TỚI (Phương thức GET)
        else {
            // Nếu ai cố tình gõ URL này, ta đẩy họ về lại trang chủ cho an toàn.
            header("Location: index.php?controller=home");
            exit();
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