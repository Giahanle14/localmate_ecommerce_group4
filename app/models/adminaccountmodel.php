<?php
// app/models/adminaccountmodel.php

class AdminAccountModel {
    private $conn;

    public function __construct() {
        // Tái sử dụng kết nối từ db_connect.php
        global $conn; 
        if (!$conn) {
            require_once __DIR__ . '/../config/db_connect.php';
        }
        $this->conn = $conn;
    }

    // --- CÁC HÀM TỰ ĐỘNG SINH MÃ ---
    public function generateTaiKhoanId() {
        $stmt = $this->conn->query("SELECT MaTK FROM taikhoan ORDER BY MaTK DESC LIMIT 1");
        $last = $stmt->fetchColumn();
        if(!$last) return 'TK00000001';
        $num = intval(substr($last, 2)) + 1;
        return 'TK' . str_pad($num, 8, '0', STR_PAD_LEFT);
    }

    public function generateQtvId() {
        $stmt = $this->conn->query("SELECT MaQTV FROM qtv ORDER BY MaQTV DESC LIMIT 1");
        $last = $stmt->fetchColumn();
        if(!$last) return 'QTV01';
        $num = intval(substr($last, 3)) + 1;
        return 'QTV' . str_pad($num, 2, '0', STR_PAD_LEFT);
    }

    public function generateDkId() {
        $stmt = $this->conn->query("SELECT MaDK FROM dukhach ORDER BY MaDK DESC LIMIT 1");
        $last = $stmt->fetchColumn();
        if(!$last) return 'DK00000001';
        $num = intval(substr($last, 2)) + 1;
        return 'DK' . str_pad($num, 8, '0', STR_PAD_LEFT);
    }

    // --- CÁC HÀM NGHIỆP VỤ ---

    // Lấy danh sách có tìm kiếm, lọc và phân trang
    public function getListAccounts($search, $role, $rank, $page, $limit) {
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT tk.MaTK, tk.HoTen, tk.SDT, tk.Gmail, tk.LoaiTK, tk.TrangThai,
                       dk.HangThanhVien, qtv.ChucDanh
                FROM taikhoan tk
                LEFT JOIN dukhach dk ON tk.MaTK = dk.MaTK_DK
                LEFT JOIN qtv qtv ON tk.MaTK = qtv.MaTK_QTV
                WHERE tk.DaXoa = 0 ";
        
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND (tk.HoTen LIKE ? OR tk.SDT LIKE ?) ";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        
        if (!empty($role)) {
            $sql .= " AND tk.LoaiTK = ? ";
            $params[] = $role;
            
            // Chỉ lọc hạng thành viên nếu vai trò là Du khách
            if ($role === 'Du khách' && !empty($rank)) {
                $sql .= " AND dk.HangThanhVien = ? ";
                $params[] = $rank;
            }
        }

        $sql .= " ORDER BY tk.MaTK DESC LIMIT $limit OFFSET $offset";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Đếm tổng số tài khoản để phân trang
    public function countAccounts($search, $role, $rank) {
        $sql = "SELECT COUNT(*) as total
                FROM taikhoan tk
                LEFT JOIN dukhach dk ON tk.MaTK = dk.MaTK_DK
                WHERE tk.DaXoa = 0 ";
        
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND (tk.HoTen LIKE ? OR tk.SDT LIKE ?) ";
            $params[] = "%$search%"; $params[] = "%$search%";
        }
        if (!empty($role)) {
            $sql .= " AND tk.LoaiTK = ? ";
            $params[] = $role;
            if ($role === 'Du khách' && !empty($rank)) {
                $sql .= " AND dk.HangThanhVien = ? ";
                $params[] = $rank;
            }
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    // Xem chi tiết
    public function getAccountDetail($maTK) {
        $stmt = $this->conn->prepare("SELECT * FROM taikhoan WHERE MaTK = ? AND DaXoa = 0");
        $stmt->execute([$maTK]);
        $account = $stmt->fetch();

        if (!$account) return null;

        if ($account['LoaiTK'] === 'Quản trị viên') {
            $stmtQtv = $this->conn->prepare("SELECT ChucDanh, MaQTV FROM qtv WHERE MaTK_QTV = ?");
            $stmtQtv->execute([$maTK]);
            $qtv = $stmtQtv->fetch();
            return array_merge($account, $qtv ? $qtv : []);
        } else {
            $stmtDk = $this->conn->prepare("SELECT MaDK, NgaySinh, GioiTinh, DiaChi, SDTKhanCap, HangThanhVien FROM dukhach WHERE MaTK_DK = ?");
            $stmtDk->execute([$maTK]);
            $dk = $stmtDk->fetch();
            return array_merge($account, $dk ? $dk : []);
        }
    }

    // Kiểm tra trùng email
    public function isEmailExists($email, $excludeMaTK = null) {
        $sql = "SELECT COUNT(*) FROM taikhoan WHERE Gmail = ? AND DaXoa = 0";
        $params = [$email];
        if ($excludeMaTK) {
            $sql .= " AND MaTK != ?";
            $params[] = $excludeMaTK;
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    // Thêm tài khoản mới (Dùng Transaction)
    public function addAccount($data) {
        try {
            $this->conn->beginTransaction();

            $maTK = $this->generateTaiKhoanId();
            $matKhau = password_hash($data['LoaiTK'] === 'Quản trị viên' ? 'qtv123' : 'dk123', PASSWORD_BCRYPT);

            // 1. Thêm vào taikhoan
            $stmt1 = $this->conn->prepare("INSERT INTO taikhoan (MaTK, HoTen, SDT, Gmail, MatKhau, LoaiTK, TrangThai) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt1->execute([$maTK, $data['HoTen'], $data['SDT'], $data['Gmail'], $matKhau, $data['LoaiTK'], $data['TrangThai']]);

            // 2. Thêm vào bảng chi tiết
            if ($data['LoaiTK'] === 'Quản trị viên') {
                $maQTV = $this->generateQtvId();
                $stmt2 = $this->conn->prepare("INSERT INTO qtv (MaTK_QTV, MaQTV, ChucDanh) VALUES (?, ?, ?)");
                $stmt2->execute([$maTK, $maQTV, $data['ChucDanh']]);
            } else {
                $maDK = $this->generateDkId();
                $stmt2 = $this->conn->prepare("INSERT INTO dukhach (MaTK_DK, MaDK, HangThanhVien) VALUES (?, ?, ?)");
                // Mặc định tạo tài khoản du khách mới thì chưa có Ngày sinh, Địa chỉ (cập nhật sau)
                $stmt2->execute([$maTK, $maDK, 'Đồng']); 
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    // Cập nhật tài khoản
    public function updateAccount($data) {
        try {
            $this->conn->beginTransaction();

            // Cập nhật bảng taikhoan (Đã BỎ trường HoTen ra khỏi câu lệnh SET để chống cập nhật)
            $stmt1 = $this->conn->prepare("UPDATE taikhoan SET SDT = ?, Gmail = ?, TrangThai = ? WHERE MaTK = ?");
            $stmt1->execute([$data['SDT'], $data['Gmail'], $data['TrangThai'], $data['MaTK']]);

            // Cập nhật bảng chi tiết nếu là QTV
            if ($data['LoaiTK'] === 'Quản trị viên' && isset($data['ChucDanh'])) {
                $stmt2 = $this->conn->prepare("UPDATE qtv SET ChucDanh = ? WHERE MaTK_QTV = ?");
                $stmt2->execute([$data['ChucDanh'], $data['MaTK']]);
            }
            // Du khách thì Hạng thành viên tự cập nhật theo logic hệ thống, admin ít khi sửa tay, nhưng nếu muốn có thể thêm logic ở đây.

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    // Xóa mềm tài khoản
    public function deleteAccount($maTK) {
        $stmt = $this->conn->prepare("UPDATE taikhoan SET DaXoa = 1 WHERE MaTK = ?");
        return $stmt->execute([$maTK]);
    }
}
?>