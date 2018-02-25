<?php
    ob_start();
    session_start();
    $tittlepage  = 'items';
if(isset($_SESSION['username'])){   // redirect to the home page
   	    // tittle page
    include 'initialize.php';
       //manage  members
   	   $do = isset($_GET["do"]) ? $_GET["do"] : 'Manage';
     if($do == 'Manage'){          // manage page 
          $stmt = $db->prepare("SELECT items.*, categories.Name AS cat_name, users.username
                                FROM items 
                                INNER JOIN categories 
                                ON 
                                      categories.Id = items.Cat_Id
                                INNER JOIN users
                                ON 
                                      users.userID = items.Member_Id
                                ORDER BY Item_Id DESC");
           $stmt->execute();
           $items = $stmt->fetchAll();
           if(!empty($items)){
         ?>
       <h1 class="text-center">Manage  Items</h1>
       <div class="container">  
      <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
           <tr>
             <td>#ID</td>
             <td>name</td>
             <td>dascription</td>
             <td>price</td>
             <td>Items date</td>
             <td>cat_name</td>
             <td>username</td>
             <td>control</td>
           </tr>
   <?php
           foreach ($items as $item) {
             echo "<tr>";
                echo '<td>' . $item["Item_Id"] . '</td>';
                echo '<td>' . $item["Name"] . '</td>';
                echo '<td>' . $item["Description"] . '</td>';
                echo '<td>' . $item["Price"] . '</td>';
                echo '<td>' . $item["Add_Date"] . '</td>';
                echo '<td>' . $item["cat_name"] . '</td>';
                echo '<td>' . $item["username"] . '</td>';
                echo "<td>
                        <a href='items.php?do=Edit&itemid=" . $item['Item_Id'] . 
                        " 'class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                        <a href='items.php?do=Delite&itemid=" . $item['Item_Id'] . 
                        " 'class='btn btn-danger confirm'><i class='fa fa-close'></i>Delite</a>";
                     if($item['Aprouve'] == 0){
                    echo   "<a href='items.php?do=Aprouve&itemid=". $item['Item_Id'] . 
                    " 'class='btn btn-info regestr'><i class='fa fa-check'></i>Aprouved</a>";
                    
                  }
                    
                     
                     "</td>";
             echo "</tr>";
           }
     ?>
        
        </table>
      </div>
      <a href="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>New Items</a>
       </div>    
    <?php }else{
             echo '<div class="container">'; 
                 echo '<div class="alert alert-danger">';
                     echo 'There No Items Exist';
                 echo '</div>';
                 echo '<a href="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>New Items</a>
                           </div>';    
   
             echo '</div>';
           }  ?>   

<?php   }elseif ($do == "Add") {      //page add member ?>
          <h1 class="text-center">Add Items</h1>
          <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="POST">
              <!-- Name -->
              <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Name</label>
               <div class="col-sm-6">
               <input type="text" 
                      name="name" 
                      class="form-control" 
                      autocomplete="off" 
                       required
                      placeholder="Name Items"/>
               </div>
              </div>
               <!-- Description -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-6">
                  <input type="text" name="description" 
                         class="password form-control" 
                          required
                         placeholder="description items" />
                   </div>
              </div>
              <!-- Price -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Price</label>
                <div class="col-sm-6">
                  <input type="text" name="price" 
                         class="password form-control"
                          required
                         placeholder="Price items" />
                   </div>
              </div>
              <!-- Country -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Country</label>
                <div class="col-sm-6">
                  <input type="text" name="country" 
                        class="password form-control"
                       required
                        placeholder="Country items" />
                   </div>
              </div>
                   <!-- Status -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Status</label>
                <div class="col-sm-6">
                  <select name="status" required>
                    <option value=''>...</option>
                    <option value='1'>New</option>
                    <option value='2'>Like New</option>
                    <option value='3'>Occasion</option>
                    <option value='4'>Old</option>
                  </select>
                </div>
              </div>
               <!-- Members -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Members</label>
                <div class="col-sm-6">
                  <select name="member" required>
                    <option value=''>...</option>
                    <?php 
                      $getusers =  getAllFrom("*", "users",  "", "", "userID");
   
                        // $stmt2 = $db->prepare("SELECT * FROM users");
                        // $stmt2->execute();
                        // $counts = $stmt2->fetchAll();
                         foreach ($getusers as $count) {
                             echo '<option value="'.$count['userID'] .'">' . $count['username'] . '</option>';
                         }                      
                      ?>
                  </select>   
                </div>
              </div>
               <!-- Categories -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Categories</label>
                <div class="col-sm-6">
                  <select name="cat" required>
                    <option value=''>...</option>
                      <?php 
                       $getcats =  getAllFrom("*", "categories",  "WHERE parent = 0", "", "Id");
   
                         //$stmt = $db->prepare("SELECT * FROM categories");
                         //$stmt->execute();
                         //$cats = $stmt->fetchAll();
                         foreach ($getcats as $cat) {
                             echo '<option value="'. $cat['Id'] .'">' . $cat['Name'] . '</option>';
                              $childcats =  getAllFrom("*", "categories",  "WHERE parent = {$cat['Id']}", "", "Id");
                             foreach ($childcats as $child) {
                                 echo '<option value="'. $child['Id'] .'">==>' . $child['Name'] . '</option>';
                            
                             }
                         }                      
                      ?>
                  </select>
                </div>
              </div>
              <!-- Tags -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Tags</label>
                <div class="col-sm-6">
                  <input type="text" name="tags" 
                        class="password form-control"
                        placeholder="Ceparete with (,)" />
                </div>
              </div>
            
                    <!-- button -->
              <div class="form-group form-group-lg">
                <div class="col-sm-offset-2 col-sm-8">
                  <input type="submit" value="Add Items" 
                  class="btn btn-primary btn-sm" />
                </div>
              </div>
            </form>
         </div>  
          <?php                        
     } elseif ($do == "Insert"){  // insret page
          if($_SERVER["REQUEST_METHOD"]== 'POST'){
            echo '<h1 class="text-center">Insert Items</h1>';
            echo '<div class="container">';
              $name        = $_POST['name'];
              $desc        = $_POST['description'];
              $price       = $_POST['price'];
              $country     = $_POST['country'];
              $status      = $_POST['status'];
              $categorie   = $_POST['cat'];
              $member      = $_POST['member'];
              $tags        = $_POST['tags'];
              
                  $errors = array();
                if(empty($name)){$errors[]    = 'name cant be <strong>empty</strong>';}
                if(empty($desc)){$errors[]    = 'description cant be  <strong>empty</strong>';}
                if(empty($price)){$errors[]   = 'price cant be  <strong>empty</strong>'; }
                if(empty($country)){$errors[] = 'country cant be <strong>empty</strong>';}
                if($status == 0){$errors[]    = 'status cant be <strong>empty</strong>';}
                if($categorie == 0){$errors[] = 'categorie cant be <strong>empty</strong>';}
                if($member == 0){$errors[]    = 'member cant be <strong>empty</strong>';}
                
                 foreach($errors as $erro ) {echo  '<div class="alert alert-danger">' . $erro . '</div>'; }
                  
                 if(empty($errors)){
              
                  $stmt = $db->prepare("INSERT INTO items
                                (Name, Description, Price, Country_Made, Status, Add_Date, Cat_Id, Member_Id, tags) 
                                    VALUES(:name, :disc, :price, :country, :status, now(), :cat, :member, :tags)");
                  $stmt->execute(array(
                      'name'    => $name,
                      'disc'    => $desc,
                      'price'   => $price,
                      'country' => $country,
                      'status'  => $status,
                      'cat'     => $categorie,
                      'member'  => $member,
                      'tags'    => $tags
                      
                      ));
                    $theMsg =  "<div class='alert alert-success'>" . $stmt->rowcount() . 'Items insert</div>'; 
                    redirecthome($theMsg, 'back');
               }
           }else{
                     echo '<div class="container">';
                     $theMsg = '<div class="alert alert-danger">sorry you can browse this page</div>';
                     redirecthome($theMsg);
                     echo '</div>';
                }
            echo '</div>'; 

     }elseif($do == "Edit"){       // edit form  
                 // if userid is exist , if is numirec , hese value is 0
                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
                   // chek all  select from users
               
                 $stmt = $db->prepare("SELECT * FROM items WHERE item_Id = ? ");
                // execute  the select in array
                 $stmt->execute(array($itemid));
                   // fitch the data
                 $item  =$stmt->fetch();
                   // chek the count
                 $count = $stmt->rowcount();
                // if the count > 0  show the form
        if($count > 0  ){     ?>
          <h1 class="text-center"><h1 class="text-center">Edit Items</h1>
          <div class="container">
            <form class="form-horizontal" action="?do=Update" method="POST">
              <input type="hidden" name="itemid" value="<?php echo $itemid ?>" />
        
              <!-- Name -->
              <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Name</label>
               <div class="col-sm-6">
               <input type="text" 
                      name="name" 
                      class="form-control" 
                      autocomplete="off" 
                       required
                      placeholder="Name Items"
                      value="<?php echo  $item['Name'] ?>"
                      />
               </div>
              </div>
               <!-- Description -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-6">
                  <input type="text" name="description" 
                         class="password form-control" 
                          required
                         placeholder="description items" 
                         value="<?php echo  $item['Description'] ?>"
                     />
                   </div>
              </div>
              <!-- Price -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Price</label>
                <div class="col-sm-6">
                  <input type="text" name="price" 
                         class="password form-control"
                          required
                         placeholder="Price items"
                         value="<?php echo  $item['Price'] ?>"
                    />
                   </div>
              </div>
              <!-- Country -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Country</label>
                <div class="col-sm-6">
                  <input type="text" name="country" 
                        class="password form-control"
                        required
                        placeholder="Country items" 
                        value="<?php echo  $item['Country_Made'] ?>"
                  />
                   </div>
              </div>
                   <!-- Status -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Status</label>
                <div class="col-sm-6">
                  <select name="status">
                    <option value='1' <?php if($item['Status'] == 1){ echo 'selected';} ?> >New</option>
                    <option value='2' <?php if($item['Status'] == 2){ echo 'selected';} ?> >Like New</option>
                    <option value='3' <?php if($item['Status'] == 3){ echo 'selected';} ?> >Occasion</option>
                    <option value='4' <?php if($item['Status'] == 4){ echo 'selected';} ?> >Old</option>
                  </select>
                </div>
              </div>
               <!-- Members -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Members</label>
                <div class="col-sm-6">
                  <select name="member">
                     <?php 
                        $countusers = getAllFrom("*", "users",  "", "","userID");
                        // $stmt2 = $db->prepare("SELECT * FROM users");
                        // $stmt2->execute();
                         //$counts = $stmt2->fetchAll();
                         foreach ($countusers as $count) {
                             echo '<option value="'. $count['userID'] .'"';  
                             if($item['Member_Id'] == $count['userID']){ echo 'selected';} 
                             echo  '>' .$count['username'] .'</option>';
                         }                      
                      ?>
                  </select>   
                </div>
              </div>
               <!-- Categories -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Categories</label>
                <div class="col-sm-6">
                  <select name="cat">
                      <?php 
                      $countcats = getAllFrom("*", "categories",  "", "","Id");
                        
                        // $stmt = $db->prepare("SELECT * FROM categories");
                        // $stmt->execute();
                         //$cats = $stmt->fetchAll();
                         foreach ($countcats as $cat) {
                             echo '<option value="'. $cat['Id'] .'"';
                             if($item['Cat_Id'] == $cat['Id']){ echo 'selected';} 
                             
                            echo  '>'. $cat['Name'] . '</option>';
                         }                      
                      ?>
                  </select>
                </div>
              </div>
                <!-- Tags -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Tags</label>
                <div class="col-sm-6">
                  <input type="text" name="tags" 
                        class="password form-control"
                        placeholder="Ceparete with (,)" 
                        value="<?php echo  $item['tags'] ?>" />
               
                </div>
              </div>
            
                    <!-- button -->
              <div class="form-group form-group-lg">
                <div class="col-sm-offset-2 col-sm-8">
                  <input type="submit" value="Add Items" 
                  class="btn btn-primary btn-sm" />
                </div>
              </div>
            </form>
            <!--   -->
 <?php        $stmt = $db->prepare("SELECT comments.*, users.username AS userName
                                  FROM comments
                                   INNER JOIN users
                                  ON  comments.user_Id   = users.userid
                                  WHERE item_Id = ?");
           $stmt->execute(array($itemid));
           $rows = $stmt->fetchAll();

           if(! empty($rows)){
     ?>
       <h1 class="text-center">Manage <?php echo $item["Name"]?>  comments</h1>
      <div class="table-responsive">
        <table class="main-table text-center table table-bordered">
           <tr>
         
             <td>comments</td>
             <td>user name</td>
             <td>comments date</td>
             <td>control</td>
           </tr>
   <?php
           foreach ($rows as $row) {
             echo "<tr>";
                echo '<td>' . $row["c_ID"] . '</td>';
                echo '<td>' . $row["userName"] . '</td>';
                echo '<td>' . $row["c_Date"] . '</td>';
                echo "<td>
                        <a href='comments.php?do=Edit&comid=" . $row['c_ID'] . " 'class='btn btn-success'><i class='fa fa-plus'></i>Edit</a>
                        <a href='comments.php?do=Delite&comid=" . $row['c_ID'] . " 'class='btn btn-danger confirm'><i class='fa fa-edit'></i>Delite</a>";
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
<?php }  ?>

            <!--  -->
         </div>  


    <?php 
                // else show error
               }else{
                echo '<div class="container">';
                $theMsg = '<div class="alert alert-danger">Error Id</div>';
                redirecthome($theMsg);
              echo '</div>';
                    }
     
     }elseif($do == "Update"){     // update page  
         if($_SERVER["REQUEST_METHOD"]== 'POST'){
            echo '<h1 class="text-center">Update Items</h1>';
            echo '<div class="container">';
              $id          = $_POST['itemid'];
              $name        = $_POST['name'];
              $desc        = $_POST['description'];
              $price       = $_POST['price'];
              $country     = $_POST['country'];
              $status      = $_POST['status'];
              $categorie   = $_POST['cat'];
              $member      = $_POST['member'];
              $tags        = $_POST['tags'];
              
                  $errors = array();
                if(empty($name)){$errors[]    = 'name cant be <strong>empty</strong>';}
                if(empty($desc)){$errors[]    = 'description cant be  <strong>empty</strong>';}
                if(empty($price)){$errors[]   = 'price cant be  <strong>empty</strong>'; }
                if(empty($country)){$errors[] = 'country cant be <strong>empty</strong>';}
                if($status == 0){$errors[]    = 'status cant be <strong>empty</strong>';}
                if($categorie == 0){$errors[] = 'categorie cant be <strong>empty</strong>';}
                if($member == 0){$errors[]    = 'member cant be <strong>empty</strong>';}
                
                 foreach($errors as $erro ) {echo  '<div class="alert alert-danger">' . $erro . '</div>'; }
                  
                 if(empty($errors)){
              
                  $stmt = $db->prepare("UPDATE  items SET
                                Name = ?, Description = ?, Price = ?, 
                                  Country_Made = ?,
                                 Status = ?, Cat_Id = ?, Member_Id= ?,
                                 tags = ?
                                 WHERE item_Id = ?"); 
                                
                                
                  $stmt->execute(array($name, $desc, $price, $country, $status, $categorie, $member, $tags, $id));
                
                   
                    $theMsg =  "<div class='alert alert-success'>" . $stmt->rowcount() . 'Items Update</div>'; 
                    redirecthome($theMsg, 'back');
                 }
           }else{
                     echo '<div class="container">';
                     $theMsg = '<div class="alert alert-danger">sorry you can browse this page</div>';
                     redirecthome($theMsg);
                     echo '</div>';
                }
            echo '</div>'; 

     }elseif($do == 'Delite'){     //delite page
         echo '<h1 class="text-center">Delite Items</h1>';
         echo '<div class="container">';
               // if itemid is exist , if is numirec , hese value is 0
          $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
             // chek all  select from users
          $chek = chekitem('item_Id', 'items', $itemid);
            // if the count > 0  show the form
        if( $chek > 0  ){
              $stmt = $db->prepare("DELETE  FROM items WHERE item_Id = :zitem");
              $stmt->bindParam(':zitem', $itemid);
              $stmt->execute();
             
             $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'Record Deleted</div>'; 
             redirecthome($theMsg, 'back');
                   
                
         }else{
           $theMsg = '<div class="alert alert-danger">Error Members</div>';
            redirecthome($theMsg);
                   
         }
      echo '</div>';

     }elseif ($do == 'Aprouve') {  //activate page members
      echo '<h1 class="text-center">Aprouve Item</h1>';
      echo '<div class="container">';
             // if userid is exist , if is numirec , hese value is 0
          $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;
             // chek all  select from users
          $chek = chekitem('Item_Id', 'items', $itemid);

          if( $chek > 0  ){
              $stmt = $db->prepare("UPDATE items SET  Aprouve = 1 WHERE Item_Id = ?");
              $stmt->execute(array($itemid));
             
             $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'Item Aprouved</div>'; 
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