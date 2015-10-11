<?php
//---------------------------------------------------------
//微信扫码支付请求示例，商户按照此文档进行开发即可
//---------------------------------------------------------
require_once ("tenpay_config.php");
require_once ("classes/RequestHandler.class.php");

/* 获取提交的订单号 */
$out_trade_no = $_REQUEST["order_no"];
/* 获取提交的商品名称 */
$product_name = $_REQUEST["product_name"];
/* 获取提交的商品价格 */
$order_price = $_REQUEST["order_price"];

$strDate = date("Ymd");
$strTime = date("His");

/* 商品价格（包含运费），以分为单位 */
$total_fee = intval(100 * $order_price);

/* 创建支付请求对象 */
$reqHandler = new RequestHandler();
$reqHandler->init();
$reqHandler->setKey($key);
$reqHandler->setGateUrl("https://gw.tenpay.com/gateway/pay.htm");

//----------------------------------------
//设置支付参数 
//----------------------------------------
$reqHandler->setParameter("partner",	$partner);
$reqHandler->setParameter("out_trade_no",	$out_trade_no);
$reqHandler->setParameter("total_fee",	$total_fee);  //总金额
$reqHandler->setParameter("return_url", $return_url);
$reqHandler->setParameter("notify_url", $notify_url);
$reqHandler->setParameter("body",		$product_name);
$reqHandler->setParameter("bank_type", "WX");		//银行类型
//用户ip
$reqHandler->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);//客户端IP
$reqHandler->setParameter("fee_type", "1");               //币种

//系统可选参数
$reqHandler->setParameter("sign_type",		"MD5");			//签名方式，默认为MD5，可选RSA
$reqHandler->setParameter("service_version","1.0");			//接口版本号
$reqHandler->setParameter("input_charset",	"UTF-8");			//字符集UTF-8,GBK
$reqHandler->setParameter("sign_key_index",	"1");			//密钥序号

//业务可选参数
$reqHandler->setParameter("attach",		"");				//附件数据，原样返回就可以了
$reqHandler->setParameter("buyer_id",	"");                //买方财付通帐号
$reqHandler->setParameter("time_start", date("YmdHis"));	//订单生成时间
$reqHandler->setParameter("time_expire","");				//订单失效时间
$reqHandler->setParameter("transport_fee", "0");			//物流费用
$reqHandler->setParameter("product_fee", "");				//商品费用
$reqHandler->setParameter("goods_tag",	"");				//商品标记

//请求的URL
$reqUrl = $reqHandler->getRequestURL();

//获取debug信息,建议把请求和debug信息写入日志，方便定位问题
/**/
$debugInfo = $reqHandler->getDebugInfo();
echo "<br/>" . $reqUrl . "<br/>";
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>微信扫码支付程序演示</title>
</head>
<body>
<br/><a href="<?php echo $reqUrl ?>" target="_blank">微信扫码支付</a>
<form action="<?php echo $reqHandler->getGateUrl() ?>" method="post" target="_blank">
<?php
$params = $reqHandler->getAllParameters();
foreach($params as $k => $v) {
	echo "<input type=\"hidden\" name=\"{$k}\" value=\"{$v}\" />\n";
}
?>
<input type="submit" value="微信扫码支付">
</form>
<?php
echo "<br/>" . $reqUrl . "<br/>";
echo "<br/>" . $debugInfo . "<br/>";
?>
</body>
</html>
