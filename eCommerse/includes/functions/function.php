<?php
   //   getcat funcion
   function getAllFrom($select, $table,  $where = NULL, $and = NULL, $orderBy, $ordering = 'DESC'){
    global $db;
     $gettAll = $db->prepare("SELECT $select FROM $table $where $and ORDER BY $orderBy $ordering");
    $gettAll->execute();
    $All =  $gettAll->fetchAll();
    return $All;
  }
 
   //   getcat funcion
  /* function getcategorie(){
    global $db;
    $getcat = $db->prepare("SELECT * FROM categories ORDER BY Id ASC");
    $getcat->execute();
    $cat =  $getcat->fetchAll();
    return $cat;*/
 // }
  //   getitem funcion  advertize
   /*function getitems($select, $value, $aprouve = NULL){
    global $db;
    if($aprouve == NULL){
       $sql = 'AND Aprouve = 1'; 
    }else{
      $sql = NULL;
    }
    $getitem = $db->prepare("SELECT * FROM items WHERE $select = ? $sql ORDER BY Item_Id DESC");
    $getitem->execute(array($value));
    $items =  $getitem->fetchAll();
    return $items;
  }*/

   // Page title
  function getTittle(){

     global $tittlepage;

     if(isset($tittlepage)){
     
 	echo $tittlepage;

    }else{

 	echo 'page faild';
    }
}
  // redirect function
  function redirecthome($theMsg, $url = null, $seconds = 3){
     if($url === null){
        $url = 'home.php';
     }else{
        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
          $url = $_SERVER['HTTP_REFERER'];
        }else{
          $url = 'home.php';
        }
      }

    echo $theMsg;
    echo "<div class='alert alert-info'>You Well Be Redirect On $seconds Seconds</div>";
    header("refresh:$seconds;url=$url");
    exit();
  }
  // chek item function

  function chekitem($select, $users, $value){

    global $db;
    $stmt = $db->prepare("SELECT $select FROM $users WHERE $select = ?");
    $stmt->execute(array($value));
    $count = $stmt->rowCount();
    return $count;
  }
  // numbers of users function
  function numberItems($items, $users){
     global $db;
     $stmt2 = $db->prepare("SELECT COUNT($items) FROM $users");
     $stmt2->execute();
     return $stmt2->fetchColumn();

  }
  // latest atems function
  function latestItems($select, $users, $order, $limit = 5){
    global $db;
    $stmt3 = $db->prepare("SELECT $select FROM $users ORDER BY $order DESC LIMIT $limit ");
    $stmt3->execute();
    $rows =  $stmt3->fetchAll();
    return $rows;
  }

 // functio check if user regstatus == 0
  function checkregstatus($user){
    global $db;
    $stmt = $db->prepare("select  username, RegStatus FROM users WHERE username = ? AND RegStatus= 0");
    $stmt->execute(array($user));
    $status = $stmt->rowcount();
      return $status;
  }









