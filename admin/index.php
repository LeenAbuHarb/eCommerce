<?php 
session_start();
$Nonavbar='';
$pageTitle = 'Login';
if(isset($_SESSION['UserName'])){

    header('Location:dashbord.php');

}


include 'init.php';


 if($_SERVER['REQUEST_METHOD']=='POST'){
    $username=$_POST['user'];
    $password=$_POST['pass'];
    $hashedPass = sha1($password);

    

    // $statement = $con ->prepare("select UserName,Password from users where UserName=? and Password=?")
    // $statement ->execute(array($username,$hashedPass));
    
    $sql = "SELECT
                UserId,UserName,Password 
             FROM 
                users 
             WHERE
               UserName='$username'
             AND 
               password='$hashedPass'
             AND
               GroupId=1 
                LIMIT 1";
                
    // GroupId=1 => ADMIN
    // GroupId=0 => MEMBER OR USER
        $result = $con->query($sql);
        $row=$result->fetch();
        $count=$result->rowCount();

      if($count>0){
        $_SESSION['UserName']=$username;
        $_SESSION['Id']=$row['UserId'];
        header('Location:dashbord.php');
        exit();

  
   }
 }


?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
<h4 class=" text-center">Admin Login</h4>
    <input class="form-control" type="text"name="user"placeholder="Username" autocomplete="off"/>
    <input class="form-control" type="password"name="pass" placeholder="Password" autocomplete="new-password"/>
    <input class="btn btn-primary btn-block" type="submit" value="login"/>
</form>

