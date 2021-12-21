<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Cookie;

class Currencytrade extends Controller
{

    /*添加订单*/
    public function addorder(){
        $trade_type = input('trade_type'); // 0买 1卖
        $num = floatval(input('num')) ;//数量
        $amount = floatval( input('amount'));//金额
        $currency = input('currency');//法币币种
        $symbol = input('symbol');//虚拟币
        if(!$_SESSION['uid']){
            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_cwcs')]);die;
        }
        if($trade_type == 1){

            $payment = input('payment'); //收款方式
            $pay_id = db('user_payment_method')->where('id',$payment)->value('type');
        }else{
            $pay_id = input('payment');//支付方式
            $shoukuan = db('user_payment_method')->where(['user_id'=>$_SESSION['uid'],'type'=>$pay_id])->find();

            $payment = 0;
        }



        if($trade_type == '' || $currency == '' || $symbol == '' || $pay_id == 0){
            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_cwcs')]);die;
        }
        if(!$num && !$amount){
            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_qtxjyd')]);die;
        }
        //汇率
        $exc_rate = getCurrencyHuilv($currency);
        //虚拟币价格
        if($symbol == 'USDT' || $symbol == 'AGC'){
            $s_price = 1;

        }else{
            $tick = getHuobiSymbolMarketDetail($symbol.'USDT');
            $s_price =  $tick['close']?floatval($tick['close']):1 ;
        }

        $user_id = $_SESSION['uid'];

        $num = $num ?  $num : sprintf('%.6f',$amount/$exc_rate/$s_price); ;

        //会员余额
        if($trade_type == 1){
            $usermoney = db('zc')->where(['yh'=>$user_id,'qb'=>3,'cp'=>$symbol])->value('sl');

            if($usermoney<$num){
                echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_yebz')]);die;
            }
        }




        //匹配订单
        $where['trade_type'] = $trade_type==1 ? 0 : 1;
        $where['symbol'] = $symbol;
        $where['status'] = 0;
        $where['pay_id'] = $pay_id;//$payment;

        $where['isnotdone_num'] = ['egt',$num];
        $where['user_id'] = ['neq',$user_id];
        $where['currency_type'] = $currency;
        $has_matchs = Db::name('currency_shevles_order')->where($where)->select();

        //var_dump($has_match);die;
        //$has_match = Db::name('currency_shevles_order')->where($where)->find();
        if(0>0){
            $rand_num = mt_rand(1,count($has_matchs));
            //var_dump($rand_num);die;
            $has_match = $has_matchs[$rand_num-1];
            $order_sn = 'CT'.$_SESSION['uid'].time().mt_rand(1000,9999);
            $trade_order = array(
                'user_id'=>$_SESSION['uid'],
                'order_sn'=>$order_sn,//'CT'.$_SESSION['uid'].time().mt_rand(1000,9999),
                'currency_type'=>$currency,
                'symbol'=>$symbol,
                't_amount'=>$amount,
                't_num'=>$num,
                'c_exc_rate'=>$exc_rate,
                's_price'=>$s_price,
                'addtime'=>time(),
                'status'=>0,
                //'isnotdone_num'=>$num,
                'trade_type'=>$trade_type,
                'pay_id'=>$pay_id,
                'payment_method'=>$payment,
                'oid'=>$has_match['id'],
                'endtime'=>time() + 60*15,
                'update_time'=>time()
            );
            $res = Db::name('currency_trade_order')->insertGetId($trade_order);
            if($res){
                $new_num = $has_match['isnotdone_num'] - $num;

                $update = array(
                    'status'=>$new_num>0?0:1,
                    'isnotdone_num'=>$new_num
                );
                Db::name('currency_shevles_order')->where('id',$has_match['id'])->update($update);

                if($trade_type == 1){
                    //下单成功减用户余额
                    log_account_change($user_id,3,$symbol,-1*$num,$num,\think\Lang::get('fbjy_fbjycs'),0);
                }

                $msm = controller('Msm');

                $phone = db::name('userinfo')->where('uid',$has_match['user_id'])->value('utel');
                if($phone){
                    $typename = $has_match['trade_type'] == 1?\think\Lang::get('fbjy_m'):\think\Lang::get('fbjy_m2');

                    $math_side = $has_match['trade_type'] == 1?\think\Lang::get('fbjy_mj'):\think\Lang::get('fbjy_mj2');

                    $msg_end = $has_match['trade_type'] == 1?\think\Lang::get('fbjy_qzqwsk'):\think\Lang::get('fbjy_qqwzf');
                    //订单尾号
                    $order_sn_end = substr($has_match['order_sn'],-5);
                    $content = \think\Lang::get('fbjy_nyygd').$typename.\think\Lang::get('fbjy_ddddwh').$order_sn_end.\think\Lang::get('fbjy_ppdl').$math_side.\think\Lang::get('fbjy_ppddhw').$order_sn.'。'.$msg_end;
                    $send_res = $msm->sendEmailToMember(0, $content ,$phone );
                    if(!$send_res){
                        text_log('msg_fail_send',$content);
                    }
                }


                echo json_encode(['code'=>1,'msg'=>\think\Lang::get('fbjy_ddppcg'),'match'=>1,'id'=>$res]);die;

            }else{
                echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_ddscsb')]);die;
            }

        }
        else{

//            if($payment == 0){
//                if(!$shoukuan){
//                    echo json_encode(['code'=>-1,'msg'=>'请你先绑定收款方式']);die;
//                }
//                $payment = $shoukuan['id'];
//            }

            $insert = array(
                'user_id'=>$_SESSION['uid'],
                'order_sn'=>'CS'.$_SESSION['uid'].time().mt_rand(1000,9999),
                'currency_type'=>$currency,
                'symbol'=>$symbol,
                't_amount'=>$amount,
                't_num'=>$num,
                'c_exc_rate'=>$exc_rate,
                's_price'=>$s_price,
                'addtime'=>time(),
                'status'=>0,
                'isnotdone_num'=>$num,
                'trade_type'=>$trade_type,
                'pay_id'=>$pay_id,
                'payment_method'=>$payment,
                'user_type'=> Db::name('userinfo')->where('uid',$user_id)->value('user_type')
            );
            //var_dump($insert);die;
            $res = Db::name('currency_shevles_order')->insert($insert);
            if($res){
                //下单成功减用户余额
                if($trade_type == 1) {
                    log_account_change($user_id, 3, $symbol, -1 * $num, $num, \think\Lang::get('fbjy_fbjycs'), 0);
                }
                echo json_encode(['code'=>1,'msg'=>\think\Lang::get('fbjy_gdcg'),'match'=>0]);die;
            }else{
                echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_ddscsb')]);die;
            }
        }

    }

    /*自选下单*/
    public function self_check_order(){
        $id = input('id');
        $amount = input('amount');
        $num = input('num');
        $payment = input('payment');
        $user_id = $_SESSION['uid'];
        $match_order = Db::name('currency_shevles_order')->where('id',$id)->find();

        $num = $num ? $num : sprintf('%.6f',$amount/$match_order['s_price']/$match_order['c_exc_rate']);

        if($match_order['isnotdone_num']< $num){
            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_kjysl')]);die;
        }

        if($match_order['user_id'] == $_SESSION['uid']){
            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_kjysl')]);die;
        }

        $trade_type = $match_order['trade_type'] == 1? 0 : 1;
        if($trade_type == 1){
            $usermoney = db('zc')->where(['yh'=>$user_id,'qb'=>3,'cp'=>$match_order['symbol']])->value('sl');

            if($usermoney<$num){
                echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_yebz')]);die;
            }
        }
        if($trade_type){
            if(!$payment){
                echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_qxzskfs')]);die;
            }
        }




        $insert = array(
            'user_id'=>$_SESSION['uid'],
            'order_sn'=>'CT'.$_SESSION['uid'].time().mt_rand(1000,9999),
            'currency_type'=>$match_order['currency_type'],
            'symbol'=>$match_order['symbol'],
            't_amount'=>$amount,
            't_num'=>$num,
            'c_exc_rate'=>$match_order['c_exc_rate'],
            's_price'=>$match_order['s_price'],
            'addtime'=>time(),
            'status'=>0,
            //'isnotdone_num'=>$num,
            'trade_type'=>$match_order['trade_type'] == 1? 0 : 1,
            'pay_id'=>$match_order['pay_id'],
            'payment_method'=>$match_order['payment_method']?$match_order['payment_method']:$payment,
            'oid'=>$match_order['id'],
            'endtime'=>time() + 60*15,
            'update_time'=>time()
        );
        $res = Db::name('currency_trade_order')->insertGetId($insert);
        if($res){

            $new_num = $match_order['isnotdone_num'] - $num;

            $update = array(
                'status'=>$new_num>0?0:1,
                'isnotdone_num'=>$new_num
            );
            Db::name('currency_shevles_order')->where('id',$match_order['id'])->update($update);


            //下单成功减用户余额
            if($trade_type == 1){
                log_account_change($user_id,3,$match_order['symbol'],-1*$num,0,\think\Lang::get('fb_fbjy'),0);
            }


            echo json_encode(['code'=>1,'msg'=>\think\Lang::get('fbjy_ddppcg2'),'match'=>1,'id'=>$res]);die;

        }else{
            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_ddscsb')]);die;
        }


    }



    /*添加收款方式*/

    public function add_payment(){
        $data =     $data = input('post.');
//        $currency = input('currency');
//        $type = input('type');
//        $qrcode = input('image');
//var_dump(  $_SESSION['payment_id']);die;
        if($data['type']){
            $payment  = Db('payment_method')->where('id',$data['type'])->find();
            $values = explode(',',$payment['use_msg']);


            //不必填 字段
            $no_must = array('note');

            foreach ($values as $k=>$v){
                if(!in_array($v,$no_must)){
                    if(empty($data[$v]) || !isset($data[$v])){
                        echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_qtxwzxx')]);die;
                    }
                }


            }

        }

        //银行卡
        if(!empty($data['bank_name']) && !empty($data['bank_num'])){

            $had_insert = Db::name('user_payment_method')->where(['user_id'=>$_SESSION['uid'],'type'=>$data['type'],'currency_type'=>$data['currency'],'bank_num'=>$data['bank_name'],'status'=>1])->find();
            if($had_insert){
                echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_gsfsycz')]);die;
            }else{
                $insert =  array(
                    'user_id'=>$_SESSION['uid'],
                    'type'=>$data['type'],

                    'currency_type'=>$data['currency'],
                    'bank_name'=>$data['bank_name'],
                    'bank_num'=>$data['bank_num'],

                    'account_name'=>isset($data['account_name'])?$data['account_name']:'',
                    'account_num'=>isset($data['account_num'] )?$data['account_num']:'',

                    'bank_branch'=>isset($data['bank_branch'])?$data['bank_branch']:'',
                    'note'=>isset($data['note'])?$data['note']:'',

                    'addtime'=>time(),
                    'qrcode'=>isset($data['image'])?$data['image']:'',

                );
                $res =  Db::name('user_payment_method')->insertGetId($insert);
                $_SESSION['payment_id'] = $res;
                if($res){
                    echo json_encode(['code'=>1,'msg'=>\think\Lang::get('fbjy_tjcg')]);die;
                }else{
                    echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_tjsb2')]);die;
                }

            }
        }else{
            //微信或支付宝
//            $account_name = input('account_name');
//            $account_num = input('account_num');
            $had_insert = Db::name('user_payment_method')->where(['user_id'=>$_SESSION['uid'],'type'=>$data['type'],'currency_type'=>$data['currency'],'account_num'=>$data['account_num'],'status'=>1])->find();
            if($had_insert){
                echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_gsfsycz')]);die;
            }else{
                $insert = array(
                    'user_id'=>$_SESSION['uid'],
                    'type'=>$data['type'],
                    'currency_type'=>$data['currency'],
                    'account_name'=>$data['account_name'],
                    'account_num'=>$data['account_num'],

                    'bank_name'=>isset($data['bank_name'])?$data['bank_name']:'',
                    'bank_num'=>isset($data['bank_num'])?$data['bank_num']:'',


                    'bank_branch'=>isset($data['bank_branch'])?$data['bank_branch']:'',
                    'note'=>isset($data['note'])?$data['note']:'',

                    'addtime'=>time(),
                    'qrcode'=>isset($data['image'])?$data['image']:'',

                );
                $res = Db::name('user_payment_method')->insertGetId($insert);
//                session('payment_id', $res);
                $_SESSION['payment_id'] = $res;
                if($res){
                    echo json_encode(['code'=>1,'msg'=>\think\Lang::get('fbjy_tjcg'),'id'=>$res]);die;
                }else{
                    echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_tjsb2')]);die;
                }
            }
        }

    }
    /*修改收款方式*/
    public function payment_edit(){
        $data  = input('post.');


        if($data['id']){
            $payment  = Db('user_payment_method')->where('id',$data['id'])->find();
            if($payment['user_id'] != $_SESSION['uid']){
                echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_wzdgzdxx')]);die;
            }

            $use_msg = Db('payment_method')->where('id',$payment['type'])->value('use_msg');
            $values = explode(',',$use_msg);

            //不必填 字段
            $no_must = array('note');

            foreach ($values as $k=>$v){
                if(!in_array($v,$no_must)){
                    if(empty($data[$v]) || !isset($data[$v])){
                        echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_qtxwzxx')]);die;
                    }
                }

            }
//            $where = ['user_id'=>$payment['user_id'],'type'=>$payment['type'],'currency_type'=>$payment['currency_type'],'status'=>1];
//            if(isset($data['bank_num'])){
//                $where['bank_num'] = $data['bank_num'];
//            }elseif (isset($data['account_num'])){
//                $where['account_num'] = $data['account_num'];
//            }
//
//            $had_insert = Db::name('user_payment_method')->where($where)->find();
//            if($had_insert){
//                echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_gsfsycz')]);die;
//            }else {
            $update = array(
                'status'=>0,
                'bank_name' => isset( $data['bank_name'])?$data['bank_name']:'',
                'bank_num' =>isset( $data['bank_num'])?$data['bank_num']:'',
                'account_name' => isset($data['account_name']) ? $data['account_name'] : '',
                'account_num' => isset($data['account_num']) ? $data['account_num'] : '',
                'bank_branch' => isset($data['bank_branch']) ? $data['bank_branch'] : '',
                'note' => isset($data['note']) ? $data['note'] : '',
                'addtime' => time(),
                'qrcode' => isset($data['image']) ? $data['image'] : '',
            );
            $res = Db::name('user_payment_method')->where('id',$payment['id'])->update($update);
            $_SESSION['payment_id'] = $data['id'];
            echo json_encode(['code' => 1, 'msg' => \think\Lang::get('li_xgcg')]);
            die;
//            }
        }else{
            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_qszycs')]);die;

        }

    }

    /*验证邮箱*/
    public function email_comfirm(){
        $code = input('code');
//        echo '<pre>';
//        var_dump($_SESSION);die;
        if(!isset($_SESSION['payment_id'])){
            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_wzcw')]);die;
        }
        if(!isset($_SESSION['code'])  || $_SESSION['code'] != $code){
            // || $_SESSION['code'] != $code
            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_yzmcw')]);die;

        }else{
            Db::name('user_payment_method')->where('id',$_SESSION['payment_id'])->update(['status'=>1]);
            unset($_SESSION['code']);
            unset($_SESSION['payment_id']);
            echo json_encode(['code'=>1,'msg'=>\think\Lang::get('fbjy_yzcg')]);die;

        }
    }
    /*卖家确认收款*/
    public function getmoney_comfirm(){
        $code = input('code');
        $id = input('id');

        if(!isset($_SESSION['trade_oid'])){
            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_wzcw')]);die;
        }
        if(!isset($_SESSION['code'])  || $_SESSION['code'] != $code){

            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_wzcw')]);die;

        }else{
            $order = Db::name('currency_trade_order')->where('id',$_SESSION['trade_oid'])->find();

            if($order['customerid'] && $order['trade_type'] == 0){
                //四方回调
                $params = array('status'=>2,'customerid' => $order['customerid'],'sdpayno' => $order['order_sn'],'sdorderno' => $order['api_order_sn'],'total_fee' => $order['t_num'],'paytype' => $order['pay_id'],'if_off' => 2);


                $http = new \http\Http($order['notifyurl'], $this->saltData($params));
                $http->toUrl();

                $resCode = $http->getResCode();
                $resContent = substr(str_replace(' ', '', strip_tags($http->getResContent())), 0, 50);

                $resContent =$this->removeBom($resContent);


                $errInfo = $http->getErrInfo();

                if($resContent == 'success'){


                    $datass['is_notify'] = 1;
                    $datass['notify_state'] = 1;
                    Db('currency_trade_order')->where('id',$order['id'])->update($datass);


                }else{

                    $datass['is_notify'] = 1;
                    $datass['notify_state'] = 2;
                    Db('currency_trade_order')->where('id',$order['id'])->update($datass);
                }
                Db::name('currency_trade_order')->where('id',$_SESSION['trade_oid'])->update(['status'=>2]);
                $shevles_order = Db::name('currency_shevles_order')->where('id',$order['oid'])->field('user_id')->find();
                //减卖家冻结
                log_account_change($shevles_order['user_id'],3,$order['symbol'],0,-1*$order['t_num'],\think\Lang::get('fbjy_fbjy'),0);

                unset($_SESSION['trade_oid']);
                unset($_SESSION['code']);
                echo json_encode(['code'=>2,'msg'=>'验证成功','url'=>$order['returnurl'].'?request_no='.$order['api_order_sn']]);die;

            }else{
                //网站内交易
                if(!$order || $order['status'] != 1){
                    echo json_encode(['code'=>0,'msg'=>\think\Lang::get('as_ddbcz')]);die;
                }
                $shevles_order = Db::name('currency_shevles_order')->where('id',$order['oid'])->find();

                if($shevles_order['user_id'] != $_SESSION['uid']){
                    echo json_encode(['code'=>0,'msg'=>\think\Lang::get('as_ddbcz')]);die;
                }
                //上游卖 下游买
                if($order['trade_type'] == 0){


                    $buyer_type = Db('userinfo')->where('uid',$order['user_id'])->value('user_type');
                    $seller_type = Db('userinfo')->where('uid',$shevles_order['user_id'])->value('user_type');

                    Db::name('currency_trade_order')->where('id',$_SESSION['trade_oid'])->update(['status'=>2]);
                    //减卖家冻结
                    log_account_change($shevles_order['user_id'],3,$order['symbol'],0,-1*$order['t_num'],\think\Lang::get('fbjy_fbjy'),0);
                    if($buyer_type == 0 && $seller_type == 1 && $order['symbol'] == 'AGC'){
                        $ka_fee = getconf('ka_fee');
                        $jiangli = $order['t_num'] * floatval($ka_fee)/100;
                        $order['t_num'] = $order['t_num']  + ($order['t_num'] * floatval($ka_fee)/100);
                        //卡商推荐人获得奖励
                        $parent_id = Db('userinfo')->where('uid',$order['user_id'])->value('parent_id');
                        if($parent_id){
                            $ka_father_fee = getconf('ka_father_fee');
                            $father_num = $jiangli * (floatval($ka_father_fee)/100);
                            if($father_num){
                                log_account_change($parent_id,3,$order['symbol'],$father_num,0,\think\Lang::get('fbjy_parent_gain'),0);
                            }
                        }
                    }

                    //为买家增加 币的余额
                    log_account_change($order['user_id'],3,$order['symbol'],$order['t_num'],0,\think\Lang::get('fbjy_tgfbjyhd'),0);
                }
                else{
                    //上游买 下游卖

                    $buyer_type = Db('userinfo')->where('uid',$shevles_order['user_id'])->value('user_type');
                    $seller_type = Db('userinfo')->where('uid',$order['user_id'])->value('user_type');
                    Db::name('currency_trade_order')->where('id',$order['id'])->update(['status'=>2]);
                    //减卖家冻结
                    log_account_change($order['user_id'],3,$order['symbol'],0,-1*$order['t_num'],\think\Lang::get('fbjy_fbjy'),0);
                    if($buyer_type == 0 && $seller_type == 1 && $order['symbol'] == 'AGC'){
                        //卡商购买承兑商
                        $ka_fee = getconf('ka_fee');
                        $jiangli = $order['t_num'] * floatval($ka_fee)/100;
                        $order['t_num'] = $order['t_num']  + ($order['t_num'] * floatval($ka_fee)/100);
                        //卡商推荐人获得奖励
                        $parent_id = Db('userinfo')->where('uid',$shevles_order['user_id'])->value('parent_id');
                        if($parent_id){
                            $ka_father_fee = getconf('ka_father_fee');
                            $father_num = $jiangli * (floatval($ka_father_fee)/100);
                            if($father_num){
                                log_account_change($parent_id,3,$order['symbol'],$father_num,0,\think\Lang::get('fbjy_parent_gain'),0);
                            }
                        }

                    }

                    //为买家增加 币的余额
                    log_account_change($shevles_order['user_id'],3,$order['symbol'],$order['t_num'],0,\think\Lang::get('fbjy_tgfbjyhd'),0);

                }




                unset($_SESSION['trade_oid']);
                unset($_SESSION['code']);
                echo json_encode(['code'=>1,'msg'=>\think\Lang::get('fbjy_yzcg')]);die;
            }



        }
    }

    /*卖家拒绝放行订单*/
    public function refused_order(){
        $oid = input('id');
        $order = db('currency_trade_order')->where('id',$oid)->find();
        if($order['trade_type'] == 0 ){
            $orders = Db::name('currency_shevles_order')->where('id',$order['oid'])->find();
            if($orders['user_id'] != $_SESSION['uid']){
                echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_nmyqxcz')]);die;
            }
        }else{
            if($order['user_id'] != $_SESSION['uid']){
                echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_nmyqxcz')]);die;
            }
        }
        if($order['status'] != 1){
            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_ddbkjj')]);die;
        }
        $res = db('currency_trade_order')->where('id',$oid)->update(['status'=>6]);
        if($res){



            if($order['customerid']&&$order['trade_type']==0){



                $params = array('status'=>1,'customerid' => $order['customerid'],'sdpayno' => $order['order_sn'],'sdorderno' => $order['api_order_sn'],'total_fee' => $order['t_num'],'paytype' => $order['pay_id'],'if_off' => 1);

                $http = new \http\Http($order['notifyurl'], $this->saltData($params));
                $http->toUrl();
                $http->getResCode();
                $resContent = substr(str_replace(' ', '', strip_tags($http->getResContent())), 0, 50);
                $resContent =$this->removeBom($resContent);
                $http->getErrInfo();


            }

            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_jjcg')]);die;
        }else{
            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_ddbkjj')]);die;
        }

    }

    /*获取汇率接口*/
    public function getExcRate(){
        $cur = input('currency');
        if(!$cur){
            echo json_encode(['status'=>0,'msg'=>\think\Lang::get('fbjy_wcshcsbd')]);die;
        }
        $huilv =  Db::name('currency')->where('name',strtoupper($cur))->value('huilv');
        if($huilv){
            echo json_encode(['status'=>1,'data'=>floatval($huilv)]);die;
        }else{
            echo json_encode(['status'=>0,'msg'=>\think\Lang::get('fbjy_wcbzsj')]);die;
        }
    }

    public function saltData($data)
    {
        $apikey = Db('customer')->where("id = '".$data['customerid']."'")->value('key');
        $signstr = 'customerid=' . $data['customerid'] . '&status=' . $data['status'] . '&sdpayno=' . $data['sdpayno'] . '&sdorderno=' . $data['sdorderno'] . '&total_fee=' . $data['total_fee'] . '&paytype=' . $data['paytype'] . '&' . $apikey;
        $data += array('sign' => md5($signstr));
        return $data;
    }




    public function removeBom($string)//去除BOM
    {
        if (substr($string, 0, 3) == pack("CCC", 0xef, 0xbb, 0xbf)) {
            return substr($string, 3);
        }
        return $string;
    }
    /*自选区 获取收款方式*/
    public function optional_get_payment(){
        $currency = input('currency');

        $oid = input('oid');

        $uid = $_SESSION['uid'];
        if(!$uid){
            echo json_encode(['code'=>0,'msg'=>'错误参数']);die;
        }

        $pay_id = Db('currency_shevles_order')->where('id',$oid)->value('pay_id');

        $list = Db::name('user_payment_method')->where(['user_id'=>$uid,'currency_type'=>$currency,'status'=>1,'type'=>$pay_id])->order('id desc')->select();

        if(count($list)>0){
            $type_name = array('微信','支付宝','银行卡');
            foreach ($list as $k=>$v){
                $list[$k]['type_name'] = change_payname_byId($v['type']);// Db::name('payment_method')->where('id',$v['type'])->value('name');// $type_name[$v['type']];
                $list[$k]['account_num'] = $v['account_num']? addstartonum($v['account_num']) :addstartonum( $v['bank_num']);
            }

            echo json_encode(array('code'=>1,'data'=>$list,'pay_id'=>$pay_id));die;
        }else{

//            $all_payments_id = Db('currency')->where('name',$currency)->value('payments');
//            if($all_payments_id){
//                $all_payments_id = explode(',',$all_payments_id);
//
//            }
            $where['id'] =  $pay_id ;//['in',$all_payments_id];
            $payments = db('payment_method')->where($where)->order('id desc')->select();
            if($payments){
                foreach ($payments as $k=>$v){
                    $payments[$k] = change_payment_name($v);
                }
            }
            $payments = isset($payments)?$payments:'';
            echo json_encode(array('code'=>0,'list'=>$payments,'pay_id'=>$pay_id));die;
        }

    }

    /*获取收款方式*/
    public function get_payment(){
        $currency = input('currency');

        $uid = $_SESSION['uid'];
        if(!$uid){
            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_cwcs')]);die;
        }


        $list = Db::name('user_payment_method')->where(['user_id'=>$uid,'currency_type'=>$currency,'status'=>1])->order('id desc')->select();

        if(count($list)>0){
            $type_name = array(\think\Lang::get('fbjy_wx'),\think\Lang::get('fbjy_zfb'),\think\Lang::get('fbjy_yhk'));
            foreach ($list as $k=>$v){
                $payment_method = Db::name('payment_method')->where('id',$v['type'])->find();// $type_name[$v['type']];
                $payment_method =  change_payment_name($payment_method);
                $list[$k]['type_name'] = $payment_method['name'];
                $list[$k]['account_num'] = $v['account_num']? addstartonum($v['account_num']) :addstartonum( $v['bank_num']);
            }

            echo json_encode(array('code'=>1,'data'=>$list));die;
        }else{

            $all_payments_id = Db('currency')->where('name',$currency)->value('payments');
            if($all_payments_id){
                $all_payments_id = explode(',',$all_payments_id);
                $where['id'] = ['in',$all_payments_id];
                $payments = db('payment_method')->where($where)->order('id desc')->select();
                if($payments){
                    foreach ($payments as $k=>$v){
                        $payments[$k] = change_payment_name($v);
                    }
                }
            }
            $payments = isset($payments)?$payments:'';
            echo json_encode(array('code'=>0,'list'=>$payments));die;
        }


    }

    /*撤销挂单*/
    public function goback_shevles_order(){
        $oid = input('oid');
        $order = db('currency_shevles_order')->where('id',$oid)->find();
        if($order['status'] == 0 && $order['user_id'] == $_SESSION['uid']){
            db('currency_shevles_order')->where('id',$oid)->update(['status'=>2]);
            //把剩余的数量返回给用户
            if($order['trade_type'] == 1){
                $isnotdone_num = $order['isnotdone_num'];
                if($isnotdone_num>0){
                    log_account_change($order['user_id'],3,$order['symbol'],$isnotdone_num,-1*$isnotdone_num,\think\Lang::get('fbjy_xjdd'),0);
                }
            }

            echo json_encode(['code'=>1,'msg'=>\think\Lang::get('fbjy_qxcg')]);die;
        }else{
            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_gddbkqx')]);die;
        }
    }



    /*买方取消订单*/
    public function cancel_order(){
        $oid = input('oid');
        $order = db('currency_trade_order')->where('id',$oid)->find();


        if($order['status'] <= 1){
            $fa_orders = Db::name('currency_shevles_order')->where('id',$order['oid'])->find();
            if( !$fa_orders  || $order['user_id'] != $_SESSION['uid'] ){
                echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_gddbkqx')]);die;
            }

            db('currency_trade_order')->where('id',$oid)->update(['status'=>5]);

            $back_notdone = array(
                'isnotdone_num' => $fa_orders['isnotdone_num'] + $order['t_num'],
                'status'=>0,
            );
            Db::name('currency_shevles_order')->where('id',$order['oid'])->update($back_notdone);


            if($order['customerid']&&$order['trade_type']==1){
                //下游提现订单，通知下游
                $shoukuan = db('user_payment_method')->where('id',$order['payment_method'])->find();
                $params = array('status'=>204,'errorCode' => '','errorCodeDesc' => '','userNo' => $order['customerid'],'merchantOrderNo' => $order['api_order_sn'],'platformSerialNo' => $order['order_sn'],'receiverAccountNoEnc' => $shoukuan['bank_num'],'receiverNameEnc' => $shoukuan['account_name']  ,'paidAmount' => number_format($order['t_num'],2,'.',''),'fee' => number_format(0,2,'.',''),'pz_url'=>'');

                text_log('6663331',$this->daifusaltData($params));

                $http = new \http\Http($order['notifyurl'], $this->daifusaltData($params));
                $http->toUrl();

                $http->getResCode();
                $resContent = substr(str_replace(' ', '', strip_tags($http->getResContent())), 0, 50);
                $resContent =$this->removeBom($resContent);
                $http->getErrInfo();
                if($resContent == 'success'){

                    $datass['is_notify'] = 1;
                    $datass['notify_state'] = 1;
                    Db('currency_trade_order')->where('id',$order['id'])->update($datass);
                }else{
                    $datass['is_notify'] = 1;
                    $datass['notify_state'] = 2;
                    Db('currency_trade_order')->where('id',$order['id'])->update($datass);
                }

            }



            echo json_encode(['code'=>1,'msg'=>\think\Lang::get('fbjy_qxcg')]);die;
        }else{
            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_gddbkqx')]);die;
        }
    }
    /*买方确认付款*/
    public function confirm_pay(){

        $id = input('id');
        $order = db('currency_trade_order')->where('id',$id)->find();
        $pz = '';
        if(empty($_SESSION['xypz'])){
            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_qsczfpz')]);die;
        }
        $pz = $_SESSION['xypz'];
        if( $order['customerid'] ){
            if( $order['status'] > 1){
                echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_ddztygx')]);die;
            }
        }else if(!$order  || $order['user_id'] != $_SESSION['uid'] || $order['status'] > 1){
            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_cwcs')]);die;
        }
        
        
        if($order['customerid']&&$order['trade_type']==0) {
            $ip = get_client_ip();
            $dead_time = time() - 720 * 60;


            if (db('currency_trade_order')->where("ip = '" . $ip . "' and customerid = '" . $order['customerid'] . "'  and user_id = '" . $order['user_id'] . "'  and status = 1 and addtime >= '" . $dead_time . "' ")->count()) {

                text_log('666333',"ip = '" . $ip . "' and customerid = '" . $order['customerid'] . "'  and user_id = '" . $order['user_id'] . "'  and status = 1 and addtime >= '" . $dead_time . "' ");

                exit(json_encode(array('error' => 1, 'msg' => \think\Lang::get('fbjy_ddhyczqsh'))));
            }
        }

        

        if($order['status'] == 0){
            $end_time = time() + 60*360;
            $res = db('currency_trade_order')->where('id',$id)->update(['status'=>1,'endtime'=>$end_time,'update_time'=>time(),'pay_done_img'=>$pz]);
            $_SESSION['xypz']='';
        }elseif ($order['status'] == 1){
            $res = 1;
        }

        if($res){
            if($order['customerid']&&$order['trade_type']==1){
                //下游提现订单，通知下游
                $shoukuan = db('user_payment_method')->where('id',$order['payment_method'])->find();
                $params = array('status'=>205,'errorCode' => '','errorCodeDesc' => '','userNo' => $order['customerid'],'merchantOrderNo' => $order['api_order_sn'],'platformSerialNo' => $order['order_sn'],'receiverAccountNoEnc' => $shoukuan['bank_num'],'receiverNameEnc' => $shoukuan['account_name']  ,'paidAmount' => number_format($order['t_num'],2,'.',''),'fee' => number_format(0,2,'.',''),'pz_url'=>'http://'.$_SERVER['HTTP_HOST'].'/public/uploads/'.$pz);

                text_log('666333',$this->daifusaltData($params));

                $http = new \http\Http($order['notifyurl'], $this->daifusaltData($params));
                $http->toUrl();

                $http->getResCode();
                $resContent = substr(str_replace(' ', '', strip_tags($http->getResContent())), 0, 50);
                $resContent =$this->removeBom($resContent);
                $http->getErrInfo();
                if($resContent == 'success'){

                    $datass['is_notify'] = 1;
                    $datass['notify_state'] = 1;
                    Db('currency_trade_order')->where('id',$order['id'])->update($datass);
                }else{
                    $datass['is_notify'] = 1;
                    $datass['notify_state'] = 2;
                    Db('currency_trade_order')->where('id',$order['id'])->update($datass);
                }

            }

            if($order['customerid']&&$order['trade_type']==0){
                //下游充值订单，发邮件
                $msm = controller('Msm');
                $order_sn = $order['order_sn'];
                $has_match = Db::name('currency_shevles_order')->where('id',$order['oid'])->find();

                $phone = db::name('userinfo')->where('uid',$has_match['user_id'])->value('utel');
                if($phone){
                    $typename = $has_match['trade_type'] == 1?\think\Lang::get('fbjy_m'):\think\Lang::get('fbjy_m2');

                    $math_side = $has_match['trade_type'] == 1?\think\Lang::get('fbjy_mj'):\think\Lang::get('fbjy_mj2');

                    $msg_end = $has_match['trade_type'] == 1?\think\Lang::get('fbjy_qzqwsk'):\think\Lang::get('fbjy_qqwzf');
                    //订单尾号
                    $order_sn_end = substr($has_match['order_sn'],-5);
                    $content = \think\Lang::get('fbjy_nyygd').$typename.\think\Lang::get('fbjy_ddddwh').$order_sn_end.\think\Lang::get('fbjy_ppdl').$math_side.\think\Lang::get('fbjy_ppddhw').$order_sn.'。'.$msg_end;
                    $send_res = $msm->sendEmailToMember(0, $content ,$phone );
                    if(!$send_res){
                        text_log('msg_fail_send',$content);
                    }
                }

                //发送凭证到下游
                $params = array('status'=>2,'customerid' => $order['customerid'],'sdpayno' => $order['order_sn'],'sdorderno' => $order['api_order_sn'],'total_fee' => $order['t_num'],'paytype' => $order['pay_id'],'pz_url'=>'http://'.$_SERVER['HTTP_HOST'].'/public/uploads/'.$pz);

                $http = new \http\Http($order['notifyurl'], $this->saltData($params));
                $http->toUrl();
                $http->getResCode();
                $resContent = substr(str_replace(' ', '', strip_tags($http->getResContent())), 0, 50);
                $resContent =$this->removeBom($resContent);
                $http->getErrInfo();


            }
            echo json_encode(['code'=>1]);die;
        }else{
            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_gxsb')]);die;
        }
    }

    public function daifusaltData($data)
    {
        $apikey = Db('customer')->where("id = '".$data['userNo']."'")->value('key');

        $sign = $this->hmacRequest($data,$apikey);
        $data += array('sign' => $sign);

        return $data;
    }


    public function hmacRequest($params, $key, $encryptType = "1")
    {
        if ("1" == $encryptType) {
            return md5(implode("", $params) . $key);
        } else {
            $private_key = openssl_pkey_get_private($key);
            $params = implode("", $params);
            openssl_sign($params, $sign, $private_key, OPENSSL_ALGO_MD5);
            openssl_free_key($private_key);
            $sign = base64_encode($sign);
            return $sign;
        }

    }


    /*查询订单状态*/
    public function select_order(){
        $id = input('id');
        $order = db('currency_trade_order')->where('id',$id)->find();
        echo json_encode(['code'=>1,'status'=>$order['status']]);die;
    }

    /*获取支付方式*/
    public function get_paymethod(){
        $currency = input('currency');

        $uid = $_SESSION['uid'];
        if(!$uid){
            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_cwcs')]);die;
        }

        $all_payments_id = Db('currency')->where('name',$currency)->value('payments');
        if($all_payments_id){
            $all_payments_id = explode(',',$all_payments_id);
            $where['id'] = ['in',$all_payments_id];
            $payments = db('payment_method')->where($where)->order('id desc')->select();
            if($payments){
                foreach ($payments as $k=>$v){
                    $payments[$k] = change_payment_name($v);
                }
            }
        }
        $payments = isset($payments)?$payments:'';
        echo json_encode(array('code'=>1,'list'=>$payments));die;
    }

    /*获取正在上架的订单*/
    public function get_shevles_order(){
        $currency = input('currency');
        $symbol = input('symbol');
        $page = input('page');
        $trade_type = input('trade_type');

        $size = 15;

        $page_start = $page * $size;

        $where['trade_type'] = $trade_type==1 ? 0 : 1;
        $where['symbol'] = $symbol;
        $where['status'] = 0;
        $where['currency_type'] = $currency;
        //$where['user_id'] = ['neq',$_SESSION['uid']];

        $orders = Db::name('currency_shevles_order')->where($where)->order('id desc')->limit($page_start,$size)->select();

        if($orders){
            foreach ($orders as $k=>$v){
                //用户昵称
                $orders[$k]['nickname'] = Db('userinfo')->where('uid',$v['user_id'])->value('nickname');
                $orders[$k]['nickname_f'] = mb_substr( strip_tags($orders[$k]['nickname']),0,1,"utf-8");

                $user_type = Db('userinfo')->where('uid',$v['user_id'])->value('user_type');
                $orders[$k]['user_type']  = $user_type == 1 ? \think\Lang::get('fbjy_crs'):\think\Lang::get('fbjy_ks');
                //var_dump( $orders[$k]['nickname_f']);die;

                //收款方式
                $orders[$k]['payment_name'] = change_payname_byId($v['pay_id']);// Db('payment_method')->where('id',$v['pay_id'])->value('name');


                //成单量
                $orders[$k]['success_onum'] = Db::name('currency_shevles_order')
                    ->alias('s')
                    ->join('currency_trade_order t','s.id = t.oid')
                    ->where(['s.user_id'=>$v['user_id'],'t.status'=>2])
                    ->count('t.id');
                $orders[$k]['success_onum'] =     $orders[$k]['success_onum']?    $orders[$k]['success_onum']: 0;
                //总订单数量
                $orders[$k]['all_onum'] = Db::name('currency_shevles_order')
                    ->alias('s')
                    ->join('currency_trade_order t','s.id = t.oid')
                    ->where(['s.user_id'=>$v['user_id']])
                    ->count('t.id');
                $orders[$k]['all_onum'] = $orders[$k]['all_onum']?$orders[$k]['all_onum']:1;

                $orders[$k]['success_rate'] = sprintf('%.2f',$orders[$k]['success_onum'] /  $orders[$k]['all_onum'] * 100) ;

                $orders[$k]['one_amount'] = sprintf('%.2f',$v['s_price'] * $v['c_exc_rate']);

                //法币符号
                $currency_icon = Db('currency')->where('name',$v['currency_type'])->value('symbol');
                $orders[$k]['icon'] = $currency_icon;
            }
            //echo '123';

            echo json_encode(array('code'=>1,'list'=>$orders));die;

        }else{
            echo json_encode(['code'=>0]);die;
        }
    }

    /*获取订单信息*/
    public function get_order_info(){
        $id = input('id');
        $where['id'] = $id;
        $orders = Db::name('currency_shevles_order')->where($where)->find();

        //支付方式
        $orders['payment_name'] = change_payname_byId($orders['pay_id']);;// Db('payment_method')->where('id',$orders['pay_id'])->value('name');

        //收款账号
        if($orders['payment_method']){
            $pay = Db('user_payment_method')->where('id',$orders['payment_method'])->find();
            $orders['payment_name'] = $pay['account_name']?$pay['account_name']:'';
            $orders['payment_num'] = $pay['account_num']?$pay['account_num']:$pay['bank_num'];
            $orders['payment_bnum'] = $pay['bank_num']?$pay['bank_num']:'';
        }else{

            $orders['payment_name'] =  change_payname_byId($orders['pay_id']);;// Db('payment_method')->where('id',$orders['pay_id'])->value('name');;
            $orders['payment_num'] = '';
            $orders['payment_bnum'] = '';
        }

        $orders['nickname'] = Db('userinfo')->where('uid',$orders['user_id'])->value('nickname');

        //单价
        $orders['one_amount'] = sprintf('%.2f',$orders['s_price'] * $orders['c_exc_rate']);

        //法币符号
        $currency_icon = Db('currency')->where('name',$orders['currency_type'])->value('symbol');
        $orders['icon'] = $currency_icon;


        //会员的余额
        $user_id = $_SESSION['uid'];
        $has_money = db('zc')->where(['yh'=>$user_id,'qb'=>3,'cp'=>$orders['symbol']])->value('sl');
        $has_money_h = $has_money * $orders['one_amount'];

        echo json_encode(['code'=>1,'data'=>$orders,'has_money_s'=>$has_money,'has_money_c'=> sprintf('%.2f',$has_money_h)]);die;
    }

    /*上传收款二维码*/
    public function upload_payment_qrcode(){
        $FILES = $_FILES['file'];
        //var_dump($FILES);die;
        if(!$FILES){
            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('fbjy_ks2')]);die;
        }
        $res = upload_img($FILES,'payment');
        echo $res;die;
    }



    public function ddmjqrsk()
    {
        $id = input('id');
        if(!$id){

            die(\think\Lang::get('ue_cscw'));

        }
        $order_info = Db::name('currency_trade_order')->where(['id'=>$id,'customerid'=>10891,'trade_type'=>0])->find();

        if(!$order_info){
            die(\think\Lang::get('ue_cscw'));
        }

        $currency = Db::name('currency')->where('name',$order_info['currency_type'])->find();

        if($order_info['oid']){
            $seller_order = Db::name('currency_shevles_order')->where('id',$order_info['oid'])->find();
        }
        $payment_type = db('payment_method')->where('id',$order_info['pay_id'])->find();
        $payment_type['name'] =  change_payname_byId($order_info['pay_id']);

        $payment_method = $order_info['payment_method']?$order_info['payment_method']:$seller_order['payment_method'];
        $shoukuan = db('user_payment_method')->where('id',$payment_method)->find();


        $payment = db('payment_method')->where('id',$order_info['pay_id'])->find();
        $payment = change_payment_name($payment);
        $has_time = $order_info['endtime'] - time();
        $has_time = $has_time>0?$has_time:0;

        //$all_amount = sprintf( '%.2f',$order_info['t_num']*$order_info['c_exc_rate']*$order_info['s_price']);
        $all_amount =sprintf('%.2f',$order_info['t_amount']);

        $url=$order_info['returnurl'].'?request_no='.$order_info['api_order_sn'];

        $one_amount = floatval($order_info['c_exc_rate']*$order_info['s_price']) ;
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
        $this->assign('url',$url);

        return $this->fetch();
    }

    //获取交易订单
    public function ajax_get_torder(){
        $page = input('page');
        $status = input('status');
        if(isset($status) && (int)$status>0){
            $where['status'] = (int)$status-1;
        }
        $size = 20;
        $page_start = $size * intval($page);
        $where['user_id'] = $_SESSION['uid'];
        $order_list = db('currency_trade_order')->where($where)->order('id desc')->limit($page_start,$size)->select();
        if($order_list){
            $trade_type = [\think\Lang::get('sw_gm'),\think\Lang::get('fbjy_cs')];
            $status = array(\think\Lang::get('fbjy_dmjfk'),\think\Lang::get('fbjy_dmjqr'),\think\Lang::get('sl_ywc'),\think\Lang::get('fbjy_ssz'),\think\Lang::get('fbjy_ysx'),\think\Lang::get('fbjy_yqx'),\think\Lang::get('fbjy_mjjujue'));
            foreach ($order_list as $k=>$v){
                $order_list[$k]['add_time'] = date('Y-m-d H:i:s',$v['addtime']);
                $order_list[$k]['one_price'] = sprintf('%.2f',$v['c_exc_rate'] * $v['s_price']);
                $order_list[$k]['all_pay'] = $v['t_num'] *  $order_list[$k]['one_price'];
                $currency_icon = Db('currency')->where('name',$v['currency_type'])->value('symbol');
                $order_list[$k]['icon'] = $currency_icon;
                $order_list[$k]['status_name'] = $status[$v['status']];
                $order_list[$k]['type'] = $trade_type[$v['trade_type']];

                $order_list[$k]['old_order_sn'] =  Db::name('currency_shevles_order')->where('id',$v['oid'])->value('order_sn');
            }
            echo json_encode(['code'=>1,'data'=>$order_list,'page'=>$page+=1]);die;
        }else{
            echo json_encode(['code'=>0]);die;
        }

    }
    //获取待收款订单
    public function ajax_get_waitin_order(){
        $page = input('page');
        $status = input('status');
        if(isset($status) && (int)$status>0){
            $where['t.status'] = (int)$status-1;
        }
        $size = 20;
        $page_start = $size * intval($page);
        $where['s.user_id'] = $_SESSION['uid'];
        $order_list = db('currency_trade_order')
            ->alias('t')
            ->Join('currency_shevles_order s','s.id = t.oid')
            ->field('t.*,s.order_sn as old_order_sn')
            ->where($where)->order('t.id desc')
            ->limit($page_start,$size)->select();
        if($order_list){
            $trade_type = [\think\Lang::get('fbjy_cs'),\think\Lang::get('sw_gm')];
            $status = array(\think\Lang::get('fbjy_dmjfk'),\think\Lang::get('fbjy_dqr'),\think\Lang::get('sl_ywc'),\think\Lang::get('fbjy_ssz'),\think\Lang::get('fbjy_ysx'),\think\Lang::get('fbjy_yxq'),\think\Lang::get('fbjy_mjjujue'));
            foreach ($order_list as $k=>$v){
                $order_list[$k]['add_time'] = date('Y-m-d H:i:s',$v['addtime']);
                $order_list[$k]['one_price'] = sprintf('%.2f',$v['c_exc_rate'] * $v['s_price']);
                $order_list[$k]['all_pay'] = $v['t_num'] *  $order_list[$k]['one_price'];
                $currency_icon = Db('currency')->where('name',$v['currency_type'])->value('symbol');
                $order_list[$k]['icon'] = $currency_icon;
                $order_list[$k]['status_name'] = $status[$v['status']];
                $order_list[$k]['type'] = $trade_type[$v['trade_type']];
            }
            echo json_encode(['code'=>1,'data'=>$order_list,'page'=>$page+=1]);die;
        }else{
            echo json_encode(['code'=>0]);die;
        }

    }

    //获取挂卖挂买订单
    public function ajax_get_sorder(){
        $page = input('page');
        $status = input('status');
        if(isset($status) && (int)$status>0){
            $where['status'] = (int)$status-1;
        }
        $size = 20;
        $page_start = $size * intval($page);
        $where['user_id'] = $_SESSION['uid'];
        $order_list = db('currency_shevles_order')->where($where)->order('id desc')->limit($page_start,$size)->select();
        if($order_list){
            $status = array(\think\Lang::get('ll_jyz'),\think\Lang::get('fbjy_ywc'),\think\Lang::get('fbjy_yxq'));
            $trade_type = [\think\Lang::get('sw_gm'),\think\Lang::get('fbjy_cs')];
            foreach ($order_list as $k=>$v){
                $order_list[$k]['add_time'] = date('Y-m-d H:i:s',$v['addtime']);
                $order_list[$k]['one_price'] = sprintf('%.2f',$v['c_exc_rate'] * $v['s_price']);
                $order_list[$k]['all_pay'] = sprintf('%.2f',$v['t_num'] *  $order_list[$k]['one_price']); ;
                $currency_icon = Db('currency')->where('name',$v['currency_type'])->value('symbol');
                $order_list[$k]['icon'] = $currency_icon;
                $order_list[$k]['status_name'] = $status[$v['status']];
                $order_list[$k]['type'] = $trade_type[$v['trade_type']];
                $order_list[$k]['t_num'] = floatval($v['t_num']);
            }
            $page = intval($page);
            echo json_encode(['code'=>1,'data'=>$order_list,'page'=>$page+=1]);die;
        }else{
            echo json_encode(['code'=>0]);die;
        }

    }

    //刷新汇率
    public function update_currency_table(){
        $list = Db::name('currency')->select();
        $huilvs_arr = getExchangeRate();
        foreach ($list as $k=>$v){
            if(isset($huilvs_arr[$v['name']])){
                Db::name('currency')->where('id',$v['id'])->update(['huilv'=>$huilvs_arr[$v['name']]]);
            }
        }
    }

    //添加收款方式前 选择币种
    public function addpayment(){
        // 获取法币币种
        $tender = Db::name('currency')->field('id,name,symbol,huilv')->select();
        $tenderWord = [];
        $tender_firstw = [];
        foreach ($tender as $key=>$val) {

            $tender[$key]['exc_rate'] = floatval($val['huilv']) ;// getCurrencyHuilv[strtoupper($val['name'])];

            $tender_firstw[$key] = getfirstchar($val['name']);
            $tenderWord[getfirstchar($val['name'])][] = $tender[$key];

        }
        $tender_firstw = array_unique($tender_firstw);

        $this->assign(['tenderWord' => $tenderWord, 'tender' => $tender,'firstw'=>$tender_firstw]);
        return $this->fetch();
    }
    /*删除收款方式*/
    public function payment_del(){
        $id = input('id');
        $shoukuan = db('user_payment_method')->where('id',$id)->find();
        if($shoukuan && $shoukuan['user_id'] == $_SESSION['uid']){
            db('user_payment_method')->where('id',$id)->update(['status'=>0]);
            echo json_encode(['code'=>1,'msg'=>\think\Lang::get('as_cg')]);die;
        }else{
            echo json_encode(['code'=>0,'msg'=>\think\Lang::get('li_xgsb')]);die;
        }
    }

    //搜索币种
    public function  search_curr(){
        $keyword = input('keyword');
        $where['name'] = ['like','%'.$keyword.'%'];
        $list = Db::name('currency')->where($where)->field('id,name,symbol,huilv')->select();
        if($list){
            echo json_encode(['code'=>1,'data'=>$list]);die;
        }else{
            echo json_encode(['code'=>0]);die;
        }

    }

    /*挂卖 匹配买*/
    /*买家付款倒计时15分钟*/
    public function upSellDownBuy_buyerTimeGo(){
        $newtime = time();
        $all_buyorder_list = Db::name('currency_trade_order')->where(['trade_type'=>0,'status'=>0])->select();
        if($all_buyorder_list){
            foreach ($all_buyorder_list as $k=>$v){
                if(!$v['endtime']){
                    $end_time = $v['addtime'] + 60*15;
                }else{
                    $end_time = $v['endtime'];
                }

                if($newtime>=$end_time){
                    $res =  Db::name('currency_trade_order')->where(['id'=>$v['id']])->update(['status'=>4,'update_time'=>$newtime]);
                    //归还挂单的数量
                    if($res){
                        $shevles_order =  Db::name('currency_shevles_order')->where(['id'=>$v['oid']])->field('id,isnotdone_num')->find();
                        if($shevles_order){
                            Db::name('currency_shevles_order')->where(['id'=>$shevles_order['id']])->update(
                                [
                                    'isnotdone_num'=>$shevles_order['isnotdone_num']+$v['t_num'],
                                    //'status'=>0
                                ]
                            );
                        }
                    }
                }
            }
        }
    }

    /*挂卖 匹配买*/
    /*卖家点击我已收款3分钟倒计时*/
    public function UpSellDownBuy_sellerTimeGo(){
        $newtime = time();
        $all_buyorder_list = Db::name('currency_trade_order')->where(['trade_type'=>0,'status'=>1])->select();
        if($all_buyorder_list){
            foreach ($all_buyorder_list as $k=>$v){

                if(!$v['endtime']){
                    $end_time = $v['addtime'] + 60*3;
                }else{
                    $end_time = $v['endtime'];
                }
                $end_time = $v['addtime'] + 60*375;
                if($newtime>=$end_time){
                    //3分钟后自动确认
                    $res =  Db::name('currency_trade_order')->where(['id'=>$v['id']])->update(['status'=>2,'update_time'=>$newtime]);
                    //上分
                    if($res){
                        if(!$v['api_order_sn']){
                            //站内
                            $buyer_type = Db('userinfo')->where('uid',$v['user_id'])->value('user_type');
                            $shevles_order =  Db::name('currency_shevles_order')->where(['id'=>$v['oid']])->field('id,user_id,isnotdone_num')->find();
                            $seller_type = Db('userinfo')->where('uid',$shevles_order['user_id'])->value('user_type');


                            //减卖家冻结
                            log_account_change($shevles_order['user_id'],3,$v['symbol'],0,-1*$v['t_num'],\think\Lang::get('fbjy_fbjy'),0);
                            if($buyer_type == 0 && $seller_type == 1 && $v['symbol'] == 'AGC'){
                                $ka_fee = getconf('ka_fee');
                                $jiangli = $v['t_num'] * floatval($ka_fee)/100;
                                $v['t_num']  = $v['t_num']  + ($v['t_num'] * floatval($ka_fee)/100);
                                //卡商推荐人获得奖励
                                $parent_id = Db('userinfo')->where('uid',$v['user_id'])->value('parent_id');
                                if($parent_id){
                                    $ka_father_fee = getconf('ka_father_fee');
                                    $father_num = $jiangli * (floatval($ka_father_fee)/100);
                                    if($father_num){
                                        log_account_change($parent_id,3,$v['symbol'],$father_num,0,\think\Lang::get('fbjy_parent_gain'),0);
                                    }
                                }
                            }
                            //为买家增加 币的余额
                            log_account_change($v['user_id'],3,$v['symbol'],$v['t_num'],0,\think\Lang::get('fbjy_tgfbjyhd'),0);

                        }else{
                            //站外充值订单
                            $params = array('status'=>2,'customerid' => $v['customerid'],'sdpayno' => $v['order_sn'],'sdorderno' => $v['api_order_sn'],'total_fee' => $v['t_num'],'paytype' => $v['pay_id'],'if_off' => 2);

                            $http = new \http\Http($v['notifyurl'], $this->saltData($params));
                            $http->toUrl();
                            $http->getResCode();
                            $resContent = substr(str_replace(' ', '', strip_tags($http->getResContent())), 0, 50);
                            $resContent =$this->removeBom($resContent);
                            $http->getErrInfo();
                            if($resContent == 'success'){
                                $datass['is_notify'] = 1;
                                $datass['notify_state'] = 1;
                                Db('currency_trade_order')->where('id',$v['id'])->update($datass);
                            }else{
                                $datass['is_notify'] = 1;
                                $datass['notify_state'] = 2;
                                Db('currency_trade_order')->where('id',$v['id'])->update($datass);
                            }
                            $shevles_order =  Db::name('currency_shevles_order')->where(['id'=>$v['oid']])->field('id,user_id,isnotdone_num')->find();
                            //减卖家冻结
                            log_account_change($shevles_order['user_id'],3,$v['symbol'],0,-1*$v['t_num'],\think\Lang::get('fbjy_fbjy'),0);
                        }
                    }
                }
            }
        }
    }

    /*挂买 匹配卖*/
    /*买家确认付款超时*/
    public function upBuyDownSell_buyerTimeGo(){
        $newtime = time();
        $all_order_list = Db::name('currency_trade_order')->where(['trade_type'=>1,'status'=>0])->select();
        if($all_order_list){
            foreach ($all_order_list as $k=>$v){
                if(!$v['endtime']){
                    $end_time = $v['addtime'] + 60*15;
                }else{
                    $end_time = $v['endtime'];
                }
                if($newtime>=$end_time){
                    //未付款退回订单
                    $res =  Db::name('currency_trade_order')->where(['id'=>$v['id']])->update(['status'=>4,'update_time'=>$newtime]);
                    //归还挂单的数量
                    if($res){
                        $shevles_order =  Db::name('currency_shevles_order')->where(['id'=>$v['oid']])->field('id,isnotdone_num')->find();
                        if($shevles_order){
                            $back =  Db::name('currency_shevles_order')->where(['id'=>$shevles_order['id']])->update(
                                [
                                    'isnotdone_num'=>$shevles_order['isnotdone_num']+$v['t_num'],
                                    'status'=>0
                                ]
                            );
                            //四方订单通知，买家不付款
                            if($back && !empty($v['api_order_sn'])){
                                $shoukuan = db('user_payment_method')->where('id',$v['payment_method'])->find();
                                $params = array('status'=>204,'errorCode' => '','errorCodeDesc' => '','userNo' => $v['customerid'],'merchantOrderNo' => $v['api_order_sn'],'platformSerialNo' => $v['order_sn'],'receiverAccountNoEnc' => $shoukuan['bank_num'],'receiverNameEnc' => $shoukuan['account_name']  ,'paidAmount' => number_format($v['t_num'],2,'.',''),'fee' => number_format(0,2,'.',''),'pz_url'=>'');

                                text_log('666333',$this->daifusaltData($params));
                                $http = new \http\Http($v['notifyurl'], $this->daifusaltData($params));
                                $http->toUrl();
                                $http->getResCode();
                                $resContent = substr(str_replace(' ', '', strip_tags($http->getResContent())), 0, 50);
                                $resContent =$this->removeBom($resContent);
                                $http->getErrInfo();
                                if($resContent == 'success'){
                                    $datass['is_notify'] = 1;
                                    $datass['notify_state'] = 1;
                                    Db('currency_trade_order')->where('id',$v['id'])->update($datass);
                                }else{
                                    $datass['is_notify'] = 1;
                                    $datass['notify_state'] = 2;
                                    Db('currency_trade_order')->where('id',$v['id'])->update($datass);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /*挂买 匹配卖*/
    /*卖家点击我已收款倒计时*/
    public function UpBuyDownSell_sellerTimeGo(){
        $newtime = time();
        $all_buyorder_list = Db::name('currency_trade_order')->where(['trade_type'=>1,'status'=>1])->select();
        if($all_buyorder_list){
            foreach ($all_buyorder_list as $k=>$v){

                if(!$v['endtime']){
                    $end_time = $v['addtime'] + 60*3;
                }else{
                    $end_time = $v['endtime'];
                }
                if($newtime>=$end_time){
                    //站内3分钟后自动确认
                    if(!$v['api_order_sn']) {
                        $res = Db::name('currency_trade_order')->where(['id' => $v['id']])->update(['status' => 2, 'update_time' => $newtime]);
                        //上分
                        if ($res) {
                            $seller_type = Db('userinfo')->where('uid', $v['user_id'])->value('user_type');
                            $shevles_order = Db::name('currency_shevles_order')->where(['id' => $v['oid']])->field('id,user_id,isnotdone_num')->find();
                            $buyer_type = Db('userinfo')->where('uid', $shevles_order['user_id'])->value('user_type');

                            //减卖家冻结
                            log_account_change($v['user_id'], 3, $v['symbol'], 0, -1 * $v['t_num'], \think\Lang::get('fbjy_fbjy'), 0);
                            //卡商承兑商交易奖励
                            if ($buyer_type == 0 && $seller_type == 1 && $v['symbol'] == 'AGC') {
                                $ka_fee = getconf('ka_fee');
                                $jiangli = $v['t_num'] * floatval($ka_fee) / 100;
                                $v['t_num'] = $v['t_num'] + ($v['t_num'] * floatval($ka_fee) / 100);
                                //卡商推荐人获得奖励
                                $parent_id = Db('userinfo')->where('uid', $shevles_order['user_id'])->value('parent_id');
                                if ($parent_id) {
                                    $ka_father_fee = getconf('ka_father_fee');
                                    $father_num = $jiangli * (floatval($ka_father_fee) / 100);
                                    if ($father_num) {
                                        log_account_change($parent_id, 3, $v['symbol'], $father_num, 0, \think\Lang::get('fbjy_parent_gain'), 0);
                                    }
                                }
                            }
                            //为买家增加 币的余额
                            log_account_change($shevles_order['user_id'], 3, $v['symbol'], $v['t_num'], 0, \think\Lang::get('fbjy_tgfbjyhd'), 0);
                        }
                    }
                }
            }
        }
    }

    public function uppzimg()
    {

        $file = request()->file("file");
        if(empty($file)){
            exit(json_encode(array('error'=>1,'msg'=>\think\Lang::get('fbjy_qsczfpz'))));
        }
        $info = $file->validate(['size'=>52428800,'ext'=>'jpg,png,gif,jpeg'])->move(ROOT_PATH.'public'.DS.'uploads');
        if($info){
            $data = $info->getSaveName();

            $_SESSION['xypz'] = $data;
            exit(json_encode(array('error'=>0,'msg'=>\think\Lang::get('ue_sccg'),'file_url'=>$data)));
        }else{
            // 上传失败获取错误信息
            $error = $file->getError();
            exit(json_encode(array('error'=>1,'msg'=>\think\Lang::get('ue_scsbqcs'))));
        }

    }
    //批量撤销正在挂的订单
    public function all_goback_shevles_order(){
        $time = input('starttime');
        if(isset($time) || !empty($time)){
            $where['addtime'] = ['elt',$time];
        }else{
            //默认3天前
            $time = mktime(0,0,date('d')-3,date('m'),0,date('Y'));
            $where['addtime'] = ['elt',$time];
        }
        $where['status'] = 0;
        $order = db('currency_shevles_order')->where($where)->field('id,user_id,isnotdone_num,symbol')->select();
        if($order) {
            foreach ($order as $k => $v) {
                db('currency_shevles_order')->where('id', $v['id'])->update(['status' => 2]);
                //把剩余的数量返回给用户
                if($v['trade_type'] == 1){
                    $isnotdone_num = $v['isnotdone_num'];
                    if ($isnotdone_num > 0) {
                        log_account_change($v['user_id'], 3, $v['symbol'], $isnotdone_num, -1 * $isnotdone_num, \think\Lang::get('fbjy_xjdd'), 0);
                    }
                }


            }

        }
    }


}