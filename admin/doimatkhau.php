<style type="text/css">
    .required{
        color: red;
    }
</style>
<?php include('includes/header.php')?>

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
                    $matkhaucu = $_POST['matkhaucu'];
                    // bỏ all các khoảng trắng và mã hóa
                    $matkhaumoi = md5(trim($_POST['matkhaumoi']));
                    $query="SELECT id,password FROM quanlyuser WHERE id={$_SESSION['id']} AND password=md5('{$matkhaucu}')";
                    $result = mysqli_query($conn, $query);
                    if(mysqli_num_rows($result) == 1)// mật khẩu cũ đúng
                    {
                        if(trim($_POST['matkhaumoi']) != trim($_POST['matkhaumoire']))
                        {
                            $message = "<p class='required'>Mật khẩu mới không giống nhau</p>";
                        }
                        else{
                        $query_up="UPDATE quanlyuser SET password='{$matkhaumoi}' WHERE id={$_SESSION['id']}";
                        $result_up=mysqli_query($conn, $query_up);
                        if(mysqli_num_rows($result) == 1)
                        {
                            $message = "<p style='color:green;' >Đổi mật khẩu thành công</p>";
                        }
                        else{
                            $message = "<p class='required' >Đổi mật khẩu không thành công</p>";
                        }
                    }
                    }
                    else{
                        $message = "<p class'required'>Mật khẩu cũ không đúng</p>";
                    }
                    // kiểm tra mảng error có RỖNG?
                    

                    
                }
                ?>
                <?php
                    if(isset($message))
                    {
                        echo $message;
                    }
                ?>
                <form name="frmdoimatkhau" method="POST">

                    <h3>Đổi mật khẩu</h3>
                    <div class="form-group">
                        <label>Tài Khoản</label>
                        <input type="text" name="username" class="form-control" placeholder="Tên tài khoản" readonly="true" value="<?php if (isset($_SESSION['username'])) {echo $_SESSION['username'];} ?>">
                        <?php 
                        if (isset($errors) && in_array('link', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập link</p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Nhập mật khẩu cũ</label>
                        <input type="password" name="matkhaucu" class="form-control" placeholder="Mật khẩu cũ" value="<?php if (isset($_POST['matkhaucu'])) {echo $_POST['matkhaucu'];} ?>">
                        <?php 
                        if (isset($errors) && in_array('title', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập tiêu đề</p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Nhập mật khẩu mới</label>
                        <input type="password" name="matkhaumoi" class="form-control" placeholder="Nhập mật khẩu mới" value="<?php if (isset($_POST['matkhaumoi'])) {echo $_POST['matkhaumoi'];} ?>">
                        <?php 
                        if (isset($errors) && in_array('title', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập tiêu đề</p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Xác nhận mật khẩu mới</label>
                        <input type="password" name="matkhaumoire" class="form-control" placeholder="xác nhận mật khẩu mới" value="<?php if (isset($_POST['matkhaumoire'])) {echo $_POST['matkhaumoire'];} ?>">
                        <?php 
                        if (isset($errors) && in_array('title', $errors)) {
                            echo "<p class='required'>Bạn chưa nhập tiêu đề</p>";
                        }
                        ?>
                    </div>
                   
                    <input type="submit" name="submit" class="btn btn-primary" value="Đồng ý">
                </form>


            </div>
        </div>

        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<?php include('includes/footer.php') ?>