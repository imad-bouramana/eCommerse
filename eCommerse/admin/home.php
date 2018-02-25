<?php
     ob_start();   //function clean error
    session_start();

   if(isset($_SESSION['username'])){   // redirect to the home page
   	$tittlepage = 'home';
     include 'initialize.php'; 
     // function latest items
    $Lmember  = 6;    // number of last member
    $themember = (latestItems('*', 'users', 'userID', $Lmember));
    $Litems  = 6;    // number of last items
    $theitems = (latestItems('*', 'items', 'Item_Id', $Litems));
    $num_comment  = 6;
    
   ?>
     <!--start home page-->
    <div class="container text-center item-block">
       <h1>Dashbord</h1>
       <div class="row">
         <div class="col-md-3">
            <div class="items item1">
              <i class="fa fa-comments-o"></i>
               <div class="info">
               Totale Members
               <span><a href="members.php"><?php echo numberItems('userID', 'users') ?></a></span>
               </div>
            </div>
         </div>
         <div class="col-md-3">
            <div class="items item2">
              <i class="fa fa-refresh"></i>
               <div class="info">
                     Pending Members
                    <span><a href="members.php?do=Manage&page=pending">
                     <?php echo chekitem('RegStatus', 'users', '0')?>
                   </a></span>
                </div>
            </div>
         </div>
         <div class="col-md-3">
            <div class="items item3">
              <i class="fa fa-pencil-square-o"></i>
               <div class="info">
                Totale Items
                <span><a href="items.php"><?php echo numberItems('item_Id', 'items') ?></a></span>
              </div>
            </div>
         </div>
         <div class="col-md-3">
            <div class="items item4">
             <i class="fa fa-gavel"></i>
              <div class="info">
                  Totale Comments
                <span><a href="comments.php"><?php echo numberItems('c_ID', 'comments') ?></a></span>
               
               </div>
            </div>
         </div>
       </div>
    </div>
    <!-- start items --> 
    <div class="container panel-block">
       <div class="row">
         <div class="col-sm-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                <div class="inc_list  pull-right">
                     <i class="fa fa-plus"></i>
                </div>
                <i class="fa fa-database"></i>
                  Latest <?php echo $Lmember ?> Regester Users
              </div>
              <div class="panel-body">
                <ul class="list-unstyled list-pull">
            <?php 
             foreach ($themember as $latest) {
                echo  '<li>';
                  echo  $latest["username"];
                  echo '<a href="members.php?do=Edit&userid=' . $latest["userID"] . '">';
                     echo '<span class="btn btn-success pull-right"><i class="fa fa-edit">Edit</i></span>';
                  echo '</a>';
                  if($latest['RegStatus'] == 0){
                  echo "<a href='members.php?do=Activate&userid=". $latest['userID'] . 
                  " 'class='btn btn-info regestr pull-right'><i class='fa fa-edit'></i>Confirm</a>";
                   } 
                echo '</li>';
              }
            ?>
                </ul>
              </div>
            </div>
         </div>
          <div class="col-sm-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                <div class="inc_list  pull-right">
                     <i class="fa fa-plus "></i>
                </div>
                  <i class="fa fa-registered"></i>
                Letest <?php echo  $Litems ?> Items Regestred
              </div>
              <div class="panel-body">
                <ul class="list-unstyled list-pull">
            <?php 
            if(! empty($theitems)){
             foreach ($theitems as $latestitems) {
                echo  '<li>';
                  echo  $latestitems["Name"];
                  echo '<a href="items.php?do=Edit&itemid=' . $latestitems["Item_Id"] . '">';
                     echo '<span class="btn btn-success pull-right"><i class="fa fa-edit">Edit</i></span>';
                  echo '</a>';
                  if($latestitems['Aprouve'] == 0){
                  echo "<a href='items.php?do=Aprouve&itemid=". $latestitems['Item_Id'] . " 'class='btn btn-info regestr pull-right'><i class='fa fa-edit'></i>Confirm</a>";
                   } 
                echo '</li>';
                  }
            }else{
                  echo '<div class="alert alert-danger">';
                    echo 'There No Items Exist';
                  echo '</div>';
           }  
            ?></ul>
              </div>
            </div>
         </div>
         <!-- start comments -->
          <div class="col-sm-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                <div class="inc_list  pull-right">
                     <i class="fa fa-plus"></i>
                </div>
                  <i class="fa fa-comments-o"></i>
                Letest <?php echo $num_comment ?> Comments
              </div>
              <div class="panel-body">
                <ul class="list-unstyled list-pull">
            <?php 
              $stmt = $db->prepare("SELECT comments.*, users.username AS userName
                                  FROM comments
                                   INNER JOIN users
                                  ON  comments.user_Id   = users.userid LIMIT 6");
           $stmt->execute();
           $rows = $stmt->fetchAll();
           if(! empty($rows)){

             foreach ($rows as $row) {
                echo  '<div class="comment-box">';
                  echo '<span>' . $row["userName"] . '</span>';
                  echo '<div class="cent">';
                  echo '<p>' . $row["Comment"]  . '</p>';
                  echo '</div>';
                      echo    "<a href='comments.php?do=Edit&comid="
                         . $row['c_ID'] . " 'class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>";
                     echo    "<a href='comments.php?do=Delite&comid="
                         . $row['c_ID'] . " 'class='btn btn-danger confirm'><i class='fa fa-close'></i>Delite</a>";
                      if($row['Status'] == 0){
                      echo   "<a href='comments.php?do=Aprouve&comid="
                         . $row['c_ID'] . " 'class='btn btn-info regestr'><i class='fa fa-check'></i>Aprouve</a>";
                         } 
                echo '</div>';
              }
            }else{
              echo '<div class="alert alert-danger">';
                echo 'no comment';
              echo '</div>';
            }
            ?>
              </ul>
              </div>
            </div>
         </div>
     
       </div>
    </div>
   	 <!--end home page-->
    
<?php 
    include  $inctem . "footer.php";
   }else{
   	header('location: index.php');  // redirect to the home page
   }
   exit();
  ob_end_flush();
   ?>