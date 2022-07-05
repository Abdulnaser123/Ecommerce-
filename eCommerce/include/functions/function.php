<?php 
//title function that echo the page title in case the page
//and the variables $pageTitle and echo defult title for other pages 





function getCat(){
  global $con;
  $stmt = $con->prepare("select * from categories");
  $stmt->execute();
  $cats = $stmt->fetchAll();
  return $cats;
}

function getItems($person_id , $id,$approve = NULL ){
  
  if( $approve == 1 ){
    $sql = "AND approve = 1";
  }
  else {
    $sql =""; 
  }
  global $con;
  $stmt = $con->prepare("select * from items where $person_id = ? $sql");
  $stmt->execute(array($id));
  $items = $stmt->fetchAll();
  return $items;
}

function getAllItems() {
  
  global $con;
  $stmt = $con->prepare("select * from items where approve =1 ");
  $stmt->execute(array());
  $items = $stmt->fetchAll();
  return $items;
}


function checkActivation ($user){

  global $con;
  $stmt = $con->prepare("SELECT userName,regStatus from users 
                          where userName = ?    
                           and regStatus = 0");
  $stmt->execute(array($user));
  $status = $stmt->rowCount();
      return $status;
}



function getTitle (){
    global $pageTitle ;
    if (isset($pageTitle)) {
        echo $pageTitle ; 
    }
    else 
     {
         echo 'defult';
     }


}

//redirect function echo the error masage v1

function redirect ($errorMsg , $url=null ,$seconds = 7){

    if($url === null )

    $url = 'index.php';


    echo $errorMsg;
    echo "<div class = 'alert alert-info'>you will be redireded to $url page after $seconds seconds.</div>";

    header("refresh:$seconds ; url=$url");
    exit();
}


// function to check member username in database [ function accept parameters ]
  function checkItem ($colom , $table , $value) {

    global $con ; 
    $statement = $con->prepare("select $colom from $table where $colom = ? ");
    $statement->execute(array($value));
    $count=$statement->rowCount();
    return $count;

  }

  //count numbers of items function v1.0

  function countItem ($table , $item) {

    global $con ; 
    $stmt = $con->prepare("select count($item) from $table");
    $stmt->execute();
    return $stmt->fetchColumn(); 

  }

  //get latest element in database 

  function getLatest($select , $table , $order , $limit = 5){
      global $con  ; 
      $getStmt = $con->prepare("select $select from $table order by $order desc limit $limit ");
      $getStmt->execute();
      $rows = $getStmt->fetchAll();
      return $rows;
  }