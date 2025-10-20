<?php
require "../inc/db.php";
session_start();

// Lấy thông tin điểm của sinh viên
if(isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    $query = "SELECT scores.id, subjects.code, subjects.name, subjects.credits, 
              scores.score_10, scores.score_4, scores.score_char, scores.pass
              FROM scores 
              JOIN subjects ON scores.subject_id = subjects.id 
              WHERE scores.student_id = '$student_id'";
              
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
    $output = "";
    $cnt = 1;
    while ($score = mysqli_fetch_assoc($result)) {
        $pass_status = ($score['pass'] == 'True') ? 'Đạt' : 'Trượt';
        $output .= "<tr>
                        <td>{$cnt}</td>
                        <td>{$score['code']}</td>
                        <td>{$score['name']}</td>
                        <td>{$score['credits']}</td>
                        <td>{$score['score_10']}</td>
                        <td>{$score['score_4']}</td>
                        <td>{$score['score_char']}</td>
                        <td>{$pass_status}</td>
                        <td>
                            <a href='' class='btn btn-warning text-white rounded-pill shadow-none btn-sm' onclick='editScore({$score['id']})' data-bs-toggle='modal' data-bs-target='#edit-score'><i class='bi bi-pencil-fill'></i> Sửa</a>
                            <a onclick=\"return confirm('Bạn có chắc chắn muốn xóa không?');\" href='code_score.php?delete_id={$score['id']}' class='btn btn-danger rounded-pill shadow-none btn-sm'><i class='bi bi-trash-fill'></i> Xóa</a>
                        </td>
                    </tr>";
        $cnt++;
    }
    
    echo $output;
    mysqli_free_result($result);
}

// Lấy thông tin môn học để thêm
if(isset($_GET['subject_id'])) {
    $subject_id = $_GET['subject_id'];
    
    $query = "SELECT * FROM subjects WHERE id = '$subject_id'";
    $result = mysqli_query($conn, $query);
    
    if ($result->num_rows > 0) {
        $subject = $result->fetch_assoc();
        echo json_encode($subject);
    } else {
        echo json_encode(["name" => "", "credits" => ""]);
    }
}

// Thêm điểm cho sinh viên
if(isset($_POST['add_score'])) {
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $score_10 = $_POST['score_10'];
    $score_4 = $_POST['score_4'];
    $score_char = $_POST['score_char'];
    $pass = $score_10 >= 4 ? 'True' : 'False';

    $check_query = "SELECT * FROM scores WHERE student_id = '$student_id' AND subject_id = '$subject_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['message'] = "Sinh viên đã có điểm cho môn học này!";
        $_SESSION['message_type'] = "error";
        header("Location: scores.php?student_id=" . $student_id);
    } else {
        $sql = "INSERT INTO scores(student_id, subject_id, score_10, score_4, score_char, pass) 
            VALUES ('$student_id', '$subject_id', '$score_10', '$score_4', '$score_char', '$pass')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $_SESSION['message'] = "Thêm điểm thành công!";
            $_SESSION['message_type'] = "success";
            header("Location: scores.php");
        } else {
            $_SESSION['message'] = "Thêm điểm thất bại!";
            $_SESSION['message_type'] = "error";
            header("Location: scores.php");
        }
    }
}

// Lấy thông tin điểm để sửa
if(isset($_GET['score_id'])) {
    $score_id = $_GET['score_id'];
    $query = "SELECT scores.id, scores.subject_id, scores.score_10, scores.score_4, scores.score_char, subjects.code AS subject_code, subjects.name AS subject_name, subjects.credits
              FROM scores
              JOIN subjects ON scores.subject_id = subjects.id
              WHERE scores.id = '$score_id'";
              
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        echo json_encode(mysqli_fetch_assoc($result));
    } else {
        echo json_encode([]);
    }
}

// Sửa điểm
if(isset($_POST['update_score'])) {
    $score_id = $_POST['score_id'];
    $score_10 = $_POST['score_10'];
    $score_4 = $_POST['score_4'];
    $score_char = $_POST['score_char'];
    $pass = $score_10 >= 4 ? 'True' : 'False';

    $edit = "UPDATE scores SET score_10 = '$score_10', score_4 = '$score_4', score_char = '$score_char', pass = '$pass' WHERE id = '$score_id'";
    $result = mysqli_query($conn, $edit);
    if ($result) {
        $_SESSION['message'] = "Sửa điểm thành công!";
        $_SESSION['message_type'] = "success";
        header("Location: scores.php");
    } else {
        $_SESSION['message'] = "Sửa điểm thất bại!";
        $_SESSION['message_type'] = "error";
        header("Location: scores.php");
    }
}

// Xóa điểm
error_reporting(0);
if($_GET['delete_id']){
    $score_id = $_GET['delete_id'];
    $delete = "DELETE FROM scores WHERE id = '$score_id'";
    $result = mysqli_query($conn, $delete);
    if($result){
        $_SESSION['message'] = "Xóa điểm thành công!";
        $_SESSION['message_type'] = "success";
        header("Location: scores.php");
    }else{
        $_SESSION['message'] = "Xóa điểm thất bại!";
        $_SESSION['message_type'] = "error";
        header("Location: scores.php");
    }
}
?>