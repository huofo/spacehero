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
		$this->user_win = array();//指定客户赢利
		$this->user_loss = array();//指定客户亏损
		//K线数据库
		$this->klinedata = db('klinedata');
	}

	public function getdate()
	{

		//die();

		//产品列表
		$pro = db('productinfo')->where('isdelete',0)->select();
		//dump($pro);
		if(!isset($pro)) return false;

		$nowtime = time();
		$_rand = rand(1,900)/100000;
		$thisdatas = array();

		foreach ($pro as $k => $v)
		{
		    $thisdata=array();
			
			//验证休市
			$isopen = ChickIsOpen($v['pid']);
			if(!$isopen)
			{
				continue;
			}
			if($v['is_fb']==0)
			{

				$url = "https://api.huobi.pro/market/detail/merged?symbol=".$v['procode'];
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
				$kurl = "https://api.huobi.pro/market/history/kline?period=1day&size=1&symbol=".$v['procode'];
				$kdata = $this->curlfun($kurl);
				$kdata = json_decode($kdata,1);
				$kdata_arr = $kdata['data']['0'];
				if(!is_array($kdata_arr)||$kdata['status']!='ok') continue;
				
				
				$thisdata['Diff'] = $data_arr['close']-$kdata_arr['open'];
				$thisdata['DiffRate'] =sprintf("%.2f",(($data_arr['close']-$kdata_arr['open'])/$kdata_arr['open'])*100);
				
			}

			else
			{
				if($v['procode']==36){
					$urls = "https://api.huobi.pro/market/detail/merged?symbol=htusdt";
					$getdatas = $this->curlfun($urls);
					$ress = json_decode($getdatas,1);
	
					$data_arrs=$ress['tick'];
					 $thisdata['vol'] = $data_arrs['vol'];
				}
				
				else if($v['procode']==37){
					$urls = "https://api.huobi.pro/market/detail/merged?symbol=dotusdt";
					$getdatas = $this->curlfun($urls);
					$ress = json_decode($getdatas,1);
	
					$data_arrs=$ress['tick'];
					$thisdata['vol'] = $data_arrs['vol'];
				}else{
				    $urls = "https://api.huobi.pro/market/detail/merged?symbol=".$v['procode'];
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

			$thisdata['Name'] = $v['ptitle'];
			$thisdata['UpdateTime'] = $nowtime;
			$thisdata['pid'] = $v['pid'];

			$thisdatas[$v['pid']] = $thisdata;

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
	/*public function fengkong($price,$pro)
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
		
	}*/
	
	public function fengkong($price,$pro)
	{
		
		$point_low = $pro['point_low'];
		$point_top = $pro['point_top'];
		
		$FloatLength = getFloatLength($point_top);
		$jishu_rand = pow(10,$FloatLength);
		
	    $point_low = $point_low * $jishu_rand;
		$point_top = $point_top * $jishu_rand;
		
		$rand = rand($point_low,$point_top)/$jishu_rand;
		
		
		$price = $price + $rand;
		
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
	
	//锁仓释放
	public function lock_order()
	{
		
        //订单列表
		$map['state'] = 0;//委托当中
		$orderlist = db('lockorder')->where($map)->order('id asc')->select();
		foreach ($orderlist as $order){
		    if($order['is_gain']<$order['gain']){
		        $money = $order['gain']/$order['cycle'];
		        log_account_change($order['uid'],1,$order['name'], $money,0,$order['name'].'锁仓挖矿收益（订单ID:'.$order['id'].'）',0);
		        if($order['is_gain']+$money>=$order['gain']){
		            $where['state'] = 1;
		            log_account_change($order['uid'],1,$order['name'], $order['num'],-1*$order['num'],$order['name'].'锁仓挖矿返本（订单ID:'.$order['id'].'）',0);
		        }
		        $where['id'] = $order['id'];
		        $where['is_gain'] = $order['is_gain']+$money;
		        db('lockorder')->update($where);
		        
		    }else{
		        $d_map['id'] = $order['id'];
				$d_map['state'] = 1;
                db('lockorder')->update($d_map);
		    }
		}

	}

	//币币的委托订单

	public function bibi_order()
	{
		$db_order = db('order');
		$db_userinfo = db('userinfo');
		$data_info = db('productinfo');
		//订单列表
		$map['ostaus'] = 2;//委托当中
		$map['is_timing'] = 2;//币币交易
		$orderlist = $db_order->where($map)->order('selltime asc')->select();
		if(!$orderlist)
		{
			return false;
		}


		//循环处理订单

		foreach ($orderlist as $k => $v)
		{
			$pr = GetProData($v['pid'],'pi.ptitle,pi.procode,pi.protime,pi.propoint,pi.proscale,pi.numprice,pi.code,pd.*');
			if(!$pr){
				return false;
			}
			$huobidui = explode('/',$pr['ptitle']);
			if($v['ostyle']==0){
				//委托买入
				if($pr['Price']<=$v['realprice']){
					//成交
					//平仓处理订单
					$d_map['sellprice'] = $v['realprice'];
					$d_map['buyprice'] = $v['realprice'];
					$d_map['selltime'] = time();
					$d_map['ostaus'] = 1;
					$d_map['oid'] = $v['oid'];
					db('order')->update($d_map);

					log_account_change($v['uid'],1,$huobidui[0],$v['onumber'],0,\think\Lang::get('od_bbwtmr').\think\Lang::get('od_dd').$v['oid'].')',0);

					log_account_change($v['uid'],1,$huobidui[1], 0,-1*$v['fee'],\think\Lang::get('od_bbwtmr').$huobidui[0].\think\Lang::get('od_kj'),0);
					//手续费
					log_account_change($v['uid'],1,$huobidui[1], 0,-1*$v['sx_fee'],\think\Lang::get('od_bbwtmr').$huobidui[0].\think\Lang::get('od_kjsxf'),0);
				}
			}else{
				//委托卖出
				if($pr['Price']>=$v['realprice']){
					//成交
					//平仓处理订单
					$d_map['sellprice'] = $v['realprice'];
					$d_map['buyprice'] = $v['realprice'];
					$d_map['selltime'] = time();
					$d_map['ostaus'] = 1;
					$d_map['oid'] = $v['oid'];
					db('order')->update($d_map);

					log_account_change($v['uid'],1,$huobidui[0],0,-1*$v['onumber'],\think\Lang::get('od_bbjywtmckj').\think\Lang::get('od_dd').$v['oid'].')',0);

					log_account_change($v['uid'],1,$huobidui[1], $v['fee'],0,\think\Lang::get('od_bbjywtmc').$huobidui[0].\think\Lang::get('od_zhengjia'),0);
					//手续费
					log_account_change($v['uid'],1,$huobidui[1], -1*$v['sx_fee'],0,\think\Lang::get('od_bbjywtmc').$huobidui[0].\think\Lang::get('od_kjsxf'),0);
				}
			}

		}

	}


	//合约的委托订单

	public function lever_order()
	{
		$db_order = db('order');
		$db_userinfo = db('userinfo');
		$data_info = db('productinfo');
		//订单列表
		$map['ostaus'] = 2;//委托当中
		$map['is_timing'] = 1;//合约交易
		$orderlist = $db_order->where($map)->order('selltime asc')->select();
		if(!$orderlist)
		{
			return false;
		}
		//循环处理订单
		foreach ($orderlist as $k => $v)
		{
			$pr = GetProData($v['pid'],'pi.ptitle,pi.procode,pi.protime,pi.propoint,pi.proscale,pi.numprice,pi.code,pd.*');
			if(!$pr){
				return false;
			}
			$huobidui = explode('/',$pr['ptitle']);
			if($v['ostyle']==0){
				//委托买入
				if($pr['Price']<=$v['realprice']){
					//成交
					//平仓处理订单
					$d_map['sellprice'] = $v['realprice'];
					$d_map['buyprice'] = $v['realprice'];
					$d_map['selltime'] = time();
					$d_map['ostaus'] = 0;
					$d_map['oid'] = $v['oid'];
					db('order')->update($d_map);


					log_account_change($v['uid'],2,$huobidui[1], 0,-1*$v['fee'],\think\Lang::get('od_hyjymr').$huobidui[0].\think\Lang::get('od_kj'),0);
					//手续费
					log_account_change($v['uid'],2,$huobidui[1], 0,-1*$v['sx_fee'],\think\Lang::get('od_hyjymr').$huobidui[0].\think\Lang::get('od_kjsxf'),0);
				}
			}else{
				//委托卖出
				if($pr['Price']>=$v['realprice']){
					//成交
					//平仓处理订单
					$d_map['sellprice'] = $v['realprice'];
					$d_map['buyprice'] = $v['realprice'];
					$d_map['selltime'] = time();
					$d_map['ostaus'] = 0;
					$d_map['oid'] = $v['oid'];
					db('order')->update($d_map);

					log_account_change($v['uid'],2,$huobidui[1], 0,-1*$v['fee'],\think\Lang::get('od_hyjywtmc').$huobidui[0].\think\Lang::get('od_kj'),0);
					//手续费
					log_account_change($v['uid'],2,$huobidui[1], 0,-1*$v['sx_fee'],\think\Lang::get('od_hyjywtmc').$huobidui[0].\think\Lang::get('od_kjsxf'),0);
				}
			}

		}

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
		$map['ostaus'] = 0;//没有平仓的
		$map['selltime'] = array('elt',$nowtime+$s_rand );
		$map['is_timing'] = 0;//秒合约的
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

			$isopen = ChickIsOpen($v['pid']);
			if($isopen)
			{
				$prodata[$v['pid']] = $this->order_type($_orderlist,$_pro[$v['pid']],$risk,$data_info);
			}
		}

		//订单列表
		$map['ostaus'] = 0;
		$map['selltime'] = array('elt',$nowtime);
		$map['is_timing'] = 0;
		$orderlist = $db_order->where($map)->limit(0,50)->select();

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

					log_account_change($v['uid'],4,'USDT',$u_add,0,\think\Lang::get('od_mhyddjs').\think\Lang::get('od_dd').$v['oid'].')',0);

                   	//$db_userinfo->where('uid',$v['uid'])->setInc('usermoney',$u_add);
                   	//写入日志
                   	//$this->set_order_log($v,$u_add);


				}
				elseif($order_cha < 0)
				{	//亏损
					$yingli = -1*$v['fee'];
					$d_map['is_win'] = 2;
					//$this->set_order_log($v,0);

				}
				else
				{		//无效
					$yingli = 0;
					$d_map['is_win'] = 3;

					//平仓增加用户金额
                   	$u_add = $fee;
					log_account_change($v['uid'],4,'USDT',$u_add,0,\think\Lang::get('od_mhyddjs').\think\Lang::get('od_dd').$v['oid'].')',0);

                   	/*$db_userinfo->where('uid',$v['uid'])->setInc('usermoney',$u_add);
                   	//写入日志
                   	$this->set_order_log($v,$u_add);*/
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
					log_account_change($v['uid'],4,'USDT',$u_add,0,\think\Lang::get('od_mhyddjs').\think\Lang::get('od_dd').$v['oid'].')',0);

                   	/*$db_userinfo->where('uid',$v['uid'])->setInc('usermoney',$u_add);
                   	//写入日志
                   	$this->set_order_log($v,$u_add);*/
				}
				elseif($order_cha > 0)
				{	//亏损
					$yingli = -1*$v['fee'];
					$d_map['is_win'] = 2;
					//$this->set_order_log($v,0);

				}
				else
				{		//无效
					$yingli = 0;
					$d_map['is_win'] = 3;

					//平仓增加用户金额
                   	$u_add = $fee;
					log_account_change($v['uid'],4,'USDT',$u_add,0,\think\Lang::get('od_mhyddjs').\think\Lang::get('od_dd').$v['oid'].')',0);

                   	/*$db_userinfo->where('uid',$v['uid'])->setInc('usermoney',$u_add);
                   	$this->set_order_log($v,$u_add);*/
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

	//隔夜费，收取保证金的百分之多少
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

			//合约货币对
			$huobidui = explode('/',$v['ptitle']);
			$user_info = db('userinfo')->field('usermoney,level')->where('uid',$v['uid'])->find();
			$user_info['usermoney'] = get_money($v['uid'],2,$huobidui[1]);

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
				$u_fee = round($v['fee']*$gentletownship/100,2);
				if($user_info['usermoney']>=$u_fee){
					$d_map = array(
						'oid' => $v['oid'],
						'night_time' => time()
					);
					db('order')->update($d_map);
					log_account_change($v['uid'],2,$huobidui[1],-1*$u_fee,0,\think\Lang::get('od_gyf').\think\Lang::get('od_dd').$v['oid'].')',0);
				}else{
					$this->settlement_order($v['pid'],$v['oid'],$v['uid'],$v['buyprice'],$v['fee'],$v['onumber'],$v['ostyle'],1);
					$money = get_money($v['uid'],2,$huobidui[1]);
					if($money>=$u_fee){
						$d_map = array(
							'oid' => $v['oid'],
							'night_time' => time()
						);
						db('order')->update($d_map);
						log_account_change($v['uid'],2,$huobidui[1],-1*$u_fee,0,\think\Lang::get('od_gyf').\think\Lang::get('od_dd').$v['oid'].')',0);

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

		$ord=  db('order')->field('code,chicang,ptitle,ostaus,is_timing,stoploss_price,stopwin_price,stopwin_money,stoploss_money')->where("oid=".$oid)->find();
		if($ord['ostaus']!=0||$ord['is_timing']!=1){
			exit;
		}
		$code['code'] =  $ord['code'];

		
		//平仓价
		$enter = floatval($price['Price']);
		//入仓价
		$flat = floatval($buyprice);
		$cha = bcsub($enter,$flat,8);
		$point = floatval($cha);
	
		
		
		
		
		//合约货币对
		$huobidui = explode('/',$ord['ptitle']);
		//余额
		$umoney = get_money($uid,2,$huobidui[1]);
		//手续费
		$shouxufei = getconf('web_gratuity');
		$shouxufei = explode('|',$shouxufei);
		$user_info = Db::name('userinfo')->field('level')->where('uid',$uid)->find();

		if($user_info['level']=='level_zero')
		{
			$web_poundage =$shouxufei[0];
		}elseif($user_info['level']=='level_one')
		{
			$web_poundage =$shouxufei[1];
		}elseif($user_info['level']=='level_two')
		{
			$web_poundage =$shouxufei[2];
		}
		elseif($user_info['level']=='level_three')
		{
			$web_poundage =$shouxufei[3];
		}
		elseif($user_info['level']=='level_four')
		{
			$web_poundage =$shouxufei[4];
		}

		$sxfee = ($ord['chicang']*$price['Price']*$web_poundage)/100;
		$sxfee = sprintf("%.8f",$sxfee);

		// $this->textlog('6666',$price);
		$range = $point*$code['code']*$ord['chicang'];

		if($type == 1){
			//手动平仓
			$user_money = $fee;//保证金
			$d_map = array();
			//买涨
			if($ostyle == 0){
				//盈
				if($range>0){
					$total_money = $range+$user_money;//保证金+盈利
					log_account_change($uid,2,$huobidui[1],$total_money,0,\think\Lang::get('od_hyddpc').\think\Lang::get('od_dd').$oid.')',0);
					$d_map['is_win'] = 1;
					$d_map['ploss'] = $range;
				}
				//平
				if($range == 0){
					$total_money = $user_money;
					log_account_change($uid,2,$huobidui[1],$total_money,0,\think\Lang::get('od_hyddpc').\think\Lang::get('od_dd').$oid.')',0);
					$d_map['is_win'] = 3;
					$d_map['ploss'] = 0;
				}
				//亏
				if($range<0){
					$total_money = $user_money - abs($range);
					if($total_money>0){
						log_account_change($uid,2,$huobidui[1],$total_money,0,\think\Lang::get('od_hyddpc').\think\Lang::get('od_dd').$oid.')',0);
					}elseif($total_money<0){
						log_account_change($uid,2,$huobidui[1],$total_money,0,\think\Lang::get('od_hyddpc').\think\Lang::get('od_dd').$oid.')',0);

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
					log_account_change($uid,2,$huobidui[1],$total_money,0,\think\Lang::get('od_hyddpc').\think\Lang::get('od_dd').$oid.')',0);
					$d_map['is_win'] = 1;
					$d_map['ploss'] = abs($range);
				}
				//平
				if($range==0){
					$total_money = $user_money;
					if($total_money>0){
						log_account_change($uid,2,$huobidui[1],$total_money,0,\think\Lang::get('od_hyddpc').\think\Lang::get('od_dd').$oid.')',0);
					}
					$d_map['is_win'] = 3;
					$d_map['ploss'] = 0;
				}
				//亏
				if($range>0){
					$total_money = $user_money - $range;
					if($total_money>0){
						log_account_change($uid,2,$huobidui[1],$total_money,0,\think\Lang::get('od_hyddpc').\think\Lang::get('od_dd').$oid.')',0);
					}elseif($total_money<0){
						log_account_change($uid,2,$huobidui[1],$total_money,0,\think\Lang::get('od_hyddpc').\think\Lang::get('od_dd').$oid.')',0);
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

			//扣减手续费
			//log_account_change($uid,2,$huobidui[1],-1*$sxfee,0,'合约订单平仓手续费(订单：'.$oid.')',0);
		}else{
		    
		    //系统平仓
			$total_fee = $fee;//保证金
			$d_map = array(
				'ostaus' => 1,
				'system' => 1,
				'selltime' => time()
			);

			//买涨
			if($ostyle == 0){
			    //盈利
				if($range>0){
				    //设置了止盈价格
					if($ord['stopwin_money']>0  && $ord['stopwin_price']>0){
					    $stop_win = $ord['stopwin_money'];
    					//止盈
    					if($range>=$stop_win){
    						$total_money = $total_fee+$stop_win;
    
    						$user_info = array();
    						$user_info['oid'] = $oid;
    						$user_info['uid'] = $uid;
    						if($total_money>0){
    							log_account_change($uid,2,$huobidui[1],$total_money,0,\think\Lang::get('od_hyddzypc').\think\Lang::get('od_dd').$oid.')',0);
    						}
    						//平仓处理订单
    						$d_map['sellprice'] = $ord['stopwin_price'];
    						$d_map['ploss'] = $stop_win;
    						$d_map['oid'] = $oid;
    						$d_map['is_win'] = 1;
    						$d_map['endloss'] = abs($stop_win);
    						db('order')->update($d_map);
    						
    						$sxfee = ($ord['chicang']*$ord['stopwin_price']*$web_poundage)/100;
		                    $sxfee = sprintf("%.8f",$sxfee);
    
    						//扣减手续费
    						//log_account_change($uid,2,$huobidui[1],-1*$sxfee,0,'合约订单止盈平仓手续费(订单：'.$oid.')',0);
    
    					}
					}
				}
				//亏损
				if($range<0){
				    
				    if(abs($ord['stoploss_money'])>0  && $ord['stoploss_price']>0){
				        
				        
				        if(abs($ord['stoploss_money'])>($total_fee+$umoney)){
				            $ord['stoploss_price'] = $price['Price'];
				            $stop_loss = $total_fee+$umoney;
				        }else{
				            $stop_loss = abs($ord['stoploss_money']);
				        }
				    }else{
				        $stop_loss = $total_fee+$umoney;
				        $ord['stoploss_price'] = $price['Price'];
				    }
				    

					//止损
					if(abs($range)>=$stop_loss){


                        $total_money = $total_fee-$stop_loss;

                        $user_info = array();
                        $user_info['oid'] = $oid;
                        $user_info['uid'] = $uid;
                        if($total_money>0){
							log_account_change($uid,2,$huobidui[1],$total_money,0,\think\Lang::get('od_hyddzsfp').\think\Lang::get('od_dd').$oid.')',0);

                        }elseif($total_money<0){
							log_account_change($uid,2,$huobidui[1],$total_money,0,\think\Lang::get('od_hyddzsfp').\think\Lang::get('od_dd').$oid.')',0);
                        }
                        //平仓处理订单
                        $d_map['sellprice'] = $ord['stoploss_price'];
                        $d_map['ploss'] = $stop_loss*(-1);
                        $d_map['oid'] = $oid;
                        $d_map['is_win'] = 2;
                        $d_map['endloss'] = abs($stop_loss);
                        db('order')->update($d_map);
						//扣减手续费
						$sxfee = ($ord['chicang']*$ord['stoploss_price']*$web_poundage)/100;
		                $sxfee = sprintf("%.8f",$sxfee);
						//log_account_change($uid,2,$huobidui[1],-1*$sxfee,0,'合约订单止损平仓手续费(订单：'.$oid.')',0);

					}
				}
			}
			//买跌
			if($ostyle == 1){
				//盈
				if($range<0){
				    //设置了止盈价格
					if($ord['stopwin_money']>0 && $ord['stopwin_price']>0){
					    $stop_win = $ord['stopwin_money'];

    					if(abs($range)>=$stop_win){
    						$total_money = $total_fee+$stop_win;
    						$user_info = array();
    						$user_info['oid'] = $oid;
    						$user_info['uid'] = $uid;
    						if($total_money>0){
    							log_account_change($uid,2,$huobidui[1],$total_money,0,\think\Lang::get('od_hyddzypc').\think\Lang::get('od_dd').$oid.')',0);
    						}
    						//平仓处理订单
    						$d_map['sellprice'] = $ord['stopwin_price'];
    						$d_map['ploss'] = $stop_win;
    						$d_map['oid'] = $oid;
    						$d_map['is_win'] = 1;
    						$d_map['endloss'] = abs($stop_win);
    						db('order')->update($d_map);
    						
    						$sxfee = ($ord['chicang']*$ord['stopwin_price']*$web_poundage)/100;
		                    $sxfee = sprintf("%.8f",$sxfee);
    						//扣减手续费
    						//log_account_change($uid,2,$huobidui[1],-1*$sxfee,0,'合约订单止盈平仓手续费(订单：'.$oid.')',0);
    
    					}
					}
					
				}
				//亏
				if($range>0){
					
					if(abs($ord['stoploss_money'])>0  && $ord['stoploss_price']>0){
				        
				        
				        if(abs($ord['stoploss_money'])>($total_fee+$umoney)){
				            $ord['stoploss_price'] = $price['Price'];
				            $stop_loss = $total_fee+$umoney;
				        }else{
				            $stop_loss = abs($ord['stoploss_money']);
				        }
				    }else{
				        $stop_loss = $total_fee+$umoney;
				        $ord['stoploss_price'] = $price['Price'];
				    }
				    
					
					

					if(abs($range)>=$stop_loss){
						$total_money = $total_fee-$stop_loss;
						$user_info = array();
						$user_info['oid'] = $oid;
						$user_info['uid'] = $uid;
						if($total_money>0){

							log_account_change($uid,2,$huobidui[1],$total_money,0,\think\Lang::get('od_hyddzsfp').\think\Lang::get('od_dd').$oid.')',0);
						}elseif($total_money<0){

							log_account_change($uid,2,$huobidui[1],$total_money,0,\think\Lang::get('od_hyddzsfp').\think\Lang::get('od_dd').$oid.')',0);
                        }
						//平仓处理订单
						$d_map['sellprice'] = $ord['stoploss_price'];
						$d_map['ploss'] = $stop_loss*(-1);
						$d_map['oid'] = $oid;
						$d_map['is_win'] = 2;
						$d_map['endloss'] = abs($stop_loss);
						db('order')->update($d_map);
						//扣减手续费
						$sxfee = ($ord['chicang']*$ord['stoploss_price']*$web_poundage)/100;
		                $sxfee = sprintf("%.8f",$sxfee);
						//log_account_change($uid,2,$huobidui[1],-1*$sxfee,0,'合约订单止损平仓手续费(订单：'.$oid.')',0);

					}
				}
			}
		    
		    

		    /*//系统平仓止盈止损比例
			$total_fee = $fee;//保证金
			$d_map = array(
				'ostaus' => 1,
				'system' => 1,
				'selltime' => time()
			);

			//买涨
			if($ostyle == 0){
			    //盈利
				if($range>0){
					if($win==0){
						$win = 100000000;
					}
					$stop_win = ($total_fee+$umoney)*$win/100;
					//止盈
					if($range>=$stop_win){
						$total_money = $total_fee+$stop_win;

						$user_info = array();
						$user_info['oid'] = $oid;
						$user_info['uid'] = $uid;
						if($total_money>0){
							log_account_change($uid,2,$huobidui[1],$total_money,0,'合约订单止盈平仓(订单：'.$oid.')',0);
						}
						//平仓处理订单
						$d_map['sellprice'] = $price['Price'];
						$d_map['ploss'] = $stop_win;
						$d_map['oid'] = $oid;
						$d_map['is_win'] = 1;
						$d_map['endloss'] = abs($stop_win);
						db('order')->update($d_map);

						//扣减手续费
						log_account_change($uid,2,$huobidui[1],-1*$sxfee,0,'合约订单止盈平仓手续费(订单：'.$oid.')',0);

					}


				}
				//亏损
				if($range<0){
					if($loss==0){
						$loss = 100;
					}
					$stop_loss = ($total_fee+$umoney)*$loss/100;

					//止损
					if(abs($range)>=$stop_loss){


                        $total_money = $total_fee-$stop_loss;

                        $user_info = array();
                        $user_info['oid'] = $oid;
                        $user_info['uid'] = $uid;
                        if($total_money>0){
							log_account_change($uid,2,$huobidui[1],$total_money,0,'合约订单止损平仓(订单：'.$oid.')',0);

                        }elseif($total_money<0){
							log_account_change($uid,2,$huobidui[1],$total_money,0,'合约订单止损平仓(订单：'.$oid.')',0);
                        }
                        //平仓处理订单
                        $d_map['sellprice'] = $price['Price'];
                        $d_map['ploss'] = $stop_loss*(-1);
                        $d_map['oid'] = $oid;
                        $d_map['is_win'] = 2;
                        $d_map['endloss'] = abs($stop_loss);
                        db('order')->update($d_map);
						//扣减手续费
						log_account_change($uid,2,$huobidui[1],-1*$sxfee,0,'合约订单止损平仓手续费(订单：'.$oid.')',0);

					}
				}
			}
			//买跌
			if($ostyle == 1){
				//盈
				if($range<0){
					if($win==0){
						$win = 100000000;
					}
					$stop_win = ($total_fee+$umoney)*$win/100;

					if(abs($range)>=$stop_win){
						$total_money = $total_fee+$stop_win;
						$user_info = array();
						$user_info['oid'] = $oid;
						$user_info['uid'] = $uid;
						if($total_money>0){
							log_account_change($uid,2,$huobidui[1],$total_money,0,'合约订单止盈平仓(订单：'.$oid.')',0);
						}
						//平仓处理订单
						$d_map['sellprice'] = $price['Price'];
						$d_map['ploss'] = $stop_win;
						$d_map['oid'] = $oid;
						$d_map['is_win'] = 1;
						$d_map['endloss'] = abs($stop_win);
						db('order')->update($d_map);
						//扣减手续费
						log_account_change($uid,2,$huobidui[1],-1*$sxfee,0,'合约订单止盈平仓手续费(订单：'.$oid.')',0);

					}
				}
				//亏
				if($range>0){
					if($loss==0){
						$loss=100;
					}
					$stop_loss = ($total_fee+$umoney)*$loss/100;

					if(abs($range)>=$stop_loss){
						$total_money = $total_fee-$stop_loss;
						$user_info = array();
						$user_info['oid'] = $oid;
						$user_info['uid'] = $uid;
						if($total_money>0){

							log_account_change($uid,2,$huobidui[1],$total_money,0,'合约订单止损平仓(订单：'.$oid.')',0);
						}elseif($total_money<0){

							log_account_change($uid,2,$huobidui[1],$total_money,0,'合约订单止损平仓(订单：'.$oid.')',0);
                        }
						//平仓处理订单
						$d_map['sellprice'] = $price['Price'];
						$d_map['ploss'] = $stop_loss*(-1);
						$d_map['oid'] = $oid;
						$d_map['is_win'] = 2;
						$d_map['endloss'] = abs($stop_loss);
						db('order')->update($d_map);
						//扣减手续费
						log_account_change($uid,2,$huobidui[1],-1*$sxfee,0,'合约订单止损平仓手续费(订单：'.$oid.')',0);

					}
				}
			}*/
		}

	}

	public function timing_free_order(){
		$map = array(
			'ostaus'=>0,
			'is_timing'=>1
		);
		$timing_order = db('order')->where($map)->select();

		foreach ($timing_order as $k => $v){

			if($v){
				$isopen = ChickIsOpen($v['pid']);
				if($isopen == 0){
					continue;
				}
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
			exit(json_encode(array('error'=>\think\Lang::get('od_cwpzx'))));
		}
		if($order['ostaus'] == 1){
			exit(json_encode(array('error'=>\think\Lang::get('od_gddyjs'))));
		}
		if($user_id>0 && $order['uid'] == $user_id&&$order['is_timing'] ==1){
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
       	if($addprice>=0){
       		$leixing = 1;
		}else{
			$leixing = 2;
		}

       	set_price_log($v['uid'],$leixing,abs($addprice),$des,$info,$v['oid'],$o_log['user_money']);
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
		if($pro['is_fb']==0)
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
				case 'w':
    				$datalen = '1week';
    				break;
    				
    				
    					case '4h':
    				$datalen = '4hour';
    				break;
    				
    				
    				
    					case 'y':
    				$datalen = '1mon';
    				break;

				default:
					exit;
					break;
			}


			$geturl ="https://api.huobi.pro/market/history/kline?period=".$datalen."&size=".$num."&symbol=".$pro['procode'];

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
			


		}

		else
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



		 $sl = count($res_arr);

		if($pro['Price'] < $res_arr[$sl-1][1]){
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
	/*public function setusers()
	{
		test_web();
	}*/



	public function getprodata()
	{
		$pid = input('param.pid');

		$pro = GetProData($pid);


		if(!$pro){
			exit;
		}

		//涨跌幅
		$chajia = round($pro['Price']-$pro['Open'],2);
		$zhangfu = round($chajia/$pro['Price']*100,2);


		if($_SESSION['uid']){

			$user_info = Db::name('userinfo')->field('income_range')->where('uid',$_SESSION['uid'])->find();

			$buyenter = Db::name('productinfo')->field('decimal,income_range')->where('pid',$pid)->find();

			$newprice_length = getFloatLength($pro['Price']);//小数点位数
			$length_difference = $newprice_length - $buyenter['decimal'];

			$user_ferry = explode(',',$user_info['income_range']);

			if($user_ferry[0]>0||$user_ferry[1]>0)
			{
				$ferry = explode(',',$user_info['income_range']);
			}else
			{

				$ferry = explode(',',$buyenter['income_range']);
			}

			//入仓价
			$digit = sprintf("%.".$buyenter['decimal']."f",$pro['Price']);
			//跌
			$spread_die = $digit - abs($ferry[0]/pow(10,$buyenter['decimal']));
			//涨
			$spread_zhang = $digit + abs($ferry[0]/pow(10,$buyenter['decimal']));
		}




		$topdata = array(
						'topdata'=>$pro['UpdateTime'],
						'now'=>$pro['Price'],
						'open'=>$pro['Open'],
						'lowest'=>$pro['Low'],
						'highest'=>$pro['High'],
						'close'=>$pro['Close'],
						'chajia'=>$chajia,
						'zhangfu'=>$zhangfu,
						'spread_die'=>$spread_die,
						'spread_zhang'=>$spread_zhang,

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
		$map['is_timing'] = array('<>',2);
		$map['selltime'] = array('<',time()-60);
		$list = db('order')->where($map)->limit(0,10)->select();

		if(!$list){
			return false;
		}

		foreach ($list as $k => $v) {
			//分配金额
			$this->allotfee($v['uid'],$v['fee'],$v['is_win'],$v['oid'],$v['ploss'],$v['sx_fee'],$v['ptitle'],$v['is_timing']);
			//更改订单状态
			db('order')->where('oid',$v['oid'])->update(array('isshow'=>1));

		}

	}

	//用户id，下单金额，输赢，订单id，盈亏

	public function allotfee($uid,$fee,$is_win,$order_id,$ploss,$sx_fee,$ptitle,$is_timing)
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
			$pay_fee = 0;
		}
		$huobidui = explode('/',$ptitle);
		if($is_timing==0){
			$qblx = 4;
			$huobidui[1]='USDT';
		}elseif ($is_timing==1){
			$qblx = 2;
		}

		foreach ($myoids as $k => $v) {

			if($user['oid'] == $v['uid']){	//直接推荐者拿自己设置的比例


				$_fee = round($pay_fee * ($v["rebate"]/100),2);
				$_feerebate = round($sx_fee * ($v["feerebate"]/100),2);
				//echo $_feerebate;

			}else{		//他上级比例=本级-下级比例

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
					//$ids_fee = $userinfo->where('uid',$v['uid'])->setDec('usermoney', $_fee);

					log_account_change($v['uid'],$qblx,$huobidui[1],-1*$_fee,0,\think\Lang::get('od_xxkhdc').\think\Lang::get('od_dd').$order_id.')',0);

				}else{
					$ids_fee = null;
				}

				$type = 2;
				$_fee = $_fee*-1;
			}elseif($is_win == 2){	//客户亏损代理盈利
				if($_fee != 0){
					//$ids_fee = $userinfo->where('uid',$v['uid'])->setInc('usermoney', $_fee);

					log_account_change($v['uid'],$qblx,$huobidui[1],1*$_fee,0,\think\Lang::get('od_xxkhdc').\think\Lang::get('od_dd').$order_id.')',0);

				}else{
					$ids_fee = null;
				}

				$type = 1;
			}elseif($is_win == 3){	//无效订单不做操作
				$ids_fee = null;
			}



			//手续费
			if($_feerebate != 0){
				//$ids_feerebate = $userinfo->where('uid',$v['uid'])->setInc('usermoney', $_feerebate);
				log_account_change($v['uid'],$qblx,$huobidui[1],$_feerebate,0,\think\Lang::get('od_xxkhxdsxf').\think\Lang::get('od_dd').$order_id.')',0);
			}else{
				$ids_feerebate = null;
			}



		}



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
