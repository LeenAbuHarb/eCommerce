<?php 
ob_start();
session_start();
$pageTitle = 'Homepage';


include 'init.php';
?>
<div class="container">
    <div class="row">

      <?php
         echo " <h1 class='text-center'>All Items </h1>";
          $allItem=getِAllFrom('*','items','where Approve = 1','','Item_ID','ASC');
            foreach($allItem as $item){
               echo '<div class="col-sm-6 col-md-3">';
                    echo '<div class="thumbnail item-box">';
                        echo '<span class="price-tag">$'.$item['Price'].'</span>';
                        if(empty($item['avatar'])){
                            echo "<img src='../eCommerce/upload/avatar/22-223863_no-avatar-png-circle-transparent-png.png' alt=''/>";
                           }
                           else{
                            echo "<img src='../eCommerce/upload/avatar/" . $item['avatar'] ."' alt=''/>";
                        }
                        echo '<div class="caption">';
                            echo '<h3><a href="item.php?Itemid='.$item['Item_ID'].'">'.$item['Name'].'</a></h3>';
                            echo '<p>'.$item['Description'].'</p>';
                            echo '<div class="date">'.$item['Add_Date'].'</div>';

                        echo '</div>';
                    echo'</div>';
              echo  '</div>';
            }
        ?>
            
   

     </div>
</div>









<?php

include $tpl .'footer.php';
ob_end_flush();

?>
