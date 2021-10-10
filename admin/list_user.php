<?php include('includes/header.php'); ?>
<?php include('includes/sidebar.php'); ?>
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->

        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">

            <h3>Danh sách user</h3>
            <table class="table table-hover">
                <?php
            // mở kết nối
                include('../connect/myconnect.php');
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                ?>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Tài khoản</th>
                        <th>Mật khẩu</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Trạng thái</th>
                        <th>Reset pass</th>
                        <th>Sửa</th>
                        <th>Xóa</th>


                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // BƯỚC 2: TÌM TỔNG SỐ RECORDS
                    $result = mysqli_query($conn, 'select count(id) as total from tbluser');
                    // đổ all các kết quả ở trong 1 hàng trong csdl vào trong "mảng kết hợp" $ROW
                    $row = mysqli_fetch_assoc($result);
                    // dùng mảng ROW để lấy ra tổng số bản ghi hiện có
                    $total_records = $row['total'];
                    // BƯỚC 3: TÌM LIMIT VÀ CURRENT_PAGE
                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $limit = 6;
                    // BƯỚC 4: TÍNH TOÁN TOTAL_PAGE VÀ START
                    // tổng số trang
                    $total_page = ceil($total_records / $limit);

                    // Giới hạn current_page trong khoảng 1 đến total_page
                    if ($current_page > $total_page) {
                        $current_page = $total_page;
                    } else if ($current_page < 1) {
                        $current_page = 1;
                    }

                    // Tìm Start
                    $start = ($current_page - 1) * $limit;

                    // BƯỚC 5: TRUY VẤN LẤY DANH SÁCH TIN TỨC
                    // Có limit và start rồi thì truy vấn CSDL lấy danh sách tin tức
                    //start là lấy ra bản ghi đầu tiên, limit là số bản ghi đc lấy ra trên 1 page
                    $sql = "SELECT * FROM tbluser ORDER BY id DESC LIMIT {$start},{$limit}";

                    // chạy truy vấn và đặt dữ liệu vào biến result
                    $result = $conn->query($sql);
                    //kiểm tra nếu có nhiều hơn 0 hàng trả về
                    if ($result->num_rows > 0) {
                        //echo "<h4 style='color: blue'>xem thanh cong</h4>";
                        //hàm fetch_assoc () đặt tất cả các kết quả vào một mảng kết hợp mà chúng ta có thể lặp qua
                        while ($user = $result->fetch_assoc()) {
                            // hàm chức năng tương tự $row = mysqli_fetch_array($result, MYSQLI_ASSOC))

                            ?>

                    <tr>
                        <td><?php echo $user["id"]; ?></td>
                        <td><?php echo $user["taikhoan"]; ?></td>
                        <td><?php echo $user["matkhau"]; ?></td>
                        <td><?php echo $user["hoten"]; ?></td>
                        <td><?php echo $user["email"]; ?></td>

                        
                        <td><?php if ($user["status"] == 1) {
                                echo "kích hoạt";
                            } else {
                                echo "<p style='color: red'>Chưa kích hoạt<p>";
                            } ?></td>
                        <td align="center"><a href="reset_user.php?id=<?php echo $user['id']; ?>"><img width="25" src="../images/icon_reset.jpg"></a></td>
                        <td align="center"><a href="edit_user.php?id=<?php echo $user['id']; ?>"><img width="25" src="../images/icon_insertnv.jpg"></a></td>
                        <td align="center"><a onclick="return confirm('Bạn có muốn xóa không');" href="delete_user.php?id=<?php echo $user['id']; ?>"><img width="25" src="../images/icon_deletenv.png"></a></td>
                    </tr>
                    <?php 
                }
            } else {
                echo "0 results";
                echo "Error " . $sql . " Loi: " . $conn->connect_error;
            }
            // đóng kết nối
             ?>
                </tbody>

            </table>
            <ul class="pagination">
                <?php 
                // PHẦN HIỂN THỊ PHÂN TRANG
                // BƯỚC 7: HIỂN THỊ PHÂN TRANG

                // nếu current_page > 1 và total_page > 1 mới hiển thị nút prev
                if ($current_page > 1 && $total_page > 1) {
                    echo '<li><a href="list_user.php?page=' . ($current_page - 1) . '">Prev</a></li>';
                }

                // Lặp khoảng giữa
                for ($i = 1; $i <= $total_page; $i++) {
                    // Nếu là trang hiện tại thì hiển thị thẻ span MỤC ĐÍCH : không cho ngdung click vào trang đang hiển thị
                    // ngược lại hiển thị thẻ a
                    if ($i == $current_page) {
                        //echo '<li>' . $i . '</li>';
                        echo '<li><span style="background-color: #0000FF; color: white;">'.$i.'</span></li>';
                        
                    } else {
                        echo '<li><a href="list_user.php?page=' . $i . '">'.$i.'</a></li>';
                        
                    }
                }

                // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
                if ($current_page < $total_page && $total_page > 1) {
                    echo '<li><a href="list_user.php?page=' . ($current_page + 1) . '">Next</a></li>';
                }
                ?>
            </ul>
        </div>



        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>


<?php include('includes/footer.php'); ?> 