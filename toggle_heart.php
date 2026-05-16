<?php
// toggle_heart.php
session_start();
require_once 'db_connect.php';
header('Content-Type: application/json');

$maDK = isset($_SESSION['MaDK']) ? $_SESSION['MaDK'] : 'KH00000001'; // Giả lập đang đăng nhập
$maTour = isset($_POST['ma_tour']) ? $_POST['ma_tour'] : '';

if(empty($maTour)) {
    echo json_encode(['success' => false, 'message' => 'Lỗi dữ liệu']);
    exit;
}

try {
    global $conn;
    $checkSql = "SELECT * FROM DanhSachYeuThich WHERE MaDK = :maDK AND MaTour = :maTour";
    $stmt = $conn->prepare($checkSql);
    $stmt->execute([':maDK' => $maDK, ':maTour' => $maTour]);
    
    if($stmt->rowCount() > 0) {
        $delSql = "DELETE FROM DanhSachYeuThich WHERE MaDK = :maDK AND MaTour = :maTour";
        $conn->prepare($delSql)->execute([':maDK' => $maDK, ':maTour' => $maTour]);
        echo json_encode(['success' => true, 'action' => 'removed']);
    } else {
        $insSql = "INSERT INTO DanhSachYeuThich(MaDK, MaTour) VALUES(:maDK, :maTour)";
        $conn->prepare($insSql)->execute([':maDK' => $maDK, ':maTour' => $maTour]);
        echo json_encode(['success' => true, 'action' => 'added']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Lỗi server']);
}
?>