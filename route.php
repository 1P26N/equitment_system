<?php

/*
 * 功能：路由控制
 * 版本：0.1
 * 作者：谜来谜去
 * 时间：2015.6.24
*/

    include "include\head.php";
    
    $controller=$_GET['control'];
    $action=$_GET['action'];
    
    //echo $controller;
    //echo $action;
    
    if($controller && $action)
    {
        switch($action)
        {
            case "display":
                $page=$_GET['page'];
                echo "<meta http-equiv=refresh content='0; url=controller\c_".$controller.".php?action=".$action."&page=".$page."'>";
                break;
            case "delete":
                $id=$_GET['id'];
                echo "<meta http-equiv=refresh content='0; url=controller\c_".$controller.".php?action=".$action."&id=".$id."'>";
                break;
            case "edit":
                $id=$_GET['id'];
                echo "<meta http-equiv=refresh content='0; url=controller\c_".$controller.".php?action=".$action."&id=".$id."'>";
                break;
            case "in":
                echo "<meta http-equiv=refresh content='0; url=controller\c_".$controller.".php?action=".$action."'>";
                break;
            case "out":
                echo "<meta http-equiv=refresh content='0; url=controller\c_".$controller.".php?action=".$action."'>";
                break;
        }
    }
    else
    {
        echo "缺少条件!";
    }
?>
