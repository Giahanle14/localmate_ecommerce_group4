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

    .btn-print { background: #fff; border: 2px solid #cbd5e1; color: #475569; padding: 8px 18px; border-radius: 8px; font-weight: 700; transition: 0.3s; }
    .btn-print:hover { background: #f1f5f9; color: #1e293b; border-color: #94a3b8; }

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

    /* =========================================
       CSS CHUYÊN DỤNG KHI IN HÓA ĐƠN (PRINT)
       ========================================= */
    @media print {
        body { background-color: #fff !important; margin: 0; padding: 0; }
        header, footer, .breadcrumb-custom, .btn-print, .btn-action-fill, .btn-action-outline { display: none !important; }
        .container { max-width: 100% !important; padding: 0 !important; margin: 0 !important; }
        .detail-card { box-shadow: none !important; border: 1px solid #ccc !important; padding: 20px !important; margin-bottom: 20px !important; break-inside: avoid; }
        .trip-header-box { border-bottom: 2px solid #000; padding-bottom: 10px; }
        .badge-warning, .badge-success, .badge-danger { border: 1px solid #000 !important; color: #000 !important; background: transparent !important; }
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

    <div class="trip-header-box">
        <div>
            <h1 class="trip-id">Mã chuyến đi: <?= htmlspecialchars($trip['MaChuyenDi']) ?></h1>
            <div class="trip-date">Ngày đặt: <?= !empty($trip['NgayGiaoDich']) ? date('d/m/Y - H:i', strtotime($trip['NgayGiaoDich'])) : 'N/A' ?></div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <button class="btn-print" onclick="window.print()"><i class="fa-solid fa-print me-2"></i> In hóa đơn</button>
            <div class="status-badge <?= $statusClass ?>">
                <i class="fa-solid <?= $statusText === 'Chưa hoàn thành' ? 'fa-clock' : ($statusText === 'Đã hoàn thành' ? 'fa-circle-check' : 'fa-circle-xmark') ?>"></i>
                <?= htmlspecialchars($statusText) ?>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            
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
                            <i class="fa-solid fa-fingerprint"></i> Mã Tour: <?= htmlspecialchars($trip['MaTour']) ?>
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

        <div class="col-lg-5">
            
            <?php if ($trip['TrangThai'] === 'Đã hủy' && !empty($trip['LyDoHuy'])): ?>
                <div class="cancel-box">
                    <h5><i class="fa-solid fa-triangle-exclamation"></i> Chi tiết hủy chuyến</h5>
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label" style="color: #b91c1c;">Lý do hủy</span>
                            <span class="info-value text-danger"><?= htmlspecialchars($trip['LyDoHuy']) ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label" style="color: #b91c1c;">Trạng thái xử lý</span>
                            <span class="info-value"><?= htmlspecialchars($trip['TrangThaiHuy']) ?></span>
                        </div>
                        <?php if (!empty($trip['SoTienHoan'])): ?>
                            <div class="info-row mt-2 pt-2" style="border-top: 1px dashed #FECACA;">
                                <span class="info-label" style="color: #b91c1c;">Tỷ lệ hoàn tiền</span>
                                <span class="info-value"><?= ($trip['TyLeHoanTien'] * 100) ?>%</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label" style="color: #b91c1c;">Số tiền hoàn lại</span>
                                <span class="info-value" style="color: #DC2626; font-size: 1.1rem;"><?= number_format($trip['SoTienHoan'], 0, ',', '.') ?> đ</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="detail-card">
                <h3 class="card-title-custom"><i class="fa-solid fa-file-invoice-dollar" style="color: var(--primary);"></i> Chi tiết thanh toán</h3>
                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">Trạng thái</span>
                        <span class="info-value text-success"><?= htmlspecialchars($trip['TrangThaiGD'] ?? 'Thành công') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Phương thức</span>
                        <span class="info-value"><?= htmlspecialchars($trip['PhuongThuc'] ?? 'Chưa rõ') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Ngày giao dịch</span>
                        <span class="info-value"><?= !empty($trip['NgayGiaoDich']) ? date('d/m/Y H:i', strtotime($trip['NgayGiaoDich'])) : 'N/A' ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Mã tham chiếu</span>
                        <span class="info-value"><?= htmlspecialchars($trip['MaGiaoDichDoiTac'] ?? 'N/A') ?></span>
                    </div>
                    <div class="info-row mt-3 pt-3" style="border-top: 2px dashed #cbd5e1;">
                        <span class="info-label" style="font-size: 1.1rem; color: #111;">Tổng tiền</span>
                        <span class="total-highlight"><?= number_format($trip['TongGiaTien'], 0, ',', '.') ?> đ</span>
                    </div>
                </div>
            </div>

            <?php if ($trip['TrangThai'] === 'Chưa hoàn thành'): ?>
                <button type="button" class="btn-action-outline mt-2" onclick="alert('Tính năng yêu cầu hủy chuyến đang được cập nhật!');">
                    Yêu cầu hủy chuyến
                </button>
            <?php elseif ($trip['TrangThai'] === 'Đã hoàn thành'): ?>
                <a href="index.php?controller=review&action=create&id=<?= $trip['MaChuyenDi'] ?>" class="btn-action-fill text-center mt-2 d-block text-decoration-none">
                    <i class="fa-solid fa-pen-nib me-2"></i> Đánh giá chuyến đi
                </a>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>