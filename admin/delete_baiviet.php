<?php 
include('../connect/myconnect.php');
include('../connect/function.php');
if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1)))
{
	$id=$_GET['id'];
	//xóa hình ảnh trong thư mục upload
	$sql="SELECT img,img_thumb FROM tblbaiviet WHERE id={$id}";
	$query_a=mysqli_query($conn,$sql);
	$anhInfo=mysqli_fetch_assoc($query_a);
	unlink('../'.$anhInfo['img']);
	unlink('../'.$anhInfo['img_thumb']);
	$query="DELETE FROM tblbaiviet WHERE id={$id}";
	$result=mysqli_query($conn,$query);
	kt_query($result,$query);		
	header('Location: list_baiviet.php');	
}
else
{
	header('Location: list_baiviet.php');	
}
?>