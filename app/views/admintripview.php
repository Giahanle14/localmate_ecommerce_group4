<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/vn.js"></script>

<style>
    body { background-color: #F8FAF5; font-family: 'Quicksand', sans-serif; }
    .admin-container { max-width: 1300px; margin: 20px auto 40px; padding: 0 20px; }

    .admin-title { color: #0d5c2c; font-weight: 800; font-size: 32px; margin-bottom: 25px; }

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
    .btn-icon { width: 32px; height: 32px; border-radius: 50%; display: flex; justify-content: center; align-items: center; border: none; transition: 0.2s; text-decoration: none;}
    .btn-view { background-color: #EAF9DE; color: #0d5c2c; }
    .btn-view:hover { background-color: #0d5c2c; color: white; }
    .btn-alert { background-color: #F8D7DA; color: #DC3545; }
    .btn-alert:hover { background-color: #DC3545; color: white; }

    .pagination-wrapper { display: flex; justify-content: space-between; align-items: center; padding: 20px; background: #fafafa; border-top: 1px solid #eee; }
    .page-info { color: #777; font-size: 13px; }
    .pagination { margin: 0; gap: 5px; }
    .page-link { border-radius: 6px !important; border: 1px solid #0d5c2c; color: #0d5c2c; font-weight: 600; padding: 6px 12px; margin: 0 2px;}
    .page-link:hover { background: #EAF9DE; color: #0d5c2c; }
    .page-item.active .page-link { background: #0d5c2c; color: white; border-color: #0d5c2c; }
</style>

<div class="breadcrumb-custom">
    <a href="index.php?controller=adminhome"><i class="fa-solid fa-house me-1"></i>Trang chủ</a> 
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <a href="index.php?controller=admintrip">Quản lý chuyến đi</a>
</div>

<div class="admin-container">
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
                <input type="text" id="dateRange" placeholder="Nhập khoảng thời gian">
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
                            
                            $badgeClass = '';
                            $statusText = '';
                            
                            if ($trip['HuyTrangThai'] === 'Chưa xử lý') {
                                $badgeClass = 'st-pending';
                                $statusText = 'Chưa xử lý';
                            } else {
                                if ($trip['TrangThai'] == 'Chưa hoàn thành') {
                                    $badgeClass = 'st-pending';
                                    $statusText = 'Chưa hoàn thành';
                                } elseif ($trip['TrangThai'] == 'Đã hoàn thành') {
                                    $badgeClass = 'st-completed';
                                    $statusText = 'Đã hoàn thành';
                                } else {
                                    $badgeClass = 'st-canceled';
                                    $statusText = 'Đã hủy';
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
                                    <a href="#" class="btn-icon btn-view" title="Xem chi tiết">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <?php if ($trip['HuyTrangThai'] === 'Chưa xử lý'): ?>
                                    <a href="#" class="btn-icon btn-alert" title="Có yêu cầu hủy">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                    </a>
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
            <ul class="pagination">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?controller=admintrip&tab=<?= $tab ?>&search=<?= urlencode($search) ?>&page=<?= $page - 1 ?>"><i class="fa-solid fa-chevron-left"></i></a>
                </li>
                
                <?php for($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="index.php?controller=admintrip&tab=<?= $tab ?>&search=<?= urlencode($search) ?>&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                
                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?controller=admintrip&tab=<?= $tab ?>&search=<?= urlencode($search) ?>&page=<?= $page + 1 ?>"><i class="fa-solid fa-chevron-right"></i></a>
                </li>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function changeTab(tabName) {
        document.getElementById('tabInput').value = tabName;
        document.getElementById('filterForm').submit();
    }

    flatpickr("#dateRange", {
        mode: "range",
        dateFormat: "d/m/Y",
        locale: "vn"
    });
</script>