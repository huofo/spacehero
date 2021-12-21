<?php
namespace app\wap\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Cookie;

class Index extends controller
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
        $un_need_login_action = ['index','ajaxindexpro','ajaxclass','ajaxclass_bibi'];
//var_dump($_SESSION);die;
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

        if(!$langage){
            cookie('think_var', 'en-us');
        }
        $langage = cookie('think_var');
        if($langage=='en-us'){
            $langagename = "English";
        }
        elseif($langage=='zh-cn'){
            $langagename = "中文";
        }
        elseif($langage=='ja-jp'){
            $langagename = "日本語";
        }
        elseif($langage=='ko-kr'){
            $langagename = "한글";
        }
        $this->assign('langagename', $langagename);
        $this->assign('langage', $langage);




    }
    public function index()
    {

        $a=empty($_SESSION["night"]);
        if($a=="1"){$_SESSION["night"]="abc";}
        if ($_SESSION["night"]=="yes"){
            $yes="yes";$this->assign('yes',$yes);

        }else if ($_SESSION["night"]=="on"){
            $on="on";$this->assign('yes',$on);
        }else{$this->assign('yes',"abc");}

        $tutorlist = db('guidance')->where('gshow = 1')->order('gtop desc,gid desc')->select();
        foreach ($tutorlist as $k => $v) {
            if(!empty($v['gavatar'])){
                $tutorlist[$k]['gavatar'] = '/public/uploads/'.$v['gavatar'];
            }
        }
        $articlelist = db('garticle')->field('id,gtitle,g_time')->where('g_show = 1')->order('g_top desc,id desc')->limit('0,4')->select();

        $noticelist = db('notice')->field('id,n_title,n_time')->where('n_show = 1')->order('n_sort desc,id desc')->limit('0,6')->select();
        $conf = db('conf')->where('id',1)->find();

        $autlist = db('advertisement')->field('picture')->where('type',1)->order('id asc')->select();
        foreach ($autlist as $k => $v){
            $autlist[$k]['key'] = $k+1;
        }
        $actlist = db('advertisement')->field('picture')->where('type',2)->order('id asc')->select();
        $str_p = '';
        $plist =array();
        foreach ($actlist as $k => $v){
            $actlist[$k]['key'] = 'p'.($k+1);
            $plist[]= '"'.$actlist[$k]['key'].'"';
        }
        //产品信息
        $pro = db('productdata')->where('isdelete',0)->order('pid desc')->limit(6)->select();
        $this->assign('prodata',$pro);
        //涨跌榜
        $pro_zd = db('productdata')->where('isdelete',0)->order('DiffRate desc')->select();
        $this->assign('pro_zd',$pro_zd);

        //成交榜
        $pro_cj = db('productdata')->where('isdelete',0)->order('vol desc')->select();

        foreach($pro_cj as $key=>$value){
            $pro_cj[$key]['vol']=sprintf("%.2f",$value['vol']*6.8/100000000);
        }
        $proclass = db('productclass')->where('isdelete',0)->order('pcid asc')->select();

        //获取产品信息
        $pro = Db::name('productinfo')->alias('pi')->field('pi.pid,pi.ptitle,pd.Price,pd.UpdateTime,pd.Low,pd.High')
            ->join('__PRODUCTDATA__ pd','pd.pid=pi.pid')
            ->where('pi.isdelete',0)->order('pi.pid asc')->limit(10)->select();
        //dump(cookie('pid7'));

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
        $this->assign('langage', $langage);

        foreach($pro as $key=>$value){
            $pro[$key]['isopen'] = ChickIsOpen($value['pid']);
        }
        $this->assign('pro',$pro);
        $this->assign('proclass',$proclass);


//        $user = db('userinfo')->where('uid',$_SESSION['uid'])->find();
//
//
//        $msg_nums = Db::name('consult_message')->where("sender = 1 AND receiver = '$_SESSION[uid]' AND is_read = 0")->count();
//        $this->assign('msg_nums',$msg_nums);
//
//
//        $this->assign('user',$user);
        $this->assign('pro_cj',$pro_cj);


        $plist = array_reverse($plist);
        $plist = implode(",", $plist);
        $pull_out = array_shift($actlist);
        array_push($actlist,$pull_out);
        $actlist = array_reverse($actlist);
        $fixinfo = db('advertisement')->field('picture')->where('type',3)->find();
        $this->assign('autlist',$autlist);
        $this->assign('actlist',$actlist);
        $this->assign('fixinfo',$fixinfo);
        $this->assign('plist',$plist);
        $this->assign('conf',$conf);
        $this->assign('gonggao',$this->conf['web_notice']);
        $this->assign('noticelist',$noticelist);
        $this->assign('articlelist',$articlelist);
        $this->assign('tutorlist',$tutorlist);
        $this->assign('logo_src', str_replace("\\","/",getconf('web_logo')));

        $config = db('conf')->field('service_number,service_qq,ally_number,ally_qq')->where('id',1)->find();
        $href = 'http://wpa.qq.com/msgrd?v=3&uin='.$config['service_qq'].'&site=qq&menu=yes';
        $this->assign('config',$config);
        $this->assign('href',$href);
        $this->assign('app_download',getconf('app_download'));
        return $this->fetch();
    }

    public function ajaxindexpro()
    {

        //获取产品信息
        $pro = Db::name('productinfo')->alias('pi')->field('pi.pid,pi.ptitle,pd.DiffRate,pd.vol,pd.Price,pd.UpdateTime,pd.Low,pd.High')
            ->join('__PRODUCTDATA__ pd','pd.pid=pi.pid')
            ->where('pi.isdelete',0)->order('pi.pid asc')->select();
        $newpro = array();
        //var_dump(count($pro));;die;
        foreach ($pro as $k => $v) {
            $newpro[$v['pid']] = $pro[$k];
            $newpro[$v['pid']]['UpdateTime'] = date('H:i:s',$v['UpdateTime']);

            $title_arr = explode('/',$v['ptitle']);
            $newpro[$v['pid']]['prbase'] = $title_arr[0];
            // if(!isset($_COOKIE['pid'.$v['pid']])){
            //     cookie('pid'.$v['pid'],$v['Price']);
            //     continue;
            // }
            if($v['Price'] < cookie('pid'.$v['pid']) ){  //跌了
                $newpro[$v['pid']]['isup'] = 0;
            }elseif($v['Price'] > cookie('pid'.$v['pid']) ){  //涨了
                $newpro[$v['pid']]['isup'] = 1;
            }else{  //没跌没涨
                $newpro[$v['pid']]['isup'] = 2;
            }

            cookie('pid'.$v['pid'],$v['Price']);

        }

        return base64_encode(json_encode($newpro));
    }
    public function ajaxclass(){
        $id = input('int');

        if($id>0){
            $map = array(
                'pi.isdelete'=>0,
                'pi.cid'=>$id
            );
        }else{
            $map = array(
                'pi.isdelete'=>0
            );
        }
        $pro = Db::name('productinfo')->alias('pi')->field('pi.pid,pi.ptitle,pd.Price,pd.UpdateTime,pd.Low,pd.High')
            ->join('__PRODUCTDATA__ pd','pd.pid=pi.pid')
            ->where($map)->order('pi.pid asc')->limit(10)->select();
        //var_dump($pro);die;
        $html = '';
        $url = '';
        foreach ($pro as $k => $v) {
            $html .=
                '<div class="dashuju wl_flex wl_align_center gugugus" style="background: #f0f8ff" id="pid'.$v['pid'].'">
                <div class="jutishuju wl_justify_between" style="width: 30%">
                    <div class="kus prtitle"></div>
                    <div class="kus prbase "></div>
                </div>
                <div class="jutishuju wl_justify_between" style="width: 20%">
                    <div class="ksu now-value"></div>
                    <div class="ksu updown-rate"style="color: #00a0e9"></div>
                </div>
                <div class="jutishuju wl_justify_between" style="width: 50%">
                    <div class="sku price-max"></div>
                    <div class="sku price-min"></div>
                    <div class="sku exchange-amount"></div>
                </div>
            </div>';
        }
        exit(json_encode($html));
    }

    public function ajax_get_hold_bibi(){
        $pid = input('pid');
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
            $hold = Db::name('order')->where(array('uid'=>$uid,'is_timing'=>2,'pid'=>$pid,'ostyle'=>$ostyle,'ostaus'=>1))->order('oid desc')->select();
        }else{
            $sl = \think\Lang::get('ti_qb'); //全部
            $hold = Db::name('order')->where(array('uid'=>$uid,'is_timing'=>2,'pid'=>$pid,'ostaus'=>1))->order('oid desc')->select();
        }
        $this->assign('sl',$sl);

        foreach ($hold as $key=>$val){
            $hold[$key]['buytime']=date("Y-m-d H:i:s",$val['buytime']);
            $hold[$key]['fangxiang']=$val['ostyle']?\think\Lang::get('bi_mc'):\think\Lang::get('bi_mc2');//买入、卖出

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
        return base64_encode(json_encode($hold));
        //$this->assign('hold',$hold);
    }


    public function search_bibi(){
        $keyword = input('keyword');
        if(empty($keyword)){
            echo '错误~';
        }
        $pro = Db::name('productinfo')->alias('pi')->field('pi.pid,pi.ptitle,pd.Price,pd.UpdateTime,pd.Low,pd.High')
            ->join('__PRODUCTDATA__ pd','pd.pid=pi.pid')
            ->where('pi.procode','like', '%'.$keyword.'%')->order('pi.pid asc')->limit(10)->select();
        //var_dump($pro);die;
        $html = '';
        $url = '';
        foreach ($pro as $k => $v) {
            $html .= '   <div class="shakod xh_flex xh_justify_between uhb" id="pid'.$v['pid'].'">
                    <div style="margin-left: 10px;" class="prtitle"></div>
                    <div class="now-value"></div>
                    <div style="margin-right: 10px;color: red" class="rise-rate"></div>
                </div>';
        }
        exit(json_encode($html));
    }

    public function ajaxclass_bibi(){
        $id = input('int');
        if($id>0){
            $map = array(
                'pi.isdelete'=>0,
                'pi.cid'=>$id
            );
        }else{
            $map = array(
                'pi.isdelete'=>0
            );
        }
        $pro = Db::name('productinfo')->alias('pi')->field('pi.pid,pi.ptitle,pd.Price,pd.UpdateTime,pd.Low,pd.High')
            ->join('__PRODUCTDATA__ pd','pd.pid=pi.pid')
            ->where($map)->order('pi.pid asc')->select();
        $html = '';
        $url = '';
        foreach ($pro as $k => $v) {
            $html .= '   <div class="shakod xh_flex xh_justify_between uhb" id="pid'.$v['pid'].'" onclick="change_oid('.$v['pid'].')">
                    <div style="margin-left: 10px;" class="prtitle"></div>
                    <div class="now-value"></div>
                    <div style="margin-right: 10px;color: red" class="rise-rate"></div>
                </div>';
        }
        exit(json_encode($html));
    }

    public function userpidinfo(){
        $id = input('pid');
        $type = input('type');
        $type = $type?$type:1;
        $productinfo = Db::name('productinfo')->where('pid='.$id)->find();
        //拆分货币对
        $huobidui = explode('/',$productinfo['ptitle']);
        //$this->assign('huobidui',$huobidui);

        //合约币种的手数数据
        $numprice = $productinfo['numprice'];

        //手续费
        if($type == 1){//币币
            $shouxufei = getconf('bibi_sxfee');
        }
        elseif($type == 2){//合约
            $shouxufei = getconf('web_gratuity');

        }elseif ($type == 3){//秒合约
            $shouxufei = getconf('web_poundage');
        }
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




        $qian_money = get_money($this->uid,$type,$huobidui[0]);
        $hou_money = get_money($this->uid,$type,$huobidui[1]);




        exit(json_encode(['base_name'=>$huobidui[0],
            'u_money'=>floatval($hou_money),
            'base_money'=>floatval($qian_money),
            'numprice'=>$numprice,
            'fee_rate'=>$web_poundage]));

    }

    public function heyuejiaoyi()
    {
        $proclass = db('productclass')->where('isdelete',0)->order('pcid asc')->select();

        $pro = Db::name('productinfo')->alias('pi')->field('pi.pid,pi.ptitle,pd.Price,pd.UpdateTime,pd.Low,pd.High,pd.DiffRate')
            ->join('__PRODUCTDATA__ pd','pd.pid=pi.pid')
            ->where('pi.isdelete',0)->order('pi.pid asc')->select();
        //dump(cookie('pid7'));

        foreach($pro as $key=>$value){
            $pro[$key]['isopen'] = ChickIsOpen($value['pid']);
        }

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

        $this->assign('pro',$pro);
        $this->assign('order_id',$pro[0]['pid']);
        $this->assign('basename',explode('/',$pro[0]['ptitle'])[0]);
        $this->assign('proclass',$proclass);
        return $this->fetch();
    }
    public function ajax_get_heyue_order_list(){
        $pid = input('pid');
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
        echo base64_encode(json_encode($hold));die;
        //$this->assign('hold',$hold);
    }

    public function bibijiaoyi()
    {
        $proclass = db('productclass')->where('isdelete',0)->order('pcid asc')->select();
        //获取产品信息
        $pro = Db::name('productinfo')->alias('pi')->field('pi.pid,pi.ptitle,pd.Price,pd.UpdateTime,pd.Low,pd.High')
            ->join('__PRODUCTDATA__ pd','pd.pid=pi.pid')
            ->where('pi.isdelete',0)->order('pi.pid asc')->select();
        //dump(cookie('pid7'));

        foreach($pro as $key=>$value){
            $pro[$key]['isopen'] = ChickIsOpen($value['pid']);
        }

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

        $pid = input('pid');

        $this->assign('pro',$pro);
        $this->assign('order_id',$pid?$pid:$pro[0]['pid']);
        $this->assign('proclass',$proclass);




        return $this->fetch();
    }
    public function weituoyemian()
    {
        return $this->fetch();
    }
    public function hangqing()
    {
        $proclass = db('productclass')->where('isdelete',0)->order('pcid asc')->select();
        //获取产品信息
        $pro = Db::name('productinfo')->alias('pi')->field('pi.pid,pi.ptitle,pd.Price,pd.UpdateTime,pd.Low,pd.High')
            ->join('__PRODUCTDATA__ pd','pd.pid=pi.pid')
            ->where('pi.isdelete',0)->order('pi.pid asc')->limit(10)->select();
        //dump(cookie('pid7'));


        foreach($pro as $key=>$value){
            $pro[$key]['isopen'] = ChickIsOpen($value['pid']);
        }

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

        $this->assign('pro',$pro);
        $this->assign('proclass',$proclass);
        return $this->fetch();
    }
    public function falv()
    {
        return $this->fetch();
    }
    public function heyuechicang()
    {
        //持仓列表
        $uid = $this->uid;
        $daojishiid='';
        $all_pro_loss =  Db::name('order')->where(array('uid'=>$uid,'ostaus'=>0,'is_timing'=>1))->sum('ploss');
        $hold = Db::name('order')->where(array('uid'=>$uid,'is_timing'=>1,'ostaus'=>0))->order('oid desc')->paginate(10);
        $pages = $hold->render();
        $hold = $hold->all();
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

        $this->assign('pages',$pages);
        $this->assign('all_pro_loss',$all_pro_loss);
        $this->assign('daojishiid',$daojishiid);
        $this->assign('hold',$hold);
        return $this->fetch();

    }
    //更新合约持仓订单的最新价格
    public function ajax_getOrderNewPrice(){
        $new_arr = [];
        $hold = Db::name('order')->where(array('uid'=>$this->uid,'is_timing'=>1,'ostaus'=>0))->order('oid desc')->select();
       // var_dump($hold);die;
        if($hold){
            foreach ($hold as $k=>$v){

                $pro = Db::name('productinfo')->alias('pi')->field('pi.pid,pi.ptitle,pd.DiffRate,pd.vol,pd.Price,pd.UpdateTime,pd.Low,pd.High')
                    ->join('__PRODUCTDATA__ pd','pd.pid=pi.pid')
                    ->where('pi.isdelete',0)
                    ->where('pi.pid',$v['pid'])
                    ->find();

                $title_arr = explode('/',$v['ptitle']);
                $newpro[$v['oid']]['oid'] = $v['oid'];
                $newpro[$v['oid']]['prbase'] = $title_arr[0];
                $newpro[$v['oid']]['price'] = $pro['Price'];
                if($pro['Price'] < cookie('pid'.$v['pid']) ){  //跌了
                    $newpro[$v['oid']]['isup'] = 0;
                }elseif($pro['Price'] > cookie('pid'.$v['pid']) ){  //涨了
                    $newpro[$v['oid']]['isup'] = 1;
                }else{  //没跌没涨
                    $newpro[$v['oid']]['isup'] = 2;
                }

                cookie('pid'.$v['pid'],$pro['Price']);
            }
        }
        echo json_encode($newpro);die;
    }

    public function jiaoyichicang()
    {
        $ostaus = input('ostaus');
        $ostaus = $ostaus?$ostaus:0;
        //持仓列表
        $uid = $this->uid;
        $daojishiid='';
        $hold = Db::name('order')->where(array('uid'=>$uid,'ostaus'=>$ostaus,'is_timing'=>1))->order('oid desc')->paginate(15,false,[ 'query' => request()->param(),]);
        $pages = $hold->render();
        $hold = $hold->all();
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
            
            if($val['ostaus']==0){
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
            }else{
                 if($val['ploss']>0){
                    $hold[$key]['ploss'] = '<span style="color:green">+'.$val['ploss']."</span>";
                }else{
                     $hold[$key]['ploss'] = '<span style="color:red">'.$val['ploss']."</span>";
                }
                
                $hold[$key]['pctime']=date("Y-m-d H:i:s",$val['selltime']);
            }

            



        }




        $this->assign('pages',$pages);
        $this->assign('ostaus',$ostaus);

        $this->assign('daojishiid',$daojishiid);
        $this->assign('hold',$hold);
        return $this->fetch();
    }

}



