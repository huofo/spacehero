<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Loader;



class Base extends Controller
{
	protected $current_action;

    public function __construct(){
		parent::__construct();


	

		include $_SERVER['DOCUMENT_ROOT'].'/extend/org/menu.php';
		if(!isset($_SESSION['userid'])){
			$this->error('请先登录！','login/login',1,1);
		}
		//4.18添加
		Loader::import("org/Auth", EXTEND_PATH);
        $auth=new \Auth();
        $this->current_action = request()->module().'/'.request()->controller().'/'.lcfirst(request()->action());
		if($_SESSION['userid'] == 1){
	        $result = db('auth_rule')->where('name',$this->current_action)->find();
	        if(!$result){
	        	if ($this->request->isAjax()){
	        		$data = array(
		            	'name'=>$this->current_action,
		            	'type'=>2,
		            	'status'=>1
	            	);
	        	}else{
	        		$data = array(
		            	'name'=>$this->current_action,
		            	'type'=>1,
		            	'status'=>1
	            	);
	        	}
	            $addid = Db::name('auth_rule')->insertGetId($data);
	        }
	        $ruleslist = "all";
		}else{
		    
		    if($_SESSION['otype']==3){
		       
		        $group_id = db('userinfo')->where('uid',$_SESSION['userid'])->value('group_id');
    		    $ruleslist = db('auth_group')->where('id',$group_id)->value('rules');
    		    $ruleslist = explode(',',$ruleslist);
    		    
    			if($this->current_action != 'admin/Index/index'){
    				$result = $auth->check($this->current_action,$_SESSION['userid']);
    		        if(!$result){
    		        	return $this->error('您没有权限执行此操作',url('admin/Index/index'));exit;
    		        }
    			}
		    }
		    else{
		        //代理商
		        $ruleslist = "all";
		    }
			
		}
		

		if(!isset($_SESSION['token']) || $_SESSION['token'] != md5('nimashabi')){
			$this->redirect('login/logout');
		}

		$request = \think\Request::instance();

		$contrname = $request->controller();
        $actionname = $request->action();
        $this->assign('contrname',$contrname);
        $this->assign('actionname',$actionname);
        $this->assign('menulist',$menulist);
        $this->assign('ruleslist',$ruleslist);
        

		$this->otype = $_SESSION['otype'];
        $this->uid = $_SESSION['userid'];

		$result = Db::name('userinfo')->where(array('uid'=>$_SESSION['userid']))->field("channel_fk")->find();

		$this->channelfk = $result['channel_fk'];
		$this->assign('channelfk',$result['channel_fk']);
        $this->assign('otype',$this->otype);
        //未读消息
        $msg_nums = Db::name('consult_message')->where("receiver = 1 AND is_read = 0")->count();
        $this->assign('msg_nums',$msg_nums);
	}

	protected function fetch($template = '', $vars = [], $replace = [], $config = [])
    {
    	$replace['__ADMIN__'] = str_replace('/index.php','',\think\Request::instance()->root()).'/static/admin';
        return $this->view->fetch($template, $vars, $replace, $config);
    }
}
