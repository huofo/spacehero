<?php 
namespace app\index\controller;
use think\Controller;
use think\Db;

class Getdata extends Controller{

	public function __construct(){
		parent::__construct();
		$this->minute = strtotime(date('Y-m-d H:i',time()));
		
		$this->now_time = time();
		$this->start_time = mktime(0,0,0,date('m'),date('d'),date('Y'));
		$this->today =  strtotime(date('Y-m-d',$this->now_time));
		
		
	}
	
	/*
	public function fudong($price,$pro)
	{
		
		
		$point_top = $pro['point_top'];
		
		$FloatLength = getFloatLength($point_top);
		$jishu_rand = pow(10,$FloatLength);

		$point_top = $point_top * $jishu_rand;
		$rand = rand(-1*$point_top,$point_top)/$jishu_rand;
		
		
		$price = $price + $rand;
		
		return $price;
	}
*/

    public function fudong($price,$pro)
	{
		
		$point_low = $pro['point_low'];
		$point_top = $pro['point_top'];
		
		$FloatLength = getFloatLength($point_top);
		$jishu_rand = pow(10,$FloatLength);
		
	    $point_low = $point_low * $jishu_rand;
		$point_top = $point_top * $jishu_rand;
		
		
		$rand = rand($point_low,$point_top)/$jishu_rand;
		
		
		$price = $price + $rand;
		
		return $price;
	}
	
	
	public function get()
	{
		//exit;
		//产品列表
		$pro = db('productinfo')->where(['isdelete'=>0,'is_fb'=>1])->select();
	
		if(!isset($pro)) return false;
		foreach ($pro as $k => $v) 
		{
            /*$isopen = ChickIsOpen($v['pid']);
            if(!$isopen)
            {
                continue;
            }*/

            
			if($v['is_fb']==1)
			{
				$dir = "runtime/get";
			    $this->mkdirs($dir, $mode = 0777);
				$nowtime = time();//当前时间
				if(file_exists("runtime/get/data".$v['procode'].".php"))
				{
					$date = file_get_contents("runtime/get/data".$v['procode'].".php");
				}else
				{
					$date = 0;
					file_put_contents("runtime/get/data".$v['procode'].".php",$date);
				}
					
				if($date==''||$date<='0'){
				
					$id = db("msg")->where(array('type'=>$v['procode']))->max('id');
			    	$date= db("msg")->where(array('id'=>$id))->value('price');
			
				}
				
				if(file_exists("runtime/get/fengkong".$v['procode'].".php"))
				{
					$fengkong= file_get_contents("runtime/get/fengkong".$v['procode'].".php");
					if($fengkong==''){
						$fengkong=0;
					}
				}else
				{
					
					$fengkong=0;
					file_put_contents("runtime/get/fengkong".$v['procode'].".php",$fengkong);
				}
				
				echo $fengkong;
				echo "<br>";
				
				echo $date;
				echo "<br>";
			
				
				$date = $this->fudong($date,$v)+$fengkong; 
				
			

				
				echo $date;
				echo "<br>";
				
				file_put_contents("runtime/get/data".$v['procode'].".php",$date);
				
				if(file_exists("runtime/get/fengkong".$v['procode'].".php"))
				{
					if($fengkong!=0)
					{
						file_put_contents("runtime/get/fengkong".$v['procode'].".php",0);
					}
				}
				
				//print_r($date);exit;
				
				
				$mintime = strtotime(date('Y-m-d H:i',$nowtime));
				$daytime = strtotime(date('Y-m-d',$nowtime));
				if($date){
					$data['type'] = $v['procode'];
					$data['price'] = $date;
					$data['createtime']= $nowtime;
					$data['mintime'] = $mintime;
					$data['daytime'] = $daytime;
					db('msg')->insert($data);
					$this->data($v['procode'],$date);
				}
			}
		}	
	}
	
	
	public function mkdirs($dir, $mode = 0777) {
		if (is_dir($dir) || @mkdir($dir, $mode))
			return TRUE;
		if (!mkdirs(dirname($dir), $mode))
			return FALSE;
		return @mkdir($dir, $mode);
	}
	
	
	public function data($type,$close)
	{
		$cha = $this->now_time-$this->start_time;
		
		//1分钟K线
		$nearmin = floor($cha/60)*60+$this->start_time;
		$snearmin = $nearmin-60;
		if(db('min1msg')->where(array("mintime"=>$nearmin,"type"=>$type))->count()){
			//存在
			$id = db("min1msg")->where(array("mintime"=>$nearmin,"type"=>$type))->value('id');
			$thisdata['high']= db("msg")->where(array('mintime'=>$nearmin,'type'=>$type))->max('price');
			$thisdata['low'] = db("msg")->where(array('mintime'=>$nearmin,'type'=>$type))->min('price');
			$thisdata['close']= $close;
			db('min1msg')->where('id',$id)->update($thisdata);
			 
		}else{
			//不存在
			$adddata['type']=$type;
			$adddata['creattime']=time();
			$adddata['mintime']=$nearmin;
			$adddata['daytime']=$this->today;
			$adddata['high']= db("msg")->where(array('mintime'=>$nearmin,'type'=>$type))->max('price');
			$adddata['low'] = db("msg")->where(array('mintime'=>$nearmin,'type'=>$type))->min('price');
			//$openid = db("msg")->where(array('mintime'=>$nearmin,'type'=>$type))->min('id');
			
			if(db('min1msg')->where(array("mintime"=>$snearmin,"type"=>$type))->count()){
				$adddata['open']= db('min1msg')->where(array("mintime"=>$snearmin,"type"=>$type))->value('close');
				
			}else{
				
				$openid = db("msg")->where(array('mintime'=>$snearmin,'type'=>$type))->max('id');
				$adddata['open']= db("msg")->where(array('id'=>$openid))->value('price');
			}
			if(empty($adddata['open'])){
                $openid = db("msg")->where(array('type'=>$type))->max('id');
                $adddata['open']= db("msg")->where(array('id'=>$openid))->value('price');
            }
			
			
			$adddata['close']= $close;
			db('min1msg')->insert($adddata);
		}
		//删除秒表


        $delerow = db('msg')->field("id")->where("type = '".$type."'")->order("id desc")->limit(100)->select();

       $zuixiao =  min($delerow);
     	db('msg')->where("type = '".$type."' and id <'$zuixiao[id]'")->delete();
		
		
		
		//5分钟K线
		$nearmin = floor($cha/300)*300+$this->start_time;
		$snearmin = $nearmin-300;
		if(db('min5msg')->where(array("mintime"=>$nearmin,"type"=>$type))->count()){
			//存在
			$id = db("min5msg")->where(array("mintime"=>$nearmin,"type"=>$type))->value('id');
			$where = "mintime >= '".$nearmin."' and type = '".$type."'";
			$thisdata['high']= db("min1msg")->where($where)->max('high');
			$thisdata['low'] = db("min1msg")->where($where)->min('low');
			$thisdata['close']= $close;
			db('min5msg')->where('id',$id)->update($thisdata);
			 
		}else{
			//不存在
			$adddata['type']=$type;
			$adddata['creattime']=time();
			$adddata['mintime']=$nearmin;
			$adddata['daytime']=$this->today;	
			$where = "mintime >= '".$nearmin."' and type = '".$type."'";
			$adddata['high']= db("min1msg")->where($where)->max('high');
			$adddata['low'] = db("min1msg")->where($where)->min('low');
			if(db('min5msg')->where(array("mintime"=>$snearmin,"type"=>$type))->count()){
				$adddata['open']= db('min5msg')->where(array("mintime"=>$snearmin,"type"=>$type))->value('close');
				
			}else{
				$openid = db("min1msg")->where($where)->min('id');
				$adddata['open']= db("min1msg")->where(array('id'=>$openid))->value('open');	
			}
			
			
			$adddata['close']= $close;
			db('min5msg')->insert($adddata);
		}
		
		//删除分钟表

        $delerow = db('min1msg')->field("id")->where("type = '".$type."'")->order("id desc")->limit(150)->select();

        $zuixiao =  min($delerow);
        db('min1msg')->where("type = '".$type."' and id <'$zuixiao[id]'")->delete();
		
		
		//15分钟K线
		$nearmin = floor($cha/900)*900+$this->start_time;
		$snearmin = $nearmin-900;
		if(db('min15msg')->where(array("mintime"=>$nearmin,"type"=>$type))->count()){
			//存在
			$id = db("min15msg")->where(array("mintime"=>$nearmin,"type"=>$type))->value('id');
			$where = "mintime >= '".$nearmin."' and type = '".$type."'";
			$thisdata['high']= db("min5msg")->where($where)->max('high');
			$thisdata['low'] = db("min5msg")->where($where)->min('low');
			$thisdata['close']= $close;
			db('min15msg')->where('id',$id)->update($thisdata);
			 
		}else{
			//不存在
			$adddata['type']=$type;
			$adddata['creattime']=time();
			$adddata['mintime']=$nearmin;
			$adddata['daytime']=$this->today;	
			$where = "mintime >= '".$nearmin."' and type = '".$type."'";
			$adddata['high']= db("min5msg")->where($where)->max('high');
			$adddata['low'] = db("min5msg")->where($where)->min('low');
			
			if(db('min15msg')->where(array("mintime"=>$snearmin,"type"=>$type))->count()){
				$adddata['open']= db('min15msg')->where(array("mintime"=>$snearmin,"type"=>$type))->value('close');
				
			}else{
				
				$openid = db("min5msg")->where($where)->min('id');
				$adddata['open']= db("min5msg")->where(array('id'=>$openid))->value('open');
			}
			$adddata['close']= $close;
			db('min15msg')->insert($adddata);
		}
		


        $delerow = db('min5msg')->field("id")->where("type = '".$type."'")->order("id desc")->limit(150)->select();

        $zuixiao =  min($delerow);
        db('min5msg')->where("type = '".$type."' and id <'$zuixiao[id]'")->delete();
		
		//30分钟K线
		$nearmin = floor($cha/1800)*1800+$this->start_time;
		$snearmin = $nearmin-1800;
		if(db('min30msg')->where(array("mintime"=>$nearmin,"type"=>$type))->count()){
			//存在
			$id = db("min30msg")->where(array("mintime"=>$nearmin,"type"=>$type))->value('id');
			$where = "mintime >= '".$nearmin."' and type = '".$type."'";
			$thisdata['high']= db("min15msg")->where($where)->max('high');
			$thisdata['low'] = db("min15msg")->where($where)->min('low');
			$thisdata['close']= $close;
			db('min30msg')->where('id',$id)->update($thisdata);
			 
		}else{
			//不存在
			$adddata['type']=$type;
			$adddata['creattime']=time();
			$adddata['mintime']=$nearmin;
			$adddata['daytime']=$this->today;	
			$where = "mintime >= '".$nearmin."' and type = '".$type."'";
			$adddata['high']= db("min15msg")->where($where)->max('high');
			$adddata['low'] = db("min15msg")->where($where)->min('low');
			if(db('min30msg')->where(array("mintime"=>$snearmin,"type"=>$type))->count()){
				$adddata['open']= db('min30msg')->where(array("mintime"=>$snearmin,"type"=>$type))->value('close');
				
			}else{
				$openid = db("min15msg")->where($where)->min('id');
				$adddata['open']= db("min15msg")->where(array('id'=>$openid))->value('open');
			}
			$adddata['close']= $close;
			db('min30msg')->insert($adddata);
		}
		


        $delerow = db('min15msg')->field("id")->where("type = '".$type."'")->order("id desc")->limit(150)->select();

        $zuixiao =  min($delerow);
        db('min15msg')->where("type = '".$type."' and id <'$zuixiao[id]'")->delete();
		
		//60分钟K线
		$nearmin = floor($cha/3600)*3600+$this->start_time;
		$snearmin = $nearmin-3600;
		if(db('min60msg')->where(array("mintime"=>$nearmin,"type"=>$type))->count()){
			//存在
			$id = db("min60msg")->where(array("mintime"=>$nearmin,"type"=>$type))->value('id');
			$where = "mintime >= '".$nearmin."' and type = '".$type."'";
			$thisdata['high']= db("min30msg")->where($where)->max('high');
			$thisdata['low'] = db("min30msg")->where($where)->min('low');
			$thisdata['close']= $close;
			db('min60msg')->where('id',$id)->update($thisdata);
			 
		}else{
			//不存在
			$adddata['type']=$type;
			$adddata['creattime']=time();
			$adddata['mintime']=$nearmin;
			$adddata['daytime']=$this->today;	
			$where = "mintime >= '".$nearmin."' and type = '".$type."'";
			$adddata['high']= db("min30msg")->where($where)->max('high');
			$adddata['low'] = db("min30msg")->where($where)->min('low');
			if(db('min60msg')->where(array("mintime"=>$snearmin,"type"=>$type))->count()){
				$adddata['open']= db('min60msg')->where(array("mintime"=>$snearmin,"type"=>$type))->value('close');
				
			}else{
				$openid = db("min30msg")->where($where)->min('id');
				$adddata['open']= db("min30msg")->where(array('id'=>$openid))->value('open');
			}
			$adddata['close']= $close;
			db('min60msg')->insert($adddata);
		}


        $delerow = db('min30msg')->field("id")->where("type = '".$type."'")->order("id desc")->limit(150)->select();

        $zuixiao =  min($delerow);
        db('min30msg')->where("type = '".$type."' and id <'$zuixiao[id]'")->delete();
		
		
		//1天K线
		$nearmin = $this->start_time;
		$snearmin = $nearmin-86400;
		if(db('oneday')->where(array("mintime"=>$nearmin,"type"=>$type))->count()){
			//存在
			$id = db("oneday")->where(array("mintime"=>$nearmin,"type"=>$type))->value('id');
			$where = "mintime >= '".$nearmin."' and type = '".$type."'";
			$thisdata['high']= db("min60msg")->where($where)->max('high');
			$thisdata['low'] = db("min60msg")->where($where)->min('low');
			$thisdata['close']= $close;
			db('oneday')->where('id',$id)->update($thisdata);
			 
		}else{
			//不存在
			$adddata['type']=$type;
			$adddata['creattime']=time();
			$adddata['mintime']=$nearmin;
			$adddata['daytime']=$this->today;	
			$where = "mintime >= '".$nearmin."' and type = '".$type."'";
			$adddata['high']= db("min60msg")->where($where)->max('high');
			$adddata['low'] = db("min60msg")->where($where)->min('low');
			if(db('oneday')->where(array("mintime"=>$snearmin,"type"=>$type))->count()){
				$adddata['open']= db('oneday')->where(array("mintime"=>$snearmin,"type"=>$type))->value('close');
				
			}else{
				$openid = db("min60msg")->where($where)->min('id');
				$adddata['open']= db("min60msg")->where(array('id'=>$openid))->value('open');
			}
			$adddata['close']= $close;
			db('oneday')->insert($adddata);
		}
		



        $delerow = db('min60msg')->field("id")->where("type = '".$type."'")->order("id desc")->limit(150)->select();

        $zuixiao =  min($delerow);
        db('min60msg')->where("type = '".$type."' and id <'$zuixiao[id]'")->delete();

        $delerow = db('oneday')->field("id")->where("type = '".$type."'")->order("id desc")->limit(150)->select();

        $zuixiao =  min($delerow);
        db('oneday')->where("type = '".$type."' and id <'$zuixiao[id]'")->delete();

		


	}
//"55"=>"55","51"=>"51","37"=>"37","36"=>"36","44"=>"44","35"=>"35"

    public function jiadata()
    {

        //$pro =  ["52"=>"52","51"=>"51","37"=>"37","36"=>"36","44"=>"44","35"=>"35"];
		$pro =  ["37"=>"37","36"=>"36"];
        $datalen = ['1','2','3','4','5','6'];
        foreach ($pro as $key=>$val){
            foreach ($datalen as $value)
            {


                $geturl = 'https://m.sojex.net/api.do?rtp=CandleStick&type='.$value.'&qid='.$val;



                $html = $this->curlfun($geturl);



                $_arr = explode('[{',$html);
                if(!isset($_arr[1])){
                    return;
                }

                if(!empty($_arr[1])){
                    $array = explode('}]',$_arr[1]);
                }


                $_data_arr = explode('},{',$array[0]);


                $_count = count($_data_arr);
                //print_r($_count);exit;
                //$_data_arr = array_slice($_data_arr,$_count-150,$_count);


                foreach ($_data_arr as $k => $v)
                {


                    $_son_arr = explode(',', $v);
                    $_h_arr = explode(':',$_son_arr[1]);
                    $_l_arr = explode(':',$_son_arr[2]);
                    $_o_arr = explode(':',$_son_arr[0]);
                    $_c_arr = explode(':',$_son_arr[3]);
                    $_v_arr = explode(':',$_son_arr[5]);
                    $_t = explode(':',$_son_arr[6]);

                    $_h = substr($_h_arr[1],1,-1);
                    $_l = substr($_l_arr[1],1,-1);
                    $_o = substr($_o_arr[1],1,-1);
                    $_c = substr($_c_arr[1],1,-1);
                    $_v = substr($_v_arr[1],1,-1);




                    $_time = $_t[1]/1000;

                    $adddata = array();

                    $adddata['high'] = $_h;
                    $adddata['low'] = $_l;
                    $adddata['open'] = $_o;
                    $adddata['close'] = $_c ;
                    $adddata['type']=$key;
                    $adddata['creattime']=$_time;
                    $adddata['mintime']=$_time;

                    $adddata['daytime']=strtotime(date('Y-m-d',$_time));



                    if($value == '1') $table ="min1msg";
                    if($value == '2') $table ="min5msg";
                    if($value == '3') $table ="min15msg";
                    if($value == '4') $table ="min30msg";
                    if($value == '5') $table ="min60msg";
                    if($value == '6') $table ="oneday";


                    db($table)->insert($adddata);


                }
            }

        }
        echo 1;
    }

    public function shanchu(){

        db('msg')->where("type in(35,36,37,44,51,22,52,55,92,96)")->delete();
        db('min1msg')->where("type in(35,36,37,44,51,22,52,55,92,96)")->delete();
        db('min5msg')->where("type in(35,36,37,44,51,22,52,55,92,96)")->delete();
        db('min15msg')->where("type in(35,36,37,44,51,22,52,55,92,96)")->delete();
        db('min30msg')->where("type in(35,36,37,44,51,22,52,55,92,96)")->delete();
        db('min60msg')->where("type in(35,36,37,44,51,22,52,55,92,96)")->delete();
        db('oneday')->where("type in(35,36,37,44,51,22,52,55,92,96)")->delete();

        echo 1;exit;
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


 ?>