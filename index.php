<?php include('includes/header.php') ?>

<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9" id="center">
    <div class="box_center">
        <div class="box_center_top">
            <div class="box_center_top_l">
                <a href="tinbycategory.php?dm=36" id="1">Trong nước</a>
            </div>
            <div class="box_center_top_r"></div>
            <div class="clearfix"></div>
        </div>
        <div class="box_center_main">
            <div class="row">
                <?php

                $sql = "SELECT * FROM tblbaiviet WHERE danhmucbaiviet = 36 ORDER BY id DESC LIMIT 0,3";
                // chạy truy vấn và đặt dữ liệu vào biến result
                $result = $conn->query($sql);
                //kiểm tra nếu có nhiều hơn 0 hàng trả về

                //echo "<h4 style='color: blue'>xem thanh cong</h4>";
                //hàm fetch_assoc () đặt tất cả các kết quả vào một mảng kết hợp mà chúng ta có thể lặp qua
                while ($baiviet = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    // hàm chức năng tương tự $row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                    ?>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 tinhome_item">
                        <a href="baivietchitiet.php?id=<?php echo $baiviet['id']; ?>" class="tinhome_item_img"><img src="<?php echo $baiviet['img']; ?>"></a>

                        <a href="baivietchitiet.php?id=<?php echo $baiviet['id']; ?>" class="tinhome_item_name"><?php echo $baiviet['title']; ?></a>
                    </div>
                <?php
            }

            ?>
            </div>
        </div>
    </div>
    <div class="box_center">
        <div class="box_center_top">
            <div class="box_center_top_l">
                <a href="tinbycategory.php?dm=37" id="2">Ngoài nước</a>
            </div>
            <div class="box_center_top_r"></div>
            <div class="clearfix"></div>
        </div>

        <div class="box_center_main">
            <div class="row">
                <?php

                $sql = "SELECT * FROM tblbaiviet WHERE danhmucbaiviet = 37 ORDER BY id DESC LIMIT 0,3";
                // chạy truy vấn và đặt dữ liệu vào biến result
                $result = $conn->query($sql);
                //kiểm tra nếu có nhiều hơn 0 hàng trả về

                //echo "<h4 style='color: blue'>xem thanh cong</h4>";
                //hàm fetch_assoc () đặt tất cả các kết quả vào một mảng kết hợp mà chúng ta có thể lặp qua
                while ($baiviet = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    // hàm chức năng tương tự $row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                    ?>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 tinhome_item">
                        <a href="baivietchitiet.php?id=<?php echo $baiviet['id']; ?>" class="tinhome_item_img"><img src="<?php echo $baiviet['img']; ?>"></a>
                        <!--<a href="" class="tintuc_item_img"><img width="250px" height="200px" src="<?php echo $baiviet['img']; ?>">-->
                        <a href="baivietchitiet.php?id=<?php echo $baiviet['id']; ?>" class="tinhome_item_name"><?php echo $baiviet['title']; ?></a>
                    </div>
                <?php
            }

            ?>

            </div>
        </div>

    </div>
    <div class="box_center">
        <div class="box_center_top">
            <div class="box_center_top_l">
                <a href="">Top Những địa điểm hàng đầu</a>
            </div>
            <div class="box_center_top_r"></div>
            <div class="clearfix"></div>
        </div>
        <div class="box_center_main">
            <div class="row">
                <?php

                $sql_view = "SELECT * FROM tblbaiviet ORDER BY view DESC LIMIT 0,3";
                // chạy truy vấn và đặt dữ liệu vào biến result
                $result_view = $conn->query($sql_view);
                //kiểm tra nếu có nhiều hơn 0 hàng trả về

                //echo "<h4 style='color: blue'>xem thanh cong</h4>";
                //hàm fetch_assoc () đặt tất cả các kết quả vào một mảng kết hợp mà chúng ta có thể lặp qua
                while ($baiviet = mysqli_fetch_array($result_view, MYSQLI_ASSOC)) {
                    // hàm chức năng tương tự $row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                    ?>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 tinhome_item">
                        <a href="baivietchitiet.php?id=<?php echo $baiviet['id']; ?>" class="tinhome_item_img"><img src="<?php echo $baiviet['img']; ?>"></a>
                        <a href="baivietchitiet.php?id=<?php echo $baiviet['id']; ?>" class="tinhome_item_name"><?php echo $baiviet['title']; ?></a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>

<?php include('includes/footer.php') ?>