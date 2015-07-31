<html>
<head>

</head>

<body>
<?php

/*
 * 功能：工具库存视图
 * 版本：0.1
 * 作者：谜来谜去
 * 时间：2015.6.24
 */

include "../include/head.php";
session_start();

echo "<p>";

if($_SESSION['nowpage']!=1)
{   //不是首页  
      echo "<a href=../route.php?control=tools_stock&action=display&page=1>首页</a>&nbsp;";
      echo "<a href=../route.php?control=tools_stock&action=display&page=".($_SESSION['nowpage']-1).">上一页</a>&nbsp;";    
}
       
if($_SESSION['nowpage']<$_SESSION['page_count'])
{   /*  显示“下一页”超链接  */                            
      echo "<a href=../route.php?control=tools_stock&action=display&page=".($_SESSION['nowpage']+1).">下一页</a>&nbsp;";
      echo "<a href=../route.php?control=tools_stock&action=display&page=".$_SESSION['page_count'].">尾页</a>";
}

echo "</p>";

echo "<p style='font-size:20px;font-weight:bold'><CENTER>工具库存</CENTER></p>";

echo "<div id='main'><p><table border='1px' width='1200px' hight='700' cellspacing='0px' style='border-collapse:collapse'>
     <tr bgcolor=#b8b8b8> <th>ID</th> <th>型号</th> <th>品牌</th> <th>类型</th> <th>精度</th> <th>库存数量</th> <th>安全库存</th>
     <th>采购周期</th> <th>扭力下限</th> <th>扭力上限</th> ";

if($_SESSION['lv']<2)
{
    echo "<th>单价</th> <th>入库</th> <th>领用</th> <th>备件</th> <th>编辑</th></tr>";
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
       
       //如果库存数≤安全库存数则将格子显示为红色。
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
