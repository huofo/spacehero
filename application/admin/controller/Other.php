<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Other extends Base
{

	/**
	 * 其他配置显示项
	 * @author lukui  2017-02-17
	 * @return [type] [description]
	 */
	public function other()
	{
		$config = db('conf')->field('service_number,service_qq,ally_number,ally_qq,risk,copy')->where('id',1)->find();
		$this->assign('service_number',$config['service_number']);
		$this->assign('service_qq',$config['service_qq']);
		$this->assign('ally_number',$config['ally_number']);
		$this->assign('ally_qq',$config['ally_qq']);
		$this->assign('risk',$config['risk']);
		$this->assign('copy',$config['copy']);
		return $this->fetch();
	}

	public function config(){
		if(input('post.')){
			$data = input('post.');
			$arr = array('service_number','service_qq','ally_number','ally_qq','risk','copy');
			foreach ($data as $k => $v) {
				if(!in_array($k,$arr)){
					return WPreturn('错误的配置项',-1);
				}
			}
			$result = db('conf')->where('id',1)->update($data);
			if($result>0){
				return WPreturn('修改配置成功',1);
			}else{
				return WPreturn('修改配置出错',-1);
			}
		}
	}

	public function touchslider(){
		$autlist = db('advertisement')->where('type',1)->order('id asc')->select();
		$actlist = db('advertisement')->where('type',2)->order('id asc')->select();
		$fixinfo = db('advertisement')->where('type',3)->find();
		$this->assign('autlist',$autlist);
		$this->assign('actlist',$actlist);
		$this->assign('fixinfo',$fixinfo);
		return $this->fetch();
	}

	public function delpicture(){
		$id = intval(input('id'));
		if($id){
			$pic = db('advertisement')->field('picture')->where('id',$id)->find();
			if($pic['picture']){
				$url = ROOT_PATH.$pic['picture'];
				if(file_exists($url)){
		            @unlink($url);
		        }
			}
			$result = db('advertisement')->delete($id);
	    	if($result){
	    		exit(json_encode(array('state'=>'success','tips'=>'删除成功')));
	    	}else{
	    		exit(json_encode(array('state'=>'error','tips'=>'删除失败')));
	    	}
		}
	}

	public function pictureajax(){
		$id = intval(input('id'));
		$file = request()->file();
		foreach ($file as $key => $value) {
			$pic_name = $key;
			$data = array('time'=>time());
			$info = $file[$key]->validate(['size'=>5242880,'ext'=>'jpg,png,gif'])->move(ROOT_PATH.'public'.DS.'uploads');
			if($info){
				$data['picture'] = '/public' . DS . 'uploads/'.$info->getSaveName();
				if($key == 'fixedpic'){
					$pic = db('advertisement')->field('picture')->where('type',3)->find();
					if($pic['picture']){
						$url = ROOT_PATH.'public'.DS.'uploads/'.$pic['picture'];
						if(file_exists($url)){
				            @unlink($url);
				        }
						$result = db('advertisement')->where('type',3)->update($data);
					}else{
						$data['type'] = 3;
						$result = db('advertisement')->insertGetId($data);
					}
					$con = '';
				}else{
					if($key == 'automatic'){
	        			$data['type'] = 1;
					}
					if($key == 'activity'){
						$data['type'] = 2;
					}
					if($id){
						$data['id'] = $id;
						$pic = db('advertisement')->field('picture')->where('id',$id)->find();
	        			if($pic['picture']){
	        				$url = ROOT_PATH.'public'.DS.'uploads/'.$pic['picture'];
							if(file_exists($url)){
					            @unlink($url);
					        }
	        			}
	        			$con = 'up';
						$result = db('advertisement')->update($data);
					}else{
						$con = 'in';
						$result = db('advertisement')->insertGetId($data);
					}
				}
	        }else{
	            // 上传失败获取错误信息
	            $error = $file[$key]->getError();
	            exit(json_encode(array('state'=>'error','tips'=>$error)));
	        }
		}
		if($result>0){
			exit(json_encode(array('state'=>'success','tips'=>'上传成功','name'=>$pic_name,'pic'=>$data['picture'],'con'=>$con,'id'=>$result)));
		}else{
			exit(json_encode(array('state'=>'error','tips'=>'上传失败','name'=>$pic_name)));
		}
	}


	public function clause(){
		$data = input('post.');
		if($data){
			print_r($data);die;
		}else{
			return $this->fetch();
		}
	}
}
