


 <!DOCTYPE html>

<html>
   <head>
    <meta charset="UTF-8"/>
    <title> <?php  title() ;?> </title>
    <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>mydesign.css">

    <link rel="stylesheet" href="<?php echo $css; ?>fontawesome.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.css">
    <link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css">
    <script src="https://kit.fontawesome.com/4b7bc06ea4.js" crossorigin="anonymous"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>
<body>
  <div class="upper-bar">
    <div class="container">

    <?php

        if($session){?>
        <img class="my-img img-circle img-thumbnail"src="Screenshot 2024-01-14 174321.png" alt=""/>
        <div class="btn-group my-info pull-right">
            <span class="btn dropdown-toggle" data-toggle="dropdown">
                  <?php echo $_SESSION['anyuser'] ?>
                  <span class="caret"></span>
               </span>
               <ul class="dropdown-menu">
                  <li><a href="profile.php">My Profile</a></li>
                  <li><a href="newad.php">New Item</a></li>
                  <li><a href="profile.php#my-ads">My Item</a></li>
                  <li><a href="logout.php">Logout</a></li>
               </ul>
           
        </div>
      <?php  
          
       
        }
        else{
          ?>
          <a href="login.php">
          <span class="pull-right">Login/Sign Up</span>
          </a>
       <?php }?>
  
     
    </div>
   
  </div>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Homepage</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">
       <?php

          $allcat=getِAllFrom('*','categories','where parent=0','','Id','ASC');
          foreach($allcat as $cat){
            echo '<li>
             <a href="cateories.php?pageid=' .$cat['Id'].'">
                 '. $cat['Name'].'
             </a>
                 </li>';
          }




      ?>
      </ul>
  
        </li>
      </ul>
    </div>
  </div>
</nav>   
