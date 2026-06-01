<?php 
// Định dạng hiển thị Badge Trạng thái
$statusClass = '';
$statusText = $trip['TrangThai'];
if ($statusText === 'Chưa hoàn thành') {
    if (!empty($trip['TrangThaiHuy']) && $trip['TrangThaiHuy'] === 'Chưa xử lý') {
        $statusText = 'Đang chờ duyệt hủy';
        $statusClass = 'badge-warning';
    } else {
        $statusClass = 'badge-warning';
    }
} elseif ($statusText === 'Đã hoàn thành') {
    $statusClass = 'badge-success';
} elseif ($statusText === 'Đã hủy') {
    $statusClass = 'badge-danger';
}
?>
<style>
    :root { --primary: #1A5336; --bg-color: #FDFDF9; }
    body { background-color: var(--bg-color); font-family: 'Quicksand', sans-serif; }

    .trip-header-box { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px dashed #e2e8f0; padding-bottom: 20px; margin-bottom: 30px; }
    .trip-id { font-size: 1.8rem; font-weight: 800; color: #111; margin: 0; }
    .trip-date { color: #666; font-weight: 600; font-size: 0.95rem; margin-top: 5px; }
    
    .status-badge { padding: 8px 16px; border-radius: 30px; font-weight: 700; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 8px; }
    .badge-warning { background-color: #FEF3C7; color: #D97706; border: 1px solid #FDE68A; }
    .badge-success { background-color: #D1FAE5; color: #059669; border: 1px solid #A7F3D0; }
    .badge-danger { background-color: #FEE2E2; color: #DC2626; border: 1px solid #FECACA; }

    .detail-card { background: #fff; border-radius: 20px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #f0f0f0; margin-bottom: 25px; }
    .card-title-custom { font-weight: 800; color: #111; font-size: 1.25rem; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px;}
    
    .tour-hz-box { display: flex; gap: 25px; align-items: flex-start; margin-bottom: 25px;}
    .tour-hz-img { width: 160px; height: 160px; object-fit: cover; border-radius: 16px; border: 1px solid #eee;}
    .tour-hz-info h4 { font-weight: 800; color: var(--primary); font-size: 1.25rem; margin-bottom: 12px; line-height: 1.4; }
    .tour-hz-meta { display: flex; align-items: flex-start; gap: 10px; color: #555; font-weight: 600; font-size: 0.95rem; margin-bottom: 8px;}
    .tour-hz-meta i { color: #F29A2E; margin-top: 3px;}

    .info-grid { display: flex; flex-direction: column; gap: 15px; }
    .info-row { display: flex; justify-content: space-between; align-items: center; font-size: 1rem; border-bottom: 1px dashed #f1f5f9; padding-bottom: 10px; }
    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .info-label { color: #64748b; font-weight: 600; min-width: 140px;}
    .info-value { color: #1e293b; font-weight: 700; text-align: right; }
    .total-highlight { font-size: 1.5rem; color: #e74c3c; font-weight: 900; }

    .cancel-box { background-color: #FEF2F2; border: 1px solid #FECACA; border-radius: 16px; padding: 20px; margin-bottom: 25px; }
    .cancel-box h5 { color: #DC2626; font-weight: 800; font-size: 1.1rem; margin-bottom: 15px; display: flex; align-items: center; gap: 8px;}

    .btn-action-outline { border: 2px solid #DC2626; color: #DC2626; background: transparent; padding: 14px 30px; border-radius: 12px; font-weight: 800; font-size: 1.05rem; transition: 0.3s; width: 100%; text-transform: uppercase; text-align: center; text-decoration: none; display: block; box-sizing: border-box;}
    .btn-action-outline:hover { background: #DC2626; color: #fff; }
    
    .btn-action-fill { background: var(--primary); color: #fff; border: none; padding: 14px 30px; border-radius: 12px; font-weight: 800; font-size: 1.05rem; transition: 0.3s; width: 100%; text-transform: uppercase; box-shadow: 0 4px 15px rgba(26, 83, 54, 0.2); text-align: center; text-decoration: none; display: block; box-sizing: border-box;}
    .btn-action-fill:hover { background: #123C27; color: #fff; transform: translateY(-2px); }
    
    .btn-print { background: #fff; border: 2px solid #cbd5e1; color: #475569; padding: 14px 30px; border-radius: 12px; font-weight: 800; font-size: 1.05rem; transition: 0.3s; width: 100%; text-transform: uppercase; display: block; box-sizing: border-box;}
    .btn-print:hover { background: #f1f5f9; color: #1e293b; border-color: #94a3b8; }

    @media print {
        body { background-color: #fff !important; margin: 0; padding: 0; font-size: 12px !important; }
        header, footer, .breadcrumb-custom, .btn-print, .btn-action-fill, .btn-action-outline { display: none !important; }
        
        @page { size: A4 portrait; margin: 1cm; }
        .container { max-width: 100% !important; width: 100% !important; margin: 0 !important; padding: 0 !important; }
        .row { display: flex !important; flex-wrap: nowrap !important; flex-direction: row !important; }
        .col-lg-7 { width: 55% !important; padding-right: 15px !important; }
        .col-lg-5 { width: 45% !important; padding-left: 15px !important; }
        
        .detail-card, .cancel-box { box-shadow: none !important; border: 1px solid #ddd !important; padding: 10px 15px !important; margin-bottom: 10px !important; border-radius: 8px !important; page-break-inside: avoid !important; }
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
    <a href="index.php?controller=home"><i class="fa-solid fa-house me-1"></i>Trang chủ</a> 
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <a href="index.php?controller=mytrip">Chuyến đi của tôi</a> 
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <span class="text-dark fw-bold">Chi tiết chuyến đi</span>
</div>

<div class="container" style="max-width: 1100px; padding-bottom: 80px;">

    <div class="trip-header-box">
        <div>
            <h1 class="trip-id">Mã chuyến đi: <?= htmlspecialchars($trip['MaChuyenDi']) ?></h1>
            <div class="trip-date">Ngày đặt: <?= !empty($trip['NgayGiaoDich']) ? date('d/m/Y - H:i', strtotime($trip['NgayGiaoDich'])) : 'N/A' ?></div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="status-badge <?= $statusClass ?>">
                <i class="fa-solid <?= $statusText === 'Chưa hoàn thành' || $statusText === 'Đang chờ duyệt hủy' ? 'fa-clock' : ($statusText === 'Đã hoàn thành' ? 'fa-circle-check' : 'fa-circle-xmark') ?>"></i>
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
                            <i class="fa-regular fa-clock"></i> Thời gian: <?= $trip['SoNgay'] ?> ngày
                        </div>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">Ngày khởi hành</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($trip['NgayBatDau'])) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Ngày kết thúc</span>
                        <span class="info-value"><?= date('d/m/Y', strtotime($trip['NgayKetThuc'])) ?></span>
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

            <!-- BẮT ĐẦU: BOX THÔNG TIN THEO DÕI HỦY TOUR -->
            <?php if (!empty($trip['TrangThaiHuy'])): ?>
                <?php 
                    $isPending = ($trip['TrangThaiHuy'] === 'Chưa xử lý');
                    $boxBorder = $isPending ? '#FDE68A' : '#FCA5A5';
                    $boxBg = $isPending ? '#FFFBEB' : '#FEF2F2';
                    $titleColor = $isPending ? 'text-warning' : 'text-danger';
                ?>
                
                <div class="mt-4 p-4 rounded-4" style="border: 2px solid <?= $boxBorder ?>; background-color: <?= $boxBg ?>;">
                    <h5 class="fw-bold <?= $titleColor ?> mb-3">
                        <i class="fa-solid fa-file-invoice-dollar me-2"></i> THÔNG TIN YÊU CẦU HỦY TOUR
                    </h5>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex flex-column gap-2">
                                <div>
                                    <span class="text-muted fw-bold small text-uppercase">Trạng thái:</span><br>
                                    <?php if($isPending): ?>
                                        <span class="badge bg-warning text-dark px-3 py-2 mt-1 rounded-pill"><i class="fa-solid fa-hourglass-half me-1"></i> Đang chờ xét duyệt</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger px-3 py-2 mt-1 rounded-pill"><i class="fa-solid fa-check-double me-1"></i> Đã hủy thành công</span>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <span class="text-muted fw-bold small text-uppercase">Ngày gửi yêu cầu:</span><br>
                                    <span class="fw-bold text-dark"><?= !empty($trip['NgayYeuCau']) ? date('d/m/Y - H:i', strtotime($trip['NgayYeuCau'])) : 'N/A' ?></span>
                                </div>
                                <?php if(!$isPending && !empty($trip['NgayHoanTat'])): ?>
                                    <div>
                                        <span class="text-muted fw-bold small text-uppercase">Ngày duyệt:</span><br>
                                        <span class="fw-bold text-dark"><?= date('d/m/Y - H:i', strtotime($trip['NgayHoanTat'])) ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="bg-white p-3 rounded-3 border" style="box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                                <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                    <span class="text-muted fw-bold">Tỷ lệ hoàn:</span>
                                    <span class="fw-bold text-dark"><?= floatval($trip['TyLeHoanTien'] ?? 0) * 100 ?>%</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted fw-bold">Số tiền hoàn lại:</span>
                                    <span class="fw-bold fs-4" style="color: #1A5336;"><?= number_format($trip['SoTienHoan'] ?? 0, 0, ',', '.') ?> VNĐ</span>
                                </div>
                            </div>
                            <div class="mt-2 text-muted small">
                                <strong>Lý do:</strong> <?= htmlspecialchars($trip['LyDoHuy'] ?? 'Không có lý do') ?>
                            </div>
                        </div>
                    </div>

                    <!-- Thông báo tình trạng tiền -->
                    <?php if($isPending): ?>
                        <div class="alert alert-warning mt-3 mb-0 border-0 shadow-sm d-flex align-items-center" style="background-color: rgba(255,193,7,0.15);">
                            <i class="fa-solid fa-circle-notch fa-spin fs-4 text-warning me-3"></i>
                            <div>Yêu cầu của bạn đang được xử lý. Hệ thống sẽ phản hồi tối đa trong vòng 24h.</div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-success mt-3 mb-0 border-0 shadow-sm d-flex align-items-center" style="background-color: #D1E7DD; color: #0F5132;">
                            <i class="fa-solid fa-shield-check fs-4 text-success me-3"></i>
                            <div>
                                <strong>Đã phê duyệt!</strong> Tiền hoàn sẽ được chuyển về tài khoản thanh toán ban đầu của bạn trong vòng 3-5 ngày làm việc.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <!-- KẾT THÚC: BOX THÔNG TIN THEO DÕI HỦY TOUR -->
        </div>

        <div class="col-lg-5">
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

            <div class="d-flex flex-column gap-3 mt-2">
                <?php if ($trip['TrangThai'] === 'Chưa hoàn thành'): ?>
                    <?php if (empty($trip['TrangThaiHuy'])): ?>
                        <a href="index.php?controller=canceltrip&id=<?= $trip['MaChuyenDi'] ?>" class="btn-action-outline">
                            Yêu cầu hủy chuyến
                        </a>
                    <?php endif; ?>
                    <button class="btn-print" onclick="window.print()"><i class="fa-solid fa-print me-2"></i> In hóa đơn</button>
                
                <?php elseif ($trip['TrangThai'] === 'Đã hoàn thành'): ?>
                    <a href="index.php?controller=review&action=create&id=<?= $trip['MaChuyenDi'] ?>" class="btn-action-fill">
                        <i class="fa-solid fa-pen-nib me-2"></i> Đánh giá chuyến đi
                    </a>
                    <button class="btn-print" onclick="window.print()"><i class="fa-solid fa-print me-2"></i> In hóa đơn</button>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?php include 'app/views/layouts/footer.php'; ?>