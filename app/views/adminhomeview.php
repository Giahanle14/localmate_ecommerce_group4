<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700;800&display=swap" rel="stylesheet">

<style>
    .admin-dashboard {
        font-family: 'Quicksand', sans-serif;
        background-color: #fdfae9; /* Màu nền kem vàng nhạt của trang */
        padding: 40px;
        min-height: 100vh;
    }
    .section-title {
        color: #00712D !important; /* Ép buộc màu chữ là xanh lá */
        background-color: transparent !important; /* Ép buộc xóa nền, làm cho nền trong suốt */
        font-weight: 800;
        text-align: center;
        font-size: 1.8rem;
        margin-bottom: 30px;
        letter-spacing: 1px;
        text-transform: uppercase;
        border: none !important; 
        text-align: center !important; 
        display: block !important;
        width: 100% !important;
    }
    
    /* CSS CHO 4 THẺ THỐNG KÊ */
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 25px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 2px solid #fff;
        margin-bottom: 25px;
        transition: 0.3s ease;
        cursor: pointer; /* THÊM DÒNG NÀY ĐỂ HIỆN BÀN TAY KHI HOVER */
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    }
    .stat-title {
        font-size: 0.95rem;
        color: #888;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .stat-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: #00712D; /* Màu xanh lá chuẩn */
        margin: 0;
    }
    /* Các ô icon pastel */
    .icon-box {
        width: 70px; height: 70px;
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        font-size: 2rem;
    }
    .icon-wallet { background-color: #e5f5e5; color: #4caf50; }
    .icon-tour { background-color: #e3f2fd; color: #2196f3; }
    .icon-user { background-color: #fff3e0; color: #ff9800; }
    .icon-review { background-color: #fce4ec; color: #e91e63; }

    /* CSS CHO BẢNG CHUYẾN ĐI */
    .table-container {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        margin-top: 20px;
    }
    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px; /* Tạo khoảng cách giữa các dòng */
    }
    .custom-table th {
        background-color: #eaf5eb; /* Nền xanh nhạt ở Header */
        color: #00712D;
        font-weight: 700;
        padding: 15px;
        text-align: center;
        border: none;
    }
    .custom-table th:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px; }
    .custom-table th:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px; }
    
    .custom-table td {
        padding: 15px;
        text-align: center;
        font-weight: 600;
        color: #444;
        background: #fafafa; /* Nền xám rất nhẹ cho từng dòng */
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
    }
    .custom-table td:first-child { border-left: 1px solid #f0f0f0; border-top-left-radius: 10px; border-bottom-left-radius: 10px; color: #222; font-weight: 700; }
    .custom-table td:last-child { border-right: 1px solid #f0f0f0; border-top-right-radius: 10px; border-bottom-right-radius: 10px; }
    
    .status-badge {
        background-color: #00712D;
        color: white;
        padding: 8px 15px;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 700;
        display: inline-block;
    }
</style>

<div class="admin-dashboard">
    <div class="container">
        
        <h2 class="section-title mb-5">TRANG CHỦ</h2>

        <div class="row">
            <div class="col-md-6">
                <div class="stat-card" onclick="window.location.href='index.php?controller=adminreport'">
                    <div>
                        <div class="stat-title">DOANH THU THÁNG</div>
                        <h3 class="stat-value"><?= number_format($doanhThu, 0, ',', '.') ?> VNĐ</h3>
                    </div>
                    <div class="icon-box icon-wallet">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="stat-card" onclick="window.location.href='index.php?controller=admintour'">
                    <div>
                        <div class="stat-title">TOUR ĐANG HOẠT ĐỘNG</div>
                        <h3 class="stat-value"><?= $soTour ?> TOUR</h3>
                    </div>
                    <div class="icon-box icon-tour">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="stat-card" onclick="window.location.href='index.php?controller=adminaccount'">
                    <div>
                        <div class="stat-title">TỔNG SỐ TÀI KHOẢN</div>
                        <h3 class="stat-value"><?= $soTaiKhoan ?> TÀI KHOẢN</h3>
                    </div>
                    <div class="icon-box icon-user">
                        <i class="fa-solid fa-user"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="stat-card" onclick="window.location.href='index.php?controller=admintour'">
                    <div>
                        <div class="stat-title">TỔNG SỐ ĐÁNH GIÁ</div>
                        <h3 class="stat-value"><?= $soDanhGia ?> ĐÁNH GIÁ</h3>
                    </div>
                    <div class="icon-box icon-review">
                        <i class="fa-solid fa-comment-dots"></i>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="section-title mt-5">CÁC CHUYẾN ĐI MỚI NHẤT</h2>
        
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Mã Chuyến Đi</th>
                        <th style="text-align: left;">Tên Tour</th>
                        <th>Ngày bắt đầu</th>
                        <th>Số lượng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($chuyenDiMoi)): ?>
                        <?php foreach ($chuyenDiMoi as $cd): ?>
                            <tr>
                                <td><?= htmlspecialchars($cd['MaChuyenDi']) ?></td>
                                <td style="text-align: left; font-weight: 700;"><?= htmlspecialchars($cd['TenTour']) ?></td>
                                <td><?= date('d/m/Y', strtotime($cd['NgayBatDau'])) ?></td>
                                <td><?= $cd['SoLuongKhach'] ?></td>
                                <td><?= number_format($cd['TongTien'], 0, ',', '.') ?> VNĐ</td>
                                <td>
                                    <span class="status-badge" style="<?= ($cd['TrangThai'] == 'Hoàn thành') ? 'background-color: #888;' : '' ?>">
                                        <?= htmlspecialchars($cd['TrangThai']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Chưa có chuyến đi nào gần đây.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <div class="text-end mt-4">
                <a href="index.php?controller=admintrip" class="btn fw-bold" style="background-color: #eaf5eb; color: #00712D; border-radius: 30px; padding: 10px 25px; transition: 0.3s;" onmouseover="this.style.backgroundColor='#d3ebd6'" onmouseout="this.style.backgroundColor='#eaf5eb'">
                    Xem tất cả chuyến đi <i class="fa-solid fa-arrow-right ms-2"></i>
                </a>
            </div>

        </div>

    </div>
</div>