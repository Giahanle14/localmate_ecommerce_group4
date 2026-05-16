<style>
    .lm-footer {
        background-color: #0d5c2c; /* Màu nền xanh chuẩn của LocalMate */
        color: white;
        padding: 50px 40px;
        font-size: 13px;
        font-family: 'Quicksand', sans-serif;
        margin-top: 50px;
    }
    .footer-container {
        display: grid;
        /* Chia tỷ lệ các cột để phần Công ty và Chính sách có không gian rộng hơn */
        grid-template-columns: 2fr 3fr 1.5fr 1.8fr 2fr; 
        gap: 30px;
    }
    
    /* Chỉnh logo và đoạn mô tả */
    .lm-footer-col1 img {
        height: 70px; /* Phóng to logo */
        margin-bottom: 20px;
    }
    .lm-footer-col1 p {
        line-height: 1.8;
        opacity: 0.9;
    }

    /* Tiêu đề các cột */
    .lm-footer h5 {
        font-weight: bold;
        margin-bottom: 25px;
        font-size: 14px;
        text-transform: uppercase;
    }

    /* Định dạng danh sách có dấu chấm (•) */
    .lm-footer ul {
        list-style-type: disc; /* Thêm dấu chấm tròn */
        padding-left: 15px; /* Thụt lề cho dấu chấm */
        line-height: 2.2;
        margin: 0;
    }
    .lm-footer a {
        color: white;
        text-decoration: none;
        opacity: 0.9;
    }
    .lm-footer a:hover {
        text-decoration: underline;
        opacity: 1;
    }

    /* Riêng cột thông tin công ty dùng dấu chấm tùy chỉnh cho đẹp */
    .company-info {
        list-style: none !important;
        padding-left: 0 !important;
    }
    .company-info li {
        position: relative;
        padding-left: 15px;
        margin-bottom: 8px;
        line-height: 1.6;
    }
    .company-info li::before {
        content: "•";
        position: absolute;
        left: 0;
        top: 0;
        font-size: 16px;
    }

    /* Khu vực MXH và Thanh toán */
    .bottom-actions {
        display: flex;
        gap: 60px;
        margin-top: 25px;
    }
    .bottom-actions-block {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .bottom-actions-block b {
        font-size: 13px;
    }
    .social-icons {
        display: flex;
        gap: 15px;
        font-size: 22px;
    }
    .payment-icons {
        display: flex;
        gap: 10px;
    }
    .payment-icons img {
        height: 25px;
        width: 25px;
        object-fit: contain;
        background: white;
        padding: 3px;
        border-radius: 4px;
    }
</style>

<footer class="lm-footer">
    <div class="footer-container">
        
        <div class="lm-footer-col1">
            <img src="image/logo.png" alt="LocalMate Logo">
            <p>LocalMate là nền tảng thương mại điện tử theo mô hình kinh tế chia sẻ, kết nối trực tiếp du khách với người bản địa. Chúng tôi mang đến những trải nghiệm du lịch chân thực, an toàn và đậm đà bản sắc văn hóa.</p>
        </div>

        <div>
            <h5>CÔNG TY CỔ PHẦN CÔNG NGHỆ DU LỊCH LOCALMATE</h5>
            <ul class="company-info">
                <li><b>Trụ sở chính:</b> Khu Công nghệ Phần mềm, ĐHQG TP. HCM, KP 6, P. Linh Trung, TP. Thủ Đức, TP. HCM.</li>
                <li><b>Điện thoại:</b> +84 123 456 789</li>
                <li><b>Email:</b> hello@localmate.vn</li>
            </ul>

            <div class="bottom-actions">
                <div class="bottom-actions-block">
                    <b>MẠNG XÃ HỘI</b>
                    <div class="social-icons">
                        <a href="#"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-tiktok"></i></a>
                    </div>
                </div>
                <div class="bottom-actions-block">
                    <b>PHƯƠNG THỨC THANH TOÁN</b>
                    <div class="payment-icons">
                        <img src="source/logo/vnpay.png" alt="VNPAY">
                        <img src="source/logo/momo.png" alt="MoMo">
                    </div>
                </div>
            </div>
        </div>

        <div>
            <h5>VỀ CHÚNG TÔI</h5>
            <ul>
                <li><a href="#">Giới thiệu về LocalMate</a></li>
                <li><a href="#">Cách thức hoạt động</a></li>
                <li><a href="#">Cẩm nang du lịch (Blog)</a></li>
                <li><a href="#">Liên hệ hỗ trợ</a></li>
            </ul>
        </div>

        <div>
            <h5>KHÁM PHÁ</h5>
            <ul>
                <li><a href="#">Food Tour & Ẩm thực</a></li>
                <li><a href="#">Khám phá văn hóa & Lịch sử</a></li>
                <li><a href="#">Phượt xe máy trải nghiệm</a></li>
                <li><a href="#">Nghệ thuật & Làng nghề</a></li>
                <li><a href="#">Du lịch chữa lành (Healing)</a></li>
            </ul>
        </div>

        <div>
            <h5>CHÍNH SÁCH</h5>
            <ul>
                <li><a href="#">Quy chế hoạt động nền tảng</a></li>
                <li><a href="#">Điều khoản sử dụng dịch vụ</a></li>
                <li><a href="#">Chính sách bảo mật thông tin</a></li>
                <li><a href="#">Quy định thanh toán & Tạm giữ</a></li>
                <li><a href="#">Chính sách hủy tour & Hoàn tiền</a></li>
                <li><a href="#">Cơ chế giải quyết tranh chấp</a></li>
                <li><a href="#">Tiêu chuẩn cộng đồng an toàn</a></li>
            </ul>
        </div>
        
    </div>
</footer>