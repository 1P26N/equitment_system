<?php

/*
 * ���ܣ����߿��ʵ�ַ���
 * �汾��0.1
 * ���ߣ�������ȥ
 * ʱ�䣺2015.6.24
 */

include_once "../include/head.php";
include_once "../model/m_event.php";

class tools_stock
{
    public function display($page)
    {
        $user_database=new database();
        
        //session_start();
        
        //����ǵ�һҳ���ȡһ����ҳ����
        if($page==1)
        {
            $sql="select count(*) from  tools_stock";
            $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
            $row=mysql_fetch_array($result);
            $page_count=$row[0]/20;
            $_SESSION['page_count']=ceil($page_count);
            $result=null;
        }
        //���µ�ǰҳ��
        $_SESSION['nowpage']=$page;
        
        //��ȡ��Nҳ
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
            echo "��ѯʧ�ܣ�";
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
    
    
    //���淽��������ͺű���ˣ������������������ݿ⣬û�б��ֻ������һ�����ݡ�
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
                    $event_text="Ʒ���ɡ�".$tools_info['BRAND']."�����Ϊ��".$table[2].
                                "��,��ȫ������ɡ�".$tools_info['QTY_MIN']."�����Ϊ��".$table[3].
                                "��,�ɹ������ɡ�".$tools_info['CYCLE']."�����Ϊ��".$table[4].
                                "��,��СŤ��ֵ�ɡ�".$tools_info['TORQUE_MIN']."�����Ϊ��".$table[5].
                                "��,���Ť��ֵ�ɡ�".$tools_info['TORQUE_MAX']."�����Ϊ��".$table[6].
                                "��,�����ɡ�".$tools_info['PRICE']."�����Ϊ��".$table[7].
                                "��,�����ɡ�".$tools_info['TYPE']."�����Ϊ��".$table[8];
                                "��,�����ɡ�".$tools_info['ACCURACY']."�����Ϊ��".$table[9]."����";
                    
                    $event_type="�޸�";
                    
                    $tools_event=new event();
                    
                    if($tools_event->write("",$row['MODEL'],$_SESSION['user'],$event_type,$event_text,$table[4]))
                    {
                        echo "�¼�д�����";
                    }
                    else
                    {
                        echo "<meta http-equiv=refresh content='0; url=../route.php?control=tools_stock&action=display&page=".$_SESSION['nowpage']."'>";
                    }
                    
                }
                else
                {
                    echo "����д��ʧ�ܣ�";
                }
            }
            else
            {
                echo "�ͺű����";
            }
        }
        else
        {
            echo "�ͺ�Ϊ�գ�";
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
         * $table[0]  �ͺ�
         * $table[1]  Ʒ��
         * $table[2]  ���
         * $table[3]  �۸�
         * $table[4]  ����
         */
        //session_start();
        $user_database=new database();
        
        //�����Ƿ��и��ͺŵĹ����ڿ�
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
        
        //���ұ���Ƿ����ظ�
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
        
        //��tools����룬�������Ѵ�������ֹ���롣
        if($number_exist)
        {
            echo "�ñ���Ѵ��ڣ����������롣��3s�󷵻����ҳ�棩";
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
                 "',`STATE`='�ڿ�'";
            $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
            
            //���д��ɹ��������¼�ϵͳд�롣
            if($result)
            {
                $event_text="�½�������Ŀ���ʲ����Ϊ��".$table[2]."���ͺ�Ϊ��".$table[0].
                            "��������Ϊ��".$table[3]."����״̬Ϊ���ڿ⡯��";
                
                $tools_event=new event();
                
                if($tools_event->write($table[2], $table[0], $_SESSION['user'], "���", $event_text, $table[4]))
                {
                    echo "�¼�д�����";
                }
            }
            else
            {
                echo "д��tools���ݿ����";
                break;
            }
        }
        
        //��tools_stock����룬����ͺŴ��ڣ�����ͺŵĿ������1��������������½�һ����¼��
        if($result)
        {
            if($model_exist)
            {
                $sql="update ".$GLOBALS["TOOLS_DATABASE_STOCK_TABLE"]." set QTY=QTY+1 where `MODEL`='".$table[0]."'";
                $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);

                //д��ɹ������¼����ݿ�д����仯��Ϣ��
                if($result)
                {
                    $sql="select QTY from ".$GLOBALS["TOOLS_DATABASE_STOCK_TABLE"]." where `MODEL`='".$table[0]."'";
                    $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
                    
                    if($result)
                    {
                        $QTY=mysql_fetch_array($result);
                        $qty_read=$QTY['QTY'];
                    }
                    
                    $event_text="��������ɡ�".$qty_read."�����Ϊ��".($qty_read+1)."����";
                    
                    if($tools_event->write($table[2],$table[0],$_SESSION['user'],"���",$event_text,$table[4]))
                    {
                        echo "�¼�д�����";
                        break;
                    }
                    
                    echo "д��ɹ���3s�󷵻����ҳ��";
                    echo "<meta http-equiv=refresh content='3; url=../view/v_tools_stock_in.php'>";
                    return 0;
                }
                else
                {
                    echo "���߿���д��ʧ�ܣ�3s�󷵻����ҳ��";
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
                    $event_text="��������ɡ�0�����Ϊ��".($qty_read+1)."����";
                    
                    if($tools_event->write($table[2],$table[0],$_SESSION['user'],"���",$event_text,$table[4]))
                    {
                        echo "�¼�д�����";
                        break;
                    }
           
                    echo "д��ɹ���3s�󷵻����ҳ��";
                    echo "<meta http-equiv=refresh content='3; url=../view/v_tools_stock_in.php'>";
                    return 0;
                }
                else
                {
                    echo "���߿���д��ʧ�ܣ�3s�󷵻����ҳ��";
                    echo "<meta http-equiv=refresh content='3; url=../view/v_tools_stock_in.php'>";
                }
            }
        }
        else
        {
            echo "�����嵥��д��ʧ�ܣ�3s�󷵻����ҳ��";
        }
        
    }
}

?>
