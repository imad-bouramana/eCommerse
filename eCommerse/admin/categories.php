<?php
    ob_start();
    session_start();
    $tittlepage  = 'categories';
if(isset($_SESSION['username'])){   // redirect to the home page
   	    // tittle page
    include 'initialize.php';
       //manage  members
   	$do = isset($_GET["do"]) ? $_GET["do"] : 'Manage';
      if($do == 'Manage'){          // manage page
       $sort = "ASC";
       $sort_array = array('DESC','ASC');
       if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){
             $sort = $_GET['sort'];
       }
       $stmt = $db->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY Ordering $sort");
       $stmt->execute();
       $cats = $stmt->fetchAll();
       if(! empty($cats)){

  ?> 
        <h1 class="text-center">Manage Categories</h1>
        <div class="container categories">
           <div class="panel panel-default">
             <div class="panel-heading">
              <i class="fa fa-edit"></i>Manage Categories
                 <div class="options pull-right"><i class="fa fa-sort"></i>Order : [
                   <a class="<?php if($sort == 'ASC'){echo 'active';}?>" href="?sort=ASC">ASC</a> |
                   <a  class="<?php if($sort == 'DESC'){echo 'active';}?>" href="?sort=DESC">DESC</a>]
                   <i class="fa fa-eye"></i>
              View : [
                   <span class='active' data-view="Full">Full</span> |
                   <span data-view="Classic">Classic</span>]
                 
                 </div>
             </div>
             <div class="panel-body">
             <?php
               foreach ($cats as $cat) {
              echo '<div class="cat">';
                 echo '<div class="cat-btn">';
                      echo '<a href="categories.php?do=Edit&catid=' . $cat['Id'] . '"class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>';
                      echo '<a href="categories.php?do=Delite&catid=' . $cat['Id']. '" class="btn btn-xs btn-danger confirm"><i class="fa fa-close"></i> Delite</a>';
                 
                 echo '</div>';
                 echo  '<h3>' . $cat['Name'] . '</h3>';
                 echo '<div class="full-view">';
                 
                      echo   '<p>'; 
                          if($cat['Description'] == ''){
                               echo 'No Description Is Found';
                          }else{
                               echo $cat['Description'];
                          } 
                      echo  '</p>';
                          if($cat['Visibility'] == 1){
                               echo '<span class="visibled"><i class="fa fa-eye"></i>Desabled</span>';} 
                          if($cat['Alow_Comments'] == 1){
                               echo '<span class="commented"> <i class="fa fa-close"></i>Comment Desabled</span>';}
                          if($cat['Alow_Ads'] == 1){
                              echo '<span class="advertises"><i class="fa fa-close"></i>Ads Desabled</span>';}

                    // child categories
                  $childcategory = getAllFrom("*", "categories",  "WHERE parent = {$cat['Id']}", "", "Id", "ASC");
   
                  if(! empty($childcategory)){
                    echo '<h4 class="child-h">Child Category</h4>';
                    echo '<ul class="list-unstyled child-cat">';
                       foreach ($childcategory as $child) {
                            echo '<li class="delite-child">
                                 <a href="categories.php?do=Edit&catid=' . $child['Id'] . '">'. $child["Name"] . '</a>
                                 <a href="categories.php?do=Delite&catid=' . $child['Id']. '"class="confirm delite"> Delite</a>
                 
                                 </li>';
                            }
                    echo '</ul>';
                   }
                echo '</div>';
                  echo "</div>";
                 
                 echo '<hr>';
            
             }
             ?>
             </div>
           </div>
           <a class="btn btn-primary" href="categories.php?do=Add"><i class="fa fa-edit">Add Categories</i></a>
         </div>
  <?php }else{
             echo '<div class="container">'; 
                 echo '<div class="alert alert-danger">';
                     echo 'There No Member Exist';
                 echo '</div>';
                 echo '<a class="btn btn-primary" href="categories.php?do=Add"><i class="fa fa-edit">Add Categories</i></a>';
    
             echo '</div>';
           }  ?>   

<?php }elseif ($do == "Add") {      //page add categories  ?>
         <h1 class="text-center">Add Categories</h1>
         <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="POST">
              <!-- Name -->
              <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Name</label>
               <div class="col-sm-6">
               <input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Name"/>
               </div>
              </div>
              <!-- Description -->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Description</label>
          <div class="col-sm-6">
            <input type="text" name="description" class="password form-control"  placeholder="description" />
             </div>
        </div>
        <!-- ordering -->
       <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Ordering</label>
          <div class="col-sm-6">
            <input type="text" name="order" class="form-control" placeholder="Order"/>
          </div>
        </div>
        <!-- parent -->
       <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Parent?</label>
          <div class="col-sm-6">
            <select name="parent">
              <option value="0">none</option>
              <?php
                $parents =  getAllFrom("*", "categories",  "WHERE parent = 0", "", "Id","DESC");
                  foreach ($parents as $parent ) {
                    echo '<option value="'. $parent['Id'].'">'.$parent['Name'].'</option>';
                  }
              ?>
            </select>
             </div>
        </div>
      
        <!-- visibitity -->
       <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Visible</label>
          <div class="col-sm-6">
            <div>
          <input id="vis-yes" type="radio" name="visibility" value="0" checked />
          <label for="vis-yes">Yes</label>
            </div>
            <div>
          <input id="vis-no" type="radio" name="visibility" value="1" />
          <label for="vis-no">No</label>
            </div>
          </div>
       </div>
       <!-- comments-->
         <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Comments</label>
          <div class="col-sm-6">
            <div>
          <input id="com-yes" type="radio" name="comments" value="0" checked />
          <label for="com-yes">Yes</label>
            </div>
            <div>
          <input id="com-no" type="radio" name="comments" value="1" />
          <label for="com-no">No</label>
            </div>
          </div>
       </div>
       <!-- ads -->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Ads</label>
          <div class="col-sm-6">
            <div>
          <input id="ads-yes" type="radio" name="ads" value="0" checked />
          <label for="ads-yes">Yes</label>
            </div>
            <div>
          <input id="ads-no" type="radio" name="ads" value="1" />
          <label for="ads-no">No</label>
            </div>
          </div>
       </div>
       <!-- button -->
       <div class="form-group form-group-lg">
          <div class="col-sm-offset-2 col-sm-8">
            <input type="submit" value="Add Categories" class="btn btn-success btn-lg" />
          </div>
       </div>
            </form>
         </div>  
    
                           
<?php  } elseif ($do == "Insert"){  // insret page
            if($_SERVER["REQUEST_METHOD"]== 'POST'){
              echo '<h1 class="text-center">Update Categories</h1>';
              echo '<div class="container">';
              $name     = $_POST['name'];
              $descc    = $_POST['description'];
              $order    = $_POST['order'];
              $parent   = $_POST['parent'];
             
              $visible  = $_POST['visibility'];
              $comment  = $_POST['comments'];
              $ads      = $_POST['ads'];
              // chek if categories exist
              $chek = chekitem('Name', 'categories', $name);
                if($chek == 1){
                  $theMsg = '<div class="alert alert-danger">This Categories Is Exist</div>';
                    redirecthome($theMsg, 'back');
                }else{
                    $stmt = $db->prepare('INSERT INTO categories 
                        (Name, Description, parent ,Ordering, Visibility, Alow_Comments, Alow_Ads) 
                        VALUES(:name, :descc, :parent, :order, :visible, :comment, :ads)');
                    $stmt->execute(array(
                      'name'     => $name,
                      'descc'    => $descc,
                      'parent'    => $parent,
                       'order'    => $order,
                      'visible'  => $visible,
                      'comment'  => $comment,
                      'ads'      => $ads));
                   $theMsg =  "<div class='alert alert-success'>" . $stmt->rowcount() . 'Categories insert</div>'; 
                    redirecthome($theMsg, 'back');
                 }
                
            }else{
              echo '<div class="container">';
          $theMsg = '<div class="alert alert-danger">sorry you can browse this page</div>';
                     redirecthome($theMsg);
                echo '</div>';
                 }
             echo '</div>';
                
      }elseif($do == "Edit"){  // edit cat form   
               // if catid is exist , if is numirec , hese value is 0
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
                   // chek all  select from users
         $stmt = $db->prepare("SELECT * FROM categories WHERE Id = ? ");
                   // execute  the select in array
                 $stmt->execute(array($catid));
                   // fitch the data
                $rowcat  =$stmt->fetch();
                   // chek the count
                 $count = $stmt->rowcount();
                  // if the count > 0  show the form
          if($count > 0  ){     ?>
          <h1 class="text-center">Edit Categories</h1>
         <div class="container">
            <form class="form-horizontal" action="?do=Update" method="POST">
              <input type="hidden" name="catid" value="<?php echo $catid ?>" />
              <!-- Name -->
              <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Name</label>
               <div class="col-sm-6">
               <input type="text" name="name" class="form-control" required="required" placeholder="Name" value="<?php echo $rowcat['Name'] ?>" />
               </div>
              </div>
              <!-- Description -->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Description</label>
          <div class="col-sm-6">
            <input type="text" name="description" class="password form-control"  placeholder="description" value="<?php echo $rowcat['Description'] ?>" />
          </div>
        </div>
        <!-- ordering -->
       <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Ordering</label>
          <div class="col-sm-6">
            <input type="text" name="order" class="form-control" placeholder="Order" value="<?php echo $rowcat['Ordering'] ?>" />
          </div>
        </div>
         <!-- parent -->
       <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Parent?<?php echo $rowcat['parent']?></label>
          <div class="col-sm-6">
            <select name="parent">
              <option value="0">none</option>
              <?php
                $parents =  getAllFrom("*", "categories",  "WHERE parent = 0", "", "Id","DESC");
                  foreach ($parents as $parent ) {
                     echo "<option value='". $parent['Id']."'";
                       if($rowcat['parent'] == $parent['Id']){ echo ' selected';}
                   
                     echo ">" .$parent['Name']."</option>";
                  }
              ?>
            </select>
             </div>
        </div>
      
        <!-- visibitity -->
       <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Visible</label>
          <div class="col-sm-6">
            <div>
        <input id="vis-yes" type="radio" name="visibility" value="0" <?php  if($rowcat['Visibility'] == 0){echo 'checked';}?> />
          <label for="vis-yes">Yes</label>
            </div>
            <div>
          <input id="vis-no" type="radio" name="visibility" value="1" <?php  if($rowcat['Visibility'] == 1){echo 'checked';}?> />
          <label for="vis-no">No</label>
            </div>
          </div>
       </div>
       <!-- comments-->
         <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Comments</label>
          <div class="col-sm-6">
            <div>
          <input id="com-yes" type="radio" name="comments" value="0"  <?php  if($rowcat['Alow_Comments'] == 0){echo 'checked';}?>/>
          <label for="com-yes">Yes</label>
            </div>
            <div>
          <input id="com-no" type="radio" name="comments" value="1" <?php  if($rowcat['Alow_Comments'] == 1){echo 'checked';}?>/>
          <label for="com-no">No</label>
            </div>
          </div>
       </div>
       <!-- ads -->
       <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Ads</label>
          <div class="col-sm-6">
            <div>
          <input id="ads-yes" type="radio" name="ads" value="0"  <?php  if($rowcat['Alow_Ads'] == 0){echo 'checked';}?>/>
          <label for="ads-yes">Yes</label>
            </div>
            <div>
          <input id="ads-no" type="radio" name="ads" value="1" <?php  if($rowcat['Alow_Ads'] == 1){echo 'checked';}?>/>
          <label for="ads-no">No</label>
            </div>
          </div>
       </div>
       <!-- button -->   
       <div class="form-group form-group-lg">
          <div class="col-sm-offset-2 col-sm-8">
            <input type="submit" value="Edit Categories" class="btn btn-success btn-lg" />
          </div>
       </div>
    </form>
  </div>  
       
     <?php     }else{
                echo '<div class="container">';
                $theMsg = '<div class="alert alert-danger">Error Id</div>';
                redirecthome($theMsg);
                echo '</div>';
              }     
     }elseif($do == "Update"){     // update page  
      echo '<h1 class="text-center">Update Categories</h1>';
      echo '<div class="container">';
           if($_SERVER["REQUEST_METHOD"] == 'POST'){
              $id       = $_POST['catid'];
              $name     = $_POST['name'];
              $desc     = $_POST['description'];
              $order    = $_POST['order'];
              $parent   = $_POST['parent'];
              $visible  = $_POST['visibility'];
              $comment  = $_POST['comments'];
              $ads      = $_POST['ads'];
          $stmt = $db->prepare('UPDATE categories SET Name = ?, Description = ?, Ordering = ?, parent = ?, Visibility = ?, Alow_Comments = ?, Alow_Ads = ? WHERE  Id = ?');
          $stmt->execute(array($name, $desc, $order, $parent, $visible, $comment, $ads, $id));
                // rederect message
          $theMsg =  "<div class='alert alert-success'>" . $stmt->rowcount() . 'Categories Update</div>';
          redirecthome($theMsg, 'back'); 
           }else{
             $theMsg = '<div class="alert alert-danger">Sorry You Can Enter</div>';
             redirecthome($theMsg); 
               }
      echo '</div>';
     }elseif($do == 'Delite'){     //delite page
      echo '<h1 class="text-center">Delite Categories</h1>';
      echo '<div class="container">';
             // if userid is exist , if is numirec , hese value is 0
          $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;
             // chek all  select from users
          $chek = chekitem('Id', 'categories', $catid);
         if( $chek > 0  ){
              $stmt = $db->prepare("DELETE  FROM categories WHERE Id = :zId");
              $stmt->bindParam(':zId', $catid);
              $stmt->execute();
             
             $theMsg = "<div class='alert alert-success'>" . $stmt->rowcount() . 'Categories Deleted</div>'; 
             redirecthome($theMsg, 'back');
              }else{
           $theMsg = '<div class="alert alert-danger">Error Members</div>';
            redirecthome($theMsg);
                   
         }
      echo '</div>';

     }                             //includ footer
      include  $inctem . "footer.php";  
}else{
   	header('location: index.php');  // redirect to the home page
    exit();
     }	 
    ob_end_flush();
?>