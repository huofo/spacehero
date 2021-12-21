<?php
namespace app\index\controller;
use think\Db;


class User extends Base
{

    /**
     * 用户个人中心首页
     * @author lukui  2017-07-21
     * @return [type] [description]
     */




    public function gesjy()
    {
        $uid = $this->uid;
        $user = Db::name('userinfo')->field('usermoney')->where('uid',$uid)->find();
        $this->assign($user);

        $url  = $this->conf['usdturl_trc20'];

        $this->assign('urltext',$url);

        $url = 'https://api.qrserver.com/v1/create-qr-code/?size=150%C3%97150&data='.$url;

        $this->assign('url',$url);

        return $this->fetch();

    }



    public function uppzimg()
    {
        $map['uid'] = $this->uid;

        $file = request()->file("file");
        if(empty($file)){
            exit(json_encode(array('error'=>1,'msg'=>\think\Lang::get('fbjy_qsczfpz'))));
        }
        $info = $file->validate(['size'=>52428800,'ext'=>'jpg,png,gif,jpeg'])->move(ROOT_PATH.'public'.DS.'uploads');
        if($info){
            $data = $info->getSaveName();

            $_SESSION['pz'] = $data;
            exit(json_encode(array('error'=>0,'msg'=>\think\Lang::get('ue_sccg'),'file_url'=>$data)));
        }else{
            // 上传失败获取错误信息
            $error = $file->getError();
            exit(json_encode(array('error'=>1,'msg'=>$error)));
        }



    }

    public function dorecharge(){
        $num = input('param.num');
        $usdt_type = input('param.usdt_type');
        $cbdz = input('param.cbdz');
        if(is_numeric($num) && $num>0  && !empty($num)){
            $data['bpprice'] = $num;

        }else{
            $result = array(
                'error' => 1,
                'msg' =>\think\Lang::get('ae_qsrzqczs') ,
            );
            echo json_encode($result);
            exit();
        }

        if($cbdz==''){
            $result = array(
                'error' => 1,
                'msg' =>\think\Lang::get('fbjy_qxzcbfs') ,
            );
            echo json_encode($result);
            exit();
        }

        $pz = $_SESSION['pz'];
        if(empty($pz)){
            $result = array(
                'error' => 1,
                'msg' =>\think\Lang::get('fbjy_qsczfpz') ,
            );
            echo json_encode($result);
            exit();
        }

        $data['bpbalance'] = Db::name('userinfo')->field('usermoney')->where('uid',$this->uid)->value('usermoney');
        $data['bptype'] = 3;
        $data['bptime'] = time();
        $data['remarks'] = \think\Lang::get('pa_cz').'AGC' ;
        $data['uid'] = $this->uid;
        $data['isverified'] = 0;
        $data['btime'] = time();
        $data['reg_par'] = 0;
        $data['pay_type'] = 'USDT';
        $data['usdt_url'] = $cbdz;
        $data['bizhong'] = 'AGC';
        $data['pingzheng'] = $pz;

        $data['usdt_type'] = $usdt_type;


        $data['balance_sn'] = $this->uid.time().rand(111111,999999);

        $ids = db('balance')->insertGetId($data);
        if(!$ids){
            $result = array(
                'error' => 1,
                'msg' =>\think\Lang::get('fbjy_tjsb') ,
            );
            echo json_encode($result);
            exit();
        }

        $result = array(
            'error' => 0,
            'msg' =>\think\Lang::get('cb_tjcg') ,
        );
        echo json_encode($result);
        exit();
    }


    public function qxmjfklist()
    {
        return $this->fetch();
    }

    public function ddmjqrsk()
    {
        $id = input('id');
        if(!$id){
            die('123');
        }
        $order_info = Db::name('currency_trade_order')->where('id',$id)->find();
        if($order_info['oid']){
            $seller_order = Db::name('currency_shevles_order')->where('id',$order_info['oid'])->find();
        }

        if($order_info['trade_type'] == 0){
            if($order_info['user_id'] != $this->uid){
                die('123');
            }
            $talk_side = Db::name('userinfo')->where('uid',$seller_order['user_id'])->count();
            $talk_side = $talk_side ? 1 : 0;
        }else{
            if($seller_order['user_id'] != $this->uid){
                die('123');
            }
            $talk_side = Db::name('userinfo')->where('uid',$order_info['user_id'])->count();
            $talk_side = $talk_side ? 1 : 0;
        }

        $currency = Db::name('currency')->where('name',$order_info['currency_type'])->find();


        $payment_type = db('payment_method')->where('id',$order_info['pay_id'])->find();
        $payment_type = change_payment_name($payment_type);

        $payment_method = $order_info['payment_method']?$order_info['payment_method']:$seller_order['payment_method'];
        $shoukuan = db('user_payment_method')->where('id',$payment_method)->find();
        //var_dump($payment_method);die;
        $payment = db('payment_method')->where('id',$order_info['pay_id'])->find();
        $payment = change_payment_name($payment);
        $has_time = $order_info['endtime'] - time();
        $has_time = $has_time>0?$has_time:0;
        $all_amount = sprintf( '%.2f',$order_info['t_num']*$order_info['c_exc_rate']*$order_info['s_price']);
        $one_amount = floatval($order_info['c_exc_rate']*$order_info['s_price']) ;



        //对方是否能联系到
        $this->assign('talk_side',$talk_side);
        $this->assign('payment',$payment);
        $this->assign('one_amount',$one_amount);
        $this->assign('all_amount',$all_amount);
        $this->assign('payment_type',$payment_type);
        $this->assign('has_time',$has_time);
        $this->assign('currency',$currency);
        $this->assign('order',$order_info);
        $this->assign('my_order',$seller_order);
        $this->assign('shoukuan',$shoukuan);
        $this->assign('id',$id);
        return $this->fetch();
    }

    public function qxmjfk()
    {
        $id = input('id');
        if(!$id){
            die('123');
        }
        $order_info = Db::name('currency_trade_order')->where('id',$id)->find();


        $currency = Db::name('currency')->where('name',$order_info['currency_type'])->find();


        $seller_order = Db::name('currency_shevles_order')->where('id',$order_info['oid'])->find();


        if($order_info['trade_type'] == 0){
            if($order_info['user_id'] != $this->uid){
                die('123');
            }
            $talk_side = Db::name('userinfo')->where('uid',$seller_order['user_id'])->count();
            $talk_side = $talk_side ? 1 : 0;
        }else{

            if($order_info['status']==1){

                $this->redirect('user/ddmjqrsk?id='.$id);
            }

            if($seller_order['user_id'] != $this->uid){
                die('123');
            }
            $talk_side = Db::name('userinfo')->where('uid',$order_info['user_id'])->count();
            $talk_side = $talk_side ? 1 : 0;
        }

        $payment_type = db('payment_method')->where('id',$order_info['pay_id'])->find();
        $payment_type = change_payment_name($payment_type);
        $payment_method = $order_info['payment_method']?$order_info['payment_method']:$seller_order['payment_method'];

        $shoukuan = db('user_payment_method')->where('id',$payment_method)->find();

        if(!$shoukuan){
            $shoukuan = db('user_payment_method')->where(['user_id'=>$seller_order['user_id'],'type'=>$order_info['pay_id']])->find();
        }
        //var_dump($payment_method);die;

        $has_time = $order_info['endtime'] - time();
        $has_time = $has_time>0?$has_time:0;
        $all_amount = sprintf( '%.2f',$order_info['t_num']*$order_info['c_exc_rate']*$order_info['s_price']);

        //对方是否能联系到
        $this->assign('talk_side',$talk_side);
        $this->assign('all_amount',$all_amount);
        $this->assign('payment_type',$payment_type);
        $this->assign('has_time',$has_time);
        $this->assign('currency',$currency);
        $this->assign('order',$order_info);
        $this->assign('my_order',$seller_order);
        $this->assign('shoukuan',$shoukuan);
        $this->assign('id',$id);
        return $this->fetch();
    }
    //确认支付
    public function qfk()
    {
        $id = input('id');
        if(!$id){
            die('123');
        }
        $order_info = Db::name('currency_trade_order')->where('id',$id)->find();

        if($order_info['trade_type'] == 0){
            if($order_info['user_id'] != $this->uid){
                die('222');
            }
            if($order_info['oid']){
                $seller_order = Db::name('currency_shevles_order')->where('id',$order_info['oid'])->find();
            }

            $talk_side = Db::name('userinfo')->where('uid',$seller_order['user_id'])->count();
            $talk_side = $talk_side ? 1 : 0;

            $seller_info = Db::name('user_payment_method')->where('id',$seller_order['payment_method'])->find();

            $currency = Db::name('currency')->where('name',$order_info['currency_type'])->find();

            $has_time = $order_info['endtime'] - time();

            $has_time = $has_time>0?$has_time:0;

            $all_amount = sprintf('%.2f', $order_info['t_num']*$order_info['c_exc_rate']*$order_info['s_price']);
            $one_amount = floatval($order_info['c_exc_rate']*$order_info['s_price']) ;

            $payment = db('payment_method')->where('id',$order_info['pay_id'])->find();
            $payment = change_payment_name($payment);
        }else{
            if($order_info['status']==1){

                $this->redirect('user/ddmjqrsk?id='.$id);
            }


            $seller_order = Db::name('currency_shevles_order')->where('id',$order_info['oid'])->find();
            if($seller_order['user_id'] != $this->uid){
                die('333');
            }

            $talk_side = Db::name('userinfo')->where('uid',$order_info['user_id'])->count();
            $talk_side = $talk_side ? 1 : 0;

            $seller_info = Db::name('user_payment_method')->where('id',$order_info['payment_method'])->find();
            $currency = Db::name('currency')->where('name',$order_info['currency_type'])->find();
            $has_time = $order_info['endtime'] - time();

            $has_time = $has_time>0?$has_time:0;
            $all_amount = sprintf('%.2f', $order_info['t_num']*$order_info['c_exc_rate']*$order_info['s_price']);
            $one_amount = floatval($order_info['c_exc_rate']*$order_info['s_price']) ;

            $payment = db('payment_method')->where('id',$order_info['pay_id'])->find();
            $payment = change_payment_name($payment);
        }
        //对方是否能联系到
        $this->assign('talk_side',$talk_side);

        $this->assign('one_amount',$one_amount);
        $this->assign('all_amount',$all_amount);
        $this->assign('payment',$payment);
        $this->assign('has_time',$has_time);
        $this->assign('currency',$currency);
        $this->assign('order',$order_info);
        $this->assign('my_order',$seller_order);
        $this->assign('info',$seller_info);
        $this->assign('id',$id);
        return $this->fetch();
    }
    //确认收款
    public function payment()
    {
        $id = input('id');
        if(!$id){
            die('1');
        }
        $order_info = Db::name('currency_trade_order')->where('id',$id)->find();
        if($order_info['oid']){
            $seller_order = Db::name('currency_shevles_order')->where('id',$order_info['oid'])->find();
        }

        $payment_id = $seller_order['payment_method']?$seller_order['payment_method']:$order_info['payment_method'];

        $payment = Db::name('user_payment_method')->where('id',$payment_id)->find();

        $seller_uid = $order_info['trade_type'] == 0 ? $seller_order['user_id'] : $order_info['user_id'] ;
        $buyer_uid = $order_info['trade_type'] == 0 ? $order_info['user_id'] : $seller_order['user_id'] ;

        if($seller_uid != $this->uid){
            die('123');
        }




        $talk_side = Db::name('userinfo')->where('uid',$buyer_uid['user_id'])->count();
        $talk_side = $talk_side ? 1 : 0;



        $currency = Db::name('currency')->where('name',$seller_order['currency_type'])->find();

        $has_time = $order_info['endtime'] - time();
        $has_time = $has_time>=0?$has_time:0;

        $all_amount = floatval( $order_info['t_num']*$order_info['c_exc_rate']*$order_info['s_price']);
        $one_amount = floatval($order_info['c_exc_rate']*$order_info['s_price']) ;


        //$payment['name'] = db('payment_method')->where('id',$payment['type'])->value('name');
        $payment['name'] = change_payname_byId($order_info['pay_id']);

        $this->assign('id',$id);

        $this->assign('one_amount',$one_amount);
        $this->assign('all_amount',$all_amount);
        $this->assign('talk_side',$talk_side);
        $this->assign('has_time',$has_time);
        $this->assign('currency',$currency);
        $this->assign('order',$order_info);
        $this->assign('my_order',$seller_order);
        $this->assign('payment',$payment);
        return $this->fetch();
    }



    public function anquan(){
        $uid = $this->uid;
        $utel = $this->user['utel'];
        $utel = addstartonum($utel);
        $this->assign('utel',$utel);
        return $this->fetch();
    }


    public function anquan_confirmpay(){
        $id = input('id');
        $_SESSION['trade_oid'] = $id;
        $uid = $this->uid;
        $utel = $this->user['utel'];
        $utel = addstartonum($utel);
        $this->assign('utel',$utel);
        $this->assign('id',$id);
        return $this->fetch();
    }

    public function skfs(){
        $currency = input('c');

        $pay_type = input('p');
        if($pay_type){
            $where['id'] = ['in',$pay_type];
            $payments = db('payment_method')->where($where)->order('id desc')->select();
        }else{
            $currency =  isset($currency)?$currency:'CNY';
            $payments = Db('currency')->where('name',$currency)->value('payments');
            if($payments){
                $all_payments_id = explode(',',$payments);
                $where['id'] = ['in',$all_payments_id];
                $payments = db('payment_method')->where($where)->order('id desc')->select();
            }
        }


        $payments = $payments?$payments:'';

        if(!empty($payments)){
            foreach ($payments as $k=>$v){
                $payments[$k] = change_payment_name($v);
                $payments[$k]['use_values']  = explode(',',$v['use_msg']);

            }
        }

//    echo '<pre>';        var_dump($payments);;die;

        $this->assign('payments',$payments);
        $this->assign('currency',$currency);
        return $this->fetch();
    }
    /*修改收款方式*/
    public function skfs_edit(){
        $id = input('id');
        if(!$id){
            return $this->fetch('skfs');
        }
        $payment = db('user_payment_method')->where('id',$id)->find();
        $payment['typename'] = change_payname_byId($payment['type']);// db('payment_method')->where('id',$payment['type'])->value('name');
        if($payment['user_id'] != $this->uid){
            return $this->fetch('skfs');
        }
        $this->assign('payment',$payment);
        return $this->fetch();
    }

    public function success2(){

        $id = input('id');

        $order = db('currency_trade_order')->where('id',$id)->find();

        if($order['oid']){
            $seller_order = Db::name('currency_shevles_order')->where('id',$order['oid'])->find();
        }
        //当匹配订单持有者进入
        if($order['user_id'] == $this->uid){
            $shevles_msg = $order['trade_type'] == 1? \think\Lang::get('fbjy_mj') : \think\Lang::get('fbjy_mj2');
            $trade_name = $order['trade_type'] == 1 ? \think\Lang::get('fbjy_cs'):\think\Lang::get('sw_gm');


            $talk_side = Db::name('userinfo')->where('uid',$seller_order['user_id'])->count();
            $talk_side = $talk_side ? 1 : 0;


        }else{
            $shevles_msg =  $order['trade_type'] == 1?  \think\Lang::get('fbjy_mj2'):\think\Lang::get('fbjy_mj');
            $trade_name = $order['trade_type'] == 1 ? \think\Lang::get('sw_gm') : \think\Lang::get('fbjy_cs');


            $talk_side = Db::name('userinfo')->where('uid',$order['user_id'])->count();
            $talk_side = $talk_side ? 1 : 0;

        }

        $this->assign('talk_side',$talk_side);

        $order['trade_name'] = $trade_name;

        $order['addtime'] = date('Y-m-d H:i:s',$order['addtime']);
        $order['all_pay_amount'] = sprintf('%.2f', $order['t_num'] * $order['s_price'] * $order['c_exc_rate']);
        $order['currency_icon'] =  $payments = Db('currency')->where('name',$order['currency_type'])->value('symbol');

        $payment  = Db('payment_method')->where('id',$order['pay_id'])->find();
        $payment['name'] = change_payname_byId($order['pay_id']);
        $order['pay_way']  = $payment['name'];
        $this->assign('order',$order);
        $this->assign('id',$id);
        $this->assign('seller_msg',$shevles_msg);
        return $this->fetch();
    }

    //已取消
    public function cancelled(){

        $id = input('id');

        $order = db('currency_trade_order')->where('id',$id)->find();

        if($order['oid']){
            $seller_order = Db::name('currency_shevles_order')->where('id',$order['oid'])->find();
        }
        //当匹配订单持有者进入
        if($order['user_id'] == $this->uid){

            $trade_name = $order['trade_type'] == 1 ? \think\Lang::get('fbjy_cs'):\think\Lang::get('sw_gm');


            $talk_side = Db::name('userinfo')->where('uid',$seller_order['user_id'])->count();
            $talk_side = $talk_side ? 1 : 0;


        }else{

            $trade_name = $order['trade_type'] == 1 ? \think\Lang::get('sw_gm') : \think\Lang::get('fbjy_cs');


            $talk_side = Db::name('userinfo')->where('uid',$order['user_id'])->count();
            $talk_side = $talk_side ? 1 : 0;

        }

        $this->assign('talk_side',$talk_side);
        $order['trade_name'] = $trade_name;

        $order['addtime'] = date('Y-m-d H:i:s',$order['addtime']);

        $trade_type = [\think\Lang::get('fbjy_cs'),\think\Lang::get('sw_gm')];
        $status = array(\think\Lang::get('fbjy_dmjfk'),\think\Lang::get('fbjy_dqr'),\think\Lang::get('sl_ywc'),\think\Lang::get('fbjy_ssz'),\think\Lang::get('fbjy_ysx'),\think\Lang::get('fbjy_yxq'),\think\Lang::get('fbjy_mjjujue'));

        $order['currency_icon'] =  $payments = Db('currency')->where('name',$order['currency_type'])->value('symbol');
        $order['all_pay_amount'] = sprintf('%.2f', $order['t_num'] * $order['s_price'] * $order['c_exc_rate']);
        $order['status'] = $status[$order['status']];

        $order['trade_type'] = $trade_type[$order['trade_type']];

        $this->assign('order',$order);




        return $this->fetch();
    }

    public function cance(){

        return $this->fetch();
    }
    //法币交易 交易订单
    public function ordes(){
        return $this->fetch();
    }

    public function curordes(){
        return $this->fetch();
    }

    //首页 进 添加收款方式 的入口
    public function transactions2(){
        $payments = Db::name('user_payment_method')
            ->alias('up')
            ->join('payment_method pm','up.type = pm.id')
            ->field('up.*,pm.name as typename,pm.color')
            ->where(['up.user_id'=>$this->uid,'up.status'=>1])->order('up.addtime desc')->select();
//        var_dump($payments);die;
        if(count($payments)>0){
            foreach ($payments as $k=>$v){
                $payments[$k]['typename'] = change_payname_byId($v['type']);
            }
        }

        $this->assign('payment',$payments);
        return $this->fetch();
    }


    public function optional(){
        // 获取法币币种
        $tender = Db::name('currency')->field('id,name,symbol,huilv')->select();

        // 获取平台币种
        $currencys = Db::name('productinfo')->where('isdelete',0)->field('pid,ptitle,procode')->order('proorder asc')->select();
        //获取此时美元外汇汇率
        //$currency_exc_ra = getExchangeRate('');



        $dataName = [];
        foreach ($currencys as $key=>$val) {

            $str = explode( '/',$val['ptitle']);
            $currencys[$key]['Name'] = $str[0];//str_replace($str, '', $val['ptitle']);
            $dataName[] = $currencys[$key]['Name'];

            $currencys[$key]['sl'] = isset($wallets[$str[0]]) ? floatval($wallets[$str[0]])  : 0;


            //获取交易对价格
            if(IsPersonSymbol($val['procode'])){
                $currencys[$key]['price'] = Db::name('productdata')->where('pid',$val['pid'])->value('Price');
            }else{
                $price_data =  getHuobiSymbolMarketDetail($val['procode']);
                $currencys[$key]['price'] = $price_data? $price_data['close']:1;
            }
        }
        $usdt = array(
            'pid'=>0,
            'Name'=>'USDT',
            'price'=>1,
            'sl'=>isset($wallets['USDT'])?$wallets['USDT']:0,
        );
        $agc = array(
            'pid'=>1,
            'Name'=>'AGC',
            'price'=>1,
            'sl'=>isset($wallets['AGC'])?$wallets['AGC']:0,
        );
        array_unshift($currencys,$agc,$usdt);
        //获取默认法币
        $default_currency = 'CNY';
        $default_currency_icon = '￥';
        $default_lang = cookie('think_var');
        switch ($default_lang) {

            case 'cny':

                $default_currency = 'CNY';

                break;

            case 'usd':

                $default_currency = 'USD';

                break;

            case 'jpy':

                $default_currency = 'JPY';

                break;

            case 'krw':

                $default_currency = 'KRW';

                break;

            case 'try':

                $default_currency = 'TRY';

                break;
        }
        $default_currency_price = getCurrencyHuilv($default_currency);// $currency_exc_ra[$default_currency];

        $tenderWord = [];
        $tender_firstw = [];
        foreach ($tender as $key=>$val) {
//            $tender[$key][$this->getfirstchar($val['name'])] =  $val;
//            $tenderWord[$key] = $this->getfirstchar($val['name']);

            $tender[$key]['exc_rate'] = $val['huilv'];// $currency_exc_ra[strtoupper($val['name'])];

            $tender_firstw[$key] = $this->getfirstchar($val['name']);
            $tenderWord[$this->getfirstchar($val['name'])][] = $tender[$key];

            if($default_currency == strtoupper($val['name'])){
                $default_currency_icon = $val['symbol'];
            };
        }
        $tender_firstw = array_unique($tender_firstw);



//        echo '<pre>';
//        var_dump($user_wallet);die;


        $this->assign([ 'currencys' => $currencys, 'tenderWord' => $tenderWord, 'tender' => $tender,'firstw'=>$tender_firstw,'default_currency'=>$default_currency,'default_currency_price'=>$default_currency_price,'default_symbol'=>$currencys[0],'default_currency_icon'=>$default_currency_icon]);
        return $this->fetch();
    }
    public function huazhuan(){

        return $this->fetch();
    }


    public function bank_deposit()
    {
        return $this->fetch();
    }
    //身份认证
    public function smrz()
    {
        $uid = $this->uid;
        $user = Db::name('userinfo')->where('uid',$uid)->find();
        $this->assign('user',$user);
        if($this->user['smsh_state']==1 || $this->user['smsh_state']==2){
            return $this->fetch();
        }else{
            return $this->fetch('sfrzsc');
        }

    }


    public function smrztj(){

        $data = input('post.');
        //验证用户信息
        if(!isset($data['xingming']) || empty($data['xingming'])){
            return WPreturn(\think\Lang::get('ue_qsrzsxm'),-1);
        }
        if(!isset($data['id_card']) || empty($data['id_card'])){
            return WPreturn(\think\Lang::get('sz_qsrsfzh'),-1);
        }
        if(!isset($data['zmurl']) || empty($data['zmurl'])){
            return WPreturn(\think\Lang::get('sz_qscsfzzm'),-1);
        }


        if(!isset($data['fmurl']) || empty($data['fmurl'])){
            return WPreturn(\think\Lang::get('sz_qscsfzfm'),-1);
        }



        $userinfo = Db::name('userinfo');
        $t_data['nickname'] = $data['xingming'];
        $t_data['id_card'] = $data['id_card'];
        $t_data['smsh_state'] = 1;

        $t_data['uid'] =$uid = $this->uid;
        $userinfo->update($t_data);

        return WPreturn(\think\Lang::get('li_xgcg'),1);

    }


    public function upzmimg(){



        $file = request()->file('file');
        if($file){
            $info = $file->move(ROOT_PATH .'/Uploads/images/sfz');
            if($info){

                $front_side = '/Uploads/images/sfz/'.$info->getSaveName();
                $send_id = $this->uid;

                $msg = $front_side;
                $newData = [
                    'uid' => $send_id,
                    'zm_img' => $msg,

                ];

                $msg_id = db('userinfo')->update($newData);


                if($msg_id){
                    $ret = ['error'=>0,'content'=>\think\Lang::get('ue_sccg'),'file_url'=>$front_side,'msg_id'=>$msg_id];
                    die(json_encode($ret));
                }else{
                    $ret = ['error'=>1,'content'=>\think\Lang::get('ue_scsbqcs')];
                    die(json_encode($ret));
                }
            }else{
                // 上传失败获取错误信息
                $msg =  $file->getError();
                $ret = ['error'=>1,'content'=>$msg];
                die(json_encode($ret));
            }
        }else{
            $ret = ['error'=>1,'content'=>\think\Lang::get('ue_scsbqcs')];
            die(json_encode($ret));
        }

    }


    public function upfmimg(){



        $file = request()->file('file');
        if($file){
            $info = $file->move(ROOT_PATH .'/Uploads/images/sfz');
            if($info){

                $front_side = '/Uploads/images/sfz/'.$info->getSaveName();
                $send_id = $this->uid;

                $msg = $front_side;
                $newData = [
                    'uid' => $send_id,
                    'fm_img' => $msg,

                ];

                $msg_id = db('userinfo')->update($newData);


                if($msg_id){
                    $ret = ['error'=>0,'content'=>\think\Lang::get('ue_sccg'),'file_url'=>$front_side,'msg_id'=>$msg_id];
                    die(json_encode($ret));
                }else{
                    $ret = ['error'=>1,'content'=>\think\Lang::get('ue_scsbqcs')];
                    die(json_encode($ret));
                }
            }else{
                // 上传失败获取错误信息
                $msg =  $file->getError();
                $ret = ['error'=>1,'content'=>$msg];
                die(json_encode($ret));
            }
        }else{
            $ret = ['error'=>1,'content'=>\think\Lang::get('ue_scsbqcs')];
            die(json_encode($ret));
        }

    }


    public function test()
    {
        // $data[12] = array('id'=> 167, 'pid' => 168, 'Name' => 'HT');
        $currencys = Db::name('productdata')->field('id,pid,Name')->select();
        $tender = Db::name('currency')->field('id,name,symbol')->order('name asc')->select();
        $dataName = [];
        foreach ($currencys as $key=>$val) {
            if ($val['Name']) {
                $str = strstr($val['Name'], '/');
                $currencys[$key]['Name'] = str_replace($str, '', $val['Name']);
                $dataName[] = $currencys[$key]['Name'];
            }
        }
//        $tenderWord = [];
//        foreach ($tender as $key=>$val) {
//            $tender[$key]['word'] =  $this->getfirstchar($val['name']);
//            $tenderWord[$key] = $this->getfirstchar($val['name']);
//        }
//        $tenderWord = array_unique($tenderWord);
//        $tend = [];
//        foreach ($tender as $key=>$val) {
//            if ($val['word'] == $this->getfirstchar($val['name'])) {
//                $tend[$val['word']] = $val;
//            }
//        }

        $ud = getCurrencyHuilv('AED');
        halt($tender);
    }

    function getfirstchar($s0){
        $fchar = ord($s0{0});

        if($fchar >= ord("A") and $fchar <= ord("z") )return strtoupper($s0{0});

        $s1 = iconv("UTF-8","gb2312", $s0);

        $s2 = iconv("gb2312","UTF-8", $s1);

        if($s2 == $s0){$s = $s1;}else{$s = $s0;}

        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;

        if($asc >= -20319 and $asc <= -20284) return "A";

        if($asc >= -20283 and $asc <= -19776) return "B";

        if($asc >= -19775 and $asc <= -19219) return "C";

        if($asc >= -19218 and $asc <= -18711) return "D";

        if($asc >= -18710 and $asc <= -18527) return "E";

        if($asc >= -18526 and $asc <= -18240) return "F";

        if($asc >= -18239 and $asc <= -17923) return "G";

        if($asc >= -17922 and $asc <= -17418) return "H";

        if($asc >= -17417 and $asc <= -16475) return "J";

        if($asc >= -16474 and $asc <= -16213) return "K";

        if($asc >= -16212 and $asc <= -15641) return "L";

        if($asc >= -15640 and $asc <= -15166) return "M";

        if($asc >= -15165 and $asc <= -14923) return "N";

        if($asc >= -14922 and $asc <= -14915) return "O";

        if($asc >= -14914 and $asc <= -14631) return "P";

        if($asc >= -14630 and $asc <= -14150) return "Q";

        if($asc >= -14149 and $asc <= -14091) return "R";

        if($asc >= -14090 and $asc <= -13319) return "S";

        if($asc >= -13318 and $asc <= -12839) return "T";

        if($asc >= -12838 and $asc <= -12557) return "W";

        if($asc >= -12556 and $asc <= -11848) return "X";

        if($asc >= -11847 and $asc <= -11056) return "Y";

        if($asc >= -11055 and $asc <= -10247) return "Z";

        return null;
    }

    function assoc_unique($arr, $key) {
        $tmp_arr = array();

        foreach($arr as $k => $v) {
            if(in_array($v[$key], $tmp_arr)) {
                unset($arr[$k]);

            } else {
                $tmp_arr[] = $v[$key];

            }

        }

        sort($arr);

        return $arr;

    }

//    法币交易
    public function fbjy()
    {
        $uid = $this->uid;
        $user = Db::name('userinfo')->where('uid',$uid)->find();

        // 获取法币币种
        $tender = Db::name('currency')->field('id,name,symbol,huilv')->select();

        // 获取平台币种
        $currencys = Db::name('productinfo')->where('isdelete',0)->field('pid,ptitle,procode')->order('proorder asc')->select();



        //获取此时美元外汇汇率
        //$currency_exc_ra = getExchangeRate('');


        //获取用户钱包余额
        $user_wallet = Db::name('zc')->where(['yh'=>$uid,'qb'=>3])->select();
        $wallets = [];
        if(count($user_wallet)>0){
            foreach ($user_wallet as $key=>$val){
                $wallets[$val['cp']] = $val['sl'];
            }
        }
//        echo '<pre>';
//        var_dump($wallets);die;


        $dataName = [];
        foreach ($currencys as $key=>$val) {

            $str = explode( '/',$val['ptitle']);
            $currencys[$key]['Name'] = $str[0];//str_replace($str, '', $val['ptitle']);
            $dataName[] = $currencys[$key]['Name'];

            $currencys[$key]['sl'] = isset($wallets[$str[0]]) ? floatval($wallets[$str[0]])  : 0;


            //获取交易对价格
            if(IsPersonSymbol($val['procode'])){
                $currencys[$key]['price'] = Db::name('productdata')->where('pid',$val['pid'])->value('Price');

            }else{
                $price_data =  getHuobiSymbolMarketDetail($val['procode']);
                $currencys[$key]['price'] = $price_data['close']?$price_data['close']:1;

            }
        }



        $usdt = array(
            'pid'=>0,
            'Name'=>'USDT',
            'price'=>1,
            'sl'=>isset($wallets['USDT'])?$wallets['USDT']:0,
        );
        $agc = array(
            'pid'=>1,
            'Name'=>'AGC',
            'price'=>1,
            'sl'=>isset($wallets['AGC'])?$wallets['AGC']:0,
        );





        array_unshift($currencys,$agc,$usdt);

        //var_dump($currencys);die;

        //获取默认法币
        $default_currency = 'CNY';
        $default_currency_icon = '￥';



        $default_lang = cookie('think_var');
        switch ($default_lang) {

            case 'cny':


                $default_currency = 'CNY';

                break;


            case 'usd':


                $default_currency = 'USD';

                break;

            case 'jpy':


                $default_currency = 'JPY';

                break;


            case 'krw':


                $default_currency = 'KRW';

                break;

            case 'try':

                $default_currency = 'TRY';

                break;
        }
        $default_currency_price = getCurrencyHuilv($default_currency);

        $tenderWord = [];
        $tender_firstw = [];
        foreach ($tender as $key=>$val) {
//            $tender[$key][$this->getfirstchar($val['name'])] =  $val;
//            $tenderWord[$key] = $this->getfirstchar($val['name']);

            $tender[$key]['exc_rate'] = floatval($val['huilv']) ;// getCurrencyHuilv[strtoupper($val['name'])];

            $tender_firstw[$key] = $this->getfirstchar($val['name']);
            $tenderWord[$this->getfirstchar($val['name'])][] = $tender[$key];

            if($default_currency == strtoupper($val['name'])){
                $default_currency_icon = $val['symbol'];
            };
        }
        $tender_firstw = array_unique($tender_firstw);



//        echo '<pre>';
//        var_dump($user_wallet);die;


        $this->assign(['user' => $user, 'currencys' => $currencys, 'tenderWord' => $tenderWord, 'tender' => $tender,'firstw'=>$tender_firstw,'default_currency'=>$default_currency,'default_currency_price'=>$default_currency_price,'default_symbol'=>$currencys[0],'default_currency_icon'=>$default_currency_icon]);
        return $this->fetch();
    }


//    锁仓挖矿
    public function scwk()
    {
        $uid = $this->uid;
        $user = Db::name('userinfo')->where('uid',$uid)->find();
        $this->assign('user',$user);
        $prolist = Db::name('lockming')->where('show',1)->order('sort desc')->select();
        $this->assign('prolist',$prolist);
        return $this->fetch();
    }

    public function doscwk()
    {
        $id = input('param.id');
        $num = input('param.num');
        if($num<=0){
            $result = array(
                'error' => 1,
                'msg' =>\think\Lang::get('ue_qsrcbsl') ,
            );
            echo json_encode($result);
            exit();
        }

        $pro = Db::name('lockming')->where(['show'=>1,'id'=>$id])->find();
        if(!$pro){
            $result = array(
                'error' => 1,
                'msg' =>\think\Lang::get('ae_ffcz') ,
            );
            echo json_encode($result);
            exit();
        }


        $money = get_money($this->uid,1,trim($pro['name']));

        if($money<$num){
            $result = array(
                'error' => 1,
                'msg' =>$pro['name'].\think\Lang::get('ue_bz') ,
            );
            echo json_encode($result);
            exit();
        }



        $gain = $num*$pro['cycle']*$pro['lilv']/100;

        $endtime = $pro['cycle']*86400+time();

        //建仓
        $adddata['name'] = $pro['name'];
        $adddata['num'] = $num;
        $adddata['uid'] = $this->uid;
        $adddata['gain'] = $gain;
        $adddata['cycle'] = $pro['cycle'];
        $adddata['bili'] = $pro['lilv'];

        $adddata['starttime'] = time();

        $adddata['endtime'] = $endtime;
        $adddata['state'] = 0;





        //下单
        $ids = Db::name('lockorder')->insertGetId($adddata);
        if($ids){

            log_account_change($this->uid,1,trim($pro['name']),-1*$num,$num,\think\Lang::get('ind_scwk'),0);
            $result = array(
                'error' => 0,
                'msg' =>\think\Lang::get('us_gmcg') ,
            );
            echo json_encode($result);
            exit();
        }else{
            $result = array(
                'error' => 1,
                'msg' =>\think\Lang::get('us_gmsb') ,
            );
            echo json_encode($result);
            exit();
        }

    }



    //    锁仓挖矿
    public function scwk_list()
    {
        $uid = $this->uid;
        $orderlist = Db::name('lockorder')->where('uid',$uid)->select();
        $this->assign('orderlist',$orderlist);
        return $this->fetch();
    }






    //安全中心

    public function security(){
        $uid = $this->uid;
        $user = Db::name('userinfo')->where('uid',$uid)->find();
        $this->assign('user',$user);
        return $this->fetch();
    }

    //    修改密码
    public function resetpwd()
    {
        $uid = $this->uid;
        $user = Db::name('userinfo')->where('uid',$uid)->find();
        $this->assign('user',$user);
        return $this->fetch();
    }

    //修改登录密码
    public function xgdlmm(){

        $data = input('post.');
        //验证用户信息
        if(!isset($data['upwd']) || empty($data['upwd'])){
            return WPreturn(\think\Lang::get('ri_qsrdlmm'),-1);
        }
        if(!isset($data['upwd2']) || empty($data['upwd2'])){
            return WPreturn(\think\Lang::get('ri_qzcsrdlmm'),-1);
        }
        if($data['upwd'] != $data['upwd2']){
            return WPreturn(\think\Lang::get('ue_lcsrdmmbt'),-1);
        }

        //判断邮箱验证码
        if(!isset($_SESSION['code']) || $_SESSION['code'] != $data['phonecode'] ){
            return WPreturn(\think\Lang::get('ue_yzmbzq'),-1);
        }else{
            unset($_SESSION['code']);
        }


        $userinfo = Db::name('userinfo');
        $t_data['upwd'] = md5($data['upwd']);
        $t_data['uid'] =$uid = $this->uid;
        $userinfo->update($t_data);

        return WPreturn(\think\Lang::get('li_xgcg'),1);

    }

    //修改交易密码
    public function reseterjipwd()
    {
        $uid = $this->uid;
        $user = Db::name('userinfo')->where('uid',$uid)->find();
        $this->assign('user',$user);
        return $this->fetch();
    }
    //修改交易密码
    public function xgjymm(){

        $data = input('post.');
        //验证用户信息
        if(!isset($data['upwd']) || empty($data['upwd'])){
            return WPreturn(\think\Lang::get('rj_qsrjymm'),-1);
        }
        if(!isset($data['upwd2']) || empty($data['upwd2'])){
            return WPreturn(\think\Lang::get('ue_qzcsrjymm'),-1);
        }
        if($data['upwd'] != $data['upwd2']){
            return WPreturn(\think\Lang::get('ue_lcsrdmmbt'),-1);
        }

        //判断邮箱验证码
        if(!isset($_SESSION['code']) || $_SESSION['code'] != $data['suijicode'] ){
            return WPreturn(\think\Lang::get('ue_yzmbzq'),-1);
        }else{
            unset($_SESSION['code']);
        }


        $userinfo = Db::name('userinfo');
        $t_data['erjimima'] = md5($data['upwd']);
        $t_data['uid'] =$uid = $this->uid;
        $userinfo->update($t_data);

        return WPreturn(\think\Lang::get('li_xgcg'),1);

    }


    public function index()
    {
        $this->redirect('index/Assets/bibi');


        $uid = $this->uid;
        $user = Db::name('userinfo')->where('uid',$uid)->find();
        if($user['level']=='level_zero')
        {
            $user['level']=\think\Lang::get('ue_ptyh');
        }elseif($user['level']=='level_one')
        {
            $user['level']=\think\Lang::get('ue_bzyh');
        }elseif($user['level']=='level_two')
        {
            $user['level']=\think\Lang::get('ue_bjyh');
        }elseif($user['level']=='level_three')
        {
            $user['level']=\think\Lang::get('ue_hjyh');
        }
        elseif($user['level']=='level_four')
        {
            $user['level']=\think\Lang::get('ue_zsyh');
        }
        //出金------------------------------------------
        //银行卡
        $data['banks'] = db('banks')->select();

        //地区
        $province = db('area')->where(array('pid'=>0))->select();

        //已签约信息
        $data['mybank'] = db('bankcard')->alias('b')->field('b.*,ba.bank_nm')
            ->join('__BANKS__ ba','ba.id=b.bankno')
            ->where('uid',$uid)->find();

        //$data['mybank'] = db('bankcard')->where('uid',$uid)->find();
        //资金流水
        $data['order_list'] = db('price_log')->where('uid',$uid)->order('id desc')->limit(0,20)->select();
        //dump($data['order_list']);

        //充值方式
        $payment = db('payment')->where(array('isdelete'=>0,'is_use'=>1))->order('pay_order desc ')->select();
        if($user['rmbtd']==0){
            foreach($payment as $k=>$v){
                if($v['id']!=18){
                    unset($payment[$k]);
                }
            }
        }

        if($payment){
            $arr2 = $arr = $arr1 = array();
            foreach ($payment as $key => $value) {


                $arr1 = explode('|',trimall($value['pay_conf']));

                foreach ($arr1 as $k => $v) {
                    $arr2 = explode(':',trimall($v));
                    if(isset($arr2[0]) && isset($arr2[1])){
                        $arr[$arr2[0]] = $arr2[1];
                    }


                }
                $payment[$key]['pay_conf_arr'] = $arr;


            }
        }

        //推广二维码
        if($user['otype'] == 101){
            $oid = $uid;
        }else{
            $oid = $user['oid'] ;
        }
        $data['oid_url'] = "http://".$_SERVER['SERVER_NAME'].'?fid='.$oid;
        //$data['oid_url'] = "http://www.tp5.com/index.php?fid=".$oid;
        //dump($payment);exit;
        $data['sub_bankno'] = substr($data['mybank']['accntno'],-4,4);

        //入金金额
        $reg_push = $this->conf['reg_push'];
        if($reg_push){
            $reg_push = explode('|',$reg_push);
        }

        $recharge_activity = $this->conf['recharge_activity'];

        $this->assign('recharge_activity',$recharge_activity);
        $this->assign('level',$user['level']);
        $this->assign('province',$province);
        $this->assign($data);
        $this->assign('payment',$payment);
        $this->assign('reg_push',$reg_push);


        //未读消息
        $msg_nums = Db::name('consult_message')->where("sender = 1 AND receiver = '$uid' AND is_read = 0")->count();
        $this->assign('msg_nums',$msg_nums);
        return $this->fetch();
    }

    public function rechange(){
        $uid = $this->uid;
        $user = Db::name('userinfo')->where('uid',$uid)->find();
        //充值方式
        $payment = db('payment')->where(array('isdelete'=>0,'is_use'=>1))->order('pay_order desc ')->select();
        if($user['rmbtd']==0){
            foreach($payment as $k=>$v){
                if($v['id']!=18){
                    unset($payment[$k]);
                }
            }
        }

        if($payment){
            $arr2 = $arr = $arr1 = array();
            foreach ($payment as $key => $value) {


                $arr1 = explode('|',trimall($value['pay_conf']));

                foreach ($arr1 as $k => $v) {
                    $arr2 = explode(':',trimall($v));
                    if(isset($arr2[0]) && isset($arr2[1])){
                        $arr[$arr2[0]] = $arr2[1];
                    }


                }
                $payment[$key]['pay_conf_arr'] = $arr;


            }
        }



        //入金金额
        $reg_push = $this->conf['reg_push'];
        if($reg_push){
            $reg_push = explode('|',$reg_push);
        }

        $recharge_activity = $this->conf['recharge_activity'];

        $this->assign('recharge_activity',$recharge_activity);

        $this->assign('payment',$payment);
        $this->assign('reg_push',$reg_push);



        return $this->fetch();


    }

    public function zym_kflt(){
        $uid = $this->uid;
        $send_list = db('consult_message')->where("(sender = '$uid' AND receiver = '1') OR (sender = '1' AND receiver = '$uid')")->order("add_time ASC")->select();
        /* 格式化日期、头像 */
        foreach ($send_list as $k => $v)
        {
            $send_list[$k]['add_time'] = date('m/d H:i:s', $v['add_time']);

            if(strpos($v['msg'],'/images/consultimg/') !== false){
                $send_list[$k]['is_img'] = 'img';
            }else{
                $send_list[$k]['is_img'] = '';
            }
        }



        /* 将接收的信息全部标记为已读*/

        $data['sender'] = 1;
        $data['receiver'] = $uid;
        db('consult_message')->where($data)->update(['is_read'=>1]);
        $userinfo = Db::name('userinfo') -> where('uid',$uid)->find();

        $this->assign('user',$userinfo );
        $this->assign('send_list', $send_list);

        return $this->fetch();

    }


    public function get_message(){
        $send_id = $this->uid;
        $receiv_id = 1;

        /* 将数据库未读的接收的数据读取 */
        $where['sender'] = $receiv_id;
        $where['receiver'] = $send_id;
        $where['is_read'] = 0;
        $msg_list = db('consult_message')->where($where)->select();

        /* 重组html，返回 */
        $msg_html = '';
        foreach ($msg_list as $k => $v)
        {
            if(strpos($v['msg'],'/images/consultimg/') !== false){
                $v['msg'] = '<img src = "'.$v['msg'].'"  onclick="showNotes('.$v['msg_id'].')" id = "n_img_'.$v['msg_id'].'" >';
            }
            $headimg = "/new/images/kefu.png";
            $msg_html .= '
			<div class="send">
				<div class="time">'.date('m/d H:i:s', $v['add_time']).'</div>
				<div class="msg">
					<img src="'.$headimg.'">
					<p>'.$v['msg'].'</p>
				</div>
			</div>
		';
        }
        $ret = array('msg' => $msg_html);
        /* 消息获取完成后，将接收的消息全部标记为已读 */
        $data['sender'] = $receiv_id;
        $data['receiver'] = $send_id;
        db('consult_message')->where($data)->update(['is_read'=>1]);
        /* 返回数据 */
        die(json_encode($ret));
    }

    public function send_message(){
        $send_id = $this->uid;
        if($send_id>0){
            $receiv_id = 1;

            $msg = str_replace("","<br />",htmlspecialchars($_POST['msg']));

            $newData = [
                'sender' => $send_id,
                'receiver' => $receiv_id,
                'msg' => $msg,
                'add_time' => time(),
                'is_read' => 0, // 推荐人ID
            ];
            $msg_id = db('consult_message')->insertGetId($newData);

            if($msg_id){
                $ret = array('errCode' => 101, 'errMsg' => \think\Lang::get('li_fscg'));
            }else{
                $ret = array('errCode' => 100, 'errMsg' => \think\Lang::get('ue_fssb'));
            }


            die(json_encode($ret));
        }

    }

    //发送图片
    public function up_imgurl(){

        $file = request()->file('file');
        if($file){
            $info = $file->move(ROOT_PATH .'/Uploads/images/consultimg/client');
            if($info){

                $front_side = '/Uploads/images/consultimg/client/'.$info->getSaveName();
                $send_id = $this->uid;
                $receiv_id = 1;
                $msg = $front_side;
                $newData = [
                    'sender' => $send_id,
                    'receiver' => $receiv_id,
                    'msg' => $msg,
                    'add_time' => time(),
                    'is_read' => 0,
                ];

                $msg_id = db('consult_message')->insertGetId($newData);
                if($msg_id){
                    $ret = ['error'=>0,'content'=>\think\Lang::get('li_fscg'),'file_url'=>$front_side,'msg_id'=>$msg_id];
                    die(json_encode($ret));
                }else{
                    $ret = ['error'=>1,'content'=>\think\Lang::get('ue_fssbqcs')];
                    die(json_encode($ret));
                }
            }else{
                // 上传失败获取错误信息
                $msg =  $file->getError();
                $ret = ['error'=>1,'content'=>$msg];
                die(json_encode($ret));
            }
        }else{
            $ret = ['error'=>1,'content'=>\think\Lang::get('ue_fssbqcs')];
            die(json_encode($ret));
        }
    }


    //联系卖家
    public function lxmj(){
        $uid = $this->uid;
        $re_id = input('receiv_id');
        if(!$re_id){
            $oid = input('oid');
            $trade_order = db('currency_trade_order')->where('id',$oid)->field('oid,user_id')->find();
            if($trade_order['user_id'] == $uid){
                $re_id =  db('currency_shevles_order')->where('id',$trade_order['oid'])->value('user_id');
            }else{
                $re_id = $trade_order['user_id'];
            }
        }


        $send_list = db('consult_message')->where("(sender = '$uid' AND receiver = '$re_id') OR (sender = '$re_id' AND receiver = '$uid')")->order("add_time ASC")->select();
        /* 格式化日期、头像 */
        foreach ($send_list as $k => $v)
        {
            $send_list[$k]['add_time'] = date('m/d H:i:s', $v['add_time']);

            if(strpos($v['msg'],'/images/consultimg/') !== false){
                $send_list[$k]['is_img'] = 'img';
            }else{
                $send_list[$k]['is_img'] = '';
            }
        }



        /* 将接收的信息全部标记为已读*/

        $data['sender'] = $re_id;
        $data['receiver'] = $uid;
        db('consult_message')->where($data)->update(['is_read'=>1]);
        $userinfo = Db::name('userinfo') -> where('uid',$uid)->find();
        $reinfo =  Db::name('userinfo') -> where('uid',$re_id)->find();
        $this->assign('receiv',$reinfo );
        $this->assign('user',$userinfo );
        $this->assign('send_list', $send_list);

        return $this->fetch();

    }


    public function lxmj_get_message(){
        $send_id = $this->uid;
        $receiv_id = intval(input('receiv_id'));

        /* 将数据库未读的接收的数据读取 */
        $where['sender'] = $receiv_id;
        $where['receiver'] = $send_id;
        $where['is_read'] = 0;
        $msg_list = db('consult_message')->where($where)->select();

        /* 重组html，返回 */
        $msg_html = '';
        foreach ($msg_list as $k => $v)
        {
            if(strpos($v['msg'],'/images/consultimg/') !== false){
                $v['msg'] = '<img src = "'.$v['msg'].'"  onclick="showNotes('.$v['msg_id'].')" id = "n_img_'.$v['msg_id'].'" >';
            }
            $headimg = "/new/images/kefu.png";
            $msg_html .= '
			<div class="send">
				<div class="time">'.date('m/d H:i:s', $v['add_time']).'</div>
				<div class="msg">
					<img src="'.$headimg.'">
					<p>'.$v['msg'].'</p>
				</div>
			</div>
		';
        }
        $ret = array('msg' => $msg_html);
        /* 消息获取完成后，将接收的消息全部标记为已读 */
        $data['sender'] = $receiv_id;
        $data['receiver'] = $send_id;
        db('consult_message')->where($data)->update(['is_read'=>1]);
        /* 返回数据 */
        die(json_encode($ret));
    }

    public function lxmj_send_message(){
        $send_id = $this->uid;
        if($send_id>0){
            $receiv_id = intval(input('receiv_id'));

            $msg = str_replace("","<br />",htmlspecialchars($_POST['msg']));

            $newData = [
                'sender' => $send_id,
                'receiver' => $receiv_id,
                'msg' => $msg,
                'add_time' => time(),
                'is_read' => 0, // 推荐人ID
            ];
            $msg_id = db('consult_message')->insertGetId($newData);

            if($msg_id){
                $ret = array('errCode' => 101, 'errMsg' => \think\Lang::get('li_fscg'));
            }else{
                $ret = array('errCode' => 100, 'errMsg' => \think\Lang::get('ue_fssb'));
            }


            die(json_encode($ret));
        }

    }

    //发送图片
    public function lxmj_up_imgurl(){

        $file = request()->file('file');
        if($file){
            $info = $file->move(ROOT_PATH .'/Uploads/images/consultimg/client');
            if($info){

                $front_side = '/Uploads/images/consultimg/client/'.$info->getSaveName();
                $send_id = $this->uid;
                $receiv_id = intval(input('receiv_id'));
                $msg = $front_side;
                $newData = [
                    'sender' => $send_id,
                    'receiver' => $receiv_id,
                    'msg' => $msg,
                    'add_time' => time(),
                    'is_read' => 0,
                ];


                $msg_id = db('consult_message')->insertGetId($newData);
                if($msg_id){
                    $ret = ['error'=>0,'content'=>\think\Lang::get('li_fscg'),'file_url'=>$front_side,'msg_id'=>$msg_id];
                    die(json_encode($ret));
                }else{
                    $ret = ['error'=>1,'content'=>\think\Lang::get('ue_fssbqcs')];
                    die(json_encode($ret));
                }
            }else{
                // 上传失败获取错误信息
                $msg =  $file->getError();
                $ret = ['error'=>1,'content'=>$msg];
                die(json_encode($ret));
            }
        }else{
            $ret = ['error'=>1,'content'=>\think\Lang::get('ue_fssbqcs')];
            die(json_encode($ret));
        }
    }

    /**
     * 用户提现
     * @author lukui  2017-07-21
     * @return [type] [description]
     */
    public function cash()
    {
        $uid = $this->uid;
        if(input('post.')){
            $data = input('post.');
            if($data){




                $arr = array('price','usdt_type','usdt_url');
                foreach ($data as $k => $v) {
                    if(!in_array($k,$arr)){
                        return WPreturn(\think\Lang::get('od_cwpzx'),-1);
                    }
                }
                $file = request()->file();
                if($file){
                    return WPreturn(\think\Lang::get('od_cwpzx'),-1);
                }
                if(!$data['price']){
                    return WPreturn(\think\Lang::get('ue_qsrxjje'),-1);
                }
                //验证申请金额
                $user = $this->user;
                if($user['ustatus'] != 0){
                    return WPreturn(\think\Lang::get('ue_bqnwqcj'),-1);
                }
                $conf = $this->conf;





                if($conf['is_cash'] != 1){
                    return WPreturn(\think\Lang::get('ue_bqzswfcj'),-1);
                }
                if($conf['cash_min'] > $data['price']){
                    return WPreturn(\think\Lang::get('ue_dbzdtxjew').$conf['cash_min'],-1);
                }
                if($conf['cash_max'] < $data['price']){
                    return WPreturn(\think\Lang::get('ue_dbzgtxjew').$conf['cash_max'],-1);
                }
                if($data['price']%10!=0){
                    return WPreturn(\think\Lang::get('ue_txjebxwsdbs'),-1);
                }

                if(empty($data['usdt_url'])||empty($data['usdt_type'])){
                    return WPreturn(\think\Lang::get('jse_qsrtbdz'),-1);
                }


                $_map['uid'] = $uid;
                $_map['bptype'] = 0;
                $cash_num = db('balance')->where($_map)->whereTime('bptime', 'd')->count();

                if($cash_num + 1 > $conf['day_cash']){
                    return WPreturn(\think\Lang::get('ue_mrzdtxcsw').$conf['day_cash'].\think\Lang::get('ue_ci'),-1);
                }
                $cash_day_max = db('balance')->where($_map)->whereTime('bptime', 'd')->sum('bpprice');
                if($conf['cash_day_max'] < $cash_day_max + $data['price']){
                    return WPreturn(\think\Lang::get('ue_drljzgtxjew').$conf['cash_day_max'],-1);
                }

                if(date('H') == 6 || date('H')==0){
                    return WPreturn(\think\Lang::get('ue_cjsjwrzdzw'),-1);
                }
                if(date('H') < 10 || date('H') > 23){
                    return WPreturn(\think\Lang::get('ue_cjsjwrzdzw'),-1);
                }



                //代理商的话判断金额是否够
                if($this->user['otype'] == 101){
                    if( ($this->user['usermoney'] - $data['price']) < $this->user['minprice'] ){
                        return WPreturn(\think\Lang::get('ue_ndbzjs').$this->user['minprice'].\think\Lang::get('ue_ywxhbsybzj'),-1);
                    }
                }

                if($this->user['otype'] == 0){
                    if (($this->user['usermoney'] - $data['price']) < 0) {
                        return WPreturn(\think\Lang::get('ue_zwgtxjew').$this->user['usermoney'].\think\Lang::get('ue_yuan'),-1);
                    }
                }

                if( ($this->user['usermoney'] - $data['price']) < 0){
                    return WPreturn(\think\Lang::get('ue_zwgtxjew').$this->user['usermoney'].\think\Lang::get('ue_yuan'),-1);
                }



                //签约信息
                //$mybank = db('bankcard')->where('uid',$uid)->find();



                //提现申请
                $newdata['usdt_url'] = $data['usdt_url'];
                $newdata['usdt_type'] = $data['usdt_type'];
                $newdata['bpprice'] = $data['price'];
                $newdata['bptime'] = time();
                $newdata['bptype'] = 0;
                $newdata['remarks'] = \think\Lang::get('ue_hytx');
                $newdata['uid'] = $uid;
                $newdata['isverified'] = 0;
                $newdata['bpbalance'] = 0;
                $newdata['bankid'] = $uid;
                $newdata['btime'] = time();
                $newdata['reg_par'] = $conf['reg_par'];
                $newdata['balance_sn'] = $uid.time().rand(1111,9999);


                $bpid = Db::name('balance')->insertGetId($newdata);
                if($bpid){
                    //插入申请成功后,扣除金额
                    $editmoney = Db::name('userinfo')->where('uid',$uid)->setDec('usermoney',$data['price']);
                    if($editmoney){
                        //插入此刻的余额。
                        $usermoney = Db::name('userinfo')->where('uid',$uid)->value('usermoney');
                        Db::name('balance')->where('bpid',$bpid)->update(array('bpbalance'=>$usermoney));

                        //资金日志
                        set_price_log($uid,2,$data['price'],\think\Lang::get('ue_tx'),\think\Lang::get('ue_txsq'),$bpid,$usermoney);

                        return WPreturn(\think\Lang::get('ue_txsqtjcg'),1);
                    }else{
                        //扣除金额失败，删除提现记录
                        Db::name('balance')->where('bpid',$bpid)->delete();
                        return WPreturn(\think\Lang::get('ue_txsb'),-1);
                    }

                }else{
                    return WPreturn(\think\Lang::get('ue_txsb'),-1);
                }



            }else{
                return WPreturn(\think\Lang::get('ae_zbzcczflx'),-1);
            }
        }else{

            $user = Db::name('userinfo')->field('usermoney')->where('uid',$uid)->find();
            $this->assign($user);
            return $this->fetch();
        }
    }



    /**
     * 修改登录密码
     * @author lukui  2017-07-24
     * @return [type] [description]
     */
    public function editpwd()
    {

        $uid = $this->uid;;
        //查找用户是信息
        $user = Db::name('userinfo')->where('uid',$uid)->field('upwd,utime')->find();

        //添加密码
        if(input('post.')){
            $data = input('post.');
            if(!isset($data['oldpwd']) || empty($data['oldpwd'])){
                return WPreturn(\think\Lang::get('ae_qsrysmm'),-1);
            }
            //验证密码
            if($user['upwd'] != md5($data['oldpwd'].$user['utime'])){
                return WPreturn(\think\Lang::get('us_ysmmcwqcs'),-1);
            }
            if(!isset($data['newpwd']) || empty($data['newpwd'])){
                return WPreturn(\think\Lang::get('us_qsrxddlmm'),-1);
            }
            if(!isset($data['newpwd2']) || empty($data['newpwd2'])){
                return WPreturn(\think\Lang::get('us_qqrxdlmm'),-1);
            }
            if($data['newpwd'] != $data['newpwd2']){
                return WPreturn(\think\Lang::get('ue_lcsrdmmbt'),-1);
            }
            if($data['oldpwd'] == $data['newpwd']){
                return WPreturn(\think\Lang::get('ue_qbyxgwymm'),-1);
            }

            $adddata['upwd'] = trim($data['newpwd']);
            $adddata['upwd'] = md5($adddata['upwd'].$user['utime']);
            $adddata['uid'] = $uid;

            $newids = Db::name('userinfo')->update($adddata);
            if ($newids) {
                return WPreturn(\think\Lang::get('li_xgcg'),1);
            }else{
                return WPreturn(\think\Lang::get('ue_xgsbqcs'),-1);
            }

        }


        return $this->fetch();

    }



    /**
     * 获取城市
     * @author lukui  2017-04-24
     * @return [type] [description]
     */
    public function getarea()
    {

        $id = input('id');
        if(!$id){
            return false;
        }

        $list = db('area')->where('pid',$id)->select();
        $data = '<option value="">'.\think\Lang::get('ue_qxz').'</option>';
        foreach ($list as $k => $v) {
            $data .= '<option value="'.$v['id'].'">'.$v['name'].'</option>';
        }
        echo $data;

    }


    /**
     * 签约
     * @author lukui  2017-07-03
     * @return [type] [description]
     */
    public function dobanks()
    {
        $arr = array('bankno','provinceid','cityno','address','accntnm','accntno','scard','phone','id','usdt_url');
        $post = input('post.');
        foreach ($post as $k => $v) {

            if(empty($v)){
                return WPreturn(\think\Lang::get('ue_qtxzqdxx'),-1);
            }
            if(!in_array($k,$arr)){
                return WPreturn(\think\Lang::get('od_cwpzx'),-1);
            }
            $post[$k] = trim($v);

        }
        $file = request()->file();
        if($file){
            return WPreturn(\think\Lang::get('od_cwpzx'),-1);
        }

        if(isset($post['id']) && !empty($post['id'])){

            $ids = db('bankcard')->update($post);
        }else{
            unset($post['id']);
            $post['uid'] = $this->uid;
            $ids = db('bankcard')->insert($post);
        }

        if ($ids) {
            return WPreturn(\think\Lang::get('ue_czcg'),1);
        }else{
            return WPreturn(\think\Lang::get('ue_czsbqcs'),-1);
        }



    }



    public function ajax_price_list()
    {
        $uid = $this->uid;

        $list = db('price_log')->where('uid',$uid)->order('id desc')->paginate(20);
        return $list;

    }
    /**
     * 用户充值
     */
    public function addbalance()
    {
        $post = input('get.');
        if(!$post){
            $this->error(\think\Lang::get('ue_cscw'));
        }

        /*$arr = array('pay_type','bpprice');
     foreach ($post as $k => $v) {

         if(!in_array($k,$arr)){

             return WPreturn('错误的配置项',-1);
         }
     }
     */

        $file = request()->file();
        if($file){
            return WPreturn(\think\Lang::get('od_cwpzx'),-1);
        }
        if(!$post['pay_type'] || !$post['bpprice']){
            return WPreturn(\think\Lang::get('ue_cscw'),-1);
        }

        if(!strpos($post['bpprice'],'.')){

            $post['bpprice'] = $post['bpprice'];

        }
        //$post['bpprice'] = 0.1;
        //$this->error('系统升级中！');
        //$post['bpprice'] = 105.1;
        //$post['pay_type'] = 'qtb_pay_wxpay_code';
        $uid = $this->uid;
        $user = $this->user;
        $nowtime = time();
        //插入充值数据
        $data['bptype'] = 3;
        $data['bptime'] = $nowtime;
        //$data['bpprice'] = $post['bpprice']/6.8;
        $data['bpprice'] = $post['bpprice'];
        //$data['bpprice'] = 0.1;
        $data['remarks'] = \think\Lang::get('ae_yhcz');
        if($post['pay_type'] == 'bank_deposit'){
            $data['remarks'] = \think\Lang::get('ae_yhcz').'(USDT)';
        }



        $data['uid'] = $uid;
        $data['isverified'] = 0;
        $data['btime'] = $nowtime;
        $data['reg_par'] = 0;
        $data['balance_sn'] = $uid.$nowtime.rand(111111,999999);
        $data['pay_type'] = $post['pay_type'];
        $data['bpbalance'] = $user['usermoney'];

        $ids = db('balance')->insertGetId($data);
        if(!$ids){
            return WPreturn(\think\Lang::get('ue_wlyc'),-1);
        }

        $data['bpid'] = $ids;
        //print_r($data);exit;
        $Pay = controller('Pay');




        if($post['pay_type'] == 'bank_deposit'){

            $usdt_url = getconf('usdt_url');
            $this->assign('usdt_url',$usdt_url);
            //print_r($usdt_url );exit;
            $this->assign('money',$data['bpprice']);
            return $this->fetch('bank_deposit');

        }



        if($post['pay_type'] !='bank_deposit'){

            $res = $Pay -> syt_alipay($data,$post['pay_type']);
            /*$regs = $res;


            $str_ca = '打开后拿另一台设备,扫描二维码';
            $this->assign('str_ca',$str_ca);
            $this->assign('res',$regs);
            return $this->fetch();*/

        }





    }

    /**
     * 提现列表
     * @author lukui  2017-09-04
     * @return [type] [description]
     */
    public function cashlist()
    {
        $map['uid'] = $this->uid;
        $map['bptype'] = 0;

        $list = db('balance')->where($map)->order('bpid desc')->select();

        $this->assign('list',$list);

        return $this->fetch();
    }


    /**
     * 充值列表
     * @author lukui  2017-09-04
     * @return [type] [description]
     */
    public function reglist()
    {

        $map['uid'] = $this->uid;
        $map['bptype'] = 1;

        $list = db('balance')->where($map)->order('bpid desc')->select();

        $this->assign('list',$list);

        return $this->fetch();
    }



    public function kefucode()
    {
        return $this->fetch();
    }






}
