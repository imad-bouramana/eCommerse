<?php
    ob_start();
    session_start();
    $tittlepage  = 'members';
   if(isset($_SESSION['username'])){   // redirect to the home page
   	    // tittle page
       include 'initialize.php';
       //manage  members
   	    $do = isset($_GET["do"]) ? $_GET["do"] : 'Manage';
       
       // chek if îmad = manage
       if($do == 'Manage'){  // manage page 
             $query = '';
             if(isset($_GET['page']) && $_GET['page'] == 'pending'){
              $query = 'AND RegStatus = 0';
             } 
          
           $stmt = $db->prepare("SELECT * FROM users WHERE groupID != 1 $query ORDER BY userID DESC");
           $stmt->execute();
           $rows = $stmt->fetchAll();
           if(! empty($rows)){
     ?>
       <h1 class="text-center">Manage  Members</h1>
       <div class="container">  
      <div class="table-responsive">
        <table class="main-table text-center table table-bordered table-hover table-condensed table-striped">
           <tr>
             <td>#ID</td>
             <td>Avatar</td>
             <td>username</td>
             <td>email</td>
             <td>fullname</td>
             <td>register date</td>
             <td>control</td>
           </tr>
   <?php
           foreach ($rows as $row) {
             echo "<tr>";
                echo '<td>' . $row["userID"] . '</td>';
                echo '<td>'; 
                if(empty($row['avatar'])){
                  echo "<img src='layout/images/imad.jpg' alt='img' >";
                } else{
                  echo "<img src='layout/images/". $row['avatar'] . " 'alt='img' >";
                }
                echo '</td>';

                echo '<td>' . $row["username"] . '</td>';
                echo '<td>' . $row["email"] . '</td>';
                echo '<td>' . $row["fullname"] . '</td>';
                echo '<td>' . $row["time"] . '</td>';
                echo "<td>
                        <a href='members.php?do=Edit&userid=" . $row['userID'] . 
                        " 'class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                        <a href='members.php?do=Delite&userid=" . $row['userID'] .
                         " 'class='btn btn-danger confirm'><i class='fa fa-close'></i>Delite</a>";
                  if($row['RegStatus'] == 0){
                echo   "<a href='members.php?do=Activate&userid=". $row['userID'] . 
                " 'class='btn btn-info regestr'><i class='fa fa-check'></i>Confirm</a>";
                    
                  }          
                        "</td>";
             echo "</tr>";
           }
     ?>
        
        </table>
      </div>
      <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>New Members</a>
       </div> 

<?php   }else{
             echo '<div class="container">'; 
                 echo '<div class="alert alert-danger">';
                     echo 'There No Member Exist';
                 echo '</div>';
                 echo '<a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>New Members</a>
                           </div>';
             echo '</div>';
           }  ?>    

 <?php }elseif ($do == "Add") {  //page add members ?>
      
       <h1 class="text-center">Add Members</h1>
       <div class="container">  
     <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
          <!-- usrename -->
       <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Username</label>
          <div class="col-sm-8">
            <input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="add_username"/>
          </div>
       </div>
       <!-- password -->
       <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Password</label>
          <div class="col-sm-8">
            <input type="password" name="password" class="password form-control" autocomplete="new-password" required='required' placeholder="add password" />
            <i class="pass-eye fa fa-eye fa-2x"></i>
          </div>
       </div>
       <!-- email -->
       <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Email</label>
          <div class="col-sm-8">
            <input type="email" name="email" class="form-control" required="required" placeholder="add email"/>
          </div>
       </div>
       <!-- fullname -->
       <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">FullName</label>
          <div class="col-sm-8">
            <input type="text" name="fullname" class="form-control" required="required" placeholder="add fullname"/>
          </div>
       </div>
        <!-- Avatar -->
       <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Avatar :</label>
          <div class="col-sm-8">
            <input type="file" name="avatar" class="form-control" required="required" />
          </div>
       </div>
       <!-- button -->
       <div class="form-group form-group-lg">
          <div class="col-sm-offset-2 col-sm-8">
            <input type="submit" value="add member" class="btn btn-success btn-lg" />
          </div>
       </div>
     </form>
       </div>

   <?php  // insret page
        } elseif ($do == "Insert") {
           if($_SERVER["REQUEST_METHOD"]== 'POST'){
            echo '<h1 class="text-center">Update Members</h1>';
            echo '<div class="container">';
              $username = $_POST['username'];
              $pass     = $_POST['password'];
              $email    = $_POST['email'];
              $fullname = $_POST['fullname'];
              // avatar 
              $avatarname = $_FILES['avatar']['name'];
              $avatartype = $_FILES['avatar']['type'];
              $avatartmp = $_FILES['avatar']['tmp_name'];
              $avatarsize = $_FILES['avatar']['size'];
               // allowed avatar
              $allowedavatar = array('png','jpg','gif','jpeg');
              // avatar extention
              $extentionavatar = strtolower(end(explode('.',$_FILES['avatar']['name'])));
              
              // password treck
              $hashpass  = sha1($_POST['password']);
                // chek empty array
                $errors = array();
                if(empty($username)){$errors[] = 'username cant be <strong>empty</strong>';}
                if(strlen($username) > 15 ){$errors[] = 'username cant be more than<strong> 15 char</strong>';}
                if(strlen($username) < 4 ){$errors[] = 'username cant be less than char<strong> 4 char</strong>'; }
                if(empty($email)){$errors[] = 'email cant be <strong>empty</strong>';}
                if(empty($pass)){$errors[] = 'password cant be <strong>empty</strong>';}
                if(empty($fullname)){$errors[] = 'fullname cant be <strong>empty</strong>';}
                if(! empty($avatarname) && ! in_array($extentionavatar, $allowedavatar)){
                      $errors[] = 'Avatar Extention Is not <strong>Correct</strong>';    }
                 if(empty($avatarname)){
                      $errors[] = 'Avatar  Is  <strong>Required</strong>';    }
                if($avatarsize > 1000000){
                      $errors[] = 'Avatar  Cant be larger than <strong>1MB</strong>';    }
               
                foreach($errors as $erro ) {echo  '<div class="alert alert-danger">' . $erro . '</div>'; }
                //chek the empty errors
                
               if(empty($errors)){
                     $avatar = rand('1', "1000000"). '-'. $avatarname;

                     move_uploaded_file($avatartmp, 'layout/images/' .$avatar);
                // chek if username exist
               $chek = chekitem('username', 'users', $username);
                if($chek == 1){
                    $theMsg = '<div class="alert alert-danger">This Username Is Exist</div>';
                    redirecthome($theMsg, 'back');
                }else{

                  $stmt = $db->prepare('INSERT INTO users 
                                (username, password, email, fullname, RegStatus, time, avatar) 
                                    VALUES(:user, :pass, :email, :full, 1, now(), :avatar)');
                  $stmt->execute(array(
                       'user' => $username,
                       'pass' => $hashpass,
                      'email' => $email,
                      'full' => $fullname,
                        'avatar' => $avatar));
                    $theMsg =  "<div class='alert alert-success'>" . $stmt->rowcount() . 'record insert</div>'; 
                    redirecthome($theMsg, 'back');
                 }
               }

           }else{ 
                     echo '<div class="container">';
                     $theMsg = '<div class="alert alert-danger">sorry you can browse this page</div>';
                     redirecthome($theMsg);
                     echo '</div>'; 
                }
            echo '</div>'; 

         }elseif($do == "Edit"){  // edit form   
                  // if userid is exist , if is numirec , hese value is 0
                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
                   // chek all  select from users
               
                 $stmt = $db->prepare("SELECT * FROM users WHERE userID = ?  LIMIT 1");
                   // execute  the select in array
                 $stmt->execute(array($userid));
                   // fitch the data
                 $row  =$stmt->fetch();
                   // chek the count
                 $count = $stmt->rowcount();
                  // if the count > 0  show the form
              if($count > 0  ){     ?>
    <h1 class="text-center">Edit Members</h1>
    <div class="container">  
     <form class="form-horizontal" action="?do=Update" method="POST">
         <input type="hidden" name="userid" value="<?php echo $userid ?>" />
        <!-- usrename -->
       <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Username</label>
          <div class="col-sm-8">
            <input type="text" name="username" class="form-control" value="<?php echo  $row['username']?>
            
          "autocomplete="off" required="required"/>
          </div>
       </div>
       <!-- password -->
       <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Password</label>
          <div class="col-sm-8">
            <input type="hidden" name="oldpassword" value='<?php echo $row["password"]?>' />
            <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="if no pass the pass is default" />

          </div>
       </div>
       <!-- email -->
       <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Email</label>
          <div class="col-sm-8">
            <input type="email" name="email" class="form-control" value="<?php echo  $row['email']?>"
             required="required"/>
          </div>
       </div>
       <!-- fullname -->
       <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">FullName</label>
          <div class="col-sm-8">
            <input type="text" name="fullname" class="form-control" value="<?php echo  $row['fullname']?>"
             required="required"/>
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
      echo '<h1 class="text-center">Update Members</h1>';
      echo '<div class="container">';
           if($_SERVER["REQUEST_METHOD"] == 'POST'){
              $id       = $_POST["userid"];
              $username = $_POST['username'];
              $email    = $_POST['email'];
              $fullname = $_POST['fullname'];
                // password treck
              $pass   = '';
                if(empty($_POST['newpassword'])){ $pass = $_POST['oldpassword'];
                }else{$pass = sha1($_POST['newpassword']);}
                // chek empty array
                $errors = array();
                if(empty($username)){ $errors[] = 'username cant be <strong>empty</strong>';}
                if(empty($email)){$errors[] = 'email cant be <strong>empty</strong>';}
                if(empty($fullname)){$errors[] = 'fullname cant be <strong>empty</strong>';}
                if(strlen($username) > 15 ){$errors[] = 'usrname cant be more than<strong> 15 char</strong>';}
                if(strlen($username) < 4 ){$errors[] = 'usrname cant be less than char<strong> 4 char</strong>';}
                foreach($errors as $erro ) {echo  '<div class="alert alert-danger">' . $erro . '</div>';}

                //chek the empty errors
                if(empty($errors)){
              $stmt = $db->prepare('UPDATE users SET username = ?, email = ?, fullname = ?, password = ? WHERE userID = ?');
              $stmt->execute(array($username, $email, $fullname, $pass, $id));
                // rederect message
             $theMsg =  "<div class='alert alert-success'>" . $stmt->rowcount() . 'Record Update</div>';
             redirecthome($theMsg, 'back');}
           }else{
            $theMsg = '<div class="alert alert-danger">Sorry You Can Enter</div>';
             redirecthome($theMsg);}
             echo '</div>';
      }elseif($do == 'Delite'){  //delite page
      echo '<h1 class="text-center">Delite Members</h1>';
      echo '<div class="container">';
             // if userid is exist , if is numirec , hese value is 0
          $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;
             // chek all  select from users
          $chek = chekitem('userid', 'users', $userid);

                // if the count > 0  show the form
        if( $chek > 0  ){
              $stmt = $db->prepare("DELETE  FROM users WHERE userID = :zuser");
              $stmt->bindParam(':zuser', $userid);
              $stmt->execute();
             
             $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'Record Deleted</div>'; 
             redirecthome($theMsg, 'back');
                   
                
         }else{
           $theMsg = '<div class="alert alert-danger">Error Members</div>';
            redirecthome($theMsg);
                   
         }
      echo '</div>';

      }elseif ($do == 'Activate') {  //activate page members
      echo '<h1 class="text-center">Delite Members</h1>';
      echo '<div class="container">';
             // if userid is exist , if is numirec , hese value is 0
          $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;
             // chek all  select from users
          $chek = chekitem('userid', 'users', $userid);
         if( $chek > 0  ){
              $stmt = $db->prepare("UPDATE users SET  RegStatus = 1 WHERE userid = ?");
              $stmt->execute(array($userid));
             
             $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'Record Activated</div>'; 
             redirecthome($theMsg);
                   
                
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