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
        alert("Ʒ�Ʋ���Ϊ�գ�");
    }
    else if(input_model==null)
    {
        alert("�ͺŲ���Ϊ�գ�");
    }
    else if(input_number==null)
    {
        alert("��Ų���Ϊ�գ�");
    }
    else if(input_price==null)
    {
        alert("���۲���Ϊ�գ�");    
    }
    else if(isNaN(input_price))
    {
        alert("���۱��������֣�");    
    }
    else if(input_date==null)
    {
        alert("���ڲ���Ϊ�գ�");
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
        echo "<p>�������</p>";
        
        echo "

         <p><table border='1px' width='' cellspacing='0px' style='border-collapse:collapse'>";
         
        echo '

         <tr bgcolor=#ffffff>
         <th>Ʒ��</th><th><input type="text" list="brand_list" name="BRAND" id="BRAND" value="" width="200px" height="16px"></th>
         </tr>';
        
        //html5֧�ֵ�list���ԣ�ʹ�������listЧ����Ʒ��ѡ��list
        echo "<datalist id='brand_list'>";
        
        foreach($GLOBALS["TOOLS_BRAND"] as $brand)
        {
            echo "<option value='".$brand."'/>";
        }
        echo "</datalist>";
        
        echo "
         <tr bgcolor=#e8e8e8>
         <th>�ͺ�</th><th><input type='text' list='model_list' name='MODEL' id='MODEL' value='' width='200px' height='16px'></th>
         </tr>";  
        
        echo "<datalist id='model_list'>";
        
        foreach($_SESSION["model_list"] as $model)
        {
            echo "<option value='".$model."'/>";
        }
        echo "</datalist>";

        
        echo "
         <tr bgcolor=#e8e8e8>
         <th>���</th><th><input type='text' name='NUMBER' id='NUMBER' value='' width='200px' height='16px'></th>
         </tr>

         <tr bgcolor=#ffffff>
         <th>����</th><th><input type='text' pattern='^[0-9]*$' title='ֻ������������' name='PRICE' id='PRICE' value='' width='200px' height='16px'></th>
         </tr>";
        
        $timestr="({dateFmt:'yyyy/MM/dd'});";
        echo '
         <tr bgcolor=#e8e8e8>
         <th>����</th><th><input id="DATE" name="DATE" value="" width="200px" height="16px" readonly class="Wdate" type="text" onclick="WdatePicker'.$timestr.'"></th>
         </tr>';
                
        echo '
         </table>
         <p><input type="submit" name="enter" id="enter" value="ȷ�����" onclick="insert()"></p>
        ';
    }
?>
