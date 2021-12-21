<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:68:"/www/wwwroot/agc.bxtrade.vip/application/index/view/goods/goods.html";i:1637657870;s:61:"/www/wwwroot/agc.bxtrade.vip/application/index/view/head.html";i:1636641480;}*/ ?>
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

<!--        夜间白天切换的文件-->
<!--<link rel="stylesheet" href="/index/css/goods.css" >-->
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


<script>
  var cs_kp = '<?php echo \think\Lang::get('cs_kp'); ?>';
    var m_sp = '<?php echo \think\Lang::get('m_sp'); ?>';
    var  iin_zd = '<?php echo \think\Lang::get('iin_zd'); ?>';
    var iin_zg = '<?php echo \think\Lang::get('iin_zg'); ?>';
    var iin_mz='<?php echo \think\Lang::get('iin_mz'); ?>'
    var gs_md='<?php echo \think\Lang::get('gs_md'); ?>';
    var jin_zxxzjew='<?php echo \think\Lang::get('jin_zxxzjew'); ?>';
    var od_ndyebzqcz = '<?php echo \think\Lang::get('od_ndyebzqcz'); ?>';
var order_type = 0;
var order_pid = <?php echo $pro['pid']; ?>;
var order_price = <?php echo $pay_choose_arr[0]; ?>;
var order_sen = <?php echo $protime[0]*60; ?>;
var order_shouyi = <?php echo $proscale[0]; ?>;
var newprice = <?php echo $pro['Price']; ?>;  //实时价格
var rawData_data = [];
var my_money = <?php echo !empty($userinfo['usermoney'])?$userinfo['usermoney']:'0'; ?>;
var order_min_price = <?php echo getconf('order_min_price'); ?>;
var order_max_price = <?php echo getconf('order_max_price'); ?>;
var numprice = <?php echo $pro['numprice']; ?>;


window.onload = function(){
	//只有合约
<?php if($jiying==1 and $jinjie ==1): ?>

	 $('.second').css({'display':'none'});
        $('.scroll-xxs').css({'width':'98%'});
        $('.expect_profit').css({'display':'none'});
        $('.stop-win').css({'display':'block'});
        $('.stop-loss').css({'display':'block'});
		 $('.jixings').css({'display':'none'});
		 $('.jinjies').css({'display':'block'});
        $('.onumber').css({'display':'block'});
        $('.investment-amount').css({'display':'none'});
        $('.ng-other').css({'display':'none'});
		 $("#jinjie").addClass("active");


<?php endif; ?>

	//都没有
<?php if($jiying==1 and $jinjie ==0): ?>

	 $('.second').css({'display':'none'});
        $('.scroll-xxs').css({'width':'98%'});
        $('.expect_profit').css({'display':'none'});
        $('.stop-win').css({'display':'none'});
        $('.stop-loss').css({'display':'none'});
		 $('.jixings').css({'display':'none'});
		 $('.jinjies').css({'display':'none'});
        $('.onumber').css({'display':'none'});
        $('.investment-amount').css({'display':'none'});
        $('.ng-other').css({'display':'none'});
	  $('.order-detail').css({'display':'none'});
	  $('.my-money').css({'display':'none'});

	  $('.end_time').html('暂无权限');



<?php endif; ?>


}





</script>

<style>
    .trade-view .trade_bar {bottom: 3%;}
    .headerbar{
        background-color: black;
    }
    .headerbar .header-item{
        color: white;
    }
    .back-button{
        color: white !important;
    }
    .content-background{
        background-color: #1B1B1B!important;
    }
    .close-position {width: 150px;}
    .period-widget-header {line-height: 12px;}
</style>
<!--        夜间白天切换的文件-->
<?php if($_SESSION["night"]=="yes"): ?><link rel="stylesheet" href="/index/css/goods.css" ><?php endif; ?>
<body ng-app="starter" ng-controller="AppCtrl" class="grade-a platform-browser platform-ios platform-ios9 platform-ios9_1 platform-ready">

<ion-nav-bar class="bar-stable headerbar nav-bar-container" nav-bar-transition="ios" nav-bar-direction="exit" nav-swipe="">
<div class="nav-bar-block" nav-bar="active"><ion-header-bar class="bar-stable headerbar bar bar-header" align-title="center"><div class="buttons buttons-left" style="transition-duration: 0ms;"><span class="left-buttons">
        <a href="javascript:history.go(-1);" class="back-button" style="transition-duration: 0ms;    margin-top: 0.072rem;">
            <i class="icon ion-ios-arrow-left"></i>
        </a>
    </span></div>
    <div  id="nav-title"  class="title title-center header-item goodstitle" style="transition-duration: 0ms; transform: translate3d(0px, 0px, 0px); left: 48px; right: 48px;"> </div>

    <div class="buttons buttons-left" style="transition-duration: 0ms;    top: 0px; ">
                <span class="left-buttons">
                    <a href="<?php echo url('/index/user/index/token/'.$token); ?>" class="back-button" style="transition-duration: 0ms;text-decoration:none  ">
                        <i class="icon--8 iconfont "></i>
                    </a>
                </span>
            </div>


    </ion-header-bar></div>




    <style type="text/css" media="screen">
        .pane{background-color: #000000;}
        .trade-content header {border-top: none;}
				#nav-title{
				}
				#nav-title span{
					position: relative;
				}
				#nav-title span::before{
					height: 40px;
					line-height: 40px;
					padding-left: 1em;
					position: absolute;
				}
				.nav-list{
					/*width: 9em;*/
					    z-index: 9999;
					background: rgba(0,0,0,0.7);
					margin: 0 auto;
					padding: 10px 0;
					position: absolute;
					top: 40px;
					left: 0;
					right: 0;
				}
				.nav-list a{
					color: #fff;
					text-decoration: none;
 					padding: 5px 1em;
				}
				.nav-list li{
					height: 2.5em;
					text-align: center;
					line-height: 2.5em;
				}
                .other-amount {
                    width: 28%;
                }
			</style>
			<ul class="nav-list" style="display: none; overflow-y: scroll; height: 100%;">


                <!-- <?php if(is_array($prolist) || $prolist instanceof \think\Collection || $prolist instanceof \think\Paginator): $i = 0; $__LIST__ = $prolist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?> -->
                <li>
                    <a href="<?php echo url('/index/goods/goods',array('pid'=>$vo['pid'],'token'=>$token)); ?>"><?php echo $vo['ptitle']; ?></a>
                </li>
                <!-- <?php endforeach; endif; else: echo "" ;endif; ?> -->
			</ul>
			<script>
				(function(){
					var title = document.querySelector("#nav-title");
					var list = document.querySelector("ul.nav-list");
					console.log(title);
					title.addEventListener("click", function(){
						q();
					});
					function q(){
						list.style.display = list.style.display == 'block' ? 'none' : 'block';
					}
				})();
			</script>



    </ion-nav-bar>
<ion-nav-view class="view-container"  nav-view-transition="ios" nav-view-direction="exit" nav-swipe="">
<ion-view   class="trade-view pane"  hide-nav-bar="false" state="trade" nav-view="active" style="opacity: 1; transform: translate3d(0%, 0px, 0px);">

    <ion-content  class="trade-content content-background scroll-content ionic-scroll  has-header" scroll="true"><div class="scroll" style="transform: translate3d(0px, 0px, 0px) scale(1);">


		<header>
			<section  class="ng-binding rise data-price" style=""><?php echo $pro['Price']; ?></section>
			<section style="display:none; padding:0 5px">
				<p class="kaipan"></p>
				<p  class="ng-binding rise data-open" style=""><?php echo $pro['Open']; ?></p>
			</section>
			<section style=" padding:0 5px">
                <div style="width: 100%;display: block;margin-top: 10px">
                    <p class="zuidi" style="text-align:center"></p>
                    <p  style="text-align:right;" class="ng-binding rise data-low"><?php echo $pro['Low']; ?></p>
                </div>
                <div style="width: 100%;display: block">
                    <p  style="text-align:center" class="zuigao"></p>
                    <p  style="text-align:right;font-size: 0.09rem;font-weight: 700;" class="ng-binding rise data-high"><?php echo $pro['High']; ?></p>
                </div>
			</section>
		</header>

		<nav>
             <article>
                <span class="trade-chart-type stock active Kxian" onClick="change_chart_type('stock')"></span>
                <span class="trade-chart-type line zoushi" onClick="change_chart_type('line')"></span>
            </article>
            <section class="trade-chart-period 1M active" onClick="change_chart_period('1M')">1M</section>
            <section class="trade-chart-period 5M" onClick="change_chart_period('5M')">5M</section>
            <section class="trade-chart-period 15M" onClick="change_chart_period('15M')">15M</section>
            <section class="trade-chart-period 30M" onClick="change_chart_period('30M')">30M</section>
            <section class="trade-chart-period 1H" onClick="change_chart_period('1H')">1H</section>
            <section class="trade-chart-period 1D" onClick="change_chart_period('1D')">1D</section>
        </nav>
		<footer>
             <div id="container">
               <div id="ecKx"></div>
               <div class="txt1"><span class="a"></span><span class="b"></span><span class="c"></span><span class="d"></span><span class="e"></span></div>
               <div class="txt2"><span class="a DIFF"><i></i></span><span class="b DEA"><i></i></span><span class="c MACD"><i></i></span></div>
             </div>
        </footer>
    </div><div class="scroll-bar scroll-bar-v"><div class="scroll-bar-indicator scroll-bar-fade-out" style="transform: translate3d(0px, 0px, 0px) scaleY(1); height: 0px;"></div></div></ion-content>
	<div class="trade_bar">
    <?php if($isopen == 1): ?>
		<section onClick="toggle_history_order_panel()" class="">
			<i class="icon--14 iconfont"></i>
            <p class="chicangs"><?php echo \think\Lang::get('gs_cc'); ?></p>
		</section>
		<section onClick="toggle_order_confirm_panel('lookup')" class="">
			<i class="iconfont icon--17"></i>
            <p class="maizhang"></p>
		</section>
		<section onClick="toggle_order_confirm_panel('lookdown')" class="">
			<i class="iconfont icon--18"></i>
            <p class="maidie"></p>
		</section>
    <?php else: ?>
        <section  class="" style="flex-basis:100%">
            <i class="icon--14 iconfont"></i>
            <p class="xiushi"><span ng-show="order_list" class="ng-binding ng-hide" style="">(0)</span></p>
        </section>

    <?php endif; ?>
	</div>

    <!-- ngInclude: 'templates/order-confirm-panel.html' --><div ng-include="'templates/order-confirm-panel.html'" class="">
    <div class="pro_mengban "  >
    <div class="order-confirm-panel" >
        <div class="panel-header">
            <div>
                <?php echo \think\Lang::get('gs_ddqr'); ?>
                <div class="close" onClick="toggle_order_close_panel()">
                    <i class="icon ion-ios-close-empty close_tag"></i>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="period" style="height: 80px;">
                <p class="end_time"><?php echo \think\Lang::get('gs_xzwf'); ?></p>
                <ion-scroll direction="x" class="scroll-view ionic-scroll scroll-x"><div class="scroll" style="transform: translate3d(0px, 0px, 0px) scale (1);">
                    <div class="period-widget-view close-position-view">
                        <!-- ngRepeat: c in trade.cycle -->
                        <?php if($jiying==0): ?>
                        <div class="close-position active" data-sen="1" id='jiying'><?php echo \think\Lang::get('gs_mhy'); ?></div>
                         <?php endif; if($jinjie): ?>
                        <!--<div class="close-position" data-sen="2"  id='jinjie'>合约交易</div>-->
                        <?php endif; ?>
                        <!-- end ngRepeat: c in trade.cycle -->
                    </div>
                </div>
                <div class="scroll-bar scroll-bar-h">
                    <div class="scroll-bar-indicator scroll-bar-fade-out" style="transform: translate3d(0px, 0px, 0px) scaleX(1); width: 289px;">
                    </div>
                </div>
            </ion-scroll>
            </div>
            <div class="period second">
                <p class="end_time"><?php echo \think\Lang::get('gs_dqsj'); ?></p>
                <ion-scroll direction="x" class="scroll-view ionic-scroll scroll-x"><div class="scroll" style="transform: translate3d(0px, 0px, 0px) scale(1);">
                    <div class="period-widget-view">
                        <!-- ngRepeat: c in trade.cycle -->
                        <?php if(is_array($protime) || $protime instanceof \think\Collection || $protime instanceof \think\Paginator): $k = 0; $__LIST__ = $protime;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
                        <div class="period-widget <?php if($k==1): ?> active <?php endif; ?>"  data-sen="<?php echo $vo*60; ?>" data-shouyi="<?php echo $proscale[$k-1]; ?>">
                            <div class="period-widget-header">
                                <?php echo \think\Lang::get('gs_jssj'); ?>
                            </div>
                            <div class="period-widget-content" >
                                <span  class="final_time ng-binding"><?php echo $vo*60; ?></span>
                                <span  class="final_unit"><?php echo \think\Lang::get('gs_miao'); ?></span>
                            </div>
                            <div class="period-widget-footer period_footer ng-binding">
                                <?php echo \think\Lang::get('gs_sy'); ?>  <?php echo $proscale[$k-1]; ?>%
                            </div>
                        </div>
						<?php endforeach; endif; else: echo "" ;endif; ?>
                        <!-- end ngRepeat: c in trade.cycle -->
                    </div>
                </div><div class="scroll-bar scroll-bar-h"><div class="scroll-bar-indicator scroll-bar-fade-out" style="transform: translate3d(0px, 0px, 0px) scaleX(1); width: 289px;"></div></div></ion-scroll>
            </div>
            <div class="amount investment-amount">
                <p class="invest_account tousijine">

                    <span  class="<?php if($userinfo['usermoney'] > $pay_choose_arr[0]): ?> ng-hide <?php endif; ?> no-money"><?php echo \think\Lang::get('gs_tzjebzqcz'); ?></span>
                    <span  class="ng-hide no-max"><?php echo \think\Lang::get('gs_dbtzjebcg'); ?><?php echo getconf('order_max_price'); ?></span>
                    <span   class="ng-hide no-min"><?php echo \think\Lang::get('gs_dbtzjebsy'); ?><?php echo getconf('order_min_price'); ?></span>
                </p>
                <ion-scroll direction="x" class="scroll-view ionic-scroll scroll-x scroll-xxs" style="width: 70%;"><div class="scroll" style="transform: translate3d(0px, 0px, 0px) scale(1);">
                    <div class="amount-view">
                        <?php if(is_array($pay_choose_arr) || $pay_choose_arr instanceof \think\Collection || $pay_choose_arr instanceof \think\Paginator): $k = 0; $__LIST__ = $pay_choose_arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
                        <div class="amount-box ng-binding <?php if($k==1): ?> active <?php endif; ?>" data-price="<?php echo $vo; ?>">
                            <?php echo $vo; ?> U
                        </div>
                        <?php endforeach; endif; else: echo "" ;endif; ?>

                    </div>
                </div><div class="scroll-bar scroll-bar-h"><div class="scroll-bar-indicator scroll-bar-fade-out" style="transform: translate3d(0px, 0px, 0px) scaleX(1); width: 192px;"></div></div></ion-scroll>
                <label class="other-amount">
                    <input type="number" placeholder="<?php echo \think\Lang::get('gs_qtje'); ?>" ng-init="onfocus=false" ng-focus="onfocus==true" ng-model="order_params.other_amount" ng-keydown="min_money()" class="ng-pristine ng-untouched ng-valid ng-empty ng-other">
                </label>
            </div>



            <div class="amount onumber" style="height: 90px;">
                <p class="invest_account"><?php echo \think\Lang::get('gs_mrss'); ?></p>
                <div class="move-share">
                    <span class="red-share" onClick="redshare($(this))" >-</span>
                    <input type="number" value="1" onMouseOut="changeshare($(this))" />
                    <span class="add-share" onClick="addshare($(this))" >+</span>
                </div>
                <div class="amount-explain"><?php echo \think\Lang::get('gs_ms'); ?><span><?php echo $pro['numprice']; ?></span>,<?php echo \think\Lang::get('gs_fd'); ?><span><?php echo $pro['code']; ?></span>,<?php echo \think\Lang::get('gs_dc'); ?><span id="getspread"></span></div>
            </div>
            <div class="amount stop-win">
                <p class="invest_account"><?php echo \think\Lang::get('gs_zy'); ?></p>
                <ion-scroll direction="x" class="scroll-view ionic-scroll scroll-x" style="width: 75%;">
                    <div class="scroll" style="transform: translate3d(0px, 0px, 0px) scale(1);">
                    <div class="amount-view">
                        <div class="never-win ng-binding" data-sen="20">20%</div>
                        <div class="never-win ng-binding" data-sen="40">40%</div>
                        <div class="never-win ng-binding" data-sen="60">60%</div>
                        <div class="never-win ng-binding active" data-sen="80">80%</div>
                        <div class="never-win ng-binding " data-sen="100">100%</div>
                    </div>
                    </div>
                </ion-scroll>
                <label class="other-amount ng-win">
                    <input type="number" placeholder="<?php echo \think\Lang::get('gs_qtzy'); ?>" ng-init="onfocus=false" ng-focus="onfocus==true" ng-model="order_params.other_amount" ng-keydown="min_money()" class="ng-pristine ng-untouched ng-valid ng-empty">
                </label>
            </div>
            <div class="amount stop-loss">
                <p class="invest_account"><?php echo \think\Lang::get('gs_zs'); ?></p>
                <ion-scroll direction="x" class="scroll-view ionic-scroll scroll-x" style="width: 75%;">
                    <div class="scroll" style="transform: translate3d(0px, 0px, 0px) scale(1);">
                    <div class="amount-view">
                        <div class="never-loss ng-binding " data-sen="50">50%</div>
                        <div class="never-loss ng-binding" data-sen="60">60%</div>
                        <div class="never-loss ng-binding " data-sen="70">70%</div>
                        <div class="never-loss ng-binding" data-sen="80">80%</div>
                        <div class="never-loss ng-binding active" data-sen="100">100%</div>
                    </div>
                    </div>
                </ion-scroll>
                <label class="other-amount ng-loss">
                    <input type="number" placeholder="<?php echo \think\Lang::get('gs_qtzs'); ?>" ng-init="onfocus=false" ng-focus="onfocus==true" ng-model="order_params.other_amount" ng-keydown="min_money()" class="ng-pristine ng-untouched ng-valid ng-empty ">
                </label>
            </div>
            <div class="info-view ">
                <div class="ng-binding my-money"><?php echo \think\Lang::get('gs_ye'); ?>:  <span class="pay_mymoney"><?php echo $userinfo['usermoney']; ?>USDT</span></div>
                <div class="ng-binding jixings"><?php echo \think\Lang::get('gs_syf'); ?>：<span><?php echo $web_poundage; ?></span>%</div>

                <div class="ng-binding jinjies" style="display:none" ><?php echo \think\Lang::get('gs_syf'); ?>：<span><?php echo $web_gratuity; ?></span>%</div>

            </div>




            <div class="order-detail-view">
                <div class="order-detail">
                    <div class="row fields">
                        <div class="col"><?php echo \think\Lang::get('ind_mc'); ?></div>
                        <div class="col"><?php echo \think\Lang::get('gs_fx'); ?></div>
                        <div class="col"><?php echo \think\Lang::get('gs_xj'); ?></div>
                        <div class="col"><?php echo \think\Lang::get('gs_je'); ?></div>
                    </div>
                    <div class="row">
                        <div class="col qoute_name ng-binding goodstitles"> </div>
                        <div class="col ng-binding order_type" ><?php echo \think\Lang::get('gs_md'); ?></div>
                        <div class="col ng-binding rise col-nowprice" ><?php echo $pro['Price']; ?></div>
                        <div class="col ng-binding" id="money"> <?php echo $pay_choose_arr[0]; ?>U</div>
                    </div>
                    <div class="row btn_confirm">
                        <div class="col">
                            <button class="button" ak="1" onClick="judge($(this))" >
                                <?php echo \think\Lang::get('gs_qrxd'); ?>
                            </button>
                        </div>
                    </div>
                    <p class="expect_profit">
                        <span class="ng-binding"><?php echo \think\Lang::get('gs_yqsy'); ?> :  <span id="yuqi">180.00</span>U</span>
                        &nbsp;&nbsp;
                        <span class="ng-binding"><?php echo \think\Lang::get('gs_bdje'); ?> :  0.00U</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
    <!-- ngInclude: 'templates/order-state-panel.html' -->
    <div class="order_mengban"  style="width:100%;height:100%;"><div>
    <div >
        <div class="order-state-panel"  >
            <div class="panel-header">
                <div class="ng-binding goodstitles">

                    <div class="close" onClick="close_order()">
                        <i class="icon ion-ios-close-empty"></i>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="paysuccess  ng-hide" ng-show="order_result.status == 'SUCCESS'">
                    <div class="circle_wrapper" ng-show="order_params.cycle.time.indexOf('-') == -1">
                        <div class="right_circle">
                            <img class="img_circle_right" style="-webkit-animation: run 60s linear;" src="__HOME__/img/right_circle1.png">
                        </div>
                        <div class="left_circle">
                            <img class="img_circle_lift" style="-webkit-animation: runaway 60s linear;" src="__HOME__/img/left_circle1.png">
                        </div>
                    </div>
                    <div class="row remaining count_remaining" ng-show="order_params.cycle.time.indexOf('-') == -1">
                        <div class="col">
                            <div class="ng-binding pay_order_sen"></div>
                            <div><?php echo \think\Lang::get('gs_xj'); ?></div>
                            <div class="ng-binding newprice"></div>
                        </div>
                    </div>
                    <div class="pupil_success ng-hide" ng-show="order_params.cycle.time.indexOf('-') >= 0">
                        <p><?php echo \think\Lang::get('gs_jycgddjs'); ?></p>
                        <p class="ng-binding">
                            <span><?php echo \think\Lang::get('gs_sysj'); ?>：</span>
                            <?php echo \think\Lang::get('sw_t'); ?>Invalid Date
                        </p>
                    </div>
                    <div class="row info_list">
                        <div class="col col-15 first_info">
                            <p><?php echo \think\Lang::get('gs_fx'); ?></p>
                            <p  class="ng-binding pay_order_type"></p>
                        </div>
                        <div class="col col-30">
                            <p><?php echo \think\Lang::get('gs_je'); ?></p>
                            <p class="ng-binding"><span class="pay_order_price"></span>U</p>
                        </div>
                        <div class="col col-30">
                            <p><?php echo \think\Lang::get('gs_zxj'); ?></p>
                            <p class="ng-binding pay_order_buypricee"></p>
                        </div>
                        <div class="col col-25 last_info">
                            <p><?php echo \think\Lang::get('gs_csjg'); ?></p>
                            <p  class="ng-binding yuce">  U </p>
                        </div>
                    </div>
                </div>

                <div class="wait" ng-show="order_result.status == 'POST'">
                    <div class="row">
                        <div class="col ng-binding">
                            <i class="ion-paper-airplane"></i>
                            <?php echo \think\Lang::get('gs_qsh'); ?>
                        </div>
                    </div>
                </div>
                <div class="fail ng-hide" ng-show="order_result.status == 'FAIL'">
                    <div class="row">
                        <div class="col ng-binding">
                            <i class="ion-close-circled"></i>
                            <?php echo \think\Lang::get('gs_zctjdd'); ?>
                        </div>
                    </div>
                </div>

                <div class="fail ng-hide order_fail" ng-show="order_result.status == 'FAIL'" style="">
                    <div class="row">
                        <div class="col ng-binding">
                            <i class="ion-close-circled"></i>
                            <span class="fail-info" style="    font-size: 18px;color: #fff;"></span>
                        </div>
                    </div>
                </div>


                <div class="ordersuccess ng-hide" style="">
                    <div class="row remaining finish_remaining">
                        <div class="col">
                            <div class="result_profit ng-binding "  style="">$180</div>
                            <div class="expired_statements"><?php echo \think\Lang::get('gs_dqjswc'); ?></div>
                        </div>
                    </div>
                    <div class="row info_list">
                        <div class="col col-15 first_info">
                            <p><?php echo \think\Lang::get('gs_fx'); ?></p>
                            <p  class="ng-binding pay_order_type"></p>
                        </div>
                        <div class="col col-30">
                            <p><?php echo \think\Lang::get('gs_je'); ?></p>
                            <p class="ng-binding"><span class="pay_order_price"></span>U</p>
                        </div>
                        <div class="col col-30">
                            <p><?php echo \think\Lang::get('gs_zxj'); ?></p>
                            <p class="ng-binding pay_order_buypricee"></p>
                        </div>

                        <div class="col col-25 last_info">
                            <p><?php echo \think\Lang::get('gs_cjj'); ?></p>
                            <p class="ng-binding rise endprice" style=""></p>
                        </div>
                    </div>
                </div>


                <div class="row button_row">
                    <div class="col">
                        <button class="button" onClick="continue_order()"><?php echo \think\Lang::get('gs_gbck'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<!-- ngInclude: 'templates/history-order-panel.html' -->
<!-- <div  class=""><div class="history-panel" ng-include="1">
        <div class="panel-header chicangmingxi" >
            <div class="close" onClick="toggle_history_order_panel()">
                <i class="icon ion-ios-close-empty"></i>
            </div>
        </div>
        <div class="trade_history_list">
        	<ion-scroll style="height: 100%" class="scroll-view ionic-scroll scroll-y"><div class="scroll" style="transform: translate3d(0px, 0px, 0px) scale(1);">
            	<ul>
                </ul>
            </div><div class="scroll-bar scroll-bar-v"><div class="scroll-bar-indicator scroll-bar-fade-out" style="transform: translate3d(0px, 0px, 0px) scaleY(1); height: 0px;"></div></div></ion-scroll>
        </div>
    </div>
</div> -->
</ion-view></ion-nav-view>


<div class="backdrop"></div><div class="ionic_toast"><div class="toast_section" ng-class="ionicToast.toastClass" ng-style="ionicToast.toastStyle" ng-click="hideToast()" style="display: none; opacity: 0;"><span class="ionic_toast_close"><i class="ion-android-close toast_close_icon"></i></span><span ng-bind-html="ionicToast.toastMessage" class="ng-binding"></span></div></div><div class="click-block click-block-hide"></div><div class="modal-backdrop hide"><div class="modal-backdrop-bg"></div><div class="modal-wrapper" ng-transclude=""><ion-modal-view class="order-modal modal slide-in-up ng-leave ng-leave-active">
    <ion-header-bar class="order-modal-header bar bar-header">
        <h1 class="title" style="left: 54px; right: 54px;"><?php echo \think\Lang::get('gs_zjls'); ?></h1>
        <div class="close" ng-click="capital_history_modal_hide()">
            <i class="icon ion-ios-arrow-left"></i>
        </div>
    </ion-header-bar>
    <ion-content class="person_money_list scroll-content ionic-scroll  has-header"><div class="scroll" style="transform: translate3d(0px, 0px, 0px) scale(1);">
		<ion-scroll style="height:100%" class="scroll-view ionic-scroll scroll-y"><div class="scroll" style="transform: translate3d(0px, 0px, 0px) scale(1);">

			<ul>
                <!-- ngRepeat: c in moneyList -->

			</ul>
			<!-- ngIf: has_more_money_order.if_has_more_money_order -->
		</div><div class="scroll-bar scroll-bar-v"><div class="scroll-bar-indicator scroll-bar-fade-out" style="height: 0px; transform: translate3d(0px, 0px, 0px) scaleY(1); transform-origin: center bottom 0px;"></div></div></ion-scroll>
    </div><div class="scroll-bar scroll-bar-v"><div class="scroll-bar-indicator scroll-bar-fade-out" style="transform: translate3d(0px, 0px, 0px) scaleY(1); height: 0px;"></div></div></ion-content>
    <div class="button-bar">
        <a class="button button-dark" ng-click="capital_history_modal_hide()"><?php echo \think\Lang::get('gs_gb'); ?></a>
    </div>
    <script src="__HOME__/js/lk/chardata.js"></script>
    <script src="__HOME__/js/echarts.js"></script>
    <script src="__HOME__/js/m.js"></script>
    <script>



   // setInterval('getdata(<?php echo $pro['pid']; ?>)', 1000);
    //window.setInterval('getMaindata()',5000);
   // setInterval("window.location.reload();",1000*60*5);

    var titurl = '<?php echo url("goodsinfo"); ?>'
    $.post(titurl, 'pid=<?php echo $pro['pid']; ?>', function(_res){

        var res = jQuery.parseJSON(Base64.decode(_res));

        if(res.ptitle){
            var span = '<span class="icon ion-ios-arrow-down"></span>';
            $('.goodstitle').html(res.ptitle+span);
			 $('.goodstitles').html(res.ptitle);
        }else{
           // history.go(-1);
        }
    })

    var charturl = '<?php echo url("getchart"); ?>';
    $.get(charturl,function(_res){


        var res = jQuery.parseJSON(Base64.decode(_res));


        $.each(res,function(k,v){
            $('.'+k).html(v);
        })
    })

    </script>

    <script>
    var flag = false;
    var cur = {
        x:0,
        y:0
    }
    var nx,ny,dx,dy,x,y ;
    function down(){
        flag = true;
        var touch ;
        if(event.touches){
            touch = event.touches[0];
        }else {
            touch = event;
        }
        cur.x = touch.clientX;
        cur.y = touch.clientY;
        dx = div2.offsetLeft;
        dy = div2.offsetTop;
    }
    function move(){

        if(flag){
            var touch ;
            if(event.touches){
                touch = event.touches[0];
            }else {
                touch = event;
            }
            nx = touch.clientX - cur.x;
            ny = touch.clientY - cur.y;
            x = dx+nx;
            y = dy+ny;
            div2.style.left = x+"px";
            div2.style.top = y +"px";
            //阻止页面的滑动默认事件
            document.addEventListener("touchmove",function(){
                event.preventDefault();
            },false);
        }
    }
    //鼠标释放时候的函数
    function end(){
        flag = false;
    }
    var div2 = document.getElementById("div2");
    div2.addEventListener("mousedown",function(){
        down();
    },false);
    div2.addEventListener("touchstart",function(){
        down();
    },false)
    div2.addEventListener("mousemove",function(){
        move();
    },false);
    div2.addEventListener("touchmove",function(){
        move();
    },false)
    document.body.addEventListener("mouseup",function(){
        end();
    },false);
    div2.addEventListener("touchend",function(){
        end();
    },false);
</script>
</ion-modal-view></div></div></body></html>
