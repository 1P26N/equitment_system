<?php

/*
 * 功能：工具库存实现方法
 * 版本：0.1
 * 作者：谜来谜去
 * 时间：2015.6.24
 */

include_once "../include/head.php";
include_once "../model/m_event.php";

class tools_stock
{
    public function display($page)
    {
        $user_database=new database();
        
        //session_start();
        
        //如果是第一页则获取一次总页码数
        if($page==1)
        {
            $sql="select count(*) from  tools_stock";
            $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
            $row=mysql_fetch_array($result);
            $page_count=$row[0]/20;
            $_SESSION['page_count']=ceil($page_count);
            $result=null;
        }
        //更新当前页码
        $_SESSION['nowpage']=$page;
        
        //获取第N页
        $sql="select * from ".$GLOBALS["TOOLS_DATABASE_STOCK_TABLE"]." limit ".(($page-1)*20).",".$page*20;  
        
        $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
        
        if($result)
        {
            $i=0;
            
            while($row=mysql_fetch_array($result))
            {
                $table[$i][0]=$row['ID'];
                $table[$i][1]=$row['MODEL'];
                $table[$i][2]=$row['BRAND'];
                $table[$i][3]=$row['TYPE'];
                $table[$i][4]=$row['ACCURACY'];
                $table[$i][5]=$row['QTY'];
                $table[$i][6]=$row['QTY_MIN'];
                $table[$i][7]=$row['CYCLE'];
                $table[$i][8]=$row['TORQUE_MIN'];
                $table[$i][9]=$row['TORQUE_MAX'];
                $table[$i][10]=$row['PRICE'];
                
                $i++;
            }
        }
        else
        {
            echo "查询失败！";
        }
        
        return $table;
    }
    
    public function edit($id)
    {
        $user_database=new database();
        $sql="select * from ".$GLOBALS["TOOLS_DATABASE_STOCK_TABLE"]." where MODEL='".$id."'";
        $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
        
        if($result)
        {
            $row=mysql_fetch_array($result);
            $table[0]=$row['ID'];
            $table[1]=$row['MODEL'];
            $table[2]=$row['BRAND'];
            $table[3]=$row['TYPE'];
            $table[4]=$row['ACCURACY'];
            $table[5]=$row['QTY'];
            $table[6]=$row['QTY_MIN'];
            $table[7]=$row['CYCLE'];
            $table[8]=$row['TORQUE_MIN'];
            $table[9]=$row['TORQUE_MAX'];
            $table[10]=$row['PRICE'];
        }
               
        return $table;
    }
    
    
    //保存方法。如果型号变更了，则需更新所有相关数据库，没有变更只更新这一条数据。
    public function save($table)
    {
        if($table[1]!=null)
        {
            $user_database=new database();
            
            $sql="select * from ".$GLOBALS["TOOLS_DATABASE_STOCK_TABLE"]." where `ID`='".$table[0]."'";
            $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
            $tools_info=mysql_fetch_array($result);
            
            
            $sql="select MODEL from ".$GLOBALS["TOOLS_DATABASE_STOCK_TABLE"].
                 " where `ID`='".$table[0]."'";
            $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
            $row=mysql_fetch_array($result);
            
            if($row['MODEL']==$table[1])
            {
                $sql="update ".$GLOBALS["TOOLS_DATABASE_STOCK_TABLE"].
                 " set `MODEL`='".$table[1].
                 "',`BRAND`='".$table[2].
                 "',`QTY_MIN`='".$table[3].
                 "',`CYCLE`='".$table[4].
                 "',`TORQUE_MIN`=".$table[5].
                 ",`TORQUE_MAX`='".$table[6].
                 "',`PRICE`=".$table[7].
                 ",`TYPE`='".$table[8].
                 "',`ACCURACY`='".$table[9].
                 "' where `ID`='".$table[0]."'";
                
                if($user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql))
                {                   
                    $event_text="品牌由‘".$tools_info['BRAND']."’变更为‘".$table[2].
                                "’,安全库存量由‘".$tools_info['QTY_MIN']."’变更为‘".$table[3].
                                "’,采购周期由‘".$tools_info['CYCLE']."’变更为‘".$table[4].
                                "’,最小扭力值由‘".$tools_info['TORQUE_MIN']."’变更为‘".$table[5].
                                "’,最大扭力值由‘".$tools_info['TORQUE_MAX']."’变更为‘".$table[6].
                                "’,单价由‘".$tools_info['PRICE']."’变更为‘".$table[7].
                                "’,类型由‘".$tools_info['TYPE']."’变更为‘".$table[8];
                                "’,精度由‘".$tools_info['ACCURACY']."’变更为‘".$table[9]."’。";
                    
                    $event_type="修改";
                    
                    $tools_event=new event();
                    
                    if($tools_event->write("",$row['MODEL'],$_SESSION['user'],$event_type,$event_text,$table[4]))
                    {
                        echo "事件写入错误！";
                    }
                    else
                    {
                        echo "<meta http-equiv=refresh content='0; url=../route.php?control=tools_stock&action=display&page=".$_SESSION['nowpage']."'>";
                    }
                    
                }
                else
                {
                    echo "数据写入失败！";
                }
            }
            else
            {
                echo "型号变更！";
            }
        }
        else
        {
            echo "型号为空！";
        }
        
    }
    
    public function get_model_list()
    {
        $user_database=new database();
        $sql="select MODEL from ".$GLOBALS["TOOLS_DATABASE_STOCK_TABLE"];
        $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
        
        $i=0;
        while($row=mysql_fetch_array($result))
        {
            $table[$i]=$row["MODEL"];
            $i++;
        }
        
        return $table;
    }
    
    public function in($table)
    {
        /*
         * $table[0]  型号
         * $table[1]  品牌
         * $table[2]  编号
         * $table[3]  价格
         * $table[4]  日期
         */
        //session_start();
        $user_database=new database();
        
        //查找是否有该型号的工具在库
        $sql="select count(*) from ".$GLOBALS["TOOLS_DATABASE_STOCK_TABLE"]." where `MODEL`='".$table[0]."'";
        $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
        $row=mysql_fetch_array($result);
        if($row[0]==1)
        {
            $model_exist=true;
        }
        else
        {
            $model_exist=false;
        }
        
        //查找编号是否有重复
        $sql="select count(*) from ".$GLOBALS["TOOLS_DATABASE_TABLE"]." where `NUMBER`='".$table[2]."'";
        $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
        $row=mysql_fetch_array($result);
        
        if($row[0]==1)
        {
            $number_exist=true;
        }
        else
        {
            $number_exist=false;
        }
        
        //向tools表插入，如果编号已存在则终止插入。
        if($number_exist)
        {
            echo "该编号已存在，请重新输入。（3s后返回入库页面）";
            echo "<meta http-equiv=refresh content='3; url=../view/v_tools_stock_in.php'>";
            return 1;
        }
        else
        {
            $sql="insert into ".$GLOBALS["TOOLS_DATABASE_TABLE"].
                 " set `NUMBER`='".$table[2].
                 "',`MODEL`='".$table[0].
                 "',`IN_TIME`='".$table[4].
                 "',`PRICE`='".$table[3].
                 "',`STATE`='在库'";
            $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
            
            //如果写入成功，则向事件系统写入。
            if($result)
            {
                $event_text="新建工具条目：资产编号为‘".$table[2]."，型号为‘".$table[0].
                            "’，单价为‘".$table[3]."’，状态为‘在库’。";
                
                $tools_event=new event();
                
                if($tools_event->write($table[2], $table[0], $_SESSION['user'], "入库", $event_text, $table[4]))
                {
                    echo "事件写入错误！";
                }
            }
            else
            {
                echo "写入tools数据库错误！";
                break;
            }
        }
        
        //向tools_stock表插入，如果型号存在，则该型号的库存数加1。如果不存在则新建一条记录。
        if($result)
        {
            if($model_exist)
            {
                $sql="update ".$GLOBALS["TOOLS_DATABASE_STOCK_TABLE"]." set QTY=QTY+1 where `MODEL`='".$table[0]."'";
                $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);

                //写入成功后，向事件数据库写入库存变化信息。
                if($result)
                {
                    $sql="select QTY from ".$GLOBALS["TOOLS_DATABASE_STOCK_TABLE"]." where `MODEL`='".$table[0]."'";
                    $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
                    
                    if($result)
                    {
                        $QTY=mysql_fetch_array($result);
                        $qty_read=$QTY['QTY'];
                    }
                    
                    $event_text="库存数量由‘".$qty_read."’变更为‘".($qty_read+1)."’。";
                    
                    if($tools_event->write($table[2],$table[0],$_SESSION['user'],"入库",$event_text,$table[4]))
                    {
                        echo "事件写入错误！";
                        break;
                    }
                    
                    echo "写入成功！3s后返回入库页面";
                    echo "<meta http-equiv=refresh content='3; url=../view/v_tools_stock_in.php'>";
                    return 0;
                }
                else
                {
                    echo "工具库存表写入失败！3s后返回入库页面";
                    echo "<meta http-equiv=refresh content='3; url=../view/v_tools_stock_in.php'>";
                }
            }
            else
            {
                $sql="insert into ".$GLOBALS["TOOLS_DATABASE_STOCK_TABLE"].
                     " set `MODEL`='".$table[0].
                     "',`BRAND`='".$table[1].
                     "',`QTY`=1
                       ,`PRICE`=".$table[3];

                $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);

                if($result)
                {   
                    $event_text="库存数量由‘0’变更为‘".($qty_read+1)."’。";
                    
                    if($tools_event->write($table[2],$table[0],$_SESSION['user'],"入库",$event_text,$table[4]))
                    {
                        echo "事件写入错误！";
                        break;
                    }
           
                    echo "写入成功！3s后返回入库页面";
                    echo "<meta http-equiv=refresh content='3; url=../view/v_tools_stock_in.php'>";
                    return 0;
                }
                else
                {
                    echo "工具库存表写入失败！3s后返回入库页面";
                    echo "<meta http-equiv=refresh content='3; url=../view/v_tools_stock_in.php'>";
                }
            }
        }
        else
        {
            echo "工具清单表写入失败！3s后返回入库页面";
        }
        
    }
}

?>
