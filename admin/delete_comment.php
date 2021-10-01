<?php 
include('../connect/myconnect.php');
echo "vao hay chưa";
// kiểm tra id có phải kiểu số ko               // giá trị id phải nhỏ nhất là 1 vì id cho AI tăng tự động trong database
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
        $id = $_GET['id'];
        $query = "DELETE FROM tblgopy WHERE id={$id}";
        $result = mysqli_query($conn, $query);
        if($result)
        {
            echo "Xóa thành công";
        }else
        {
            echo "Error deleting record: ". mysqli_error($conn);
        }
        header('Location: comment.php');
    }
    else{
        header('Location: comment.php');
    }
    
 ?>