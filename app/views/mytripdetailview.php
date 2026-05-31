<?php 
// Định dạng hiển thị Badge Trạng thái
$statusClass = '';
$statusText = $trip['TrangThai'];
if ($statusText === 'Chưa hoàn thành') {
    $statusClass = 'badge-warning';
} elseif ($statusText === 'Đã hoàn thành') {
    $statusClass = 'badge-success';
} elseif ($statusText === 'Đã hủy') {
    $statusClass = 'badge-danger';
}
?>
<style>
    :root {
        --primary: #1A5336;
        --bg-color: #FDFDF9;
    }
    body { background-color: var(--bg-color); font-family: 'Quicksand', sans-serif; }
    
    /* Breadcrumb */
    .breadcrumb-custom { padding: 15px 40px; font-weight: 600; font-size: 0.95rem; background-color: transparent; width: 100%; }
    .breadcrumb-custom a { color: var(--primary); text-decoration: none; transition: 0.2s;}
    .breadcrumb-custom a:hover { text-decoration: underline; opacity: 0.8; }

    /* Header & Badge */
    .trip-header-box { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px dashed #e2e8f0; padding-bottom: 20px; margin-bottom: 30px; }
    .trip-id { font-size: 1.8rem; font-weight: 800; color: #111; margin: 0; }
    .trip-date { color: #666; font-weight: 600; font-size: 0.95rem; margin-top: 5px; }
    
    .status-badge { padding: 8px 16px; border-radius: 30px; font-weight: 700; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 8px; }
    .badge-warning { background-color: #FEF3C7; color: #D97706; border: 1px solid #FDE68A; }
    .badge-success { background-color: #D1FAE5; color: #059669; border: 1px solid #A7F3D0; }
    .badge-danger { background-color: #FEE2E2; color: #DC2626; border: 1px solid #FECACA; }

    /* Cards */
    .detail-card { background: #fff; border-radius: 20px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #f0f0f0; margin-bottom: 25px; }
    .card-title-custom { font-weight: 800; color: #111; font-size: 1.25rem; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;}
    
    /* Tour Info Horizontal */
    .tour-hz-box { display: flex; gap: 25px; align-items: flex-start; margin-bottom: 25px;}
    .tour-hz-img { width: 160px; height: 160px; object-fit: cover; border-radius: 16px; border: 1px solid #eee;}
    .tour-hz-info h4 { font-weight: 800; color: var(--primary); font-size: 1.25rem; margin-bottom: 12px; line-height: 1.4; }
    .tour-hz-meta { display: flex; align-items: flex-start; gap: 10px; color: #555; font-weight: 600; font-size: 0.95rem; margin-bottom: 8px;}
    .tour-hz-meta i { color: #F29A2E; margin-top: 3px;}

    /* Info Rows */
    .info-grid { display: flex; flex-direction: column; gap: 15px; }
    .info-row { display: flex; justify-content: space-between; align-items: center; font-size: 1rem; border-bottom: 1px dashed #f1f5f9; padding-bottom: 10px; }
    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .info-label { color: #64748b; font-weight: 600; min-width: 140px;}
    .info-value { color: #1e293b; font-weight: 700; text-align: right; }
    .total-highlight { font-size: 1.5rem; color: #e74c3c; font-weight: 900; }

    /* Cancellation Box */
    .cancel-box { background-color: #FEF2F2; border: 1px solid #FECACA; border-radius: 16px; padding: 20px; margin-bottom: 25px; }
    .cancel-box h5 { color: #DC2626; font-weight: 800; font-size: 1.1rem; margin-bottom: 15px; display: flex; align-items: center; gap: 8px;}

    /* Action Buttons */
    .btn-action-outline { border: 2px solid #DC2626; color: #DC2626; background: transparent; padding: 14px 30px; border-radius: 12px; font-weight: 800; font-size: 1.05rem; transition: 0.3s; width: 100%; text-transform: uppercase; }
    .btn-action-outline:hover { background: #DC2626; color: #fff; }
    .btn-action-fill { background: var(--primary); color: #fff; border: none; padding: 14px 30px; border-radius: 12px; font-weight: 800; font-size: 1.05rem; transition: 0.3s; width: 100%; text-transform: uppercase; box-shadow: 0 4px 15px rgba(26, 83, 54, 0.2); }
    .btn-action-fill:hover { background: #123C27; color: #fff; transform: translateY(-2px); }
    
    .btn-print { background: #fff; border: 2px solid #cbd5e1; color: #475569; padding: 14px 30px; border-radius: 12px; font-weight: 800; font-size: 1.05rem; transition: 0.3s; width: 100%; text-transform: uppercase; margin-top: 10px;}
    .btn-print:hover { background: #f1f5f9; color: #1e293b; border-color: #94a3b8; }

    /* =========================================
       CSS CHUYÊN DỤNG KHI IN HÓA ĐƠN (PRINT)
       Ép toàn bộ nội dung nằm vừa vặn trên 1 trang
       ========================================= */
    @media print {
        body { background-color: #fff !important; margin: 0; padding: 0; font-size: 12px !important; }
        header, footer, .breadcrumb-custom, .btn-print, .btn-action-fill, .btn-action-outline { display: none !important; }
        
        @page { size: A4 portrait; margin: 1cm; }
        .container { max-width: 100% !important; width: 100% !important; margin: 0 !important; padding: 0 !important; }
        
        .row { display: flex !important; flex-wrap: nowrap !important; flex-direction: row !important; }
        .col-lg-7 { width: 55% !important; padding-right: 15px !important; }
        .col-lg-5 { width: 45% !important; padding-left: 15px !important; }
        
        /* Thu gọn tối đa các Card */
        .detail-card, .cancel-box { 
            box-shadow: none !important; 
            border: 1px solid #ddd !important; 
            padding: 10px 15px !important; 
            margin-bottom: 10px !important; 
            border-radius: 8px !important;
            page-break-inside: avoid !important;
        }
        
        .trip-header-box { border-bottom: 2px solid #000; padding-bottom: 5px; margin-bottom: 10px; flex-direction: row !important; align-items: center !important;}
        .trip-id { font-size: 1.3rem !important; margin: 0 !important; }
        .trip-date { font-size: 0.85rem !important; margin-top: 2px !important; }
        
        .tour-hz-box { margin-bottom: 10px !important; gap: 10px !important; }
        .tour-hz-img { width: 70px !important; height: 70px !important; border-radius: 8px !important; }
        .tour-hz-info h4 { font-size: 1.1rem !important; margin-bottom: 4px !important; }
        .tour-hz-meta { margin-bottom: 2px !important; font-size: 0.85rem !important; }
        
        .card-title-custom { margin-bottom: 10px !important; padding-bottom: 5px !important; font-size: 1rem !important;}
        .info-grid { gap: 5px !important; }
        .info-row { padding-bottom: 3px !important; margin-bottom: 4px !important; font-size: 0.85rem !important; border-bottom: 1px dashed #eee !important; }
        .total-highlight { font-size: 1.2rem !important; }
        
        .status-badge { border: 1px solid #000 !important; color: #000 !important; background: transparent !important; padding: 4px 10px !important; font-size: 0.85rem !important; }
    }

    @media (max-width: 768px) {
        .trip-header-box { flex-direction: column; align-items: flex-start; gap: 15px; }
        .tour-hz-box { flex-direction: column; align-items: flex-start; gap: 15px;}
        .tour-hz-img { width: 100%; height: 200px; }
        .info-row { flex-direction: column; align-items: flex-start; gap: 5px; }
        .info-value { text-align: left; }
    }
</style>

<div class="breadcrumb-custom">
    <a href="?controller=home">Trang chủ</a> &nbsp;>&nbsp; 
    <a href="?controller=mytrip">Chuyến đi của tôi</a> &nbsp;>&nbsp; 
    <span style="color: #666;">Chi tiết chuyến đi</span>
</div>

<div class="container" style="max-width: 1100px; padding-bottom: 80px;">

    <!-- HEADER: ID, NGÀY ĐẶT, STATUS -->
    <div class="trip-header-box">
        <div>
            <h1 class="trip-id">Mã chuyến đi: <?= htmlspecialchars($trip['MaChuyenDi']) ?></h1>
            <div class="trip-date">Ngày đặt: <?= !empty($trip['NgayGiaoDich']) ? date('d/m/Y - H:i', strtotime($trip['NgayGiaoDich'])) : 'N/A' ?></div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="status-badge <?= $statusClass ?>">
                <i class="fa-solid <?= $statusText === 'Chưa hoàn thành' ? 'fa-clock' : ($statusText === 'Đã hoàn thành' ? 'fa-circle-check' : 'fa-circle-xmark') ?>"></i>
                <?= htmlspecialchars($statusText) ?>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- CỘT TRÁI: THÔNG TIN TOUR & KHÁCH HÀNG -->
        <div class="col-lg-7">
            
            <!-- KHỐI 1: THÔNG TIN HÀNH TRÌNH -->
            <div class="detail-card">
                <h3 class="card-title-custom"><i class="fa-solid fa-map-location-dot" style="color: var(--primary);"></i> Thông tin hành trình</h3>
                
                <div class="tour-hz-box">
                    <img src="<?= htmlspecialchars($trip['HinhAnh']) ?>" class="tour-hz-img" alt="Tour Image">
                    <div class="tour-hz-info">
                        <h4><?= htmlspecialchars($trip['TenTour']) ?></h4>
                        <div class="tour-hz-meta">
                            <i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($trip['DiaDiem']) ?>
                        </div>
                        
                        <div class="tour-hz-meta">
                            <i class="fa-regular fa-clock"></i> Thời gian: <?= $trip['SoNgay'] ?> ngày
                        </div>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">Ngày khởi hành</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($trip['NgayBatDau'])) ?> <span class="text-muted fw-normal">lúc 07:00</span></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Ngày kết thúc</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($trip['NgayKetThuc'])) ?> <span class="text-muted fw-normal">lúc 17:00</span></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Số lượng khách</span>
                        <span class="info-value text-primary"><?= $trip['SoLuongKhach'] ?> hành khách</span>
                    </div>
                </div>
            </div>

            <!-- KHỐI 2: THÔNG TIN LIÊN HỆ KHÁCH HÀNG -->
            <div class="detail-card">
                <h3 class="card-title-custom"><i class="fa-solid fa-address-card" style="color: var(--primary);"></i> Thông tin người đặt</h3>
                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">Họ và tên</span>
                        <span class="info-value"><?= htmlspecialchars($trip['HoTen']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Số điện thoại</span>
                        <span class="info-value"><?= htmlspecialchars($trip['SDT']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email</span>
                        <span class="info-value"><?= htmlspecialchars($trip['Gmail']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Địa chỉ</span>
                        <span class="info-value"><?= !empty($trip['DiaChi']) ? htmlspecialchars($trip['DiaChi']) : 'Chưa cập nhật' ?></span>
                    </div>
                </div>
            </div>

        </div>

        <!-- CỘT PHẢI: THANH TOÁN & NÚT ACTION -->
        <div class="col-lg-5">
            
            <!-- NẾU ĐÃ HỦY: HIỆN THÔNG TIN HOÀN TIỀN CỰC CHI TIẾT -->
            <?php if ($trip['TrangThai'] === 'Đã hủy'): ?>
                <div class="cancel-box">
                    <h5><i class="fa-solid fa-triangle-exclamation"></i> Chi tiết hủy chuyến</h5>
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label" style="color: #b91c1c;">Thời gian hủy</span>
                            <span class="info-value">
                                <?= !empty($trip['NgayYeuCau']) ? date('d/m/Y H:i', strtotime($trip['NgayYeuCau'])) : (!empty($trip['NgayHoanTat']) ? date('d/m/Y H:i', strtotime($trip['NgayHoanTat'])) : 'Đang xử lý') ?>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label" style="color: #b91c1c;">Lý do hủy</span>
                            <span class="info-value text-danger"><?= htmlspecialchars($trip['LyDoHuy'] ?? 'Không xác định') ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label" style="color: #b91c1c;">Trạng thái xử lý</span>
                            <span class="info-value"><?= htmlspecialchars($trip['TrangThaiHuy'] ?? 'Đã xử lý') ?></span>
                        </div>
                        <?php if (isset($trip['TyLeHoanTien'])): ?>
                            <div class="info-row mt-2 pt-2" style="border-top: 1px dashed #FECACA;">
                                <span class="info-label" style="color: #b91c1c;">% số tiền hoàn</span>
                                <span class="info-value"><?= ($trip['TyLeHoanTien'] * 100) ?>%</span>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($trip['SoTienHoan'])): ?>
                            <div class="info-row">
                                <span class="info-label" style="color: #b91c1c;">Số tiền được hoàn</span>
                                <span class="info-value" style="color: #DC2626; font-size: 1.1rem;"><?= number_format($trip['SoTienHoan'], 0, ',', '.') ?> đ</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- KHỐI 3: CHI TIẾT THANH TOÁN -->
            <div class="detail-card">
                <h3 class="card-title-custom"><i class="fa-solid fa-file-invoice-dollar" style="color: var(--primary);"></i> Chi tiết thanh toán</h3>
                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">Phương thức</span>
                        <span class="info-value"><?= htmlspecialchars($trip['PhuongThuc'] ?? 'Chưa rõ') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Ngày giao dịch</span>
                        <span class="info-value"><?= !empty($trip['NgayGiaoDich']) ? date('d/m/Y H:i', strtotime($trip['NgayGiaoDich'])) : 'N/A' ?></span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Mã giao dịch</span>
                        <span class="info-value"><?= htmlspecialchars($trip['MaGiaoDich'] ?? 'N/A') ?></span>
                    </div>
                    
                    <div class="info-row mt-3 pt-3" style="border-top: 2px dashed #cbd5e1;">
                        <span class="info-label" style="font-size: 1.1rem; color: #111;">Tổng tiền</span>
                        <span class="total-highlight"><?= number_format($trip['TongGiaTien'], 0, ',', '.') ?> đ</span>
                    </div>
                </div>
            </div>

            <!-- KHỐI 4: CÁC NÚT HÀNH ĐỘNG -->
            <div class="d-flex flex-column gap-2 mt-3">
                <?php if ($trip['TrangThai'] === 'Chưa hoàn thành'): ?>
                    <button type="button" class="btn-action-outline" onclick="alert('Tính năng yêu cầu hủy chuyến đang được cập nhật!');">
                        Yêu cầu hủy chuyến
                    </button>
                    <button class="btn-print" onclick="window.print()"><i class="fa-solid fa-print me-2"></i> In hóa đơn</button>
                
                <?php elseif ($trip['TrangThai'] === 'Đã hoàn thành'): ?>
                    <a href="index.php?controller=review&action=create&id=<?= $trip['MaChuyenDi'] ?>" class="btn-action-fill text-center text-decoration-none">
                        <i class="fa-solid fa-pen-nib me-2"></i> Đánh giá chuyến đi
                    </a>
                    <button class="btn-print" onclick="window.print()"><i class="fa-solid fa-print me-2"></i> In hóa đơn</button>
                
                <?php endif; ?>
                <!-- Đã xóa nút in hóa đơn ở trạng thái 'Đã hủy' -->
            </div>

        </div>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>