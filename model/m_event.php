<?php

/*
 * 功能：事件实现方法
 * 版本：0.1
 * 作者：谜来谜去
 * 时间：2015.7.3
 * 
 * ID   |NUMBER     |MODEL      |USER       |TYPE       |TEXT       |INPUT_TIME     |SYSTEM_TIME
 * 
 */

include_once "../include/head.php";

class event
{
    /*
     * $from [操作者],$type [事件类别],$event_text [事件文本],$input_time [录入时间]
     * 
     * 事件类别："入库","出库","修改","维修","保养"
     */
    public function write($number,$model,$user,$type,$event_text,$input_time)
    {
        $user_database=new database();
        
        //更改时区到东8区。
        date_default_timezone_set('PRC');
            
        //获取系统时间
        //'y-m-d H:i:s' 24小时制
        //'y-m-d h:i:s' 12小时制
        $system_time=date('y-m-d H:i:s',time());
        
        
        $sql="insert into ".$GLOBALS["EVENT_DATABASE_TABLE"]." set `NUMBER`='".$number."',`MODEL`='".$model."',`USER`='".$user."',`TYPE`='".$type."',`TEXT`='".$event_text.
             "',`INPUT_TIME`='".$input_time."',`SYSTEM_TIME`='".$system_time."'";
        
        if($result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql))
        {
            return 0;
        }
    }
    
    public function display($page)
    {
        $user_database=new database();
        
        session_start();
        
        //如果是第一页则获取一次总页码数
        if($page==1)
        {
            $sql="select count(*) from  event";
            $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
            $row=mysql_fetch_array($result);
            $page_count=$row[0]/20;
            $_SESSION['page_count']=ceil($page_count);
            $result=null;
        }
        //更新当前页码
        $_SESSION['nowpage']=$page;
        
        //获取第N页
        $sql="select * from ".$GLOBALS["EVENT_DATABASE_TABLE"]." limit ".(($page-1)*20).",".$page*20;  
        
        $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
        
        if($result)
        {
            $i=0;
            
            while($row=mysql_fetch_array($result))
            {
                $table[$i][0]=$row['ID'];
                $table[$i][1]=$row['NUMBER'];
                $table[$i][2]=$row['MODEL'];
                $table[$i][3]=$row['TYPE'];
                $table[$i][4]=$row['TEXT'];
                $table[$i][5]=$row['USER'];
                $table[$i][6]=$row['INPUT_TIME'];
                $table[$i][7]=$row['SYSTEM_TIME'];
                
                $i++;
            }
        }
        else
        {
            echo "查询失败！";
        }
        
        return $table;
    }
}

?>