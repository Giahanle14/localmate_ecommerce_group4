<?php
// db_connect.php
$host = '26.211.116.140';
$dbname = 'localmate_db';
$username = 'LocalMateData';
$password = 'LocalMate04';     

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Thiết lập chế độ báo lỗi
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Kết nối CSDL thất bại: " . $e->getMessage());
}
?>