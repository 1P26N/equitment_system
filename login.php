<?php
    include_once "include\head.php";
    
    $user1=new user($_POST['user']);
    
    if($user1->get_pwd()==MD5($_POST['pwd']))
    {
        session_start();
        //���ID��������Ȩ�޵ȼ�
        $_SESSION['id']=$user1->get_id(); 
        $_SESSION['user']=$user1->get_name();
        $_SESSION['lv']=$user1->get_lv();
        echo "<meta http-equiv=refresh content='0; url=main.php'>";
    }
    else
    {
        echo "<CENTER><FONT SIZE=' ' COLOR='red'>�˺������������</FONT></CENTER>";
	echo ("<CENTER><A HREF='index.php'>����������µ�¼</A></CENTER>");
    }
    
?>