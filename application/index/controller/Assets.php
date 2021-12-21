<?php
namespace app\index\controller;
use mysql_xdevapi\Session;
use think\Controller;
use think\Db;
use think\Cookie;

class Assets extends Base
{
    public function tradeaccount(){
        $qb = input('param.qb');
        $cp = input('param.cp');
        $map['qb'] = $qb;
        $map['cp'] = trim($cp);
        $map['yh'] = $this->uid;

        $account = Db::name('zc')->where($map)->find();


        if(!$account){
            $this->redirect('assets/bibi');
        }
        $account['sl'] = floatval($account['sl']);
        $account['dj'] = floatval($account['dj']);
        if($cp!='USDT'){

            if($cp=='HUSD'){
                $url = "https://api.huobi.pro/market/detail/merged?symbol=usdthusd";
                $getdata = $this->curlfun($url);
                $res = json_decode($getdata,1);

                if($res['status']!='ok'){
                    $account['rmb']  = floatval(($account['sl']+$account['dj']));
                }else{
                    $data_arr=$res['tick'];

                    $account['rmb']  = floatval(($account['sl']+$account['dj'])/$data_arr['close']);
                }


            }else{
                $ptitle = $cp.'/USDT';
                $price = Db::name('productdata')->where('Name',$ptitle)->value('Price');
                if(!$price){
                    $url = "https://api.huobi.pro/market/detail/merged?symbol=".strtolower($cp)."usdt";
                    $getdata = $this->curlfun($url);
                    $res = json_decode($getdata,1);

                    if($res['status']!='ok'){
                        $account['rmb'] = floatval(($account['sl']+$account['dj']));
                    }else{
                        $data_arr=$res['tick'];

                        $account['rmb'] = floatval(($account['sl']+$account['dj'])*$data_arr['close']);
                    }

                }else{
                    $account['rmb'] = floatval(($account['sl']+$account['dj'])*$price);
                }
            }

        }else{
            $account['rmb'] = floatval(($account['sl']+$account['dj']));
        }

        $leixing = array(\think\Lang::get('bii_bzh'),\think\Lang::get('bii_hy'),\think\Lang::get('bii_fb'),\think\Lang::get('bii_mhy')); //币币账户、合约账户、法币账户、秒合约账户

        //明细
        $where['uid'] = $this->uid;
        $where['type'] = $qb;
        $where['name'] = $cp;
        $where['sl'] = array('<>',0);
        $log  =  Db::name('record')->where($where)->order('id desc')->select();
        foreach ($log as $key=>$val){
            $log[$key]['shijian'] =  date("Y-m-d H:i:s",$val['time']);
        }

        $this->assign('zhlx',$leixing[$qb-1]);
        $this->assign('log',$log);
        $this->assign('qblx',$qb);
        $this->assign('cp',$cp);

        $this->assign('account',$account);
        return $this->fetch();
    }

    public function getmoney(){
        $qb = input('param.types');
        $cp = input('param.name');


        $account =  get_money($this->uid,$qb,trim($cp));


        $res = array(
            "money"=>$account,
        );

        exit(json_encode($res));
    }


    public function sdgetmoney(){

        $cp = input('param.name');


        $account =  get_money($this->uid,3,trim($cp));


        $res = array(
            "money"=>$account,
        );

        exit(json_encode($res));
    }

    public function tibi()
    {


        $name = input('param.name');

        $map['qb'] = 1;
        $map['cp'] = trim($name);
        $map['yh'] = $this->uid;

        $account = Db::name('zc')->where($map)->find();
        if(!$account){
            $this->redirect('assets/bibi');
        }
        $sxf  = $this->conf['sc_sxfee'];
        $sxfee  =  explode("|",$sxf);

        if(in_array($name,array('USDT','BTC','ETH','HUSD'))){
            $key =  array_search($name,array('USDT','BTC','ETH','HUSD'));
            $tisxf = $sxfee[$key];
        }else{
            $tisxf = $sxfee[4];
        }



        $ti_zuixiao = $this->conf['ti_zuixiao'];
        $tizuixiao  =  explode("|",$ti_zuixiao);

        if(in_array($name,array('USDT','BTC','ETH','HUSD'))){
            $key =  array_search($name,array('USDT','BTC','ETH','HUSD'));
            $tizx = $tizuixiao[$key];
        }else{
            $tizx = $tizuixiao[4];
        }


        $this->assign('account',$account);
        $this->assign('tisxf',$tisxf);
        $this->assign('tizx',$tizx);

        return $this->fetch();
    }


    /**
     * 用户提现
     * @author lukui  2017-07-21
     * @return [type] [description]
     */
    public function cash()
    {
        $uid = $this->uid;
        if(input('post.')){
            $data = input('post.');
            if($data){

                $arr = array('price','usdt_type','usdt_url','erjimima','name');
                foreach ($data as $k => $v) {
                    if(!in_array($k,$arr)){
                        return WPreturn(\think\Lang::get('od_cwpzx'),-1);
                    }
                }
                $file = request()->file();
                if($file){
                    return WPreturn(\think\Lang::get('od_cwpzx'),-1);
                }

                $uid = $_SESSION['uid'] ;
                $user = Db::name('userinfo')->where('uid',$uid)->find();
                if(md5($data['erjimima'])!=$user['erjimima']){
                    return WPreturn(\think\Lang::get('at_jymmbzq'),-1);
                }


                if(!$data['price']){
                    return WPreturn(\think\Lang::get('at_qsrtbsl'),-1);
                }
                //验证申请金额
                $user = $this->user;
                if($user['ustatus'] != 0){
                    return WPreturn(\think\Lang::get('at_bqnzswqtb'),-1);
                }



                if($user['smsh_state'] == 0){
                    return WPreturn(\think\Lang::get('od_qtjsfzwcsmrz'),-1);
                }

                if($user['smsh_state'] == 1){
                    return WPreturn(\think\Lang::get('od_smshzzswfcz'),-1);
                }

                if($user['smsh_state'] == 3){
                    return WPreturn(\think\Lang::get('od_smrzsbqcxrz'),-1);
                }



                $conf = $this->conf;

                if($conf['is_cash'] != 1){
                    return WPreturn(\think\Lang::get('od_bqzswftb'),-1);
                }


                $sxf  = $this->conf['sc_sxfee'];
                $sxfee  =  explode("|",$sxf);

                if(in_array(trim($data['name']),array('USDT','BTC','ETH','HUSD'))){
                    $key =  array_search($data['name'],array('USDT','BTC','ETH','HUSD'));
                    $tisxf = $sxfee[$key];
                }else{
                    $tisxf = $sxfee[4];
                }


                $ti_zuixiao = $this->conf['ti_zuixiao'];
                $tizuixiao  =  explode("|",$ti_zuixiao);

                if(in_array($data['name'],array('USDT','BTC','ETH','HUSD'))){
                    $key =  array_search($data['name'],array('USDT','BTC','ETH','HUSD'));
                    $tizx = $tizuixiao[$key];
                }else{
                    $tizx = $tizuixiao[4];
                }



                if($tizx > $data['price']){
                    return WPreturn(\think\Lang::get('od_dbzdtbsw').$tizx,-1);
                }


                if(empty($data['usdt_url'])){
                    return WPreturn(\think\Lang::get('jse_qsrtbdz'),-1);
                }
                if(strlen($data['usdt_url'])<15){
                    return WPreturn(\think\Lang::get('ae_qsrzqdtbdz'),-1);
                }


                //判断金额是否够
                $map['qb'] = 1;
                $map['cp'] = $data['name'];
                $map['yh'] = $this->uid;

                $account = Db::name('zc')->where($map)->find();


                if ($account['sl'] < $data['price']) {
                    return WPreturn(\think\Lang::get('ae_zdtbsw').$account['sl'],-1);
                }

                //提现申请
                $newdata['usdt_url'] = $data['usdt_url'];
                $newdata['usdt_type'] = $data['usdt_type'];
                $newdata['bizhong'] = $data['name'];
                $newdata['pay_type'] = $data['name'];
                $newdata['balance_sn'] = $uid.time().rand(1111,9999);
                $newdata['reg_par'] = $tisxf;
                $newdata['btime'] = time();
                $newdata['isverified'] = 0;
                $newdata['uid'] = $uid;
                $newdata['remarks'] = \think\Lang::get('ae_hytb').$data['name'];
                $newdata['bpprice'] = $data['price'];
                $newdata['bptime'] = time();
                $newdata['bptype'] = 0;
                $bpid = Db::name('balance')->insertGetId($newdata);
                if($bpid){
                    //插入申请成功后,扣除金额
                    log_account_change($uid,1,trim($data['name']),-1*$data['price'],$data['price'],$remark=\think\Lang::get('tt_tb'),0);
                    return WPreturn(\think\Lang::get('ae_tbsqtjcg'),1);

                }else{
                    return WPreturn(\think\Lang::get('ae_tbsb'),-1);
                }

            }else{
                return WPreturn(\think\Lang::get('ae_zbzcczflx'),-1);
            }
        }
    }

    public function huazhuan()
    {
        $qb = input('param.qb');
        $cp = input('param.name');
        $map['qb'] = $qb;
        $map['cp'] = trim($cp);
        $map['yh'] = $this->uid;

        $account = Db::name('zc')->where($map)->find();
        if(!$account){
            $this->redirect('assets/bibi');
        }
        $this->assign('account',$account);
        $uid = $this->uid;
        $user = Db::name('userinfo')->field('usermoney')->where('uid',$uid)->find();
        $this->assign($user);
        return $this->fetch();
    }


    //闪兑
    public function shandui()
    {



        $umap['qb'] = 3;
        $umap['cp'] = 'USDT';
        $umap['yh'] = $this->uid;

        $usdtaccount = Db::name('zc')->where($umap)->find();
        if(!$usdtaccount){
            $this->redirect('assets/bibi');
        }
        $this->assign('account',$usdtaccount);



        $uid = $this->uid;
        $user = Db::name('userinfo')->field('usermoney')->where('uid',$uid)->find();
        $this->assign($user);
        return $this->fetch();
    }

    public function dohuazhuan(){
        $num = input('param.num');
        $from_account = input('param.from_account');
        $name = input('param.name');
        $to_account = input('param.to_account');

        $leixing = array(\think\Lang::get('bii_bzh'),\think\Lang::get('bii_hy'),\think\Lang::get('bii_fb'),\think\Lang::get('bii_mhy'));


        if($from_account == $to_account){
            $result = array(
                'error' => 1,
                'msg' =>\think\Lang::get('bii_tlxzhbnhz'),
            );
            echo json_encode($result);
            exit();
        }




        $map['qb'] = $to_account;
        $map['cp'] = trim($name);
        $map['yh'] = $this->uid;

        $account = Db::name('zc')->where($map)->find();

        if(!$account){
            $result = array(
                'error' => 1,
                'msg' =>$leixing[$to_account-1].\think\Lang::get('ae_my').$name.\think\Lang::get('ae_qbgzsb') ,
            );
            echo json_encode($result);
            exit();
        }



        if(!is_numeric($num) || $num<=0  || empty($num)){

            $result = array(
                'error' => 1,
                'msg' =>\think\Lang::get('ae_qsrzqdsl')  ,
            );
            echo json_encode($result);
            exit();
        }

        $usermoney =  get_money($this->uid,$from_account,trim($name));
        if($num>$usermoney){
            $result = array(
                'error' => 1,
                'msg' =>\think\Lang::get('ae_zdkhz').$usermoney,
            );
            echo json_encode($result);
            exit();
        }

        log_account_change($this->uid,$from_account,trim($name),-1*$num,0,$remark=\think\Lang::get('ae_hzd').$leixing[$to_account-1],0);
        log_account_change($this->uid,$to_account,trim($name),$num,0,$remark=\think\Lang::get('hz_c').$leixing[$from_account-1].\think\Lang::get('tt_hz'),0);



        $result = array(
            'error' => 0,
            'msg' =>\think\Lang::get('zh_hzcg') ,
        );
        echo json_encode($result);
        exit();


    }



    public function doshandui(){
        $num = input('param.num');
        $from_account = input('param.from_account');
        $to_account = input('param.to_account');




        if($from_account == $to_account){
            $result = array(
                'error' => 1,
                'msg' =>'同一币种不能闪兑',
            );
            echo json_encode($result);
            exit();
        }







        if(!is_numeric($num) || $num<=0  || empty($num)){

            $result = array(
                'error' => 1,
                'msg' =>'请输入闪兑数量'  ,
            );
            echo json_encode($result);
            exit();
        }

        $usermoney =  get_money($this->uid,3,trim($from_account));
        if($num>$usermoney){
            $result = array(
                'error' => 1,
                'msg' =>'最大可闪兑数量'.$usermoney,
            );
            echo json_encode($result);
            exit();
        }

        log_account_change($this->uid,3,trim($from_account),-1*$num,0,'闪兑',0);
        log_account_change($this->uid,3,trim($to_account),$num,0,'闪兑',0);



        $result = array(
            'error' => 0,
            'msg' =>\think\Lang::get('zh_hzcg') ,
        );
        echo json_encode($result);
        exit();


    }



    public function chongbi()
    {
        $name = input('param.name');
        $name = trim($name);
        if(!in_array($name,array('USDT','BTC','ETH'))){
            $this->redirect('assets/bibi');
        }
        $uid = $this->uid;
        $user = Db::name('userinfo')->field('usermoney')->where('uid',$uid)->find();
        $this->assign($user);

        if($name=='BTC'){
            $url  = $this->conf['btcurl'];

        }elseif($name=='USDT'){
            $url  = $this->conf['usdt_url'];
        }elseif($name=='ETH'){
            $url  = $this->conf['ethurl'];
        }

        $this->assign('urltext',$url);
        $url = "https://api.qrserver.com/v1/create-qr-code/?size=150%C3%97150&data=".$url;

        $this->assign('url',$url);

        $this->assign('name',$name);
        return $this->fetch();
    }
    public function url(){
        $type = input('param.types');
        $url = '';
        if($type=='0'){
            $url  = $this->conf['usdt_url'];

        }elseif($type=='1'){
            $url  = $this->conf['usdturl_omni'];
        }elseif($type=='2'){
            $url  = $this->conf['usdturl_trc20'];
        }
        $urltext = $url;
        $url =  "https://api.qrserver.com/v1/create-qr-code/?size=150%C3%97150&data=".$url;


        $res = array(

            "url"=>$url,
            "urltext"=>$urltext,

        );

        exit(json_encode($res));
    }

    public function dorecharge(){
        $num = input('param.num');
        $cbdz = input('param.cbdz');
        $name = input('param.name');
        $usdt_type = input('param.usdt_type');
        if($cbdz==''){
            $result = array(
                'error' => 1,
                'msg' =>\think\Lang::get('cb_qsrcbdz') ,
            );
            echo json_encode($result);
            exit();
        }



        $user = $this->user;
        if($user['ustatus'] != 0){

            $result = array(
                'error' => 1,
                'msg' =>\think\Lang::get('cb_qsrcbdz') ,
            );
            echo json_encode($result);
            exit();
            return WPreturn(\think\Lang::get('at_bqnzswqtb'),-1);
        }



        if($user['smsh_state'] == 0){
            $result = array(
                'error' => 1,
                'msg' =>\think\Lang::get('od_qtjsfzwcsmrz') ,
            );
            echo json_encode($result);
            exit();

        }

        if($user['smsh_state'] == 1){
            $result = array(
                'error' => 1,
                'msg' =>\think\Lang::get('od_smshzzswfcz') ,
            );
            echo json_encode($result);
            exit();

        }

        if($user['smsh_state'] == 3){
            $result = array(
                'error' => 1,
                'msg' =>\think\Lang::get('od_smrzsbqcxrz') ,
            );
            echo json_encode($result);
            exit();

        }



        if(strlen($cbdz)<15){
            $result = array(
                'error' => 1,
                'msg' =>\think\Lang::get('ae_qsrzqdtbdz') ,
            );
            echo json_encode($result);
            exit();

        }



        if(!in_array($name,array('USDT','BTC','ETH'))){
            $result = array(
                'error' => 1,
                'msg' =>\think\Lang::get('ae_ffcz') ,
            );
            echo json_encode($result);
            exit();
        }

        if(is_numeric($num) && $num>0  && !empty($num)){
            $data['bpprice'] = $num;

        }else{

            $result = array(
                'error' => 1,
                'msg' =>\think\Lang::get('ae_qsrzqczs') ,
            );
            echo json_encode($result);
            exit();
        }
        $data['bptype'] = 3;
        $data['bptime'] = time();
        $data['remarks'] = \think\Lang::get('ae_yhcz').$name;
        $data['uid'] = $this->uid;
        $data['isverified'] = 0;
        $data['btime'] = time();
        $data['reg_par'] = 0;
        $data['pay_type'] = $name;
        $data['usdt_url'] = $cbdz;
        $data['bizhong'] = $name;
        if($name=='USDT'){
            $data['usdt_type'] = $usdt_type;
        }

        $data['balance_sn'] = $this->uid.time().rand(111111,999999);

        $ids = db('balance')->insertGetId($data);
        if(!$ids){
            $result = array(
                'error' => 1,
                'msg' =>\think\Lang::get('ae_crddsbqcs') ,
            );
            echo json_encode($result);
            exit();
        }

        $result = array(
            'error' => 0,
            'msg' =>\think\Lang::get('cb_tjcg') ,
        );
        echo json_encode($result);
        exit();
    }





    //curl获取数据
    public function curlfun($url, $params = array(), $method = 'GET')
    {

        $header = array();
        $opts = array(CURLOPT_TIMEOUT => 10, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false, CURLOPT_HTTPHEADER => $header);

        /* 根据请求类型设置特定参数 */
        switch (strtoupper($method)) {
            case 'GET' :
                $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
                $opts[CURLOPT_URL] = substr($opts[CURLOPT_URL],0,-1);

                break;
            case 'POST' :
                //判断是否传输文件
                $params = http_build_query($params);
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_POST] = 1;
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            default :

        }

        /* 初始化并执行curl请求 */
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if($error){
            $data = null;
        }

        return $data;

    }


    //币币
    public function bibi(){


        $allbibi_money = 0;
        $all_money = 0;
//       币币钱包所有币种
        $a=Db::table("wp_zc")->field("cp,sl,dj")->where("yh",$this->uid)->where("qb",1)->select();
        foreach ($a as $key=>$val){
            $zhehe = 0;
            if($val['cp']!='USDT'){
                if($val['cp']=='HUSD'){
                    $url = "https://api.huobi.pro/market/detail/merged?symbol=usdthusd";
                    $getdata = $this->curlfun($url);
                    $res = json_decode($getdata,1);



                    if($res['status']!='ok') continue;
                    $data_arr=$res['tick'];
                    $zhehe = floatval(($val['sl']+$val['dj'])/$data_arr['close']);

                }else{
                    $ptitle = $val['cp'].'/USDT';
                    $price = Db::name('productdata')->where('Name',$ptitle)->value('Price');
                    if(!$price){
                        $url = "https://api.huobi.pro/market/detail/merged?symbol=".strtolower($val['cp'])."usdt";
                        $getdata = $this->curlfun($url);
                        $res = json_decode($getdata,1);



                        if($res['status']!='ok') continue;
                        $data_arr=$res['tick'];
                        $zhehe = floatval(($val['sl']+$val['dj'])*$data_arr['close']);


                    }else{
                        $zhehe = floatval(($val['sl']+$val['dj'])*$price);
                    }
                }


            }else{
                $zhehe = floatval(($val['sl']+$val['dj']));
            }

            $a[$key]['zhehe'] = $zhehe;

            $allbibi_money += $zhehe;
        }


        //       钱包所有币种
        $b=Db::table("wp_zc")->field("cp,sl,dj")->where("yh",$this->uid)->select();
        foreach ($b as $val){
            $zhehe = 0;
            if($val['cp']!='USDT'){
                if($val['cp']=='HUSD'){
                    $url = "https://api.huobi.pro/market/detail/merged?symbol=usdthusd";
                    $getdata = $this->curlfun($url);
                    $res = json_decode($getdata,1);



                    if($res['status']!='ok') continue;
                    $data_arr=$res['tick'];
                    $zhehe = floatval(($val['sl']+$val['dj'])/$data_arr['close']);

                }else{
                    $ptitle = $val['cp'].'/USDT';
                    $price = Db::name('productdata')->where('Name',$ptitle)->value('Price');
                    if(!$price){
                        $url = "https://api.huobi.pro/market/detail/merged?symbol=".strtolower($val['cp'])."usdt";
                        $getdata = $this->curlfun($url);
                        $res = json_decode($getdata,1);



                        if($res['status']!='ok') continue;
                        $data_arr=$res['tick'];
                        $zhehe = floatval(($val['sl']+$val['dj'])*$data_arr['close']);

                    }else{
                        $zhehe = floatval(($val['sl']+$val['dj'])*$price);
                    }
                }


            }else{
                $zhehe = floatval(($val['sl']+$val['dj']));
            }

            $all_money += $zhehe;
        }


        $this->assign('all_money',$all_money);
        $this->assign('allbibi_money',$allbibi_money);
        $this->assign('bibi',$a);


        return $this->fetch();
    }

//     法币
    public function fabi(){

        $allbibi_money = 0;
        $all_money = 0;
//       合约钱包所有币种
        $a=Db::table("wp_zc")->field("cp,sl,dj")->where("yh",$this->uid)->where("qb",3)->select();
        foreach ($a as $key=>$val){
            $zhehe = 0;
            if($val['cp']!='USDT'){
                if($val['cp']=='HUSD'){
                    $url = "https://api.huobi.pro/market/detail/merged?symbol=usdthusd";
                    $getdata = $this->curlfun($url);
                    $res = json_decode($getdata,1);



                    if($res['status']!='ok') continue;
                    $data_arr=$res['tick'];
                    $zhehe = floatval(($val['sl']+$val['dj'])/$data_arr['close']);

                }else{
                    $ptitle = $val['cp'].'/USDT';
                    $price = Db::name('productdata')->where('Name',$ptitle)->value('Price');
                    if(!$price){
                        $url = "https://api.huobi.pro/market/detail/merged?symbol=".strtolower($val['cp'])."usdt";
                        $getdata = $this->curlfun($url);
                        $res = json_decode($getdata,1);



                        if($res['status']!='ok') continue;
                        $data_arr=$res['tick'];
                        $zhehe = floatval(($val['sl']+$val['dj'])*$data_arr['close']);


                    }else{
                        $zhehe = floatval(($val['sl']+$val['dj'])*$price);
                    }
                }


            }else{
                $zhehe = floatval(($val['sl']+$val['dj']));
            }

            $a[$key]['zhehe'] = $zhehe;

            $allbibi_money += $zhehe;
        }


        //       钱包所有币种
        $b=Db::table("wp_zc")->field("cp,sl,dj")->where("yh",$this->uid)->select();
        foreach ($b as $val){
            $zhehe = 0;
            if($val['cp']!='USDT'){
                if($val['cp']=='HUSD'){
                    $url = "https://api.huobi.pro/market/detail/merged?symbol=usdthusd";
                    $getdata = $this->curlfun($url);
                    $res = json_decode($getdata,1);



                    if($res['status']!='ok') continue;
                    $data_arr=$res['tick'];
                    $zhehe = floatval(($val['sl']+$val['dj'])/$data_arr['close']);

                }else{
                    $ptitle = $val['cp'].'/USDT';
                    $price = Db::name('productdata')->where('Name',$ptitle)->value('Price');
                    if(!$price){
                        $url = "https://api.huobi.pro/market/detail/merged?symbol=".strtolower($val['cp'])."usdt";
                        $getdata = $this->curlfun($url);
                        $res = json_decode($getdata,1);



                        if($res['status']!='ok') continue;
                        $data_arr=$res['tick'];
                        $zhehe = floatval(($val['sl']+$val['dj'])*$data_arr['close']);

                    }else{
                        $zhehe = floatval(($val['sl']+$val['dj'])*$price);
                    }
                }


            }else{
                $zhehe = floatval(($val['sl']+$val['dj']));
            }

            $all_money += $zhehe;
        }


        $this->assign('all_money',$all_money);
        $this->assign('allbibi_money',$allbibi_money);
        $this->assign('bibi',$a);


        return $this->fetch();

    }

//     合约
    public function heyue(){

        $allbibi_money = 0;
        $all_money = 0;
//       合约钱包所有币种
        $a=Db::table("wp_zc")->field("cp,sl,dj")->where("yh",$this->uid)->where("qb",2)->select();
        foreach ($a as $key=>$val){
            $zhehe = 0;
            if($val['cp']!='USDT'){
                if($val['cp']=='HUSD'){
                    $url = "https://api.huobi.pro/market/detail/merged?symbol=usdthusd";
                    $getdata = $this->curlfun($url);
                    $res = json_decode($getdata,1);



                    if($res['status']!='ok') continue;
                    $data_arr=$res['tick'];
                    $zhehe = floatval(($val['sl']+$val['dj'])/$data_arr['close']);

                }else{
                    $ptitle = $val['cp'].'/USDT';
                    $price = Db::name('productdata')->where('Name',$ptitle)->value('Price');
                    if(!$price){
                        $url = "https://api.huobi.pro/market/detail/merged?symbol=".strtolower($val['cp'])."usdt";
                        $getdata = $this->curlfun($url);
                        $res = json_decode($getdata,1);



                        if($res['status']!='ok') continue;
                        $data_arr=$res['tick'];
                        $zhehe = floatval(($val['sl']+$val['dj'])*$data_arr['close']);


                    }else{
                        $zhehe = floatval(($val['sl']+$val['dj'])*$price);
                    }
                }


            }else{
                $zhehe = floatval(($val['sl']+$val['dj']));
            }

            $a[$key]['zhehe'] = $zhehe;

            $allbibi_money += $zhehe;
        }


        //       钱包所有币种
        $b=Db::table("wp_zc")->field("cp,sl,dj")->where("yh",$this->uid)->select();
        foreach ($b as $val){
            $zhehe = 0;
            if($val['cp']!='USDT'){
                if($val['cp']=='HUSD'){
                    $url = "https://api.huobi.pro/market/detail/merged?symbol=usdthusd";
                    $getdata = $this->curlfun($url);
                    $res = json_decode($getdata,1);



                    if($res['status']!='ok') continue;
                    $data_arr=$res['tick'];
                    $zhehe = floatval(($val['sl']+$val['dj'])/$data_arr['close']);

                }else{
                    $ptitle = $val['cp'].'/USDT';
                    $price = Db::name('productdata')->where('Name',$ptitle)->value('Price');
                    if(!$price){
                        $url = "https://api.huobi.pro/market/detail/merged?symbol=".strtolower($val['cp'])."usdt";
                        $getdata = $this->curlfun($url);
                        $res = json_decode($getdata,1);



                        if($res['status']!='ok') continue;
                        $data_arr=$res['tick'];
                        $zhehe = floatval(($val['sl']+$val['dj'])*$data_arr['close']);

                    }else{
                        $zhehe = floatval(($val['sl']+$val['dj'])*$price);
                    }
                }


            }else{
                $zhehe = floatval(($val['sl']+$val['dj']));
            }

            $all_money += $zhehe;
        }


        $this->assign('all_money',$all_money);
        $this->assign('allbibi_money',$allbibi_money);
        $this->assign('bibi',$a);


        return $this->fetch();
    }

//    秒合约
    public function miaoheyue(){
        $allbibi_money = 0;
        $all_money = 0;
//       合约钱包所有币种
        $a=Db::table("wp_zc")->field("cp,sl,dj")->where("yh",$this->uid)->where("qb",4)->select();
        foreach ($a as $key=>$val){
            $zhehe = 0;
            if($val['cp']!='USDT'){
                if($val['cp']=='HUSD'){
                    $url = "https://api.huobi.pro/market/detail/merged?symbol=usdthusd";
                    $getdata = $this->curlfun($url);
                    $res = json_decode($getdata,1);



                    if($res['status']!='ok') continue;
                    $data_arr=$res['tick'];
                    $zhehe = floatval(($val['sl']+$val['dj'])/$data_arr['close']);

                }else{
                    $ptitle = $val['cp'].'/USDT';
                    $price = Db::name('productdata')->where('Name',$ptitle)->value('Price');
                    if(!$price){
                        $url = "https://api.huobi.pro/market/detail/merged?symbol=".strtolower($val['cp'])."usdt";
                        $getdata = $this->curlfun($url);
                        $res = json_decode($getdata,1);



                        if($res['status']!='ok') continue;
                        $data_arr=$res['tick'];
                        $zhehe = floatval(($val['sl']+$val['dj'])*$data_arr['close']);


                    }else{
                        $zhehe = floatval(($val['sl']+$val['dj'])*$price);
                    }
                }


            }else{
                $zhehe = floatval(($val['sl']+$val['dj']));
            }

            $a[$key]['zhehe'] = $zhehe;

            $allbibi_money += $zhehe;
        }


        //       钱包所有币种
        $b=Db::table("wp_zc")->field("cp,sl,dj")->where("yh",$this->uid)->select();
        foreach ($b as $val){
            $zhehe = 0;
            if($val['cp']!='USDT'){
                if($val['cp']=='HUSD'){
                    $url = "https://api.huobi.pro/market/detail/merged?symbol=usdthusd";
                    $getdata = $this->curlfun($url);
                    $res = json_decode($getdata,1);



                    if($res['status']!='ok') continue;
                    $data_arr=$res['tick'];
                    $zhehe = floatval(($val['sl']+$val['dj'])/$data_arr['close']);

                }else{
                    $ptitle = $val['cp'].'/USDT';
                    $price = Db::name('productdata')->where('Name',$ptitle)->value('Price');
                    if(!$price){
                        $url = "https://api.huobi.pro/market/detail/merged?symbol=".strtolower($val['cp'])."usdt";
                        $getdata = $this->curlfun($url);
                        $res = json_decode($getdata,1);



                        if($res['status']!='ok') continue;
                        $data_arr=$res['tick'];
                        $zhehe = floatval(($val['sl']+$val['dj'])*$data_arr['close']);

                    }else{
                        $zhehe = floatval(($val['sl']+$val['dj'])*$price);
                    }
                }


            }else{
                $zhehe = floatval(($val['sl']+$val['dj']));
            }

            $all_money += $zhehe;
        }


        $this->assign('all_money',$all_money);
        $this->assign('allbibi_money',$allbibi_money);
        $this->assign('bibi',$a);


        return $this->fetch();

    }

}

?>