<?php
namespace app\wap\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Cookie;
class Zichan extends controller
{
    public function __construct(){
        parent::__construct();
        $this->conf = getconf('');
        if($this->conf['is_close'] != 1){
            header('Location:/error.html');
        }
        $this->assign('conf',$this->conf);
        $this->token = md5(rand(1,100).time());
        $this->assign('token',$this->token);

        $request= \think\Request::instance();
        $module = $request->module();//模块名
        $action = $request->action();//方法名
        $un_need_login_action = [];
//var_dump($_SESSION);die;
        if(!in_array($action,$un_need_login_action)){
            //推荐
            $fid = input('get.fid');

            if($fid){
                $_SESSION['fid'] = $fid;
                if(!isset($_SESSION['uid'])){
                    $this->redirect('Denglu/zc?token='.$this->token);

                }
            }

            if(!isset($_SESSION['uid'])){

                $this->redirect('Denglu/dl?token='.$this->token);
            }

            $this->uid = $_SESSION['uid'];
            $this->user = db('userinfo')->where('uid',$this->uid)->find();
            if(!$this->user){
                unset($_SESSION['uid']);
                $this->redirect('Denglu/dl?token='.$this->token);
            }
        }

        $langage = cookie('think_var');
        if(!$langage){
            cookie('think_var', 'en-us');
        }
        $langage = cookie('think_var');
        if($langage=='en-us'){
            $langagename = "English";
        }
        elseif($langage=='zh-cn'){
            $langagename = "简体中文";
        }
        elseif($langage=='ja-jp'){
            $langagename = "日本語";
        }
        elseif($langage=='ko-kr'){
            $langagename = "한국어";
        }
        $this->assign('langagename', $langagename);
    }
    public function bibi(){

        $allbibi_money = 0;
        $all_money = 0;
//       币币钱包所有币种
        $a=Db::table("wp_zc")->field("id,cp,sl,dj")->where("yh",$this->uid)->where("qb",1)->select();


        $can_rechage_bi_type = ['BTC','USDT','ETH'];


        foreach ($a as $key=>$val){
            $zhehe = 0;

            if(in_array($val['cp'],$can_rechage_bi_type)){
                $a[$key]['can_re'] = 1;
            }else{
                $a[$key]['can_re'] = 0;
            }

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

        $langage = cookie('think_var');
        if(!$langage){
            cookie('think_var', 'en-us');
        }
        if($langage=='en-us'){
            $langagename = "English";
        }
        elseif($langage=='zh-cn'){
            $langagename = "简体中文";
        }
        elseif($langage=='ja-jp'){
            $langagename = "日本語";
        }
        elseif($langage=='ko-kr'){
            $langagename = "한국어";
        }
        $this->assign('langagename', $langagename);

        $this->assign('all_money',$all_money);
        $this->assign('allbibi_money',$allbibi_money);
        $this->assign('bibi',$a);

        return $this->fetch();
    }

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

        $langage = cookie('think_var');
        if(!$langage){
            cookie('think_var', 'en-us');
        }
        if($langage=='en-us'){
            $langagename = "English";
        }
        elseif($langage=='zh-cn'){
            $langagename = "简体中文";
        }
        elseif($langage=='ja-jp'){
            $langagename = "日本語";
        }
        elseif($langage=='ko-kr'){
            $langagename = "한국어";
        }
        $this->assign('langagename', $langagename);

        $this->assign('all_money',$all_money);
        $this->assign('allbibi_money',$allbibi_money);
        $this->assign('bibi',$a);

        return $this->fetch();
    }

    public function change_log(){
        $name = input('name');
        if($name){
            $where['name'] = $name;
        }
        $type = input('type');
        $type_name = ['','币币','合约','法币','秒合约'];
        if($type){
            $where['type'] = $type;
        }
        $where['uid'] = $this->uid;

        $logs = Db('record')->where($where)->order('time desc')->paginate(10, false, [
            'query' => request()->param(),//不丢失已存在的url参数
        ]);
        $pages = $logs->render();
        $data = $logs->all();

        foreach ($data as $k=>$v){
            $data[$k]['key'] = $k;
        }


        $this->assign(
            [
                'logs'=>$logs,
                'pages'=>$pages,
                'data'=>$data,
                'biname'=>$name,
                'type'=>$type_name[$type]
            ]
        );

        $langage = cookie('think_var');
        if(!$langage){
            cookie('think_var', 'en-us');
        }
        if($langage=='en-us'){
            $langagename = "English";
        }
        elseif($langage=='zh-cn'){
            $langagename = "简体中文";
        }
        elseif($langage=='ja-jp'){
            $langagename = "日本語";
        }
        elseif($langage=='ko-kr'){
            $langagename = "한국어";
        }
        $this->assign('langagename', $langagename);

        return $this->fetch();
    }

    public function url(){
        $name = input('param.name');
        $url = '';
        $html = '';
        if($name == 'USDT'){

            $url_erc20  = $this->conf['usdt_url'];
            $url_omin  = $this->conf['usdturl_omni'];
            $url_trc20  = $this->conf['usdturl_trc20'];
            $arr = [
                'ERC20'=>  $url_erc20,
                'OMIN'=> $url_omin,
                'TRC20'=>$url_trc20
            ];
            $i = 0;
            foreach ($arr as $k=>$v){
                //$img = 'http://api.k780.com:88/?app=qr.get&data='.$v.'&appkey=56489&sign=9f9d153160dc83b01126f1217ac7e71a';
                
                $img = "https://api.qrserver.com/v1/create-qr-code/?size=150%C3%97150&data=".$v;
                if($i==0){
                    $html .= '<div class="bi-cb-tc-div2-ewm">
								<img src="'.$img.'" />
						</div>
						<div class="bi-cb-tc-div2">
							<div><input name="usdt_type" checked type="radio" value="'.$k.'">'.$k.'：'.$v.'</div>
							<span data-clipboard-text="'.$v.'" class="copy_address" onclick="copy_id(\''.$k.'\')" id="copy_btn'.$k.'">复制</span>
							<span>二维码</span>
						</div>';
                }else{
                    $html .= '<div class="bi-cb-tc-div2-ewm">
								<img src="'.$img.'" />
						</div>
						<div class="bi-cb-tc-div2">
							<div><input name="usdt_type" type="radio" value="'.$k.'">'.$k.'：'.$v.'</div>
							<span data-clipboard-text="'.$v.'" class="copy_address" onclick="copy_id(\''.$k.'\')" id="copy_btn'.$k.'">复制</span>
							<span>二维码</span>
						</div>';
                }

                $i++;
            }
        }elseif ($name=='ETH'){
            $url = $this->conf['ethurl'];

            //$img = 'http://api.k780.com:88/?app=qr.get&data='.$url.'&appkey=56489&sign=9f9d153160dc83b01126f1217ac7e71a';
            $img = "https://api.qrserver.com/v1/create-qr-code/?size=150%C3%97150&data=".$url;
            $html .= '<div class="bi-cb-tc-div2-ewm">
								<img src="'.$img.'" />
						</div>
						<div class="bi-cb-tc-div2">
							<div>'.$url.'</div>
							<span data-clipboard-text="'.$url.'" class="copy_address" onclick="copy_id(\''.$name.'\')" id="copy_btn'.$name.'" onclick="copy_id('.$name.')" id="copy'.$name.'">复制</span>
							<span>二维码</span>
						</div>';
        }elseif ($name == 'BTC'){
            $url = $this->conf['btcurl'];

            //$img = 'http://api.k780.com:88/?app=qr.get&data='.$url.'&appkey=56489&sign=9f9d153160dc83b01126f1217ac7e71a';
            
             $img = "https://api.qrserver.com/v1/create-qr-code/?size=150%C3%97150&data=".$url;
            $html .= '<div class="bi-cb-tc-div2-ewm">
								<img src="'.$img.'" />
						</div>
						<div class="bi-cb-tc-div2">
							<div>'.$url.'</div>
							<span data-clipboard-text="'.$url.'" class="copy_address" onclick="copy_id(\''.$name.'\')" id="copy_btn'.$name.'">复制</span>
							<span>二维码</span>
						</div>';
        }else{
            exit('error');
        }

//        $urltext = $url;
//        $url = 'http://api.k780.com:88/?app=qr.get&data='.$url.'&appkey=56489&sign=9f9d153160dc83b01126f1217ac7e71a';
//        $res = array(
//
//            "html"=>$html,
//
//        );

        exit( base64_encode(json_encode(['data'=>$html])));
    }

    public function tx_msg(){

        $name = input('name');

        $map['qb'] = 1;
        $map['cp'] = trim($name);
        $map['yh'] = $this->uid;

        $account = Db::name('zc')->where($map)->find();
        //var_dump($account);die;
        $account = $account?$account['sl']:0;
//        if(!$account){
//            $this->redirect('assets/bibi');
//        }
        $sxf  = $this->conf['sc_sxfee'];
        $sxfee  =  explode("|",$sxf);

        if(in_array($name,array('USDT','BTC','ETH','HUSD'))){
            $key =  array_search($name,array('USDT','BTC','ETH','HUSD'));
            $tisxf = $sxfee[$key];
        }else{
            $tisxf = $sxfee[4];//每笔手续费
        }

        $ti_zuixiao = $this->conf['ti_zuixiao'];
        $tizuixiao  =  explode("|",$ti_zuixiao);


        if(in_array($name,array('USDT','BTC','ETH','HUSD'))){
            $key =  array_search($name,array('USDT','BTC','ETH','HUSD'));
            $tizx = $tizuixiao[$key];
        }else{
            $tizx = $tizuixiao[4];//最小提现
        }

        echo json_encode(array('min_num'=>$tizx,'fee'=>$tisxf,'has_money'=>$account));
    }

    public function fabi(){
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

        $langage = cookie('think_var');
        if(!$langage){
            cookie('think_var', 'en-us');
        }
        if($langage=='en-us'){
            $langagename = "English";
        }
        elseif($langage=='zh-cn'){
            $langagename = "简体中文";
        }
        elseif($langage=='ja-jp'){
            $langagename = "日本語";
        }
        elseif($langage=='ko-kr'){
            $langagename = "한국어";
        }
        $this->assign('langagename', $langagename);

        $this->assign('all_money',$all_money);
        $this->assign('allbibi_money',$allbibi_money);
        $this->assign('bibi',$a);
        return $this->fetch();
    }

    public function miaoheyue(){
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

        $langage = cookie('think_var');
        if(!$langage){
            cookie('think_var', 'en-us');
        }
        if($langage=='en-us'){
            $langagename = "English";
        }
        elseif($langage=='zh-cn'){
            $langagename = "简体中文";
        }
        elseif($langage=='ja-jp'){
            $langagename = "日本語";
        }
        elseif($langage=='ko-kr'){
            $langagename = "한국어";
        }
        $this->assign('langagename', $langagename);

        $this->assign('all_money',$all_money);
        $this->assign('allbibi_money',$allbibi_money);
        $this->assign('bibi',$a);
        return $this->fetch();
    }

    public function huazhuan(){
        $name  = input('name');
        $type = input('type');
        $name = $name?$name:'BTC';
        $type = $type?$type:1;

        //$pro  = Db::name('productinfo')->where('isdelete',0)->select();
        $pro=Db::table("wp_zc")->field("id,cp,sl,dj")->where("yh",$this->uid)->where("qb",$type)->select();
        $bi_arr = [];
        foreach ($pro as $k=>$v){
            //$title = explode('/',$v['ptitle']);
            $bi_arr[] = $v['cp'];
        }

        $to_arr = [\think\Lang::get('ti_bibi'),\think\Lang::get('ti_hy'),\think\Lang::get('bii_fb'),\think\Lang::get('bii_mhy')];

        $map['qb'] = $type;
        $map['cp'] = trim($name);
        $map['yh'] = $this->uid;

        $account = Db::name('zc')->where($map)->find();

        $langage = cookie('think_var');
        if(!$langage){
            cookie('think_var', 'en-us');
        }
        if($langage=='en-us'){
            $langagename = "English";
        }
        elseif($langage=='zh-cn'){
            $langagename = "简体中文";
        }
        elseif($langage=='ja-jp'){
            $langagename = "日本語";
        }
        elseif($langage=='ko-kr'){
            $langagename = "한국어";
        }
        $this->assign('langagename', $langagename);

        $this->assign('has_money',$account['sl']);
        $this->assign('to_arr',$to_arr);
        $this->assign('bi',$bi_arr);
        $this->assign('type',$type);
        $this->assign('biname',$name);
        return $this->fetch();
    }
    public function select_money(){
        $type = input('type');
        $name  = input('name');

        $map['qb'] = $type;
        $map['cp'] = trim($name);
        $map['yh'] = $this->uid;

        $account = Db::name('zc')->where($map)->find();
        $account = $account?$account['sl']:0;
        echo json_encode(['money'=>$account]);die;
    }
    public function cwjl(){
        return $this->fetch();
    }

    public function jilu(){
        return $this->fetch();
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
}