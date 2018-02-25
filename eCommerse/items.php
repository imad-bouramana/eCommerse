<?php  
  ob_start();
 session_start();
 $tittlepage = "Items Profile"; // tittle page
  include 'initialize.php'; 

  // if userid is exist , if is numirec , hese value is 0
  $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

                   // chek all  select from users
   $stmt = $db->prepare("SELECT items.*, categories.Name AS category_Name,
   	                           users.username
   	                       FROM items
   	                        INNER JOIN categories 
                                ON 
                                      categories.Id = items.Cat_Id
                            INNER JOIN users
                            ON       users.userid  = items.Member_ID
                                 
   	                       WHERE item_Id = ? 
                           AND Aprouve = 1");

     // execute  the select in array
   $stmt->execute(array($itemid));

   $count = $stmt->rowCount();

   if($count > 0){

         // fitch the data
    $item  =$stmt->fetch();           
  
?>

<h1 class="text-center"><?php echo $item['Name'] ?> Profile</h1>
 <div class="container">
 	 <div class="row">
 	 	<div class="col-md-3">
 	 		<img src="img.png" class="img-responsive img-thumbnail" alt=""/>
		</div>
 	 	<div class="col-md-9 item-info">
 	 		<h2><?php echo $item['Name'] ?></h2>
 	 		<p><?php echo $item['Description'] ?></p>
       <ul class="list-unstyled">
 	 		    <li><i class="fa fa-money fa-fw"></i>
            <span>Price</span> : $<?php echo $item['Price'] ?></li>
 	        <li><i class="fa fa-calendar fa-fw"></i>
            <span>Added On </span>: <?php echo $item['Add_Date'] ?></li> 
 	        <li><i class="fa fa-truck fa-fw"></i>
             <span>Country </span>: <?php echo $item['Country_Made'] ?></li>
 	        <li><i class="fa fa-tags fa-fw"></i>
           <span>Categories</span> : <a href="categories.php?catid=<?php echo $item['Cat_Id']?>"><?php echo $item['category_Name'] ?></a></li> 
 	        <li><i class="fa fa-male fa-fw"></i>
           <span>Addes By</span> : <a href="#"><?php echo $item['username'] ?></a></li> 
          <li class="tags"><i class="fa fa-male fa-fw"></i>
           <span>Tags</span> : 
           <?php 
            $alltags = explode(',', $item['tags']);
            foreach ($alltags as $tag) {
              $tag = str_replace(' ', '', $tag);
              $tag = strtolower($tag);
              if(! empty($tag)){
            echo '<a href="tags.php?tagename=' . $tag .'">' . $tag . '</a>'; 

               }
           }
           ?>
          </li> 
    
 	    </ul>     
 	 	</div>
 	 </div>
   <hr class="custom-hr">
   <?php  if(isset($_SESSION['user'])){ ?>
   <div class="row">
      <div class="col-md-offset-3">
        <div class="item-form">
           <h3>Add Comment</h3>
           <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item["Item_Id"] ?>" method='POST'>
              <textarea name="comment" required></textarea>
              <input type="submit" value="Add Comment" class="btn btn-primary">
           </form>
           <?php  
               if($_SERVER['REQUEST_METHOD']== "POST"){
                  $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                  $itemid  = $item['Item_Id'];
                  $userid  =  $_SESSION['getuser'];
                  if(! empty($comment)){
                    $stmt = $db->prepare('INSERT INTO comments(Comment, Status, c_Date, item_Id, user_Id)
                      VALUES(:zcomment, 0,  NOW(), :zitemid, :zuserid)');
                    $stmt->execute(array(
                       'zcomment' => $comment,
                       'zitemid'  => $itemid,
                       'zuserid'  => $userid
                      ));
                    if($stmt){
                      echo '<div class="alert alert-success">Comment Added By Success</div>';
                      

                    }
                  }
              }



           ?>
        </div>
      </div>
   </div>
<?php }else{
      echo '<a href="login.php">Login</a> Or <a href="login.php">Regester</a> To Show Comments';
} ?>
   <hr class="custom-hr">
   <?php 
       $stmt = $db->prepare("SELECT comments.*,  users.username AS userName
                                  FROM comments
                                  INNER JOIN users
                                  ON  comments.user_Id   = users.userid
                                  WHERE Status = 1
                                  AND  item_Id = ?
                                  ORDER BY c_ID DESC");
           $stmt->execute(array($item['Item_Id']));
           $comments = $stmt->fetchAll();
          
           foreach ($comments as $comment) { ?>
           <div class="coment-div">
              <div class="row">
                  <div class="col-md-2 text-center">
                    <img src="img.png" class="img-responsive img-thumbnail img-circle block" alt=""/>
                 
                     <h4><?php echo $comment['userName'] ?> </h4>
                  </div>
                  <div class="col-md-10">
                     <p class="dv-coment lead">
                     <?php  echo  $comment['Comment'] ?>
                   </p>
                  </div>
              </div>
           </div>
           <hr class="custom-hr">
  <?php    }   ?>   
   
 </div>

<?php
}else{   
       echo '<div class="container">';
        echo '<div class="alert alert-danger">No Such Id Itmes Or Items Not Prouve</div>';
       echo '</div>';


}	
  include  $inctem . "footer.php"; 
   ob_end_flush();
 
  ?>