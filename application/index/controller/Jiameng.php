<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Cookie;

class Jiameng extends Controller
{
	public function jiameng()
	{
		$this->assign('logo_src', str_replace("\\","/",getconf('web_logo')));
		return $this->fetch();
	}

	public function papply()
	{
		if(input('post.')){
			$data = input('post.');
			$arr = array('lastname','firstname','email','password','confirm','papply_phone','code','papply_protocol');
			foreach ($data as $k => $v) {
				if(!in_array($k,$arr)){
					return WPreturn(\think\Lang::get('od_cwdtjfs'),-1);
				}
				if($v){
					if($k == 'email'){
						if (!filter_var($v, FILTER_VALIDATE_EMAIL)) {
						    return WPreturn(\think\Lang::get('jm_yxgscw'),-1);
						}
					}
					if($k == 'password'){
						if($v != $data['confirm']){
							return WPreturn(\think\Lang::get('jm_lcmmsrbyz'),-1);
						}
						if(strlen($v)<6){
							return WPreturn(\think\Lang::get('jm_mmcdbxylw'),-1);
						}
						$data['pwd'] = $data['password'];
						$data['password'] = md5($v);
						unset($data['confirm']);
					}
					if($k == 'code'){
						//判断邮箱验证码
			            if(!isset($_SESSION['code']) || $_SESSION['code'] != $data['code'] ){
			                return WPreturn(\think\Lang::get('jm_yxyzmbzq'),-1);
			            }else{
			                unset($_SESSION['code']);
			                unset($data['code']);
			            }
					}
					if($k == 'papply_phone'){
				        if(!preg_match("/^1[34578]\d{9}$/", $v)){
				        	return WPreturn(\think\Lang::get('jm_yxgscw'),-1);
				        }
				        $data['phone'] = $v;
				        unset($data['papply_phone']);
					}
					if($k == 'papply_protocol'){
						if($v != 'on'){
							return WPreturn(\think\Lang::get('jm_qxydbgxxyzc'),-1);
						}else{
							unset($data['papply_protocol']);
						}
					}
				}else{
					if($k == 'lastName' || $k == 'firstName'){
						return WPreturn(\think\Lang::get('jm_qsrndxm'),-1);
					}
					if($k == 'email'){
						return WPreturn(\think\Lang::get('jm_qsrndyx'),-1);
					}
					if($k == 'password' || $k == 'confirm'){
						return WPreturn(\think\Lang::get('jm_qsrndmm'),-1);
					}
					if($k == 'papply_phone'){
						return WPreturn(\think\Lang::get('jm_qsrndyx'),-1);
					}
					if($k == 'code'){
						return WPreturn(\think\Lang::get('jm_qsryxyzm'),-1);
					}
					if($k == 'papply_protocol'){
						return WPreturn(\think\Lang::get('jm_qxydbgxxyzc'),-1);
					}
				}
			}
			$file = request()->file();  
            if($file){
                return WPreturn(\think\Lang::get('od_cwpzx'),-1);
            }
			//时间
			$data['time'] = time();
			//个人
			$data['personal'] = 1;
			$result = Db::name('ally')->insertGetId($data);
			if($result>0){
				return WPreturn(\think\Lang::get('jm_zccgqsh'),1);
			}else{
				return WPreturn(\think\Lang::get('jm_zcsb'),-1);
			}
		}
	}

	public function capply()
	{
		if(input('post.')){
			$data = input('post.');
			$arr = array('email','password','company','legal','regnumber','capply_phone','code','capply_protocol');
			foreach ($data as $k => $v) {
				if(!in_array($k,$arr)){
					return WPreturn(\think\Lang::get('jm_cwdtkfs'),-1);
				}
				if($v){
					if($k == 'email'){
						if (!filter_var($v, FILTER_VALIDATE_EMAIL)) {
						    return WPreturn(\think\Lang::get('jm_yxgscw'),-1);
						}
					}
					if($k == 'password'){
						if(strlen($v)<6){
							return WPreturn(\think\Lang::get('jm_mmcdbxylw'),-1);
						}
						$data['pwd'] = $data['password'];
						$data['password'] = md5($v);
					}
					if($k == 'capply_phone'){
				        if(!preg_match("/^1[34578]\d{9}$/", $v)){
				        	return WPreturn(\think\Lang::get('jm_yxgscw'),-1);
				        }
				        $data['phone'] = $v;
				        unset($data['capply_phone']);
					}
					if($k == 'code'){
						//判断邮箱验证码
			            if(!isset($_SESSION['code']) || $_SESSION['code'] != $data['code'] ){
			                return WPreturn(\think\Lang::get('jm_yxyzmbzq'),-1);
			            }else{
			                unset($_SESSION['code']);
			                unset($data['code']);
			            }
					}
					if($k == 'capply_protocol'){
						if($v != 'on'){
							return WPreturn(\think\Lang::get('jm_qxydbgxxyzc'),-1);
						}else{
							unset($data['capply_protocol']);
						}
					}
				}else{
					if($k == 'email'){
						return WPreturn(\think\Lang::get('jm_qsrndyx'),-1);
					}
					if($k == 'password'){
						return WPreturn(\think\Lang::get('jm_qsrndmm'),-1);
					}
					if($k == 'company'){
						return WPreturn(\think\Lang::get('jm_qsrgsmc'),-1);
					}
					if($k == 'legal'){
						return WPreturn(\think\Lang::get('jm_qsrfrdb'),-1);
					}
					if($k == 'regnumber'){
						return WPreturn(\think\Lang::get('jm_qsrgsbh'),-1);
					}
					if($k == 'capply_phone'){
						return WPreturn(\think\Lang::get('jm_qsrndyx'),-1);
					}
					if($k == 'code'){
						return WPreturn(\think\Lang::get('jm_qsryxyzm'),-1);
					}
					if($k == 'capply_protocol'){
						return WPreturn(\think\Lang::get('jm_qxydbgxxyzc'),-1);
					}
				}
			}

			//时间
			$data['time'] = time();
			//个人
			$data['personal'] = 0;
			$result = Db::name('ally')->insertGetId($data);
			if($result>0){
				return WPreturn(\think\Lang::get('jm_zccgqsh'),1);
			}else{
				return WPreturn(\think\Lang::get('jm_zcsb'),-1);
			}
		}
	}
}
