<?php
    include_once "../include/head.php";
    session_start();
    
    if($_SESSION['id']&&$_SESSION['lv']<2)
    {
        echo "

         <form name='form1' method='post' action='../controller/c_tools_stock.php?action=save&id=".$_SESSION['date'][0]."'>

         <p><table border='1px' width='' cellspacing='0px' style='border-collapse:collapse'>
         <tr bgcolor=#e8e8e8>
         <th>���</th><th>".$_SESSION['date'][0]."</th>
         </tr>

         <tr bgcolor=#ffffff>
         <th>�ͺ�</th><th><input type='text' name='MODEL' id='MODEL' value='".$_SESSION['date'][1]."'></th>
         </tr>";
                
        echo "

         <tr bgcolor=#e8e8e8>
         <th>Ʒ��</th><th><input type='text' list='brand_list' name='BRAND' id='BRAND' value='".$_SESSION['date'][2]."'></th>
         </tr>";
        
        //html5֧�ֵ�list���ԣ�ʹ�������listЧ����Ʒ��ѡ��list
        echo "
          <datalist id='brand_list'>";
        
        foreach($GLOBALS["TOOLS_BRAND"] as $brand)
        {
            echo "<option value='".$brand."'/>";
        }
        
        echo "</datalist>";
        
        //����ѡ��list
        echo "
         <tr bgcolor=#ffffff>
         <th>����</th><th><input type='text' list='type_list' name='TYPE' id='TYPE' value='".$_SESSION['date'][3]."'></th>
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
         <th>����</th><th><input type='text' name='ACCURACY' id='ACCURACY' value='".$_SESSION['date'][4]."'></th>
         </tr>

         <tr bgcolor=#ffffff>
         <th>��ȫ���</th><th><input type='text' pattern='^[0-9]*$' title='ֻ������������' name='QTY_MIN' id='QTY_MIN' value='".$_SESSION['date'][6]."'></th>
         </tr>

         <tr bgcolor=#e8e8e8>
         <th>�ɹ�����</th><th><input type='text' pattern='^[0-9]*$' title='ֻ������������' name='CYCLE' id='CYCLE' value='".$_SESSION['date'][7]."'></th>
         </tr>

         <tr bgcolor=#ffffff>
         <th>Ť������</th><th><input type='text' pattern='^[0-9]*$' title='ֻ������������' name='TORQUE_MIN' id='TORQUE_MIN' value='".$_SESSION['date'][8]."'></th>
         </tr>
         
         <tr bgcolor=#e8e8e8>
         <th>Ť������</th><th><input type='text' pattern='^[0-9]*$' title='ֻ������������' name='TORQUE_MAX' id='TORQUE_MAX' value='".$_SESSION['date'][9]."'></th>
         </tr>
         
         <tr bgcolor=#ffffff>
         <th>����</th><th><input type='text' pattern='^[0-9]*$' title='ֻ������������' name='PRICE' id='PRICE' value='".$_SESSION['date'][10]."'></th>
         </tr></table>

         <p><input type='submit' name='enter' id='enter' value='����'></p>
        ";
    }
      
?>
