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
                // kiểm tra id có phải là kiểu số và có tồn tại không
                if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
                    $id = $_GET['id'];
                } else {
                    // chuyển hướng đến trang list_danhmucbv
                    header('Location: list_baiviet.php');
                    /*Lưu ý: hàm header nếu ở trong file tồn tại cả tiếng việt và cả mã html thì sẽ bị lôi
                    - cách xử lý
                    Lưu tạm trong bộ nhớ đệm
                    */
                    // thoát ra để chạy tiếp các câu lệnh phía dưới
                    exit();
                }
                $message = '';
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
                      /*  //upload hình ảnh
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
                            $imageThumb->resize(1280, 467, 'crop');
                            $imageThumb->save($temp[0] . '_thumb', '../upload/resized');
                        }
                        */
                        $ngaydang_ht = explode("-", $_POST['ngaydang']);
                        $ngaydang_in = $ngaydang_ht[2] . '-' . $ngaydang_ht[1] . '-' . $ngaydang_ht[0];
                        $giodang_in = $_POST['giodang'];
                        //inser vao trong db
                        $query = "UPDATE tblbaiviet SET danhmucbaiviet = {$parent_id},title='{$title}',tomtat='{$tomtat}',noidung='{$noidung}',ordernum={$ordernum} WHERE id={$id}";
                        $result = $conn->query($query);
                        if ($result == true) {
                            echo "<h4 style='color: blue'>Chỉnh sửa thành công</h4>";
                        } else {
                            echo "Error " . $query . " Lỗi: " . $conn->error;
                        }
                        //kt_query($results, $query);
                    } else {
                        $message = "<p class='required'>Bạn hãy nhập đầy đủ thông tin</p>";
                    }
                }
                ?>

<?php
                $sql_id = "SELECT danhmucbaiviet, title, tomtat, noidung, img, ordernum,status FROM tblbaiviet WHERE id={$id}";
                $result_id = mysqli_query($conn, $sql_id);
                // kiểm tra xem id  có tồn tại hay ko
                if (mysqli_num_rows($result_id) == 1) {
                        list($danhmucbaiviet, $Tieude, $Tomtat, $Noidung, $Hinhanh,$Sothutu, $Trangthai) = mysqli_fetch_array($result_id, MYSQLI_NUM);
                    } else {
                    if (empty($id)) {
                            $message = "<p class='required'>ID user không tồn tại</p>";
                        }
                }
                ?>

                <form name="frmbaiviet" method="POST" enctype="multipart/form-data">
                    <?php
                    if (isset($message)) {
                        echo $message;
                    }
                    ?>
                    <h3>Chỉnh sửa bài viết</h3>
                    <div class="form-group">
                        <label style="display:block;">Danh mục bài viết</label>
                        <?php selectCtrl('parent', 'forFormdim'); ?>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="<?php if (isset($Tieude)) {
                                                                    echo $Tieude;
                                                                } ?>" class="form-control" placeholder="Title">
                        <?php
                                                                if (isset($errors) && in_array('title', $errors)) {
                                                                    echo "<p class='required'>Bạn chưa nhập tiêu đề</p>";
                                                                }
                                                                ?>
                    </div>
                    <div class="form-group">
                        <label style="display:block;">Tóm tắt</label>
                        <textarea name="tomtat" style="Width:100%;height:150px;"><?php if (isset($Tomtat)) {
                                                                    echo $Tomtat;
                                                                }?></textarea>
                    </div>
                    <div class="form-group">
                        <label style="display:block;">Nội dung</label>
                        <textarea id="noidung" name="noidung" style="Width:100%;height:150px;"><?php if (isset($Noidung)) {
                                                                    echo $Noidung;
                                                                }?></textarea>
                    </div>
                    
                    <!--<div class="form-group">
                        <label>Ảnh đại diện</label>
                        <input type="file" name="img" value="">
                        <img style="width: 400px; height: 200px" src="../<?php echo $Hinhanh; ?>">
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
                        <label>Giờ đăng</label>
                        <?php 


                                                                ?>
                        <input type="text" name="giodang" value="<?php /*echo $today; */?>" class="form-control">
                    </div>
                    -->
                    <div class="form-group">
                        <label >Thứ tự</label>
                        <input type="text" name="ordernum" value="<?php if (isset($Sothutu)) {
                                                                        echo $Sothutu;
                                                                    } ?>" class="form-control">
                    </div>
                    <!--<div class="form-group">
                        <label style="display:block;">Trạng thái</label>
                        <label class="radio-inline"><input checked="checked" type="radio" name="status" value="1">Hiện thị</label>
                        <label class="radio-inline"><input type="radio" name="status" value="0">Không hiện thị</label>
                    </div>-->
                    <input type="submit" name="submit" class="btn btn-primary" value="Cập nhật">
                </form>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>