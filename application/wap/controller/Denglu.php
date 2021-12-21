<?php
namespace app\wap\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Cookie;

class Denglu extends controller
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

        //推荐
    }
    public function wangji()
    {
        $a=empty($_SESSION["night"]);
        if($a=="1"){$_SESSION["night"]="abc";}
        if ($_SESSION["night"]=="yes"){
            $yes="yes";$this->assign('yes',$yes);

        }else if ($_SESSION["night"]=="on"){
            $on="on";$this->assign('yes',$on);
        }else{$this->assign('yes',"abc");}

        if (isset($_SESSION['uid'])) {
            $this->redirect('index/index?token='.$this->token);
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

        return $this->fetch();
    }
    public function dl()
    {

        $a=empty($_SESSION["night"]);
        if($a=="1"){$_SESSION["night"]="abc";}
        if ($_SESSION["night"]=="yes"){
            $yes="yes";$this->assign('yes',$yes);

        }else if ($_SESSION["night"]=="on"){
            $on="on";$this->assign('yes',$on);
        }else{$this->assign('yes',"abc");}

        if (isset($_SESSION['uid'])) {
            $this->redirect('index/index?token='.$this->token);
        }

        if (isset($_SESSION['uid'])) {
            $this->redirect('index/index?token='.$this->token);
        }


        return $this->fetch();
    }
    public function zc()
    {

        $a=empty($_SESSION["night"]);
        if($a=="1"){$_SESSION["night"]="abc";}
        if ($_SESSION["night"]=="yes"){
            $yes="yes";$this->assign('yes',$yes);

        }else if ($_SESSION["night"]=="on"){
            $on="on";$this->assign('yes',$on);
        }else{$this->assign('yes',"abc");}

        if (isset($_SESSION['uid'])) {
            $this->redirect('index/index?token='.$this->token);
        }

        if (isset($_SESSION['uid'])) {
            $this->redirect('index/index?token='.$this->token);
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

        return $this->fetch();
    }
    public function logout()
    {
        session_unset();
        cookie('wx_info',null);
        $this->redirect('Denglu/dl?token='.$this->token);

    }
    public function login()
    {

        $userinfo = Db::name('userinfo');
        //判断是否已经登录
//        if (isset($_SESSION['uid'])) {
//            $this->redirect('Trades/index?token='.$this->token);
//        }




        //web用户登录请求
        if(input('post.')){
            $data = input('post.');
            $arr = array('username','upwd');
            foreach ($data as $k => $v) {
                if(!in_array($k,$arr)){
                    return WPreturn(\think\Lang::get('od_cwpzx'),-1);
                }
            }
            $file = request()->file();
            if($file){
                return WPreturn(\think\Lang::get('od_cwpzx'),-1);
            }
            //验证用户信息
            if(!isset($data['username']) || empty($data['username'])){
                return WPreturn(\think\Lang::get('qsryhm'),-1);
            }
            if(!isset($data['upwd']) || empty($data['upwd'])){
                return WPreturn(\think\Lang::get('rt_qsrmm'),-1);
            }
            //查询用户

            $result = $userinfo
                ->where('username',$data['username'])->whereOr('nickname',$data['username'])->whereOr('utel',$data['username'])
                ->field("uid,upwd,username,utel,utime,otype,ustatus")->find();
            //验证用户
            if(empty($result)){

                return WPreturn(\think\Lang::get('rt_dlsbyhmbcz'),-1);
            }else{
                if(!in_array($result['otype'], array(0,101))){  //非客户无权登录
                    return WPreturn(\think\Lang::get('li_nwqdl'),-1);
                }
                if($result['upwd'] == md5($data['upwd'])){

                    if ($result['ustatus']==0)
                    {
                        $_SESSION['uid'] = $result['uid'];
                        //更新登录时间
                        $t_data['logintime'] = $t_data['lastlog'] = time();
                        $t_data['uid'] = $result['uid'];
                        $userinfo->update($t_data);

                        Update_useraccount($result['uid']);

                        return WPreturn(\think\Lang::get('li_dlcg'),1);

                    }elseif($result['ustatus']==1){
                        return WPreturn(\think\Lang::get('li_dlsbnnzhbdj'),-1);
                    }else{
                        return WPreturn(\think\Lang::get('rt_dlsbyhmbcz'),-1);
                    }

                }
                else{
                    return WPreturn(\think\Lang::get('rt_dlsbmmcw'),-1);
                }
            }



        }
        $this->assign('logo_src', str_replace("\\","/",getconf('web_logo')));
        return $this->fetch();



    }
    public function respass2()
    {	//忘记密码

        $data = input('post.');
        if($data){
            $arr = array('username','phonecode','upwd','upwd2');
            foreach ($data as $k => $v) {
                if(!in_array($k,$arr)){
                    return WPreturn(\think\Lang::get('od_cwpzx'),-1);
                }
            }
            $file = request()->file();
            if($file){
                return WPreturn(\think\Lang::get('od_cwpzx'),-1);
            }
            $suerinfo = db('userinfo');

            if($data['username'] == '11111111111')
            {
                return WPreturn(\think\Lang::get('ae_ffcz'),-1);
            }
            /*if(!isset($_SESSION['uid'])){//都没登陆哪来的SESSION['uid']
                return WPreturn('非法操作',-1);
            }*/

            $user = $suerinfo->where('utel',$data['username'])->find();

            if(!$user){
                return WPreturn(\think\Lang::get('ae_gyxbzc'),-1);
            }
            if($user['otype']==3){
                return WPreturn(\think\Lang::get('ae_ffcz'),-1);
            }
            /*if($user['uid']!= $_SESSION('uid')){
                return WPreturn('非法操作!',-1);
            }*/



            if(!isset($data['upwd']) || empty($data['upwd'])){
                return WPreturn(\think\Lang::get('qsrmm'),-1);
            }
            if(!isset($data['upwd2']) || empty($data['upwd2'])){
                return WPreturn(\think\Lang::get('ai_qzcsrmm'),-1);
            }
            if($data['upwd'] != $data['upwd2']){
                return WPreturn(\think\Lang::get('li_lcsrdmmbt'),-1);
            }

            //判断邮箱验证码
            if (!isset($_SESSION['code']) || $_SESSION['code'] != $data['phonecode']) {
                return WPreturn(\think\Lang::get('jm_yxyzmbzq'), -1);
            } else {
                unset($_SESSION['code']);
            }

            //unset($data['phonecode']);

            unset($data['upwd2']);

            // if($user['otype'] == 101){
            // return WPreturn('非法操作',-1);
            // unset($data['username']);
            // }

            $data['upwd'] = md5($data['upwd']);
            $data['uid'] = $user['uid'];
            $data['logintime'] = $data['lastlog'] = time();
            // $updata['username']=$data['username'];
            $updata['upwd']=$data['upwd'];
            $updata['uid']=$data['uid'];
            $updata['lastlog']=$data['lastlog'];
            $updata['logintime']=$data['logintime'];

            $ids = $suerinfo->update($updata);
            if($ids){
                return WPreturn(\think\Lang::get('li_xgcg'),1);
            }else{
                return WPreturn(\think\Lang::get('li_xgsb'),-1);
            }

        }
        return $this->fetch();
    }
    public function sendmsm()
    {
        header("Access-Control-Allow-Origin: *");//官网跨域请求
        $phone = input('phone');

        if(!$phone || $phone == 'undefined'){
            return WPreturn(\think\Lang::get('ri_qsryx'),-1);
        }
        $code = rand(100000,999999);
        $_SESSION['code'] = $code;
        $msm = controller('Msm');
        $res = $msm->sendsms(0, $code ,$phone );
        if($res){
            if(input('status') == 1){//官网返回
                return json_encode(array('data'=>\think\Lang::get('li_fscg'),'type'=>1));
                exit;
            }
            return WPreturn(\think\Lang::get('li_fscg'),1);
        }else{
            return WPreturn(\think\Lang::get('li_fsyzmsb'),-1);
        }


    }

    public function register()
    {

        $userinfo = Db::name('userinfo');
        if(input('post.')){
            $data = input('post.');
            $arr = array('username','phonecode','oid','upwd','upwd2','protocol','nickname');
            foreach ($data as $k => $v) {
                if(!in_array($k,$arr)){
                    return WPreturn(\think\Lang::get('od_cwpzx'),-1);
                }
            }
            $file = request()->file();
            if($file){
                return WPreturn(\think\Lang::get('od_cwpzx'),-1);
            }
            if($data['protocol'] != 'on'){
                return WPreturn(\think\Lang::get('ri_qrzydyszchfftk'),-1);
            }else{
                unset($data['protocol']);
            }
            //验证用户信息
            if(!isset($data['username']) || empty($data['username'])){
                return WPreturn(\think\Lang::get('qsryhm'),-1);
            }
            if(!isset($data['upwd']) || empty($data['upwd'])){
                return WPreturn(\think\Lang::get('rt_qsrmm'),-1);
            }
            if(!isset($data['upwd2']) || empty($data['upwd2'])){
                return WPreturn(\think\Lang::get('ai_qzcsrmm'),-1);
            }
            if($data['upwd'] != $data['upwd2']){
                return WPreturn(\think\Lang::get('li_lcsrdmmbt'),-1);
            }
            if(!isset($data['oid']) || empty($data['oid'])){
                return WPreturn(\think\Lang::get('ri_qsmyqm'),-1);
            }
            // //判断邀请码是否存在
            $codeid = checkcode($data['oid']);
            if(!$codeid){
                return WPreturn(\think\Lang::get('ri_cyqmbcz'),-1);
            }
            //代理商id
            if($codeid['otype']==101){
                $data['oid'] = $codeid['uid'];
            }else{
                $data['oid'] = $codeid['oid'];
            }

            //判断邮箱验证码
            if(!isset($_SESSION['code']) || $_SESSION['code'] != $data['phonecode'] ){
                return WPreturn(\think\Lang::get('jm_yxyzmbzq'),-1);
            }else{
                unset($_SESSION['code']);
            }

            unset($data['phonecode']);
            unset($data['upwd2']);
            if(check_user('utel',$data['username'])){
                return WPreturn(\think\Lang::get('ri_gyxycz'),-1);
            }
            $data['utime'] = $data['logintime'] = $data['lastlog'] = time();
            $data['upwd'] = md5($data['upwd']);
            $data['nickname'] = trim($data['nickname']);
            $data['utel'] = trim($data['username']);
            $data['managername'] = db('userinfo')->where('uid',$data['oid'])->value('username');

            if(isset($this->conf['reg_type']) && $this->conf['reg_type'] == 1){
                $data['ustatus'] = 0;
            }else{
                $data['ustatus'] = 1;
            }

            if(isset($_SESSION['fid']) && $_SESSION['fid']>0){
                $fid = $_SESSION['fid'];
                $fid_info = $userinfo->where(array('uid'=>$fid,'otype'=>101))->value('uid');
                if($fid_info){
                    $data['oid'] = $fid;
                }

            }
            $data['managername'] = $userinfo->where(array('uid'=>$data['oid'],'otype'=>101))->value('username');


            $updata['username']=$data['username'];
            $updata['upwd']=$data['upwd'];
            $updata['oid']=$data['oid'];
            $updata['utime']=$data['utime'];
            $updata['logintime']=$data['logintime'];
            $updata['lastlog']=$data['lastlog'];

            $updata['nickname']=$data['nickname'];
            $updata['utel']=$data['utel'];
            $updata['ustatus']=$data['ustatus'];
            $updata['managername']=$data['managername'];
            $updata['parent_id'] = $codeid['uid'];

            $updata['jinjie']=1;
            $updata['jiying']=0;
            $updata['rmbtd']=0;
            //插入数据
            $ids = $userinfo->insertGetId($updata);
            $newdata['uid'] = $ids;
            $newdata['username'] = 10000000+$ids;
            $newids = $userinfo->update($newdata);
            if ($newids) {
                $_SESSION['uid'] = $ids;


                //蒙庚宇判断是否是新用户
                Update_useraccount($ids);



                return WPreturn(\think\Lang::get('ri_zccgyzddl'),1);
            }else{
                return WPreturn(\think\Lang::get('ri_zcsbqcs'),-1);
            }

        }
        if(isset($_SESSION['fid']) && $_SESSION['fid']>0){
            $oid = $_SESSION['fid'];
        }else{
            $oid = '';
        }
        $this->assign('logo_src', str_replace("\\","/",getconf('web_logo')));
        $this->assign('oid',$oid);
        return $this->fetch();
    }


}