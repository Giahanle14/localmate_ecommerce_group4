<?php
// app/controllers/adminreportcontroller.php

require_once __DIR__ . '/../models/adminreportmodel.php';

class AdminReportController {
    private $model;

    public function __construct() {
        $this->model = new AdminReportModel();
    }

    public function index() {
        // Kiểm tra gọi API ngầm từ AJAX
        if (isset($_REQUEST['ajax_action'])) {
            $this->handleAjax($_REQUEST['ajax_action']);
            exit();
        }

        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/adminreportview.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    private function handleAjax($action) {
        header('Content-Type: application/json');
        
        switch ($action) {
            case 'getData':
                $filters = [
                    'year' => $_GET['year'] ?? date('Y'),
                    'month' => $_GET['month'] ?? '',
                    'quarter' => $_GET['quarter'] ?? '',
                    'loai' => $_GET['loai'] ?? '',
                    'vung' => $_GET['vung'] ?? ''
                ];
                
                $data = $this->model->getRevenueData($filters);
                echo json_encode(['status' => 'success', 'data' => $data]);
                break;
            default:
                echo json_encode(['status' => 'error', 'message' => 'Invalid Action']);
                break;
        }
    }
}
?>