<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Loader;

class Base extends Controller
{
    public function __construct(){
		parent::__construct();
		cookie(['prefix' => '', 'expire' => 60*60*24]);
		$this->token = md5(time());
		$this->assign('token',$this->token);

		//推荐
		$fid = input('get.fid');
		
		if($fid){
			$_SESSION['fid'] = $fid;
			if(!isset($_SESSION['uid'])){
				$this->redirect('login/register?token='.$this->token);
			}
		}


		if(!isset($_SESSION['uid'])){
			

			$this->redirect('login/login?token='.$this->token);
		}

		$this->uid = $_SESSION['uid'];
		$this->user = db('userinfo')->where('uid',$this->uid)->find();
		if(!$this->user){
			unset($_SESSION['uid']);
			$this->redirect('login/login?token='.$this->token);
		}
		
		
		$uemail = cookie('uemail');
    
        if(!$uemail){
            cookie('uemail', $this->user['utel']);
        }
            

        $this->user['usermoney'] = get_money($this->uid,4,'USDT');
		$this->assign('userinfo',$this->user);
		//网站配置信息
		$this->conf = getconf('');
		if($this->conf['is_close'] != 1){
            header('Location:/error.html');
            exit;
        }
		$this->assign('conf',$this->conf);



	}

	protected function fetch($template = '', $vars = [], $replace = [], $config = [])
    {
    	$replace['__HOME__'] = str_replace('/index.php','',\think\Request::instance()->root()).'/static/index';
        return $this->view->fetch($template, $vars, $replace, $config);
    }
}
