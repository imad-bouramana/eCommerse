<?php  
  ob_start();
 session_start();
 $tittlepage = "New Add"; // tittle page
  include 'initialize.php'; 
  if(isset($_SESSION['user'])){
  
  if($_SERVER['REQUEST_METHOD'] == 'POST'){

     $formerror = array();
      $name       = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
      $desc       = filter_var($_POST["description"], FILTER_SANITIZE_STRING);
      $price      = filter_var($_POST["price"], FILTER_SANITIZE_NUMBER_INT);
      $country    = filter_var($_POST["country"], FILTER_SANITIZE_STRING);
      $status     = filter_var($_POST["status"], FILTER_SANITIZE_NUMBER_INT);
      $category   = filter_var($_POST["cat"], FILTER_SANITIZE_NUMBER_INT);
      $tags       = filter_var($_POST["tags"], FILTER_SANITIZE_STRING);
      
          if(strlen($name ) < 4){
            $formerror[] = 'The Name must Be More 4 Character';
          }
          if(strlen($desc ) < 10){
            $formerror[] = 'The description must Be More 10 Character';
          }
          if(strlen($country ) < 2){
            $formerror[] = 'The country must Be More 2 Character';
          }
          if(empty($price )){
            $formerror[] = 'The price must Be Not Empty';
          }
          if(empty($status )){
            $formerror[] = 'The status must Be Not Empty';
          }
          if(empty($category )){
            $formerror[] = 'The category must Be Not Empty';
          }


                 if(empty($formerror)){
              
                  $stmt = $db->prepare("INSERT INTO items
                                (Name, Description, Price, Country_Made, Status, Add_Date, Cat_Id, Member_Id, tags) 
                                    VALUES(:name, :disc, :price, :country, :status, now(), :cat, :member, :tags)");
                  $stmt->execute(array(
                      'name'    => $name,
                      'disc'    => $desc,
                      'price'   => $price,
                      'country' => $country,
                      'status'  => $status,
                      'cat'     => $category,
                      'member'  => $_SESSION['getuser'],
                      'tags'    => $tags
                      ));
                   if($stmt){
                       $msgsucces = 'New Item Add';
                   }
               }
    }

?>

<h1 class="text-center"><?php echo $sessionUser ?> Add Item</h1>
<div class="information block">
	<div class="container">
		<div class="panel panel-info">
			<div class="panel-heading">
				Add New Items
			</div>
			<div class="panel-body">
				<div class="row">
			  <div class="col-md-8">
			  <form class="form-horizontal main-form" action="<?php $_SERVER['PHP_SELF']?>" method="POST">
              <!-- Name -->
              <div class="form-group form-group-lg">
               <label class="col-sm-3 control-label">Name</label>
               <div class="col-sm-9">
               <input type="text" 
                      name="name" 
                      pattern='.{4,}'
                      title='Name Must Be More 4 Chars'
           
                      class="form-control new" 
                      autocomplete="off" 
                      required
                      placeholder="Name Items"
                      data-class=".new-name"/>
               </div>
              </div>
               <!-- Description -->
              <div class="form-group form-group-lg">
                <label class="col-sm-3 control-label">Description</label>
                <div class="col-sm-9">
                  <input type="text" name="description" 
                         class="form-control new" 
                         pattern='.{10,}'
                         title='desc Must Be More 10 Chars'
           
                         required
                         placeholder="description items" 
                         data-class=".new-desc"/>
                </div>
              </div>
              <!-- Price -->
              <div class="form-group form-group-lg">
                <label class="col-sm-3 control-label">Price</label>
                <div class="col-sm-9">
                  <input type="text" name="price" 
                         class="form-control new"
                         required
                         placeholder="Price items" 
                         data-class=".new-price"/>
                </div>
              </div>
              <!-- Country -->
              <div class="form-group form-group-lg">
                <label class="col-sm-3 control-label">Country</label>
                <div class="col-sm-9">
                  <input type="text" name="country" 
                         class="password form-control"
                         required
                         placeholder="Country items" />
                </div>
              </div>
                   <!-- Status -->
              <div class="form-group form-group-lg">
                <label class="col-sm-3 control-label">Status</label>
                <div class="col-sm-9">
                  <select name="status" required>
                    <option value=''>...</option>
                    <option value='1'>New</option>
                    <option value='2'>Like New</option>
                    <option value='3'>Occasion</option>
                    <option value='4'>Old</option>
                  </select>
                </div>
              </div>
               <!-- Categories -->
              <div class="form-group form-group-lg">
                <label class="col-sm-3 control-label">Categories</label>
                <div class="col-sm-9">
                  <select name="cat" required>
                    <option value=''>...</option>
                      <?php 
                      $cats = getAllFrom('*','categories', '','', 'Id');
                         //$stmt = $db->prepare("SELECT * FROM categories");
                         //$stmt->execute();
                         //$cats = $stmt->fetchAll();
                         foreach ($cats as $cat) {
                             echo '<option value="'. $cat['Id'] .'">' . $cat['Name'] . '</option>';
                         }                      
                      ?>
                  </select>
                </div>
              </div>
              <!-- Tags -->
              <div class="form-group form-group-lg">
                <label class="col-sm-3 control-label">Tags</label>
                <div class="col-sm-9">
                  <input type="text" name="tags" 
                        class="password form-control"
                        placeholder="Ceparete with (,)" />
                </div>
              </div>
                    <!-- button -->
              <div class="form-group form-group-lg">
                <div class="col-sm-offset-3 col-sm-9">
                  <input type="submit" value="Add Items" 
                  class="btn btn-primary btn-sm" />
                </div>
              </div>
        </form>
	     </div>
				<div class="col-md-4">
					<div class="thumbnail main-thumb">
  	                   <div class="it-price">$
                         <span class="new-price"></span>
                       </div>
  	                   <img src="img.png" class="img-responsive" alt=""/>
  	                   <div class="caption">
  	                      <h3 class="new-name">title</h3>
  	                      <p class="new-desc">Description</p>
  	                   </div>
  	      </div>
				</div>
      </div>
        <!-- start error-->
        <?php
          if(! empty($formerror)){
              foreach ($formerror as $error) {
                echo '<div class="alert alert-danger">'. $error .'</div>';
              }
          }
           if(isset($msgsucces)){
          echo '<div class="alert alert-success"><i class="fa fa-check pull-right"></i>'. $msgsucces . '</div>';
        
        }


        ?>
        <!-- end error -->
			</div>
		</div>
	</div>
	</div>	
  	 
          
<?php 
    }else{
    	header('location: login.php');
    	exit();
    }
  include  $inctem . "footer.php"; 
   ob_end_flush();
 
  ?>