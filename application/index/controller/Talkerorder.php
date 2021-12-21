<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Cookie;

class Talkerorder extends Controller
{



    public function order()
    {
        $oid =  input('oid');
        if(!$oid){
            echo \think\Lang::get('fbjy_ffz');
            exit;
        }

        $trade_order = Db::name('currency_trade_order')->where(['id'=>$oid,'customerid'=>10891])->find();
        if(!$trade_order){
            echo "no order";
            exit;
        }
       
        $order_info = $trade_order;
        if($order_info['oid']){
            $seller_order = Db::name('currency_shevles_order')->where('id',$order_info['oid'])->find();
        }

        $seller_info = Db::name('user_payment_method')->where('id',$seller_order['payment_method'])->find();

        $currency = Db::name('currency')->where('name',$order_info['currency_type'])->find();

        $has_time = $order_info['endtime'] - time();
        $has_time = $has_time>0?$has_time:0;

        if($order_info['status']!=0){
            $has_time =0;
        }


        $all_amount = sprintf('%.2f',$order_info['t_amount']);
        $one_amount = floatval($order_info['c_exc_rate']*$order_info['s_price']) ;
        $payment = db('payment_method')->where('id',$order_info['pay_id'])->find();
        $payment = change_payment_name($payment);

        $lang = array(
            array('usd'=>'WeChat','cny'=>'WeChat','jpy'=>'WeChat','krw'=>'작은 편지','try'=>'WeChat','USD'=>'WeChat','CNY'=>'WeChat','JPY'=>'WeChat','KRW'=>'작은 편지','TRY'=>'WeChat',),
            array('usd'=>'Alipay','cny'=>'Alipay','jpy'=>'アリペイを支払う','krw'=>'알 리 페 이','try'=>'Alipay','USD'=>'Alipay','CNY'=>'Alipay','JPY'=>'アリペイを支払う','KRW'=>'알 리 페 이','TRY'=>'Alipay'),
            array('usd'=>'bank card','cny'=>'bank card','jpy'=>'銀行カード','krw'=>'은행 카드','try'=>'banka kartı','USD'=>'bank card','CNY'=>'bank card','JPY'=>'銀行カード','KRW'=>'은행 카드','TRY'=>'banka kartı'),
        );
        $yy = cookie('think_var');
        if(empty($yy)){
            $yy = 'usd';
        }
        $payment['name'] = $lang[$payment['id']-1][$yy];

        $this->assign('one_amount',$one_amount);
        $this->assign('all_amount',$all_amount);
        $this->assign('payment',$payment);
        $this->assign('has_time',$has_time);
        $this->assign('currency',$currency);
        $this->assign('order',$order_info);
        $this->assign('my_order',$seller_order);
        $this->assign('info',$seller_info);
        $this->assign('id',$oid);

        return $this->fetch();
    }






}
