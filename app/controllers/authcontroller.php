<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class AuthController {

    public function login() {
        require_once __DIR__ . '/../config/db_connect.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            try {
                $stmt = $conn->prepare("SELECT * FROM TaiKhoan WHERE Gmail = ? AND MatKhau = ?");
                $stmt->execute([$email, $password]);
                $taiKhoan = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($taiKhoan) {
                    $stmtDK = $conn->prepare("SELECT * FROM DuKhach WHERE MaTK_DK = ?");
                    $stmtDK->execute([$taiKhoan['MaTK']]);
                    $duKhach = $stmtDK->fetch(PDO::FETCH_ASSOC);

                    $_SESSION['user'] = [
                        'MaTK' => $taiKhoan['MaTK'],
                        'Gmail' => $taiKhoan['Gmail'],
                        'LoaiTK' => $taiKhoan['LoaiTK'], 
                        'HoTen' => $taiKhoan['HoTen'], // Cột HoTen nằm ở bảng TaiKhoan
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
}
?>