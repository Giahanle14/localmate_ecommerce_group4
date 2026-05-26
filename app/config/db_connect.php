<?php

$host = '26.211.116.140'; // IP VPN máy chủ (Giữ nguyên nếu nhóm đang dùng chung mạng ảo)
$dbname = 'LocalMate_db'; 
$username = 'LocalMateData';
$password = 'LocalMate04';     

try {
    // Kết nối CSDL bằng PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Thiết lập chế độ báo lỗi (Exception) để dễ debug
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Thiết lập mảng trả về mặc định là mảng kết hợp (Associative Array)
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // Báo lỗi bằng Tiếng Việt kèm chi tiết lỗi từ hệ thống
    die("<h3 style='color:red; text-align:center;'>Kết nối CSDL thất bại: " . $e->getMessage() . "</h3>");
}
?>