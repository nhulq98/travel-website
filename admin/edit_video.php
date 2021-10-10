<?php ob_start();?>
<style>
    .required {
        color: red;
    }
</style>

<?php include('includes/header.php');

?>

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <?php
                include('../connect/myconnect.php'); // mo ket noi
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                // kiểm tra id có phải là kiểu số và có tồn tại không
                if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
                        $id = $_GET['id'];
                    } else {
                        // chuyển hướng đến trang list_video
                        header('Location: list_video.php');
                        /*Lưu ý: hàm header nếu ở trong file tồn tại cả tiếng việt và cả mã html thì sẽ bị lôi
                        - cách xử lý
                        Lưu tạm trong bộ nhớ đệm
                        */ 
                        // thoát ra để chạy tiếp các câu lệnh phía dưới
                        exit();
                    }
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
                    if (empty($_POST['link'])) {
                        $errors[] = "link";
                    } else {
                        $link = $_POST['link'];
                    }
                    if (empty($_POST['ordernum'])) {
                        $errors[] = "ordernum";
                    } else {
                        $ordernum = $_POST['ordernum'];
                    }
                    if (empty($_POST['status'])) {
                        $status = 0;
                    } else {
                        $status = $_POST['status'];
                    }
                    // kiểm tra mảng error có RỖNG?
                    if (empty($errors)) {
                        // rỗng rồi thì ...
                    $query = "UPDATE tblvideo SET title='{$title}', link='{$link}', ordernum={$ordernum}, status={$status} WHERE id={$id}";
                        // chạy câu lệnh truy vấn
                        $result = $conn->query($query);
                        if ($result == true) {
                            echo "<h4 style='color: blue'>Sửa thành công</h4>";
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
                <?php
                $sql_id="SELECT title, link, ordernum, status FROM tblvideo WHERE id={$id}";
                $result_id=mysqli_query($conn, $sql_id); 
                // kiểm tra xem id  có tồn tại hay ko
                if(mysqli_num_rows($result_id) == 1)
                {
                    list($title, $link, $ordernum, $status) = mysqli_fetch_array($result_id, MYSQLI_NUM);
                } 
                else{
                    echo "<p class='required'>ID video không tồn tại</p>";
                }
                ?>
                <form name="frmadd_video" method="POST">

                    <h3>Chỉnh sửa Video: <?php if(isset($title)){echo "<p style='color: blue'>".$title."</p>";}?></h3>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" placeholder="title" value="<?php if (isset($title)) {
                                                                                                            echo $title;
                                                                                                        } ?>">
                        <?php 
                        if (isset($errors) && in_array('title', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập tiêu đề</p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Link</label>
                        <input type="text" name="link" class="form-control" placeholder="link video" value="<?php if (isset($link)) {
                                                                                                                echo $link;
                                                                                                            } ?>">
                        <?php 
                        if (isset($errors) && in_array('link', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập link</p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Thứ Tự</label>
                        <input type="number" name="ordernum" class="form-control" placeholder="ordernum" value="<?php if (isset($ordernum)) {
                                                                                                                    echo $ordernum;} ?>">
                        <?php 
                        if (isset($errors) && in_array('ordernum', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập số thứ tự</p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label style="display: block;">Trạng Thái</label>
                        <?php
                        if(isset($status) && $status == 1) 
                        {
                        ?>
                        <label class="radio-inline"><input checked="checked" type="radio" name="status" value="1">Hiển Thị</label>
                        <label class="radio-inline"><input type="radio" name="status" value="0">Không hiển thị</label>
                        <?php
                        }
                        else if(isset($status) && $status == 0){
                            ?>
                            <label class="radio-inline"><input type="radio" name="status" value="1">Hiển Thị</label>
                            <label class="radio-inline"><input checked="checked" type="radio" name="status" value="0">Không hiển thị</label>
                        <?php
                        }
                        ?>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Chỉnh sửa">
                </form>


            </div>
        </div>

        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<?php include('includes/footer.php'); ?> 
<?php ob_flush()();?>