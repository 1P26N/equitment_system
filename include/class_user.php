<?php
    include "env_var.php";
    include "class_database.php";
    
    class user
    {
        private $p_id;  //�˺�
        private $p_pwd; //����
        private $p_lv;  //Ȩ��
        private $p_pos; //ְλ
        private $p_tel; //�绰
        private $p_email; //����
        private $p_name; //����
        private $p_face; //ͷ��
        
        function __construct($ID) 
        { 
            $user_database=new database();
            $sql="select * from user where ID='".$ID."'";
            
            $result=$user_database->query_database($GLOBALS["USER_DATABASE_HOST"], $GLOBALS["USER_DATABASE_USER"], 
                    $GLOBALS["USER_DATABASE_PWD"], $GLOBALS["USER_DATABASE_DB"],$sql);
            
            if($result)
            {
                $row=mysql_fetch_array($result);
            
                $this->p_id=$row['ID'];
                $this->p_pwd=$row['PWD'];
                $this->p_lv=$row['LV'];
                $this->p_pos=$row['POS'];
                $this->p_tel=$row['TEL'];
                $this->p_email=$row['EMAIL'];
                $this->p_name=$row['NAME'];
                $this->p_face=$row['FACE'];
            }
            else
            {
                echo "�û���Ϣ��ȡʧ�ܣ�";
            }
        }
               
        public function get_id()
        {   
            return $this->p_id;
        }
        
        public function get_pwd()
        {   
            return $this->p_pwd;
        }
        
        
        public function get_lv()
        {   
            return $this->p_lv;
        }
        
        public function get_pos()
        {   
            return $this->p_pos;
        }
        
        public function get_tel()
        {   
            return $this->p_tel;
        }
        
        public function get_email()
        {   
            return $this->p_email;
        }
        
        public function get_name()
        {   
            return $this->p_name;
        }
        
        public function get_face()
        {   
            return $this->p_face;
        }
            
    }
    
?>