<?php
session_start();
$pageTitle = 'login';
if(isset($_SESSION['user'])) {
    header('Location:index.php');
}

include "init.php";

$username ="";
    $password ="";
    $hashedpass = "";

if($_SERVER['REQUEST_METHOD']=='POST'){

    if(isset($_POST["login"])){

    $username = $_POST['user'];
    $password = $_POST['password'];
    
    $hashedpass = sha1($password);

   // echo '<br>'."user name :".$username ."   ".'<br>'."pass :".$hashedpass;

//check if user is exist in database
$stmt = $con->prepare("     select 
                                id,userName , password 
                             from
                                 users
                             where
                                  username = ? 
                              and 
                                   password=?" 
                             
                         );
$stmt->execute(array($username,$hashedpass));
$data = $stmt->fetch();
$count = $stmt -> rowCount();


//echo $count;
//if count larger than zero that mean there is exist user in database  
if($count >0 ){

//print_r($data);
$_SESSION['user'] = $username ;
$_SESSION['id'] = $data['id'];
header('location:index.php');
exit();
//echo $data['id'];

}

    }

else{


    $Email = $_POST['email'];
    $Pass = $_POST['password'];
    $User = $_POST['username'];

    $formError = array();
    if(isset($_POST['username'])){

        $user = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
        if(strlen($user) < 4 ){
            $formError[]='username must be larger than 4 character';
        }
    }

   

    if(isset($_POST['password']) && $_POST['password1']){

        $pass1 = sha1($_POST['password']);
        $pass2 = sha1($_POST['password1']);
        if($pass1 == $pass2 ){

        }   
        else{
            $formError[] = 'the two passwors you did entered not matched';
        } 
        }

        if(isset($_POST['email'])){

            $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
            if(filter_var($email, FILTER_VALIDATE_EMAIL) == false){
                $formError[]='This email not valid';
            }
        }

        if (empty($formErrors)){

            if (checkItem ('userName' , 'users' , $_POST['username']) == 1  ) {
              $msg = "this username is alredy exist";
                $formError[]=$msg;
               }
            else{ 
            
          $stmt = $con->prepare("INSERT into
           users(userName , password , email,regStatus,date )
           VALUES(:zuser , :pass , :zemail, 0 , now())");
           
           $stmt->execute(array(

              'zuser' => $User,
               'pass' => sha1($Pass) , 
                'zemail' => $Email
           ));
           $msgSuccess = "<div class='alert alert-success'>COOL! you has been registered</div>" ;

        
      }
    }

  

}
}


?>

<div class="container login-page">
    <h1 class="text-center">
        <span  data-class="login">Login</span> 
        | <span  data-class="signup">signup</span>
    </h1>
    <form action="" class="login" method="POST" >
    <input
    pattern=".{4,8}"
    title = "username name must be larger than 4 and less than 8"
    class="form-control" 
    type="text" name="user"
     autocomplete="off"
     placeholder="username" required/>
    <input class="form-control"
     type="password" name="password" 
     autocomplete="new-password"
     placeholder="password"/>
    <input class="btn btn-primary d-grid gap-2 col-12 mx-auto" type="submit" name ='login' value="login" />
    </form>


    <form class="signup" action="" method="POST" >
    <input
    
    pattern=".{4,8}"
    title = "username name must be larger than 4 and less than 8"
    class="form-control" 
    type="text" name="username"
     placeholder="username" autocomplete="off" required/>

    <input
    minlength = "4"
    class="form-control"
     type="password" name="password"
     placeholder="password"
     autocomplete="off" required/>

     <input  minlength = "4"
      class="form-control"
     type="password" name="password1"
     placeholder="password again"
     autocomplete="off" required/>
     
    <input class="form-control"
     type="email" name="email" 
     placeholder="E-mail"
     autocomplete="off"/>

    <input class="btn btn-success d-grid gap-2 col-12 mx-auto" name = "signup" type="submit" value="login" />
    </form>
    <div class="errors text-center">
<?php
if(empty($formError))
{

}
else
foreach($formError as $error){
    echo '<p class = "error-paragraph1">'.$error.'</p>';
    echo '<p class = "error-paragraph"></p>';

}
    if(isset($msgSuccess)){
        echo $msgSuccess;
    }



?>

    </div>
</div>
<?php
include $tpl.'footer.php';