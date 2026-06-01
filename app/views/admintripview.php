<?php require_once 'app/views/layouts/header.php'; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/vn.js"></script>

<style>
    body { background-color: #F8FAF5; font-family: 'Quicksand', sans-serif; }
    .admin-container { max-width: 1300px; margin: 20px auto 40px; padding: 0 20px; }
    /* =========================================================
       CSS DANH SÁCH & BỘ LỌC
       ========================================================= */
    .trip-tabs { display: flex; gap: 15px; margin-bottom: 25px; flex-wrap: wrap; }
    .trip-tab-btn { background-color: #EAF9DE; color: #0d5c2c; border: none; border-radius: 30px; padding: 10px 20px; font-weight: 700; font-size: 15px; display: flex; align-items: center; gap: 8px; text-decoration: none; transition: 0.3s; }
    .trip-tab-btn:hover { background-color: #d8f2c3; }
    .trip-tab-btn.active { background-color: #0d5c2c; color: white; }
    .tab-badge { background: white; color: #0d5c2c; border-radius: 20px; padding: 2px 10px; font-size: 13px; font-weight: 800; }
    .trip-tab-btn.active .tab-badge { background: rgba(255,255,255,0.2); color: white; }
    .tab-badge-danger { background: #DC3545 !important; color: white !important; }

    .filter-section { display: flex; gap: 15px; margin-bottom: 30px; }
    .search-box { position: relative; width: 300px; }
    .search-box i { position: absolute; top: 50%; left: 15px; transform: translateY(-50%); color: #0d5c2c; font-size: 16px; }
    .search-box input { width: 100%; border: 1px solid #0d5c2c; border-radius: 8px; padding: 10px 15px 10px 40px; font-weight: 500; outline: none; background: white;}
    
    .date-box { position: relative; width: 250px; }
    .date-box i { position: absolute; top: 50%; right: 15px; transform: translateY(-50%); color: #0d5c2c; font-size: 18px; pointer-events: none; }
    .date-box input { width: 100%; border: 1px solid #666; border-radius: 8px; padding: 10px 40px 10px 15px; font-weight: 500; outline: none; background: white;}

    .table-container { background: white; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); overflow: hidden; border: 1px solid #f0f0f0; }
    .table { margin-bottom: 0; }
    .table thead { background-color: #EAF9DE; }
    .table th { color: #0d5c2c; font-weight: 700; border-bottom: none; padding: 18px 15px; font-size: 15px; }
    .table td { padding: 18px 15px; vertical-align: middle; border-bottom: 1px solid #f5f5f5; color: #0d5c2c; font-weight: 600; font-size: 14px; }
    
    .status-badge { padding: 6px 15px; border-radius: 20px; font-weight: 700; font-size: 13px; display: inline-block; white-space: nowrap; }
    .st-pending { background-color: #FFEAB6; color: #D38000; }
    .st-completed { background-color: #D6E8D8; color: #0d5c2c; }
    .st-canceled { background-color: #E2E2E2; color: #666; }
    
    .action-btns { display: flex; gap: 8px; }
    .btn-icon { width: 32px; height: 32px; border-radius: 50%; display: flex; justify-content: center; align-items: center; border: none; transition: 0.2s; text-decoration: none; background: transparent; cursor: pointer;}
    .btn-view { background-color: #EAF9DE; color: #0d5c2c; }
    .btn-view:hover { background-color: #0d5c2c; color: white; }
    
    .btn-alert { background-color: #F8D7DA; color: #DC3545; animation: pulse-danger 1.5s infinite; }
    .btn-alert:hover { background-color: #DC3545; color: white; }
    @keyframes pulse-danger {
        0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.6); }
        70% { box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }

    .pagination-wrapper { display: flex; justify-content: space-between; align-items: center; padding: 20px; background: #fafafa; border-top: 1px solid #eee; }
    .page-info { color: #777; font-size: 13px; }
    .pagination { margin: 0; gap: 5px; }
    .page-link { border-radius: 6px !important; border: 1px solid #0d5c2c; color: #0d5c2c; font-weight: 600; padding: 6px 12px; margin: 0 2px;}
    .page-link:hover { background: #EAF9DE; color: #0d5c2c; }
    .page-item.active .page-link { background: #0d5c2c; color: white; border-color: #0d5c2c; }

    /* =========================================================
       CSS GIAO DIỆN XEM CHI TIẾT
       ========================================================= */
    .detail-card { background: white; border-radius: 16px; border: 1px solid #f0f0f0; box-shadow: 0 4px 15px rgba(0,0,0,0.03); padding: 30px; margin-bottom: 20px;}
    .detail-title { color: #0d5c2c; font-weight: 800; font-size: 20px; margin-bottom: 25px; border-bottom: 2px dashed #eee; padding-bottom: 15px;}
    
    .user-avatar-lg { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 12px; }
    
    .info-group { margin-bottom: 20px; }
    .info-label { font-size: 12px; color: #888; font-weight: 700; text-transform: uppercase; margin-bottom: 5px; }
    .info-value { font-size: 16px; color: #333; font-weight: 600; }
    
    .tour-cover-img { width: 100%; height: 230px; object-fit: cover; border-radius: 12px; margin-bottom: 20px;}

    /* =========================================================
       RESPONSIVE CHO TRANG QUẢN LÝ CHUYẾN ĐI (MOBILE & TABLET)
       ========================================================= */
    @media (max-width: 768px) {
        .trip-tabs { gap: 10px; }
        .trip-tab-btn { font-size: 13px; padding: 8px 12px; flex: 1 1 calc(50% - 10px); justify-content: center; }

        .filter-section { flex-direction: column; gap: 12px; margin-bottom: 20px; }
        .search-box, .date-box { width: 100% !important; }

        .table-responsive::-webkit-scrollbar { height: 6px; }
        .table-responsive::-webkit-scrollbar-thumb { background-color: #8A9D8E; border-radius: 10px; }
        .table-responsive::-webkit-scrollbar-track { background: #EAF9DE; border-radius: 10px; }

        .pagination-wrapper { flex-direction: column; gap: 15px; text-align: center; }
        .page-info { font-size: 12px; }
        
        .admin-container { padding: 0 10px; }
    }
</style>

<div class="breadcrumb-custom">
    <a href="index.php?controller=adminhome"><i class="fa-solid fa-house me-1"></i>Tổng quan</a> 
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <a href="index.php?controller=admintrip">Quản lý chuyến đi</a>
    
    <?php if ($viewMode === 'detail'): ?>
        <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
        <span class="text-dark fw-bold"><?= htmlspecialchars($tripData['MaChuyenDi']) ?></span>
    <?php endif; ?>
</div>

<div class="admin-container">

<?php if ($viewMode === 'list'): ?>
    
    <form action="index.php" method="GET" id="filterForm">
        <input type="hidden" name="controller" value="admintrip">
        <input type="hidden" name="tab" id="tabInput" value="<?= $tab ?>">

        <div class="trip-tabs">
            <a href="javascript:void(0)" onclick="changeTab('all')" class="trip-tab-btn <?= $tab == 'all' ? 'active' : '' ?>">
                Tất cả chuyến đi <span class="tab-badge"><?= $stats['all'] ?></span>
            </a>
            <a href="javascript:void(0)" onclick="changeTab('pending')" class="trip-tab-btn <?= $tab == 'pending' ? 'active' : '' ?>">
                Chưa hoàn thành <span class="tab-badge"><?= $stats['pending'] ?></span>
            </a>
            <a href="javascript:void(0)" onclick="changeTab('completed')" class="trip-tab-btn <?= $tab == 'completed' ? 'active' : '' ?>">
                Đã hoàn thành <span class="tab-badge"><?= $stats['completed'] ?></span>
            </a>
            <a href="javascript:void(0)" onclick="changeTab('cancel_req')" class="trip-tab-btn <?= $tab == 'cancel_req' ? 'active' : '' ?>" style="background-color: <?= $tab == 'cancel_req' ? '#0d5c2c' : '#EAF9DE' ?>;">
                Yêu cầu hủy <span class="tab-badge tab-badge-danger"><?= $stats['cancel_req'] ?></span>
            </a>
        </div>

        <div class="filter-section">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" placeholder="Nhập mã chuyến đi, tên..." value="<?= htmlspecialchars($search) ?>" onchange="document.getElementById('filterForm').submit();">
            </div>
            <div class="date-box">
                <input type="text" id="dateRange" name="daterange" placeholder="Nhập khoảng thời gian" value="<?= htmlspecialchars(isset($_GET['daterange']) ? $_GET['daterange'] : '') ?>">
                <i class="fa-regular fa-calendar"></i>
            </div>
        </div>
    </form>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Mã chuyến đi</th>
                        <th>Tên khách hàng</th>
                        <th>Tên Tour</th>
                        <th>Ngày bắt đầu</th>
                        <th>Ngày kết thúc</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($trips) > 0): ?>
                        <?php foreach ($trips as $trip): 
                            $ngayBD = date('d/m/Y', strtotime($trip['NgayBatDau']));
                            $ngayKT = date('d/m/Y', strtotime($trip['NgayKetThuc']));
                            
                            $badgeClass = ''; $statusText = '';
                            
                            date_default_timezone_set('Asia/Ho_Chi_Minh'); 
                            $today = date('Y-m-d');
                            
                            if ($tab === 'cancel_req') {
                                if ($trip['HuyTrangThai'] === 'Chưa xử lý') {
                                    $badgeClass = 'st-pending'; 
                                    $statusText = 'Chưa xử lý';
                                } else {
                                    $badgeClass = 'st-canceled'; 
                                    $statusText = 'Đã xử lý';
                                }
                            } else {
                                if ($trip['TrangThai'] === 'Đã hủy') {
                                    $badgeClass = 'st-canceled'; 
                                    $statusText = 'Đã hủy';
                                } else {
                                    if ($trip['NgayKetThuc'] >= $today) {
                                        $badgeClass = 'st-pending'; 
                                        $statusText = 'Chưa hoàn thành';
                                    } else {
                                        $badgeClass = 'st-completed'; 
                                        $statusText = 'Đã hoàn thành';
                                    }
                                }
                            }
                        ?>
                        <tr>
                            <td><?= $trip['MaChuyenDi'] ?></td>
                            <td><?= htmlspecialchars($trip['HoTen']) ?></td>
                            <td style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= htmlspecialchars($trip['TenTour']) ?>">
                                <?= htmlspecialchars($trip['TenTour']) ?>
                            </td>
                            <td><?= $ngayBD ?></td>
                            <td><?= $ngayKT ?></td>
                            <td>
                                <span class="status-badge <?= $badgeClass ?>"><?= $statusText ?></span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="index.php?controller=admintrip&action=detail&id=<?= $trip['MaChuyenDi'] ?>" class="btn-icon btn-view" title="Xem chi tiết">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    
                                    <?php if ($trip['HuyTrangThai'] === 'Chưa xử lý'): ?>
                                    <button type="button" class="btn-icon btn-alert" title="Duyệt yêu cầu hủy" onclick="confirmCancel('<?= $trip['MaChuyenDi'] ?>')">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Không tìm thấy chuyến đi nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if ($totalPages > 0): ?>
        <div class="pagination-wrapper">
            <?php
                $startItem = ($page - 1) * $limit + 1;
                $endItem = min($page * $limit, $total);
            ?>
            <div class="page-info">
                Hiển thị <?= $startItem ?>-<?= $endItem ?> trong tổng số <?= $total ?> kết quả
            </div>
            <ul class="pagination d-flex flex-wrap justify-content-center">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?controller=admintrip&tab=<?= $tab ?>&search=<?= urlencode($search) ?>&daterange=<?= urlencode($daterange) ?>&page=<?= $page - 1 ?>"><i class="fa-solid fa-chevron-left"></i></a>
                </li>
                
                <?php 
                    $startPage = max(1, $page - 2);
                    $endPage = min($totalPages, $page + 2);

                    if ($page <= 2) {
                        $endPage = min($totalPages, 5);
                    }
                    if ($page >= $totalPages - 1) {
                        $startPage = max(1, $totalPages - 4);
                    }
                ?>
                
                <?php if ($startPage > 1): ?>
                    <li class="page-item disabled"><a class="page-link border-0 bg-transparent text-muted" href="#">...</a></li>
                <?php endif; ?>

                <?php for($i = $startPage; $i <= $endPage; $i++): ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="index.php?controller=admintrip&tab=<?= $tab ?>&search=<?= urlencode($search) ?>&daterange=<?= urlencode($daterange) ?>&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($endPage < $totalPages): ?>
                    <li class="page-item disabled"><a class="page-link border-0 bg-transparent text-muted" href="#">...</a></li>
                <?php endif; ?>

                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?controller=admintrip&tab=<?= $tab ?>&search=<?= urlencode($search) ?>&daterange=<?= urlencode($daterange) ?>&page=<?= $page + 1 ?>"><i class="fa-solid fa-chevron-right"></i></a>
                </li>
            </ul>
        </div>
        <?php endif; ?>
    </div>

<?php elseif ($viewMode === 'detail'): ?>
    
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="detail-card text-center h-100">
                
                <h4 class="detail-title d-flex justify-content-center align-items-center" style="gap: 10px;">
                    <i class="fa-solid fa-user-check"></i> NGƯỜI ĐẶT
                </h4>
                
                <?php 
                    $hoTenURL = urlencode($tripData['HoTen']);
                    $avatar = !empty($tripData['AnhDaiDien']) ? $tripData['AnhDaiDien'] : "https://ui-avatars.com/api/?name={$hoTenURL}&background=EAF9DE&color=0d5c2c&size=150&font-size=0.4&bold=true";
                    if (strpos($avatar, 'public/') !== 0 && strpos($avatar, 'http') === false) { $avatar = 'public/' . $avatar; }
                    
                    $tier = $tripData['HangThanhVien'];
                    $tierColor = '#E8B923';
                    if($tier == 'Bạc') $tierColor = '#A6A9B6';
                    elseif($tier == 'Vàng') $tierColor = '#F2A900';
                    elseif($tier == 'Kim Cương') $tierColor = '#51C4D3';
                ?>
                <div style="background-color: #f7f9f3; border-radius: 50%; width: 110px; height: 110px; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center;">
                    <img src="<?= $avatar ?>" class="user-avatar-lg m-0">
                </div>
                
                <h4 class="fw-bold" style="color: #0d5c2c; margin-bottom: 15px;"><?= htmlspecialchars($tripData['HoTen']) ?></h4>
                
                <div style="margin-bottom: 25px;">
                    <i class="fa-solid fa-medal" style="font-size: 45px; color: <?= $tierColor ?>; margin-bottom: 12px; display: block;"></i>
                    <div style="font-weight: 800; font-size: 18px; text-transform: uppercase; color: <?= $tierColor ?>;">
                        Thành viên <?= mb_strtolower($tier, 'UTF-8') ?>
                    </div>
                </div>

                <div class="text-start mt-2">
                    <div class="info-group">
                        <div class="info-label">Email liên hệ</div>
                        <div class="info-value"><i class="fa-regular fa-envelope me-2 text-success"></i><?= htmlspecialchars($tripData['Gmail']) ?></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Số điện thoại</div>
                        <div class="info-value"><i class="fa-solid fa-phone me-2 text-success"></i><?= htmlspecialchars($tripData['SDT'] ?? 'Chưa cập nhật') ?></div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">SĐT Khẩn cấp</div>
                        <div class="info-value"><i class="fa-solid fa-truck-medical me-2 text-danger"></i><?= htmlspecialchars($tripData['SDTKhanCap'] ?? 'Chưa cập nhật') ?></div>
                    </div>
                    <div class="info-group mb-0">
                        <div class="info-label">Địa chỉ</div>
                        <div class="info-value"><i class="fa-solid fa-location-dot me-2 text-success"></i><?= htmlspecialchars($tripData['DiaChi'] ?? 'Chưa cập nhật') ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="detail-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-2 border-dashed pb-3">
                    <h4 class="detail-title border-0 m-0 p-0"><i class="fa-solid fa-map-location-dot"></i> THÔNG TIN CHUYẾN ĐI</h4>
                    <?php 
                        $statusText = $tripData['TrangThai'];
                        if ($tripData['TrangThai'] !== 'Đã hủy' && $tripData['HuyTrangThai'] === 'Chưa xử lý') $statusText = 'Yêu cầu hủy';
                        
                        $color = ($statusText == 'Đã hoàn thành') ? '#0d5c2c' : (($statusText == 'Đã hủy' || $statusText == 'Yêu cầu hủy') ? '#DC3545' : '#D38000');
                    ?>
                    <h5 class="fw-bold m-0" style="color: <?= $color ?>;">Trạng thái: <?= $statusText ?></h5>
                </div>

                <div class="row">
                    <div class="col-md-5">
                        <img src="<?= strpos($tripData['AnhTour'], 'public/') === 0 ? $tripData['AnhTour'] : 'public/' . $tripData['AnhTour'] ?>" class="tour-cover-img">
                    </div>
                    <div class="col-md-7">
                        <h4 class="fw-bold text-dark mb-4" style="color: #123C27 !important;"><?= htmlspecialchars($tripData['TenTour']) ?></h4>
                        
                        <div class="row mb-3">
                            <div class="col-6 info-group">
                                <div class="info-label">VÙNG MIỀN</div>
                                <div class="info-value" style="font-weight: 500; font-size: 15px;"><?= $tripData['VungDiaLy'] ?></div>
                            </div>
                            <div class="col-6 info-group">
                                <div class="info-label">THỜI LƯỢNG</div>
                                <div class="info-value" style="font-weight: 500; font-size: 15px;"><?= $tripData['SoNgay'] ?> Ngày</div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-6 info-group">
                                <div class="info-label">NGÀY KHỞI HÀNH</div>
                                <div class="info-value" style="color: #0d5c2c; font-weight: 700;"><?= date('d/m/Y', strtotime($tripData['NgayBatDau'])) ?></div>
                            </div>
                            <div class="col-6 info-group">
                                <div class="info-label">NGÀY KẾT THÚC</div>
                                <div class="info-value" style="color: #0d5c2c; font-weight: 700;"><?= date('d/m/Y', strtotime($tripData['NgayKetThuc'])) ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-light rounded-3 p-4 mt-3 border">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold text-muted">Số lượng vé đặt:</span>
                        <span class="fs-5 fw-bold text-dark"><?= $tripData['SoLuongKhach'] ?> Khách</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <span class="fw-bold text-muted">Đơn giá Tour:</span>
                        <span class="fs-6 fw-bold text-dark"><?= number_format($tripData['GiaTour'], 0, ',', '.') ?> VNĐ / khách</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fs-5 fw-bold" style="color: #0d5c2c;">TỔNG THANH TOÁN:</span>
                        <span class="fs-4 fw-bold" style="color: #F29A2E;"><?= number_format($tripData['TongGiaTien'], 0, ',', '.') ?> VNĐ</span>
                    </div>
                </div>

                <?php if ($tripData['LyDoHuy']): ?>
                    <div class="alert mt-4 <?= $tripData['HuyTrangThai'] == 'Chưa xử lý' ? 'alert-warning' : 'alert-danger' ?> d-flex align-items-start border-0 shadow-sm" style="background-color: #FFF3CD;">
                        <i class="fa-solid fa-circle-exclamation fs-3 text-warning me-3 mt-1"></i>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">Khách hàng yêu cầu hủy chuyến</h6>
                            <p class="mb-1 text-muted" style="font-size: 14px;"><strong>Lý do:</strong> <?= htmlspecialchars($tripData['LyDoHuy']) ?></p>
                            <p class="mb-0 text-muted" style="font-size: 14px;"><strong>Tình trạng:</strong> <?= $tripData['HuyTrangThai'] ?></p>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
<?php endif; ?>

</div>

<script>
    if(document.getElementById('dateRange')) {
        flatpickr("#dateRange", {
            mode: "range",
            dateFormat: "d/m/Y",
            locale: "vn",
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2 || selectedDates.length === 0) {
                    document.getElementById('filterForm').submit();
                }
            }
        });
    }

    function changeTab(tabName) {
        document.getElementById('tabInput').value = tabName;
        document.getElementById('filterForm').submit();
    }

    function confirmCancel(maChuyenDi) {
        Swal.fire({
            title: 'Duyệt yêu cầu hủy?',
            html: "Xác nhận duyệt sẽ chuyển trạng thái đơn này thành <b>'Đã hủy'</b>. Bạn không thể hoàn tác thao tác này!",
            icon: 'warning',
            iconColor: '#DC3545',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#e0e0e0',
            confirmButtonText: 'Đồng ý duyệt',
            cancelButtonText: '<span style="color:#333;">Đóng</span>'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('index.php?controller=admintrip&action=approve_cancel', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'maChuyenDi=' + encodeURIComponent(maChuyenDi)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire('Thành công!', data.message, 'success').then(() => {
                            window.location.reload(); 
                        });
                    } else {
                        Swal.fire('Lỗi!', data.message, 'error');
                    }
                })
            }
        })
    }
</script>

<?php require_once 'app/views/layouts/footer.php'; ?>