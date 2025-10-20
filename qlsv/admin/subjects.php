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
    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@700&family=Poppins:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/common.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Trang chủ quản lí - Môn Học</title>
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
                    <h3 class="mb-4 fs-2 mt-5">Danh Sách Môn Học</h3> 
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
                            <input type="text" id="searchSubject" class="form-control me-2 shadow-none" placeholder="Tìm kiếm môn học" style="width: 500px;">
                            <select id="sortSubjects" class="form-select me-2 shadow-none" style="width: auto; max-height: 50px;">
                                <option value="">Sắp xếp theo</option>
                                <option value="name_asc">Tên A-Z</option>
                                <option value="name_desc">Tên Z-A</option>
                                <option value="code_asc">Mã môn tăng dần</option>
                                <option value="code_desc">Mã môn giảm dần</option>
                                <option value="credits_asc">Số tín chỉ tăng dần</option>
                                <option value="credits_desc">Số tín chỉ giảm dần</option>
                            </select>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#add-subject" style="max-height: 50px;">
                                <i class="bi bi-plus-square"></i> Thêm mới môn học
                            </button>
                        </div>
                        <div class="table-responsive" style="height: 550px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-nowrap">STT</th>
                                        <th scope="col" class="text-nowrap">Mã môn học</th>
                                        <th scope="col" class="text-nowrap">Tên môn học</th>
                                        <th scope="col" class="text-nowrap">Số tín chỉ</th>
                                        <th scope="col" class="text-nowrap">Tùy chọn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql = "SELECT * FROM `subjects`";
                                        $result = mysqli_query($conn, $sql);
                                        $cnt = 1;
                                        while($subject=$result->fetch_assoc())
                                        {
                                    ?>
                                        <tr class="align-middle">
                                            <th scope="row"><?php echo "{$cnt}"; ?></th>
                                            <td class="text-nowrap"><?php echo "{$subject['code']}"; ?></td>
                                            <td class="text-nowrap"><?php echo "{$subject['name']}"; ?></td>
                                            <td class="text-nowrap"><?php echo "{$subject['credits']}"; ?></td>
                                            <td class="text-nowrap">
                                                <?php echo "<a href='' class='btn btn-warning text-white rounded-pill shadow-none btn-sm' onclick='editSubject({$subject['id']})' data-bs-toggle='modal' data-bs-target='#edit-subject'><i class='bi bi-pencil-fill'></i> Sửa</a>"; ?>
                                                <?php echo "<a onclick=\"return confirm('Bạn có chắc chắn muốn xóa không?');\" href='code_subject.php?delete_id={$subject['id']}' class='btn btn-danger rounded-pill shadow-none btn-sm'><i class='bi bi-trash-fill'></i> Xóa</a>"; ?>
                                            </td>
                                        </tr>
                                    <?php
                                        $cnt++;
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Add Student Modal -->
                <div class="modal fade" id="add-subject" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="code_subject.php" method="POST" id="SubjectForm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fs-5">Thêm Môn Học</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Mã Môn Học</label>
                                            <input type="text" required name="mamonhoc" class="form-control shadow-none" placeholder="Mã Môn Học">
                                            <span id="subjectCodeError"></span>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Tên Môn Học</label>
                                            <input type="text" required name="tenmonhoc" class="form-control shadow-none" placeholder="Tên Môn Học">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Số Tín Chỉ</label>
                                            <input type="text" required class="form-control shadow-none"
                                                placeholder="Số Tín Chỉ" name="sotinchi">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal" onclick="resetForm()">Hủy</button>
                                    <button type="submit" class="btn bg-1 text-white shadow-none" name="add_subject">Thêm mới</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Edit Student Modal -->
                <div class="modal fade" id="edit-subject" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="code_subject.php" method="POST" id="SubjectForm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fs-5">Sửa môn học</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <input type="hidden" name="subject_id" id="subject_id">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Mã Môn Học</label>
                                            <input type="text" readonly name="mamonhoc" id="mamonhoc" class="form-control shadow-none" placeholder="Mã Môn Học">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Tên Môn Học</label>
                                            <input type="text" name="tenmonhoc" id="tenmonhoc" class="form-control shadow-none" placeholder="Tên Môn Học">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Số Tín Chỉ</label>
                                            <input type="text" class="form-control shadow-none"
                                                placeholder="Số Tín Chỉ" name="sotinchi" id="sotinchi">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none"
                                        data-bs-dismiss="modal" onclick="resetForm()">Hủy</button>
                                    <button type="submit" class="btn bg-1 text-white shadow-none" name="update_subject">Lưu</button>
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
    // ajax check mã môn học có bị trùng
    $(document).ready(function() {
        function checkDuplicate(field, value, errorElement) {
            const fieldNames = {
                code: 'Mã môn học',
                name: 'Tên môn học',
                credits: 'Số tín chỉ'
            };

            const fieldName = fieldNames[field] || field;
            $.ajax({
                url: 'check_duplicate_subject.php',
                type: 'POST',
                data: { field: field, value: value },
                success: function(response) {
                    if (response === 'duplicate') {
                        const duplicateMessage = `${fieldName} ${value} đã tồn tại.`;
                        $(errorElement).text(duplicateMessage).css('color', 'red');
                    } else {
                        $(errorElement).text('');
                    }
                }
            });
        }

        $('input[name="mamonhoc"]').keyup('blur', function() {
            checkDuplicate('code', $(this).val(), '#subjectCodeError');
        });
    });

    function resetForm() {
        $("#SubjectForm")[0].reset();
        $('#subjectCodeError').text('');
    }

    function editSubject(subjectId) {
        $.ajax({
            url: 'code_subject.php',
            type: 'GET',
            data: { subject_id: subjectId },
            success: function(response) {
                const subject = JSON.parse(response);
                $("#subject_id").val(subject.id || '');
                $("#mamonhoc").val(subject.code || '');
                $("#tenmonhoc").val(subject.name || ''); 
                $("#sotinchi").val(subject.credits || ''); 
            }
        });
    }
    $(document).ready(function() {
        function searchSubjects(query) {
            $.ajax({
                url: 'code_subject.php',
                type: 'GET',
                data: { search: query },
                success: function(response) {
                    $('tbody').html(response);
                }
            });
        }

        $('#searchSubject').on('keyup', function() {
            const query = $(this).val();
            searchSubjects(query);
        });

        function sortSubjects(sortOption) {
            $.ajax({
                url: 'code_subject.php',
                type: 'GET',
                data: { sort: sortOption },
                success: function(response) {
                    $('tbody').html(response);
                }
            });
        }

        $('#sortSubjects').on('change', function() {
            const sortOption = $(this).val();
            if (sortOption) {
                sortSubjects(sortOption);
            }
        });
    });
</script>
</html>