<?php 
     // error reporting
     ini_set('display_errors', 'ON');
     error_reporting(E_ALL);
  include 'admin/connect.php';    //  connect directory

     $sessionUser = '';
     if(isset($_SESSION['user'])){
      $sessionUser = $_SESSION['user'];
           }
  $inctem = "includes/templates/";  //  
  $laycss = "layout/css/";  //     css directory
  $layjs = "layout/js/"; //    js directory
  $langs =  'includes/languages/'; 
  $Tfunc =  "includes/functions/";  //functions directory

  include $Tfunc . 'function.php';
  include   $langs . 'english.php';  //  english directory
  include  $inctem . "header.php";  
  //    header directory
   
   ?>
   