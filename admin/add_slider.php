<?php error_reporting(0);?>
<style>
    .required {
        color: red;
    }
</style>

<?php include('includes/header.php'); ?>// get header

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <?php
                include('../connect/images_helper.php');
                include('../connect/myconnect.php'); // mo ket noi
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                $message = '';
                // kiểm tra nút submit đã được nhấn chưa.
                if (isset($_POST['submit'])) {
                    // nếu đã nhấn thì vào đây
                    $errors = array();
                    // kiểm tra ô title có rỗng
                    if (empty($_POST['title'])) {
                        // vào này là rỗng nè
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
                        } elseif ($_FILES['img']['size'] == '') {
                            $message = "bạn chưa chọn file ảnh";
                        } else {
                            $img = $_FILES['img']['name'];

                            $link_img = 'upload/' . $img;
                            // chuyển ảnh vào thư mục upload
                            move_uploaded_file($_FILES['img']['tmp_name'], "../upload/" . $img);
                            
                            // xử lý Resize, Crop hinh anh
                            $temp = explode('.', $img); // cắt ra tên file và đuôi file vào trong temp
                            if($temp[1] == 'ipeg' or $temp[1] == 'JPEG')// temp[1] tức là đuôi file.temp[1] là tên file
                            {
                                $temp[1] == 'ipg';
                            }
                            $temp[1] = strtolower($temp[1]);
                            $thumb = 'upload/resized/' . $temp[0].'_thumb'.'.'.$temp[1];
                            $imageThumb = new Image('../'. $link_img);
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
                            $imageThumb->resize(1280, 467,'crop');
                            $imageThumb->save($temp[0].'_thumd','../upload/resized');
                        }
                        $query = "INSERT INTO tblslider (title, img,img_thumb, link, ordernum, status)
                         VALUES ('{$title}','{$link_img}','{$Thumb}', '{$link}', $ordernum, $status)";
                        // chạy câu lệnh truy vấn
                        $result = $conn->query($query);
                        if ($result == true) {
                            echo "<h4 style='color: blue'>Thêm thành công</h4>";
                        } else {
                            echo "Error " . $query . " Loi: " . $conn->error;
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

                    <h3>Thêm mới Slider</h3>
                    <?php if (isset($message)) {
                        echo $message;
                    } ?>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" placeholder="title" value="<?php if (isset($_POST['title'])) {
                                                                                                            echo $_POST['title'];
                                                                                                        } ?>">
                        <?php 
                        if (isset($errors) && in_array('title', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập tiêu đề</p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Hình ảnh</label>
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
                        <input type="text" name="link" class="form-control" placeholder="link slider" value="<?php if (isset($_POST['link'])) {
                                                                                                                    echo $_POST['link'];
                                                                                                                } ?>">
                        <?php 
                        if (isset($errors) && in_array('link', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập link</p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Thứ Tự</label>
                        <input type="number" name="ordernum" class="form-control" placeholder="default 0" value="<?php if (isset($_POST['ordernum'])) {
                                                                                                                    echo $_POST['ordernum'];
                                                                                                                } ?>">
                        <?php 
                        if (isset($errors) && in_array('ordernum', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập so thu tu</p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label style="display: block;">Trạng Thái</label>
                        <label class="radio-inline"><input checked="checked" type="radio" name="status" value="1">Hiển Thị</label>
                        <label class="radio-inline"><input type="radio" name="status" value="0">Không hiển thị</label>

                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Thêm mới">
                </form>


            </div>
        </div>

        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<?php include('includes/footer.php'); ?> 