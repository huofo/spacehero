<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"/www/wwwroot/agc.bxtrade.vip/application/index/view/register/register.html";i:1637561064;}*/ ?>
<!DOCTYPE html>
<html style="font-size: 132.813px;">

	<head>
		<meta charset="utf-8">
		<title>B.King</title>
		<meta name="keywords" content="B.King">
		<meta name="description" content="B.King">
		<meta name="full-screen" content="yes">
		<meta name="browsermode" content="application">
		<meta name="x5-page-mode" content="app">
		<meta name="x5-fullscreen" content="true">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
		<link href="/index/css/index_for.css" rel="stylesheet" type="text/css">

		<!--图标字体插件-->
		<link rel="stylesheet" href="/index/iconfont/iconfont.css">
		<!--        夜间白天切换的文件-->
<!--		<link rel="stylesheet" href="/index/css/register-register.css">-->
		<script type="text/javascript" src="/index/iconfont/iconfont.js"></script>
		<script type="text/javascript">
			//web端自适应rem样式
			//auto adaptation
			var calculate_size = function() {
				var BASE_FONT_SIZE = 100;
				var docEl = document.documentElement,
					clientWidth = docEl.clientWidth;
				if(!clientWidth) return;
				docEl.style.fontSize = BASE_FONT_SIZE * (clientWidth / 320) + 'px';
			};
			// Abort if browser does not support addEventListener
			if(document.addEventListener) {
				var resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize';
				window.addEventListener(resizeEvt, calculate_size, false);
				document.addEventListener('DOMContentLoaded', calculate_size, false);
				calculate_size();
			}
		</script>
		<script type="text/javascript" src="/index/js/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="/index/js/index.js"></script>
		<script src="/static/layer/layer.js"></script>
        <script src="/static/public/js/function.js"></script>
        <script src="/static/index/js/lk/user.js"></script>

		<style>
			.register-box .date{
				background: none;
			}
			.register-box .date .r-input{
				color: #ffffff;
			}
			.register-box .date .r-code{
				color: #ffffff;
			}
			.login-box .account .number .r-name{
				color: #ffffff;
			}
			.register-box .date .r-code {
				width: 1.9rem;
			}
			.register-box .date .code {
				width: auto;
			}
			.register-box .date .r-input {
				width: 2.5rem;
			}
			.styku span{font-size: 12px;}
			.styku span{font-size: 12px;}
			.btnClick>img{display: block;margin: 0 auto;float: left;}
			.m-wzxz{ width: 90px;height: 100%; font-size: 12px; display: block; line-height: 15px;}
		</style>
	</head>

	<body style="background: #0b1622">
	<div class="sygq0" style="color:#FFF;width:25%;height:auto;padding-top:10px; position: fixed; right: 0%; top: 0%; z-index: 9999;">

		<span class="btnClick sygq1" lang="cn" style="color:#FFF;display:block;float:right;height:30px ; margin-right: 15%!important;%; width:70%;position: relative;" ><img  alt="" src="/index/images/language/<?php echo $langage; ?>.png" style="width:16px;vertical-align:middle;" ><p class="m-wzxz m-wzxz2">&ensp;<?php echo $langagename; ?></p></span>


		<span class="btnClick sygq2" lang="cn" style="color:#FFF;display:block;float:right;height:30px; margin-right: 15%; width:60%;position: relative;" ><img alt="" src="/index/images/language/CNY.png" style="width:16px;vertical-align:middle;" ><p class="m-wzxz m-wzxz3">&ensp;中文</p></span>

		<span class="btnClick sygq2" lang="en" style="color:#FFF;display:block;float:right;width:60%; margin-right: 15%; height:40px;position: relative;" ><img alt="" src="/index/images/language/USD.png" style="width:16px;vertical-align:middle;" ><p class="m-wzxz m-wzxz3">&nbsp;English</p></span>

		<span class="btnClick sygq2" lang="jpn" style="color:#FFF;display:block;float:right;width:60%; margin-right: 15%; height:40px;position: relative;" ><img alt="" src="/index/images/language/JPY.png" style="width:16px;vertical-align:middle;" ><p class="m-wzxz m-wzxz3">&nbsp;日本語</p></span>

		<span class="btnClick sygq2" lang="kro" style="color:#FFF;display:block;float:right;width:60%; margin-right: 15%; height:40px;position: relative;" ><img alt="" src="/index/images/language/KRW.png" style="width:16px;vertical-align:middle;" ><p class="m-wzxz m-wzxz3">&nbsp;한글</p></span>

		<span class="btnClick sygq2" lang="turkey" style="color:#FFF;display:block;float:right;width:60%; margin-right: 15%; height:40px;position: relative;" ><img alt="" src="/index/images/language/TRY.png" style="width:16px;vertical-align:middle;" ><p class="m-wzxz m-wzxz3">&nbsp;Türkçe</p></span>

	</div>
		<div class="head wl_flex wl_align_center" style="background: #102030;position: relative">
			<a class="close" href="javascript:void(0)" onclick="javascript:history.back(-1);" style="font-size: 16px;color: white;margin-left: 8px;z-index: 99">
				<i class="iconfont icon-back_icon"></i>
			</a>
			<div class="logo" style="background: url(<?php echo $logo_src; ?>) no-repeat bottom; background-size: contain;position: absolute;top: auto;width: 100%"></div>
		</div>
		<!--<div class="pop hide" style="display: none;">
			<script type="text/javascript">
				//1
				$(document).ready(function() {
					$(".pop-shut").click(function() {
						$(".pop").toggle(300);
					});
					$(".nav").click(function() {
						$(".pop").toggle(300);
					});
				});
			</script>
			<div class="pop-shut"></div>
			<div class="list">
				<a href="<?php echo url('index/index'); ?>" style="color:#000000">
                    <div class="list-1">首页</div>
                </a>
                <a href="<?php echo url('about/about'); ?>" style="color:#000000">
                    <div class="list-1">关于我们</div>
                </a>
			</div>
		</div>-->
		<div class="register-box" style="background: #0b1622">
			<form method="post" id="form_submit" action="/Register/?op=register">
				<div class="title" style="color: #ffffff"><?php echo \think\Lang::get('regetit'); ?></div>
                
                <div class="date">
					<div class="phone"></div>
					<input type="text" class="r-input " name="nickname" placeholder="<?php echo \think\Lang::get('ri_zsxm'); ?>">
				</div>
				<div class="date">
					<div class="phone"></div>
					<input type="text" class="r-input username" name="username" placeholder="<?php echo \think\Lang::get('ri_yx'); ?>">
				</div>
				<div class="date">
					<input type="text" class="r-code" name="phonecode" placeholder="<?php echo \think\Lang::get('ri_qsryzm'); ?>">
					<input type="button" value="<?php echo \think\Lang::get('ri_hqyzm'); ?>" class="code code_btn"  onclick ="return get_svg();" >
				</div>
				<div class="date">
					<div class=""></div>
					<input type="text" class="r-input" name="oid" <?php if($oid): ?> value="<?php echo $oid; ?>" readonly <?php endif; ?> placeholder="<?php echo \think\Lang::get('ri_tjm'); ?>" >
				</div>
				<div class="date">
					<div class="passw"></div>
					<input type="password" class="r-input" name="upwd" placeholder="<?php echo \think\Lang::get('ri_mmywcd'); ?>">
				</div>
				<div class="date">
					<div class="passw"></div>
					<input type="password" class="r-input" name="upwd2" placeholder="<?php echo \think\Lang::get('ri_qrmm'); ?>">
				</div>
				<div class="terms">
					<input type="checkbox" class="checkbox" name="protocol" checked="checked">
					<span class="r-gree"><?php echo \think\Lang::get('ri_wyydbty'); ?><a href=""><?php echo \think\Lang::get('ri_yszc'); ?></a><?php echo \think\Lang::get('ri_h'); ?><a href=""><?php echo \think\Lang::get('ri_fwtk'); ?></a></span>
				</div>
				<div class="clear"></div>
				<div class="login_ps" id="login_ps"></div>
				<div class="register_btn">
					<input type="submit" name="submit" value="<?php echo \think\Lang::get('ri_cjzh'); ?>" class="sub_btn" onclick="return checkform(this.form);" >
				</div>
			</form>
			<div class="link">———————— or ————————</div>
			<div class="forget" style="color: #ffffff"><?php echo \think\Lang::get('ri_yyzh'); ?>
				<a href="<?php echo url('login/login'); ?>" class="col_orange"><?php echo \think\Lang::get('ri_ljdl'); ?></a>
			</div>
		</div>
	</body>
	<script>

		//选择国家语言
		$(".sygq2").hide();
		$(".sygq0").click(function () {
			$(".sygq1").hide();
			$(".sygq2").show();
		});
		$(".sygq2").click(function () {
			$(".sygq1").hide();
			$(".sygq2").hide();
			var data={'lang':$(this).attr('lang')};
			$.get("<?php echo url('login/lang'); ?>",data,function(){
				location.reload();
			})
		});

	function checkform(form){
		var username = form.username.value;
		var upwd = form.upwd.value;
		var upwd2 = form.upwd2.value;
		var oid = form.oid.value;
		var code = form.phonecode.value;
		if(!username){
			layer.msg('<?php echo \think\Lang::get('ri_qsryx'); ?>');
			return false; 
		}

		if(!code){
			layer.msg('<?php echo \think\Lang::get('ri_qsyzm'); ?>');
			return false; 
		}

		if (!upwd) {
			layer.msg('<?php echo \think\Lang::get('ri_qsrdlmm'); ?>');
			return false;
		}

		if (!upwd2) {
			layer.msg('<?php echo \think\Lang::get('ri_qzcsrdlmm'); ?>');
			return false;
		}

		if(upwd.length < 6 || upwd2.length < 6){
			layer.msg('<?php echo \think\Lang::get('ri_mmcddylw'); ?>');
			return false;
		}

		if(upwd != upwd2){
			layer.msg('<?php echo \think\Lang::get('ri_lcmmbt'); ?>');
			return false;
		}

		if(!oid){
			layer.msg('<?php echo \think\Lang::get('ri_qsmyqm'); ?>');
			return false; 
		}
		var data = $('#form_submit').serialize();
	    var formurl = "<?php echo Url('register/register'); ?>";
	    var locurl = "<?php echo Url('trades/index'); ?>";
	    WPpost(formurl,data,locurl);
	    return false;
	}
	</script>
</html>