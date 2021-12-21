<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class Operation extends Base
{
    /**
	 * 关于我们列表
	 * @author lukui  2017-02-15
	 * @return [type] [description]
	 */
	public function operationlist()
	{
		$pagenum = cache('page');
		$getdata = $where = array();
		$data = input('get.');
		//栏目编号、栏目标题
		if(isset($data['name']) && !empty($data['name'])){
			$where['oid|oname'] = array('like','%'.$data['name'].'%');
			$getdata['name'] = $data['name'];
		}
		if(isset($data['starttime']) && !empty($data['starttime'])){
			if(!isset($data['endtime']) || empty($data['endtime'])){
				$data['endtime'] = date('Y-m-d H:i:s',time());
			}
			$where['otime'] = array('between time',array($data['starttime'],$data['endtime']));
			$getdata['starttime'] = $data['starttime'];
			$getdata['endtime'] = $data['endtime'];
		}
		$operationlist = Db::name('operation')->where($where)->order('otime desc,oid desc')->paginate($pagenum,false,['query'=> $getdata]);
        $this->assign('operationlist',$operationlist);
        $this->assign('getdata',$getdata);
		return $this->fetch();
	}

	/**
	 * 添加栏目
	 * @author lukui  2017-02-15
	 * @return [type] [description]
	 */
	public function operationadd()
	{
		if(input('post.')){
			$data = input('post.');
			$data['otime'] = time();
			//添加栏目
			if($data['act'] == 'add'){
				if(!$data['oname']){
					return $this->error('请输入指导栏目名称',url('operation/operationadd'));exit;
				}
				$file = request()->file("picture");
				$steplist = $data['step'];
				unset($data['act']);
				unset($data['step']);
				unset($data['stepid']);
				unset($data['pic']);
				$addid = db('operation')->insertGetId($data);
				if($addid>0){
					$step = array();
					if($steplist){
						foreach($steplist as $ko => $vo){
							if($vo){
								$info = $file[$ko]->validate(['size'=>5242880,'ext'=>'jpg,png,gif'])->move(ROOT_PATH.'public'.DS.'uploads');
						        if($info){
						        	$step['step'] = $vo;
						        	$step['oid'] = $addid;
						        	$step['picture'] = $info->getSaveName();
						        	$infoid[] = db('operation_info')->insertGetId($step);
						        }else{
						            // 上传失败获取错误信息
						            $error = $file[$ko]->getError();
						            return $this->error($error,url('operation/operationadd'));exit;
						        }
							}
						}
						if(array_sum($infoid)>0){
							$this->redirect('operationlist');
						}else{
							return $this->error('栏目添加错误',url('operation/operationadd'));exit;
						}
					}else{
						$this->redirect('operationlist');
					}
				}else{
					return $this->error('栏目添加错误',url('operation/operationadd'));exit;
				}
			}
			//修改栏目
			if(!empty($data['id'])){
				if(!$data['oname']){
					return $this->error('请输入指导栏目名称',url('operation/operationadd',array('oid'=>$data['id'])));exit;
				}
				// print_r($data);die;
				$steplist = $data['step'];
				$stepidlist = $data['stepid'];
				$data['oid'] = $data['id'];
				$piclist = $data['pic'];
				unset($data['act']);
				unset($data['step']);
				unset($data['id']);
				unset($data['stepid']);
				unset($data['pic']);
				$addid = db('operation')->update($data);
				if($addid>0){
					if($stepidlist){
						foreach($stepidlist as $ko => $vo){
							$step = array();
							$step['picture'] = $piclist[$ko];
							$step['step'] = $steplist[$ko];
							if($vo){
								$step['id'] = $vo;
						        $infoid[] = db('operation_info')->update($step);
							}else{
						        $step['oid'] = $data['oid'];
						        $infoid[] = db('operation_info')->insertGetId($step);
							}
						}
						if(array_sum($infoid)>0){
							$this->redirect('operationlist');
						}else{
							return $this->error('编辑指导栏目失败',url('operation/operationadd',array('id'=>$data['oid'])));exit;
						}
					}else{
						$this->redirect('operationlist');
					}
					$this->redirect('operationlist');
				}
			}
		}else{
			$id = input('id');
			//编辑显示页
			if($id){
				$result = db('operation')->where('oid',$id)->find();
				$infolist = db('operation_info')->where('oid',$result['oid'])->select();
				foreach ($infolist as $k => $v) {
					$infolist[$k]['picture'] = '/public/uploads/'.$v['picture'];
					$infolist[$k]['pic'] = $v['picture'];
				}
				$this->assign('result',$result);
				$this->assign('infolist',$infolist);
				$this->assign('act','edit');
			}else{
				$this->assign('result','');
				$this->assign('act','add');
			}
			return $this->fetch();
		}
	}
	//修改排序
	public function operationsort(){
		$data = input('post.');
		$data['oid'] = intval($data['id']);
		if(intval($data['int'])){
			$data['osort'] = intval($data['int']);
			unset($data['int']);
			unset($data['id']);
			$result = db('operation')->update($data);
			if($result>0){
				exit(json_decode($data['osort']));
			}else{
				$sort = db('operation')->field('osort')->where('oid='.$data['id'])->find();
				exit(json_decode($sort['osort']));
			}
		}
	}

	//修改显示
	public function operationshow(){
		$id = input('id');
		if(intval($id)){
			$info = db('operation')->field('oshow')->where('oid',$id)->find();
			if($info['oshow'] == 1){
				$data['oshow'] = 0;
			}else{
				$data['oshow'] = 1;
			}
			$data['oid'] = $id;
			$result = db('operation')->update($data);
			if($result>0){
				exit(json_encode(array('state'=>'success','show'=>$data['oshow'])));
			}else{
				exit(json_encode(array('state'=>'error','show'=>$data['oshow'])));
			}
		}
	}
	//删除
	public function operationdel(){
		$id = input('id');
    	if(!$id){
    		return WPreturn('参数错误',-1);
    	}
    	$infolist = db('operation_info')->field('id,picture')->where('oid',$id)->select();
    	foreach ($infolist as $v){
    		if($v){
    			if(!empty($v['picture'])){
					$url = ROOT_PATH.'public'.DS.'uploads/'.$v['picture'];
					if(file_exists($url)){
			            @unlink($url);
			        }
				}
				db('operation_info')->delete($v['id']);
    		}
    	}
		$result = db('operation')->delete($id);
    	if($result){
    		return WPreturn('删除成功',1);
    	}else{
    		return WPreturn('删除失败',-1);
    	}
	}

	public function operationajax(){
		$id = input('id');
		if($id){
			$pic = db('operation_info')->field('picture')->where('id',$id)->find();
			if(!empty($pic['picture'])){
				$url = ROOT_PATH.'public'.DS.'uploads/'.$pic['picture'];
				if(file_exists($url)){
		            @unlink($url);
		        }
			}
			$result = db('operation_info')->delete($id);
	    	if($result){
	    		exit(json_encode('success'));
	    	}else{
	    		exit(json_encode('error'));
	    	}
		}
	}

	public function uploadsajax(){
		$id = input('id');
		$file = request()->file("picture");
		if($file){
			if($id){
				$pic = db('operation_info')->field('picture')->where('id',$id)->find();
				if(!empty($pic['picture'])){
					$url = ROOT_PATH.'public'.DS.'uploads/'.$pic['picture'];
					if(file_exists($url)){
			            @unlink($url);
			        }
				}
			}
			$info = $file->validate(['size'=>5242880,'ext'=>'jpg,png,gif'])->move(ROOT_PATH.'public'.DS.'uploads');
	        if($info){
	        	$data = $info->getSaveName();
	        	exit(json_encode(array('state'=>'success','data'=>$data)));
	        }else{
	            // 上传失败获取错误信息
	            $error = $file->getError();
	            exit(json_encode(array('state'=>'error','data'=>$error)));
	        }
		}else{
			exit(json_encode(array('error'=>'上传文件失败')));
		}
	}
}
