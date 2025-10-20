<!-- Nav -->
<nav class="navbar navbar-expand-lg navbar-light bg-1 px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand me-4 fw-bold fs-3 text-light" href="index.php"><i class="bi bi-house-door-fill"></i>Trang
            chủ</a>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link me-3 fs-5 text-light clhv" href="#contact"><i
                            class="bi bi-person-fill me-1"></i>Liên hệ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-3 fs-5 text-light clhv" href="#howtouse"><i
                            class="bi bi-book-fill me-1"></i></i>Hướng dẫn</a>
                </li>
            </ul>
            <div class="d-flex ms-auto">
                <a class="navbar-brand text-light clhv" style="cursor: pointer;" data-bs-toggle="modal"
                    data-bs-target="#LoginModal"><i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập</a>
            </div>
        </div>
    </div>
</nav>

<!-- Đăng nhập -->
<div class="modal fade" id="LoginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-block">
                    <h3 class="modal-title d-flex align-items-center">
                        Đăng nhập
                    </h3>
                    <h4 class="text-danger mt-2 mb-0">
                        <?php 
                            error_reporting(0);
                            session_start();
                            session_destroy();
                            echo isset($_SESSION['loginMessage']) ? $_SESSION['loginMessage'] : '';
                        ?>
                    </h4>
                </div>
                <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="check_login.php" method="POST" id="LoginForm">
                    <div class="mb-3">
                        <i class="bi bi-person-fill fs-5"></i>
                        <label class="form-label fs-5">Tài khoản</label>
                        <input type="text" required name="username" class="form-control shadow-none" 
                            placeholder="Nhập tài khoản" value="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>">
                    </div>
                    <div class="mb-4">
                        <i class="bi bi-lock-fill fs-5"></i>
                        <label class="form-label fs-5">Mật khẩu</label>
                        <input type="password" required name="password" class="form-control shadow-none"
                            placeholder="Nhập mật khẩu" value="<?php echo isset($_SESSION['password']) ? htmlspecialchars($_SESSION['password']) : ''; ?>">
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <button class="btn bg-1 text-white shadow-none w-100 fs-5" type="submit" name="submit"><i
                                class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
