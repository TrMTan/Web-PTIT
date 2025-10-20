<?php
    require "../inc/db.php";
    $field = $_POST['field'];
    $value = $_POST['value'];

    $field = $_POST['field'];
    $value = $_POST['value'];

    $sql = "SELECT COUNT(*) AS count FROM subjects WHERE `$field` = '$value'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row['count'] > 0) {
            echo 'duplicate';
        } else {
            echo 'unique';
        }
    } else {
        echo 'error';
    }
?>