

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
      <a class="navbar-brand" href="#">STOP SHOP</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li class=""><a href="dashbord.php"><?php echo lang('HOME') ?> <span class="sr-only">(current)</span></a></li>
        <li><a href="categories.php"><?php echo lang('Categories') ?> </a></li>
        <li><a href="Items.php"><?php echo lang('ITEMS') ?> </a></li>
        <li><a href="member.php"><?php echo lang('MEMBER') ?> </a></li>
        <li><a href="comment.php"><?php echo lang('COMMENT') ?> </a></li>
       
        <li class="dropdown">
          
        </li>
      </ul>
   
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo lang('leen') ?>  <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../index.php">Visit Shop</a></li>
            <li><a href="member.php?do=Edit&userid=<?php echo $_SESSION['Id'] ?>">Edit</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
            
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>