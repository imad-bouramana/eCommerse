<?php 
  include 'connect.php';    //  connect directory
  $inctem = "includes/templates/";  //  
  $laycss = "layout/css/";  //     css directory
  $layjs = "layout/js/"; //    js directory
  $langs =  'includes/languages/'; 
  $Tfunc =  "includes/functions/";  //functions directory

  include $Tfunc . 'function.php';
  include   $langs . 'english.php';  //  english directory
  include  $inctem . "header.php";  //    header directory

  //iclude navbar if  $noNavbar not exist
   if(!isset($noNavbar)){ include $inctem . "navbar.php";}
   ?>