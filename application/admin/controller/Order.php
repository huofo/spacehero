<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;

class Order extends Base
{
    /**
     * 产品订单列表
     * @author lukui  2017-02-15
     * @return [type] [description]
     */
    public function orderlist()
    {
        $pagenum = cache('page');
        $data = input('get.');

        //验证搜索数据
        $res = $this->ecickdata($data);
        $where = $res['where'];
        $getdata = $res['getdata'];
        //权限检测
        if($this->otype != 3){

            $uids = myuids($this->uid);
            if(!empty($uids)){
                $where['u.uid'] = array('IN',$uids);
            }
        }

        $where['o.is_timing'] = 0;

        $order = Db::name('order')->alias('o')->field('o.*,u.username,u.nickname,u.oid as uoid,u.managername')
            ->join('__USERINFO__ u','o.uid=u.uid')
            ->where($where)->order('oid desc')->paginate($pagenum,false,['query'=> $getdata]);
        //产品
        $pro = Db::name('productinfo')->field('pid,ptitle')->where('isdelete',0)->select();
        //没有数据

        if($order->total() == 0){

            $this->assign('noorder',1);
        }
        $daojishiid='';
        $orderlist = $order->items();
        foreach($orderlist as $key => $val)
        {

            if($val['ostaus']=='0')$daojishiid .=$val['oid'].',';

            $orderlist[$key]['fee'] = $val['fee'];

            $procode= db("productinfo")->where(array('pid'=>$val['pid']))->value('procode');
            if(file_exists("runtime/get/fengkong".$procode.".php"))
            {
                $orderlist[$key]['canlapan'] =1;
            }else
            {
                $orderlist[$key]['canlapan'] = 0;
            }

        }

        $uid = $this->uid;
        $this->assign('daojishiid',$daojishiid);
        $this->assign('myuid',$uid);
        $this->assign('orderlist',$orderlist);
        $this->assign('pro',$pro);
        $this->assign('order',$order);
        $this->assign('getdata',$getdata);
        $getdata['display'] = 0;
        $this->assign('jsongetdata',http_build_query($getdata));
        return $this->fetch();
    }


    public function orderlist_lever()
    {
        $pagenum = cache('page');
        $data = input('get.');

        //验证搜索数据
        $res = $this->ecickdata($data);
        $where = $res['where'];
        $getdata = $res['getdata'];
        //权限检测
        if($this->otype != 3){

            $uids = myuids($this->uid);
            if(!empty($uids)){
                $where['u.uid'] = array('IN',$uids);
            }
        }

        $where['o.is_timing'] = 1;

        $order = Db::name('order')->alias('o')->field('o.*,u.username,u.nickname,u.oid as uoid,u.managername')
            ->join('__USERINFO__ u','o.uid=u.uid')
            ->where($where)->order('oid desc')->paginate($pagenum,false,['query'=> $getdata]);
        //产品
        $pro = Db::name('productinfo')->field('pid,ptitle')->where('isdelete',0)->select();
        //没有数据

        if($order->total() == 0){

            $this->assign('noorder',1);
        }
        $daojishiid='';
        $orderlist = $order->items();
        foreach($orderlist as $key => $val)
        {


            if($val['ostaus']=='0')$daojishiid .=$val['oid'].',';


            $orderlist[$key]['fee'] = $val['fee'];






            $procode= db("productinfo")->where(array('pid'=>$val['pid']))->value('procode');
            if(file_exists("runtime/get/fengkong".$procode.".php"))
            {
                $orderlist[$key]['canlapan'] =1;
            }else
            {
                $orderlist[$key]['canlapan'] = 0;
            }

        }

        $uid = $this->uid;
        $this->assign('daojishiid',$daojishiid);
        $this->assign('myuid',$uid);
        $this->assign('orderlist',$orderlist);
        $this->assign('pro',$pro);
        $this->assign('order',$order);
        $this->assign('getdata',$getdata);
        $getdata['display'] = 0;
        $this->assign('jsongetdata',http_build_query($getdata));
        return $this->fetch();
    }


    //法币 上架 订单
    public function orderlist_shevles()
    {
        $pagenum = cache('page');
        $data = input('get.');

        //验证搜索数据
        $res = $this->searchdatas($data);
        $where = $res['where'];
        $getdata = $res['getdata'];
        //权限检测
        if($this->otype != 3){

            $uids = myuids($this->uid);
            if(!empty($uids)){
                $where['u.uid'] = array('IN',$uids);
            }
        }



        $order = Db::name('currency_shevles_order')->alias('o')->field('o.*,u.username,u.nickname,u.oid as uoid,u.managername')
            ->join('__USERINFO__ u','o.user_id=u.uid')
            ->where($where)->order('id desc')->paginate($pagenum,false,['query'=> $getdata]);
        //产品
        $pro = Db::name('productinfo')->field('pid,ptitle')->where('isdelete',0)->select();
        foreach ($pro as $k=>$v){
            $name = explode('/',$v['ptitle']);
            $pro[$k]['name'] = $name[0];
        }
        //没有数据
        $usdt = array(
            'pid'=>0,
            'name'=>'USDT',
        );
        $agc = array(
            'pid'=>1,
            'name'=>'AGC',
        );
        array_unshift($pro,$usdt,$agc);


        //法币币种
        $cur = Db::name('currency')->field('id,name')->select();
        if($order->total() == 0){

            $this->assign('noorder',1);
        }
        $daojishiid='';
        $orderlist = $order->items();
        foreach($orderlist as $key => $val)
        {
            $orderlist[$key]['one_price'] = $val['s_price'] * $val['c_exc_rate'];

            $orderlist[$key]['all_price'] = $val['t_num'] * $val['s_price'] * $val['c_exc_rate'];
        }

        $uid = $this->uid;
        $this->assign('daojishiid',$daojishiid);
        $this->assign('myuid',$uid);
        $this->assign('orderlist',$orderlist);
        $this->assign('pro',$pro);
        $this->assign('cur',$cur);
        $this->assign('order',$order);
        $this->assign('getdata',$getdata);
        $getdata['display'] = 0;
        $this->assign('jsongetdata',http_build_query($getdata));
        return $this->fetch();
    }
    //法币 撮合 订单
    public function orderlist_trade()
    {
        $pagenum = cache('page');
        $data = input('get.');

        //验证搜索数据
        $res = $this->searchdata($data);
        $where = $res['where'];
        $getdata = $res['getdata'];
        //权限检测
        if($this->otype != 3){

            $uids = myuids($this->uid);
            if(!empty($uids)){
                $where['u.uid'] = array('IN',$uids);
            }
        }

        //$where['o.is_timing'] = 1;

        $order = Db::name('currency_trade_order')->alias('o')->field('o.*,u.username,u.nickname,u.oid as uoid,u.managername,so.order_sn as old_order_sn,so.user_id as old_uid')
            ->join('__USERINFO__ u','o.user_id=u.uid','LEFT')
            ->join('currency_shevles_order so','so.id=o.oid','LEFT')
            ->where($where)->order('id desc')->paginate($pagenum,false,['query'=> $getdata]);
        //产品
        $pro = Db::name('productinfo')->field('pid,ptitle')->where('isdelete',0)->select();
        foreach ($pro as $k=>$v){
            $name = explode('/',$v['ptitle']);
            $pro[$k]['name'] = $name[0];
        }
        //没有数据
        $usdt = array(
            'pid'=>0,
            'name'=>'USDT',
        );
        $agc = array(
            'pid'=>1,
            'name'=>'AGC',
        );
        array_unshift($pro,$usdt,$agc);


        //法币币种
        $cur = Db::name('currency')->field('id,name')->select();
        if($order->total() == 0){

            $this->assign('noorder',1);
        }
        $daojishiid='';
        $orderlist = $order->items();
        //var_dump($orderlist[0]);die;
        foreach($orderlist as $key => $val)
        {
            $orderlist[$key]['one_price'] = $val['s_price'] * $val['c_exc_rate'];

            $orderlist[$key]['all_price'] = $val['t_num'] * $val['s_price'] * $val['c_exc_rate'];
            $oldusernick = Db('userinfo')->where('uid',$val['old_uid'])->value('nickname');
            $orderlist[$key]['old_username'] = $oldusernick?$oldusernick:$val['old_uid'];
        }

        $uid = $this->uid;
        $this->assign('daojishiid',$daojishiid);
        $this->assign('myuid',$uid);
        $this->assign('orderlist',$orderlist);
        $this->assign('pro',$pro);
        $this->assign('cur',$cur);
        $this->assign('order',$order);
        $this->assign('getdata',$getdata);
        $getdata['display'] = 0;
        $this->assign('jsongetdata',http_build_query($getdata));
        return $this->fetch();
    }


    public function jujue_torder(){
        $oid = input('id');
        $order = db('currency_trade_order')->where('id',$oid)->find();

        if($order['status'] == 1&&$order['trade_type'] == 0){
            $res = db('currency_trade_order')->where('id',$oid)->update(['status'=>6]);
            if($res){

                if($order['api_order_sn']) {
                    $params = array('status' => 1, 'customerid' => $order['customerid'], 'sdpayno' => $order['order_sn'], 'sdorderno' => $order['api_order_sn'], 'total_fee' => $order['t_num'], 'paytype' => $order['pay_id'],'if_off' => 1);

                    $http = new \http\Http($order['notifyurl'], $this->saltData($params));
                    $http->toUrl();

                    $resCode = $http->getResCode();
                    $resContent = substr(str_replace(' ', '', strip_tags($http->getResContent())), 0, 50);

                    $resContent = $this->removeBom($resContent);

                    $errInfo = $http->getErrInfo();
                    
                    
                    
                }

                echo json_encode(['data'=>'操作成功','type'=>1]);die;
            }else{
                echo json_encode(['data'=>'操作失败','type'=>0]);die;
            }
        }else{
            echo json_encode(['data'=>'非法操作','type'=>0]);die;
        }


    }

    /*通过订单*/
    public function pass_torder(){
        $id = input('id');
        $order = Db('currency_trade_order')->where('id',$id)->find();
        if($order['status'] != 2){
            //购买
            if($order['trade_type'] == 0){
                $res =  Db::name('currency_trade_order')->where(['id'=>$id])->update(['status'=>2,'update_time'=>time()]);
                //上分
                if($res){
                    if(!$order['api_order_sn']){
                        //站内

                        $buyer_type = Db('userinfo')->where('uid',$order['user_id'])->value('user_type');
                        $shevles_order =  Db::name('currency_shevles_order')->where(['id'=>$order['oid']])->field('id,user_id,isnotdone_num')->find();
                        $seller_type = Db('userinfo')->where('uid',$shevles_order['user_id'])->value('user_type');

                        //减卖家冻结
                        log_account_change($shevles_order['user_id'],3,$order['symbol'],0,-1*$order['t_num'],'法币出售完成',0);

                        if($buyer_type == 0 && $seller_type == 1 && $order['symbol'] == 'AGC'){
                            $ka_fee = getconf('ka_fee');
                            $jiangli = $order['t_num'] * floatval($ka_fee)/100;
                            $order['t_num']  = $order['t_num']  + ($order['t_num'] * floatval($ka_fee)/100);
                            //卡商推荐人获得奖励
                            $parent_id = Db('userinfo')->where('uid',$order['user_id'])->value('parent_id');
                            if($parent_id){
                                $ka_father_fee = getconf('ka_father_fee');
                                $father_num = $jiangli * (floatval($ka_father_fee)/100);
                                if($father_num){
                                    log_account_change($parent_id,3,$order['symbol'],$father_num,0,\think\Lang::get('fbjy_parent_gain'),0);
                                }
                            }
                        }
                        //为买家增加 币的余额
                        log_account_change($order['user_id'],3,$order['symbol'],$order['t_num'],0,'通过法币交易获得',0);
                        echo json_encode(['data'=>'成功','type'=>1]);die;
                    }
                    else{
                        //站外充值订单
                        $params = array('status'=>2,'customerid' => $order['customerid'],'sdpayno' => $order['order_sn'],'sdorderno' => $order['api_order_sn'],'total_fee' => $order['t_num'],'paytype' => $order['pay_id'],'if_off' => 2);

                        $http = new \http\Http($order['notifyurl'], $this->saltData($params));
                        $http->toUrl();

                        $resCode = $http->getResCode();
                        $resContent = substr(str_replace(' ', '', strip_tags($http->getResContent())), 0, 50);

                        $resContent =$this->removeBom($resContent);


                        $errInfo = $http->getErrInfo();

                        if($resContent == 'success'){


                            $datass['is_notify'] = 1;
                            $datass['notify_state'] = 1;
                            Db('currency_trade_order')->where('id',$order['id'])->update($datass);


                        }else{

                            $datass['is_notify'] = 1;
                            $datass['notify_state'] = 2;
                            Db('currency_trade_order')->where('id',$order['id'])->update($datass);
                        }
                        //减卖家冻结


                        $shevles_order =  Db::name('currency_shevles_order')->where(['id'=>$order['oid']])->field('id,user_id,isnotdone_num')->find();

                        log_account_change($shevles_order['user_id'],3,$order['symbol'],0,-1*$order['t_num'],'通过法币交易卖出',0);
                        echo json_encode(['data'=>'成功！','type'=>1]);die;
                    }

                }


            }else{
                //出售
                if(!$order['api_order_sn']){
                    //站内
                    $seller_type= Db('userinfo')->where('uid',$order['user_id'])->value('user_type');
                    $shevles_order =  Db::name('currency_shevles_order')->where(['id'=>$order['oid']])->field('id,user_id,isnotdone_num')->find();
                    $buyer_type= Db('userinfo')->where('uid',$shevles_order['user_id'])->value('user_type');

                    //减卖家冻结
                    log_account_change($order['user_id'],3,$order['symbol'],0,-1*$order['t_num'],'法币出售完成',0);
                    //卡商承兑商交易奖励
                    if($buyer_type == 0 && $seller_type == 1 && $order['symbol'] == 'AGC'){
                        $ka_fee = getconf('ka_fee');
                        $jiangli = $order['t_num'] * floatval($ka_fee)/100;
                        $order['t_num']  = $order['t_num']  + ($order['t_num'] * floatval($ka_fee)/100);
                        //卡商推荐人获得奖励
                        $parent_id = Db('userinfo')->where('uid',$shevles_order['user_id'])->value('parent_id');
                        if($parent_id){
                            $ka_father_fee = getconf('ka_father_fee');
                            $father_num = $jiangli * (floatval($ka_father_fee)/100);
                            if($father_num){
                                log_account_change($parent_id,3,$order['symbol'],$father_num,0,\think\Lang::get('fbjy_parent_gain'),0);
                            }
                        }
                    }
                    //为买家增加 币的余额
                    log_account_change($shevles_order['user_id'],3,$order['symbol'],$order['t_num'],0,'通过法币交易获得',0);
                    echo json_encode(['data'=>'成功','type'=>1]);die;
                }else{
                    //站外提现订单
                }

            }
        }else{
            //补发通知
            if($order['trade_type'] == 0 && !empty($order['api_order_sn'])){
                $params = array('status'=>2,'customerid' => $order['customerid'],'sdpayno' => $order['order_sn'],'sdorderno' => $order['api_order_sn'],'total_fee' => $order['t_num'],'paytype' => $order['pay_id'],'if_off' => 2);

                    $http = new \http\Http($order['notifyurl'], $this->saltData($params));
                    $http->toUrl();

                    $resCode = $http->getResCode();
                    $resContent = substr(str_replace(' ', '', strip_tags($http->getResContent())), 0, 50);

                    $resContent =$this->removeBom($resContent);


                    $errInfo = $http->getErrInfo();

                    if($resContent == 'success'){


                        $datass['is_notify'] = 1;
                        $datass['notify_state'] = 1;
                        Db('currency_trade_order')->where('id',$order['id'])->update($datass);


                    }else{

                        $datass['is_notify'] = 1;
                        $datass['notify_state'] = 2;
                        Db('currency_trade_order')->where('id',$order['id'])->update($datass);
                    }
                    
                    echo json_encode(['data'=>'成功','type'=>1]);die;
            }   
        }
    }
    public function saltData($data)
    {
        $apikey = Db('customer')->where("id = '".$data['customerid']."'")->value('key');
        $signstr = 'customerid=' . $data['customerid'] . '&status=' . $data['status'] . '&sdpayno=' . $data['sdpayno'] . '&sdorderno=' . $data['sdorderno'] . '&total_fee=' . $data['total_fee'] . '&paytype=' . $data['paytype'] . '&' . $apikey;
        $data += array('sign' => md5($signstr));
        return $data;
    }
    public function removeBom($string)//去除BOM
    {
        if (substr($string, 0, 3) == pack("CCC", 0xef, 0xbb, 0xbf)) {
            return substr($string, 3);
        }
        return $string;
    }

    public function orderlist_bibi()
    {
        $pagenum = cache('page');
        $data = input('get.');


        //验证搜索数据
        $res = $this->ecickdata($data);
        $where = $res['where'];
        $getdata = $res['getdata'];
        //权限检测
        if($this->otype != 3){

            $uids = myuids($this->uid);
            if(!empty($uids)){
                $where['u.uid'] = array('IN',$uids);
            }
        }

        $where['o.is_timing'] = 2;

        $order = Db::name('order')->alias('o')->field('o.*,u.username,u.nickname,u.oid as uoid,u.managername')
            ->join('__USERINFO__ u','o.uid=u.uid')
            ->where($where)->order('oid desc')->paginate($pagenum,false,['query'=> $getdata]);
        //产品
        $pro = Db::name('productinfo')->field('pid,ptitle')->where('isdelete',0)->select();
        //没有数据

        if($order->total() == 0){

            $this->assign('noorder',1);
        }
        $daojishiid='';
        $orderlist = $order->items();
        foreach($orderlist as $key => $val)
        {


            if($val['ostaus']=='0')$daojishiid .=$val['oid'].',';


            $orderlist[$key]['fee'] = $val['fee'];






            $procode= db("productinfo")->where(array('pid'=>$val['pid']))->value('procode');
            if(file_exists("runtime/get/fengkong".$procode.".php"))
            {
                $orderlist[$key]['canlapan'] =1;
            }else
            {
                $orderlist[$key]['canlapan'] = 0;
            }

        }

        $uid = $this->uid;
        $this->assign('daojishiid',$daojishiid);
        $this->assign('myuid',$uid);
        $this->assign('orderlist',$orderlist);
        $this->assign('pro',$pro);
        $this->assign('order',$order);
        $this->assign('getdata',$getdata);
        $getdata['display'] = 0;
        $this->assign('jsongetdata',http_build_query($getdata));
        return $this->fetch();
    }


    public function getchance(){
        $uid = $_POST['id'];
        $info = db("userinfo")->where('uid',$uid)->find();
        $info = json_encode($info);
        echo $info;exit;
    }

    public function lapan(){
        $pid = $_POST['id'];

        $info = db("productinfo")->where('pid',$pid)->find();
        $fengkong= file_get_contents("runtime/get/fengkong".$info['procode'].".php");
        $info['fengkong']=$fengkong;

        if($info['decimal']>=0){
            //平仓价
            $fudian = 1/pow(10,abs($info['decimal']));

        }else{
            $fudian = pow(10,abs($info['decimal']));
        }


        $info['ptitle']=$info['ptitle'];
        $info = json_encode($info);
        echo $info;exit;
    }


    public function edit_lapan(){
        $pid = $_POST['pid'];
        $dianshu = $_POST['dianshu'];
        if(empty($pid)||empty($dianshu))
        {
            $ret = array('stute'=>2,'msg'=>'参数错误，请重新输入');
        }

        if(!is_numeric($dianshu))
        {
            $ret = array('stute'=>2,'msg'=>'参数错误，请输入数字！');
        }
        $info = db("productinfo")->where('pid',$pid)->find();


        $file = fopen("runtime/get/fengkong".$info['procode'].".php","w");
        $ok = fwrite($file,$dianshu);
        fclose($file);
        if($ok)
        {
            $ret = array('stute'=>1,'msg'=>"OK");
        }else
        {
            $ret = array('stute'=>2,'msg'=>"操作失败");
        }

        $ret = json_encode($ret);
        echo $ret;exit;
    }


    public function editchance(){
        if($this->otype==3)
        {
            $uid = $_POST['id'];
            $lv = $_POST['lv']?$_POST['lv']:'0';
            $lv = $lv>=100?'100':$lv;
            $lv = sprintf("%.0f",$lv);

            $income_range = $_POST['income_range']?$_POST['income_range']:'0,0';

            $garbage = strstr($income_range, ",");

            $incomearray = explode("," ,$income_range);
            if($garbage == true && $incomearray[0]>=0&& $incomearray[1]>=0)
            {
                // 数据库插入代码
                $thisdata['income_range']=$income_range;
                $thisdata['chance']=$lv;

                $ids = db('userinfo')->where('uid',$uid)->update($thisdata);
                $ret = array('stute'=>1,'msg'=>'修改成功');
                $ret = json_encode($ret);
                echo $ret;exit;
            }else
            {
                $ret = array('stute'=>0,'msg'=>'点差格式错误，请重新输入！');
                $ret = json_encode($ret);
                echo $ret;exit;
            }
        }elseif($this->otype==101)
        {
            if($this->channelfk==1)
            {
                $uid = $_POST['id'];

                if($uid!=$_SESSION['userid'])
                {


                    $lv = $_POST['lv']?$_POST['lv']:'0';
                    $lv = $lv>=100?'100':$lv;
                    $lv = sprintf("%.0f",$lv);
                    $income_range = $_POST['income_range']?$_POST['income_range']:'0,0';


                    $garbage = strstr($income_range, ",");

                    $incomearray = explode("," ,$income_range);
                    if($garbage == true && $incomearray[0]>=0&& $incomearray[1]>=0)
                    {
                        // 数据库插入代码

                        $thisdata['income_range']=$income_range;
                        $thisdata['chance']=$lv;
                        $ids = db('userinfo')->where('uid',$uid)->update($thisdata);
                        $ret = array('stute'=>1,'msg'=>'修改成功');
                        $ret = json_encode($ret);
                        echo $ret;exit;
                    }else
                    {
                        $ret = array('stute'=>0,'msg'=>'点差格式错误，请重新输入！');
                        $ret = json_encode($ret);
                        echo $ret;exit;
                    }
                }else
                {
                    $ret = array('stute'=>0,'msg'=>'您不能修改自己的合约点差！');
                    $ret = json_encode($ret);
                    echo $ret;exit;
                }


            }

        }





    }

    public function daojishi(){
        $id = $_POST['daojishiid'];
        $time = time();

        $where['oid'] = array('in',rtrim($id,','));

        //$where['selltime'] =['egt',$time];
        $list = db('order')->field('oid,selltime,pid,sellprice,ploss,ostaus,buyprice,system,is_timing,ostyle,endloss,fee,onumber,code,chicang')->where($where)->select();


        $fp = fopen('list.txt','w+'); fwrite($fp,var_export($list,true)); fclose($fp);

        foreach($list as $key => $val){
            $price = db('productdata')->field('Price')->where("pid=".$val['pid'])->find();

            if($val['ostaus']==1){
                $list[$key]['endtime'] = '<span style="color:red">结束</span>';

                if($val['buyprice']>$val['sellprice']){
                    $list[$key]['sellprice'] = '<span style="color:#2fb44e">'.$val['sellprice']."</span>";
                }else{
                    $list[$key]['sellprice'] = '<span style="color:#ed0000">'.$val['sellprice']."</span>";
                }

                if($val['ploss']>0){
                    $list[$key]['ploss'] = '<span style="color:red">'.$val['ploss']."</span>";
                }else{
                    $list[$key]['ploss'] = '<span style="color:green">'.$val['ploss']."</span>";
                }


                if($val['is_timing']==1){
                    if($val['system']==1){
                        $list[$key]['pingcang'] = "系统平仓";
                    }else{
                        $list[$key]['pingcang'] = "自由平仓";
                    }

                }else{
                    $list[$key]['pingcang'] = "已平仓";
                }



            }else{

                if($val['is_timing']==1){

                    $list[$key]['endtime'] = '<span style="color:red">进行中</span>';
                    if($val['buyprice']>$price['Price']){
                        $list[$key]['sellprice'] = '<span style="color:#2fb44e">'.$price['Price']."</span>";
                    }else{
                        $list[$key]['sellprice'] = '<span style="color:#ed0000">'.$price['Price']."</span>";
                    }




                    $code = db('productinfo')->field('code,decimal,numprice,procode')->where("pid=".$val['pid'])->find();
                    $code['code'] = $val['code'];


                    //平仓价
                    $enter = floatval($price['Price']);
                    //入仓价
                    $flat = floatval($val['buyprice']);
                    $cha = bcsub($enter,$flat,8);
                    $point = floatval($cha);




                    $range = $point*$code['code']*$val['chicang'];

                    if($val['ostyle']==0)
                    {
                        if($range>0){
                            $list[$key]['ploss'] = '<span style="color:red">'.$range."</span>";
                        }else{
                            $list[$key]['ploss'] = '<span style="color:green">'.$range."</span>";
                        }
                    }else{
                        if($range>0){
                            $list[$key]['ploss'] = '<span style="color:green">-'.$range."</span>";
                        }else{
                            $list[$key]['ploss'] = '<span style="color:red">'.abs($range)."</span>";
                        }
                    }







                }else{
                    $endtime = $val['selltime']-$time;
                    if($endtime>=1){
                        $list[$key]['endtime'] = '<span style="color:green">'.$endtime."</span>";
                    }
                    else{
                        $list[$key]['endtime'] = '<span style="color:red">结束</span>';
                    }


                    if($val['buyprice']>$price['Price']){
                        $list[$key]['sellprice'] = '<span style="color:#2fb44e">'.$price['Price']."</span>";
                    }else{
                        $list[$key]['sellprice'] = '<span style="color:#ed0000">'.$price['Price']."</span>";
                    }

                    $order_cha = round(floatval($price['Price'])-floatval($val['buyprice']),6);


                    if($val['ostyle']==0)
                    {
                        if($order_cha > 0)
                        {  //盈利
                            $yingli = $val['fee']*($val['endloss']/100);
                        }
                        elseif($order_cha < 0)
                        {	//亏损
                            $yingli = -1*$val['fee'];
                        }
                        else
                        {		//无效
                            $yingli = 0;
                        }
                    }else{

                        if($order_cha < 0)
                        {  //盈利
                            $yingli = $val['fee']*($val['endloss']/100);
                        }
                        elseif($order_cha > 0)
                        {	//亏损
                            $yingli = -1*$val['fee'];
                        }
                        else
                        {		//无效
                            $yingli = 0;

                        }

                    }

                    if($yingli>0){
                        $list[$key]['ploss'] = '<span style="color:red">'.$yingli."</span>";
                    }else{
                        $list[$key]['ploss'] = '<span style="color:green">'.$yingli."</span>";
                    }



                }

            }




        }
        if($list){
            $info = json_encode($list);
            print_r($info);exit;
        }
    }

    /**
     * 平仓日志
     * @author lukui  2017-02-15
     * @return [type] [description]
     */
    public function orderlog()
    {
        $pagenum = cache('page');
        $where = array();
        $getdata = array();
        $data = input('get.');
        //用户名称、id、邮箱、昵称
        if(isset($data['username']) && !empty($data['username'])){
            $where['username|u.uid|utel|nickname'] = array('like','%'.$data['username'].'%');
            $getdata['username'] = $data['username'];
        }

        //时间搜索
        if(isset($data['starttime']) && !empty($data['starttime'])){
            if(!isset($data['endtime']) || empty($data['endtime'])){
                $data['endtime'] = date('Y-m-d H:i:s',time());
            }
            $where['time'] = array('between time',array($data['starttime'],$data['endtime']));
            $getdata['starttime'] = $data['starttime'];
            $getdata['endtime'] = $data['endtime'];
        }

        //盈亏
        if(isset($data['ploss']) && !empty($data['ploss'])){
            if ($data['ploss'] == 1) { //赢利
                $where['addpoint'] = array('>',0);
            }
            if ($data['ploss'] == 2) { //亏损
                $where['addpoint'] = array('<=',0);
            }

            $getdata['ploss'] = $data['ploss'];
        }

        //权限检测
        if($this->otype != 3){

            $uids = myuids($this->uid);
            if(!empty($uids)){
                $where['u.uid'] = array('IN',$uids);
            }
        }

        if(isset($data['doble']) && !empty($data['doble'])){
            $sql = 'select * from wp_order_log
                where oid in (select   oid from   wp_order_log group by   oid having count(oid) > 1) and uid='.trim($data['username']);
            $orderlog =  Db::query($sql);
            $this->assign('doble',1);
        }else{
            $orderlog = Db::name('order_log')->alias('ol')->field('ol.*,u.username,u.nickname,u.oid as uoid')
                ->join('__USERINFO__ u','ol.uid=u.uid')
                ->where($where)->order('id desc')->paginate($pagenum,false,['query'=> $getdata]);
        }
        $uid = $this->uid;
        $prousername =Db::name('userinfo') -> where('uid',$uid)->find();
        $this->assign('prousername',$prousername);
        $this->assign('orderlog',$orderlog);
        $this->assign('getdata',$getdata);
        $this->assign('doble',0);
        return $this->fetch();
    }

    /**
     * 订单详情
     * @author lukui  2017-02-15
     * @return [type] [description]
     */
    public function orderinfo()
    {
        $oid = input('param.oid');

        if(!$oid){
            $this->redirect('order/orderlist');
        }
        $where['o.oid'] = $oid;
        $order = Db::name('order')->alias('o')->field('o.*,u.username,u.nickname,u.oid as uoid,u.usermoney,u.portrait')
            ->join('__USERINFO__ u','o.uid=u.uid')
            ->where($where)->order('oid desc')->find();

        if($this->otype != 3){

            $uids = myuids($this->uid);
            if(!in_array($order['uid'],$uids)){
                $this->error("无权查看！");
            }
        }


        $this->assign($order);
        return $this->fetch();
    }

    /**
     * 订单统计
     * @author lukui  2017-02-15
     * @return [type] [description]
     */

    public function ordersta()
    {
        $data = input('post.');

        //验证搜索数据
        $res = $this->ecickdata($data);

        $where = $res['where'];
        if(isset($where['o.oid'])){
            $where['ol.oid'] = $where['o.oid'];
            unset($where['o.oid']);
        }
        $getdata = $res['getdata'];
        if($this->otype != 3){
            $uids = myuids($this->uid);
            if(!empty($uids)){
                $where['ol.uid'] = array('IN',$uids);
            }
        }

        $ordersta = Db::name('order')->alias('ol')->field('SUM(ploss) as ploss,SUM(fee) as fee')->join('__USERINFO__ u','ol.uid=u.uid')->where($where)->select();
        //盈亏统计
        $resdata['profit'] = $ordersta['0']['ploss']?$ordersta['0']['ploss']:0;
        //委托金额
        $resdata['fee'] = $ordersta['0']['fee']?$ordersta['0']['fee']:0;
        //交易手数
        $ordersta = Db::name('order')->alias('ol')->join('__USERINFO__ u','ol.uid=u.uid')->where($where)->count();
        $resdata['count'] = $ordersta;
        //无效金额
        $where['ostaus'] = 1;
        if(!isset($data['ploss'])){
            $where['ploss'] = 0;
        }
        if(isset($data['ploss']) && ($data['ploss'] == 1 || $data['ploss'] == 2)){
            $ordersta = 0;
        }else{
            $ordersta = Db::name('order')->alias('ol')->join('__USERINFO__ u','ol.uid=u.uid')->where($where)->sum('fee');
        }
        $resdata['invalid_fee'] = $ordersta?$ordersta:0;
        //有效金额
        $where['ostaus'] = 1;
        if(!isset($data['ploss'])){
            $where['ploss'] = array('neq',0);
        }

        if(isset($data['ploss']) && $data['ploss'] == 3){
            $ordersta = 0;
        }else{
            $ordersta = Db::name('order')->alias('ol')->join('__USERINFO__ u','ol.uid=u.uid')->where($where)->sum('fee');
        }
        $resdata['valid_fee'] = $ordersta?$ordersta:0;
        //建仓金额
        $where['ostaus'] = 0;
        $ordersta = Db::name('order')->alias('ol')->join('__USERINFO__ u','ol.uid=u.uid')->where($where)->sum('fee');
        $resdata['now_fee'] = $ordersta?$ordersta:0;

        //手续费
        unset($where['ploss']);
        unset($where['ostaus']);
        $resdata['valid_shouxu'] = Db::name('order')->alias('ol')->join('__USERINFO__ u','ol.uid=u.uid')->where($where)->sum('sx_fee');
        if(!$resdata['valid_shouxu']) $resdata['valid_shouxu']=0;


        return $resdata;
    }

    /**
     * 订单搜索数据验证
     * @author lukui  2017-02-16
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function ecickdata($data)
    {

        $where = array();
        $getdata = array();
        //订单id/编号
        if(isset($data['orderid']) && !empty($data['orderid'])){
            $where['o.oid|orderno'] = array('like','%'.$data['orderid'].'%');
            $getdata['oid'] = $data['orderid'];
        }

        //用户名称、id、邮箱、昵称
        if(isset($data['username']) && !empty($data['username'])){
            if(!isset($data['stype'])) $data['stype'] = 1;
            if($data['stype'] == 1){
                $where['username|u.uid|utel|nickname'] = array('like','%'.$data['username'].'%');
            }
            if($data['stype'] == 2){
                $puid = db('userinfo')->where(array('username'=>$data['username']))->whereOr('utel',$data['username'])->value('uid');
                if(!$puid) $puid = 0;
                $where['u.oid'] = $puid;
            }
            $getdata['username'] = $data['username'];
            $getdata['stype'] = $data['stype'];


        }

        //时间搜索
        if(isset($data['starttime']) && !empty($data['starttime'])){
            if(!isset($data['endtime']) || empty($data['endtime'])){
                $data['endtime'] = date('Y-m-d H:i:s',time());
            }

            if($data['ttype'] == 1){
                $where['buytime'] = array('between time',array($data['starttime'],$data['endtime']));
            }
            if($data['ttype'] == 2){
                $where['selltime'] = array('between time',array($data['starttime'],$data['endtime']));
            }

            $getdata['starttime'] = $data['starttime'];
            $getdata['endtime'] = $data['endtime'];
            $getdata['ttype'] = $data['ttype'];
        }

        //涨跌
        if(isset($data['ostyle']) && !empty($data['ostyle'])){
            $where['ostyle'] = $data['ostyle']-1;
            $getdata['ostyle'] = $data['ostyle'];
        }

        //盈亏
        if(isset($data['ploss']) && !empty($data['ploss'])){
            if ($data['ploss'] == 1) { //赢利
                $where['ploss'] = array('>',0);
            }
            if ($data['ploss'] == 2) { //亏损
                $where['ploss'] = array('<',0);
            }
            if ($data['ploss'] == 3) { //无效
                $where['ploss'] = array('=',0);
            }
            $getdata['ploss'] = $data['ploss'];
        }

        //产品
        if(isset($data['pid']) && !empty($data['pid'])){
            $where['pid'] = $data['pid'];
            $getdata['pid'] = $data['pid'];
        }

        //状态
        if(isset($data['ostaus']) && !empty($data['ostaus'])){
            $where['ostaus'] = $data['ostaus']-1;
            $getdata['ostaus'] = $data['ostaus'];
        }
        //特定oid
        if(isset($data['oid']) && !empty($data['oid'])){
            $where['o.oid'] = $data['oid'];
            $getdata['oid'] = $data['oid'];
        }
        if (empty($where)) {
            $times['starttime'] = strtotime("-7 day");
            //$times['starttime'] = strtotime(date("Y").'-'.date("m").'-'.date("d").' 00:00:00');
            $times['endtime'] = strtotime(date("Y").'-'.date("m").'-'.date("d").' 24:00:00');
            $where['buytime'] = array('between time',array($times['starttime'],$times['endtime']));
        }



        $res['where'] = $where;
        $res['getdata'] = $getdata;
        check_res(0, 0 ,0,$res);
        return $res;
    }

    public function searchdata($data)
    {

        $where = array();
        $getdata = array();
        //订单id/编号
        if(isset($data['orderid']) && !empty($data['orderid'])){
            $where['o.order_sn|o.api_order_sn|so.order_sn|o.sdorder_sn'] = array('like','%'.$data['orderid'].'%');
            $getdata['oid'] = $data['orderid'];
        }

        //用户名称、id、邮箱、昵称
        if(isset($data['username']) && !empty($data['username'])){
            if(!isset($data['stype'])) $data['stype'] = 1;
            if($data['stype'] == 1){
                $where['username|u.uid|utel|nickname|o.user_id'] = array('like','%'.$data['username'].'%');
            }

            $getdata['username'] = $data['username'];
            $getdata['stype'] = $data['stype'];
        }



        //时间搜索
        if(isset($data['starttime']) && !empty($data['starttime'])){
            if(!isset($data['endtime']) || empty($data['endtime'])){
                $data['endtime'] = date('Y-m-d H:i:s',time());
            }


            $where['o.addtime'] = array('between time',array($data['starttime'],$data['endtime']));

            $getdata['starttime'] = $data['starttime'];
            $getdata['endtime'] = $data['endtime'];

        }

        //买卖
        if(isset($data['trade_type']) && !empty($data['trade_type'])){
            $where['o.trade_type'] = $data['trade_type']-1;
            $getdata['trade_type'] = $data['trade_type'];
        }


        //法币币种
        if(isset($data['currency']) && !empty($data['currency'])){
            $where['o.currency_type'] = $data['currency'];
            $getdata['currency'] = $data['currency'];
        }

        //虚拟币名
        if(isset($data['symbol']) && !empty($data['symbol'])){
            $where['o.symbol'] = $data['symbol'];
            $getdata['symbol'] = $data['symbol'];
        }

        //状态
        if(isset($data['status']) && !empty($data['status'])){
            $where['o.status'] = $data['status']-1;
            $getdata['status'] = $data['status'];
        }

        if (empty($where)) {
            $times['starttime'] = strtotime("-7 day");

            $times['endtime'] = strtotime(date("Y").'-'.date("m").'-'.date("d").' 24:00:00');
            $where['o.addtime'] = array('between time',array($times['starttime'],$times['endtime']));
        }



        $res['where'] = $where;
        $res['getdata'] = $getdata;
        //check_res(0, 0 ,0,$res);
        return $res;
    }


    public function searchdatas($data)
    {

        $where = array();
        $getdata = array();
        //订单id/编号
        if(isset($data['orderid']) && !empty($data['orderid'])){
            $where['o.order_sn|o.id'] = array('like','%'.$data['orderid'].'%');
            $getdata['oid'] = $data['orderid'];
        }

        //用户名称、id、邮箱、昵称
        if(isset($data['username']) && !empty($data['username'])){
            if(!isset($data['stype'])) $data['stype'] = 1;
            if($data['stype'] == 1){
                $where['username|u.uid|utel|nickname|o.user_id'] = array('like','%'.$data['username'].'%');
            }

            $getdata['username'] = $data['username'];
            $getdata['stype'] = $data['stype'];
        }



        //时间搜索
        if(isset($data['starttime']) && !empty($data['starttime'])){
            if(!isset($data['endtime']) || empty($data['endtime'])){
                $data['endtime'] = date('Y-m-d H:i:s',time());
            }


            $where['o.addtime'] = array('between time',array($data['starttime'],$data['endtime']));

            $getdata['starttime'] = $data['starttime'];
            $getdata['endtime'] = $data['endtime'];

        }

        //买卖
        if(isset($data['trade_type']) && !empty($data['trade_type'])){
            $where['o.trade_type'] = $data['trade_type']-1;
            $getdata['trade_type'] = $data['trade_type'];
        }


        //法币币种
        if(isset($data['currency']) && !empty($data['currency'])){
            $where['o.currency_type'] = $data['currency'];
            $getdata['currency'] = $data['currency'];
        }

        //虚拟币名
        if(isset($data['symbol']) && !empty($data['symbol'])){
            $where['o.symbol'] = $data['symbol'];
            $getdata['symbol'] = $data['symbol'];
        }

        //状态
        if(isset($data['status']) && !empty($data['status'])){
            $where['o.status'] = $data['status']-1;
            $getdata['status'] = $data['status'];
        }

        if (empty($where)) {
            $times['starttime'] = strtotime("-7 day");

            $times['endtime'] = strtotime(date("Y").'-'.date("m").'-'.date("d").' 24:00:00');
            $where['o.addtime'] = array('between time',array($times['starttime'],$times['endtime']));
        }



        $res['where'] = $where;
        $res['getdata'] = $getdata;
        //check_res(0, 0 ,0,$res);
        return $res;
    }

    /*撤销挂单*/
    public function goback_shevles_order(){
        $oid = input('oid');
        $order = db('currency_shevles_order')->where('id',$oid)->find();
        if($order['status'] == 0 ){
            db('currency_shevles_order')->where('id',$oid)->update(['status'=>2]);
            //把剩余的数量返回给用户
            if($order['trade_type'] == 1){
                $isnotdone_num = $order['isnotdone_num'];
                if($isnotdone_num>0){
                    log_account_change($order['user_id'],3,$order['symbol'],$isnotdone_num,-1*$isnotdone_num,\think\Lang::get('fbjy_xjdd'),0);
                }
            }


            return WPreturn('操作成功',1);
        }else{
            return WPreturn('操作失败',-1);
        }
    }

    /**
     * 我的对冲
     * @return [type] [description]
     */
    public function myallot()
    {

        $map['uid'] = 2;
        $getdata = array();
        $pagenum = cache('page');

        $list = db('allot')->where($map)->order('id desc')->paginate($pagenum,false,['query'=> $getdata]);

        $this->assign('list',$list);
        $this->assign('getdata',$getdata);
        $this->assign('jsongetdata',http_build_query($getdata));
        return $this->fetch();

    }


    public function dankong()
    {

        $data = input('post.');
        $order = db('order')->where('oid',$data['oid'])->find();
        if($order['ostaus'] == 1){
            return WPreturn('此单已平仓',-1);
        }
        $ids = db('order')->update($data);
        if($ids){
            return WPreturn('操作成功',1);
        }else{
            return WPreturn('操作失败',-1);
        }


    }




}