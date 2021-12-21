<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Cookie;

class Sifang extends Controller
{



    public function __construct(){
        parent::__construct();
        $version = '1.0';
        $customerid = input('post.customerid');
        $sdorderno =  input('post.sdorderno');
        $total_fee =  input('post.total_fee');
        $paytype =  input('post.paytype');
        $notifyurl =  input('post.notifyurl');
        $returnurl =  input('post.returnurl');
        $sign =  input('post.sign');
        $pankouid =  input('post.pankouid');
        $currency = input('post.currency');
        $huilv = input('post.huilv');
        $old_amount = input('post.old_amount');
        $shordr_sn = input('post.shordr_sn');


        if(in_array($currency,array('CNY','JPY','USD','TRY','KRW'))){
            cookie('think_var', strtolower($currency));
        }else{
            cookie('think_var', 'usd');
        }


        if (!isset($_REQUEST) || !$_REQUEST) {
            echo \think\Lang::get('fbjy_ffz');
            exit;
        }

        if ($version == '' || $customerid == '' || $sdorderno == '' || $total_fee == '' || $paytype == '' || $notifyurl == '' || $returnurl == ''|| $sign == '' || $pankouid == '' || $currency == '' || $huilv == '' || $old_amount == '') {
            echo \think\Lang::get('fbjy_csbwz');
            exit;
        }

        if (db('currency_trade_order')->field('id')->where("api_order_sn = '".$sdorderno."' and customerid = '".$customerid."'")->find()) {
            echo \think\Lang::get('fbjy_ddhycz');
            exit;
        }

        $ip = get_client_ip();
        $dead_time = time()-0*60;
        if (db('currency_trade_order')->where("ip = '".$ip."' and customerid = '".$customerid."'  and user_id = '".$pankouid."'  and status = 1 and addtime >= '".$dead_time."' ")->count()) {
            echo \think\Lang::get('fbjy_ddhycz');
            exit;
        }



        $this->userData = db('customer')->field('id,key')->where("id = '".$customerid."'")->find();

        if (!$this->userData) {
            echo \think\Lang::get('fbjy_shbcz');
            exit;
        }


        $this->params = array('version' => $version, 'customerid' => $customerid, 'sdorderno' => $sdorderno, 'total_fee' => number_format($total_fee, 2, '.', ''), 'paytype' => $paytype,  'notifyurl' => $notifyurl, 'returnurl' => $returnurl, 'sign' => $sign,'pankouid'=>$pankouid,'currency'=>$currency,'huilv'=>$huilv,'old_amount'=>$old_amount,'shordr_sn'=>$shordr_sn);


    }

    public function index()
    {
        extract($this->params);
        $signStr = 'version=' . $version . '&customerid=' . $customerid . '&total_fee=' . $total_fee . '&sdorderno=' . $sdorderno . '&notifyurl=' . $notifyurl . '&returnurl=' . $returnurl .'&currency=' . $currency .  '&' . $this->userData['key'];


        $mysign = md5($signStr);

        if ($sign != $mysign) {
            echo "Sign".\think\Lang::get('fbjy_yzsb');
            exit;
        }

        if(in_array($currency,array('CNY','JPY','USD','TRY','KRW'))){
            cookie('think_var', strtolower($currency));
        }else{
            cookie('think_var', 'usd');
        }


        //匹配订单
        $where['trade_type'] =  1 ;
        $where['symbol'] = 'AGC';
        $where['status'] = 0;
        $where['pay_id'] = 3;//$payment;
        $where['isnotdone_num'] = ['egt',$total_fee];
        $where['currency_type'] = $currency;
        $where['user_type'] = 0;


        //选出可匹配的用户
        $user_where['customer_id'] = ['LIKE','%'.$pankouid.'%'];
        $userids = Db::name('userinfo')->where($user_where)->field('uid')->select();

        if($userids && count($userids)>0){
            foreach ($userids as $k=>$v){
                $userids_arr[] = $v['uid'];
            }
            $where['user_id'] = ['IN',$userids_arr];
        }
        else{

            $suijiuserids = Db::name('userinfo')->where('customer_id','')->field('uid')->select();
            if($suijiuserids && count($suijiuserids)>0){
                foreach ($suijiuserids as $k=>$v){
                    $suijiuserids_arr[] = $v['uid'];
                }
                $where['user_id'] = ['IN',$suijiuserids_arr];
            }

        }

        //未完成的不匹配
        $wheres['status'] = ['IN',array(0,1,3)];
        $wheres['trade_type'] = 0;
        $whereno = array();
        /*$oids = Db::name('currency_trade_order')->where($wheres)->field('oid')->select();
        if($oids && count($oids)>0){
            foreach ($oids as $k=>$v){
                $oids_arrs[] = $v['oid'];
            }
            $oidss = array_unique($oids_arrs);
            $where_o['id'] = ['IN',$oidss];
            $nouser = Db::name('currency_shevles_order')->where($where_o)->field('user_id')->select();
            if($nouser && count($nouser)>0){
                foreach ($nouser as $k=>$v){
                    $nouser_arr[] = $v['user_id'];
                }
                $nouser_arr = array_unique($nouser_arr);
                $whereno['user_id'] = ['NOT IN',$nouser_arr];
            }
        }*/

        if(!empty($whereno)){
            $has_matchs = Db::name('currency_shevles_order')->where($where)->where($whereno)->select();

        }else{
            $has_matchs = Db::name('currency_shevles_order')->where($where)->select();
        }


        if(count($has_matchs)>0){
            $rand_num = mt_rand(1,count($has_matchs));
            $has_match = $has_matchs[$rand_num-1];
            $order_sn = 'CT'.$pankouid.time().mt_rand(1000,9999);
            $trade_order = array(
                'user_id'=>$pankouid,
                'order_sn'=>$order_sn,
                'currency_type'=>$currency,
                'api_order_sn'=>$sdorderno,
                'sdorder_sn' => $shordr_sn,
                'customerid'=>$customerid,
                'symbol'=>'AGC',
                't_amount'=>$old_amount,
                't_num'=>$total_fee,
                'c_exc_rate'=>$huilv,
                's_price'=>1,
                'addtime'=>time(),
                'status'=>0,
                'trade_type'=>0,
                'pay_id'=>3,
                'payment_method'=>$has_match['payment_method'],
                'oid'=>$has_match['id'],
                'endtime'=>time() + 60*15,
                'update_time'=>time(),
                'returnurl'=>$returnurl,
                'notifyurl'=>$notifyurl,
                'ip'=> get_client_ip(),
            );
            $res = Db::name('currency_trade_order')->insertGetId($trade_order);
            if($res){
                $new_num = $has_match['isnotdone_num'] - $total_fee;
                $update = array(
                    'status'=>$new_num>0?0:1,
                    'isnotdone_num'=>$new_num
                );
                Db::name('currency_shevles_order')->where('id',$has_match['id'])->update($update);
                //通知用户
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
                $this->redirect('Talkerorder/order?oid='.$res);
            }else{
                echo \think\Lang::get('fbjy_ddscsb');
                exit;
            }
        }else{
            echo \think\Lang::get('fbjy_ddscsb');
            exit;
        }
    }






}
