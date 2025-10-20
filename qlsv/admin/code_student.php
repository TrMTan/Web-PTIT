<?php
require "../inc/db.php";
session_start();

// Thêm sinh viên
if(isset($_POST["add_student"])){
    $username = $_POST["masinhvien"];
    $password = $_POST["matkhau"];
    $user_type = "student";
    $fullname = $_POST["hoten"];
    $dob = $_POST["ngaysinh"];
    $address = $_POST["diachi"];
    $gender = $_POST["gioitinh"];
    $phone = $_POST["sodienthoai"];
    $email = $_POST["email"];
    $class = $_POST["lop"];
    $major = $_POST["nganh"];

    $add = "INSERT INTO users(username, password, usertype, fullname, dob, address, gender, phone, email, class, major) VALUES ('$username', '$password', '$user_type', '$fullname', '$dob', '$address', '$gender', '$phone', '$email', '$class', '$major')";
    $result = mysqli_query($conn, $add);
    if($result){
        $_SESSION['message'] = "Thêm sinh viên thành công!";
        $_SESSION['message_type'] = "success";
        header("Location: students.php");
    } else {
        $_SESSION['message'] = "Thêm sinh viên thất bại!";
        $_SESSION['message_type'] = "error";
        header("Location: students.php");
    }
}

// Lấy thông tin sinh viên để sửa
if (isset($_GET['student_id'])) {
    $id = intval($_GET['student_id']);
    $get = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $get);

    if ($result && mysqli_num_rows($result) > 0) {
        $student = $result->fetch_assoc();
        echo json_encode($student);
    } else {
        echo json_encode(['error' => 'No data found']);
    }
} 
// else {
//     echo json_encode(['error' => 'Invalid ID']);
// }

$search = isset($_GET['search']) ? $_GET['search'] : '';
if(!empty($search)) {
    $query = "SELECT * FROM users WHERE fullname LIKE '%$search%' AND usertype = 'student' ORDER BY fullname ASC";
    $result = mysqli_query($conn, $query);

    $cnt = 1;
    while ($student = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<th scope='row'>{$cnt}</th>";
        echo "<td class='text-nowrap'>{$student['username']}</td>";
        echo "<td class='text-nowrap'>{$student['password']}</td>";
        echo "<td class='text-nowrap'>{$student['fullname']}</td>";
        echo "<td class='text-nowrap'>" . date('d/m/Y', strtotime($student['dob'])) . "</td>";
        echo "<td class='text-nowrap'> {$student['address']}</td>";
        echo "<td class='text-nowrap'>{$student['gender']}</td>";
        echo "<td class='text-nowrap'>{$student['phone']}</td>";
        echo "<td class='text-nowrap'>{$student['email']}</td>";
        echo "<td class='text-nowrap'>{$student['class']}</td>";
        echo "<td class='text-nowrap'>{$student['major']}</td>";
        echo "<td class='text-nowrap'>
                <a href='' class='btn btn-warning text-white rounded-pill shadow-none btn-sm' onclick='editStudent({$student['id']})' data-bs-toggle='modal' data-bs-target='#edit-student'><i class='bi bi-pencil-fill'></i> Sửa</a>
                <a onclick=\"return confirm('Bạn có chắc chắn muốn xóa không?');\" href='code_student.php?delete_id={$student['id']}' class='btn btn-danger rounded-pill shadow-none btn-sm'><i class='bi bi-trash-fill'></i> Xóa</a>
              </td>";
        echo "</tr>";
        $cnt++;
    }
}

// Sửa thông tin sinh viên
if (isset($_POST['update_student'])) {
    $id = $_POST["student_id"];
    $password = $_POST["matkhau"];
    $fullname = $_POST["hoten"];
    $dob = $_POST["ngaysinh"];
    $address = $_POST["diachi"];
    $gender = $_POST["gioitinh"];
    $class = $_POST["lop"];
    $major = $_POST["nganh"];

    $edit = "UPDATE users SET password = '$password', fullname = '$fullname', dob = '$dob', address = '$address', gender = '$gender', class = '$class', major = '$major' WHERE id = '$id'";
    $result = mysqli_query($conn, $edit);
    if ($result) {
        $_SESSION['message'] = "Sửa sinh viên thành công!";
        $_SESSION['message_type'] = "success";
        header("Location: students.php");
    } else {
        $_SESSION['message'] = "Sửa sinh viên thất bại!";
        $_SESSION['message_type'] = "error";
        header("Location: students.php");
    }
}

// Sắp xếp sinh viên
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
if(!empty($sort)) {
    $query = "SELECT * FROM users WHERE usertype = 'student'";
    
    switch($sort) {
        case 'name_asc':
            $query .= " ORDER BY fullname ASC";
            break;
        case 'name_desc':
            $query .= " ORDER BY fullname DESC";
            break;
        case 'class_asc':
            $query .= " ORDER BY class ASC";
            break;
        case 'class_desc':
            $query .= " ORDER BY class DESC";
            break;
        case 'id_asc':
            $query .= " ORDER BY username ASC";
            break;
        case 'id_desc':
            $query .= " ORDER BY username DESC";
            break;
        default:
            $query .= "";
    }

    $result = mysqli_query($conn, $query);
    
    $cnt = 1;
    while ($student = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<th scope='row'>{$cnt}</th>";
        echo "<td class='text-nowrap'>{$student['username']}</td>";
        echo "<td class='text-nowrap'>{$student['password']}</td>";
        echo "<td class='text-nowrap'>{$student['fullname']}</td>";
        echo "<td class='text-nowrap'>" . date('d/m/Y', strtotime($student['dob'])) . "</td>";
        echo "<td class='text-nowrap'>{$student['address']}</td>";
        echo "<td class='text-nowrap'>{$student['gender']}</td>";
        echo "<td class='text-nowrap'>{$student['phone']}</td>";
        echo "<td class='text-nowrap'>{$student['email']}</td>";
        echo "<td class='text-nowrap'>{$student['class']}</td>";
        echo "<td class='text-nowrap'>{$student['major']}</td>";
        echo "<td class='text-nowrap'>
                <a href='' class='btn btn-warning text-white rounded-pill shadow-none btn-sm' onclick='editStudent({$student['id']})' data-bs-toggle='modal' data-bs-target='#edit-student'><i class='bi bi-pencil-fill'></i> Sửa</a>
                <a onclick=\"return confirm('Bạn có chắc chắn muốn xóa không?');\" href='code_student.php?delete_id={$student['id']}' class='btn btn-danger rounded-pill shadow-none btn-sm'><i class='bi bi-trash-fill'></i> Xóa</a>
              </td>";
        echo "</tr>";
        $cnt++;
    }
}

// Xóa sinh viên
error_reporting(0);
if($_GET['delete_id']){
    $user_id = $_GET['delete_id'];
    $delete = "DELETE FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $delete);
    if($result){
        $_SESSION['message'] = "Xóa sinh viên thành công!";
        $_SESSION['message_type'] = "success";
        header("Location: students.php");
    }else{
        $_SESSION['message'] = "Xóa sinh viên thất bại!";
        $_SESSION['message_type'] = "error";
        header("Location: students.php");
    }
}
?>