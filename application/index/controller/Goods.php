<?php
namespace app\index\controller;
use think\Db;

class Goods extends Base
{
    /**
     * 产品详情页
     * @author lukui  2017-02-20
     * @return [type] [description]
     */
    //秒合约K线页面
    public function goods()
    {

         $pid = input('param.pid');
        if(!$pid){
            $morenpro = db('productinfo')->where('isdelete',0)->order('proorder asc')->limit(1)->find();
            if(!$morenpro){
                $this->redirect('index/index');
            }else{
                $pid = $morenpro['pid'];
            }
        }

        //$this->redirect('goods/goods_bibi?pid='.$pid);


        //获取产品实时行情
        $pro = GetProData($pid,'pi.ptitle,pi.procode,pi.protime,pi.propoint,pi.proscale,pi.numprice,pi.code,pd.*');
        if(!$pro){
            $this->redirect('index/index');
        }
        $pro['chajia'] = round($pro['Price']-$pro['Open'],2);
        $pro['zhangfu'] = round($pro['chajia']/$pro['Price']*100,2);

        //时间间隔
        $protime = $pro['protime'];
        if($protime){
            $protime = explode(',',$protime);
        }
        //点位间隔
        $propoint = $pro['propoint'];
        if($propoint){
            $propoint = explode(',',$propoint);
        }
        //盈亏比例
        $proscale = $pro['proscale'];
        if($proscale){
            $proscale = explode(',',$proscale);
        }

        $uid = $this->uid;
        $user = Db::name('userinfo')->where('uid',$uid)->find();

        $level_shouyi = getconf($user['level']);



        if(count($level_shouyi)==1)
        {
            $level_shouyi = explode('|',$level_shouyi);


            if(!empty($level_shouyi))
            {
                $proscale = $level_shouyi;
            }

        }

        //投资金额
        $pay_choose = getconf('pay_choose');
        $pay_choose_arr = explode('|',$pay_choose);

        //是否休市
        $isopen = ChickIsOpen($pid);


        $shouxufei = getconf('web_poundage');

        $shouxufei = explode('|',$shouxufei);

        $gratuity = getconf('web_gratuity');
        $gratuity = explode('|',$gratuity);

        $uid = $this->uid;;
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

        if($user_info['level']=='level_zero')
        {
            $web_gratuity =$gratuity[0];
        }elseif($user_info['level']=='level_one')
        {
            $web_gratuity =$gratuity[1];
        }elseif($user_info['level']=='level_two')
        {
            $web_gratuity =$gratuity[2];
        }
        elseif($user_info['level']=='level_three')
        {
            $web_gratuity =$gratuity[3];
        }
        elseif($user_info['level']=='level_four')
        {
            $web_gratuity =$gratuity[4];
        }

        $prolist = Db::name('productinfo')->field('pid,ptitle')->where('isdelete',0)->order('proorder asc , pid desc')->select();

        $this->assign('web_gratuity',$web_gratuity);
        $this->assign('web_poundage',$web_poundage);
        $this->assign('pro',$pro);
        $this->assign('protime',$protime);

        $this->assign('jinjie',$user_info['jinjie']);

        $this->assign('jiying',$user_info['jiying']);

        $this->assign('propoint',$propoint);
        $this->assign('proscale',$proscale);
        $this->assign('pay_choose_arr',$pay_choose_arr);
        $this->assign('prolist',$prolist);
        $this->assign('isopen',$isopen);

        return $this->fetch();
    }
    //原合约K线页面
    public function goods_heyue()
    {
        $pid = input('param.pid');
        if(!$pid){
            $this->redirect('index/index');
        }
        //获取产品实时行情
        $pro = GetProData($pid,'pi.ptitle,pi.procode,pi.protime,pi.propoint,pi.proscale,pi.numprice,pi.code,pd.*');
        if(!$pro){
            $this->redirect('index/index');
        }
        $pro['chajia'] = round($pro['Price']-$pro['Open'],2);
        $pro['zhangfu'] = round($pro['chajia']/$pro['Price']*100,2);

        //时间间隔
        $protime = $pro['protime'];
        if($protime){
            $protime = explode(',',$protime);
        }
        //点位间隔
        $propoint = $pro['propoint'];
        if($propoint){
            $propoint = explode(',',$propoint);
        }
        //盈亏比例
        $proscale = $pro['proscale'];
        if($proscale){
            $proscale = explode(',',$proscale);
        }

        $uid = $this->uid;
        $user = Db::name('userinfo')->where('uid',$uid)->find();

        $level_shouyi = getconf($user['level']);



        if(count($level_shouyi)==1)
        {
            $level_shouyi = explode('|',$level_shouyi);


            if(!empty($level_shouyi))
            {
                $proscale = $level_shouyi;
            }

        }

        //投资金额
        $pay_choose = getconf('pay_choose');
        $pay_choose_arr = explode('|',$pay_choose);

        //是否休市
        $isopen = ChickIsOpen($pid);


        $shouxufei = getconf('web_poundage');

        $shouxufei = explode('|',$shouxufei);

        $gratuity = getconf('web_gratuity');
        $gratuity = explode('|',$gratuity);

        $uid = $this->uid;;
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

        if($user_info['level']=='level_zero')
        {
            $web_gratuity =$gratuity[0];
        }elseif($user_info['level']=='level_one')
        {
            $web_gratuity =$gratuity[1];
        }elseif($user_info['level']=='level_two')
        {
            $web_gratuity =$gratuity[2];
        }
        elseif($user_info['level']=='level_three')
        {
            $web_gratuity =$gratuity[3];
        }
        elseif($user_info['level']=='level_four')
        {
            $web_gratuity =$gratuity[4];
        }

        $prolist = Db::name('productinfo')->field('pid,ptitle')->where('isdelete',0)->order('proorder asc , pid desc')->select();
        //dump($pay_choose);exit;
        $this->assign('web_gratuity',$web_gratuity);
        $this->assign('web_poundage',$web_poundage);
        $this->assign('pro',$pro);
        $this->assign('protime',$protime);

        $this->assign('jinjie',$user_info['jinjie']);

        $this->assign('jiying',$user_info['jiying']);
        $this->assign('goods_id',$pid);


        $this->assign('propoint',$propoint);
        $this->assign('proscale',$proscale);
        $this->assign('pay_choose_arr',$pay_choose_arr);
        $this->assign('prolist',$prolist);
        $this->assign('isopen',$isopen);

        return $this->fetch();
    }

    //原合约下单页面
    public function heyuegoods()
    {


        $pid = input('param.pid');
        if(!$pid){
            $this->redirect('index/index');
        }

        $this->redirect('goods/lever',array('pid'=>$pid));

        $uid = $this->uid;
        $user_info = Db::name('userinfo')->where('uid',$uid)->find();



        //获取所有产品信息
        $allpro = Db::name('productinfo')->alias('pi')->field('pi.pid,pi.ptitle,pd.Price,pd.UpdateTime,pd.Low,pd.High')
            ->join('__PRODUCTDATA__ pd','pd.pid=pi.pid')
            ->where('pi.isdelete',0)->order('pi.proorder asc')->select();
        foreach($allpro as $key=>$value){
            $allpro[$key]['isopen'] = ChickIsOpen($value['pid']);
        }
        $this->assign('allpro',$allpro);



        //获取产品实时行情
        $pro = GetProData($pid,'pi.decimal,pi.ptitle,pi.procode,pi.protime,pi.propoint,pi.proscale,pi.numprice,pi.code,pd.*');
        if(!$pro){
            $this->redirect('index/index');
        }
        //涨跌幅
        $pro['chajia'] = round($pro['Price']-$pro['Open'],2);
        $pro['zhangfu'] = round($pro['chajia']/$pro['Price']*100,2);

        //产品价格
        $this->assign('goodsprice',$pro['Price']);
        $this->assign('goodsrmbprice',$pro['Price']*6.425);

        //杠杠
        $code = explode(',',$pro['code']);
        $this->assign('code',$code);



        //默认产品数量
        $pronum = 100*$pro['numprice'];
        $proprice = 100*$pro['numprice']*$pro['Price'];
        $this->assign('pronum',$pronum);
        $this->assign('proprice',$proprice);
        $title = explode('/',$pro['ptitle']);
        $this->assign('procode',strtoupper($title[0]));

        //手续费
        $shouxufei = getconf('web_gratuity');
        $shouxufei = explode('|',$shouxufei);

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


        $fee =  (100*$pro['numprice']*$pro['Price'] )/$code[0];
        $sx_fee = (100*$pro['numprice']*$pro['Price']*$web_poundage )/100;

        $this->assign('bzj',round($sx_fee+$fee,2));




        //点差
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

        $this->assign('spread_die',$spread_die);
        $this->assign('spread_zhang',$spread_zhang);


        $this->assign('userinfo',$user_info);

        $this->assign('pro',$pro);


        return $this->fetch();
    }

    //新合约K线页面
    public function goods_lever()
    {
        $pid = input('param.pid');
        if(!$pid){
            $this->redirect('index/index');
        }
        //获取产品实时行情
        $pro = GetProData($pid,'pi.ptitle,pi.procode,pi.protime,pi.propoint,pi.proscale,pi.numprice,pi.code,pd.*');
        if(!$pro){
            $this->redirect('index/index');
        }
        $pro['chajia'] = round($pro['Price']-$pro['Open'],2);
        $pro['zhangfu'] = round($pro['chajia']/$pro['Price']*100,2);

        //时间间隔
        $protime = $pro['protime'];
        if($protime){
            $protime = explode(',',$protime);
        }
        //点位间隔
        $propoint = $pro['propoint'];
        if($propoint){
            $propoint = explode(',',$propoint);
        }
        //盈亏比例
        $proscale = $pro['proscale'];
        if($proscale){
            $proscale = explode(',',$proscale);
        }

        $uid = $this->uid;
        $user = Db::name('userinfo')->where('uid',$uid)->find();

        $level_shouyi = getconf($user['level']);



        if(count($level_shouyi)==1)
        {
            $level_shouyi = explode('|',$level_shouyi);


            if(!empty($level_shouyi))
            {
                $proscale = $level_shouyi;
            }

        }

        //投资金额
        $pay_choose = getconf('pay_choose');
        $pay_choose_arr = explode('|',$pay_choose);

        //是否休市
        $isopen = ChickIsOpen($pid);


        $shouxufei = getconf('web_poundage');

        $shouxufei = explode('|',$shouxufei);

        $gratuity = getconf('web_gratuity');
        $gratuity = explode('|',$gratuity);

        $uid = $this->uid;;
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

        if($user_info['level']=='level_zero')
        {
            $web_gratuity =$gratuity[0];
        }elseif($user_info['level']=='level_one')
        {
            $web_gratuity =$gratuity[1];
        }elseif($user_info['level']=='level_two')
        {
            $web_gratuity =$gratuity[2];
        }
        elseif($user_info['level']=='level_three')
        {
            $web_gratuity =$gratuity[3];
        }
        elseif($user_info['level']=='level_four')
        {
            $web_gratuity =$gratuity[4];
        }

        $prolist = Db::name('productinfo')->field('pid,ptitle')->where('isdelete',0)->order('proorder asc , pid desc')->select();
        //dump($pay_choose);exit;
        $this->assign('web_gratuity',$web_gratuity);
        $this->assign('web_poundage',$web_poundage);
        $this->assign('pro',$pro);
        $this->assign('protime',$protime);

        $this->assign('jinjie',$user_info['jinjie']);

        $this->assign('jiying',$user_info['jiying']);
        $this->assign('goods_id',$pid);


        $this->assign('propoint',$propoint);
        $this->assign('proscale',$proscale);
        $this->assign('pay_choose_arr',$pay_choose_arr);
        $this->assign('prolist',$prolist);
        $this->assign('isopen',$isopen);

        return $this->fetch();
    }

    //币币K线页面
    public function goods_bibi()
    {
        $pid = input('param.pid');
        if(!$pid){
            $this->redirect('index/index');
        }
        //获取产品实时行情
        $pro = GetProData($pid,'pi.ptitle,pi.procode,pi.protime,pi.propoint,pi.proscale,pi.numprice,pi.code,pd.*');
        if(!$pro){
            $this->redirect('index/index');
        }
        $pro['chajia'] = round($pro['Price']-$pro['Open'],2);
        $pro['zhangfu'] = round($pro['chajia']/$pro['Price']*100,2);

        //时间间隔
        $protime = $pro['protime'];
        if($protime){
            $protime = explode(',',$protime);
        }
        //点位间隔
        $propoint = $pro['propoint'];
        if($propoint){
            $propoint = explode(',',$propoint);
        }
        //盈亏比例
        $proscale = $pro['proscale'];
        if($proscale){
            $proscale = explode(',',$proscale);
        }

        $uid = $this->uid;
        $user = Db::name('userinfo')->where('uid',$uid)->find();

        $level_shouyi = getconf($user['level']);



        if(count($level_shouyi)==1)
        {
            $level_shouyi = explode('|',$level_shouyi);


            if(!empty($level_shouyi))
            {
                $proscale = $level_shouyi;
            }

        }

        //投资金额
        $pay_choose = getconf('pay_choose');
        $pay_choose_arr = explode('|',$pay_choose);

        //是否休市
        $isopen = ChickIsOpen($pid);


        $shouxufei = getconf('web_poundage');

        $shouxufei = explode('|',$shouxufei);

        $gratuity = getconf('web_gratuity');
        $gratuity = explode('|',$gratuity);

        $uid = $this->uid;;
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

        if($user_info['level']=='level_zero')
        {
            $web_gratuity =$gratuity[0];
        }elseif($user_info['level']=='level_one')
        {
            $web_gratuity =$gratuity[1];
        }elseif($user_info['level']=='level_two')
        {
            $web_gratuity =$gratuity[2];
        }
        elseif($user_info['level']=='level_three')
        {
            $web_gratuity =$gratuity[3];
        }
        elseif($user_info['level']=='level_four')
        {
            $web_gratuity =$gratuity[4];
        }

        $prolist = Db::name('productinfo')->field('pid,ptitle')->where('isdelete',0)->order('proorder asc , pid desc')->select();
        //dump($pay_choose);exit;
        $this->assign('web_gratuity',$web_gratuity);
        $this->assign('web_poundage',$web_poundage);
        $this->assign('pro',$pro);
        $this->assign('protime',$protime);

        $this->assign('jinjie',$user_info['jinjie']);

        $this->assign('jiying',$user_info['jiying']);
        $this->assign('goods_id',$pid);


        $this->assign('propoint',$propoint);
        $this->assign('proscale',$proscale);
        $this->assign('pay_choose_arr',$pay_choose_arr);
        $this->assign('prolist',$prolist);
        $this->assign('isopen',$isopen);

        return $this->fetch();
    }

    public function heyuegoodsajax()
    {
        $pid = input('param.pid');
        $shendu = $this->shendu($pid);
        //获取产品实时行情
        $pro = GetProData($pid,'pi.decimal,pi.ptitle,pi.procode,pi.protime,pi.propoint,pi.proscale,pi.numprice,pi.code,pd.*');
        if(!$pro){
            exit;
        }

        $old_price = input('param.old_price');

        if($old_price<$pro['Price']){
            $shendu['fx']='up';
        }else{
            $shendu['fx']='down';
        }

        $shendu['price']=$pro['Price'];

        $shendu['zdf']=$pro['DiffRate'];


        $shendu['goodsrmbprice']=$pro['Price']*6.425;
        return base64_encode(json_encode($shendu));
    }

    public function bzj(){
        $pid = input('post.pid');
        $number = input('post.number');
        $code = input('post.code');

        if(!is_numeric($number) || !is_numeric($code)){
            exit;
        }

        $uid = $this->uid;
        $user_info = Db::name('userinfo')->where('uid',$uid)->find();
        $pro = GetProData($pid,'pi.decimal,pi.ptitle,pi.procode,pi.protime,pi.propoint,pi.proscale,pi.numprice,pi.code,pd.*');
        if(!$pro){
            exit;
        }
        //手续费
        $shouxufei = getconf('web_gratuity');
        $shouxufei = explode('|',$shouxufei);

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


        $fee =  ($number*$pro['numprice']*$pro['Price'] )/$code;
        $sx_fee = ($number*$pro['numprice']*$pro['Price']*$web_poundage )/100;
        $bzj = round($sx_fee+$fee,2);


        $pronum = $number*$pro['numprice'];
        $proprice = $number*$pro['numprice']*$pro['Price'];


        $res = array(

            "bzj"=>$bzj,
            "pronum"=>$pronum,
            "proprice"=>$proprice,
        );

        exit(json_encode($res));




    }

    //获取可买可卖数量
    public function kemai(){
        $pid = input('post.pid');//产品id
        $number = input('post.number');//比例
        $price = input('post.jiage');//限价价格
        $place_type = input('post.place_type')?input('post.place_type'):'市价';

        $order_type = input('post.order_type');//比例

        if(!is_numeric($number) ){

            $res = array(
                "kemai"=>0,
            );

            exit(json_encode($res));
        }
        if($number <= 0){
            $res = array(
                "kemai"=>0,
            );

            exit(json_encode($res));
        }

        if($place_type=='限价'){
            if($price<=0|| !is_numeric($price)){
                $res = array(
                    "kemai"=>0,
                );

                exit(json_encode($res));
            }
        }


        $uid = $this->uid;
        $user_info = Db::name('userinfo')->where('uid',$uid)->find();
        $pro = GetProData($pid,'pi.decimal,pi.ptitle,pi.procode,pi.protime,pi.propoint,pi.proscale,pi.numprice,pi.code,pd.*');
        if(!$pro){
            $res = array(
                "kemai"=>0,
            );

            exit(json_encode($res));
        }

        //拆分货币对
        $huobidui = explode('/',$pro['ptitle']);
        $qian_money = get_money($this->uid,1,$huobidui[0]);
        $hou_money = get_money($this->uid,1,$huobidui[1]);

        //手续费
        $shouxufei = getconf('bibi_sxfee');
        $shouxufei = explode('|',$shouxufei);

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

        if($place_type=='市价'){
            $price = $pro['Price'];
        }



        if($order_type==0){
            $kemai = (($hou_money*$number)/100)/($price*(1+$web_poundage/100));
            $kemai = floor($kemai*100)/100;
        }else{
            $kemai =  $qian_money*$number/100;
        }




        $res = array(
            "kemai"=>$kemai,
        );

        exit(json_encode($res));

    }

    //币币交易额
    public function bibijye(){
        $pid = input('post.pid');
        $number = input('post.number');
        $price = input('post.jiage');
        $place_type = input('post.place_type')?input('post.place_type'):'市价';

        if(!is_numeric($number) ){
            $res = array(

                "bzj"=>0,
                "fee"=>0,
                "sx_fee"=>0,
            );

            exit(json_encode($res));
        }
        if($number <= 0){
            $res = array(

                "bzj"=>0,
                "fee"=>0,
                "sx_fee"=>0,
            );

            exit(json_encode($res));
        }

        if($place_type=='限价'){
            if($price<=0|| !is_numeric($price)){
                $res = array(

                    "bzj"=>0,
                    "fee"=>0,
                    "sx_fee"=>0,
                );

                exit(json_encode($res));
            }
        }


        $uid = $this->uid;
        $user_info = Db::name('userinfo')->where('uid',$uid)->find();
        $pro = GetProData($pid,'pi.decimal,pi.ptitle,pi.procode,pi.protime,pi.propoint,pi.proscale,pi.numprice,pi.code,pd.*');
        if(!$pro){
            $res = array(

                "bzj"=>0,
                "fee"=>0,
                "sx_fee"=>0,
            );

            exit(json_encode($res));
        }
        //手续费
        $shouxufei = getconf('bibi_sxfee');
        $shouxufei = explode('|',$shouxufei);

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

        if($place_type=='市价'){
            $price = $pro['Price'];
        }



        $fee =  $number*$price;
        $sx_fee = ($fee*$web_poundage )/100;
        $bzj = round($sx_fee+$fee,2);

        $pronum = $number*$pro['numprice'];
        $proprice = $number*$pro['numprice']*$pro['Price'];

        $res = array(

            "bzj"=>floatval($bzj),
            "fee"=>floatval($fee),
            "sx_fee"=>floatval($sx_fee),
        );
        exit(json_encode($res));

    }

    //币币页面
    public function bibi()
    {

        $pid = input('param.pid');
        if(!$pid){
            $morenpro = db('productinfo')->where('isdelete',0)->order('proorder asc')->limit(1)->find();
            if(!$morenpro){
                $this->redirect('index/index');
            }else{
                $pid = $morenpro['pid'];
            }
        }
        //买入或卖出
        $order_type= input('param.order_type');
        $this->assign('order_type',$order_type==''?0:$order_type);

        //获取产品实时行情
        $pro = GetProData($pid,'pi.decimal,pi.ptitle,pi.procode,pi.protime,pi.propoint,pi.proscale,pi.numprice,pi.code,pd.*');
        if(!$pro){
            $this->redirect('index/index');
        }
        $pro['chajia'] = round($pro['Price']-$pro['Open'],2);
        $pro['zhangfu'] = round($pro['chajia']/$pro['Price']*100,2);

        //拆分货币对
        $huobidui = explode('/',$pro['ptitle']);
        $this->assign('huobidui',$huobidui);

        $qian_money = get_money($this->uid,1,$huobidui[0]);
        $hou_money = get_money($this->uid,1,$huobidui[1]);
        $this->assign('qian_money',floatval($qian_money));
        $this->assign('hou_money',floatval($hou_money));

        //深度
        $shendu = $this->shendu($pid);

        $this->assign('jiashendu',$shendu['jia']);
        $this->assign('jianshendu',$shendu['jian']);


        //获取所有产品信息
        $allpro = Db::name('productinfo')->alias('pi')->field('pi.pid,pi.ptitle,pd.Price,pd.UpdateTime,pd.Low,pd.High')
            ->join('__PRODUCTDATA__ pd','pd.pid=pi.pid')
            ->where('pi.isdelete',0)->order('pi.proorder asc')->select();

        foreach($allpro as $key=>$value){
            $allpro[$key]['isopen'] = ChickIsOpen($value['pid']);
        }
        $this->assign('allpro',$allpro);

        $this->assign('goodsprice',$pro['Price']);


        //持仓列表
        $uid = $this->uid;
        
        
        $ostyle =input('param.ostyle');
        if($ostyle!=''){
            if($ostyle==0){
                $sl = \think\Lang::get('bi_mc');
            }
            else{
                $sl = \think\Lang::get('bi_mc2');
            }
             $hold = Db::name('order')->where(array('uid'=>$uid,'is_timing'=>2,'pid'=>$pid,'ostyle'=>$ostyle))->order('oid desc')->select();
        }else{
            $sl = \think\Lang::get('ti_qb'); //全部
            $hold = Db::name('order')->where(array('uid'=>$uid,'is_timing'=>2,'pid'=>$pid))->order('oid desc')->select();
        }
 $this->assign('sl',$sl);
       
        foreach ($hold as $key=>$val){
            $hold[$key]['buytime']=date("Y-m-d H:i:s",$val['buytime']);
            $hold[$key]['fangxiang']=$val['ostyle']?\think\Lang::get('bi_mc2'):\think\Lang::get('bi_mc');//买入、卖出

            $ptitle = Db::name('productinfo')->field('ptitle')->where('pid='.$val['pid'])->find();
            if($val['pid']==60){
                $hold[$key]['buyprice']=sprintf("%.8f",$val['buyprice']);
            }
            if($val['ostaus']==0){
                $hold[$key]['zt']=\think\Lang::get('ll_jyz');//交易中
            }
            if($val['ostaus']==1){
                $hold[$key]['zt']=\think\Lang::get('sl_ywc');//已完成
            }
            if($val['ostaus']==2){
                $hold[$key]['zt']=\think\Lang::get('ll_wtz');//委托中
            }
            if($val['ostaus']==3){
                $hold[$key]['zt']=\think\Lang::get('ll_ycd');//已撤单
            }

            $hold[$key]['nyr']=date("Y-m-d",$val['buytime']);
            $hold[$key]['sfm']=date("H:i:s",$val['buytime']);



            $hold[$key]['name']=$ptitle['ptitle'];
        }

        $this->assign('hold',$hold);

        //是否休市
        $isopen = ChickIsOpen($pid);



        $gratuity = getconf('bibi_sxfee');
        $gratuity = explode('|',$gratuity);
        $user_info = Db::name('userinfo')->where('uid',$uid)->find();
        $this->assign('user_info',$user_info);


        if($user_info['level']=='level_zero')
        {
            $web_gratuity =$gratuity[0];
        }elseif($user_info['level']=='level_one')
        {
            $web_gratuity =$gratuity[1];
        }elseif($user_info['level']=='level_two')
        {
            $web_gratuity =$gratuity[2];
        }
        elseif($user_info['level']=='level_three')
        {
            $web_gratuity =$gratuity[3];
        }
        elseif($user_info['level']=='level_four')
        {
            $web_gratuity =$gratuity[4];
        }

        $this->assign('web_gratuity',$web_gratuity/100);
        $this->assign('pro',$pro);
        $this->assign('isopen',$isopen);
        return $this->fetch();
    }
    
    //撤销币币委托订单
    public function free_orderbibi(){
		$id = input('post.id');
        $file = request()->file();
        if($file){
            exit(json_encode(array('error'=>\think\Lang::get('od_cwpzx'))));
        }
		$user_id = $_SESSION['uid'];
		$order = db('order')->where("oid=".$id)->find();
	
		if($order['ostaus'] != 2){
			exit(json_encode(array('error'=>\think\Lang::get('od_gddycghcx'))));
		}
		
		if($user_id>0 && $order['uid'] == $user_id&&$order['is_timing'] ==2){
		    if($order['ostyle']==0){
		        $d_map['selltime'] = time();
				$d_map['ostaus'] = 3;
				$d_map['oid'] = $order['oid'];
				$ok = db('order')->update($d_map);
				$huobidui = explode('/',$order['ptitle']);
				if($ok){
				    $money = $order['fee']+$order['sx_fee'];
				    
				    log_account_change($order['uid'],1,$huobidui[1], 0,-1*$money,$remark=\think\Lang::get('od_bbwtmr').$huobidui[0].\think\Lang::get('ll_cd'),0);
					
					log_account_change($order['uid'],1,$huobidui[1], $money,0,$remark=\think\Lang::get('od_bbwtmr').$huobidui[0].\think\Lang::get('ll_cd'),0);
				}
		        
		    }else{
		        $d_map['selltime'] = time();
				$d_map['ostaus'] = 3;
				$d_map['oid'] = $order['oid'];
				$ok = db('order')->update($d_map);
				$huobidui = explode('/',$order['ptitle']);
				if($ok){
				    
				    
				    log_account_change($order['uid'],1,$huobidui[0], 0,-1*$order['onumber'],$remark=\think\Lang::get('od_bbjywtmc').$huobidui[0].\think\Lang::get('ll_cd'),0);
					
					log_account_change($order['uid'],1,$huobidui[0], $order['onumber'],0,$remark=\think\Lang::get('od_bbjywtmc').$huobidui[0].\think\Lang::get('ll_cd'),0);
				}
		    }
			
			exit(json_encode(array('success'=>\think\Lang::get('le_pccg'))));
		}else{
			exit(json_encode(array('error'=>\think\Lang::get('ae_ffcz'))));
		}
	}
	
	
	//撤销合约委托订单
    public function free_orderlever(){
		$id = input('post.id');
        $file = request()->file();
        if($file){
            exit(json_encode(array('error'=>\think\Lang::get('od_cwpzx'))));
        }
		$user_id = $_SESSION['uid'];
		$order = db('order')->where("oid=".$id)->find();
	
		if($order['ostaus'] != 2){
			exit(json_encode(array('error'=>\think\Lang::get('od_gddycghcx'))));
		}
		
		if($user_id>0 && $order['uid'] == $user_id&&$order['is_timing'] ==1){
		   
	        $d_map['selltime'] = time();
			$d_map['ostaus'] = 3;
			$d_map['oid'] = $order['oid'];
			$ok = db('order')->update($d_map);
			$huobidui = explode('/',$order['ptitle']);
			if($ok){
			    $money = $order['fee']+$order['sx_fee'];
			    
			    log_account_change($order['uid'],2,$huobidui[1], 0,-1*$money,$remark=\think\Lang::get('gd_hyjywtcd'),0);
				
				log_account_change($order['uid'],2,$huobidui[1], $money,0,$remark=\think\Lang::get('gd_hyjywtcd'),0);
			}
		        
		   
			
			exit(json_encode(array('success'=>\think\Lang::get('le_pccg'))));
		}else{
			exit(json_encode(array('error'=>\think\Lang::get('ae_ffcz'))));
		}
	}
	
    //合约历史订单列表
    public function leverlist(){
        
        //持仓列表
        
        $order = array(
            '0'=>array(),
            '1'=>array(),
            '2'=>array(),
            '3'=>array(),
        );
        $uid = $this->uid;
        $daojishiid='';
        $hold = Db::name('order')->where(array('uid'=>$uid,'is_timing'=>1))->order('oid desc')->select();
        foreach ($hold as $key=>$val){
            
            $price = db('productdata')->field('Price')->where("pid=".$val['pid'])->find();
            $hold[$key]['nyr']=date("Y-m-d",$val['buytime']);
            $hold[$key]['sfm']=date("H:i:s",$val['buytime']);
            
            $hold[$key]['kctime']=date("Y-m-d H:i:s",$val['buytime']);
            $hold[$key]['fangxiang']=$val['ostyle']?\think\Lang::get('gs_zk'):\think\Lang::get('gs_zd');   //做多、做空

            $code = db('productinfo')->field('code,decimal,numprice,procode,ptitle')->where("pid=".$val['pid'])->find();
            
            $hold[$key]['jye']=$val['chicang']*$val['buyprice'];
           

            $hold[$key]['name']=$code['ptitle'];
            
            
            if($val['ostaus']==0){
                
                $daojishiid = $daojishiid? $daojishiid.','.$val['oid']:$val['oid'];
                $code['code'] = $val['code'];
                
                    //平仓价
                    $enter = floatval($price['Price']);
                    //入仓价
                    $flat = floatval($val['buyprice']);
                    
                  $cha = bcsub($enter,$flat,8);
                    //$cha = $enter - $flat;
                    $point = floatval($cha);
                
    
                $range = $point*$code['code']*$val['chicang'];
           
                 if($val['ostyle']==0)
                {
                    if($range>0){
                        $hold[$key]['ploss'] = '<span style="color:green">+'.$range."</span>";
                    }else{
                        $hold[$key]['ploss'] = '<span style="color:red">'.$range."</span>";
                    }
                }else{
                    if($range>0){
                        $hold[$key]['ploss'] = '<span style="color:red">-'.$range."</span>";
                    }else{
                        $hold[$key]['ploss'] = '<span style="color:green">+'.abs($range)."</span>";
                    }
                }
            }else{
                if($val['ploss']>0){
                    $hold[$key]['ploss'] = '<span style="color:green">+'.$val['ploss']."</span>";
                }else{
                     $hold[$key]['ploss'] = '<span style="color:red">'.$val['ploss']."</span>";
                }
                
                $hold[$key]['pctime']=date("Y-m-d H:i:s",$val['selltime']);
            }
            
            if($val['ostaus']!=1){
                $hold[$key]['sellprice']=$price['Price'];
            }
            


            $order[$val['ostaus']][]=$hold[$key];

        }
	$this->assign('daojishiid',$daojishiid);
        $this->assign('order',$order);
       
        return $this->fetch();
    }
    //合约当前订单列表
    public function orderlist(){
        
        //持仓列表
        $uid = $this->uid;
        $daojishiid='';
        $hold = Db::name('order')->where(array('uid'=>$uid,'ostaus'=>0,'is_timing'=>1))->order('oid desc')->select();
        foreach ($hold as $key=>$val){
            
            
            $daojishiid = $daojishiid? $daojishiid.','.$val['oid']:$val['oid'];
             $price = db('productdata')->field('Price')->where("pid=".$val['pid'])->find();
            $hold[$key]['nyr']=date("Y-m-d",$val['buytime']);
            $hold[$key]['sfm']=date("H:i:s",$val['buytime']);
            
            $hold[$key]['kctime']=date("Y-m-d H:i:s",$val['buytime']);
            $hold[$key]['fangxiang']=$val['ostyle']?\think\Lang::get('gs_zk'):\think\Lang::get('gs_zd');

             $code = db('productinfo')->field('code,decimal,numprice,procode,ptitle')->where("pid=".$val['pid'])->find();

            $hold[$key]['jye']=$val['chicang']*$val['buyprice'];
            $hold[$key]['nowprice']=$price['Price'];

            $hold[$key]['name']=$code['ptitle'];
            
            
           
            $code['code'] = $val['code'];

           
                //平仓价
                $enter = floatval($price['Price']);
                //入仓价
                $flat = floatval($val['buyprice']);
                //求小数精确数值
              

                $cha = bcsub($enter,$flat,8);
                $point = floatval($cha);
            

            $range = $point*$code['code']*$val['chicang'];
       
             if($val['ostyle']==0)
            {
                if($range>0){
                    $hold[$key]['ploss'] = '<span style="color:green">'.$range."</span>";
                }else{
                    $hold[$key]['ploss'] = '<span style="color:red">'.$range."</span>";
                }
            }else{
                if($range>0){
                    $hold[$key]['ploss'] = '<span style="color:red">-'.$range."</span>";
                }else{
                    $hold[$key]['ploss'] = '<span style="color:green">'.abs($range)."</span>";
                }
            }

            
            
        }
	$this->assign('daojishiid',$daojishiid);
        $this->assign('hold',$hold);
        return $this->fetch();
    }
    
    
    public function daojishi(){
		$id = $_POST['daojishiid'];
		$time = time();
		
		$where['oid'] = array('in',rtrim($id,','));	
				
		//$where['selltime'] =['egt',$time];
		$list = db('order')->field('oid,selltime,pid,sellprice,ploss,ostaus,buyprice,system,is_timing,ostyle,endloss,fee,onumber,code,chicang')->where($where)->select();
		
		
	$fp = fopen('list.txt','w+'); fwrite($fp,var_export($list,true)); fclose($fp);
		
		foreach($list as $key => $val){
            $price = db('productdata')->field('Price')->where("pid=".$val['pid'])->find();

		    

                if($val['is_timing']==1){

                  
                    if($val['buyprice']>$price['Price']){
                        $list[$key]['sellprice'] = '<span style="color:#ed0000">'.$price['Price']."</span>";
                    }else{
                        $list[$key]['sellprice'] = '<span style="color:#2fb44e">'.$price['Price']."</span>";
                    }




                    $code = db('productinfo')->field('code,decimal,numprice,procode')->where("pid=".$val['pid'])->find();
                    $code['code'] = $val['code'];

                    
                        //平仓价
                        $enter = floatval($price['Price']);
                        //入仓价
                        $flat = floatval($val['buyprice']);
                    	$cha = bcsub($enter,$flat,8);
		                $point = floatval($cha);

                
                    

                    $range = $point*$code['code']*$val['chicang'];

                    if($val['ostyle']==0)
                    {
                        if($range>0){
                            $list[$key]['ploss'] = '<span style="color:green">'.$range."</span>";
                        }else{
                            $list[$key]['ploss'] = '<span style="color:red">'.$range."</span>";
                        }
                    }else{
                        if($range>0){
                            $list[$key]['ploss'] = '<span style="color:red">-'.$range."</span>";
                        }else{
                            $list[$key]['ploss'] = '<span style="color:green">'.abs($range)."</span>";
                        }
                    }



                }

            




		}
		if($list){
			$info = json_encode($list);
			print_r($info);exit;
		}
	}

    //币币订单列表
    public function entrust(){
        
        //持仓列表
        $uid = $this->uid;
        $ostyle =input('param.ostyle');
        if($ostyle!=''){
            if($ostyle==0){
                $sl = \think\Lang::get('bi_mc');//买入
            }
            else{
                $sl = \think\Lang::get('bi_mc2');//卖出
            }
             $hold = Db::name('order')->where(array('uid'=>$uid,'is_timing'=>2,'ostyle'=>$ostyle))->order('oid desc')->select();
        }else{
            $sl = "全部";//全部
            $hold = Db::name('order')->where(array('uid'=>$uid,'is_timing'=>2))->order('oid desc')->select();
        }
        $this->assign('sl',$sl);
       
        foreach ($hold as $key=>$val){
            $hold[$key]['buytime']=date("Y-m-d H:i:s",$val['buytime']);
            $hold[$key]['fangxiang']=$val['ostyle']?\think\Lang::get('bi_mc2'):\think\Lang::get('bi_mc');  //买入或卖出

            $ptitle = Db::name('productinfo')->field('ptitle')->where('pid='.$val['pid'])->find();
            if($val['pid']==60){
                $hold[$key]['buyprice']=sprintf("%.8f",$val['buyprice']);
            }
            if($val['ostaus']==0){
                $hold[$key]['zt']=\think\Lang::get('ll_jyz'); //交易中
            }
            if($val['ostaus']==1){
                $hold[$key]['zt']=\think\Lang::get('sl_ywc'); //已完成
            }
            if($val['ostaus']==2){
                $hold[$key]['zt']=\think\Lang::get('ll_wtz'); //委托中
            }
            if($val['ostaus']==3){
                $hold[$key]['zt']=\think\Lang::get('ll_ycd');//已撤单
            }

            $hold[$key]['nyr']=date("Y-m-d",$val['buytime']);
            $hold[$key]['sfm']=date("H:i:s",$val['buytime']);



            $hold[$key]['name']=$ptitle['ptitle'];
        }

        $this->assign('hold',$hold);
        return $this->fetch();
    }



    //新合约页面
    public function lever()
    {
        $pid = input('param.pid');
        if(!$pid){
            $morenpro = db('productinfo')->where('isdelete',0)->order('proorder asc')->limit(1)->find();
            if(!$morenpro){
                $this->redirect('index/index');
            }else{
                $pid = $morenpro['pid'];
            }
        }
        //买入或卖出
        $order_type= input('param.order_type');
        $this->assign('order_type',$order_type==''?0:$order_type);

        //获取产品实时行情
        $pro = GetProData($pid,'pi.decimal,pi.ptitle,pi.procode,pi.protime,pi.propoint,pi.proscale,pi.numprice,pi.code,pd.*');
        if(!$pro){
            $this->redirect('index/index');
        }
        $pro['chajia'] = round($pro['Price']-$pro['Open'],2);
        $pro['zhangfu'] = round($pro['chajia']/$pro['Price']*100,2);

        //拆分货币对
        $huobidui = explode('/',$pro['ptitle']);
        $this->assign('huobidui',$huobidui);

        $qian_money = get_money($this->uid,2,$huobidui[0]);
        $hou_money = get_money($this->uid,2,$huobidui[1]);

        $this->assign('qian_money',floatval($qian_money));
        $this->assign('hou_money',floatval($hou_money));

        //深度
        $shendu = $this->shendu($pid);

        $this->assign('jiashendu',$shendu['jia']);
        $this->assign('jianshendu',$shendu['jian']);
        //杠杠
        $code = explode(',',$pro['code']);
        $this->assign('code',$code);

        //获取所有产品信息
        $allpro = Db::name('productinfo')->alias('pi')->field('pi.pid,pi.ptitle,pd.Price,pd.UpdateTime,pd.Low,pd.High')
            ->join('__PRODUCTDATA__ pd','pd.pid=pi.pid')
            ->where('pi.isdelete',0)->order('pi.proorder asc')->select();

        foreach($allpro as $key=>$value){
            $allpro[$key]['isopen'] = ChickIsOpen($value['pid']);
        }
        $this->assign('allpro',$allpro);

        $this->assign('goodsprice',$pro['Price']);


        //持仓列表
        $uid = $this->uid;

        $hold = Db::name('order')->where(array('uid'=>$uid,'ostaus'=>0,'is_timing'=>1,'pid'=>$pid))->order('oid desc')->select();
        foreach ($hold as $key=>$val){
            $hold[$key]['nyr']=date("Y-m-d",$val['buytime']);
            $hold[$key]['sfm']=date("H:i:s",$val['buytime']);
            $hold[$key]['fangxiang']=$val['ostyle']?\think\Lang::get('gs_zk'):\think\Lang::get('gs_zd');

            $ptitle = Db::name('productinfo')->field('ptitle')->where('pid='.$val['pid'])->find();

            $hold[$key]['jye']=$val['chicang']*$val['buyprice'];


            $hold[$key]['name']=$ptitle['ptitle'];
        }

        $this->assign('hold',$hold);

        //是否休市
        $isopen = ChickIsOpen($pid);



        $gratuity = getconf('bibi_sxfee');
        $gratuity = explode('|',$gratuity);
        $user_info = Db::name('userinfo')->where('uid',$uid)->find();
        $this->assign('user_info',$user_info);


        if($user_info['level']=='level_zero')
        {
            $web_gratuity =$gratuity[0];
        }elseif($user_info['level']=='level_one')
        {
            $web_gratuity =$gratuity[1];
        }elseif($user_info['level']=='level_two')
        {
            $web_gratuity =$gratuity[2];
        }
        elseif($user_info['level']=='level_three')
        {
            $web_gratuity =$gratuity[3];
        }
        elseif($user_info['level']=='level_four')
        {
            $web_gratuity =$gratuity[4];
        }


        $this->assign('web_gratuity',$web_gratuity/100);
        $this->assign('pro',$pro);
        $this->assign('isopen',$isopen);
        return $this->fetch();
    }

    public function shendu($pid)
    {
        $pro = db('productinfo')->where('pid',$pid)->find();

        $prodata = db('productdata')->where('pid',$pid)->find();
        $shendu = array();
        $jiashendu = array();
        $jianshendu = array();
        $jia = $prodata['Price'];
        $jian = $prodata['Price'];
        for($i=0;$i<5;$i++){
            $rowjia = array();
            $jia = $this->jia($jia,$pro);
            $jiashuliang = mt_rand(1,1000)/10;


            if($pid==60){
                $rowjia['jiage'] = sprintf("%.8f",$jia);
            }else{
                $rowjia['jiage'] = $jia;
            }



            $rowjia['shuliang'] = $jiashuliang;

            $rowjian = array();
            $jian = $this->jian($jian,$pro);
            $jianshuliang = mt_rand(1,1000)/10;


            if($pid==60){
                $rowjian['jiage'] = sprintf("%.8f",$jian);
            }else{
                $rowjian['jiage'] = $jian;
            }



            $rowjian['shuliang'] = $jianshuliang;
            $jiashendu[]=$rowjia;
            $jianshendu[]=$rowjian;

        }
        $shendu['jia']=array_reverse($jiashendu);
        $shendu['jian']=$jianshendu;

        return $shendu;
    }

    public function jia($price,$pro)
    {

        $point_low = $pro['point_low'];
        $point_top = $pro['point_top'];

        $FloatLength = getFloatLength($point_top);
        $jishu_rand = pow(10,$FloatLength);

        $point_low = $point_low * $jishu_rand;
        $point_top = $point_top * $jishu_rand;
        $rand = rand($point_low,$point_top)/$jishu_rand;

        $_new_rand = rand(0,10);

        $price = $price + $rand;

        return $price;
    }

    public function jian($price,$pro)
    {

        $point_low = $pro['point_low'];
        $point_top = $pro['point_top'];

        $FloatLength = getFloatLength($point_top);
        $jishu_rand = pow(10,$FloatLength);

        $point_low = $point_low * $jishu_rand;
        $point_top = $point_top * $jishu_rand;
        $rand = rand($point_low,$point_top)/$jishu_rand;

        $_new_rand = rand(0,10);

        $price = $price - $rand;

        return $price;
    }



    public function chicang()
    {

        return $this->fetch();
    }



    /**
     * 实时更新面板信息
     * @author lukui  2017-02-20
     * @return [type] [description]
     */
    public function ajaxpro()
    {
        $pid = input('param.pid');
        $pro = GetProData($pid,'pd.Price,pd.Open,pd.Close,pd.High,pd.Low,pd.UpdateTime');
        $pro['UpdateTime'] = date('H:i:s',$pro['UpdateTime']);

        return $pro;
    }


    public function getkdata()
    {

        $pid = input('param.pid');
        $pro = GetProData($pid);

        if(!$pro){
            return false;
        }
        $interval = input('param.interval') ? input('param.interval') : 1;

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

            default:
                # code...
                break;
        }
        $nowtime = time();
        $year = date('Y_m_d',$nowtime);
        if($interval == 'd'){

            $geturl = "http://vip.stock.finance.sina.com.cn/forex/api/jsonp.php/var%20_".$pro['procode']."$year=/NewForexService.getDayKLine?symbol=".$pro['procode']."&_=$year";
        }else{
            $geturl = "http://vip.stock.finance.sina.com.cn/forex/api/jsonp.php/var%20_".$pro['procode']."_".$interval."_$nowtime=/NewForexService.getMinKline?symbol=".$pro['procode']."&scale=".$interval."&datalen=".$datalen;
        }

        $html = file_get_contents($geturl);

        $_arr = explode('[',$html);
        $_str = substr($_arr[1],1,-3);
        $_data_arr = explode('},{',$_str);
        $_data_arr = array_slice($_data_arr,$datalen-30,$datalen-1);



        foreach ($_data_arr as $k => $v) {

            $_son_arr = explode(',', $v);

            $res_arr[] = array(
                substr($_son_arr[0],14,-1),
                substr($_son_arr[1],3,-1),
                substr($_son_arr[4],3,-1),
                substr($_son_arr[2],3,-1),
                substr($_son_arr[3],3,-1),
                substr($_son_arr[1],3,-1)
            );

        }
        $res_arr[30] = array(date('H:i:s',$nowtime),$pro['Price'],$pro['Open'],$pro['Close'],$pro['Low'],$pro['Price']);

        exit(json_encode($res_arr));

    }



    
    /**
     * 加载k线图信息
     * @author lukui  2017-02-20
     * @return [type] [description]
     */
    public function ajaxkbase()
    {

        $code = input('param.procode');
        $pid = input('param.pid');
        //产品信息
        $pro = GetProData($pid,'pi.add_data');

        $interval = input('get.interval') ? input('get.interval') : 1;
        if($interval >= 15){
            $num = $interval*10;
        }else{
            $num = 50;
        }

        if($code){
            $data = json_decode(WsGetKline($code,$interval,$num),1);
        }
        $newdata = array();
        if ($data) {
            $huilv = 6.8517;
            krsort($data);
            unset($data[0]);
            $i = 0;
            if(!$pro['add_data']){
                $huilv = 1;
                $pro['add_data'] = 1;
            }
            foreach ($data as $key => $value) {
                $newdata[$i]['price'] = round($value['Open']*$huilv*$pro['add_data'],2);
                $newdata[$i]['open'] = round($value['Open']*$huilv*$pro['add_data'],2);
                $newdata[$i]['close'] = round($value['Close']*$huilv*$pro['add_data'],2);
                $newdata[$i]['lowest'] = round($value['Low']*$huilv*$pro['add_data'],2);
                $newdata[$i]['highest'] = round($value['High']*$huilv*$pro['add_data'],2);
                $newdata[$i]['time'] = strtotime($value['Date']).'000';
                $newdata[$i]['fulltime'] = $value['Date'];
                $newdata[$i]['goodtime'] = $value['Date'];
                $i++;
            }

        }

        return $newdata;

    }



    public function ajaxkdata()
    {
        //获取k线图数据，转化为array

        $pid = input('param.pid');
        $data = Db::name('productdata')->where('pid='.$pid)->find();
        $newdata = array();
        if($data){
            $data['UpdateTime'] = $data['UpdateTime'];
            $newdata[0]['price'] = $data['Price'];
            $newdata[0]['open'] = $data['Open'];
            $newdata[0]['close'] = $data['Close'];
            $newdata[0]['lowest'] = $data['Low'];
            $newdata[0]['highest'] = $data['High'];
            $newdata[0]['time'] = $data['UpdateTime'].'000';
            $newdata[0]['fulltime'] = date('Y-m-d H:i:s',$data['UpdateTime']);
            $newdata[0]['goodtime'] = date('Y-m-d H:i:s',$data['UpdateTime']);

        }

        return $newdata;
    }

    public function goodsinfo()
    {

        $post = input('post.');
        $goods = db('productinfo')->where($post)->find();
        $res = base64_encode(json_encode($goods));
        return $res;
    }


    public function getchart()
    {

        $data['kaipan'] = '开盘';
        $data['zuidi'] = \think\Lang::get('iin_zd'); //最低
        $data['zuigao'] = \think\Lang::get('iin_zg'); //最高
        $data['Kxian'] = 'k'.\think\Lang::get('iin_kx'); //k线
        $data['zoushi'] =\think\Lang::get('iin_zs');//走势
        $data['DIFF'] = 'DIFF:';
        $data['DEA'] = 'DEA:';
        $data['MACD'] = 'MACD:';
        $data['chicang'] = \think\Lang::get('gs_cc');//持仓
        $data['maizhang'] =\think\Lang::get('iin_mz');//买涨
        $data['maidie'] = \think\Lang::get('iin_md');//买跌
        $data['xiushi'] = \think\Lang::get('iin_xs');//休市
        $data['tousijine'] = \think\Lang::get('iin_tzje'); //投资金额
        $data['chicangmingxi'] =\think\Lang::get('iin_ccmx'); //持仓明细
        $res = base64_encode(json_encode($data));
        return $res;
    }






}

