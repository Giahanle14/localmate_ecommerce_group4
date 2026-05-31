<!-- app/views/adminaccountview.php -->
<div class="breadcrumb-custom">
    <a href="index.php?controller=adminhome"><i class="fa-solid fa-house me-1"></i>Trang chủ</a> 
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <a href="index.php?controller=adminaccount">Quản lý tài khoản</a>
</div>
<main class="container-fluid px-3 px-lg-5 py-4">
    <!-- Toolbar Filters -->
    <div class="toolbar mb-4">
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="searchInput" placeholder="Tìm kiếm tên, sđt...">
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="filter-box">
                <select id="roleFilter">
                    <option value="">-- Tất cả vai trò --</option>
                    <option value="Quản trị viên">Quản trị viên</option>
                    <option value="Du khách">Du khách</option>
                </select>
            </div>
            <div class="filter-box">
                <select id="rankFilter" disabled>
                    <option value="">-- Tất cả hạng (du khách) --</option>
                    <option value="Đồng">Đồng</option>
                    <option value="Bạc">Bạc</option>
                    <option value="Vàng">Vàng</option>
                    <option value="Kim Cương">Kim Cương</option>
                </select>
            </div>
            <button class="btn btn-add-new" onclick="openAddModal()">
                <i class="fa-solid fa-plus"></i> Thêm
            </button>
        </div>
    </div>

    <!-- Table Danh Sách -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th class="text-start">Họ và tên</th>
                        <th>SĐT</th>
                        <th>Vai trò</th>
                        <th>Hạng thành viên</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    </tbody>
            </table>
        </div>
    </div>

    <!-- Phân trang -->
    <div class="d-flex justify-content-center mt-5">
        <ul class="pagination justify-content-center gap-2" id="pagination">
            <!-- Pagination rendered by JS -->
        </ul>
    </div>
</main>

<!-- ================= MODALS ================= -->

<!-- Modal Xem Chi Tiết / Cập Nhật / Thêm -->
<div class="modal fade" id="accountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-header-custom">
                <h5 class="modal-title" id="modalTitle">Tiêu đề modal</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="accountForm">
                    <input type="hidden" id="formAction" value="">
                    <input type="hidden" id="maTK" value="">

                    <div class="form-group-title">THÔNG TIN CƠ BẢN</div>
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="hoTen" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Gmail <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="gmail" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="sdt" required pattern="[0-9]{10}">
                        </div>
                    </div>

                    <!-- Khu vực dành riêng cho Du khách khi XEM CHI TIẾT -->
                    <div id="extraInfoDuKhach" style="display: none;">
                        <div class="form-group-title">THÔNG TIN CÁ NHÂN (DU KHÁCH)</div>
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ngày sinh</label>
                                <input type="text" class="form-control" id="ngaySinh" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Giới tính</label>
                                <input type="text" class="form-control" id="gioiTinh" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" id="diaChi" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">SĐT Khẩn cấp</label>
                                <input type="text" class="form-control" id="sdtKhanCap" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-group-title">PHÂN QUYỀN & TRẠNG THÁI</div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Vai trò <span class="text-danger">*</span></label>
                            <select class="form-select" id="loaiTK" required>
                                <option value="">-- Chọn --</option>
                                <option value="Quản trị viên">Quản trị viên</option>
                                <option value="Du khách">Du khách</option>
                            </select>
                        </div>
                        
                        <!-- Chức danh cho QTV -->
                        <div class="col-md-6 mb-3" id="wrapChucDanh">
                            <label class="form-label">Chức danh <span class="text-danger">*</span></label>
                            <select class="form-select" id="chucDanh">
                                <option value="">-- Chọn --</option>
                                <option value="Nhân viên">Nhân viên</option>
                                <option value="Trưởng phòng">Trưởng phòng</option>
                            </select>
                        </div>

                        <!-- Hạng thành viên cho DK (Chỉ Readonly khi View/Edit và luôn tô xám) -->
                        <div class="col-md-6 mb-3" id="wrapHangThanhVien" style="display: none;">
                            <label class="form-label">Hạng thành viên</label>
                            <input type="text" class="form-control" id="hangThanhVien" readonly style="background-color: #e9ecef;">
                        </div>

                        <div class="col-md-12 mt-2">
                            <label class="form-label me-3">Trạng thái tài khoản:</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="trangThai" id="ttHoatDong" value="Hoạt động" checked>
                                <label class="form-check-label" for="ttHoatDong">Hoạt động</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="trangThai" id="ttBiKhoa" value="Bị khóa">
                                <label class="form-check-label" for="ttBiKhoa">Bị khóa</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-submit-modal" id="btnSubmitForm">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // --- STATE VARIABLES ---
    let currentPage = 1;
    let searchTimeout = null;

    // Khai báo biến
    let tableBody, searchInput, roleFilter, rankFilter, pagination;
    let accountModal, form, modalTitle, btnSubmitForm;
    
    const API_URL = 'index.php?controller=adminaccount&action=index&ajax_action=';

    // --- INITIALIZATION ---
    document.addEventListener("DOMContentLoaded", () => {
        tableBody = document.getElementById('tableBody');
        searchInput = document.getElementById('searchInput');
        roleFilter = document.getElementById('roleFilter');
        rankFilter = document.getElementById('rankFilter');
        pagination = document.getElementById('pagination');
        form = document.getElementById('accountForm');
        modalTitle = document.getElementById('modalTitle');
        btnSubmitForm = document.getElementById('btnSubmitForm');
        
        try {
            if (typeof bootstrap !== 'undefined') {
                accountModal = new bootstrap.Modal(document.getElementById('accountModal'));
            }
        } catch (error) {
            console.warn("Bootstrap JS chưa sẵn sàng: ", error);
        }

        if (tableBody) loadData();

        if (searchInput) {
            searchInput.addEventListener('input', () => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => { currentPage = 1; loadData(); }, 500);
            });
        }

        if (roleFilter) {
            roleFilter.addEventListener('change', () => {
                if(roleFilter.value === 'Du khách') {
                    rankFilter.disabled = false;
                } else {
                    rankFilter.disabled = true;
                    rankFilter.value = "";
                }
                currentPage = 1; 
                loadData();
            });
        }

        if (rankFilter) rankFilter.addEventListener('change', () => { currentPage = 1; loadData(); });

        const loaiTKElement = document.getElementById('loaiTK');
        if (loaiTKElement) {
            loaiTKElement.addEventListener('change', function() {
                toggleRoleFields(this.value);
            });
        }

        if (form) form.addEventListener('submit', handleFormSubmit);
    });

    // --- HELPER CHUYỂN HƯỚNG KHI BỊ KHÓA ---
    function checkForceLogout(result) {
        if (result && result.redirect) {
            alert(result.message); // Hiện thông báo bị khóa
            window.location.href = result.redirect; // Đá văng về trang chủ
            return true;
        }
        return false;
    }

    // --- Helpers Mở / Đóng Modal ---
    function showModalHelper() {
        if (accountModal) accountModal.show();
        else if (typeof $ !== 'undefined' && $.fn.modal) $('#accountModal').modal('show'); 
    }

    function hideModalHelper() {
        if (accountModal) accountModal.hide();
        else if (typeof $ !== 'undefined' && $.fn.modal) $('#accountModal').modal('hide');
    }

    // --- FETCH DATA ---
    async function loadData() {
        tableBody.innerHTML = '<tr><td colspan="6"><i class="fa-solid fa-spinner fa-spin"></i> Đang tải dữ liệu...</td></tr>';
        
        const params = new URLSearchParams({
            search: searchInput.value,
            role: roleFilter.value,
            rank: rankFilter.disabled ? '' : rankFilter.value,
            page: currentPage
        });

        try {
            const response = await fetch(API_URL + 'getList&' + params.toString());
            const textRaw = await response.text(); 
            
            try {
                const result = JSON.parse(textRaw);
                
                // KIỂM TRA BỊ ĐĂNG XUẤT
                if (checkForceLogout(result)) return;

                if (result.status === 'success') {
                    renderTable(result.data);
                    renderPagination(result.totalPages);
                } else {
                    tableBody.innerHTML = `<tr><td colspan="6" class="text-danger">Lỗi: ${result.message}</td></tr>`;
                }
            } catch (jsonError) {
                console.error("Lỗi Parse JSON: ", textRaw);
                tableBody.innerHTML = '<tr><td colspan="6" class="text-danger"><b>Lỗi Backend!</b></td></tr>';
            }
        } catch (error) {
            tableBody.innerHTML = '<tr><td colspan="6" class="text-danger">Lỗi kết nối máy chủ!</td></tr>';
        }
    }

    // --- RENDER UI ---
    function renderTable(data) {
        if (!data || data.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="6" class="text-muted">Không tìm thấy tài khoản nào.</td></tr>';
            return;
        }

        let html = '';
        data.forEach(item => {
            let rankHtml = '';
            if (item.LoaiTK === 'Du khách') {
                let rankClass = '';
                if(item.HangThanhVien === 'Kim Cương') rankClass = 'rank-kimcuong';
                else if(item.HangThanhVien === 'Vàng') rankClass = 'rank-vang';
                else if(item.HangThanhVien === 'Bạc') rankClass = 'rank-bac';
                else rankClass = 'rank-dong';
                rankHtml = `<span class="badge-rank ${rankClass}">${item.HangThanhVien}</span>`;
            }

            let statusHtml = item.TrangThai === 'Hoạt động' 
                ? '<span class="badge-status status-active">Hoạt động</span>' 
                : '<span class="badge-status status-locked">Bị khóa</span>';

            html += `
                <tr>
                    <td class="text-start font-weight-bold">${item.HoTen}</td>
                    <td>${item.SDT || '---'}</td>
                    <td style="font-weight: 600;">${item.LoaiTK === 'Quản trị viên' ? 'QTV' : 'Du khách'}</td>
                    <td>${rankHtml}</td>
                    <td>${statusHtml}</td>
                    <td>
                        <i class="fa-solid fa-eye action-icon" onclick="openViewModal('${item.MaTK}')" title="Xem"></i>
                        <i class="fa-solid fa-pen-to-square action-icon" style="color: #4CAF50;" onclick="openEditModal('${item.MaTK}')" title="Sửa"></i>
                        <i class="fa-solid fa-trash action-icon" style="color: #D32F2F;" onclick="deleteAccount('${item.MaTK}')" title="Xóa"></i>
                    </td>
                </tr>
            `;
        });
        tableBody.innerHTML = html;
    }

    function renderPagination(totalPages) {
        let html = '';
        if (totalPages > 1) {
            html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link rounded text-success fw-bold" href="#" onclick="changePage(${currentPage - 1}); return false;"><i class="fa-solid fa-chevron-left"></i></a>
                     </li>`;
            for (let i = 1; i <= totalPages; i++) {
                html += `<li class="page-item">
                            <a class="page-link rounded fw-bold ${currentPage === i ? 'bg-success text-white' : 'text-success'}" href="#" onclick="changePage(${i}); return false;">${i}</a>
                         </li>`;
            }
            html += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                        <a class="page-link rounded text-success fw-bold" href="#" onclick="changePage(${currentPage + 1}); return false;"><i class="fa-solid fa-chevron-right"></i></a>
                     </li>`;
        }
        pagination.innerHTML = html;
    }

    function changePage(page) {
        currentPage = page;
        loadData();
    }

    // --- MODAL ACTIONS ---
    function setReadOnly(isReadOnly) {
        const inputs = form.querySelectorAll('input:not([type="radio"]), select');
        inputs.forEach(input => {
            if(input.id !== 'formAction' && input.id !== 'maTK' && input.id !== 'hangThanhVien') {
                input.readOnly = isReadOnly;
                input.disabled = (input.tagName === 'SELECT') ? isReadOnly : false;
                input.style.backgroundColor = isReadOnly ? '#e9ecef' : '';
            }
        });
        form.querySelectorAll('input[type="radio"]').forEach(radio => radio.disabled = isReadOnly);
    }

    function toggleRoleFields(role, action = '') {
        const wrapChucDanh = document.getElementById('wrapChucDanh');
        const chucDanhSelect = document.getElementById('chucDanh');
        const wrapHangThanhVien = document.getElementById('wrapHangThanhVien');
        const extraInfoDuKhach = document.getElementById('extraInfoDuKhach');

        if (role === 'Quản trị viên') {
            wrapChucDanh.style.display = 'block';
            chucDanhSelect.required = true;
            wrapHangThanhVien.style.display = 'none';
            extraInfoDuKhach.style.display = 'none';
        } else if (role === 'Du khách') {
            wrapChucDanh.style.display = 'none';
            chucDanhSelect.required = false;
            
            if(action === 'view' || action === 'edit') wrapHangThanhVien.style.display = 'block';
            else wrapHangThanhVien.style.display = 'none';

            extraInfoDuKhach.style.display = (action === 'view') ? 'block' : 'none';
        } else {
            wrapChucDanh.style.display = 'none';
            wrapHangThanhVien.style.display = 'none';
            extraInfoDuKhach.style.display = 'none';
            chucDanhSelect.required = false;
        }
    }

    function openAddModal() {
        form.reset();
        document.getElementById('formAction').value = 'add';
        modalTitle.innerText = 'Thêm tài khoản';
        btnSubmitForm.innerText = '+ Thêm';
        btnSubmitForm.style.display = 'inline-block';
        
        setReadOnly(false);
        document.getElementById('loaiTK').disabled = false;
        toggleRoleFields('');

        showModalHelper();
    }

    async function openEditModal(maTK) {
        document.getElementById('formAction').value = 'update';
        document.getElementById('maTK').value = maTK;
        modalTitle.innerText = 'Cập nhật tài khoản';
        btnSubmitForm.innerText = 'Cập nhật';
        btnSubmitForm.style.display = 'inline-block';
        
        await fetchAccountDetail(maTK, 'edit');
    }

    async function openViewModal(maTK) {
        document.getElementById('formAction').value = 'view';
        modalTitle.innerText = 'Xem chi tiết tài khoản';
        btnSubmitForm.innerText = 'Đóng'; 
        btnSubmitForm.onclick = (e) => { e.preventDefault(); hideModalHelper(); };
        
        await fetchAccountDetail(maTK, 'view');
    }

    async function fetchAccountDetail(maTK, action) {
        try {
            const response = await fetch(API_URL + 'getDetail&maTK=' + maTK);
            const result = await response.json();
            
            // KIỂM TRA BỊ ĐĂNG XUẤT
            if (checkForceLogout(result)) return;
            
            if(result.status === 'success') {
                const data = result.data;
                document.getElementById('hoTen').value = data.HoTen;
                document.getElementById('gmail').value = data.Gmail;
                document.getElementById('sdt').value = data.SDT || '';
                document.getElementById('loaiTK').value = data.LoaiTK;
                
                if (data.TrangThai === 'Hoạt động') document.getElementById('ttHoatDong').checked = true;
                else document.getElementById('ttBiKhoa').checked = true;

                toggleRoleFields(data.LoaiTK, action);

                if (data.LoaiTK === 'Quản trị viên') {
                    document.getElementById('chucDanh').value = data.ChucDanh;
                } else {
                    document.getElementById('hangThanhVien').value = data.HangThanhVien;
                    if(action === 'view') {
                        document.getElementById('ngaySinh').value = data.NgaySinh || 'Chưa cập nhật';
                        document.getElementById('gioiTinh').value = data.GioiTinh || 'Chưa cập nhật';
                        document.getElementById('diaChi').value = data.DiaChi || 'Chưa cập nhật';
                        document.getElementById('sdtKhanCap').value = data.SDTKhanCap || 'Chưa cập nhật';
                    }
                }

                if(action === 'edit') {
                    setReadOnly(false);
                    const loaiTKEl = document.getElementById('loaiTK');
                    loaiTKEl.disabled = true;
                    loaiTKEl.style.backgroundColor = '#e9ecef';
                    
                    const hoTenEl = document.getElementById('hoTen');
                    hoTenEl.readOnly = true;
                    hoTenEl.style.backgroundColor = '#e9ecef';

                    btnSubmitForm.onclick = null;
                } else if(action === 'view') {
                    setReadOnly(true);
                }

                showModalHelper();
            } else {
                alert(result.message);
            }
        } catch(e) {
            alert('Lỗi khi lấy dữ liệu tài khoản');
        }
    }

    async function handleFormSubmit(e) {
        e.preventDefault();
        const action = document.getElementById('formAction').value;
        if(action === 'view') return;

        const data = {
            MaTK: document.getElementById('maTK').value,
            HoTen: document.getElementById('hoTen').value,
            Gmail: document.getElementById('gmail').value,
            SDT: document.getElementById('sdt').value,
            LoaiTK: document.getElementById('loaiTK').value,
            TrangThai: document.querySelector('input[name="trangThai"]:checked').value,
        };

        if(data.LoaiTK === 'Quản trị viên') {
            data.ChucDanh = document.getElementById('chucDanh').value;
        }

        const btnOriginalText = btnSubmitForm.innerText;
        btnSubmitForm.innerText = 'Đang xử lý...';
        btnSubmitForm.disabled = true;

        try {
            const response = await fetch(API_URL + action, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            const result = await response.json();

            // KIỂM TRA BỊ ĐĂNG XUẤT
            if (checkForceLogout(result)) return;

            if (result.status === 'success') {
                alert(result.message);
                hideModalHelper();
                loadData();
            } else {
                alert(result.message);
            }
        } catch (error) {
            alert('Lỗi kết nối đến máy chủ!');
        } finally {
            btnSubmitForm.innerText = btnOriginalText;
            btnSubmitForm.disabled = false;
        }
    }

    async function deleteAccount(maTK) {
        if(confirm('Bạn có chắc chắn muốn XÓA tài khoản này không? Việc này không thể hoàn tác.')) {
            try {
                const response = await fetch(API_URL + 'delete', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ MaTK: maTK })
                });
                const result = await response.json();
                
                // KIỂM TRA BỊ ĐĂNG XUẤT
                if (checkForceLogout(result)) return;
                
                if(result.status === 'success') {
                    alert('Đã xóa thành công!');
                    loadData();
                } else {
                    alert(result.message);
                }
            } catch(e) {
                alert('Lỗi kết nối máy chủ!');
            }
        }
    }
</script>