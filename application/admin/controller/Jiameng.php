<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class Jiameng extends Base
{
    /**
	 * 关于我们列表
	 * @author lukui  2017-02-15
	 * @return [type] [description]
	 */
	public function jiamenglist()
	{
		$pagenum = cache('page');
		$getdata = $where = array();
		$data = input('get.');
		if(isset($data['personal']) && !empty($data['personal'])){
			if($data['personal'] == '1'){
				$personal = '0';
			}
			if($data['personal'] == '2'){
				$personal = '1';
			}
			$where['personal'] = $personal;
			$getdata['personal'] = $data['personal'];
		}
		//栏目编号、栏目标题
		if(isset($data['name']) && !empty($data['name'])){
			$where['id|phone|company|legal|regnumber'] = array('like','%'.$data['name'].'%');
			$getdata['name'] = $data['name'];
		}
		if(isset($data['starttime']) && !empty($data['starttime'])){
			if(!isset($data['endtime']) || empty($data['endtime'])){
				$data['endtime'] = date('Y-m-d H:i:s',time());
			}
			$where['time'] = array('between time',array($data['starttime'],$data['endtime']));
			$getdata['starttime'] = $data['starttime'];
			$getdata['endtime'] = $data['endtime'];
		}
		$allylist = Db::name('ally')->where($where)->order('time desc,id desc')->paginate($pagenum,false,['query'=> $getdata]);
        $this->assign('allylist',$allylist);
        $this->assign('getdata',$getdata);
		return $this->fetch();
	}

	//删除
	public function jiamengdel(){
		$id = input('id');
    	if(!$id){
    		return WPreturn('参数错误',-1);
    	}
    	$result = Db::name('ally')->delete($id);
    	if($result){
    		return WPreturn('删除成功',1);
    	}else{
    		return WPreturn('删除失败',-1);
    	}
	}
}
