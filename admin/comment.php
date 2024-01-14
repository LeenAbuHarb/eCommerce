<?php

session_start();
$pageTitle='Comment';
if(isset($_SESSION['UserName'])){
  include 'init.php';
  $do= isset($_GET['do'])?$_GET['do']:'Manage';

  
  
//==============================MANAGE=============================//
//==============================MANAGE=============================//
//==============================MANAGE=============================//
  if($do=='Manage'){
   
        
       $sql="SELECT comments.* ,items.Name ,users.UserName
             FROM comments
            INNER JOIN items ON items.Item_ID=comments.item_id
            INNER JOIN users ON users.UserId=comments.user_id
            order by c_id DESC  
            
             
              ";
       $result = $con->prepare($sql);
       $result->execute();
       $row=$result->fetchAll();
       if(!empty($row)){
       // $count=$result->rowCount();
    ?>
    <h1 class="text-center">Mange Comments</h1>  
    <div class="container">
     <div class="table-responsive">
        <table class="main-table table text-center table-bordered">
            <tr>
                <td>#id</td>
                <td>Comments</td>
                <td>Item Name</td>
                <td>User Name</td>
                <td>Added Date</td>
                <td>Control</td>
            </tr>
            <?php
                 
                 foreach($row as $row){
                    echo "<tr>";
                       echo "<td>" . $row['c_id'] ."</td>"; 
                       echo "<td>" . $row['comment'] ."</td>";
                       echo "<td>" . $row['Name'] ."</td>";
                       echo "<td>" . $row['UserName'] ."</td>";
                       echo "<td>" . $row['comment_date'] ."</td>";

                        echo "<td> 
                        <a href='comment.php?do=Edit&comid=".$row['c_id']."' class='btn btn-success'><i class='fa-solid fa-pen-to-square bbb'></i>Edit</a>
                        <a href='comment.php?do=Delet&comid=".$row['c_id']."'class='btn btn-danger confirmation'><i class='fa-solid fa-xmark bbb'></i>Delete</a>";
                         
                        if($row['status']==0){
                            echo "  <a href='comment.php?do=Approve&comid=".$row['c_id']."'class='btn btn-info activate '><i class='fa fa-check bbb '></i>Approve</a>";

                        }
                       echo "</td>";
                    echo "</tr>";
                 }
                 
            ?>
              
     
        
        
       
        </table>
     </div>
   </div>
      <?php          } 
      
      else{
        echo '<div class="container">';
        
      echo " <div class='nice-message'>There is no Comment to show</div>";
       ' </div>';

     }
      ?>
 <?php  } 
 



   elseif($do=='Edit'){
        $comid= isset($_GET['comid'])&&is_numeric($_GET['comid'] )?intval($_GET['comid']):0; 
          
        $sql = "SELECT * FROM comments WHERE c_id=$comid";

         $result = $con->query($sql);
         $row=$result->fetch();
         $count=$result->rowCount();

         if($count>0){ ?>

       <h1 class="text-center">Edit Comments</h1>  
        <div class="container">
            <form class="form-horizontal"  action="?do=Update" method="POST">
                <input type="hidden" name="comid" value="<?php echo $comid  ?>">
                <div  class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Comment</label>
                    <div class="col-sm-10 col-md-6">
                        <textarea class="form-control" name="comment"><?php echo $row['comment']  ?></textarea>
                    </div>
                 
              
                </div>
                <!-- ****************************** -->
              
                 <!-- ****************************** -->
                <div  class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit"class="btn btn-primary btn-lg" value="Save " >
                    </div>
                 
              
                </div>
                 <!-- ****************************** -->

            </form>
        </div>

         
   <?php  
   
    }else{
        echo "<div class='container'> ";
       $msg= '<div class="alert alert-danger"> There is no such ID</div>'; 
       redirectHome($msg);


       echo "</div> ";
    }
  }


// //*************************************************UPDSTE********************************************************* */
// //*************************************************UPDSTE********************************************************* */
elseif($do=='Update'){
  echo "<h1 class='text-center'>Update comment</h1>";
  echo"<div class='container'>";
  if($_SERVER['REQUEST_METHOD']=='POST'){
      
    $comid       =$_POST['comid'];
    $comment     =$_POST['comment'];
   
        $sql = "UPDATE comments SET comment=? WHERE c_id=?";
   
        $result = $con->prepare($sql);
        $result->execute(array($comment,$comid));
        $msg= "<div class='alert alert-success'>" . $result->rowCount() . ' Record Update </div>';
        redirectHome($msg,'back');

    

  
  }
   else{
   $msg= '<div class="alert alert-danger">Sorry you cant browes this page directly</div>';
    redirectHome($msg);

  }

  echo "</div>";
}
elseif($do=='Delet'){
         
   
    
    echo "<h1 class='text-center'>Delete Items</h1>";
    echo "<div class='container'>";

    $comid= isset($_GET['comid'])&&is_numeric($_GET['comid'] )?intval($_GET['comid']):0; 
          
    
    $check=checkItem('c_id','comments',$comid);
    

        if($check>0){
            $stmt = $con->prepare("DELETE FROM `comments` WHERE c_id= :zcomment");
            $stmt->bindParam(":zcomment",$comid);
            $stmt->execute();
            $msg= "<div class='alert alert-success isConfirmed'>" . $stmt->rowCount() . ' Record Deleted </div>';

            redirectHome($msg,'back');


        }
        else{

                $msg= '<div class="alert alert-danger">This is Not Exist</div>';
                redirectHome($msg);

            }

            echo "</div>";
// *********************************************
}
elseif($do=='Approve'){

    echo "<h1 class='text-center'>Approve Comments</h1>";
    echo "<div class='container'>";

    $comid= isset($_GET['comid'])&&is_numeric($_GET['comid'] )?intval($_GET['comid']):0; 
          
    
    $check=checkItem('c_id','comments',$comid);
    

        if($check>0){
            $stmt = $con->prepare("UPDATE `comments` SET status=1 WHERE c_id = ?");
            
            $stmt->execute(array($comid));
            $msg= "<div class='alert alert-success isConfirmed'>" . $stmt->rowCount() . ' Record Activated </div>';

            redirectHome($msg,'back');


        }
        else{

                $msg= '<div class="alert alert-danger">This is Not Exist</div>';
                redirectHome($msg);

            }

            echo "</div>";


}
 
  include $tpl.'footer.php';

}
else{
    header('Location:index.php');
    exit();
}

