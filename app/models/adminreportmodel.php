<?php
// app/models/adminreportmodel.php

class AdminReportModel {
    private $conn;

    public function __construct() {
        global $conn; 
        if (!$conn) {
            require_once __DIR__ . '/../config/db_connect.php';
        }
        $this->conn = $conn;
    }

    public function getRevenueData($filters) {
        $year = $filters['year'] ?? date('Y');
        $month = $filters['month'] ?? '';
        $quarter = $filters['quarter'] ?? '';
        $loaiStr = $filters['loai'] ?? '';
        $vungStr = $filters['vung'] ?? '';

        // Điều kiện cơ bản: Chỉ tính các chuyến đi Đã hoàn thành
        $where = ["cd.trangthai = 'Đã hoàn thành'"];
        $params = [];

        if (!empty($year)) {
            $where[] = "YEAR(lkh.ngaybatdau) = ?";
            $params[] = $year;
        }

        if (!empty($month)) {
            $where[] = "MONTH(lkh.ngaybatdau) = ?";
            $params[] = $month;
        } elseif (!empty($quarter)) {
            $where[] = "QUARTER(lkh.ngaybatdau) = ?";
            $params[] = $quarter;
        }

        // XỬ LÝ LỌC NHIỀU LOẠI TRẢI NGHIỆM
        if (!empty($loaiStr)) {
            $loaiArr = explode(',', $loaiStr);
            $loaiConditions = [];
            foreach ($loaiArr as $loaiItem) {
                if (!empty(trim($loaiItem))) {
                    $loaiConditions[] = "FIND_IN_SET(?, t.loaitraininghiem)";
                    $params[] = trim($loaiItem);
                }
            }
            if (count($loaiConditions) > 0) {
                $where[] = "(" . implode(' OR ', $loaiConditions) . ")";
            }
        }

        // XỬ LÝ LỌC NHIỀU VÙNG ĐỊA LÝ
        if (!empty($vungStr)) {
            $vungArr = explode(',', $vungStr);
            $vungPlaceholders = [];
            foreach ($vungArr as $vungItem) {
                if (!empty(trim($vungItem))) {
                    $vungPlaceholders[] = "?";
                    $params[] = trim($vungItem);
                }
            }
            if (count($vungPlaceholders) > 0) {
                $where[] = "t.vungdialy IN (" . implode(',', $vungPlaceholders) . ")";
            }
        }

        $whereClause = "WHERE " . implode(' AND ', $where);

        // CHUỖI JOIN MỚI CẬP NHẬT THEO SCHEME CSDL
        $joins = "FROM chuyendi cd 
                  JOIN lichkhoihanh lkh ON cd.malichkhoihanh = lkh.malichkhoihanh 
                  JOIN tour t ON lkh.matour = t.matour";

        // 1. Truy vấn Tổng doanh thu
        $sqlTotal = "SELECT SUM(cd.tonggiatien) as Total $joins $whereClause";
        $stmt = $this->conn->prepare($sqlTotal);
        $stmt->execute($params);
        $totalRevenue = $stmt->fetchColumn() ?: 0;

        // 2. Dữ liệu Biểu đồ cột (Theo ngày nếu chọn Tháng, ngược lại theo Tháng)
        if (!empty($month)) {
            $sqlBar = "SELECT DAY(lkh.ngaybatdau) as label, SUM(cd.tonggiatien) as value 
                       $joins $whereClause GROUP BY DAY(lkh.ngaybatdau) ORDER BY DAY(lkh.ngaybatdau)";
        } else {
            $sqlBar = "SELECT MONTH(lkh.ngaybatdau) as label, SUM(cd.tonggiatien) as value 
                       $joins $whereClause GROUP BY MONTH(lkh.ngaybatdau) ORDER BY MONTH(lkh.ngaybatdau)";
        }
        $stmt = $this->conn->prepare($sqlBar);
        $stmt->execute($params);
        $barDataRaw = $stmt->fetchAll();
        
        $barData = ['labels' => [], 'values' => []];
        $dataMap = [];
        foreach ($barDataRaw as $row) $dataMap[$row['label']] = $row['value'];

        // Lấp đầy các khoảng trống (ngày/tháng không có doanh thu thì gán = 0)
        if (!empty($month)) {
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $barData['labels'][] = "$i/$month";
                $barData['values'][] = isset($dataMap[$i]) ? (float)$dataMap[$i] : 0;
            }
        } else {
            $startMonth = 1; $endMonth = 12;
            if (!empty($quarter)) {
                $startMonth = ($quarter - 1) * 3 + 1;
                $endMonth = $quarter * 3;
            }
            for ($i = $startMonth; $i <= $endMonth; $i++) {
                $barData['labels'][] = "Tháng $i";
                $barData['values'][] = isset($dataMap[$i]) ? (float)$dataMap[$i] : 0;
            }
        }

        // 3. Biểu đồ tròn - Cơ cấu theo Vùng địa lý
        $sqlVung = "SELECT t.vungdialy as label, SUM(cd.tonggiatien) as value 
                    $joins $whereClause GROUP BY t.vungdialy";
        $stmt = $this->conn->prepare($sqlVung);
        $stmt->execute($params);
        $pieVung = $stmt->fetchAll();

        // 4. Biểu đồ ngang - Doanh thu theo Loại trải nghiệm
        $loaiList = ['Văn hóa', 'Ẩm thực', 'Rừng cây', 'Chữa lành', 'Núi non', 'Tham quan', 'Biển đảo', 'Nông thôn', 'Sông nước'];
        $pieLoai = [];
        foreach ($loaiList as $l) {
            $paramsLoai = $params;
            $sqlLoai = "SELECT SUM(cd.tonggiatien) 
                        $joins $whereClause AND FIND_IN_SET(?, t.loaitraininghiem)";
            $paramsLoai[] = $l;
            $stmt = $this->conn->prepare($sqlLoai);
            $stmt->execute($paramsLoai);
            $val = $stmt->fetchColumn();
            if ($val > 0) {
                $pieLoai[] = ['label' => $l, 'value' => (float)$val];
            }
        }

        return [
            'total' => (float)$totalRevenue,
            'barChart' => $barData,
            'pieVung' => $pieVung,
            'pieLoai' => $pieLoai
        ];
    }
}
?>