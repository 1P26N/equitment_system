<?php

class database
{
    private $p_connection;
    
    public function query_database($host,$user,$pwd,$db,$sql)
    {
        $this->p_connection=mysql_connect($host,$user,$pwd) or exit("�޷��������ݿ� - ".mysql_error());
        mysql_select_db($db, $this->p_connection) or exit("�޷������ݿ� - ".mysql_error());
        mysql_query("SET NAMES 'gbk'");
        $result=mysql_query($sql);
        mysql_close($this->p_connection);
        return $result;
    }
    
    public function search_database($db,$sql)
    {
        $this->p_connection=  mysql_connect($GLOBALS["USER_DATABASE_HOST"],$GLOBALS["USER_DATABASE_USER"],
                $GLOBALS["USER_DATABASE_PWD"]) or exit("�޷��������ݿ� - ".mysql_error());
        
        mysql_select_db($db,$this->p_connection) or exit("�޷��������ݿ� - ".mysql_error());
        mysql_query("SET NAMES 'gbk'");
        $result=mysql_query($sql);
        mysql_close($this->p_connection);
        return $result; 
    }
    
}

?>