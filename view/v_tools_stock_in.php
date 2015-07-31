<script src="js/jquery.min.js"></script>
<script language="javascript" src="/js/WdatePicker.js"></script>

<script language="javascript" type="text/javascript">

function insert()
{
    var input_brand=document.getElementsByName("BRAND")[0].value;
    var input_model=document.getElementsByName("MODEL")[0].value;
    var input_number=document.getElementsByName("NUMBER")[0].value;
    var input_price=document.getElementsByName("PRICE")[0].value;
    var input_date=document.getElementsByName("DATE")[0].value;
       
    if(input_brand==null)
    {
        alert("品牌不能为空！");
    }
    else if(input_model==null)
    {
        alert("型号不能为空！");
    }
    else if(input_number==null)
    {
        alert("编号不能为空！");
    }
    else if(input_price==null)
    {
        alert("单价不能为空！");    
    }
    else if(isNaN(input_price))
    {
        alert("单价必须是数字！");    
    }
    else if(input_date==null)
    {
        alert("日期不能为空！");
    }
    else
    {
        window.location.href="../controller/c_tools_stock.php?action=insert&brand="+input_brand+
                             "&model="+input_model+
                             "&number="+input_number+
                             "&price="+input_price+
                             "&date="+input_date;
    }
}

</script>

    
<?php
    include_once "../include/head.php";
    session_start();
    
    if($_SESSION['id']&&$_SESSION['lv']<2)
    {
        echo "<p>工具入库</p>";
        
        echo "

         <p><table border='1px' width='' cellspacing='0px' style='border-collapse:collapse'>";
         
        echo '

         <tr bgcolor=#ffffff>
         <th>品牌</th><th><input type="text" list="brand_list" name="BRAND" id="BRAND" value="" width="200px" height="16px"></th>
         </tr>';
        
        //html5支持的list属性，使输入框获得list效果，品牌选择list
        echo "<datalist id='brand_list'>";
        
        foreach($GLOBALS["TOOLS_BRAND"] as $brand)
        {
            echo "<option value='".$brand."'/>";
        }
        echo "</datalist>";
        
        echo "
         <tr bgcolor=#e8e8e8>
         <th>型号</th><th><input type='text' list='model_list' name='MODEL' id='MODEL' value='' width='200px' height='16px'></th>
         </tr>";  
        
        echo "<datalist id='model_list'>";
        
        foreach($_SESSION["model_list"] as $model)
        {
            echo "<option value='".$model."'/>";
        }
        echo "</datalist>";

        
        echo "
         <tr bgcolor=#e8e8e8>
         <th>编号</th><th><input type='text' name='NUMBER' id='NUMBER' value='' width='200px' height='16px'></th>
         </tr>

         <tr bgcolor=#ffffff>
         <th>单价</th><th><input type='text' pattern='^[0-9]*$' title='只允许输入数字' name='PRICE' id='PRICE' value='' width='200px' height='16px'></th>
         </tr>";
        
        $timestr="({dateFmt:'yyyy/MM/dd'});";
        echo '
         <tr bgcolor=#e8e8e8>
         <th>日期</th><th><input id="DATE" name="DATE" value="" width="200px" height="16px" readonly class="Wdate" type="text" onclick="WdatePicker'.$timestr.'"></th>
         </tr>';
                
        echo '
         </table>
         <p><input type="submit" name="enter" id="enter" value="确认入库" onclick="insert()"></p>
        ';
    }
?>
