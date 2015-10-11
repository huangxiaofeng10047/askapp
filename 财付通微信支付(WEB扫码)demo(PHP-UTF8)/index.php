<?php
   require_once ("classes/RequestHandler.class.php");
   require_once ("tenpay_config.php");
	$curDateTime = date("YmdHis");
	//4位随机数
	$randNum = rand(1000, 9999);
	//10位序列号,可以自行调整。
	$strReq = $curDateTime . $randNum;
?>
<html>
<head>
<title>微信支付Demo(WEB扫码)</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<style type="text/css">
<!--
body,td,th {
	font-family: 宋体;
	font-size: 14px;
}
-->
</style>
<script language="javascript">
function payFrm()
{
	if (directFrm.order_no.value=="")
	{
		alert("提醒：请填写订单编号；如果无特定的订单编号，请采用默认编号！（刷新一下页面就可以了）");
		directFrm.order_no.focus();
		return false;
	}
	if (directFrm.product_name.value=="")
	{
		alert("提醒：请填写商品名称(付款项目)！");
		directFrm.product_name.focus();
		return false;
	}
	if (directFrm.order_price.value=="")
	{
		alert("提醒：请填写订单的交易金额！");
		directFrm.order_price.focus();
		return false;
	}
	if (directFrm.product_name.value.length>31)
	{
		alert("提醒：超出规定的字数,请重新输入");
		event.returnValue=false;   
		return   false;   
	}
	
	return true;
}
</script>
<body topmargin="0">
<div align="center">
	<form action="tenpay.php" method="post" name="directFrm" onsubmit="return payFrm();">
  <table width="760" height="406" border="0" align="center" cellpadding="0" cellspacing="0">
    <tbody><tr>
      <td align="center" valign="top">
    	<table width="760" border="0" cellspacing="0" cellpadding="3" align="center"><tbody>
    	<tr>
          <td height="30" width="5" bgcolor="#666666"></td>
          <td width="743" height="30" bgcolor="#FF6600"><font style="color:#FFFFFF;font-size:14px;"><b> 　微信支付Demo(WEB扫码)</b></font></td>
        </tr>
      	</tbody></table>
	    <table width="760" height="42" border="0" align="center" cellpadding="0" cellspacing="0">
	    	<tbody><tr>
			<td height="30"><span class="STYLE2"><img src="image/arrow_02_01.gif"> 填写订单信息</span></td>
	        </tr>
	    </tbody></table>
        
        <table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
            <tbody><tr>
              <td align="left"><table width="760" height="30" border="0" align="left" cellpadding="0" cellspacing="1" bgcolor="#FFCC00">
                  <tbody><tr>
                    <td align="center" valign="top" bgcolor="#FFFFEE"><table width="760" height="351" border="0" cellpadding="6" cellspacing="0" class="px14">
                        <tbody><tr>
                          <td height="26" align="right" valign="top">&nbsp;</td>
                          <td valign="top"> 　 </td>
                        </tr>
                        <tr>
                        <td width="102" height="26" align="right" valign="top">收款方：</td>
                        <td width="353" valign="top">测试账户 </td>
                        </tr> 
                      <tr>
                        <td align="right" valign="top">订单编号：</td>
                        <td valign="top">
			              <input type="text" name="order_no" maxlength="50" size="25" value="<?php echo $strReq ?>" font="" style="color:#000000;font-size:14px;"></td>
                      </tr>
                      <tr>
                        <td align="right" valign="top">付款金额：</td>
                        <td valign="top"><input type="text" name="order_price" maxlength="50" size="18" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')" font="" style="color:#000000;font-size:14px;" value="0.01"> 
                        元（格式：500.01）</td>
                      </tr>
                      <tr>
                        <td height="99" align="right" valign="top">简要说明：</td>
                        <td valign="top"><textarea name="product_name" cols="40" rows="5" id="remark2" font="" style="color:#000000;font-size:14px;">微信支付测试(WEB扫码)</textarea>
                          <br>
                          请填写您订单的简要说明（30字以内）</td></tr>
                      <tr>
                        <td align="right" valign="top">&nbsp;</td>
                        <td valign="top"><b>
                          <input name="submit" type="image" src="image/next.gif" alt="使用微信支付" width="103" height="27">
                        </b></td>
                        <td valign="top">&nbsp;</td>
                      </tr>
                    </tbody></table></td>
                  </tr>
              </tbody></table></td>
            </tr> 
        </tbody></table>
        </td>
    </tr>
  </tbody></table>
</div><hr width="760" size="1">
</form>
</body></html>