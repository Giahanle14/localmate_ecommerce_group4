<?php
session_start();

// 3 DÒNG NÀY LÀ THẦN CHÚ ĐỂ BẬT HIỂN THỊ LỖI THAY VÌ TRẮNG MÀN HÌNH
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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