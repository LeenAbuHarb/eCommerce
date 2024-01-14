<?php

$dsn='mysql:host=localhost;dbname=shop';
$user='root';
$pass='';
$option=array(
   PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES utf8',

);

try{
    $con=new PDO($dsn,$user,$pass,$option);
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    // echo'Yor Are connected welcome to database';

}

catch(PDOExeption $e){
echo 'Faild to connect ' . $e->getMessage();
}



