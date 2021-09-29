<style>
    .required {
        color: red;
    }
</style>
<script language="javascript">
    function checkall(class_name, obj) {
        var items = document.getElementsByClassName(class_name);
        if (obj.checked == true) {
            for (i = 0; i < items.length; i++) {
                items[i].checked = true;

            }
        } else {
            for (i = 0; i < items.length; i++) {
                items[i].checked = false;

            }
        }
    }
</script>
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
                $message = '';
                // kiểm tra nút submit đã được nhấn chưa.
                if (isset($_POST['submit'])) {
                    // nếu đã nhấn thì vào đây
                    $errors = array();
                    // kiểm tra ô title có rỗng
                    if (empty($_POST['username'])) {
                        // vào này là rỗng nè
                        $errors[] = "username";
                    } else {
                        // ko rỗng thì vào này lấy dữ liệu ra
                        if (strlen(strstr($_POST['username'], " ")) > 0) {
                            $errors[] = "errorUsername";

                        } else {
                            
                            $username = $_POST['username'];
                        }
                    }
                    if (empty($_POST['password'])) {
                        $errors[] = "password";
                    } else {
                        // sau khi nhập thì ktra pass có đủ 6 ký tự ko
                        if (strlen($_POST['password']) < 6) {
                            $errors = "passwordthieu";
                        } else {
                            $password = md5(trim($_POST['password']));
                        }
                    }
                    if (trim($_POST['password']) != trim($_POST['passwordre'])) {
                        $errors[] = "passwordre";
                    }
                    if (empty($_POST['hoten'])) {
                        $errors[] = "hoten";
                    } else {
                        $hoten = $_POST['hoten'];
                    }
                    // kiểm tra email nhập vào có hợp lệ
                    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == true) {
                        // hợp lệ thì truyền giá trị vào đây
                        $email = mysqli_real_escape_string($conn, $_POST['email']);
                    } else {
                        $errors[] = "email";
                    }
                    if (empty($_POST['role'])) {
                        $role = 0; //defalt là user
                    } else {
                        $role = $_POST['role'];
                    }
                    if (empty($_POST['status'])) {
                        $status = 0; //defalt là không kích hoạt
                    } else {
                        $status = $_POST['status'];
                    }
                    // kiểm tra mảng error có RỖNG?
                    if (empty($errors)) {
                        // rỗng rồi thì ...
                        // kiểm tra tài khoản đã tồn tại chưa
                        $query = "SELECT taikhoan FROM tbluser WHERE taikhoan='{$username}'";
                        $result = mysqli_query($conn, $query);
                        // kiểm tra có câu query có hợp lệ truy xuất đúng ko?

                        // kiểm tra email đã tồn tại chưa
                        $query2 = "SELECT email FROM tbluser WHERE email='{$email}'";
                        $result2 = mysqli_query($conn, $query2);
                        // kiểm tra có câu query có hợp lệ truy xuất đúng ko?

                        if (mysqli_num_rows($result) == 1) {
                            $message = "<p class='required'>Tài khoản đã tồn tại. yêu cầu nhập tài khoản khác</p>";
                           
                        } elseif (mysqli_num_rows($result2) == 1) {
                            $message = "<p class='required'>Email đã tồn tại. yêu cầu nhập email khác</p>";

                        } else {
                            $chrole = $_POST['chrole'];
                            $countcheckrole = count($chrole);
                            $del_role = '';
                            for ($i = 0; $i < $countcheckrole; $i++) {
                                $del_role = $del_role . ',' . $chrole[$i];
                            }

                            // ko lỗi j. thì vào đây thêm mới
                            $query_in = "INSERT INTO tbluser (taikhoan, matkhau, hoten, email, role, status) VALUES ('{$username}','{$password}','{$hoten}', '{$email}', '{$del_role}', $status)";

                            // chạy câu lệnh truy vấn
                            $result_in = $conn->query($query_in);
                            if (mysqli_affected_rows($conn) == 1) {
                                echo "<h4 style='color: blue'>Thêm thành công</h4>";
                                
                                // set về cho all các ô là rỗng mỗi khi thêm xong
                                $_POST['username'] = "";
                                $_POST['password'] = "";
                                $_POST['passwordre'] = "";
                                $_POST['hoten'] = "";
                                $_POST['email'] = "";
                            } else {
                                echo "Error " . $query_in . " Lỗi: " . $conn->error;
                            }
                        }
                    } else if (!empty($errors)) {
                        echo "<p class='required' >Bạn hãy nhập đầy đủ thông tin</p>";
                    }
                }
                ?>
                <form name="frmadd_user" method="POST">
                    <?php
                    if (isset($message)) {
                        echo $message;
                    }

                    ?>
                    <h3>Thêm mới User</h3>
                    <div class="form-group">
                        <label>tài khoản</label>
                        <input type="text" name="username" class="form-control" placeholder="tên tài khoản" value="<?php if (isset($_POST['username'])) {
                                                                                                                        echo $_POST['username'];
                                                                                                                    } ?>">
                        <?php
                        //echo "<p class='required'>Lưu ý:Tài khoản viết không dấu</p>";
                        if (isset($errors) && in_array('username', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập tên tài khoản</p>";
                        }
                        if (isset($errors) && in_array('errorUsername', $errors)) {
                            echo "<p class='required'>username không được chứa khoản trắng</p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Mật khẩu</label>
                        <input type="password" name="password" class="form-control" placeholder="mật khẩu" value="<?php if (isset($_POST['password'])) {
                                                                                                                        echo $_POST['password'];
                                                                                                                    } ?>">
                        <?php
                        echo "<p class='required'>Lưu ý:mật khẩu ít nhất 6 ký tự</p>";
                        if (isset($errors) && in_array('password', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập mật khẩu</p>";
                        }
                        if (isset($errors) && in_array('passwordthieu', $errors)) {
                            echo "<p class='required'>Mật khẩu ít nhất 6 ký tự</p>";
                        }

                        ?>
                    </div>
                    <div class="form-group">
                        <label>Xác nhận mật khẩu</label>
                        <input type="password" name="passwordre" class="form-control" placeholder="mật khẩu" value="<?php if (isset($_POST['passwordre'])) {
                                                                                                                        echo $_POST['passwordre'];
                                                                                                                    } ?>">
                        <?php
                        if (isset($errors) && in_array('passwordre', $errors)) {
                            echo "<p class='required'>Mật khẩu không khớp. xin kiểm tra lại</p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Họ tên</label>
                        <input type="text" name="hoten" class="form-control" placeholder="họ và tên" value="<?php if (isset($_POST['hoten'])) {
                                                                                                                echo $_POST['hoten'];
                                                                                                            } ?>">
                        <?php
                        if (isset($errors) && in_array('hoten', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập họ tên</p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Email" value="<?php if (isset($_POST['email'])) {
                                                                                                            echo $_POST['email'];
                                                                                                        } ?>">
                        <?php
                        if (isset($errors) && in_array('email', $errors)) {
                            echo "<p class='required'>Email không hợp lệ</p>";
                        }
                        ?>
                    </div>

                    <div class="form-group">
                        <label>Chọn quyền</label>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                <input type="checkbox" name="chkfull" onclick="checkall('chrole', this)">
                                <label>Full quyền</label>
                            </div>
                        </div>
                        <div class="row">
                            <div>
                                <?php
                                foreach ($mang as $mang_add) {
                                    ?>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        <div class="role_item">
                                            <input type="checkbox" name="chrole[]" class="chrole" value="<?php echo $mang_add['title'] . '-' . $mang_add['link_themmoi'] . '-' . $mang_add['link_edit'] . '-' . $mang_add['link_list'] . '-' . $mang_add['link_delete']; ?>">
                                            <label><?php echo $mang_add['title']; ?></label>
                                        </div>
                                    </div>
                                <?php
                            }
                            ?>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label style="display: block;">Trạng Thái</label>
                        <label class="radio-inline"><input checked="checked" type="radio" name="status" value="0">chưa Kích hoạt</label>
                        <label class="radio-inline"><input type="radio" name="status" value="1"> kích hoạt</label>

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