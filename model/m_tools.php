<?php
include_once "../include/head.php";
include_once "../model/m_event.php";
    
class tools
{   
    public function get_all($page)
    {
        $user_database=new database();
        
        //session_start();
        
        //获取页码数
        if($page==1)
        {
            $sql="select count(*) from  tools";
            $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
            $row=mysql_fetch_array($result);
            $page_count=$row[0]/20;
            $_SESSION['page_count']=ceil($page_count);
            $result=null;
        }
        //更新当前页码
        $_SESSION['nowpage']=$page;
        
        //获取第N页
        $sql="select * from ".$GLOBALS["TOOLS_DATABASE_TABLE"]." limit ".(($page-1)*20).",".$page*20;        
        $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
        
        if($result)
        {
            $i=0;
            
            while($row=mysql_fetch_array($result))
            {
                $table[$i][0]=$row['NUMBER'];
                $table[$i][1]=$row['MODEL'];
                $table[$i][2]=$row['IN_TIME'];
                $table[$i][3]=$row['PRICE'];
                $table[$i][4]=$row['OUT_TIME'];
                $table[$i][5]=$row['GROUP'];
                $table[$i][6]=$row['TORQUE'];
                $table[$i][7]=$row['STATE'];

                
                $i++;
            }
        }
        else
        {
            echo "查询失败！";
        }
        
        return $table;
    }
    
    public function get_by_number()
    {
   
    }
    
    public function get_by_groub()
    {
        
    }
    
    public function get_by_user()
    {
        
    }
    
    public function get_by_state()
    {
        
    }
    
    public function get_by_model()
    {
        
    }
    
    public function edit($number)
    {
        $user_database=new database();
        $sql="select * from ".$GLOBALS["TOOLS_DATABASE_TABLE"]." where NUMBER='".$number."'";
        $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
        
        if($result)
        {
            $row=mysql_fetch_array($result);
            $table[0]=$row['NUMBER'];
            $table[1]=$row['MODEL'];
            $table[2]=$row['GROUP'];
            $table[3]=$row['TORQUE'];
            $table[4]=$row['STATE'];          
        }
        return $table;
    }

    //删除记录
    public function delete($id)
    {
        $user_database=new database();
        $sql="delete from ".$GLOBALS["TOOLS_DATABASE_TABLE"]." where ID='".$id."'";
        $user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
    }
    
    //保存工具资产变更
    public function save($table)
    {
        /*
         * $table[0] 资产编号
         * $table[1] 班组
         * $table[2] 扭力
         * $table[3] 状态
         * $table[4] 日期
         */
        
        $user_database=new database();
        
        $sql="select * from ".$GLOBALS["TOOLS_DATABASE_TABLE"]." where `NUMBER`='".$table[0]."'";
        $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
        
        if($result)
        {
            $row=mysql_fetch_array($result);
        }
        
        
        //写入tools表。
        //如果是第一次出库，记录出库时间，否则不记录；如果是进仓库则不记录班组
        
        //写入出库时间sql语句。
        $sql_out_time="";
        //写入状态sql语句。
        $sql_state="";
        //写入班组sql语句。
        $sql_group="";
        //写入扭力sql语句。
        $sql_torque=",`TORQUE`='".$table[2]."'";
        
        if($row['OUT_TIME']=="0000-00-00")
        {
            if($table[1]!="仓库")
            {
                $sql_out_time=",`OUT_TIME`='".$table[4]."'";
            }
        }
        
        switch($table[1])
        {
            case "仓库":
                $sql_state=",`STATE`='在库'";
                $sql_group="`GROUP`='仓库'";
                $sql_torque=",`TORQUE`=''";
                break;
            
            case "保全":
                $sql_state=",`STATE`='备用',";
                $sql_group="`GROUP`='保全'";
                $sql_torque=",`TORQUE`=''";
                break;
            
            default :
                $sql_state=",`STATE`='".$table[3]."'";
                $sql_group="`GROUP`='".$table[1]."'";
        }
        
        if($table[3]=="报废")
        {
            $sql_state=",`STATE`='".$table[3]."'";
            $sql_group="`GROUP`=''";
            $sql_torque=",`TORQUE`=''";
        }
        
        $sql="update ".$GLOBALS["TOOLS_DATABASE_TABLE"].
             " set ".$sql_group.$sql_torque.$sql_state.$sql_out_time." where `NUMBER`='".$table[0]."'";
        
        $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
        
        //写工具数据库的操作进行记录，记录到event数据库。
        //public function write($from [操作者],$type [事件类别],$event_text [事件文本],$input_time [录入时间])
        //session_start();
        
        $text_group="";
        $text_torque="";
        $text_state="";
        
        if($result)
        {
            //生成事件所需的文本内容。

            $text_group="班组由‘".$row["GROUP"]."’变更为‘".$table[1]."’；";          
            
            switch($table[1])
            {
                case "仓库":
                    $text_torque="标定扭力由‘".$row["TORQUE"]."’变更为‘’；";
                    $text_state="状态由‘".$row["STATE"]."’变更为‘在库’；";
                    break;
                
                case "保全":
                    $text_torque="标定扭力由‘".$row["TORQUE"]."’变更为‘’；";
                    $text_state="状态由‘".$row["STATE"]."’变更为‘备用’；";
                    break;
                
                default:
                    $text_torque="标定扭力由‘".$row["TORQUE"]."’变更为‘".$table[2]."’；";
                    $text_state="状态由‘".$row["STATE"]."’变更为‘".$table[3]."’；";
                    break;
            }
            
            $event_text=$text_group.$text_torque.$text_state."。";
            
            //生成事件类别。
            //事件类别："入库","出库","修改","维修","保养"
            $event_type="修改";
            
            if($row["GROUP"]=="仓库"&&$table[1]!="仓库")
            {
                $event_type="出库";
            }
            else if($row["GROUP"]!="仓库"&&$table[1]=="仓库")
            {
                $event_type="入库";
            }
            
            //提交事件记录
            $tools_event=new event();
            
            if($tools_event->write($row['NUMBER'],$row['MODEL'],$_SESSION['user'], $event_type, $event_text, $table[4]))
            {
                echo "事件写入错误！";
            }
            
            if($row["TORQUE"]!=$table[2])
            {
                $text_torque="标定扭力由‘".$row["TORQUE"]."’变更为‘".$table[2]."’";
            }
            
            if($row["STATE"]!=$table[3])
            {
                $text_torque="状态由‘".$row["TORQUE"]."’变更为‘".$table[2]."’";
            }
            
            $_SESSION['user'];
        }
        else
        {
            $event_type="系统";
            $event_text="写入失败！";
        }
        
        //写入tools_stock
        //如果状态由仓库变为其他库存减少一，若由其他变为仓库，则库存增加一。
        if($row["STATE"]=="在库" && $row["STATE"]!=$table[3])
        {
            $sql="select QTY from ".$GLOBALS["TOOLS_DATABASE_STOCK_TABLE"]." where `MODEL`='".$row["MODEL"]."'";
            $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
            
            if($result)
            {
                $QTY=mysql_fetch_array($result);
                $qty_read=$QTY['QTY'];
            }
            
            $sql="update ".$GLOBALS["TOOLS_DATABASE_STOCK_TABLE"]." set QTY=QTY-1 where `MODEL`='".$row["MODEL"]."'";
            $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
            
            //库存减少写入事件记录
            if($result)
            {
                $event_type="出库";
                $event_text="库存数量由‘".$qty_read."’变更为‘".($qty_read-1)."’。";
                
                if($tools_event->write($row['NUMBER'],$row['MODEL'],$_SESSION['user'],$event_type,$event_text,$table[4]))
                {
                    echo "事件写入错误！";
                }
            }
        }
        else if($row["STATE"]!="在库" && $table[1]=="仓库")
        {
            $sql="select QTY from ".$GLOBALS["TOOLS_DATABASE_STOCK_TABLE"]." where `MODEL`='".$row["MODEL"]."'";
            $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
            
            if($result)
            {
                $QTY=mysql_fetch_array($result);
                $qty_read=$QTY['QTY'];
            }
            
            $sql="update ".$GLOBALS["TOOLS_DATABASE_STOCK_TABLE"]." set QTY=QTY+1 where `MODEL`='".$row["MODEL"]."'";
            $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
            
            //库存增加写入事件记录
            if($result)
            {
                $event_type="入库";
                $event_text="库存数量由‘".$qty_read."’变更为‘".($qty_read+1)."’。";
                
                if($tools_event->write($row['NUMBER'],$row['MODEL'],$_SESSION['user'],$event_type,$event_text,$table[4]))
                {
                    echo "事件写入错误！";
                }
            }
        }
        
    }
}

?>
