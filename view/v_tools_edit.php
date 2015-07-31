<script src="js/jquery.min.js"></script>
<script language="javascript" src="/js/WdatePicker.js"></script>

<script language="javascript" type="text/javascript">

function update()
{
    var input_number=document.getElementsByName("NUMBER")[0].value;
    var input_group=document.getElementsByName("GROUP")[0].value;
    var input_torque=document.getElementsByName("TORQUE")[0].value;
    var input_state=document.getElementsByName("STATE")[0].value;
    var input_date=document.getElementsByName("DATE")[0].value;
    
    var empty_torque=false;
    var state_error=false;
    
    if((input_torque=="")&&(input_group!=="仓库"))
    {
        if(input_group!="保全")
        {
                empty_torque=true;
        }
    }
    
    if(input_group!="保全" && input_group!="仓库")
    {
        if(input_state!="领用" && input_state!="待修")
        {
            state_error=true;
        }
    }
    
    if(empty_torque==true)
    {
        alert("扭力不能为空！");    
    }
    else if(input_group=="")
    {
        alert("班组不能为空！");
    }  
    else if(isNaN(input_torque)&&!empty_torque)
    {
        alert("扭力必须为数字！");
    }
    //保全只能对应备用状态，其他班组对应领用和维修。
    else if(state_error==true)
    {
        alert("状态错误！");
    }
    else if(input_date=="")
    {
        alert("日期不能为空！");
    }
    else
    {
        window.location.href="../controller/c_tools.php?action=save&number="+input_number+
                             "&group="+input_group+
                             "&torque="+input_torque+
                             "&state="+input_state+
                             "&date="+input_date;
    }
}

</script>

<?php
    include_once "../include/head.php";
    session_start();

    echo "
        
     <p><table border='1px' width='' cellspacing='0px' style='border-collapse:collapse'>
     <tr bgcolor=#e8e8e8>
     <th>资产编号</th><th><input id='NUMBER' name='NUMBER' value='".$_SESSION['date'][0]."' style='width:200px;' readonly></th>
     </tr>
     
     <tr bgcolor=#ffffff>
     <th>型号</th><th>".$_SESSION['date'][1]."</th>
     </tr>
     
     <tr bgcolor=#e8e8e8>
     <th>班组</th><th>
     <select style='width:200px;' name='GROUP' id='GROUP'>";
    
     $select=0;
     foreach($GLOBALS["TOOLS_GROUP"] as $group)
     {
         echo "<option value='".$group."'";
         
         if($_SESSION['date'][2]==$group)
         {
             echo " selected='selected'>".$group."</option>";
             $select=1;
         }
         else if($group=="仓库"&&$select==0)
         {
             echo " selected='selected'>".$group."</option>";
         }
         else
         {
             echo ">".$group."</option>";
         }
     
     }        
     echo "</select></th></tr>";
     
     echo "  
     <tr bgcolor=#ffffff>
     <th>扭力</th><th><input pattern='^[0-9]*$' title='只允许输入数字' style='width:200px;' type='text' name='TORQUE' id='TORQUE' value='".$_SESSION['date'][3]."'></th>
     </tr>

     <tr bgcolor=#e8e8e8>
     <th>状态</th><th>
     <select style='width:200px;' name='STATE' id='STATE'>";
     
     foreach($GLOBALS["TOOLS_STATE"] as $state)
     {
         echo "<option value='".$state."'";
         
         if($_SESSION['date'][4]==$state)
         {
             echo " selected='selected'>".$state."</option>";
         }
         else
         {
             echo ">".$state."</option>";
         }
     }
     
     echo "</select></th></tr>";
     
     $timestr="({dateFmt:'yyyy/MM/dd'});";
     echo '
     <tr bgcolor=#ffffff>
     <th>日期</th><th><input id="DATE" name="DATE" value="" style="width:200px;" readonly class="Wdate" type="text" onclick="WdatePicker'.$timestr.'"></th>
     </tr>';
     
     echo "</table>";
     
     echo '<p><input type="submit" name="enter" id="enter" value="保存" onclick="update()"></p>';
    
    
?>
