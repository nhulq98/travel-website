<?php error_reporting(0); ?>
<?php include('includes/header.php'); ?>
<style type="text/css">
    .required {
        color: red;
    }
</style>
<div id="page-wrapper">

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php 
				include('../connect/images_helper.php');
				include('../connect/function.php');
				include('../connect/myconnect.php');
				//Kiểm tra ID có phải là kiểu số không
				if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
						$id = $_GET['id'];
					} else {
						header('Location: list_baiviet.php');
						exit();
					}
				/*if ($_SERVER['REQUEST_METHOD'] == 'POST') {
						$errors = array();
						if ($_POST['parent'] == 0) {
								$parent_id = 0;
							} else {
								$parent_id = $_POST['parent'];
							}
						if (empty($_POST['title'])) {
								$errors[] = 'title';
							} else {
								$title = $_POST['title'];
							}
						$tomtat = $_POST['tomtat'];
						$noidung = $_POST['noidung'];
						if (empty($_POST['ordernum'])) {
								$ordernum = 0;
							} else {
								$ordernum = $_POST['ordernum'];
							}
						$status = $_POST['status'];
						if (empty($errors)) {
								if ($_FILES['img']['size'] == '') {
										$link_img = $_POST['anh_hi'];
										$thumb = $_POST['anhthumb_hi'];
									} else {
										//upload hình ảnh
										if (
											($_FILES['img']['type'] != "image/gif")
											&& ($_FILES['img']['type'] != "image/png")
											&& ($_FILES['img']['type'] != "image/jpeg")
											&& ($_FILES['img']['type'] != "image/jpg")
										) {
											$message = "File không đúng định dạng";
										} elseif ($_FILES['img']['size'] > 1000000) {
											$message = "Kích thước phải nhỏ hơn 1MB";
										} elseif ($_FILES['img']['size'] == '') {
											$message = "Bạn chưa chọn file ảnh";
										} else {
											$img = $_FILES['img']['name'];
											$link_img = 'upload/' . $img;
											move_uploaded_file($_FILES['img']['tmp_name'], "../upload/" . $img);
											//Xử lý Resize, Crop hình anh
											$temp = explode('.', $img);
											if ($temp[1] == 'jpeg' or $temp[1] == 'JPEG') {
												$temp[1] = 'jpg';
											}
											$temp[1] = strtolower($temp[1]);
											$thumb = 'upload/resized/' . $temp[0] . '_thumb' . '.' . $temp[1];
											$imageThumb = new Image('../' . $link_img);
											//Resize anh						
											if ($imageThumb->getWidth() > 700) {
												$imageThumb->resize(700, 'resize');
											}
											//$imageThumb->resize(1280, 467,'crop');
											$imageThumb->save($temp[0] . '_thumb', '../upload/resized');
											}
										//xoa anh trong thu muc 
										$sql = "SELECT img,img_thumb FROM tblbaiviet WHERE id={$id}";
										$query_a = mysqli_query($conn, $sql);
										$anhInfo = mysqli_fetch_assoc($query_a);
										unlink('../' . $anhInfo['img']);
										unlink('../' . $anhInfo['img_thumb']);
									}
								$ngaydang_ht = explode("/", $_POST['ngaydang']);
								$ngaydang_up = $ngaydang_ht[2] . '-' . $ngaydang_ht[0] . '-' . $ngaydang_ht[1];
								$giodang_up = $_POST['giodang'];
								//update vao trong db
								$query = "UPDATE tblbaiviet
							SET danhmucbaiviet=$parent_id,
								title='{$title}',
								tomtat='{$tomtat}',
								noidung='{$noidung}',
								img='{$link_img}',
								img_thumb='{$thumb}',
								ngaydang='{$ngaydang_up}',
								giodang='{$giodang_up}',
								ordernum={$ordernum},
								status={$status}
							WHERE id={$id} ";
								$results = mysqli_query($conn, $query);
								kt_query($results, $query);
								if (mysqli_affected_rows($conn) == 1) {
										echo "<p style='color:green;'>Sửa thành công</p>";
									} else {
										echo "<p style='required'>Bạn chưa sửa gì</p>";
									}
							} else {
								$message = "<p class='required'>Bạn hãy nhập đầy đủ thông tin</p>";
							}
					}
				$query_id = "SELECT * FROM tblbaiviet WHERE id={$id}";
				$result_id = mysqli_query($conn, $query_id);
				kt_query($result_id, $query_id);
				//Kiểm tra xem ID có tồn tại không
				if (mysqli_num_rows($result_id) == 1) {
						list($danhmucbaiviet, $title, $tomtat, $noidung, $img, $img_thumb, $ngaydang, $giodang, $ordernum, $status) = mysqli_fetch_array($result_id, MYSQLI_NUM);
					} else {
						$message = "<p class='required'>ID bài viết không tồn tại</p>";
					}
				?>
				*/
                <form name="frmbaiviet" method="POST" enctype="multipart/form-data">
                    /*<?php 
					if (isset($message)) {
							echo $message;
						}
					?> */
                    <h3>Edit bài viết</h3>
                    <div class="form-group">
                        <label style="display:block;">Danh mục bài viết</label>
                        <?php selectCtrl_e($danhmucbaiviet, 'parent', 'forFormdim'); ?>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="<?php if (isset($title)) {
																	echo $title;
																} ?>" class="form-control" placeholder="Title">
                        <?php 
						if (isset($errors) && in_array('title', $errors)) {
								echo "<p class='required'>Bạn chưa nhập tiêu đề</p>";
							}
						?>
                    </div>
                    <div class="form-group">
                        <label style="display:block;">Tóm tắt</label>
                        <textarea name="tomtat" style="Width:100%;height:150px;"><?php if (isset($tomtat)) {
																						echo $tomtat;
																					} ?></textarea>
                    </div>
                    <div class="form-group">
                        <label style="display:block;">Nội dung</label>
                        <textarea id="noidung" name="noidung" style="width:100%;height:150px;"><?php if (isset($noidung)) {
																									echo $noidung;
																								} ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Ảnh đại diện</label>
                        <input type="file" name="img" value="">
                        <p><img width="100" src="../<?php echo $img; ?>"></p>
                        <input type="hidden" name="anh_hi" value="<?php echo $img; ?>">
                        <input type="hidden" name="anhthumb_hi" value="<?php echo $img_thumb; ?>">
                    </div>
                    <div class="form-group">
                        <label>Ngày đăng</label>
                        <?php 
						if (isset($ngaydang)) {
								$ngaydang_cu = explode('-', $ngaydang);
								$ngaydang_cu_m = $ngaydang_cu[1] . '/' . $ngaydang_cu[2] . '/' . $ngaydang_cu[0];
							}
						?>
                        <input type="text" value="<?php echo $ngaydang_cu_m; ?>" name="ngaydang" id="ngaydang_edit" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Giờ đăng</label>
                        <?php 
						date_default_timezone_set('Asia/Ho_Chi_Minh');
						$today = date('g:i A');
						?>
                        <input type="text" name="giodang" value="<?php if (isset($giodang)) {
																		echo $giodang;
																	} ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Thứ tự</label>
                        <input type="text" name="ordernum" value="<?php if (isset($ordernum)) {
																		echo $ordernum;
																	} ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label style="display:block;">Trạng thái</label>
                        <?php 
						if (isset($status) == 1) {
								?>
                        <label class="radio-inline"><input checked="checked" type="radio" name="status" value="1">Hiện thị</label>
                        <label class="radio-inline"><input type="radio" name="status" value="0">Không hiện thị</label>
                        <?php 
					} else {
						?>
                        <label class="radio-inline">
                            <input type="radio" name="status" value="1">Hiện thị
                        </label>
                        <label class="radio-inline">
                            <input checked="checked" type="radio" name="status" value="0">Không hiện thị
                        </label>
                        <?php	
					}
				?>
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Sửa">
                </form>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?> 