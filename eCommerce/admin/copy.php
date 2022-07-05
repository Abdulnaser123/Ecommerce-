<?php
session_start();
 $pageTitle='';

 if(isset($_SESSION['userName'])){
     include 'init.php';
     $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

     if($do == 'manage'){

     }
     elseif($do == 'Add'){

     }
     elseif($do == 'insert'){

     }
     elseif($do == 'Edit'){

     }
     elseif($do == 'update')
     {
         
     }
     elseif($do == 'update'){

     }
     elseif($do == 'delete'){

     }
     elseif ($do == 'activate'){

     }
     include $tpl . 'footer.php'
 }
 else 
 {
   header('location: index.php');
   exit() ; 
}
