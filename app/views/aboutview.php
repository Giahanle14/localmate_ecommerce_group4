<?php require_once 'app/views/layouts/header.php'; ?>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Quicksand', sans-serif; background-color: #F8FAF5; }
    
    /* Đồng bộ thanh điều hướng */
    .breadcrumb-custom { padding: 15px 40px; font-weight: 500; color: #0d5c2c; background: white; border-bottom: 1px solid #eee; }
    .breadcrumb-custom a { color: #0d5c2c; text-decoration: none; }
    .breadcrumb-custom a:hover { text-decoration: underline; }

    /* Khu vực Title & Text */
    .about-section { padding: 60px 0; }
    .about-title { font-weight: 700; color: #00712D; font-size: 2.5rem; margin-bottom: 20px; line-height: 1.3;}
    .about-subtitle { font-weight: 700; color: #F89B29; font-size: 1rem; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 2px; }
    .about-text { color: #555; line-height: 1.8; font-size: 1.1rem; text-align: justify; margin-bottom: 20px;}
    .about-img { border-radius: 20px; width: 100%; box-shadow: 0 10px 30px rgba(0,0,0,0.1); object-fit: cover; height: 450px; }

    /* Khu vực Giá trị cốt lõi */
    .value-card { background: white; border-radius: 20px; padding: 40px 30px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.03); height: 100%; transition: 0.3s; border: 1px solid #f0f0f0; }
    .value-card:hover { transform: translateY(-10px); border-color: #00712D; box-shadow: 0 15px 40px rgba(0, 113, 45, 0.1);}
    .value-icon { width: 80px; height: 80px; background: #EBF6E0; color: #00712D; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 20px; transition: 0.3s;}
    .value-card:hover .value-icon { background: #00712D; color: white; }
    .value-title { font-weight: 700; color: #1B3B2B; margin-bottom: 15px; font-size: 1.3rem; }
    .value-desc { color: #666; line-height: 1.6; }

    /* Khu vực Đội ngũ */
    .team-img-wrap { position: relative; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    .team-img-wrap img { width: 100%; height: 400px; object-fit: cover; transition: 0.5s; }
    .team-img-wrap:hover img { transform: scale(1.05); }

    /* Khu vực Testimonial (Cảm nhận khách hàng) */
    .testimonial-card { background: white; border-radius: 20px; padding: 35px 30px 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); position: relative; border: 1px solid #f0f0f0; height: 100%; margin-top: 20px;}
    .quote-icon { position: absolute; top: -20px; left: 30px; background: #F89B29; color: white; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; box-shadow: 0 5px 15px rgba(248, 155, 41, 0.3); }
    .testimonial-text { color: #555; line-height: 1.7; font-size: 1.05rem; font-style: italic; margin-bottom: 20px; }
    .customer-info { display: flex; align-items: center; gap: 15px; border-top: 1px dashed #eee; padding-top: 15px; }
    .customer-avatar { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; background: #e0e0e0;}
    .customer-name { font-weight: 700; color: #1B3B2B; margin-bottom: 0; }
    .stars { color: #FF9F00; font-size: 0.9rem; }

    /* Khu vực Kêu gọi hành động (CTA) */
    .cta-section { background: linear-gradient(135deg, #00712D 0%, #004d1f 100%); color: white; padding: 60px 0; border-radius: 20px; margin-bottom: 80px; text-align: center; box-shadow: 0 10px 20px rgba(0, 113, 45, 0.2); }
    .btn-cta { background: #F89B29; color: white; font-weight: 700; border-radius: 30px; padding: 12px 35px; border: none; font-size: 1.1rem; transition: 0.3s; margin-top: 20px; display: inline-block; text-decoration: none;}
    .btn-cta:hover { background: #e08920; color: white; transform: scale(1.05);}
</style>

<div class="breadcrumb-custom">
    <a href="index.php?controller=home">Trang chủ</a> >
    <span style="color: #666;">Về LocalMate</span>
</div>

<div class="container about-section">
    <div class="row align-items-center mb-5 pb-5">
        <div class="col-lg-6 mb-4 mb-lg-0 pe-lg-5">
            <div class="about-subtitle">CÂU CHUYỆN CỦA CHÚNG TÔI</div>
            <h1 class="about-title">Mang đến những hành trình du lịch trọn vẹn và khác biệt</h1>
            <p class="about-text">
                LocalMate ra đời với khát vọng mang đến cho du khách những trải nghiệm du lịch chất lượng cao, an toàn và đầy cảm hứng. Chúng tôi không ngừng nỗ lực tự tay khảo sát, thiết kế và tổ chức những tour du lịch độc quyền, đáp ứng đa dạng nhu cầu của mọi hành khách.
            </p>
            <p class="about-text">
                Tại LocalMate, mỗi chuyến đi không chỉ là việc đặt chân đến một vùng đất mới, mà là sự tận hưởng dịch vụ chuyên nghiệp từ A đến Z. Khách du lịch sẽ hoàn toàn an tâm trao gửi kỳ nghỉ của mình cho chúng tôi để nhận lại những khoảnh khắc đáng giá nhất bên gia đình và người thân.
            </p>
        </div>
        
        <div class="col-lg-6">
            <?php
                $duongDanThuMuc = 'public/image/tour/*.{jpg,jpeg,png,gif}'; 
                $tourImages = glob($duongDanThuMuc, GLOB_BRACE);
                
                if (empty($tourImages)) {
                    $tourImages = [
                        'https://images.unsplash.com/photo-1528164344705-47542687000d?auto=format&fit=crop&w=1000&q=80',
                        'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=1000&q=80',
                        'https://images.unsplash.com/photo-1583417319070-4a69db38a482?auto=format&fit=crop&w=1000&q=80'
                    ];
                } else {
                    shuffle($tourImages);
                    $tourImages = array_slice($tourImages, 0, 5);
                }
            ?>
            <div id="aboutCarousel" class="carousel slide carousel-fade shadow-sm" data-bs-ride="carousel" data-bs-interval="3000" style="border-radius: 20px; overflow: hidden;">
                <div class="carousel-inner">
                    <?php foreach($tourImages as $index => $img): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <img src="<?= htmlspecialchars($img) ?>" class="d-block w-100 about-img" alt="LocalMate Tour" style="height: 450px; object-fit: cover; border-radius: 20px;">
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#aboutCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true" style="filter: drop-shadow(0px 0px 3px rgba(0,0,0,0.8));"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#aboutCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true" style="filter: drop-shadow(0px 0px 3px rgba(0,0,0,0.8));"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <div class="row mb-5 pb-5 border-bottom">
        <div class="col-12 text-center mb-5">
            <div class="about-subtitle">Tầm nhìn & Sứ mệnh</div>
            <h2 class="about-title" style="font-size: 2.2rem;">Giá trị cốt lõi</h2>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="value-card">
                <div class="value-icon"><i class="fa-solid fa-gem"></i></div>
                <h3 class="value-title">Chất lượng hàng đầu</h3>
                <p class="value-desc">Mỗi tour du lịch đều được LocalMate khảo sát kỹ lưỡng, lên lịch trình tối ưu và cung cấp dịch vụ tốt nhất để đảm bảo sự hài lòng tuyệt đối của hành khách.</p>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="value-card">
                <div class="value-icon"><i class="fa-solid fa-user-shield"></i></div>
                <h3 class="value-title">Dịch vụ tận tâm</h3>
                <p class="value-desc">Đội ngũ chăm sóc khách hàng và hướng dẫn viên đồng hành luôn sẵn sàng hỗ trợ 24/7, mang đến cảm giác an tâm trọn vẹn như những người thân trong gia đình.</p>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="value-card">
                <div class="value-icon"><i class="fa-solid fa-leaf"></i></div>
                <h3 class="value-title">Du lịch bền vững</h3>
                <p class="value-desc">Hướng tới các giá trị bảo tồn thiên nhiên, tôn trọng văn hóa bản địa và phát triển các hoạt động du lịch đi đôi với việc bảo vệ môi trường sống.</p>
            </div>
        </div>
    </div>

    <div class="row align-items-center mb-5 pb-5 border-bottom">
        <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0 ps-lg-5">
            <div class="about-subtitle">Những con người nhiệt huyết</div>
            <h2 class="about-title">Đội ngũ đằng sau mỗi chuyến đi</h2>
            <p class="about-text">
                Đằng sau mỗi chuyến đi thành công rực rỡ là sự cống hiến không ngừng nghỉ của tập thể đội ngũ LocalMate. Chúng tôi tự hào sở hữu một môi trường làm việc năng động, sáng tạo và chuyên nghiệp.
            </p>
            <p class="about-text">
                Từ những chuyên viên thiết kế tour ngày đêm tìm kiếm các vùng đất mới, nhân viên tư vấn nhiệt tình giải đáp mọi thắc mắc, cho đến các hướng dẫn viên dày dặn kinh nghiệm dẫn dắt đoàn – tất cả đều chung một đam mê xê dịch và khát khao mang lại niềm vui bất tận cho khách hàng.
            </p>
        </div>
        <div class="col-lg-6 order-lg-1">
            <div class="team-img-wrap">
                <img src="public/image/decor/nhanvien.png" alt="Đội ngũ LocalMate">
            </div>
        </div>
    </div>

    <div class="row mb-5 pb-4">
        <div class="col-12 text-center mb-5">
            <div class="about-subtitle">Phản hồi từ hành khách</div>
            <h2 class="about-title" style="font-size: 2.2rem;">Khách hàng nói gì về chúng tôi?</h2>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="testimonial-card">
                <div class="quote-icon"><i class="fa-solid fa-quote-left"></i></div>
                <p class="testimonial-text">"Chuyến đi Đà Lạt vừa rồi thực sự trên cả tuyệt vời. Hướng dẫn viên rất chu đáo, lịch trình sắp xếp hợp lý không bị mệt. Chắc chắn gia đình mình sẽ tiếp tục ủng hộ LocalMate!"</p>
                <div class="customer-info">
                    <img src="https://ui-avatars.com/api/?name=Lan+Anh&background=EBF6E0&color=00712D" class="customer-avatar" alt="Khách hàng">
                    <div>
                        <h6 class="customer-name">Nguyễn Lan Anh</h6>
                        <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="testimonial-card">
                <div class="quote-icon"><i class="fa-solid fa-quote-left"></i></div>
                <p class="testimonial-text">"Giá tour cực kỳ hợp lý so với chất lượng. Dịch vụ từ lúc tư vấn đến khi kết thúc tour đều rất chuyên nghiệp. Rất thích cách đội ngũ LocalMate chăm lo từng bữa ăn giấc ngủ cho đoàn."</p>
                <div class="customer-info">
                    <img src="https://ui-avatars.com/api/?name=Trần+Nam&background=EBF6E0&color=00712D" class="customer-avatar" alt="Khách hàng">
                    <div>
                        <h6 class="customer-name">Trần Văn Nam</h6>
                        <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="testimonial-card">
                <div class="quote-icon"><i class="fa-solid fa-quote-left"></i></div>
                <p class="testimonial-text">"Lần đầu tiên mình mua tour trực tuyến mà ưng ý đến vậy. Xe đưa đón đời mới, khách sạn sạch sẽ tiện nghi. Hướng dẫn viên thì vui tính vô cùng. Cảm ơn LocalMate rất nhiều!"</p>
                <div class="customer-info">
                    <img src="https://ui-avatars.com/api/?name=Bảo+Ngọc&background=EBF6E0&color=00712D" class="customer-avatar" alt="Khách hàng">
                    <div>
                        <h6 class="customer-name">Lê Phạm Bảo Ngọc</h6>
                        <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cta-section">
        <h2 style="font-weight: 700; margin-bottom: 15px;">Sẵn sàng cho chuyến đi tuyệt vời tiếp theo?</h2>
        <p style="font-size: 1.1rem; opacity: 0.9; max-width: 650px; margin: 0 auto;">Hãy để LocalMate đồng hành cùng bạn trên mọi nẻo đường. Đặt tour ngay hôm nay để nhận được những ưu đãi tốt nhất từ hệ thống!</p>
        <a href="index.php?controller=tour" class="btn-cta"><i class="fa-solid fa-compass me-2"></i> Khám phá các tour ngay</a>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>