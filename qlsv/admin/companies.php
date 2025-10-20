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
    <title>Trang chủ quản lí - Công ty</title>
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
                    <h3 class="mb-4 fs-2 mt-5">Danh Sách Công Ty</h3> 
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
                        <div class="text-end mb-4 d-flex d-flex align-items-center">
                            <input type="text" id="searchCompany" class="form-control me-2 shadow-none" placeholder="Tìm kiếm công ty" style="width: 500px;">
                            <select id="sortCompanies" class="form-select me-2 shadow-none" style="width: auto; max-height: 50px;">
                                <option value="">Sắp xếp theo</option>
                                <option value="name_asc">Tên A-Z</option>
                                <option value="name_desc">Tên Z-A</option>
                                <option value="gpa_asc">GPA tăng dần</option>
                                <option value="gpa_desc">GPA giảm dần</option>
                            </select>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#add-company">
                                <i class="bi bi-plus-square"></i> Thêm mới công ty
                            </button>
                        </div>
                        <div class="table-responsive" style="height: 550px; overflow-y: scroll;">
                            <table class="table table-hover border">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-nowrap">STT</th>
                                        <th scope="col" class="text-nowrap">Tên Công ty</th>
                                        <th scope="col" class="text-nowrap">GPA tối thiểu</th>
                                        <th scope="col" class="text-nowrap">Tùy chọn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $sql = "SELECT * FROM `companies`";
                                        $result = mysqli_query($conn, $sql);
                                        $cnt = 1;
                                        while($company=$result->fetch_assoc())
                                        {
                                    ?>
                                        <tr class="align-middle">
                                            <th scope="row"><?php echo "{$cnt}"; ?></th>
                                            <td class="text-nowrap"><?php echo "{$company['name']}"; ?></td>
                                            <td class="text-nowrap"><?php echo "{$company['gpa']}"; ?></td>
                                            <td class="text-nowrap">
                                                <?php echo "<a href='' class='btn btn-primary text-white rounded-pill shadow-none btn-sm' onclick='viewStudents({$company['id']})' data-bs-toggle='modal' data-bs-target='#view-student'><i class='bi bi-eye-fill'></i> Xem DS Sinh Viên</a>"; ?>
                                                <?php echo "<a href='' class='btn btn-warning text-white rounded-pill shadow-none btn-sm' onclick='editCompany({$company['id']})' data-bs-toggle='modal' data-bs-target='#edit-company'><i class='bi bi-pencil-fill'></i> Sửa</a>"; ?>
                                                <?php echo "<a onclick=\"return confirm('Bạn có chắc chắn muốn xóa không?');\" href='code_company.php?delete_id={$company['id']}' class='btn btn-danger rounded-pill shadow-none btn-sm'><i class='bi bi-trash-fill'></i> Xóa</a>"; ?>
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

                <!-- Add Company Modal -->
                <div class="modal fade" id="add-company" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="code_company.php" method="POST" id="CompaniesForm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fs-5">Thêm công ty</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Tên công ty</label>
                                            <input type="text" name="tencongty" class="form-control shadow-none" placeholder="Tên công ty">
                                            <span id="companiesCodeError"></span>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">GPA tối thiểu</label>
                                            <input type="text" name="gpa" class="form-control shadow-none" placeholder="GPA tối thiểu">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none" data-bs-dismiss="modal" onclick="resetForm()">Hủy</button>
                                    <button type="submit" class="btn bg-1 text-white shadow-none" name="add_company">Thêm mới</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Edit Company Modal -->
                <div class="modal fade" id="edit-company" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="code_company.php" method="POST" id="CompaniesForm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fs-5">Sửa công ty</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <input type="hidden" name="company_id" id="company_id">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Tên công ty</label>
                                            <input type="text" readonly name="tencongty" id="tencongty" class="form-control shadow-none" placeholder="Tên công ty">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">GPA tối thiểu</label>
                                            <input type="text" name="gpa" id="gpa" class="form-control shadow-none" placeholder="GPA tối thiểu">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn text-secondary shadow-none"
                                        data-bs-dismiss="modal" onclick="resetForm()">Hủy</button>
                                    <button type="submit" class="btn bg-1 text-white shadow-none" name="update_company">Lưu</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- View Student Modal -->
                <div class="modal fade" id="view-student" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <form action="code_companies.php" method="POST" id="CompaniesForm">
                            <div class="modal-content">
                                <div class="modal-header d-flex">
                                    <h5 class="modal-title fs-5">Danh Sách Sinh Viên</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="table-responsive" style="height: 550px; overflow-y: scroll;">
                                            <table class="table table-hover border">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-nowrap">STT</th>
                                                        <th scope="col" class="text-nowrap">Mã sinh viên</th>
                                                        <th scope="col" class="text-nowrap">Họ và tên</th>
                                                        <th scope="col" class="text-nowrap">Giới tính</th>
                                                        <th scope="col" class="text-nowrap">Địa chỉ</th>
                                                        <th scope="col" class="text-nowrap">Ngày sinh</th>  
                                                        <th scope="col" class="text-nowrap">GPA</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
    // ajax check tên công ty trùng
    $(document).ready(function() {
        function checkDuplicate(field, value, errorElement) {
            const fieldNames = {
                name: 'Tên Công Ty'
            };

            const fieldName = fieldNames[field] || field;
            $.ajax({
                url: 'check_duplicate_company.php',
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

        $('input[name="tencongty"]').keyup('blur', function() {
            checkDuplicate('name', $(this).val(), '#companiesCodeError');
        });
    });

    function resetForm() {
        $("#CompaniesForm")[0].reset();
        $('#companiesCodeError').text('');
    }

    function editCompany(companyId) {
        $.ajax({
            url: 'code_company.php',
            type: 'GET',
            data: { company_id: companyId },
            success: function(response) {
                const company = JSON.parse(response);
                $("#company_id").val(company.id || '');
                $("#tencongty").val(company.name || ''); 
                $("#gpa").val(company.gpa || ''); 
            }
        });
    }

    function viewStudents(companyId) {
        $.ajax({
            url: 'code_company.php',
            type: 'GET',
            data: { company_id_st: companyId },
            success: function(response) {
                $('#view-student tbody').html(response);
            }
        });
    }

    $(document).ready(function() {
        function searchCompanies(query) {
            $.ajax({
                url: 'code_company.php',
                type: 'GET',
                data: { search: query },
                success: function(response) {
                    $('tbody').html(response);
                }
            });
        }

        $('#searchCompany').on('keyup', function() {
            const query = $(this).val();
            searchCompanies(query);
        });

        function sortCompanies(sortOption) {
            $.ajax({
                url: 'code_company.php',
                type: 'GET',
                data: { sort: sortOption },
                success: function(response) {
                    $('tbody').html(response);
                }
            });
        }

        $('#sortCompanies').on('change', function() {
            const sortOption = $(this).val();
            if (sortOption) {
                sortCompanies(sortOption);
            }
        });
    });
</script>
</html>