<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"/www/wwwroot/agc.bxtrade.vip/application/index/view/login/respass2.html";i:1637561064;}*/ ?>
<html style="font-size: 129.375px;"><head>
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
<!--    <link rel="stylesheet" href="/index/css/login-respass2.css" >-->
    <script type="text/javascript" src="/index/iconfont/iconfont.js"></script>
    <script type="text/javascript" src="/index/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="/index/js/index.js"></script>
    <script src="__HOME__/js/lk/user.js"></script>
    <script src="/static/layer/layer.js"></script>
    <script src="/static/public/js/function.js"></script>
</head>
<style type="text/css">
    #formid{
        width: 100%;
        font-size: 14px;
    }
    .sign_up{
        width: 100%;
        height: 100%;
        padding-top: 0.2rem;
        position: relative;
    }
    .newinput{
        width: 94%;
        margin: auto;
        height: 0.34rem;
        border-bottom: 1px solid #343438;
        padding-top: 0.1rem;
    }
    .newbutton{
        display: block;
        height: 0.24rem;
        border-radius: 0.05rem;
        background: #2873c8;
        color: #FFFFFF;
        line-height: 0.24rem;
        text-align: center;
        font-size: 0.12rem;
        margin: auto;
        border: none;
        width: 30%;
        margin-top: 0.1rem;
        cursor: pointer;
    }
    .newinput .input-text {
        display: block;
        vertical-align: top;
        height: 0.3rem;
        text-align: left;
        font-size: 0.1rem;
        line-height: 0.3rem;
        float: left;
        width: 0.6rem;
    }
    .newinput .ng-pristine{
        display: block;
        height: 0.3rem;
        line-height: 0.3rem;
        float: left;
        text-indent: 0.5em;
        font-size: 0.1rem;
    }
    .code_btn{
        float: right;
        height: 0.3rem;
        line-height: 0.3rem;
        cursor: pointer;
        color: #ffffff;
        text-align: center;
        background: #2873c8;
        border-radius: 0.05rem;
        border: 1px solid #2873c8;
        padding: 0 0.04rem 0 0.04rem;
        width: 0.6rem;
    }
    .register-box{
        background: #0b1622
    }
    .register-box .title{
        color: #ffffff;
    }
    .register-box .retrieve{
        background: #102030;
    }
    .register-box .input-text{
        color: #ffffff;
    }
    .newinput .ng-pristine{
        border: none;
        background: none;
        outline: none;
        color: #ffffff;
    }
    .login-box .account .number .r-name{
        color: #ffffff;
    }
    .styku span{font-size: 12px;}
    .styku span{font-size: 12px;}
    .btnClick>img{display: block;margin: 0 auto;float: left;}
    .m-wzxz{ width: 90px;height: 100%; font-size: 12px; display: block; line-height: 15px;}

</style>
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
    <div class="logo" style="position: absolute;top: auto;width: 100%"></div>
</div>

<div class="register-box">
    <div class="title"><?php echo \think\Lang::get('ra_zhmm'); ?></div>
    <div class="retrieve">
        <div id="bpwidgets">
            <form method="post" id="formid">
              <div class="sign_up">
                  <div class="sign_up_content">
                      <ul class="sign_up_list">
                          <li class="newinput" ng-show="show_signup_code">
                              <span class="input-text" style="width: auto;">
                                  <?php echo \think\Lang::get('ra_yx'); ?>
                              </span>
                              <input type="text" placeholder="<?php echo \think\Lang::get('ra_yx2'); ?>" name="username" class="username ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" style="">
                          </li>
                          
                          
                          <li class="newinput input_iphone_code">
                              <span class="input-text" style="width: auto">
                                  <?php echo \think\Lang::get('ra_yzm'); ?>:
                              </span>
                              <input type="text" placeholder="<?php echo \think\Lang::get('ra_dxyzm'); ?>" name="phonecode" class="phonecode ng-pristine ng-valid ng-empty ng-touched" style="width: 0.7rem;">
                              <input type="button" class="code_btn ng-binding"  onclick ="return get_svg();" value="<?php echo \think\Lang::get('ra_hqyzm'); ?>">
                          </li>
                         
                          <li class="newinput">
                              <span class="input-text">
                                   <?php echo \think\Lang::get('ra_xmm'); ?>:
                              </span>
                              <input type="password" placeholder=" <?php echo \think\Lang::get('ra_mm'); ?>" name="upwd" required class="ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" style="">
                          </li>
                          <li class="newinput">
                              <span class="input-text">
                                   <?php echo \think\Lang::get('ra_mm'); ?>:
                              </span>
                              <input type="password" placeholder="<?php echo \think\Lang::get('ra_qrmm'); ?>" name="upwd2" required class="ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" style="">
                          </li>

                      </ul>
                      <button class="newbutton sign_up_btn" onClick="return checkform(this.form);" >
                          <?php echo \think\Lang::get('ra_czmm'); ?>
                      </button>
                  </div>
            </form>
        </div>
    </div>
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


function checkform(form){
    var username = form.username.value;
    var upwd = form.upwd.value;
    var upwd2 = form.upwd2.value;
    if(!username){
        layer.msg('<?php echo \think\Lang::get('ra_qsryx'); ?>');
        return false; 
    }

    if (!upwd) {
        layer.msg('<?php echo \think\Lang::get('ra_qsrdlmm'); ?>');
        return false;
    }

    if (!upwd2) {
        layer.msg('<?php echo \think\Lang::get('ra_qzcsrdlmm'); ?>');
        return false;
    }

    if(upwd.length < 6 || upwd2.length < 6){
        layer.msg('<?php echo \think\Lang::get('ra_mmcddyl'); ?>');
        return false;
    }

    if(upwd != upwd2){
        layer.msg('<?php echo \think\Lang::get('ra_lcsrdmmbt'); ?>');
        return false;
    }
    var data = $('#formid').serialize();
    var formurl = "<?php echo Url('login/respass2'); ?>";
    var locurl = "<?php echo Url('index/user/index'); ?>";
    WPpost(formurl,data,locurl);
    return false;
}
</script>
</body>
</html>