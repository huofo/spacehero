<?php
header("Content-Type: text/html;charset=utf-8");
include 'base.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){ 
	
	$payKey = "6823fcfe11517bc*****b8e4c4dc9be9";//支付Key(PayKey)
	
	$data = $_POST["data"];

	$array = xmlToArray($data);
	
	$signVal = make_sign($array,$payKey);
	
	if($signVal==$array["Sign"]){
		//签名正确，执行业务逻辑，注意重复回调处理
		
		echo "<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[处理成功]]></return_msg></xml>";
	}
	else{
		echo "<xml><return_code><![CDATA[FAIL]]></return_code><return_msg><![CDATA[处理失败]]></return_msg></xml>";
	}
}

?>