<?php
namespace app\wap\controller;

use think\Controller;
use think\Db;
use think\Loader;
class Second extends controller
{
    public function __construct(){
        parent::__construct();
        $this->conf = getconf('');
        if($this->conf['is_close'] != 1){
            header('Location:/error.html');
        }
        $this->assign('conf',$this->conf);
        $this->token = md5(rand(1,100).time());
        $this->assign('token',$this->token);

        $request= \think\Request::instance();
        $module = $request->module();//模块名
        $action = $request->action();//方法名
        $un_need_login_action = [];

        if(!in_array($action,$un_need_login_action)){
            //推荐
            $fid = input('get.fid');

            if($fid){
                $_SESSION['fid'] = $fid;
                if(!isset($_SESSION['uid'])){
                    $this->redirect('Denglu/zc?token='.$this->token);

                }
            }

            if(!isset($_SESSION['uid'])){

                $this->redirect('Denglu/dl?token='.$this->token);
            }

            $this->uid = $_SESSION['uid'];
            $this->user = db('userinfo')->where('uid',$this->uid)->find();
            if(!$this->user){
                unset($_SESSION['uid']);
                $this->redirect('Denglu/dl?token='.$this->token);
            }
        }

        $langage = cookie('think_var');
        if(!$langage){
            cookie('think_var', 'en-us');
        }
        $langage = cookie('think_var');
        if($langage=='en-us'){
            $langagename = "English";
        }
        elseif($langage=='zh-cn'){
            $langagename = "简体中文";
        }
        elseif($langage=='ja-jp'){
            $langagename = "日本語";
        }
        elseif($langage=='ko-kr'){
            $langagename = "한국어";
        }
        $this->assign('langagename', $langagename);

    }

    public function index(){



        $proclass = db('productclass')->where('isdelete',0)->order('pcid asc')->select();
        //获取产品信息
        $pro = Db::name('productinfo')->alias('pi')->field('pi.pid,pi.ptitle,pd.Price,pd.UpdateTime,pd.Low,pd.High')
            ->join('__PRODUCTDATA__ pd','pd.pid=pi.pid')
            ->where('pi.isdelete',0)->order('pi.pid asc')->select();
        //dump(cookie('pid7'));
        $qian_money = get_money($this->uid,4,'usdt');
        $pid = input('pid');
        $pid = $pid?$pid:$pro[0]['pid'];
        $productinfo = Db::name('productinfo')->where('pid='.$pid)->find();
        foreach($pro as $key=>$value){
            $pro[$key]['isopen'] = ChickIsOpen($value['pid']);
            $prtitle = explode('/',$value['ptitle']);
            $pro[$key]['base_name'] = $prtitle[0];
        }
        $uid = $this->uid;
        $user = Db::name('userinfo')->where('uid',$uid)->find();
        $level_shouyi = getconf($user['level']);

        //时间间隔
        $protime = $productinfo['protime'];
        if($protime){
            $protime = explode(',',$protime);
        }
        //点位间隔
        $propoint = $productinfo['propoint'];
        if($propoint){
            $propoint = explode(',',$propoint);
        }
        //盈利比例
        $proscale = $productinfo['proscale'];
        if($proscale){
            $proscale = explode(',',$proscale);
        }
        //投资金额
        $pay_choose = getconf('pay_choose');
        $pay_choose_arr = explode('|',$pay_choose);

        if(count($level_shouyi)==1)
        {
            $level_shouyi = explode('|',$level_shouyi);


            if(!empty($level_shouyi))
            {
                $proscale = $level_shouyi;
            }

        }

        $isopen = ChickIsOpen($pid);


        $shouxufei = getconf('web_poundage');

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
        $ptile = $productinfo['ptitle'];
        $t  = explode('/',$ptile);
        $base_name = $t[0];

        $langage = cookie('think_var');
        if(!$langage){
            cookie('think_var', 'en-us');
        }
        if($langage=='en-us'){
            $langagename = "English";
        }
        elseif($langage=='zh-cn'){
            $langagename = "简体中文";
        }
        elseif($langage=='ja-jp'){
            $langagename = "日本語";
        }
        elseif($langage=='ko-kr'){
            $langagename = "한국어";
        }
        $this->assign('langagename', $langagename);

        $this->assign('propoint',$propoint);
        $this->assign('protime',$protime);
        $this->assign('isopen',$isopen);
        $this->assign('web_poundage',$web_poundage);
        $this->assign('pay_choose_arr',$pay_choose_arr);
        $this->assign('productinfo',$productinfo);
        $this->assign('pro',$pro);
        $this->assign('order_id',$pid);
        $this->assign('proclass',$proclass);
        $this->assign('u_money',$qian_money);
        $this->assign('proscale',$proscale);

         $this->assign('base_name',$base_name);
        return $this->fetch();

    }


    public function holdlist(){
        $uid = $this->uid;
        if (empty($uid)) {
            return false;
        }
        $page = input('page');
        $type = input('type');
        $page = $page?intval($page):0;
        $type = $type?intval($type):0;

        $page_size = 10;
        $start = $page*$page_size;
        //持仓信息
        $map = array('uid'=>$uid,'ostaus'=>$type,'is_timing'=>0);
        // $map['selltime'] = array('gt',time());

        $hold = Db::name('order')->where($map)->order('oid desc')->limit($start,$page_size)->select();
        $all_count = Db::name('order')->where($map)->count();
        if($hold){
            $nowtime = time();
            foreach ($hold as $k => $v){
                $has_time = $v['buytime']+$v['endprofit'] - $nowtime;
                if($has_time>0){
                    $hold[$k]['endprofit'] = $has_time;
                }
                $hold[$k]['buytime'] = date('Y-m-d H:i:s',$v['buytime']);
                if($v['is_timing'] == 1){
                    $code = Db::name('productinfo')->field('code,decimal,procode')->where('pid='.$v['pid'])->find();
                    $hold[$k]['newprice'] = Db::name('productdata')->where('pid='.$v['pid'])->getField('Price');
                    $hold[$k]['point'] = $code['decimal'];
                    //$hold[$k]['code'] = $code['code'];
                    $hold[$k]['procode'] =strtoupper($code['procode']);
                    $hold[$k]['isopen'] = ChickIsOpen($v['pid']);

                }
            }
        }

        $has_more = ($start+$page_size)>=$all_count? 0 : 1;

        if($hold){
            echo  json_encode(['data'=>$hold,'code'=>1,'has_more'=>$has_more]);die;
        }else{
            return false;
        }
    }





}