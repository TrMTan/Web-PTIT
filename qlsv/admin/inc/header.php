<div class="container-fluid bg-1 text-light p-3 d-flex align-items-center justify-content-between sticky-top" style="z-index: 2;">
    <h3 class="mb-0">Trang quản lí sinh viên</h3>
    <a href="../logout.php" class="btn btn-light btn-sm me-2">Đăng xuất</a>
</div>

<div class="col-lg-2 bg-dark border-top border-3 border-secondary d-none" id="dashboard-menu">
  <nav class="navbar navbar-expand-lg navbar-dark">
  </nav>
</div>

<div class="col-lg-2 bg-dark border-top border-3 border-secondary" id="dashboard-menu" style="z-index: 1;">
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid flex-lg-column align-items-stretch">
      <h4 class="mt-2 text-white">Trang chủ admin</h4>
      <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#adminDropdown" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="adminDropdown">
        <ul class="nav nav-pills flex-column">
          <li class="nav-item clhv2">
            <a class="nav-link text-white fs-5" href="adminhome.php">Trang chủ</a>
          </li>
          <li class="nav-item clhv2">
            <a class="nav-link text-white fs-5" href="students.php">Sinh viên</a>
          </li>
          <li class="nav-item clhv2">
            <a class="nav-link text-white fs-5" href="subjects.php">Môn học</a>
          </li>
          <li class="nav-item clhv2">
            <a class="nav-link text-white fs-5" href="scores.php">Điểm thi</a>
          </li>
          <li class="nav-item clhv2">
            <a class="nav-link text-white fs-5" href="companies.php">Công ty</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</div>
