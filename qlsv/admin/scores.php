<?php
session_start();
require "../inc/config.php";
require "../inc/db.php";
if (!isset($_SESSION['username']) || $_SESSION['usertype'] !== 'admin') {
    header("Location: ../index.php");
    session_destroy();
}

$query = "SELECT * FROM users WHERE usertype = 'student'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo BASE_URL; ?>/images/logo.jpg" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@700&family=Poppins:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/common.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Trang chủ quản lí - Điểm thi</title>
    <style>
        .alert-dismissible {
            animation: fadeOut 4s forwards;
            animation-delay: 1s;
        }

        @keyframes fadeOut {
            from {opacity: 1;}
            to {opacity: 0; display: none;}
        }
    </style>
</head>
<body class="bg-3">
    <!-- Header -->
    <?php require("./inc/header.php") ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden fs-5">
                <div class="container-fluid d-flex align-items-center justify-content-between">
                    <h3 class="mb-4 fs-2 mt-5">Danh Sách Điểm Thi</h3> 
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-<?php echo ($_SESSION['message_type'] == 'success') ? 'success' : 'danger'; ?> alert-dismissible fade show ms-4 w-25 fs-6" role="alert">
                            <i class="bi <?php echo ($_SESSION['message_type'] == 'success') ? 'bi-check-circle-fill' : 'bi-exclamation-circle-fill'; ?> me-2"></i>
                            <?php echo $_SESSION['message']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php 
                        unset($_SESSION['message']);
                        unset($_SESSION['message_type']);
                        ?>
                    <?php endif; ?>
                </div>
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="mb-4 d-flex">
                            <select id="studentSelect" class="form-select w-50 me-2 fs-5" onchange="loadScores(this.value)" onfocus="this.size=3" onblur="this.size=1" 
                            onchange="this.size=1; this.blur();">
                                <option value="">Chọn sinh viên</option>
                                <?php while ($student = mysqli_fetch_assoc($result)) : ?>
                                    <option value="<?php echo $student['id']; ?>">
                                        <?php echo $student['username'] . " - " . $student['fullname']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#add-score" style="max-height: 44px;">
                                <i class="bi bi-plus-square"></i> Thêm mới điểm
                            </button>
                        </div>

                        <div class="table-responsive" style="height: 550px; overflow-y: scroll;">
                            <table id="scoresTable" class="table table-hover border">
                                <thead>
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Mã môn học</th>
                                        <th scope="col">Tên</th>
                                        <th scope="col">Số tín chỉ</th>
                                        <th scope="col">Điểm TK(10)</th>
                                        <th scope="col">Điểm TK(4)</th>
                                        <th scope="col">Điểm TK(C)</th>
                                        <th scope="col">Kết quả</th>
                                        <th scope="col">Tùy chọn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Add Score Modal -->
                <div class="modal fade" id="add-score" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form action="code_score.php" method="POST" id="ScoreForm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fs-5">Thêm điểm thi</h5>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="studentIdInput" name="student_id">
                                    <input type="hidden" id="subjectIdInput" name="subject_id">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="courseCode" class="form-label">Mã môn học</label>
                                            <select class="form-select me-2" id="courseCode" onchange="courseInfo(this.value)" onfocus="this.size=3" onblur="this.size=1" 
                                            onchange="this.size=1; this.blur();">
                                                <option value="">Chọn môn học</option>
                                                <?php
                                                    $subjects = mysqli_query($conn, "SELECT * FROM subjects");
                                                    while ($subject = mysqli_fetch_assoc($subjects)) {
                                                        echo "<option value='{$subject['id']}'>{$subject['code']}</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tên môn học</label>
                                            <input id="courseName" type="text" class="form-control shadow-none" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Số tín chỉ</label>
                                            <input id="courseCredit" type="text" class="form-control shadow-none" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Điểm TK(10)</label>
                                            <input type="text" name="score_10" id="score10" class="score10 form-control shadow-none" placeholder="Điểm TK(10)" oninput="calculateGrade(this)">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Điểm TK(4)</label>
                                            <input type="text" name="score_4" id="score4" class="score4 form-control shadow-none" placeholder="Điểm TK(4)">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Điểm TK(C)</label>
                                            <input type="text" name="score_char" id="scoreChar" class="scoreChar form-control shadow-none" placeholder="Điểm TK(C)">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none"
                                        data-bs-dismiss="modal" onclick="resetForm()">Hủy</button>
                                    <button type="submit" class="btn bg-1 text-white shadow-none" name="add_score">Thêm mới</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Edit Score Modal -->
                <div class="modal fade" id="edit-score" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form action="code_score.php" method="POST">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fs-5">Sửa điểm sinh viên</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <input type="hidden" name="score_id" id="score_id">
                                        <div class="col-md-6 mb-3">
                                            <label for="courseCode" class="form-label">Mã môn học</label>
                                            <input id="courseCode" type="text" class="form-control shadow-none" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Tên môn học</label>
                                            <input id="courseName" type="text" class="form-control shadow-none" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Số tín chỉ</label>
                                            <input id="courseCredit" type="text" class="form-control shadow-none" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Điểm TK(10)</label>
                                            <input type="text" name="score_10" id="score10" class="score10 form-control shadow-none" placeholder="Điểm TK(10)" oninput="calculateGrade(this)">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Điểm TK(4)</label>
                                            <input type="text" name="score_4" id="score4" class="score4 form-control shadow-none" placeholder="Điểm TK(4)">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Điểm TK(C)</label>
                                            <input type="text" name="score_char" id="scoreChar" class="scoreChar form-control shadow-none" placeholder="Điểm TK(C)">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none"
                                        data-bs-dismiss="modal">Hủy</button>
                                    <button type="submit" class="btn bg-1 text-white shadow-none" name="update_score">Lưu</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button id="backToTopBtn">
        <i class="bi bi-arrow-up fs-4 fw-bold"></i>
    </button>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="<?php echo BASE_URL; ?>/js/move-top.js"></script>
<script>
function loadScores(studentId) {
    $("#studentIdInput").val(studentId);
    if (studentId) {
        $.ajax({
            url: "code_score.php",
            type: "GET",
            data: { student_id: studentId },
            success: function(data) {
                $("#scoresTable tbody").html(data);
            }
        });
    } else {
        $("#scoresTable tbody").html("");
    }
}
function resetForm() {
    $("#ScoreForm")[0].reset();
}
function courseInfo(subjectId) {
    $("#subjectIdInput").val(subjectId);
    if (subjectId) {
        $.ajax({
            url: 'code_score.php',
            type: 'GET',
            data: { subject_id: subjectId },
            success: function(response) {
                const data = JSON.parse(response);
                $('#courseName').val(data.name);
                $('#courseCredit').val(data.credits);
            }
        });
    }
}

function calculateGrade(element) {
    const score10 = parseFloat($(element).val());
    let score4 = 0;
    let scoreChar = '';

    if (score10 >= 9) {
        score4 = 4.0;
        scoreChar = 'A+';
    } else if (score10 >= 8.5) {
        score4 = 3.8;
        scoreChar = 'A';
    } else if (score10 >= 8) {
        score4 = 3.5;
        scoreChar = 'B+';
    } else if (score10 >= 7) {
        score4 = 3.0;
        scoreChar = 'B';
    } else if (score10 >= 6.5) {
        score4 = 2.5;
        scoreChar = 'C+';
    } else if (score10 >= 5.5) {
        score4 = 2.0;
        scoreChar = 'C';
    } else if (score10 >= 5) {
        score4 = 1.5;
        scoreChar = 'D+';
    } else if (score10 >= 4) {
        score4 = 1.0;
        scoreChar = 'D';
    } else {
        score4 = 0;
        scoreChar = 'F';
    }

    $(element).closest('.modal-body').find('.score4').val(score4);
    $(element).closest('.modal-body').find('.scoreChar').val(scoreChar);
}

function editScore(scoreId) {
    $.ajax({
        url: 'code_score.php',
        type: 'GET',
        data: { score_id: scoreId },
        success: function(response) {
            const score = JSON.parse(response);
            $("#edit-score #score_id").val(score.id);
            $("#edit-score #courseCode").val(score.subject_code);
            $("#edit-score #courseName").val(score.subject_name);
            $("#edit-score #courseCredit").val(score.credits);
            $("#edit-score #score10").val(score.score_10);
            $("#edit-score #score4").val(score.score_4);
            $("#edit-score #scoreChar").val(score.score_char);
        }
    });
}
</script>
</html>