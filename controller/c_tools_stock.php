<?php

/*
 * 功能：工具库存控制器
 * 版本：0.1
 * 作者：谜来谜去
 * 时间：2015.6.24
 */

 include_once "../include/head.php";
 include_once "../model/m_tools_stock.php";
    
    session_start();
    
    if($_SESSION['user'])
    {
    
        $tools1=new tools_stock();

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
                    $_SESSION['date']=$tools1->display($page);
                }

                echo "<meta http-equiv=refresh content='0; url=../view/v_tools_stock_display.php'>";
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

                    echo "<meta http-equiv=refresh content='0; url=../view/v_tools_stock_edit.php'>";
                }
                else
                {
                    echo "无权限！";
                }
                break;
                
            case "save":
                if($_SESSION['lv']<2)
                {
                    if($_GET['id'])
                    {
                        $table[0]=$_GET['id'];
                        $table[1]=$_POST['MODEL'];
                        $table[2]=$_POST['BRAND'];
                        $table[3]=$_POST['QTY_MIN'];
                        $table[4]=$_POST['CYCLE'];
                        $table[5]=$_POST['TORQUE_MIN'];
                        $table[6]=$_POST['TORQUE_MAX'];
                        $table[7]=$_POST['PRICE'];
                        $table[8]=$_POST['TYPE'];
                        $table[9]=$_POST['ACCURACY'];

                        $tools1->save($table);
                    }
                }
                break;
                
            case "in":
                if($_SESSION['lv']<2)
                {
                    $_SESSION['model_list']=$tools1->get_model_list();
                    echo "<meta http-equiv=refresh content='0; url=../view/v_tools_stock_in.php'>";
                }
                break;
                
            case "insert":
                if($_SESSION['lv']<2)
                {
                    if($_GET['model']!=null)
                    {
                        $table[0]=$_GET['model'];
                    }
                    else
                    {
                        echo "型号为空！";
                        break;
                    }
                    
                    if($_GET['brand']!=null)
                    {
                        $table[1]=$_GET['brand'];
                    }
                    else
                    {
                        echo "品牌为空！";
                        break;
                    }
                    
                    if($_GET['number']!=null)
                    {
                        $table[2]=$_GET['number'];
                    }
                    else
                    {
                        echo "编号为空！";
                        break;
                    }
                    
                    if($_GET['price']!=null && is_numeric($_GET['price']))
                    {
                        $table[3]=$_GET['price'];
                    }
                    else
                    {
                        echo "价格为空或不是数字！";
                        break;
                    }
                    
                    if($_GET['date']!==null)
                    {
                        $table[4]=$_GET['date'];
                    }
                    else
                    {
                        echo "入库日期为空！";
                        break;
                    }
                    
                    $tools1->in($table);
                }
                break;
            
            case "out":
                if($_SESSION['lv']<2)
                {
                    echo "<meta http-equiv=refresh content='0; url=../view/v_tools_stock_out.php'>";
                }
                break;
                
            default:
                echo "未定义动作。";
                break;
        }
    }

?>
