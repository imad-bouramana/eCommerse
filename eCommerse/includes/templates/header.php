<!DOCTYPE html>
<html>
    <head>
         <meta charset="UTF-8" />
         <title><?php getTittle(); ?></title>
          <link rel="stylesheet" href="<?php echo $laycss; ?>bootstrap.min.css"  />
	      <link rel="stylesheet" href="<?php echo $laycss; ?>font-awesome.min.css" />
	      <link rel="stylesheet" href="<?php echo $laycss; ?>jquery-ui.css" />
	      <link rel="stylesheet" href="<?php echo $laycss; ?>jquery.selectBoxIt.css" />
	      
	      <link rel="stylesheet" href="<?php echo $laycss; ?>frontend.css" />
	      
    </head>
    <body>
      <div class="uppear-case">
        <div class="container">
          <?php 
           if(isset($_SESSION['user'])){ ?>
             <div class="btn-group">
               <img src="img.png" class=" img-circle log-img" alt=""/>
                 
               <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <?php echo $sessionUser ?>
                <span class="caret"></span>
                </span>
                <ul class="dropdown-menu">
                  <li> <a href="profile.php">My Profile </a></li>
                  <li> <a href="newadd.php">New Item </a></li>
                  <li> <a href="profile.php#ads">My Item </a></li>
                  <li> <a href="logout.php">Logout</a></li>
                </ul>
             </div>

           <?php
                
                  
               
          }else{

          ?>
             <a href="login.php"><span class="pull-right">Login | SignUp</span></a>
      <?php }  ?>
        </div>
      </div>
<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-id" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Home Page</a>
    </div>
    <div class="collapse navbar-collapse" id="app-id">
      <ul class="nav navbar-nav navbar-right">
         <?php
         $getcategory = getAllFrom('*', 'categories',  'WHERE parent = 0', '', 'Id', 'ASC');
   
          foreach ($getcategory as $cat) {
              echo '<li>
                      <a href="categories.php?catid=' . $cat["Id"]. '">'  
                      . $cat["Name"] . '</a>
                   </li>';
        }
           ?> 
      </ul>
       
    </div>
  </div>
</nav>

      </body>
 </html>

