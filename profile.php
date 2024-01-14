<?php 
ob_start();

session_start();
$pageTitle = 'Profile';
include 'init.php';

if(isset($_SESSION['anyuser'])){
    $getUser=$con->prepare("SELECT * FROM users WHERE UserName=?");
    $getUser->execute(array($session));
    $info=$getUser->fetch();
    $userid=$info['UserId'];
?>
<h1 class="text-center"> Welcom Profile</h1>
    <div class="information block">
        <div class="container">
            <div class="panel">
                <div class="panel-heading">My Information</div>
                <div class="panel-body">
                    <ul class="list-unstyled">
                        <li> 
                            <i class="fa fa-unlock-alt fa-fw"></i>
                            <span>Name is: </span>  <?php echo $info['UserName'] ?> 
                        </li>
                        <li>
                        <i class="fa fa-envelope-o fa-fw"></i>

                             <span>Email is:</span> <?php echo $info['Email'] ?> 
                            </li>
                        <li> 
                        <i class="fa fa-user fa-fw"></i>

                            <span>FullName is:</span> <?php echo $info['FullName'] ?> 
                        </li>
                        <li> 
                        <i class="fa fa-calendar fa-fw"></i>

                             <span>Register Date is:</span> <?php echo $info['TheDate'] ?>
                            </li>
                        <li> 
                        <i class="fa fa-tags fa-fw"></i> 
                            <span>Favourite Category :</span> <?php echo $info['UserId'] ?>
                        </li>
                    </ul>
                    <a href="#" class="btn btn-default my-button">Edit Information</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ************ -->
    <div id="my-ads" class="my-ads block">
        <div class="container">
            <div class="panel">
                <div class="panel-heading">My Itemes</div>
                <div class="panel-body">

                            <?php
                            $myItems=getِAllFrom("*", "items", "WHERE Member_ID =$userid","", "Item_ID", "ASC");

                                if(!empty($myItems)){
                                    echo '<div class="row">';
                                foreach ($myItems as $item){
                                    echo '<div class="col-sm-6 col-md-3">';
                                        echo '<div class="thumbnail item-box">';
                                            if($item['Approve']==0){echo '<span class="approve-status">Not Approved</span>';}
                                            echo '<span class="price-tag">$'.$item['Price'].'</span>';
                                            echo '<img class="img-responsive"src="22-223863_no-avatar-png-circle-transparent-png.png" alt=""/>';
                                            echo '<div class="caption">';
                                                echo '<h3><a href="item.php?Itemid='.$item['Item_ID'].'">'.$item['Name'].'</a></h3>';
                                                echo '<p>'.$item['Description'].'</p>';
                                                echo '<div class="date">'.$item['Add_Date'].'</div>';
                                            echo '</div>';
                                        echo'</div>';
                                    echo  '</div>';
                                }
                                echo'</div>';
                            }
                            else{
                                echo 'Sorry There is No Ads To Show , Craete <a href="newad.php">New Ads</a>' ;
                            }
                            ?>
                                


                            </div>
            </div>
        </div>
    </div>
        <!-- ************ -->
    <div class="my-comment block">
        <div class="container">
            <div class="panel">
                <div class="panel-heading">Latest Comment</div>
                <div class="panel-body">
                <?php
                $MyComment=getِAllFrom("Comment", "comments", "where user_id= $userid","", "c_id", "DESC");

                   if(!empty($MyComment)){
                        foreach($MyComment as $comment){
                            echo '<p>'.$comment['Comment'].'</p>';
                        }
                   }
                   else{
                    echo 'There is No Comment To Show';
                   }
                   ?>
                </div>
            </div>
        </div>
    </div>

<?php
}
else{
    header('Location:login.php');
    exit();
}
include $tpl .'footer.php';
ob_end_flush();

?>
