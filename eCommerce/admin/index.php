<?php
session_start();
$pageTitle = 'login';
$noNavBar='';
include "init.php";

// if(isset($_SESSION['username'])){
//     header('location:dashboard.php');
// }
//print_r($_SESSION);
echo '<br>';

//include "include/tempelets/header.php";
//include $tpl. "header.php" ;

//include "include/languages/arabic.php" ;
//check user if coming from post method 
$username ="";
    $password ="";
    $hashedpass = "";

if($_SERVER['REQUEST_METHOD']=='POST'){
    $username = $_POST['user'];
    $password = $_POST['password'];
    
    $hashedpass = sha1($password);
}
   // echo '<br>'."user name :".$username ."   ".'<br>'."pass :".$hashedpass;

//check if user is exist in database
$stmt = $con->prepare("     select 
                                 id,userName , password 
                             from
                                 users
                             where
                                  username = ? 
                              and 
                                   password=? 
                             and
                                     groupId=1
                                     LIMIT 1"
                         );
$stmt->execute(array($username,$hashedpass));
$count = $stmt -> rowCount();
$data = $stmt -> fetch();

//echo $count;
//if count larger than zero that mean there is exist user in database  
if($count >0 ){

//print_r($data);
$_SESSION['username'] = $username ;
$_SESSION['ID'] = $data['id'];
header('location:dashboard.php');
//echo $data['id'];



}
// if(isset($_SESSION['username'])){
//     header('location:dashboard.php');
// }
// exit();
// }
// else 
// echo "welcom user";
// }

?>


<form  class ='login' action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
      <h4 calss='text-center'>ADMIN LOGIN</h4>

    <input class = 'form-control input-lg'  type="text" name ='user' placeholder='user name' autocomplete='off'/>
    <input class = 'form-control'  type="password" name='password' placeholder='password' autocomplete='new-password'>
    <input class = 'btn btn-primary btn-block'  type="submit" value='login'>

     


    </div>

</form>

<?php

?>