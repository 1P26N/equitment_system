<html>
<head>

</head>

<body>
<?php

/*
 * ���ܣ����߿����ͼ
 * �汾��0.1
 * ���ߣ�������ȥ
 * ʱ�䣺2015.6.24
 */

include "../include/head.php";
session_start();

echo "<p>";

if($_SESSION['nowpage']!=1)
{   //������ҳ  
      echo "<a href=../route.php?control=tools_stock&action=display&page=1>��ҳ</a>&nbsp;";
      echo "<a href=../route.php?control=tools_stock&action=display&page=".($_SESSION['nowpage']-1).">��һҳ</a>&nbsp;";    
}
       
if($_SESSION['nowpage']<$_SESSION['page_count'])
{   /*  ��ʾ����һҳ��������  */                            
      echo "<a href=../route.php?control=tools_stock&action=display&page=".($_SESSION['nowpage']+1).">��һҳ</a>&nbsp;";
      echo "<a href=../route.php?control=tools_stock&action=display&page=".$_SESSION['page_count'].">βҳ</a>";
}

echo "</p>";

echo "<p style='font-size:20px;font-weight:bold'><CENTER>���߿��</CENTER></p>";

echo "<div id='main'><p><table border='1px' width='1200px' hight='700' cellspacing='0px' style='border-collapse:collapse'>
     <tr bgcolor=#b8b8b8> <th>ID</th> <th>�ͺ�</th> <th>Ʒ��</th> <th>����</th> <th>����</th> <th>�������</th> <th>��ȫ���</th>
     <th>�ɹ�����</th> <th>Ť������</th> <th>Ť������</th> ";

if($_SESSION['lv']<2)
{
    echo "<th>����</th> <th>���</th> <th>����</th> <th>����</th> <th>�༭</th></tr>";
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
               
       echo "<CENTER><tr bgcolor=#".$color.">";

       echo "<td><CENTER>" . (($_SESSION['nowpage']-1)*20+$i+1) . "</CENTER></td>";
       echo "<td><CENTER>" . $_SESSION['date'][$i][1] . "</CENTER></td>";
       echo "<td><CENTER>" . $_SESSION['date'][$i][2] . "</CENTER></td>";
       echo "<td><CENTER>" . $_SESSION['date'][$i][3] . "</CENTER></td>";
       echo "<td><CENTER>" . $_SESSION['date'][$i][4] . "</CENTER></td>";
       
       //���������ܰ�ȫ������򽫸�����ʾΪ��ɫ��
       if($_SESSION['date'][$i][5]>$_SESSION['date'][$i][6])
       {
           echo "<td><CENTER>" . $_SESSION['date'][$i][5] . "</CENTER></td>";
       }
       else 
       {
           echo "<td BGCOLOR='red'><CENTER>" . $_SESSION['date'][$i][5] . "</FONT></CENTER></td>";
       }
       echo "<td><CENTER>" . $_SESSION['date'][$i][6] . "</CENTER></td>";
       echo "<td><CENTER>" . $_SESSION['date'][$i][7] . "</CENTER></td>";
       echo "<td><CENTER>" . $_SESSION['date'][$i][8] . "</CENTER></td>";
       echo "<td><CENTER>" . $_SESSION['date'][$i][9] . "</CENTER></td>";
       
       if($_SESSION['lv']<2)
       {
           $id=rawurlencode($_SESSION['date'][$i][1]);
           echo "<td><CENTER>" . $_SESSION['date'][$i][10] . "</CENTER></td>"; 
           echo "<td><CENTER><a href=../route.php?control=tools_event&action=in&id=".$id."><image src='../pic/search.png'></a></td>";
           echo "<td><CENTER><a href=../route.php?control=tools_event&action=out&id=".$id."><image src='../pic/search.png'></a></td>";
           echo "<td><CENTER><a href=../route.php?control=tools_spare&action=spare&id=".$id."><image src='../pic/search.png'></a></td>";
           echo "<td><CENTER><a href=../route.php?control=tools_stock&action=edit&id=".$id."><image src='../pic/edit.png'></a></td>";
       }
       
       echo "</tr></CENTER>";
       
}

echo "</table>";

?>
</div>
</body>
