<?php

namespace app\wap\controller;
use think\Controller;
use think\Db;


class Msm extends Controller{

	public function testsend()
	{
		$code = 458645;
		$res = $this->sendsms(2175, $code ,17772160166);
		dump($res);
	}



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


	/*
	public function sendsms($uid = 0, $code ,$phone){
		$conf = getconf('');


		$url="https://api.dingdongcloud.com/v1/sms/sendyzm";
        $data = "apikey=%s&mobile=%s&content=%s";
        $content = "【".$conf['msm_SignName']."】你的验证码是".$code."，请在10分钟内输入。";
        $content = urlencode($content);
        $apikey = $conf['msm_appkey'];
        $mobile = $phone;

        $rdata = sprintf($data, $apikey, $mobile, $content);
        $url = $url.'?'.$rdata;

       	$api = controller('Api');
       	$result = $api->curlfun($url);
       	$arr = json_decode($result,1);
        if($arr['code'] == 1){
        	return true;
        }else{
        	return false;
        }



	}



	*/

	/**
	 * 阿里云短信
	 */
	/*
	public function sendsms($uid = 0, $code ,$phone){
		$conf = getconf('');
		// 初始化SendSmsRequest实例用于设置发送短信的参数
        $request = new SendSmsRequest();

        // 必填，设置雉短信接收号码
        $request->setPhoneNumbers($phone);

        // 必填，设置签名名称
        $request->setSignName($conf['msm_SignName']);

        // 必填，设置模板CODE
        $request->setTemplateCode($conf['msm_TCode']);

        // 可选，设置模板参数
        $templateParam = Array( "code"=>$code);

        if($templateParam) {
            $request->setTemplateParam(json_encode($templateParam));
        }

        // 暂时不支持多Region
        $region = "cn-hangzhou";
        // 服务结点
        $endPointName = "cn-hangzhou";
        // 短信API产品名
        $product = "Dysmsapi";
        // 短信API产品域名
        $domain = "dysmsapi.aliyuncs.com";
        // 初始化用户Profile实例
        $profile = DefaultProfile::getProfile($region, $conf['msm_appkey'], $conf['msm_secretkey']);

        // 增加服务结点
        DefaultProfile::addEndpoint($endPointName, $region, $product, $domain);

        $this->acsClient = new DefaultAcsClient($profile);
        // 发起访问请求
        $acsResponse = $this->acsClient->getAcsResponse($request);

        // 打印请求结果
        // var_dump($acsResponse);
        $array = json_decode(json_encode($acsResponse),TRUE);

        if(isset($array['Code']) && $array['Code'] == "OK"){
			return true;
		}else{
			return false;
		}
	}
*/
	/*
	public function sendsms($uid = 0, $code ,$phone)
	{
		$conf = getconf('');
		$c = new TopClient();
		$c ->appkey = trim($conf['msm_appkey']) ;
		$c ->secretKey = trim($conf['msm_secretkey']) ;
		$req = new AlibabaAliqinFcSmsNumSendRequest;
		$req ->setExtend( $uid );
		$req ->setSmsType( "normal" );
		$req ->setSmsFreeSignName( trim($conf['msm_SignName']) );
		$req ->setSmsParam("{\"code\":\"$code\"}");
		$req ->setRecNum( trim($phone) );
		$req ->setSmsTemplateCode( trim($conf['msm_TCode']) );



		$resp = $c ->execute( $req );
		$array = json_decode(json_encode($resp),TRUE);
		dump($array);
		if(isset($array['result']["success"]) && $array['result']["success"] == "true"){
			return true;
		}else{
			return false;
		}

	}

	*/

/*
	public function sendsms($uid = 0, $code ,$phone)
	{
		$conf = getconf('');
		return $this->sendTemplateSMS($phone,$code,$conf['msm_TCode'],$conf);
	}

	public function sendTemplateSMS($to,$datas,$tempId,$conf)
	{
		 // 初始化REST SDK

		//主帐号,对应开官网发者主账号下的 ACCOUNT SID
		$accountSid= $conf['msm_secretkey'];

		//主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
		$accountToken= $conf['msm_appkey'];

		//应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
		//在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
		$appId='8a216da85da6adf7015de42a6fc21628';

		//请求地址
		//沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
		//生产环境（用户应用上线使用）：app.cloopen.com
		$serverIP='app.cloopen.com';


		//请求端口，生产环境和沙盒环境一致
		$serverPort='8883';

		//REST版本号，在官网文档REST介绍中获得。
		$softVersion='2013-12-26';

	     $rest = new Rest($serverIP,$serverPort,$softVersion);
	     $rest->setAccount($accountSid,$accountToken);
	     $rest->setAppId($appId);

	     // 发送模板短信

	     $result = $rest->sendTemplateSMS($to,$datas,$tempId);
	     dump($result);
	     if($result == NULL ) {
	         return false;
	         break;
	     }
	     if($result->statusCode == '000000'){
	     	return true;
	     }else{
	     	return false;
	     }


	}

*/



}

