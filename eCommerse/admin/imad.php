<?php

$imad = '';

if(isset($_GET["imad"])){

    $imad = $_GET["imad"];
}else{
   $imad = 'manage';
}


if($imad == 'omar'){
	echo 'welcome omar';
}elseif($imad == 'dounia'){
    echo 'welcome dounia';
}elseif($imad == 'hayat'){
	echo 'welcome hayat';
}else{
	echo 'sorry';
}