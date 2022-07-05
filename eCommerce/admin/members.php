<?php
 //manage members page
 //u can add/delete/update members from here 

 session_start() ; 
 if (isset($_SESSION['username']))
 {
     include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'manage' ; 


    if ($do == 'manage')
    { 
      $query='';
      if (isset($_GET['page']) && $_GET['page'] == 'pending'){
           $query = "AND regStatus = 0" ;

      }



      $stmt = $con->prepare("select * from users where groupId != 1 $query");
      $stmt->execute();
      $data = $stmt->fetchAll();
      ?>
<h1 class = "text-center">manage Members</h1>
<div class="container">
<div class="table-responsive">
<table class="main text-center table table-bordered">
<tr>
  <td>ID</td>
  <td>usernmae</td>
  <td>email</td>
  <td>full name</td>
  <td>registerd date</td>
  <td>control</td>
</tr>

<?php

foreach ($data as $row){

  if ($row['date']==null){
    $row['date'] = 'Unknown DATE .REG';
  }

  echo '<tr>';
  echo "<td>". $row['id'] . "</td>" ;

  echo "<td>". $row['userName'] . "</td>" ;
  echo "<td>". $row['email'] . "</td>" ;
  echo "<td>". $row['fullName'] . "</td>" ;
   echo "<td>" . $row['date'] .  "</td>";
  echo "<td>
  <a href='members.php?do=Edit&userId=".$row['id']."' class='btn btn-success'> <i class='fa fa-edit'></i>Edit</a>
  <a href='members.php?do=Delete&userId=".$row['id']."' class='btn btn-danger confirm'> <i class='fa fa-close'></i> Delete</a>";

  if($row['regStatus'] == 0){
    echo  "<a href='members.php?do=activate&userId=".$row['id']."' class='btn btn-info activate'> <i class='fa fa-edit'></i>Activate</a>";
 
   }


  echo "</td>" ;
    
  


  echo '<tr>';

  
}

?>
</table>

</div>
<a href="members.php?do=Add" class ="btn btn-outline-primary btn-add-member"> <i class="fa fa-plus">  add new member</i> </a>

</div>



<?php
    }
    elseif($do == "Add"){ 
      
      
      ?>
        <!-- //add member page -->
        
        <h1 class='text-center'> add new member  </h1>


        <div class="container">
           <form class='form-horizontal' action ="?do=insert" method="POST">
               <!-- <input type="hidden" name="userid" value="<?php echo $_GET["userId"] ?>"> -->

          <!-- START USERNAME FEILD  -->
              <div class="form-group form-group-lg">
             
                  <label class="col-sm-2 col-md-6 control-label" >username</label>

                       <div class="col-sm-10 col-md-10" > 
                          <input type="text" name="username"  class="form-control" required = "required"  autocomplete="off"  placeholder = "set username here "/>
                        </div>
               </div>

                   <!-- START USERNAME FEILD  -->
              <div class="form-group">
             
             <label class="col-sm-2 control-label">password</label>

                  <div class="col-sm-10 col-md-10"> 
                     <input type="password" name="password" required = "required" class="password form-control" autocomplete="new-password" placeholder="password here" />
                     <i class="show pass fa fa-eye fa-2x" ></i></div>
          </div>

              <!-- START email FEILD  -->
              <div class="form-group form-group-lg">
             
                  <label class="col-sm-2 control-label">E-mail</label>

                       <div class="col-sm-10 col-md-10"> 
                          <input type="email" name="email"   required = "required" class="form-control" placeholder = "set your E-mail"/>
                        </div>
               </div>

                  <!-- START full name FEILD  -->
              <div class="form-group">
             
             <label class="col-sm-2 control-label">Full Name</label>

                  <div class="col-sm-10 col-md-10" d-flex> 
                     <input type="text" name="full"  class="form-control"  required = "required" placeholder = "full name appare if your profile"/>
                   </div>
          </div>

                   <!-- START submit FEILD  -->
                   <br>
              <div class="form-group">
             

                  <div class="col-sm-10 col-md-10 "> 
                     <input type="submit" value="add member" class="btn btn-primary btn-lg" />
                   </div>
          </div>



           </form>
       </div>


  <?php
    }

    elseif ($do == 'Edit') {
       //check if user id is numeric and it exist
        if (isset($_GET["userId"]) && is_numeric($_GET["userId"])) 
        $user = $_GET["userId"];
        else
        $user = 0;


        $stmt = $con->prepare("select * from users where id = ? LIMIT 1 ");
        $stmt->execute(array($user));
                $row=$stmt ->fetch();
        $count = $stmt -> rowCount();

        if ($count > 0 ) { ?>

        
        <h1 class='text-center'> Edit member </h1>


          <div class="container">
             <form class='form-horizontal' action ="?do=update" method="POST">
                 <input type="hidden" name="userid" value="<?php echo $_GET["userId"] ?>">

            <!-- START USERNAME FEILD  -->
                <div class="form-group form-group-lg">
               
                    <label class="col-sm-2 col-md-6 control-label">username</label>

                         <div class="col-sm-10 col-md-10" > 
                            <input type="text" name="username" class="form-control" value="<?php echo $row["userName"] ?>" autocomplete="off" required="required"/>
                          </div>
                 </div>

                     <!-- START USERNAME FEILD  -->
                <div class="form-group">
               
               <label class="col-sm-2 control-label">password</label>

                    <div class="col-sm-10 col-md-10"> 
                       <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="leave empty if u woud not change your old password " />
                      <input type="hidden" name = "oldpassword" value = <?php echo $row['password']?>>
                    </div>
            </div>

                <!-- START email FEILD  -->
                <div class="form-group form-group-lg">
               
                    <label class="col-sm-2 control-label">E-mail</label>

                         <div class="col-sm-10 col-md-10"> 
                            <input type="email" name="email" value="<?php echo $row["email"] ?>" class="form-control" required="required"/>
                          </div>
                 </div>

                    <!-- START full name FEILD  -->
                <div class="form-group">
               
               <label class="col-sm-2 control-label">Full Name</label>

                    <div class="col-sm-10 col-md-10" d-flex> 
                       <input type="text" name="full" value="<?php echo $row["fullName"] ?>" class="form-control" required="required" />
                     </div>
            </div>

                     <!-- START submit FEILD  -->
                     <br>
                <div class="form-group">
               

                    <div class="col-sm-10 col-md-10 "> 
                       <input type="submit" value="save" class="btn btn-primary btn-lg" />
                     </div>
            </div>



             </form>
         </div>

         
    
    <?php 
        }
        else
        {
          echo "<div class='container'>";
            $msg = "<div class = 'alert alert-danger'>NO user Id</div>";
            redirect($msg , null , 6);
            echo "</div>";
        } 
    }

    //insert page
elseif($do == 'insert') {


    //echo $_POST['username'] . $_POST['password']  . $_POST['email'] . $_POST['full']  ;

    
        
        if($_SERVER["REQUEST_METHOD"] == "POST") {

            echo "<h1 class='text-center'> Insert Member </h1>";
        echo "<div class = 'container' >";
  
          // get the variabels from the form 
          $pass = $_POST["password"];
          $user = $_POST["username"];
          $email = $_POST["email"];
          $full = $_POST["full"];
          //$date = $_POST["date"];

          $hpass =sha1($_POST["password"]);




      
//form validation
$formErrors = array();

            if (strlen($user) < 4){
                $formErrors[] ='<div class="alert alert-primary" role="alert">
                username can\'t be less than 4 cahracter
              </div>';  
            }

          if (empty ($user)){
              $formErrors[] ='<div class="alert alert-primary" role="alert">
              username can\'t be empty    
              </div>';  
          }
          if(empty($email)){
            $formErrors[] = '<div class="alert alert-primary" role="alert">
            email can\'t br empty
          </div>';  
          }
          if(empty($full)){
            $formErrors[] = '<div class="alert alert-primary" role="alert">
            name can\'t be empty
          </div>';  
          }

          if(empty($pass)){
            $formErrors[] = '<div class="alert alert-primary" role="alert">
            password can\'t be empty
          </div>';  
          }

          foreach($formErrors as $error){



            echo $error ;
            ECHO '<BR>';

          }   
   
         
             
         // echo $id . $user . $email . $full ;
        // update the database with this info
        

            //insert into database

            if (empty($formErrors)){

              if (checkItem ('userName' , 'users' , $user) == 1  ) {
                $msg = "<div class='alert alert-danger'>this username is alredy exist </div>";
                redirect($msg , 'members.php' , 6);
                 }
              else {
              
            $stmt = $con->prepare("insert into
             users(userName , password , email , fullName,regStatus,date)
             VALUES(:islam , :pass , :zemail , :fullname ,1,now())");
             
             $stmt->execute(array(

                'islam' => $user,
                 'pass' => $hpass, 
                  'zemail' => $email,  
                  'fullname' => $full, 
                  
             ));
             $msg = "<div class='alert alert-success'>" .$stmt->rowCount() . 'record update</div>' ;
             redirect($msg , 'members.php' , 6);

        }
      }
  
        }
        else{
         
          $errorMsg = "<div class = 'alert alert-danger'>u can\'t browse this page directly</div>";
            
          redirect ($errorMsg ,'members.php' ,6);
      }
      echo "</div>";

    }
        

    elseif($do == 'update'){
    
      echo "<h1 class='text-center'> Update Member </h1>";
      echo "<div class = 'container' >";
      
      if($_SERVER["REQUEST_METHOD"] == "POST") {
  
        // get the variabels from the form 
        $id = $_POST["userid"];
        $user = $_POST["username"];
        $email = $_POST["email"];
        $full = $_POST["full"];
  
  
        $pass="";
        if(empty($_POST['newpassword']))
        {
            $pass = $_POST["oldpassword"];
        }
        else{
            $pass = sha1($_POST["newpassword"]);
        }
  
  
    
  //form validation
  $formErrors = array();
  
          if (strlen($user) < 4){
              $formErrors[] ='<div class="alert alert-primary" role="alert">
              username can\'t be less than 4 cahracter
            </div>';  
          }
  
        if (empty ($user)){
            $formErrors[] ='<div class="alert alert-primary" role="alert">
            username can\'t be empty    
            </div>';  
        }
        if(empty($email)){
          $formErrors[] = '<div class="alert alert-primary" role="alert">
          email can\'t br empty
        </div>';  
        }
        if(empty($full)){
          $formErrors[] = '<div class="alert alert-primary" role="alert">
          name can\'t be empty
        </div>';  
        }
  
        foreach($formErrors as $error){
  
          echo $error ;
          ECHO '<BR>';
  
        }   
  
       
           
       // echo $id . $user . $email . $full ;
      // update the database with this info
      if(empty($formErrors)){
  
  
      $stmt = $con->prepare
       ("UPDATE
        users
         SET
        userName = ? , email = ? , fullName = ? , password = ?
           where
       id = ? ");
      //  $stmt-> execute(arrary());
        $stmt->execute(array($user , $email ,$full ,$pass, $id));
  
        //echo success maseage
        $errorMsg = "<div class='alert alert-success'>" .$stmt->rowCount() . 'record update</div>' ;
  
        redirect ($errorMsg  , 'members.php' , 4);
      }
  }
      else{
         
        $errorMsg = "<div class = 'alert alert-danger'>u can\'t browse this page directly</div>";
              
        redirect ($errorMsg, null,6);
      }
      echo "</div>";
  
  
  }
  elseif ($do == 'Delete'){
    echo "<h1 class='text-center'> Delete Member </h1>";
    echo "<div class = 'container' >";
  
       //check if user id is numeric and it exist
       if (isset($_GET["userId"]) && is_numeric($_GET["userId"])) 
       $user = $_GET["userId"];
       else
       $user = 0;
       $stmt = $con->prepare("select * from users where id = ? LIMIT 1 ");
       $stmt->execute(array($user));
       $count = $stmt-> rowCount();
  
       if ($count > 0 ) {
         $stmt = $con -> prepare("delete from users where id = :zuser");
           $stmt->bindParam(":zuser",$user);
           $stmt->execute();
           $msg = "<div class='alert alert-success'>" .$stmt->rowCount() . 'record deleted</div>' ;
  
           redirect($msg , 'dashboard.php' , 6);
  
       }
  
       echo "</div>";
  
  
  
  
      
    
      }
      elseif ($do == 'activate'){

        echo "<h1 class='text-center'> Activate Member </h1>";
        echo "<div class = 'container' >";
      
           //check if user id is numeric and it exist
           if (isset($_GET["userId"]) && is_numeric($_GET["userId"])) 
           $user = $_GET["userId"];
           else
           $user = 0;

           $check = checkItem ('id' , 'users' , $user) ;
      
           if ($check > 0 ) {
             $stmt = $con-> prepare("update users set regStatus =1 where id = ? ");
               $stmt->execute(array($user));
               $msg = "<div class='alert alert-success'>" .$stmt->rowCount() . 'record activated</div>' ;
      
               redirect($msg , 'dashboard.php' , 6);
      
           }
      
           echo "</div>";
      
      

      }

      include $tpl.'footer.php';

}



  
 else {
     header('location: index.php'); 
     exit();
 }