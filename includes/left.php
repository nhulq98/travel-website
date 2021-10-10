<?php include('connect/myconnect.php'); ?>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" id="left">
    <div class="box">
        <div class="box_top">
            <p>Hỗ trợ trực tuyến</p>
        </div>
        <div class="box_main">
            <div id="support">
                <p><a href="https://www.facebook.com/lequang.nhu.98"><img src="images/facebook.png"></a><a href=""><img src="images/skype.png"></a>
                </p>
                <p>Hotline:&nbsp;<span>0335206644-0369733352</span></p>
                <p>Email:&nbsp;nhule2031998@gmail.com</p>
            </div>
        </div>
    </div>

    <div class="box">
        <div class="box_top">
            <p>Video</p>
        </div>
        <div class="box_main">
            <div id="video">
                <div id="content_video">
                    <?php
                    $query_video_one = "SELECT * FROM tblvideo ORDER BY ordernum DESC LIMIT 1";
                    $results_video_one = mysqli_query($conn, $query_video_one);
                    $query_video_two = mysqli_fetch_assoc($results_video_one);
                    $str_one = explode('=', $query_video_two['link']);
                    ?>
                    <iframe width="100%" height="162px" class="embed-player" src="https://www.youtube.com/embed/<?php echo $str_one[1]; ?>" frameborder="0" allowfullscreen></iframe>
                    <br />
                    <ul class="list-video">
                        <?php
                                                                                                                $query_video = "SELECT * FROM tblvideo ORDER BY ordernum DESC";
                                                                                                                $result_video = mysqli_query($conn, $query_video);

                                                                                                                while ($video = mysqli_fetch_array($result_video, MYSQLI_ASSOC)) {
                                                                                                                    $str = explode('=', $video['link']);

                                                                                                                    ?>
                                                                                                                    <li><a style="cursor:pointer;" title="<?php echo $str[1]; ?>"><i class="fa fa-caret-right fw"></i>&nbsp;<?php echo $video['title']; ?></a></li>
                                                                                                                                                                                                                                            <?php
                                                                                                                            }
                                                                                                                            ?>
                        <script>
                            $(document).ready(function() {
                                $('.list-video li').click(function() {
                                    $(this).parent().siblings('.embed-player').attr('src', 'http://www.youtube.com/embed/' + $(this).children('a').attr('title'));
                                });
                            });
                        </script>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box_top">
            <p>Bài viết mới nhất</p>
        </div>
        <div class="box_main">
            <ul id="baiviet_l">
                <?php

                                                                                                                            $sql_id = "SELECT * FROM tblbaiviet ORDER BY id DESC LIMIT 0,5";
                                                                                                                            // chạy truy vấn và đặt dữ liệu vào biến result
                                                                                                                            $result_id = $conn->query($sql_id);
                                                                                                                            //kiểm tra nếu có nhiều hơn 0 hàng trả về

                                                                                                                            //echo "<h4 style='color: blue'>xem thanh cong</h4>";
                                                                                                                            //hàm fetch_assoc () đặt tất cả các kết quả vào một mảng kết hợp mà chúng ta có thể lặp qua
                                                                                                                            while ($baiviet = mysqli_fetch_array($result_id, MYSQLI_ASSOC)) {
                                                                                                                                // hàm chức năng tương tự $row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                                                                                                                                ?>
                                                                                                                                <li><a href="baivietchitiet.php?id=<?php echo $baiviet['id']; ?>" target="_blank"><?php echo $baiviet['title'];?></a></li>
                                                                                                                                                                                                                                            <?php
                                                                                                                            } ?>
            </ul>
        </div>
    </div>
</div>