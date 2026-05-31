<div class="breadcrumb-custom">
    <a href="index.php?controller=adminhome"><i class="fa-solid fa-house me-1"></i>Trang chủ</a> 
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <a href="index.php?controller=adminreport">Báo cáo doanh thu</a>
</div>
<main class="container-fluid px-3 px-lg-5 py-4" style="background-color: #FCFDF9;">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="sidebar-filter bg-white p-4 rounded-4 shadow-sm border" style="border-color: #E6EECA !important;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="fw-bold" style="color: #123C27;"><i class="fa-solid fa-filter me-2"></i>Bộ lọc tìm kiếm</span>
                    <a href="#" onclick="resetFilters(event)" class="text-success text-decoration-none small"><i class="fa-solid fa-rotate-right"></i> Làm mới</a>
                </div>
                
                <form id="filterForm">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Thời gian</label>
                        <select class="form-select mb-2 text-muted fw-semibold" id="filterYear">
                            <option value="2026">Năm 2026</option>
                            <option value="2025">Năm 2025</option>
                            <option value="2024">Năm 2024</option>
                        </select>
                        <!-- Thêm class d-flex flex-column flex-sm-row flex-lg-column flex-xl-row để responsive tự xếp chồng trên màn hình nhỏ -->
                        <div class="d-flex gap-2 flex-column flex-sm-row flex-lg-column flex-xl-row">
                            <select class="form-select text-muted fw-semibold w-100" id="filterQuarter">
                                <option value="">-- Chọn quý --</option>
                                <option value="1">Quý 1</option>
                                <option value="2">Quý 2</option>
                                <option value="3">Quý 3</option>
                                <option value="4">Quý 4</option>
                            </select>
                            <select class="form-select text-muted fw-semibold w-100" id="filterMonth">
                                <option value="">-- Chọn tháng --</option>
                                <?php for($i=1; $i<=12; $i++) echo "<option value='$i'>Tháng $i</option>"; ?>
                            </select>
                        </div>
                    </div>

                    <!-- LOẠI TRẢI NGHIỆM: Dạng Dropdown Checkbox -->
                    <div class="mb-3 custom-multi-select">
                        <label class="form-label text-muted small fw-bold">Loại trải nghiệm</label>
                        <div class="dropdown">
                            <button class="btn border w-100 text-start d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" style="background-color: #fff;">
                                <span id="textLoai" class="text-truncate text-muted fw-semibold" style="max-width: 85%;">-- Tất cả trải nghiệm --</span>
                                <i class="fa-solid fa-angle-down text-muted"></i>
                            </button>
                            <ul class="dropdown-menu w-100 p-2 shadow-sm border-0" style="max-height: 250px; overflow-y: auto; border: 1px solid #E6EECA !important;">
                                <li><label class="dropdown-item rounded py-2"><input class="form-check-input me-2 filter-loai-chk" type="checkbox" value="Văn hóa"> Văn hóa</label></li>
                                <li><label class="dropdown-item rounded py-2"><input class="form-check-input me-2 filter-loai-chk" type="checkbox" value="Ẩm thực"> Ẩm thực</label></li>
                                <li><label class="dropdown-item rounded py-2"><input class="form-check-input me-2 filter-loai-chk" type="checkbox" value="Rừng cây"> Rừng cây</label></li>
                                <li><label class="dropdown-item rounded py-2"><input class="form-check-input me-2 filter-loai-chk" type="checkbox" value="Chữa lành"> Chữa lành</label></li>
                                <li><label class="dropdown-item rounded py-2"><input class="form-check-input me-2 filter-loai-chk" type="checkbox" value="Núi non"> Núi non</label></li>
                                <li><label class="dropdown-item rounded py-2"><input class="form-check-input me-2 filter-loai-chk" type="checkbox" value="Tham quan"> Tham quan</label></li>
                                <li><label class="dropdown-item rounded py-2"><input class="form-check-input me-2 filter-loai-chk" type="checkbox" value="Biển đảo"> Biển đảo</label></li>
                                <li><label class="dropdown-item rounded py-2"><input class="form-check-input me-2 filter-loai-chk" type="checkbox" value="Nông thôn"> Nông thôn</label></li>
                                <li><label class="dropdown-item rounded py-2"><input class="form-check-input me-2 filter-loai-chk" type="checkbox" value="Sông nước"> Sông nước</label></li>
                            </ul>
                        </div>
                    </div>

                    <!-- VÙNG ĐỊA LÝ: Dạng Dropdown Checkbox -->
                    <div class="mb-3 custom-multi-select">
                        <label class="form-label text-muted small fw-bold">Vùng địa lý</label>
                        <div class="dropdown">
                            <button class="btn border w-100 text-start d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" style="background-color: #fff;">
                                <span id="textVung" class="text-truncate text-muted fw-semibold" style="max-width: 85%;">-- Tất cả các vùng --</span>
                                <i class="fa-solid fa-angle-down text-muted"></i>
                            </button>
                            <ul class="dropdown-menu w-100 p-2 shadow-sm border-0" style="max-height: 250px; overflow-y: auto; border: 1px solid #E6EECA !important;">
                                <li><label class="dropdown-item rounded py-2"><input class="form-check-input me-2 filter-vung-chk" type="checkbox" value="Tây Bắc"> Tây Bắc</label></li>
                                <li><label class="dropdown-item rounded py-2"><input class="form-check-input me-2 filter-vung-chk" type="checkbox" value="Đông Nam Bộ"> Đông Nam Bộ</label></li>
                                <li><label class="dropdown-item rounded py-2"><input class="form-check-input me-2 filter-vung-chk" type="checkbox" value="Nam Trung Bộ"> Nam Trung Bộ</label></li>
                                <li><label class="dropdown-item rounded py-2"><input class="form-check-input me-2 filter-vung-chk" type="checkbox" value="Bắc Trung Bộ"> Bắc Trung Bộ</label></li>
                                <li><label class="dropdown-item rounded py-2"><input class="form-check-input me-2 filter-vung-chk" type="checkbox" value="Tây Nguyên"> Tây Nguyên</label></li>
                                <li><label class="dropdown-item rounded py-2"><input class="form-check-input me-2 filter-vung-chk" type="checkbox" value="Đồng bằng sông Cửu Long"> Đồng bằng sông Cửu Long</label></li>
                                <li><label class="dropdown-item rounded py-2"><input class="form-check-input me-2 filter-vung-chk" type="checkbox" value="Đông Bắc"> Đông Bắc</label></li>
                                <li><label class="dropdown-item rounded py-2"><input class="form-check-input me-2 filter-vung-chk" type="checkbox" value="Đồng bằng sông Hồng"> Đồng bằng sông Hồng</label></li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="bg-white p-4 rounded-4 shadow-sm border h-100" style="border-color: #E6EECA !important;">
                
                <!-- Đã sửa header: Bỏ h4 màu xanh, đưa Kỳ báo cáo sang trái và Nút xuất sang phải -->
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                    <span class="fw-bold text-muted" id="reportPeriodText" style="font-size: 1.1rem;">Kỳ: Năm 2026</span>
                    <button class="btn text-white fw-bold d-flex align-items-center gap-2 rounded-pill px-4" style="background-color: #F29A2E;" onclick="showExportModal()">
                        <i class="fa-solid fa-file-export"></i> Xuất
                    </button>
                </div>

                <div class="mb-5">
                    <p class="text-muted fw-bold mb-1 text-uppercase">Tổng doanh thu kỳ này</p>
                    <!-- text-break giúp số lớn tự động xuống dòng tránh vỡ layout trên mobile -->
                    <h1 class="fw-bolder text-break" style="color: var(--color-primary-dark); font-size: clamp(2rem, 5vw, 2.5rem);" id="totalRevenueDisplay">0 VNĐ</h1>
                </div>

                <div class="mb-5 pb-4 border-bottom">
                    <p class="text-muted fw-bold small mb-3">Đơn vị: Triệu VNĐ</p>
                    <!-- position: relative bắt buộc cho Chart.js responsive -->
                    <div style="position: relative; height: 320px; width: 100%;">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>

                <div class="row g-4 mb-3">
                    <div class="col-md-6">
                        <div class="p-4 border rounded-4 h-100" style="background-color: #FAFAFA; border-color:#eee;">
                            <h6 class="text-muted fw-bold mb-4 text-center text-uppercase" style="font-size: 0.9rem;">Doanh thu theo loại trải nghiệm</h6>
                            <!-- Tăng chiều cao lên 320px để cân đối với biểu đồ Vùng bên cạnh -->
                            <div style="position: relative; height: 320px; width: 100%;">
                                <canvas id="barChartLoai"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 border rounded-4 h-100" style="background-color: #FAFAFA; border-color:#eee;">
                            <h6 class="text-muted fw-bold mb-4 text-center text-uppercase" style="font-size: 0.9rem;">Cơ cấu doanh thu theo vùng địa lý</h6>
                            <!-- Tăng chiều cao lên 320px để phần legend (chú thích) có chỗ hiển thị ở bên dưới mà không che mất hình tròn -->
                            <div style="position: relative; height: 320px; width: 100%;">
                                <canvas id="pieChartVung"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<!-- Modal Tóm Tắt & Xác nhận Xuất Báo Cáo -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header text-white" style="background-color: var(--color-primary-dark); border-radius: 12px 12px 0 0; padding: 15px 20px; border-bottom: none;">
                <h5 class="modal-title fw-bold fs-6"><i class="fa-regular fa-file-lines me-2"></i>Xuất báo cáo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4 pt-4">
                <div class="text-center mb-4">
                    <h5 class="fw-bolder mb-1" style="color: #222; font-size: 1.25rem;">BÁO CÁO DOANH THU HOẠT ĐỘNG</h5>
                    <p class="text-muted mb-0" style="font-size: 0.95rem;">Nền tảng LocalMate</p>
                </div>
                
                <hr style="opacity: 0.15;" class="mb-4">

                <div class="row mb-4">
                    <!-- Đổi sang col-12 col-sm-6 để tự xuống hàng gọn gàng trên mobile -->
                    <div class="col-12 col-sm-6 mb-3 mb-sm-0">
                        <p class="text-muted small mb-1">Người lập báo cáo:</p>
                        <p class="fw-bold mb-0 text-dark"><?= htmlspecialchars($_SESSION['user']['HoTen'] ?? 'Quản trị viên') ?></p>
                        <p class="text-muted" style="font-size: 0.8rem;">Quản trị viên</p>
                    </div>
                    <div class="col-12 col-sm-6 text-start text-sm-end">
                        <p class="text-muted small mb-1">Thời gian trích xuất:</p>
                        <p class="fw-bold mb-0 text-dark" id="exportTimeVal">--:--:-- --/--/----</p>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-muted small mb-2">Kỳ báo cáo:</p>
                    <span class="badge" style="background-color: #EAF9DE; color: var(--color-primary-dark); font-size: 1rem; padding: 8px 15px; font-weight: 700; border-radius: 6px;" id="exportPeriodText">NĂM 2026 - THÁNG 5</span>
                </div>

                <!-- Tổng doanh thu flex column ở mobile để khỏi dính chùm -->
                <div class="border rounded-3 p-3 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-2 gap-2" style="border-color: #e0e0e0 !important;">
                    <span class="fw-bold text-dark" style="font-size: 1.05rem;">TỔNG DOANH THU ĐẠT ĐƯỢC:</span>
                    <span class="fw-bolder text-break" style="color: var(--color-primary-dark); font-size: 1.5rem;" id="exportTotalVal">0 đ</span>
                </div>
            </div>
            
            <div class="modal-footer border-top-0 d-flex flex-column flex-sm-row justify-content-end gap-2 pb-4 px-4 pt-0">
                <button type="button" class="btn text-muted fw-bold bg-transparent border-0 w-100 w-sm-auto" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn text-white fw-bold rounded-2 px-4 w-100 w-sm-auto" style="background-color: #F29A2E;" onclick="downloadPDF()">
                    <i class="fa-solid fa-print me-2"></i> Tiếp tục in/Lưu PDF
                </button>
            </div>
        </div>
    </div>
</div>

<!-- =========================================================================
     KHU VỰC KHUÔN MẪU A4 FULL CHI TIẾT DÀNH RIÊNG CHO VIỆC XUẤT PDF 
     (Bình thường được giấu đi an toàn bằng display: none)
     ========================================================================= -->
<div id="fullReportExport" style="display: none; width: 100%; max-width: 850px; background: white; color: #333; font-family: 'Times New Roman', Times, serif;">
    
    <!-- Tiêu đề báo cáo -->
    <div style="text-align: center; margin-bottom: 25px;">
        <h2 style="color: #005A24; margin: 0; font-size: 26px; font-weight: 900; text-transform: uppercase;">Báo Cáo Doanh Thu Hoạt Động</h2>
        <p style="color: #666; margin-top: 8px; font-size: 16px;">Nền tảng Du lịch Bản địa LocalMate</p>
    </div>
    
    <hr style="border-top: 2px solid #005A24; margin-bottom: 25px; opacity: 0.8;">

    <!-- Thông tin người lập & Thời gian (Sử dụng Flexbox để đảm bảo không bị rớt dòng) -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; font-size: 15px; width: 100%;">
        <div style="width: 48%;">
            <p style="margin: 0 0 5px 0; color: #666;">Người lập báo cáo:</p>
            <p style="margin: 0 0 2px 0; font-weight: bold; font-size: 18px; color: #222;"><?= htmlspecialchars($_SESSION['user']['HoTen'] ?? 'Quản trị viên') ?></p>
            <p style="margin: 0; color: #888; font-size: 14px;">Quản trị viên</p>
        </div>
        <div style="width: 48%; text-align: right;">
            <p style="margin: 0 0 5px 0; color: #666;">Thời gian trích xuất:</p>
            <p style="margin: 0; font-weight: bold; font-size: 16px; color: #222;" id="pdfTimeVal">--</p>
        </div>
    </div>

    <!-- Kỳ báo cáo -->
    <div style="margin-bottom: 30px;">
        <p style="margin: 0 0 8px 0; color: #666; font-size: 15px;">Kỳ báo cáo:</p>
        <div style="background-color: #EAF9DE; color: #005A24; display: inline-block; padding: 10px 20px; font-weight: bold; font-size: 16px; border-radius: 6px; border: 1px solid #B4D6B5;" id="pdfPeriodText">
            --
        </div>
    </div>

    <!-- Tổng tiền (Nổi bật) -->
    <div style="border: 2px solid #E6EECA; border-radius: 12px; padding: 25px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; background-color: #FAFAFA; width: 100%; box-sizing: border-box;">
        <span style="font-size: 20px; font-weight: bold; color: #333;">TỔNG DOANH THU ĐẠT ĐƯỢC:</span>
        <span style="font-size: 28px; font-weight: 900; color: #005A24;" id="pdfTotalVal">0 đ</span>
    </div>

    <!-- Nơi chứa Biểu đồ (Sẽ được JS dán hình ảnh vào) -->
    <div style="margin-bottom: 40px; text-align: center; width: 100%;">
        <h4 style="font-size: 18px; font-weight: bold; color: #123C27; margin-bottom: 15px; text-transform: uppercase;">1. Biểu đồ Doanh thu (Triệu VNĐ)</h4>
        <img id="pdfBarChartImg" src="" style="width: 100%; height: auto; max-height: 350px; object-fit: contain;">
    </div>

    <div style="display: flex; justify-content: space-between; width: 100%; margin-top: 20px;">
        <div style="width: 48%; padding: 10px; text-align: center;">
            <h4 style="font-size: 16px; font-weight: bold; color: #123C27; margin-bottom: 15px; text-transform: uppercase;">2. Doanh thu theo Trải nghiệm</h4>
            <img id="pdfBarLoaiImg" src="" style="width: 100%; height: auto; max-height: 250px; object-fit: contain;">
        </div>
        <div style="width: 48%; padding: 10px; text-align: center;">
            <h4 style="font-size: 16px; font-weight: bold; color: #123C27; margin-bottom: 15px; text-transform: uppercase;">3. Cơ cấu theo Vùng</h4>
            <img id="pdfPieVungImg" src="" style="width: 100%; height: auto; max-height: 250px; object-fit: contain;">
        </div>
    </div>
    
    <div style="margin-top: 50px; text-align: center; color: #888; font-size: 13px; border-top: 1px dashed #ddd; padding-top: 20px; width: 100%;">
        Đây là tài liệu được trích xuất tự động từ Hệ thống Quản trị LocalMate.<br>
        Mọi thắc mắc vui lòng liên hệ Bộ phận Kỹ thuật.
    </div>
</div>

<!-- =========================================================================
     THƯ VIỆN & SCRIPT XỬ LÝ
     ========================================================================= -->

<!-- Thư viện Chart.js để vẽ biểu đồ -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Plugin hiển thị Datalabels cho Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
    // Đăng ký Plugin DataLabels cho toàn cục
    Chart.register(ChartDataLabels);

    let barChartInstance = null;
    let barLoaiInstance = null; 
    let pieVungInstance = null;

    const API_URL = 'index.php?controller=adminreport&action=index&ajax_action=getData';

    const colorPalette = [
        '#58D68D', '#F4D03F', '#F39C12', '#5DADE2', '#AF7AC5', 
        '#F1948A', '#E74C3C', '#AAB7B8', '#48C9B0'
    ];

    document.addEventListener('DOMContentLoaded', () => {
        const d = new Date();
        document.getElementById('filterYear').value = d.getFullYear();
        document.getElementById('filterMonth').value = d.getMonth() + 1;
        
        // Khởi tạo các sự kiện lắng nghe bộ lọc
        setupFilters();
        
        loadData();
    });

    function setupFilters() {
        // Lắng nghe Select cơ bản (Năm, Quý, Tháng)
        const filters = ['filterYear', 'filterQuarter', 'filterMonth'];
        filters.forEach(id => {
            document.getElementById(id).addEventListener('change', (e) => {
                if (id === 'filterQuarter' && e.target.value !== '') {
                    document.getElementById('filterMonth').value = '';
                } else if (id === 'filterMonth' && e.target.value !== '') {
                    document.getElementById('filterQuarter').value = '';
                }
                loadData();
            });
        });

        // Lắng nghe Checkbox (Loại trải nghiệm)
        const loaiCheckboxes = document.querySelectorAll('.filter-loai-chk');
        loaiCheckboxes.forEach(chk => {
            chk.addEventListener('change', () => {
                updateDropdownText('.filter-loai-chk', 'textLoai', '-- Tất cả trải nghiệm --');
                loadData();
            });
        });

        // Lắng nghe Checkbox (Vùng địa lý)
        const vungCheckboxes = document.querySelectorAll('.filter-vung-chk');
        vungCheckboxes.forEach(chk => {
            chk.addEventListener('change', () => {
                updateDropdownText('.filter-vung-chk', 'textVung', '-- Tất cả các vùng --');
                loadData();
            });
        });
    }

    // Hàm cập nhật chữ trên nút Dropdown
    function updateDropdownText(checkboxClass, textId, defaultText) {
        const checkedBoxes = document.querySelectorAll(checkboxClass + ':checked');
        const textSpan = document.getElementById(textId);
        
        if (checkedBoxes.length === 0) {
            textSpan.innerText = defaultText;
        } else if (checkedBoxes.length <= 2) {
            // Nối tên của 1 hoặc 2 mục đang chọn
            textSpan.innerText = Array.from(checkedBoxes).map(cb => cb.value).join(', ');
        } else {
            // Rút gọn nếu chọn quá nhiều
            textSpan.innerText = `Đã chọn ${checkedBoxes.length} mục`;
        }
    }

    function resetFilters(e) {
        e.preventDefault();
        const d = new Date();
        document.getElementById('filterYear').value = d.getFullYear();
        document.getElementById('filterQuarter').value = '';
        document.getElementById('filterMonth').value = d.getMonth() + 1;
        
        // Bỏ chọn tất cả các Checkbox
        document.querySelectorAll('.filter-loai-chk').forEach(chk => chk.checked = false);
        document.querySelectorAll('.filter-vung-chk').forEach(chk => chk.checked = false);
        
        // Trả về chữ mặc định trên nút
        document.getElementById('textLoai').innerText = '-- Tất cả trải nghiệm --';
        document.getElementById('textVung').innerText = '-- Tất cả các vùng --';
        
        loadData();
    }

    async function loadData() {
        const year = document.getElementById('filterYear').value;
        const quarter = document.getElementById('filterQuarter').value;
        const month = document.getElementById('filterMonth').value;
        
        // Lấy tất cả các Checkbox đang tích và nối thành chuỗi
        const loai = Array.from(document.querySelectorAll('.filter-loai-chk:checked')).map(cb => cb.value).join(',');
        const vung = Array.from(document.querySelectorAll('.filter-vung-chk:checked')).map(cb => cb.value).join(',');

        updatePeriodText(year, quarter, month);

        const params = new URLSearchParams({ year, quarter, month, loai, vung });
        
        try {
            const response = await fetch(API_URL + '&' + params.toString());
            const result = await response.json();
            
            if (result && result.redirect) {
                alert(result.message);
                window.location.href = result.redirect;
                return;
            }

            if (result.status === 'success') {
                updateDashboard(result.data);
            } else {
                alert('Lỗi tải dữ liệu: ' + result.message);
            }
        } catch (e) {
            console.error('Lỗi kết nối API lấy báo cáo', e);
        }
    }

    function updatePeriodText(year, quarter, month) {
        let text = `Năm ${year}`;
        if (month) text += ` - Tháng ${month}`;
        else if (quarter) text += ` - Quý ${quarter}`;
        document.getElementById('reportPeriodText').innerText = 'Kỳ: ' + text;
    }

    function updateDashboard(data) {
        document.getElementById('totalRevenueDisplay').innerText = new Intl.NumberFormat('vi-VN').format(data.total) + ' VNĐ';
        renderBarChart(data.barChart);

        // Chỉ hiển thị trên biểu đồ những "Loại trải nghiệm" đã được tick chọn (nếu có)
        const selectedLoai = Array.from(document.querySelectorAll('.filter-loai-chk:checked')).map(cb => cb.value);
        let barLoaiToRender = data.pieLoai;
        if (selectedLoai.length > 0) {
            barLoaiToRender = data.pieLoai.filter(item => selectedLoai.includes(item.label));
        }
        renderBarChartLoai(barLoaiToRender);

        // Chỉ hiển thị trên biểu đồ những "Vùng địa lý" đã được tick chọn (nếu có)
        const selectedVung = Array.from(document.querySelectorAll('.filter-vung-chk:checked')).map(cb => cb.value);
        let pieVungToRender = data.pieVung;
        if (selectedVung.length > 0) {
            pieVungToRender = data.pieVung.filter(item => selectedVung.includes(item.label));
        }
        renderPieChartVung(pieVungToRender);
    }

    function renderBarChart(chartData) {
        const ctx = document.getElementById('barChart').getContext('2d');
        if (barChartInstance) barChartInstance.destroy();

        const valuesInMillions = chartData.values.map(v => v / 1000000);

        barChartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Doanh thu (Triệu VNĐ)',
                    data: valuesInMillions,
                    backgroundColor: '#B5E48C',
                    hoverBackgroundColor: '#7A9F5A',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false },
                    datalabels: { display: false } 
                },
                scales: { y: { beginAtZero: true } },
                animation: { duration: 0 } 
            }
        });
    }

    // ĐÃ CHUYỂN ĐỔI THÀNH BIỂU ĐỒ CỘT NGANG (HORIZONTAL BAR CHART)
    function renderBarChartLoai(dataArray) {
        const ctx = document.getElementById('barChartLoai').getContext('2d');
        if (barLoaiInstance) barLoaiInstance.destroy();

        // Sắp xếp các cột doanh thu từ cao xuống thấp để dễ quan sát nhất
        const sortedData = [...dataArray].sort((a, b) => b.value - a.value);

        const rawLabels = sortedData.map(item => item.label);
        const valuesInMillions = sortedData.map(item => (parseFloat(item.value) || 0) / 1000000); // Đổi ra Triệu VNĐ giống biểu đồ chính

        barLoaiInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: rawLabels,
                datasets: [{
                    label: 'Doanh thu (Triệu VNĐ)',
                    data: valuesInMillions,
                    backgroundColor: colorPalette.slice(0, rawLabels.length),
                    borderRadius: 4
                }]
            },
            options: {
                indexAxis: 'y', // Biến biểu đồ cột dọc thành cột ngang
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }, // Không cần chú thích rườm rà vì nhãn đã ở trục y
                    datalabels: { display: false }, 
                    tooltip: {
                        displayColors: false, 
                        callbacks: {
                            label: function(context) {
                                // Trả lại định dạng số tiền thực (x 1,000,000) khi hover chuột
                                let value = context.raw * 1000000;
                                return new Intl.NumberFormat('vi-VN').format(value) + ' VNĐ';
                            }
                        }
                    }
                },
                scales: { 
                    x: { beginAtZero: true }
                },
                animation: { duration: 0 }
            }
        });
    }

    function renderPieChartVung(dataArray) {
        const ctx = document.getElementById('pieChartVung').getContext('2d');
        if (pieVungInstance) pieVungInstance.destroy();

        const rawLabels = dataArray.map(item => item.label);
        const values = dataArray.map(item => parseFloat(item.value) || 0);

        const total = values.reduce((a, b) => a + b, 0);
        const formattedLabels = rawLabels.map((label, index) => {
            const pct = total > 0 ? ((values[index] / total) * 100).toFixed(1) : "0.0";
            return `${label} (${pct}%)`;
        });

        pieVungInstance = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: formattedLabels, 
                datasets: [{
                    data: values,
                    backgroundColor: colorPalette.slice().reverse().slice(0, rawLabels.length)
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        position: 'bottom', // ĐƯA CHÚ THÍCH XUỐNG DƯỚI ĐỂ KHÔNG BỊ MẤT CHỮ
                        onClick: null 
                    },
                    datalabels: { display: false }, 
                    tooltip: {
                        displayColors: false, 
                        callbacks: {
                            label: function(context) {
                                let value = context.raw || 0;
                                return new Intl.NumberFormat('vi-VN').format(value) + ' VNĐ';
                            }
                        }
                    }
                },
                animation: { duration: 0 }
            }
        });
    }

    // --- HIỂN THỊ MODAL ---
    function showExportModal() {
        let periodText = document.getElementById('reportPeriodText').innerText.replace('Kỳ: ', '').toUpperCase();
        document.getElementById('exportPeriodText').innerText = periodText;
        
        let totalRev = document.getElementById('totalRevenueDisplay').innerText;
        document.getElementById('exportTotalVal').innerText = totalRev.replace('VNĐ', 'đ');

        const now = new Date();
        const timeString = now.toLocaleTimeString('vi-VN', { hour12: false }) + ' ' + now.toLocaleDateString('vi-VN');
        document.getElementById('exportTimeVal').innerText = timeString;

        if (typeof bootstrap !== 'undefined') {
            new bootstrap.Modal(document.getElementById('exportModal')).show();
        } else if (typeof $!== 'undefined' &&$.fn.modal) {
            $('#exportModal').modal('show');
        } else {
            alert('Chưa load được thư viện để mở cửa sổ tóm tắt!');
        }
    }

    // --- XUẤT PDF BẰNG TRÌNH DUYỆT (NATIVE WINDOW.PRINT) ---
    function downloadPDF() {
        document.getElementById('pdfTimeVal').innerText = document.getElementById('exportTimeVal').innerText;
        document.getElementById('pdfPeriodText').innerText = document.getElementById('exportPeriodText').innerText;
        document.getElementById('pdfTotalVal').innerText = document.getElementById('exportTotalVal').innerText;

        const barCanvas = document.getElementById('barChart');
        const barLoaiCanvas = document.getElementById('barChartLoai');
        const pieVungCanvas = document.getElementById('pieChartVung');

        if(barCanvas) document.getElementById('pdfBarChartImg').src = barCanvas.toDataURL('image/png', 1.0);
        if(barLoaiCanvas) document.getElementById('pdfBarLoaiImg').src = barLoaiCanvas.toDataURL('image/png', 1.0);
        if(pieVungCanvas) document.getElementById('pdfPieVungImg').src = pieVungCanvas.toDataURL('image/png', 1.0);

        if (typeof bootstrap !== 'undefined') {
            const modalEl = document.getElementById('exportModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if(modal) modal.hide();
        } else if (typeof $!== 'undefined' &&$.fn.modal) {
            $('#exportModal').modal('hide');
        }

        setTimeout(() => {
            window.print();
        }, 400);
    }
</script>