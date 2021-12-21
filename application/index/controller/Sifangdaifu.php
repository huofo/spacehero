<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Cookie;

class Sifangdaifu extends Controller
{



    public function __construct(){
        parent::__construct();
        $version = '1.0';
        $customerid = input('post.customerid');
        $sdorderno =  input('post.sdorderno');
        $total_fee =  input('post.total_fee');
        $notifyurl =  input('post.notifyurl');
        $currency =  input('post.currency');
        $huilv =  input('post.huilv');
        $pankouid =  input('post.pankouid');
        $old_amount =  input('post.old_amount');
        $account_name = input('post.account_name');
        $account_number = input('post.account_number');
        $bank_name = input('post.bank_name');
        $bank_branch = input('post.bank_branch');
        $remark = input('post.remark');
        $sign =  input('post.sign');
        $shordr_sn = input('post.shordr_sn');


        if(in_array($currency,array('CNY','JPY','USD','TRY','KRW'))){
            cookie('think_var', strtolower($currency));
        }else{
            cookie('think_var', 'usd');
        }

        if(in_array($currency,array('CNY','JPY','USD','TRY','KRW'))){
            cookie('think_var', strtolower($currency));
        }else{
            cookie('think_var', 'usd');
        }



        if (!isset($_REQUEST) || !$_REQUEST) {
            $res = array(
                "statusCode"=>"0",
                "message"=>'非法空值'
            );
            echo json_encode($res); exit;
        }

        if ($version == '' || $customerid == '' || $sdorderno == '' || $total_fee == '' || $notifyurl == '' || $currency == '' || $huilv == ''|| $pankouid == '' || $old_amount == '' || $account_name == '' || $account_number == '' || $bank_name == '' ||$sign=='') {

            $res = array(
                "statusCode"=>"0",
                "message"=>'参数不完整'
            );
            echo json_encode($res); exit;
        }



        if (db('currency_trade_order')->field('id')->where("api_order_sn = '".$sdorderno."' and customerid = '".$customerid."' and user_id = '".$pankouid."' ")->find()) {

            $res = array(
                "statusCode"=>"0",
                "message"=>'订单号已存在'
            );
            echo json_encode($res); exit;

        }

        $this->userData = db('customer')->field('id,key')->where("id = '".$customerid."'")->find();

        if (!$this->userData) {

            $res = array(
                "statusCode"=>"0",
                "message"=>'商户不存在'
            );
            echo json_encode($res); exit;
        }


        $this->params = array('version' => $version, 'customerid' => $customerid, 'sdorderno' => $sdorderno, 'total_fee' => number_format($total_fee, 2, '.', ''), 'notifyurl' => $notifyurl,  'currency' => $currency, 'huilv' => $huilv, 'pankouid' => $pankouid,'old_amount'=>$old_amount,'account_name'=>$account_name,'account_number'=>$account_number,'bank_name'=>$bank_name,'bank_branch'=>$bank_branch,'remark'=>$remark,'sign'=>$sign,'shordr_sn'=>$shordr_sn);


    }

    /**
     * 首页 行情列表
     * @author lukui  2017-02-18
     * @return [type] [description]
     */
    public function index()
    {


        extract($this->params);


        $signStr = 'version='.$version.'&customerid='.$customerid.'&sdorderno='.$sdorderno.'&total_fee='.$total_fee.'&notifyurl='.$notifyurl.'&currency='.$currency.'&huilv='.$huilv.'&pankouid='.$pankouid.'&old_amount='.$old_amount.'&account_name='.$account_name.'&account_number='.$account_number.'&bank_name='.$bank_name.'&bank_branch='.$bank_branch.'&remark='.$remark.'&'.$this->userData['key'];


        $mysign = md5($signStr);
        //$this->textlog(999,$mysign );


        if ($sign != $mysign) {


            $res = array(
                "statusCode"=>"0",
                "message"=>"Sign验证失败"
            );
            echo json_encode($res); exit;
        }


        //匹配订单
        $where['trade_type'] =  0 ;
        $where['symbol'] = 'AGC';
        $where['status'] = 0;
        $where['pay_id'] = 3;//$payment;
        $where['isnotdone_num'] = ['egt',$total_fee];
        $where['currency_type'] = $currency;
        $where['user_type'] = 0;


        //选出可匹配的用户
        $user_where['customer_daifu'] = ['LIKE','%'.$pankouid.'%'];
        $userids = Db::name('userinfo')->where($user_where)->field('uid')->select();

        if($userids && count($userids)>0){
            foreach ($userids as $k=>$v){
                $userids_arr[] = $v['uid'];
            }
            $where['user_id'] = ['IN',$userids_arr];
        }
        else{
            $suijiuserids = Db::name('userinfo')->where('customer_daifu','')->field('uid')->select();
            if($suijiuserids && count($suijiuserids)>0){
                foreach ($suijiuserids as $k=>$v){
                    $suijiuserids_arr[] = $v['uid'];
                }
                $where['user_id'] = ['IN',$suijiuserids_arr];
            }
        }






        $has_matchs = Db::name('currency_shevles_order')->where($where)->select();


        if(count($has_matchs)>0) {
            $rand_num = mt_rand(1, count($has_matchs));

            $has_match = $has_matchs[$rand_num-1];
        }else{
            $res = array(
                "statusCode"=>"0",
                "message"=>'暂无卡商'
            );
            echo json_encode($res); exit;
        }

        $inserpayment_id = db('user_payment_method')->insertGetId([
            'user_id'=>$pankouid,
            'type'=>3,
            'currency_type'=>$currency,
            'account_num'=>$account_number,
            'account_name'=>$account_name,
            'bank_name'=>$bank_name,
            'bank_num'=>$account_number,
            'status'=>1,
            'bank_branch'=>$bank_branch,
            'note'=>$remark,
            'addtime'=>time()
        ]);

        if(!$inserpayment_id){
            $res = array(
                "statusCode"=>"0",
                "message"=>'订单生成失败'
            );
            echo json_encode($res); exit;
        }

        if($has_match && $inserpayment_id){
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

                'trade_type'=>1,
                'pay_id'=>3,
                'payment_method'=>$inserpayment_id,
                'oid'=>$has_match['id'],
                'endtime'=>time() + 120*60,
                'update_time'=>time(),
                'returnurl'=>'',
                'notifyurl'=>$notifyurl
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


                $res = array(
                    "statusCode"=>"1",
                    "message"=>'提交成功'
                );
                echo json_encode($res); exit;

            }else{
                $res = array(
                    "statusCode"=>"0",
                    "message"=>'暂无卡商2'
                );
                echo json_encode($res); exit;

            }

        }else{
            $res = array(
                "statusCode"=>"0",
                "message"=>'暂无卡商1'
            );
            echo json_encode($res); exit;
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



}
