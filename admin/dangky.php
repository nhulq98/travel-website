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

    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

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
    // kiểm tra có nhấn nút đâng nhập chưa
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
        // kiểm tra các trường đầu vào nào rỗng ko
        if (empty($_POST['username'])) {
            $errors[] = 'username';
        } else {
            $username = $_POST['username'];
        }
        if (empty($_POST['hoten'])) {
            $errors[] = 'hoten';
        } else {
            // md5 để mã hóa
            $hoten = $_POST['hoten'];
        }
        if (empty($_POST['email'])) {
            $errors[] = 'email';
        } else {
            // md5 để mã hóa
            $email = $_POST['email'];
        }
        if (empty($_POST['password'])) {
            $errors[] = 'password';
        } else {
            // md5 để mã hóa
            $password = md5($_POST['password']);
        }
        if (empty($_POST['password_confirm'])) {
            $errors[] = 'password_confirm';
        } else {
            // md5 để mã hóa
            $password_confirm = md5($_POST['password_confirm']);
        }
        
    }
    if (empty($errors)) {
        $query = "INSERT INTO tbluser(taikhoan, hoten,email,matkhau) VALUES (taikhoan='{$username}', hoten='{$hoten}', email='{$email}', matkhau='{$password}');";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) // nếu bằng 1 thì câu truy vấn tồn tại trong database
            {
                list($id, $username, $password, $role, $status) = mysqli_fetch_array($result, MYSQLI_NUM);
                $message = "<p class='required'>Đăng ký thành công</p>";
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
        <form class="form-horizontal" action='' method="POST">
  <fieldset>
    <div id="legend">
      <legend class="">Đăng Ký</legend>
    </div>
    <div class="control-group">
      <!-- Username -->
      <label class="control-label"  for="username">Tài khoản</label>
      <div class="controls">
        <input type="text" id="username" name="username" placeholder="Tên tài khoản" class="input-xlarge">
        
      </div>
    </div>
    <div class="control-group">
      <!-- E-mail -->
      <label class="control-label" for="hoten">Họ tên</label>
      <div class="controls">
        <input type="text" id="hoten" name="hoten" placeholder="Nhập họ và tên" class="input-xlarge">
        
      </div>
    </div>

    <div class="control-group">
      <!-- E-mail -->
      <label class="control-label" for="email">E-mail</label>
      <div class="controls">
        <input type="text" id="email" name="email" placeholder="vd: sieunhan@gmail.com" class="input-xlarge">
        
      </div>
    </div>
 
    <div class="control-group">
      <!-- Password-->
      <label class="control-label" for="password">Mật khẩu</label>
      <div class="controls">
        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" class="input-xlarge">
        
      </div>
    </div>
 
    <div class="control-group">
      <!-- Password -->
      <label class="control-label"  for="password_confirm">Xác nhận mật khẩu</label>
      <div class="controls">
        <input type="password" id="password_confirm" name="password_confirm" placeholder="" class="input-xlarge">
        
      </div>
    </div>
 
    <div class="control-group">
      <!-- Button -->
      <div class="controls">
        <button class="btn btn-success" name="" >Đăng ký</button>
      </div>
    </div>
  </fieldset>
</form>
    </div>
</body>

</html> 