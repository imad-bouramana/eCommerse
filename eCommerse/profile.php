<?php  
  ob_start();
 session_start();
 $tittlepage = "Profile"; // tittle page
  include 'initialize.php'; 
  if(isset($_SESSION['user'])){

  	$getUser = $db->prepare('SELECT * FROM users WHERE username = ?');
  	$getUser->execute(array($sessionUser));
  	$count = $getUser->fetch();
    $countuid  =  $count['userID'];
?>

<h1  class="text-center"><?php echo $sessionUser ?> Profile</h1>
<div class="information block">
	<div class="container">
		<div class="panel panel-info">
			<div class="panel-heading">
				Information
			</div>
			<div class="panel-body">
				<ul class="list-unstyled">
				<li>
					<i class="fa fa-unlock-alt fa-fw"></i>
					<span>Name</span> :  <?php echo $count['username'] ?>
				</li>
				<li>
					<i class="fa fa-envelope-o fa-fw"></i>
						<span>Email</span> :  <?php echo $count['email'] ?>
				</li>
		        <li>
                    <i class="fa fa-user fa-fw"></i>
					<span>Fullname</span> :  <?php echo $count['fullname'] ?>
				</li>
		        <li>
		        	<i class="fa fa-tags fa-fw"></i>
		        	<span>RegDate</span> :  <?php echo $count['time'] ?>
		        </li>
		       </ul>
		       <a href="#" class="btn btn-default">Edit Information</a>
			</div>
		</div>
	</div>
</div>
<div  id="ads" class="items">
	<div class="container">
		<div class="panel panel-info">
			<div class="panel-heading">
				Items
			</div>
			<div class="panel-body">

 <?php  
       $getitem = getAllFrom("*","items","where Member_Id = $countuid", "","Item_Id");
          
            if(! empty($getitem)){
            	echo '<div class="row">';
			  	  foreach ($getitem as $item) {
			  	  echo '<div class="col-sm-6 col-md-3">';
			  	    echo '<div class="thumbnail main-thumb">';
			  	        if($item['Aprouve'] == 0){ 
			  	        	echo '<div class="wait">Waiting</div>';}
			  	    echo '<div class="it-price">$'. $item['Price'] .'</div>';
			  	    echo '<img src="img.png" class="img-responsive" alt=""/>';
			  	        echo '<div class="caption">';
			  	          echo '<h3><a href="items.php?itemid='.$item['Item_Id'].'">' . $item['Name'] . '</a></h3>';
			  	          echo '<p>'.$item['Description'] .'</p>';
			  	          echo '<div class="date">'.$item['Add_Date'] .'</div>';
			  	        echo '</div>';
			  	    echo '</div>';
			  	  echo '</div>';
			      }
			    echo '</div>';
			}else{
				echo 'No Such Items <a href="newadd.php">Add New </a>';
			}
?>
			 
			</div>
		</div>
	</div>
</div>
<div class="Latest Comments">
	<div class="container">
		<div class="panel panel-info">
			<div class="panel-heading">
				Latest Comments
			</div>
			<div class="panel-body">
		<?php
              $getcmment = getAllFrom("Comment", "comments",  "WHERE user_Id = $countuid", "", "c_ID");
              //$getcomment = $db->prepare('SELECT Comment FROM comments WHERE user_Id = ?');
  	          //$getcomment->execute(array($count['userID']));
  	          //$comment = $getcomment->fetchAll();

  	          if(! empty($getcmment)){
  	          	  foreach ($getcmment as $com) {
  	          	  	echo '<p>' . $com['Comment'] . '</p>';
  	          	  }

  	          }else{
  	          	echo 'no such comment';
  	          }

		?>
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