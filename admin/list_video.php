<?php include('includes/header.php'); ?>
<?php include('includes/sidebar.php'); ?>
<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                
            <h3>Danh sách video</h3>
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
                    <th>Mã</th>
                    <th>tiêu đề</th>
                    <th>link</th>
                    <th>số thứ tự</th>
                    <th>trạng thái</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $query = "SELECT * FROM tblvideo ORDER BY ordernum DESC";
                    // chạy truy vấn và đặt dữ liệu vào biến result
                    $result = $conn->query($query);
                    //kiểm tra nếu có nhiều hơn 0 hàng trả về
                    if ( $result->num_rows > 0) {
                        echo "<h4 style='color: blue'>xem thanh cong</h4>";
                    //hàm fetch_assoc () đặt tất cả các kết quả vào một mảng kết hợp mà chúng ta có thể lặp qua
                    while($video = $result->fetch_assoc()){
                        // hàm chức năng tương tự $row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                        
                ?>
                
                <tr>
                    <td><?php echo $video["id"]?></td>
                    <td><?php echo $video["title"]?></td>
                    <td><?php echo $video["link"]?></td>
                    <td><?php echo $video["ordernum"]?></td>
                    <td><?php if($video["status"] == 1){echo "Hiển thị"; }else{echo "<p style='color: red'>Không hiển thị<p>";}?></td>
                    <td align="center"><a href="edit_video.php?id=<?php echo $video['id']?>"><img width="20" src="../images/icon_edit.png"></a></td>
                    <td align="center"><a onclick="return confirm('Bạn có muốn xóa không');"href="delete_video.php?id=<?php echo $video['id'];?>"><img width="20" src="../images/icon_delete.png"></a></td>
                </tr>
                    <?php } }
                    else{ echo "0 results";
                        echo "Error " . $query . " Loi: " . $conn->error;
                    }
                    ?>
            </tbody>
               
            </table>
            </div>
        </div>

        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<?php include('includes/footer.php'); ?>