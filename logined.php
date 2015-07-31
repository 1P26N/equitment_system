<?php
session_start();
if ($_SESSION['user'])
{
	echo "<div align='right'>";
        echo "<FONT SIZE='' COLOR='black'>Login As </FONT><FONT SIZE='' COLOR='blue'>".$_SESSION['user'];
	echo "</FONT>";
	echo "&nbsp;&nbsp<U><A HREF='loginout.php' target='_parent'>登出</A></U>";
        echo "</div>";
	return 1;
}
else
{
	echo "<CENTER>请先登录</CENTER>";
	echo "<BR>";
	echo "<CENTER><A HREF='index.php' target='_parent'>点击这里重新登录</A></CENTER>";
	return 0;
}

?>