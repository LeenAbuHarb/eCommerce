<?php 
ob_start();
session_start();
$Nonavbar='';
$pageTitle = 'Login';
if(isset($_SESSION['anyuser'])){

    header('Location:index.php');

}

include 'init.php';
if($_SERVER['REQUEST_METHOD']=='POST'){
  if(isset($_POST['login'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $hashedPass = sha1($password);
    
    $sql = "SELECT
                UserName,UserId,Password 
             FROM 
                users 
             WHERE
               UserName='$username'
             AND 
               password='$hashedPass'";
 
        $result = $con->query($sql);
        $get=$result->fetch();
        $count=$result->rowCount();
      

      if($count>0){
        $_SESSION['anyuser']=$username;
        $_SESSION['uid']=$get['UserId'];
        header('Location:index.php');
        exit();
   }
  }
  else{

    $formsError=array();
    $username=$_POST['username'];
    $password=$_POST['password'];
    $password2=$_POST['password2'];
    $email=$_POST['email'];

    if(isset($username)){
      $filteruser=filter_var($username,FILTER_SANITIZE_STRING);
        
        if(strlen($filteruser)<4){
          $formsError[]='Username Must Be Larger Than 4 Character';
        } 

    }
    if(isset($password) && isset($password2)){
        if(empty($password)){
          $formsError[]='Sorry Password Cant Be Empty';
        }
            $pass1=sha1($password);
            $pass2=sha1($password2);
            if($pass1 !== $pass2){
              $formsError[]='Sorry Password Is Not Match';
            }

    }
    if(isset($email)){
      $filterEmail=filter_var($email,FILTER_SANITIZE_EMAIL);
        if(filter_var($filterEmail,FILTER_VALIDATE_EMAIL)!=true){
            $formsError[]='This Email Not Valid';
        }
     

    }
  

  // .....
  if(empty($formsError)){
    $check2= checkItem("UserName","users",$username );
    if($check2==1){
      $formsError[]='Sorry This User is Exist';

    }

    else{
            $sql = "INSERT users
                (UserName,Password,Email,RegStatus,TheDate)
                VALUES
                (:zuser,:zpass,:zmail,0,now())";
    
        $result = $con->prepare($sql);
        $result->execute(array(
            'zuser'   =>$username,
            'zpass'   =>sha1($password),
            'zmail'   => $email,
        ));
       
          $succesMsg='Cangrats Are Now Registerd User';
  
        }
        
      }
    
  }
  
 }

?>


<div class="container login-page">
    <h1 class="text-center"><span class="active" data-class="login">Login</span> | 
    <span data-class="signup">Signup</span>
    </h1>
    <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">

        <div class="input-container">
             <input class="form-control" type="text" name="username" autocomplete="off" placeholder="type your username" required/>
        </div>
        <div class="input-container">
        <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="type your password" required/>
        </div>
        
        <input class="btn btn-primary btn-block" name="login" type="submit" value="Login">
    </form>

    <!-- ************************ -->

    <form class="signup" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
    <div class="input-container">
        <input  pattern=".{4,8}" title="Username Must Be Between 4 and 8 Cahracter" class="form-control" type="text" name="username" autocomplete="off" placeholder="type your username"required/>
        </div>
        <div class="input-container">
        <input minlength="4" class="form-control" type="password" name="password" autocomplete="new-password" placeholder="type your password"required/>
        </div>
        <div class="input-container">
        <input minlength="4" class="form-control" type="password" name="password2" autocomplete="new-password" placeholder="type a password again"required/>
        </div>
        <div class="input-container">
        <input class="form-control" type="email" name="email" autocomplete="off" placeholder="Type valid Email "required>
        </div>
        <input class="btn btn-success btn-block" type="submit" name="signup" value="Sigunup">
    </form>
    <div class="the-errors text-center">
    <?php

        if(!empty($formsError)){
          foreach($formsError as $error){
            echo '<div class="msg error">'. $error .'</div>';
          }
        }

        if(isset($succesMsg)){
          echo '<div class="msg success">'. $succesMsg .'</div>';

        }

    ?>
    </div>
</div>

   



<?php 
include $tpl.'footer.php';
ob_end_flush();
?>