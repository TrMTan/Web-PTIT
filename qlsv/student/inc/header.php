<!-- Nav -->
<nav class="navbar navbar-expand-lg navbar-light bg-1 px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand me-4 fw-bold fs-3 text-light" href="studenthome.php"><i class="bi bi-house-door-fill"></i>Trang chủ</a>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link me-3 fs-5 text-light clhv" href="studenthome.php"><i class="bi bi-person-fill me-1"></i>Thông tin</a>
                </li>
                <div class="d-lg-none"> <!-- Only show on mobile -->
                    <div class="list-group">
                        <li class="nav-item"></li>
                            <a class="nav-link me-3 fs-5 text-light clhv" href="./view_score.php"><i class="bi bi-table me-1"></i>Xem điểm</a>
                        </li>
                    </div>
                </div>
                <li class="nav-item">
                    <a class="nav-link me-3 fs-5 text-light clhv" data-bs-toggle="modal" data-bs-target="#ChangePassModal"><i class="bi bi-person-fill-lock me-1"></i>Đổi mật khẩu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-3 fs-5 text-light clhv" href="../logout.php"><i class="bi bi-box-arrow-in-right me-1"></i>Đăng xuất</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Đổi mật khẩu -->
<div class="modal fade" id="ChangePassModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title d-flex align-items-center">
                    Đổi mật khẩu
                </h3>
                <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="check_pass.php" method="POST">
                    <div class="mb-3">
                        <i class="bi bi-person-fill fs-5"></i>
                        <label class="form-label fs-5">Mật khẩu cũ</label>
                        <input type="password" required name="old_password" class="form-control shadow-none" placeholder="Nhập mật khẩu cũ">
                    </div>
                    <div class="mb-3">
                        <i class="bi bi-lock-fill fs-5"></i>
                        <label class="form-label fs-5">Mật khẩu mới</label>
                        <input type="password" required name="new_password" class="form-control shadow-none" placeholder="Nhập mật khẩu mới">
                    </div>
                    <div class="mb-3">
                        <i class="bi bi-lock-fill fs-5"></i>
                        <label class="form-label fs-5">Nhập Lại Mật khẩu</label>
                        <input type="password" required name="confirm_password" class="form-control shadow-none" placeholder="Xác nhận mật khẩu mới">
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        <button class="btn bg-1 text-white shadow-none fs-5" type="submit" name="submit"><i class="bi bi-arrow-clockwise"></i>Thay Đổi mật khẩu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>