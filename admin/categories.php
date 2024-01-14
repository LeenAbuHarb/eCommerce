<?php

ob_start();  //output buffering start

session_start();

  $pageTitle = 'categories';

  if(isset($_SESSION['UserName'])){
 
      include 'init.php';
      $do= isset($_GET['do'])?$_GET['do']:'Manage';
      if($do=='Manage'){

        $sort='ASC';

        $sort_array=array('ASC','DESC');

        if(isset($_GET['sort'])&&in_array($_GET['sort'],$sort_array)){
            $sort=$_GET['sort'];
        }

        $stm2=$con->prepare("SELECT * FROM categories where parent=0 ORDER BY Ordering $sort");

        $stm2->execute();

        $cats=$stm2->fetchAll();?>
     <?php   
     if(!empty($cats)){
?>
<h1 class="text-center">Manage Category</h1>
<div class="container category">
    <div class="panel panel-default">
           <div class="panel-heading">
           <i class="fa fa-edit"></i> Manage Category
        <div class="option pull-right">
          <i class="fa fa-sort"></i>  Ordering:[
            <a class="<?php  if($sort=='ASC'){echo 'active';} ?>" href="?sort=ASC">Asc</a> |
            
            <a class="<?php  if($sort=='DESC'){echo 'active';} ?>" href="?sort=DESC">Desc</a>]
            <i class="fa fa-eye"></i> View:[ <span class="active" data-view="full">Full</span> |
            <span data-view="classic">Classic</span>]
        </div>
        </div>
               <div class="panel-body">
        <?php
        foreach($cats as $cat){
            echo "<div class='cat'>";
            echo"<div class='hiiden-button'>";
                echo "<a href='categories.php?do=Edit&catId=". $cat['Id'] ."' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
                echo "<a href='categories.php?do=Delet&catId=". $cat['Id'] ."' class='confirmation btn btn-xs btn-danger'><i class='fa-solid fa-xmark bbb'></i>Delete</a>";
            echo "</div>";
                    echo "<h3>". $cat['Name']."</h3>";
                    // *****
                    echo "<div class='full-view'>";
                                echo "<p>" ; 
                                if( $cat['Description']==''){
                                    echo "This category has no description";
                                }
                                else{ 
                                echo  $cat['Description'];
                                } 
                                echo"</p>";
                                // ******

                                if( $cat['Visibility']==1)
                                {
                                    echo '<span class="Visibile cat-span"><i class="fa fa-eye"></i> Hidden</span>';
                                }
                                // ********
                                if($cat['Allow_Comment']==1){
                                echo '<span class="Comment"><i class="fa fa-close"></i> Comment Disabled </span>';
                                }
                            // ********
                                if($cat['Allow_Ads']==1)
                                {
                                    echo '<span class="Adds"><i class="fa fa-close"></i> Adds Disabled</span>';
                                }
                                // ********
                     echo "</div>";
                     
                                    // get child category
                                    $childCat=getِAllFrom("*","categories","where parent= {$cat['Id']}","","Id","ASC");
                                    if(!empty($childCat)){
                                    echo "<h4 class='childe-head'>Child Categories</h4>";
                                      echo "<ul class='list-unstyled child-cat'>";
                                    foreach($childCat as $c){
                                            echo "<li class='child-link'>
                                                <a href='categories.php?do=Edit&catId=". $c['Id'] ."'>". $c['Name']."</a>
                                                 <a href='categories.php?do=Delet&catId=". $c['Id'] ."' class='show-delete confirmation'>Delete</a>

                                             </li>";
                                    }
              echo  "</ul>";
             
    
          } 
            echo"</div>";
           
        echo "<hr>";
    }
        ?>
    </div>
    </div>
 <a class="add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i>Add New Category</a>
</div>
<?php  
     }
     else{
        echo '<div class="container">';
        
      echo " <div class='nice-message'>There is no Category to show</div>";
       ' </div>';
    echo  ' <a href="categories.php?do=Add" class="btn btn-primary"><i class="fa fa-plus bbb"></i>Add Category</a>';

     }


?>
<?php

      }
      elseif($do=='Add'){
        ?>
        
         <!-- add member page  -->
    <h1 class="text-center">Add new Category</h1>  
    <div class="container">
        <form class="form-horizontal"  action="?do=Insert" method="POST">
            <!-- <input type="hidden" name="userid" value="<?php echo $userid  ?>"> -->
            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text" name="name"class="form-control" autocomplete="off" required="required"placeholder="Name of the category ">
                </div>
             
          
            </div>
            <!-- ****************************** -->
            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Descreption</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text" id="descreption" name="descreption"class="form-control" placeholder="Descripe the Category">
                </div>
             
          
            </div>

            <!-- ****************************** -->

            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Ordering</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text" name="ordering"class="form-control" placeholder="Number to arrange categories">
                </div>
             
          
            </div>
             <!-- ****************************** -->
            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Parent ?</label>
                <div class="col-sm-10 col-md-6">
                    <select name="parent">
                        <option value="0">None</option>
                         <?php
                            $allCat=getِAllFrom("*","categories","WHERE parent=0","","Id","ASC");
                            foreach($allCat as $cat){
                                echo "<option value='".$cat['Id']."'>".$cat['Name']."</option>";
                            }
                         
                         ?>
                    </select>
            </div>
             
          
            </div>
             <!-- ****************************** -->
            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Visibile</label>
                <div class="col-sm-10 col-md-6">
                <div>
                    <input id="vis-yes" type="radio" name="Visibility" Value="0" checked>
                    <label for="vis-yes">Yes</label>
                </div>
                <div>
                    <input id="vis-no" type="radio" name="Visibility" Value="1">
                    <label for="vis-no">No</label>
                </div>
            </div>
                         <!-- ****************************** -->
                         </div>
            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">ِAllow Commenting</label>
                <div class="col-sm-10 col-md-6">
                <div>
                    <input id="com-yes" type="radio" name="Commenting" Value="0" checked>
                    <label for="com-yes">Yes</label>
                </div>
                <div>
                    <input id="com-no" type="radio" name="Commenting" Value="1">
                    <label for="com-no">No</label>
                </div>
            </div>
                         <!-- ****************************** -->
              </div>
            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">ِAllow Adds</label>
                <div class="col-sm-10 col-md-6">
                <div>
                    <input id="ads-yes" type="radio" name="ads" Value="0" checked>
                    <label for="ads-yes">Yes</label>
                </div>
                <div>
                    <input id="ads-no" type="radio" name="ads" Value="1">
                    <label for="ads-no">No</label>
                </div>
            </div>
             <!-- ****************************** -->

          
            </div>
             <!-- ****************************** -->
            <div  class="form-group form-group-lg">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit"class="btn btn-primary btn-lg" value="Add Categories " >
                </div>
             
          
            </div>
             <!-- ****************************** -->

        </form>
    </div>
<?php
     
        
        
        
   
      }
      elseif($do=='Insert'){

    if($_SERVER['REQUEST_METHOD']=='POST'){
            
        echo "<h1 class='text-center'>Insert Category</h1>";
        echo"<div class='container'>";
            
    //   $id       =$_POST['userid'];
      $name            =$_POST['name'];
      $descreption     =$_POST['descreption'];
      $ordering        =$_POST['ordering'];
      $parent          =$_POST['parent'];
      $Visibility      =$_POST['Visibility'];
      $Commenting      =$_POST['Commenting'];
      $ads             =$_POST['ads'];
      

      // validate******************************************
      
    
        // $value="leen";
        $check2= checkItem("Name","categories",$name );
        if($check2==1){
            $msg= "<div class='alert alert-danger'> Sorry This Category is Exist</div>";
            redirectHome($msg,'back');

        }

        else{
                $sql = "INSERT INTO categories
                    (Name,Description,Ordering,parent,Visibility,Allow_Comment,Allow_Ads)
                    VALUES
                    (:zname,:zdescription,:zorder,:zparent,:zvisible,:zcomment,:zads)";
        
            $result = $con->prepare($sql);
            $result->execute(array(
                'zname'            =>$name,
                'zdescription'     =>$descreption,
                'zorder'           =>$ordering ,
                'zparent'           =>$parent ,
                'zvisible'         => $Visibility,
                'zcomment'         =>$Commenting,
                'zads'             =>$ads
            ));
            // $row=$result->fetch();
                // $count=$result->rowCount();
                $msg= "<div class='alert alert-success'>" . $result->rowCount() . ' Record Insert </div>';
                redirectHome($msg,'back');
  }
        
      }
     else{
     echo " <div class='container'>";  
      $msg= '<div class="alert alert-danger">Sorry you cant browes this page directly</div> ';
      redirectHome($msg,'back');
      echo "</div>";
}
  
    echo "</div>";
   } 
    //   *****************************************************
    //   *****************************************************

      elseif($do=='Edit'){
        $catId= isset($_GET['catId'])&&is_numeric($_GET['catId'] )?intval($_GET['catId']):0; 
          
        $stmt =  $con->prepare("SELECT * FROM categories WHERE Id=?");

         $stmt->execute(array($catId));
         $cat=$stmt->fetch();
         $count=$stmt->rowCount();

         if($count > 0){ ?>

<h1 class="text-center">Edit Category</h1>  
    <div class="container">
        <form class="form-horizontal"  action="?do=Update" method="POST">
        <input type="hidden" name="catId" value="<?php echo $catId  ?>">

            <!-- <input type="hidden" name="userid" value="<?php echo $userid  ?>"> -->
            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text" name="name"class="form-control" required="required"placeholder="Name of the category " Value="<?php echo $cat['Name']  ?>">
                </div>
             
          
            </div>
            <!-- ****************************** -->
            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Descreption</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text" id="descreption" name="descreption"class="form-control" placeholder="Descripe the Category" Value="<?php echo $cat['Description']  ?>">
                </div>
             
          
            </div>

            <!-- ****************************** -->

            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Ordering</label>
                <div class="col-sm-10 col-md-6">
                    <input type="text" name="ordering"class="form-control" placeholder="Number to arrange categories" Value="<?php echo $cat['Ordering']  ?>">
                </div>
             
          
            </div>
             <!-- ****************************** -->
             <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Parent ? </label>
                <div class="col-sm-10 col-md-6">
                    <select name="parent">
                        <option value="0">None</option>
                         <?php
                            $allCat=getِAllFrom("*","categories","WHERE parent=0","","Id","ASC");
                            foreach($allCat as $c){
                                echo "<option value='".$c['Id']."'";
                                if($cat['parent'] == $c['Id']){echo'selected';}
                               echo ">".$c['Name']."</option>";
                            }
                         
                         ?>
                    </select>
            </div>
          
            </div>
               <!-- ****************************** -->

            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Visibile</label>
                <div class="col-sm-10 col-md-6">
                <div>
                    <input id="vis-yes" type="radio" name="Visibility" Value="0"<?php if($cat['Visibility']==0){echo 'checked';}   ?>>
                    <label for="vis-yes">Yes</label>
                </div>
                <div>
                    <input id="vis-no" type="radio" name="Visibility" Value="1" <?php if($cat['Visibility']==1){echo 'checked';}   ?>>
                    <label for="vis-no">No</label>
                </div>
            </div>
                         <!-- ****************************** -->
                         </div>
            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">ِAllow Commenting</label>
                <div class="col-sm-10 col-md-6">
                <div>
                    <input id="com-yes" type="radio" name="Commenting" Value="0"<?php if($cat['Allow_Comment']==0){echo 'checked';}   ?>>
                    <label for="com-yes">Yes</label>
                </div>
                <div>
                    <input id="com-no" type="radio" name="Commenting" Value="1"<?php if($cat['Allow_Comment']==1){echo 'checked';}   ?>>
                    <label for="com-no">No</label>
                </div>
            </div>
                         <!-- ****************************** -->
              </div>
            <div  class="form-group form-group-lg">
                <label class="col-sm-2 control-label">ِAllow Adds</label>
                <div class="col-sm-10 col-md-6">
                <div>
                    <input id="ads-yes" type="radio" name="ads" Value="0"<?php if($cat['Allow_Ads']==0){echo 'checked';}   ?>>
                    <label for="ads-yes">Yes</label>
                </div>
                <div>
                    <input id="ads-no" type="radio" name="ads" Value="1"<?php if($cat['Allow_Ads']==1){echo 'checked';}   ?>>
                    <label for="ads-no">No</label>
                </div>
            </div>
             <!-- ****************************** -->

          
            </div>
             <!-- ****************************** -->
            <div  class="form-group form-group-lg">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit"class="btn btn-primary btn-lg" value="Save Categories " >
                </div>
             
          
            </div>
             <!-- ****************************** -->

        </form>
         </div>
      
          <?php  
   
    }else{
        echo "<div class='container'> ";
       $msg= '<div class="alert alert-danger"> There is no such ID</div>'; 
       redirectHome($msg);


       echo "</div> ";
    }
  }


      

       //   *****************************************************
    //   *****************************************************

      elseif($do=='Update'){
        echo "<h1 class='text-center'>Update Category</h1>";
        echo"<div class='container'>";
        if($_SERVER['REQUEST_METHOD']=='POST'){
            
          $catId       = $_POST['catId'];
          $name        =  $_POST['name'];
          $descreption = $_POST['descreption'];
          $ordering    = $_POST['ordering'];
          $parent      = $_POST['parent'];
          $Visibility  = $_POST['Visibility'];
          $Commenting  = $_POST['Commenting'];
          $ads         = $_POST['ads'];
          
          $sql = "UPDATE 
                    categories 
                  SET
                     Name=? , 
                     Description=?,
                      Ordering=? ,
                      parent=? ,
                      Visibility=? ,
                      Allow_Comment=? ,
                      Allow_ads=?
                  WHERE Id=?";
     
         $result = $con->prepare($sql);
          $result->execute(array($name,$descreption,$ordering,$parent,$Visibility,$Commenting,$ads,$catId));
         // $row=$result->fetch();
      //    $count=$result->rowCount();
          $msg= "<div class='alert alert-success'>" . $result->rowCount() . ' Record Update </div>';
          redirectHome($msg,'back');
        
        }
         else{
         $msg= '<div class="alert alert-danger">Sorry you cant browes this page directly</div>';
          redirectHome($msg);
      
        }
      
        echo "</div>";
      }
      

    //   *****************************************************
    //   *****************************************************

      elseif($do=='Delet'){
        echo "<h1 class='text-center'>Delete Category</h1>";
        echo "<div class='container'>";
    
        $catId= isset($_GET['catId'])&&is_numeric($_GET['catId'] )?intval($_GET['catId']):0; 
              
        
        $check=checkItem('Id','categories',$catId);
        
    
            if($check>0){
                $stmt = $con->prepare("DELETE FROM `categories` WHERE Id =?");
                $stmt->execute(array($catId));
                $msg= "<div class='alert alert-success isConfirmed'>" . $stmt->rowCount() . ' Record Deleted </div>';
    
                redirectHome($msg,'back');
    
    
            }
            else{
    
                    $msg= '<div class="alert alert-danger">This is Not Exist</div>';
                    redirectHome($msg);
    
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