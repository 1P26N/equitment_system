<?php

/*
 * ���ܣ��¼�ʵ�ַ���
 * �汾��0.1
 * ���ߣ�������ȥ
 * ʱ�䣺2015.7.3
 * 
 * ID   |NUMBER     |MODEL      |USER       |TYPE       |TEXT       |INPUT_TIME     |SYSTEM_TIME
 * 
 */

include_once "../include/head.php";

class event
{
    /*
     * $from [������],$type [�¼����],$event_text [�¼��ı�],$input_time [¼��ʱ��]
     * 
     * �¼����"���","����","�޸�","ά��","����"
     */
    public function write($number,$model,$user,$type,$event_text,$input_time)
    {
        $user_database=new database();
        
        //����ʱ������8����
        date_default_timezone_set('PRC');
            
        //��ȡϵͳʱ��
        //'y-m-d H:i:s' 24Сʱ��
        //'y-m-d h:i:s' 12Сʱ��
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
        
        //����ǵ�һҳ���ȡһ����ҳ����
        if($page==1)
        {
            $sql="select count(*) from  event";
            $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
            $row=mysql_fetch_array($result);
            $page_count=$row[0]/20;
            $_SESSION['page_count']=ceil($page_count);
            $result=null;
        }
        //���µ�ǰҳ��
        $_SESSION['nowpage']=$page;
        
        //��ȡ��Nҳ
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
            echo "��ѯʧ�ܣ�";
        }
        
        return $table;
    }
}

?>