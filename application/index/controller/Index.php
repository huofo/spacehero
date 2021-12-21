<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Cookie;

class Index extends Controller
{


    //控制白天夜晚开关按钮
    public function night(){
//        session_start();
        $vau =$_POST["yes"];
        if ($vau=="yes"){
            $sess=$_SESSION["night"]="yes";
            if ($sess){return "ok";}
        }
        if ($vau=="on"){
            $sess=$_SESSION["night"]="on";
            if ($sess){return "on";}
        }
    }


    public function __construct(){
        parent::__construct();
        $this->conf = getconf('');
        if($this->conf['is_close'] != 1){
            header('Location:/error.html');
        }
        $this->assign('conf',$this->conf);
        $this->token = md5(rand(1,100).time());
        $this->assign('token',$this->token);

        if(!isset($_SESSION['uid'])){
            //$this->error('请先登录！','index.php/index/user/login',1,1);
            $this->redirect('login/login?token='.$this->token);
        }


        //推荐
        $fid = input('get.fid');

        if($fid){
            $_SESSION['fid'] = $fid;
            if(!isset($_SESSION['uid'])){
                $this->redirect('register/register?token='.$this->token);

            }
        }

        if(isset($_SESSION['uid'])){
            $this->uid = $_SESSION['uid'];
            $this->user = db('userinfo')->where('uid',$this->uid)->find();
            if(!$this->user){
                unset($_SESSION['uid']);
                $this->redirect('login/login?token='.$this->token);
            }

            $uemail = cookie('uemail');

            if(!$uemail){
                cookie('uemail', $this->user['utel']);
            }
        }

    }

    /**
     * 首页 行情列表
     * @author lukui  2017-02-18
     * @return [type] [description]
     */
    public function index()
    {
        $tutorlist = db('guidance')->where('gshow = 1')->order('gtop desc,gid desc')->select();
        foreach ($tutorlist as $k => $v) {
            if(!empty($v['gavatar'])){
                $tutorlist[$k]['gavatar'] = '/public/uploads/'.$v['gavatar'];
            }
        }
        $articlelist = db('garticle')->field('id,gtitle,g_time')->where('g_show = 1')->order('g_top desc,id desc')->limit('0,4')->select();

        $noticelist = db('notice')->field('id,n_title,n_time')->where('n_show = 1')->order('n_sort desc,id desc')->limit('0,6')->select();
        $conf = db('conf')->where('id',1)->find();

        $autlist = db('advertisement')->field('picture')->where('type',1)->order('id asc')->select();
        foreach ($autlist as $k => $v){
            $autlist[$k]['key'] = $k+1;
        }
        $actlist = db('advertisement')->field('picture')->where('type',2)->order('id asc')->select();
        $str_p = '';
        $plist =array();
        foreach ($actlist as $k => $v){
            $actlist[$k]['key'] = 'p'.($k+1);
            $plist[]= '"'.$actlist[$k]['key'].'"';
        }
        //产品信息
        $pro = db('productdata')->where('isdelete',0)->order('pid desc')->limit(6)->select();
        $this->assign('prodata',$pro);
        //涨跌榜
        $pro_zd = db('productdata')->where('isdelete',0)->order('DiffRate desc')->select();
        $this->assign('pro_zd',$pro_zd);

        //成交榜
        $pro_cj = db('productdata')->where('isdelete',0)->order('vol desc')->select();

        foreach($pro_cj as $key=>$value){
            $pro_cj[$key]['vol']=sprintf("%.2f",$value['vol']*6.8/100000000);
        }

        if(isset($_SESSION['uid'])){
            $user = db('userinfo')->where('uid',$_SESSION['uid'])->find();
            $msg_nums = Db::name('consult_message')->where("sender = 1 AND receiver = '$_SESSION[uid]' AND is_read = 0")->count();
            $this->assign('msg_nums',$msg_nums);
            $this->assign('user',$user);
        }else{
            $this->assign('msg_nums',0);
            $this->assign('user',array());
        }


        //控制白天夜间模式样式文件
        $a=empty($_SESSION["night"]);
        if($a=="1"){$_SESSION["night"]="on";}
        if ($_SESSION["night"]=="yes"){
            $yes="yes";$this->assign('yes',$yes);

        }else if ($_SESSION["night"]=="on"){
            $on="on";$this->assign('yes',$on);
        }else{$this->assign('yes',"abc");}

        $this->assign('pro_cj',$pro_cj);


        $langage = cookie('think_var');


        if(!$langage){
            cookie('think_var', 'usd');
            $langage = 'usd';
        }

        if($langage=='usd'){
            $langagename = "English";
        }
        elseif($langage=='cny'){
            $langagename = "中文";
        }
        elseif($langage=='jpy'){
            $langagename = "日本語";
        }
        elseif($langage=='krw'){
            $langagename = "한글";
        }
        elseif($langage=='try'){
            $langagename = "Türkçe";
        }else{
            $langage='try';
            cookie('think_var', 'try');
            $langagename = "Türkçe";
        }



        $this->assign('langagename', $langagename);
        $this->assign('langage', strtoupper($langage));

        $plist = array_reverse($plist);
        $plist = implode(",", $plist);
        $pull_out = array_shift($actlist);
        array_push($actlist,$pull_out);
        $actlist = array_reverse($actlist);
        $fixinfo = db('advertisement')->field('picture')->where('type',3)->find();
        $this->assign('autlist',$autlist);
        $this->assign('actlist',$actlist);
        $this->assign('fixinfo',$fixinfo);
        $this->assign('plist',$plist);
        $this->assign('conf',$conf);
        $this->assign('gonggao',$this->conf['web_notice']);
        $this->assign('noticelist',$noticelist);
        $this->assign('articlelist',$articlelist);
        $this->assign('tutorlist',$tutorlist);
        $this->assign('logo_src', str_replace("\\","/",getconf('web_logo')));

        $config = db('conf')->field('service_number,service_qq,ally_number,ally_qq')->where('id',1)->find();
        $href = 'http://wpa.qq.com/msgrd?v=3&uin='.$config['service_qq'].'&site=qq&menu=yes';
        $this->assign('config',$config);
        $this->assign('href',$href);
        $this->assign('app_download',getconf('app_download'));
        return $this->fetch();
    }
    /**
     * 二维码
     * @author lukui  2017-09-04
     * @return [type] [description]
     */
    public function ercode()
    {
        if(!isset($_SESSION['uid'])){
            unset($_SESSION['uid']);
            $this->redirect('login/login?token='.$this->token);
        }


        $user = $this->user;
        //推广二维码
        if($user['otype'] == 101){
            $oid = $this->uid;
        }else{
            $oid = $user['oid'] ;
        }
        $oid_url =  "http://".$_SERVER['SERVER_NAME'].'/index/register/register?fid='.$this->uid;
        $this->assign('oid_url',$oid_url);
        $this->assign('oid',$this->uid);
        return $this->fetch();

    }



    public function getdata_index()
    {
        $prodata = db('productdata')->where(1)->select();
        $this->ajaxReturn(['status'=>1,'data'=>$prodata]);
    }


    public function ajaxindexzd()
    {

        //获取产品信息
        $pro = Db::name('productinfo')->alias('pi')->field('pi.pid,pi.ptitle,pd.Price,pd.UpdateTime,pd.*')
            ->join('__PRODUCTDATA__ pd','pd.pid=pi.pid')
            ->where('pi.isdelete',0)->order('pd.DiffRate desc')->select();
        $newpro = array();
        foreach ($pro as $k => $v) {
            $newpro[$v['pid']] = $pro[$k];
            $newpro[$v['pid']]['UpdateTime'] = date('H:i:s',$v['UpdateTime']);


            if($v['Price'] < cookie('pidzd'.$v['pid']) ){  //跌了
                $newpro[$v['pid']]['isup'] = 0;
            }elseif($v['Price'] > cookie('pidzd'.$v['pid']) ){  //涨了
                $newpro[$v['pid']]['isup'] = 1;
            }else{  //没跌没涨
                $newpro[$v['pid']]['isup'] = 2;
            }
            cookie('pidzd'.$v['pid'],$v['Price']);

        }
        $res=array();
        $res['zd'] = $newpro;


        //获取产品信息
        $pro = Db::name('productinfo')->alias('pi')->field('pi.pid,pi.ptitle,pd.Price,pd.UpdateTime,pd.*')
            ->join('__PRODUCTDATA__ pd','pd.pid=pi.pid')
            ->where('pi.isdelete',0)->order('pd.vol desc')->select();
        $newpro = array();
        foreach ($pro as $k => $v) {
            $newpro[$v['pid']] = $pro[$k];
            $newpro[$v['pid']]['UpdateTime'] = date('H:i:s',$v['UpdateTime']);


            if($v['Price'] < cookie('pidcj'.$v['pid']) ){  //跌了
                $newpro[$v['pid']]['isup'] = 0;
            }elseif($v['Price'] > cookie('pidcj'.$v['pid']) ){  //涨了
                $newpro[$v['pid']]['isup'] = 1;
            }else{  //没跌没涨
                $newpro[$v['pid']]['isup'] = 2;
            }
            cookie('pidcj'.$v['pid'],$v['Price']);

            $newpro[$v['pid']]['vol']=sprintf("%.2f",$v['vol']*6.8/100000000).\think\Lang::get('ind_yi');

        }

        $res['cj'] = $newpro;

        return base64_encode(json_encode($res));
    }





    public function notice(){
        $id = input('id');
        if(intval($id)){
            $result = db('notice')->where('n_show = 1 and id = '.$id)->find();
            if(empty($result)){
                $this->redirect('index/index');
            }else{
                $result['content'] = htmlspecialchars_decode($result['n_content']);
                unset($result['n_content']);
                $this->assign('result',$result);
                return $this->fetch();
            }
        }else{
            $this->redirect('index/index');
        }
    }

    public function article(){
        $id = input('id');
        if(intval($id)){
            $result = db('garticle')
                ->alias('a')
                ->field('a.*,g.gname')
                ->join('__GUIDANCE__ g','a.gid=g.gid')
                ->where('g_show = 1 and id = '.$id)
                ->find();
            if(empty($result)){
                $this->redirect('index/index');
            }else{
                $result['content'] = htmlspecialchars_decode($result['gcontent']);
                unset($result['gcontent']);
                $this->assign('result',$result);
                return $this->fetch();
            }
        }else{
            $this->redirect('index/index');
        }
    }

    public function guidance(){
        $guilist = db('guidance')->where('gshow',1)->order('gtop desc,gid desc')->select();
        foreach ($guilist as $k => $v) {
            $guilist[$k]['gavatar'] = '/public/uploads/'.$v['gavatar'];
            $guilist[$k]['key'] = $k+1;
        }
        $this->assign('guilist',$guilist);
        return $this->fetch();
    }

    public function gui_ajax(){
        $gid = input('gid');
        if(is_numeric($gid) && $gid>0 && !is_float($gid)){
            $result = db('guidance')->field('gid,gname,gavatar,gskill,gfield')->where('gid>'.$gid." and gshow = 1")->order('gid asc')->find();
            if(!$result){
                $result = db('guidance')->field('gid,gname,gavatar,gskill,gfield')->where('gid',db('guidance')->field('min(gid) as gid')->where('gshow = 1')->value('gid'))->order('gid asc')->find();
            }
            if(!empty($result['gavatar'])){
                $result['gavatar'] = '/public/uploads/'.$result['gavatar'];
            }
            $msg = array(
                'id'=>$result['gid'],
                'name'=>$result['gname'],
                'photo'=>$result['gavatar'],
                'skill'=>$result['gskill'],
                'lord'=>$result['gfield']
            );
            exit(json_encode($msg));
        }
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
        $data['index'] = \think\Lang::get('ti_sy');
        $data['hangqing'] = \think\Lang::get('iin_sssj');
        $data['jiaoyijilu'] = \think\Lang::get('iin_jyjl');
        $data['shangpinmingcheng'] = \think\Lang::get('ind_mc');
        $data['xianjia'] = \think\Lang::get('gs_xj');
        $data['zuidi'] = \think\Lang::get('iin_zd');
        $data['zuigao'] = \think\Lang::get('iin_zg');
        $data['xianjia'] = \think\Lang::get('gs_xj');
        $data['xianjia'] = \think\Lang::get('gs_xj');


        $res = base64_encode(json_encode($data));
        return $res;
    }


}
