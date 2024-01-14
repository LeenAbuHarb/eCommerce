<?php


ini_set('display_errors','On');
error_reporting(E_ALL);


include 'admin/connectDB.php' ;

$session= '';

if(isset($_SESSION['anyuser'])){
    $session=$_SESSION['anyuser']; 
}

$tpl='includes/templetes/';
$lang='includes/languages/';
$func='includes/functions/';
$css='layout/css/';
$js='layout/js/';

include $func .'function.php';
include $lang .'english.php';
include  $tpl.'header.php';
