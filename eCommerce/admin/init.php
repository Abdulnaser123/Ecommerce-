<?php
//routes

$tpl = "include/tempelets/"; // tempelet directory
 // echo $tpl; 
 $css = "layout/css/";
 $js = "layout/js/";
 $func = "include/functions/";
include 'connect.php' ; 
//include the important file 
include "include/languages/eng.php"; 
include $func  . 'function.php';



include $tpl.'header.php';
 


if(!isset($noNavBar)){
include $tpl.'navbar.php';

}
 
?>