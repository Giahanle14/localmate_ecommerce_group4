<?php
// app/controllers/adminaccountcontroller.php

require_once __DIR__ . '/../models/adminaccountmodel.php';

class AdminAccountController {
    private $model;

    public function __construct() {
        $this->model = new AdminAccountModel();
    }

    // Hàm index chính
    public function index() {
        // Kiểm tra xem đây có phải là request AJAX không
        if (isset($_REQUEST['ajax_action'])) {
            $this->handleAjax($_REQUEST['ajax_action']);
            exit(); // Ngưng thực thi để chỉ trả về JSON
        }

        // Nếu không phải AJAX, load giao diện bình thường
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/adminaccountview.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    // --- XỬ LÝ AJAX ---
    private function handleAjax($action) {
        header('Content-Type: application/json');
        
        switch ($action) {
            case 'getList':
                $search = $_GET['search'] ?? '';
                $role = $_GET['role'] ?? '';
                $rank = $_GET['rank'] ?? '';
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $limit = 10; // 10 dòng 1 trang

                $list = $this->model->getListAccounts($search, $role, $rank, $page, $limit);
                $total = $this->model->countAccounts($search, $role, $rank);
                $totalPages = ceil($total / $limit);

                echo json_encode([
                    'status' => 'success',
                    'data' => $list,
                    'totalPages' => $totalPages,
                    'currentPage' => $page
                ]);
                break;

            case 'getDetail':
                $maTK = $_GET['maTK'] ?? '';
                $detail = $this->model->getAccountDetail($maTK);
                if ($detail) {
                    echo json_encode(['status' => 'success', 'data' => $detail]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy tài khoản']);
                }
                break;

            case 'add':
                $data = json_decode(file_get_contents('php://input'), true);
                
                // Validate email trùng
                if ($this->model->isEmailExists($data['Gmail'])) {
                    echo json_encode(['status' => 'error', 'message' => 'Gmail đã tồn tại trong hệ thống!']);
                    return;
                }

                $result = $this->model->addAccount($data);
                if ($result) {
                    echo json_encode(['status' => 'success', 'message' => 'Thêm tài khoản thành công!']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Lỗi hệ thống khi thêm tài khoản.']);
                }
                break;

            case 'update':
                $data = json_decode(file_get_contents('php://input'), true);
                
                // Validate email trùng
                if ($this->model->isEmailExists($data['Gmail'], $data['MaTK'])) {
                    echo json_encode(['status' => 'error', 'message' => 'Gmail đã tồn tại cho một tài khoản khác!']);
                    return;
                }

                $result = $this->model->updateAccount($data);
                if ($result) {
                    echo json_encode(['status' => 'success', 'message' => 'Cập nhật tài khoản thành công!']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Lỗi hệ thống khi cập nhật.']);
                }
                break;

            case 'delete':
                $data = json_decode(file_get_contents('php://input'), true);
                $maTK = $data['MaTK'] ?? '';
                
                $result = $this->model->deleteAccount($maTK);
                if ($result) {
                    echo json_encode(['status' => 'success', 'message' => 'Đã xóa tài khoản thành công!']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Lỗi hệ thống khi xóa.']);
                }
                break;

            default:
                echo json_encode(['status' => 'error', 'message' => 'Invalid Action']);
                break;
        }
    }
}
?>