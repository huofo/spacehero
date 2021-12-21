<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:68:"/www/wwwroot/agc.bxtrade.vip/application/index/view/index/index.html";i:1639995480;s:63:"/www/wwwroot/agc.bxtrade.vip/application/index/view/alyslt.html";i:1636617716;s:61:"/www/wwwroot/agc.bxtrade.vip/application/index/view/foot.html";i:1638431011;}*/ ?>
<!DOCTYPE html>
<html style="font-size: 132.813px;">
<head>
    
<!--<link rel="stylesheet" href="//at.alicdn.com/t/font_2846038_fnopv2bz6be.css" >-->

<link rel="stylesheet" href="//at.alicdn.com/t/font_2846038_g9wnpy77tk.css" >


    <meta charset="utf-8">
    <title>B.King</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="full-screen" content="yes">
    <meta name="browsermode" content="application">
    <meta name="x5-page-mode" content="app">
    <meta name="x5-fullscreen" content="true">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <link href="/index/css/index_for.css" rel="stylesheet" type="text/css">
    <!--        夜间白天切换的文件-->


    <?php if(isset($_SESSION['night']) && $_SESSION["night"]=="yes"): ?>
    <link href="/index/css/switch-index_for.css" rel="stylesheet" type="text/css"><?php endif; ?>
    <link href="/index/css/swiper-bundle.min.css" rel="stylesheet" type="text/css">
    <link href="/static/index/layui/css/layui.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/index/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="/index/js/touchSlider.js"></script>
    <script type="text/javascript" src="/index/js/index.js"></script>
    <script src="/static/public/js/function.js"></script>
    <script src="/static/public/js/base64.js"></script>
    <script type="text/javascript">
        var Base64 = new Base64();
    </script>

    <style>
        .head{
            position: fixed;
            top: 0;
        }
        .banner{
            margin-top: 0.31rem;
        }

        .rise {
            color: #1fc65b !important;

        }

        .fall {
            color: #fa2e42 !important;
        }

        .rise-value {
            color: white!important;

            background-color: rgb(28, 190, 82)!important;
        }

        .fall-value {
            color: white;


            background-color: rgb(246, 41, 59)!important;
        }



        #performer li:last-child
        {
            border-bottom: 0px solid #f1f1f1;
        }

        #turnover li:last-child
        {
            border-bottom: 0px solid #f1f1f1;
        }
        .head .logo {
            width: 0.7rem!important;
            height: 0.2rem;
            margin: 0!important;
        }
        .head .header-txt2 {
            font-size: 14px;
            position: absolute;
            top: 0.075rem;
            right: 0.15rem;
        }
        .head .header-txt2 a{
            font-size: 14px;
            color: #000000;
        }
        /*    实验样式*/
        .dropbtnst {
            background: none;
            color: black;
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
            background-color: #f9f9f9;
            min-width: 160px;
            overflow: auto;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-contentst a {
            color: black;
            padding: 10px 60px 10px 10px;
            text-decoration: none;
            display: block;
        }

        .dropdownst a:hover {background-color: #f1f1f1}

        .showst {display:block;}
        .styku a{
            color: #F1F1F1;
        }
        .styku span{font-size: 12px;}
        .styku span{font-size: 12px;}
        .btnClick>img{display: block;margin: 0 auto;float: left;}
        .m-wzxz{ width: 90px;height: 100%;display: block; line-height: 15px;}
        .bottom-nav ul li a {font-size: 12px;}


        .myjms{color: #FFFFFF;}

        .lay{width: 100px; height: 30px;background-color: #60b879; border-radius: 25px;}
        .lay-div1{width: 25px;height: 25px; border-radius: 100px; background-color: #FFFFFF;float: left; margin-top: 2.5%; margin-left: 2%;}
        .lay>span{width: 70px; height: 100%; color: #FFFFFF; float: right; text-align: center; line-height: 30px; }
        .lay-div1-2{width: 25px;height: 25px; border-radius: 100px; background-color: #FFFFFF;float: right; margin-top: 2.5%; margin-right: 2%;}



        .layui-input-block{margin-left: 0px!important;margin-right: 10px}
        .layui-form-onswitch em{margin-left: 2.98px}
        .layui-form-switch em{top: -2px;}
        .layui-form-item{margin-bottom: 0!important;}
        .layui-form-label{float: unset!important;padding: 0;margin-bottom: 0px;margin-right: 10px}
        .layui-input-block {min-height: 40px;}
        .icon-yueliang,.icon-taiyang{color: #ffce54;}

        .left-hidden-box .nav-box .nav-box-header { height: 10%; margin-top: 0px;}
        .nav-box-tabs{height: 90%; width: 100%; overflow-y: scroll;}


    </style>
</head>
<body style="overflow-x:hidden;background: #000000">

<div class="sygq0" style="color:#FFF;width:25%;height:auto;padding-top:10px; position: fixed; right: 0%; top: 0%; z-index: 9999;">

    <span class="btnClick sygq1" lang="cn" style="color:#FFF;display:block;float:right;height:30px ; margin-right: 15%!important;%; width:70%;position: relative;" ><img  alt="" src="/index/images/language/<?php echo $langage; ?>.png" style="width:16px;vertical-align:middle;" ><p class="m-wzxz m-wzxz2">&ensp;<?php echo $langagename; ?></p></span>


    <span class="btnClick sygq2" lang="cn" style="color:#FFF;display:block;float:right;height:30px; margin-right: 15%; width:60%;position: relative;" ><img alt="" src="/index/images/language/CNY.png" style="width:16px;vertical-align:middle;" ><p class="m-wzxz m-wzxz3">&ensp;中文</p></span>

    <span class="btnClick sygq2" lang="en" style="color:#FFF;display:block;float:right;width:60%; margin-right: 15%; height:40px;position: relative;" ><img alt="" src="/index/images/language/USD.png" style="width:16px;vertical-align:middle;" ><p class="m-wzxz m-wzxz3">&nbsp;English</p></span>

    <span class="btnClick sygq2" lang="jpn" style="color:#FFF;display:block;float:right;width:60%; margin-right: 15%; height:40px;position: relative;" ><img alt="" src="/index/images/language/JPY.png" style="width:16px;vertical-align:middle;" ><p class="m-wzxz m-wzxz3">&nbsp;日本語</p></span>

    <span class="btnClick sygq2" lang="kro" style="color:#FFF;display:block;float:right;width:60%; margin-right: 15%; height:40px;position: relative;" ><img alt="" src="/index/images/language/KRW.png" style="width:16px;vertical-align:middle;" ><p class="m-wzxz m-wzxz3">&nbsp;한글</p></span>

    <span class="btnClick sygq2" lang="turkey" style="color:#FFF;display:block;float:right;width:60%; margin-right: 15%; height:40px;position: relative;" ><img alt="" src="/index/images/language/TRY.png" style="width:16px;vertical-align:middle;" ><p class="m-wzxz m-wzxz3">&nbsp;Türkçe</p></span>

</div>



<div class="head">
    <a href="javascript:void(0)">
        <div class="buttons buttons-left" style="transition-duration: 0ms;text-align: center;">
                <span class="center-buttons left-buttons">
                    <div class="back-button" btn="show-left" style="z-index: 55">
                    <i class="iconfont icon-gerenzhongxin"></i>
                    </div>
                </span>
        </div>
    </a>
    <!-- 左侧弹出栏-->
    <div id="left-hidden-box" class="left-hidden-box" style="display: none;">
        <div class="nav-box" style="transition: all 0.5s ease 0s; transform: translateX(-100%);">



            <div class="nav-box-header">
                <span style="font-size: 0.13rem;" ><?php echo !empty($user['utel'])?$user['utel']:''; ?></span> </br>
                <span style="font-size: 0.1rem;float: left;margin-top: -9px;">UID:<?php echo !empty($user['uid'])?$user['uid']:''; if($user['user_type']==1): ?>（<?php echo \think\Lang::get('fbjy_crs'); ?>）<?php else: ?>（<?php echo \think\Lang::get('fbjy_ks2'); ?>）<?php endif; ?></span>

            </div>



            <div class="nav-box-tabs" style="margin-left: 6%;">
                <div class="currency_name" style="font-size: 0.1rem;">
                    <ul class="ul styku">
                        <li class="legal_name flex between" onclick="">
                            <form class="layui-form" style="width: 51%;" action="">
                                <div class="layui-form-item wl_flex wl_align_center">
                                    <label class="layui-form-label myjms"><?php if($_SESSION["night"]=="yes"): ?><i class="iconfont icon-taiyang" style="font-size: 25px;"></i><?php else: ?><i class="iconfont icon-yueliang" style="font-size: 20px;"></i><?php endif; ?> </label>
                                    <div class="layui-input-block">
                                        <input <?php if($yes=="yes"): ?>checked<?php endif; ?> type="checkbox"  name="open" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
                                    </div>
                                </div>
                            </form>
                        </li>

                        <a href="<?php echo url('user/smrz'); ?>">
                            <li class="legal_name flex between" onclick="">
                                <strong><span><img src="/index/images/shenfens.png"  style="width: 15px;margin-top: -5px;margin-right: 10px;"><?php echo \think\Lang::get('ind_sfzr'); ?></span></strong>
                                <p class="gre"><span style="float: right;margin-top: -18px;margin-right: 10%;"><img src="/index/images/youjiantouyjt.png"  style="width: 15px;"></span></p>
                            </li>
                        </a>

                        <a href="<?php echo url('index/ercode'); ?>">
                            <li class="legal_name flex between" onclick="" style="margin-top: 25px;">
                                <strong><span><img src="/index/images/fenxianglianjie.png"  style="width: 15px;margin-top: -5px;margin-right: 10px;"><?php echo \think\Lang::get('ind_wdfxlj'); ?></span></strong>
                                <p class="gre"><span style="float: right;margin-top: -18px;margin-right: 10%;"><img src="/index/images/youjiantouyjt.png" alt="" style="width: 15px;"></span></p>
                            </li>
                        </a>

                        <a href="<?php echo url('goods/goods'); ?>">
                            <li class="legal_name flex between" onclick="" style="margin-top: 25px;">
                                <strong><span><img src="/index/images/hetong.png" style="width: 15px;margin-top: -5px;margin-right: 10px;"><?php echo \think\Lang::get('ind_myhjy'); ?></span></strong>
                                <p class="gre"><span style="float: right;margin-top: -18px;margin-right: 5%;"><img src="/index/images/youjiantouyjt.png" style="width: 15px;"></span></p>
                            </li>
                        </a>

                        <a href="<?php echo url('assets/shandui'); ?>">
                            <li class="legal_name flex between" onclick="" style="margin-top: 25px;">
                                <strong><span><img src="/index/images/hetong.png" style="width: 15px;margin-top: -5px;margin-right: 10px;"><?php echo \think\Lang::get('fbjy_sr'); ?></span></strong>
                                <p class="gre"><span style="float: right;margin-top: -18px;margin-right: 10%;"><img src="/index/images/youjiantouyjt.png" style="width: 15px;"></span></p>
                            </li>
                        </a>

                        <a href="<?php echo url('user/curordes'); ?>">
                            <li class="legal_name flex between" onclick="" style="margin-top: 25px;">
                                <strong><span><img src="/index/images/hetong.png" style="width: 15px;margin-top: -5px;margin-right: 10px;"><?php echo \think\Lang::get('fbjy_ddlb'); ?></span></strong>
                                <p class="gre"><span style="float: right;margin-top: -18px;margin-right: 10%;"><img src="/index/images/youjiantouyjt.png" style="width: 15px;"></span></p>
                            </li>
                        </a>





                        <?php if($user['user_type']==1): ?>
                      <a href="/index/User/gesjy">
                            <li class="legal_name flex between" onclick="" style="margin-top: 25px;">
                                <strong><span><i class="iconfont icon-navicon-jytj" style="color: #1296db;"></i> &#8194;AGC<?php echo \think\Lang::get('pa_cz'); ?></span></strong>
                                <p class="gre"><span style="float: right;margin-top: -18px;margin-right: 10%;"><img src="/index/images/youjiantouyjt.png" style="width: 15px;"></span></p>
                            </li>
                        </a>
                        <?php endif; ?>
                        <a href="<?php echo url('user/fbjy'); ?>">
                            <li class="legal_name flex between" onclick="" style="margin-top: 25px;">
                                <strong><span><img src="/index/images/ichaxun.png"  style="width: 15px;margin-top: -5px;margin-right: 10px;"><?php echo \think\Lang::get('ind_fbjy'); ?></span></strong>
                                <p class="gre"><span style="float: right;margin-top: -18px;margin-right: 10%;"><img src="/index/images/youjiantouyjt.png" alt=""style="width: 15px;"></span></p>
                            </li>
                        </a>

                        <!--<a href="<?php echo url('currencytrade/addpayment'); ?>">-->
                        <a href="<?php echo url('user/transactions2'); ?>">
                            <li class="legal_name flex between" onclick="" style="margin-top: 25px;">
                                <strong><span><img src="/index/images/icn60.png"  style="width: 15px;margin-top: -5px;margin-right: 10px;"><?php echo \think\Lang::get('fbjy_tjskfs'); ?></span></strong>
                                <p class="gre"><span style="float: right;margin-top: -18px;margin-right: 10%;"><img src="/index/images/youjiantouyjt.png" alt=""style="width: 15px;"></span></p>
                            </li>
                        </a>


                        <a href="<?php echo url('user/scwk'); ?>">
                            <li class="legal_name flex between" onclick="" style="margin-top: 25px;">
                                <strong><span><img src="/index/images/suocang.png"  style="width: 15px;margin-top: -5px;margin-right: 10px;"><?php echo \think\Lang::get('ind_scwk'); ?></span></strong>
                                <p class="gre"><span style="float: right;margin-top: -18px;margin-right: 10%;"><img src="/index/images/youjiantouyjt.png" alt=""style="width: 15px;"></span></p>
                            </li>
                        </a>
                        <style>
                            .mxxzx1{ width: 50%; float: left;}
                            .mxxzx1>span{margin-left: 8.5%; font-size: 14px;font-weight: 700;}
                            .mxxzx2{ width: 40%; float: right; margin-right: 10%;}
                            .mxxzx2>div{float: right;}
                            .mxxzx{width: 19px; height: 19px; line-height: 19px; text-align: center; border-radius: 50%;background-color: #ff3e60;}
                            .mxxzx1-img{width: 15px;height: 15px; margin-bottom: 2.5px;}
                            .mxxzx2-img{width: 15px;height: 15px; float: right; margin-top: 2.5px;}
                        </style>
                        <a href="/index/user/zym_kflt" >
                            <li class="legal_name flex between" onclick="" style="margin-top: 25px; overflow: hidden;">
                                <div class="mxxzx1" style="width: 70%"><img class="mxxzx1-img" src="/index/images/language/xxzx.png" /><span><?php echo \think\Lang::get('id_xxzx'); ?></span></div><div class="mxxzx2" style="width: 20%;"><img class="mxxzx2-img" src="/index/images/youjiantouyjt.png" />
                                <?php if($msg_nums): ?>
                                <div class="mxxzx"><?php echo $msg_nums; ?></div>
                                <?php endif; ?>

                            </div>
                            </li>
                        </a>

                        <a href="<?php echo url('user/security'); ?>">
                            <li class="legal_name flex between" onclick="" style="margin-top: 25px;">
                                <strong><span><img src="/index/images/suos.png"  style="width: 15px;margin-top: -5px;margin-right: 10px;"><?php echo \think\Lang::get('ind_aqzx'); ?></span></strong>
                                <p class="gre"><span style="float: right;margin-top: -18px;margin-right: 10%;"><img src="/index/images/youjiantouyjt.png"  style="width: 15px;"></span></p>
                            </li>
                        </a>

                        <a href="<?php echo url('about/about'); ?>">
                            <li class="legal_name flex between" onclick="" style="margin-top: 25px;">
                                <strong><span><img src="/index/images/ichaxun.png"  style="width: 15px;margin-top: -5px;margin-right: 10px;"><?php echo \think\Lang::get('ind_gywm'); ?></span></strong>
                                <p class="gre"><span style="float: right;margin-top: -18px;margin-right: 10%;"><img src="/index/images/youjiantouyjt.png"  style="width: 15px;"></span></p>
                            </li>
                        </a>

                        <a href="<?php echo url('login/logout'); ?>">
                            <li class="legal_name flex between" onclick="" style="margin-top: 30px;width: 80%;height: 35px;display: inline-block;background: dodgerblue;
                                       text-align: center;line-height: 35px;margin-left: 6%;border-radius: 5px;">
                                <strong><span class="m-sptcdl"><?php echo \think\Lang::get('ind_tcdl'); ?></span></strong>
                            </li>
                        </a>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--座谈出栏-->
    <div class="header-txt"></div>

    <div class="dropdownst" style="float: right;margin-right: 10px; display:none">
        <button onclick="myFunctionst()" class="dropbtnst" style="line-height: 0.3rem;width: 100%;color: white">
            中文<img src="/index/images/guoqi.png" alt="" style="float: right;margin-top: 0.1rem;margin-left: 3px;">
        </button>
        <div id="myDropdownst" class="dropdown-contentst" style="margin-left: -35px">
            <a href="#home">中文<img src="/index/images/guoqi.png" alt="" style="float: right;"></a>
            <a href="#about">한국어<img src="/index/images/hanguo.png" alt="" style="float: right;"></a>
            <a href="#contact">日本语<img src="/index/images/riben.png" alt="" style="float: right;"></a>
            <a href="#styhh">English<img src="/index/images/yingguo.png" alt="" style="float: right;"></a>
        </div>
    </div>

</div>

<div class="mindex-div1" style="background: #000033;">
    <div class="banner">
        <div class="main_visual">
            <div class="main_image">
                <ul>
                    <li><span class="img_3"></span></li>
                    <li><span class="img_2"></span></li>
                    <a href="">
                        <li><span class="img_1"></span></li>
                    </a>
                </ul>
                <a href="javascript:;" id="btn_prev"></a>
                <a href="javascript:;" id="btn_next"></a>
            </div>
        </div>
    </div>
    <!--用于撑起外边距div，请勿删除-->
    <!--        <div style="width: 100%;height: 1px;"></div>-->
    <div id="touchSlider1" class="touchSlider" style="height: 201.5px;">
        <div class="content">
            <ul>
                <!-- <?php if(is_array($autlist) || $autlist instanceof \think\Collection || $autlist instanceof \think\Paginator): $i = 0; $__LIST__ = $autlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?> -->
                <a href="">
                    <li><img src="<?php echo $vo['picture']; ?>"></li>
                </a>
                <!-- <?php endforeach; endif; else: echo "" ;endif; ?> -->
            </ul>
        </div>
        <ul class="number">
            <!-- <?php if(is_array($autlist) || $autlist instanceof \think\Collection || $autlist instanceof \think\Paginator): $i = 0; $__LIST__ = $autlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?> -->
            <li {if $vo.key eq 1} class="current"{if}><?php echo $vo['key']; ?></li>
            <!-- <?php endforeach; endif; else: echo "" ;endif; ?> -->
        </ul>
    </div>
    <!--用于撑起外边距div，请勿删除-->
    <div style="width: 100%;height: 1px;"></div>
</div>

<!--公告-->
<div class="news-two">
    <div class="new-two-box">
        <div class="new-two-left">
            <i class="iconfont icon-gonggao"></i>
        </div>
        <div class="new-two-right">
            <div class="new-two-list">
                <marquee direction="left" scrolldelay="20" scrollamount="2" loop="loop" behavior="scroll" hspace="10" height="20" class="marquee">
                    <div class="new-two-list-box"><?php echo $gonggao; ?></div>
                </marquee>
            </div>
        </div>
    </div>
</div>

<!--GU信息-->
<div class="trade swiper-container">
    <ul class="swiper-wrapper trade_list">
        <?php if(is_array($prodata) || $prodata instanceof \think\Collection || $prodata instanceof \think\Paginator): $i = 0; $__LIST__ = $prodata;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?>
        <li class="swiper-slide" id="kj<?php echo $list['pid']; ?>">
            <a href="<?php echo url('goods/goods_heyue',array('pid'=>$list['pid'],'token'=>$token)); ?>">
                <small class="usdt prtitle"><?php echo $list['Name']; ?></small>
                <h4  >
                    <span class="Price" ><?php echo $list['Price']; ?></span>
                    <span  class="DiffRate" ><?php echo $list['DiffRate']; ?>%</span>

                </h4>
            </a>
        </li>
        <?php endforeach; endif; else: echo "" ;endif; ?>


    </ul>

</div>



<!--快捷菜单-->
<div class="features-box">
    <div class="features-left" onclick="quickdepositlog()">
        <div class="features-left-txt">
            <span style="font-size: 12px;"><?php echo \think\Lang::get('ind_kjcb'); ?></span>
            <em><?php echo \think\Lang::get('ind_zcus'); ?>USDT</em>
        </div>
        <div class="features-left-right">
            <img src="/index/images/newico_recharge.png">
        </div>
    </div>
    <div class="features-right">
        <a href="<?php echo url('trades/index_heyue'); ?>">
            <div class="features-right-top">
                <img src="/index/images/newico_contract.png">
                <span><?php echo \think\Lang::get('ind_hyjy'); ?></span>
            </div>
        </a>
        <a href="<?php echo url('about/about'); ?>">
            <div class="features-right-top" style="margin-bottom:0">
                <img src="/index/images/newico_help.png">
                <span><?php echo \think\Lang::get('ind_bzzg'); ?></span>
            </div>
        </a>
    </div>
</div>
<script>
    function quickdepositlog(){
        location.href = "<?php echo url('assets/chongbi',array('name'=>'USDT')); ?>";
    }
</script>

<!-- 广告 -->
<div class="ad">
    <a href=""><img class="ad_img" src="<?php echo $fixinfo['picture']; ?>"></a>
</div>

<!--排行榜-->
<div class="highlists mt10">
    <ul class="nav nav-tabs">
        <li class="nav-active" data-type="0"><a style="font-weight: bold;"><?php echo \think\Lang::get('ind_zfb'); ?></a></li>
        <li data-type="1" class=""><a href="#turnover" style="font-weight: bold;"><?php echo \think\Lang::get('ind_cjeb'); ?></a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active">
            <ul class="flex ft12 between performer-classify performer-classifyone mxzdiv1" style="display: flex;background: #000033">
                <li><?php echo \think\Lang::get('ind_mc'); ?></li>
                <li class="tc"><?php echo \think\Lang::get('ind_zxj'); ?></li>
                <li class="tr"><?php echo \think\Lang::get('ind_zdf'); ?></li>
            </ul>
            <ul class="flex ft12 between performer-classify performer-classifytwo" style="display: none;">
                <li><?php echo \think\Lang::get('ind_mc'); ?></li>
                <li class="tc"><?php echo \think\Lang::get('ind_zxj'); ?></li>
                <li class="tr"><?php echo \think\Lang::get('ind_24cje'); ?>(CNY)</li>
            </ul>
            <ul id="performer" style="display: block;">

                <?php if(is_array($pro_zd) || $pro_zd instanceof \think\Collection || $pro_zd instanceof \think\Paginator): $i = 0; $__LIST__ = $pro_zd;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?>

                <li  id="zd<?php echo $list['pid']; ?>"><a href="<?php echo url('goods/goods',array('pid'=>$list['pid'],'token'=>$token)); ?>">
                    <b class="prtitle"><?php echo $list['Name']; ?></b>
                    <b class="tc Price" style="color:#00c087" ><?php echo $list['Price']; ?></b>
                    <button class="btn btn-default DiffRate" style="background:#00c087"  ><?php echo $list['DiffRate']; ?>%</button>
                </a>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>

            </ul>
            <ul id="turnover" style="display: none;">

                <?php if(is_array($pro_cj) || $pro_cj instanceof \think\Collection || $pro_cj instanceof \think\Paginator): $i = 0; $__LIST__ = $pro_cj;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?>
                <li  id="cj<?php echo $list['pid']; ?>"><a href="<?php echo url('goods/goods',array('pid'=>$list['pid'],'token'=>$token)); ?>">
                    <b  class="prtitle"><?php echo $list['Name']; ?></b>
                    <b class="tc Price" style="color:#ff3e60"   ><?php echo $list['Price']; ?></b>
                    <button class="btn btn-default vol" style="background:#ff3e60"  ><?php echo $list['vol']; ?><?php echo \think\Lang::get('ind_yi'); ?></button>
                </a>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>

            </ul>
        </div>
    </div>
</div>

<div class="clear"></div>
<div style="height: 50px"></div>
<!-- 弹框 -->
<script type="text/javascript">

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



    //setInterval('GuidanceTransformation()', 10000);
    $(document).ready(function() {
        //幻灯
        $(function() {
            $("#touchSlider1").touchSlider(600, 300, true, 5000);
        });
        //内容切换
        $('.news li').click(function() {
            $(this).addClass("cour").siblings().removeClass("cour");
            var index = $('.news li').index(this);
            $('.news-box').eq(index).addClass('pro_show').siblings().removeClass('pro_show');
        });
        //底部导航
        $('.bottom-nav li').click(function() {
            $(this).addClass("butcour").siblings().removeClass("butcour");
        })
        //名师轮播
        var li_l = $('#tutor li').length;
        var t_w = $('#tutorlist').width();
        var s_m = $('.switch').width()*2.5/100;
        $('#tutor li').width(t_w);
        $('#tutor li').css({'margin-right':s_m});
        $('#tutor').width(li_l*(t_w+(s_m*(li_l-1))));
        var list=$('#tutor li');
        var k=0;
        list.each(function(){
            var i=$(this).index();
            $(this).click(function(){
                list.eq(i).fadeIn();
                list.not(list.eq(i)).fadeOut();
                k=i;
            });
        });
        //自动轮播.
        setInterval(function(){
            k++;
            if(k>li_l-1){k=0}
            list.eq(k).fadeIn();
            list.not(list.eq(k)).fadeOut();
        },5000);
    });
</script>
<!-- 底部广告 -->
<script type="text/javascript">
    var $a = $(".buttons a");
    var $s = $(".buttons span");
    var cArr = [<?php echo $plist; ?>];
    var index = 0;
    var timer;
    //上一张
    function previmg() {
        cArr.unshift(cArr[8]);
        cArr.pop();
        $(".list li").each(function(i, e) {
            $(e).removeClass().addClass(cArr[i]);
        });
        index--;
        if(index < 0) {
            index = 8;
        }
        show();
    }
    //下一张
    function nextimg() {
        cArr.push(cArr[0]);
        cArr.shift();
        $(".list li").each(function(i, e) {
            $(e).removeClass().addClass(cArr[i]);
        });
        index++;
        if(index > 8) {
            index = 0;
        }
        show();
    }
    //通过底下按钮点击切换
    $a.each(function() {
        $(this).click(function() {
            var myindex = $(this).index();
            var b = myindex - index;
            if(b == 0) {
                return;
            } else if(b > 0) {
                var newarr = cArr.splice(0, b);
                cArr = $.merge(cArr, newarr);
                $(".list li").each(function(i, e) {
                    $(e).removeClass().addClass(cArr[i]);
                });
                index = myindex;
                show();
            } else if(b < 0) {

                cArr.reverse();
                var oldarr = cArr.splice(0, -b);
                cArr = $.merge(cArr, oldarr);
                cArr.reverse();
                $(".list li").each(function(i, e) {
                    $(e).removeClass().addClass(cArr[i]);
                });
                index = myindex;
                show();
            }
        })
    });
    //改变底下按钮的背景色
    function show() {
        $($s).eq(index).addClass("blue").parent().siblings().children().removeClass("blue");
    }
    //点击class为p4的元素触发下一张照片的函数
    $(document).on("click", ".p4", function() {
        clearInterval(timer);
        nextimg();
        return false;
    });
    // 进入页面自动开始定时器
    timer = setInterval(nextimg, 2500);

</script>

<script type="text/javascript" src="/index/js/swiper-bundle.min.js"></script>
<script>
    //新选项卡切换效果
    $(function () {
        // intervalData(true);
        setInterval(function () {
            // intervalData(false)
        }, 6000)

        $(".nav-tabs li").click(function () {
            $(".nav-tabs li").removeClass('nav-active');
            $(this).addClass('nav-active');
            if ($(this).attr('data-type') == 1) {
                $("#performer").hide();
                $("#turnover").show();
                $(".performer-classifytwo").show();
                $(".performer-classifyone").hide();
            } else {
                $("#performer").show();
                $("#turnover").hide();
                $(".performer-classifyone").show();
                $(".performer-classifytwo").hide();
            }
        })
    })
    //数值信息轮播
    // $('.trade_list').html(html)
    var swiper = new Swiper('.trade', {
        slidesPerView: 3,
        spaceBetween: 30,

    });
</script>


<script>
    setInterval("ajaxpros()",3000);
    function ajaxpros(){
        var geturl = "/index/index/ajaxindexzd";
        var type = '';
        $.get(geturl,function(data){
            if (data) {
                data = jQuery.parseJSON(Base64.decode(data));
                $.each(data.zd,function(k,v){


                    $('#zd'+v.pid+' .prtitle').html(v.ptitle);
                    $('#zd'+v.pid+' .Price').html(v.Price);
                    $('#zd'+v.pid+' .DiffRate').html(v.DiffRate+'%');

                    $('#kj'+v.pid+' .prtitle').html(v.ptitle);
                    $('#kj'+v.pid+' .Price').html(v.Price);
                    $('#kj'+v.pid+' .DiffRate').html(v.DiffRate+'%');


                    if(v.isup == 1){


                        $('#zd'+v.pid+' .Price').addClass('rise');
                        $('#zd'+v.pid+' .Price').removeClass('fall');

                        $('#kj'+v.pid+' .Price').addClass('rise');
                        $('#kj'+v.pid+' .Price').removeClass('fall');


                    }else if(v.isup == 0){


                        $('#zd'+v.pid+' .Price').removeClass('rise');
                        $('#zd'+v.pid+' .Price').addClass('fall');

                        $('#kj'+v.pid+' .Price').removeClass('rise');
                        $('#kj'+v.pid+' .Price').addClass('fall');
                    }


                    if(v.DiffRate >= 0){

                        $('#zd'+v.pid+' .DiffRate').addClass('rise-value');
                        $('#zd'+v.pid+' .DiffRate').removeClass('fall-value');

                        $('#kj'+v.pid+' .DiffRate').addClass('rise');
                        $('#kj'+v.pid+' .DiffRate').removeClass('fall');

                    }else{

                        $('#zd'+v.pid+' .DiffRate').removeClass('rise-value');
                        $('#zd'+v.pid+' .DiffRate').addClass('fall-value');

                        $('#kj'+v.pid+' .DiffRate').removeClass('rise');
                        $('#kj'+v.pid+' .DiffRate').addClass('fall');

                    }

                });

                $.each(data.cj,function(k,v){

                    $('#cj'+v.pid+' .prtitle').html(v.ptitle);
                    $('#cj'+v.pid+' .Price').html(v.Price);
                    $('#cj'+v.pid+' .vol').html(v.vol);

                    if(v.isup == 1){

                        $('#cj'+v.pid+' .Price').addClass('rise');
                        $('#cj'+v.pid+' .Price').removeClass('fall');

                    }else if(v.isup == 0){

                        $('#cj'+v.pid+' .Price').removeClass('rise');
                        $('#cj'+v.pid+' .Price').addClass('fall');
                    }
                });

            }

        });
    }

</script>
<script src="/static/index/layui/layui.js"></script>
<script>
    // 'element', var element = layui.element;
    layui.use('form', function(){
        var form = layui.form;
        //监听提交
        form.on('submit(formDemo)', function(data){
            layer.msg(JSON.stringify(data.field));
            return false;
        });

        //点击切换黑夜白天模式
        $(".layui-form-switch").click(function () {
            var vau=$(".layui-form-switch>em").text();
            var yes="yes"
            if (vau=="ON"){
                $.post("/index/index/night",{yes:yes},function (re) {
                    if (re=="ok"){window.location.href="/index/Index/index"}
                });
            }else if(vau=="OFF"){
                $.post("/index/index/night",{yes:"on"},function (re) {
                    if (re=="on"){window.location.href="/index/Index/index";}
                });
            }

        })


    });

</script>
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
            $('.view-container').css('z-index', 10)
            Pdiv.style.display = 'block';
            setTimeout(function(){
                Sdiv.style.transition ='0.5s';
                Sdiv.style.transform = 'translateX(0%)';
            }, 0);
        }
        function hiddenBox(){

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

        }
        function hiddenBox(){

            Sdiv.style.transform = 'translateX(-100%)';
            setTimeout(function(){
                $('.view-container').css('z-index', 9)
                Pdiv.style.display = 'none';
            }, 500)

        }
    })();
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
