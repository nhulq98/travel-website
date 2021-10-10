<?php
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
    $id = $_GET['id'];
    //include('connect/function.php');
    include('includes/header.php');
    $sql = "SELECT * FROM tblbaiviet WHERE id={$id}";
    $query_a = mysqli_query($conn, $sql);
    $dm_info = mysqli_fetch_assoc($query_a);
    $sql2 = "SELECT * FROM tbldanhmucbaiviet WHERE id={$dm_info['danhmucbaiviet']}";
    $query_a2 = mysqli_query($conn, $sql2);
    $dm_info2 = mysqli_fetch_assoc($query_a2);
    $view_add = $dm_info['view'] + 1;
    $query = "UPDATE tblbaiviet SET view={$view_add} WHERE id=$id";
    $results = mysqli_query($conn, $query);
    $sql3 = "SELECT * FROM tblbaiviet WHERE id=$id";
    $query_a3 = mysqli_query($conn, $sql3);
    $dm_info3 = mysqli_fetch_assoc($query_a3);
    ?>
    <div class="row" style="display:inline">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" id="left">
        </div>
        <div class="col-lg-9 col-md-3 col-sm-9 col-xs-9" id="left">
            <div class="box_center">
                <div class="box-center_top">
                    <div class="box_center_top_l">
                        <a href="tinbycategory.php?dm=<?php echo $dm_info2['id']; ?>" title="<?php echo $dm_info2['danhmucbaiviet']; ?>"><?php echo $dm_info2['danhmucbaiviet']; ?></a>
                    </div>
                    <div class="box_center_top_r"></div>
                    <div class="clearfix"></div>
                </div>
                <div class="box_center_main">
                    <ul class="breadcrumb">
                        <li><a href="<?php echo BASE_URL; ?>" title="<?php echo $dm_info2['danhmucbaiviet']; ?>"><i class="fa fa-home"></i></a></li>
                        <li><a href="tinbycategory.php?dm=<?php echo $dm_info2['id']; ?>" title="<?php echo $dm_info2['danhmucbaiviet']; ?>" title="<?php echo $dm_info2['danhmucbaiviet']; ?>"><?php echo $dm_info2['danhmucbaiviet']; ?></a></li>
                        <li class="active"><?php echo $dm_info['title']; ?></li>
                    </ul>
                    <div class="baiviet_ct">
                        <h1><?php echo $dm_info["title"]; ?></h1>
                        <div id="time">
                            <?php
                            $ng_dang = explode('-', $dm_info['ngaydang']);
                            $ngay_dang_ct = $ng_dang[2] . '-' . $ng_dang[1] . '-' . $ng_dang[0];
                            ?>
                            <span style="color: blue;">Ngày đăng:</span> &nbsp;<?php echo $ngay_dang_ct; ?> | <?php echo $dm_info['giodang']; ?> | <?php echo $dm_info3['view']; ?> <span style="color: blue;">Lượt xem</span>

                        </div>

                        <div class="p"><?php echo "<h3>" . $dm_info['tomtat'] . "</h3>"; ?></div>
                        <div class="p"><img width="800px" height="400px" src="<?php echo $dm_info['img']; ?>"></div>
                        <div class="p"><?php echo $dm_info['noidung']; ?></div>

                        <p class="trangtri">Gửi ý kiến</p>
                        <br>
                        <div id="show2"><label>Cảm ơn bạn đã góp ý</label></div>
                        <div id="show1">
                            <table>
                                <!--dùng để lưu id bài viết hiện tại-->
                                <input type="hidden" name="idbv" id="idbv" value="<?php echo $dm_info['id']; ?>">
                                <tr>
                                    <td>Họ tên</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="hoten" id="hoten" value=""></td>
                                </tr>
                                <tr>
                                    <td>Điện thoại</td>
                                </tr>
                                <tr>
                                    <td><input type="number" name="dienthoai" id="dienthoai" value=""></td>
                                </tr>
                                <tr>
                                    <td>Địa chỉ</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="diachi" id="diachi" value=""></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="email" id="email" value=""></td>
                                </tr>
                                <tr>
                                    <td>Nội dung</td>
                                </tr>
                                <tr>
                                    <td><textarea name="noidung" id="noidung"></textarea></td>
                                </tr>
                                <tr>
                                    <td><input id="button" type="button" name="button" value="Gửi ý kiến"></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                        <br>
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $("#show2").hide();
                                $("#button").click(function() {
                                    var idbv = $("#idbv").val();
                                    var hoten = $("#hoten").val();
                                    var dienthoai = $("#dienthoai").val();
                                    var diachi = $("#diachi").val();
                                    var email = $("#email").val();
                                    var noidung = $("#noidung").val();
                                    if (hoten == '') {
                                        alert("Bạn chưa nhập họ tên");
                                        $("#hoten").focus();
                                        return false;
                                    } else if (dienthoai == "") {
                                        alert("Bạn chưa nhập điện thoại");
                                        $("#dienthoai").focus();
                                        return false;
                                    } else if (diachi == "") {
                                        alert("Bạn chưa nhập địa chỉ");
                                        $("#diachi").focus();
                                        return false;
                                    } else if (email == "") {
                                        alert("Bạn chưa nhập email");
                                        $("#email").focus();
                                        return false;
                                    } else if (noidung == "") {
                                        alert("Bạn chưa nhập nội dung");
                                        $("#noidung").focus();
                                        return false;
                                    } else {
                                        $.ajax({
                                            type: "POST",
                                            url: "dogopy.php",
                                            data: {
                                                idbv: idbv,
                                                hoten: hoten,
                                                dienthoai: dienthoai,
                                                diachi: diachi,
                                                email: email,
                                                noidung: noidung
                                            },
                                            cache: false,
                                            success: function(html) {
                                                $("#show1").hide();
                                                $("#show2").show();

                                            }
                                        });
                                    }
                                    return false;
                                });
                            });
                        </script>


                        <p class="trangtri">Tin liên quan</p>

                        <ul>
                            <?php
                            $query_lq = "SELECT * FROM tblbaiviet WHERE id!={$dm_info['id']} AND danhmucbaiviet={$dm_info['danhmucbaiviet']} ORDER BY ordernum DESC LIMIT 0,8";
                            $results_lq = mysqli_query($conn, $query_lq);
                            while ($tinlq = mysqli_fetch_array($results_lq, MYSQLI_ASSOC)) {
                                ?>
                                <li style="border-bottom: 1px solid LightGray;">
                                    <a href="baivietchitiet.php?id=<?php echo $tinlq['id']; ?>" title="<?php echo $tinlq['title']; ?>" target="_blank"><?php echo $tinlq['title']; ?></a>
                                </li>
                            <?php
                        }
                        ?>
                        </ul>
                    </div>

                </div>

            </div>

        </div>

    </div>
<?php
} else {
    header('Location: index.php');
    exit();
}

include('includes/footer.php');
?>