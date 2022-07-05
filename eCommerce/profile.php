<?php

session_start();

$pageTitle = "profile";


include "init.php";

$getStmt = $con->prepare("select * from users where userName = ? ");
      $getStmt->execute(array($_SESSION['user']));
      $rows = $getStmt->fetch();
      $rows;
     


?>

<div class="information block">
    <div class="container">
    <div class="panel panel-primary">
      <div class="panel-heading">My Information</div>
      <div class="panel-body">
        <ul class="list-unstyled">
        <li>
          <i class="fa fa-unlock-alt fa-fw"></i>
          <span>login NAME: </span><?php echo $rows['userName'] ?>
        </li>
        <li> 
        <i class="fa fa-user fa-fw"></i>

                 <span>Full name: </span><?php echo $rows['fullName'] ?>
        </li>    
        <li>          
          <i class="fa fa-key fa-fw"></i>
          <span>Hash-password: </span><?php echo $rows['password'] ?>
        </li>  
        <li> 
                   <i class="fa fa-calendar fa-fw"></i>
          <span>Date: </span><?php echo $rows['date'] ?>
        </li>  
        <li>
                    <i class="fa fa-envelope-o fa-fw"></i>
          <span>Email: </span><?php echo $rows['email'] ?>
        </li> 
       
        </ul>
</div>
    </div>
    </div>
   
</div>

<div id= "my-ads" class="Myads block">
    <div class="container">
    <div class="panel panel-primary">
      <div class="panel-heading">My Ads</div>
      <div class="panel-body"><?php

      if(!empty(getItems('member_id', $rows['id'] ))){
foreach(getItems('member_id', $rows['id'] ) as $item){
echo '<div class="col-sm-6 col-md-4">';
    echo '<div class="thumbnil">';
    echo '<div class="before-price"></div><span class = "price">'.$item['price'].'</span>';
    if($item['approve'] == 0 ){
      echo '<span class="approval">did not approved</span>';
    }
    echo '<img class = "img-responsive" src="profile.png" alt="" />';
    echo '<div class="caption">';
    echo '<h3 class="center"><a href="items.php?itemid='.$item['id'].'">' . $item['name'] . '</a></h3>';
    echo '<p>'.$item['description'].'</p>';
    echo '<div class="date">'.$item['add-date'].'</div>';
echo '</div>';  
echo '</div>';
echo '</div>';
}
      }
      else{
        echo '<p style = "font-weight:bold;" }>No ads to show,create <a href="createAd.php">new ad</a></p>';
echo '</div>';  
echo '</div>';
echo '</div>';
      }

?>
</div>
    </div>
    </div>
   
</div>

<div class="information block">
    <div class="container">
    <div class="panel panel-primary">
      <div class="panel-heading">Latest Comments</div>
      <div class="panel-body">

<?php

$stmt=$con->prepare("SELECT comment from comments where member_id = ? ");
$stmt->execute(array($rows['id']));
$data=$stmt->fetchAll();
if(!empty($data)){
foreach($data as $data1){
  echo $data1['comment'];
}
}
else{
  echo '<p style = "font-weight:bold;" }>No Comments to show</p>';

}
?>
    </div>
    </div>
    </div>
   
</div>


<?php


include $tpl."footer.php";

?>


