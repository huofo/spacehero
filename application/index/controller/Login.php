<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Cookie;

class Login extends Controller
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
    
    
    public function lang()
    {

        switch ($_GET['lang']) {

            case 'cn':


                cookie('think_var', 'cny');


                break;

            case 'en':


                cookie('think_var', 'usd');


                break;
                
            case 'jpn':


                cookie('think_var', 'jpy');


                break;
                
            case 'kro':


                cookie('think_var', 'krw');


                break;
            case 'turkey':


                cookie('think_var', 'try');


                break;
        }

    }
    /**
     * 用户登录
     * @author lukui  2017-02-18
     * @return [type] [description]
     */
    public function login()
    {

        $userinfo = Db::name('userinfo');
    	//判断是否已经登录
    	if (isset($_SESSION['uid'])) {
    		$this->redirect('Trades/index?token='.$this->token);
    	}

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



        //控制白天夜间模式样式文件
        $_SESSION["night"]="on";
        $a=empty($_SESSION["night"]);
        if($a=="1"){$_SESSION["night"]="abc";}
        if ($_SESSION["night"]=="yes"){
            $yes="yes";$this->assign('yes',$yes);

        }else if ($_SESSION["night"]=="on"){
            $on="on";$this->assign('yes',$on);
        }else{$this->assign('yes',"abc");}




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
        }else{
            $langage='try';
            cookie('think_var', 'try');
            $langagename = "Türkçe";
        }


        	$uemail = cookie('uemail');
            $this->assign('uemail', $uemail);
            $this->assign('langagename', $langagename);
            $this->assign('langage', strtoupper($langage));
			$this->assign('logo_src', str_replace("\\","/",getconf('web_logo')));
            return $this->fetch();

    }

  

    public function logout()
    {
        $sess=$_SESSION["night"];
        session_unset();
        cookie('wx_info',null);
        $_SESSION["night"]=$sess;
        $this->redirect('login/login?token='.$this->token);

    }


    /**
     * 发送短信
     * @return [type] [description]
     */
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
    
    
     public function sendmsm_suiji(){
        header("Access-Control-Allow-Origin: *");//官网跨域请求
        
        if(!$_SESSION['uid']){return WPreturn(\think\Lang::get('ae_ffcz'),-1);}
        
        $uid = $_SESSION['uid'] ;
        $user = Db::name('userinfo')->where('uid',$uid)->find();
        
        if($user['utel']){
            $phone = $user['utel'];
        }
        
        
        if(!$phone){
            return WPreturn(\think\Lang::get('ae_xbdyx'),-1);
        }
        
        
        $code = rand(100000,999999);
        $_SESSION['code'] = $code;
        $_SESSION['email'] = $phone;
        $msm = controller('Msm');
         $fp = fopen('6464.txt','w+'); fwrite($fp,var_export($code,true)); fclose($fp);
        
        $res = $msm->sendsms(0, $code ,$phone );
       
        if($res){
            
            if(input('status') == 1){//官网返回
				return json_encode(array('data'=>\think\Lang::get('li_fscg'),'type'=>1));
				exit;
				}
			
				
				return WPreturn(\think\Lang::get('li_yzmfscg'),1);

            
        }else{
            return WPreturn(\think\Lang::get('li_fsyzmsb'),-1);
        }
        
    }
    



    public function respass2()
    {	//忘记密码


        //控制白天夜间模式样式文件
        $a=empty($_SESSION["night"]);
        if($a=="1"){$_SESSION["night"]="abc";}
        if ($_SESSION["night"]=="yes"){
            $yes="yes";$this->assign('yes',$yes);

        }else if ($_SESSION["night"]=="on"){
            $on="on";$this->assign('yes',$on);
        }else{$this->assign('yes',"abc");}

	  
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
        }else{
            $langage='try';
            cookie('think_var', 'try');
            $langagename = "Türkçe";
        }

        $this->assign('langagename', $langagename);
        $this->assign('langage', strtoupper($langage));
        return $this->fetch();
    }













    protected function fetch($template = '', $vars = [], $replace = [], $config = [])
    {
        $replace['__HOME__'] = str_replace('/index.php','',\think\Request::instance()->root()).'/static/index';
        return $this->view->fetch($template, $vars, $replace, $config);
    }

}
