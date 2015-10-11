<?php

//---------------------------------------------------------
//支付页面回调示例，商户按照此文档进行开发即可
//---------------------------------------------------------
require_once ("./classes/ResponseHandler.class.php");
require_once ("./classes/function.php");
require_once ("./tenpay_config.php");

log_result("进入前台回调页面");
/* 创建支付应答对象 */
$resHandler = new ResponseHandler();
$resHandler->setKey($key);

//判断签名
if($resHandler->isTenpaySign()) {
	
	//通知id
	$notify_id = $resHandler->getParameter("notify_id");
	//商户订单号
	$out_trade_no = $resHandler->getParameter("out_trade_no");
	//财付通订单号
	$transaction_id = $resHandler->getParameter("transaction_id");
	//金额,以分为单位
	$total_fee = $resHandler->getParameter("total_fee");
	//如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
	$discount = $resHandler->getParameter("discount");
	//支付结果
	$trade_state = $resHandler->getParameter("trade_state");

	if( "0" == $trade_state){ 
		echo "<br/>" . "支付成功" . "<br/>";
	} else {
		//当做不成功处理
		echo "<br/>" . "支付失败" . "<br/>";
	}
} else {
	echo "<br/>" . "认证签名失败" . "<br/>";
	echo $resHandler->getDebugInfo() . "<br>";
}

?>