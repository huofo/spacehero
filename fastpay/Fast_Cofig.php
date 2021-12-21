<?php
/*
fastpay版本2.03
*/
@error_reporting(E_ALL^E_NOTICE);

define("PAY_VERSION", '3');//版本
//FAST客户支付配置
define("FAST_APPKEY", "5775_7163be8da86067cee474fd582d605099");//你的appkey
define("SECRET_KEY", "f8f84df5d96d11417b0f3e71ebc41630");//你的秘钥
define('PAY_DESC',"平台给你汇款");//汇款备注
define('PAY_RETURN_URL',"http://ba.caichuangtong.com");//支付后成功后返回的页面,
define('PAY_NOTIFY_URL',"http://ba.caichuangtong.com");//异步回调页面,不填写默认就是会员中心的

define('PAY_OPENID',1);//是否开启代汇款接口,0,关闭,1,为开启,如果页面不能进入或者有错误,请关闭


/**----汇款接口获取openid接口的域名---------**/
define("API_OPENID", 'http://fastpay.bjnre.com/code.php?v='.PAY_VERSION);//如果需要汇款接口,请联系客服索取域名开通



//FAST的SDK配置，
define("PAY_API", 'http://api.hxs823.cn/home/Public/pay/api.php');//请求的api

/**----汇款接口---------**/
define("API_TRANSFERS", PAY_API."?pay_type=transfers&v=".PAY_VERSION);

/**----获取收款码接口---------**/
define("API_GET_QR", PAY_API."?pay_type=company_qr&v=".PAY_VERSION);
/**----获取微信用户信息接口---------**/
define("API_OPENID_INFO", 'http://www.xxx.cn/index.php?v='.PAY_VERSION);//如果需要汇款接口,请联系客服索取域名开通




//获取下单地址
function fastpay_order($paydata,$type="http"){
if(!is_array($paydata)){
exit("data错误");
}
//print_r($paydata);die;
$data = array(
    'appkey'=>FAST_APPKEY,//你的appkey
    'uid'=>$paydata['uid'],//你的用户id
    'total_fee'=>$paydata['total_fee'],//你的金额
    'order_no'=>$paydata['order_no'],//你的订单号
    'pay_title'=>'fastpay支付',//你的订单号
    'me_param'=>'',//其他参数,可返回回调里面
    'notify_url'=>PAY_NOTIFY_URL,//异步回调地址
    'me_back_url'=>PAY_RETURN_URL,//支付成功后返回
    'me_eshop_openid'=>'',//付款用户openid
    'me_party'=>'',//根据其他支付插件,异步回调返回同样参数,比如填写codepay,码支付,我们异步回调的时候就按码支付的回调参数返回
    'sign'=>''//签名
    );
$data=array_merge($data,$paydata);
extract($data);
if(empty($appkey)){exit("appkey没有填写");}
if(empty($total_fee)){exit("金额不能为空");}
if(empty($uid)){exit("付款用户id不能为空");}
if(empty($order_no)){$data['order_no']=md5(time() . mt_rand(1,1000000));}
if(!empty($me_back_url)){
  $data['me_back_url']=urlencode($me_back_url);//
}
if(!empty($notify_url)){
  $data['notify_url']=urlencode($notify_url);//
}
$data['total_fee']=bcadd($total_fee,0,2);
if(empty($sign)){$data['sign']=pay_sign($data);}
$url_quer=http_build_query($data);
$url=($type=='https') ? "/fastpay/fpay/pays.php?{$url_quer}" : "/fastpay/fpay/pay.php?{$url_quer}" ;
return $url;
}




//获取用户openid
function get_openid($scope="snsapi_base"){
	
	
  if(PAY_OPENID!=1){return '';}
  
  if(stripos(PAY_OPENID,"fastpay.bjnre.com")!==false){
    exit("在请Fast_Cofig.php里面开启汇款,并且填写汇款域名");
	}

  if(!isset($_GET['pay_openid'])){
  //获取openid后返回的页面
  $back_url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  $back_url=urlencode($back_url);//url编码
  $login_api=API_OPENID."&back_url={$back_url}&scope={$scope}";
  $login_api=API_OPENID."&back_url={$back_url}&scope={$scope}";
  exit("<meta http-equiv='Refresh' content='0;URL={$login_api}'>");
  }else {
  $_COOKIE['pay_openid']=$_GET['pay_openid'];
  return $_GET['pay_openid'];
  }
}




//获取用户信息
function get_openid_info($arr=[]){
if(!is_array($arr)){
exit("data错误");
}

if(isset($arr['fast_weixin_token'])){
  $data=array();
  $data['fast_weixin_token']=$arr['fast_weixin_token'];
  $res=get_cur(API_OPENID_INFO,$data,"POST");
  $res=json_decode($res,true);
  return $res;
}
if(empty($arr['back_url'])){
$arr['back_url']='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}
$sign=md5(FAST_APPKEY.SECRET_KEY);
$options['appkey']=FAST_APPKEY;
$options['sign']=$sign;
$options['back_url']=$arr['back_url'];
$options['scope']="snsapi_userinfo";
$url=http_build_query($options);
$login_api=API_OPENID_INFO."&{$url}";
exit("<meta http-equiv='Refresh' content='0;URL={$login_api}'>");

}




//后端获取收款二维码接口
function fast_collection($paydata){
if(!is_array($paydata)){
exit("data错误");
}
$data=array();
$data['appkey']=FAST_APPKEY;
$data['pay_type']="gren_qr";
$data['pay_way']="wechat";
$data['order_prefix']="shop";
$paydata=array_merge($data,$paydata);
$paydata['total_fee']=bcadd($paydata['total_fee'],0,2);//转换金额保留两位小数点
$paydata['me_pri']=$paydata['total_fee'];
$paydata['sign']=pay_sign($paydata);//计算签名，
$res=get_cur(API_GET_QR,$paydata,"POST");
return $res;
}


//微信汇款接口
function fast_pay($paydata){
	
	
if(!is_array($paydata)){
exit("data错误");
}
if(empty($paydata['appkey'])){$paydata['appkey']=FAST_APPKEY;}
$data=array();
$data['appkey']=(string)$paydata['appkey'];
$data['openid']=(string)$paydata['openid'];
$data['amount']=(string)$paydata['amount'];
$data['billno']=(string)$paydata['billno'];;
$data['desc']=(string)$paydata['desc'];
$data['uid']=$paydata['uid'];
$data['pay_way']='wepay';
$str_sign="appkey={$data['appkey']}&openid={$data['openid']}&amount={$data['amount']}&billno={$data['billno']}&secretkey=".SECRET_KEY."&";
$sign=md5($str_sign);
$data['sign']=$sign;//支付签名
$res=get_cur(API_TRANSFERS,$data,"POST");
return $res;
}


//支付宝汇款接口
function fast_pay_alipay($paydata){
	
	
if(!is_array($paydata)){
exit("data错误");
}
if(empty($paydata['appkey'])){$paydata['appkey']=FAST_APPKEY;}
$data=array();
$data['appkey']=(string)$paydata['appkey'];//汇款appkey
$data['openid']=(string)$paydata['payee_account'];//支付宝收款账号
$data['amount']=(string)$paydata['amount'];//金额
$data['billno']=(string)$paydata['billno'];//订单号
$data['uid']=$paydata['uid'];//你网站的用户id
$data['payer_show_name']=(string)$paydata['payer_show_name'];//付款方昵称
$data['desc']=(string)$paydata['desc'];//备注
$data['pay_way']='alipay';
$str_sign="appkey={$data['appkey']}&openid={$data['openid']}&amount={$data['amount']}&billno={$data['billno']}&secretkey=".SECRET_KEY."&";
$sign=md5($str_sign);
$data['sign']=$sign;//支付签名
$res=get_cur(API_TRANSFERS,$data,"POST");
return $res;
}


//支付下单计算签名,
function pay_sign($paydata){
if(!is_array($paydata)){
exit("data错误");
}
$str_sign="appkey={$paydata['appkey']}&order_no={$paydata['order_no']}&secretkey=".SECRET_KEY."&total_fee={$paydata['total_fee']}&uid={$paydata['uid']}&";
$sign=md5($str_sign);
return $sign;
}


//异步回调计算签名
function notify_sign($paydata){
if(!is_array($paydata)){
exit("data错误");
}
$str_sign="appkey={$paydata['appkey']}&order_no={$paydata['order_no']}&secretkey=".SECRET_KEY."&total_fee={$paydata['me_pri']}&uid={$paydata['uid']}&";
$sign=md5($str_sign);
return $sign;
}



//模拟http
function get_cur($url,$data="",$type="GET",$header=""){
$HTTP_REFERER='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
curl_setopt ($ch,CURLOPT_REFERER,$HTTP_REFERER);
//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
if(!empty($data)){
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
}

if(!empty($header)){
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
}

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$temp = curl_exec($ch);
curl_close($ch);
return $temp;
}


//判断是否是微信端
function is_weixin_pay() {
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
        return true;
    }return false;
}
