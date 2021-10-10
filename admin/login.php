<!--
    chức năng là nhập password vào sau đó nó sẽ mã hóa và đem đi so
    sánh với password ở trong d
-->
<?php
session_start();
if (isset($_SESSION['id'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <title>Đăng nhập hệ thống</title>
    <style>
        .required {
            color: red;
            font-size: 15px;
        }
    </style>
</head>

<body>
    <?php
    include('../connect/myconnect.php');
    $message = "";
    // kiểm tra có nhấn nút đâng nhập chưa
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
        // kiểm tra các trường đầu vào nào rỗng ko
        if (empty($_POST['username'])) {
            $errors[] = 'username';
        } else {

            $username = $_POST['username'];
        }
        if (empty($_POST['password'])) {
            $errors[] = 'password';
        } else {
            // md5 để mã hóa
            $password = md5($_POST['password']);
        }
    }
    if (empty($errors)) {
        $query = "SELECT id, taikhoan, matkhau, role, status FROM tbluser WHERE taikhoan='{$username}' AND matkhau='{$password}' AND status='1'";
        $result = mysqli_query($conn, $query);
        //$check = $result->fetch_assoc();
        if (mysqli_num_rows($result) == 1) // nếu bằng 1 thì câu truy vấn tồn tại trong database
            {
                list($id, $username, $password, $role, $status) = mysqli_fetch_array($result, MYSQLI_NUM);

                // Set session variables
                $_SESSION["username"] = $username;
                $_SESSION["id"] = $id;
                header('Location: index.php');
            } else {
            $message = "<p class='required'>Tài khoản hoặc mật khẩu không đúng</p>";
        }
    }



    ?>
    <div class="table_div">
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
        <form class="login" method="POST" action="" name="frmlogin">
            <table>
                <tr>
                    <td colspan="2" class="title">Đăng nhập hệ thống</td>
                </tr>
                <tr>
                    <td style="color: black"><strong>Tài khoản</strong></td>
                    <td><input type="text" name="username" placeholder="User name" value="<?php if (isset($_POST['username'])) {
                                                                        echo $_POST['username'];
                                                                    } ?>"></td>
                    <td>
                        <?php
                        if (isset($errors) && in_array('username', $errors)) {
                            echo "<p class='required'>Không được để trống username</p>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="color: black"><strong>Mật khẩu</strong></td>
                    <td><input type="password" name="password" placeholder="password" value="<?php if (isset($_POST['password'])) {
                                                                            echo $_POST['password'];
                                                                        } ?>"></td>
                    <td>
                        <?php
                        if (isset($errors) && in_array('password', $errors)) {
                        echo "<p class='required'>Không được để trống password</p>";
                        }

                        ?>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" value="Đăng nhập"></td>
                </tr>
        </form>
    </div>
</body>

</html>