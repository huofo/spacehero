<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Api extends Controller{

	public function __construct(){
		parent::__construct();

		$this->nowtime = time();
		$minute = date('Y-m-d H:i',$this->nowtime).':00';
		$this->minute = strtotime($minute);
		$this->start_time = mktime(0,0,0,date('m'),date('d'),date('Y'));
		//指定客户赢利或亏损：
		//array()里面写客户编号，如客户id为1027则写为  array(1027)
		//如多个客户，则以英文逗号分开，如 array(1027,2018,3765)
		//注意一定是英文逗号，中文逗号会报错
		$this->user_win = array();//指定客户赢利
		$this->user_loss = array();//指定客户亏损

		//K线数据库
		$this->klinedata = db('klinedata');


	}
	public function xiufu()
	{
		$pro = db('oneday')->where("type=92")->select();
		
		foreach($pro as $k=>$v){
			$thisdata=array();
			$thisdata['open'] =$v['open']+960.3 ;
			$thisdata['high']=$v['high']+960.3;
			$thisdata['close']=$v['close']+960.3;
			$thisdata['low']=$v['low']+960.3;
			
			db('oneday')->where('id',$v['id'])->update($thisdata);
		}
		
	}
	
	public function getdate()
	{
		//产品列表
		$pro = db('productinfo')->where('isdelete',0)->select();
		//dump($pro);
		if(!isset($pro)) return false;

		$nowtime = time();
		$_rand = rand(1,900)/100000;
		$thisdatas = array();

		foreach ($pro as $k => $v)
		{
			
			//验证休市
			$isopen = ChickIsOpen($v['pid']);
			if(!$isopen)
			{
				continue;
			}




			 if(in_array($v['procode'],array("1","2","3","4","5","6","12","13","14","90","91","93","94","95","97","98","99","100")))
			 {
				//口袋贵金属
				$url = "https://m.sojex.net/api.do?rtp=GetQuotesDetail&id=".$v['procode'];

				//$html = file_get_contents($url);
				$html = $this->curlfun($url);

		   		$res = json_decode($html,1);
		   		$res = $res['data']['quotes'];


		  		if(empty($res)){
		  			continue;
		  		}



				$thisdata['Price'] = $this->fengkong($res['buy'],$v);;
		   		//$thisdata['Price'] = $res['buy'];
				$thisdata['Open'] = $res['open'];
				$thisdata['Close'] = $res['sell'];
				$thisdata['High'] = $res['top'];
				$thisdata['Low'] = $res['low'];
				$thisdata['Diff'] = 0;
				$thisdata['DiffRate'] = 0;

			}
			elseif(in_array($v['procode'],array("eos","btc","ltc","eth","xrp","dash","etc","etc","doge","shib")))
			{



				/*$url ="http://api.bitkk.com/data/v1/ticker?market=".$v['procode']."_usdt";
			
				$getdata = $this->curlfun($url);
				$res = json_decode($getdata,1);

				$data_arr=$res['ticker'];

				if(!is_array($data_arr)) continue;

				$thisdata['Price'] = $this->fengkong($data_arr['sell'],$v);

				$thisdata['Open'] = $data_arr['buy'];
				$thisdata['Close'] = $data_arr['last'];
				$thisdata['High'] = $data_arr['high'];
				$thisdata['Low'] = $data_arr['low'];
				$thisdata['Diff'] = 0;
				$thisdata['DiffRate'] =$data_arr['riseRate'];
                $thisdata['vol'] = $data_arr['vol'];*/
				
				$url = "https://api.huobi.pro/market/detail/merged?symbol=".$v['procode']."usdt";
				$getdata = $this->curlfun($url);
				$res = json_decode($getdata,1);

				$data_arr=$res['tick'];

				if(!is_array($data_arr)||$res['status']!='ok') continue;
				
				
				if($v['procode']== "shib"){ 
				 	
					$data_arr['close']=sprintf("%.8f",$data_arr['close']);
					$data_arr['open']=sprintf("%.8f",$data_arr['open']);
					$data_arr['high']=sprintf("%.8f",$data_arr['high']);
					$data_arr['low']=sprintf("%.8f",$data_arr['low']);
					$fk = $this->fengkong($data_arr['close'],$v);
					$thisdata['Price'] = (string)sprintf("%.8f",$fk );
					$thisdata['Open'] = $data_arr['open'];
					$thisdata['Close'] = $data_arr['close'];
					$thisdata['High'] = $data_arr['high'];
					$thisdata['Low'] = $data_arr['low'];
					$thisdata['vol'] = $data_arr['vol'];
					
					
				}else{
					$thisdata['Price'] = $this->fengkong($data_arr['close'],$v);
					$thisdata['Open'] = $data_arr['open'];
					$thisdata['Close'] = $data_arr['close'];
					$thisdata['High'] = $data_arr['high'];
					$thisdata['Low'] = $data_arr['low'];
					$thisdata['vol'] = $data_arr['vol'];
				}

				
				
				
				//获取今日开盘价
				$kurl = "https://api.huobi.pro/market/history/kline?period=1day&size=1&symbol=".$v['procode']."usdt";
				$kdata = $this->curlfun($kurl);
				$kdata = json_decode($kdata,1);
				$kdata_arr = $kdata['data']['0'];
				if(!is_array($kdata_arr)||$kdata['status']!='ok') continue;
				
				
				$thisdata['Diff'] = $data_arr['close']-$kdata_arr['open'];
				$thisdata['DiffRate'] =sprintf("%.2f",(($data_arr['close']-$kdata_arr['open'])/$kdata_arr['open'])*100);
				
			}

			elseif(in_array($v['procode'],array("92","96","35","36","37","44","51" ,"22","52","55")))
			{
				if($v['procode']==36){
					$urls = "https://api.huobi.pro/market/detail/merged?symbol=htusdt";
					$getdatas = $this->curlfun($urls);
					$ress = json_decode($getdatas,1);
	
					$data_arrs=$ress['tick'];
					 $thisdata['vol'] = $data_arrs['vol'];
				}
				
				if($v['procode']==37){
					$urls = "https://api.huobi.pro/market/detail/merged?symbol=dotusdt";
					$getdatas = $this->curlfun($urls);
					$ress = json_decode($getdatas,1);
	
					$data_arrs=$ress['tick'];
					$thisdata['vol'] = $data_arrs['vol'];
				}
				
				
				$html = Db::name('oneday')->where(array("mintime"=>$this->start_time,"type"=>$v['procode']))->find();
				$thisdata['Price'] = sprintf("%.".$v['decimal']."f",$html['close']);
				$thisdata['Open'] = sprintf("%.".$v['decimal']."f",$html['open']);
				$thisdata['Close'] =  sprintf("%.".$v['decimal']."f",$html['close']);
				$thisdata['High'] = sprintf("%.".$v['decimal']."f",$html['high']);
				$thisdata['Low'] = sprintf("%.".$v['decimal']."f",$html['low']);
				$thisdata['Diff'] = $thisdata['Close']-$thisdata['Open'];
				if($html['open']!=0){
					$thisdata['DiffRate'] =sprintf("%.2f",(($html['close']-$html['open'])/$html['open'])*100);
				}else{
					$thisdata['DiffRate'] =0;
				}
				

			}

			/*elseif(!in_array($v['procode'],array("1","2","3","4","5","6","12","13","14","90","91","92","93","94","95","96","97","98","99","100", "35","36","37","44","51" ,"22","52","55","btc","ltc","eth","xrp","dash","eos","etc","bsv")))
			{

				$url = "http://hq.sinajs.cn/rn=".$nowtime."list=".$v['procode'];
				$getdata = $this->curlfun($url);
				$data_arr = explode(',',$getdata);

				if(!is_array($data_arr) || count($data_arr) != 18) continue;
				$thisdata['Price'] = $this->fengkong($data_arr[1],$v);
				//$thisdata['Price'] = $data_arr[1];
				$thisdata['Open'] = $data_arr[5];
				$thisdata['Close'] = $data_arr[3];
				$thisdata['High'] = $data_arr[6];
				$thisdata['Low'] = $data_arr[7];
				$thisdata['Diff'] = $data_arr[12];
				$thisdata['DiffRate'] = $data_arr[4]/10000;
			}
*/


			$thisdata['Name'] = $v['ptitle'];
			$thisdata['UpdateTime'] = $nowtime;
			$thisdata['pid'] = $v['pid'];

			$thisdatas[$v['pid']] = $thisdata;
			
			//print_r($thisdatas);
			//echo "<br>";
			//$ids = db('productdata')->where('pid',$v['pid'])->update($thisdata);

		}
		cache('nowdata',$thisdatas);
	}


	/**
	 * 数据风控
	 * @author lukui  2017-06-27
	 * @param  [type] $price [description]
	 * @param  [type] $pro   [description]
	 * @return [type]        [description]
	 */
	public function fengkong($price,$pro)
	{

		$point_low = $pro['point_low'];
		$point_top = $pro['point_top'];

		$FloatLength = getFloatLength($point_top);
		$jishu_rand = pow(10,$FloatLength);

		$point_low = $point_low * $jishu_rand;
		$point_top = $point_top * $jishu_rand;
		$rand = rand($point_low,$point_top)/$jishu_rand;

		$_new_rand = rand(0,10);
		if($_new_rand % 2 == 0){
			$price = $price + $rand;
		}else{
			$price = $price - $rand;
		}
		return $price;
	}




	//curl获取数据
	public function curlfun($url, $params = array(), $method = 'GET')
	{

		$header = array();
		$opts = array(CURLOPT_TIMEOUT => 10, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false, CURLOPT_HTTPHEADER => $header);

		/* 根据请求类型设置特定参数 */
		switch (strtoupper($method)) {
			case 'GET' :
				$opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
				$opts[CURLOPT_URL] = substr($opts[CURLOPT_URL],0,-1);

				break;
			case 'POST' :
				//判断是否传输文件
				$params = http_build_query($params);
				$opts[CURLOPT_URL] = $url;
				$opts[CURLOPT_POST] = 1;
				$opts[CURLOPT_POSTFIELDS] = $params;
				break;
			default :

		}

		/* 初始化并执行curl请求 */
		$ch = curl_init();
		curl_setopt_array($ch, $opts);
		$data = curl_exec($ch);
		$error = curl_error($ch);
		curl_close($ch);

		if($error){
			$data = null;
		}

		return $data;

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



	/**
	 * 全局平仓
	 * @return [type] [description]
	 */
	public function order()
	{

		$nowtime = time();

		$kong_end = getconf('kong_end');
		$kong_end_arr = explode('-',$kong_end );
		if(count($kong_end_arr) == 2)
		{
			$s_rand = rand($kong_end_arr[0],$kong_end_arr[1]);
		}else
		{
			$s_rand = rand(6,12);
		}

		$db_order = db('order');
		$db_userinfo = db('userinfo');
		//订单列表
		$map['ostaus'] = 0;
		$map['selltime'] = array('elt',$nowtime+$s_rand );
		$map['is_timing'] = 0;
		$_orderlist = $db_order->where($map)->order('selltime asc')->limit('0,50')->select();

		$data_info = db('productinfo');

		//风控参数
		$risk = db('risk')->find();

		//此刻产品价格
		$p_map['isdelete'] = 0;
		$pro = db('productdata')->field('pid,Price')->where($p_map)->select();


		$prodata = array();

		foreach ($pro as $k => $v)
		{

			$_pro = cache('nowdata');


			if(!isset($_pro[$v['pid']]))
			{
				$prodata[$v['pid']] = $v['Price'];

				continue;
			}



			//$prodata[$v['pid']] = $this->order_type($_orderlist,$_pro[$v['pid']],$risk,$data_info);
			$isopen = ChickIsOpen($v['pid']);
			if($isopen)
			{
				//$prodata[$v['pid']] = $this->order_type($_orderlist,$v,$risk,$data_info);
				$prodata[$v['pid']] = $this->order_type($_orderlist,$_pro[$v['pid']],$risk,$data_info);

			}



		}

		//订单列表
		$map['ostaus'] = 0;
		$map['selltime'] = array('elt',$nowtime);
		$map['is_timing'] = 0;
		$orderlist = $db_order->where($map)->limit(0,50)->select();

		//exit;
		if(!$orderlist)
		{
			return false;
		}

		//循环处理订单
		$nowtime = time();
		foreach ($orderlist as $k => $v)
		{
			//此刻可平仓价位
			$sellprice = isset($prodata[$v['pid']])?$prodata[$v['pid']]:0;

			if($sellprice == 0)
			{
				continue;
			}

			//买入价
			$buyprice = $v['buyprice'];


			/*$info = db("userinfo")->where('uid',$v['uid'])->find();
			if($info['chance']>0)
			{


				$proinfo = db("productinfo")->where('pid',$v['pid'])->find();
				//根据现在的价格算出风控点
				$FloatLength = getFloatLength((float)$sellprice);


				if($FloatLength == 0){
					$FloatLength = getFloatLength($proinfo['point_top']);
				}
				$jishu_rand = pow(10,$FloatLength);
				$beishu_rand = rand(1,10);
				$data_rands = db("productinfo")->where('pid',$v['pid'])->value('rands');
				$data_randsLength = getFloatLength($data_rands);
				if($data_randsLength > 0)
				{
					$_j_rand = pow(10,$data_randsLength)*$data_rands;
					$beichushu = pow(10,$data_randsLength);
					$chushu = rand(1,$_j_rand);
					$_s_rand = $chushu/$beichushu ;
				}else{
					$_s_rand = 0;

				}
				$do_rand = $_s_rand;
				$suc_rand = rand(1,99);
				if($info['chance']>$suc_rand)
				{
					if($v['ostyle'] == 0 && $nowtime >= $v['selltime'])
					{
						$sellprice = $buyprice + $do_rand;
					}elseif($v['ostyle']==1 && $nowtime >= $v['selltime'])
					{
						$sellprice = $buyprice - $do_rand;
					}
				}
				else
				{
					if($v['ostyle'] == 0 && $nowtime >= $v['selltime'])
					{
						$sellprice = $buyprice - $do_rand;
					}elseif($v['ostyle']==1 && $nowtime >= $v['selltime'])
					{
						$sellprice = $buyprice + $do_rand;
					}
				}


			}


			if($info['uid']==4708||$info['uid']==46931)
			{


				$proinfo = db("productinfo")->where('pid',$v['pid'])->find();

				$FloatLength = getFloatLength((float)$sellprice);


				if($FloatLength == 0){
					$FloatLength = getFloatLength($proinfo['point_top']);
				}
				$jishu_rand = pow(10,$FloatLength);
				$beishu_rand = rand(1,10);
				$data_rands = db("productinfo")->where('pid',$v['pid'])->value('rands');
				$data_randsLength = getFloatLength($data_rands);
				if($data_randsLength > 0)
				{
					$_j_rand = pow(10,$data_randsLength)*$data_rands;
					$beichushu = pow(10,$data_randsLength);
					$chushu = rand(1,$_j_rand);
					$_s_rand = $chushu/$beichushu ;
				}else{
					$_s_rand = 0;

				}
				$do_rand = $_s_rand;


					if($v['ostyle'] == 0 && $nowtime >= $v['selltime'])
					{
						$sellprice = $buyprice - $do_rand;
					}elseif($v['ostyle']==1 && $nowtime >= $v['selltime'])
					{
						$sellprice = $buyprice + $do_rand;
					}




			}
			*/

			$updata['Price'] = $sellprice;
			db('productdata')->where('pid',$v['pid'])->update($updata);


			$fee = $v['fee'];
			$order_cha = round(floatval($sellprice)-floatval($buyprice),6);
			//买涨
			if($v['ostyle'] == 0 && $nowtime >= $v['selltime'])
			{

				if($order_cha > 0)
				{  //盈利
					$yingli = $v['fee']*($v['endloss']/100);
					$d_map['is_win'] = 1;


					//平仓增加用户金额
                   	$u_add = $yingli + $fee;
                   	$db_userinfo->where('uid',$v['uid'])->setInc('usermoney',$u_add);

                   	//写入日志
                   	$this->set_order_log($v,$u_add);


				}
				elseif($order_cha < 0)
				{	//亏损
					$yingli = -1*$v['fee'];
					$d_map['is_win'] = 2;
					$this->set_order_log($v,0);

				}
				else
				{		//无效
					$yingli = 0;
					$d_map['is_win'] = 3;

					//平仓增加用户金额
                   	$u_add = $fee;
                   	$db_userinfo->where('uid',$v['uid'])->setInc('usermoney',$u_add);
                   	//写入日志
                   	$this->set_order_log($v,$u_add);
				}

				//平仓处理订单
				$d_map['ostaus'] = 1;
				$d_map['sellprice'] = $sellprice;
				$d_map['ploss'] = $yingli;
				$d_map['oid'] = $v['oid'];
				db('order')->update($d_map);


			}
			elseif($v['ostyle']==1 && $nowtime >= $v['selltime'])
			{//买跌

				if($order_cha < 0)
				{  //盈利
					$yingli = $v['fee']*($v['endloss']/100);
					$d_map['is_win'] = 1;

					//平仓增加用户金额
                   	$u_add = $yingli + $fee;
                   	$db_userinfo->where('uid',$v['uid'])->setInc('usermoney',$u_add);

                   	//写入日志
                   	$this->set_order_log($v,$u_add);
				}
				elseif($order_cha > 0)
				{	//亏损
					$yingli = -1*$v['fee'];
					$d_map['is_win'] = 2;
					$this->set_order_log($v,0);

				}
				else
				{		//无效
					$yingli = 0;
					$d_map['is_win'] = 3;

					//平仓增加用户金额
                   	$u_add = $fee;
                   	$db_userinfo->where('uid',$v['uid'])->setInc('usermoney',$u_add);
                   	//写入日志
                   	$this->set_order_log($v,$u_add);
				}

				//平仓处理订单
				$d_map['ostaus'] = 1;
				$d_map['sellprice'] = $sellprice;
				$d_map['ploss'] = $yingli;
				$d_map['oid'] = $v['oid'];
				$db_order->update($d_map);

			}



		}

	}


	public function overnight(){
		$retention = getconf('retention');
		$retention = explode('|',$retention);
		$map = array(
			'ostaus'=>0,
			'is_timing'=>1
		);
		$timinglist = db('order')->where($map)->order('buytime asc')->select();
		foreach ($timinglist as $k => $v){
			$isopen = ChickIsOpen($v['pid']);
			if($isopen == 0){
				continue;
			}
			$user_info = db('userinfo')->field('usermoney,level')->where('uid',$v['uid'])->find();
			$time = getdate();
			$night_time = getdate($v['night_time']);
			if(($night_time['year'] == $time['year'] && $night_time['yday'] != $time['yday']) || ($night_time['year'] != $time['year'])){
				if($user_info['level']=='level_zero')
				{
					$gentletownship =$retention[0];
				}elseif($user_info['level']=='level_one')
				{
					$gentletownship =$retention[1];
				}elseif($user_info['level']=='level_two')
				{
					$gentletownship =$retention[2];
				}
				elseif($user_info['level']=='level_three')
				{
					$gentletownship =$retention[3];
				}
				elseif($user_info['level']=='level_four')
				{
					$gentletownship =$retention[4];
				}
				$u_fee = round($v['onumber']*$v['fee']*$gentletownship/100,2);
				if($user_info['usermoney']>=$u_fee){
					db('userinfo')->where('uid',$v['uid'])->setDec('usermoney',$u_fee);
					$user = array(
						'oid'=>$v['oid'],
						'uid'=>$v['uid']
					);
					$d_map = array(
						'oid' => $v['oid'],
						'night_time' => time()
					);
					db('order')->update($d_map);
					$this->set_order_log($user,$u_fee*(-1),4);
				}else{
					$this->settlement_order($v['pid'],$v['oid'],$v['uid'],$v['buyprice'],$v['fee'],$v['onumber'],$v['ostyle'],1);
					$money = db('user_info')->field('usermoney')->where('uid',$v['uid'])->find();
					if($money['usermoney']>=$u_fee){
						db('userinfo')->where('uid',$v['uid'])->setDec('usermoney',$u_fee);
						$user = array(
							'oid'=>$v['oid'],
							'uid'=>$v['uid']
						);
						$d_map = array(
							'oid' => $v['oid'],
							'night_time' => time()
						);
						db('order')->update($d_map);
						$this->set_order_log($user,$u_fee*(-1),4);
					}
				}
			}
		}
	}
	//产品id、订单id、用户id、入仓价、总费用、手数、方向、
	public function settlement_order($pid,$oid,$uid,$buyprice,$fee,$onumber,$ostyle,$type,$win=0,$loss=0){
		$price = '';
		$code = '';
		$price = db('productdata')->field('Price')->where("pid=".$pid)->find();
		$code = db('productinfo')->field('code,decimal,numprice,procode')->where("pid=".$pid)->find();
		if($code['decimal']>=0){
			//平仓价
			$enter = sprintf("%.".$code['decimal']."f",$price['Price']);
			//入仓价
			$flat = sprintf("%.".$code['decimal']."f",$buyprice);
			//求小数精确数值
			$point = ($enter*pow(10,$code['decimal']))-($flat*pow(10,$code['decimal']));
		}else{
			//平仓价
			$enter_arr = explode('.',$price['Price']);
			$enter = substr($enter_arr[0],0,$code['decimal']);
			//入仓价
			$flat_arr = explode('.',$buyprice);
			$flat = substr($flat_arr[0],0,$code['decimal']);
			$point = $enter - $flat;
		}
		$umoney = db('userinfo')->where("uid=".$uid)->value('usermoney');



        if($uid==46621121){
            $procode  = db('productinfo')->field('procode')->where("pid=".$pid)->find();
            if(in_array( $procode['procode'],array("92","96","35","36","37","44","51","22","52","55")))
            {

                $fengkong= file_get_contents("runtime/get/fengkong".$procode['procode'].".php");

                $is_kong = db('order')->field('is_kong')->where("oid=".$oid)->find();
                if($fengkong==0&&$is_kong['is_kong']==0){
                    if($code['decimal']>=0){
                        $allumoney = $umoney+$fee*$onumber+15;
                        $ds = $allumoney/($code['code']*$onumber);

                        if($ostyle == 0){
                            $jishujia=-1*($ds/pow(10,$code['decimal']));
                            $jishujia = $jishujia;
                        }else{

                            $jishujia=$ds/pow(10,$code['decimal']);
                            $jishujia = $jishujia;
                        }
                        file_put_contents("runtime/get/fengkong".$procode['procode'].".php",$jishujia);

                        $tijian['is_kong'] = 1;

                        $tijian['oid'] = $oid;

                        db('order')->update($tijian);

                    }
                }

            }

        }






		// $this->textlog('6666',$price);
		$range = $point*$code['code']*$onumber;
		if($type == 1){


			$user_money = $fee*$onumber;
			$d_map = array();
			if($ostyle == 0){
				//盈
				if($range>0){
					$total_money = $range+$user_money;
					$d_map['is_win'] = 1;
					db('userinfo')->where('uid',$uid)->setInc('usermoney',$total_money);
					$d_map['ploss'] = $range;
				}
				//平
				if($range == 0){
					$total_money = $user_money;
					if($total_money>0){
						db('userinfo')->where('uid',$uid)->setInc('usermoney',$total_money);
					}
					$d_map['is_win'] = 3;
					$d_map['ploss'] = 0;
				}
				//亏
				if($range<0){
					$total_money = $user_money - abs($range);
					if($total_money>0){
						db('userinfo')->where('uid',$uid)->setInc('usermoney',$total_money);
					}elseif($total_money<0){
                        db('userinfo')->where('uid',$uid)->setDec('usermoney',-1*$total_money);
                    }
					$d_map['is_win'] = 2;
					$d_map['ploss'] = $range;
				}
			}
			//买跌
			if($ostyle == 1){
				//盈
				if($range<0){
					$total_money = abs($range)+$user_money;
					$d_map['is_win'] = 1;
					db('userinfo')->where('uid',$uid)->setInc('usermoney',$total_money);
					$d_map['ploss'] = abs($range);
				}
				//平
				if($range==0){
					$total_money = $user_money;
					if($total_money>0){
						db('userinfo')->where('uid',$uid)->setInc('usermoney',$total_money);
					}
					$d_map['is_win'] = 3;
					$d_map['ploss'] = 0;
				}
				//亏
				if($range>0){
					$total_money = $user_money - $range;
					if($total_money>0){
						db('userinfo')->where('uid',$uid)->setInc('usermoney',$total_money);
					}elseif($total_money<0){
                        db('userinfo')->where('uid',$uid)->setDec('usermoney',-1*$total_money);
                    }
					$d_map['is_win'] = 2;
					$d_map['ploss'] = $range*(-1);
				}
			}
			$user_info = array();
			$user_info['oid'] = $oid;
			$user_info['uid'] = $uid;
			//平仓处理订单
			$d_map['ostaus'] = 1;
			$d_map['sellprice'] = $price['Price'];
			$d_map['oid'] = $oid;
			$d_map['selltime'] = time();
			$d_map['endloss'] = abs($range);
			db('order')->update($d_map);
			$total_money = sprintf("%.2f",$total_money);
			$this->set_order_log($user_info,$total_money,1);
		}else{
		    //系统平仓
			$total_fee = $fee*$onumber;
			$d_map = array(
				'ostaus' => 1,
				'system' => 1,
				'selltime' => time()
			);
			//买涨
			if($ostyle == 0){

			    //盈利
				if($range>0){
					$stop_win = ($total_fee+$umoney)*$win/100;

					//止盈
					if($range>=$stop_win){
						$total_money = $total_fee+$stop_win;

						$user_info = array();
						$user_info['oid'] = $oid;
						$user_info['uid'] = $uid;
						if($total_money>0){
							db('userinfo')->where('uid',$uid)->setInc('usermoney',$total_money);
						}
						//平仓处理订单
						$d_map['sellprice'] = $price['Price'];
						$d_map['ploss'] = $stop_win;
						$d_map['oid'] = $oid;
						$d_map['is_win'] = 1;
						$d_map['endloss'] = abs($stop_win);
						db('order')->update($d_map);
						$total_money = sprintf("%.2f",$total_money);
						$this->set_order_log($user_info,abs($total_money),2);
					}
				}
				//亏损
				if($range<0){
					$stop_loss = ($total_fee+$umoney)*$loss/100;

					//止损
					if(abs($range)>=$stop_loss){


                        $total_money = $total_fee-$stop_loss;

                        $user_info = array();
                        $user_info['oid'] = $oid;
                        $user_info['uid'] = $uid;
                        if($total_money>0){
                            db('userinfo')->where('uid',$uid)->setInc('usermoney',$total_money);
                        }elseif($total_money<0){
                            db('userinfo')->where('uid',$uid)->setDec('usermoney',-1*$total_money);
                        }
                        //平仓处理订单
                        $d_map['sellprice'] = $price['Price'];
                        $d_map['ploss'] = $stop_loss*(-1);
                        $d_map['oid'] = $oid;
                        $d_map['is_win'] = 2;
                        $d_map['endloss'] = abs($stop_loss);
                        db('order')->update($d_map);
                        $total_money = sprintf("%.2f",$total_money);
                        $this->set_order_log($user_info,$total_money,3);
					}
				}
			}
			//买跌
			if($ostyle == 1){
				//盈
				if($range<0){
					$stop_win = ($total_fee+$umoney)*$win/100;

					if(abs($range)>=$stop_win){
						$total_money = $total_fee+$stop_win;
						$user_info = array();
						$user_info['oid'] = $oid;
						$user_info['uid'] = $uid;
						if($total_money>0){
							db('userinfo')->where('uid',$uid)->setInc('usermoney',$total_money);
						}
						//平仓处理订单
						$d_map['sellprice'] = $price['Price'];
						$d_map['ploss'] = $stop_win;
						$d_map['oid'] = $oid;
						$d_map['is_win'] = 1;
						$d_map['endloss'] = abs($stop_win);
						db('order')->update($d_map);
						$total_money = sprintf("%.2f",$total_money);
						$this->set_order_log($user_info,abs($total_money),2);
					}
				}
				//亏
				if($range>0){
					$stop_loss = ($total_fee+$umoney)*$loss/100;

					if(abs($range)>=$stop_loss){
						$total_money = $total_fee-$stop_loss;
						$user_info = array();
						$user_info['oid'] = $oid;
						$user_info['uid'] = $uid;
						if($total_money>0){
							db('userinfo')->where('uid',$uid)->setInc('usermoney',$total_money);
						}elseif($total_money<0){
                            db('userinfo')->where('uid',$uid)->setDec('usermoney',-1*$total_money);
                        }
						//平仓处理订单
						$d_map['sellprice'] = $price['Price'];
						$d_map['ploss'] = $stop_loss*(-1);
						$d_map['oid'] = $oid;
						$d_map['is_win'] = 2;
						$d_map['endloss'] = abs($stop_loss);
						db('order')->update($d_map);
						$total_money = sprintf("%.2f",$total_money);
						$this->set_order_log($user_info,$total_money,3);
					}
				}
			}
		}
	}

	public function timing_free_order(){
		// $map['ostaus'] = 0;
		$map = array(
			'ostaus'=>0,
			'is_timing'=>1
		);
		$timing_order = db('order')->where($map)->select();
		//$this->textlog('2222',$timing_order);
		foreach ($timing_order as $k => $v){


			//$this->textlog('11111',$v);
			if($v){
				$isopen = ChickIsOpen($v['pid']);
				if($isopen == 0){
					continue;
				}
				//$this->textlog('3333',$v);
				$this->settlement_order($v['pid'],$v['oid'],$v['uid'],$v['buyprice'],$v['fee'],$v['onumber'],$v['ostyle'],2,$v['stop_win'],$v['stop_loss']);
			}
		}
	}

	public function free_order(){
		$id = input('post.id');
        $file = request()->file();
        if($file){
            exit(json_encode(array('error'=>\think\Lang::get('od_cwpzx'))));
        }
		$user_id = $_SESSION['uid'];
		$order = db('order')->where("oid=".$id)->find();
		$isopen = ChickIsOpen($order['pid']);
		if($isopen == 0){
			exit(json_encode(array('error'=>\think\Lang::get('od_xsztbnpc'))));
		}
		if($order['ostaus'] == 1){
			exit(json_encode(array('error'=>\think\Lang::get('od_gddyjs'))));
		}
		if($user_id>0 && $order['uid'] == $user_id){
			$this->settlement_order($order['pid'],$order['oid'],$order['uid'],$order['buyprice'],$order['fee'],$order['onumber'],$order['ostyle'],1);
			exit(json_encode(array('success'=>\think\Lang::get('le_pccg'))));
		}else{
			exit(json_encode(array('error'=>\think\Lang::get('od_pcsb'))));
		}
	}
	/**
	 * 写入平仓日志
	 * @author lukui  2017-07-01
	 * @param  [type] $v        [description]
	 * @param  [type] $addprice [description]
	 */
	public function set_order_log($v,$addprice,$type=0)
	{
		$o_log['uid'] = $v['uid'];
       	$o_log['oid'] = $v['oid'];
       	$o_log['addprice'] = $addprice;
       	$o_log['addpoint'] = 0;
       	$o_log['time'] = time();
       	$o_log['user_money'] = db('userinfo')->where('uid',$v['uid'])->value('usermoney');
       	db('order_log')->insert($o_log);


       	//资金日志
       	if($type == 4){
       		$des = \think\Lang::get('ai_lcf');
       	}else{
       		$des = \think\Lang::get('le_pc');
       	}
       	if($type == 1){
       		$info = \think\Lang::get('le_hyjyptjs');
       	}elseif($type == 2){
       		$info = \think\Lang::get('ai_hyjyzypcjs');
       	}elseif($type == 3){
       		$info = \think\Lang::get('ai_hyjyzspcjs');
       	}elseif($type == 4){
       		$info = \think\Lang::get('ai_ddlcf');
       	}else{
       		$info = \think\Lang::get('ai_mhyjs');
       	}

       	set_price_log($v['uid'],1,$addprice,$des,$info,$v['oid'],$o_log['user_money']);
	}


	/**
	 * 订单类型
	 * @param  [type] $orders [description]
	 * @return [type]         [description]
	 */
	public function order_type($orders,$pro,$risk,$data_info)
	{


		$_prcie = $pro['Price'];

		$pid = $pro['pid'];
		$thispro = array();		//买此产品的用户


		//此产品购买人数
		$price_num = 0;
		//买涨金额，计算过盈亏比例以后的
		$up_price = 0;
		//买跌金额，计算过盈亏比例以后的
		$down_price = 0;
		//买入最低价
		$min_buyprice = 0;
		//买入最高价
		$max_buyprice = 0;
		//下单最大金额
		$max_fee = 0;
		//指定客户亏损
		$to_win = explode('|',$risk['to_win']);
		$to_win = array_filter(array_merge($to_win,$this->user_win));
		$is_to_win = array();
		//指定客户亏损
		$to_loss = explode('|',$risk['to_loss']);
		$to_loss = array_filter(array_merge($to_loss,$this->user_loss));
		$is_to_loss = array();

		$i = 0;

		foreach ($orders as $k => $v)
		{

			if($v['pid'] == $pid )
			{
				//没炒过最小风控值直接退出price
				if ($v['fee'] < $risk['min_price'])
				{
					//return $pro['Price'];
				}
				$i++;

				//单控 赢利
				if($v['kong_type'] == '1' || $v['kong_type'] == '3')
				{
					$dankong_ying = $v;
					break;
				}


				//单控 亏损
				if($v['kong_type'] == '2')
				{

					$dankong_kui = $v;
					break;
				}


				$info = db("userinfo")->where('uid',$v['uid'])->find();
                if($info['chance'] > 0)
                {
                    if($info['chance'] > mt_rand(1,99))
                    {
                        $dankong_ying = $v;
                        break;
                    }else{
                        $dankong_kui = $v;
                        break;
                    }
                }


				//dump($v['kong_type']);
				//是否存在指定盈利
				if(in_array($v['uid'], $to_win))
				{
					$is_to_win = $v;
					break;

				}
				//是否存在指定亏损
				if(in_array($v['uid'], $to_loss))
				{
					$is_to_loss = $v;
					break;

				}

				//总下单人数
				$price_num++;
				//买涨买跌累加
				if($v['ostyle'] == 0)
				{
					$up_price += $v['fee']*$v['endloss']/100;
				}
				else
				{
					$down_price += $v['fee']*$v['endloss']/100;
				}
				//统计最大买入价与最大下单价
				if($i == 1)
				{
					$min_buyprice = $v['buyprice'];
					$max_buyprice = $v['buyprice'];
					$max_fee = $v['fee'];
				}
				else
				{
					if($min_buyprice > $v['buyprice'])
					{
						$min_buyprice = $v['buyprice'];

					}
					if($max_buyprice < $v['buyprice'])
					{
						$max_buyprice = $v['buyprice'];
					}
					if($max_fee < $v['fee']){
						$max_fee = $v['fee'];
					}
				}
			}

		}

		// if(isset($orders[0]) && isset($max_buyprice)){
		// 	if($orders[0]['buyprice'] > $max_buyprice){
		// 		$max_buyprice = $orders[0]['buyprice'];
		// 	}
		// }
		// if(isset($orders[0]) && isset($min_buyprice)){
		// 	if($orders[0]['buyprice'] < $min_buyprice){
		// 		$min_buyprice = $orders[0]['buyprice'];
		// 	}
		// }



		// if( $pid == 12){


		// dump('$pid:'.$pid);
		// dump('$price_num:'.$price_num);
		// dump('$up_price:'.$up_price);
		// dump('$down_price:'.$down_price);
		// dump('$min_buyprice:'.$min_buyprice);
		// dump('$max_buyprice:'.$max_buyprice);
		// dump('$max_fee:'.$max_fee);

		// }
		$proinfo = $data_info->where('pid',$pro['pid'])->find();
		//根据现在的价格算出风控点
		$FloatLength = getFloatLength((float)$pro['Price']);

		if($FloatLength == 0){
			$FloatLength = getFloatLength($proinfo['point_top']);
		}

		//是否存在指定盈利
		$is_do_price = 0; 	//是否已经操作了价格

		$jishu_rand = pow(10,$FloatLength);
		$beishu_rand = rand(1,10);

		$data_rands = $data_info->where('pid',$pro['pid'])->value('rands');

		$data_randsLength = getFloatLength($data_rands);
		if($data_randsLength > 0){
			$_j_rand = pow(10,$data_randsLength)*$data_rands;
			$_s_rand = rand(1,$_j_rand)/pow(10,$data_randsLength);

		}else{
			$_s_rand = 0;

		}


		$do_rand = $_s_rand;

		//if($pro['pid'] == 12) dump($do_rand);




		//先考虑单控
		if(!empty($dankong_ying) && $is_do_price == 0){ 		//单控 1赢利
			if($dankong_ying['ostyle'] == 0 ){
				$pro['Price'] = $v['buyprice'] + $do_rand;
			}elseif($dankong_ying['ostyle'] == 1 ){
				$pro['Price'] = $v['buyprice'] - $do_rand;
			}
			$is_do_price = 1;
			//echo 1;
		}

		if(!empty($dankong_kui) && $is_do_price == 0){ 		//单控 2亏损
			if($dankong_kui['ostyle'] == 0  ){
				$pro['Price'] = $v['buyprice'] - $do_rand;
			}elseif($dankong_kui['ostyle'] == 1 ){
				$pro['Price'] = $v['buyprice'] + $do_rand;
			}

			//echo 2;
			$is_do_price = 1;
		}

		//指定客户赢利
		if(!empty($is_to_win) && $is_do_price == 0){

			if($is_to_win['ostyle'] == 0 ){
				$pro['Price'] = $v['buyprice'] + $do_rand;
			}elseif($is_to_win['ostyle'] == 1 ){
				$pro['Price'] = $v['buyprice'] - $do_rand;
			}
			$is_do_price = 1;
			////echo 1;
			//echo 3;

		}
		//是否存在指定亏损
		if(!empty($is_to_loss) && $is_do_price == 0){


			if($is_to_loss['ostyle'] == 0 ){
				$pro['Price'] = $v['buyprice'] - $do_rand;
			}elseif($is_to_loss['ostyle'] == 1 ){
				$pro['Price'] = $v['buyprice'] + $do_rand;
			}
			$is_do_price = 1;
			//echo 4;
		}
		//没有任何下单记录
		if($up_price == 0 && $down_price == 0 && $is_do_price == 0){
			$is_do_price = 2;
			//return $pro['Price'];
		}

		//只有一个人下单，或者所有人下单买的方向相同
		if(( ($up_price == 0 && $down_price != 0) || ($up_price != 0 && $down_price == 0) )  && $is_do_price == 0 ){

			//风控参数
			$chance = $risk["chance"];
			$chance_1 = explode('|',$chance);
			$chance_1 = array_filter($chance_1);
			//循环风控参数
			if(count($chance_1) >= 1){
				foreach ($chance_1 as $key => $value) {
					//切割风控参数
					$arr_1 = explode(":",$value);
					$arr_2 = explode("-",$arr_1[0]);
					//比较最大买入价格
					if($max_fee >= $arr_2[0] && $max_fee < $arr_2[1]){
						//得出风控百分比
						if(!isset($arr_1[1])){
							$chance_num = 30;
						}else{
							$chance_num = $arr_1[1];
						}

						$_rand = rand(1,100);
						continue;

					}

				}
			}




			//买涨
			if(isset($_rand) && $up_price != 0){

				if($_rand > $chance_num){	//客损
					$pro['Price'] = $min_buyprice-$do_rand;

					// if( abs($pro['Price'] - $_prcie) > $proinfo['point_top']){
					// 	$pro['Price'] = $_prcie - ($proinfo['point_top'] + rand(100,999)/1000);
					// }

					$is_do_price = 1;
					//echo 5;
				}else{		//客赢
					$pro['Price'] = $max_buyprice+$do_rand;
					// if( abs($pro['Price'] - $_prcie) > $proinfo['point_top']){
					// 	$pro['Price'] = $_prcie + ($proinfo['point_top'] + rand(100,999)/1000);
					// }
					$is_do_price = 1;
					//echo 6;
				}

			}

			if(isset($_rand) && $down_price != 0){

				if($_rand > $chance_num){	//客损
					$pro['Price'] = $max_buyprice+$do_rand;
					// if( abs($pro['Price'] - $_prcie) > $proinfo['point_top']){
					// 	$pro['Price'] = $_prcie + ($proinfo['point_top'] + rand(100,999)/1000);
					// }
					$is_do_price = 1;
					//echo 7;
				}else{		//客赢
					$pro['Price'] = $min_buyprice-$do_rand;
					// if( abs($pro['Price'] - $_prcie) > $proinfo['point_top']){
					// 	$pro['Price'] = $_prcie - ($proinfo['point_top'] + rand(100,999)/1000);
					// }
					$is_do_price = 1;
					//echo 8;
				}

			}



		}


		//多个人下单，并且所有人下单买的方向不相同
		if($up_price != 0 && $down_price != 0  && $is_do_price == 0){

			//买涨大于买跌的
			if ($up_price > $down_price) {
				$pro['Price'] = $min_buyprice-$do_rand;
				// if( abs($pro['Price'] - $_prcie) > $proinfo['point_top']){
				// 	$pro['Price'] = $_prcie - ($proinfo['point_top'] + rand(100,999)/1000);
				// }
				$is_do_price = 1;
				//echo 9;

			}
			//买涨小于买跌的
			if ($up_price < $down_price) {
				$pro['Price'] = $max_buyprice+$do_rand;
				// if( abs($pro['Price'] - $_prcie) > $proinfo['point_top']){
				// 	$pro['Price'] = $_prcie + ($proinfo['point_top'] + rand(100,999)/1000);
				// }
				$is_do_price = 1;
				//echo 10;
			}
			if ($up_price == $down_price) {
				$is_do_price = 2;
			}



		}



		if($is_do_price == 2 || $is_do_price == 0){
			if($pid == 60){
				
				$pro['Price'] = sprintf("%.8f",$this->fengkong($pro['Price'],$proinfo));
			}else{
				$pro['Price'] = $this->fengkong($pro['Price'],$proinfo);
			}
			
		}
		//if( $pid == 12) dump($pro['Price']);

		db('productdata')->where('pid',$pro['pid'])->update($pro);

		//存储k线值
		$k_map['pid'] = $pro['pid'];
		$k_map['ktime'] = $this->minute;

		/* 此处多余--
		$issetkline = $this->klinedata->where($k_map)->find();

		if($issetkline){
			$nk_map['id'] = $issetkline['id'];
			if($issetkline['updata'] < $pro['Price']){
				$nk_map['updata'] = $pro['Price'];

			}
			if($issetkline['downdata'] > $pro['Price']){
				$nk_map['downdata'] = $pro['Price'];

			}
			$nk_map['closdata'] = $pro['Price'];
			$this->klinedata->update($nk_map);
		}else{
			$k_map['updata'] = $pro['Price'];
			$k_map['downdata'] = $pro['Price'];
			$k_map['opendata'] = $pro['Price'];
			$this->klinedata->insert($k_map);
		}




		if($pro['Price'] < $pro['Low']){
			$pro['Price'] = $pro['Low'];
		}
		if($pro['Price'] > $pro['High']){
			$pro['Price'] = $pro['High'];
		}
		*/
		return $pro['Price'];


	}



	/**
	 * 获取K线数据
	 * @author lukui  2017-07-01
	 * @return [type] [description]
	 */
	public function getkdata($pid=null,$num=null,$interval=null,$isres=null)
	{
		$pid = empty($pid)?input('param.pid'):$pid; //如果$pid为空input('param.pid')否则$pid=$pid
		$num = empty($num)?input('param.num'):$num;
		$num = empty($num)?80:$num;
		$pro = GetProData($pid);
		$all_data = array();

		if(!$pro){
			exit;
		}

		$interval = empty($interval)?input('param.interval'):$interval;
		$interval = input('param.interval') ? input('param.interval') : 1;
		$nowtime = time().rand(100,999);

		$klength = $interval*60*$num;

		if($klength == 'd') $klength = 1*60*24*$num;
		$k_map['pid'] = $pid;
		$k_map['ktime'] = array('between',array( ($this->nowtime - $klength),$this->nowtime ) );

		//比特币莱特币
		if(in_array($pro['procode'],array("etc","xrp","btc","ltc","eth","dash","eos","doge","shib")))
		{
			switch ($interval)
			{
				case '1':
					$datalen = '1min';
					break;
				case '5':
					$datalen = '5min';
					break;
				case '15':
					$datalen ='15min';
					break;
				case '30':
					$datalen ='30min';
					break;
				case '60':
					$datalen = '60min';
					break;
				case 'd':
					$datalen = '1day';
					break;

				default:
					exit;
					break;
			}


			$geturl ="https://api.huobi.pro/market/history/kline?period=".$datalen."&size=".$num."&symbol=".$pro['procode']."usdt";

			$html = $this->curlfun($geturl);
			$html = json_decode($html,true);


			$_data_arr = $html['data'];
			$_data_arr =array_reverse($_data_arr);

			foreach ($_data_arr as $k => $v)
			{
				
				$_son_arr =$v;
				
				$_time = $_son_arr['id'];
				
				$_h = $_son_arr['high'];
				$_l = $_son_arr['low'];
				$_o = $_son_arr['open'];
				$_c = $_son_arr['close'];
				
				$res_arr[] = array($_time,$_o,$_c,$_h,$_l);

			}
			
			/*$geturl ="http://api.zb.live/data/v1/kline?market=".$pro['procode']."_usdt&type=".$datalen."&size=".$num;
			
			

			$html = $this->curlfun($geturl);
			$html = json_decode($html,true);


			$_data_arr = $html['data'];


			foreach ($_data_arr as $k => $v)
			{
				
				$_son_arr =$v;
				
				$_time = $_son_arr[0]/1000;
				if(in_array($interval,array(1,5)) && isset($_kline[$_time]))
				{
					$_h = $_kline[$_time]['updata'];
					$_l = $_kline[$_time]['downdata'];
					$_o = $_kline[$_time]['opendata'];
					$_c = $_kline[$_time]['closdata'];
				}
				else
				{
					$_h = str_replace('"', '', $_son_arr[2]);
					$_l = str_replace('"', '', $_son_arr[3]);
					$_o = str_replace('"', '', $_son_arr[1]);
					$_c = str_replace('"', '', $_son_arr[4]);
				}
				$res_arr[] = array($_time,$_o,$_c,$_h,$_l);

			}*/

		}

		elseif(in_array($pro['procode'],array("92","96", "35","36","37","44","51" ,"22","52","55")))
		{

			if($interval == 1) $table ="min1msg";
			if($interval == 5) $table ="min5msg";
			if($interval == 15) $table ="min15msg";
			if($interval == 30) $table ="min30msg";
			if($interval == 60) $table ="min60msg";
			if($interval == 'd') $table ="oneday";

			$_data_arr = Db::name($table)->where(array('type'=>$pro['procode']))->limit($num)->order('id desc')->select();
			$_data_arr = array_reverse($_data_arr);
			foreach ($_data_arr as $k => $v)
			{

				$_time = $v['mintime'];

				$_h = $v['high'];
				$_l = $v['low'];
				$_o = $v['open'];
				$_c = $v['close'];
				$res_arr[] = array($_time,$_o,$_c,$_h,$_l);

			}

		}


		//外汇产品
		/*elseif(!in_array($pro['procode'],array("etc","dash","eos","xrp","btc","ltc","eth","1","2","3","4","5","6","12","13","14","90","91","92","93","94","95","96","97","98","99","100", "35","36","37","44","51" ,"22","52","55"))){

			switch ($interval) {
				case '1':
					$datalen = 1440;
					break;
				case '5':
					$datalen = 1440;
					break;
				case '15':
					$datalen = 480;
					break;
				case '30':
					$datalen = 240;
					break;
				case '60':
					$datalen = 120;
					break;
				case 'd':
					break;
				default:
					exit;
					break;
			}




	            $year = date('Y_n_j',time());

				if($interval == 'd'){
					$geturl = "http://vip.stock.finance.sina.com.cn/forex/api/jsonp.php/var%20_".$pro['procode']."$year=/NewForexService.getDayKLine?symbol=".$pro['procode']."&_=$year";
				}else{
					$geturl = "http://vip.stock.finance.sina.com.cn/forex/api/jsonp.php/var%20_".$pro['procode']."_".$interval."_$nowtime=/NewForexService.getMinKline?symbol=".$pro['procode']."&scale=".$interval."&datalen=".$datalen;
				}



			$html = $this->curlfun($geturl);



			if($interval == 'd'){
				$_arr = explode('("',$html);
				if(!isset($_arr[1])){
					return;
				}
				$_str = substr($_arr[1],1,-4);
				$_data_arr = explode(',|',$_str);

			}else{
				$_arr = explode('[',$html);
				if(!isset($_arr[1])){
					return;
				}
				$_str = substr($_arr[1],1,-3);
				$_data_arr = explode('},{',$_str);
			}
			$_count = count($_data_arr);

			$_data_arr = array_slice($_data_arr,$_count-$num,$_count);



			foreach ($_data_arr as $k => $v) {

				$_son_arr = explode(',', $v);

				if($interval == 'd'){


					$res_arr[] = array(
										strtotime($_son_arr['0']),
										$_son_arr[1],
										$_son_arr[4],
										$_son_arr[2],
										$_son_arr[3],
									);
									// print_r($res_arr);exit;
				}else{


						$_time = strtotime(substr($_son_arr['0'],5,-1));

						if(in_array($interval,array(1,5)) && isset($_kline[$_time])){
							$_h = $_kline[$_time]['updata'];
							$_l = $_kline[$_time]['downdata'];
							$_o = $_kline[$_time]['opendata'];
							$_c = $_kline[$_time]['closdata'];
						}else{

							$_h = substr($_son_arr[3],5,-1);
							$_l = substr($_son_arr[2],5,-1);
							$_o = substr($_son_arr[1],5,-1);
							$_c = substr($_son_arr[4],5,-1);
						}
						$res_arr[] = array($_time,$_o,$_c,$_h,$_l);


				}
			}


	    }*/
	    elseif(in_array($pro['procode'],array("1","2","3","4","5","6","12","13","14","90","91","93","94","95","97","98","99","100"))){


			if($interval == 1) $interval =1;
			if($interval == 5) $interval =2;
			if($interval == 15) $interval =3;
			if($interval == 30) $interval =4;
			if($interval == 60) $interval =5;
			if($interval == 'd') $interval =6;

			$geturl = 'https://m.sojex.net/api.do?rtp=CandleStick&type='.$interval.'&qid='.$pro['procode'];

			$html = $this->curlfun($geturl);



			$_arr = explode('[{',$html);
			if(!isset($_arr[1])){
				return;
			}

			if(!empty($_arr[1])){
				$array = explode('}]',$_arr[1]);
			}

			// $_str = substr($_arr[1],1,-3);

			$_data_arr = explode('},{',$array[0]);
			$_count = count($_data_arr);
			$_data_arr = array_slice($_data_arr,$_count-$num,$_count);



			foreach ($_data_arr as $k => $v) {

				$_son_arr = explode(',', $v);


				if($interval == 6){
					$tm = explode(':',$_son_arr[7]);

					 $_ktime =  substr($tm[1],1,-1).' 00:00:00';


				}else{

				$_ktime = '2020-'.substr($_son_arr[7],5,-1);


				}

				$_h_arr = explode(':',$_son_arr[1]);
				$_l_arr = explode(':',$_son_arr[2]);
				$_o_arr = explode(':',$_son_arr[0]);
				$_c_arr = explode(':',$_son_arr[3]);

				$_h = substr($_h_arr[1],1,-1);
				$_l = substr($_l_arr[1],1,-1);
				$_o = substr($_o_arr[1],1,-1);
				$_c = substr($_c_arr[1],1,-1);

				$res_arr[] = array(
								strtotime($_ktime),
								$_o,
								$_c,
								$_l,
								$_h,

							);


			}

		}

		if($pro['Price'] < $res_arr[$num-1][1]){
			$_state = 'down';
		}else{
			$_state = 'up';
		}
		$all_data['topdata'] = array(
										'topdata'=>$pro['UpdateTime'],
										'now'=>$pro['Price'],
										'open'=>$pro['Open'],
										'lowest'=>$pro['Low'],
										'highest'=>$pro['High'],
										'close'=>$pro['Close'],
										'state'=>$_state
									);

		$all_data['items'] = $res_arr;


		//$this->textlog('55555',$all_data);
		return(json_encode(base64_encode(json_encode($all_data))));

	}
	//test web data
	public function setusers()
	{
		test_web();
	}



	public function getprodata()
	{
		$pid = input('param.pid');

		$pro = GetProData($pid);


		if(!$pro){
			exit;
		}

		$topdata = array(
						'topdata'=>$pro['UpdateTime'],
						'now'=>$pro['Price'],
						'open'=>$pro['Open'],
						'lowest'=>$pro['Low'],
						'highest'=>$pro['High'],
						'close'=>$pro['Close']

					);

		exit(json_encode(base64_encode(json_encode($topdata))));
	}




	/**
	 * 分配订单
	 * @return [type] [description]
	 */
	public function allotorder()
	{
		//查找以平仓未分配的订单  isshow字段
		$map['isshow'] = 0;
		$map['ostaus'] = 1;
		$map['selltime'] = array('<',time()-60);
		$list = db('order')->where($map)->limit(0,10)->select();

		if(!$list){
			return false;
		}

		foreach ($list as $k => $v) {
			//分配金额
			$this->allotfee($v['uid'],$v['fee'],$v['is_win'],$v['oid'],$v['ploss'],$v['sx_fee']);
			//更改订单状态
			db('order')->where('oid',$v['oid'])->update(array('isshow'=>1));

		}
		//dump($list);
	}

	//用户id，下单金额，输赢，订单id，盈亏

	public function allotfee($uid,$fee,$is_win,$order_id,$ploss,$sx_fee)
	{
		$userinfo = db('userinfo');
		$allot = db('allot');
		$nowtime = time();

		$user = $userinfo->field('uid,oid')->where('uid',$uid)->find();
		$myoids = myupoid($user['oid']);



		if(!$myoids){
			return;
		}

		//红利
		$_fee = 0;
		//佣金
		$_feerebate = 0;
		//手续费
		$web_poundage = getconf('web_poundage');
		//分配金额
		if($is_win == 1){
			$pay_fee = $ploss;
		}elseif($is_win == 2){
			$pay_fee = abs($ploss);
		}else{
			//20170801 edit
			$pay_fee = 0;
		}

		foreach ($myoids as $k => $v) {

			if($user['oid'] == $v['uid']){	//直接推荐者拿自己设置的比例
			//print_r("4545");exit;

				$_fee = round($pay_fee * ($v["rebate"]/100),2);
				$_feerebate = round($sx_fee * ($v["feerebate"]/100),2);
				echo $_feerebate;

			}else{		//他上级比例=本级-下级比例
				//print_r("1111");exit;
				$_my_rebate = ($v["rebate"] - $myoids[$k-1]["rebate"]);

				if($_my_rebate < 0) $_my_rebate = 0;
				$_fee = round($pay_fee * ( $_my_rebate /100),2);

				$_my_feerebate = ($v["feerebate"]  - $myoids[$k-1]["feerebate"] );
				if($_my_feerebate < 0) $_my_feerebate = 0;
				$_feerebate = round($sx_fee * ( $_my_feerebate /100),2);


			}


			//红利
			if($is_win == 1){	//客户盈利代理亏损
				if($_fee != 0){
					$ids_fee = $userinfo->where('uid',$v['uid'])->setDec('usermoney', $_fee);
				}else{
					$ids_fee = null;
				}

				$type = 2;
				$_fee = $_fee*-1;
			}elseif($is_win == 2){	//客户亏损代理盈利
				if($_fee != 0){
					$ids_fee = $userinfo->where('uid',$v['uid'])->setInc('usermoney', $_fee);
				}else{
					$ids_fee = null;
				}

				$type = 1;
			}elseif($is_win == 3){	//无效订单不做操作
				$ids_fee = null;
			}

			if($ids_fee){
				//余额
				$nowmoney = $userinfo->where('uid',$v['uid'])->value('usermoney');
				set_price_log($v['uid'],$type,$_fee,\think\Lang::get('od_dc'),\think\Lang::get('od_xxkhdc'),$order_id,$nowmoney);

			}

			//手续费
			if($_feerebate != 0){
				$ids_feerebate = $userinfo->where('uid',$v['uid'])->setInc('usermoney', $_feerebate);
			}else{
				$ids_feerebate = null;
			}

			if($ids_feerebate){
				//余额
				$nowmoney = $userinfo->where('uid',$v['uid'])->value('usermoney');
				set_price_log($v['uid'],1,$_feerebate,\think\Lang::get('as_khsxf'),\think\Lang::get('od_xxkhxdsxf'),$order_id,$nowmoney);

			}

		}

		/*

		foreach ($myoids as $k => $v) {
			//分红利
			if($_fee <= 0){
				continue;
			}

			if($v['rebate'] <= 0 || $v['rebate'] > 100){
				continue;
			}

			//分给我的钱
			$my_fee = round($_fee*(100-$v['rebate'])/100,2);

			if($my_fee <= 0.01){
				continue;
			}


			if($is_win == 1){	//客户盈利代理亏损
				$ids = $userinfo->where('uid',$v['uid'])->setDec('usermoney', $my_fee);
				$type = 2;
				$my_fee = $my_fee*-1;
			}elseif($is_win == 2){	//客户亏损代理盈利

				$ids = $userinfo->where('uid',$v['uid'])->setInc('usermoney', $my_fee);
				$type = 1;
			}elseif($is_win == 3){	//无效订单不做操作
				$ids = null;
			}
			//余额
			$nowmoney = $userinfo->where('uid',$v['uid'])->value('usermoney');

			if($ids){
				$_data['is_win'] = $is_win;
				$_data['time'] = $nowtime;
				$_data['uid'] = $v['uid'];
				$_data['order_id'] = $order_id;
				$_data['my_fee'] = $my_fee;
				$_data['nowmoney'] = $nowmoney;
				$_data['type'] = 1;
				$allot->insert($_data);

				set_price_log($v['uid'],$type,$my_fee,'对冲','下线客户平仓对冲',$order_id,$nowmoney);
			}

			$_fee = round($_fee*$v['rebate']/100,2);


		}

		//分佣金
		foreach ($myoids as $k => $v) {


			if($yj_fee <= 0){
				continue;
			}

			if($v['feerebate'] <= 0 || $v['feerebate'] > 100){
				continue;
			}

			//分给我的钱
			$my_fee = round($yj_fee*(100-$v['feerebate'])/100,2);

			if($my_fee <= 0.01){
				continue;
			}

			//余额
			$nowmoney = $userinfo->where('uid',$v['uid'])->value('usermoney');
			if($is_win == 1 || $is_win == 2){	//有效订单
				$ids = $userinfo->where('uid',$v['uid'])->setInc('usermoney', $my_fee);
				$type = 1;
			}else{
				$ids = null;
			}
			if($ids){
				$_data['is_win'] = $is_win;
				$_data['time'] = $nowtime;
				$_data['uid'] = $v['uid'];
				$_data['order_id'] = $order_id;
				$_data['my_fee'] = $my_fee;
				$_data['nowmoney'] = $nowmoney;
				$_data['type'] = 2;
				$allot->insert($_data);

				set_price_log($v['uid'],$type,$my_fee,'客户手续费','下线客户下单手续费',$order_id,$nowmoney);
			}

			$yj_fee = round($yj_fee*$v['feerebate']/100,2);


		}
		*/

	}



	/**
	 * 获取K线。缓存起来
	 * @author lukui  2017-08-13
	 * @return [type] [description]
	 */
	public function cachekline()
	{

		$pro = db('productinfo')->field('pid')->where('isdelete',0)->select();
		$kline = cache('cache_kline');
		foreach ($pro as $k => $v) {

			$res[$v['pid']][1] = $this->getkdata($v['pid'],60,1,1);
			if(!$res[$v['pid']][1]) $res[$v['pid']][1] = $kline[$v['pid']][1] ;
			$res[$v['pid']][5] = $this->getkdata($v['pid'],60,5,1);
			if(!$res[$v['pid']][5]) $res[$v['pid']][5] = $kline[$v['pid']][5] ;
			$res[$v['pid']][15] = $this->getkdata($v['pid'],60,15,1);
			if(!$res[$v['pid']][15]) $res[$v['pid']][15] = $kline[$v['pid']][15] ;
			$res[$v['pid']][30] = $this->getkdata($v['pid'],60,30,1);
			if(!$res[$v['pid']][30]) $res[$v['pid']][30] = $kline[$v['pid']][30] ;
			$res[$v['pid']][60] = $this->getkdata($v['pid'],60,60,1);
			if(!$res[$v['pid']][60]) $res[$v['pid']][60] = $kline[$v['pid']][60] ;
			$res[$v['pid']]['d'] = $this->getkdata($v['pid'],60,'d',1);
			if(!$res[$v['pid']]['d']) $res[$v['pid']]['d'] = $kline[$v['pid']]['d'] ;
		}



		cache('cache_kline',$res);

	}

	function getkline(){

		$kline = cache('cache_kline');
		$pid = input('pid');
		$interval = input('interval');

		if(!$interval || !$pid){
			return false;
		}

		$info = json_decode($kline[$pid][$interval],1);

		return exit(json_encode($info));;

	}





	public function checkbal(){
		$lttime = $this->nowtime-10*60;
		$map['bptime'] = array('lt',$lttime);
		$map['pay_type'] = array('in',array('ysy_alwap','ysy_wxwap'));
		$map['bptype'] = 3;
		$db_balance = db('balance');
		$list = $db_balance->where($map)->select();

		if(!$list) return false;

		foreach($list as $key=>$val){

			$miyao="86cf593f909d80d6495b671b489f170c";
			$mchntid = '308231373720001';
			$inscd = '93081888';

				$data = array();
				$qxdata = array();
				$data['version'] = "2.2";
				$data['signType'] = 'SHA256';
				$data['charset'] = 'utf-8';
				$data['origOrderNum'] = $val['balance_sn'];
				$data['busicd'] = 'INQY';
				//$data['respcd'] = '00';
				$data['inscd'] = $inscd;
				$data['mchntid'] = $mchntid;
				$data['terminalid'] = $inscd;
				$data['txndir'] = 'Q';
				ksort($data);
				$str = '';
				foreach($data as $k=>$v){
					if($str!=''){
						$str .= '&';
					}
					$str .= $k.'='.$v;
				}
				$str.= $miyao;
				$sign=hash("sha256", $str);
				$data['sign'] = $sign;
				$data=json_encode($data);
				$pc = json_decode($this->post_curl('https://showmoney.cn/scanpay/unified',$data),true);


				if($pc['errorDetail']==\think\Lang::get('as_dmjzf')){

					$qxdata['busicd'] = 'CANC';
					$qxdata['charset'] = 'utf-8';
					$qxdata['inscd'] = $inscd;
					$qxdata['mchntid'] = $mchntid;
					$qxdata['orderNum'] = time().rand(1000,9999);
					$qxdata['origOrderNum'] = $val['balance_sn'];
					$qxdata['signType'] = 'SHA256';
					$qxdata['terminalid'] = $inscd;
					$qxdata['txndir'] = 'Q';
					$qxdata['version'] = '2.2';
					ksort($qxdata);
					$str = '';
					foreach($qxdata as $k=>$v){
						if($str!=''){
							$str .= '&';
						}
						$str .= $k.'='.$v;
					}
					$str.= $miyao;
					$qxdata['sign'] = hash("sha256", $str);
					$qpc = json_decode($this->post_curl('https://showmoney.cn/scanpay/unified',json_encode($qxdata)),true);




				}elseif($pc['errorDetail']==\think\Lang::get('as_cg')){

				}elseif($pc['errorDetail']==\think\Lang::get('as_ddbcz')){

				}

				$_map['bpid'] = $val['bpid'];
				$_map['bptype'] = 4;
				$db_balance->update($_map);

		}


	}

	public function post_curl($url,$data){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			print curl_error($ch);
		}
		curl_close($ch);
		return $result;
	}




}


 ?>
