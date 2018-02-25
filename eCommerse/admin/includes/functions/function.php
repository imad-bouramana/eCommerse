<?php
    function getAllFrom($select, $table,  $where = NULL, $and = NULL, $orderBy, $ordering = 'DESC'){
    global $db;
     $gettAll = $db->prepare("SELECT $select FROM $table $where $and ORDER BY $orderBy $ordering");
    $gettAll->execute();
    $All =  $gettAll->fetchAll();
    return $All;
  }
   // Page title
  
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
function getTittle(){

     global $tittlepage;

     if(isset($tittlepage)){
     
  echo $tittlepage;

    }else{

  echo 'page faild';
    }
  }