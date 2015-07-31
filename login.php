<?php
    include_once "include\head.php";
    
    $user1=new user($_POST['user']);
    
    if($user1->get_pwd()==MD5($_POST['pwd']))
    {
        session_start();
        //获得ID、姓名、权限等级
        $_SESSION['id']=$user1->get_id(); 
        $_SESSION['user']=$user1->get_name();
        $_SESSION['lv']=$user1->get_lv();
        echo "<meta http-equiv=refresh content='0; url=main.php'>";
    }
    else
    {
        echo "<CENTER><FONT SIZE=' ' COLOR='red'>账号名或密码错误</FONT></CENTER>";
	echo ("<CENTER><A HREF='index.php'>点击这里重新登录</A></CENTER>");
    }
    
?>