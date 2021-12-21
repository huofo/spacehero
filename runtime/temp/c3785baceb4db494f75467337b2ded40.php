<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:67:"/www/wwwroot/agc.bxtrade.vip/application/index/view/goods/bibi.html";i:1634714268;s:66:"/www/wwwroot/agc.bxtrade.vip/application/index/view/head_bibi.html";i:1628234268;s:61:"/www/wwwroot/agc.bxtrade.vip/application/index/view/foot.html";i:1638431011;}*/ ?>
﻿<html style="font-size: 120px;">
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
<?php if($_SESSION["night"]=="yes"): ?><link rel="stylesheet" href="/index/css/goods-bibi.css" ><?php endif; ?>
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
    .col{
        padding: 0px;

    }

    .yincang{
        display: none!important;
    }
    .xianshi{
        display: block!important;
    }
    .dropbtnvu{
        background: none;
        color: #7286a5;
        padding: 2px 5px;
        font-size: 14px;
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
        background-color: #0b1622;
        min-width: 160px;
        overflow: auto;
        /*box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);*/
        z-index: 1;
    }

    .dropdown-contentvu a {
        color: #486277;
        padding: 1px 5px;
        text-decoration: none;
        display: block;
    }

    .dropdownvu a:hover {background-color: #f1f1f1}

    .showvu {display:block;}
    .zuihoumianl{width: 100%;min-height: 20px;margin-top: 10px}
    .zuihoumianls{width: 100%;height: 30px;margin-top: 5px}

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


                <p><?php echo $pro['Name']; ?></p><span style="<?php if($pro['DiffRate'] > 0): ?>color: green;<?php else: ?>color: red;<?php endif; ?>font-size: 0.16rem;margin-left: 9px" id="head_DiffRate"><?php if($pro['DiffRate'] > 0): ?>+<?php endif; ?><?php echo $pro['DiffRate']; ?>%</span></div>
            <div class="tupianks"><a href="<?php echo url('goods/goods_bibi',array('pid'=>$pro['pid'])); ?>"><img src="/index/images/xinkxian.png" alt="" style="height: 25px;margin-top: 0.09rem;margin-right: 15px"></a></div>

        </ion-header-bar>
    </div>


</ion-nav-bar>

<div id="place">
    <div id="data" class="bgColor pb10  <?php if($order_type == 1): ?>  col2 <?php endif; ?> " >
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


            <div class="dropdown">
                <button onclick="myFunction()" class="dropbtn" id="place_type"><?php echo \think\Lang::get('bi_sj'); ?></button><i class="iconfont icon-xiangxia"></i>
                <div id="myDropdown" class="dropdown-content">
                    
                    <a href="javascript:void(0)" data-type="0"><?php echo \think\Lang::get('bi_sj'); ?></a>
                    <a href="javascript:void(0)" data-type="1"><?php echo \think\Lang::get('bi_xj'); ?></a>
                </div>
            </div>
            <!--  实验限价-->
            

            <div class="control">
                <input class="bibi-text2 bibi-jian" value="<?php echo \think\Lang::get('bi_ydqzyjgjy'); ?>" type="text" style="width: 100%;border: 0.1px solid;">
            </div>
            
            <div class="control"  style="display: none">
                <input id="bibi-text" value="<?php echo $pro['Price']; ?>" type="number" oninput="bzj()" >
                <input class="bibi-text2 bibi-jian" readonly="readonly"  onclick="jiajian(0)" value="-" type="text">
                <input class="bibi-text2 bibi-jia" readonly="readonly"  onclick="jiajian(1)" value="+" type="text">
            </div>


            <div class="bibi-sl">
                <input class="bibi-sl-inp1" id="num" type="number" placeholder="<?php echo \think\Lang::get('bi_sl'); ?>" style="padding: 0 5px;text-align: center;color:#ffffff" oninput="bzj_num()" >
                <input class="bibi-sl-inp2" type="text" value="<?php echo $huobidui[0]; ?>" readonly="readonly" style="padding: 0 3px" >
            </div>
            <div class="bibi-ky">
                <span><?php echo \think\Lang::get('bi_ky'); ?>:<span id="keyong"> <?php if($order_type == 1): ?><?php echo $qian_money; ?>&nbsp;<?php echo $huobidui[0]; else: ?><?php echo $hou_money; ?>&nbsp;<?php echo $huobidui[1]; endif; ?></span></span>
            </div>

            <input type="hidden" id="bibi_sxfee" value="<?php echo $web_gratuity; ?>">

            <input type="hidden" id="qian_money" value="<?php echo $qian_money; ?>">

            <input type="hidden" id="hou_money" value="<?php echo $hou_money; ?>">

            <div class="bibi-bfb">
                <ul>
                    <li data-type="25">25%</li>
                    <li data-type="50">50%</li>
                    <li data-type="75">75%</li>
                    <li data-type="100">100%</li>
                </ul>
            </div>


            <div class="bibi-cje">
                <span><?php echo \think\Lang::get('bi_jye'); ?>:<span id="jye">0</span>&nbsp;<?php echo $huobidui[1]; ?></span>

            </div>
            <div class="transactionAmount mb10">
                <button class="buy_sell" id="bt_zd"  <?php if($order_type == 1): ?> style="display: none" <?php endif; ?>    onClick="addordersbibi(0)" >
                <span><?php echo \think\Lang::get('bi_mc'); ?> <?php echo $huobidui[0]; ?></span>
                <span class="legal_title"></span>
                </button>
                <button class="buy_sell" id="bt_zk" <?php if($order_type == 0): ?> style="display: none" <?php endif; ?>  onClick="addordersbibi(1)" >
                <span><?php echo \think\Lang::get('bi_mc2'); ?> <?php echo $huobidui[0]; ?></span>
                <span class="legal_title"></span>
                </button>
            </div>
        </div>


        <!--右边-->
        <div class="pull-right active1">
            <div class="ft10color1">
                <div class="flex alcenter around pb10  ft12 colorGrey" style="margin-left: -0.31rem;margin-right: -0.2rem;">
                    <div class="flex1 mr5" style="color: #42526a" ><?php echo \think\Lang::get('bi_js'); ?></div>
                    <div class="flex1 tr" style="color: #42526a" ><?php echo \think\Lang::get('bi_sl'); ?></div>
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

    <div id="entrust" class="bgColor mt10" style="margin-bottom: 60px">
        <div>
            <h3 class="pull-left "><?php echo \think\Lang::get('bi_dqcc'); ?></h3>
            <span class="bibi-mr">
                <div class="dropdownvu">
                        <button onclick="myFunctionvu()" class="dropbtnvu"><?php echo $sl; ?> </button><i class="iconfont icon-xiangxia"></i>
                        <div id="myDropdownvu" class="dropdown-contentvu">
                            <a  href="<?php echo url('goods/bibi',array('pid'=>$pro['pid'])); ?>"><?php echo \think\Lang::get('ti_qb'); ?></a>
                            <a  href="<?php echo url('goods/bibi',array('ostyle'=>0,'pid'=>$pro['pid'])); ?>"><?php echo \think\Lang::get('bi_mc'); ?></a>
                            <a href="<?php echo url('goods/bibi',array('ostyle'=>1,'pid'=>$pro['pid'])); ?>"><?php echo \think\Lang::get('bi_mc2'); ?></a>
                        </div>
                    </div></span>
            <p class="pull-right filtrate all">
                <a href="<?php echo url('goods/entrust'); ?>"><span style="color: #778899!important;"><?php echo \think\Lang::get('ti_qb'); ?></span></a>
            </p>

            <?php if(is_array($hold) || $hold instanceof \think\Collection || $hold instanceof \think\Paginator): $i = 0; $__LIST__ = $hold;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <div class="bibi-order">
                  <div class="zuihoumianls wl_flex wl_align_center wl_justify_between">
                      <div class="yuuuus" style="width: 70%"><span <?php if($vo['ostyle'] == 0): ?> class="green" <?php else: ?>  class="red"<?php endif; ?>><?php echo $vo['fangxiang']; ?></span> <span style="color: #42526a;font-size: 12px;"> <?php echo $vo['nyr']; ?><span style="color: #42526a;margin-left: 2px"><?php echo $vo['sfm']; ?> </span> </span></div>
                      <?php if($vo['ostaus'] != 2): ?>
                      <div class="yuuuus"><span class="bibi-state" ><?php echo $vo['zt']; ?></span></div>
                      <?php else: ?>
                      <div class="yuuuus"><span class="bibi-state" onclick="bt_pc(<?php echo $vo['oid']; ?>)" ><?php echo \think\Lang::get('bi_cx'); ?></span></div>
                      <?php endif; ?>
                  </div>
                  <div class="zuihoumianl wl_flex wl_align_center wl_justify_between">
                      <div class="yuuuus" style="text-align: left"><span class="top"><?php echo \think\Lang::get('bi_js'); ?></span><br><span><?php echo $vo['buyprice']; ?></span></div>
                      <div class="yuuuus" style="text-align: center"><span class="top"><?php echo \think\Lang::get('bi_sl'); ?></span><br><span><?php echo $vo['chicang']; ?></span></div>
                      <div class="yuuuus" style="text-align: right"><span class="top"><?php echo \think\Lang::get('bi_jyd'); ?></span><br><span><?php echo $vo['ptitle']; ?></span></div>
                  </div>
                </div>


            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
</div>
<script>
    function bt_pc(id){

        layer.confirm('<?php echo \think\Lang::get('bi_qdycxm'); ?>', {
            btn: ['<?php echo \think\Lang::get('bi_qd'); ?>','<?php echo \think\Lang::get('bi_qx'); ?>'] //按钮
        }, function(){


            $.ajax({
                type:'POST',
                url:'/index/goods/free_orderbibi',
                data:{id:id},
                success: function(msg){
                    var msg = eval("(" + msg + ")");
                    if(msg.error){
                        layer.msg(msg.error);
                    }
                    if(msg.success){
                        layer.msg('<?php echo \think\Lang::get('bi_cxcg'); ?>', {icon: 1});

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
            <?php echo \think\Lang::get('ti_bibi'); ?>
        </div>
        <div class="nav-box-tabs">
            <div class="currency_name">
                <ul class="ul">
                    <?php if(is_array($allpro) || $allpro instanceof \think\Collection || $allpro instanceof \think\Paginator): $i = 0; $__LIST__ = $allpro;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <li class="legal_name flex between" onClick="parent.location='<?php echo url('goods/bibi',array('pid'=>$vo['pid'],'token'=>$token)); ?>';">
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

    //切换买卖触发

    $('.switch-col a').on('click', function () {
        $('.switch-col .col').removeClass('col')
        $(this).addClass('col')
        if($(this).data('index') == 1){
            var keyong = '<?php echo $hou_money; ?>'+'&nbsp;<?php echo $huobidui[1]; ?>';
            $('#data').removeClass('col2');
            $('#bt_zd').css('display','block');
            $('#bt_zk').css('display','none');
            $('#keyong').html(keyong);

           $('#num').val('');
            $('#jye').html('0');
            var jg =  $('#goodsprice').html();
            $('#bibi-text').val(jg);
            $('.bibi-bfb ul li').removeClass('actives')
            order_type = 0

        }else {
            var keyong = '<?php echo $qian_money; ?>'+'&nbsp;<?php echo $huobidui[0]; ?>';
            $('#data').addClass('col2')
            $('#bt_zd').css('display','none');
            $('#bt_zk').css('display','block');
            $('#keyong').html(keyong);
            $('#num').val('');
            $('#jye').html('0');
            var jg =  $('#goodsprice').html();
            $('#bibi-text').val(jg);
            $('.bibi-bfb ul li').removeClass('actives')
            order_type = 1
        }
    })


    $('.bibi-bfb ul').on('click', function (e) {

        if(e.target.nodeName == 'LI' || e.target.nodeName == 'INPUT'){
            $(this).find('.actives').removeClass('actives')
            $(e.target).addClass('actives');
            var bili  = $('.bibi-bfb ul .actives').attr('data-type');
            var place_type = $('#place_type').html();

            var jiage = $('#bibi-text').val();
            jiage = Number(jiage);
            if(jiage==''||jiage<0){
                jiage=0;
            }


            $.ajax({
                type:'POST',
                url:'/index/Goods/kemai',
                data:{pid:<?php echo $pro['pid']; ?>,number:bili,jiage:jiage,place_type:place_type,order_type:order_type},
                success: function(msg){
                    var msg = eval("(" + msg + ")");
                    var num = $('#num').val(msg.kemai);
                    bzj();

                }
            })

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

                bzj();
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


<script >


    function jiajian(type) {

        var place_type = $('#place_type').html()
        var jiage = $('#bibi-text').val();

        jiage = Number(jiage);
        if(jiage==''||jiage<0){
            jiage=0;
        }

        if(type==0){
            var newjiage = Subtr(jiage,0.01);
        }else{
            var newjiage = accAdd(jiage,0.01);
        }

        if(newjiage<=0){
            newjiage = 0;
            $('#bibi-text').val(0);
        }else{
            $('#bibi-text').val(newjiage);
        }
        var num = $('#num').val();
        num = Number(num);
        if(num==''){
            num=0;
        }


        $.ajax({
            type:'POST',
            url:'/index/Goods/bibijye',
            data:{pid:<?php echo $pro['pid']; ?>,number:num,jiage:newjiage,place_type:place_type},
            success: function(msg){
                var msg = eval("(" + msg + ")");
                $('#jye').html(msg.fee);

            }
        })
    }


    function bzj() {

        var place_type = $('#place_type').html()

        var num = $('#num').val();
        num = Number(num);
        if(num==''){
            num=0;
        }
        var jiage = $('#bibi-text').val();
        jiage = Number(jiage);
        if(jiage==''||jiage<0){
            jiage=0;
        }

        $.ajax({
            type:'POST',
            url:'/index/Goods/bibijye',
            data:{pid:<?php echo $pro['pid']; ?>,number:num,jiage:jiage,place_type:place_type},
            success: function(msg){
                var msg = eval("(" + msg + ")");
                $('#jye').html(msg.fee);
            }
        })

    }

    function bzj_num() {

        var place_type = $('#place_type').html()

        var num = $('#num').val();
        num = Number(num);
        if(num==''){
            num=0;
        }
        var jiage = $('#bibi-text').val();
        jiage = Number(jiage);
        if(jiage==''||jiage<0){
            jiage=0;
        }

        $('.bibi-bfb ul li').removeClass('actives')

        $.ajax({
            type:'POST',
            url:'/index/Goods/bibijye',
            data:{pid:<?php echo $pro['pid']; ?>,number:num,jiage:jiage,place_type:place_type},
            success: function(msg){
                var msg = eval("(" + msg + ")");
                $('#jye').html(msg.fee);
            }
        })

    }

    //加法
    function accAdd(arg1,arg2){
        var r1,r2,m;
        try{r1=arg1.toString().split(".")[1].length}catch(e){r1=0}
        try{r2=arg2.toString().split(".")[1].length}catch(e){r2=0}
        m=Math.pow(10,Math.max(r1,r2))
        return (arg1*m+arg2*m)/m
    }
    //减法
    function Subtr(arg1,arg2){
        var r1,r2,m,n;
        try{r1=arg1.toString().split(".")[1].length}catch(e){r1=0}
        try{r2=arg2.toString().split(".")[1].length}catch(e){r2=0}
        m=Math.pow(10,Math.max(r1,r2));
        n=(r1>=r2)?r1:r2;
        return ((arg1*m-arg2*m)/m).toFixed(n);
    }


    function cutZero(old){
        //拷贝一份 返回去掉零的新串
        newstr=old;
        //循环变量 小数部分长度
        var leng = old.length-old.indexOf(".")-1
        //判断是否有效数
        if(old.indexOf(".")>-1){
            //循环小数部分
            for(i=leng;i>0;i--){
                //如果newstr末尾有0
                if(newstr.lastIndexOf("0")>-1 && newstr.substr(newstr.length-1,1)==0){
                    var k = newstr.lastIndexOf("0");
                    //如果小数点后只有一个0 去掉小数点
                    if(newstr.charAt(k-1)=="."){
                        return  newstr.substring(0,k-1);
                    }else{
                        //否则 去掉一个0
                        newstr=newstr.substring(0,k);
                    }
                }else{
                    //如果末尾没有0
                    return newstr;
                }
            }
        }
        return old;
    }

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


        $('.control').hide().eq(0).show()
        $("#myDropdown a").click(function () {
            
          
            $('.control').hide().eq($(this).data('type')).show()

            if ($(this).attr('data-type') == 1) {
                $('#place_type').html('<?php echo \think\Lang::get('bi_xj'); ?>')
                $('#num').val('');
                $('#jye').html('0');
                var jg =  $('#goodsprice').html();
                $('#bibi-text').val(jg);
                $('.bibi-bfb ul li').removeClass('actives')


            } else if($(this).attr('data-type') == 0) {
                $('#place_type').html('<?php echo \think\Lang::get('bi_sj'); ?>')
                $('#num').val('');
                $('#jye').html('0');
                $('.bibi-bfb ul li').removeClass('actives')
            }
        })
    });
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
