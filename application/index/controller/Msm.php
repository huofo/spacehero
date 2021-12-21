<?php

namespace app\index\controller;
use think\Controller;
use think\Db;
use alidayu\top\TopClient;
use alidayu\top\request\AlibabaAliqinFcSmsNumSendRequest;

require_once $_SERVER['DOCUMENT_ROOT'].'/extend/dayu2.0/vendor/autoload.php';

use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\QuerySendDetailsRequest;

use fusms\Ucpaas;

use yuntongxun\Rest;
// 加载区域结点配置
Config::load();

class Msm extends Controller{

	public function testsend()
	{
		$code = 458645;
		$res = $this->sendsms(2175, $code ,17772160166);
		dump($res);
	}

/*
	public function sendsms($uid = 0, $code ,$phone)
	{
		if(!$code){
			return false;
		}

		if(!$phone){
			return false;
		}

		//初始化必填
		$options['accountsid']='f7acc233dc79a57fc37c791db2ccc54c';
		$options['token']='75b58c0ba10f39199fe79c3f54dc5e08';


		//初始化 $options必填
		$ucpass = new Ucpaas($options);

		//开发者账号信息查询默认为json或xml

		$ucpass->getDevinfo('json');
		$appId = "38f8f22da49d4681b9d1aca4ebdf22af";
		$to = $phone;
		$templateId = "128304";
		$param=$code;

		$res = $ucpass->templateSMS($appId,$to,$templateId,$param);
		$arr = json_decode($res,1);
		if(isset($arr["resp"]["respCode"]) && $arr["resp"]["respCode"] == "000000"){
			return true;
		}else{
			return false;
		}
	}
*/
	/**
	 * 短信宝 http://www.smsbao.com/
	 */

	/*public function sendsms($uid = 0, $code ,$phone)
	{
		$conf = getconf('');

		if(!$code){
			return false;
		}

		if(!$phone){
			return false;
		}

		$content = '您的验证码为'.$code.'，在10分钟内有效。';

		$smsapi = "http://api.smsbao.com/"; //短信网关
		$user = "A8521234334"; //短信平台帐号
		$pass = md5("A177188199"); //短信平台密码
		$content="【中金智投】".$content;//要发送的短信内容
		$phone = $phone;
		$sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
		$result =file_get_contents($sendurl) ;
		if($result !=0){
			return false;
		}else{
			return true;
		}

	}
*/

    public function sendsmss($uid = 0, $code ,$mobile)
    {


        $content = $code.\think\Lang::get('ms_ndyzmw');
        $http = 'http://http.yunsms.cn/tx/';
        $uid='230867';
        $pwd='987654321';
        $time='';
        $mid='';
        $data = array
        (
            'uid'=>$uid,					//数字用户名
            'pwd'=>strtolower(md5($pwd)),	//MD5位32密码
            'mobile'=>$mobile,				//号码
            //'content'=>$content,			//内容 如果对方是utf-8编码，则需转码iconv('gbk','utf-8',$content); 如果是gbk则无需转码
            'content'=>iconv('utf-8','GBK',$content),			//内容 如果对方是utf-8编码，则需转码iconv('gbk','utf-8',$content); 如果是gbk则无需转码
            'time'=>$time,		//定时发送
            'mid'=>$mid						//子扩展号
        );
        $re=$this->postSMS($http,$data);			//POST方式提交
        if( trim($re) == '100' )
        {
            return true;
        }
        else
        {
            return false;
        }
    }



   /* public function sendsms($uid = 0, $code ,$mobile)
    {
        $content = '您的验证码为'.$code.'，在10分钟内有效。';
        $post_data = array();
        $account = 'bn2021';	//账号
        $password = 'Bn2021@@';	//密码
        $post_data['userid'] = 3261;	//用户ID
        $post_data['timestamp'] = date('YmdHis',time());
        $singstr  = MD5($account.$password.$post_data['timestamp']);
        $post_data['sign'] = strtolower($singstr);
        $post_data['mobile'] = $mobile;
        //$post_data['content'] = '【B.King】'.mb_convert_encoding($content,'UTF-8', 'GB2312');
        $post_data['content'] = '【牛生活】'.$content;
        $url='http://116.62.155.121:8888/v2sms.aspx?action=send';
        $o='';
        foreach ($post_data as $k=>$v)
        {
            $o.="$k=".urlencode($v).'&';
        }
        $post_data=substr($o,0,-1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 	 //直接返回到变量里
        $result = curl_exec($ch);
        $result =$this->xml_to_json($result);
        $result = json_decode($result,1);
        curl_close($ch);
        $fp =  fopen('1111222.txt','ab+');
        fwrite($fp,'-----------'.date('Y-m-d H:i:s').'-----------------');
        fwrite($fp,"\r\n\r\n\r\n");
        fwrite($fp,var_export($result,true));
        fwrite($fp,"\r\n\r\n\r\n");
        fclose($fp);

        if($result['returnstatus']=='Success'&&$result['message']=='ok'){
            return 1;
        }else{
            return 0;
        }
    }*/
    
    
     public function sendsms($uid = 0, $code ,$mobile)
    {
        $type = 0;
        $notification=false;
        $email = $mobile;
        $subject = $code;
         $content = \think\Lang::get('ms_ndyzms').$code;
        $shop_name = 'B.King';
        $name = $mobile;
        $charset   ="UTF8";

        /* 邮件的头部信息 */
        $content_type = ($type == 0) ?
            'Content-Type: text/plain; charset=' . $charset : 'Content-Type: text/html; charset=' . $charset;
        $content   =  base64_encode($content);
        $youxiang = "galaxymining8@gmail.com";
        $headers = array();
        $headers[] = 'Date: ' . gmdate('D, j M Y H:i:s') . ' +0000';
        $headers[] = 'To: "' . '=?' . $charset . '?B?' . base64_encode($name) . '?=' . '" <' . $email. '>';
        $headers[] = 'From: "' . '=?' . $charset . '?B?' . base64_encode($shop_name) . '?='.'" <' . $youxiang . '>';
        $headers[] = 'Subject: ' . '=?' . $charset . '?B?' . base64_encode($subject) . '?=';
        $headers[] = $content_type . '; format=flowed';
        $headers[] = 'Content-Transfer-Encoding: base64';
        $headers[] = 'Content-Disposition: inline';
        if ($notification)
        {
            $headers[] = 'Disposition-Notification-To: ' . '=?' . $charset . '?B?' . base64_encode($shop_name) . '?='.'" <' . $youxiang . '>';
        }

        /* 获得邮件服务器的参数设置 */

        $params['host'] = 'smtp.gmail.com';
        $params['port'] = '465';
        $params['user'] = 'galaxymining8@gmail.com';
        $params['pass'] = 'lxysazkrdhjvqzbj';


        // 发送邮件



        $send_params['recipients'] = $email;
        $send_params['headers']    = $headers;
        $send_params['from']       = "galaxymining8@gmail.com";
        $send_params['body']       = $content;



        $smtp = new \smtp\Clssmtp($params);



        if ($smtp->connect() && $smtp->send($send_params))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    
    public function xml_to_json($source) {
        if(is_file($source)){ //传的是文件，还是xml的string的判断
            $xml_array=simplexml_load_file($source);
        }else{
            $xml_array=simplexml_load_string($source);
        }
        $json = json_encode($xml_array); //php5，以及以上，如果是更早版本，请查看JSON.php
        return $json;
    }



    public function sendsmsss($uid = 0, $code ,$mobile)
		{
			$content = \think\Lang::get('od_ndyzmw').$code.\think\Lang::get('od_zsfzznyx');
			$http = 'http://http.yunsms.cn/tx/';
			$uid='230867';
			$pwd='987654321';
			$time='';
			$mid='';
			$data = array
				(
				'uid'=>$uid,					//数字用户名
				'pwd'=>strtolower(md5($pwd)),	//MD5位32密码
				'mobile'=>$mobile,				//号码
				//'content'=>$content,			//内容 如果对方是utf-8编码，则需转码iconv('gbk','utf-8',$content); 如果是gbk则无需转码
				'content'=>iconv('utf-8','GBK',$content),			//内容 如果对方是utf-8编码，则需转码iconv('gbk','utf-8',$content); 如果是gbk则无需转码
				'time'=>$time,		//定时发送
				'mid'=>$mid						//子扩展号
				);
			$re=$this->postSMS($http,$data);			//POST方式提交


			if( trim($re) == '100' )
			{
				return true;
			}
			else
			{
				return false;
			}
		}

	public function postSMS($url,$data='')
	{
		$post='';
		$row = parse_url($url);

		$fp = fopen('99999999.txt','w+'); fwrite($fp,var_export($row,true)); fclose($fp);
		$host = $row['host'];
		$port = 80;
		$file = $row['path'];
		while (list($k,$v) = each($data))
		{
			$post .= rawurlencode($k)."=".rawurlencode($v)."&";	//转URL标准码
		}
		$post = substr( $post , 0 , -1 );
		$len = strlen($post);
		//$fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
		$fp = stream_socket_client("tcp://".$host.":".$port, $errno, $errstr, 10);

		if (!$fp) {
			return "$errstr ($errno)\n";
		} else {
			$receive = '';
			$out = "POST $file HTTP/1.0\r\n";
			$out .= "Host: $host\r\n";
			$out .= "Content-type: application/x-www-form-urlencoded\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Content-Length: $len\r\n\r\n";
			$out .= $post;
			fwrite($fp, $out);
			while (!feof($fp)) {
				$receive .= fgets($fp, 128);
			}
			fclose($fp);
			$receive = explode("\r\n\r\n",$receive);
			unset($receive[0]);
			return implode("",$receive);
		}
	}


	/*发送信息通知用户*/
    public function sendEmailToMember($uid = 0, $content ,$mobile)
    {


        $type = 0;
        $notification=false;
        $email = $mobile;
        $subject = "new order！";
        //$content = \think\Lang::get('ms_ndyzms').$code;
        $shop_name = 'B.King';
        $name = $mobile;
        $charset   ="UTF8";

        /* 邮件的头部信息 */
        $content_type = ($type == 0) ?
            'Content-Type: text/plain; charset=' . $charset : 'Content-Type: text/html; charset=' . $charset;
        $content   =  base64_encode($content);
        $youxiang = "ernshbergs@gmail.com";
        $headers = array();
        $headers[] = 'Date: ' . gmdate('D, j M Y H:i:s') . ' +0000';
        $headers[] = 'To: "' . '=?' . $charset . '?B?' . base64_encode($name) . '?=' . '" <' . $email. '>';
        $headers[] = 'From: "' . '=?' . $charset . '?B?' . base64_encode($shop_name) . '?='.'" <' . $youxiang . '>';
        $headers[] = 'Subject: ' . '=?' . $charset . '?B?' . base64_encode($subject) . '?=';
        $headers[] = $content_type . '; format=flowed';
        $headers[] = 'Content-Transfer-Encoding: base64';
        $headers[] = 'Content-Disposition: inline';
        if ($notification)
        {
            $headers[] = 'Disposition-Notification-To: ' . '=?' . $charset . '?B?' . base64_encode($shop_name) . '?='.'" <' . $youxiang . '>';
        }

        /* 获得邮件服务器的参数设置 */

        $params['host'] = 'smtp.gmail.com';
        $params['port'] = '465';
        $params['user'] = 'ernshbergs@gmail.com';
        $params['pass'] = 'yemrzcrfgoauiktq';


        // 发送邮件



        $send_params['recipients'] = $email;
        $send_params['headers']    = $headers;
        $send_params['from']       = "ernshbergs@gmail.com";
        $send_params['body']       = $content;



        $smtp = new \smtp\Clssmtp($params);



        if ($smtp->connect() && $smtp->send($send_params))
        {
            return true;
        }
        else
        {
            return false;
        }
    }



}

