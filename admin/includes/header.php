<?php
error_reporting(0);
session_start();
include('config/config.php');
include('../connect/myconnect.php');
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
}
// kiểm tra quyền truy cập
else {
    $sqlcheckrole = "SELECT * FROM tbluser WHERE id={$_SESSION['id']}";
    $checkrole = mysqli_query($conn, $sqlcheckrole);
    $checkrole_row = mysqli_fetch_assoc($checkrole);
    $current_url = $_SERVER['SERVERNAME'] . $_SERVER['REQUEST_URI'];
    $current_tach = explode('/', $current_url);
    $tm = count($current_tach);
    $dem_mt = 1;
    // foreach ($current_tach as $current_tach2) {
    //     if ($dem_mt == $tm) {
    //         if (isset($_GET['id']) || isset($_GET['s'])) {
    //             $current_tach2_id = explode('?', $current_tach2);
    //         }
    //         $mangthaythe = array();
    //         $tachcheckrole = explode(',', $checkrole_row['role']);
    //         $demthay = 1;
    //         foreach ($tachcheckrole as $tachcheckrole_it) {
    //             if ($demthay > 1) {
    //                 $tachcheckrole2 = explode('-', $tachcheckrole_it);
    //                 $mangthaythe[] = array(
    //                     'link1' => $tachcheckrole2[1],
    //                     'link2' => $tachcheckrole2[2],
    //                     'link3' => $tachcheckrole2[3],
    //                     'link4' => $tachcheckrole2[4],
    //                 );
    //                 $okc = 0;
    //                 foreach ($mangthaythe as $itemthay) {
    //                     if (isset($_GET['id'])) {
    //                         if ($current_tach2_id[0] == $itemthay['link3'] || $current_tach2_id[0] == $itemthay['link4']) {
    //                             $okc = 1;
    //                             break;
    //                         }
    //                     } elseif (isset($_GET['s'])) {
    //                         if ($current_tach2_id[0] == $itemthay['link2']) {
    //                             $okc = 1;
    //                             break;
    //                         }
    //                     } else {
    //                         if ($current_tach2 == $itemthay['link1'] || $current_tach2 == $itemthay['link2']) {
    //                             $okc = 1;
    //                             break;
    //                         }
    //                     }
    //                 }
    //             }
    //             $demthay++;
    //         }
    //     }
    //     $dem_mt++;
    // }
    // if ($okc <> 1) {
    //     $dem_mtch = 1;
    //     foreach ($current_tach as $current_tach_ch2) {
    //         if ($dem_mtch == $tm) {
    //             if ($current_tach_ch2 != "index.php") {
    //                 header('Location: index.php');
    //             }
    //         }
    //         $dem_mtch++;
    //     }
    // }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Quản trị hệ thống</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom CSS -->
    <link href="../css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>


    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">QUẢN TRỊ HỆ THỐNG</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Xin chào: &nbsp;<?php if (isset($_SESSION['username'])) {
                                                                                                                                echo $_SESSION['username'];
                                                                                                                            } ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="edit_user.php?id=<?php echo $_SESSION['id']; ?>"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="doimatkhau.php"><i class="fa fa-fw fa-gear"></i>Đổi mật khẩu</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="exit.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <?php include('sidebar.php') ?>
            <!-- /.navbar-collapse -->
        </nav>