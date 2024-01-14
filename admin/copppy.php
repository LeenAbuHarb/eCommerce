<?php

ob_start();  //output buffering start

session_start();

  $pageTitle = 'Items';

  if(isset($_SESSION['UserName'])){
 
      include 'init.php';
      $do= isset($_GET['do'])?$_GET['do']:'Manage';
      if($do=='Manage'){


      }
      elseif($do=='Add'){
      
   
      }
      elseif($do=='Insert'){

   } 
   

      elseif($do=='Edit'){
   
  }


      elseif($do=='Update'){
     
      }
      


      elseif($do=='Delet'){

    
      }

      
      
      include $tpl.'footer.php';

    }
    else{
        header('Location:index.php');
        exit();
    }
    


    ob_end_flush();

?>