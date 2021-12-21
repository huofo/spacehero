<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:68:"/www/wwwroot/agc.bxtrade.vip/application/index/view/goods/lever.html";i:1637657919;s:66:"/www/wwwroot/agc.bxtrade.vip/application/index/view/head_bibi.html";i:1628234268;s:61:"/www/wwwroot/agc.bxtrade.vip/application/index/view/foot.html";i:1638431011;}*/ ?>
<html style="font-size: 120px;">
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
<!-- 是否启用全屏模式 -->
<meta name="apple-mobile-web-app-capable" content="yes">
<!-- 全屏时状态颜色设置 -->
<meta name="apple-mobile-web-status-bar-style" content="white">
<!-- 禁用电话号码自动识别 -->
<meta name="format-detection" content="telephone=no">
<!--禁止读取本地缓存模板-->
<meta http-equiv="Pragma" contect="no-cache">


<title><?php echo $conf['web_name']; ?></title>

<script type="text/javascript">
window.onload=function(){
//设置适配rem
var change_rem = ((window.screen.width > 450) ? 450 : window.screen.width)/375*100;
document.getElementsByTagName("html")[0].style.fontSize=change_rem+"px";
window.onresize = function(){
change_rem = ((window.screen.width > 450) ? 450 : window.screen.width)/375*100;
document.getElementsByTagName("html")[0].style.fontSize=change_rem+"px";
}
}
</script>

<link href="__HOME__/css/ionic.css" rel="stylesheet">

<!--<script src="__HOME__/js/jquery-1.9.1.min.js"></script>-->
    <script src="__HOME__/js/jquery-3.2.1.min.js"></script>
<style type="text/css">@charset "UTF-8";[ng\:cloak],[ng-cloak],[data-ng-cloak],[x-ng-cloak],.ng-cloak,.x-ng-cloak,.ng-hide:not(.ng-hide-animate){display:none !important;}ng\:form{display:block;}.ng-animate-shim{visibility:hidden;}.ng-anchor{position:absolute;}</style>
<style>
.ionic_toast {
  z-index: 9999;
}

.toast_section {
  color: #FFF;
  cursor: default;
  font-size: 1em;
  display: none;
  border-radius: 5px;
  opacity: 1;
  padding: 10px 30px 10px 10px;
  margin: 10px;
  position: fixed;
  left: 0;
  right: 0;
  text-align: center;
  z-index: 9999;
  background-color: rgba(0, 0, 0, 0.75);
}

.ionic_toast_top {
  top: 10px;
}

.ionic_toast_middle {
  top: 40%;
}

.ionic_toast_bottom {
  bottom: 10px;
}

.ionic_toast_close {
  border-radius: 2px;
  color: #CCCCCC;
  cursor: pointer;
  display: none;
  position: absolute;
  right: 4px;
  top: 4px;
  width: 20px;
  height: 20px;
}

.toast_close_icon {
  position: relative;
  top: 1px;
}

.ionic_toast_sticky .ionic_toast_close {
  display: block;
}

.ionic_toast_close:active {

}</style>

<script src="__HOME__/js/lk/order.js"></script>
<!-- 弹框插件 -->
<script src="/static/layer/layer.js"></script>
<!-- 公共函数 -->
<script src="/static/public/js/function.js"></script>
<script src="/static/public/js/base64.js"></script>
<script type="text/javascript">
  var Base64 = new Base64();
</script>
</head>

<link rel="stylesheet" href="/index/css/bibi.css">
<link href="/index/css/index_for_bibi.css" rel="stylesheet" type="text/css">
<link href="__HOME__/layui/css/layui.css" rel="stylesheet">
<!--        夜间白天切换的文件-->
<?php if($_SESSION["night"]=="yes"): ?><link rel="stylesheet" href="/index/css/goods-lever.css" ><?php endif; ?>
<script src="__HOME__/layui/layui.js"></script>
<script type="text/javascript">
window.onload=function(){
//设置适配rem
var change_rem = ((window.screen.width > 450) ? 450 : window.screen.width)/375*100;
document.getElementsByTagName("html")[0].style.fontSize=change_rem+"px";
window.onresize = function(){
    change_rem = ((window.screen.width > 450) ? 450 : window.screen.width)/375*100;
    document.getElementsByTagName("html")[0].style.fontSize=change_rem+"px";
}
}

//编译php模板变量
var qsrjysl = '<?php echo \think\Lang::get('cd_qsrjysl'); ?>';
</script>
<script type="text/javascript" src="__HOME__/js/lodash.min.js"></script>

<script src="/static/public/js/function.js"></script>
		<script src="/static/public/js/base64.js"></script>
        <script type="text/javascript">
          var Base64 = new Base64();
        </script>


<script>
    var order_type = <?php echo $order_type; ?>;//买入、卖出
    var order_pid = <?php echo $pro['pid']; ?>;//产品id
    var newprice = <?php echo $pro['Price']; ?>;  //实时价格
    var my_money = <?php echo !empty($userinfo['usermoney'])?$userinfo['usermoney']:'0'; ?>;
    var numprice = <?php echo $pro['numprice']; ?>;//每手对应产品数量
    var bi_xj = '<?php echo \think\Lang::get('bi_xj'); ?>';
var od_xdcg = '<?php echo \think\Lang::get('od_xdcg'); ?>';
</script>
<style>
    body{
        width: 100%;
        height: 100%;
        overflow: hidden;
        overflow-y: scroll;
        background: #0b1622;
    }
    .nav-bar-block{
        width: 100%;
        height: 40px;
        position: fixed;
        top: 0;
    }
    .bar-header{
    }
    .bottom-nav ul li{
        float: left;
        text-align: center;
        height: 0.5rem;
        padding: 1% 0 0;
    }
    .bottom-nav ul li p{
        height: 17px;
        line-height: 17px!important;
        margin-top: 0px!important;
    }
    .left-buttons, .left-buttons .back-button{
        height: 40px!important;
        line-height: 40px!important;
    }
    .left-buttons, .left-buttons .icon-caidan{
        color: #000000;
        font-size: 24px;
    }
    /*实验下拉菜单样式*/
    .dropbtnst {
        background: none;
        color: #7286a5;
        padding: 2px 5px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    .dropbtnst:hover, .dropbtnst:focus {
        background: none;
    }

    .dropdownst {
        position: relative;
        display: inline-block;
    }

    .dropdown-contentst {
        display: none;
        position: absolute;
        background-color: #0b1622;
        min-width: 160px;
        overflow: auto;
        /*box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);*/
        z-index: 1;
    }

    .dropdown-contentst a {
        color: #486277;
        padding: 10px 10px;
        text-decoration: none;
        display: block;
    }

    .dropdownst a:hover {background-color: #f1f1f1}

    .showst {display:block;}
    .dropbtnvu{
        background: none;
        color: black;
        padding: 2px 5px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    .dropbtnvu:hover, .dropbtnvu:focus {
        background: none;
    }

    .dropdownvu{
        position: relative;
        display: inline-block;
    }

    .dropdown-contentvu{
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        overflow: auto;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .dropdown-contentvu a {
        color: black;
        padding: 1px 5px;
        text-decoration: none;
        display: block;
    }

    .dropdownvu a:hover {background-color: #f1f1f1}

    .showvu {display:block;}
    .zuihoumianl{width: 100%;height: 30px;}
    .zuihoumianls{width: 100%;height: 45px;}

    .col{
        padding: 0px;

    }

    .yincang{
        display: none!important;
    }
    .xianshi{
        display: block!important;
    }

</style>

<body ng-app="starter" ng-controller="AppCtrl" class="grade-a platform-browser platform-ios platform-ios9 platform-ios9_1 platform-ready">

<ion-nav-bar class="bar-stable headerbar nav-bar-container" nav-bar-transition="ios" nav-bar-direction="exit" nav-swipe="">
    <!--头部-->
    <div class="nav-bar-block" nav-bar="active" style="background: white">
        <ion-header-bar class="bar-stable headerbar bar bar-header wl_flex wl_justify_between" align-title="center">
            <div class="buttons buttons-left" style="transition-duration: 0ms;">
                <span class="left-buttons">
                    <a href="javascript:(0);" class="back-button" btn="show-left" style="transition-duration: 0ms;">
                        <i class="iconfont icon-caidan" style="margin-left: 10px;"></i>
                    </a>
                </span>
            <!--商品名称参数-->
                <p style="    font-size: 0.16rem;"><?php echo $pro['Name']; ?></p><span style="<?php if($pro['DiffRate'] > 0): ?>color: green;<?php else: ?>color: red;<?php endif; ?>font-size: 0.16rem;margin-left: 9px" id="head_DiffRate"><?php if($pro['DiffRate'] > 0): ?>+<?php endif; ?><?php echo $pro['DiffRate']; ?>%</span></div>
            <div class="tupianks" style="width: 80px"><a href="<?php echo url('goods/goods_lever',array('pid'=>$pro['pid'])); ?>"><img src="/index/images/xinkxian.png" alt="" style="height: 25px;margin-right: -3px"></a>

                <!--历史记录-->
                <a href="<?php echo url('goods/leverlist'); ?>"><img src="/index/images/zhishibenlp.png" alt="" style="height: 33px;margin-right: 15px"></a>
            </div>
        </ion-header-bar>
    </div>
</ion-nav-bar>



    <div id="place">
        <div id="data" class="bgColor pb10  <?php if($order_type == 1): ?>  col2 <?php endif; ?>" >
            <!--左边-->
            <div class="pull-left active">
                <div class="deal flex between switch-col">

                    <span class="pull-left buy business bor">
                        <a <?php if($order_type == 0): ?>  class="col" <?php endif; ?> id="qihuan_mr" data-index="1"><?php echo \think\Lang::get('bi_mc'); ?></a>
                        <em></em>
                    </span>
                    <span class="sell business" >
                        <a  id="qihuan_mc"  <?php if($order_type == 1): ?>  class="col" <?php endif; ?>   data-index="2"><?php echo \think\Lang::get('bi_mc2'); ?></a>
                        <em></em>
                    </span>
                </div>

                    <div class="wl_justify_between wl_flex"><div class="dropdown" style="width: 50%">
                        <button onClick="myFunction()" class="dropbtn" style="border: 0.5px solid #4d5568;padding: 2px 9px;margin-bottom: 5px;width: 100%;font-size: 12px" id="place_type"><?php echo \think\Lang::get('bi_sj'); ?> </button><i class="iconfont icon-xiangxia" style="color: #ced6db;position: absolute;right: 4px;top: 3px"></i>
                        <div id="myDropdown" class="dropdown-content">
                            <a href="javascript:void(0)" data-type="0" ><?php echo \think\Lang::get('bi_sj'); ?></a>
                            <a href="javascript:void(0)" data-type="1"><?php echo \think\Lang::get('bi_xj'); ?></a>
                            
                        </div>
                    </div>


                    <div class="dropdownst" style="width: 45%">
                        <button onClick="myFunctionst()" class="dropbtnst" style="border: 0.5px solid #4d5568;padding: 2px 10px;width: 100%;font-size: 12px"><span  id="ganggan"><?php echo $code[0]; ?></span>X</button><i class="iconfont icon-xiangxia" style="color: #ced6db;position: absolute;right: 4px;top: 3px"></i>
                        <div id="myDropdownst" class="dropdown-contentst">
                            <?php if(is_array($code) || $code instanceof \think\Collection || $code instanceof \think\Paginator): $k = 0; $__LIST__ = $code;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
                            <a href="javascript:void(0)" data_desen = "<?php echo $vo; ?>" style="color: #7286a5;" ><?php echo $vo; ?>X</a>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    </div>
                </div>

                <!--限价-->
                
                <div class="control" style="height: 30px;line-height: 30px">
                    <input class="bibi-text2 bibi-jian" value="<?php echo \think\Lang::get('bi_ydqzyjgjy'); ?>" type="text" style="border: 0.5px solid #4d5568;width: 100%;height: 30px">
                </div>
                
                
                <div class="control" style="height: 30px;line-height: 30px;display:none">
                   <input id="bibi-text" value="<?php echo $pro['Price']; ?>" type="text" style="border: 0.5px solid #4d5568;width: 100%;margin-top: 3%;height: 30px">

                </div>
                
                


                <div class="bibi-ktys" style="margin-top: 10%!important;padding: 2px 0;">
                    <span><?php echo $pro['numprice']; ?>&nbsp;<?php echo $huobidui[0]; ?>/<?php echo \think\Lang::get('gb_le_s'); ?></span><br>
                    <span><?php echo \think\Lang::get('le_jyss'); ?></span>
                </div>

                <div class="bibi-sl">
                    <input class="bibi-sl-inp1"  id="num"  type="number" placeholder="<?php echo \think\Lang::get('le_qsrjyss'); ?>" style="width: 100%;border: 0.5px solid #4d5568;margin-top: -10%;padding: 0px 8px;height: 30px ;color:#ffffff">
                </div>

                <!--<div class="bibi-bfb">
                    <ul>
                        <li>25%</li>
                        <li>50%</li>
                        <li>75%</li>
                        <li>100%</li>
                    </ul>
                </div>-->


                <div class="bibi-cje" style="margin-top: 28%;">
                    <span><?php echo \think\Lang::get('gs_ye'); ?>:<?php echo $hou_money; ?>&nbsp;<?php echo $huobidui[1]; ?></span>
                </div>
                <div class="transactionAmount mb10">
                    <button class="buy_sell" id="bt_zd"   onClick="addorderlever(0)" >
                        <span style="color: #FFFFFF;"><?php echo \think\Lang::get('gs_mrzd'); ?></span>
                        <span class="legal_title"></span>
                    </button>
                    <button class="buy_sell" id="bt_zk" style="display: none" onClick="addorderlever(1)" >
                        <span style="color: #FFFFFF"><?php echo \think\Lang::get('gs_mczk'); ?></span>
                        <span class="legal_title"></span>
                    </button>
                </div>
            </div>
            <!--右边-->
            <div class="pull-right active1">
                <div class="ft10color1">
                    <div class="flex alcenter around pb10  ft12 colorGrey" style="margin-left: -0.31rem;margin-right: -0.2rem;">
                        <div class="flex1 mr5"><?php echo \think\Lang::get('bi_js'); ?></div>
                        <div class="flex1 tr"><?php echo \think\Lang::get('bi_sl'); ?></div>
                    </div>
                    <div>
                        <div class="sell_out" style="margin-right: -.1rem;">

                            <?php if(is_array($jiashendu) || $jiashendu instanceof \think\Collection || $jiashendu instanceof \think\Paginator): $k = 0; $__LIST__ = $jiashendu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
                            <div class="flex alcenter around pb10 pd5" id="jia<?php echo $k-1; ?>">
                                <div class="red flex2 ft12 jiage"  onclick="changeprice('jia<?php echo $k-1; ?>')"><?php echo $vo['jiage']; ?></div>
                                <div class="flex2 tc gray ft12 shuliang"><?php echo $vo['shuliang']; ?></div>
                            </div>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                        <p class="new_price red mt10" id="goodsprice" style="    margin-top: 0px;"  onclick="changenowprice('goodsprice')" ><?php echo $goodsprice; ?></p>
                        <p  style=" height: 10px;"></p>
                    </div>
                </div>
                <div class="ft10color1" style="margin-right: -.1rem;">
                    <div class="buyIn">
                        <?php if(is_array($jianshendu) || $jianshendu instanceof \think\Collection || $jianshendu instanceof \think\Paginator): $k = 0; $__LIST__ = $jianshendu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
                        <div class="flex alcenter around pb10 pd5"  id="jian<?php echo $k-1; ?>">
                            <div class="gre flex2 ft12 jiage"  onclick="changeprice('jian<?php echo $k-1; ?>')"><?php echo $vo['jiage']; ?></div>
                            <div class="flex2 tc gray ft12 shuliang"><?php echo $vo['shuliang']; ?></div>
                        </div>
                        <?php endforeach; endif; else: echo "" ;endif; ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="mlever-div1" style="height: 10px; background-color: #102030; border: 1px solid #102030"></div>


        <div id="entrust" class="bgColor mt10" style="margin-bottom: 60px">
            <div>
                <div><h3 class="pull-left "><?php echo \think\Lang::get('bi_dqcc'); ?></h3>

                    <p class="pull-right filtrate all">
                        <a href="#"><img src="/index/images/zhishibenlp.png" alt="" style="height: 33px;margin-top: -5px;"></a>
                        <a href="<?php echo url('goods/orderlist'); ?>"><span style="color: #778899!important;"><?php echo \think\Lang::get('gs_cc'); ?></span></a>
                    </p></div>

                <div class="zuihoumianl wl_flex wl_align_center wl_justify_between">
                    <div class="yuuuus yt" style="text-align: center"><?php echo \think\Lang::get('le_lx'); ?></div>
                    <div class="yuuuus yt" style="text-align: center"><?php echo \think\Lang::get('le_sj'); ?></div>
                    <div class="yuuuus yt" style="text-align: center"><?php echo \think\Lang::get('bi_js'); ?></div>
                    <div class="yuuuus yt" style="text-align: center"><?php echo \think\Lang::get('bi_jye'); ?></div>
                    <div class="yuuuus yt" style="text-align: center"><?php echo \think\Lang::get('le_cz'); ?></div>
                </div>

                <?php if(is_array($hold) || $hold instanceof \think\Collection || $hold instanceof \think\Paginator): $i = 0; $__LIST__ = $hold;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <div class="zuihoumianls wl_flex wl_align_center wl_justify_between" style="height: auto;">
                    <div class="yuuuus" style="text-align: center"><?php echo $vo['fangxiang']; ?></div>
                    <div class="yuuuus" style="text-align: center"><?php echo $vo['nyr']; ?><br><span><?php echo $vo['sfm']; ?></span></div>
                    <div class="yuuuus" style="text-align: center"><?php echo $vo['buyprice']; ?></div>
                    <div class="yuuuus" style="text-align: center"><?php echo $vo['chicang']; ?></div>
                    <div class="yuuuus mlevpc"style="background: aqua;color: white;width: 20%;height: auto; font-size: 12px; text-align: center;border-radius: 3px;" onClick="bt_pc(<?php echo $vo['oid']; ?>)"><?php echo \think\Lang::get('le_pc'); ?></div>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
    </div>
<script>
    function bt_pc(id){

        layer.confirm('<?php echo \think\Lang::get('le_qdypcm'); ?>', {
            btn: ['<?php echo \think\Lang::get('bi_qd'); ?>','<?php echo \think\Lang::get('bi_qx'); ?>'] //按钮
        }, function(){
            $.ajax({
                type:'POST',
                url:'/index/api/free_order',
                data:{id:id},
                success: function(msg){
                    var msg = eval("(" + msg + ")");
                    if(msg.error){
                        layer.msg(msg.error);
                    }
                    if(msg.success){
                        layer.msg('<?php echo \think\Lang::get('le_pccg'); ?>', {icon: 1});

                        setTimeout(function () {

                            window.location.reload();

                        }, 1000);

                    }
                }
            })
        }, function(){

        });

    }
</script>

    <!--左侧弹出菜单-->
    <div id="left-hidden-box" class="left-hidden-box" style="display: none;">
        <div class="nav-box" style="background: #102030">
            <div class="nav-box-header" style="color: #ffffff;font-weight: 600;">
                <?php echo \think\Lang::get('ti_hy'); ?>
            </div>
            <div class="nav-box-tabs">
                <div class="currency_name">
                    <ul class="ul">


                        <?php if(is_array($allpro) || $allpro instanceof \think\Collection || $allpro instanceof \think\Paginator): $i = 0; $__LIST__ = $allpro;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <li class="legal_name flex between" onClick="parent.location='<?php echo url('goods/lever',array('pid'=>$vo['pid'],'token'=>$token)); ?>';">
                            <strong><span><?php echo $vo['ptitle']; ?></span></strong>
                            <p class="gre"><span><?php echo $vo['Price']; ?></span></p>
                        </li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="__HOME__/js/lk/chardata.js"></script>

<script>
    //左侧菜单开启
    (function(){
        var Pdiv = document.querySelector('#left-hidden-box');
        var Sdiv = Pdiv.querySelector('.nav-box');
        var btn = document.querySelector('[btn="show-left"]');

        Pdiv.addEventListener('click', function(){
            hiddenBox();
        });
        Sdiv.addEventListener('click', function(){
            window.event ? window.event.cancelBubble = true : e.stopPropagation();
        });
        btn.addEventListener('click', function(){
            showBox();
        });

        function showBox(){
            Pdiv.style.display = 'block';
            setTimeout(function(){
                Sdiv.style.transition ='0.5s';
                Sdiv.style.transform = 'translateX(0%)';
            }, 0);
        }
        function hiddenBox(){
            Pdiv.style.display = 'none';
            Sdiv.style.transition ='0s';
            Sdiv.style.transform = 'translateX(-100%)';
        }
    })();
    //左侧菜单关闭
    (function(){
        var Pdiv = document.querySelector('#left-hidden-box');
        var Sdiv = Pdiv.querySelector('.nav-box');
        var btn = document.querySelector('[btn="off-left"]');

        Pdiv.addEventListener('click', function(){
            hiddenBox();
        });
        Sdiv.addEventListener('click', function(){
            window.event ? window.event.cancelBubble = true : e.stopPropagation();
        });

        function showBox(){
            setTimeout(function(){
                Sdiv.style.transition ='0.5s';
                Sdiv.style.transform = 'translateX(-100%)';
            }, 0);
            Pdiv.style.display = 'none';
        }
        function hiddenBox(){
            Pdiv.style.display = 'blck';
            Sdiv.style.transition ='0s';
            Sdiv.style.transform = 'translateX(0%)';
        }
    })();

    //买卖切换

    $('.switch-col a').on('click', function () {
        $('.switch-col .col').removeClass('col')
        $(this).addClass('col')
        if($(this).data('index') == 1){
            $('#data').removeClass('col2');
            $('#bt_zd').css('display','block');
            $('#bt_zk').css('display','none');

            $('#num').val('');
            var jg =  $('#goodsprice').html();
            $('#bibi-text').val(jg);
            order_type = 0

        }else {
            $('#data').addClass('col2')
            $('#bt_zd').css('display','none');
            $('#bt_zk').css('display','block');

            $('#num').val('');
            var jg =  $('#goodsprice').html();
            $('#bibi-text').val(jg);
            order_type = 1

        }
    })




    $('.control').on('click', function (e) {

        if(e.target.nodeName == 'SPAN' || e.target.nodeName == 'INPUT'){
            $(this).find('.actives').removeClass('actives')
            $(e.target).addClass('actives')
        }


    })

    layui.use('layer', function(){
        var layer = layui.layer;

    });
	
	
	
	
           setInterval("ajaxpros()",2000);
			function ajaxpros(){
                var old_price = $('#goodsprice').html()
                var geturl = "/index/Goods/heyuegoodsajax/pid/"+<?php echo $pro['pid']; ?>+"/old_price/"+old_price;
				 var type = '';
				$.get(geturl,function(data){
					if (data) {
						data = jQuery.parseJSON(Base64.decode(data));


                        if(data.zdf<0){
                            $('#head_DiffRate').html(data.zdf+"%");
                        }else {
                            $('#head_DiffRate').html("+"+data.zdf+"%");
                        }


                        $('#goodsprice').html(data.price);

                        if(data.fx == 'up'){

                            $('#goodsprice').addClass('gre')
                            $('#goodsprice').removeClass('red')
                        }else{
                            $('#goodsprice').addClass('red')
                            $('#goodsprice').removeClass('gre')
                        }

                        $.each(data.jia,function(k,v){
							$('#jia'+k+' .jiage').html(v.jiage);
							
							$('#jia'+k+' .shuliang').html(v.shuliang);
			
						});
						
						$.each(data.jian,function(k,v){
							
							
							$('#jian'+k+' .jiage').html(v.jiage);
							
							$('#jian'+k+' .shuliang').html(v.shuliang);
							
			
						});
					}
			
				});
			}

    function changeprice(jia){
        var pricebuy = $('#'+jia+' .jiage').html();
        $('#bibi-text').val(pricebuy);
    }

    function changenowprice(){
        var old_price = $('#goodsprice').html()
        $('#bibi-text').val(old_price);
    }

</script>
<!--后来进行的修改-->
<script src="/index/js/jquery-2.1.4.min.js">
$(".bibi-jian").click(function(){
    var a=$(".bibi-text").val();
    alert("7987");
    console.log(a);
});
</script>


<script>
    $(function () {

        if(<?php echo $order_type; ?>==0){

            $('#qihuan_mc').removeClass('col')
            $('#qihuan_mr').addClass('col')

            $('#data').removeClass('col2');
            $('#bt_zd').css('display','block');
            $('#bt_zk').css('display','none');
        }else{

            $('#qihuan_mr').removeClass('col')
            $('#qihuan_mc').addClass('col')

            $('#data').addClass('col2')
            $('#bt_zd').css('display','none');
            $('#bt_zk').css('display','block');
        }
        //限价市价
        $('.control').hide().eq(0).show()
        $("#myDropdown a").click(function () {
            $('.control').hide().eq($(this).data('type')).show()

            if ($(this).attr('data-type') == 1) {
                $('#place_type').html('<?php echo \think\Lang::get('bi_xj'); ?>')
                $('#num').val('');
                var jg =  $('#goodsprice').html();
                $('#bibi-text').val(jg);

            } else if($(this).attr('data-type') == 0) {
                $('#place_type').html('<?php echo \think\Lang::get('bi_sj'); ?>')
                $('#num').val('');
            }
        })
        //杠杆
        $("#myDropdownst a").click(function () {

            var ganggan = $(this).attr('data_desen');
            $('#ganggan').html(ganggan);

        })

    });
</script>



<script>
    /* 点击按钮，下拉菜单在 显示/隐藏 之间切换 */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }
    // 点击下拉菜单意外区域隐藏
    window.onclick = function(event) {

        if (!event.target.matches('.dropbtn')) {

            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];

                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>

<script>
    /* 点击按钮，下拉菜单在 显示/隐藏 之间切换 */
    function myFunctionst() {
        document.getElementById("myDropdownst").classList.toggle("showst");
    }

    // 点击下拉菜单意外区域隐藏
    window.addEventListener('click',function(){
        if (!event.target.matches('.dropbtnst')) {

            var dropdownst = document.getElementsByClassName("dropdown-contentst");
            var i;
            for (i = 0; i < dropdownst.length; i++) {
                var openDropdownst = dropdownst[i];
                if (openDropdownst.classList.contains('showst')) {
                    openDropdownst.classList.remove('showst');
                }
            }
        }
    })
</script>



<script>
    /* 点击按钮，下拉菜单在 显示/隐藏 之间切换 */
    function myFunctionvu() {
        document.getElementById("myDropdownvu").classList.toggle("showvu");
    }

    // 点击下拉菜单意外区域隐藏
    window.addEventListener('click',function(){
        if (!event.target.matches('.dropbtnvu')) {

            var dropdownvu = document.getElementsByClassName("dropdown-contentvu");
            var i;
            for (i = 0; i < dropdownvu.length; i++) {
                var openDropdownst = dropdownvu[i];
                if (openDropdownst.classList.contains('showvu')) {
                    openDropdownst.classList.remove('showvu');
                }
            }
        }
    })
</script>

        <!-- 底部导航 -->
        <style>
            .bottom-nav ul li {
                width: 20%;
                
            }
            
            
        </style>

        <link rel="stylesheet" href="/index/iconfont/iconfont.css">
        <script type="text/javascript" src="/index/iconfont/iconfont.js"></script>
        <link rel="stylesheet" href="/index/bibi/iconfont.css">
        
        <div class="bottom-nav">
            <ul>
                <li>
                    <a id="index" href="<?php echo url('index/index'); ?>">
                        <i></i>
                        <p><?php echo \think\Lang::get('ti_sy'); ?></p>
                    </a>
                </li>

                <li>
                    <a id="token" href="<?php echo Url('/index/trades/index/token/'.$token); ?>">
                        <i></i>
                        <p><?php echo \think\Lang::get('ti_hq'); ?></p>
                    </a>
                </li>

                <li>
                    <a id="bibi" href="<?php echo url('/index/goods/bibi'); ?>">
                        <i></i>
                        <p><?php echo \think\Lang::get('ti_bibi'); ?></p>
                    </a>
                </li>


                <li>
                    <a id="lever" href="<?php echo url('/index/goods/lever'); ?>">
                        <i></i>
                        <p><?php echo \think\Lang::get('ti_hy'); ?></p>
                    </a>
                </li>

                <li>
                    <a id="bibi2" href="<?php echo url('index/Assets/bibi'); ?>">
                        <i></i>
                        <p><?php echo \think\Lang::get('ti_zc'); ?></p>
                    </a>
                </li>
                <div class="clear"></div>
            </ul>
        </div>
        <script type="text/javascript">
            var url = window.location.href;
            var map = url.split("/");
            var str = map[map.length-1];
            var str2 = str.split(".")
            var str3 = str2[str2.length-2];
            $("#" + str3).addClass('cur')




            function set_active(id) {
                $('#zy img').attr('src', '__STATIC__/module/index/images/shouye/zy.png');
                $('#sc img').attr('src', '__STATIC__/module/index/images/shouye/sc.png');
                $('#tuig img').attr('src', '__STATIC__/module/index/images/shouye/tuig.png');
                $('#wd img').attr('src', '__STATIC__/module/index/images/shouye/wd.png');

                $('#zy p').addClass('foot');
                $('#sc p').addClass('foot');
                $('#tuig p').addClass('foot');
                $('#wd p').addClass('foot');

                $('#' + id + ' img').attr('src', '__STATIC__/module/index/images/shouye/' + id + '1.png');
                $('#' + id + ' p').removeClass('foot');
            }
        </script>
    </body>
</html>
</body>
</html>
