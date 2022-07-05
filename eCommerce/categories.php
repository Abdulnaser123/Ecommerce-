<?php
include 'init.php';
?>

<div class="container">
    <div class="row">
    
    <h1 class="text-center"><?php 
    echo str_replace('_',' ',$_GET['pageName']) ?>
    </h1>

    <?php
foreach(getItems('cat_id',$_GET['pageid'] ,1   ) as $item){
echo '<div class="col-sm-6 col-md-4">';
    echo '<div class="thumbnil">';
    echo '<div class="before-price"></div><span class = "price">'.$item['price'].'</span>';
    echo '<img class = "img-responsive" src="profile.png" alt="" />';
    echo '<div class="caption">';
    echo '<h3 class="center"><a href ="items.php?itemid='.$item['id'].'">' . $item['name'] . '</a></h3>';
    echo '<p>'.$item['description'].'</p>';
    echo '<div class="date">'.$item['add-date'].'</div>';

echo '</div>';  
echo '</div>';
echo '</div>';
}

?>
    </div>
</div>
