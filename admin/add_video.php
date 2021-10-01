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
                include('../connect/myconnect.php'); // mo ket noi
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
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
                            $query = "INSERT INTO tblvideo (title, link, ordernum, status) VALUES ('{$title}', '{$link}', $ordernum, $status)";
                            // chạy câu lệnh truy vấn
                            $result = $conn->query($query);
                            if ($result == true) {
                                echo "<h4 style='color: blue'>them thanh cong</h4>";
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
                <form name="frmadd_video" method="POST">

                    <h3>Thêm mới Video</h3>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" placeholder="title" value="<?php if (isset($_POST['title'])) {echo $_POST['title'];} ?>">
                        <?php 
                        if (isset($errors) && in_array('title', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập tiêu đề</p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Link</label>
                        <input type="text" name="link" class="form-control" placeholder="link video" value="<?php if (isset($_POST['link'])) {echo $_POST['link'];} ?>">
                        <?php 
                        if (isset($errors) && in_array('link', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập link</p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Thứ Tự</label>
                        <input type="number" name="ordernum" class="form-control" placeholder="ordernum" value="<?php if (isset($_POST['ordernum'])) {echo $_POST['ordernum'];} ?>">
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