<?php
namespace app\wap\controller;

use think\Controller;
use think\Db;
use think\Loader;
class Mining extends controller
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
            $this->assign('user',$this->user);
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
        $uid = $this->uid;
        $user = Db::name('userinfo')->where('uid',$uid)->find();
        $this->assign('user',$user);
        $prolist = Db::name('lockming')->where('show',1)->order('sort desc')->select();
        $this->assign('prolist',$prolist);


        $orderlist = Db::name('lockorder')->where('uid',$uid)->order('id desc')->paginate(10);
        $pages = $orderlist->render();
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
        $this->assign('orderlist',$orderlist);
        $this->assign('pages',$pages);


        return $this->fetch();
    }
}