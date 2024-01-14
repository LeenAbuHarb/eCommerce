
<?php

$do='';

$do= isset($_GET['do'])?$_GET['do']:'Manage';


if($do=='Manage'){
    echo 'welcome in Mange page';
}
elseif($do=='Add'){
    echo 'welcome in ADD page';

}
else{
    echo'Error page';
}

?>