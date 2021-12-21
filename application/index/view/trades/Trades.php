<?php
namespace app\index\controller;
use think\Db;
use think\Cookie;



class Trades extends Base
{
	/**
	 * 首页 行情列表
	 * @author lukui  2017-02-18
	 * @return [type] [description]
	 */
    public function index()
    {
        if(!input('token')){
            $this->redirect('trades/index?token='.$this->token);
        }

        $proclass = db('productclass')->where('isdelete',0)->order('pcid asc')->select();

        //获取产品信息
        $pro = Db::name('productinfo')->alias('pi')->field('pi.pid,pi.ptitle,pd.Price,pd.UpdateTime,pd.Low,pd.High')
        		->join('__PRODUCTDATA__ pd','pd.pid=pi.pid')
        		->where('pi.isdelete',0)->order('pi.proorder asc')->select();
        //dump(cookie('pid7'));
		
		
		foreach($pro as $key=>$value){
			$pro[$key]['isopen'] = ChickIsOpen($value['pid']);
		}
        $this->assign('pro',$pro);
		$this->assign('proclass',$proclass);
		$gonggao = Db::name('config')->where('id',26)->find();
		$this->assign('gonggao',$gonggao);
		
        return $this->fetch();
		
    }

    public function index_heyue()
    {
        if(!input('token')){
            $this->redirect('trades/index_heyue?token='.$this->token);
        }

        $proclass = db('productclass')->where('isdelete',0)->order('pcid asc')->select();

        //获取产品信息
        $pro = Db::name('productinfo')->alias('pi')->field('pi.pid,pi.ptitle,pd.Price,pd.UpdateTime,pd.Low,pd.High')
            ->join('__PRODUCTDATA__ pd','pd.pid=pi.pid')
            ->where('pi.isdelete',0)->order('pi.proorder asc')->select();
        //dump(cookie('pid7'));


        foreach($pro as $key=>$value){
            $pro[$key]['isopen'] = ChickIsOpen($value['pid']);
        }
        $this->assign('pro',$pro);
        $this->assign('proclass',$proclass);
        $gonggao = Db::name('config')->where('id',26)->find();
        $this->assign('gonggao',$gonggao);

        return $this->fetch();

    }

    public function ajaxindexpro()
    {
    	
    	//获取产品信息
        $pro = Db::name('productinfo')->alias('pi')->field('pi.pid,pi.ptitle,pd.Price,pd.UpdateTime,pd.Low,pd.High')
        		->join('__PRODUCTDATA__ pd','pd.pid=pi.pid')
        		->where('pi.isdelete',0)->order('pi.pid desc')->select();
        $newpro = array();
        foreach ($pro as $k => $v) {
        	$newpro[$v['pid']] = $pro[$k];
        	$newpro[$v['pid']]['UpdateTime'] = date('H:i:s',$v['UpdateTime']);
        	
        	
            // if(!isset($_COOKIE['pid'.$v['pid']])){
            //     cookie('pid'.$v['pid'],$v['Price']);
            //     continue;
            // }
        	if($v['Price'] < cookie('pid'.$v['pid']) ){  //跌了
        		$newpro[$v['pid']]['isup'] = 0;
        	}elseif($v['Price'] > cookie('pid'.$v['pid']) ){  //涨了
        		$newpro[$v['pid']]['isup'] = 1;
        	}else{  //没跌没涨
        		$newpro[$v['pid']]['isup'] = 2;
        	}
            
        	cookie('pid'.$v['pid'],$v['Price']);

        }

        return base64_encode(json_encode($newpro));
    }
	
	
	

    public function getchart()
    {
        $data['index'] = '首页';
        $data['hangqing'] = '实时数据';
        $data['jiaoyijilu'] = '交易记录';
        $data['shangpinmingcheng'] = '名称';
        $data['xianjia'] = '现价';
        $data['zuidi'] = '最低';
        $data['zuigao'] = '最高';
        $data['xianjia'] = '现价';
        $data['xianjia'] = '现价';

        
        $res = base64_encode(json_encode($data));
        return $res;
    }

    public function ajaxclass(){
        $id = input('int');
        if($id>0){
            $map = array(
                'pi.isdelete'=>0,
                'pi.cid'=>$id
            );
        }else{
            $map = array(
                'pi.isdelete'=>0
            );
        }
        $pro = Db::name('productinfo')->alias('pi')->field('pi.pid,pi.ptitle,pd.Price,pd.UpdateTime,pd.Low,pd.High')
            ->join('__PRODUCTDATA__ pd','pd.pid=pi.pid')
            ->where($map)->order('pi.proorder asc')->select();
        $html = '';
        $url = '';
        foreach ($pro as $k => $v) {
            $url = '/index/goods/goods/pid/'.$v['pid'].'/token/'.$this->token.'.html';
            $html .= '<ul onClick="parent.location=\''.$url.'\'" id="pid'.$v['pid'].'">';
            $html .= '<li><a href="javascript:;" class="ng-binding">'.$v['ptitle'].'</a></li>';
            $html .= '<li><a  href="javascript:;" class="ng-binding rise-value now-value">'.$v['Price'].'</a></li>';
            $html .= '<li><a href="javascript:;" class="ng-binding rise rise-low">'.$v['Low'].'</a></li>';
            $html .= '<li><a href="javascript:;" class="ng-binding rise rise-high">'.$v['High'].'</a></li>';
            $html .= '</ul>';
        }
        exit(json_encode($html));
    }

}
