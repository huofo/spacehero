<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:68:"/www/wwwroot/agc.bxtrade.vip/application/index/view/login/login.html";i:1637561064;}*/ ?>
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
        <!--        夜间白天切换的文件-->
<!--        <link rel="stylesheet" href="/index/css/wap_css/login-login.css" >-->
        <script src="/index/js/jquery-2.1.4.min.js"></script>


        <!-- 弹框插件 -->
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

        <style>
            body{
                box-sizing: border-box;
                height: 100vh;
            }
            .login-box .account .number .r-name{
                color: #ffffff;
            }
            .styku span{font-size: 12px;}
            .styku span{font-size: 12px;}
            .btnClick>img{display: block;margin: 0 auto;float: left;}
            .m-wzxz{ width: 90px;height: 100%; font-size: 12px; display: block; line-height: 15px;}
        </style>
    </head>

    <body style="background: url(/index/images/language/dkybjt6.jpg)no-repeat center; background-size: 100% 100%;">

    <div class="sygq0" style="color:#FFF;width:25%;height:auto;padding-top:10px; position: fixed; right: 0%; top: 0%; z-index: 9999;">

        <span class="btnClick sygq1" lang="cn" style="color:#FFF;display:block;float:right;height:30px ; margin-right: 15%!important;%; width:70%;position: relative;" ><img  alt="" src="/index/images/language/<?php echo $langage; ?>.png" style="width:16px;vertical-align:middle;" ><p class="m-wzxz m-wzxz2">&ensp;<?php echo $langagename; ?></p></span>

        <span class="btnClick sygq2" lang="cn" style="color:#FFF;display:block;float:right;height:30px; margin-right: 15%; width:60%;position: relative;" ><img alt="" src="/index/images/language/CNY.png" style="width:16px;vertical-align:middle;" ><p class="m-wzxz m-wzxz3">&ensp;中文</p></span>

        <span class="btnClick sygq2" lang="en" style="color:#FFF;display:block;float:right;width:60%; margin-right: 15%; height:40px;position: relative;" ><img  alt="" src="/index/images/language/USD.png" style="width:16px;vertical-align:middle;" ><p class="m-wzxz m-wzxz3">&nbsp;English</p></span>

        <span class="btnClick sygq2" lang="jpn" style="color:#FFF;display:block;float:right;width:60%; margin-right: 15%; height:40px;position: relative;" ><img alt="" src="/index/images/language/JPY.png" style="width:16px;vertical-align:middle;" ><p class="m-wzxz m-wzxz3">&nbsp;日本語</p></span>

        <span class="btnClick sygq2" lang="kro" style="color:#FFF;display:block;float:right;width:60%; margin-right: 15%; height:40px;position: relative;" ><img alt="" src="/index/images/language/KRW.png" style="width:16px;vertical-align:middle;" ><p class="m-wzxz m-wzxz3">&nbsp;한글</p></span>

        <span class="btnClick sygq2" lang="turkey" style="color:#FFF;display:block;float:right;width:60%; margin-right: 15%; height:40px;position: relative;" ><img alt="" src="/index/images/language/TRY.png" style="width:16px;vertical-align:middle;" ><p class="m-wzxz m-wzxz3">&nbsp;Türkçe</p></span>

    </div>


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

            //加载语言包
            // $('.btnClick').click(function(){
            //
            //     var data={'lang':$(this).attr('lang')};
            //
            //     $.get("<?php echo url('login/lang'); ?>",data,function(){
            //
            //         location.reload();  //重新加载下语言包
            //
            //     })
            //
            // })
        
        </script>
       <style>
           .li-logdiv{width: 100%;height: 20%; margin-bottom: 26%;}
           .li-logdiv>img{width: 60px;height: 60px; display: block; margin: 0 auto;}
       </style>
        <div class="login-box" style="background-color: inherit;">
            <div class="li-logdiv">
                <img src="/index/images/language/logo11.png" />
            </div>
            <form method="post" id="form_submit" action="">
<!--                <div class="title" style="color: #ffffff"><?php echo \think\Lang::get('denglu'); ?></div>-->
                <div class="account" style="background: none">
                    <div class="number">
                        <div class="user"></div>
                        <input type="text" class="r-name" name="username" value="<?php echo !empty($uemail)?$uemail:''; ?>" placeholder="<?php echo \think\Lang::get('yhm'); ?>">
                    </div>
                    <div class="clear"></div>
                    <div class="number" style="border:0;">
                        <div class="passw"></div>
                        <input type="password" class="r-name" name="upwd" placeholder="<?php echo \think\Lang::get('dlmm'); ?>">
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="login_ps" id="login_ps"></div>
                <div class="login_btn">
                    <input type="submit" name="submit" value="<?php echo \think\Lang::get('msdl'); ?>"  class="sub_btn" onclick="return checkform(this.form);">
                </div>
            </form>
            <div class="forget" style="color: #ffffff"><?php echo \think\Lang::get('wjmm'); ?>？
                <a href="<?php echo url('login/respass2'); ?>" class="col_blu"><?php echo \think\Lang::get('zhmm'); ?></a>
            </div>
            <div class="link">———————— or ————————</div>
            <div class="forget" style="color: #ffffff"><?php echo \think\Lang::get('hmzh'); ?>？
                <a href="<?php echo url('register/register'); ?>" class="col_orange"><?php echo \think\Lang::get('10mzc'); ?></a>
            </div>
        </div>
       <script>
            function checkform(form){
                var username = form.username.value;
                var upwd = form.upwd.value;
                if(!username){
                    layer.msg('<?php echo \think\Lang::get('qsryhm'); ?>');
                    return false; 
                }
                if (!upwd) {
                    layer.msg('<?php echo \think\Lang::get('qsrmm'); ?>'); 
                    return false;
                }
                var data = $('#form_submit').serialize();
                var formurl = "<?php echo Url('index/login/login'); ?>";
                var locurl = "<?php echo Url('/index/index/index/token/'.$token); ?>";
                WPpost(formurl,data,locurl);
                return false;
            }


        </script>
    </body>
</html>