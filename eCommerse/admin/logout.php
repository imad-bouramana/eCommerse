<?php

  session_start();  //start session

  session_unset();  //end data

  session_destroy();  //destry session

  header("location: index.php");

  exit();