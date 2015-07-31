<?php
    include_once "../include/head.php";
    session_start();
    
    if($_SESSION['id']&&$_SESSION['lv']<2)
    {
        echo "

         <form name='form1' method='post' action='../controller/c_tools_stock.php?action=save&id=".$_SESSION['date'][0]."'>

         <p><table border='1px' width='' cellspacing='0px' style='border-collapse:collapse'>
         <tr bgcolor=#e8e8e8>
         <th>编号</th><th>".$_SESSION['date'][0]."</th>
         </tr>

         <tr bgcolor=#ffffff>
         <th>型号</th><th><input type='text' name='MODEL' id='MODEL' value='".$_SESSION['date'][1]."'></th>
         </tr>";
                
        echo "

         <tr bgcolor=#e8e8e8>
         <th>品牌</th><th><input type='text' list='brand_list' name='BRAND' id='BRAND' value='".$_SESSION['date'][2]."'></th>
         </tr>";
        
        //html5支持的list属性，使输入框获得list效果，品牌选择list
        echo "
          <datalist id='brand_list'>";
        
        foreach($GLOBALS["TOOLS_BRAND"] as $brand)
        {
            echo "<option value='".$brand."'/>";
        }
        
        echo "</datalist>";
        
        //类型选择list
        echo "
         <tr bgcolor=#ffffff>
         <th>类型</th><th><input type='text' list='type_list' name='TYPE' id='TYPE' value='".$_SESSION['date'][3]."'></th>
         </tr>";
        
        echo "
          <datalist id='type_list'>";
        
        foreach($GLOBALS["TOOLS_TYPE"] as $type)
        {
            echo "<option value='".$type."'/>";
        }
        
        echo "</datalist>";
        
        echo " 
         <tr bgcolor=#e8e8e8>
         <th>精度</th><th><input type='text' name='ACCURACY' id='ACCURACY' value='".$_SESSION['date'][4]."'></th>
         </tr>

         <tr bgcolor=#ffffff>
         <th>安全库存</th><th><input type='text' pattern='^[0-9]*$' title='只允许输入数字' name='QTY_MIN' id='QTY_MIN' value='".$_SESSION['date'][6]."'></th>
         </tr>

         <tr bgcolor=#e8e8e8>
         <th>采购周期</th><th><input type='text' pattern='^[0-9]*$' title='只允许输入数字' name='CYCLE' id='CYCLE' value='".$_SESSION['date'][7]."'></th>
         </tr>

         <tr bgcolor=#ffffff>
         <th>扭力下限</th><th><input type='text' pattern='^[0-9]*$' title='只允许输入数字' name='TORQUE_MIN' id='TORQUE_MIN' value='".$_SESSION['date'][8]."'></th>
         </tr>
         
         <tr bgcolor=#e8e8e8>
         <th>扭力上限</th><th><input type='text' pattern='^[0-9]*$' title='只允许输入数字' name='TORQUE_MAX' id='TORQUE_MAX' value='".$_SESSION['date'][9]."'></th>
         </tr>
         
         <tr bgcolor=#ffffff>
         <th>单价</th><th><input type='text' pattern='^[0-9]*$' title='只允许输入数字' name='PRICE' id='PRICE' value='".$_SESSION['date'][10]."'></th>
         </tr></table>

         <p><input type='submit' name='enter' id='enter' value='保存'></p>
        ";
    }
      
?>
