<?php
session_start();
if ($_SESSION['user'])
{
	echo "<div align='right'>";
        echo "<FONT SIZE='' COLOR='black'>Login As </FONT><FONT SIZE='' COLOR='blue'>".$_SESSION['user'];
	echo "</FONT>";
	echo "&nbsp;&nbsp<U><A HREF='loginout.php' target='_parent'>�ǳ�</A></U>";
        echo "</div>";
	return 1;
}
else
{
	echo "<CENTER>���ȵ�¼</CENTER>";
	echo "<BR>";
	echo "<CENTER><A HREF='index.php' target='_parent'>����������µ�¼</A></CENTER>";
	return 0;
}

?>