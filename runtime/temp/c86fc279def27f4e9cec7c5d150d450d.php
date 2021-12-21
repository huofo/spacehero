<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:69:"/www/wwwroot/agc.bxtrade.vip/application/index/view/trades/index.html";i:1637071789;s:61:"/www/wwwroot/agc.bxtrade.vip/application/index/view/head.html";i:1636641480;s:63:"/www/wwwroot/agc.bxtrade.vip/application/index/view/alyslt.html";i:1636617716;}*/ ?>
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
<!-- iPhone 启动图标 -->
<link rel="apple-touch-icon" href="img/logo.png">
<!-- Android 启动图标 -->
<link rel="shortcut icon" href="img/logo.png">
<!-- 添加 favicon icon -->
<link rel="shortcut icon" type="image/ico" href="img/favicon.ico">
<title><?php echo !empty($conf['web_name'])?$conf['web_name']:'B.King'; ?></title> 
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
<link href="__HOME__/css/style.css" rel="stylesheet">
<!-- <script src="__HOME__/js/jquery-3.2.1.min.js"></script> -->
<script src="__HOME__/js/jquery-1.9.1.min.js"></script>
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

<!-- <script type="text/javascript" src="__HOME__/js/lk/echarts-all-3.js"></script>
<script type="text/javascript" src="__HOME__/js/lk/ecStat.min.js"></script>
<script type="text/javascript" src="__HOME__/js/lk/dataTool.min.js"></script>
<script type="text/javascript" src="__HOME__/js/lk/china.js"></script>
<script type="text/javascript" src="__HOME__/js/lk/world.js"></script>
<script type="text/javascript" src="__HOME__/js/lk/api"></script>
<script type="text/javascript" src="__HOME__/js/lk/getscript"></script>
<script type="text/javascript" src="__HOME__/js/lk/bmap.min.js"></script> -->
<!-- 弹框插件 -->
<script src="/static/layer/layer.js"></script>
<!-- 公共函数 -->
<script src="/static/public/js/function.js"></script>
<script src="/static/public/js/base64.js"></script>
<script type="text/javascript">
  var Base64 = new Base64();

  
</script>
</head>

<!--<link rel="stylesheet" href="//at.alicdn.com/t/font_2846038_fnopv2bz6be.css" >-->

<link rel="stylesheet" href="//at.alicdn.com/t/font_2846038_g9wnpy77tk.css" >


<!--        夜间白天切换的文件-->
<?php if(isset($_SESSION['night']) && $_SESSION["night"]=="yes"): ?><link rel="stylesheet" href="/index/css/trades-index.css" ><?php endif; ?>
<body ng-app="starter" ng-controller="AppCtrl" class="grade-a platform-browser platform-win32 platform-ready" style="background-color: #102030;" >
<style>
    body{height: 100%;}
    .qoute-view-header>ul{background-color: #102030;}
    .bottom-nav ul li a {font-size: 12px;}
    .bottom-nav {bottom: 4%!important;}
</style>
<div id="mask"></div>
<ion-nav-bar class="bar-stable headerbar nav-bar-container" nav-bar-transition="ios" nav-bar-direction="none" nav-swipe="">
    <div class="nav-bar-block" nav-bar="cached"><ion-header-bar class="bar-stable headerbar bar bar-header" align-title="center"><div class="title title-center hangqing header-item" style="transition-duration: 0ms; transform: translate3d(-176.414px, 0px, 0px); opacity: 0;"></div><div class="buttons buttons-right" style="transition-duration: 0ms; opacity: 0;"></div></ion-header-bar></div><div class="nav-bar-block" nav-bar="active"><ion-header-bar class="bar-stable headerbar bar bar-header" align-title="center"><div class="buttons buttons-left" style="transition-duration: 0ms;"></div><div class="title hangqing title-center header-item" style="transition-duration: 0ms; transform: translate3d(0px, 0px, 0px);"><?php echo \think\Lang::get('ti_sssl'); ?></div></ion-header-bar></div></ion-nav-bar>

<section class="product-classification"  >
    <div class="current"><?php echo \think\Lang::get('ti_qb'); ?></div>
    <!-- <?php if(is_array($proclass) || $proclass instanceof \think\Collection || $proclass instanceof \think\Paginator): $i = 0; $__LIST__ = $proclass;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?> -->
    <div ak="<?php echo $vo['pcid']; ?>"><?php echo $vo['pcname']; ?></div>
    <!-- <?php endforeach; endif; else: echo "" ;endif; ?> -->
</section>
<ion-nav-view class="view-container" nav-view-transition="ios" nav-view-direction="enter" nav-swipe=""><ion-tabs class="tabs-icon-top navbar pane tabs-bottom tabs-standard" abstract="true" nav-view="active" style="opacity: 1; transform: translate3d(0%, 0px, 0px);">
    <div class="bottom-nav">
        <ul>
            <li>
                <a id="index" href="<?php echo url('index/index'); ?>">
                    <i></i>
                    <p><?php echo \think\Lang::get('ti_sy'); ?></p>
                </a>
            </li>

            <li>
                <a id="token" href="<?php echo Url('/index/trades/index/token/'.$token); ?>" class="cur">
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
<ion-nav-view name="tab-qoute" class="view-container tab-content" nav-view="active" nav-view-transition="ios" nav-view-direction="none" nav-swipe="">
    <ion-view view-title="" hide-nav-bar="false" class="pane" state="tab.qoute" nav-view="active" style="opacity: 1; transform: translate3d(0%, 0px, 0px);">
    <ion-content style="top: 0px;" class="content-background scroll-content ionic-scroll scroll-content-false  has-header has-tabs" scroll="false">

        <div class="slide-qoute slider" delegate-handle="slide-qoute" on-slide-changed="slide_change($index)" show-pager="false" style="visibility: visible;top:75px"><div class="slider-slides" ng-transclude="" style="width: 100%;">
            <!-- ngRepeat: c in category_list --><ion-slide ng-repeat="c in category_list" class="slider-slide" data-index="0" style="width: 100%; left: 0px; transition-duration: 300ms; transform: translate(0px, 0px) translateZ(0px);">
                <div class="qoute-view">
                    <div class="qoute-view-header">
                        <ul>
                            <li class="shangpinmingcheng"></li>
                            <li class="xianjia"></li>
                            <li class="zuidi"></li>
                            <li class="zuigao"></li>
                        </ul>
                    </div>
                    <div class="qoute-view-content">
                        <ion-scroll class="scroll-view ionic-scroll scroll-y"><div class="scroll" style="transform: translate3d(0px, 0px, 0px) scale(1);">

						<!-- <?php if(is_array($pro) || $pro instanceof \think\Collection || $pro instanceof \think\Paginator): $i = 0; $__LIST__ = $pro;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?> -->
                            <ul onClick="parent.location='<?php echo url('goods/goods',array('pid'=>$vo['pid'],'token'=>$token)); ?>';"  id="pid<?php echo $vo['pid']; ?>">
                                <li>
                                    <a href="javascript:;" class="ng-binding prtitle"></a>
                                </li>
                                <li>
                                    <a  href="javascript:;" class="ng-binding rise-value now-value">

                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="ng-binding rise rise-low">

                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;" class="ng-binding rise rise-high">

                                    </a>
                                </li>
                            </ul>
						<!-- <?php endforeach; endif; else: echo "" ;endif; ?> -->

                        </div>



                        <div style="width: 100%;height: 50px">

                        </div>
                        </ion-scroll>
                    </div>
                </div>
            </ion-slide>

        </div>
        </div>
    </ion-content>
</ion-view></ion-nav-view></ion-tabs></ion-nav-view>

<script>

var charturl = '<?php echo url("getchart"); ?>';
$.get(charturl,function(_res){


    var res = jQuery.parseJSON(Base64.decode(_res));

    $.each(res,function(k,v){
        $('.'+k).html(v);
    })
})

<?php if(isset($_SESSION['isshow']) && $_SESSION['isshow'] == 1): ?>
$('.pay_code_area').hide();
<?php else: ?>

$('.pay_code_area').show();
<?php endif;  $_SESSION['isshow'] = 1;?>
function pay_code_area() {
    $('.pay_code_area').hide();
}
</script>
</body></html>
<script src="__HOME__/js/lk/index.js">ajaxpro()</script>
<script type="text/javascript">
$(function(){
    $('.product-classification div').click(function(){
        var obj = $(this);
        var int = obj.attr('ak');
        $.ajax({
            type:"post",
            url:"<?php echo url('trades/ajaxclass'); ?>",
            data:{
                int:int
            },
            dataType:'JSON',
            async:false,
            beforeSend: function(){
                $('#mask').css({'display':'block'});
            },
            success:function(msg){
                $('.scroll-view.ionic-scroll.scroll-y').html(msg);
                $('.product-classification div').removeClass('current');
                obj.addClass('current');
            },
            complete: function () {
                $('#mask').css({'display':'none'});
            },
            error:function(){
              alert('<?php echo \think\Lang::get('ti_wlfm'); ?>');
            }
        });
    });
});
</script>
