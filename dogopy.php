<?php
include('connect/function.php');
include('connect/myconnect.php');
    $idbv = $_POST['idbv'];
    $hoten = $_POST['hoten'];
    $dienthoai = $_POST['dienthoai'];
    $diachi = $_POST['diachi'];
    $email = $_POST['email'];
    $noidung = $_POST['noidung'];
    // insert vào trong database
    $query="INSERT INTO tblgopy(title, hoten, diachi, dienthoai, email, noidung, status)
            VALUES ('{$idbv}', '{$hoten}', '{$diachi}', '{$dienthoai}','{$email}', '{$noidung}',0)";
            // bởi vì lúc đầu ngta gửi ý kiến trang thái chưa được xem nên status = 0
    $result = mysqli_query($conn, $query);
    kt_query($result, $query);
?>