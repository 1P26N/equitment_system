<?php
/*
 * 
 */
    
    include_once "../include/head.php";
    include_once "../model/m_tools.php";
    
    session_start();
    
    if($_SESSION['user'])
    {
    
        $tools1=new tools();

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
                   // session_start();

                    $_SESSION['date']=$tools1->get_all($page);
                }

                echo "<meta http-equiv=refresh content='0; url=../view/v_tools_display.php'>";
                break;

            case "insert":
                break;

            case "edit":
                if($_SESSION['lv']<2)
                {
                    if($_GET['id'])
                    {
                        $id=$_GET['id'];
                    }
                    else
                    {
                        echo "未定义ID。";
                        break;
                    }
                    if($id)
                    {
                        $_SESSION['date']=$tools1->edit($id);
                    }

                    echo "<meta http-equiv=refresh content='0; url=../view/v_tools_edit.php'>";
                }
                else
                {
                    echo "无权限访问！";
                    echo "<meta http-equiv=refresh content='3; url=../route.php?control=tools&action=display&page=".$_SESSION['nowpage']."'>";
                }
                break;
   
            case "save":
                if($_SESSION['lv']<2)
                {
                    if($_GET['number'])
                    {
                        $table[0]=$_GET['number'];
                        $table[1]=$_GET['group'];
                        $table[2]=$_GET['torque'];
                        $table[3]=$_GET['state'];
                        $table[4]=$_GET['date'];

                        $tools1->save($table);
                        echo "<meta http-equiv=refresh content='0; url=../route.php?control=tools&action=display&page=".$_SESSION['nowpage']."'>";
                    }
                }
                else
                {
                    echo "无权限访问！";
                    echo "<meta http-equiv=refresh content='3; url=../route.php?control=tools&action=display&page=".$_SESSION['nowpage']."'>";
                }
                break;
                
            default:
                echo "未定义动作。";
                break;
        }
    }
?>
