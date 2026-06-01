<?php require_once 'app/views/layouts/header.php'; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/vn.js"></script>

<style>
    /* =========================================================
       CSS TOOLBAR & TABLE
       ========================================================= */
    .toolbar { display: flex; justify-content: space-between; align-items: center; }
    
    .filter-section { display: flex; gap: 15px; width: 100%;}
    
    .search-box { position: relative; width: 300px; }
    .search-box i { position: absolute; top: 50%; left: 15px; transform: translateY(-50%); color: #0d5c2c; font-size: 16px; }
    .search-box input { width: 100%; border: 1px solid #ccc; border-radius: 8px; padding: 10px 15px 10px 40px; font-weight: 500; outline: none; background: white;}
    .search-box input:focus { border-color: #0d5c2c; }

    .date-box { position: relative; width: 250px; }
    .date-box i { position: absolute; top: 50%; right: 15px; transform: translateY(-50%); color: #0d5c2c; font-size: 18px; pointer-events: none; }
    .date-box input { width: 100%; border: 1px solid #ccc; border-radius: 8px; padding: 10px 40px 10px 15px; font-weight: 500; outline: none; background: white;}
    .date-box input:focus { border-color: #0d5c2c; }

    .btn-add-new { background-color: #00712D; color: white; border-radius: 8px; padding: 10px 20px; font-weight: 600; border: none; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; transition: 0.2s;}
    .btn-add-new:hover { background-color: #005A24; color: white; }

    .table-container { background: white; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); overflow: hidden; border: 1px solid #f0f0f0; }
    .table { margin-bottom: 0; }
    .table thead { background-color: #EAF9DE; }
    .table th { color: #0d5c2c; font-weight: 700; border-bottom: none; padding: 18px 15px; font-size: 15px; white-space: nowrap; }
    .table td { padding: 18px 15px; vertical-align: middle; border-bottom: 1px solid #f5f5f5; color: #0d5c2c; font-weight: 600; font-size: 14px; }
    
    .action-icon { font-size: 18px; cursor: pointer; margin: 0 8px; transition: transform 0.2s; }
    .action-icon:hover { transform: scale(1.15); }
    .action-disabled { opacity: 0.4; pointer-events: none; cursor: not-allowed; filter: grayscale(100%); }

    /* =========================================================
       CSS PHÂN TRANG
       ========================================================= */
    .pagination-wrapper { display: flex; justify-content: space-between; align-items: center; padding: 20px; background: #fafafa; border-top: 1px solid #eee; }
    .page-info { color: #777; font-size: 13px; }
    .pagination { margin: 0; gap: 5px; }
    .page-link { border-radius: 6px !important; border: 1px solid #0d5c2c; color: #0d5c2c; font-weight: 600; padding: 6px 12px; margin: 0 2px;}
    .page-link:hover { background: #EAF9DE; color: #0d5c2c; }
    .page-item.active .page-link { background: #0d5c2c; color: white; border-color: #0d5c2c; }

    /* =========================================================
       RESPONSIVE CHO TRANG QUẢN LÝ LỊCH KHỞI HÀNH (MOBILE & TABLET)
       ========================================================= */
    @media (max-width: 768px) {
        .toolbar { flex-direction: column; gap: 15px; align-items: stretch; }
        .filter-section { flex-direction: column; gap: 12px; }
        .search-box, .date-box { width: 100% !important; }
        
        .d-flex.align-items-center.gap-3 { justify-content: flex-end; }
        .btn-add-new { width: 100%; justify-content: center; }

        .table-responsive::-webkit-scrollbar { height: 6px; }
        .table-responsive::-webkit-scrollbar-thumb { background-color: #8A9D8E; border-radius: 10px; }
        .table-responsive::-webkit-scrollbar-track { background: #EAF9DE; border-radius: 10px; }

        .pagination-wrapper { flex-direction: column; gap: 15px; text-align: center; }
        .page-info { font-size: 12px; }
    }
</style>

<div class="breadcrumb-custom">
    <a href="index.php?controller=adminhome"><i class="fa-solid fa-house me-1"></i>Tổng quan</a> 
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <a href="index.php?controller=adminschedule">Quản lý lịch khởi hành</a>
</div>

<main class="container-fluid px-3 px-lg-5 py-4" style="background-color: #FCFDF9; min-height: 80vh;">
    
    <?php if ($viewMode === 'list'): ?>
        <div class="toolbar mb-4">
            <form method="GET" action="index.php" id="filterForm" class="m-0 w-100 me-md-3">
                <input type="hidden" name="controller" value="adminschedule">
                <div class="filter-section">
                    <div class="search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="search" placeholder="Tìm kiếm mã lịch, tên tour..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" onchange="document.getElementById('filterForm').submit();">
                    </div>
                    <div class="date-box">
                        <input type="text" id="dateRange" name="daterange" placeholder="Lọc theo ngày khởi hành" value="<?= isset($_GET['daterange']) ? htmlspecialchars($_GET['daterange']) : '' ?>">
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                </div>
            </form>
            <div class="d-flex align-items-center gap-3 mt-3 mt-md-0">
                <a href="index.php?controller=adminschedule&action=add" class="btn-add-new">
                    <i class="fa-solid fa-plus"></i> Thêm
                </a>
            </div>
        </div>

        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mã lịch</th>
                            <th>Tour liên kết</th>
                            <th>Ngày khởi hành</th>
                            <th style="width: 25%; min-width: 180px;">Tình trạng chỗ</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($schedules)): ?>
                            <?php foreach($schedules as $item): ?>
                                <?php 
                                    $ngayBatDauTime = strtotime($item['NgayBatDau']);
                                    $soNgay = (int)$item['SoNgay'];
                                    $ngayKetThucTime = strtotime("+$soNgay days", $ngayBatDauTime);
                                    $homNayTime = strtotime(date('Y-m-d'));
                                    $daHoanThanh = ($ngayKetThucTime < $homNayTime);
                                ?>
                                <tr>
                                    <td><?= $item['MaLichKhoiHanh'] ?></td>
                                    
                                    <td style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= htmlspecialchars($item['TenTour']) ?>">
                                        <?= htmlspecialchars($item['TenTour']) ?>
                                    </td>
                                    
                                    <td><?= date('d/m/Y', strtotime($item['NgayBatDau'])) ?></td>
                                    
                                    <td>
                                        <?php 
                                            $tyLe = $item['SoKhachToiDa'] > 0 ? ($item['SoChoDaDat'] / $item['SoKhachToiDa']) * 100 : 0;
                                            $color = $tyLe >= 100 ? 'danger' : ($tyLe >= 80 ? 'warning' : 'success');
                                        ?>
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span style="font-size: 13px;">Đã đặt: <?= $item['SoChoDaDat'] ?>/<?= $item['SoKhachToiDa'] ?></span>
                                            <span class="small fw-bold text-<?= $color ?>"><?= round($tyLe) ?>%</span>
                                        </div>
                                        <div class="progress" style="height: 6px; border-radius: 10px; background-color: #EAF9DE;">
                                            <div class="progress-bar bg-<?= $color ?>" role="progressbar" style="width: <?= $tyLe ?>%; border-radius: 10px;"></div>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center" style="white-space: nowrap;">
                                        <i class="fa-solid fa-eye action-icon" style="color: #0d5c2c;" title="Xem chi tiết"
                                           onclick="openViewModal('<?= $item['MaLichKhoiHanh'] ?>', '<?= htmlspecialchars($item['TenTour'], ENT_QUOTES) ?>', '<?= date('d/m/Y', strtotime($item['NgayBatDau'])) ?>', <?= $item['SoChoDaDat'] ?>, <?= $item['SoKhachToiDa'] ?>, '<?= $item['MaTour'] ?>')">
                                        </i>

                                        <a href="index.php?controller=adminschedule&action=edit&id=<?= $item['MaLichKhoiHanh'] ?>" 
                                           title="<?= $daHoanThanh ? 'Chuyến đi đã hoàn thành, không thể sửa' : 'Sửa' ?>" 
                                           style="text-decoration: none;"
                                           class="<?= $daHoanThanh ? 'action-disabled' : '' ?>">
                                            <i class="fa-solid fa-pen-to-square action-icon" style="color: <?= $daHoanThanh ? '#b0b0b0' : '#4CAF50' ?>;"></i>
                                        </a>
                                        
                                        <a href="index.php?controller=adminschedule&action=delete&id=<?= $item['MaLichKhoiHanh'] ?>" 
                                           onclick="return confirm('Bạn có chắc chắn muốn xóa lịch khởi hành này? Chú ý: Việc này có thể ảnh hưởng đến các chuyến đi đã được đặt!');" 
                                           title="<?= $daHoanThanh ? 'Chuyến đi đã hoàn thành, không thể xóa' : 'Xóa' ?>" 
                                           style="text-decoration: none;"
                                           class="<?= $daHoanThanh ? 'action-disabled' : '' ?>">
                                            <i class="fa-solid fa-trash action-icon" style="color: <?= $daHoanThanh ? '#b0b0b0' : '#D32F2F' ?>;"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center py-4 text-muted">Không tìm thấy lịch khởi hành nào.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if (isset($totalPages) && $totalPages > 0): ?>
            <div class="pagination-wrapper">
                <?php
                    // Lấy các biến tìm kiếm từ URL/Controller
                    $page = isset($page) ? $page : 1;
                    $limit = isset($limit) ? $limit : 10;
                    $total = isset($total) ? $total : 0;
                    
                    $searchParam = isset($search) ? urlencode($search) : (isset($_GET['search']) ? urlencode($_GET['search']) : '');
                    $daterangeParam = isset($daterange) ? urlencode($daterange) : (isset($_GET['daterange']) ? urlencode($_GET['daterange']) : '');
                    
                    $startItem = ($page - 1) * $limit + 1;
                    $endItem = min($page * $limit, $total);
                ?>
                <div class="page-info">
                    Hiển thị <?= $startItem ?>-<?= $endItem ?> trong tổng số <?= $total ?> kết quả
                </div>
                <ul class="pagination d-flex flex-wrap justify-content-center">
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="index.php?controller=adminschedule&search=<?= $searchParam ?>&daterange=<?= $daterangeParam ?>&page=<?= $page - 1 ?>"><i class="fa-solid fa-chevron-left"></i></a>
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
                            <a class="page-link" href="index.php?controller=adminschedule&search=<?= $searchParam ?>&daterange=<?= $daterangeParam ?>&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($endPage < $totalPages): ?>
                        <li class="page-item disabled"><a class="page-link border-0 bg-transparent text-muted" href="#">...</a></li>
                    <?php endif; ?>

                    <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="index.php?controller=adminschedule&search=<?= $searchParam ?>&daterange=<?= $daterangeParam ?>&page=<?= $page + 1 ?>"><i class="fa-solid fa-chevron-right"></i></a>
                    </li>
                </ul>
            </div>
            <?php endif; ?>

        </div>

    <?php elseif ($viewMode === 'add' || $viewMode === 'edit'): ?>
        <div class="card shadow-sm border-0 rounded-4 mx-auto mt-4 mt-md-0" style="max-width: 800px;">
            <div class="card-body p-4 p-md-5">
                <h3 class="admin-title text-center mb-4" style="color: #00712D; font-weight: 800; text-transform: uppercase; font-size: clamp(1.2rem, 3vw, 1.75rem);">
                    <?= $viewMode === 'add' ? 'Thêm Lịch Khởi Hành' : 'Cập Nhật Lịch Khởi Hành' ?>
                </h3>
                
                <form action="index.php?controller=adminschedule&action=<?= $viewMode ?><?= $viewMode === 'edit' ? '&id='.$schedule['MaLichKhoiHanh'] : '' ?>" method="POST">
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Chọn Tour Liên Kết <span class="text-danger">*</span></label>
                        <select name="maTour" class="form-select py-2 rounded-3" required <?= ($viewMode === 'edit' && $schedule['SoChoDaDat'] > 0) ? 'disabled' : '' ?>>
                            <option value="">-- Chọn Tour --</option>
                            <?php foreach ($tours as $t): ?>
                                <option value="<?= $t['MaTour'] ?>" <?= ($viewMode === 'edit' && $schedule['MaTour'] === $t['MaTour']) ? 'selected' : '' ?>>
                                    [<?= $t['MaTour'] ?>] <?= htmlspecialchars($t['TenTour']) ?> (Max: <?= $t['SoKhachToiDa'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if($viewMode === 'edit' && $schedule['SoChoDaDat'] > 0): ?>
                            <input type="hidden" name="maTour" value="<?= $schedule['MaTour'] ?>">
                            <small class="text-danger mt-1 d-block"><i class="fa-solid fa-circle-info"></i> Không thể đổi sang Tour khác vì lịch này đã có khách đăng ký.</small>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Ngày Khởi Hành <span class="text-danger">*</span></label>
                        <input type="date" name="ngayBatDau" class="form-control py-2 rounded-3" value="<?= $viewMode === 'edit' ? $schedule['NgayBatDau'] : '' ?>" required>
                    </div>

                    <hr class="my-4 text-muted">
                    <div class="text-end d-flex justify-content-end gap-2">
                        <a href="index.php?controller=adminschedule" class="btn btn-outline-secondary px-4 py-2 fw-bold rounded-3">Hủy bỏ</a>
                        <button type="submit" class="btn text-white px-4 py-2 fw-bold rounded-3" style="background-color: #00712D;"><?= $viewMode === 'add' ? 'Thêm Mới' : 'Cập Nhật' ?></button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <div class="modal fade" id="viewScheduleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div class="modal-header" style="background-color: #00712D; color: white; border-radius: 16px 16px 0 0; padding: 15px 25px;">
                    <h5 class="modal-title fw-bold m-0"><i class="fa-solid fa-calendar-day me-2"></i>Chi Tiết Lịch Trình</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3 border-bottom pb-2">
                        <label class="text-muted small fw-bold text-uppercase">Mã Lịch Khởi Hành</label>
                        <h6 id="viewMaLich" class="fw-bold text-dark mt-1 fs-5">LKC---</h6>
                    </div>
                    <div class="mb-3 border-bottom pb-2">
                        <label class="text-muted small fw-bold text-uppercase">Tên Tour Liên Kết</label>
                        <h6 id="viewTenTour" class="fw-bold mt-1" style="color: #00712D; line-height: 1.4;">Tên tour...</h6>
                    </div>
                    <div class="row mb-4">
                        <div class="col-6">
                            <label class="text-muted small fw-bold text-uppercase">Ngày Khởi Hành</label>
                            <h6 id="viewNgay" class="fw-bold text-dark mt-1">--/--/----</h6>
                        </div>
                        <div class="col-6">
                            <label class="text-muted small fw-bold text-uppercase">Tình Trạng Chỗ</label>
                            <h6 id="viewCho" class="fw-bold text-dark mt-1">- / -</h6>
                        </div>
                    </div>
                    
                    <div class="text-center pt-2">
                        <a href="#" id="viewLinkTour" class="btn text-white fw-bold px-4 py-2 rounded-3 w-100 shadow-sm" style="background-color: #F29A2E; transition: 0.3s;">
                            <i class="fa-solid fa-link me-2"></i>Xem Tour Gốc
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
if(document.getElementById('dateRange')) {
    let initialDateStr = document.getElementById('dateRange').value;
    
    flatpickr("#dateRange", {
        mode: "range",
        dateFormat: "d/m/Y",
        locale: "vn",
        rangeSeparator: " - ", 
        onClose: function(selectedDates, dateStr, instance) {
            if (dateStr !== initialDateStr) {
                document.getElementById('filterForm').submit();
            }
        }
    });
}

    function openViewModal(maLich, tenTour, ngay, daDat, toiDa, maTour) {
        document.getElementById('viewMaLich').innerText = maLich;
        document.getElementById('viewTenTour').innerText = tenTour;
        document.getElementById('viewNgay').innerText = ngay;
        document.getElementById('viewCho').innerText = daDat + ' / ' + toiDa + ' (Khách)';
        document.getElementById('viewLinkTour').href = 'index.php?controller=admintour&action=detail&id=' + maTour;
        var myModal = new bootstrap.Modal(document.getElementById('viewScheduleModal'));
        myModal.show();
    }
</script>

<?php require_once 'app/views/layouts/footer.php'; ?>