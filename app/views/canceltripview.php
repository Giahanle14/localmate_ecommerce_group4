<style>
    :root {
        --primary: #1A5336;
        --bg-color: #FDFDF9;
        --danger: #DC2626;
        --warning-bg: #FFFBEB;
        --warning-border: #FDE68A;
        --warning-text: #D97706;
    }
    
    body { background-color: var(--bg-color); font-family: 'Quicksand', sans-serif; }    
    .cancel-container { max-width: 800px; margin: 0 auto 100px; padding: 0 20px; }
    .page-title { font-weight: 800; color: var(--primary); font-size: 2.2rem; margin-bottom: 30px; text-align: center; }

    /* Hộp Cảnh báo Chính sách */
    .policy-alert { background-color: var(--warning-bg); border: 2px solid var(--warning-border); border-radius: 16px; padding: 25px; margin-bottom: 30px; }
    .policy-alert h5 { color: var(--warning-text); font-weight: 800; margin-bottom: 15px; display: flex; align-items: center; gap: 10px; font-size: 1.15rem; }
    .policy-list { margin: 0; padding-left: 20px; color: #555; line-height: 1.8; font-weight: 600; font-size: 0.95rem; }

    /* Hộp Thông tin chuyến đi */
    .trip-summary-box { background: #fff; border: 1px solid #f0f0f0; border-radius: 16px; padding: 25px; margin-bottom: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); }
    .summary-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; font-size: 1rem; border-bottom: 1px dashed #f1f5f9; padding-bottom: 10px; }
    .summary-row:last-child { margin-bottom: 0; padding-bottom: 0; border-bottom: none; }
    .sum-label { color: #64748b; font-weight: 600; }
    .sum-value { color: #1e293b; font-weight: 800; text-align: right; }
    .highlight-price { font-size: 1.25rem; color: var(--danger); font-weight: 900; }
    .highlight-refund { font-size: 1.25rem; color: var(--primary); font-weight: 900; }

    /* Hộp Form nhập liệu */
    .cancel-form-box { background: #fff; border: 1px solid #f0f0f0; border-radius: 16px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); margin-bottom: 30px; }
    .form-label { font-weight: 800; color: #111; font-size: 1.05rem; margin-bottom: 10px; }
    .form-control, .form-select { border-radius: 12px; padding: 14px 18px; border: 1.5px solid #e2e8f0; font-weight: 600; color: #333; transition: 0.3s; background-color: #f8fafc; }
    .form-control:focus, .form-select:focus { border-color: var(--danger); box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1); background-color: #fff;}

    /* Checkbox & Buttons */
    .terms-check { font-weight: 600; font-size: 0.95rem; color: #475569; display: flex; gap: 10px; align-items: flex-start; margin-bottom: 30px; cursor: pointer;}
    .terms-check input { margin-top: 4px; width: 18px; height: 18px; accent-color: var(--danger); }
    
    .btn-action-group { display: flex; gap: 20px; }
    .btn-back { border: 2px solid #cbd5e1; color: #475569; background: #fff; padding: 14px 30px; border-radius: 12px; font-weight: 800; font-size: 1.05rem; transition: 0.3s; flex: 1; text-transform: uppercase; text-decoration: none; text-align: center;}
    .btn-back:hover { background: #f1f5f9; color: #1e293b; border-color: #94a3b8; }
    .btn-submit { background: var(--danger); color: #fff; border: none; padding: 14px 30px; border-radius: 12px; font-weight: 800; font-size: 1.05rem; transition: 0.3s; flex: 1; text-transform: uppercase; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.25); cursor: pointer;}
    .btn-submit:hover { background: #b91c1c; color: #fff; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(220, 38, 38, 0.35); }

    /* =======================================
       CSS CHO POP-UP XÁC NHẬN HỦY
       ======================================= */
    .modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(245, 245, 240, 0.75);
        backdrop-filter: blur(4px);
        z-index: 9999; display: flex; align-items: center; justify-content: center;
        opacity: 0; pointer-events: none; transition: 0.3s ease;
    }
    .modal-overlay.show { opacity: 1; pointer-events: auto; }
    .modal-box {
        background: #fff; border: 2px solid #111; border-radius: 20px;
        padding: 40px 30px; text-align: center; max-width: 450px; width: 90%;
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
        transform: translateY(-20px); transition: 0.3s ease;
    }
    .modal-overlay.show .modal-box { transform: translateY(0); }
    .modal-box h3 { font-size: 1.9rem; font-weight: 800; color: #111; line-height: 1.3; margin-bottom: 35px; }
    .modal-btn-group { display: flex; justify-content: center; gap: 15px; }
    
    .btn-modal-gray { background: #9CA3AF; color: white; border: none; padding: 10px 25px; border-radius: 12px; font-weight: 800; font-size: 1.1rem; cursor: pointer; transition: 0.3s; min-width: 120px; white-space: nowrap; }
    .btn-modal-gray:hover { background: #6B7280; }
    .btn-modal-red { background: #DC2626; color: white; border: none; padding: 10px 25px; border-radius: 12px; font-weight: 800; font-size: 1.1rem; cursor: pointer; transition: 0.3s; min-width: 120px; white-space: nowrap; }
    .btn-modal-red:hover { background: #B91C1C; }

    @media (max-width: 768px) {
        .btn-action-group { flex-direction: column-reverse; gap: 15px; }
        .summary-row { flex-direction: column; align-items: flex-start; gap: 5px; }
        .sum-value { text-align: left; }
    }
</style>

<div class="breadcrumb-custom">
    <a href="index.php?controller=home"><i class="fa-solid fa-house me-1"></i>Trang chủ</a> 
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <a href="index.php?controller=mytrip">Chuyến đi của tôi</a> 
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <a href="index.php?controller=tripdetail&id=<?= htmlspecialchars($trip['MaChuyenDi']) ?>">Chi tiết chuyến đi</a>
    <i class="fa-solid fa-angle-right mx-2 text-muted" style="font-size: 12px;"></i> 
    <span class="text-dark fw-bold">Hủy chuyến</span>
</div>

<div class="cancel-container">
    <h1 class="page-title">Yêu cầu hủy chuyến đi</h1>

    <div class="policy-alert">
        <h5><i class="fa-solid fa-triangle-exclamation"></i> Chính sách hủy chuyến & Hoàn tiền</h5>
        <ul class="policy-list">
            <li>Hủy trước <strong>7 ngày</strong> tính từ ngày khởi hành: Hoàn <strong>100%</strong> tổng tiền.</li>
            <li>Hủy từ <strong>3 - 6 ngày</strong> tính từ ngày khởi hành: Hoàn <strong>50%</strong> tổng tiền.</li>
            <li>Hủy trong vòng <strong>3 ngày</strong> hoặc không tham gia: <strong>Không hoàn tiền</strong>.</li>
            <li class="mt-2 text-danger"><i>Lưu ý: Thời gian hoàn tiền từ 3 - 5 ngày làm việc (không tính T7, CN). Hành động này không thể hoàn tác.</i></li>
        </ul>
    </div>

    <div class="trip-summary-box">
        <div class="summary-row">
            <span class="sum-label">Mã chuyến đi</span>
            <span class="sum-value" style="color: var(--primary);"><?= htmlspecialchars($trip['MaChuyenDi']) ?></span>
        </div>
        <div class="summary-row">
            <span class="sum-label">Tên Tour</span>
            <span class="sum-value"><?= htmlspecialchars($trip['TenTour']) ?></span>
        </div>
        <div class="summary-row">
            <span class="sum-label">Ngày khởi hành</span>
            <span class="sum-value"><?= date('d/m/Y', strtotime($trip['NgayBatDau'])) ?></span>
        </div>
        <div class="summary-row mt-3 pt-3" style="border-top: 2px solid #e2e8f0;">
            <span class="sum-label text-dark">Tổng tiền đã thanh toán</span>
            <span class="highlight-price"><?= number_format($trip['TongGiaTien'], 0, ',', '.') ?> VNĐ</span>
        </div>
        <div class="summary-row mt-2" style="background: #eaf5eb; padding: 15px; border-radius: 12px; border: 1px solid #c9d8c9;">
            <span class="sum-label text-dark"><i class="fa-solid fa-hand-holding-dollar" style="color: var(--primary);"></i> Số tiền hoàn trả dự kiến (<?= $tyLeHoan * 100 ?>%)</span>
            <span class="highlight-refund"><?= number_format($soTienHoan, 0, ',', '.') ?> VNĐ</span>
        </div>
    </div>

    <form action="index.php?controller=canceltrip&action=process" method="POST" id="cancelForm">
        <input type="hidden" name="ma_chuyen_di" value="<?= htmlspecialchars($trip['MaChuyenDi']) ?>">

        <div class="cancel-form-box">
            <div class="mb-4">
                <label class="form-label">Lý do hủy chuyến <span class="text-danger">*</span></label>
                <select name="ly_do_select" id="ly_do_select" class="form-select" required>
                    <option value="" disabled selected>-- Chọn lý do hủy --</option>
                    <option value="Thay đổi kế hoạch cá nhân">Thay đổi kế hoạch cá nhân</option>
                    <option value="Vấn đề sức khỏe cá nhân/Gia đình">Vấn đề sức khỏe cá nhân/Gia đình</option>
                    <option value="Thời tiết xấu tại điểm đến">Thời tiết xấu tại điểm đến</option>
                    <option value="Tìm được lựa chọn khác tốt hơn">Tìm được lựa chọn khác tốt hơn</option>
                    <option value="Lý do khác">Lý do khác</option>
                </select>
            </div>

            <div class="mb-2">
                <label class="form-label">Chi tiết lý do (Tùy chọn)</label>
                <textarea name="chi_tiet_ly_do" class="form-control" rows="4" placeholder="Vui lòng cung cấp thêm thông tin (nếu có) để chúng tôi cải thiện dịch vụ tốt hơn..."></textarea>
            </div>
        </div>

        <label class="terms-check" for="termsCheck">
            <input type="checkbox" id="termsCheck" required>
            <span>Tôi đã đọc và đồng ý với <strong>Chính sách hủy chuyến</strong> của LocalMate. Tôi hiểu rằng thao tác này không thể hoàn tác sau khi bấm xác nhận.</span>
        </label>

        <div class="btn-action-group">
            <a href="javascript:history.back()" class="btn-back">Quay lại</a>
            <button type="submit" class="btn-submit">Hủy chuyến</button>
        </div>
    </form>
</div>

<div id="confirmCancelModal" class="modal-overlay">
    <div class="modal-box">
        <h3>Bạn chắc chắn muốn<br>hủy tour này?</h3>
        <div class="modal-btn-group">
            <button type="button" class="btn-modal-gray" onclick="closeModal()">Không, quay lại</button>
            
            <button type="button" class="btn-modal-red" onclick="submitRealForm()">Xác nhận hủy</button>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('cancelForm');
    const modal = document.getElementById('confirmCancelModal');

    // Chặn submit mặc định để hiện Pop-up
    form.addEventListener('submit', function(e) {
        e.preventDefault(); 
        const terms = document.getElementById('termsCheck');
        if (!terms.checked) {
            alert('Vui lòng đánh dấu xác nhận đồng ý với chính sách hủy chuyến!');
        } else {
            // Mở Pop-up xác nhận
            modal.classList.add('show');
        }
    });

    // Hàm đóng Pop-up (Gắn vào nút Hủy màu đỏ)
    function closeModal() {
        modal.classList.remove('show');
    }

    // Hàm gửi Form đi (Gắn vào nút Tiếp tục màu xám)
    function submitRealForm() {
        form.submit();
    }
</script>