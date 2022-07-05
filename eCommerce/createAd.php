<?php
ob_start();
session_start();

$pageTitle = "Create New Item";


include "init.php";
if(isset($_SESSION['user'])){

   

    if($_SERVER['REQUEST_METHOD']=='POST'){
        

        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $country = $_POST['country'];
        $catId = $_POST['category'];
        $status = $_POST['status'];
        $memberId = $_SESSION['id'];



              
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
    

  
    

 
// echo $id . $user . $email . $full ;
// update the database with this info


//insert into database

if (empty($formErrors)) {


  

        $stmt = $con->prepare("INSERT into
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
                    echo "done";
         
    }
    
}
    



?>
<h1 class="text-center">Create New Item</h1>

<div class="information block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">Create New Item</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8"> 
                                   



              
        <div class="container">
           <form class='form-horizontal' action ="" method="POST">

          <!-- START items name FEILD  -->
              <div class="form-group ">
             
                  <label class="col-sm-2 col-md-3 control-label" >Name</label>

                       <div class="col-sm-4 col-md-3" > 
                          <input type="text" name="name"  
                          class="form-control live-name"
                             placeholder = "name of item " />
                        </div>
               </div>
                 <!-- START descriprtion FEILD  -->
                 <div class="form-group">
              
              <label class="col-sm-2 col-md-3 control-label">description</label>
 
                   <div class="col-sm-4 col-md-3"> 
                      <input type="text" name="description"  class="form-control live-description"  placeholder="describe the category" />
            </div>
           </div>

           <!-- START price FEILD  -->
           <div class="form-group">
              
              <label class="col-sm-2 col-md-3 control-label">price</label>
 
                   <div class="col-sm-4 col-md-3"> 
                      <input type="text" name="price"  class="form-control live-price"  placeholder="price of the items" />
           </div>
           </div>
             <!-- START country made FEILD  -->
             <div class="form-group">
              
              <label class="col-sm-2 col-md-3 control-label">country</label>
 
                   <div class="col-sm-4 col-md-3"> 
                      <input type="text" name="country"  class="form-control"  placeholder="country of made" />
           </div>
           </div>
            <!-- START status FEILD  -->
            <div class="form-group">
              
              <label class="col-sm-2 col-md-3 control-label">status</label>
 
                   <div class="col-sm-4 col-md-3"> 
                                    <select name="status" class='form-select' id="">
                                        <option value="0">...</option>
                                        <option value="1">New</option>
                                        <option value="2">Like New</option>
                                        <option value="3">Used</option>
                                        <option value="4">Refreshed</option>
                                    </select>
                    </div>
                    </div>
               

            <!-- START status FEILD  -->

                    <div class="form-group">
                    <label class="col-sm-2 col-md-3 control-label">categories</label>
 
                   <div class="col-sm-4 col-md-3"> 
                   <select name = "category" class="form-select">
                                      
                   <?php
                   $stmt = $con->prepare("select * from categories");
                   $stmt->execute();
                   $cats=$stmt->fetchAll();
                   foreach($cats as $cat){

                    echo '<option  name = "category" value = "'.$cat['id'].'">' . $cat['name'] . ' </option>';

                   }
                   ?>
                   </select>

                                   
                    </div>
                    </div>


                   

                                   <!-- START submit FEILD  -->
                                 
               <div class="form-group">
                   <div class="col-sm-offset-3 col-md-8 "> 
                      <input type="submit"   value="add item" class="btn btn-primary btn-md " />
                    </div>
           </div>

           </form>

    
           
<?php
          
        

?>

       </div>



                                    <!-- START ADS FEILD  -->

                                    </div>


                                <div class="col-md-4">
                                <div class="thumbnil live-preview">
                                <div class="before-price"></div><span class = "price">$0</span>
                                <img class = "img-responsive" src="profile.png" alt="" />
                                <div class="caption">
                                <h3 class="center">Tilte</h3>
                                <p>Description</p>
                            
                              </div>
                            </div>
                         </div>
                     </div>
                 </div>
             </div>
        </div>
    </div>
</div>
    
<?php
if(!empty($formErrors)){
foreach($formErrors as $error){
    echo '<span class="panel panel-danger">'.$error.'<span>';
}   
}


}
else
{
    header('Location: login.php');
    exit();
}


include $tpl."footer.php";
ob_end_flush();


?>


