<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Cookie;

class Operation extends Controller
{
	public function operation()
	{
		$operalist = db('operation')->field('oid,oname')->order('osort desc, oid desc')->select();
		$this->assign('operalist',$operalist);
		return $this->fetch();
	}
	public function operationinfo()
	{
		$oid = input('id');
		if(intval($oid)){
			$operainfo = db('operation_info')->where('oid',$oid)->field('*')->order('id asc')->select();
			$oname = db('operation')->where('oid',$oid)->field('oname')->find();
			if(empty($operainfo)){
				$this->redirect('operation');
			}else{
				foreach ($operainfo as $k => $v) {
					$operainfo[$k]['picture'] = '/public/uploads/'.$v['picture'];
					$operainfo[$k]['num'] = $k+1;
				}
			}
		}
		$this->assign('oname',$oname['oname']);
		$this->assign('operainfo',$operainfo);
		return $this->fetch();
	}
}
