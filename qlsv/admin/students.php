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
    <title>Trang chủ quản lí - Sinh Viên</title>
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
                    <h3 class="mb-4 fs-2 mt-5">Danh Sách Sinh viên</h3> 
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
                            <input type="text" id="searchStudent" class="form-control me-2 shadow-none" placeholder="Tìm kiếm sinh viên" style="width: 500px;">
                            <select id="sortStudents" class="form-select me-2 shadow-none" style="width: auto; max-height: 50px;">
                                <option value="">Sắp xếp theo</option>
                                <option value="name_asc">Tên A-Z</option>
                                <option value="name_desc">Tên Z-A</option>
                                <option value="class_asc">Lớp tăng dần</option>
                                <option value="class_desc">Lớp giảm dần</option>
                                <option value="id_asc">Mã SV tăng dần</option>
                                <option value="id_desc">Mã SV giảm dần</option>
                            </select>
                            <button type="button" class="btn btn-dark shadow-none btn-sm me-2" data-bs-toggle="modal"
                                data-bs-target="#add-student" style="max-height: 50px;">
                                <i class="bi bi-plus-square"></i> Thêm mới sinh viên
                            </button>
                            <button type="button" class="btn btn-success shadow-none btn-sm me-2" onclick="window.location.href='export_excel.php'" style="max-height: 50px;">
                                <i class="bi bi-file-earmark-spreadsheet"></i> Xuất Excel
                            </button>
                        </div>
                        <div class="table-responsive" style="height: 550px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-nowrap">STT</th>
                                        <th scope="col" class="text-nowrap">Mã Sinh viên</th>
                                        <th scope="col" class="text-nowrap">Mật Khẩu</th>
                                        <th scope="col" class="text-nowrap">Họ Và Tên</th>
                                        <th scope="col" class="text-nowrap">Ngày sinh</th>
                                        <th scope="col" class="text-nowrap">Địa chỉ</th>
                                        <th scope="col" class="text-nowrap">Giới tính</th>
                                        <th scope="col" class="text-nowrap">Số điện thoại</th>
                                        <th scope="col" class="text-nowrap">Email</th>
                                        <th scope="col" class="text-nowrap">Lớp</th>
                                        <th scope="col" class="text-nowrap">Ngành</th>
                                        <th scope="col" class="text-nowrap">Tùy chọn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql = "SELECT * FROM `users` WHERE usertype='student'";
                                        $result = mysqli_query($conn, $sql);
                                        $cnt = 1;
                                        while($student=$result->fetch_assoc())
                                        {
                                    ?>
                                        <tr class="align-middle">
                                            <th scope="row"><?php echo "{$cnt}"; ?></th>
                                            <td class="text-nowrap"><?php echo "{$student['username']}"; ?></td>
                                            <td class="text-nowrap"><?php echo "{$student['password']}"; ?></td>
                                            <td class="text-nowrap"><?php echo "{$student['fullname']}"; ?></td>
                                            <td class="text-nowrap"><?php echo date("d/m/Y", strtotime($student['dob'])); ?></td>
                                            <td class="text-nowrap"><?php echo "{$student['address']}"; ?></td>
                                            <td class="text-nowrap"><?php echo "{$student['gender']}"; ?></td>
                                            <td class="text-nowrap"><?php echo "{$student['phone']}"; ?></td>
                                            <td class="text-nowrap"><?php echo "{$student['email']}"; ?></td>
                                            <td class="text-nowrap"><?php echo "{$student['class']}"; ?></td>
                                            <td class="text-nowrap"><?php echo "{$student['major']}"; ?></td>
                                            <td class="text-nowrap">
                                                <?php echo "<a href='' class='btn btn-warning text-white rounded-pill shadow-none btn-sm' onclick='editStudent({$student['id']})' data-bs-toggle='modal' data-bs-target='#edit-student'><i class='bi bi-pencil-fill'></i> Sửa</a>"; ?>
                                                <?php echo "<a onclick=\"return confirm('Bạn có chắc chắn muốn xóa không?');\" href='code_student.php?delete_id={$student['id']}' class='btn btn-danger rounded-pill shadow-none btn-sm'><i class='bi bi-trash-fill'></i> Xóa</a>"; ?>
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
                <div class="modal fade" id="add-student" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form action="code_student.php" method="POST" id="StudentForm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fs-5">Thêm Sinh Viên</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Mã Sinh Viên</label>
                                            <input type="text" name="masinhvien" class="form-control shadow-none" placeholder="Mã Sinh Viên">
                                            <span id="studentCodeError"></span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Mật Khẩu</label>
                                            <input type="text" name="matkhau" class="form-control shadow-none" placeholder="Mật Khẩu">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Họ Và Tên</label>
                                            <input type="text" required class="form-control shadow-none"
                                                placeholder="Họ Và Tên" name="hoten">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Ngày Sinh</label>
                                            <input type="date" required class="form-control shadow-none"
                                                placeholder="Ngày Sinh" name="ngaysinh">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Địa chỉ</label>
                                            <input type="text" required class="form-control shadow-none"
                                                placeholder="Địa Chỉ" name="diachi">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Giới Tính</label>
                                            <input type="text" required class="form-control shadow-none"
                                                placeholder="Giới tính" name="gioitinh">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Số Điện Thoại</label>
                                            <input type="text" required class="form-control shadow-none"
                                                placeholder="Số Điện Thoại" name="sodienthoai">
                                            <span id="phoneError"></span>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control shadow-none" placeholder="Email" name="email">
                                            <span id="emailError"></span> 
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Lớp</label>
                                            <input type="text" class="form-control shadow-none" placeholder="Lớp" name="lop">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Ngành</label>
                                            <input type="text" class="form-control shadow-none" placeholder="Ngành" name="nganh">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal" onclick="resetForm()">Hủy</button>
                                    <button type="submit" class="btn bg-1 text-white shadow-none" name="add_student">Thêm mới</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Edit Student Modal -->
                <div class="modal fade" id="edit-student" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form action="code_student.php" method="POST" id="StudentForm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fs-5">Sửa sinh viên</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <input type="hidden" name="student_id" id="student_id">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Mã Sinh Viên</label>
                                            <input type="text" readonly name="masinhvien" id="masinhvien" class="form-control shadow-none" placeholder="Mã Sinh Viên">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Mật Khẩu</label>
                                            <input type="text" name="matkhau" id="matkhau" class="form-control shadow-none" placeholder="Mật Khẩu">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Họ Và Tên</label>
                                            <input type="text" class="form-control shadow-none"
                                                placeholder="Họ Và Tên" name="hoten" id="hoten">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Ngày Sinh</label>
                                            <input type="date" class="form-control shadow-none"
                                                placeholder="Ngày Sinh" name="ngaysinh" id="ngaysinh">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Địa chỉ</label>
                                            <input type="text" class="form-control shadow-none"
                                                placeholder="Địa Chỉ" name="diachi" id="diachi">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Giới Tính</label>
                                            <input type="text" class="form-control shadow-none"
                                                placeholder="Giới tính" name="gioitinh" id="gioitinh">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Số Điện Thoại</label>
                                            <input type="text" readonly class="form-control shadow-none"
                                                placeholder="Số Điện Thoại" name="sodienthoai" id="sodienthoai">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" readonly class="form-control shadow-none" placeholder="Email" name="email" id="email">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Lớp</label>
                                            <input type="text" class="form-control shadow-none" placeholder="Lớp" name="lop" id="lop">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Ngành</label>
                                            <input type="text" class="form-control shadow-none" placeholder="Ngành" name="nganh" id="nganh">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none"
                                        data-bs-dismiss="modal" onclick="resetForm()">Hủy</button>
                                    <button type="submit" class="btn bg-1 text-white shadow-none" name="update_student">Lưu</button>
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
    // ajax check SĐT, email, mã sinh viên trùng
    $(document).ready(function() {
        function checkDuplicate(field, value, errorElement) {
            const fieldNames = {
                username: 'Mã Sinh Viên',
                phone: 'Số Điện Thoại',
                email: 'Email'
            };

            const fieldName = fieldNames[field] || field;
            $.ajax({
                url: 'check_duplicate_student.php',
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

        $('input[name="masinhvien"]').keyup('blur', function() {
            checkDuplicate('username', $(this).val(), '#studentCodeError');
        });

        $('input[name="sodienthoai"]').keyup('blur', function() {
            checkDuplicate('phone', $(this).val(), '#phoneError');
        });

        $('input[name="email"]').keyup('blur', function() {
            checkDuplicate('email', $(this).val(), '#emailError');
        });
    });

    function resetForm() {
        $("#StudentForm")[0].reset();
        $('#studentCodeError').text('');
        $('#phoneError').text('');
        $('#emailError').text('');
    }

    function editStudent(studentId) {
        $.ajax({
            url: 'code_student.php',
            type: 'GET',
            data: { student_id: studentId },
            success: function(response) {
                const student = JSON.parse(response);
                $("#student_id").val(student.id || '');
                $("#masinhvien").val(student.username || '');
                $("#matkhau").val(student.password || ''); 
                $("#hoten").val(student.fullname || '');
                $("#ngaysinh").val(student.dob || '');
                $("#diachi").val(student.address || '');
                $("#gioitinh").val(student.gender || '');
                $("#sodienthoai").val(student.phone || '');
                $("#email").val(student.email || '');
                $("#lop").val(student.class || '');
                $("#nganh").val(student.major || '');
            }
        });
    }

    $(document).ready(function() {
        function searchStudents(query) {
            $.ajax({
                url: 'code_student.php',
                type: 'GET',
                data: { search: query },
                success: function(response) {
                    $('tbody').html(response);
                }
            });
        }

        $('#searchStudent').on('keyup', function() {
            const query = $(this).val();
            searchStudents(query);
        });

        function sortStudents(sortOption) {
            $.ajax({
                url: 'code_student.php',
                type: 'GET',
                data: { sort: sortOption },
                success: function(response) {
                    $('tbody').html(response);
                }
            });
        }

        $('#sortStudents').on('change', function() {
            const sortOption = $(this).val();
            if (sortOption) {
                sortStudents(sortOption);
            }
        });
    });

</script>
</html>