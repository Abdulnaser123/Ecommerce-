<?php
session_start();
 $pageTitle='';

 if(isset($_SESSION['username'])){
     include 'init.php';
     $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

     if($do == 'manage'){

                 


                      $stmt = $con->prepare("select 
                      items.*,
                      categories.name as category_name,
                      users.userName as USERNAME
                      from 
                      items
                      inner join
                      categories 
                      on
                      categories.id=items.cat_id
                      inner join 
                      users
                      on 
                      users.id = items.member_id
                      ");
                      $stmt->execute();
                      $items = $stmt->fetchAll();
                      ?>
                <h1 class = "text-center">manage Items</h1>
                <div class="container">
                <div class="table-responsive">
                <table class="main text-center table table-bordered">
                <tr>
                  <td>ID</td>
                  <td>name</td>
                  <td>description</td>
                  <td>price</td>
                  <td>adding date</td>
                  <td>Category</td>
                  <td>Username</td>
                  <td>control</td>
                </tr>

                <?php

                foreach ($items as $item){

                  if ($item['add-date']==null){
                    $item['add-date'] = 'Unknown DATE .REG';
                  }

                  echo '<tr>';
                  echo "<td>". $item['id'] . "</td>" ;

                  echo "<td>". $item['name'] . "</td>" ;
                  echo "<td>". $item['description'] . "</td>" ;
                  echo "<td>". $item['price'] . "</td>" ;
                  echo "<td>" . $item['add-date'] .  "</td>";
                  echo "<td>" . $item['category_name'] .  "</td>";
                  echo "<td>" . $item['USERNAME'] .  "</td>";

                  echo "<td>
                  <a href='items.php?do=Edit&itemid=".$item['id']."' class='btn btn-success'> <i class='fa fa-edit'></i>Edit</a>
                  <a href='items.php?do=delete&itemid=".$item['id']."' class='btn btn-danger confirm'> <i class='fa fa-close'></i> Delete</a>";
                  if($item['approve'] == 0){
                    echo  "<a href='items.php?do=approve&itemid=".$item['id']."' class='btn btn-info activate'> <i class='fa fa-check'></i>Approve</a>";
                 
                   }

                  echo "</td>" ;

                  echo '<tr>';

                  
              }
     ?>
     </table>
     
     </div>
     <a href="items.php?do=Add" class ="btn btn-outline-primary btn-add-member"> <i class="fa fa-plus">  add new items</i> </a>
     
     </div>
     
     
     
     <?php
     }
     elseif($do == 'Add'){

        ?>


        <h1 class='text-center'> Add New Item  </h1>


        <div class="container">
           <form class='form-horizontal' action ="?do=insert" method="POST">

          <!-- START items name FEILD  -->
              <div class="form-group form-group-lg">
             
                  <label class="col-sm-2 col-md-6 control-label" >name</label>

                       <div class="col-sm-10 col-md-10" > 
                          <input type="text" name="name"  class="form-control"   placeholder = "name of item "/>
                        </div>
               </div>
                 <!-- START descriprtion FEILD  -->
                 <div class="form-group">
              
              <label class="col-sm-2 control-label">description</label>
 
                   <div class="col-sm-10 col-md-10"> 
                      <input type="text" name="description"  class="form-control"  placeholder="describe the category" />
            </div>
           </div>

           <!-- START price FEILD  -->
           <div class="form-group">
              
              <label class="col-sm-2 control-label">price</label>
 
                   <div class="col-sm-10 col-md-10"> 
                      <input type="text" name="price"  class="form-control"  placeholder="price of the items" />
           </div>
           </div>
             <!-- START country made FEILD  -->
             <div class="form-group">
              
              <label class="col-sm-2 control-label">country</label>
 
                   <div class="col-sm-10 col-md-10"> 
                      <input type="text" name="country"  class="form-control"  placeholder="country of made" />
           </div>
           </div>
            <!-- START status FEILD  -->
            <div class="form-group">
              
              <label class="col-sm-2 control-label">status</label>
 
                   <div class="col-sm-10 col-md-10"> 
                                    <select name="status" class='form-select' id="">
                                        <option value="0">...</option>
                                        <option value="1">New</option>
                                        <option value="2">Like New</option>
                                        <option value="3">Used</option>
                                        <option value="4">Refreshed</option>
                                    </select>
                    </div>
                    </div>
                    <label class="col-sm-2 control-label">Members</label>
 
                   <div class="col-sm-10 col-md-10"> 
                   <select  name = "memberId" class="form-select">                 
                   <?php
                   $stmt = $con->prepare("select * from users");
                   $stmt->execute();
                   $users=$stmt->fetchAll();
                   foreach($users as $user){

                    echo '<option  value = "'.$user['id'].'">' . $user['userName'] . ' </option>';

                   }
                   ?>
                   </select>

                                   
                    </div>
                    <label class="col-sm-2 control-label">categories</label>
 
                   <div class="col-sm-10 col-md-10"> 
                   <select name = "catId" class="form-select">
                                      
                   <?php
                   $stmt = $con->prepare("select * from categories");
                   $stmt->execute();
                   $cats=$stmt->fetchAll();
                   foreach($cats as $cat){

                    echo '<option  value = "'.$cat['id'].'">' . $cat['name'] . ' </option>';

                   }
                   ?>
                   </select>

                                   
                    </div>


                   

                                   <!-- START submit FEILD  -->
                                 <br>  
               <div class="form-group">
              
 
                   <div class="col-sm-10 col-md-10 "> 
                      <input type="submit"   value="add item" class="btn btn-primary btn-lg" />
                    </div>
           </div>

           </form>
       </div>

       


        <?php

     }
     elseif($do == 'insert'){

          
        if($_SERVER["REQUEST_METHOD"] == "POST") {

            echo "<h1 class='text-center'> Insert Item </h1>";
        echo "<div class = 'container' >";
  
          // get the variabels from the form 
          $name = $_POST["name"];
          $description = $_POST["description"];
          $price = $_POST["price"];
          $country = $_POST["country"];
          $status = $_POST["status"];
          $memberId = $_POST['memberId'];
          $catId = $_POST['catId'];
          //$date = $_POST["date"];





      
//form validation
$formErrors = array();

            if (empty($name)){
                $formErrors[] ='<div class="alert alert-danger" role="alert">
                name can\'t be <strong>empty</strong></div>';  
            }

          if (empty ($description)){
              $formErrors[] ='<div class="alert alert-danger" role="alert">
              description can\'t be <strong>empty</strong></div>';  
              
          }
          if(empty($price)){
            $formErrors[] = '<div class="alert alert-danger" role="alert">
            price can\'t be <strong>empty</strong>
          </div>';  
          }
          if(empty($country)){
            $formErrors[] = '<div class="alert alert-danger" role="alert">
            country of made can\'t be <strong>empty</strong>
          </div>';  
          }

          if($status == 0){
            $formErrors[] = '<div class="alert alert-danger" role="alert">
            status of item can\'t be <strong>empty</strong> you must chose 
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

           
              
              $stmt = $con->prepare("insert into
              items(name , description , price , `country-made` ,`status`,`add-date`,cat_id,member_id	)
               VALUES(:zname , :zdesc , :zprice , :zcountry ,:zstatus,now() , :zcatId,:zmemberId )");
               
               $stmt->execute(array(
                     ':zname' => $name,
                     ':zdesc' =>$description ,
                     ':zprice' =>$price , 
                     ':zcountry'  =>$country, 
                     ':zstatus' => $status,
                     ':zcatId' => $catId,
                     ':zmemberId' => $memberId
                    ));
             $msg = "<div class='alert alert-success'>" .$stmt->rowCount() . 'record update</div>' ;
             redirect($msg , 'items.php' , 6);

        
      }
  
        }
        else{
         
          $errorMsg = "<div class = 'alert alert-danger'>u can\'t browse this page directly</div>";
            
          redirect ($errorMsg ,'dashboard.php' ,6);
      }
      echo "</div>";

    }
        
     elseif($do == 'Edit'){

       //check if user id is numeric and it exist
       if (isset($_GET["itemid"]) && is_numeric($_GET["itemid"])) 
       $itemid = $_GET["itemid"];
       else
       $itemid = 0;



       $stmt = $con->prepare("select * from items where id = ? LIMIT 1 ");
       $stmt->execute(array($itemid));
               $item=$stmt ->fetch();
       $count = $stmt -> rowCount();

       if ($count > 0 ) {  ?>


        <h1 class='text-center'> Edit The Item  </h1>


        <div class="container">
           <form class='form-horizontal' action ="?do=update" method="POST">
         <input type="hidden" name="itemid" value="<?php echo $_GET["itemid"] ?>"> 

          <!-- START items name FEILD  -->
              <div class="form-group form-group-lg">
             
                  <label class="col-sm-2 col-md-6 control-label" >name</label>

                       <div class="col-sm-10 col-md-10" > 
                          <input value = "<?PHP echo $item['name'] ?>" type="text" name="name"  class="form-control"   placeholder = "name of item "/>
                        </div>
               </div>
                 <!-- START descriprtion FEILD  -->
                 <div class="form-group">
              
              <label class="col-sm-2 control-label">description</label>
 
                   <div class="col-sm-10 col-md-10"> 
                      <input value = "<?PHP echo $item['description'] ?>" type="text" name="description"  class="form-control"  placeholder="describe the category" />
           </div>

           <!-- START price FEILD  -->
           <div class="form-group">
              
              <label class="col-sm-2 control-label">price</label>
 
                   <div class="col-sm-10 col-md-10"> 
                      <input value = "<?PHP echo $item['price'] ?>" type="text" name="price"  class="form-control"  placeholder="price of the items" />
           </div>
             <!-- START country made FEILD  -->
             <div class="form-group">
              
              <label class="col-sm-2 control-label">country</label>
 
                   <div class="col-sm-10 col-md-10"> 
                      <input value = "<?PHP echo $item['country-made'] ?>" type="text" name="country"  class="form-control"  placeholder="country of made" />
           </div>
            <!-- START status FEILD  -->
            <div class="form-group">
              
              <label class="col-sm-2 control-label">status</label>
 
                   <div class="col-sm-10 col-md-10"> 
                                    <select name="status" class='form-select' id="">
                                        <option value="1"  <?PHP if($item['status']==1) echo 'selected'; ?> >New</option>
                                        <option value="2" <?PHP if($item['status']==2) echo 'selected'; ?> >Like New</option>
                                        <option value="3" <?PHP if($item['status']==3) echo 'selected'; ?> >Used</option>
                                        <option value="4" <?PHP if($item['status']==4) echo 'selected'; ?> >Refreshed</option>
                                    </select>
                    </div>
                    <label class="col-sm-2 control-label">Members</label>
 
                   <div class="col-sm-10 col-md-10"> 
                   <select  name = "memberId" class="form-select">
                                      
                   <?php
                     
                   $stmt = $con->prepare("select * from users");
                   $stmt->execute();
                   $users=$stmt->fetchAll();
                   foreach($users as $user){

                    echo '<option  value = "'.$user['id'].'"'; 
                    if($item['member_id'] == $user['id']) echo 'selected';
                    echo '>' . $user['userName'] . ' </option>';

                   }
                   ?>
                   </select>

                                   
                    </div>
                    <label class="col-sm-2 control-label">categories</label>
 
                   <div class="col-sm-10 col-md-10"> 
                   <select name = "catId" class="form-select">
                                      
                   <?php
                   $stmt = $con->prepare("select * from categories");
                   $stmt->execute();
                   $cats=$stmt->fetchAll();
                   foreach($cats as $cat){

                    echo '<option  value = "'.$cat['id'].'"'; 
                    if($item['cat_id'] == $cat['id']) echo 'selected';
                    echo '>' . $cat['name'] . ' </option>';
                   }
                   ?>
                   </select>

                                   
                    </div>


                   

                                   <!-- START submit FEILD  -->
                                 <br>  
               <div class="form-group">
              
 
                   <div class="col-sm-10 col-md-10 "> 
                      <input type="submit"   value="add item" class="btn btn-primary btn-lg" />
                    </div>
           </div>

           </form>

<?php


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
where item_id = ? 
");

       $stmt->execute(array($itemid));
$data = $stmt->fetchAll();

if(!empty ($data)){
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

?>
           
       </div>

       


        <?php





     }
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


      echo "<h1 class='text-center'> Update Item </h1>";
      echo "<div class = 'container' >";
      
      if($_SERVER["REQUEST_METHOD"] == "POST") {
  
        // get the variabels from the form 
        $id = $_POST["itemid"];
        $name = $_POST["name"];
        $description = $_POST["description"];
        $country = $_POST["country"];
        $price = $_POST["price"];
        $status = $_POST["status"];
        $memberId = $_POST["memberId"];
        $catId = $_POST["catId"];


  
  
  
    
  //form validation
  $formErrors = array();
  
      
  
        if (empty ($name)){
            $formErrors[] ='<div class="alert alert-primary" role="alert">
            item name can\'t be empty    
            </div>';  
        }
        if(empty($description)){
          $formErrors[] = '<div class="alert alert-primary" role="alert">
          description can\'t br empty
        </div>';  
        }
        if(empty($price)){
          $formErrors[] = '<div class="alert alert-primary" role="alert">
          price can\'t be empty
        </div>';  
        }
        if(empty($country)){
          $formErrors[] = '<div class="alert alert-primary" role="alert">
          country of item can\'t be empty
        </div>';  
        }
        if(empty($memberId)){
          $formErrors[] = '<div class="alert alert-primary" role="alert">
          member id can\'t be empty
        </div>';  
        }
        if(empty($catId)){
          $formErrors[] = '<div class="alert alert-primary" role="alert">
          category name can\'t be empty
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
        items
         SET
         `name` = ? , `description` = ? , price = ? ,
         cat_id = ? ,member_id =? , `status` = ? ,
         `country-made` = ?  
           where
       id = ? ");
      //  $stmt-> execute(arrary());
        $stmt->execute(array( $name ,$description ,$price,
                    $catId, $memberId ,$status ,$country,$id ));
  
        //echo success maseage
        $errorMsg = "<div class='alert alert-success'>" .$stmt->rowCount() . 'record update</div>' ;
  
        redirect ($errorMsg  , 'items.php' , 4);
      }
  }
      else{
         
        $errorMsg = "<div class = 'alert alert-danger'>u can\'t browse this page directly</div>";
              
        redirect ($errorMsg, null,6);
      }
      echo "</div>";

   
     }
     elseif($do == 'delete'){


      
      echo "<h1 class='text-center'> Delete Items </h1>";
      echo "<div class = 'container' >";
    
         //check if user id is numeric and it exist
         if (isset($_GET["itemid"]) && is_numeric($_GET["itemid"])) 
         $id = $_GET["itemid"];
         else
         $id = 0;
         $stmt = $con->prepare("select * from items where id = ? LIMIT 1 ");
         $stmt->execute(array($id));
         $count = $stmt-> rowCount();
    
         if ($count > 0 ) {
           $stmt = $con -> prepare("delete from items where id = :zid");
             $stmt->bindParam(":zid",$id);
             $stmt->execute();
             $msg = "<div class='alert alert-success'>" .$stmt->rowCount() . 'record deleted</div>' ;
    
             redirect($msg , 'items.php' , 6);
    
         }
    
         echo "</div>";
    
  
         

     }
     elseif ($do == 'approve'){


      echo "<h1 class='text-center'> Approve item </h1>";
      echo "<div class = 'container' >";
    
         //check if user id is numeric and it exist
         if (isset($_GET["itemid"]) && is_numeric($_GET["itemid"])) 
         $itemid = $_GET["itemid"];
         else
         $itemid= 0;

         $check = checkItem ('id' , 'items' , $itemid) ;
    
         if ($check > 0 ) {
           $stmt = $con-> prepare("update items set approve =1 where id = ? ");
             $stmt->execute(array($itemid));
             $msg = "<div class='alert alert-success'>" .$stmt->rowCount() . 'record approved</div>' ;
    
             redirect($msg , 'items.php' , 3);
    
         }
    
         echo "</div>";
    
    

     }
     include $tpl . 'footer.php';
 }
 else 
 {
   header('location: index.php');
   exit() ; 
}
