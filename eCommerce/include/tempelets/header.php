
<!DOCTYPE HTML>
<hmtl>
    <head>
        <meta charset="UTF-8" />
        <title><?php getTitle() ?> </title>

        <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $css; ?>frontEnd.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    </head>
<body>

  
<div class="upper-bar my-info">
    <div class=" container ">

    <?php 
      if(isset($_SESSION['user'])){
     /// $s = checkActivation ($_SESSION['user']);
  ?>

<div class="dropdown my-info">
  <img class  = "img-circle" src="profile.png" alt="" />

  <div class = "text-left upper-bar-info" >
    <a  href="profile.php">My Profile</a> |
    <a href="profile.php#my-ads">My info</a> |
    <a  href="createAd.php">New advetize</a> |
    <a href="logout.php">Logout</a> 

  </div>
</div>












      
    <?php 


  
}else{
  ?>
        <a href="login.php">
            <span class="login">Login/signup</span>
        </a>
<?php } ?>
</div>
</div>



<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <a class="navbar-brand" href="index.php"><?php echo lang('HOME_ADMIN') ?></a>
  <button class="navbar-toggler" type="button" data-bs-toggle="dropdown" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
    <?php
$cats = getCat();
foreach($cats as $cat){
    echo '<li class="nav-item"><a class="nav-link" href = "categories.php?pageid='.$cat['id'] .'&pageName=' . str_replace(' ','-',$cat['name']).'">'. $cat['name'] .'</a></li>' ;
}

include $tpl."footer.php";


?>


    </ul>
  </div>  
</nav>
<br>




