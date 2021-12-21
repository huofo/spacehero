<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:72:"/www/wwwroot/agc.bxtrade.vip/application/index/view/goods/leverlist.html";i:1637657931;s:61:"/www/wwwroot/agc.bxtrade.vip/application/index/view/head.html";i:1636641480;}*/ ?>
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
<link href="/index/css/index_for.css" rel="stylesheet" type="text/css">
<!--白天黑夜模式切换样式-->
<?php if($_SESSION["night"]=="yes"): ?><link rel="stylesheet" href="/index/css/goods-leverlist.css" ><?php endif; ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
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
<script type="text/javascript" src="__HOME__/js/lodash.min.js"></script>
<style>
    body{
        background: #102030;
    }
    .nav-bar-block{
        width: 100%;
        height: 40px;
        position: fixed;
        top: 0;
    }
    .bar-header{
        border-bottom: 1px solid #333333;
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
        margin-top: -8px!important;
    }
    .left-buttons, .left-buttons .back-button{
        height: 40px!important;
        line-height: 40px!important;
    }
    .left-buttons, .left-buttons .icon-caidan{
        color: #000000;
        font-size: 24px;
    }
    .nav-bar-container{
        width: 100%;
        height: 40px;
        position: fixed;
        top: 0;
        left: 0;
    }
    .bar-header .close{
        color: white!important;
    }
    .zuihoumianl{
        border-bottom: none;
    }
    .wtall-nav2{
        height: calc(100% - 40px);
        overflow-y: scroll;
    }
    .bottom-nav {bottom: 0%;}
    .bar-header .tab-list {
        line-height: 18px;
    }

</style>

<body ng-app="starter" ng-controller="AppCtrl" class="grade-a platform-browser platform-ios platform-ios9 platform-ios9_1 platform-ready">
    <ion-nav-bar class="bar-stable headerbar nav-bar-container" nav-bar-transition="ios" nav-bar-direction="swap" nav-swipe="">
        <div class="nav-bar-block" nav-bar="active">
            <ion-header-bar class="bar-stable headerbar bar bar-header" align-title="center">
                <a class="close" href="javascript:void(0)" onClick="javascript:history.back(-1);">
                    <i class="icon ion-ios-arrow-left"></i>
                </a>
                <div class="clearfix tab-list between" style="width: 85%; font-size: 12px; margin-left: 13%;margin-right: 0%;">
                    <div>
                        <span class="active" data-type="0"><?php echo \think\Lang::get('ll_wtz'); ?></span>
                    </div>
                    <div>
                        <span data-type="1"><?php echo \think\Lang::get('ll_jyz'); ?></span>
                    </div>
                    <div>
                        <span  data-type="2"><?php echo \think\Lang::get('ll_ypc'); ?></span>
                    </div>
                    <div>
                        <span data-type="3"><?php echo \think\Lang::get('ll_ycd'); ?></span>
                    </div>
                </div>
            </ion-header-bar>
        </div>
    </ion-nav-bar>
    <!--隔离层div-->
    <div class="header-space"></div>

    <!--选项卡内容-->
    <div class="cc_content wtall-nav2">
        <div class="wtall-nav-center">
            <?php if(is_array($order[2]) || $order[2] instanceof \think\Collection || $order[2] instanceof \think\Paginator): $i = 0; $__LIST__ = $order[2];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <div class="wtall-box">
                <div class="zuihoumianls wl_flex wl_align_center wl_justify_between">
                    <div class="yuuuus green" style="width: 70%"><span <?php if($vo['ostyle'] == 0): ?> class="green" <?php else: ?>  class="red"<?php endif; ?>><?php echo $vo['fangxiang']; ?></span> <span style="color: #ffffff;font-size: 12px;"> <?php echo $vo['ptitle']; ?> &nbsp; x<?php echo $vo['onumber']; ?><?php echo \think\Lang::get('gb_le_s'); ?>  </span></div>
                    <div class="yuuuus green" style="font-size: 12px"><?php echo $vo['ploss']; ?></div>
                </div>
                <div class="zuihoumianl wl_flex wl_align_center wl_justify_between">
                    <div class="yuuuus" style="text-align: left"><span class="top"><?php echo \think\Lang::get('or_kcj'); ?></span><br><span><?php echo $vo['buyprice']; ?></span></div>
                    <div class="yuuuus" style="text-align: center"><span class="top"><?php echo \think\Lang::get('or_zyj'); ?></span><br><span><?php echo $vo['stopwin_price']; ?></span></div>
                    <div class="yuuuus" style="text-align: right"><span class="top"><?php echo \think\Lang::get('or_dqj'); ?></span><br><span><?php echo $vo['sellprice']; ?></span></div>
                </div>
                <div class="zuihoumianl wl_flex wl_align_center wl_justify_between">
                    <div class="yuuuus" style="text-align: left"><span class="top"><?php echo \think\Lang::get('or_zsj'); ?></span><br><span><?php echo $vo['stoploss_price']; ?></span></div>
                    <div class="yuuuus" style="text-align: center"><span class="top"><?php echo \think\Lang::get('or_bzj'); ?></span><br><span><?php echo $vo['fee']; ?></span></div>
                    <div class="yuuuus" style="text-align: right"><span class="top"><?php echo \think\Lang::get('or_jyl'); ?></span><br><span><?php echo $vo['chicang']; ?></span></div>
                </div>
                <div class="zuihoumianl wl_flex wl_align_center wl_justify_between">
                        <div class="yuuuus" style="text-align: left"><span class="top"><?php echo \think\Lang::get('or_sxf'); ?></span><br><span><?php echo $vo['sx_fee']; ?></span></div>
                        <div class="yuuuus" style="text-align: center"><span class="top"><?php echo \think\Lang::get('or_gg'); ?></span><br><span><?php echo $vo['code']; ?>x</span></div>
                        <div class="yuuuus" style="text-align: right"><span class="top"><?php echo \think\Lang::get('ll_wtsj'); ?></span><br><span><?php echo $vo['kctime']; ?></span></div>
                    
                    </div>
                    
               
                <div class="zuihoumianl caozuo wl_flex wl_align_center wl_justify_between">
                    <div class="yuuuus" style="text-align: left"><span class="top"><?php echo \think\Lang::get('bi_jye'); ?></span><br><span><?php echo $vo['jye']; ?></span></div>
                    <div class="yuuuus" style="text-align: right;width: 67%">
                        <button type="button" onClick="bt_cd(<?php echo $vo['oid']; ?>)"><?php echo \think\Lang::get('ll_cd'); ?></button>
                    </div>
                </div>
            </div>
            
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
    <div class="cc_content wtall-nav2">
        <div class="wtall-nav-center">
            
            <?php if(is_array($order[0]) || $order[0] instanceof \think\Collection || $order[0] instanceof \think\Paginator): $i = 0; $__LIST__ = $order[0];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <div class="wtall-box">
                <div class="zuihoumianls wl_flex wl_align_center wl_justify_between">
                    <div class="yuuuus green" style="width: 70%"><span <?php if($vo['ostyle'] == 0): ?> class="green" <?php else: ?>  class="red"<?php endif; ?>><?php echo $vo['fangxiang']; ?></span> <span style="color: #ffffff;font-size: 12px;"> <?php echo $vo['ptitle']; ?> &nbsp; x<?php echo $vo['onumber']; ?><?php echo \think\Lang::get('gb_le_s'); ?>  </span></div>
                    <div class="yuuuus green" style="font-size: 12px"   id="yingkui_<?php echo $vo['oid']; ?>"><?php echo $vo['ploss']; ?></div>
                </div>
                <div class="zuihoumianl wl_flex wl_align_center wl_justify_between">
                    <div class="yuuuus" style="text-align: left"><span class="top"><?php echo \think\Lang::get('or_kcj'); ?></span><br><span><?php echo $vo['buyprice']; ?></span></div>
                    <div class="yuuuus" style="text-align: center"><span class="top"><?php echo \think\Lang::get('or_zyj'); ?></span><br><span><?php echo $vo['stopwin_price']; ?></span></div>
                    <div class="yuuuus" style="text-align: right"><span class="top"><?php echo \think\Lang::get('or_dqj'); ?></span><br><span id="nowprice_<?php echo $vo['oid']; ?>"><?php echo $vo['sellprice']; ?></span></div>
                </div>
                <div class="zuihoumianl wl_flex wl_align_center wl_justify_between">
                    <div class="yuuuus" style="text-align: left"><span class="top"><?php echo \think\Lang::get('or_zsj'); ?></span><br><span><?php echo $vo['stoploss_price']; ?></span></div>
                    <div class="yuuuus" style="text-align: center"><span class="top"><?php echo \think\Lang::get('or_bzj'); ?></span><br><span><?php echo $vo['fee']; ?></span></div>
                    <div class="yuuuus" style="text-align: right"><span class="top"><?php echo \think\Lang::get('or_jyl'); ?></span><br><span><?php echo $vo['chicang']; ?></span></div>
                </div>
                <div class="zuihoumianl wl_flex wl_align_center wl_justify_between">
                        <div class="yuuuus" style="text-align: left"><span class="top"><?php echo \think\Lang::get('or_sxf'); ?></span><br><span><?php echo $vo['sx_fee']; ?></span></div>
                        <div class="yuuuus" style="text-align: center"><span class="top"><?php echo \think\Lang::get('or_gg'); ?></span><br><span><?php echo $vo['code']; ?>x</span></div>
                        <div class="yuuuus" style="text-align: right"><span class="top"><?php echo \think\Lang::get('or_kcsj'); ?></span><br><span><?php echo $vo['kctime']; ?></span></div>
                    
                    </div>
                    
                    
                <div class="zuihoumianl caozuo wl_flex wl_align_center wl_justify_between">
                    <div class="yuuuus" style="text-align: left"><span class="top"><?php echo \think\Lang::get('bi_jye'); ?></span><br><span><?php echo $vo['jye']; ?></span></div>
                    <div class="yuuuus" style="text-align: right;width: 67%">
                        <button type="button" onClick="bt_pc(<?php echo $vo['oid']; ?>)"><?php echo \think\Lang::get('le_pc'); ?></button>
                    </div>
                </div>
            </div>
            
             <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
    <div class="cc_content wtall-nav2">
        <div class="wtall-nav-center">
            
            <?php if(is_array($order[1]) || $order[1] instanceof \think\Collection || $order[1] instanceof \think\Paginator): $i = 0; $__LIST__ = $order[1];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <div class="wtall-box">
                <div class="zuihoumianls wl_flex wl_align_center wl_justify_between">
                    <div class="yuuuus green" style="width: 70%"><span <?php if($vo['ostyle'] == 0): ?> class="green" <?php else: ?>  class="red"<?php endif; ?>><?php echo $vo['fangxiang']; ?></span> <span style="color: #ffffff;font-size: 12px;"> <?php echo $vo['ptitle']; ?> &nbsp; x<?php echo $vo['onumber']; ?><?php echo \think\Lang::get('gb_le_s'); ?>  </span></div>
                    <div class="yuuuus green m-yl" style="font-size: 12px"><?php echo $vo['ploss']; ?></div>
                </div>
                <div class="zuihoumianl wl_flex wl_align_center wl_justify_between">
                    <div class="yuuuus" style="text-align: left"><span class="top"><?php echo \think\Lang::get('or_kcj'); ?></span><br><span><?php echo $vo['buyprice']; ?></span></div>
                    <div class="yuuuus" style="text-align: center"><span class="top"><?php echo \think\Lang::get('or_zyj'); ?></span><br><span><?php echo $vo['stopwin_price']; ?></span></div>
                    <div class="yuuuus" style="text-align: right"><span class="top"><?php echo \think\Lang::get('ll_pcj'); ?></span><br><span><?php echo $vo['sellprice']; ?></span></div>
                </div>
                <div class="zuihoumianl wl_flex wl_align_center wl_justify_between">
                    <div class="yuuuus" style="text-align: left"><span class="top"><?php echo \think\Lang::get('or_zsj'); ?></span><br><span><?php echo $vo['stoploss_price']; ?></span></div>
                    <div class="yuuuus" style="text-align: center"><span class="top"><?php echo \think\Lang::get('or_bzj'); ?></span><br><span><?php echo $vo['fee']; ?></span></div>
                    <div class="yuuuus" style="text-align: right"><span class="top"><?php echo \think\Lang::get('or_jyl'); ?></span><br><span><?php echo $vo['chicang']; ?></span></div>
                </div>
                
                <div class="zuihoumianl wl_flex wl_align_center wl_justify_between">
                        <div class="yuuuus" style="text-align: left"><span class="top"><?php echo \think\Lang::get('or_sxf'); ?></span><br><span><?php echo $vo['sx_fee']; ?></span></div>
                        <div class="yuuuus" style="text-align: center"><span class="top"><?php echo \think\Lang::get('or_gg'); ?></span><br><span><?php echo $vo['code']; ?>x</span></div>
                        <div class="yuuuus" style="text-align: right"><span class="top"><?php echo \think\Lang::get('bi_jye'); ?></span><br><span><?php echo $vo['jye']; ?></span></div>
                    
                    </div>
                    
                    
                     <div class="zuihoumianl caozuo wl_flex wl_align_center wl_justify_between">
                         
                         
                        <div class="yuuuus" style="text-align: left"><span class="top"><?php echo \think\Lang::get('or_kcsj'); ?></span><br><span><?php echo $vo['kctime']; ?></span></div>
                    
                    
                        <div class="yuuuus" style="text-align: center"></div>
                     
                     
                        <div class="yuuuus" style="text-align: right"><span class="top"><?php echo \think\Lang::get('ll_pcsj'); ?></span><br><span><?php echo $vo['pctime']; ?></span></div>
                   
                       
                    </div>
                
                
            </div>
            
             <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
    <div class="cc_content wtall-nav2">
        <div class="wtall-nav-center">
            
             <?php if(is_array($order[3]) || $order[3] instanceof \think\Collection || $order[3] instanceof \think\Paginator): $i = 0; $__LIST__ = $order[3];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <div class="wtall-box">
                <div class="zuihoumianls wl_flex wl_align_center wl_justify_between">
                    <div class="yuuuus green" style="width: 70%"><span <?php if($vo['ostyle'] == 0): ?> class="green" <?php else: ?>  class="red"<?php endif; ?>><?php echo $vo['fangxiang']; ?></span> <span style="color: #ffffff;font-size: 12px;"> <?php echo $vo['ptitle']; ?> &nbsp; x<?php echo $vo['onumber']; ?><?php echo \think\Lang::get('gb_le_s'); ?>  </span></div>
                    <div class="yuuuus green" style="font-size: 12px"></div>
                </div>
                <div class="zuihoumianl wl_flex wl_align_center wl_justify_between">
                    <div class="yuuuus" style="text-align: left"><span class="top"><?php echo \think\Lang::get('ll_wtj'); ?></span><br><span><?php echo $vo['buyprice']; ?></span></div>
                    <div class="yuuuus" style="text-align: center"><span class="top"><?php echo \think\Lang::get('or_zyj'); ?></span><br><span><?php echo $vo['stopwin_price']; ?></span></div>
                    <div class="yuuuus" style="text-align: right"><span class="top"><?php echo \think\Lang::get('bi_jye'); ?></span><br><span><?php echo $vo['jye']; ?></span></div>
                </div>
                <div class="zuihoumianl wl_flex wl_align_center wl_justify_between">
                    <div class="yuuuus" style="text-align: left"><span class="top"><?php echo \think\Lang::get('or_zsj'); ?></span><br><span><?php echo $vo['stoploss_price']; ?></span></div>
                    <div class="yuuuus" style="text-align: center"><span class="top"><?php echo \think\Lang::get('or_bzj'); ?></span><br><span><?php echo $vo['fee']; ?></span></div>
                    <div class="yuuuus" style="text-align: right"><span class="top"><?php echo \think\Lang::get('or_jyl'); ?></span><br><span><?php echo $vo['chicang']; ?></span></div>
                </div>
                <div class="zuihoumianl wl_flex wl_align_center wl_justify_between">
                        <div class="yuuuus" style="text-align: left"><span class="top"><?php echo \think\Lang::get('or_sxf'); ?></span><br><span><?php echo $vo['sx_fee']; ?></span></div>
                        <div class="yuuuus" style="text-align: center"><span class="top"><?php echo \think\Lang::get('or_gg'); ?></span><br><span><?php echo $vo['code']; ?>x</span></div>
                        <div class="yuuuus" style="text-align: right"><span class="top"><?php echo \think\Lang::get('ll_wtsj'); ?></span><br><span><?php echo $vo['kctime']; ?></span></div>
                    
                    </div>
            </div>
            
             <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
<input type="hidden" value="<?php echo $daojishiid; ?>" id="daojishiid"/>
    <!--修改弹窗-->
    <div id="cc_modals">
        <div class="cc_modals" style="display: none;">
            <div>
                <span class="prices-modals"><?php echo \think\Lang::get('or_zyj'); ?></span>
                <p class="clearfix inputs">
                    <span class="reduce fl tc"><i>-</i></span>
                    <input type="number" class="prices fl">
                    <span class="add fr">+</span>
                </p>
            </div>
            <p class="yl tc"><?php echo \think\Lang::get('ll_yqyl'); ?>：<span style="color: rgb(88, 139, 247);">0.00</span></p>
            <div>
                <span class="prices-modals"><?php echo \think\Lang::get('or_zsj'); ?></span>
                <p class="clearfix inputs">
                    <span class="reduce fl tc"><i>-</i></span>
                    <input type="number" class="reduce-price fl">
                    <span class="add fr">+</span>
                </p>
            </div>
            <p class="ks tc"><?php echo \think\Lang::get('or_yqks'); ?>：<span style="color: rgb(88, 139, 247);">0.00</span></p>
        </div>
    </div>
</body>
<script>

    var vau1=$(".m-yl>span").text();
    if (vau1<0){$(".m-yl>span").css("color","#666")}


    //新选项卡切换效果
    $(function () {
        // intervalData(true);
        setInterval(function () {
            // intervalData(false)
        }, 6000)
        $('.cc_content').hide().eq(0).show()
        $(".tab-list div span").click(function () {
            $('.cc_content').hide().eq($(this).data('type')).show()
            $(".tab-list div span").removeClass('active');
            $(this).addClass('active');
            if ($(this).attr('data-type') == 2) {

            } else if($(this).attr('data-type') == 1) {

            }
        })
    })
</script>
<script>
    layui.use('layer', function(){
        var layer = layui.layer;
    });

    $('.show-content').on('click', function () {
        $(this).next().toggleClass('show')
    })


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
    
    
    function bt_cd(id){
        layer.confirm('<?php echo \think\Lang::get('bi_qdycxm'); ?>', {
            btn: ['<?php echo \think\Lang::get('bi_qd'); ?>','<?php echo \think\Lang::get('bi_qx'); ?>'] //按钮
        }, function(){


            $.ajax({
                type:'POST',
                url:'/index/goods/free_orderlever',
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
<script>
    window.onload=function(){

	daojishi()
}
    
    
function daojishi(){
	var daojishiid = $("#daojishiid").val();
	$.ajax({
		type: 'post',
		url: "/index/goods/daojishi",
		data:{
			daojishiid:daojishiid,	
		},
		success: function (msg) {
			if(msg){
				msg = eval("("+msg+")");
				$.each(msg,function(key,val){
				  
                        $("#nowprice_"+val['oid']+"").html(val['sellprice']);
                        $("#yingkui_"+val['oid']+"").html(val['ploss']);
                       
                    


				});
			
			}
		}
	});
	setTimeout("daojishi()",1000);	
}


    
    
</script>
</html>
