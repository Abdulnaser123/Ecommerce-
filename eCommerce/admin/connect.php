<?php
$dsn = 'mysql:host=localhost;dbname=shop';
$user ='root';
$password='';
$option = array (
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);
try {
    $con=new PDO($dsn,$user , $password , $option);
     $con->setAttribute(PDO::ATTR_ERRMODE  ,  PDO::ERRMODE_EXCEPTION);
    // echo 'u are connected welcom to database';
}
catch (PDOException $e){
    echo 'feild connection'.$e->getMessage();

}

