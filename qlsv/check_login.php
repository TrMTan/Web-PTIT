<?php
require "./inc/db.php";
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    if($row['usertype'] == 'admin') {
        $_SESSION['username']= $username;
        $_SESSION['usertype']="admin";
        header("Location: ./admin/adminhome.php");
    } elseif($row['usertype'] == 'student') {
        $_SESSION['username']= $username;
        $_SESSION['usertype']="student";
        header("Location: ./student/studenthome.php");
    } else {
        $message= "Tài khoản hoặc mật khẩu không chính xác";
        $_SESSION['loginMessage']= $message;
        $_SESSION['username']= $username;
        $_SESSION['password']= $password;
        header("Location: index.php");
    }
}
?> 

