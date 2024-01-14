<?php

function getِAllFrom($field, $table,string $where = NULL, string $and= NULL,$order, $ordering ="DESC"){

    global $con;

    $getAll=$con->prepare("SELECT $field FROM $table $where $and ORDER BY $order $ordering");
    $getAll->execute();
    return $getAll->fetchAll();


}

    function title(){

       global $pageTitle;
       if (isset($pageTitle)){
           echo $pageTitle;
       }

       else{
           echo 'Default';
       }
    }

// Redirect function echo the error message
function redirectHome($msg, $url=null, $seconde=3){
     
    if($url=== null){
        $url="index.php";
        $link='Home page';
    }
   else{
            if(isset($_SERVER['HTTP_REFERER'])&& $_SERVER['HTTP_REFERER'] !== '' ){
                $url=$_SERVER['HTTP_REFERER'];
                $link='Previose page';
            }
            else{
                $url="index.php";
                $link='Home page';


            }
    
   }
    echo $msg;
    echo "<div class='alert alert-info'>You will be Redirected to $link after $seconde seconds. </div>";
    header("refresh:$seconde;url=$url");
    exit();
}

// function to check Item in database

    function checkItem($select,$from,$value){
        global $con;

        $stmt2=$con->prepare("SELECT $select FROM $from WHERE $select=?");
        $stmt2->execute(array($value));
        $count=$stmt2->rowCount();
        return $count;
    }

// count # of Item 

function countItem($item,$table){
 
    global $con;
       $stmt=$con->prepare("SELECT COUNT($item) FROM $table");
        $stmt->execute();
        return $stmt->fetchColumn();

}


function getLatest($select,$table,$order,$limit=5){

    global $con;

    $getStmt=$con->prepare("SELECT $select FROM $table ORDER by $order LIMIT $limit");
    $getStmt->execute();
    return $getStmt->fetchAll();


}