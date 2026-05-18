<?php
require_once 'app/models/rate_model.php';

class RateController {
    
    // Giao diện Thêm mới Đánh giá
    public function create() {
        $maChuyenDi = $_GET['id'] ?? '';
        if (empty($maChuyenDi)) die("Không tìm thấy mã chuyến đi.");

        $trip = RateModel::getTripDetails($maChuyenDi);
        if (!$trip) die("Chuyến đi không tồn tại.");

        require_once 'app/views/rate/index.php';
    }

    // Xử lý Lưu Đánh giá mới vào DB
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maChuyenDi = $_POST['ma_chuyen_di'] ?? '';
            $maDK = $_POST['ma_dk'] ?? '';
            $soSao = $_POST['so_sao'] ?? 5;
            $noiDung = $_POST['noi_dung'] ?? '';

            // Gọi hàm sinh mã tự động tăng dần thay vì dùng rand()
            $maDG = RateModel::generateNextMaDG();

            $result = RateModel::saveRating($maDG, $noiDung, $soSao, $maDK, $maChuyenDi);

            if ($result) {
                // Thông báo thành công bằng JavaScript Alert
                echo "<script>alert('Đánh giá chuyến đi thành công! Cảm ơn ý kiến đóng góp của bạn.'); window.location.href='index.php?controller=mytrip&action=index';</script>";
                exit();
            } else {
                echo "<script>alert('Gửi đánh giá thất bại. Vui lòng thử lại.'); window.history.back();</script>";
            }
        }
    }

    // Giao diện Sửa đánh giá đã có
    public function edit() {
        $maChuyenDi = $_GET['id'] ?? '';
        if (empty($maChuyenDi)) die("Không tìm thấy mã chuyến đi.");

        $trip = RateModel::getTripDetails($maChuyenDi);
        $rating = RateModel::getRatingByTrip($maChuyenDi); // Lấy nội dung cũ từ DB

        if (!$trip || !$rating) {
            die("Không tìm thấy thông tin đánh giá cũ.");
        }

        // Gọi View sửa đánh giá (file mới tạo ở bước dưới)
        require_once 'app/views/rate/edit.php';
    }

    // Xử lý Cập nhật thay đổi vào DB
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maDG = $_POST['ma_dg'] ?? '';
            $soSao = $_POST['so_sao'] ?? 5;
            $noiDung = $_POST['noi_dung'] ?? '';

            $result = RateModel::updateRating($maDG, $noiDung, $soSao);

            if ($result) {
                echo "<script>alert('Cập nhật nội dung đánh giá thành công!'); window.location.href='index.php?controller=mytrip&action=index';</script>";
                exit();
            } else {
                echo "<script>alert('Cập nhật thất bại. Vui lòng kiểm tra lại.'); window.history.back();</script>";
            }
        }
    }
}
?>