<?php
    include "head.php";
    
    $user1=new user("yelizhi");
    
    echo $user1->get_id(); 
    echo $user1->get_lv();
    echo $user1->get_pos();
    echo $user1->get_name();
?>