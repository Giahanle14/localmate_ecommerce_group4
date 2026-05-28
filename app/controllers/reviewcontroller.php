<?php
require_once __DIR__ . '/../models/reviewmodel.php';

class ReviewController {
    
    // 1. Hàm hiển thị Form Thêm Đánh Giá
    public function create() {
        $maChuyenDi = $_GET['id'] ?? '';
        if (empty($maChuyenDi)) die("Không tìm thấy mã chuyến đi.");

        $trip = ReviewModel::getTripDetails($maChuyenDi);
        if (!$trip) die("Chuyến đi không tồn tại.");

        // Khai báo rỗng để View hiểu là đang thêm mới
        $review = null;
        $images = [];

        require_once __DIR__ . '/../views/reviewview.php';
    }

    // 2. Hàm lưu dữ liệu đánh giá MỚI
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maChuyenDi = $_POST['ma_chuyen_di'] ?? '';
            $maTK_DK = $_POST['ma_dk'] ?? ''; 
            $soSao = $_POST['so_sao'] ?? 5;
            $noiDung = !empty($_POST['noi_dung']) ? $_POST['noi_dung'] : NULL;
            
            $dieuAnTuongArr = $_POST['dieu_an_tuong'] ?? [];
            $dieuAnTuong = !empty($dieuAnTuongArr) ? implode(',', $dieuAnTuongArr) : NULL;

            $maDG = ReviewModel::generateNextMaDG();
            $result = ReviewModel::saveRating($maDG, $noiDung, $soSao, $dieuAnTuong, $maTK_DK, $maChuyenDi);

            if ($result) {
                if (!empty($_FILES['hinh_anh']['name'][0])) {
                    $uploadDir = 'public/image/reviews/';
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                    foreach ($_FILES['hinh_anh']['name'] as $key => $name) {
                        if ($_FILES['hinh_anh']['error'][$key] == 0) {
                            $tmpName = $_FILES['hinh_anh']['tmp_name'][$key];
                            $ext = pathinfo($name, PATHINFO_EXTENSION);
                            $newName = 'rev_' . $maDG . '_' . time() . '_' . $key . '.' . $ext;
                            $targetFilePath = $uploadDir . $newName;
                            
                            if (move_uploaded_file($tmpName, $targetFilePath)) {
                                $maHA = ReviewModel::generateNextMaHinhAnh();
                                ReviewModel::saveReviewImage($maHA, $targetFilePath, $maDG);
                            }
                        }
                    }
                }
                echo "<script>alert('Đánh giá thành công!'); window.location.href='index.php?controller=mytrip';</script>";
                exit();
            } else {
                echo "<script>alert('Gửi đánh giá thất bại.'); window.history.back();</script>";
            }
        }
    }

    // 3. Hàm hiển thị Form SỬA Đánh Giá
    public function edit() {
        $maChuyenDi = $_GET['id'] ?? '';
        if (empty($maChuyenDi)) die("Không tìm thấy mã chuyến đi.");

        $trip = ReviewModel::getTripDetails($maChuyenDi);
        if (!$trip) die("Chuyến đi không tồn tại.");

        // Lấy dữ liệu cũ truyền ra view để View hiểu là đang sửa
        $review = ReviewModel::getReviewByTripId($maChuyenDi);
        if (!$review) die("Không tìm thấy đánh giá nào cho chuyến đi này.");
        $images = ReviewModel::getReviewImages($review['MaDG']);

        require_once __DIR__ . '/../views/reviewview.php';
    }

    // 4. Hàm lưu dữ liệu đánh giá SAU KHI SỬA
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maDG = $_POST['ma_dg'] ?? ''; 
            $soSao = $_POST['so_sao'] ?? 5;
            $noiDung = !empty($_POST['noi_dung']) ? $_POST['noi_dung'] : NULL;
            
            $dieuAnTuongArr = $_POST['dieu_an_tuong'] ?? [];
            $dieuAnTuong = !empty($dieuAnTuongArr) ? implode(',', $dieuAnTuongArr) : NULL;

            if (empty($maDG)) {
                echo "<script>alert('Lỗi dữ liệu.'); window.history.back();</script>";
                exit();
            }

            $result = ReviewModel::updateRating($maDG, $noiDung, $soSao, $dieuAnTuong);

            if ($result) {
                // Xử lý thêm ảnh mới (ảnh cũ vẫn giữ nguyên trong DB)
                if (!empty($_FILES['hinh_anh']['name'][0])) {
                    $uploadDir = 'public/image/reviews/';
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                    foreach ($_FILES['hinh_anh']['name'] as $key => $name) {
                        if ($_FILES['hinh_anh']['error'][$key] == 0) {
                            $tmpName = $_FILES['hinh_anh']['tmp_name'][$key];
                            $ext = pathinfo($name, PATHINFO_EXTENSION);
                            $newName = 'rev_' . $maDG . '_' . time() . '_' . $key . '.' . $ext;
                            $targetFilePath = $uploadDir . $newName;
                            
                            if (move_uploaded_file($tmpName, $targetFilePath)) {
                                $maHA = ReviewModel::generateNextMaHinhAnh();
                                ReviewModel::saveReviewImage($maHA, $targetFilePath, $maDG);
                            }
                        }
                    }
                }
                echo "<script>alert('Cập nhật đánh giá thành công!'); window.location.href='index.php?controller=mytrip';</script>";
                exit();
            } else {
                echo "<script>alert('Cập nhật thất bại. Vui lòng thử lại.'); window.history.back();</script>";
            }
        }
    }

    // 5. Hàm XÓA đánh giá
    public function delete() {
        $maChuyenDi = $_GET['id'] ?? ''; 
        if (empty($maChuyenDi)) {
            echo "<script>alert('Không tìm thấy chuyến đi.'); window.location.href='index.php?controller=mytrip';</script>";
            exit();
        }

        $review = ReviewModel::getReviewByTripId($maChuyenDi);
        
        if ($review) {
            $result = ReviewModel::deleteReview($review['MaDG']);
            if ($result) {
                echo "<script>alert('Đã xóa đánh giá thành công!'); window.location.href='index.php?controller=mytrip';</script>";
            } else {
                echo "<script>alert('Xóa đánh giá thất bại.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Đánh giá không tồn tại.'); window.history.back();</script>";
        }
    }
}
?>