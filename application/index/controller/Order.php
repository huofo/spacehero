<?php
namespace app\index\controller;
use think\Db;


class Order extends Base
{
    
    public function dowin_loss()
	{
	    $data = input('post.');
		$arr = array('oid','stoploss_price','stopwin_price','yuqi_loss','yuqi_win');
        foreach ($data as $k => $v) {
            if(!in_array($k,$arr)){
                return WPreturn(\think\Lang::get('od_cwpzx'),-1);
            }
        }
         if($data['stopwin_price']==''||$data['stopwin_price']<0){
            $result = array(
                'error' => 1,
                'msg' => \think\Lang::get('or_qsrzyjg') ,
            );
            echo json_encode($result);
            exit();
        }
        
         if($data['stoploss_price']==''||$data['stoploss_price']<0){
            $result = array(
                'error' => 1,
                'msg' => \think\Lang::get('or_qsrzsjg') ,
            );
            echo json_encode($result);
            exit();
        }
        $order = Db::name('order')->where(['oid'=>$data['oid'],'ostaus'=>0,'is_timing'=>1])->find();
        if(!$order){
           $result = array(
                'error' => 1,
                'msg' => \think\Lang::get('od_szsb') ,
            );
            echo json_encode($result);
            exit(); 
        }
        
        
       
       
       //止盈
        $point = $data['stopwin_price'] - $order['buyprice'];
        $win_loss = $order['chicang']*$point*$order['code'];
        if($order['ostyle'] == 0){
            if($win_loss>0){
                $yuqi_win = $win_loss;
                
            }else{
                $yuqi_win = 0;
               
            }
        }else{
            
            if($win_loss>0){
                 $yuqi_win = 0;
                
            }else{
                 $yuqi_win = -1*$win_loss;
            }
        }
        
        
        //止损
        
        $point = $data['stoploss_price'] - $order['buyprice'];
        $win_loss = $order['chicang']*$point*$order['code'];
        
        if($order['ostyle'] == 0){
            if($win_loss>0){
                $yuqi_loss = 0;
                
            }else{
                $yuqi_loss = $win_loss;
               
            }
        }else{
            
            if($win_loss>0){
                 $yuqi_loss = -1*$win_loss;
                
            }else{
                 $yuqi_loss = 0;
            }
        }
        
        
       
        
        $d_map['stoploss_money'] = $yuqi_loss;
		$d_map['stopwin_money'] =$yuqi_win;
        $d_map['stopwin_price'] = $data['stopwin_price'];
		$d_map['stoploss_price'] =$data['stoploss_price'];
		$d_map['oid'] = $data['oid'];
	db('order')->update($d_map);
	
		    $result = array(
                'error' =>0,
                'msg' => \think\Lang::get('or_szcg') ,
            );
            echo json_encode($result);
            exit(); 
		
        
        
	}

	/**
	 * 秒合约下单
	 * @author lukui  2017-07-20
	 * @return [type] [description]
	 */
	public function addorder()
	{

		$data = input('post.');
		$arr = array('order_type','order_pid','order_price','order_sen','order_shouyi','newprice');
        foreach ($data as $k => $v) {
            if(!in_array($k,$arr)){
                return WPreturn(\think\Lang::get('od_cwpzx'),-1);
            }
        }
        $file = request()->file();
        if($file){
            return WPreturn(\think\Lang::get('od_cwpzx'),-1);
        }
		$adddata['uid'] = $data['uid']=$this->uid;
		$conf = $this->conf;

		if($data['order_price'] > $conf['order_max_price']){
			return WPreturn(\think\Lang::get('od_dbcczdw').$conf['order_max_price'].'！',-1);
		}
		$allcount = Db::name('order')->where(array('ostaus'=>0,'uid'=>$data['uid']))->count();
		if($allcount >  $conf['max_order_count']){
			return WPreturn(\think\Lang::get('od_zdccsw').$conf['max_order_count'].'！',-1);
		}


		//用户信息
		$user = Db::name('userinfo')->field('ustatus,usermoney,uid,smsh_state')->where('uid',$data['uid'])->find();
		//验证用户是否被冻结
		if($user['ustatus'] != 0){
			return WPreturn(\think\Lang::get('od_ndzhybdj'),-1);
		}


if($user['smsh_state'] == 0){
			return WPreturn(\think\Lang::get('od_qtjsfzwcsmrz'),-1);
		}
		
		if($user['smsh_state'] == 1){
			return WPreturn(\think\Lang::get('od_smshzzswfcz'),-1);
		}
		
			if($user['smsh_state'] == 3){
			return WPreturn(\think\Lang::get('od_smrzsbqcxrz'),-1);
		}
		
		//验证金额 20 ~ 5000
		if($data['order_price'] < $conf['order_min_price'] || $data['order_price'] > $conf['order_max_price']){
			return WPreturn(\think\Lang::get('od_bqdbccz').$conf['order_min_price'].'~'.$conf['order_max_price'].\think\Lang::get('od_zj'),-1);
		}
		//手续费
		$shouxufei = getconf('web_poundage');

		$shouxufei = explode('|',$shouxufei);

		$uid = $this->uid;
		$user_info = Db::name('userinfo')->where('uid',$uid)->find();

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

		if($user_info['jiying'] == 1){
			return WPreturn(\think\Lang::get('od_nwqx'),-1);
		}
        $user['usermoney'] = get_money($this->uid,4,'USDT');
		//验证余额是否够
		if($user['usermoney'] < $data['order_price'] + ($data['order_price']*$web_poundage/100)){
			return WPreturn(\think\Lang::get('od_ndyebzqcz'),-1);
		}



		//建仓
		$adddata['buytime'] = time();
		$adddata['night_time'] = time();
		$adddata['endprofit'] = $data['order_sen'];
		$adddata['pid'] = $data['order_pid'];
		$adddata['ostyle'] = $data['order_type'];
		$adddata['buyprice'] = $data['newprice'];
		$adddata['realprice'] = $data['newprice'];
		$adddata['endloss'] = $data['order_shouyi'];
		$adddata['eid'] = 2;
		$adddata['selltime']=$adddata['buytime']+$adddata['endprofit'];
		$adddata['fee'] = $data['order_price'];
        $adddata['ptitle'] = db('productinfo')->where('pid',$data['order_pid'])->value('ptitle');
        $adddata['ostaus']='0';
        $adddata['sx_fee']=round($adddata['fee']*$web_poundage/100 ,2);

        $allfee = $adddata['fee'] + $adddata['sx_fee'];
        //会员建仓后金额
        $adddata['commission'] = $user['usermoney'] - $allfee;
        //订单号
        $adddata['orderno']=date('YmdHis').rand(1111,9999);

        //下单
        $ids = Db::name('order')->insertGetId($adddata);
        if($ids){
        	//下单成功减用户余额
            log_account_change($this->uid,4,'USDT',-1*$adddata['fee'],0,\think\Lang::get('od_mhyxdcj'),0);
            //手续费
            log_account_change($this->uid,4,'USDT',-1*$adddata['sx_fee'],0,\think\Lang::get('od_smhxdcjsxf'),0);

            $adddata['oid'] = $ids;
            //缓存加载验证
            $order_rand = rand(1,1000);
            cache('goorder_'.$ids,$order_rand,$adddata['endprofit']+10);
            $adddata['order_rand'] = $order_rand;
            $res = base64_encode(json_encode($adddata));
            return WPreturn($res,1);
        }else{
        	return WPreturn(\think\Lang::get('od_xdsbqcs'),-1);
        }
	
	}

	

    
    public function addorderslever()
    {


        $data = input('post.');
        //方向，产品，价格，手数，
        $arr = array('order_type','order_pid','newprice','move_share','never_win','never_loss','ng_win','ng_loss','code','price_type');
        foreach ($data as $k => $v) {
            if(!in_array($k,$arr)){
                return WPreturn(\think\Lang::get('od_cwpzx'),-1);
            }
        }
        $file = request()->file();
        if($file){
            return WPreturn(\think\Lang::get('od_cwpzx'),-1);
        }

        $data['price_type'] = trim($data['price_type']);
        //用户信息
        $user = Db::name('userinfo')->where('uid',$this->uid)->find();
        //验证用户是否被冻结
        if($user['ustatus'] != 0){
            return WPreturn(\think\Lang::get('od_ndzhybdj'),-1);
        }
        if($user['smsh_state'] == 0){
			return WPreturn(\think\Lang::get('od_qtjsfzwcsmrz'),-1);
		}
		
		if($user['smsh_state'] == 1){
			return WPreturn(\think\Lang::get('od_smshzzswfcz'),-1);
		}
		
			if($user['smsh_state'] == 3){
			return WPreturn(\think\Lang::get('od_smrzsbqcxrz'),-1);
		}
		

        //产品信息
        $pr = GetProData($data['order_pid'],'pi.ptitle,pi.procode,pi.protime,pi.propoint,pi.proscale,pi.numprice,pi.code,pd.*');
        if(!$pr){
            return WPreturn(\think\Lang::get('od_jyhbdccz'),-1);
        }


        //用户余额
        $huobidui = explode('/',$pr['ptitle']);
        $qian_money = get_money($this->uid,2,$huobidui[0]);
        $hou_money = get_money($this->uid,2,$huobidui[1]);

        //手续费
        $shouxufei = getconf('web_gratuity');
        $shouxufei = explode('|',$shouxufei);

        if($user['level']=='level_zero')
        {
            $web_poundage =$shouxufei[0];
        }elseif($user['level']=='level_one')
        {
            $web_poundage =$shouxufei[1];
        }elseif($user['level']=='level_two')
        {
            $web_poundage =$shouxufei[2];
        }
        elseif($user['level']=='level_three')
        {
            $web_poundage =$shouxufei[3];
        }
        elseif($user['level']=='level_four')
        {
            $web_poundage =$shouxufei[4];
        }

        if($data['price_type']==\think\Lang::get('bi_xj')){
            
            
            if($data['order_type']==0){
                
                 
                //委托买入
                if($data['newprice']>=$pr['Price']){
                    //高价委托买不允许
                    return WPreturn(\think\Lang::get('od_xjjyzdjgbngydqj'),-1);
                    //立即成交
                    $data['newprice'] = $pr['Price'];
                    $adddata = array();
                    $adddata['uid'] = $data['uid']=$this->uid;
                    $conf = $this->conf;
                    $adddata['stop_win'] = 0;
                    $adddata['stop_loss'] =0;
                    /*if(is_numeric($data['never_win']) && $data['never_win']>0 && $data['never_win']<1000 && !empty($data['never_win'])){
                        $adddata['stop_win'] = $data['never_win'];
                    }else{
                        if(is_numeric($data['ng_win']) && $data['ng_win']>0 && $data['ng_win']<1000 && !empty($data['ng_win'])){
                            $adddata['stop_win'] = $data['ng_win'];
                        }else{
                            return WPreturn('止盈在1%~999%之间',-1);
                        }
                    }
                    if(is_numeric($data['never_loss']) && $data['never_loss']>0 && $data['never_loss']<=100 && !empty($data['never_loss'])){
                        $adddata['stop_loss'] = $data['never_loss'];
                    }else{
                        if(is_numeric($data['ng_loss']) && $data['ng_loss']>0 && $data['ng_loss']<=100 && !empty($data['ng_loss'])){
                            $adddata['stop_loss'] = $data['ng_loss'];
                        }else{
                            return WPreturn('止损在1%~100%之间',-1);
                        }
                    }*/
        
                    if(is_numeric($data['move_share']) && $data['move_share']>0 && preg_match("/^[1-9][0-9]*$/" ,$data['move_share']) && !empty($data['move_share'])){
                        $adddata['onumber'] = $data['move_share'];
                    }else{
                        return WPreturn(\think\Lang::get('od_qsrzqxdss'),-1);
                    }
        
                    $allcount = Db::name('order')->where(array('ostaus'=>0,'uid'=>$data['uid']))->count();
                    if($allcount >  $conf['max_order_count']){
                        return WPreturn(\think\Lang::get('od_zdccslw').$conf['max_order_count'].'！',-1);
                    }
        
                    if($user['jinjie'] == 0){
                        return WPreturn(\think\Lang::get('od_nwqx'),-1);
                    }
        
                    $numprice = Db::name('productinfo')->field('numprice,code')->where('pid='.$data['order_pid'])->find();
                    //手续费
                    $sx_fee = sprintf("%.8f",$data['move_share']*$numprice['numprice']* $data['newprice']*$web_poundage/100);
        
                    //杠杆
                    $code = explode(',',$numprice['code']);
        
                    if(in_array($data['code'],$code)){
                        $adddata['fee'] =  ($data['move_share']*$numprice['numprice']*$data['newprice'] )/$data['code'];//保证金
                        $adddata['code'] =  $data['code'];
                        $adddata['chicang'] =$data['move_share']*$numprice['numprice'];
                    }else{
                        return WPreturn(\think\Lang::get('od_ggcscw'),-1);
                    }
                    if($hou_money < ($adddata['fee'] + $sx_fee)){
                        return WPreturn($huobidui[1].\think\Lang::get('od_slbz'),-1);
                    }
        
                    //点差
                    $buyenter = Db::name('productinfo')->field('decimal,income_range')->where('pid',$data['order_pid'])->find();
                    $user_ferry = explode(',',$user['income_range']);
        
                    if($user_ferry[0]!=0||$user_ferry[1]!=0)
                    {
        
                        $ferry = explode(',',$user['income_range']);
                    }else
                    {
        
                        $ferry = explode(',',$buyenter['income_range']);
                    }
                    
                
        
                    //入仓价
                    $digit = floatval($data['newprice']);
                    if($data['order_type'] == 1){
                        //跌
                        $spread = $digit - $ferry[1];
                    }else{
                        //涨
                        $spread = $digit + $ferry[0];
                    }
        
                    //建仓
                    $adddata['buytime'] = time();
                    $adddata['is_timing'] = 1;
                    $adddata['night_time'] = time();
                    $adddata['pid'] = $data['order_pid'];
                    $adddata['ostyle'] = $data['order_type'];
                    $adddata['buyprice'] = $spread;
                    $adddata['realprice'] = $data['newprice'];
                    $adddata['eid'] = 2;
                    $adddata['ptitle'] = db('productinfo')->where('pid',$data['order_pid'])->value('ptitle');
                    $adddata['ostaus']='0';
                    $adddata['sx_fee']=$sx_fee;
        
        
                    //订单号
                    $adddata['orderno']=date('YmdHis').rand(1111,9999);
                    //下单
                    $ids = Db::name('order')->insertGetId($adddata);
                    if($ids){
        
                        if($data['order_type']==0){
                            //做多
        
                            log_account_change($this->uid,2,$huobidui[1],-1*$adddata['fee'],0,\think\Lang::get('od_hyjyzd').$huobidui[0].\think\Lang::get('od_kj'),0);
                            //手续费
                            log_account_change($this->uid,2,$huobidui[1],-1*$sx_fee,0,\think\Lang::get('od_hyjyzd').$huobidui[0].\think\Lang::get('od_kjsxf'),0);
                        }else{
                            //做空
                            log_account_change($this->uid,2,$huobidui[1],-1*$adddata['fee'],0,\think\Lang::get('od_hyzk').$huobidui[0].\think\Lang::get('od_kj'),0);
                            //手续费
                            log_account_change($this->uid,2,$huobidui[1],-1*$sx_fee,0,\think\Lang::get('od_hyzk').$huobidui[0].\think\Lang::get('od_kjsxf'),0);
                        }
                        return WPreturn(\think\Lang::get('od_xdcg'),1);
        
                    }else{
                        return WPreturn(\think\Lang::get('od_xdsbqcs'),-1);
                    }
                    
                }else{
                    //低价委托买成功委托
                    $adddata = array();
                    $adddata['uid'] = $data['uid']=$this->uid;
                    $conf = $this->conf;

                    $adddata['stop_win'] = 0;
                    $adddata['stop_loss'] =0;
                    /*if(is_numeric($data['never_win']) && $data['never_win']>0 && $data['never_win']<1000 && !empty($data['never_win'])){
                        $adddata['stop_win'] = $data['never_win'];
                    }else{
                        if(is_numeric($data['ng_win']) && $data['ng_win']>0 && $data['ng_win']<1000 && !empty($data['ng_win'])){
                            $adddata['stop_win'] = $data['ng_win'];
                        }else{
                            return WPreturn('止盈在1%~999%之间',-1);
                        }
                    }
                    if(is_numeric($data['never_loss']) && $data['never_loss']>0 && $data['never_loss']<=100 && !empty($data['never_loss'])){
                        $adddata['stop_loss'] = $data['never_loss'];
                    }else{
                        if(is_numeric($data['ng_loss']) && $data['ng_loss']>0 && $data['ng_loss']<=100 && !empty($data['ng_loss'])){
                            $adddata['stop_loss'] = $data['ng_loss'];
                        }else{
                            return WPreturn('止损在1%~100%之间',-1);
                        }
                    }*/

                    if(is_numeric($data['move_share']) && $data['move_share']>0 && preg_match("/^[1-9][0-9]*$/" ,$data['move_share']) && !empty($data['move_share'])){
                        $adddata['onumber'] = $data['move_share'];
                    }else{
                        return WPreturn(\think\Lang::get('od_qsrzqxdss'),-1);
                    }

                    $allcount = Db::name('order')->where(array('ostaus'=>0,'uid'=>$data['uid']))->count();
                    if($allcount >  $conf['max_order_count']){
                        return WPreturn(\think\Lang::get('od_zdccslw').$conf['max_order_count'].'！',-1);
                    }

                    if($user['jinjie'] == 0){
                        return WPreturn(\think\Lang::get('od_nwqx'),-1);
                    }

                    $numprice = Db::name('productinfo')->field('numprice,code')->where('pid='.$data['order_pid'])->find();
                    //手续费
                    $sx_fee = sprintf("%.8f",$data['move_share']*$numprice['numprice']* $data['newprice']*$web_poundage/100);

                    //杠杆
                    $code = explode(',',$numprice['code']);

                    if(in_array($data['code'],$code)){
                        $adddata['fee'] =  ($data['move_share']*$numprice['numprice']*$data['newprice'] )/$data['code'];//保证金
                        $adddata['code'] =  $data['code'];
                        $adddata['chicang'] =$data['move_share']*$numprice['numprice'];
                    }else{
                        return WPreturn(\think\Lang::get('od_ggcscw'),-1);
                    }
                    if($hou_money < ($adddata['fee'] + $sx_fee)){
                        return WPreturn($huobidui[1].\think\Lang::get('od_slbz'),-1);
                    }

                    //建仓
                    $adddata['buytime'] = time();
                    $adddata['is_timing'] = 1;
                    $adddata['night_time'] = time();
                    $adddata['pid'] = $data['order_pid'];
                    $adddata['ostyle'] = $data['order_type'];
                    $adddata['buyprice'] = $data['newprice'];
                    $adddata['realprice'] = $data['newprice'];
                    $adddata['eid'] = 2;
                    $adddata['ptitle'] = db('productinfo')->where('pid',$data['order_pid'])->value('ptitle');
                    $adddata['ostaus']='2';
                    $adddata['sx_fee']=$sx_fee;

                    //订单号
                    $adddata['orderno']=date('YmdHis').rand(1111,9999);
                    //下单
                    $ids = Db::name('order')->insertGetId($adddata);
                    if($ids){

                        log_account_change($this->uid,2,$huobidui[1],-1*$adddata['fee'],0,\think\Lang::get('od_hyjyzd').$huobidui[0].\think\Lang::get('od_kj'),0);
                        //手续费
                        log_account_change($this->uid,2,$huobidui[1],-1*$sx_fee,0,\think\Lang::get('od_hyjyzd').$huobidui[0].\think\Lang::get('od_kjsxf'),0);

                        log_account_change($this->uid,2,$huobidui[1],0,$adddata['fee'],\think\Lang::get('od_hyjyzd').$huobidui[0].\think\Lang::get('od_djbzj'),0);
                        //手续费
                        log_account_change($this->uid,2,$huobidui[1],0,$sx_fee,\think\Lang::get('od_hyjyzd').$huobidui[0].\think\Lang::get('od_djsxf'),0);

                        return WPreturn(\think\Lang::get('od_xdcg'),1);

                    }else{
                        return WPreturn(\think\Lang::get('od_xdsbqcs'),-1);
                    }
                }

            }else{
                //委托卖出
                if($data['newprice']<=$pr['Price']){
                    //低价委托卖不允许
                   return WPreturn(\think\Lang::get('od_xjjyzkbndydqj'),-1);
                    //立即成交
                    $data['newprice'] = $pr['Price'];
                    $adddata = array();
                    $adddata['uid'] = $data['uid']=$this->uid;
                    $conf = $this->conf;
        
                    $adddata['stop_win'] = 0;
                    $adddata['stop_loss'] =0;
                    /*if(is_numeric($data['never_win']) && $data['never_win']>0 && $data['never_win']<1000 && !empty($data['never_win'])){
                        $adddata['stop_win'] = $data['never_win'];
                    }else{
                        if(is_numeric($data['ng_win']) && $data['ng_win']>0 && $data['ng_win']<1000 && !empty($data['ng_win'])){
                            $adddata['stop_win'] = $data['ng_win'];
                        }else{
                            return WPreturn('止盈在1%~999%之间',-1);
                        }
                    }
                    if(is_numeric($data['never_loss']) && $data['never_loss']>0 && $data['never_loss']<=100 && !empty($data['never_loss'])){
                        $adddata['stop_loss'] = $data['never_loss'];
                    }else{
                        if(is_numeric($data['ng_loss']) && $data['ng_loss']>0 && $data['ng_loss']<=100 && !empty($data['ng_loss'])){
                            $adddata['stop_loss'] = $data['ng_loss'];
                        }else{
                            return WPreturn('止损在1%~100%之间',-1);
                        }
                    }*/
        
                    if(is_numeric($data['move_share']) && $data['move_share']>0 && preg_match("/^[1-9][0-9]*$/" ,$data['move_share']) && !empty($data['move_share'])){
                        $adddata['onumber'] = $data['move_share'];
                    }else{
                        return WPreturn(\think\Lang::get('od_qsrzqxdss'),-1);
                    }
        
                    $allcount = Db::name('order')->where(array('ostaus'=>0,'uid'=>$data['uid']))->count();
                    if($allcount >  $conf['max_order_count']){
                        return WPreturn(\think\Lang::get('od_zdccslw').$conf['max_order_count'].'！',-1);
                    }
        
                    if($user['jinjie'] == 0){
                        return WPreturn(\think\Lang::get('od_nwqx'),-1);
                    }
        
                    $numprice = Db::name('productinfo')->field('numprice,code')->where('pid='.$data['order_pid'])->find();
                    //手续费
                    $sx_fee = sprintf("%.8f",$data['move_share']*$numprice['numprice']* $data['newprice']*$web_poundage/100);
        
                    //杠杆
                    $code = explode(',',$numprice['code']);
        
                    if(in_array($data['code'],$code)){
                        $adddata['fee'] =  ($data['move_share']*$numprice['numprice']*$data['newprice'] )/$data['code'];//保证金
                        $adddata['code'] =  $data['code'];
                        $adddata['chicang'] =$data['move_share']*$numprice['numprice'];
                    }else{
                        return WPreturn(\think\Lang::get('od_ggcscw'),-1);
                    }
                    if($hou_money < ($adddata['fee'] + $sx_fee)){
                        return WPreturn($huobidui[1].\think\Lang::get('od_slbz'),-1);
                    }
        
                    //点差
                    $buyenter = Db::name('productinfo')->field('decimal,income_range')->where('pid',$data['order_pid'])->find();
                    $user_ferry = explode(',',$user['income_range']);
        
                    if($user_ferry[0]!=0||$user_ferry[1]!=0)
                    {
        
                        $ferry = explode(',',$user['income_range']);
                    }else
                    {
        
                        $ferry = explode(',',$buyenter['income_range']);
                    }
        
                    //入仓价
                    $digit = floatval($data['newprice']);
                    if($data['order_type'] == 1){
                        //跌
                        $spread = $digit - $ferry[1];
                    }else{
                        //涨
                        $spread = $digit + $ferry[0];
                    }
        
                    //建仓
                    $adddata['buytime'] = time();
                    $adddata['is_timing'] = 1;
                    $adddata['night_time'] = time();
                    $adddata['pid'] = $data['order_pid'];
                    $adddata['ostyle'] = $data['order_type'];
                    $adddata['buyprice'] = $spread;
                    $adddata['realprice'] = $data['newprice'];
                    $adddata['eid'] = 2;
                    $adddata['ptitle'] = db('productinfo')->where('pid',$data['order_pid'])->value('ptitle');
                    $adddata['ostaus']='0';
                    $adddata['sx_fee']=$sx_fee;
        
        
                    //订单号
                    $adddata['orderno']=date('YmdHis').rand(1111,9999);
                    //下单
                    $ids = Db::name('order')->insertGetId($adddata);
                    if($ids){
        
                        if($data['order_type']==0){
                            //做多
        
                            log_account_change($this->uid,2,$huobidui[1],-1*$adddata['fee'],0,\think\Lang::get('od_hyjyzd').$huobidui[0].\think\Lang::get('od_kj'),0);
                            //手续费
                            log_account_change($this->uid,2,$huobidui[1],-1*$sx_fee,0,\think\Lang::get('od_hyjyzd').$huobidui[0].\think\Lang::get('od_kjsxf'),0);
                        }else{
                            //做空
                            log_account_change($this->uid,2,$huobidui[1],-1*$adddata['fee'],0,\think\Lang::get('od_hyzk').$huobidui[0].\think\Lang::get('od_kj'),0);
                            //手续费
                            log_account_change($this->uid,2,$huobidui[1],-1*$sx_fee,0,\think\Lang::get('od_hyzk').$huobidui[0].\think\Lang::get('od_kjsxf'),0);
                        }
                        return WPreturn(\think\Lang::get('od_xdcg'),1);
        
                    }else{
                        return WPreturn(\think\Lang::get('od_xdsbqcs'),-1);
                    }
                    
                }else{
                    $adddata = array();
                    $adddata['uid'] = $data['uid']=$this->uid;
                    $conf = $this->conf;

                    $adddata['stop_win'] = 0;
                    $adddata['stop_loss'] =0;
                    /*if(is_numeric($data['never_win']) && $data['never_win']>0 && $data['never_win']<1000 && !empty($data['never_win'])){
                        $adddata['stop_win'] = $data['never_win'];
                    }else{
                        if(is_numeric($data['ng_win']) && $data['ng_win']>0 && $data['ng_win']<1000 && !empty($data['ng_win'])){
                            $adddata['stop_win'] = $data['ng_win'];
                        }else{
                            return WPreturn('止盈在1%~999%之间',-1);
                        }
                    }
                    if(is_numeric($data['never_loss']) && $data['never_loss']>0 && $data['never_loss']<=100 && !empty($data['never_loss'])){
                        $adddata['stop_loss'] = $data['never_loss'];
                    }else{
                        if(is_numeric($data['ng_loss']) && $data['ng_loss']>0 && $data['ng_loss']<=100 && !empty($data['ng_loss'])){
                            $adddata['stop_loss'] = $data['ng_loss'];
                        }else{
                            return WPreturn('止损在1%~100%之间',-1);
                        }
                    }*/

                    if(is_numeric($data['move_share']) && $data['move_share']>0 && preg_match("/^[1-9][0-9]*$/" ,$data['move_share']) && !empty($data['move_share'])){
                        $adddata['onumber'] = $data['move_share'];
                    }else{
                        return WPreturn(\think\Lang::get('od_qsrzqxdss'),-1);
                    }

                    $allcount = Db::name('order')->where(array('ostaus'=>0,'uid'=>$data['uid']))->count();
                    if($allcount >  $conf['max_order_count']){
                        return WPreturn(\think\Lang::get('od_zdccslw').$conf['max_order_count'].'！',-1);
                    }

                    if($user['jinjie'] == 0){
                        return WPreturn(\think\Lang::get('od_nwqx'),-1);
                    }

                    $numprice = Db::name('productinfo')->field('numprice,code')->where('pid='.$data['order_pid'])->find();
                    //手续费
                    $sx_fee = sprintf("%.8f",$data['move_share']*$numprice['numprice']* $data['newprice']*$web_poundage/100);

                    //杠杆
                    $code = explode(',',$numprice['code']);

                    if(in_array($data['code'],$code)){
                        $adddata['fee'] =  ($data['move_share']*$numprice['numprice']*$data['newprice'] )/$data['code'];//保证金
                        $adddata['code'] =  $data['code'];
                        $adddata['chicang'] =$data['move_share']*$numprice['numprice'];
                    }else{
                        return WPreturn(\think\Lang::get('od_ggcscw'),-1);
                    }
                    if($hou_money < ($adddata['fee'] + $sx_fee)){
                        return WPreturn($huobidui[1].\think\Lang::get('od_slbz'),-1);
                    }

                    //建仓
                    $adddata['buytime'] = time();
                    $adddata['is_timing'] = 1;
                    $adddata['night_time'] = time();
                    $adddata['pid'] = $data['order_pid'];
                    $adddata['ostyle'] = $data['order_type'];
                    $adddata['buyprice'] = $data['newprice'];
                    $adddata['realprice'] = $data['newprice'];
                    $adddata['eid'] = 2;
                    $adddata['ptitle'] = db('productinfo')->where('pid',$data['order_pid'])->value('ptitle');
                    $adddata['ostaus']='2';
                    $adddata['sx_fee']=$sx_fee;

                    //订单号
                    $adddata['orderno']=date('YmdHis').rand(1111,9999);
                    //下单
                    $ids = Db::name('order')->insertGetId($adddata);
                    if($ids){

                        log_account_change($this->uid,2,$huobidui[1],-1*$adddata['fee'],0,\think\Lang::get('od_hyzk').$huobidui[0].\think\Lang::get('od_kj'),0);
                        //手续费
                        log_account_change($this->uid,2,$huobidui[1],-1*$sx_fee,0,\think\Lang::get('od_hyzk').$huobidui[0].\think\Lang::get('od_kjsxf'),0);

                        log_account_change($this->uid,2,$huobidui[1],0,$adddata['fee'],\think\Lang::get('od_hyzk').$huobidui[0].\think\Lang::get('od_djbzj'),0);
                        //手续费
                        log_account_change($this->uid,2,$huobidui[1],0,$sx_fee,\think\Lang::get('od_hyzk').$huobidui[0].\think\Lang::get('od_djsxf'),0);

                        return WPreturn(\think\Lang::get('od_xdcg'),1);

                    }else{
                        return WPreturn(\think\Lang::get('od_xdsbqcs'),-1);
                    }
                }
            }
        }

        if($data['price_type']==\think\Lang::get('bi_sj')){
            //立即成交
            $data['newprice'] = $pr['Price'];
            $adddata = array();
            $adddata['uid'] = $data['uid']=$this->uid;
            $conf = $this->conf;

            $adddata['stop_win'] = 0;
            $adddata['stop_loss'] =0;
            /*if(is_numeric($data['never_win']) && $data['never_win']>0 && $data['never_win']<1000 && !empty($data['never_win'])){
                $adddata['stop_win'] = $data['never_win'];
            }else{
                if(is_numeric($data['ng_win']) && $data['ng_win']>0 && $data['ng_win']<1000 && !empty($data['ng_win'])){
                    $adddata['stop_win'] = $data['ng_win'];
                }else{
                    return WPreturn('止盈在1%~999%之间',-1);
                }
            }
            if(is_numeric($data['never_loss']) && $data['never_loss']>0 && $data['never_loss']<=100 && !empty($data['never_loss'])){
                $adddata['stop_loss'] = $data['never_loss'];
            }else{
                if(is_numeric($data['ng_loss']) && $data['ng_loss']>0 && $data['ng_loss']<=100 && !empty($data['ng_loss'])){
                    $adddata['stop_loss'] = $data['ng_loss'];
                }else{
                    return WPreturn('止损在1%~100%之间',-1);
                }
            }*/

            if(is_numeric($data['move_share']) && $data['move_share']>0 && preg_match("/^[1-9][0-9]*$/" ,$data['move_share']) && !empty($data['move_share'])){
                $adddata['onumber'] = $data['move_share'];
            }else{
                return WPreturn(\think\Lang::get('od_qsrzqxdss'),-1);
            }

            $allcount = Db::name('order')->where(array('ostaus'=>0,'uid'=>$data['uid']))->count();
            if($allcount >  $conf['max_order_count']){
                return WPreturn(\think\Lang::get('od_zdccslw').$conf['max_order_count'].'！',-1);
            }

            if($user['jinjie'] == 0){
                return WPreturn(\think\Lang::get('od_nwqx'),-1);
            }

            $numprice = Db::name('productinfo')->field('numprice,code')->where('pid='.$data['order_pid'])->find();
            //手续费
            $sx_fee = sprintf("%.8f",$data['move_share']*$numprice['numprice']* $data['newprice']*$web_poundage/100);

            //杠杆
            $code = explode(',',$numprice['code']);

            if(in_array($data['code'],$code)){
                $adddata['fee'] =  ($data['move_share']*$numprice['numprice']*$data['newprice'] )/$data['code'];//保证金
                $adddata['code'] =  $data['code'];
                $adddata['chicang'] =$data['move_share']*$numprice['numprice'];
            }else{
                return WPreturn(\think\Lang::get('od_ggcscw'),-1);
            }
            if($hou_money < ($adddata['fee'] + $sx_fee)){
                return WPreturn($huobidui[1].\think\Lang::get('od_slbz'),-1);
            }

            //点差
            $buyenter = Db::name('productinfo')->field('decimal,income_range')->where('pid',$data['order_pid'])->find();
            $user_ferry = explode(',',$user['income_range']);

            if($user_ferry[0]!=0||$user_ferry[1]!=0)
            {

                $ferry = explode(',',$user['income_range']);
            }else
            {

                $ferry = explode(',',$buyenter['income_range']);
            }

            //入仓价
            $digit = floatval($data['newprice']);
            if($data['order_type'] == 1){
                //跌
                $spread = $digit - $ferry[1];
            }else{
                //涨
                $spread = $digit + $ferry[0];
            }

            //建仓
            $adddata['buytime'] = time();
            $adddata['is_timing'] = 1;
            $adddata['night_time'] = time();
            $adddata['pid'] = $data['order_pid'];
            $adddata['ostyle'] = $data['order_type'];
            $adddata['buyprice'] = $spread;
            $adddata['realprice'] = $data['newprice'];
            $adddata['eid'] = 2;
            $adddata['ptitle'] = db('productinfo')->where('pid',$data['order_pid'])->value('ptitle');
            $adddata['ostaus']='0';
            $adddata['sx_fee']=$sx_fee;


            //订单号
            $adddata['orderno']=date('YmdHis').rand(1111,9999);
            //下单
            $ids = Db::name('order')->insertGetId($adddata);
            if($ids){

                if($data['order_type']==0){
                    //做多

                    log_account_change($this->uid,2,$huobidui[1],-1*$adddata['fee'],0,\think\Lang::get('od_hyjyzd').$huobidui[0].\think\Lang::get('od_kj'),0);
                    //手续费
                    log_account_change($this->uid,2,$huobidui[1],-1*$sx_fee,0,\think\Lang::get('od_hyjyzd').$huobidui[0].\think\Lang::get('od_kjsxf'),0);
                }else{
                    //做空
                    log_account_change($this->uid,2,$huobidui[1],-1*$adddata['fee'],0,\think\Lang::get('od_hyzk').$huobidui[0].\think\Lang::get('od_kj'),0);
                    //手续费
                    log_account_change($this->uid,2,$huobidui[1],-1*$sx_fee,0,\think\Lang::get('od_hyzk').$huobidui[0].\think\Lang::get('od_kjsxf'),0);
                }
                return WPreturn(\think\Lang::get('od_xdcg'),1);

            }else{
                return WPreturn(\think\Lang::get('od_xdsbqcs'),-1);
            }
        }
    }

    //币币下单
	public function addordersbibi()
	{

	
		$data = input('post.');
		//方向，产品，价格，手数，
		$arr = array('order_type','order_pid','newprice','move_share','price_type');
		//过滤
        foreach ($data as $k => $v) {
            if(!in_array($k,$arr)){
                return WPreturn(\think\Lang::get('od_cwpzx'),-1);
            }
        }
        $file = request()->file();
        if($file){
            return WPreturn(\think\Lang::get('od_cwpzx'),-1);
        }
         $data['price_type'] = trim($data['price_type']);
        //用户信息
		$user = Db::name('userinfo')->where('uid',$this->uid)->find();
		//验证用户是否被冻结
		if($user['ustatus'] != 0){
			return WPreturn(\think\Lang::get('od_ndzhybdj'),-1);
		}
		
		
		if($user['smsh_state'] == 0){
			return WPreturn(\think\Lang::get('od_qtjsfzwcsmrz'),-1);
		}
		
		if($user['smsh_state'] == 1){
			return WPreturn(\think\Lang::get('od_smshzzswfcz'),-1);
		}
		
			if($user['smsh_state'] == 3){
			return WPreturn(\think\Lang::get('od_smrzsbqcxrz'),-1);
		}
		
    
        //产品信息
        $pr = GetProData($data['order_pid'],'pi.ptitle,pi.procode,pi.protime,pi.propoint,pi.proscale,pi.numprice,pi.code,pd.*');
        if(!$pr){
            return WPreturn(\think\Lang::get('od_jyhbdccz'),-1);
        }
        
        
        //用户余额
        $huobidui = explode('/',$pr['ptitle']);
        $qian_money = get_money($this->uid,1,$huobidui[0]);
        $hou_money = get_money($this->uid,1,$huobidui[1]);
        
        //手续费
        $shouxufei = getconf('bibi_sxfee');
        $shouxufei = explode('|',$shouxufei);

        if($user['level']=='level_zero')
        {
            $web_poundage =$shouxufei[0];
        }elseif($user['level']=='level_one')
        {
            $web_poundage =$shouxufei[1];
        }elseif($user['level']=='level_two')
        {
            $web_poundage =$shouxufei[2];
        }
        elseif($user['level']=='level_three')
        {
            $web_poundage =$shouxufei[3];
        }
        elseif($user['level']=='level_four')
        {
            $web_poundage =$shouxufei[4];
        }
        
        
        if($data['price_type']=='限价'){
            
           if($data['order_type']==0){
               //委托买入
               if($data['newprice']>=$pr['Price']){
                   //高价委托买，立即成交
                    $data['newprice'] = $pr['Price'];
                    $adddata = array();
            		$adddata['uid'] = $data['uid']=$this->uid;
            		$conf = $this->conf;
            		if(is_numeric($data['move_share']) && $data['move_share']>0  && !empty($data['move_share'])){
            			$adddata['onumber'] = $data['move_share'];
            			$adddata['chicang'] = $data['move_share'];
            		}else{
            			return WPreturn(\think\Lang::get('od_qsrzqdjysl'),-1);
            		}
            		
            		//手续费
            		$sx_fee = sprintf("%.8f",$data['move_share']* $data['newprice']*$web_poundage/100);
            		//买入
            		
        		   if(($sx_fee + $data['move_share']* $data['newprice'])>$hou_money) {
        		       
        		       return WPreturn($huobidui[1].\think\Lang::get('od_slbz'),-1);
        		       
        		   }
        		   //交易额
        		   $adddata['fee'] =   $data['move_share']* $data['newprice'];
            		   
            	
            		
            		//建仓
            		$adddata['buytime'] = time();
            		$adddata['selltime'] = time();
            		$adddata['is_timing'] = 2;
            	
            		$adddata['pid'] = $data['order_pid'];
            		$adddata['ostyle'] = $data['order_type'];
            		
        		    //买入
        		    $adddata['buyprice'] = $data['newprice'];
        		    $adddata['sellprice'] = $data['newprice'];
        		    //会员建仓后金额
                   // $adddata['commission'] = $qian_money + $data['move_share'];
            	
            		$adddata['realprice'] = $data['newprice'];
            
            		$adddata['eid'] = 3;
            
                    $adddata['ptitle'] = db('productinfo')->where('pid',$data['order_pid'])->value('ptitle');
                    $adddata['ostaus']='1';
                    $adddata['sx_fee']=$sx_fee;
        
                    //订单号
                    $adddata['orderno']=date('YmdHis').rand(1111,9999);
                    //下单
                    $ids = Db::name('order')->insertGetId($adddata);
                    
                    if($ids){
                        
                        log_account_change($this->uid,1,$huobidui[0],$data['move_share'],0,\think\Lang::get('od_bbjymr'),0);
                        log_account_change($this->uid,1,$huobidui[1],-1*$adddata['fee'],0,\think\Lang::get('od_bbjymr').$huobidui[0].\think\Lang::get('od_kj'),0);
                        //手续费
                        log_account_change($this->uid,1,$huobidui[1],-1*$sx_fee,0,\think\Lang::get('od_bbjymr').$huobidui[0].\think\Lang::get('od_kjsxf'),0);
                       
                    	return WPreturn(\think\Lang::get('od_xdcg'),1);
                    
                    }else{
                    	return WPreturn(\think\Lang::get('od_xdsbqcs'),-1);
                    }
               }else{
                   //低价委托买，委托成功
            		$adddata = array();
            		$adddata['uid'] = $data['uid']=$this->uid;
            		$conf = $this->conf;
            		if(is_numeric($data['move_share']) && $data['move_share']>0  && !empty($data['move_share'])){
            			$adddata['onumber'] = $data['move_share'];
            			$adddata['chicang'] = $data['move_share'];
            		}else{
            			return WPreturn(\think\Lang::get('od_qsrzqdjysl'),-1);
            		}
            		
            		//手续费
            		$sx_fee = sprintf("%.8f",$data['move_share']* $data['newprice']*$web_poundage/100);
            		//买入
            		
        		   if(($sx_fee + $data['move_share']* $data['newprice'])>$hou_money) {
        		       
        		       return WPreturn($huobidui[1].\think\Lang::get('od_slbz'),-1);
        		       
        		   }
        		   //交易额
        		   $adddata['fee'] =   $data['move_share']* $data['newprice'];
            		   
            		
            		
            		//建仓
            		$adddata['buytime'] = time();
            		$adddata['is_timing'] = 2;
            	
            		$adddata['pid'] = $data['order_pid'];
            		$adddata['ostyle'] = $data['order_type'];
            		
            		
        		    //买入
                    $adddata['buyprice'] = $data['newprice'];
            		$adddata['realprice'] = $data['newprice'];//委托价
            
            		$adddata['eid'] = 3;
            
                    $adddata['ptitle'] = db('productinfo')->where('pid',$data['order_pid'])->value('ptitle');
                    $adddata['ostaus']='2';
                    $adddata['sx_fee']=$sx_fee;
        
                    //订单号
                    $adddata['orderno']=date('YmdHis').rand(1111,9999);
                    //下单
                    $ids = Db::name('order')->insertGetId($adddata);
                    
                    if($ids){
                       
                       
                        //买入
                        log_account_change($this->uid,1,$huobidui[1],0,$adddata['fee'],\think\Lang::get('od_bbwtmr').$huobidui[0].\think\Lang::get('bii_dj'),0);
                        //手续费
                        log_account_change($this->uid,1,$huobidui[1],0,$sx_fee,\think\Lang::get('od_bbwtmr').$huobidui[0].\think\Lang::get('od_djsxf'),0);
                        //买入
                        log_account_change($this->uid,1,$huobidui[1],-1*$adddata['fee'],0,\think\Lang::get('od_bbwtmr').$huobidui[0].\think\Lang::get('bii_dj'),0);
                        //手续费
                        log_account_change($this->uid,1,$huobidui[1],-1*$sx_fee,0,\think\Lang::get('od_bbwtmr').$huobidui[0].\think\Lang::get('od_djsxf'),0);
                       
                    	return WPreturn(\think\Lang::get('od_xdcg'),1);
                    
                    }else{
                    	return WPreturn(\think\Lang::get('od_xdsbqcs'),-1);
                    }
                           
                   
               }
                
           }else{
               //委托卖出
               if($data['newprice']<=$pr['Price']){
                   //底价委托卖，立即成交
                   if($data['newprice']<0.9*$pr['Price']){
                       return WPreturn(\think\Lang::get('od_mcjvxgyzxjjs'),-1);
                   }else{
                       
                		$adddata = array();
                		$adddata['uid'] = $data['uid']=$this->uid;
                		$conf = $this->conf;
                		if(is_numeric($data['move_share']) && $data['move_share']>0  && !empty($data['move_share'])){
                			$adddata['onumber'] = $data['move_share'];
                			$adddata['chicang'] = $data['move_share'];
                		}else{
                			return WPreturn(\think\Lang::get('od_qsrzqdjysl'),-1);
                		}
                		
                		//手续费
                		$sx_fee = sprintf("%.8f",$data['move_share']* $data['newprice']*$web_poundage/100);
                		
            		    //卖出
            		    if($data['move_share']>$qian_money) {
            		       
            		       return WPreturn($huobidui[0].\think\Lang::get('od_slbz'),-1);
            		       
            		    }
            		    //交易额
            		    $adddata['fee'] =   $data['move_share']* $data['newprice'];
                	
                		//建仓
                		$adddata['buytime'] = time();
                		$adddata['selltime'] = time();
                		$adddata['is_timing'] = 2;
                	
                		$adddata['pid'] = $data['order_pid'];
                		$adddata['ostyle'] = $data['order_type'];
                		
                		
            		    $adddata['buyprice'] = $data['newprice'];
            		    $adddata['sellprice'] = $data['newprice'];
            		     //会员建仓后金额
                        //$adddata['commission'] = $qian_money - $data['move_share'];
                		
                		$adddata['realprice'] = $data['newprice'];
                
                		$adddata['eid'] = 3;
                
                        $adddata['ptitle'] = db('productinfo')->where('pid',$data['order_pid'])->value('ptitle');
                        $adddata['ostaus']='1';
                        $adddata['sx_fee']=$sx_fee;
            
                        //订单号
                        $adddata['orderno']=date('YmdHis').rand(1111,9999);
                        //下单
                        $ids = Db::name('order')->insertGetId($adddata);
                        
                        if($ids){
                            
                            //卖出
                            log_account_change($this->uid,1,$huobidui[0],-1*$data['move_share'],0,\think\Lang::get('od_bbjymc'),0);
                            log_account_change($this->uid,1,$huobidui[1],$adddata['fee'],0,\think\Lang::get('od_bbjymc').$huobidui[0].\think\Lang::get('od_zhengjia'),0);
                             //手续费
                             log_account_change($this->uid,1,$huobidui[1],-1*$sx_fee,0,\think\Lang::get('od_bbjymc').$huobidui[0].\think\Lang::get('od_kjsxf'),0);

                        	return WPreturn(\think\Lang::get('od_xdcg'),1);
                        
                        }else{
                        	return WPreturn(\think\Lang::get('od_xdsbqcs'),-1);
                        }
                   }
                   
               }else{
                   //高价委托卖，委托成功
                  
            		$adddata = array();
            		$adddata['uid'] = $data['uid']=$this->uid;
            		$conf = $this->conf;
            		if(is_numeric($data['move_share']) && $data['move_share']>0  && !empty($data['move_share'])){
            			$adddata['onumber'] = $data['move_share'];
            			$adddata['chicang'] = $data['move_share'];
            		}else{
            			return WPreturn(\think\Lang::get('od_qsrzqdjysl'),-1);
            		}
            		
            		//手续费
            		$sx_fee = sprintf("%.8f",$data['move_share']* $data['newprice']*$web_poundage/100);
            		
            		
        		    //卖出
        		    if($data['move_share']>$qian_money) {
        		       
        		       return WPreturn($huobidui[0].\think\Lang::get('od_slbz'),-1);
        		       
        		    }
        		    //交易额
        		    $adddata['fee'] =   $data['move_share']* $data['newprice'];
            	
            		
            		//建仓
            		$adddata['buytime'] = time();
            		
            		$adddata['is_timing'] = 2;
            	
            		$adddata['pid'] = $data['order_pid'];
            		$adddata['ostyle'] = $data['order_type'];



                   $adddata['buyprice'] = $data['newprice'];
            		$adddata['realprice'] = $data['newprice'];
            
            		$adddata['eid'] = 3;
            
                    $adddata['ptitle'] = db('productinfo')->where('pid',$data['order_pid'])->value('ptitle');
                    $adddata['ostaus']='2';
                    $adddata['sx_fee']=$sx_fee;
        
                    //订单号
                    $adddata['orderno']=date('YmdHis').rand(1111,9999);
                    //下单
                    $ids = Db::name('order')->insertGetId($adddata);
                    
                    if($ids){
                        
                        //卖出
                        log_account_change($this->uid,1,$huobidui[0],-1*$data['move_share'],0,\think\Lang::get('od_bbjywtmc').$huobidui[0].\think\Lang::get('bii_dj'),0);
                       
                        log_account_change($this->uid,1,$huobidui[0],0,$data['move_share'],\think\Lang::get('od_bbjywtmc').$huobidui[0].\think\Lang::get('bii_dj'),0);
                        
                        
                    	return WPreturn(\think\Lang::get('od_xdcg'),1);
                    
                    }else{
                    	return WPreturn(\think\Lang::get('od_xdsbqcs'),-1);
                    }
               }
           }
            
    		
        }
     	
        if($data['price_type']=='市价'){
            
            //价格
            $data['newprice'] = $pr['Price'];
    		$adddata = array();
    		$adddata['uid'] = $data['uid']=$this->uid;
    		$conf = $this->conf;
    		if(is_numeric($data['move_share']) && $data['move_share']>0  && !empty($data['move_share'])){
    			$adddata['onumber'] = $data['move_share'];
    			$adddata['chicang'] = $data['move_share'];
    		}else{
    			return WPreturn(\think\Lang::get('od_qsrzqdjysl'),-1);
    		}
    		
    		//手续费
    		$sx_fee = sprintf("%.8f",$data['move_share']* $data['newprice']*$web_poundage/100);
    		//买入
    		if($data['order_type']==0){
    		    
    		   if(($sx_fee + $data['move_share']* $data['newprice'])>$hou_money) {
    		       
    		       return WPreturn($huobidui[1].\think\Lang::get('od_slbz'),-1);
    		       
    		   }
    		   //交易额
    		   $adddata['fee'] =   $data['move_share']* $data['newprice'];
    		   
    		}else{
    		    //卖出
    		    if($data['move_share']>$qian_money) {
    		       
    		       return WPreturn($huobidui[0].\think\Lang::get('od_slbz'),-1);
    		       
    		    }
    		    //交易额
    		    $adddata['fee'] =   $data['move_share']* $data['newprice'];
    		}
    		
    		//建仓
    		$adddata['buytime'] = time();
    		$adddata['selltime'] = time();
    		$adddata['is_timing'] = 2;
    	
    		$adddata['pid'] = $data['order_pid'];
    		$adddata['ostyle'] = $data['order_type'];
    		
    		if($data['order_type']==0){
    		    //买入
    		    $adddata['buyprice'] = $data['newprice'];
    		    $adddata['sellprice'] = $data['newprice'];
    		    //会员建仓后金额
                //$adddata['commission'] = $qian_money + $data['move_share'];
    		}else{
    		    //卖出
    		    $adddata['buyprice'] = $data['newprice'];
    		    $adddata['sellprice'] = $data['newprice'];
    		     //会员建仓后金额
                //$adddata['commission'] = $qian_money - $data['move_share'];
    		}
    		$adddata['realprice'] = $data['newprice'];
    
    		$adddata['eid'] = 3;
    
            $adddata['ptitle'] = db('productinfo')->where('pid',$data['order_pid'])->value('ptitle');
            $adddata['ostaus']='1';
            $adddata['sx_fee']=$sx_fee;

            //订单号
            $adddata['orderno']=date('YmdHis').rand(1111,9999);
            //下单
            $ids = Db::name('order')->insertGetId($adddata);
            
            if($ids){
                if($data['order_type']==0){
                    //买入
                    log_account_change($this->uid,1,$huobidui[0],$data['move_share'],0,\think\Lang::get('od_bbjymr'),0);
                    log_account_change($this->uid,1,$huobidui[1],-1*$adddata['fee'],0,\think\Lang::get('od_bbjymr').$huobidui[0].\think\Lang::get('od_kj'),0);
                    //手续费
                    log_account_change($this->uid,1,$huobidui[1],-1*$sx_fee,0,\think\Lang::get('od_bbjymr').$huobidui[0].\think\Lang::get('od_kjsxf'),0);
                }else{
                    //卖出
                    log_account_change($this->uid,1,$huobidui[0],-1*$data['move_share'],0,\think\Lang::get('od_bbjymc'),0);
                    log_account_change($this->uid,1,$huobidui[1],$adddata['fee'],0,\think\Lang::get('od_bbjymc').$huobidui[0].\think\Lang::get('od_zhengjia'),0);
                     //手续费
                     log_account_change($this->uid,1,$huobidui[1],-1*$sx_fee,0,\think\Lang::get('od_bbjymc').$huobidui[0].\think\Lang::get('od_kjsxf'),0);
                }
                
                
            	
            	return WPreturn(\think\Lang::get('od_xdcg'),1);
            
            }else{
            	return WPreturn(\think\Lang::get('od_xdsbqcs'),-1);
            }
        }
        
	}
	/**
	 * ajax 通过产品id 获取用户订单，
	 * @author lukui  2017-07-22
	 * @return [type] [description]
	 */
	public function ajaxorder()
	{
		$uid = $_SESSION['uid'];
		$pid = input('param.pid');
		if (empty($uid) || empty($pid)) {
			return false;
		}
		//持仓信息
		$map = array('uid'=>$uid,'ostaus'=>0,'pid'=>$pid);
		// $map['selltime'] = array('gt',time());
		$hold = Db::name('order')->where($map)->order('oid desc')->select();
		if($hold){
			$hold[0]['time'] = time();
		}
		if($hold){
			return base64_encode(json_encode($hold));
		}else{
			return false;
		}


	}

	/**
	 * ajax 获取用户未平仓订单，
	 * @author lukui  2017-07-22
	 * @return [type] [description]
	 */
	public function ajaxorder_list()
	{
		$uid = $this->uid;
		if (empty($uid)) {
			return false;
		}
		//持仓信息
		$map = array('uid'=>$uid,'ostaus'=>0,'is_timing'=>0);
		// $map['selltime'] = array('gt',time());

		$hold = Db::name('order')->where($map)->order('oid desc')->select();
		if($hold){
			$hold[0]['time'] = time();
			foreach ($hold as $k => $v){
				if($v['is_timing'] == 1){
					$code = Db::name('productinfo')->field('code,decimal,procode')->where('pid='.$v['pid'])->find();
					$hold[$k]['point'] = $code['decimal'];
					//$hold[$k]['code'] = $code['code'];
                    $hold[$k]['procode'] =strtoupper($code['procode']);
					$hold[$k]['isopen'] = ChickIsOpen($v['pid']);
				}
			}
		}
		if($hold){
			return base64_encode(json_encode($hold));
		}else{
			return false;
		}
	}

	public function get_price()
	{


		//此刻产品价格
		$p_map['isdelete'] = 0;
		$pro = db('productdata')->field('pid,Price')->where($p_map)->select();
		$prodata = array();
		foreach ($pro as $k => $v) {
			$prodata[$v['pid']] = $v['Price'];
		}
		return base64_encode(json_encode($prodata));;

	}
	/**
	 * ajax 通过产品id 平仓后弹框提示，
	 * @author lukui  2017-07-22
	 * @return [type] [description]
	 */
	public function ajaxalert()
	{
		$uid = $_SESSION['uid'];
		$pid = input('param.pid');
		if (empty($uid) || empty($pid)) {
			return false;
		}
		//持仓信息
		$hold = Db::name('order')->field('oid,ploss,fee,eid')->where(array('uid'=>$uid,'ostaus'=>1,'pid'=>$pid,'isshow'=>0))->order('oid desc')->find();
		//修改持仓信息
		$isedit = Db::name('order')->where('oid',$hold['oid'])->setField('isshow','1');
		if($hold && $isedit){
			return $hold;
		}else{
			return false;
		}


	}


	/**
	 * 持仓列表
	 * @author lukui  2017-07-18
	 * @return [type] [description]
	 */
	public function hold()
	{
		$uid = $_SESSION['uid'];
		$hold = Db::name('order')->field('oid,ptitle,buytime,fee,ostyle')->where(array('uid'=>$uid,'ostaus'=>0,'is_timing' => 0))->order('oid desc')->select();
		$this->assign('hold',$hold);
		return $this->fetch();
	}


	public function holdinfo()
	{
		$uid = $_SESSION['uid'];
		$oid = input('param.oid');
		if(!$oid){
			$this->redirect('hold');
		}
		$order = Db::name('order')->where('oid',$oid)->find();
		$this->assign($order);
		return $this->fetch();


	}


	/**
	 * 订单列表
	 * @author lukui  2017-07-18
	 * @return [type] [description]
	 */
	public function orderlist()
	{
		$uid = $this->uid;
		$hold = Db::name('order')->where(array('uid'=>$uid,'ostaus'=>1,'is_timing' => 0))->order('selltime desc')->paginate(20);
		return base64_encode(json_encode($hold));
	}




	/**
	 * 已平仓订单详情
	 * @author lukui  2017-07-21
	 * @return [type] [description]
	 */
	public function orderinfo()
	{
		$uid = $_SESSION['uid'];
		$oid = input('param.oid');
		if(!$oid){
			$this->redirect('orderlist');
		}
		$order = Db::name('order')->where('oid',$oid)->find();
		$this->assign($order);
		return $this->fetch();

	}



	/**
	 * 实时获取以平仓订单
	 * @return [type] [description]
	 */
	public function get_this_order()
	{
		//sleep(2);

		$oid = input('param.oid');
		$map['oid'] = $oid;
		$map['ostaus'] = 1;


		$order = db('order')->where($map)->find();

		return base64_encode(json_encode($order));

	}

	/**
	 * 实时获取以平仓订单
	 * @return [type] [description]
	 */
	public function get_hold_order()
	{


		$oid = input('param.oid');
		$map['oid'] = $oid;
		$map['ostaus'] = 1;
        $map['is_timing'] = 0;

		$order = db('order')->where($map)->find();

		return base64_encode(json_encode($order));

	}


	//平仓
	public function goorder()
	{
		$oid = input('oid');
		$price = input('price');
		$order_rand = input('order_rand');

		$static = 1;		//1成功返回并继续运行  0失败返回不运行  2 失败返回继续轮询
		if(!$oid || !$price || !$order_rand ){
			die('0');
		}


		$order = db('order')->where('oid',$oid)->find();

		//没有此订单
		if(!$order ){
			die('0');
		}
		$info = db("userinfo")->where('uid',$order['uid'])->find();
		if($order_rand != cache('goorder_'.$order['oid'])){
			die('0');
		}

		//没有平仓
		if(isset($order['ostyle']) && $order['ostaus'] == 0){
			die('2');
		}

		//已平仓 但是价格相同
		if(isset($order['sellprice']) && $order['sellprice'] == $price){
			cache('goorder_'.$order['oid'],null);
			die('1');
		}

		//已平仓 但是无效交易
		if(isset($order['is_win']) && $order['is_win'] == 3){
			cache('goorder_'.$order['oid'],null);
			die('1');
		}

		if(isset($info['chance']) && $info['chance'] > 0){
			cache('goorder_'.$order['oid'],null);
			die('1');
		}

		//该订单指定赢亏
		if(isset($order['kong_type']) && $order['kong_type'] != 0){
			cache('goorder_'.$order['oid'],null);
			die('1');
		}

        //已平仓
        if($order['ostaus'] == 1){
            cache('goorder_'.$order['oid'],null);
            die('3');
        }


		//该用户指定赢亏
		/*$risk = db('risk')->find();
		$to_win = explode('|',$risk['to_win']);
		$to_loss = explode('|',$risk['to_loss']);
		if(in_array($order['uid'],$to_win) || in_array($order['uid'],$to_loss)){
			cache('goorder_'.$order['oid'],null);
			die('1');
		}*/

		//已平仓 但是价格不相同
		/*if(isset($order['sellprice']) && $order['sellprice'] != $price){

			//资金变动日志
			$p_map['title'] = '结单';
			$p_map['oid'] = $order['oid'];

			$price_log = db('price_log')->where($p_map)->find();

			if(!$price_log){
				die('2');
			}


			$_data['oid'] = $oid;
			$_data['sellprice'] = $price;





			//买跌 赢利 ||  买涨 赢利
			if($order['ostyle'] == 1 && $order['buyprice'] < $price && $order['is_win'] == 1 ||
				$order['ostyle'] == 0 && $order['buyprice'] > $price && $order['is_win'] == 1){

				$_data['is_win'] = 2;
				$_data['ploss'] = $order['fee']*(-1);

				$u_add = 0;

				$d_add = $price_log['account'];

				db('userinfo')->where('uid',$price_log['uid'])->setDec('usermoney',$d_add);

				$price_log['account'] = round($order['fee']*($order['endloss']/100),2)*(-1);
               	$price_log['type'] = 2;

				db('price_log')->update($price_log);

               	db('price_log')->where('id',$price_log['id'])->delete();
               	$this->order_price_log($order['oid'],$order);

               	db('order_log')->where('oid',$order['oid'])->delete();
               	//写入日志
	           	$api = controller('api');
	           	$api->set_order_log($order,$u_add);




			}

			//买跌 亏损 ||  买涨 亏损
			if($order['ostyle'] == 1 && $order['buyprice'] > $price && $order['is_win'] == 2 ||
				$order['ostyle'] == 0 && $order['buyprice'] < $price && $order['is_win'] == 2){

				$_data['is_win'] = 1;
				$yingli = $order['fee']*($order['endloss']/100);
				$_data['ploss'] = $yingli;

				//平仓增加用户金额
               	$u_add = $yingli + $order['fee'];
               	db('userinfo')->where('uid',$order['uid'])->setInc('usermoney',$u_add);



               	db('price_log')->where('id',$price_log['id'])->delete();


               	$this->order_price_log($order['oid'],$order);

               	db('order_log')->where('oid',$order['oid'])->delete();
               	//写入日志
	           	$api = controller('api');
	           	$api->set_order_log($order,$u_add);

			}

			//无效交易
			if( $price == $order['buyprice'] && $order['is_win'] != 3){

				$_data['ploss'] = 0;
				$_data['is_win'] = 3;
				$u_add = $order['ploss'];

				db('userinfo')->where('uid',$order['uid'])->setDec('usermoney',$u_add);


				db('price_log')->where('id',$price_log['id'])->delete();
               	//写入日志
	           	$api = controller('api');

	           	db('order_log')->where('oid',$order['oid'])->delete();

	           	$api->set_order_log($order,$u_add);


				$dbuser = db('userinfo');
				$dbplog = db('price_log');
				$map['oid'] = $oid;
				$map['title'] = "对冲";
				$list = $dbplog->where($map)->select();

				foreach ($list as $key => $value) {



					if($value['account'] > 0){
						$_add = $value['account'];
						$dbuser->where('uid',$value['uid'])->setDec('usermoney',$_add);
					}elseif($value['account'] < 0){
						$_add = $value['account']*(-1);
						$dbuser->where('uid',$value['uid'])->setInc('usermoney',$_add);
					}

					$_update['id'] = $value['id'];


					$dbplog->where($_update)->delete();

				}

			}




			db('order')->update($_data);
			cache('goorder_'.$order['oid'],null);
			die('3');



		}*/



	}

	public function getspread(){
		$data = input('post.');
		$proinfo = Db::name('productinfo')->field('decimal,income_range')->where('pid',$data['order_pid'])->find();
		$proprice = Db::name('productdata')->field('price')->where('pid',$data['order_pid'])->find();
		$ferry = explode(',',$proinfo['income_range']);
		if($data['order_type'] == 0){
			return $ferry[0]/pow(10,intval($proinfo['decimal']));
		}else{
			return $ferry[1]/pow(10,intval($proinfo['decimal']));
		}
	}

	public function order_price_log($oid,$order)
	{
		if(!$oid || !$order){
			return false;
		}
		$dbuser = db('userinfo');
		$dbplog = db('price_log');
		$map['oid'] = $oid;
		$map['title'] = \think\Lang::get('od_dc');
		$list = $dbplog->where($map)->select();

		if(!$list) return false;
		foreach ($list as $key => $value) {



			if($value['account'] > 0){
				$_add = $value['account'] + $value['account']*($order['endloss']/100);
				$_update['account'] = $value['account']*($order['endloss']/100)*(-1);
				$dbuser->where('uid',$value['uid'])->setDec('usermoney',$_add);
				$_update['type'] = 2;
			}elseif($value['account'] < 0){
				$_add = $value['account']*(-1) + $value['account']*(-1)/($order['endloss']/100);
				$_update['account'] = $value['account']*(-1)/($order['endloss']/100);
				$_update['type'] = 1;
				$dbuser->where('uid',$value['uid'])->setInc('usermoney',$_add);
			}

			$_update['id'] = $value['id'];
			$_update['nowmoney'] = $dbuser->where('uid',$value['uid'])->value('usermoney');

			$dbplog->update($_update);

		}



	}

	public function getchart()
    {
        $data['index'] = \think\Lang::get('ti_sy');
        $data['hangqing'] = \think\Lang::get('od_sphq');
        $data['jiaoyijilu'] = \think\Lang::get('iin_jyjl');
        $data['jiaoyilishi'] = \think\Lang::get('hd_mhyjyls');
        $data['chicangmingxi'] = \think\Lang::get('iin_ccmx');
        $data['lishimingxi'] =  \think\Lang::get('od_lsmx');

        $res = base64_encode(json_encode($data));
        return $res;
    }

    public function getFloatLength($num){
		$count = 0;
		$temp = explode ( '.', $num );
		if (sizeof ( $temp ) > 1) {
			$decimal = end ( $temp );
			$count = strlen ( $decimal );
		}
		return $count;
	}
}
