<?php
session_start();

echo "<p>";

if($_SESSION['nowpage']!=1)
{   //������ҳ  
      echo "<a href=../route.php?control=event&action=display&page=1>��ҳ</a>&nbsp;";
      echo "<a href=../route.php?control=event&action=display&page=".($_SESSION['nowpage']-1).">��һҳ</a>&nbsp;";    
}
       
if($_SESSION['nowpage']<$_SESSION['page_count'])
{   /*  ��ʾ����һҳ��������  */                            
      echo "<a href=../route.php?control=event&action=display&page=".($_SESSION['nowpage']+1).">��һҳ</a>&nbsp;";
      echo "<a href=../route.php?control=event&action=display&page=".$_SESSION['page_count'].">βҳ</a>";
}

echo "</p>";

echo "<p style='font-size:20px;font-weight:bold'><CENTER>�¼���¼�鿴</CENTER></p>";

echo "<div id='main'><p><table border='1px' width='1200px' hight='700' cellspacing='0px' style='border-collapse:collapse;font-size:10px'>
     <tr bgcolor=#b8b8b8> <th>ID</th> <th>�ʲ����</th> <th>�ͺ�</th> <th>�¼�����</th> <th>�¼���Ϣ</th> <th>������</th> <th>¼��ʱ��</th>
     <th>ϵͳʱ��</th>";

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
               
       echo "<CENTER><tr bgcolor=#".$color.">";

       echo "<td><CENTER>" . (($_SESSION['nowpage']-1)*20+$i+1) . "</CENTER></td>";
       echo "<td><CENTER>" . $_SESSION['date'][$i][1] . "</CENTER></td>";
       echo "<td><CENTER>" . $_SESSION['date'][$i][2] . "</CENTER></td>";
       echo "<td><CENTER>" . $_SESSION['date'][$i][3] . "</CENTER></td>";
       echo "<td>" . $_SESSION['date'][$i][4] . "</td>";
       echo "<td><CENTER>" . $_SESSION['date'][$i][5] . "</CENTER></td>";
       echo "<td><CENTER>" . $_SESSION['date'][$i][6] . "</CENTER></td>";
       echo "<td><CENTER>" . $_SESSION['date'][$i][7] . "</CENTER></td>";
       
       echo "</tr></CENTER>";
}

echo "</table></p>";
?>
