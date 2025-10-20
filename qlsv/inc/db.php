<?php
error_reporting(0);
session_start();

$host = "localhost";
$username = "root";
$password = "";
$db = "qlsv";

$conn = mysqli_connect($host, $username, $password, $db);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql1 = "SELECT COUNT(*) AS student FROM users WHERE usertype = 'student'";
$sql2 = "SELECT COUNT(*) AS subject FROM subjects";
$sql3 = "SELECT COUNT(*) AS company FROM companies";

$result1 = mysqli_query($conn, $sql1);
$result2 = mysqli_query($conn, $sql2);
$result3 = mysqli_query($conn, $sql3);

$student_count = mysqli_fetch_assoc($result1)['student'];
$subject_count = mysqli_fetch_assoc($result2)['subject'];
$company_count = mysqli_fetch_assoc($result3)['company'];