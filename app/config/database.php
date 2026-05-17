<?php
$host = 'localhost';
$dbname = 'localmate_db';   // dùng đúng tên hiển thị trong phpMyAdmin
$username = 'root';
$password = '';             // XAMPP mặc định để trống

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Lỗi kết nối CSDL: " . $e->getMessage());
}
?>