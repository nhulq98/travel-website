 <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
 <div class="collapse navbar-collapse navbar-ex1-collapse">
     <ul class="nav navbar-nav side-nav">
         <li style="background:#1b926c;color:#fff;">
             <a href="comment.php" style="color:#fff;"><i class="fa fa-fw fa-dashboard"></i> Quản lý comment</a>
         </li>
         <?php
            $sql_pq = "SELECT * FROM tbluser WHERE id={$_SESSION['id']}";
            $query_pq = mysqli_query($conn, $sql_pq);
            $query_row = mysqli_fetch_assoc($query_pq);
            $dem_pq = 1;

            foreach ($mang as $mang_sidebar) {
                $tach_role = explode(',', $query_row['role']);
                foreach ($tach_role as $tach_role1) {
                    $tach_role2 = explode('-', $tach_role1);
                    foreach ($tach_role2 as $tach_role3) {
                        if ($mang_sidebar['title'] == $tach_role3) {
                            ?>
                         <li>
                             <a href="javascript:;" data-toggle="collapse" data-target="#demo_<?php echo $dem_pq; ?>"><i class="fa fa-fw fa-file"></i> <?php echo $mang_sidebar['title']; ?><i class="fa fa-fw fa-caret-down"></i></a>
                             <ul id="demo_<?php echo $dem_pq; ?>" class="collapse">
                                 <li>
                                     <a href="<?php echo $mang_sidebar['link_themmoi']; ?>">Thêm mới</a>
                                 </li>
                                 <li>
                                     <a href="<?php echo $mang_sidebar['link_list']; ?>">Danh sách</a>
                                 </li>
                             </ul>
                         </li>
                     <?php
                    }
                }
            }
            ?>

             <?php
                $dem_pq++;
            }
            ?>
     </ul>
 </div>