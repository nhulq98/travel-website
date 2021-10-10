<?php error_reporting(0); ?>
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
                // kiểm tra id có phải là kiểu số và có tồn tại không
                if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
                    $id = $_GET['id'];
                } else {
                    // chuyển hướng đến trang list_user
                    header('Location: list_user.php');
                    /*Lưu ý: hàm header nếu ở trong file tồn tại cả tiếng việt và cả mã html thì sẽ bị lôi
                    - cách xử lý
                    Lưu tạm trong bộ nhớ đệm
                    */
                    // thoát ra để chạy tiếp các câu lệnh phía dưới
                    exit();
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
                        $username = $_POST['username'];
                    }
                    if (empty($_POST['password'])) {
                        $errors[] = "password";
                    } else {
                        $password = md5(trim($_POST['password']));
                    }
                    if (trim($_POST['password']) != trim($_POST['passwordre'])) {
                            $errors[] = "passwordre";
                        }
                    if (empty($_POST['hoten'])) {
                        $errors[] = "hoten";
                    } else {
                        $hoten = $_POST['hoten'];
                    }
                    if (empty($_POST['email'])) {
                        $errors[] = "email";
                    } else {
                        $email = $_POST['email'];
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
                        $chrole = $_POST['chrole'];
                            $countcheckrole = count($chrole);
                            $del_role = '';
                            for ($i = 0; $i < $countcheckrole; $i++) {
                                $del_role = $del_role . ',' . $chrole[$i];
                            }
                        // rỗng rồi thì ...
                        $query = "UPDATE tbluser SET taikhoan='{$username}', matkhau='{$password}', hoten='{$hoten}', email='{$email}', role='{$del_role}', status={$status} WHERE id={$id}";
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
                        $message = "<p class='required' >Bạn hãy nhập đầy đủ thông tin</p>";
                    }
                }
                ?>
                <?php
                $sql_id = "SELECT taikhoan, matkhau, hoten, email, role, status FROM tbluser WHERE id={$id}";
                $result_id = mysqli_query($conn, $sql_id);
                // kiểm tra xem id  có tồn tại hay ko
                if (mysqli_num_rows($result_id) == 1) {
                        list($username, $password, $hoten, $email, $role, $status) = mysqli_fetch_array($result_id, MYSQLI_NUM);
                    } else {
                    if (empty($id)) {
                            $message = "<p class='required'>ID user không tồn tại</p>";
                        }
                }
                ?>
                <form name="frmadd_user" method="POST">
                    <?php
                    if (isset($message)) {
                        echo $message;
                    }
                    ?>
                    <h3>Chỉnh sửa User:<?php if (isset($username)) {
                                            echo $username;
                                        } ?> </h3>
                    <div class="form-group">
                        <label>tài khoản</label>
                        <input type="text" name="username" readonly="true" class="form-control" placeholder="tên tài khoản" value="<?php if (isset($username)) {
                                                                                                                                        echo $username;
                                                                                                                                    } ?>">
                        <?php
                        if (isset($errors) && in_array('username', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập tên tài khoản</p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Mật khẩu</label>
                        <input type="password" name="password" class="form-control" placeholder="mật khẩu" value="<?php if (isset($password)) {
                                                                                                                        echo $password;
                                                                                                                    } ?>">
                        <?php
                        if (isset($errors) && in_array('password', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập mật khẩu</p>";
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
                        <input type="text" name="hoten" class="form-control" placeholder="họ và tên" value="<?php if (isset($hoten)) {
                                                                                                                echo $hoten;
                                                                                                            } ?>">
                        <?php
                        if (isset($errors) && in_array('hoten', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập họ tên</p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Email" value="<?php if (isset($email)) {
                                                                                                            echo $email;
                                                                                                        } ?>">
                        <?php
                        if (isset($errors) && in_array('email', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập email</p>";
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
                                        $edit_role = explode(',', $role);
                                        $ok = 0;
                                        foreach ($edit_role as $itemrole) 
                                        { 
                                            $edit_ht = $mang_add['title'] . '-' . $mang_add['link_themmoi'] . '-' . $mang_add['link_edit'] . '-' . $mang_add['link_list'] . '-' . $mang_add['link_delete'];
                                            if($edit_ht == $itemrole)
                                            {
                                                $ok = 1;
                                                break;
                                            }
                                        }
                                        ?>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        <div class="role_item">
                                    <input type="checkbox" name="chrole[]" <?php if($ok == 1){?>checked="checked"<?php } ?> class="chrole" value="<?php echo $mang_add['title'] . '-' . $mang_add['link_themmoi'] . '-' . $mang_add['link_edit'] . '-' . $mang_add['link_list'] . '-' . $mang_add['link_delete']; ?>">
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
                        <label class="radio-inline"><input <?php if($status == 0){?>checked="checked"<?php } ?> type="radio" name="status" value="0">chưa Kích hoạt</label>
                        <label class="radio-inline"><input <?php if($status == 1){?>checked="checked"<?php } ?> type="radio" name="status" value="1"> kích hoạt</label>

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