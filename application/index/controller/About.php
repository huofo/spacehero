<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Cookie;

class About extends Controller
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
    }

    public function about()
    {
        $langage = cookie('think_var');
        if($langage=='cny'){
            $aboutlist = db('about')->field('a_title,a_content,id')->where('a_show = 1 and id in(4,12,13,14)')->order('a_sort desc,id desc')->limit('0,4')->select();
        }elseif ($langage=='usd'){
            $aboutlist = db('about')->field('a_title,a_content,id')->where('a_show = 1 and id in(9,21,22,23)')->order('a_sort desc,id desc')->limit('0,4')->select();
        }
        elseif ($langage=='jpy'){
            $aboutlist = db('about')->field('a_title,a_content,id')->where('a_show = 1 and id in(10,18,19,20)')->order('a_sort desc,id desc')->limit('0,4')->select();
        }
        elseif ($langage=='krw'){
            $aboutlist = db('about')->field('a_title,a_content,id')->where('a_show = 1 and id in(11,15,16,17)')->order('a_sort desc,id desc')->limit('0,4')->select();
        }else{
            $aboutlist = db('about')->field('a_title,a_content,id')->where('a_show = 1 and id in(24,25,26,27)')->order('a_sort desc,id desc')->limit('0,4')->select();
        }

        foreach ($aboutlist as $key => $value) {
            $aboutlist[$key]['content'] = htmlspecialchars_decode($value['a_content']);
        }
        $this->assign('aboutlist',$aboutlist);
        return $this->fetch();
    }


    public function aboutdetail(){
        $id = input('param.id');
        $aboutdetail = db('about')->where('id',$id)->find();

        $aboutdetail['content'] = htmlspecialchars_decode($aboutdetail['a_content']);
        $this->assign('aboutdetail',$aboutdetail);
        return $this->fetch();

    }
}
