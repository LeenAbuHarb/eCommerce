<?php


function lang($phrase){

    static $lang=array(

        // navbar  
        'HOME'          =>'Home',
        'Categories'    =>'category',
        'ITEMS'         =>'Items',
        'MEMBER'        =>'Member',
        'COMMENT'       =>'Comment',
        'STATISTICS'    =>'Statistics',
        'LOGS'          =>'Logs',
        'leen'          =>'Section'

    );
    return $lang[$phrase];
}


?>