<!doctype html>
<html>
<head>

<title>�豸����ϵͳ</title>

<style type="text/css">
body,td,th {
	font-size: 16px;
}
</style>
</head>

<body>

<p>
    
<?php
session_start();
if($_SESSION['nowpage']!=1)
{   //������ҳ  
      echo "<a href=../route.php?control=tools&action=display&page=1>��ҳ</a>&nbsp;";
      echo "<a href=../route.php?control=tools&action=display&page=".($_SESSION['nowpage']-1).">��һҳ</a>&nbsp;";    
}
       
if($_SESSION['nowpage']<$_SESSION['page_count'])
{   /*  ��ʾ����һҳ��������  */                            
      echo "<a href=../route.php?control=tools&action=display&page=".($_SESSION['nowpage']+1).">��һҳ</a>&nbsp;";
      echo "<a href=../route.php?control=tools&action=display&page=".$_SESSION['page_count'].">βҳ</a>";
}
?>

</p>

<p style='font-size:20px;font-weight:bold'><CENTER>����̨��</CENTER></p>

<p><table border='1px' width='1200px' cellspacing='0px' style='border-collapse:collapse'>
   <tr bgcolor=#b8b8b8> <th>ID</th> <th>�ʲ����</th> <th>�ͺ�</th> <th>���ʱ��</th> <th>����</th>
   <th>����ʱ��</th> <th>���ð���</th> <th>�궨Ť��</th> <th>״̬</th>

<?php
if($_SESSION['user']&&$_SESSION['lv']<2)
{
    echo "<th>���ã������</th> </tr>";
}

$i=0;

for($i=0;$i<20&&isset($_SESSION['date'][$i][0]);$i++) 
{
      if ($i%2==0)
      {
           $color="e8e8e8";
       }
      else
      {
           $color="ffffff";	 
       }
       
       $id=rawurldecode($_SESSION['date'][$i][0]);
               
       echo "<CENTER><tr bgcolor=#".$color.">";
       //echo "<td><CENTER><input type='checkbox' id='checkbox".$i."' value='".$i."'</CENTER></td>";
       echo "<td><CENTER>" . (($_SESSION['nowpage']-1)*20+$i+1). "</CENTER></td>";
       echo "<td><CENTER>" . $_SESSION['date'][$i][0] . "</CENTER></td>";
       echo "<td><CENTER>" . $_SESSION['date'][$i][1] . "</CENTER></td>";
       echo "<td><CENTER>" . $_SESSION['date'][$i][2] . "</CENTER></td>";
       echo "<td><CENTER>" . $_SESSION['date'][$i][3] . "</CENTER></td>";
       echo "<td><CENTER>" . $_SESSION['date'][$i][4] . "</CENTER></td>";
       echo "<td><CENTER>" . $_SESSION['date'][$i][5] . "</CENTER></td>";
       echo "<td><CENTER>" . $_SESSION['date'][$i][6] . "</CENTER></td>";
       echo "<td><CENTER>" . $_SESSION['date'][$i][7] . "</CENTER></td>";
       
       if($_SESSION['user']&&$_SESSION['lv']<2)
       {
            echo "<td><CENTER><a href=../route.php?control=tools&action=edit&id=".$id."><image src='../pic/edit.png'></a></td>";
       }
       echo "</tr></CENTER>";
}

echo "</table>";
?>

</body>
</html>
