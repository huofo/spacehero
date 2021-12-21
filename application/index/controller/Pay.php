<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Cookie;
use think\Log;

class Pay extends Controller
{
   
    
    public function  syt_alipayssssss($order,$type)
	{
		
		
		$tjurl = 'https://open-api.10ss.net/oauth/scancodemodel';
        
		
        $time = time();
        $client_id = '1049703140';
        $clientSecret = 'bfb1ba776b2e8e2358d64d250703d5ac';
		$data = array(

			'client_id'=>$client_id,
			'machine_code'=>'4004508554',
			'msign'=>'byqizdxrecc6',
			'scope'=>'all',
			'sign'=>md5($client_id.$time.$clientSecret),
			'id'=>$this->uuid4(),
			'timestamp'=>$time,
		);
		

		$html = "<form id='form' action='".$tjurl."' method='post' style='display: none'>";
		foreach($data as $key=>$value)
		{
		    $html = $html."<input name='".$key."' value='".$value."'>";
		}
		$html = $html."</form>";
		$html = $html.'<script>document.getElementById("form").submit();</script>';


		
		echo $html;exit;
	
		
		
	}
	
	public function uuid4(){
        mt_srand((double)microtime() * 10000);
        $charid = strtolower(md5(uniqid(rand(), true)));
        $hyphen = '-';
        $uuidV4 =
            substr($charid, 0, 8) . $hyphen .
            substr($charid, 8, 4) . $hyphen .
            substr($charid, 12, 4) . $hyphen .
            substr($charid, 16, 4) . $hyphen .
            substr($charid, 20, 12);
        return $uuidV4;
    }


	
	public function  syt_alipay($order,$type)
	{
		
		
		$tjurl = 'http://laiya.36x10.com/apisubmit';
        $userid='10891';
		$userkey='273f3e22bc3b68a7a7726c97542321b3a7c8b22b';
		$version='1.0';
		$customerid=$userid;
		$sdorderno=$order["balance_sn"];
		
		$total_fee=number_format($order["bpprice"]*7,2,'.','');
		
		$paytype=$type;
		$bankcode='';
		$notifyurl="http://".$_SERVER['SERVER_NAME']."/index/pay/syt_huitiao.html";
		$returnurl='http://'.$_SERVER['HTTP_HOST'].'/index/user/index/';
		$remark=$order["uid"];
		$get_code='';


		$sign_char = 'version='.$version.'&customerid='.$customerid.'&total_fee='.$total_fee.'&sdorderno='.$sdorderno.'&notifyurl='.$notifyurl.'&returnurl='.$returnurl.'&'.$userkey;

		$sign=md5($sign_char);


		$data = array(

			'version'=>$version,
			'customerid'=>$customerid,
			'sdorderno'=>$sdorderno,
			'total_fee'=>$total_fee,
			'paytype'=>$paytype,
			'notifyurl'=>$notifyurl,
			'returnurl'=>$returnurl,
			'remark'=>$remark,
			'bankcode'=>$bankcode,
			'sign'=>$sign,
			'get_code'=>$get_code


		);
		

		$html = "<form id='form' action='".$tjurl."' method='post' style='display: none'>";
		foreach($data as $key=>$value)
		{
		    $html = $html."<input name='".$key."' value='".$value."'>";
		}
		$html = $html."</form>";
		$html = $html.'<script>document.getElementById("form").submit();</script>';


		
		echo $html;exit;
	
		
		
	}


    public function  hjdf_huidiao()
    {


        $userkey='273f3e22bc3b68a7a7726c97542321b3a7c8b22b';
        $status=$_POST['status'];
        $customerid=$_POST['customerid'];
        $sdorderno=$_POST['sdorderno'];
        $total_fee=$_POST['total_fee'];
        $orderid=$_POST['orderid'];
        $account_name = $_POST['account_name'];
        $account_number=$_POST['account_number'];
        $remark=$_POST['remark'];
        $sign=$_POST['sign'];
        $errorCode = $_POST['errorCode'];
        $errorDesc=$_POST['errorDesc'];


        $mysign=md5('customerid='.$customerid.'&status='.$status.'&orderid='.$orderid.'&sdorderno='.$sdorderno.'&total_fee='.$total_fee.'&account_number='.$account_number.'&account_name='.$account_name.'&'.$userkey);


        if($sign==$mysign)
        {
            
            $this->textlog(111,$_POST);
            $order_info =  Db::name('balance')->field('bpid,bpprice,isverified,bptime,reg_par,balance_sn,uid,bankid')->where('balance_sn',$sdorderno)->find();

            if($status=='205')
            {
                if($order_info['isverified'] == 0||$order_info['isverified'] == 3)
                {
                    $_data['bpid'] = $order_info['bpid'];
                    $_data['isverified'] = 1;
                    $_data['cltime'] = time();
                    $_data['remarks'] = \think\Lang::get('pa_dkydz');
                    Db::name('balance')->update($_data);
                    echo 'success';
                }
            }
            else
            {
                $_data['bpid'] = $order_info['bpid'];
                $_data['cltime'] = time();
                $_data['remarks'] = $errorDesc;
                Db::name('balance')->update($_data);
                echo 'fail';
            }
        }
        else
        {
            echo 'signerr';
        }

    }

	public function syt_yisaofu($msg){
		$data = array(
		    "orderAmount"=>$msg["bpprice"]*6.8, //金额
		    "orderId"=> $msg["balance_sn"],//订单号
		    "merchant"=>"201903290606182664", //商户号
		    'payMethod'=>'5', //支付方式
		    "payType"=>"51", //支付类型
		    "signType"=>"MD5",
		    "version"=>"1.0",
		//此参数作用为返回的数据的格式  ‘yes’时返回的是json格式数据，并且             没有支付页面，只返回支付链接  ‘no’时返回的是支付页面
		    "outcome"=>"no",
		);
		//组装参与签名的字段，生成一个数组$data;
		$key = 'D907B61A1F7AF689B42788B4EEC42033'; //商户号所对应的商户密钥
		ksort($data); //按照键名对关联数组进行升序排序
		//生成 URL-encode 之后的请求字符串
		$postString = http_build_query($data);
		//将$postString连接上商户密钥后再MD5加密
		$mdString = md5($postString.$key);
		//将MD5后的数据全部专为大写 生成签名
		$signMyself = strtoupper($mdString);
		//将签名加入数组
		$data["sign"] = $signMyself;
		$data['productName'] = $msg["bpprice"]*6.8;;//商品名称
		$data['productDesc'] = $msg["uid"] ;//商品描述
		$data['createTime'] = $msg['btime'];//time()为当前时间戳 秒级
		$data['notifyUrl'] = "http://".$_SERVER['SERVER_NAME']."/index/pay/syt_yisaofuinfo.html";//接收订单回调数据的URL
		$data['returnUrl'] = 'http://'.$_SERVER['HTTP_HOST'].'/index/user/index/';//支付成功后跳转到的地址
		//使用GET方式访问需要生成 URL-encode 之后的请求字符串
		// 这里可以用 GET 也可以用POST方式
		// 
		// print_r($data);exit;
		$postString = http_build_query($data);
		$url="http://pay.sytpay.cn/index.php/Api/Index/createOrder?".$postString;
		header("Location: " .$url);exit; 
	}

	public function syt_fhv6(){
		include '/extend/org/base.php';
		$order = input('get.');
		$data = db('balance')->where('balance_sn',$order['order_sn'])->find();
		if(!$data){
			exit(json_encode(array('status'=>0,'info'=>\think\Lang::get('pa_cwddd'))));
		}
		$baseUrl = 'http://'.$_SERVER['HTTP_HOST'];
		$merId = "0000003127";//商户号(MerId)
		$appId = "0000005684";//应用ID(AppId)
		$payKey = "7f1daabaf6ba7a50f51078526186cf6e";//支付Key(PayKey)
		$money = $data['bpprice']*100*6.8;
		$payType = $order["payType"];
		// $bankCode = $order["bankCode"];
		$order_id = $data['balance_sn'];
		//$order_id = $msg["balance_sn"]; //此处就在您服务器生成新订单，订单号不能重复提交。
	    $return_url = 'http://'.$_SERVER['HTTP_HOST'].'/index/user/index/';//支付成功，用户会跳转到这个地址
	    $notify_url = "http://".$_SERVER['SERVER_NAME']."/index/pay/fhv6.html";//
			
		$signdata = array( 
			'MerId' => $merId,		
			'AppId' => $appId,			
			'PayType' => $payType,						
			'NonceStr' => $order_id,				
			'OrderId' => $order_id,						
			'TotalFee' => $money,
			'NotifyUrl' => $notify_url,		
			'ReturnUrl' => $return_url,	
		);   

		if ($payType == 4 || $payType == 5)
		{
			$signdata["IPVal"] = $_SERVER['REMOTE_ADDR'];
		}

		// if ($payType == 4)
		// {
		// 	$signdata["BankCode"] = $bankCode;//根据实际的值赋值
		// }
		
		$signdata["Sign"] = make_sign($signdata,$payKey);

		$postData = toXml($signdata);
		
		$postResult = curlPost("http://pay.dnfqqf.cn/PaySDK/PayAPI/ReadyPay","xmlData=".$postData);
	    echo $postResult;
	}

	public function fhv6(){
		include '/extend/org/base.php';
		if($_SERVER['REQUEST_METHOD'] == "POST"){ 
			
			$payKey = "7f1daabaf6ba7a50f51078526186cf6e";//支付Key(PayKey)
			
			$data = $_POST["data"];

			$array = xmlToArray($data);
			
			$signVal = make_sign($array,$payKey);
			$fp = fopen('msgType.txt','w+'); fwrite($fp,var_export($array,true)); fclose($fp);
			if($signVal==$array["Sign"]){
				//签名正确，执行业务逻辑，注意重复回调处理
				$fp = fopen('msgTypes.txt','w+'); fwrite($fp,var_export($signVal,true)); fclose($fp);
				$this->qt_ok_dopaysss($array['OrderId'],($array['TotalFee']/100/6.8));
				echo "<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[处理成功]]></return_msg></xml>";
			}
			else{
				echo "<xml><return_code><![CDATA[FAIL]]></return_code><return_msg><![CDATA[处理失败]]></return_msg></xml>";
			}
		}
	}
	public function syt_huitiao()
    {
		
		
		$userid='10891';
		$userkey='273f3e22bc3b68a7a7726c97542321b3a7c8b22b';
		$status=$_POST['status'];
		$customerid=$_POST['customerid'];
		$sdorderno=$_POST['sdorderno'];
		$total_fee=$_POST['total_fee'];
		$paytype=$_POST['paytype'];
		$sdpayno=$_POST['sdpayno'];
		$remark=$_POST['remark'];
		$sign=$_POST['sign'];
		
		
		
		$mysign=md5('customerid='.$customerid.'&status='.$status.'&sdpayno='.$sdpayno.'&sdorderno='.$sdorderno.'&total_fee='.$total_fee.'&paytype='.$paytype.'&'.$userkey);
		
		
		if($sign==$mysign)
		{
			if($status=='1')
			{
			
			 	$user_order_no = $sdorderno;
				
				$price = $total_fee;
				$this->qt_ok_dopay($user_order_no,$price);
				echo 'success';
				
				
				
			} 
			else 
			{
				echo 'fail';
			}
		} 
		else 
		{
			echo 'signerr';
		}
		
		
		
		$ip = $this->request->ip();
	
		if($ip=='118.190.55.243' || $ip == '47.105.173.255')
		{
			$json = file_get_contents('php://input');
			$key =  'C2CD49297347B81D12F6BA9251EDA2FE';
			$arr = json_decode($json,true);
			$jsonBase64 = base64_encode(json_encode($arr['paramsJson']));
			$jsonBase64Md5 = md5($jsonBase64);
			$sign = strtoupper(md5($key.$jsonBase64Md5));
			if($sign != $arr['sign']){
				echo 'error';
			}else{
				$params = $arr['paramsJson'];	
				
					
				$user_order_no = $params['data']['orderId'];
				
				$price = $params['data']['orderAmount'];
				$this->qt_ok_dopay($user_order_no,$price);
				echo 'success';
			
			}
		}
		
		
		
 
    }
	
	
	
 public function textlog($file,$txt)
    {
        $fp =  fopen($file.'.txt','ab+');
        fwrite($fp,'-----------'.date('Y-m-d H:i:s').'-----------------');
        fwrite($fp,"\r\n\r\n\r\n");
        fwrite($fp,var_export($txt,true));
        fwrite($fp,"\r\n\r\n\r\n");
        fclose($fp);
    }

	
	public function  suzhifu($data,$cz_type)
	{
		$uid = "404";//"此处填写平台的uid";
		$price = $data["bpprice"];//从网页传入price:支付价格。校验传入的表单，确保价格为正常价格（整数，1位小数，2位小数都可以）
		$paytype = $cz_type;//paytype:支付渠道：1-支付宝；2-微信支付
		$notify_url = "http://".$_SERVER['SERVER_NAME']."/index/pay/suzhifu_huitiao.html";
		$return_url = "http://".$_SERVER['SERVER_NAME']."/index/user/index.html";
		$user_order_no = $data["balance_sn"];    //每次有任何参数变化，订单号就变一个吧。
		$note =$data["uid"];		//备注    
		$cuid = $data["uid"];       //此处传入您网站用户的用户名，方便在平台后台查看是谁付的款，强烈建议加上。可忽略。
	
	
		//此处就在您服务器生成新订单，并把创建的订单号传入到下面的orderid中。
		$token = "1a344e04ac3b4e1598b59d2eea8fcb9b";//"此处填写平台的Token";
		
		$sign = md5($uid . $price . $paytype . $notify_url . $return_url . $user_order_no . $token);
		//经常遇到有研发问为啥sign值返回错误，大多数原因：1.参数的排列顺序不对；2.上面的参数少传了，但是这里的sign值又带进去计算了，导致服务端sign算出来和你的不一样。
	
		$returndata['uid'] = $uid;
		$returndata['price'] = $price;
		$returndata['paytype'] = $paytype;
		$returndata['notify_url'] = $notify_url;
		$returndata['return_url'] = $return_url;
		$returndata['user_order_no'] =$user_order_no;
		$returndata['note'] = $note;
		$returndata['cuid'] = $cuid;
		$returndata['sign'] = $sign;
		
		
		return $returndata;
	}
	
		public function suzhifu_huitiao()
    {
		
		
		$user_order_no = isset($_GET["user_order_no"])?$_GET["user_order_no"]:'';
		$orderno = isset($_GET["orderno"])?$_GET["orderno"]:'';
		$tradeno = isset($_GET["tradeno"])?$_GET["tradeno"]:'';
		$price = isset($_GET["price"])?$_GET["price"]:'0.00';
		$realprice = isset($_GET["realprice"])?$_GET["realprice"]:'0.00';
		$cuid = isset($_GET["cuid"])?$_GET["cuid"]:0;
		$note = isset($_GET["note"])?$_GET["note"]:'';
		$sign = isset($_GET["sign"])?$_GET["sign"]:'';
	
		//校验传入的参数是否格式正确，略
	
		$token = "1a344e04ac3b4e1598b59d2eea8fcb9b";
		
		$temps = md5($user_order_no . $orderno . $tradeno . $price . $realprice . $token);

		if ($temps == $sign){
			
			$this->qt_ok_dopay($user_order_no,$price);
			
			//校验sign成功。执行自己的业务逻辑：加余额，订单付款成功，装备购买成功等等。
			echo "success";//成功必须返回"success"
		}else{
			echo "sign".\think\Lang::get('pa_bpp');//成功必须返回"success"
		}
      

    }
	
	
	
   public function qt_zhifu($data,$cz_type)
    {
       /*
        * 商户id，商户秘钥
        */
        $parter = 1777;
        $key = '6eeaa6d3569440a0bcc2372ef1c9227e';
        $nowtime = time();
        /*
        * 对接方式
		*1003支付宝扫码
		*1004微信扫码
		*1009QQ钱包
        */
        $type = $cz_type;
        
        /*
        * 支付金额
        */
        $value = $data['bpprice'];
        
        /*
        * 请求发起方自己的订单号，该订单号将作为平台的返回数据
        */
        $orderid = $data['balance_sn'];
        
        /*
        * 在下行过程中返回结果的地址，需要以http://开头。
        */
        $callbackurl = "http://".$_SERVER['SERVER_NAME']."/index/pay/qt_huitiao.html";
        /*
        * 支付完成之后平台会自动跳转回到的页面
        */
        $hrefbackurl = "http://".$_SERVER['SERVER_NAME']."/index/user/index.html";
        /*
        * 发送网址
        */
        $shidai_bank_url   = 'http://newpay.qpabc.com/bank/';

        $url = "parter=". $parter ."&type=". $type ."&value=". $value. "&orderid=". $orderid ."&callbackurl=". $callbackurl;
        //签名
        $sign   = md5($url. $key);
        
        //最终url
        $url    = $shidai_bank_url . "?" . $url . "&sign=" .$sign. "&hrefbackurl=". $hrefbackurl;
		
		
		if(in_array($cz_type,array(1005,1006,1007,1008))){
            return $url;
        }else{
        $curl = curl_init();
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($curl, CURLOPT_TIMEOUT, 500);
         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
         curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
         curl_setopt($curl, CURLOPT_URL, $url);
         
         $res = curl_exec($curl);
		 
         curl_close($curl);
            
		//dump($res);
         $res_arr = json_decode($res,1);
		 
         if(isset($res_arr["retCode"]) && $res_arr["retCode"] == '0000'){
                return $res_arr["codeUrl"];
         }else{
         return false;
        }
    }
}	    
		
		public function qt_huitiao()
    {
        cache('qdb_test',$_GET);
        //$_GET = cache('qdb_test');
        //获取返回的下行数据
        
        //$sysorderid     = trim($_GET['sysorderid']);
        //$completiontime     = trim($_GET['systime']);

        //进行爱扬签名认证
        $key = '6eeaa6d3569440a0bcc2372ef1c9227e';
        header('Content-Type:text/html;charset=GB2312');
        $orderid        = trim($_GET['orderid']);
        $opstate        = trim($_GET['opstate']);
        $ovalue         = trim($_GET['ovalue']);
        $sign           = trim($_GET['sign']);
        
        //订单号为必须接收的参数，若没有该参数，则返回错误
        if(empty($orderid)){
            die("opstate=-1");      //签名不正确，则按照协议返回数据
        }
        
        $sign_text  = "orderid=".$orderid."&opstate=".$opstate."&ovalue=".$ovalue.$key;
        $sign_md5 = md5($sign_text);
        if($sign_md5 != $sign){
            die("opstate=-2");      //签名不正确，则按照协议返回数据
        }
		$this->qt_ok_dopay($orderid,$ovalue);
		$this->qt_ok_dopay($orderid,$ovalue);
        die("opstate=0");       

    }

    public function qt_ok_dopaysss($order_no,$order_amount){
        
        if(!$order_no || !$order_amount){
            
            return false;
        }

        $balance = db('balance')->where('balance_sn',$order_no)->find();

		$subs = abs($order_amount - $balance['bpprice']);
		
		if($subs != 0){
			
			return false;
			
		}
		
        if(!$balance){
            
            return false;
        }

        if($balance['bptype'] != 3){
            
            return true;
        }
		
        $_edit['bpid'] = $balance['bpid'];
        $_edit['bptype'] = 1;
        $_edit['isverified'] = 1;
        $_edit['cltime'] = time();
        $_edit['bpbalance'] = $balance['bpbalance']+$balance['bpprice'];
        
        $is_edit = db('balance')->update($_edit);
        
        if($is_edit){
			
			
            // add money
            $_ids=db('userinfo')->where('uid',$balance['uid'])->setInc('usermoney',$balance['bpprice']);
            if($_ids){
                //资金日志
                set_price_log($balance['uid'],1,$balance['bpprice'],\think\Lang::get('pa_cz'),\think\Lang::get('ae_yhcz'),$_edit['bpid'],$_edit['bpbalance']);
				
				$this->recharge_activity($balance['uid'],$balance['bpprice'],$_edit['bpid']);
				$this->level_up($balance['uid'],$balance['bpprice']);
            }
            
            return true;
			
        }else{
            
            return false;
        }

    }
	
	 public function qt_ok_dopay($order_no,$order_amount){
        
        if(!$order_no || !$order_amount){
            
            return false;
        }

        $balance = db('balance')->where('balance_sn',$order_no)->find();

		/*$subs = abs($order_amount - $balance['bpprice']);
		
		if($subs > 5){
			
			return false;
			
		}*/
		
        if(!$balance){
            
            return false;
        }

        if($balance['bptype'] != 3){
            
            return true;
        }
		
        $_edit['bpid'] = $balance['bpid'];
        $_edit['bptype'] = 1;
        $_edit['isverified'] = 1;
        $_edit['cltime'] = time();
        $_edit['bpbalance'] = $balance['bpbalance']+$balance['bpprice'];
        
        $is_edit = db('balance')->update($_edit);
        
        if($is_edit){
			
			
            // add money
            $_ids=db('userinfo')->where('uid',$balance['uid'])->setInc('usermoney',$balance['bpprice']);
            if($_ids){
                //资金日志
                set_price_log($balance['uid'],1,$balance['bpprice'],\think\Lang::get('pa_cz'),\think\Lang::get('ae_yhcz'),$_edit['bpid'],$_edit['bpbalance']);
				
				$this->recharge_activity($balance['uid'],$balance['bpprice'],$_edit['bpid']);
				$this->level_up($balance['uid'],$balance['bpprice']);
            }
            
            return true;
			
        }else{
            
            return false;
        }

    }
	public function recharge_activity($uid,$order_amount,$bpid){
		$user = Db::name('userinfo')->where('uid',$uid)->find();
		$recharge_activity = getconf('recharge_activity');
		$money = $order_amount*$recharge_activity/100;
		
		$nowmoney = $money+$user['usermoney'];
		$ok=db('userinfo')->where('uid',$uid)->setInc('usermoney',$money);
		if($ok)
		{
			set_price_log($uid,1,$money,\think\Lang::get('pa_czzs'),\think\Lang::get('ae_yhcz').$order_amount.\think\Lang::get('ae_zs').$money, $bpid,$nowmoney);
		}
		
	}
	
	public function level_up($uid,$order_amount){
		
		$user = Db::name('userinfo')->where('uid',$uid)->find();
		$level_up = getconf('level_up');
		$order_amount = $order_amount;
		
		
		if($user['level']=='level_zero')
		{
			$user['level']=0;
		}elseif($user['level']=='level_one')
		{
			$user['level']=1;
		}elseif($user['level']=='level_two')
		{
			$user['level']=2;
		}elseif($user['level']=='level_three')
		{
			$user['level']=3;
		}
		elseif($user['level']=='level_four')
		{
			$user['level']=4;
		}
		
		
		$level_up = explode("|",$level_up);
		
		if($order_amount>=$level_up[0]&&$order_amount<$level_up[1])
		{
			if($user['level']<1)
			{
				$adddata['level']='level_one';
				$adddata['uid']=$uid;
				$newids = Db::name('userinfo')->update($adddata);		
			}
				
		}elseif($order_amount>=$level_up[1]&&$order_amount<$level_up[2])
		{
			if($user['level']<2)
			{
				$adddata['level']='level_two';
				$adddata['uid']=$uid;
				$newids = Db::name('userinfo')->update($adddata);
			}
		}elseif($order_amount>=$level_up[2]&&$order_amount<$level_up[3])
		{
			if($user['level']<3)
			{
				$adddata['level']='level_three';
				$adddata['uid']=$uid;
				$newids = Db::name('userinfo')->update($adddata);
			}
		}elseif($order_amount>=$level_up[3])
		{
			if($user['level']<4)
			{
				$adddata['level']='level_four';
				$adddata['uid']=$uid;
				$newids = Db::name('userinfo')->update($adddata);
			}
		}
	}
	
	public function bnc_pay($data)
	{	
		$postdata['userkey']='f33642269ee87764dee921f7e506c1591b554415';
		$postdata['version']='1.0';
		$postdata['customerid']='11021';
		$postdata['sdorderno']=$data['balance_sn'];
		$postdata['number']=$data['bpprice']*6.8;
		$postdata['currency']='CNY';
		$postdata['paytype']='bank';
		$postdata['bankcode']='ICBC';
		$postdata['notifyurl']='http://'.$_SERVER['HTTP_HOST'].'/index/pay/bnc_not';
		$postdata['returnurl']="http://".$_SERVER['SERVER_NAME']."/index/user/index.html";
		$postdata['remark']=\think\Lang::get('ae_yhcz');
		$signstr='version='.$postdata['version'].'&currency='.$postdata['currency'].'&customerid='.$postdata['customerid'].'&sdorderno='.$postdata['sdorderno'].'&notifyurl='.$postdata['notifyurl'].'&returnurl='.$postdata['returnurl'].'&'.$postdata['userkey'];
		$postdata['sign']=md5($signstr);
				
		echo '<body onload="document.pay.submit()"><form name="pay" action="http://www.bncp.in/apisubmit" method="post">
        <input type="hidden" name="version" value="'.$postdata['version'].'">
        <input type="hidden" name="customerid" value="'.$postdata['customerid'].'">
		<input type="hidden" name="currency" value="'.$postdata['currency'].'">
        <input type="hidden" name="sdorderno" value="'.$postdata['sdorderno'].'">
        <input type="hidden" name="number" value="'.$postdata['number'].'">
        <input type="hidden" name="paytype" value="'.$postdata['paytype'].'">
        <input type="hidden" name="notifyurl" value="'.$postdata['notifyurl'].'">
        <input type="hidden" name="returnurl" value="'.$postdata['returnurl'].'">
        <input type="hidden" name="remark" value="'.$postdata['remark'].'">
        <input type="hidden" name="bankcode" value="'.$postdata['bankcode'].'">
        <input type="hidden" name="sign" value="'.$postdata['sign'].'">
		<input type="submit" value="submit">
    </form></body>';
	}
	
	public function bnc_not()
	{
		$userkey='f33642269ee87764dee921f7e506c1591b554415';
		$status=$_POST['status'];
		$customerid=$_POST['customerid'];
		$sdorderno=$_POST['sdorderno'];
		$total_fee=$_POST['total_fee'];
		$paytype=$_POST['paytype'];
		$sdpayno=$_POST['sdpayno'];
		$remark=$_POST['remark'];
		$sign=$_POST['sign'];
		
		$mysign=md5('customerid='.$customerid.'&status='.$status.'&sdpayno='.$sdpayno.'&sdorderno='.$sdorderno.'&total_fee='.$total_fee.'&paytype='.$paytype.'&'.$userkey);
		
		if($sign==$mysign){
			if($status=='1'){
				$this->qt_ok_dopay($sdorderno,$total_fee);
				echo 'success';
			} else {
				echo 'fail';
			}
		} else {
			echo 'signerr';
		}
	}
}


?>