<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-id" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php"><?php echo lang("home-admin"); ?></a>
    </div>
    <div class="collapse navbar-collapse" id="app-id">
      <ul class="nav navbar-nav">
        <li><a href="categories.php"><?php echo lang("categories"); ?></a></li>
        <li><a href="items.php"><?php echo lang("items"); ?></a></li>
        <li><a href="members.php"><?php echo lang("members"); ?></a></li>
        <li><a href="comments.php"><?php echo lang("comments"); ?></a></li>
        
        <li><a href="#"><?php echo lang("statistics"); ?></a></li>
        <li><a href='#'><?php echo lang("logs"); ?></a></li>
     
      </ul>
       <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../index.php">Shop</a></li>
            <li><a href="members.php?do=Edit&userid=<?php echo $_SESSION['ID']?>">Edit Profile</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>