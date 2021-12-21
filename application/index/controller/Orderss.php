<?php
namespace app\index\controller;
use think\Db;


class Order extends Base
{

	/**
	 * 下单
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
		//持仓限制
		$allfee = Db::name('order')->where(array('ostaus'=>0,'uid'=>$data['uid']))->sum('fee');
		$allfee = $allfee?$allfee:0;
		/*
		if($allfee+$data['order_price'] > getconf('order_max_price')){
			return WPreturn('持仓最大为'.getconf('order_max_price').'！',-1);
		}
		*/
		if($data['order_price'] > $conf['order_max_price']){
			return WPreturn(\think\Lang::get('od_dbcczdw').$conf['order_max_price'].'！',-1);
		}
		$allcount = Db::name('order')->where(array('ostaus'=>0,'uid'=>$data['uid']))->count();
		if($allcount >  $conf['max_order_count']){
			return WPreturn(\think\Lang::get('od_zdccslw').$conf['max_order_count'].'！',-1);
		}
		//验证是否开市

		//用户信息
		$user = Db::name('userinfo')->field('ustatus,usermoney,uid')->where('uid',$data['uid'])->find();
		//验证用户是否被冻结
		if($user['ustatus'] != 0){
			return WPreturn(\think\Lang::get('od_ndzhybdj'),-1);
		}

		//手续费
		// $web_poundage = round($data['order_price']*$conf['web_poundage']/100,2);
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
        	$u_fee = $allfee;
        	$editmoney = Db::name('userinfo')->where('uid',$data['uid'])->setDec('usermoney',$u_fee);

        	$nowmoney = $adddata['commission'];
        	if($nowmoney < 0) $nowmoney=0;
        	set_price_log($data['uid'],2,$u_fee,\think\Lang::get('oe_xd'),\think\Lang::get('od_xdcg'),$ids,$nowmoney);

        	if($editmoney){
        		$adddata['oid'] = $ids;

        		//缓存加载验证
        		$order_rand = rand(1,1000);
        		cache('goorder_'.$ids,$order_rand,$adddata['endprofit']+10);
        		$adddata['order_rand'] = $order_rand;

        		$res = base64_encode(json_encode($adddata));
        		return WPreturn($res,1);
        	}else{
        		Db::table('order')->where('oid',$ids)->delete();
        		return WPreturn(\think\Lang::get('od_xdsbqcs'),-1);
        	}

        }else{
        	return WPreturn(\think\Lang::get('od_xdsbqcs'),-1);
        }
		//dump($data);
	}

	public function addorders()
	{

		// return WPreturn('未开通，请等待...',-1);
		$data = input('post.');
		$arr = array('order_type','order_pid','newprice','move_share','never_win','never_loss','ng_win','ng_loss');
        foreach ($data as $k => $v) {
            if(!in_array($k,$arr)){
                return WPreturn(\think\Lang::get('od_cwpzx'),-1);
            }
        }
        $file = request()->file();
        if($file){
            return WPreturn(\think\Lang::get('od_cwpzx'),-1);
        }
        //价格
        $pr= Db::name('productdata')->field('Price')->where