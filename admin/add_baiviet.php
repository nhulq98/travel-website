<?php include('includes/header.php'); ?>
<style type="text/css">
    .required {
        color: red;
    }
</style>
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php 
                include('../connect/images_helper.php');
                include('../connect/function.php');
                include('../connect/myconnect.php');
                if (isset($_POST['submit'])) {
                    $errors = array();
                    if ($_POST['parent'] == 0) {
                        $parent_id = 0;
                    } else {
                        $parent_id = $_POST['parent'];
                    }
                    if (empty($_POST['title'])) {
                        $errors[] = 'title';
                    } else {
                        $title = $_POST['title'];
                    }
                    $tomtat = $_POST['tomtat'];
                    $noidung = $_POST['noidung'];
                    if (empty($_POST['ordernum'])) {
                        $ordernum = 0;
                    } else {
                        $ordernum = $_POST['ordernum'];
                    }
                    $status = $_POST['status'];
                    if (empty($errors)) {
                        //upload hình ảnh
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
                            $message = "Bạn chưa chọn file ảnh";
                        } else {
                            $img = $_FILES['img']['name'];
                            $link_img = 'upload/' . $img;
                            move_uploaded_file($_FILES['img']['tmp_name'], "../upload/" . $img);
                            //Xử lý Resize, Crop hình anh
                            $temp = explode('.', $img);
                            if ($temp[1] == 'jpeg' or $temp[1] == 'JPEG') {
                                $temp[1] = 'jpg';
                            }
                            $temp[1] = strtolower($temp[1]);
                            $thumb = 'upload/resized/' . $temp[0] . '_thumb' . '.' . $temp[1];
                            $imageThumb = new Image('../' . $link_img);
                            // //Resize anh						
                            // if ($imageThumb->getWidth() > 700) {
                            //     $imageThumb->resize(700, 'resize');
                            // }
                            $imageThumb->resize(1280, 467,'crop');
                            $imageThumb->save($temp[0] . '_thumb', '../upload/resized');
                        }
                        $ngaydang_ht = explode("-", $_POST['ngaydang']);
                        $ngaydang_in = $ngaydang_ht[2] . '-' . $ngaydang_ht[1] . '-' . $ngaydang_ht[0];
                        $giodang_in = $_POST['giodang'];
                        //inser vao trong db
                        $query = "INSERT INTO tblbaiviet(danhmucbaiviet,title,tomtat,noidung,img,img_thumb,ngaydang,giodang,ordernum,status)
							VALUES($parent_id,'{$title}','{$tomtat}','{$noidung}','{$link_img}','{$thumb}','{$ngaydang_in}','{$giodang_in}',$ordernum,$status)";
                        $results = mysqli_query($conn, $query);
                        kt_query($results, $query);
                        if (mysqli_affected_rows($conn) == 1) {
                            echo "<p style='color:green;'>Thêm mới thành công</p>";
                        } else {
                            echo "<p style='required'>Thêm mới không thành công</p>";
                        }
                        $_POST['title'] = '';
                    } else {
                        $message = "<p class='required'>Bạn hãy nhập đầy đủ thông tin</p>";
                    }
                }
                ?>
                <form name="frmbaiviet" method="POST" enctype="multipart/form-data">
                    <?php 
                    if (isset($message)) {
                        echo $message;
                    }
                    ?>
                    <h3>Thêm mới bài viết</h3>
                    <div class="form-group">
                        <label style="display:block;">Danh mục bài viết</label>
                        <?php selectCtrl('parent', 'forFormdim'); ?>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="<?php if (isset($_POST['title'])) {
                                                                    echo $_POST['title'];
                                                                } ?>" class="form-control" placeholder="Title">
                        <?php 
                        if (isset($errors) && in_array('title', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập tiêu đề</p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label style="display:block;">Tóm tắt</label>
                        <textarea name="tomtat" style="Width:100%;height:150px;"></textarea>
                    </div>
                    <div class="form-group">
                        <label style="display:block;">Nội dung</label>
                        <textarea id="noidung" name="noidung" style="Width:100%;height:150px;"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Ảnh đại diện</label>
                        <input type="file" name="img" value="">
                    </div>
                    <div class="form-group">
                        <label>Ngày đăng</label>
                        <div id="datepicker" class="input-group date" data-date-format="dd-mm-yyyy">
                            <input class="form-control" readonly="true" type="text" name="ngaydang">
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-calendar"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="color: white">Giờ đăng</label>
                        <?php 
                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                        $today = date('g:i A');
                        ?>
                        <input type="text" name="giodang" value="<?php echo $today; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label style="color: white">Thứ tự</label>
                        <input type="text" name="ordernum" value="<?php if (isset($_POST['ordernum'])) {
                                                                        echo $_POST['ordernum'];
                                                                    } ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label style="display:block; color: white">Trạng thái</label>
                        <label class="radio-inline" style="color: white"><input checked="checked" type="radio" name="status" value="1">Hiện thị</label>
                        <label class="radio-inline" style="color: white"><input type="radio" name="status" value="0" >Không hiện thị</label>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Thêm mới">
                </form>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?> 