<?php
/**
 * ------------------------------公共方法--------------------------------
 * 
 * ----------------------------------------------------------------------
 */
 
 
/**
 * 生成签名
 * $signdata 签名数据 array
 * $api_key 商户秘钥
 * @return 返回md5签名
 */
function make_sign($signdata,$api_key)
{
	//签名步骤一：按字典序排序参数
	ksort($signdata);
	$string = to_signParams($signdata);
	//签名步骤二：在string后加入KEY
	$string = $string . "&key=".$api_key;
	//$file = "make_sign1";
	//$path ="/data/wwwroot/";
	//$content = $string;
	//F($file,$content,$path);
	//签名步骤三：MD5加密
	$string = md5($string);
	//签名步骤四：所有字符转为大写
	$result = strtoupper($string);
	return $result;
}

function toXml($signdata){
	$buff = "<xml>";
	
	foreach ($signdata as $k => $v)
	{
		$buff .="<" . $k . "><![CDATA[" . $v . "]]></" . $k . ">";
	}

	$buff .= "</xml>";
	return $buff;
}

function xmlToArray($data){
	libxml_disable_entity_loader(true);
	$array = json_decode(json_encode(simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    return $array;
}

/**
 * 格式化参数格式化成url参数
 */
function to_signParams($signdata)
{
	$buff = "";
	foreach ($signdata as $k => $v)
	{
		if($k != "Sign"){
			$buff .= $k . "=" . $v . "&";
		}
	}

	$buff = trim($buff, "&");
	return $buff;
}

/**
 * 格式化参数格式化成url参数
 */
function to_params($signdata)
{
	$buff = "";
	foreach ($signdata as $k => $v)
	{
		$buff .= $k . "=" . $v . "&";
	}

	$buff = trim($buff, "&");
	return $buff;
}	

/**
 * 生成随机字符串，订单号
 * @return 字符串
 */
function order_sn() 
{
	return time();
}

/**
 * 返回json
 * $message 提示文字 
 * $data 返回数据 array
 * $code 返回代码  
 * @return json字符串
 */
function json_return($message = '',$data = '',$code = 0) 
{
	$return['msg']  = $message;
	$return['data'] = $data;
	$return['code'] = $code;
	return json_encode($return);
}	

/**
 * 写文件
 * $name 文件名 
 * $content 写入内容
 * $name 文件路径 
 */
function F($name,$data='',$dir = ''){
 	$exc = '.log';
 	
 	if (!file_exists($dir)){
 		mkdir ($dir,0777,true);
 	}
 	if(!is_writable($dir.$name.$exc)){
 		fopen($dir.$name.$exc, "wd");
 	}
 	if($data){
	 	$data = json_encode($data);
	 	file_put_contents($dir.$name.$exc,date("Y-m-d H:i:s").' '.$data."\r\n", FILE_APPEND);
 	}else{ 
 		$data = file_get_contents($dir.$name.$exc);
 		$data = str_replace("\r\n","|",$data);
 		$data = explode('|',$data);
 		$array =  array();
 		foreach ($data as $v){
 			$array[] = json_decode($v,true);
 		}
 		return array_filter($array);
 	}
}
/** 
 * 模拟post进行url请求 
 * @param string $url 
 * @param array $post_data 
 */  

function curlPost($url, $param)
{
	if (empty($url) || empty($param)) {
		return false;
	}

	$ch=curl_init();
	$timeout=5;
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_HEADER, 0);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
	curl_setopt($ch,CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);	
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
	$data=curl_exec($ch);
	curl_close($ch);
	return $data;
}

/**
 * 模拟JSON提交
 * $url 路径 
 * $param_string 数据
 */
function curlPostJson($url, $param_string){  
	$param_string = json_encode($param_string);
    $ch = curl_init();  
    curl_setopt($ch, CURLOPT_POST, 1);  
    curl_setopt($ch, CURLOPT_URL, $url);  
    curl_setopt($ch, CURLOPT_POSTFIELDS, $param_string); 
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);	
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
        "Content-Type: application/json; charset=utf-8",  
        "Content-Length: " . strlen($param_string))  
    );  
    ob_start();  
    curl_exec($ch);  
    $return_content = ob_get_contents();  
    ob_end_clean();  
    $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
    return array($return_code, $return_content);  
} 

?>