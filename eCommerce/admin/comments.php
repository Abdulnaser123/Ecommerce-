<?php
 //comments members page
 //u can add/delete/update comments from here 
 $pageTitle = "comments";

 session_start() ; 
 if (isset($_SESSION['username']))
 {
     include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'manage' ; 


    if ($do == 'manage')
    { 
     



      $stmt = $con->prepare("select  
      comments.* , items.name , users.userName
      from comments
      inner join 
      items
      on
       items.id = comments.item_id
      inner join 
      users 
      on
      users.id = comments.member_id
      ");
      $stmt->execute();
      $data = $stmt->fetchAll();
      ?>
<h1 class = "text-center">manage Comments</h1>
<div class="container">
<div class="table-responsive">
<table class="main text-center table table-bordered">
<tr>
  <td>ID</td>
  <td>comments</td>
  <td>date added</td>
  <td>item name</td>
  <td>username</td>
  <td>control</td>
</tr>

<?php

foreach ($data as $row){

  if ($row['date']==null){
    $row['date'] = 'Unknown DATE .REG';
  }

  echo '<tr>';
  echo "<td>". $row['id'] . "</td>" ;

  echo "<td>". $row['comment'] . "</td>" ;
  echo "<td>". $row['date'] . "</td>" ;
  echo "<td>". $row['name'] . "</td>" ;
   echo "<td>" . $row['userName'] .  "</td>";
  echo "<td>
  <a href='comments.php?do=Edit&comid=".$row['id']."' class='btn btn-success'> <i class='fa fa-edit'></i>Edit</a>
  <a href='comments.php?do=Delete&comid=".$row['id']."' class='btn btn-danger confirm'> <i class='fa fa-close'></i> Delete</a>";

  if($row['status'] == 0){
    echo  "<a href='comments.php?do=approve&comid=".$row['id']."' class='btn btn-info activate'> <i class='fa fa-edit'></i>Approve</a>";
 
   }


  echo "</td>" ;
    
  


  echo '<tr>';

  
}

?>
</table>

</div>
</div>



<?php
    }
  

    elseif ($do == 'Edit') {
       //check if user id is numeric and it exist
        if (isset($_GET["comid"]) && is_numeric($_GET["comid"])) 
        $user = $_GET["comid"];
        else
        $user = 0;


        $stmt = $con->prepare("select * from comments where id = ? LIMIT 1 ");
        $stmt->execute(array($user));
                $row=$stmt ->fetch();
        $count = $stmt -> rowCount();

        if ($count > 0 ) { ?>

        
        <h1 class='text-center'> Edit Comments </h1>


          <div class="container">
             <form class='form-horizontal' action ="?do=update" method="POST">
                 <input type="hidden" name="comid" value="<?php echo $_GET["comid"] ?>">

            <!-- START USERNAME FEILD  -->
                <div class="form-group form-group-lg">
               
                    <label class="col-sm-2 col-md-6 control-label">Edit comment</label>

                         <div class="col-sm-10 col-md-10" > 
                            <input type="text" name="comment" class="form-control" value="<?php echo $row["comment"] ?>" />
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



    elseif($do == 'update'){
    
      echo "<h1 class='text-center'> Update Comments </h1>";
      echo "<div class = 'container' >";
      
      if($_SERVER["REQUEST_METHOD"] == "POST") {
  
        // get the variabels from the form 
        $id = $_POST["comid"];
        $comment = $_POST["comment"];
        
  
  
       
  
    
  //form validation
  $formErrors = array();
  
          if (strlen($comment) < 4){
              $formErrors[] ='<div class="alert alert-primary" role="alert">
              comments can\'t be less than 4 cahracter
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
        comments
         SET
        comment = ? 
           where
       id = ? ");
      //  $stmt-> execute(arrary());
        $stmt->execute(array($comment , $id));
  
        //echo success maseage
        $errorMsg = "<div class='alert alert-success'>" .$stmt->rowCount() . 'record update</div>' ;
  
        redirect ($errorMsg  , 'comments.php' , 4);
      }
  }
      else{
         
        $errorMsg = "<div class = 'alert alert-danger'>u can\'t browse this page directly</div>";
              
        redirect ($errorMsg, null,6);
      }
      echo "</div>";
  
  
  }
  elseif ($do == 'Delete'){
    echo "<h1 class='text-center'> Delete Comment </h1>";
    echo "<div class = 'container' >";
  
       //check if user id is numeric and it exist
       if (isset($_GET["comid"]) && is_numeric($_GET["comid"])) 
       $user = $_GET["comid"];
       else
       $user = 0;
       $stmt = $con->prepare("select * from comments where id = ? LIMIT 1 ");
       $stmt->execute(array($user));
       $count = $stmt-> rowCount();
  
       if ($count > 0 ) {
         $stmt = $con -> prepare("delete from comments where id = :zuser");
           $stmt->bindParam(":zuser",$user);
           $stmt->execute();
           $msg = "<div class='alert alert-success'>" .$stmt->rowCount() . 'record deleted</div>' ;
  
           redirect($msg , 'comments.php' , 6);
  
       }
  
       echo "</div>";
  
  
  
  
      
    
      }
      elseif ($do == 'approve'){

        echo "<h1 class='text-center'> Activate Member </h1>";
        echo "<div class = 'container' >";
      
           //check if user id is numeric and it exist
           if (isset($_GET["comid"]) && is_numeric($_GET["comid"])) 
           $user = $_GET["comid"];
           else
           $user = 0;

           $check = checkItem ('id' , 'comments' , $user) ;
      
           if ($check > 0 ) {
             $stmt = $con-> prepare("update comments set status =1 where id = ? ");
               $stmt->execute(array($user));
               $msg = "<div class='alert alert-success'>" .$stmt->rowCount() . 'record activated</div>' ;
      
               redirect($msg , 'comments.php' , 6);
      
           }
      
           echo "</div>";
      
      

      }

      include $tpl.'footer.php';

}



  
 else {
     header('location: index.php'); 
     exit();
 }