<!doctype html>
<html>
<head>

<title>设备管理系统</title>

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
{   //不是首页  
      echo "<a href=../route.php?control=tools&action=display&page=1>首页</a>&nbsp;";
      echo "<a href=../route.php?control=tools&action=display&page=".($_SESSION['nowpage']-1).">上一页</a>&nbsp;";    
}
       
if($_SESSION['nowpage']<$_SESSION['page_count'])
{   /*  显示“下一页”超链接  */                            
      echo "<a href=../route.php?control=tools&action=display&page=".($_SESSION['nowpage']+1).">下一页</a>&nbsp;";
      echo "<a href=../route.php?control=tools&action=display&page=".$_SESSION['page_count'].">尾页</a>";
}
?>

</p>

<p style='font-size:20px;font-weight:bold'><CENTER>工具台账</CENTER></p>

<p><table border='1px' width='1200px' cellspacing='0px' style='border-collapse:collapse'>
   <tr bgcolor=#b8b8b8> <th>ID</th> <th>资产编号</th> <th>型号</th> <th>入库时间</th> <th>单价</th>
   <th>领用时间</th> <th>领用班组</th> <th>标定扭力</th> <th>状态</th>

<?php
if($_SESSION['user']&&$_SESSION['lv']<2)
{
    echo "<th>领用（变更）</th> </tr>";
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
