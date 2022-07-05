<?php
// $noNavBar="";
session_start();
$pageTitle = "dashboard";


if(isset($_SESSION['username'])){
   

            //   echo 'welcome ' . $_SESSION['username'];
             include 'init.php';

            
//start dashboard page 
?>
<div class = ' container home'>
<h1 class="text-center">Dashboard</h1>
<div class= 'row'>
    <div class='col-md-3'>
    <div class='start start1'>  
          <a href="members.php">
              <li class = 'fa fa-users'></li>  </br> 
              <div class=info>
           total Members
           <br>
         <span><?php echo countItem('users' , 'id') ;?> </span>
         </div>
        </a>
         
         </div>

    </div>
    <div class='col-md-3'>
         <div class='start start2'> <a href="members.php?page=pending">
         <li class = 'fa fa-user-plus'></li>  </br> 
              <div class=info>
         Pending Members
         <span><?php echo checkItem('regStatus','users','0'); ?></span>
         </div>
         </a>
         
         </div>

    </div>
    <div class='col-md-3'>
         <div class='start start3'> 
         <a href="items.php">
         <li class = 'fa fa-tag'></li>  </br> 
              <div class=info>  
         Total items
         <span><?php echo countItem('items','id'); ?></span>
         </div>
        </a>   
        </div>
    </div>
    <div class='col-md-3'>
         <div class='start start4'>
         <li class = 'fa fa-comments'></li>  </br> 
              <div class=info>total Comment
         <span>200</span>
    </div>
     </div>
    </div>
    
</div>
</div>

<div class ="container latest">
    <div class="row" >
        <div class = "col-sm-6">
             <div class= "panel panel-default">
                <div class = "panel-heading">
                    <i class = "fa fa-users"></i> Latest <?php echo $latestNumber = 7 ;?> Registerd Users
                    <span class="toggleee pull-right">
                        <i class = "fa fa-minus fa-lg "></i>
                    </span>
                </div>
              <div class="panel-body">
                     <ul class="list-unstyled latest-users">
 <?php 
           
           $latest = getLatest('*' , 'users' , 'id' , $latestNumber );
           foreach ($latest as $last){

            echo "<li>" ;
            echo  $last['userName'] ;
             echo "<span class = 'btn btn-success pull-right'>";
             echo "<i class = 'fa fa-edit'></i>";
            echo '<a href= "members.php?do=Edit&userId='.$last['id'] .'"> Edit</a>';
            echo '</span>';
            echo '</li>';


           }
           
?>
          </ul>
            </div>
            </div>
        </div>
        <div class = "col-sm-6">
             <div class= "panel panel-default">
                <div class = "panel-heading">
                    <i class = "fa fa-tag "></i> Latest  <?php echo $latestNumber = 3;?> Items
                </div>
                <div class="panel-body">
                <ul class="list-unstyled latest-users">
 <?php 
           
           $latest = getLatest('*' , 'items' , 'id' , $latestNumber );
           foreach ($latest as $last){

            echo "<li>" ;
            echo  $last['name'] ;
             echo "<span class = 'btn btn-success pull-right'>";
             echo "<i class = 'fa fa-edit'></i>";
            echo '<a href= "items.php?do=Edit&itemid='.$last['id'] .'"> Edit</a>';
            echo '</span>';
            
                    if ($last['approve'] == 0) {

          
             echo "<span class = 'btn btn-info pull-right '>";
             echo "<i class = 'fa fa-check'></i>";
            echo '<a href= "items.php?do=approve&itemid='.$last['id'] .'"> approve</a>';
            echo '</span>';
            echo '</li>';
            

                    }

           
}


           
?>
          
          </ul>
                </div>

            </div>

            
            
        </div>
        
        <div class = "col-sm-6">
             <div class= "panel panel-default">
                <div class = "panel-heading">
                    <i class = "fa fa-comments-o "></i> Latest  <?php echo $latestNumber = 3;?> comments
                </div>
                <div class="panel-body">
                <ul class="list-unstyled latest-users">
 <?php 
           


           $stmt = $con->prepare("select comments.* , users.userName
           from 
           comments 
           inner join 
           users 
           on 
           users.id = comments.member_id
           
           ");
           $stmt->execute();
           $data = $stmt->fetchAll();
           foreach ($data as $last){

            echo "<li>" ;
            
            echo  $last['userName'] ;
            echo "<span> : <span>";
            echo  $last['comment'] ;
             echo "<span class = 'btn btn-success pull-right'>";
             echo "<i class = 'fa fa-edit'></i>";
            echo '<a href= "items.php?do=Edit&itemid='.$last['id'] .'"> Edit</a>';
            echo '</span>';
            
                    if ($last['status'] == 0) {

          
             echo "<span class = 'btn btn-info pull-right '>";
             echo "<i class = 'fa fa-check'></i>";
            echo '<a href= "items.php?do=approve&itemid='.$last['id'] .'"> approve</a>';
            echo '</span>';
            echo '</li>';
            

                    }

           
}


           
?>
          
          </ul>
                </div>

            </div>

            
            
        </div>
    </div>
</div>





<?php
//end dashboard page
             include $tpl."footer.php";   
  
}
else
header ('location: index.php');
