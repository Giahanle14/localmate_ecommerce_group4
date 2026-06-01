<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// =====================================================================
// KIỂM TRA BẢO MẬT: BUỘC ĐĂNG XUẤT NẾU TÀI KHOẢN BỊ KHÓA HOẶC XÓA
// =====================================================================
if (isset($_SESSION['user']['MaTK']) && !empty($_SESSION['user']['MaTK'])) {
    require_once "app/config/db_connect.php"; 
    global $conn;
    
    if ($conn) {
        $maTK_dang_nhap = $_SESSION['user']['MaTK'];
        // ĐÃ SỬA: TaiKhoan -> taikhoan
        $stmt = $conn->prepare("SELECT TrangThai, DaXoa FROM taikhoan WHERE MaTK = ?");
        $stmt->execute([$maTK_dang_nhap]);
        $userCheck = $stmt->fetch();

        // Nếu không tìm thấy user, bị xóa mềm, hoặc bị khóa
        if (!$userCheck || $userCheck['DaXoa'] == 1 || $userCheck['TrangThai'] == 'Bị khóa') {
            
            // 1. Xóa sạch dữ liệu đăng nhập
            session_unset();
            session_destroy();
            
            // 2. Kiểm tra xem request này là AJAX hay là Load trang bình thường
            $isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
                      || isset($_REQUEST['ajax_action']) 
                      || (isset($_REQUEST['action']) && $_REQUEST['action'] === 'toggle_heart');

            if ($isAjax) {
                // Nếu là AJAX (Ví dụ đang bấm thả tim, chuyển trang bảng) -> Trả về JSON báo lỗi
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'status' => 'error', 
                    'message' => 'Tài khoản của bạn đã bị khóa hoặc vô hiệu hóa. Hệ thống đã tự động đăng xuất.',
                    'redirect' => 'index.php?controller=home'
                ]);
                exit();
            } else {
                // Nếu load trang bình thường -> Hiển thị Alert và văng ra trang chủ
                echo "<script>
                    alert('Tài khoản của bạn đã bị khóa hoặc vô hiệu hóa. Vui lòng liên hệ quản trị viên.');
                    window.location.href = 'index.php?controller=home';
                </script>";
                exit(); 
            }
        }
    }
}
// =====================================================================

// Lấy tên Controller từ thanh URL (Mặc định là 'home')
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';

// Ép tên file về chữ thường để khớp với tên file homecontroller.php của bà
$controllerFile = "app/controllers/" . strtolower($controller) . "controller.php";

// Viết hoa chữ cái đầu cho tên Class (Ví dụ: HomeController)
$className = ucfirst($controller) . "Controller";

// Kiểm tra và chạy
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    if (class_exists($className)) {
        $obj = new $className();
        if (method_exists($obj, $actionName)) {
            $obj->$actionName();
        } else {
            echo "<h1>Lỗi: Không tìm thấy hàm '$actionName' trong class '$className'</h1>";
        }
    } else {
        echo "<h1>Lỗi: Đã thấy file '$controllerFile' nhưng bên trong không có class '$className'</h1>";
    }
} else {
    echo "<h1>Lỗi 404: Không tìm thấy file tại đường dẫn: $controllerFile</h1>";
}

?>