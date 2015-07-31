<?php
    include_once "../include/head.php";
    include_once "../model/m_event.php";
    
    session_start();
    
    if($_SESSION['user'])
    {
        $tools_event=new event();
        
        $action=$_GET['action'];
        
        switch($action)
        {
            case "display":
                if($_GET['page'])
                {
                    $page=$_GET['page'];
                }
                else
                {
                    $page=1;
                }
                
                if($page>=1)
                {
                    $_SESSION['date']=$tools_event->display($page);
                }

                echo "<meta http-equiv=refresh content='0; url=../view/v_event.php'>";
                break;
        }
    }
?>
