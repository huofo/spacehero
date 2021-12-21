<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class Guidance extends Base
{
    /**
	 * 关于我们列表
	 * @author lukui  2017-02-15
	 * @return [type] [description]
	 */
	public function guidancelist()
	{
		$pagenum = cache('page');
		$getdata = $where = array();
		$data = input('get.');
		// $res = $this->ecickdata($data);
		//栏目编号、栏目标题
		if(isset($data['name']) && !empty($data['name'])){
			$where['gid|gname'] = array('like','%'.$data['name'].'%');
			$getdata['name'] = $data['name'];
		}
		$guidancelist = Db::name('guidance')->where($where)->order('gtop desc,gid desc')->paginate($pagenum,false,['query'=> $getdata]);
        $this->assign('guidancelist',$guidancelist);
        $this->assign('getdata',$getdata);
		return $this->fetch();
	}

	/**
	 * 添加栏目
	 * @author lukui  2017-02-15
	 * @return [type] [description]
	 */
	public function guidanceadd()
	{
		if(input('post.')){
			$data = input('post.');
			$file = request()->file("gavatar");
			//添加栏目
			if($data['act'] == 'add'){
				if(!$data['gname']){
					return $this->error('请输入名师姓名',url('guidance/guidanceadd'));exit;
				}
				if($file){
					$info = $file->validate(['size'=>5242880,'ext'=>'jpg,png,gif'])->move(ROOT_PATH.'public'.DS.'uploads');
			        if($info){
			           $data['gavatar'] = $info->getSaveName();
			        }else{
			            // 上传失败获取错误信息
			            $error = $file->getError();
			            return $this->error($error,url('guidance/guidanceadd'));exit;
			        }
				}
				unset($data['act']);
				$addid = Db::name('guidance')->insertGetId($data);
				if($addid>0){
					$this->redirect('guidancelist');
				}else{
					return $this->error('添加错误',url('guidance/guidanceadd'));exit;
				}
			}
			//修改栏目
			if(!empty($data['gid'])){
				if(!$data['gname']){
					return $this->error('请输入名师姓名',url('guidance/guidancelist',array('gid'=>$data['id'])));exit;
				}
				if($file){
					$gavatar = db('guidance')->field('gavatar')->where('gid',$data['gid'])->find();
					if(!empty($gavatar['gavatar'])){
						$url = ROOT_PATH.'public'.DS.'uploads/'.$gavatar['gavatar'];
						if(file_exists($url)){
				            @unlink($url);
				        }
					}
					$info = $file->validate(['size'=>5242880,'ext'=>'jpg,png,gif'])->move(ROOT_PATH.'public'.DS.'uploads');
			        if($info){
			           $data['gavatar'] = $info->getSaveName();
			        }else{
			            // 上传失败获取错误信息
			            $error = $file->getError();
			            return $this->error($error,url('guidance/guidanceadd'));exit;
			        }
				}
				unset($data['act']);
				$addid = Db::name('guidance')->update($data);
				if($addid>0){
					$this->redirect('guidancelist');
				}else{
					return $this->error('修改失败',url('guidance/guidanceadd',array('gid'=>$data['gid'])));exit;
				}
			}
		}else{
			$id = input('gid');
			//编辑显示页
			if($id){
				$result = db('guidance')->where('gid',$id)->find();
				if($result['gavatar']){
					$result['gavatar'] = '/public/uploads/'.$result['gavatar'];
				}
				$this->assign('result',$result);
				$this->assign('act','edit');
			}else{
			//添加显示页
				$FCKeditor = create_html_editor('content');
				$this->assign('result','');
				$this->assign('act','add');
			}
			return $this->fetch();
		}
	}
	//置顶
	public function guidancegtop(){
		$id = input('id');
		if(intval($id)){
			$info = db('guidance')->field('gtop')->where('gid',$id)->find();
			if($info['gtop'] > 1){
				$data['gtop'] = 0;
			}else{
				$data['gtop'] = time();
			}
			$data['gid'] = $id;
			$result = Db::name('guidance')->update($data);
			if($result>0){
				exit(json_encode(array('state'=>'success','gtop'=>$data['gtop'])));
			}else{
				exit(json_encode(array('state'=>'error','gtop'=>$data['gtop'])));
			}
		}
	}

	//修改显示
	public function guidanceshow(){
		$id = input('id');
		if(intval($id)){
			$info = db('guidance')->field('gshow')->where('gid',$id)->find();
			if($info['gshow'] == 1){
				$data['gshow'] = 0;
			}else{
				$data['gshow'] = 1;
			}
			$data['gid'] = $id;
			$result = Db::name('guidance')->update($data);
			if($result>0){
				exit(json_encode(array('state'=>'success','show'=>$data['gshow'])));
			}else{
				exit(json_encode(array('state'=>'error','show'=>$data['gshow'])));
			}
		}
	}
	//删除
	public function guidancedel(){
		$id = input('id');
    	if(!$id){
    		return WPreturn('参数错误',-1);
    	}
    	$gavatar = db('guidance')->field('gavatar')->where('gid',$id)->find();
		if(!empty($gavatar['gavatar'])){
			$url = ROOT_PATH.'public'.DS.'uploads/'.$gavatar['gavatar'];
			if(file_exists($url)){
	            @unlink($url);
	        }
		}
    	$result = Db::name('guidance')->delete($id);
    	if($result){
    		return WPreturn('删除成功',1);
    	}else{
    		return WPreturn('删除失败',-1);
    	}
	}

	public function articlelist(){
		$pagenum = cache('page');
		$getdata = $where = array();
		$data = input('get.');
		//栏目编号、栏目标题
		if(isset($data['title']) && !empty($data['title'])){
			$where['id|gtitle'] = array('like','%'.$data['title'].'%');
			$getdata['title'] = $data['title'];
		}
		// var_dump($data);exit;
		if(isset($data['gname']) && $data['gname']>0){
			$where['a.gid'] = intval($data['gname']);
			$getdata['gid'] = intval($data['gname']);
		}else{
			$getdata['gid'] = 0;
		}

		if(isset($data['starttime']) && !empty($data['starttime'])){
			if(!isset($data['endtime']) || empty($data['endtime'])){
				$data['endtime'] = date('Y-m-d H:i:s',time());
			}
			$where['g_time'] = array('between time',array($data['starttime'],$data['endtime']));
			$getdata['starttime'] = $data['starttime'];
			$getdata['endtime'] = $data['endtime'];
		}
		$guidancelist = db('guidance')->field('gid,gname')->where('gshow',1)->order('gtop desc,gid desc')->select();

		$articlelist = db('garticle')
						->alias('a')
						->field('a.*,g.gname')
						->join('__GUIDANCE__ g','a.gid=g.gid')
						->where($where)
						->order('a.g_top desc,a.id desc')
						->paginate($pagenum,false,['query'=> $getdata]);
        $this->assign('articlelist',$articlelist);
        $this->assign('guidancelist',$guidancelist);
        $this->assign('getdata',$getdata);
		return $this->fetch();
	}

	/**
	 * 添加栏目
	 * @author lukui  2017-02-15
	 * @return [type] [description]
	 */
	public function articleadd()
	{
		if(input('post.')){
			$data = input('post.');
			$data['g_time'] = time();
			//添加栏目
			if($data['act'] == 'add'){
				if(!$data['gtitle']){
					return $this->error('请输入文章标题',url('guidance/articleadd'));exit;
				}
				if(empty($data['gname'])){
					return $this->error('请选择名师',url('guidance/articleadd'));exit;
				}else{
					$data['gid'] = $data['gname'];
					unset($data['gname']);
				}
				$data['gcontent'] = htmlspecialchars($data['content']);
				unset($data['content']);
				unset($data['act']);
				$addid = Db::name('garticle')->insertGetId($data);
				if($addid>0){
					$this->redirect('guidance/articlelist');
				}else{
					return $this->error('文章添加错误',url('guidance/articleadd'));exit;
				}
			}
			//修改栏目
			if(!empty($data['id'])){
				if(!$data['gtitle']){
					return $this->error('请输入文章标题',url('guidance/articleadd',array('id'=>$data['id'])));exit;
				}
				if(empty($data['gname'])){
					return $this->error('请选择名师',url('guidance/articleadd',array('id'=>$data['id'])));exit;
				}else{
					$data['gid'] = $data['gname'];
					unset($data['gname']);
				}
				$data['gcontent'] = htmlspecialchars($data['content']);
				unset($data['content']);
				unset($data['act']);
				$addid = Db::name('garticle')->update($data);
				if($addid>0){
					$this->redirect('guidance/articlelist');
				}else{
					return $this->error('文章修改错误',url('guidance/aboutadd',array('id'=>$data['id'])));exit;
				}
			}
		}else{
			$id = input('id');
			//编辑显示页
			if($id){
				$result = db('garticle')->where('id',$id)->find();
				$FCKeditor = create_html_editor('content',$result['gcontent']);
				$this->assign('result',$result);
				$this->assign('act','edit');
			}else{
			//添加显示页
				$FCKeditor = create_html_editor('content');
				$this->assign('result','');
				$this->assign('act','add');
			}
			$guidancelist = db('guidance')->field('gid,gname')->where('gshow',1)->order('gtop desc,gid desc')->select();
			$this->assign('guidancelist',$guidancelist);
			$this->assign('FCKeditor',$FCKeditor);
			return $this->fetch();
		}
	}


	//置顶
	public function articlegtop(){
		$id = input('id');
		if(intval($id)){
			$info = db('garticle')->field('g_top')->where('id',$id)->find();
			if($info['g_top'] > 1){
				$data['g_top'] = 0;
			}else{
				$data['g_top'] = time();
			}
			$data['id'] = $id;
			$result = Db::name('garticle')->update($data);
			if($result>0){
				exit(json_encode(array('state'=>'success','gtop'=>$data['g_top'])));
			}else{
				exit(json_encode(array('state'=>'error','gtop'=>$data['g_top'])));
			}
		}
	}

	//修改显示
	public function articleshow(){
		$id = input('id');
		if(intval($id)){
			$info = db('garticle')->field('g_show')->where('id',$id)->find();
			if($info['g_show'] == 1){
				$data['g_show'] = 0;
			}else{
				$data['g_show'] = 1;
			}
			$data['id'] = $id;
			$result = Db::name('garticle')->update($data);
			if($result>0){
				exit(json_encode(array('state'=>'success','show'=>$data['g_show'])));
			}else{
				exit(json_encode(array('state'=>'error','show'=>$data['g_show'])));
			}
		}
	}

	public function articledel(){
		$id = input('id');
    	if(!$id){
    		return WPreturn('参数错误',-1);
    	}
    	$result = Db::name('garticle')->delete($id);
    	if($result){
    		return WPreturn('删除成功',1);
    	}else{
    		return WPreturn('删除失败',-1);
    	}
	}
}
