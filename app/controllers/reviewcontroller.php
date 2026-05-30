<?php
require_once __DIR__ . '/../models/reviewmodel.php';

class ReviewController {
    
    // Hàm dùng chung để in ra thông báo SweetAlert2 cực đẹp rồi chuyển hướng
    private function alertAndRedirect($icon, $title, $url) {
        echo "<!DOCTYPE html><html><head><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head><body>";
        echo "<script>
            Swal.fire({
                icon: '$icon',
                title: '$title',
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = '$url';
            });
        </script></body></html>";
        exit();
    }

    public function create() {
        $maChuyenDi = $_GET['id'] ?? '';
        if (empty($maChuyenDi)) die("Không tìm thấy mã chuyến đi.");
        $trip = ReviewModel::getTripDetails($maChuyenDi);
        if (!$trip) die("Chuyến đi không tồn tại.");

        $review = null;
        $images = [];
        require_once __DIR__ . '/../views/reviewview.php';
    }

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
                            if (move_uploaded_file($tmpName, $uploadDir . $newName)) {
                                ReviewModel::saveReviewImage(ReviewModel::generateNextMaHinhAnh(), $uploadDir . $newName, $maDG);
                            }
                        }
                    }
                }
                // Thay vì về mytrip, giờ sẽ ở lại trang Xem lại đánh giá
                $this->alertAndRedirect('success', 'Đánh giá thành công!', "index.php?controller=review&action=edit&id=$maChuyenDi");
            } else {
                $this->alertAndRedirect('error', 'Gửi đánh giá thất bại!', "javascript:history.back()");
            }
        }
    }

    public function edit() {
        $maChuyenDi = $_GET['id'] ?? '';
        if (empty($maChuyenDi)) die("Không tìm thấy mã chuyến đi.");
        $trip = ReviewModel::getTripDetails($maChuyenDi);
        if (!$trip) die("Chuyến đi không tồn tại.");

        $review = ReviewModel::getReviewByTripId($maChuyenDi);
        if (!$review) die("Không tìm thấy đánh giá nào cho chuyến đi này.");
        $images = ReviewModel::getReviewImages($review['MaDG']);

        require_once __DIR__ . '/../views/reviewview.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maDG = $_POST['ma_dg'] ?? ''; 
            $soSao = $_POST['so_sao'] ?? 5;
            $noiDung = !empty($_POST['noi_dung']) ? $_POST['noi_dung'] : NULL;
            $maChuyenDi = $_POST['ma_chuyen_di'] ?? '';
            
            $dieuAnTuongArr = $_POST['dieu_an_tuong'] ?? [];
            $dieuAnTuong = !empty($dieuAnTuongArr) ? implode(',', $dieuAnTuongArr) : NULL;

            if (empty($maDG)) {
                $this->alertAndRedirect('error', 'Lỗi dữ liệu!', "javascript:history.back()");
            }

            // Xử lý XÓA ảnh cũ nếu người dùng bấm dấu X
            $deleteImages = $_POST['delete_images'] ?? [];
            foreach ($deleteImages as $maHA) {
                ReviewModel::deleteReviewImage($maHA);
            }

            // Cập nhật Database
            $result = ReviewModel::updateRating($maDG, $noiDung, $soSao, $dieuAnTuong);

            if ($result) {
                // Thêm ảnh mới
                if (!empty($_FILES['hinh_anh']['name'][0])) {
                    $uploadDir = 'public/image/reviews/';
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                    foreach ($_FILES['hinh_anh']['name'] as $key => $name) {
                        if ($_FILES['hinh_anh']['error'][$key] == 0) {
                            $tmpName = $_FILES['hinh_anh']['tmp_name'][$key];
                            $ext = pathinfo($name, PATHINFO_EXTENSION);
                            $newName = 'rev_' . $maDG . '_' . time() . '_' . $key . '.' . $ext;
                            if (move_uploaded_file($tmpName, $uploadDir . $newName)) {
                                ReviewModel::saveReviewImage(ReviewModel::generateNextMaHinhAnh(), $uploadDir . $newName, $maDG);
                            }
                        }
                    }
                }
                // Cập nhật xong ở lại trang đó
                $this->alertAndRedirect('success', 'Cập nhật thành công!', "index.php?controller=review&action=edit&id=$maChuyenDi");
            } else {
                $this->alertAndRedirect('error', 'Cập nhật thất bại!', "javascript:history.back()");
            }
        }
    }

    public function delete() {
        $maChuyenDi = $_GET['id'] ?? ''; 
        if (empty($maChuyenDi)) $this->alertAndRedirect('error', 'Không tìm thấy chuyến đi.', "index.php?controller=mytrip");

        $review = ReviewModel::getReviewByTripId($maChuyenDi);
        if ($review) {
            $result = ReviewModel::deleteReview($review['MaDG']);
            if ($result) {
                // Xóa xong thì về trang Mytrip
                $this->alertAndRedirect('success', 'Đã xóa đánh giá!', "index.php?controller=mytrip");
            } else {
                $this->alertAndRedirect('error', 'Xóa thất bại!', "javascript:history.back()");
            }
        } else {
            $this->alertAndRedirect('error', 'Đánh giá không tồn tại.', "javascript:history.back()");
        }
    }
}
?>