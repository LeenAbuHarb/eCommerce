<?php 

ob_start();  //output buffering start

session_start();
if(isset($_SESSION['UserName'])){
 
//  echo "<div class='leen'>leen</div>";
//  echo "<div class='leen'>leen</div>";
//  echo "<div class='leen'>leen</div>";
  // print_r ($_SESSION);
  $pageTitle = 'Dashbord';
   
  include 'init.php';
  
// ********************START***********************


?>
<div class="container home-stats text-center">
  <h1>Dsshboard</h1>
    <div class="row">
      <div class="col-md-3">
        <div class="stat members">
        <i class="fa fa-users"></i>
        <div class="info">
        Total Member 
          <span>
            <a href="member.php"> 
            <?php echo countItem('UserId','users')  ?></a>
          </span>
        </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat pendings">
        <i class="fa fa-user-plus"></i>
        <div class="info">
        Pending Member
          <span><a href="member.php?do=Activate&page=Pending"><?php echo checkItem("RegStatus","users",0)   ?></a></span>

        </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat items">
         <i class="fa fa-tag"></i>
         <div class="info">
         Total Items
          <span><a href="Items.php"> <?php echo countItem('Item_ID','items')  ?></a></span>

         </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stat comments">
         <i class="fa fa-comments"></i>
         <div class="info">
         Total Comments
         <span><a href="comment.php"> <?php echo countItem('c_id','comments')  ?></a></span>
         </div>

        </div>
      </div>
    </div>
</div>



<div class="container latest">
  <div class="row">
    <div class="col-sm-6">
      <div class="panel panel-default">
        <?php
        $numUsers=10;
        ?>
         <div class="panel-heading">
           <i class="fa fa-users"></i>Latest <?php echo $numUsers; ?> Registerd Users
           <span class="toggle-info pull-right">
            <i class="fa fa-plus fa-lg"></i>
           </span>
      </div>
      <div class="panel-body">
          <ul class="list-unstyled latest-user">
                    <?php
                  
                                   $latestUser=getLatest("*","users","UserId",$numUsers);
                                   if(!empty($latestUser)){
                                   foreach($latestUser as $user){
                                     echo '<li>' ;
                                       echo $user['UserName'];
                                     echo  ' <a href="member.php?do=Edit&userid='. $user['UserId'] .'"> ';
                                       echo  '  <span class="btn btn-success pull-right">';
                                             echo '  <i class="fa fa-edit"></i>
                                                     Edit';
                                                     if($user['RegStatus']==0){
                                                     echo "<a href='member.php?do=Activate&userid=". $user['UserId'] ."'class='btn btn-info activate pull-right '><i class='fa-solid fa-address-book bbb '></i>Activate</a>";
                           
                                                   }
                                           
                                           
                                                   echo ' </span>';
                                             echo '  </a>';
                                   echo ' </li>';
                                   }
                                  }
                                  else{
                                    echo  '<div class="vnice"> <i class="fa-sharp fa-solid fa-ban"></i> There is no recorde to show !</div>';

                                  }
                      ?>

          </ul>     
     
     
    
      </div>
    </div>
  </div>
   
  <div class="col-sm-6">
      <div class="panel panel-default">
        <?php
          $numItem=10;
        ?>
         <div class="panel-heading">

           <i class="fa fa-tag"></i>Latest <?php echo $numItem; ?> Items 
           <span class="toggle-info pull-right">
            <i class="fa fa-plus fa-lg"></i>
           </span>
      </div>
      <div class="panel-body">
      <ul class="list-unstyled latest-user">
                    <?php
                                    $latestItem=getLatest("*","items","Item_ID",$numItem);
                                    if(!empty($latestItem)){
                                    foreach($latestItem as $item){
                                      echo '<li>' ;
                                     echo $item['Name'];
                                       echo  ' <a href="Items.php?do=Edit&Itemid='. $item['Item_ID'] .'"> ';
                                        echo  '  <span class="btn btn-success pull-right">';
                                               echo '  <i class="fa fa-edit"></i>
                                                      Edit';
                                                      if($item['Approve']==0){
                                                        echo "<a href='Items.php?do=Approve&Itemid=". $item['Item_ID'] ."'class='btn btn-info activate pull-right '><i class='fa fa-check bbb '></i>Approve</a>";
                              
                                                      }
                                              
                                            
                                            
                                                    echo ' </span>';
                                              echo '  </a>';
                                     echo ' </li>';
                                    }
                                  }
                                  else{
                                    echo  '<div class="vnice"> <i class="fa-sharp fa-solid fa-ban"></i> There is no recorde to show !</div>';
                                  }
                      ?>

          </ul>     
      </div>
    </div>

  </div>
</div>
<div class="row">
    <div class="col-sm-6">
      <div class="panel panel-default">
        <?php
        $numComment=4;
        ?>
         <div class="panel-heading">
           <i class="fa fa-comment-o"></i> Latest <?php echo $numComment; ?> Comments
           <span class="toggle-info pull-right">
            <i class="fa fa-plus fa-lg"></i>
           </span>
      </div>
      <div class="panel-body">
          <?php

                
              $sql="SELECT comments.* ,users.UserName
              FROM comments INNER JOIN users ON users.UserId=comments.user_id
               order by c_id DESC
               limit $numComment";
              $result = $con->prepare($sql);
              $result->execute();
              $row=$result->fetchAll();
              if(!empty($row)){
                  foreach($row as $row ){
                    echo "<div class='comment-box'>";

                    echo '<span class="member-c">'.  $row['UserName'].'</span>';
                    echo '<p class="comment-c">'.  $row['comment'].'</p>';
              
                  echo" </div>";
                  }
            }
            else{
              echo  '<div class="vnice"> <i class="fa-sharp fa-solid fa-ban"></i> There is no recorde to show !</div>';

            }
          ?>    
      </div>
    </div>
  </div>
<?php

// ********************END***********************






  include $tpl.'footer.php';
}
else{
    header('Location:index.php');
    exit();
}

ob_end_flush();


?>