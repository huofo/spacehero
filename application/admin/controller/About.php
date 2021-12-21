<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class About extends Base
{
    /**
	 * 关于我们列表
	 * @author lukui  2017-02-15
	 * @return [type] [description]
	 */
	public function aboutlist()
	{
		$pagenum = cache('page');
		$getdata = $where = array();
		$data = input('get.');
		// $res = $this->ecickdata($data);
		//栏目编号、栏目标题
		if(isset($data['title']) && !empty($data['title'])){
			$where['id|a_title'] = array('like','%'.$data['title'].'%');
			$getdata['title'] = $data['title'];
		}
		if(isset($data['starttime']) && !empty($data['starttime'])){
			if(!isset($data['endtime']) || empty($data['endtime'])){
				$data['endtime'] = date('Y-m-d H:i:s',time());
			}
			$where['a_time'] = array('between time',array($data['starttime'],$data['endtime']));
			$getdata['starttime'] = $data['starttime'];
			$getdata['endtime'] = $data['endtime'];
		}
		//权限检测
		// if($this->otype != 3){
		//    $uids = myuids($this->uid);
  //           if(!empty($uids)){
  //               $where['uid'] = array('IN',$uids);
  //           }else{
  //           	$where['uid'] = $this->uid;
  //           }
  //       }

        // if(isset($data['otype']) && $data['otype'] != '' && in_array($data['otype'],array(0,101))){
        // 	$where['otype'] = $data['otype'];
        // 	$getdata['otype'] = $data['otype'];
        // }else{
        // 	$where['otype'] = array('IN',array(0,101));
        // }
		$aboutlist = Db::name('about')->where($where)->order('a_sort desc,id desc')->paginate($pagenum,false,['query'=> $getdata]);
		// print_r($aboutlist);exit;
/*		foreach ($aboutlist as $key => $value) {
			// print_r($value['a_time']);exit;
			$aboutlist[$key]['a_time'] = date("Y-m-d H:i",$value['a_time']);
		}*/
        $this->assign('aboutlist',$aboutlist);
        $this->assign('getdata',$getdata);
		return $this->fetch();
	}

	/**
	 * 添加栏目
	 * @author lukui  2017-02-15
	 * @return [type] [description]
	 */
	public function aboutadd()
	{
		if(input('post.')){
			$data = input('post.');
			$data['a_time'] = time();
			//添加栏目
			if($data['act'] == 'add'){
				if(!$data['a_title']){
					return $this->error('请输入栏目名称',url('about/aboutadd'));exit;
				}
				$data['a_content'] = htmlspecialchars($data['content']);
				unset($data['content']);
				unset($data['act']);
				$addid = Db::name('about')->insertGetId($data);
				if($addid>0){
					$this->redirect('aboutlist');
				}else{
					return $this->error('栏目添加错误',url('about/aboutadd'));exit;
				}
			}
			//修改栏目
			if(!empty($data['id'])){
				if(!$data['a_title']){
					return $this->error('请输入栏目名称',url('about/aboutadd',array('id'=>$data['id'])));exit;
				}
				$data['a_content'] = htmlspecialchars($data['content']);
				unset($data['content']);
				unset($data['act']);
				$addid = Db::name('about')->update($data);
				if($addid>0){
					$this->redirect('aboutlist');
				}else{
					return $this->error('栏目添加错误',url('about/aboutadd',array('id'=>$data['id'])));exit;
				}
			}
		}else{
			$id = input('id');
			//编辑显示页
			if($id){
				$result = db('about')->where('id',$id)->find();
				$FCKeditor = create_html_editor('content',$result['a_content']);
				$this->assign('result',$result);
				$this->assign('act','edit');
			}else{
			//添加显示页
				$FCKeditor = create_html_editor('content');
				$this->assign('result','');
				$this->assign('act','add');
			}
			$this->assign('FCKeditor',$FCKeditor);
			return $this->fetch();
		}
	}
	//修改排序
	public function aboutsort(){
		$data = input('post.');
		$data['id'] = intval($data['id']);
		if(intval($data['int'])){
			$data['a_sort'] = intval($data['int']);
			unset($data['int']);
			$result = Db::name('about')->update($data);
			if($result>0){
				exit(json_decode($data['a_sort']));
			}else{
				$sort = db('about')->field('a_sort')->where('id='.$data['id'])->find();
				exit(json_decode($sort['a_sort']));
			}
		}
	}

	//修改显示
	public function aboutshow(){
		$id = input('id');
		if(intval($id)){
			$info = db('about')->field('a_show')->where('id',$id)->find();
			if($info['a_show'] == 1){
				$data['a_show'] = 0;
			}else{
				$data['a_show'] = 1;
			}
			$data['id'] = $id;
			$result = Db::name('about')->update($data);
			if($result>0){
				exit(json_encode(array('state'=>'success','show'=>$data['a_show'])));
			}else{
				exit(json_encode(array('state'=>'error','show'=>$data['a_show'])));
			}
		}
	}
	//删除
	public function aboutdel(){
		$id = input('id');
    	if(!$id){
    		return WPreturn('参数错误',-1);
    	}
    	$result = Db::name('about')->delete($id);
    	if($result){
    		return WPreturn('删除成功',1);
    	}else{
    		return WPreturn('删除失败',-1);
    	}
	}
}
