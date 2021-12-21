<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Goods extends Base
{

	/**
	 * 产品列表
	 * @author lukui  2017-02-15
	 * @return [type] [description]
	 */
	public function prolist()
	{
		$proinfo = Db::name('productinfo')->alias('pi')->field('pi.*,pc.pcname')
                    ->join('__PRODUCTCLASS__ pc','pc.pcid = pi.cid')
                    ->where('pi.isdelete',0)->order('pi.proorder asc')->select();

        $this->assign('proinfo',$proinfo);
		return $this->fetch();
	}

	public function curslist(){
	    $name = input('name');
	    if(isset($name) && !empty($name)){

            $list = Db::name('currency')->where(['name'=>['like','%'.$name.'%']])->order('id asc')->select();
        }else{
            $list = Db::name('currency')->order('id asc')->select();
        }
        $this->assign('name',$name);
        $this->assign('list',$list);
        return $this->fetch();
    }
    public function cursadd()
    {
        if(input('post.')){
            $data = input('post.');


            if(!$data['name'] || !$data['huilv'] ){
                return WPreturn('参数错误',-1);
            }



            if(isset($data['id']) && !empty($data['id']) && $data['id'] != 0){
                //编辑

                $editid = Db::name('currency')->update($data);


                if($editid){

                    return WPreturn('修改成功',1);
                }else{
                    return WPreturn('修改失败',-1);
                }
            }else{  //新添加


                $addid = Db::name('currency')->insertGetId($data);
                if($addid){

                    return WPreturn('添加成功',1);
                }else{
                    return WPreturn('添加失败',-1);
                }
            }

        }else{
            if(input('param.id')){  //编辑产品

                $pid = input('param.id');
                $productinfo = Db::name('currency')->where('id',$pid)->find();
                $this->assign($productinfo);


            }

            return $this->fetch();


        }

    }

	/**
	 * 添加产品
	 * @author lukui  2017-02-15
	 * @return [type] [description]
	 */
	public function proadd()
	{
		if(input('post.')){
			$data = input('post.');

            //修改开市时间
            $opentime_arr = $data['opentime'];
            $opentime_str = '';
            foreach ($opentime_arr as $k => $v) {
                $opentime_str .= trim($v).'-';
            }
            $opentime['opentime'] = $opentime_str;
            $_otime = db('opentime')->where('pid',$data['pid'])->find();
            if($_otime){
                db('opentime')->where('pid',$data['pid'])->update($opentime);
            }

            unset($data['opentime']);

            
			if(!$data['ptitle'] || !$data['cid'] ){
				return WPreturn('参数错误',-1);
			}
			$data['time'] = time();
			$data['isdelete'] = 0;

			
			if(isset($data['pid']) && !empty($data['pid']) && $data['pid'] != 0){
			    //编辑
                unset($data['ptitle']);
				$editid = Db::name('productinfo')->update($data);
				
			
                if($editid){
                    
                    return WPreturn('修改成功',1);
                }else{
                    return WPreturn('修改失败',-1);
                }
			}else{  //新添加



				$addid = Db::name('productinfo')->insertGetId($data);
                if($addid){
                    if($data['is_fb']==1){
                        $mintime = strtotime(date('Y-m-d H:i',time()));
        				$daytime = strtotime(date('Y-m-d',time()));
        				if($data['price']){
        					$fbdata['type'] = $data['procode'];
        					$fbdata['price'] = $data['price'];
        					$fbdata['createtime']= time();
        					$fbdata['mintime'] = $mintime;
        					$fbdata['daytime'] = $daytime;
        					db('msg')->insert($fbdata);
        				}
                    }
                    	
                    
                    

                    $p_data['pid'] = $addid;
                    Db::name('productdata')->insert($p_data);

                    $add_data['opentime'] = $opentime_str;
                    $add_data['pid'] = $addid;
                    db('opentime')->insert($add_data);


                    //蒙庚宇用于进行资产表的新添加

                    $zhs=Db::table("wp_userinfo")->field("uid")->select();
                    $bome = explode("/",$data['ptitle']);
                    //1.币币，2.合约，3.法币，4.秒合约
                    $qblx=array(1,2,4);
                     foreach($zhs as $v){
                         if($v['uid']!=1){
                             foreach($qblx as $v2){
                                 foreach($bome as $v3){
                                     
                                     if($v3=="USDT"){
                                         $qb = Db::table("wp_zc")->where("yh = '".$v['uid']."' and cp = '".$v3."' and qb = '".$v2."'")->find();
                                         if(empty($qb)){
                                             $dt=array(
                                                 'yh'=>$v['uid'],
                                                 'qb'=>$v2,
                                                 'cp'=>$v3,
                                             );
                                             Db::table("wp_zc")->insert($dt);
                                         }
                                     }
                                     elseif(in_array($v3,array('BTC','ETH'))){
                                         if($v2!=4){
                                             $qb = Db::table("wp_zc")->where("yh = '".$v['uid']."' and cp = '".$v3."' and qb = '".$v2."'")->find();
                                             if(empty($qb)){
                                                 $dt=array(
                                                     'yh'=>$v['uid'],
                                                     'qb'=>$v2,
                                                     'cp'=>$v3,
                                                 );
                                                 Db::table("wp_zc")->insert($dt);
                                             }
        
                                         }
                                     }

                                     else{
                                         if(in_array($v2,array(1,3))){
                                             $qb = Db::table("wp_zc")->where("yh = '".$v['uid']."' and cp = '".$v3."' and qb = '".$v2."'")->find();
                                             if(empty($qb)){
                                                 $dt=array(
                                                     'yh'=>$v['uid'],
                                                     'qb'=>$v2,
                                                     'cp'=>$v3,
                                                 );
                                                 Db::table("wp_zc")->insert($dt);
                                             }
                                         }
                                     }
                                 }
        
                             }
                         }
                     }


                    

                    return WPreturn('添加成功',1);
                }else{
                    return WPreturn('添加失败',-1);
                }
			}

		}else{
			if(input('param.pid')){  //编辑产品

                $pid = input('param.pid');
                $productinfo = Db::name('productinfo')->where('pid',$pid)->find();
                $this->assign($productinfo);

                $opentime = db('opentime')->where('pid',$pid)->find();
                if($opentime){
                    $otime_arr = explode('-',$opentime["opentime"]);
                }else{
                    $otime_arr = array('','','','','','','');
                }
                
                $this->assign('opentime',$otime_arr);

            }
            
            
			//分类
			$proclass = Db::name('productclass')->where('isdelete',0)->order('pcid desc')->select();
            $this->assign('proclass',$proclass);
			return $this->fetch();


		}
		
	}

	/**
	 * 产品开、休市
	 * @author lukui  2017-02-15
	 * @return [type] [description]
	 */
	public function proisopen()
	{
		
		if (input('post.')) {
			$data = input('post.');
			$editid = Db::name('productinfo')->update($data);
            if($editid){
                return WPreturn('修改成功',1);
            }else{
                return WPreturn('修改失败',-1);
            }
		}else{
			return WPreturn('参数错误',-1);
		}
	}

	/**
	 * 删除产品
	 * @author lukui  2017-02-15
	 * @return [type] [description]
	 */
	public function delpro()
	{
		$id = input('get.id',0);
    	if(!$id){
    		return WPreturn('参数错误',-1);
    	}

    	$delpro = Db::name('productinfo')->where('pid', $id)->update(['isdelete' => 1]);
    	if($delpro){
            $p_data['isdelete'] = 1;
            Db::name('productdata')->where('pid', $id)->update($p_data);
    		return WPreturn('删除成功',1);
    	}else{
    		return WPreturn('删除失败',-1);
    	}
	}

    /**
     * 还原产品
     * @author lukui  2017-02-15
     * @return [type] [description]
     */
    public function hypro()
    {
        $id = input('get.id',0);
        if(!$id){
            return WPreturn('参数错误',-1);
        }

        $delpro = Db::name('productinfo')->where('pid', $id)->update(['isdelete' => 0]);
        if($delpro){
            $p_data['isdelete'] = 0;
            Db::name('productdata')->where('pid', $id)->update($p_data);
            return WPreturn('还原成功',1);
        }else{
            return WPreturn('还原失败',-1);
        }
    }




	/**
	 * 产品分类
	 * @author lukui  2017-02-15
	 * @return [type] [description]
	 */
	public function proclass()
	{
		$productclass = Db::name('productclass')->where('isdelete',0)->order('pcid desc')->select();
    	$this->assign('productclass',$productclass);
		return $this->fetch();
	}

	/**
	 * 编辑、添加产品分类
	 * @author lukui  2017-02-15
	 * @return [type] [description]
	 */
	public function editclass()
	{
		$data['pcid'] = input('post.pcid',0);
        $data['pcname'] = input('post.pcname',0);
        $data['isdelete'] = 0;
        if(!$data['pcname']){
            return WPreturn('参数错误',-1);
        }

        if($data['pcid']){ //有id 编辑信息
            $editnews = Db::name('productclass')->where('pcid', $data['pcid'])->update(array('pcname' => $data['pcname']));
            if($editnews){

                return WPreturn('修改成功',1);
            }else{
                return WPreturn('修改失败',-1);
            }
        }else{ //没di 增加一条
            $addid = Db::name('productclass')->insert($data);
            if($addid){
                return WPreturn('添加成功',1);
            }else{
                return WPreturn('添加失败',-1);
            }
        }
	}

	/**
     * 删除分类
     * @author lukui  2017-02-15
     * @return [type] [description]
     */
    public function deleteclass()
    {
    	$id = input('get.id',0);
    	if(!$id){
    		return WPreturn('参数错误',-1);
    	}

    	$delpro = Db::name('productclass')->where('pcid', $id)->update(['isdelete' => 1]);
    	if($delpro){
    		return WPreturn('删除成功',1);
    	}else{
    		return WPreturn('删除失败',-1);
    	}
    	
    }

    /**
     * 风控管理
     * @author lukui  2017-02-15
     * @return [type] [description]
     */
    public function risk()
    {
    	
    	$risk = Db::name('risk')->find();
    	$this->assign($risk);
    	return $this->fetch();
    }


    public function addrisk()
    {
        
        $post = input('post.');
        
        
        if (!$post) {
            $this->error('禁止访问');
        }

        if(empty($post['id'])){
            unset($post['id']);
            $ids = db('risk')->insert($post);
        }else{
            $ids = db('risk')->update($post);
        }

        if($ids){
            return WPreturn('操作成功',1);
        }else{
            return WPreturn('操作失败',-1);
        }

    }


    /**
     * 排序
     * @author lukui  2017-08-27
     * @return [type] [description]
     */
    public function proorder()
    {
        
        $post = input('post.');
        if(!isset($post["proorder"])){
            $this->error('参数错误！');
        }
        $proorder = $post["proorder"];
        $productinfo = db('productinfo');
        foreach ($proorder as $k => $v) {
            $_dara['pid'] = $k;
            $_dara['proorder'] = (int)trim($v);
            $productinfo->update($_dara);
            
        }

        $this->success('操作成功！');
        
    }

    public function huishou()
    {
        

        $proinfo = Db::name('productinfo')->alias('pi')->field('pi.*,pc.pcname')
                    ->join('__PRODUCTCLASS__ pc','pc.pcid = pi.cid')
                    ->where('pi.isdelete',1)->order('pi.pid asc')->select();

        $this->assign('proinfo',$proinfo);
        return $this->fetch();
    }





}
