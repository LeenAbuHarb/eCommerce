<?php 
ob_start();
session_start();
$pageTitle = 'Create New Item';
include 'init.php';

if(isset($_SESSION['anyuser'])){
   
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $formError=array();
        $title         =filter_var($_POST['name'],FILTER_SANITIZE_STRING);
        $descreption   =filter_var($_POST['descreption'],FILTER_SANITIZE_STRING);
        $price         =filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
        $country       =filter_var($_POST['country'],FILTER_SANITIZE_STRING);
        $status        =filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
        $categories    =filter_var($_POST['categories'],FILTER_SANITIZE_NUMBER_INT);
        $tags          =filter_var($_POST['tags'],FILTER_SANITIZE_STRING);

        if(empty($title)){
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
      
      
        if(($categories==0)){
            $formError[]= 'You must Choose the <strong>categories</strong>';
    
        }
      
        // .....
      if(empty($formError)){
        
        $sql =$con->prepare( "INSERT items
            (Name,Description,Price,Country_Made,Status,Add_Date,Cat_ID,Member_ID,tags)
            VALUES
            (:zname,:zdesc,:zprice,:zcountry,:zstatus,now(),:zcat,:zmember,:ztags)");

                $sql->execute(array(
                    'zname'     =>$title,
                    'zdesc'     =>$descreption,
                    'zprice'    =>$price,
                    'zcountry'  =>$country,
                    'zstatus'   =>$status,
                    'zcat'      =>$categories,
                    'ztags'      =>$tags,
                    'zmember'   =>$_SESSION['uid']
                ));
                
                if($sql){
                     $succesMsg='You Must Been Added';
                }
               

            }

    }
 
?>
<h1 class="text-center"><?php echo $pageTitle  ?></h1>
    <div class="information block">
        <div class="container">
            <div class="panel">
                <div class="panel-heading"><?php echo $pageTitle  ?></div>
                <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8">
                                <form class="form-horizontal main-form"  action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                    <div  class="form-group form-group-lg">
                                        <label class="col-sm-3 control-label">Name</label>
                                        <div class="col-sm-10 col-md-9">
                                            <input pattern=".{4,}" title="This Filed Require At Least 4 Character" type="text" name="name"class="form-control live" autocomplete="off" required="required"placeholder="Name of the Item" data-class=".live-title">
                                        </div>
                                    
                                
                                    </div>
                                    <!-- ****************************** -->
                                    <div  class="form-group form-group-lg">
                                        <label class="col-sm-3 control-label">Descreption</label>
                                        <div class="col-sm-10 col-md-9">
                                            <input pattern=".{10,}" title="This Filed Require At Least 10 Character" type="text" name="descreption"class="form-control live" autocomplete="off" required="required"placeholder="Descreption of the Item "data-class=".live-desc">
                                        </div>
                                    
                                
                                    </div>
                                    <!-- ****************************** -->
                                    <!-- ****************************** -->
                                    <div  class="form-group form-group-lg">
                                        <label class="col-sm-3 control-label">Price</label>
                                        <div class="col-sm-10 col-md-9">
                                            <input type="text" name="price"class="form-control live" autocomplete="off" required="required"placeholder="$" data-class=".live-price">
                                        </div>
                                    
                                
                                    </div>
                                    <!-- ****************************** -->
                                    <div  class="form-group form-group-lg">
                                        <label class="col-sm-3 control-label">Country</label>
                                        <div class="col-sm-10 col-md-9">
                                            <input type="text" name="country"class="form-control" autocomplete="off" required="required"placeholder="Country of Made">
                                        </div>
                                    
                                
                                    </div>
                                    <!-- ****************************** -->
                                    <div  class="form-group form-group-lg">
                                        <label class="col-sm-3 control-label">Status</label>
                                        <div class="col-sm-10 col-md-9">
                                            <Select name="status" required>
                                                <option value="">..</option>
                                                <option value="1">New</option>
                                                <option value="2">Like New</option>
                                                <option value="3">Used</option>
                                                <option value="4">Old</option>
                                            </Select>
                                        </div>
                                    
                                
                                    </div>
                                
                                    <!-- ****************************** -->
                                    <div  class="form-group form-group-lg">
                                        <label class="col-sm-3 control-label">Categories</label>
                                        <div class="col-sm-10 col-md-9">
                                            <div class="select-wrapper">
                                                <Select name="categories" required>
                                                <option value="">..</option>
                                            <?php

                                               $cats= getِAllFrom('*','categories','','','Id','ASC');
                                                foreach($cats as $cat){
                                                    echo "<option value='
                                                                     ".$cat['Id']."' >
                                                                     ". $cat['Name'] . 
                                                            "</option>";
                                                }
                                            ?>
                                            </Select>
                                            </div>
                                            
                                        </div>
                                    
                                
                                    </div>

                                    <!-- ****************************** -->
                                    <div  class="form-group form-group-lg">
                                            <label class="col-sm-3 control-label">Tags</label>
                                            <div class="col-sm-10 col-md-9">
                                                <input type="text" name="tags"class="form-control" autocomplete="off" placeholder="Separate Tags With Comma (,)">
                                            </div>
                                        
                                    
                                        </div>
                                    <!-- ****************************** -->
                                    <div  class="form-group form-group-lg">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input type="submit"class="btn btn-primary btn-sm" value="Add New Item" >
                                        </div>
                                    
                                
                                    </div>
                                    <!-- ****************************** -->

                                </form>  
                            </div>


                            <div class="col-md-4">
                                  <div class="thumbnail item-box live-preview">
                                     <span class="price-tag">
                                        $<span class="live-price"></span>
                                     </span>
                                     <img class="img=responsive"src="22-223863_no-avatar-png-circle-transparent-png.png" alt=""/>
                                       <div class="caption">
                                             <h3 class="live-title">Title</h3>
                                                 <p class="live-desc">Descreption</p>
                                         </div>
                                    </div>
                             </div>
                        </div>
                        <!-- Loopiing For ERROR -->
                        <?php
                        if(!empty($formError)){
                            foreach($formError as $error){
                                echo '<div class="alert alert-danger">'.$error.'</div>';
                            }
                        }
                        if(isset($succesMsg)){
                            echo '<div class="alert alert-success">'. $succesMsg .'</div>';
                  
                          }
                  

                        ?>
                </div>
            </div>
        </div>
    </div>
    <!-- ************ -->
<?php
}
else{
    header('Location:login.php');
    exit();
}
include $tpl .'footer.php';
ob_end_flush();

?>
