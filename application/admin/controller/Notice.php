<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class Notice extends Base
{
    /**
	 * 关于我们列表
	 * @author lukui  2017-02-15
	 * @return [type] [description]
	 */
	public function noticelist()
	{
		$pagenum = cache('page');
		$getdata = $where = array();
		$data = input('get.');
		// $res = $this->ecickdata($data);
		//栏目编号、栏目标题
		if(isset($data['title']) && !empty($data['title'])){
			$where['id|title'] = array('like','%'.$data['title'].'%');
			$getdata['title'] = $data['title'];
		}
		if(isset($data['starttime']) && !empty($data['starttime'])){
			if(!isset($data['endtime']) || empty($data['endtime'])){
				$data['endtime'] = date('Y-m-d H:i:s',time());
			}
			$where['time'] = array('between time',array($data['starttime'],$data['endtime']));
			$getdata['starttime'] = $data['starttime'];
			$getdata['endtime'] = $data['endtime'];
		}
	
		$noticelist = Db::name('lockming')->where($where)->order('sort desc,id desc')->paginate($pagenum,false,['query'=> $getdata]);

        $this->assign('noticelist',$noticelist);
        $this->assign('getdata',$getdata);
		return $this->fetch();
	}

	/**
	 * 添加栏目
	 * @author lukui  2017-02-15
	 * @return [type] [description]
	 */
	public function noticeadd()
	{
		if(input('post.')){
		   
			$data = input('post.');
			//添加栏目
			$data['time'] = time();
			if($data['act'] == 'add'){
				if(!$data['title']){
					return $this->error('请输入套餐标题',url('notice/noticeadd'));exit;
				}
				if(!$data['name']){
					return $this->error('请选择币种',url('notice/noticeadd'));exit;
				}
				
				unset($data['act']);
				unset($data['id']);
		
				$addid = Db::name('lockming')->insertGetId($data);
				if($addid>0){
					$this->redirect('noticelist');
				}else{
					return $this->error('套餐添加错误',url('notice/noticeadd'));exit;
				}
			}
			//修改栏目
			if(!empty($data['id'])){
				if(!$data['title']){
					return $this->error('请输入套餐标题',url('notice/noticeadd',array('id'=>$data['id'])));exit;
				}
				if(!$data['name']){
					return $this->error('请选择币种',url('notice/noticeadd',array('id'=>$data['id'])));exit;
				}
				
				
				unset($data['act']);
				$addid = Db::name('lockming')->update($data);
				if($addid>0){
					$this->redirect('noticelist');
				}else{
					return $this->error('套餐添加错误',url('notice/noticeadd',array('id'=>$data['id'])));exit;
				}
			}
		}else{
			$id = input('id');
			//编辑显示页
			if($id){
				$result = db('lockming')->where('id',$id)->find();
			
				$this->assign('result',$result);
				$this->assign('act','edit');
			}else{
			//添加显示页
				
				$this->assign('result','');
				$this->assign('act','add');
			}
			
			$cp =  db('zc')->distinct(true)->where('qb=1')->field('cp')->select();
		 	 
			$this->assign('cp',$cp);
			return $this->fetch();
		}
	}
	//修改排序
	public function noticesort(){
		$data = input('post.');
		$data['id'] = intval($data['id']);
		if(intval($data['int'])){
			$data['sort'] = intval($data['int']);
			unset($data['int']);
			$result = Db::name('lockming')->update($data);
			if($result>0){
				exit(json_decode($data['sort']));
			}else{
				$sort = db('lockming')->field('sort')->where('id='.$data['id'])->find();
				exit(json_decode($sort['sort']));
			}
		}
	}
	
	
	//修改排序
	public function orderlist(){
		$pagenum = cache('page');
		$getdata = $where = array();
		$data = input('get.');
		// $res = $this->ecickdata($data);
		//栏目编号、栏目标题
		if(isset($data['title']) && !empty($data['title'])){
			$where['name'] = array('like','%'.$data['title'].'%');
			$getdata['title'] = $data['title'];
		}
		if(isset($data['starttime']) && !empty($data['starttime'])){
			if(!isset($data['endtime']) || empty($data['endtime'])){
				$data['endtime'] = date('Y-m-d H:i:s',time());
			}
			$where['starttime'] = array('between time',array($data['starttime'],$data['endtime']));
			$getdata['starttime'] = $data['starttime'];
			$getdata['endtime'] = $data['endtime'];
		}
	
		$noticelist = Db::name('lockorder')->where($where)->order('id desc')->paginate($pagenum,false,['query'=> $getdata]);

        $this->assign('noticelist',$noticelist);
        $this->assign('getdata',$getdata);
		return $this->fetch();
	}


	//修改显示
	public function noticeshow(){
		$id = input('id');
		if(intval($id)){
			$info = db('lockming')->field('show')->where('id',$id)->find();
			if($info['show'] == 1){
				$data['show'] = 0;
			}else{
				$data['show'] = 1;
			}
			$data['id'] = $id;
			$result = Db::name('lockming')->update($data);
			if($result>0){
				exit(json_encode(array('state'=>'success','show'=>$data['show'])));
			}else{
				exit(json_encode(array('state'=>'error','show'=>$data['show'])));
			}
		}
	}
	//删除
	public function noticedel(){
		$id = input('id');
    	if(!$id){
    		return WPreturn('参数错误',-1);
    	}
    	$result = Db::name('lockming')->delete($id);
    	if($result){
    		return WPreturn('删除成功',1);
    	}else{
    		return WPreturn('删除失败',-1);
    	}
	}
}
