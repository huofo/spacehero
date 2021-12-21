<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Cookie;

class Register extends Controller
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
    }
	

	public function register()
    {

        //控制白天夜间模式样式文件
        $a=empty($_SESSION["night"]);
        if($a=="1"){$_SESSION["night"]="abc";}
        if ($_SESSION["night"]=="yes"){
            $yes="yes";$this->assign('yes',$yes);

        }else if ($_SESSION["night"]=="on"){
            $on="on";$this->assign('yes',$on);
        }else{$this->assign('yes',"abc");}



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

            if(!isset($data['protocol'])){
                return WPreturn(\think\Lang::get('ri_qrzydyszchfftk'),-1);
            }else{
                unset($data['protocol']);
            }


            if(isset($data['protocol'])&&$data['protocol'] != 'on'){
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
            $parent = checkpid($data['oid']);
            if(!$parent){
                return WPreturn(\think\Lang::get('ri_cyqmbcz'),-1);
            }
            //代理商id
            if($parent['otype']==101){
                $oid  = $parent['uid'];
            }else{
                $oid  = $parent['oid'];
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
            $data['managername'] = db('userinfo')->where('uid',$oid)->value('username');

            if(isset($this->conf['reg_type']) && $this->conf['reg_type'] == 1){
                $data['ustatus'] = 0; 
            }else{
                $data['ustatus'] = 1; 
            }
            


			
			
			$updata['username']=$data['username'];
			$updata['upwd']=$data['upwd'];
			$updata['oid']=$oid;
			$updata['utime']=$data['utime'];
			$updata['logintime']=$data['logintime'];
			$updata['lastlog']=$data['lastlog'];
            
            $updata['nickname']=$data['nickname'];
            $updata['utel']=$data['utel'];
            $updata['ustatus']=$data['ustatus'];
            $updata['managername']=$data['managername'];
            $updata['parent_id'] = $data['oid'];
			
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


        $langage = cookie('think_var');
        if(!$langage){

            cookie('think_var', 'usd');
            $langage = 'usd';
        }

        if($langage=='usd'){
            $langagename = "English";
        }
        elseif($langage=='cny'){
            $langagename = "中文";
        }
        elseif($langage=='jpy'){
            $langagename = "日本語";
        }
        elseif($langage=='krw'){
            $langagename = "한글";
        }
        elseif($langage=='try'){
            $langagename = "Türkçe";
        }


        $this->assign('langagename', $langagename);
        $this->assign('langage', strtoupper($langage));


        $this->assign('logo_src', str_replace("\\","/",getconf('web_logo')));
        $this->assign('oid',$oid);
        return $this->fetch();
    }

    /**
     * 发送短信
     * @return [type] [description]
     */
    public function sendmsm()
    {
        
        $phone = input('phone');
        if(!$phone){
            return WPreturn(\think\Lang::get('ri_qsryx'),-1);
        }

        $code = rand(100000,999999);
        $_SESSION['code'] = $code;		
        $msm = controller('Msm');
        $res = $msm->sendsms(0, $code ,$phone );
        if($res){
            return WPreturn(\think\Lang::get('li_fscg'),1);
        }else{
            return WPreturn(\think\Lang::get('li_fsyzmsb'),-1);
        }
        

    }

}
