<?php
session_start();

echo "<p>";

if($_SESSION['nowpage']!=1)
{   //不是首页  
      echo "<a href=../route.php?control=event&action=display&page=1>首页</a>&nbsp;";
      echo "<a href=../route.php?control=event&action=display&page=".($_SESSION['nowpage']-1).">上一页</a>&nbsp;";    
}
       
if($_SESSION['nowpage']<$_SESSION['page_count'])
{   /*  显示“下一页”超链接  */                            
      echo "<a href=../route.php?control=event&action=display&page=".($_SESSION['nowpage']+1).">下一页</a>&nbsp;";
      echo "<a href=../route.php?control=event&action=display&page=".$_SESSION['page_count'].">尾页</a>";
}

echo "</p>";

echo "<p style='font-size:20px;font-weight:bold'><CENTER>事件记录查看</CENTER></p>";

echo "<div id='main'><p><table border='1px' width='1200px' hight='700' cellspacing='0px' style='border-collapse:collapse;font-size:10px'>
     <tr bgcolor=#b8b8b8> <th>ID</th> <th>资产编号</th> <th>型号</th> <th>事件类型</th> <th>事件信息</th> <th>操作者</th> <th>录入时间</th>
     <th>系统时间</th>";

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
