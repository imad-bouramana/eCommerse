<?php  
  ob_start();
 session_start();

 $tittlepage = "tags";
 // tittle page

include 'initialize.php'; ?>

<div class="container">
                 
  <?php  
    //$catid = isset($_GET['catid']) && is_numeric($_GET['catid'])
    // ? intval($_GET['catid']) : 0;
                
 if(isset($_GET['tagename'])){
  $name = $_GET['tagename'];
  
   echo '<h1 class="text-center">Show '. $_GET["tagename"] .'</h1>';
   echo '<div class="row">';
  
  $getitem = getAllFrom("*", "items", "WHERE tags LIKE '%$name%'", "AND Aprouve = 1", "Item_Id");
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
    }
  }else{
       echo '<div class="container">';
        echo '<div class="alert alert-danger">No Such Id category Or Items Not Prouve</div>';
       echo '</div>';

      }
  ECHO '</div>';
  ?>
 </div> 
          
<?php   include  $inctem . "footer.php"; 
  ob_end_flush();
?>