<?php 
ob_start();
session_start();
$pageTitle = 'Show Items';
include 'init.php';

$Itemid= isset($_GET['Itemid'])&&is_numeric($_GET['Itemid'] )?intval($_GET['Itemid']):0; 
          
$stmt =  $con->prepare("SELECT
                              items.* , 
                              categories.Name as Category_name,
                              users.UserName as UserName
                         FROM 
                              items
                         INNER JOIN
                                categories
                          ON
                               categories.Id=items.Cat_ID        
                         INNER JOIN
                               users
                          ON
                               users.UserId=items.Member_ID        
                         WHERE Item_ID=?
                         AND 
                                Approve=1");

 $stmt->execute(array($Itemid));
 $count=$stmt->rowCount();

 if($count > 0){
    $item=$stmt->fetch();
?>
<h1 class="text-center"> <?php echo $item['Name']; ?></h1>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <?php
            if(empty($item['avatar'])){
              echo "<img class='img-responsive img-thumbnail center-block' src='../eCommerce/upload/avatar/22-223863_no-avatar-png-circle-transparent-png.png' alt=''/>";
                }
             else{
              echo "<img src='../eCommerce/upload/avatar/" . $item['avatar'] ."' alt=''/>";
              }
            ?>
        </div>
        <div class="col-md-9 item_info">
            <h2><?php echo $item['Name'];   ?></h2>
            <p><?php echo $item['Description'];   ?></p>
            <ul class="list-unstyled">
                <li>
                    <i class="fa fa-calendar fa-fw"></i>
                    <span> Added_Date:</span><?php echo $item['Add_Date'];?>
                </li>
                <li>
                <i class="fa-sharp fa-solid fa-money-bill"></i>
                    <span>Price:</span>$<?php echo $item['Price'];?>
                </li>
                <li>
                <i class="fa-solid fa-globe"></i>
                    <span>Made in:</span><?php echo $item['Country_Made'];?></span>
                </li>
                <li>
                <i class="fa fa-tags"></i>
                <span>Category:</span><a href="cateories.php?pageid=<?php echo $item['Cat_ID'] ?>"><?php echo $item['Category_name'];?></a>

                </li>
                <li>
                <i class="fa-solid fa-user"></i>
                    <span>Added By: </span><a href=""> <?php echo $item['UserName'];?></a>
                </li>   
                <li class="tags-items">  
                <i class="fa fa-user fa-fw"></i>
                    <span>Tags: </span>
                    <?php
                        $allTags=explode(",",$item['tags']);
                        foreach($allTags as $tag){
                            $tag=str_replace(' ','',$tag);
                            $lowertag=strtolower($tag);
                            if(!empty($tag)){
                            echo "<a href='tags.php?name={$lowertag}'>". $tag. '</a>';
                            }
                        }
                    ?>
                </li>     
            </ul>
        </div>
    </div>
    <hr class="custom-hr">
    <!-- *********************************start comment************************** -->
    <?php
    if(isset($_SESSION['anyuser'])){
?>
        <div class="row">
            <div class="col-md-offset-3">
                <div class="add-comment">
                    <h3>Add your Comment</h3>
                        <form action="<?php echo $_SERVER['PHP_SELF'].'?Itemid='.$item['Item_ID'] ?>" method="POST">
                            <textarea name="comment" id="" required=required></textarea>
                            <input class="btn btn-primary btn-sm" type="submit" value="Add Comment">
                        </form>
                        <?php
                            if($_SERVER['REQUEST_METHOD']=='POST'){
                                $comment=filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
                                $userid=$_SESSION['uid'];
                                $itemid=$item['Item_ID'];

                                if(!empty($comment)){
                                    $stmt=$con->prepare("INSERT INTO 
                                                            comments
                                                            (comment,status,comment_date,item_id, user_id )
                                                        VALUES 
                                                        (:zcomment,0,Now(),:zitemid,:zuserid)");
                                    $stmt->execute(array(
                                        'zcomment' => $comment,
                                        'zitemid'  =>$itemid,
                                        'zuserid'  =>$userid
                                    ));
                                    
                                    if($stmt){
                                        echo '<div class="alert alert-success">Comment Added</div>';
                                    }
                                }
                            }

                        ?>
                </div>
            </div>
        </div>
    
    <!-- *********************************end comment**************************** -->
<?php
}else{
    echo'<a href="login.php">Login</a> or <a href="login.php">Register</a> To Add Comment ';
}

?>
    <hr class="custom-hr">
    <?php
    
        $sql="SELECT comments.* ,users.UserName as Member
        FROM comments
        INNER JOIN users ON users.UserId=comments.user_id
        where item_id =?
        and status=1
        order by c_id DESC  ";
    
            
            $result = $con->prepare($sql);
            $result->execute(array($item['Item_ID']));
            $row=$result->fetchAll();
            // if(!empty($row)){}
                     ?>
           
               <?php

            foreach ($row as $row){
                echo '<div class="comment-box">';
                    echo ' <div class="row">';
                        echo '<div class="col-sm-2 text-center">
                             <img class="img-responsive img-thumbnail img-circle"src="22-223863_no-avatar-png-circle-transparent-png.png" alt=""/>
                             '. $row['Member'].'</div>';
                         echo '<div class="col-sm-10"> <p class="lead">'. $row['comment'].'</p></div>';
                echo '</div>';
                echo '</div>';
                echo '<hr class="custom-hr">';
                }

                ?>
            </div>
        
    

<?php
 }
 else{
        echo '<div class="alert alert-danger">There is No Such ID Or This Item is Waiting Approval</div>';
 }

include $tpl .'footer.php';
ob_end_flush();
?>
