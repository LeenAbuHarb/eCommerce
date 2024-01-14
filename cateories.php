<?php 
session_start();
include 'init.php';

?>


<div class="container">
    <h1 class="text-center">Show Category Items</h1>
    <div class="row">

      <?php
        // $categoryid= isset($_GET['pageid'])&&is_numeric($_GET['pageid'] )?intval($_GET['pageid']):0; 
        if(isset($_GET['pageid'])&&is_numeric($_GET['pageid'] )){
            $categoryid=intval($_GET['pageid']);
        $allItem=getِAllFrom("*", "items", "WHERE Cat_ID ={$categoryid}","AND Approve = 1", "Item_ID", "DESC");

            foreach($allItem as $item){
               echo '<div class="col-sm-6 col-md-3">';
                    echo '<div class="thumbnail item-box">';
                        echo '<span class="price-tag">'.$item['Price'].'</span>';
                        if(empty($item['avatar'])){
                            echo "<img src='../eCommerce/upload/avatar/22-223863_no-avatar-png-circle-transparent-png.png' alt=''/>";
                           }
                           else{
                                echo "<img src='../eCommerce/upload/avatar" . $item['avatar'] ."' alt=''/>";
                           }                       
                            echo '<div class="caption">';
                            echo '<h3><a href="item.php?Itemid='.$item['Item_ID'].'">'.$item['Name'].'</a></h3>';
                            echo '<p>'.$item['Description'].'</p>';
                            echo '<div class="date">'.$item['Add_Date'].'</div>';

                        echo '</div>';
                    echo'</div>';
              echo  '</div>';
            }
        }else{
            echo '<div class="alert alert-danger">You Must Add Page ID</div>';
        }
        ?>
            
        

     </div>
</div>



















<?php include $tpl .'footer.php'; ?>
