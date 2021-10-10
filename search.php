<?php include('includes/header.php'); ?>



<div class="row" style="display:inline">

    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9" id="center">
        <div class="box_center">
            <div class="box_center_top">

                <div class="box_center_top_l">
                    <a href="" title="">Tìm kiếm</a>
                </div>
                <div class="box_center_top_r"></div>
                <div class="clearfix"></div>
            </div>
            <div class="box_center_main">
                <?php
                if (isset($_REQUEST['submit'])) {
                    $search = $_GET['ten'];
                    if (empty($search)) {
                        echo "<p>Yêu cầu nhập dữ liệu vào ô trống</p>";
                    } else {
                        $query = "SELECT * FROM tblbaiviet WHERE title like '%$search%'";
                        $results = mysqli_query($conn, $query);
                        if ($results) {
                            kt_query($results, $query);
                            while ($baivietbv = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
                                ?>
                                <div class="row">
                                    <div class="tintuc_item">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                            <a href="baivietchitiet.php?id=<?php echo $baivietbv['id']; ?>" class="tintuc_item_img"><img src="<?php echo $baivietbv["img"]; ?>"></a>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                            <a href="baivietchitiet.php?id=<?php echo $baivietbv['id']; ?>" class="tintuc_item_title"><?php echo $baivietbv["title"]; ?></a>
                                            <p><?php echo $baivietbv["tomtat"]; ?></p>
                                            <a href="baivietchitiet.php?id=<?php echo $baivietbv['id']; ?>">Xem chi tiết</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            <?php
                        }
                    } else {
                        echo "<p>Không tìm thấy</p>";
                    }
                }
            }
            ?>


            </div>


        </div>
    </div>
</div>
</div>
<?php include('includes/footer.php'); ?>