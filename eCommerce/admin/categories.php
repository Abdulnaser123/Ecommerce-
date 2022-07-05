<?php
session_start();
 $pageTitle='';

 if(isset($_SESSION['username'])){
     include 'init.php';
     $do = isset($_GET['do']) ? $_GET['do'] : 'manage';

     if($do == 'manage'){

        $sort="ASC";
        $sort_array = array('ASC','DESC');
        if (isset($_GET['sort']) && in_array($_GET['sort'] , $sort_array ))
        {
            $sort = $_GET['sort'];
        }

        $stmt = $con->prepare("select * from categories order by ordering $sort");
        $stmt->execute();
        $cats=$stmt->fetchAll();

    
        ?>
        
<h1 class="text-center">Manage Categories </h1>
<div class = "container categories">
    <div class = "panel panel-default">
        <div class = "panel panel-heading"> <i class='fa fa-edit' > </i> Manage Categories
        <div class= "ordering pull-right">
        <i class = 'fa fa-sort'></i> Ordering 
        <a class= "<?php if($sort == 'ASC') echo 'active'; ?>" href="?sort=ASC">ASC </a>
        <span>|</span>
        <a class="<?php if($sort == 'DESC') echo 'active'; ?>" href="?sort=DESC">DESC</a>
    </div>
        </div>
        <div class="panel-body">
            <?php
          foreach ($cats as $category){
            
            
    echo "<div class = 'cats'>";

                
              
              
                echo '<h3>';
                
                echo "<div class = 'btn-hidden'>";
                echo '<a href="categories.php?do=Edit&catId='.$category['id'].'" class="btn btn-xs btn-primary"><i class="fa fa-edit">Edit</i></a>';
                echo '<a href="categories.php?do=delete&catId='.$category['id'].'"" class="btn btn-xs btn-danger confirm"><i class="fa fa-close">Delete</i></a>';
                echo "</div>"
                
                
                .$category['name'].'</h3>';


                //full view div 
              echo '<div class= "full-view">' ; 
                        if(!empty( $category['description'])) echo "<p>". $category['description']."</p>";
                        // echo "<span>Ordering Is ".$category['ordering']."</span>".'</br>';
                        if($category['visibility']==1) echo "<span class = 'visibility'><i class='fa fa-eye'></i>Hidden"."</span>";
                        if( $category['allow_comment']==1) echo "<span class = 'comment'><i class = 'fa fa-close'></i>Comment Is Disable</span>";
                        if( $category['ads']==1) echo "<span class= 'ads'><i class = 'fa fa-close'></i>Advertise Is Disable</span>";
              echo "</div>";
    echo "</div>";


      
             
          }
        echo '</div>';
          echo '<a href="categories.php?do=Add" class ="btn btn-outline-primary btn-add-member "> <i class="fa fa-plus">  add new member</i> </a>';
          
         echo '</div>';
          ?>
     
          
        </div>
    
    </div>
   
</div>

<?php
     }
     elseif($do == 'Add'){
         ?>


         <h1 class='text-center'> Add New Category  </h1>


         <div class="container">
            <form class='form-horizontal' action ="?do=insert" method="POST">
                <!-- <input type="hidden" name="userid" value="<?php echo $_GET["userId"] ?>"> -->
 
           <!-- START USERNAME FEILD  -->
               <div class="form-group form-group-lg">
              
                   <label class="col-sm-2 col-md-6 control-label" >name</label>
 
                        <div class="col-sm-10 col-md-10" > 
                           <input type="text" name="name"  class="form-control" required = "required"  autocomplete="off"  placeholder = "name of category "/>
                         </div>
                </div>
 
                    <!-- START descriprtion FEILD  -->
               <div class="form-group">
              
              <label class="col-sm-2 control-label">description</label>
 
                   <div class="col-sm-10 col-md-10"> 
                      <input type="text" name="description" class="form-control"  placeholder="describe the category" />
           </div>
 
               <!-- START ordering FEILD  -->
               <div class="form-group form-group-lg">
              
                   <label class="col-sm-2 control-label">Ordering</label>
 
                        <div class="col-sm-10 col-md-10"> 
                           <input type="text" name="ordering"   class="form-control" placeholder = "ordering"/>
                         </div>
                </div>
 
                   <!-- START visibility FEILD  -->
               <div class="form-group">
              
              <label class="col-sm-2 control-label">visibile</label>
 
                   <div class="col-sm-10 col-md-10" > 
                       <div>
                           <input id="yes" type="radio" name = "visibility" value = "1"  checked/>
                           <label for="yes">YES</label>
                       </div>
                       <div>
                       <input id = "no"type="radio" name = "visibility" value = "0"  />
                           <label for="no">NO</label>
                       </div>
                    </div>
                 
                    </div>
                    <label class="col-sm-2 control-label">Allow commenting</label>

                    <div class="col-sm-10 col-md-10" > 
                    <div>
                           <input id="cyes" type="radio" name = "commenting" value = "1" checked />
                           <label for="cyes">YES</label>
                       </div>
                       <div>
                       <input id = "cno"type="radio" name = "commenting" value = "0"  />
                           <label for="cno">NO</label>
                       </div>
                    </div>
                    <label class="col-sm-2 control-label">Allow Ads</label>

<div class="col-sm-10 col-md-10" > 
<div>
       <input id="ayes" type="radio" name = "ads" value = "1" checked />
       <label for="ayes">YES</label>
   </div>
   <div>
   <input id = "ano"type="radio" name = "ads" value = "0"  />
       <label for="ano">NO</label>
   </div>
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
     elseif($do == 'insert'){

        if($_SERVER["REQUEST_METHOD"] == "POST") {

            echo "<h1 class='text-center'> Insert Category </h1>";
        echo "<div class = 'container' >";
  
          // get the variabels from the form 
          $name = $_POST["name"];
          $description = $_POST["description"];
          $ordering = $_POST["ordering"];
          $visibility = $_POST["visibility"];
          $commenting =$_POST["commenting"];
          $ads = $_POST['ads'];

 
          //check if category in database

              if (checkItem ('name' , 'categories' , $name) == 1  ) {
                $msg = "<div class='alert alert-danger'>this category is alredy exist </div>";
                redirect($msg , 'members.php' , 6);
                 }
              else {
              
            $stmt = $con->prepare("insert into
            categories(name , description , ordering , visibility,allow_comment,ads)
             VALUES(:zname , :zdesc , :zordering , :zvizibility ,:zcommenting,:zads)");
             
             $stmt->execute(array(
                   ':zname' => $name,
                   ':zdesc' =>$description ,
                   ':zordering' =>$ordering , 
                   ':zvizibility'  =>$visibility, 
                   ':zcommenting' => $commenting,
                   ':zads'=>$ads));

             $msg = "<div class='alert alert-success'>" .$stmt->rowCount() . 'record update</div>' ;
             redirect($msg , 'members.php' , 6);

        }
      }
  
        
        else{
         
          $errorMsg = "<div class = 'alert alert-danger'>u can\'t browse this page directly</div>";
            
          redirect ($errorMsg ,'members.php' ,6);
      }
      echo "</div>";

        
     }
     elseif($do == 'Edit'){

         //check if caetgoty id is numeric and it exist
         if (isset($_GET["catId"]) && is_numeric($_GET["catId"])) 
         $catId = $_GET["catId"];
         else
         $catId = 0;
 
 
         $stmt = $con->prepare("select * from categories where id = ? LIMIT 1 ");
         $stmt->execute(array($catId));
                
         $cat=$stmt->fetch();
         $count = $stmt -> rowCount();
 
         if ($count > 0 ) { ?>



<h1 class='text-center'> Edit Category  </h1>


<div class="container">
   <form class='form-horizontal' action ="?do=update" method="POST">
       <input type="hidden" name="catId" value="<?php echo $catId; ?>"> 

  <!-- START USERNAME FEILD  -->
      <div class="form-group form-group-lg">
     
          <label class="col-sm-2 col-md-6 control-label" >name</label>

               <div class="col-sm-10 col-md-10" > 
                  <input type="text" name="name"  class="form-control"  value= <?PHP echo $cat['name']?>  placeholder = "name of category "/>
                </div>
       </div>

           <!-- START descriprtion FEILD  -->
      <div class="form-group">
     
     <label class="col-sm-2 control-label">description</label>

          <div class="col-sm-10 col-md-10"> 
             <input type="text" name="description" class="form-control"  placeholder="you can Edit the category description" />
  </div>

      <!-- START ordering FEILD  -->
      <div class="form-group form-group-lg">
     
          <label class="col-sm-2 control-label">Ordering</label>

               <div class="col-sm-10 col-md-10"> 
                  <input type="text" name="ordering"   class="form-control" value=<?PHP echo $cat['ordering']?> />
                </div>
       </div>

          <!-- START visibility FEILD  -->
      <div class="form-group">
     
     <label class="col-sm-2 control-label">visibile</label>

          <div class="col-sm-10 col-md-10" > 
              <div>
                  <input id="yes" type="radio" name = "visibility" value = "1" <?PHP if($cat['visibility']==1)  echo 'checked'; ?>  checked/>
                  <label for="yes">YES</label>
              </div>
              <div>
              <input id = "no"type="radio" name = "visibility" value = "0" <?PHP if($cat['visibility']==0)  echo 'checked'; ?> />
                  <label for="no">NO</label>
              </div>
           </div>
        
           </div>
           <label class="col-sm-2 control-label">Allow commenting</label>

           <div class="col-sm-10 col-md-10" > 
           <div>
                  <input id="cyes" type="radio" name = "commenting" value = "1" <?PHP if($cat['allow_comment'=='1'])  echo 'checked'; ?> />
                  <label for="cyes">YES</label>
              </div>
              <div>
              <input id = "cno"type="radio" name = "commenting" value = "0" <?PHP if($cat['allow_comment'=='0'])  echo 'checked'; ?> />
                  <label for="cno">NO</label>
              </div>
           </div>
           <label class="col-sm-2 control-label">Allow Ads</label>

<div class="col-sm-10 col-md-10" > 
<div>
<input id="ayes" type="radio" name = "ads" value = "1" <?PHP if($cat['ads'=='1'])  echo 'checked'; ?> />
<label for="ayes">YES</label>
</div>
<div>
<input id = "ano"type="radio" name = "ads" value = "0" <?PHP if($cat['ads'=='0'])  echo 'checked'; ?> />
<label for="ano">NO</label>
</div>
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
         else
         {
           echo "<div class='container'>";
             $msg = "<div class = 'alert alert-danger'>NO user Id</div>";
             redirect($msg , null , 6);
             echo "</div>";
         } 
     }
 

     
     elseif($do == 'update') {
    
        echo "<h1 class='text-center'> Update Cateroty </h1>";
        echo "<div class = 'container' >";
        
        if($_SERVER["REQUEST_METHOD"] == "POST") {
    
          // get the variabels from the form 
          $Id = $_POST["catId"];
          $catName = $_POST["name"];
          $desc = $_POST["description"];
          $ordering = $_POST["ordering"];

          $visible = $_POST["visibility"];
          $comment = $_POST["commenting"];
          $ads = $_POST["ads"];
    
    
          
      
  
        $stmt = $con->prepare
         ("UPDATE
          categories
           SET
          `name` = ? , `description` = ? , ordering = ? , visibility = ? ,allow_comment = ?, ads = ?
             where
         id = ? ");
        //  $stmt-> execute(arrary());
          $stmt->execute(array($catName , $desc ,$ordering ,$visible, $comment , $ads ,$Id ));
    
          //echo success maseage
          $errorMsg = "<div class='alert alert-success'>" .$stmt->rowCount() . 'record update</div>' ;
    
          redirect ($errorMsg  , 'categories.php' , 4);
        }
    
        else{
           
          $errorMsg = "<div class = 'alert alert-danger'>u can\'t browse this page directly</div>";
                
          redirect ($errorMsg, null,6);
        }
        echo "</div>";
  
        
     }
    
     elseif($do == 'delete'){

        echo "<h1 class='text-center'> Delete Category </h1>";
    echo "<div class = 'container' >";
  
       //check if user id is numeric and it exist
       if (isset($_GET["catId"]) && is_numeric($_GET["catId"])) 
       $id = $_GET["catId"];
       else
       $id = 0;
       $stmt = $con->prepare("select * from categories where id = ? LIMIT 1 ");
       $stmt->execute(array($id));
       $count = $stmt-> rowCount();
  
       if ($count > 0 ) {
         $stmt = $con -> prepare("delete from categories where id = :zid");
           $stmt->bindParam(":zid",$id);
           $stmt->execute();
           $msg = "<div class='alert alert-success'>" .$stmt->rowCount() . 'record deleted</div>' ;
  
           redirect($msg , 'categories.php' , 6);
  
       }
  
       echo "</div>";
  
  

     }
     elseif ($do == 'activate'){

     }
     include $tpl . 'footer.php';
 }
 else 
 {
   header('location: dashboard.php');
   exit() ; 
}
