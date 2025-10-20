<?php
require "../inc/db.php";
session_start();

// Thêm môn học
if(isset($_POST["add_subject"])){
    $code = $_POST["mamonhoc"];
    $name = $_POST["tenmonhoc"];
    $credits = $_POST["sotinchi"];

    $add = "INSERT INTO subjects(code, name, credits) VALUES ('$code', '$name', '$credits')";
    $result = mysqli_query($conn, $add);
    if($result){
        $_SESSION['message'] = "Thêm môn học thành công!";
        $_SESSION['message_type'] = "success";
        header("Location: subjects.php");
    } else {
        $_SESSION['message'] = "Thêm môn học thất bại!";
        $_SESSION['message_type'] = "error";
        header("Location: subjects.php");
    }
}

// Lấy thông tin môn học để sửa
if (isset($_GET['subject_id'])) {
    $id = intval($_GET['subject_id']);
    $get = "SELECT * FROM subjects WHERE id = $id";
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

// Tìm kiếm môn học
$search = isset($_GET['search']) ? $_GET['search'] : '';
if(!empty($search)) {
    $query = "SELECT * FROM subjects WHERE name LIKE '%$search%' ORDER BY name ASC";
    $result = mysqli_query($conn, $query);

    $cnt = 1;
    while ($subject = mysqli_fetch_assoc($result)) {
        echo "<tr class='align-middle'>";
        echo "<th scope='row'>{$cnt}</th>";
        echo "<td class='text-nowrap'>{$subject['code']}</td>";
        echo "<td class='text-nowrap'>{$subject['name']}</td>";
        echo "<td class='text-nowrap'>{$subject['credits']}</td>";
        echo "<td class='text-nowrap'>";
        echo "<a href='' class='btn btn-warning text-white rounded-pill shadow-none btn-sm me-1' onclick='editSubject({$subject['id']})' data-bs-toggle='modal' data-bs-target='#edit-subject'><i class='bi bi-pencil-fill'></i> Sửa</a>";
        echo "<a onclick=\"return confirm('Bạn có chắc chắn muốn xóa không?');\" href='code_subject.php?delete_id={$subject['id']}' class='btn btn-danger rounded-pill shadow-none btn-sm'><i class='bi bi-trash-fill'></i> Xóa</a>";
        echo "</td>";
        echo "</tr>";
        $cnt++;
    }
}

// Sửa thông tin môn học
if (isset($_POST['update_subject'])) {
    $id = $_POST["subject_id"];
    $name = $_POST["tenmonhoc"];
    $credits = $_POST["sotinchi"];

    $edit = "UPDATE subjects SET name = '$name', credits = '$credits' WHERE id = '$id'";
    $result = mysqli_query($conn, $edit);
    if ($result) {
        $_SESSION['message'] = "Sửa môn học thành công!";
        $_SESSION['message_type'] = "success";
        header("Location: subjects.php");
    } else {
        $_SESSION['message'] = "Sửa môn học thất bại!";
        $_SESSION['message_type'] = "error";
        header("Location: subjects.php");
    }
}

// Sắp xếp môn học
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
if(!empty($sort)) {
    $query = "SELECT * FROM subjects";
    
    switch($sort) {
        case 'name_asc':
            $query .= " ORDER BY name ASC";
            break;
        case 'name_desc':
            $query .= " ORDER BY name DESC";
            break;
        case 'code_asc':
            $query .= " ORDER BY code ASC";
            break;
        case 'code_desc':
            $query .= " ORDER BY code DESC";
            break;
        case 'credits_asc':
            $query .= " ORDER BY credits DESC";
            break;
        case 'credits_desc':
            $query .= " ORDER BY credits DESC";
            break;
        default:
            $query .= "";
    }

    $result = mysqli_query($conn, $query);
    
    $cnt = 1;
    while ($subject = mysqli_fetch_assoc($result)) {
        echo "<tr class='align-middle'>";
        echo "<th scope='row'>{$cnt}</th>";
        echo "<td class='text-nowrap'>{$subject['code']}</td>";
        echo "<td class='text-nowrap'>{$subject['name']}</td>";
        echo "<td class='text-nowrap'>{$subject['credits']}</td>";
        echo "<td class='text-nowrap'>";
        echo "<a href='' class='btn btn-warning text-white rounded-pill shadow-none btn-sm me-1' onclick='editSubject({$subject['id']})' data-bs-toggle='modal' data-bs-target='#edit-subject'><i class='bi bi-pencil-fill'></i> Sửa</a>";
        echo "<a onclick=\"return confirm('Bạn có chắc chắn muốn xóa không?');\" href='code_subject.php?delete_id={$subject['id']}' class='btn btn-danger rounded-pill shadow-none btn-sm'><i class='bi bi-trash-fill'></i> Xóa</a>";
        echo "</td>";
        echo "</tr>";
        $cnt++;
    }
}

// Xóa môn học
error_reporting(0);
if($_GET['delete_id']){
    $subject_id = $_GET['delete_id'];
    $delete = "DELETE FROM subjects WHERE id = '$subject_id'";
    $result = mysqli_query($conn, $delete);
    if($result){
        $_SESSION['message'] = "Xóa môn học thành công!";
        $_SESSION['message_type'] = "success";
        header("Location: subjects.php");
    }else{
        $_SESSION['message'] = "Xóa môn học thất bại!";
        $_SESSION['message_type'] = "error";
        header("Location: subject.php");
    }
}
?>