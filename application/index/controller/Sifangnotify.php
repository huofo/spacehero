<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Cookie;

class Sifangnotify extends Controller
{


  



    public function index()
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

        $this->textlog(1112,$_POST);
        if($sign==$mysign)
        {

            $this->textlog(111,$_POST);


            $order_info =  Db::name('currency_trade_order')->where('api_order_sn',$orderid)->find();

            if($status=='205')
            {
                $this->textlog(111,$order_info);
                //下游确认收款
                if($order_info['status'] == 1)
                {
                    $this->textlog(123456,$order_info);
                    //给用户上币，修改订单状态
                    Db::name('currency_trade_order')->where(['id'=>$order_info['id']])->update(['status'=>2,'update_time'=>time()]);
                    $shevles_order =  Db::name('currency_shevles_order')->where(['id'=>$order_info['oid']])->field('id,user_id,isnotdone_num')->find();
                    //为买家增加 币的余额
                    log_account_change($shevles_order['user_id'],3,$order_info['symbol'],$order_info['t_num'],0,\think\Lang::get('fbjy_tgfbjyhd'),0);

                    //卡商获取固定AGC奖励
                    $user_type = Db('userinfo')->where('uid',$shevles_order['user_id'])->value('user_type');
                    if($user_type == 0){
                        $ka_daifu_fee = getconf('ka_daifu_fee');
                        log_account_change($shevles_order['user_id'],3,$order_info['symbol'],floatval($ka_daifu_fee),0,\think\Lang::get('fbjy_ka_daifu_fee'),0);
                    }

                    echo 'success';
                }
            }
            else
            {
                //下游拒绝收款，修改订单状态
                $this->textlog(654321,$order_info);
                $res = Db::name('currency_trade_order')->where(['id'=>$order_info['id']])->update(['status'=>6,'update_time'=>time()]);
                if($res){
                    $shevles_order =  Db::name('currency_shevles_order')->where(['id'=>$order_info['oid']])->field('id,user_id,isnotdone_num')->find();
                    if($shevles_order){
                        $back =  Db::name('currency_shevles_order')->where(['id'=>$shevles_order['id']])->update(
                            [
                                'isnotdone_num'=>$shevles_order['isnotdone_num']+$order_info['t_num'],
                                'status'=>0
                            ]
                        );
                    }
                }
                echo 'fail';
            }
        }
        else
        {
            echo 'signerr';
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
