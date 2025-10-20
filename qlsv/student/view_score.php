<?php
session_start();
require "../inc/config.php";
require "../inc/db.php";
if (!isset($_SESSION['username']) || $_SESSION['usertype'] !== 'student') {
    header("Location: ../index.php");
    session_destroy();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo BASE_URL; ?>/images/logo2.jpg" type="image/png">
    <link
        href="https://fonts.googleapis.com/css2?family=Merienda:wght@700&family=Poppins:ital,wght@0,400;0,500;0,600;1,400&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/common.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Trang sinh viên</title>
    <style>
    .alert-dismissible {
        animation: fadeOut 4s forwards;
        animation-delay: 1s;
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }

        to {
            opacity: 0;
            display: none;
        }
    }
    </style>
</head>

<body class="bg-3">
    <!-- Header -->
    <?php require "./inc/header.php"; ?>

    <div class="header-content bg-1 d-flex align-items-center container-xl mx-auto p-2 mt-4">
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
        <div class="row mt-4">
            <div class="col-md-8 mb-4 mx-auto">
                <?php
                    $username = $_SESSION['username'];
                    $sql = "SELECT * FROM users WHERE username = '$username'";
                    $result = mysqli_query($conn, $sql);
                    $student = $result->fetch_assoc();
                    $student_id = $student['id'];
                    $sql = "SELECT s.id, sb.code, sb.name, sb.credits, 
                            s.score_10, s.score_4, s.score_char, s.pass
                            FROM scores s
                            JOIN subjects sb ON s.subject_id = sb.id 
                            WHERE s.student_id = '$student_id'";
                    $result = mysqli_query($conn, $sql);
                    if (!$result) {
                        die("Query failed: " . mysqli_error($conn));
                    }
                    $cnt = 1;
                    $total_credits_passed = 0; 
                    $total_score_4 = 0;
                    $total_score_10 = 0;
                    $passed_subjects = 0;
                ?>

                <div class="shadow mb-4">
                    <div class="card bg-1 text-white">
                        <div class="card-header">
                            <h3 class="mb-0">
                                <i class="bi bi-person-fill me-2"></i>
                                Bảng điểm
                            </h3>
                        </div>
                        <div class="table-responsive card-body p-0">
                            <div class="list-group list-group-flush">
                                <table class="table table-bordered table-light fs-5">
                                    <thead>
                                        <td>STT</td>
                                        <td>Mã MH</td>
                                        <td>Tên môn học</td>
                                        <td>Số tín chỉ</td>
                                        <td>Điểm TK(10)</td>
                                        <td>Điểm TK(4)</td>
                                        <td>Điểm TK(C)</td>
                                        <td>Kết quả</td>
                                    </thead>
                                    <tbody>
                                        <?php
                                            while ($score = mysqli_fetch_assoc($result)) {
                                                $pass_status = ($score['pass'] == 'True') ? 'Đạt' : 'Trượt';
                                                echo "<tr class='align-middle'>
                                                        <td>{$cnt}</td>
                                                        <td>{$score['code']}</td>
                                                        <td>{$score['name']}</td>
                                                        <td>{$score['credits']}</td>
                                                        <td>{$score['score_10']}</td>
                                                        <td>{$score['score_4']}</td>
                                                        <td>{$score['score_char']}</td>
                                                        <td>{$pass_status}</td>
                                                    </tr>";
                                                $cnt++;
                                                if ($pass_status == 'Đạt') {
                                                    $total_credits_passed += $score['credits']; 
                                                    $total_score_4 += $score['score_4'] * $score['credits']; 
                                                    $total_score_10 += $score['score_10'] * $score['credits']; 
                                                    $passed_subjects++;
                                                }
                                            }
                                            $padding_top = ($cnt - 1 == 0) ? "13%" : "7%"; 
                                            if ($cnt - 1 == 0) {
                                                echo "<tr>
                                                        <td colspan='8' class='text-center'>Không có điểm</td>
                                                    </tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="bg-secondary-subtle w-100">
                            <?php 
                                $average_score_4 = $total_credits_passed > 0 ? $total_score_4 / $total_credits_passed : 0;
                                $average_score_10 = $total_credits_passed > 0 ? $total_score_10 / $total_credits_passed : 0;
                            ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="p-2 text-primary">- Điểm trung bình tích lũy hệ 4:
                                        <span class="text-primary fw-bold"><?php echo number_format($average_score_4, 2);?></span>
                                    </h5>
                                    <h5 class="p-2 text-primary">- Điểm trung bình tích lũy hệ 10:
                                        <span class="text-primary fw-bold"><?php echo number_format($average_score_10, 2); ?></span>
                                    </h5>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="p-2 text-primary">- Số môn đã đạt:
                                        <span class="text-primary fw-bold"><?php echo $passed_subjects; ?></span>
                                    </h5>        
                                    <h5 class="p-2 text-primary">- Số tín chỉ tích lũy:
                                        <span class="text-primary fw-bold"><?php echo $total_credits_passed; ?></span>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-none d-lg-block">
                <div class="shadow">
                    <div class="card bg-1 text-white">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-gear-fill me-2"></i>TÍNH NĂNG
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <a href="view_score.php"
                                    class="list-group-item list-group-item-action fw-bold fs-4 clhv">
                                    <i class="bi bi-arrow-right me-2"></i>Xem điểm
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    <div style="padding-top: <?php echo $padding_top; ?>">
        <?php require "./inc/footer.php"; ?>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="<?php echo BASE_URL; ?>/js/move-top.js"></script>
</html>