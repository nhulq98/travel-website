<?php
define('BASE_URL', 'http://localhost:8080/xaydungweb/');

//Kiểm tra xem kết quả trả về có đúng hay không
function kt_query($result,$query)
{
	global $conn;
	if(!$result)
	{
		die("Query {$query} \n<br/> MYSQL Error:".mysqli_error($conn));
	}	
}
// Hàm đệ quy lấy ra các danh mục
function show_categories($parent_id = "0",$insert_text = "-")// gán =0 có nghĩa là nó sẽ hthi danh mục cha trước
{
    // để lấy biến $conn ở file myconnect
    global $conn;
    // lấy all các thông tin trong bảng quanlydanhmuc dựa theo parent_id sắp xếp theo parent_id và tăng dần
    $query_dq="SELECT * FROM tbldanhmucbaiviet WHERE parent_id = ".$parent_id." ORDER BY parent_id DESC";
    $result_categories = mysqli_query($conn, $query_dq);
    // đệ quy lặp all các thèn danh mục con
    while($category = mysqli_fetch_array($result_categories, MYSQLI_ASSOC))
    {
        
        echo ("<option value='".$category["id"]."'>".$insert_text.$category['danhmucbaiviet']."</option>");
        // để in ra các danh mục con
        show_categories($category["id"], $insert_text."-");
    } 
    return true;
}
// hàm hiển thị các danh mục vừa lấy ra ở trên
function selectCtrl($name, $class)
{
    global $conn;
    echo "<select name = '".$name."' class = '".$class."'>";
    echo "<option value='0'>Danh mục cha</option>";
    show_categories();
    echo "</select>";
}

function LocDau($str)
{
	$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|�� �|ặ|ẳ|ẵ|ắ)/", 'a', $str);
	$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
	$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
	$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
	$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
	$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
	$str = preg_replace("/(đ)/", 'd', $str);
	$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|�� �|Ặ|Ẳ|Ẵ)/", 'A', $str);
	$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
	$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
	$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ợ|Ở|Ớ|Ỡ)/", 'O', $str);
	$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
	$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
	$str = preg_replace("/(Đ)/", 'D', $str);
	$str = preg_replace("/( |'|,|\||\.|\"|\?|\/|\%|–|!)/", '-', $str);
	$str = preg_replace("/(\()/", '-', $str);
	$str = preg_replace("/(\))/", '-', $str);
	$str = preg_replace("/(&)/", '-', $str);
    $str = preg_replace("/“/", '', $str);
    $str = preg_replace("/”/", '', $str);  
    $str = preg_replace("/;/", '', $str);  
	return strtolower($str);
}
function menu_dacap($parent_id=0,$dem=0)
{
	global $conn;
	$cate_child=array();
	$query_dq_mn="SELECT * FROM tbldanhmucbaiviet WHERE parent_id=".$parent_id." AND menu=1 ORDER BY ordernum DESC";
	$categories_mn=mysqli_query($conn,$query_dq_mn);
	while ($category_mn=mysqli_fetch_array($categories_mn,MYSQLI_ASSOC))
	{
		$cate_child[]=$category_mn;	
	}	
	if($cate_child)
	{
		if($dem==0)
		{
			echo "<ul class='sf-menu' id='example'>";
			echo "<li><a href='".BASE_URL."'>Trang chủ</a></li>";
		}		
		else
		{
			echo "<ul>";
		}
		foreach ($cate_child as $key => $item) 
		{	
			echo "<li><a href='tinbycategory.php?dm=".$item['id']."'>".$item['danhmucbaiviet']."</a>";			
			//echo "<li><a href='dm/".$item['id']."-".LocDau($item['danhmucbaiviet']).".html'>".$item['danhmucbaiviet']."</a>";
			menu_dacap($item['id'],++$dem);			
			echo "</li>";			
		}
		// đếm tới cuối mảng thì thêm 2 cái mục này vào
		
		if(count($cate_child)==$dem)
		{	
			//echo "<li><a href='admin/login.php'>Đăng Nhập</a></li>";		
			//echo "<li><a href=''>Liên hệ</a></li>";
		}	
		echo "</ul>";
	}
}
?>