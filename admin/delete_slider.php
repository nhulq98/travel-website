<?php 
include('../connect/myconnect.php');
echo "vao hay chưa";
// kiểm tra id có phải kiểu số ko               // giá trị id phải nhỏ nhất là 1 vì id cho AI tăng tự động trong database
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
        $id = $_GET['id'];
        // xóa hình ảnh  trong thư mục upload
        $sql = "SELECT img,img_thumb FROM tblslider WHERE id={$id}";
        $query_i = mysqli_query($conn, $sql);
        $imgInfo=mysqli_fetch_assoc($query_i);
        unlink('../'.$imgInfo['img']);
        unlink('../'.$imgInfo['img_thumb']); // xóa ảnh thumb trong thư mục update luôn
        $query = "DELETE FROM tblslider WHERE id={$id}";
        $result = mysqli_query($conn, $query);
        if($result)
        {
            echo "Xóa thành công";
        }else
        {
            echo "Error deleting record: ". mysqli_error($conn);
        }
        header('Location: list_slider.php');
    }
    else{
        header('Location: list_slider.php');
    }
    
 ?>