<?php
include('../connect/myconnect.php');
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
    $id = $_GET['id'];
        
        $query_sreach = "SELECT * FROM tbldanhmucbaiviet WHERE parent_id = {$id}";
        $result_sreach = mysqli_query($conn, $query_sreach);
        $sreach = $result_sreach->fetch_assoc();
        // kiểm tra danh mục này nó có các danh mục con trong đó ko
        if(!isset($sreach['parent_id']))
        {// nếu không mới cho xóa
            $query = "DELETE FROM tbldanhmucbaiviet WHERE id={$id}";
            $result = mysqli_query($conn, $query);
            if ($result) {
                echo "Xóa thành công";
            } else
            {
                echo "Error deleting record: " . mysqli_error($conn);
            }

            header('Location: list_danhmucbv.php');
        }    
        else {
            echo "Xóa không thành công. Tồn tại danh mục con";
            header('Location: list_danhmucbv.php');
    } 
}
 