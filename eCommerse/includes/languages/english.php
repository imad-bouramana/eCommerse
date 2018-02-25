<?php


    function lang($phrases){

      static $lang  = array(
      	'home-admin' => 'Home',
      	'categories' =>   'Categories',
      	'items' => 'Items',
      	'members' => 'Members',
        'comments' => 'comments',
        
      	'statistics' => 'Statistics',
      	'logs' => 'Logs'
      	);
      return $lang[$phrases];
    }
?>
       