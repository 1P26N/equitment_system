<?php
include_once "../include/head.php";
include_once "../model/m_event.php";
    
class tools
{   
    public function get_all($page)
    {
        $user_database=new database();
        
        //session_start();
        
        //��ȡҳ����
        if($page==1)
        {
            $sql="select count(*) from  tools";
            $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
            $row=mysql_fetch_array($result);
            $page_count=$row[0]/20;
            $_SESSION['page_count']=ceil($page_count);
            $result=null;
        }
        //���µ�ǰҳ��
        $_SESSION['nowpage']=$page;
        
        //��ȡ��Nҳ
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
            echo "��ѯʧ�ܣ�";
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

    //ɾ����¼
    public function delete($id)
    {
        $user_database=new database();
        $sql="delete from ".$GLOBALS["TOOLS_DATABASE_TABLE"]." where ID='".$id."'";
        $user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
    }
    
    //���湤���ʲ����
    public function save($table)
    {
        /*
         * $table[0] �ʲ����
         * $table[1] ����
         * $table[2] Ť��
         * $table[3] ״̬
         * $table[4] ����
         */
        
        $user_database=new database();
        
        $sql="select * from ".$GLOBALS["TOOLS_DATABASE_TABLE"]." where `NUMBER`='".$table[0]."'";
        $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
        
        if($result)
        {
            $row=mysql_fetch_array($result);
        }
        
        
        //д��tools��
        //����ǵ�һ�γ��⣬��¼����ʱ�䣬���򲻼�¼������ǽ��ֿ��򲻼�¼����
        
        //д�����ʱ��sql��䡣
        $sql_out_time="";
        //д��״̬sql��䡣
        $sql_state="";
        //д�����sql��䡣
        $sql_group="";
        //д��Ť��sql��䡣
        $sql_torque=",`TORQUE`='".$table[2]."'";
        
        if($row['OUT_TIME']=="0000-00-00")
        {
            if($table[1]!="�ֿ�")
            {
                $sql_out_time=",`OUT_TIME`='".$table[4]."'";
            }
        }
        
        switch($table[1])
        {
            case "�ֿ�":
                $sql_state=",`STATE`='�ڿ�'";
                $sql_group="`GROUP`='�ֿ�'";
                $sql_torque=",`TORQUE`=''";
                break;
            
            case "��ȫ":
                $sql_state=",`STATE`='����',";
                $sql_group="`GROUP`='��ȫ'";
                $sql_torque=",`TORQUE`=''";
                break;
            
            default :
                $sql_state=",`STATE`='".$table[3]."'";
                $sql_group="`GROUP`='".$table[1]."'";
        }
        
        if($table[3]=="����")
        {
            $sql_state=",`STATE`='".$table[3]."'";
            $sql_group="`GROUP`=''";
            $sql_torque=",`TORQUE`=''";
        }
        
        $sql="update ".$GLOBALS["TOOLS_DATABASE_TABLE"].
             " set ".$sql_group.$sql_torque.$sql_state.$sql_out_time." where `NUMBER`='".$table[0]."'";
        
        $result=$user_database->search_database($GLOBALS["TOOLS_DATABASE_DB"],$sql);
        
        //д�������ݿ�Ĳ������м�¼����¼��event���ݿ⡣
        //public function write($from [������],$type [�¼����],$event_text [�¼��ı�],$input_time [¼��ʱ��])
        //session_start();
        
        $text_group="";
        $text_torque="";
        $text_state="";
        
        if($result)
        {
            //�����¼�������ı����ݡ�

            $text_group="�����ɡ�".$row["GROUP"]."�����Ϊ��".$table[1]."����";          
            
            switch($table[1])
            {
                case "�ֿ�":
                    $text_torque="�궨Ť���ɡ�".$row["TORQUE"]."�����Ϊ������";
                    $text_state="״̬�ɡ�".$row["STATE"]."�����Ϊ���ڿ⡯��";
                    break;
                
                case "��ȫ":
                    $text_torque="�궨Ť���ɡ�".$row["TORQUE"]."�����Ϊ������";
                    $text_state="״̬�ɡ�".$row["STATE"]."�����Ϊ�����á���";
                    break;
                
                default:
                    $text_torque="�궨Ť���ɡ�".$row["TORQUE"]."�����Ϊ��".$table[2]."����";
                    $text_state="״̬�ɡ�".$row["STATE"]."�����Ϊ��".$table[3]."����";
                    break;
            }
            
            $event_text=$text_group.$text_torque.$text_state."��";
            
            //�����¼����
            //�¼����"���","����","�޸�","ά��","����"
            $event_type="�޸�";
            
            if($row["GROUP"]=="�ֿ�"&&$table[1]!="�ֿ�")
            {
                $event_type="����";
            }
            else if($row["GROUP"]!="�ֿ�"&&$table[1]=="�ֿ�")
            {
                $event_type="���";
            }
            
            //�ύ�¼���¼
            $tools_event=new event();
            
            if($tools_event->write($row['NUMBER'],$row['MODEL'],$_SESSION['user'], $event_type, $event_text, $table[4]))
            {
                echo "�¼�д�����";
            }
            
            if($row["TORQUE"]!=$table[2])
            {
                $text_torque="�궨Ť���ɡ�".$row["TORQUE"]."�����Ϊ��".$table[2]."��";
            }
            
            if($row["STATE"]!=$table[3])
            {
                $text_torque="״̬�ɡ�".$row["TORQUE"]."�����Ϊ��".$table[2]."��";
            }
            
            $_SESSION['user'];
        }
        else
        {
            $event_type="ϵͳ";
            $event_text="д��ʧ�ܣ�";
        }
        
        //д��tools_stock
        //���״̬�ɲֿ��Ϊ����������һ������������Ϊ�ֿ⣬��������һ��
        if($row["STATE"]=="�ڿ�" && $row["STATE"]!=$table[3])
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
            
            //������д���¼���¼
            if($result)
            {
                $event_type="����";
                $event_text="��������ɡ�".$qty_read."�����Ϊ��".($qty_read-1)."����";
                
                if($tools_event->write($row['NUMBER'],$row['MODEL'],$_SESSION['user'],$event_type,$event_text,$table[4]))
                {
                    echo "�¼�д�����";
                }
            }
        }
        else if($row["STATE"]!="�ڿ�" && $table[1]=="�ֿ�")
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
            
            //�������д���¼���¼
            if($result)
            {
                $event_type="���";
                $event_text="��������ɡ�".$qty_read."�����Ϊ��".($qty_read+1)."����";
                
                if($tools_event->write($row['NUMBER'],$row['MODEL'],$_SESSION['user'],$event_type,$event_text,$table[4]))
                {
                    echo "�¼�д�����";
                }
            }
        }
        
    }
}

?>
