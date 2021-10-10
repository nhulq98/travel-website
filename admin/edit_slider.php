<?php error_reporting(0); ?>
<!--khởi tạo bộ nhớ đệm-->
<?php ob_start(); ?>
<style>
    .required {
        color: red;
    }
</style>

<?php include('includes/header.php'); ?>
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <?php
                include('../connect/images_helper.php'); // dùng để resize và drop img
                include('../connect/myconnect.php'); // mo ket noi
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                $message = '';
                // muốn sửa thì ta lấy ra ID của slider cần sửa

                // kiểm tra id có phải là kiểu số và có tồn tại hay không
                if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
                    $id = $_GET['id'];
                } else {
                    // chuyển hướng đến trang list_video
                    header('Location: list_slider.php');
                    /*Lưu ý: hàm header nếu ở trong file tồn tại cả tiếng việt và cả mã html thì sẽ bị lôi
                        - cách xử lý
                        Lưu tạm trong bộ nhớ đệm
                        */
                    // thoát ra để chạy tiếp các câu lệnh phía dưới
                    exit();
                }
                // lấy ra dữ liệu
                $sql_id = "SELECT title, img, img_thumb, link, ordernum, status FROM tblslider WHERE id={$id}";
                $result_id = mysqli_query($conn, $sql_id);
                // kiểm tra xem id  có tồn tại hay ko
                if (mysqli_num_rows($result_id) == 1) {
                    // đổ dữ liệu vào các biến dưới
                    list($Tieude, $Hinhanh, $Anh_Thumb, $Lienket, $Sothutu, $Trangthai) = mysqli_fetch_array($result_id, MYSQLI_NUM);
                } else {
                    echo "<p class='required'>ID video không tồn tại</p>";
                }

                // kiểm tra nút submit đã được nhấn chưa.
                if (isset($_POST['submit'])) {
                    // nếu đã nhấn thì vào đây
                    // tạo mảng chứa các ký tự 
                    $errors = array();
                    // kiểm tra ô title có rỗng
                    if (empty($_POST['title'])) {
                        // vào này là rỗng nè
                        // lỗi thì lưu vào đây
                        $errors[] = "title";
                    } else {
                        // ko rỗng thì vào này lấy dữ liệu ra
                        $title = $_POST['title'];
                    }
                    if (empty($_POST['img'])) {
                        // vào này là rỗng nè
                        $img[] = "img";
                    } else {
                        // ko rỗng thì vào này lấy dữ liệu ra
                        $img = $_POST['img'];
                    }
                    // được để trống
                    $link = $_POST['link'];
                    // kiểm tra ô ordernum có rỗng
                    if (empty($_POST['ordernum'])) {
                        // vào này là rỗng nè
                        $ordernum = 0;
                    } else {
                        // ko rỗng thì vào này lấy dữ liệu ra
                        $ordernum = $_POST['ordernum'];
                    }

                    // kiểm tra ô status có rỗng
                    if (empty($_POST['status'])) {
                        $status = 0;
                    } else {
                        $status = $_POST['status'];
                    }
                    // kiểm tra mảng error có RỖNG?
                    if (empty($errors)) {
                        // rỗng rồi thì ...
                        // ktra nếu ảnh mới là null
                        if ($_FILES['img']['size'] == '') {
                            $link_img = $_POST['img_hi'];
                            $thumb = $_POST['imgthumb_hi'];
                        }
                        // nhập ảnh mới thì vào trong else
                        else {


                            // upload ảnh
                            // kiểm tra nếu ảnh khác hết all các định dạng dưới này ko
                            if (
                                ($_FILES['img']['type'] != "image/gif")
                                && ($_FILES['img']['type'] != "image/png")
                                && ($_FILES['img']['type'] != "image/jpeg")
                                && ($_FILES['img']['type'] != "image/jpg")
                            ) {
                                $message = "File không đúng định dạng";
                            } elseif ($_FILES['img']['size'] > 1000000) {
                                $message = "Kích thước phải nhỏ hơn 1MB";
                            } else {
                                $img = $_FILES['img']['name'];

                                $link_img = 'upload/' . $img;
                                // chuyển ảnh vào thư mục upload
                                move_uploaded_file($_FILES['img']['tmp_name'], "../upload/" . $img);

                                // xử lý Resize, Crop hinh anh
                                $temp = explode('.', $img); // cắt ra tên file và đuôi file vào trong temp
                                if ($temp[1] == 'ipeg' or $temp[1] == 'JPEG') // temp[1] tức là đuôi file.temp[1] là tên file
                                    {
                                        $temp[1] == 'ipg';
                                    }
                                    // chuyển thành chữ thường
                                $temp[1] = strtolower($temp[1]);
                                $thumb = 'upload/resized/' . $temp[0] . '_thumb' . '.' . $temp[1];
                                $imageThumb = new Image('../' . $link_img);
                                // Resize img
                                // nếu hình có width lớn hơn 700 
                                /*
                            if($imageThumb->getWidth()> 700)
                            {
                                // thì resize lại thành 700
                                $imageThumb->resize(700, 'resize');
                            }
                            */
                                // crop ảnh. Khi nào chúng ta muốn cố đinh chiều cao và chiều rộng
                                $imageThumb->resize(1280, 467, 'crop');
                                $imageThumb->save($temp[0] . '_thumd', '../upload/resized');
                            }
                            // xóa ảnh trong thư mục
                            $sql = "SELECT img, img_thumb FROM quanlyslider WHERE id={$id}";
                            $query_a = mysqli_query($dbc, $sql);
                            $anhInfo = mysqli_fetch_assoc($query_a);
                            unlink('../' . $anhInfo['img']);
                            unlink('../' . $anhInfo['img_thumb']);
                        }

                        $query = "UPDATE tblslider 
                        SET title='{$title}',
                        link='{$link}',
                         img ='{$link_img}',
                          img_thumb='{$thumb}',
                           ordernum={$ordernum},
                            status={$status} 
                        WHERE id={$id}
                        ";
                        $result = mysqli_query($conn, $query);
                        if (mysqli_affected_rows($conn) == 1) {
                            echo "<h4 style='color: blue'>Sửa thành công</h4>";
                        } else {
                            echo "sửa không thành công Error " . $query . " Loi: " . $conn->error;
                        }
                        // set về cho all các ô là rỗng mỗi khi thêm xong
                        $_POST['title'] = "";
                        $_POST['link'] = "";
                        $_POST['ordernum'] = "";
                    } else if (!empty($errors)) {
                        echo "<p class='required' >Bạn hãy nhập đầy đủ thông tin</p>";
                    }

                   
                }
                ?>
                <!-- phải thêm thuộc tính này vào form mới up load dc-->
                <form name="frmadd_slider" method="POST" enctype="multipart/form-data">

                    <h3>Sửa user: <?php if (isset($Tieude)) {
                                        echo "<p style='color:blue'>" . $Tieude . "</p>";
                                    } ?></h3>
                    <?php if (isset($message)) {
                        echo $message;
                    } ?>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" placeholder="title" value="<?php if (isset($Tieude)) {
                                                                                                            echo $Tieude;
                                                                                                        } ?>">
                        <?php 
                        if (isset($errors) && in_array('title', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập tiêu đề</p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Ảnh đại diện</label>
                        <p><img width="100" src="../<?php echo $Hinhanh ?>" /></p>
                        <input type="hidden" name="img_hi" value="<?php echo $Hinhanh; ?>">
                        <input type="hidden" name="imgthumb_hi" value="<?php echo $Hinh_thumb; ?>">
                        <input type="file" name="img" value="Thêm ảnh">
                        <?php 
                        // kiểm tra cái mảng errors có chứa ký tự img hay ko
                        if (isset($errors) && in_array('img', $errors)) {
                            // có thì xuất ra dòng thông báo này
                            echo "<p class='required'>Bạn chưa nhập hình ảnh</p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Link</label>
                        <input type="text" name="link" class="form-control" placeholder="link slider" value="<?php if (isset($Lienket)) {
                                                                                                                    echo $Lienket;
                                                                                                                } ?>">

                    </div>
                    <div class="form-group">
                        <label>Thứ Tự</label>
                        <input type="number" name="ordernum" class="form-control" placeholder="default 0" value="<?php if (isset($Sothutu)) {
                                                                                                                        echo $Sothutu;
                                                                                                                    } ?>">
                        <?php 
                        if (isset($errors) && in_array('ordernum', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập so thu tu</p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label style="display: block;">Trạng Thái</label>
                        <?php if (isset($Trangthai) == 1) {
                            ?>
                        <label class="radio-inline"><input checked="checked" type="radio" name="status" value="1">Hiển Thị</label>
                        <label class="radio-inline"><input type="radio" name="status" value="0">Không hiển thị</label>
                        <?php

                    } else {
                        ?>
                        <label class="radio-inline"><input type="radio" name="status" value="1">Hiển Thị</label>
                        <label class="radio-inline"><input checked="checked" type="radio" name="status" value="0">Không hiển thị</label>

                        <?php

                    }
                    ?>


                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Sửa">
                </form>


            </div>
        </div>

        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<?php include('includes/footer.php'); ?>
<?php ob_flush()(); ?> 