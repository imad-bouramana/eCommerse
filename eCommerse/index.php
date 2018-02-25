<?php  
 ob_start();
 session_start();
 $tittlepage = "Home Page"; // tittle page
  
include 'initialize.php'; 
?>

<div class="container">
   <div class="row">
  <?php $getitem = getAllFrom('*','items','WHERE Aprouve = 1','','Item_Id');
  foreach ($getitem as $item) {
  
  	  echo '<div class="col-sm-6 col-md-3">';
  	    echo '<div class="thumbnail main-thumb">';
  	    echo '<div class="it-price">$'. $item['Price'] .'</div>';
  	    echo '<img src="img.png" class="img-responsive" alt=""/>';
  	        echo '<div class="caption">';
  	          echo '<h3><a href="items.php?itemid='.$item['Item_Id'].'">' . $item['Name'] . '</a></h3>';
  	          echo '<p>'.$item['Description'] .'</p>';
              echo '<div class="date">'.$item['Add_Date'] .'</div>';
                
  	        echo '</div>';
  	    echo '</div>';
  	  echo '</div>';
  
  }?>
  </div>
</div> 


          
<?php   include  $inctem . "footer.php"; 
 ob_end_flush();
 ?>
 