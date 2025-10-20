<?php
    require "./inc/config.php";
    require "./inc/db.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo BASE_URL; ?>/images/logo2.png" type="image/png">
    <link
        href="https://fonts.googleapis.com/css2?family=Merienda:wght@700&family=Poppins:ital,wght@0,400;0,500;0,600;1,400&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/common.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Đăng nhập</title>
</head>

<body class="bg-white">
    <!-- Header -->
    <?php 
        require "./inc/header.php";
    ?>
    <!-- Banner -->
    <section class="main-banner position-relative overflow-hidden">
        <video autoplay muted loop class="bg-video w-100">
            <source src="<?php echo BASE_URL; ?>/images/course-video.mp4" type="video/mp4" />
        </video>

        <div class="video-overlay">
            <div class="header-content d-flex align-items-center container-xl mx-auto p-2 mt-4">
                <img src="<?php echo BASE_URL; ?>/images/logo2.png" alt="Logo" class="logo">
                <div class="title">
                    <div>HỌC VIỆN ĐÀO TẠO CHẤT LƯỢNG CAO TMT</div>
                    <div>CỔNG THÔNG TIN QUẢN LÝ ĐÀO TẠO</div>
                </div>
                <div class="image-container">
                    <img src="<?php echo BASE_URL; ?>/images/view.png" alt="Header Image" class="header-image">
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="caption">
                            <h6 class="mt-0 fs-6 text-uppercase fw-semibold text-white">Xin chào các bạn sinh viên</h6>
                            <h2 class="mt-3 mb-3 fs-1 text-uppercase fw-bold text-white">Chào mừng bạn đến với TMT</h2>
                            <p class="fs-6">Đây là môi trường học thuật nơi tri thức và sáng tạo hội tụ, giúp bạn phát
                                triển toàn diện kỹ năng và kiến thức. Trường Đại học của chúng tôi tự hào mang đến
                                chương trình đào tạo hiện đại, cơ sở vật chất tiên tiến cùng môi trường học tập năng
                                động. Hãy cùng chúng tôi trải nghiệm hành trình khám phá tri thức, xây dựng tương lai
                                bền vững.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Slider -->
    <section class="slider">
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="icon">
                        <img src="<?php echo BASE_URL; ?>/images/service-icon-01.png" alt="" class="img-fluid">
                    </div>
                    <div class="mt-3">
                        <h4>Chất lượng giảng dạy tốt nhất</h4>
                        <p>Trường đại học luôn đảm bảo chất lượng giảng dạy với đội ngũ giảng viên giàu kinh nghiệm và
                            chương trình đào tạo tiên tiến.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="icon">
                        <img src="<?php echo BASE_URL; ?>/images/service-icon-02.png" alt="" class="img-fluid">
                    </div>
                    <div class="mt-3">
                        <h4>Môi trường học tập hiện đại</h4>
                        <p>Cơ sở vật chất đầy đủ, trang thiết bị hiện đại, mang đến môi trường học tập và nghiên cứu tốt
                            nhất cho sinh viên.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="icon">
                        <img src="<?php echo BASE_URL; ?>/images/service-icon-03.png" alt="" class="img-fluid">
                    </div>
                    <div class="mt-3">
                        <h4>Cộng đồng sinh viên năng động</h4>
                        <p>Sinh viên được tham gia nhiều hoạt động ngoại khóa, câu lạc bộ và sự kiện giúp phát triển kỹ
                            năng mềm và mở rộng mối quan hệ.</p>
                    </div>
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <section class="bg-image" style="margin-bottom: -280px;">
        <div class="container p-5">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-white fw-bold fs-5 p-4 rounded text-center">
                        <h2 class="fw-bold">Bốn Sinh viên có điểm GPA cao nhất</h2>
                        <div class="mt-sm-1 row g-4">
                            <?php
                                $sql = "SELECT u.id AS student_id, u.fullname, u.username, SUM(s.score_4 * sb.credits) / SUM(sb.credits) AS GPA FROM users u 
                                        JOIN scores s ON u.id = s.student_id JOIN subjects sb ON s.subject_id = sb.id 
                                        GROUP BY u.id ORDER BY GPA DESC LIMIT 4";
                                $result = mysqli_query($conn, $sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '
                                        <div class="col-lg-3">
                                            <div class="card h-100 shadow-sm stat-card">
                                                <div class="card-body text-center">
                                                    <h4 class="card-title text-success fw-bold">' . htmlspecialchars($row["fullname"]) .'</h4>
                                                    <h5 class="card-title text-success fs-5 fw-bold">' . htmlspecialchars($row["username"]) .'</h5>
                                                    <p class="card-text text-danger fs-4 fw-bold">GPA: ' . round($row["GPA"], 2) . '</p>
                                                </div>
                                            </div>
                                        </div>';
                                    }
                                } else {
                                    echo '<p>Không có dữ liệu sinh viên.</p>';
                                } 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How to use -->
    <section id="howtouse" class="bg-image">
        <div class="container">
            <div class="row mt-100">
                <div class="col-sm-12 col-lg-6 text-section">
                    <h4 class="section-title" style="text-decoration: underline; color: #f8f9fa;">Hướng dẫn sử dụng</h4>
                    <h1 class="section-title" style="color: #ffffff;">DỊCH VỤ TRỰC TUYẾN</h1>

                    <p class="step-title" style="color: #f8f9fa;">• Bước 1:</p>
                    <p class="text-content" style="color: #e0e0e0;">
                        <strong>Nhận tài khoản</strong><br> Mỗi sinh viên được cấp một tài khoản với tài khoản và mật
                        khẩu mặc định là mã số sinh viên.
                    </p>

                    <p class="step-title" style="color: #f8f9fa;">• Bước 2:</p>
                    <p class="text-content" style="color: #e0e0e0;">
                        <strong>Gửi yêu cầu</strong><br> Sinh viên đăng nhập, điền biểu mẫu yêu cầu và nộp trên hệ thống
                        online.
                    </p>

                    <p class="step-title" style="color: #f8f9fa;">• Bước 3:</p>
                    <p class="text-content" style="color: #e0e0e0;">
                        <strong>Xử lý yêu cầu</strong><br> Cơ quan, đơn vị nhận yêu cầu online, xử lý và thông báo qua
                        email khi hoàn thành.
                    </p>

                    <p class="step-title" style="color: #f8f9fa;">• Bước 4:</p>
                    <p class="text-content" style="color: #e0e0e0;">
                        <strong>Nhận kết quả</strong><br> Khi nhận được thông báo yêu cầu xử lý thành công, sinh viên
                        lên văn phòng cơ quan, đơn vị thực hiện xử lý để nhận kết quả.
                    </p>
                </div>

                <div class="col-sm-12 col-lg-6">
                    <div class="row">
                        <div class="col-6 mb-4" style="margin-top: 9%;">
                            <img src="<?php echo BASE_URL; ?>/images/img-manual1.png" class="img-fluid rounded">
                        </div>
                        <div class="col-6 mb-4">
                            <img src="<?php echo BASE_URL; ?>/images/img-manula2.png" class="img-fluid rounded"
                                style="margin-bottom: 20px;">
                            <img src="<?php echo BASE_URL; ?>/images/img-manual3.png" class="img-fluid rounded">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- our facts -->
    <section class="our-facts">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="text-white fw-bold mb-4">Một vài thông tin về trường đại học của chúng tôi</h2>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-12">
                                    <div class="count-area-content">
                                        <div class="count-digit"><?php echo "$student_count"; ?></div>
                                        <div class="count-title">Sinh viên</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="count-area-content">
                                        <div class="count-digit"><?php echo "$company_count"; ?></div>
                                        <div class="count-title">Công ty hỗ trợ thực tập</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-12">
                                    <div class="count-area-content mt-5">
                                        <div class="count-digit"><?php echo "$subject_count"; ?></div>
                                        <div class="count-title">Môn Học</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="count-area-content">
                                        <div class="count-digit">32</div>
                                        <div class="count-title">Bài Nghiên Cứu Khoa Học</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="links">
                        <a href="https://www.youtube.com/watch?v=HndV87XpkWg" target="_blank"></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- about us -->
    <section id="aboutus" class="about-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="fs-1 text-white fw-bold">Về chúng tôi</h2>
                            <p class="fs-6 text-white fw-medium">Chúng tôi là một trong những trường đại học hàng đầu,
                                cam kết mang đến cho sinh viên môi trường học tập năng động và hiện đại. Với đội ngũ
                                giảng viên giàu kinh nghiệm và cơ sở vật chất tiên tiến, chúng tôi không chỉ trang bị
                                kiến thức chuyên môn mà còn chú trọng phát triển kỹ năng mềm, giúp sinh viên sẵn sàng
                                bước vào thị trường lao động quốc tế. Trường tự hào với các chương trình đào tạo đa
                                dạng, kết hợp lý thuyết và thực tiễn, mang đến những trải nghiệm học tập đáng nhớ cho
                                sinh viên.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-us d-block mx-auto">
                        <img src="<?php echo BASE_URL; ?>/images/single-meeting.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- partners -->
    <section id="partners" class="our-partners">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="partner-area">
                        <div class="partner-area">
                            <h2 class="text-white">Đối tác</h2>
                            <p class="text-white">Các đối tác đã luôn đồng hành cùng với trường trong mọi mặt trận</p>
                        </div>
                        <div class="partner-content">
                            <div class="row">
                                <div class="col-md-2 col-sm-4 col-xs-4">
                                    <div class="partner-single">
                                        <img src="<?php echo BASE_URL; ?>/images/partners/Arm.png" alt="Brand Logo">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-4">
                                    <div class="partner-single">
                                        <img src="<?php echo BASE_URL; ?>/images/partners/Ericsson.png"
                                            alt="Brand Logo">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-4">
                                    <div class="partner-single">
                                        <img src="<?php echo BASE_URL; ?>/images/partners/fpt.jpg" alt="Brand Logo">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-4">
                                    <div class="partner-single">
                                        <img src="<?php echo BASE_URL; ?>/images/partners/google.png" alt="Brand Logo">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-4">
                                    <div class="partner-single">
                                        <img src="<?php echo BASE_URL; ?>/images/partners/microsoft.png"
                                            alt="Brand Logo">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-4">
                                    <div class="partner-single">
                                        <img src="<?php echo BASE_URL; ?>/images/partners/Mobifone.png"
                                            alt="Brand Logo">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-4">
                                    <div class="partner-single">
                                        <img src="<?php echo BASE_URL; ?>/images/partners/Naver.png" alt="Brand Logo">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-4">
                                    <div class="partner-single">
                                        <img src="<?php echo BASE_URL; ?>/images/partners/qualcomm.png"
                                            alt="Brand Logo">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-4">
                                    <div class="partner-single">
                                        <img src="<?php echo BASE_URL; ?>/images/partners/samsung.png" alt="Brand Logo">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-4">
                                    <div class="partner-single">
                                        <img src="<?php echo BASE_URL; ?>/images/partners/viettel.jpg" alt="Brand Logo">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-4">
                                    <div class="partner-single">
                                        <img src="<?php echo BASE_URL; ?>/images/partners/VMO.jpg" alt="Brand Logo">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-4">
                                    <div class="partner-single">
                                        <img src="<?php echo BASE_URL; ?>/images/partners/VNPT.png" alt="Brand Logo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- contact -->
    <section id="contact" class="bg-image">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-2">
                    <div>
                        <h2 class="section-title text-white mb-4 fs-1">Liên hệ chúng tôi</h2>
                        <iframe class="w-100 rounded" height="320px"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3725.292402547498!2d105.78254558190577!3d20.980912930780498!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135accdd8a1ad71%3A0xa2f9b16036648187!2zSOG7jWMgdmnhu4duIEPDtG5nIG5naOG7hyBCxrB1IGNow61uaCB2aeG7hW4gdGjDtG5n!5e0!3m2!1svi!2s!4v1727704527199!5m2!1svi!2s"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <div class="row mt-4">
                            <div class="col-lg-4">
                                <h5 class="mt-2 fw-bold text-white">Email</h5>
                                <a href="mailto: ctsv@ptit.edu.vn"
                                    class="d-inline-block fs-5 text-decoration-none text-white mb-2 hover-underline">
                                    ctsv@ptit.edu.vn
                                </a>
                            </div>
                            <div class="col-lg-4">
                                <h5 class="mt-2 fw-bold text-white">Trụ sở chính</h5>
                                <a href="https://maps.app.goo.gl/N7MQp81A7ZNnrTNn6" target="_blank"
                                    class="text-decoration-none text-white d-inline-block fs-5 mb-2 hover-underline">
                                    122 Hoàng Quốc Việt, Cổ Nhuế, Cầu Giấy, Hà Nội
                                </a>
                            </div>
                            <div class="col-lg-4">
                                <h5 class="mt-2 fw-bold text-white">Học viện cơ sở tại TP. Hồ Chí Minh</h5>
                                <a href="https://maps.app.goo.gl/SKSZF7Q3rpnbWq7K9" target="_blank"
                                    class="text-decoration-none text-white d-inline-block fs-5 mb-2 hover-underline">
                                    11 Nguyễn Đình Chiểu, Đa Kao, Quận 1, Hồ Chí Minh
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <h5 class="mt-2 fw-bold text-white">Số điện thoại liên hệ</h5>
                                <a href="tel: 024 3756 2186"
                                    class="d-inline-block fs-5 mb-2 text-decoration-none text-white hover-underline">
                                    024 3756 2186
                                </a>
                            </div>
                            <div class="col-lg-4">
                                <h5 class="mt-2 fw-bold text-white">Cơ sở đào tạo tại Hà Nội</h5>
                                <a href="https://maps.app.goo.gl/ABAdqpQGEQHwJkJY9" target="_blank"
                                    class="text-decoration-none text-white d-inline-block fs-5 mb-2 hover-underline">
                                    Km10 Đ. Nguyễn Trãi, P. Mộ Lao, Hà Đông, Hà Nội
                                </a>
                            </div>
                            <div class="col-lg-4">
                                <h5 class="mt-2 fw-bold text-white">Cơ sở đào tạo tại TP Hồ Chí Minh</h5>
                                <a href="https://maps.app.goo.gl/ABAdqpQGEQHwJkJY9" target="_blank"
                                    class="text-decoration-none text-white d-inline-block fs-5 mb-2 hover-underline">
                                    Đường Man Thiện, P. Hiệp Phú, Q.9 TP Hồ Chí Minh
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Phone -->
    <button id="phonecall">
        <i class="bi bi-telephone-fill fs-4 fw-bold"></i>
    </button>

    <div id="callPanel" class="p-0">
        <div class="d-flex align-items-center justify-content-between bg-1 p-3" style="border-radius: 10px 10px 0 0;">
            <h4 class="text-white mt-2 fs-5">Liên hệ để được tư vấn</h4>
            <a id="closePanel"><i class="bi bi-arrows-angle-contract text-white fw-bold fs-5"
                    style="cursor: pointer;"></i></a>
        </div>
        <p class="p-2 fw-bold">Phòng giáo vụ: <a href="" class="text-decoration-none">02438547797</a></p>
    </div>

    <button id="backToTopBtn">
        <i class="bi bi-arrow-up fs-4 fw-bold"></i>
    </button>

    <!-- Footer -->
    <?php 
        require "./inc/footer.php";
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="<?php echo BASE_URL; ?>/js/move-top.js"></script>
<script>
$(document).ready(function() {
    <?php if (isset($_SESSION['loginMessage']) && $_SESSION['loginMessage'] != ''): ?>
    var loginModal = new bootstrap.Modal($('#LoginModal')[0]);
    loginModal.show();
    <?php unset($_SESSION['loginMessage']); ?>
    <?php endif; ?>
});
</script>

</html>