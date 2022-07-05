<?php
ob_start();
session_start();

$pageTitle = "profile";
include "init.php";

  //check if user id is numeric and it exist
  if (isset($_GET["itemid"]) && is_numeric($_GET["itemid"])) 
  $itemid = intval($_GET["itemid"]);
  else
  $itemid = 0;



  $stmt = $con->prepare("SELECT items.*,
                    categories.name as cat_name ,
                    users.userName
                        from items  
                        inner join 
                        categories
                        on
                        categories.id = items.cat_id 
                        inner join
                        users
                        on
                        users.id = items.member_id
                       where 
                       items.id = ?");
  $stmt->execute(array($itemid));
          $item=$stmt ->fetch();
          if(!empty($item)){

?>
<h1 class = "text-center"><?php echo $item['name'] ?></h1>
<div class="container">
  <div class="row">
    <div class="col-md-3">
  <img class = "img-responsive img-thumbnail" src="profile.png" alt="" />

    </div>
    <div class="col-md-9 item-info">

    <!-- <img class = "img-responsive img-thumbnail" src="profile.png" alt="" /> -->

            <h2><?php echo $item['name'] ?></h2>
            <ul class="list-unstyled">
            <li>    
            <i class="fa fa-book fa-fw"></i>
              <span>description: <?php echo $item['description'] ?></sapn>
            </li>
            <li> 
             <i class="fa fa-money fa-fw"></i>
             <span>Price: <?php echo $item['price'] ?></span>
            </li>
            <li>
            <i class="fa fa-calendar fa-fw"></i>
              <span>Added-Date: <?php echo $item['add-date'] ?></span>
            </li>
            <li>
            <i class="fa fa-building  fa-fw"></i>
              <span>Made in: <?php echo $item['country-made'] ?></span>
            </li>
            <li>
            <i class="fa fa-tags fa-fw"></i>
              <span>Category is: <?php echo $item['cat_name'] ?></span>
            </li>
            <li>
            <i class="fa fa-user fa-fw"></i>
              <span>Member is: <?php echo $item['userName'] ?></span>
            </li>
            </ul>
          </div>
  </div>
  <hr>
  <!--start cooment feild-->
  <?php 

               
  
    


  if(isset($_SESSION['user'])){ ?>
  <div class="row">
            <div class ="col-md-3">
              <div class = "comment">
               <h3>Add your comment</h3>
                 <form action="" method="POST">
                   <textarea  name="comment" >

                     </textarea>
                  <input  class = "btn btn-primary" type="submit" value="Add Comment">
                </form>
                <?php
                
                ?>
                </div>
              </div>
              <?php
              if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $comment = $_POST['comment'];
                $userid = $_SESSION['id'];
                $itemid =$item['id'];
            
            
                if(!empty($comment)){
            
                  $stmt = $con->prepare("INSERT into comments (comment , status , date , item_id, member_id)
                  VALUES (:zcomment , 0 , now() , :zitemid , :zuserid)");
                  $stmt->execute(array('zcomment' => $comment, 'zitemid'=> $itemid ,'zuserid'=> $userid));
                  if($stmt){
            
                    echo '<div class ="alert alert-success text-center">Comment Added</div>';
                  }
                  
                }
            
            
            }
              ?>
             <div class="col-md-9">
           
           

          </div>
  </div>
  <hr>
<?php
  $stmt = $con->prepare("SELECT  
comments.* , users.userName
from
     comments
inner join 
     users 
on
     users.id = comments.member_id
 where item_id = ?
 and 
 status = 1  
");

$stmt->execute(array($itemid));
$data = $stmt->fetchAll();
foreach($data as $co){
  echo '<div class="comment-box">';
  echo '<div class="row">';
      echo '<div class="col-md-2 text-center"><img class = "img-responsive img-thumbnaol img-circle center-block" src="profile.png" />'
      
      .$co['userName'].'</div>';
      echo '<div class="col-md-10"><p class = "lead">'.$co['comment'].'</p></div></div><hr>';


}
?>


</div>


  <!--End cooment feild-->
  
<?php

  }
else{
  echo  'you can not comment without <a href = "login.php">login</a> your accont';
}

          



}
          else{
              echo 'there\'s no items to show';
          }
include $tpl."footer.php";
ob_end_flush();
?>


