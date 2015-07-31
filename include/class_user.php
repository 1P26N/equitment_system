<?php
    include "env_var.php";
    include "class_database.php";
    
    class user
    {
        private $p_id;  //账号
        private $p_pwd; //密码
        private $p_lv;  //权限
        private $p_pos; //职位
        private $p_tel; //电话
        private $p_email; //邮箱
        private $p_name; //姓名
        private $p_face; //头像
        
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
                echo "用户信息读取失败！";
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