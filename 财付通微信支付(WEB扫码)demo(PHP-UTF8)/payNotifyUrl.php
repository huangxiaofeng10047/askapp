<?php

//---------------------------------------------------------
//支付后台回调示例，商户按照此文档进行开发即可
//---------------------------------------------------------

require ("classes/ResponseHandler.class.php");
require ("classes/RequestHandler.class.php");
require ("classes/client/TenpayHttpClient.class.php");
require ("./classes/function.php");
require_once ("./tenpay_config.php");

log_result("进入后台回调页面");

/* 创建支付应答对象 */
$resHandler = new ResponseHandler();
$resHandler->setKey($key);

//判断签名
if($resHandler->isTenpaySign()) {

	//通知id
	$notify_id = $resHandler->getParameter("notify_id");

	//通过通知ID查询，确保通知来至财付通
	//创建查询请求
	$queryReq = new RequestHandler();
	$queryReq->init();
	$queryReq->setKey($key);
	$queryReq->setGateUrl("https://gw.tenpay.com/gateway/simpleverifynotifyid.xml");
	$queryReq->setParameter("partner", $partner);
	$queryReq->setParameter("notify_id", $notify_id);

	//通信对象
	$httpClient = new TenpayHttpClient();
	$httpClient->setTimeOut(5);
	//设置请求内容
	$httpClient->setReqContent($queryReq->getRequestURL());
	//后台调用
	if($httpClient->call()) {
	//设置结果参数
		$queryRes = new ResponseHandler();
		$queryRes->setContent($httpClient->getResContent());
		$queryRes->setKey($key);
		//判断签名及结果
		//只有签名正确,retcode为0，trade_state为0才是支付成功
		if($queryRes->getParameter("retcode") == "0" && $queryRes->isTenpaySign()){
			log_result("验签ID成功");
			if($resHandler->getParameter("trade_state") == "0") {
				
				//取结果参数做业务处理
				$out_trade_no = $resHandler->getParameter("out_trade_no");
				//财付通订单号
				$transaction_id = $resHandler->getParameter("transaction_id");
				//金额,以分为单位
				$total_fee = $resHandler->getParameter("total_fee");
				//如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
				$discount = $resHandler->getParameter("discount");
				//------------------------------
				//处理业务开始
				//------------------------------
				
				//处理数据库逻辑
				//注意交易单不要重复处理
				//注意判断返回金额
				
				//------------------------------
				//处理业务完毕
				//------------------------------
			}
			log_result("后台回调成功");
			echo "success";
		} else {
			//错误时，返回结果可能没有签名，写日志trade_state、retcode、retmsg看失败详情。
			log_result("后台回调失败");
			echo "fail";
			echo $queryRes->getParameter("retmsg");
		}
		//获取查询的debug信息,建议把请求、应答内容、debug信息，通信返回码写入日志，方便定位问题
		/*
		echo "<br>------------------------------------------------------<br>";
		echo "http res:" . $httpClient->getResponseCode() . "," . $httpClient->getErrInfo() . "<br>";
		echo "query req:" . htmlentities($queryReq->getRequestURL(), ENT_NOQUOTES, "GB2312") . "<br><br>";
		echo "query res:" . htmlentities($queryRes->getContent(), ENT_NOQUOTES, "GB2312") . "<br><br>";
		echo "query reqdebug:" . $queryReq->getDebugInfo() . "<br><br>" ;
		echo "query resdebug:" . $queryRes->getDebugInfo() . "<br><br>";
		*/
	}else{
		//通信失败
		echo "fail";
		//后台调用通信失败,写日志，方便定位问题
		echo "<br>call err:" . $httpClient->getResponseCode() ."," . $httpClient->getErrInfo() . "<br>";
	 } 
}else{
	echo "<br/>" . "认证签名失败" . "<br/>";
	echo $resHandler->getDebugInfo() . "<br>";
}
?>