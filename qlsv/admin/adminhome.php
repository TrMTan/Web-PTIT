<?php
session_start();
require "../inc/config.php";
require "../inc/db.php";
if (!isset($_SESSION['username']) || $_SESSION['usertype'] !== 'admin') {
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
    <title>Trang chủ quản lí</title>
</head>
<body class="bg-3">
    <!-- Header -->
    <?php require "./inc/header.php"; ?>

    <div class="container-fluid shadow" id="main-content">
        <div class="row">
            <div class="col-lg-10 p-4 ms-auto">
                <div class="bg-light text-dark fw-bold fs-5 p-4 rounded text-center">
                    Chào mừng bạn đến trang quản lí!
                    <div class="mt-sm-1 row g-4 mb-4">
                        <div class="col-lg-4">
                            <div class="card h-100 shadow-sm stat-card">
                                <div class="card-body text-center">
                                    <i class="bi bi-people fs-1 text-primary mb-2"></i>
                                    <h5 class="card-title">Sinh viên</h5>
                                    <p class="card-text fs-4 fw-bold"><?php echo "$student_count"; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card h-100 shadow-sm stat-card">
                                <div class="card-body text-center">
                                    <i class="bi bi-book fs-1 text-success mb-2"></i>
                                    <h5 class="card-title">Môn học</h5>
                                    <p class="card-text fs-4 fw-bold"><?php echo "$subject_count"; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card h-100 shadow-sm stat-card">
                                <div class="card-body text-center">
                                    <i class="bi bi-building fs-1 text-warning mb-2"></i>
                                    <h5 class="card-title">Công ty hỗ trợ thực tập</h5>
                                    <p class="card-text fs-4 fw-bold"><?php echo "$company_count"; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-10 p-4 ms-auto">
                <div class="bg-light text-dark fw-bold fs-5 p-4 rounded text-center">
                   Bốn Sinh viên có điểm GPA cao nhất
                    <div class="mt-sm-1 row g-4 mb-4">
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
                                                <h5 class="card-title text-success">' . htmlspecialchars($row["fullname"]) ." - ". htmlspecialchars($row["username"]) .'</h5>
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

            <div class="col-lg-10 p-4 ms-auto">
                <?php 
                    $sql = "SELECT major, gender, COUNT(*) AS total FROM users WHERE usertype = 'student' GROUP BY major, gender";
                    $result = mysqli_query($conn, $sql);                    
                    $data = [];
                    
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;
                        }
                    } else {
                        echo "Không có dữ liệu.";
                    }
                ?>
                <?php 
                    $sql = "SELECT sc.subject_id, sub.name, 
                            COUNT(CASE WHEN sc.score_10 >= 5 THEN 1 END) AS pass_count, 
                            COUNT(CASE WHEN sc.score_10 < 5 THEN 1 END) AS fail_count, 
                            (COUNT(CASE WHEN sc.score_10 >= 5 THEN 1 END) * 100.0 / COUNT(*)) AS pass_percentage, 
                            (COUNT(CASE WHEN sc.score_10 < 5 THEN 1 END) * 100.0 / COUNT(*)) AS fail_percentage 
                            FROM scores sc 
                            JOIN subjects sub ON sc.subject_id = sub.id 
                            GROUP BY sc.subject_id, sub.name;";
                    $result = mysqli_query($conn, $sql);
                    $subjects = [];
                    $pass_counts = [];
                    $fail_counts = [];
                    $pass_percentages = [];
                    $fail_percentages = [];
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $subjects[] = $row['name'];
                            $pass_counts[] = $row['pass_count'];
                            $fail_counts[] = $row['fail_count'];
                            $pass_percentages[] = $row['pass_percentage'];
                            $fail_percentages[] = $row['fail_percentage'];
                        }
                    } else {
                        echo "Không có dữ liệu.";
                    }
                ?>
                <div class="bg-light rounded p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="text-center">
                                <h3 class="text-dark fw-bold fs-5 mb-4 px-2">Thống kê số lượng sinh viên nam, nữ theo ngành</h3>
                                <div style="width: 100%; max-width: 400px; margin: 0 auto;">
                                    <canvas id="genderChart1"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center">
                                <h3 class="text-dark fw-bold fs-5 mb-4 px-2">Thống kê số lượng sinh viên qua môn theo môn học</h3>
                                <div style="width: 100%; max-width: 800px; margin: 0 auto;">
                                    <canvas id="genderChart2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button id="backToTopBtn">
        <i class="bi bi-arrow-up fs-4 fw-bold"></i>
    </button>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="<?php echo BASE_URL; ?>/js/move-top.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        const student = <?php echo json_encode($data); ?>;
        const majors = [...new Set(student.map(item => item.major))];
        const nu = majors.map(major => {
            const entry = student.find(item => item.major === major && item.gender === 'Nam');
            return entry ? entry.total : 0;
        });
        
        const nam = majors.map(major => {
            const entry = student.find(item => item.major === major && item.gender === 'Nữ');
            return entry ? entry.total : 0;
        });
        const ctx1 = document.getElementById('genderChart1').getContext('2d');
        new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: majors.map(major => `${major} - Nam`).concat(majors.map(major => `${major} - Nữ`)),
                datasets: [{
                    label: '',
                    data: nu.concat(nam),
                    backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A1', 
                                    '#FF8C33', '#8C33FF', '#33FFF6', '#FFD433', 
                                    '#FF3333', '#33FFBD', '#3385FF', '#FF33EC'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 20,
                            padding: 20
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.raw;
                                return label;
                            }
                        }
                    }
                },
                cutoutPercentage: 80
            }
        });
    });
    $(document).ready(function() {
        const subjects = <?php echo json_encode($subjects); ?>;
        const passCounts = <?php echo json_encode($pass_counts); ?>;
        const failCounts = <?php echo json_encode($fail_counts); ?>;
        const passPercentages = <?php echo json_encode($pass_percentages); ?>;
        const failPercentages = <?php echo json_encode($fail_percentages); ?>;
        
        const ctx2 = document.getElementById('genderChart2').getContext('2d');
        new Chart(ctx2, {
            type: 'bar', 
            data: {
                labels: subjects,
                datasets: [
                    {
                        label: 'Số sinh viên qua môn',
                        data: passCounts,
                        backgroundColor: '#00bfff', 
                        borderColor: '#28a745',
                        borderWidth: 1
                    },
                    {
                        label: 'Số sinh viên trượt môn',
                        data: failCounts, 
                        backgroundColor: '#ff0000', 
                        borderColor: '#dc3545',
                        borderWidth: 1
                    },
                    {
                        label: 'Tỷ lệ qua môn (%)',
                        data: passPercentages,
                        backgroundColor: '#33cc33',
                        borderColor: '#28a745',
                        borderWidth: 1
                    },
                    {
                        label: 'Tỷ lệ trượt môn (%)',
                        data: failPercentages,
                        backgroundColor: '#cc3333',
                        borderColor: '#dc3545',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,  
                            precision: 0 
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: 20,
                            padding: 20
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.raw;
                                if (context.dataset.label.includes('Tỷ lệ')) {
                                    label += '%'; 
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
</html>