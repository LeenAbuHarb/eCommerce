<?php

session_start();
$pageTitle='Member';
if(isset($_SESSION['UserName'])){
  include 'init.php';
  $do= isset($_GET['do'])?$_GET['do']:'Manage';

  
  
//==============================MANAGE=============================//
//==============================MANAGE=============================//
//==============================MANAGE=============================//
  if($do=='Manage'){
    $query='';
    if(isset($_GET['page'])&& $_GET['page']=='Pending'){
        $query='AND RegStatus=0';
    }
    // select all users exept admin
        $value="leen";
        checkItem("UserName","users",$value );
        
       $sql="SELECT * FROM users WHERE GroupId != 1 $query Order by UserId DESC ";
       $result = $con->prepare($sql);
       $result->execute();
       $row=$result->fetchAll();
       if(!empty( $row)){
    ?>
    <h1 class="text-center">Mange Member</h1>  
    <div class="container">
     <div class="table-responsive">
        <table class="main-table manage-member table text-center table-bordered">
            <tr>
                <td>#Id</td>
                <td>Avatar</td>
                <td>Username</td>
                <td>Email</td>
                <td>Full Name</td>
                <td>Register Date</td>
                <td>Control</td>
            </tr>
            <?php
                 
                 foreach($row as $row){
                    echo "<tr>";
                       echo "<td>" . $row['UserId'] ."</td>"; 
                       echo "<td>";
                       if(empty($row['avatar'])){
                        echo "<img src='upload/avatar/22-223863_no-avatar-png-circle-transparent-png.png' alt=''/>";
                       }
                       else{
                            echo "<img src='upload/avatar/" . $row['avatar'] ."' alt=''/>";
                       }
                       echo "</td>";
                       echo "<td>" . $row['UserName'] ."</td>";
                       echo "<td>" . $row['Email'] ."</td>";
                       echo "<td>" . $row['FullName'] ."</td>";
                       echo "<td>" . $row['TheDate'] ."</td>";

                        echo "<td> 
                        <a href='member.php?do=Edit&userid=".$row['UserId']."' class='btn btn-success'><i class='fa-solid fa-pen-to-square bbb'></i>Edit</a>
                        <a href='member.php?do=Delet&userid=".$row['UserId']."'class='btn btn-danger confirmation'><i class='fa-solid fa-xmark bbb'></i>Delete</a>";
                         
                        if($row['RegStatus']==0){
                            echo "  <a href='member.php?do=Activate&userid=".$row['UserId']."'class='btn btn-info activate'><i class='fa-solid fa-address-book bbb'></i>Activate</a>";

                        }
                       echo "</td>";
                    echo "</tr>";
                 }
                 
            ?>
              
     
        
                <tr>
            </table>
     </div>
                <a href="member.php?do=Add" class="btn btn-primary"><i class="fa fa-plus bbb"></i>New Member</a>
                </div>
       
     
         <?php } 
         else{
            echo '<div class="container">';
            
          echo " <div class='nice-message'>There is no Members to show</div>";
           ' </div>';
           echo '    <a href="member.php?do=Add" class="btn btn-primary"><i class="fa fa-plus bbb"></i>New Member</a>
           ';
         }
         
         
         ?>
        
   </div>
 <?php  } 
   elseif($do=='Add'){?>
    <!-- add member page  -->
    <h1 class="text-center">Add new Member</h1>  
    <div class="container">
        <form class="form-horizontal"  action="?do=Insert" method="POST" enctype="multipart/form-data">
            <!-- <input type="hidden" name="userid" value="<?php echo $userid  ?>"> -->
            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Username</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text" name="username"class="form-control" autocomplete="off" required="required"placeholder="Username to login into shop ">
                </div>
             
          
            </div>
            <!-- ****************************** -->
            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10 col-md-6">
                    <input type="password" id="password" name="Password"class="password form-control" placeholder="Passwprd must ve hard"required="required">
                    <i class="show-pass fa-solid fa-eye" id="showPasswordLink"></i>
                </div>
             
          
            </div>

            <!-- ****************************** -->

            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10 col-md-6">
                    <input type="email" name="Email"class="form-control" required="required" placeholder="Email must be valid">
                </div>
             
          
            </div>
             <!-- ****************************** -->
            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Full name</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text" name="full"class="form-control" required="required" placeholder="Full name appear in your profile page">
                </div>
             
          
            </div>
             <!-- ****************************** -->
            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">User Avatar</label>
                <div class="col-sm-10 col-md-6">
                    <input type="file" name="avatar"class="form-control" required="required" >
                </div>
             
          
            </div>
             <!-- ****************************** -->
            <div  class="form-group form-group-lg">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit"class="btn btn-primary btn-lg" value="Add Member " >
                </div>
             
          
            </div>
             <!-- ****************************** -->

        </form>
    </div>
<?php
}

elseif($do=='Insert'){
    // echo $_POST['username'] . $_POST['Password'] . $_POST['Email'] . $_POST['full'];

    if($_SERVER['REQUEST_METHOD']=='POST'){
            
        echo "<h1 class='text-center'>Insert Member</h1>";
        echo"<div class='container'>";
            
     // upload file
    
      $username =$_POST['username'];
      $pass     =$_POST['Password'];
      $Email    =$_POST['Email'];
      $full     =$_POST['full'];
      $hashPass=sha1($_POST['Password']);

      $avatar           =$_FILES['avatar'];
      $avatarName       =$_FILES['avatar']['name'];
      $avatartSize      =$_FILES['avatar']['size'];
      $avatartTmpName   =$_FILES['avatar']['tmp_name'];
      $avatarType       =$_FILES['avatar']['type'];
      
      $avatarAllowedtExtention=array("jpeg","jpg","png","gif"); 
      $avatartExtention= explode('.', $avatarName);
      $file_extension = strtolower(end($avatartExtention));
   
      

      // validate******************************************
      
      $formError=array();
  
      if(strlen($username)<4){
          $formError[]= 'Username cant be less than <strong>4 character</strong>';
      }
      if(empty($username)){
          $formError[]= 'Username cant be empty<strong>empty</strong>';
          
      }
      if(empty($full)){
          $formError[]= 'Full Name cant be empty <strong>empty</strong>>';
  
      }
      if(empty($Email)){
          $formError[]= 'Email cant be empty <strong>empty</strong>';
  
      }
      if(empty($pass)){
          $formError[]= 'Password cant be empty <strong>empty</strong>';
  
      }
      if(! empty($avatarName) && ! in_array($file_extension,$avatarAllowedtExtention) ){
        $formError[]= 'This Extention Is Not <strong>Allowed</strong>';

      }
      if(empty($avatarName) ){
        $formError[]= 'Avatar is <strong>Required</strong>';

      }
      if($avatartSize > 4194304) {
        $formError[]= 'Avatar Cant Be Larger Than <strong>4MB</strong>';

      }
      foreach($formError as $error){
       
        echo  ' <div class="alert alert-danger">'.  $error . '</div>';
      }
  
      if(empty($formError)){
        $avatar=rand(0 , 10000000000000000) . '_' . $avatarName;
       
        move_uploaded_file($avatartTmpName ,"upload\avatar\\" . $avatar );
     
        $check2= checkItem("UserName","users",$username );
        if($check2==1){
            $msg= "<div class='alert alert-danger'> Sorry This User is Exist</div>";
            redirectHome($msg,'back');

     }

        else{
                $sql = "INSERT users
                    (UserName,Password,Email,FullName,RegStatus,TheDate,avatar)
                    VALUES
                    (:zuser,:zpass,:zmail,:zname,1,now() , :zavatar)";
        
            $result = $con->prepare($sql);
            $result->execute(array(
                'zuser'   =>$username,
                'zpass'   =>$hashPass ,
                'zmail'   => $Email,
                'zname'   =>$full,
                'zavatar'   =>$avatar
            ));
            $row=$result->fetch();
                $count=$result->rowCount();
                $msg= "<div class='alert alert-success'>" . $result->rowCount() . ' Record Insert </div>';
                redirectHome($msg,'back');

     }
        
      }
    }
     else{
     echo " <div class='container'>";  
      $msg= '<div class="alert alert-danger">Sorry you cant browes this page directly</div> ';
      redirectHome($msg);
      echo "</div>";
    }
  
    echo "</div>";
}
   elseif($do=='Edit'){
        $userid= isset($_GET['userid'])&&is_numeric($_GET['userid'] )?intval($_GET['userid']):0; 
          
        $sql = "SELECT * FROM users WHERE UserId=$userid LIMIT 1";

         $result = $con->query($sql);
         $row=$result->fetch();
         $count=$result->rowCount();

         if($count>0){ ?>

       <h1 class="text-center">Edit Member</h1>  
        <div class="container">
            <form class="form-horizontal"  action="?do=Update" method="POST">
                <input type="hidden" name="userid" value="<?php echo $userid  ?>">
                <div  class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="username"class="form-control" autocomplete="off" required="required" value= "<?php echo $row['UserName'];  ?>">
                    </div>
                 
              
                </div>
                <!-- ****************************** -->
                <div  class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="hidden" name="oldPassword" value="<?php echo $row['Password'];  ?>" >
                        <input type="password" name="newPassword"class="form-control" placeholder="Leave Blank If Uou Dont Want To Change">
                    </div>
                 
              
                </div>

                <!-- ****************************** -->

                <div  class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="email" name="Email"class="form-control" required="required" value= "<?php echo $row['Email'];  ?>" >
                    </div>
                 
              
                </div>
                 <!-- ****************************** -->
                <div  class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Full name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="full"class="form-control" required="required" value= "<?php echo $row['FullName'];  ?>">
                    </div>
                 
              
                </div>
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
  echo "<h1 class='text-center'>Update Member</h1>";
  echo"<div class='container'>";
  if($_SERVER['REQUEST_METHOD']=='POST'){
      
    $id       =$_POST['userid'];
    $username =$_POST['username'];
    $Email    =$_POST['Email'];
    $full     =$_POST['full'];
    
    
    $pass='';
    if(empty($_POST['newPassword'])){
             $pass=$_POST['oldPassword'];
    }
    else{
             $pass=sha1($_POST['newPassword']);
    }
    // validate******************************************
    
    $formError=array();

    if(strlen($username)<4){
        $formError[]= ' <div class="alert alert-danger">Username cant be less than <strong>4 character</strong></div>';
    }
    if(empty($username)){
        $formError[]= ' <div class="alert alert-danger">Username cant be empty<strong>empty</strong></div>';
        
    }
    if(empty($full)){
        $formError[]= ' <div class="alert alert-danger">Full Name cant be empty <strong>empty</strong></div>';

    }
    if(empty($Email)){
        $formError[]= ' <div class="alert alert-danger">Email cant be empty <strong>empty</strong></div>';

    }
    foreach($formError as $error){
        echo $error;
    }


    // .....
    if(empty($formError)){
        $stmt22=$con->prepare("SELECT * FROM users WHERE UserName=? and UserId !=?");
        $stmt22->execute(array($username,$id));
        $count=$stmt22->rowCount();
        if($count==1){ 
            $msg= '<div class="alert alert-danger">Sorry This User Exist</div>';
            redirectHome($msg,'back');
        }
        else{
            $sql = "UPDATE users SET UserName=? , Email=?, FullName=? , Password=? 
             WHERE UserId=?";
   
                $result = $con->prepare($sql);
                $result->execute(array($username,$Email,$full,$pass,$id));
                $msg= "<div class='alert alert-success'>" . $result->rowCount() . ' Record Update </div>';
                redirectHome($msg,'back');
        }
  

    }

  
  }
   else{
   $msg= '<div class="alert alert-danger">Sorry you cant browes this page directly</div>';
    redirectHome($msg);

  }

  echo "</div>";
}
elseif($do=='Delet'){
         
   
    echo "<h1 class='text-center'>Delete Member</h1>";
    echo "<div class='container'>";

    $userid= isset($_GET['userid'])&&is_numeric($_GET['userid'] )?intval($_GET['userid']):0; 
          
    
    $check=checkItem('UserId','users',$userid);
    

        if($check>0){
            $stmt = $con->prepare("DELETE FROM `users` WHERE UserId= :zuser");
            $stmt->bindParam(":zuser",$userid);
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
elseif($do=='Activate'){

    echo "<h1 class='text-center'>Activate Member</h1>";
    echo "<div class='container'>";

    $userid= isset($_GET['userid'])&&is_numeric($_GET['userid'] )?intval($_GET['userid']):0; 
          
    
    $check=checkItem('userid','users',$userid);
    

        if($check>0){
            $stmt = $con->prepare("UPDATE `users` SET RegStatus=1 WHERE UserId = ?");
            
            $stmt->execute(array($userid));
            $msg= "<div class='alert alert-success isConfirmed'>" . $stmt->rowCount() . ' Record Activated </div>';

            redirectHome($msg);


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

