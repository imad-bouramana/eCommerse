<?php
    ob_start();
    session_start();
    $tittlepage  = 'comments';
   if(isset($_SESSION['username'])){   // redirect to the home page
        // tittle page
       include 'initialize.php';
       //manage  members
        $do = isset($_GET["do"]) ? $_GET["do"] : 'Manage';
       
       // chek if îmad = manage
       if($do == 'Manage'){  // manage page 
             
          
           $stmt = $db->prepare("SELECT comments.*, items.Name AS itname, users.username AS userName
                                  FROM comments
                                  INNER JOIN items
                                  ON  comments.item_Id  = items.Item_Id
                                  INNER JOIN users
                                  ON  comments.user_Id   = users.userid
                                  ORDER BY c_ID DESC");
           $stmt->execute();
           $rows = $stmt->fetchAll();
           if(! empty($rows)){
     ?>
       <h1 class="text-center">Manage  comments</h1>
       <div class="container">  
      <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
           <tr>
             <td>#ID</td>
             <td>comments</td>
             <td>item name</td>
             <td>user name</td>
             <td>comments date</td>
             <td>control</td>
           </tr>
   <?php
           foreach ($rows as $row) {
             echo "<tr>";
                echo '<td>' . $row["c_ID"] . '</td>';
                echo '<td>' . $row["Comment"] . '</td>';
                echo '<td>' . $row["itname"] . '</td>';
                echo '<td>' . $row["userName"] . '</td>';
                echo '<td>' . $row["c_Date"] . '</td>';
                echo "<td>
                        <a href='comments.php?do=Edit&comid=" . $row['c_ID'] . 
                        " 'class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                        <a href='comments.php?do=Delite&comid=" . $row['c_ID'] . 
                        " 'class='btn btn-danger confirm'><i class='fa fa-close'></i>Delite</a>";
                  if($row['Status'] == 0){
                echo   "<a href='comments.php?do=Aprouve&comid="
                         . $row['c_ID'] . " 'class='btn btn-info regestr'><i class='fa fa-check'></i>Aprouve</a>";
                    }          
                    "</td>";
             echo "</tr>";
           }
     ?>
        
        </table>
      </div>
       </div> 
  <?php     }else{
             echo '<div class="container">'; 
                 echo '<div class="alert alert-danger">';
                     echo 'no comment';
                 echo '</div>';
             echo '</div>';
           }   

     
         }elseif($do == "Edit"){  // edit form   
                  // if comments is exist , if is numirec , hese value is 0
                $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
                   // chek all  select from users
               
                 $stmt = $db->prepare("SELECT * FROM comments WHERE c_ID = ?");
                   // execute  the select in array
                 $stmt->execute(array($comid));
                   // fitch the data
                 $row  =$stmt->fetch();
                   // chek the count
                 $count = $stmt->rowcount();
                  // if the count > 0  show the form
              if($count > 0  ){     ?>
                  <h1 class="text-center">Edit Members</h1>
                <div class="container">  
                 <form class="form-horizontal" action="?do=Update" method="POST">
                       <input type="hidden" name="comid" value="<?php echo $comid ?>" />
                      <!-- usrename -->
                     <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">comments</label>
                        <div class="col-sm-8">
                           <textarea name="comment" class="form-control">
                             <?php echo $row['Comment'] ?>
                           </textarea>
                        </div>
                     </div>
                      <!-- button -->
                     <div class="form-group form-group-lg">
                     <div class="col-sm-offset-2 col-sm-8">
                       <input type="submit" value="save" class="btn btn-success btn-lg" />
                    </div>
                     </div>
                </form>
               </div> 

   <?php 
                // else show error
               }else{
                echo '<div class="container">';
                $theMsg = '<div class="alert alert-danger">Error Id</div>';
                redirecthome($theMsg);
                echo '</div>';
                    }
     
         }elseif($do == "Update"){  // update page  
      echo '<h1 class="text-center">Update comments</h1>';
      echo '<div class="container">';
           if($_SERVER["REQUEST_METHOD"] == 'POST'){

              $comid       = $_POST["comid"];
              $comment     = $_POST['comment'];
              
              $stmt = $db->prepare('UPDATE comments SET Comment = ? WHERE c_ID = ?');
              $stmt->execute(array($comment, $comid));
                // rederect message
             $theMsg =  "<div class='alert alert-success'>" . $stmt->rowcount() . 'Record Update</div>';
             redirecthome($theMsg, 'back');

           }else{
            $theMsg = '<div class="alert alert-danger">Sorry You Can Enter</div>';
             redirecthome($theMsg);}
             echo '</div>';
      }elseif($do == 'Delite'){  //delite page
      echo '<h1 class="text-center">Delite Comment</h1>';
      echo '<div class="container">';
             // if Comment is exist , if is numirec , hese value is 0
          $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;
             // chek all  select from users
          $chek = chekitem('c_ID', 'comments', $comid);

                // if the count > 0  show the form
        if( $chek > 0  ){
              $stmt = $db->prepare("DELETE  FROM comments WHERE c_ID = :zcom");
              $stmt->bindParam(':zcom', $comid);
              $stmt->execute();
             
             $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'Record Deleted</div>'; 
             redirecthome($theMsg);
                   
                
         }else{
           $theMsg = '<div class="alert alert-danger">Error Members</div>';
            redirecthome($theMsg);
                   
         }
      echo '</div>';

      }elseif ($do == 'Aprouve') {  //activate page comments
      echo '<h1 class="text-center">Delite Members</h1>';
      echo '<div class="container">';
             // if comments is exist , if is numirec , hese value is 0
          $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0 ;
             // chek all  select from users
          $chek = chekitem('c_ID', 'comments', $comid);
         if( $chek > 0  ){
              $stmt = $db->prepare("UPDATE comments SET  Status = 1 WHERE c_ID = ?");
              $stmt->execute(array($comid));
             
             $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'Record Activated</div>'; 
             redirecthome($theMsg, 'back');
                   
                
         }else{
           $theMsg = '<div class="alert alert-danger">Error Members</div>';
           redirecthome($theMsg);    
         }
      echo '</div>';

      }  
          
               //includ footer
      include  $inctem . "footer.php";  
   }else{
    header('location: index.php');  // redirect to the home page
   
   exit();
  }
  ob_end_flush();
  ?>