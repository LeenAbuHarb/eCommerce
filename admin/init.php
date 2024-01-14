<?php

include 'connectDB.php' ;
$tpl='includes/templetes/';
$lang='includes/languages/';
$func='includes/functions/';
$css='layout/css/';
$js='layout/js/';

include $func .'function.php';
include $lang .'english.php';
include  $tpl.'header.php';
if(!isset($Nonavbar)){
    include $tpl. 'navbar.php'; 
}

