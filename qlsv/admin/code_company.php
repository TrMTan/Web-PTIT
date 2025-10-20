<?php
require "../inc/db.php";
session_start();

// Thêm công ty
if(isset($_POST["add_company"])){
    $name = $_POST["tencongty"];
    $gpa = $_POST["gpa"];

    $add = "INSERT INTO companies(name, gpa) VALUES ('$name', '$gpa')";
    $result = mysqli_query($conn, $add);
    if($result){
        $_SESSION['message'] = "Thêm công ty thành công!";
        $_SESSION['message_type'] = "success";
        header("Location: companies.php");
    } else {
        $_SESSION['message'] = "Thêm công ty thất bại!";
        $_SESSION['message_type'] = "error";
        header("Location: companies.php");
    }
}

if (isset($_GET['company_id_st'])) {
    $company_id = $_GET['company_id_st'];
    $sql = "SELECT u.id AS student_id, u.username, u.fullname, u.gender, u.address, u.dob, 
                   ROUND(SUM(s.score_4 * sb.credits) / SUM(sb.credits), 2) AS GPA
            FROM users u
            JOIN scores s ON u.id = s.student_id
            JOIN subjects sb ON s.subject_id = sb.id
            GROUP BY u.id
            HAVING GPA >= (SELECT gpa FROM companies WHERE id = '$company_id') 
            ORDER BY GPA DESC";
    $result = $conn->query($sql);
    $cnt = 1;
    while ($student = $result->fetch_assoc()) {
        echo "<tr class='align-middle'>";
        echo "<th scope='row'>{$cnt}</th>";
        echo "<td class='text-nowrap'>{$student['username']}</td>";
        echo "<td class='text-nowrap'>{$student['fullname']}</td>";
        echo "<td class='text-nowrap'>{$student['gender']}</td>";
        echo "<td class='text-nowrap'>{$student['address']}</td>";
        echo "<td class='text-nowrap'>{$student['dob']}</td>";
        echo "<td class='text-nowrap'>{$student['GPA']}</td>";
        echo "</tr>";
        $cnt++;
    }
}
                                                   
// Tìm công ty
$search = isset($_GET['search']) ? $_GET['search'] : '';
if(!empty($search)) {
    $query = "SELECT * FROM companies WHERE name LIKE '%$search%' ORDER BY name ASC";
    $result = mysqli_query($conn, $query);

    $cnt = 1;
    while ($company = mysqli_fetch_assoc($result)) {
        echo "<tr class='align-middle'>";
        echo "<th scope='row'>{$cnt}</th>";
        echo "<td class='text-nowrap'>{$company['name']}</td>";
        echo "<td class='text-nowrap'>{$company['gpa']}</td>";
        echo "<td class='text-nowrap'>";
        echo "<a href='' class='btn btn-primary text-white rounded-pill shadow-none btn-sm me-1' onclick='viewStudents({$company['id']})' data-bs-toggle='modal' data-bs-target='#view-student'><i class='bi bi-eye-fill'></i> Xem DS Sinh Viên</a>";
        echo "<a href='' class='btn btn-warning text-white rounded-pill shadow-none btn-sm me-1' onclick='editCompany({$company['id']})' data-bs-toggle='modal' data-bs-target='#edit-company'><i class='bi bi-pencil-fill'></i> Sửa</a>";
        echo "<a onclick=\"return confirm('Bạn có chắc chắn muốn xóa không?');\" href='code_company.php?delete_id={$company['id']}' class='btn btn-danger rounded-pill shadow-none btn-sm'><i class='bi bi-trash-fill'></i> Xóa</a>";
        echo "</td>";
        echo "</tr>";
        $cnt++;
    }
}

// Lấy thông tin công ty để sửa
if (isset($_GET['company_id'])) {
    $id = intval($_GET['company_id']);
    $get = "SELECT * FROM companies WHERE id = $id";
    $result = mysqli_query($conn, $get);

    if ($result && mysqli_num_rows($result) > 0) {
        $student = $result->fetch_assoc();
        echo json_encode($student);
    } else {
        echo json_encode(['error' => 'No data found']);
    }
} 

// Sửa thông tin công ty
if (isset($_POST['update_company'])) {
    $id = $_POST["company_id"];
    $gpa = $_POST["gpa"];

    $edit = "UPDATE companies SET gpa = '$gpa' WHERE id = '$id'";
    $result = mysqli_query($conn, $edit);
    if ($result) {
        $_SESSION['message'] = "Sửa công ty thành công!";
        $_SESSION['message_type'] = "success";
        header("Location: companies.php");
    } else {
        $_SESSION['message'] = "Sửa công ty thất bại!";
        $_SESSION['message_type'] = "error";
        header("Location: companies.php");
    }
}

// Sắp xếp công ty
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
if(!empty($sort)) {
    $query = "SELECT * FROM companies";
    
    switch($sort) {
        case 'name_asc':
            $query .= " ORDER BY name ASC";
            break;
        case 'name_desc':
            $query .= " ORDER BY name DESC";
            break;
        case 'gpa_asc':
            $query .= " ORDER BY gpa ASC";
            break;
        case 'gpa_desc':
            $query .= " ORDER BY gpa DESC";
            break;
        default:
            $query .= "";
    }

    $result = mysqli_query($conn, $query);
    
    $cnt = 1;
    while ($company = mysqli_fetch_assoc($result)) {
        echo "<tr class='align-middle'>";
        echo "<th scope='row'>{$cnt}</th>";
        echo "<td class='text-nowrap'>{$company['name']}</td>";
        echo "<td class='text-nowrap'>{$company['gpa']}</td>";
        echo "<td class='text-nowrap'>";
        echo "<a href='' class='btn btn-primary text-white rounded-pill shadow-none btn-sm me-1' onclick='viewStudents({$company['id']})' data-bs-toggle='modal' data-bs-target='#view-student'><i class='bi bi-eye-fill'></i> Xem DS Sinh Viên</a>";
        echo "<a href='' class='btn btn-warning text-white rounded-pill shadow-none btn-sm me-1' onclick='editCompany({$company['id']})' data-bs-toggle='modal' data-bs-target='#edit-company'><i class='bi bi-pencil-fill'></i> Sửa</a>";
        echo "<a onclick=\"return confirm('Bạn có chắc chắn muốn xóa không?');\" href='code_company.php?delete_id={$company['id']}' class='btn btn-danger rounded-pill shadow-none btn-sm'><i class='bi bi-trash-fill'></i> Xóa</a>";
        echo "</td>";
        echo "</tr>";
        $cnt++;
    }
}

// Xóa sinh viên
error_reporting(0);
if($_GET['delete_id']){
    $company_id = $_GET['delete_id'];
    $delete = "DELETE FROM companies WHERE id = '$company_id'";
    $result = mysqli_query($conn, $delete);
    if($result){
        $_SESSION['message'] = "Xóa công ty thành công!";
        $_SESSION['message_type'] = "success";
        header("Location: companies.php");
    }else{
        $_SESSION['message'] = "Xóa công ty thất bại!";
        $_SESSION['message_type'] = "error";
        header("Location: companies.php");
    }
}
?>