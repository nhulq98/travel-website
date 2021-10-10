<?php ob_start(); ?>
<style type="text/css">
    .required {
        color: red;
    }
</style>
<?php include('includes/header.php') ?>

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
                    // chuyển hướng đến trang list_user nếu nó không tồn tại
                    header('Location: list_user.php');
                    /*Lưu ý: hàm header nếu ở trong file tồn tại cả tiếng việt và cả mã html thì sẽ bị lôi
                    - cách xử lý
                    Lưu tạm trong bộ nhớ đệm
                    */
                    // thoát ra để chạy tiếp các câu lệnh phía dưới
                    exit();
                }
                $query = "SELECT taikhoan, matkhau FROM tbluser WHERE id={$id}";
                $result = mysqli_query($conn, $query);
                // kiểm tra xem id  có tồn tại hay ko
                if (mysqli_num_rows($result) == 1) {
                    list($user, $password) = mysqli_fetch_array($result, MYSQLI_NUM);
                } else {
                    echo "<p class='required'>ID video không tồn tại</p>";
                }

                // kiểm tra nút submit đã được nhấn chưa.
                if (isset($_POST['submit'])) {
                    // kiểm tra mật khẩu nhập có trùng vs mật khẩu cũ ko
                    if (md5(trim($_POST['matkhaumoi'])) == $password) {
                            $message = "<p class='required'>Reset không thành công.Mật khẩu trùng với mật khẩu cũ</p>";
                        } else {


                        // bỏ all các khoảng trắng và mã hóa
                        $matkhaumoi = md5(trim($_POST['matkhaumoi']));

                        if (trim($_POST['matkhaumoi']) != trim($_POST['matkhaumoire'])) {
                            $message = "<p class='required'>Mật khẩu mới không giống nhau</p>";
                        } else {
                            $query_up = "UPDATE tbluser SET matkhau='{$matkhaumoi}' WHERE id={$id}";
                            $result_up = mysqli_query($conn, $query_up);
                            if (mysqli_affected_rows($conn) == 1) {
                                $message = "<p style='color:green;' >Reset mật khẩu thành công</p>";
                            } else {
                                $message = "<p class='required' >Reset mật khẩu không thành công</p>";
                            }
                        }
                    }
                }

                // kiểm tra mảng error có RỖNG?




                ?>
                <?php

                if (isset($message)) {
                    echo $message;
                }
                ?>
                <form name="frmdoimatkhau" method="POST">

                    <h3>Đổi mật khẩu</h3>
                    <div class="form-group">
                        <label>Tài Khoản</label>
                        <input type="text" name="username" class="form-control" placeholder="Tên tài khoản" readonly="true" value="<?php if (isset($user)) {
                                                                                                                                        echo $user;
                                                                                                                                    } ?>">
                        <?php 
                        if (isset($errors) && in_array('link', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập link</p>";
                        }
                        ?>
                    </div>

                    <div class="form-group">
                        <label>Nhập mật khẩu mới</label>
                        <input type="password" name="matkhaumoi" class="form-control" placeholder="Nhập mật khẩu mới" value="<?php if (isset($_POST['matkhaumoi'])) {
                                                                                                                                    echo $_POST['matkhaumoi'];
                                                                                                                                } ?>">
                        <?php 
                        if (isset($errors) && in_array('title', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập tiêu đề</p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Xác nhận mật khẩu mới</label>
                        <input type="password" name="matkhaumoire" class="form-control" placeholder="xác nhận mật khẩu mới" value="">
                        <?php 
                        if (isset($errors) && in_array('title', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập tiêu đề</p>";
                        }
                        ?>
                    </div>

                    <input type="submit" name="submit" class="btn btn-primary" value="Đổi mật khẩu">
                </form>


            </div>
        </div>

        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<?php include('includes/footer.php') ?>
<?php ob_flush(); ?> 