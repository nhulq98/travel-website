<?php include('connect/myconnect.php'); ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Review Du Lich</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/superfish.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery1.js"></script>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/wowslider.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script type="text/javascript" src="js/superfish.js"></script>
    <script>
        jQuery(document).ready(function() {
            jQuery('ul.sf-menu').superfish();
        });
    </script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
<style>
    .trangtri{
	color: blue;
	font-weight: bold; 
	border-bottom: 3px solid blue;
}
    </style>

</head>
<?php

$sql = "SELECT id, danhmucbaiviet FROM tbldanhmucbaiviet WHERE id=36";
$query_a = mysqli_query($conn, $sql);
$dm_info = mysqli_fetch_assoc($query_a);

?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" id="header">
                <div id="header">
                    <div id="logo">
                        <p><a href="index.php"><img src="images/logo.png"></a></p>
                    </div>
                    <div id="menu" style="z-index: 999 !important">
                        <?php 
                        include('connect/function.php');
                        menu_dacap();
                        ?>

                        <nav class='navclass'>
                            <div class="clearfix"></div>
                            <div id="search">
                                <form name="frmsearch" method="GET" action="search.php">
                                    <input type="text" name="ten" value="" placeholder="Tìm kiếm từ khóa">
                                    <input type="submit" name="submit" onclick="" value="Tìm kiếm">
                                </form>
                            </div>

                        </nav>
                        

                    </div>

                </div>
            </div>

            <div class="row">


            <?php include('includes/slider.php'); ?> 
            <?php include('includes/left.php'); ?> 