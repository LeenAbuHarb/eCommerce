<?php

ob_start();  //output buffering start

session_start();

  $pageTitle = 'Items';

  if(isset($_SESSION['UserName'])){
 
      include 'init.php';
      $do= isset($_GET['do'])?$_GET['do']:'Manage';

      if($do=='Manage'){

            
           $sql="SELECT
                     items.* , categories.Name AS categry_Name , users.UserName AS User_Item
                 FROM
                     items
                 INNER JOIN categories ON categories.Id=items.Cat_ID 
                 INNER JOIN users ON users.UserId=items.Member_ID ORDER BY Item_ID ";
           $result = $con->prepare($sql);
           $result->execute();
           $row=$result->fetchAll();
           // $count=$result->rowCount();
           if(!empty($row)){
        ?>
        <h1 class="text-center">Mange Items</h1>  
        <div class="container">
         <div class="table-responsive">
            <table class="main-table manage-member table text-center table-bordered">
                <tr>
                    <td>#id</td>
                    <td>Avatar</td>
                    <td>Name</td>
                    <td>Descreption</td>
                    <td>Price</td>
                    <td>Adding Date</td>
                    <td>categry_Name</td>
                    <td> User name for Item</td>
                    <td>Control</td>
                </tr>
                <?php
                     
                     foreach($row as $row){
                        echo "<tr>";
                           echo "<td>" . $row['Item_ID'] ."</td>"; 
                           echo "<td>";
                           if(empty($row['avatar'])){
                            echo "<img src='upload/avatar/22-223863_no-avatar-png-circle-transparent-png.png' alt=''/>";
                           }
                           else{
                                echo "<img src='upload/avatar/" . $row['avatar'] ."' alt=''/>";
                           }
                           echo "</td>";
                           echo "<td>" . $row['Name'] ."</td>";
                           echo "<td>" . $row['Description'] ."</td>";
                           echo "<td>" . $row['Price'] ."</td>";
                           echo "<td>" . $row['Add_Date'] ."</td>";
                           echo "<td>" . $row['categry_Name'] ."</td>";
                           echo "<td>" . $row['User_Item'] ."</td>";
    
                            echo "<td> 
                            <a href='Items.php?do=Edit&Itemid=".$row['Item_ID']."' class='btn btn-success'><i class='fa-solid fa-pen-to-square bbb'></i>Edit</a>
                            <a href='Items.php?do=Delet&Itemid=".$row['Item_ID']."'class='btn btn-danger confirmation'><i class='fa-solid fa-xmark bbb'></i>Delete</a>";
                            
                            if($row['Approve']==0){
                                echo "<a href='Items.php?do=Approve&Itemid=".$row['Item_ID']."'class='btn btn-info suberr'><i class='fa fa-check bbb'></i>Approve</a>";
                               

                            }
                       echo "</td>";
                    echo "</tr>";
                          
                     }
                     
                ?>
                  
         
            
            
           
            </table>
         </div>
        <a href="Items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus bbb"></i>Add Item</a>
       </div>
                 <?php
                    }
                    else{
                        echo '<div class="container">';
                        
                      echo " <div class='nice-message'>There is no Items to show</div>";
                       ' </div>';
                    echo  ' <a href="Items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus bbb"></i>Add Item</a>';

                     }
                    ?>

     <?php
       } 
    
      
      elseif($do=='Add'){
      
        ?>
        
      
        
        
         <!-- add member page  -->
    <h1 class="text-center">Add new Item</h1>  
    <div class="container">
        <form class="form-horizontal"  action="?do=Insert" method="POST">
            <!-- <input type="hidden" name="userid" value="<?php echo $userid  ?>"> -->
            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text" name="name"class="form-control" autocomplete="off" required="required"placeholder="Name of the Item ">
                </div>
             
          
            </div>
            <!-- ****************************** -->
          
            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Descreption</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text" name="descreption"class="form-control" autocomplete="off" required="required"placeholder="Descreption of the Item ">
                </div>
             
          
            </div>
             <!-- ****************************** -->
            <!-- ****************************** -->
            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Price</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text" name="price"class="form-control" autocomplete="off" required="required"placeholder="$">
                </div>
             
          
            </div>
             <!-- ****************************** -->
            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Country</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text" name="country"class="form-control" autocomplete="off" required="required"placeholder="Country of Made">
                </div>
             
          
            </div>
             <!-- ****************************** -->
            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Status</label>
                <div class="col-sm-10 col-md-6">
                    <Select name="status">
                        <option value="0">..</option>
                        <option value="1">New</option>
                        <option value="2">Like New</option>
                        <option value="3">Used</option>
                        <option value="4">Old</option>
                    </Select>
                </div>
             
          
            </div>
             <!-- ****************************** -->
            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Member</label>
                <div class="col-sm-10 col-md-6">
                    <Select name="member">
                        <option value="0">..</option>
                     <?php
                        $AllMember=getِAllFrom('*', 'users','', '','UserId','DESC');
                    
                        foreach($AllMember as $user){
                            echo " <option value=' ".$user['UserId']. "' >". $user['UserName'] . "</option>";
                        }
                    ?>
                    </Select>
                </div>
             
          
            </div>
             <!-- ****************************** -->
            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Categories</label>
                <div class="col-sm-10 col-md-6">
                    <Select name="categories">
                        <option value="0">..</option>
                     <?php
                     $AllCat=getِAllFrom('*', 'categories','where parent=0', '','Id','DESC');

                        foreach($AllCat as $cat){
                            echo " <option value=' ".$cat['Id']. "' >". $cat['Name'] . "</option>";
                            $ChildCat=getِAllFrom("*", "categories","where parent= {$cat['Id']}", "","Id","DESC");
                            foreach($ChildCat as $child){
                                echo " <option value=' ".$child['Id']. "' >---". $child['Name'] ." ". $cat['Name']. "</option>";

                            }

                        }
                    ?>
                    </Select>
                </div>
             
          
            </div>
             <!-- ****************************** -->
             <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Avatar</label>
                <div class="col-sm-10 col-md-6">
                    <input type="file" name="avatar"class="form-control"  required="required">
                </div>
             
          
            </div>
            <!-- ****************************** -->
             <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Tags</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text" name="tags"class="form-control" autocomplete="off" placeholder="Separate Tags With Comma (,)">
                </div>
             
          
            </div>
          
             <!-- ****************************** -->
            <div  class="form-group form-group-lg">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit"class="btn btn-primary btn-sm" value="Add Categories " >
                </div>
             
          
            </div>
             <!-- ****************************** -->

        </form>
    </div>
<?php
     
      }
      elseif($do=='Insert'){
        
    if($_SERVER['REQUEST_METHOD']=='POST'){
            
        echo "<h1 class='text-center'>Insert Item</h1>";
        echo"<div class='container'>";
            
      $name            =$_POST['name'];
      $descreption     =$_POST['descreption'];
      $price           =$_POST['price'];
      $country         =$_POST['country'];
      $status          =$_POST['status'];
      $member          =$_POST['member'];
      $cate            =$_POST['categories'];
      $tags            =$_POST['tags'];
      
      $avatar           =$_FILES['avatar'];
      $avatarName       =$_FILES['avatar']['name'];
      $avatartSize      =$_FILES['avatar']['size'];
      $avatartTmpName   =$_FILES['avatar']['tmp_name'];
      $avatarType       =$_FILES['avatar']['type'];
      
      $avatarAllowedtExtention=array("jpeg","jpg","png","gif"); 
      $avatartExtention= explode('.', $avatarName);
      $file_extension = strtolower(end($avatartExtention));
     

      // validate******************************************
      
      $formError=array();
  
      if(empty($name)){
          $formError[]= 'Name Cant be <strong>Empty</strong>';
      }
      if(empty($descreption)){
          $formError[]= 'Description Cant be <strong>Empty</strong>';
          
      }
      if(empty($price)){
          $formError[]= 'Price Cant be <strong>Empty</strong>';
  
      }
      if(empty($country)){
          $formError[]= 'Country Cant be <strong>Empty</strong>';
  
      }
      if(($status==0)){
          $formError[]= 'You must Choose the <strong>status</strong>';
  
      }
    
      if(($member==0)){
          $formError[]= 'You must Choose the <strong>Member</strong>';
  
      }
      if(($cate==0)){
          $formError[]= 'You must Choose the <strong>categories</strong>';
  
      }
      if(! empty($avatarName) && ! in_array($file_extension,$avatarAllowedtExtention) ){
        $formError[]= 'This Extention Is Not <strong>Allowed</strong>';

      }
      if(empty($avatarName) ){
        $formError[]= 'Avatar is <strong>Required</strong>';

      }
      if($avatartSize > 4194304) {
        $formError[]= 'Avatar Cant Be Larger Than <strong>4MB</strong>';

      }
    
      foreach($formError as $error){
       
        echo  ' <div class="alert alert-danger">'.  $error . '</div>';
      }
  
  
      // .....
      if(empty($formError)){

                $avatar=rand(0 , 10000000000000000) . '_' . $avatarName;
            
                move_uploaded_file($avatartTmpName ,"upload\avatar\\" . $avatar );
        
                $sql =$con->prepare( "INSERT items
                    (Name,Description,Price,Country_Made,Status,Add_Date,Cat_ID,Member_ID,tags,avatar)
                    VALUES
                    (:zname,:zdesc,:zprice,:zcountry,:zstatus,now(),:zcat,:zmember,:ztags,:zavatar)");
        
            $sql->execute(array(
                'zname'     =>$name,
                'zdesc'     =>$descreption,
                'zprice'    =>$price,
                'zcountry'  =>$country,
                'zstatus'   =>$status,
                'zcat'      =>$cate,
                'zmember'   =>$member,
                'ztags'     =>$tags,
                'zavatar'   =>$avatar
            ));
            // $row=$result->fetch();
                // $count=$result->rowCount();
                $msg= "<div class='alert alert-success'>" . $sql->rowCount() . ' Record Insert </div>';
                redirectHome($msg,'back');

        }
        
      }
    
     else{
     echo " <div class='container'>";  
      $msg= '<div class="alert alert-danger">Sorry you cant browes this page directly</div> ';
      redirectHome($msg);
      echo "</div>";
    }
  
    echo "</div>";

   } 
   

      elseif($do =='Edit'){
        $Itemid= isset($_GET['Itemid'])&&is_numeric($_GET['Itemid'] )?intval($_GET['Itemid']):0; 
          
        $stmt =  $con->prepare("SELECT * FROM items WHERE Item_ID=?");

         $stmt->execute(array($Itemid));
         $item=$stmt->fetch();
         $count=$stmt->rowCount();

         if($count >  0 ){ ?>

            <h1 class="text-center">Edit Item</h1>  
                <div class="container">
                <form class="form-horizontal" action="?do=Update" method="POST">
                <input type="hidden" name="itemid" value="<?php echo $Itemid ?>">
                        <div  class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="name"class="form-control" autocomplete="off" required="required"placeholder="Name of the Item " value="<?php echo $item['Name']  ?>">
                            </div>
                        
                    
                        </div>
                        <!-- ****************************** -->
                        <div  class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Descreption</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="descreption"class="form-control" autocomplete="off" required="required"placeholder="Descreption of the Item " value="<?php echo $item['Description']  ?>">
                            </div>
                        
                    
                        </div>
                        <!-- ****************************** -->
                        <!-- ****************************** -->
                        <div  class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="price"class="form-control" autocomplete="off" required="required"placeholder="$" value="<?php echo $item['Price']  ?>">
                            </div>
                        
                    
                        </div>
                        <!-- ****************************** -->
                        <div  class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Country</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="country"class="form-control" autocomplete="off" required="required"placeholder="Country of Made"value="<?php echo $item['Country_Made']  ?>">
                            </div>
                        
                    
                        </div>
                        <!-- ****************************** -->
                        <div  class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10 col-md-6">
                                <Select name="status">
                                    <option value="1" <?php if($item['Status']==1){echo 'selected';} ?>>New</option>
                                    <option value="2"<?php if($item['Status']==2){echo 'selected';} ?>>Like New</option>
                                    <option value="3"<?php if($item['Status']==2){echo 'selected';} ?>>Used</option>
                                    <option value="4"<?php if($item['Status']==4){echo 'selected';} ?>>Old</option>
                                </Select>
                            </div>
                        
                    
                        </div>
                        <!-- ****************************** -->
                        <div  class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Member</label>
                            <div class="col-sm-10 col-md-6">
                                <Select name="member">
                                <?php

                                    $stmt=$con->prepare( "SELECT * FROM users" );
                                    $stmt->execute();
                                    $users=$stmt->fetchAll();
                                    foreach($users as $user){
                                        echo " <option value=' ".$user['UserId']. "'";
                                        if($item['Member_ID']==$user['UserId']){echo 'selected'; }
                                        echo" >". $user['UserName'] . "</option>";
                                    }
                                ?>
                                </Select>
                            </div>
                        
                    
                        </div>
                        <!-- ****************************** -->
                        <div  class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Categories</label>
                            <div class="col-sm-10 col-md-6">
                                <Select name="categories">
                                <?php

                                    $stmt=$con->prepare( "SELECT * FROM categories" );
                                    $stmt->execute();
                                    $category=$stmt->fetchAll();
                                    foreach($category as $cat){
                                        echo " <option value=' ".$cat['Id']. "' ";
                                        if($item['Cat_ID']==$cat['Id']){echo 'selected'; }
                                        echo">". $cat['Name'] . "</option>";
                                    }
                                ?>
                                </Select>
                            </div>
                        
                    
                        </div>
                        <!-- ****************************** -->
                            <div  class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Tags</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" name="tags"class="form-control" value="<?php echo $item['tags']  ?>" autocomplete="off" placeholder="Separate Tags With Comma (,)">
                                </div>
                            
                        
                            </div>
                        <!-- ****************************** -->
                        <div  class="form-group form-group-lg">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit"class="btn btn-primary btn-sm" value="Save Item " >
                            </div>
                        
                    
                        </div>
                        <!-- ****************************** -->

                    </form>

                    <?php
                    $sql="SELECT comments.* ,users.UserName
                        FROM comments
                        INNER JOIN users ON users.UserId=comments.user_id 
                        where item_id=? ";
                    $result = $con->prepare($sql);
                    $result->execute(array($Itemid));
                    $row=$result->fetchAll();
                    if(!empty($row)){
                   // $count=$result->rowCount();
                   ?>
                <h1 class="text-center">Mange [ <?php echo $item['Name']  ?> ] Comments</h1>  
                <div class="table-responsive">
                    <table class="main-table table text-center table-bordered">
                        <tr>
                            <td>Comments</td>
                            <td>User Name</td>
                            <td>Added Date</td>
                            <td>Control</td>
                        </tr>
                        <?php
                            
                            foreach($row as $row){
                                echo "<tr>";
                                echo "<td>" . $row['comment'] ."</td>";
                                echo "<td>" . $row['UserName'] ."</td>";
                                echo "<td>" . $row['comment_date'] ."</td>";

                                    echo "<td> 
                                    <a href='comment.php?do=Edit&comid=".$row['c_id']."' class='btn btn-success'><i class='fa-solid fa-pen-to-square bbb'></i>Edit</a>
                                    <a href='comment.php?do=Delet&comid=".$row['c_id']."'class='btn btn-danger confirmation'><i class='fa-solid fa-xmark bbb'></i>Delete</a>";
                                    
                                    if($row['status']==0){
                                        echo "  <a href='comment.php?do=Approve&comid=".$row['c_id']."'class='btn btn-info activate '><i class='fa fa-check bbb '></i>Approve</a>";

                                    }
                                echo "</td>";
                                echo "</tr>";
                            }
                            
                        ?>
                        </tr>
                
                    </table>
                </div>
            <?php } ?>
            
            <?php 
               
            
           
   
    }else{
        echo "<div class='container'> ";
       $msg= '<div class="alert alert-danger"> There is no such ID</div>'; 
       redirectHome($msg);


       echo "</div> ";
    
   
  }
      }

      elseif($do=='Update'){
        echo "<h1 class='text-center'>Update Item</h1>";
        echo"<div class='container'>";
        if($_SERVER['REQUEST_METHOD']=='POST'){
            
          $id            =$_POST['itemid'];
          $name          =$_POST['name'];
          $descreption   =$_POST['descreption'];
          $price         =$_POST['price'];
          $country       =$_POST['country'];
          $status        =$_POST['status'];
          $member        =$_POST['member'];
          $categories    =$_POST['categories'];
          $tags          =$_POST['tags'];
          
          
        
          // validate******************************************
          
          $formError=array();
  
          if(empty($name)){
              $formError[]= 'Name Cant be <strong>Empty</strong>';
          }
          if(empty($descreption)){
              $formError[]= 'Description Cant be <strong>Empty</strong>';
              
          }
          if(empty($price)){
              $formError[]= 'Price Cant be <strong>Empty</strong>';
      
          }
          if(empty($country)){
              $formError[]= 'Country Cant be <strong>Empty</strong>';
      
          }
          if(($status==0)){
              $formError[]= 'You must Choose the <strong>status</strong>';
      
          }
        
          if(($member==0)){
              $formError[]= 'You must Choose the <strong>Member</strong>';
      
          }
          if(($categories==0)){
              $formError[]= 'You must Choose the <strong>categories</strong>';
      
          }
        
          foreach($formError as $error){
           
            echo  ' <div class="alert alert-danger">'.  $error . '</div>';
          }
      
      
      
          // .....
          if(empty($formError)){
              $sql = "UPDATE items SET Name=? ,Description=?, Price=? , Country_Made=? ,Status=?,Member_ID=?,Cat_ID=?,tags=?
              WHERE Item_ID=?";
         
             $result = $con->prepare($sql);
              $result->execute(array($name,$descreption,$price,$country,$status,$member,$categories,$tags,$id));
             // $row=$result->fetch();
          //    $count=$result->rowCount();
              $msg= "<div class='alert alert-success'>" . $result->rowCount() . ' Record Update </div>';
              redirectHome($msg,'back');
      
          }
      
        
        }
         else{
         $msg= '<div class="alert alert-danger">Sorry you cant browes this page directly</div>';
          redirectHome($msg);
      
        }
      
        echo "</div>";
      }
      


      elseif($do=='Delet'){
        echo "<h1 class='text-center'>Delete Items</h1>";
        echo "<div class='container'>";
    
        $Itemid= isset($_GET['Itemid'])&&is_numeric($_GET['Itemid'] )?intval($_GET['Itemid']):0; 
              
        
        $check=checkItem('Item_ID','items',$Itemid);
        
    
            if($check>0){
                $stmt = $con->prepare("DELETE FROM `items` WHERE Item_ID= :zitem");
                $stmt->bindParam(":zitem",$Itemid);
                $stmt->execute();
                $msg= "<div class='alert alert-success isConfirmed'>" . $stmt->rowCount() . ' Record Deleted </div>';
    
                redirectHome($msg,'back');
    
    
            }
            else{
    
                    $msg= '<div class="alert alert-danger">This is Not Exist</div>';
                    redirectHome($msg);
    
                }
    
                echo "</div>";
    
      }
      elseif($do=='Approve'){

    
        echo "<h1 class='text-center'>Approve Item</h1>";
        echo "<div class='container'>";
    
        $Itemid= isset($_GET['Itemid'])&&is_numeric($_GET['Itemid'] )?intval($_GET['Itemid']):0; 
              
        
        $check=checkItem('Item_ID','items',$Itemid);
        
    
            if($check>0){
                $stmt = $con->prepare("UPDATE `items` SET Approve=1 WHERE Item_ID = ?");
                
                $stmt->execute(array($Itemid));
                $msg= "<div class='alert alert-success isConfirmed'>" . $stmt->rowCount() . ' Record Approved </div>';
    
                redirectHome($msg);
    
    
            }
            else{
    
                    $msg= '<div class="alert alert-danger">This is Not Exist</div>';
                    redirectHome($msg,'back');
    
                }
    
                echo "</div>";
      }

      
      






      include $tpl.'footer.php';

    }
    else{
        header('Location:index.php');
        exit();
    }
    


    ob_end_flush();

?>