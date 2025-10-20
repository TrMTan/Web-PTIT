<?php
require "../inc/config.php";
require "../inc/db.php";
require "../admin/inc/PhpXlsxGenerator.php";

$filename = "export_student_data.xlsx";

$excelData[] = array('Mã Sinh Viên', 'Họ và Tên', 'Ngày Sinh', 'Giới Tính', 'Địa Chỉ', 'Số Điện Thoại', 'Email', 'Lớp', 'Khoa');

$sql = "SELECT * FROM users WHERE usertype = 'student'";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $line = array($row['username'], $row['fullname'], $row['dob'], $row['gender'], $row['address'], $row['phone'], $row['email'], $row['class'], $row['major']);
    $excelData[] = $line;
}

$xlsx = CodexWorld\PhpXlsxGenerator::fromArray($excelData);
$xlsx->downloadAs($filename);
exit();
?>
