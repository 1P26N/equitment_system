<?php
    include_once "../include/head.php";
    include_once "../model/m_equipment.php";
    
    $equipment1=new equipment();
    
    $action=$_GET['action'];
    
    if($_GET['page'])
    {
        $page=$_GET['page'];
    }
    else
    {
        $page=1;
    }
    
    switch($action)
    {
        case "display":
            if($page>=1)
            {
                session_start();
                
                $_SESSION['date']=$tools1->get_all($page);
            }
            //echo $result[1];
            //session_start();
            //$_SESSION['date']=$result;
            echo "<meta http-equiv=refresh content='0; url=../view/v_tools.php'>";
    }
?>