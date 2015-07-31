<?php
	session_start();
	$_SESSION['user']=NULL;                  //清空标志位
	echo "<meta http-equiv=refresh content='0; url=index.php'>";    //返回登录页
?>