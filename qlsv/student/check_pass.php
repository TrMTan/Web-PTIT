<?php
session_start();
require "../inc/config.php";
require "../inc/db.php";

if (isset($_POST['submit'])) {
    $username = $_SESSION['username']; // Lấy tên người dùng từ phiên
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Lấy thông tin người dùng từ cơ sở dữ liệu
    $sql = "SELECT password FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    // Kiểm tra mật khẩu cũ
    if ($user && $user['password'] === $old_password) {
        // Kiểm tra mật khẩu mới và xác nhận
        if ($new_password === $confirm_password) {
            // Cập nhật mật khẩu mới vào cơ sở dữ liệu
            $update_sql = "UPDATE users SET password = '$new_password' WHERE username = '$username'";
            if (mysqli_query($conn, $update_sql)) {
                $_SESSION['message'] = "Mật khẩu đã được thay đổi thành công.";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Có lỗi trong quá trình cập nhật mật khẩu.";
                $_SESSION['message_type'] = "error";
            }
        } else {
            $_SESSION['message'] = "Mật khẩu mới và xác nhận không khớp.";
            $_SESSION['message_type'] = "error";
        }
    } else {
        $_SESSION['message'] = "Mật khẩu cũ không chính xác.";
        $_SESSION['message_type'] = "error";
    }
    header("Location: studenthome.php");
}
?>
