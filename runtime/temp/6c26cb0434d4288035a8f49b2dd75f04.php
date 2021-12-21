<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:66:"/www/wwwroot/agc.bxtrade.vip/application/index/view/user/fbjy.html";i:1637561064;s:63:"/www/wwwroot/agc.bxtrade.vip/application/index/view/alyslt.html";i:1636617716;s:64:"/www/wwwroot/agc.bxtrade.vip/application/index/view/fbjy_js.html";i:1637071789;}*/ ?>
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
    <title>
    </title>
    <link href="__HOME__/css/pay1.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="/index/iconfont/font_fpk8hw6pfut/iconfont.css" >
    <link rel="stylesheet" href="/index/iconfont/font_pcmjuj5uup/iconfont.css" >
    <link rel="stylesheet" href="/index/css/optional.css" >
    <link rel="stylesheet" href="/static/index/layui/css/modules/layer/default/layer.css?v=3.1.1" >
    
<!--<link rel="stylesheet" href="//at.alicdn.com/t/font_2846038_fnopv2bz6be.css" >-->

<link rel="stylesheet" href="//at.alicdn.com/t/font_2846038_g9wnpy77tk.css" >


    <!--        夜间白天切换的文件-->
    <?php if($_SESSION["night"]=="yes"): ?><link href="/index/css/fbjy.css" rel="stylesheet" ><?php else: ?><link class="fbjyfh-btms2s" rel="stylesheet" href="/index/css/user-fbjy-htms.css"> <?php endif; ?>

<!--    黑夜模式-->
<!--    <link class="fbjyfh-btms2s" rel="stylesheet" href="/index/css/user-fbjy-htms.css">-->
  <!--  <script>
    var fbjy_qsrgmje="<?php echo \think\Lang::get('fbjy_qsrgmje'); ?>";

    var fbjy_qsrgmdjebnxy="<?php echo \think\Lang::get('fbjy_qsrgmdjebnxy'); ?>";
    var fbjy_qsrgmsl="<?php echo \think\Lang::get('fbjy_qsrgmsl'); ?>";
    var fbjy_qsrgmdbnxy="<?php echo \think\Lang::get('fbjy_qsrgmdbnxy'); ?>";
    var fbjy_ckdj="<?php echo \think\Lang::get('fbjy_ckdj'); ?>";
    var rt_qrtj="<?php echo \think\Lang::get('rt_qrtj'); ?>";
    var jse_qxzzffs="<?php echo \think\Lang::get('jse_qxzzffs'); ?>";

    var fbjy_qsrgmslje="<?php echo \think\Lang::get('fbjy_qsrgmslje'); ?>";
    var fbjy_qsrcsslhje="<?php echo \think\Lang::get('fbjy_qsrcsslhje'); ?>";
    var fbjy_srcsdslhjebnxyl="<?php echo \think\Lang::get('fbjy_srcsdslhjebnxyl'); ?>";
    var fbjy_qsrgmslhje="<?php echo \think\Lang::get('fbjy_qsrgmslhje'); ?>";
    var fbjy_qsrgmdslhjebn="<?php echo \think\Lang::get('fbjy_qsrgmdslhjebn'); ?>";
    var fbjy_djzy="<?php echo \think\Lang::get('fbjy_djzy'); ?>";
    var fbjy_zwzffs="<?php echo \think\Lang::get('fbjy_zwzffs'); ?>";


    var fbjy_qxzskfs="<?php echo \think\Lang::get('fbjy_qxzskfs'); ?>";
    var fbjy_qsrcssl="<?php echo \think\Lang::get('fbjy_qsrcssl'); ?>";
    var fbjy_srcsdslbnxyh="<?php echo \think\Lang::get('fbjy_srcsdslbnxyh'); ?>";
    var fbjy_qsrcsjesl="<?php echo \think\Lang::get('fbjy_qsrcsjesl'); ?>";
    var fbjy_sqcsdjebnxy="<?php echo \think\Lang::get('fbjy_sqcsdjebnxy'); ?>";
    var fbjy_zdksw="<?php echo \think\Lang::get('fbjy_zdksw'); ?>";
    var fbjy_qtxyzm="<?php echo \think\Lang::get('fbjy_jfsyzmdnn'); ?>";

    var fbjy_dj= "<?php echo \think\Lang::get('fbjy_dj'); ?>";
    var bi_sl= "<?php echo \think\Lang::get('bi_sl'); ?>";
    var fbjy_qxzqxdd= "<?php echo \think\Lang::get('fbjy_qxzqxdd'); ?>";
    var fbjy_wlcc= "<?php echo \think\Lang::get('fbjy_wlcc'); ?>";
    var fbjy_qqycqcs="<?php echo \think\Lang::get('fbjy_qqycqcs'); ?>";


    var  ue_sccg="<?php echo \think\Lang::get('ue_sccg'); ?>";
    var  fbjy_cdl="<?php echo \think\Lang::get('fbjy_cdl'); ?>";
    var  sw_gm="<?php echo \think\Lang::get('sw_gm'); ?>";
    var  fbjy_cs="<?php echo \think\Lang::get('fbjy_cs'); ?>";
    var  fbjy_qtxje="<?php echo \think\Lang::get('fbjy_qtxje'); ?>";
    var  fbjy_txsl="<?php echo \think\Lang::get('fbjy_txsl'); ?>";
    var fbjy_nhwtjskfs="<?php echo \think\Lang::get('fbjy_nhwtjskfs'); ?>";
    var fbjy_qrjjfx="<?php echo \think\Lang::get('fbjy_qrjjfx'); ?>";
    var fbjy_bl="<?php echo \think\Lang::get('fbjy_bl'); ?>";
    var bi_qd="<?php echo \think\Lang::get('bi_qd'); ?>";
    var fbjy_jjcg="<?php echo \think\Lang::get('fbjy_jjcg'); ?>";
    var fbjy_qdjwyqr="<?php echo \think\Lang::get('fbjy_qdjwyqr'); ?>";
    var fbjy_mjqxdd="<?php echo \think\Lang::get('fbjy_mjqxdd'); ?>";
    var fbjy_qrqxdd="<?php echo \think\Lang::get('fbjy_qrqxdd'); ?>";
    var fbjy_ddysx="<?php echo \think\Lang::get('fbjy_ddysx'); ?>";
    var fbjy_ppddh="<?php echo \think\Lang::get('fbjy_ppddh'); ?>";
    var fbjy_gqddh="<?php echo \think\Lang::get('fbjy_gqddh'); ?>";
    var fbjy_ddh="<?php echo \think\Lang::get('fbjy_ddh'); ?>";
    var fbjy_wcj="<?php echo \think\Lang::get('fbjy_wcj'); ?>";
    var fbjy_cssl="<?php echo \think\Lang::get('fbjy_cssl'); ?>";
    var fbjy_csje="<?php echo \think\Lang::get('fbjy_csje'); ?>";
    var fbjy_gmsl="<?php echo \think\Lang::get('fbjy_gmsl'); ?>";
    var fbjy_gmje="<?php echo \think\Lang::get('fbjy_gmje'); ?>";
    var fbjy_scpz ="<?php echo \think\Lang::get('fbjy_scpz'); ?>";
    var fbjy_qewc ="<?php echo \think\Lang::get('fbjy_qewc'); ?>";
    var cd_fzcg='<?php echo \think\Lang::get('cd_fzcg'); ?>';
    var cd_fzsb='<?php echo \think\Lang::get('cd_fzsb'); ?>';
    var cd_hqz='<?php echo \think\Lang::get('cd_hqz'); ?>';
    var bibi_qsrczsl='<?php echo \think\Lang::get('bibi_qsrczsl'); ?>';
    var fbjy_qxzcbfs='<?php echo \think\Lang::get('fbjy_qxzcbfs'); ?>';
    var fbjy_qscpz='<?php echo \think\Lang::get('fbjy_qscpz'); ?>';
    var ue_scsbqcs='<?php echo \think\Lang::get('ue_scsbqcs'); ?>';
    var cb_tjcg='<?php echo \think\Lang::get('cb_tjcg'); ?>';
    var bi_qx = "<?php echo \think\Lang::get('bi_qx'); ?>";
    var sl_ywc ="<?php echo \think\Lang::get('sl_ywc'); ?>";
    var isdelete_confirm = "<?php echo \think\Lang::get('isdelete_confirm'); ?>";

    var fbjy_ddmjqrsk ="<?php echo \think\Lang::get('fbjy_ddmjqrsk'); ?>";

</script>-->
    <script type="text/javascript" src="__HOME__/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="__HOME__/js/lk/user.js"></script>
    <script type="text/javascript" src="/static/index/layui/lay/modules/layer.js"></script>

        <script>
        var fbjy_qsrgmje='<?php echo \think\Lang::get('fbjy_qsrgmje'); ?>';

       var fbjy_qsrgmdjebnxy="<?php echo \think\Lang::get('fbjy_qsrgmdjebnxy'); ?>";
        var fbjy_qsrgmsl='<?php echo \think\Lang::get('fbjy_qsrgmsl'); ?>';
        var fbjy_qsrgmdbnxy="<?php echo \think\Lang::get('fbjy_qsrgmdbnxy'); ?>";
        var fbjy_ckdj='<?php echo \think\Lang::get('fbjy_ckdj'); ?>';
        var rt_qrtj='<?php echo \think\Lang::get('rt_qrtj'); ?>';
        var jse_qxzzffs='<?php echo \think\Lang::get('jse_qxzzffs'); ?>';

        var fbjy_qsrgmslje='<?php echo \think\Lang::get('fbjy_qsrgmslje'); ?>';
         var fbjy_qsrcsslhje='<?php echo \think\Lang::get('fbjy_qsrcsslhje'); ?>';
         var fbjy_srcsdslhjebnxyl="<?php echo \think\Lang::get('fbjy_srcsdslhjebnxyl'); ?>";
         var fbjy_qsrgmslhje='<?php echo \think\Lang::get('fbjy_qsrgmslhje'); ?>';
         var fbjy_qsrgmdslhjebn="<?php echo \think\Lang::get('fbjy_qsrgmdslhjebn'); ?>";
         var fbjy_djzy='<?php echo \think\Lang::get('fbjy_djzy'); ?>';
         var fbjy_zwzffs='<?php echo \think\Lang::get('fbjy_zwzffs'); ?>';


         var fbjy_qxzskfs='<?php echo \think\Lang::get('fbjy_qxzskfs'); ?>';
         var fbjy_qsrcssl='<?php echo \think\Lang::get('fbjy_qsrcssl'); ?>';
         var fbjy_srcsdslbnxyh="<?php echo \think\Lang::get('fbjy_srcsdslbnxyh'); ?>";
         var fbjy_qsrcsjesl='<?php echo \think\Lang::get('fbjy_qsrcsjesl'); ?>';
         var fbjy_sqcsdjebnxy="<?php echo \think\Lang::get('fbjy_sqcsdjebnxy'); ?>";
         var fbjy_zdksw='<?php echo \think\Lang::get('fbjy_zdksw'); ?>';
         var fbjy_qtxyzm='<?php echo \think\Lang::get('fbjy_jfsyzmdnn'); ?>';

         var fbjy_dj= '<?php echo \think\Lang::get('fbjy_dj'); ?>';
         var bi_sl= '<?php echo \think\Lang::get('bi_sl'); ?>';
         var fbjy_qxzqxdd= "<?php echo \think\Lang::get('fbjy_qxzqxdd'); ?>";
         var fbjy_wlcc= "<?php echo \think\Lang::get('fbjy_wlcc'); ?>";
         var fbjy_qqycqcs='<?php echo \think\Lang::get('fbjy_qqycqcs'); ?>';
        var  ue_sccg='<?php echo \think\Lang::get('ue_sccg'); ?>';
    </script>



</head>
<body style="background: #fbfbfb">
<div class="daohang">
    <div class="daohang-zuo">
        <a href="javascript:void(0)" onclick="javascript:history.back(-1);">
            <i class="iconfont icon-31fanhui1"></i>
        </a>
        <div class="fajy-kzq">

            <span><?php echo \think\Lang::get('fbjy_kjq'); ?></span><span style="color: #d1a954;"><?php echo \think\Lang::get('fbjy_kjq'); ?></span><i class="iconfont icon-xiangxia1"></i><i class="iconfont icon-xiangshang1" style="color: #d1a954;"></i>

        </div>
    </div>
    <div class="daohang-zhong"><span><span class="cur_name"><?php echo $default_currency; ?></span>&#8194;</span><i class="iconfont icon-huazhuan"></i></div>
</div>
<div class="fbjy-whole">
    <div class="fbjy-div1">

        <div style="width: 80%;float: left;">
            <span class="fbjy-wym"><?php echo \think\Lang::get('fb_wym'); ?>&#8195;</span>
            <span class="fbjy-wym2">&#8195;<?php echo \think\Lang::get('fb_wym2'); ?></span>
        </div>
        <div  style="width: 20%;float: right;text-align: right;"><a href="/index/User/curordes"><i class="iconfont icon-icon2"></i></a></div>
        <!--<div></div>-->

    </div>
    <div class="fbjy-xzbz">
        <ul>
            <?php if(is_array($currencys) || $currencys instanceof \think\Collection || $currencys instanceof \think\Paginator): $i = 0; $__LIST__ = $currencys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?>
            <li id="<?php echo $data['pid']; ?>" data-price="<?php echo $data['price']; ?>" data-name="<?php echo $data['Name']; ?>" data-money="<?php echo $data['sl']; ?>">
                <p><?php echo $data['Name']; ?></p>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
    <div class="fbjy-gmje">
        <div class="fbjy-gmje2">

            <p class="fbjy-gmje2-p1"><?php echo \think\Lang::get('fbjy_gmsl'); ?></p>
            <div class="fbjy-gmje2-div fbjy-gmsl">
                <input id="buy_num" placeholder="<?php echo \think\Lang::get('fbjy_esq'); ?>">

                <span class="symbol_name">USDT</span>
            </div>
<!--            <div class="fbjy-gmje2-div fbjy-gmje5">-->
<!--                <span class="currency_icon"><?php echo $default_currency_icon; ?></span>-->

<!--                <input id="buy_amount" placeholder="<?php echo \think\Lang::get('fbjy_ybq'); ?>">-->
<!--            </div>-->
            <div class="fbjy-gmje2-div2">
                <div><?php echo \think\Lang::get('fbjy_ckdj'); ?> <span class="sc_price">0.00</span> <span class="cur_name"><?php echo $default_currency; ?></span></div>
<!--                <div class="fbjy-slgm" onclick="buyonbase('num')"><?php echo \think\Lang::get('fbjy_aslgm'); ?> <i class="iconfont icon-huazhuan"></i></div>-->
<!--                <div class="fbjy-jbgb" onclick="buyonbase('amount')"><?php echo \think\Lang::get('fbjy_ajegm'); ?> <i class="iconfont icon-huazhuan"></i></div>-->
            </div>
            <button class="fbjy-gmje2-boutt fbjy-gmje2-boutt1" ><?php echo \think\Lang::get('fbjy_lsxfgm'); ?></button>
        </div>
        <div class="fbjy-gmje2">
          <p class="fbjy-gmje2-p1"><span class="fbjy-sp1"><?php echo \think\Lang::get('fbjy_cssl'); ?></span> <span class="fbjy-gmje2-hz"><a href=""><!--  划转--></a></span></p>
            <div class="fbjy-gmje2-div fbjy-cssl">
                <input id="can_sell_num" style="width: 68%; padding-left: 2%; " placeholder="<?php echo \think\Lang::get('fbjy_zdksw'); ?><?php echo $default_symbol['sl']; ?>">
                <div class="fbjy-mcxz"><span class="fbjy-mcbz"> <span class="symbol_name"> USDT</span> <span class="fbjy-mcxzqb" onclick="get_all()"><?php echo \think\Lang::get('ti_qb'); ?></span></span></div>
            </div>
<!--            <div class="fbjy-gmje2-div fbjy-csje">-->
<!--                <input  id="can_sell_amount" style="width: 100%; padding-left: 2%; " placeholder="<?php echo \think\Lang::get('fbjy_zdksw'); ?><?php echo $default_symbol['sl']; ?>">-->
<!--            </div>-->
            <div class="fbjy-gmje2-div2">
                <div><?php echo \think\Lang::get('fbjy_ckdj'); ?> <span class="sc_price">0.00</span> <span class="cur_name"><?php echo $default_currency; ?></span></div>
<!--                <div class="fbjy-jecs" onclick="sellonbase('num')"><?php echo \think\Lang::get('fbjy_aslcs'); ?> <i class="iconfont icon-huazhuan"></i></div>-->
<!--                <div class="fbjy-slcs" onclick="sellonbase('amount')"><?php echo \think\Lang::get('fbjy_ajecs'); ?> <i class="iconfont icon-huazhuan"></i></div>-->
            </div>
            <button class="fbjy-gmje2-boutt fbjy-gmje2-boutt2" onclick="addorder(1)"><?php echo \think\Lang::get('fbjy_lsxfcs'); ?></button>

        </div>
    </div>
</div>
<div class="fbjy-xzquu">
    <div class="fbjy-xzquu-div1">
        <div>
            <div class="fbjy-xzquu-div2">
                <a href="/index/user/fbjy">

                    <p class="fbjy-xzquu-p1"><?php echo \think\Lang::get('fbjy_kjq'); ?></p>
                    <p><?php echo \think\Lang::get('fbjy_yjmmksjy'); ?></p>

                </a>
            </div>
            <div class="fbjy-xzquu-div3"><i class="iconfont icon-dagou"></i></div>
        </div>
        <div>
            <div class="fbjy-xzquu-div2">
                <a href="/index/User/optional">

                    <p class="fbjy-xzquu-p1"><?php echo \think\Lang::get('fbjy_zxq'); ?></p>
                    <p><?php echo \think\Lang::get('fbjy_gdxzzyjy'); ?></p>

                </a>
            </div>
            <div class="fbjy-xzquu-div3"></div>
        </div>
    </div>
    <div></div>
</div>
<div class="fabi-xzfb" style="display: none;">
    <div class="fabi-xzfb-hode">
        <div><a class="fabi-fh"><i class="iconfont icon-31fanhui1"></i></a></div>

        <div class=""><?php echo \think\Lang::get('fbjy_xzfb'); ?></div>

        <div class=""></div>
    </div>
    <div class="fabi-xzfb-div1">
        <span><i class="iconfont icon-chaxun"></i></span>

        <input placeholder="<?php echo \think\Lang::get('fbjy_qsrfb'); ?>" id="search_curr" oninput="search_curr()">

    </div>
    <div class="fabi-xzfb-list">
        <?php if(is_array($firstw) || $firstw instanceof \think\Collection || $firstw instanceof \think\Paginator): $i = 0; $__LIST__ = $firstw;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?>


        <div class="fabi-xzfb-list2 old_list">

            <div class="fabi-xzfb-bt"><?php echo $data; ?></div>

            <ul>
                <?php if(is_array($tenderWord[$data]) || $tenderWord[$data] instanceof \think\Collection || $tenderWord[$data] instanceof \think\Paginator): $i = 0; $__LIST__ = $tenderWord[$data];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>

                    <li data-name="<?php echo $item['name']; ?>" data-rate="<?php echo $item['exc_rate']; ?>" data-icon="<?php echo $item['symbol']; ?>"><span><?php echo $item['symbol']; ?></span><span><?php echo $item['name']; ?></span></li>

                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>

        </div>

        <?php endforeach; endif; else: echo "" ;endif; ?>

        <div class="fabi-xzfb-list2 new_list">



        </div>
    </div>
</div>
<style>



</style>
<div class="fabi-qrcs">
    <div class="fabi-qrcs-whole">
        <div class="fabi-qrcs-whole-noe">

            <div><span><?php echo \think\Lang::get('fbjy_qrcs'); ?></span><i class="iconfont icon-cha"></i></div>
            <p class="fabi-qrcs-whole-p1"><?php echo \think\Lang::get('sksz_skfs'); ?></p>
            <div id="payment_method">
                <div class="fabi-qrcs-whole-tow">
                    <div>
                        <p class="fabi-qrcs-whole-tow-p1"><span><?php echo \think\Lang::get('fbjy_zfb'); ?></span><span>￥6.20</span></p>
                        <p class="fabi-qrcs-whole-tow-p2"><span><?php echo \think\Lang::get('fbjy_djzy'); ?></span></p>

                    </div>
                    <div class="fabi-qrcs-whole-tow-div2">
                        <?php echo \think\Lang::get('fbjy_zwzffs'); ?>
                    </div>
                </div>
                <div class="fabi-qrcs-whole-tow" id="2">
                    <div>
                        <p class="fabi-qrcs-whole-tow-p1"><span><?php echo \think\Lang::get('fbjy_zfb'); ?></span><span>￥6.20</span></p>
                        <p class="fabi-qrcs-whole-tow-p2"><span><?php echo \think\Lang::get('fbjy_djzy'); ?></span></p>
                    </div>
                    <div class="fabi-qrcs-whole-tow-div2">

                       <div></div><span>975****.com</span>

                    </div>
                </div>
                <div class="fabi-qrcs-whole-tow">
                    <div>
                        <p class="fabi-qrcs-whole-tow-p1"><span><?php echo \think\Lang::get('fbjy_wx'); ?></span><span>￥6.20</span></p>
                        <p class="fabi-qrcs-whole-tow-p2"><span><?php echo \think\Lang::get('fbjy_djzy'); ?></span></p>
                    </div>
                    <div class="fabi-qrcs-whole-tow-div2">
                        <?php echo \think\Lang::get('fbjy_zwzffs'); ?>
                    </div>
                </div>
                <div class="fabi-qrcs-whole-tow">
                    <div>
                        <p class="fabi-qrcs-whole-tow-p1"><span><?php echo \think\Lang::get('fbjy_yhk'); ?></span><span>￥6.20</span></p>

                    </div>
                    <div class="fabi-qrcs-whole-tow-div2">
                        <?php echo \think\Lang::get('fbjy_zwzffs'); ?>
                    </div>
                </div>
            </div>
            <div class="fabi-qrcs-whole-tow-div3">
                <p><a href="javascript:void (0)" onclick="gopage_addpayment()">+ <?php echo \think\Lang::get('fbjy_tjskfs'); ?></a></p>
                <button onclick="confirm_sell()"><?php echo \think\Lang::get('fbjy_qrcs'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="fbjy-qrgm">
    <div class="fbjy-qrgm-div0">
        <div class="fbjy-qrgm-whole">
            <p class="fbjy-qrgm-whole-p1"><?php echo \think\Lang::get('fbjy_qrgm'); ?> <i class="iconfont icon-cha"></i></p>
            <p><span class="currency_icon"><?php echo $default_currency_icon; ?></span> <span class="buy_case"> </span></p>
            <p><?php echo \think\Lang::get('fbjy_wjsd'); ?> <span class="will_get_num"></span> <span class="symbol_name">USDT</span></p>
            <p class="fbjy-qrgm-whole-p4"><?php echo \think\Lang::get('fbjy_xzzffs'); ?></p>
            <div class="fbjy-qrgm-whole-noe">


                    <div class="wx">
                        <p>
                            <span><?php echo \think\Lang::get('fbjy_wx'); ?></span>
                            <span>￥ 6.30</span>
                        </p>
                        <p>
                            <span></span>
                            <span><?php echo \think\Lang::get('fbjy_djzy'); ?></span>
                        </p>
                    </div>
                    <div class="yhk">

                        <p>
                            <span><?php echo \think\Lang::get('fbjy_yhk'); ?></span>
                            <span>￥ 6.30</span>
                        </p>

                    </div>
                    <div class="zfb">

                        <p>
                            <span><?php echo \think\Lang::get('fbjy_zfb'); ?></span>
                            <span>￥ 6.30</span>
                        </p>

                    </div>


                <button class="fbjy-qrgm-butt"><?php echo \think\Lang::get('rt_qrtj'); ?></button>
            </div>
        </div>
    </div>
</div>
<script src="/index/js/m-fbjy.js"></script>
<script>
    //点击我要买的购买按钮
    $(".fbjy-qrgm").hide();
    $(".fbjy-gmje2-boutt1").click(function () {

        if(buy_base == 'amount'){
            var inpt =$("#buy_amount").val();
            if (!inpt){layer.msg(fbjy_qsrgmje); return;}else if (inpt<=0){layer.msg(fbjy_qsrgmdjebnxy); return;}
        }else{
            var num = $("#buy_num").val();
            if (!num){layer.msg(fbjy_qsrgmsl); return;}else if (num<=0){layer.msg(fbjy_qsrgmdbnxy); return;}
        }




        get_buy_num();
        //获取支付方式
        $.ajax({
            url: '/index/Currencytrade/get_paymethod',
            type: 'post',
            dataType: 'json',
            data: {
                'currency': default_currency,
            },
            success: function (res) {
                var html = '';
                $.each(res.list,function (index,item) {



                    html += '  <div class="zfb" data-id="'+item.id+'">\n' +
                        '                    <p>\n' +
                        '                        <span>'+item.name+'</span>\n' +
                        '                        <span>'+currency_icon+sc_price+'</span>\n' +
                        '                    </p>\n' +

                        '                    <p>\n' +

                        '                        <span></span>\n' +
                        '                        <span>'+fbjy_ckdj+'</span>\n' +
                        '                    </p>'+
                        '                </div>';
                })
                html += ' <button class="fbjy-qrgm-butt" onclick="confirm_buy()">'+rt_qrtj+'</button>';
                $('.fbjy-qrgm-whole-noe').html(html);
            }
        });

        $(".fbjy-qrgm").show();
    });
    $(".fbjy-qrgm-whole-p1>i").click(function () {
        $(".fbjy-qrgm").hide();
    });

    //我要买，选择支付方式
    var zffs=0;
    // $(".fbjy-qrgm-whole-noe>div").click(function () {
    //     $(".fbjy-qrgm-whole-noe>div").css("border-color","#eee");
    //    $(this).css("border-color","#d1a954");
    //    zffs=$(this).attr("data");
    // });
    $(document).on("click",".fbjy-qrgm-whole-noe>div",function(){
        $(".fbjy-qrgm-whole-noe>div").css("border-color","#eee");
        $(this).css("border-color","#d1a954");
        zffs=$(this).attr("data-id");
    });

    //我要买，选择支付方式，后点击确认购买按钮
    $(".fbjy-qrgm-butt").click(function () {
        if(!zffs){layer.msg(jse_qxzzffs); return;}
        // if(zffs!="wx"||zffs!="yhk"||zffs!="zfb"){ layer.msg("程序出现错误"); }
    });
    //确认购买
    function confirm_buy(){
        if(!zffs){layer.msg(jse_qxzzffs); return;}
        if(buy_base == 'num'){
            var num = $("#buy_num").val();
            var amount = 0;
            if(!num ){layer.msg(fbjy_qsrgmsl); return;}
            if(num<=0){layer.msg(fbjy_qsrgmdbnxy); return;}
        }else{
            var num = 0;
            var amount =$('#buy_amount').val();
            if( !amount){layer.msg(fbjy_qsrgmslje); return;}
            if( amount<=0){layer.msg(fbjy_qsrgmdjebnxy); return;}
        }
        //
        // if(!num && !amount){layer.msg("请输入出售数量或者金额"); return;}
        // if(num<=0 && amount<=0){layer.msg("输入出售的数量或金额不能小于或等于0"); return;}
        $.ajax({
            url: '/index/Currencytrade/addorder',
            type: 'post',
            dataType: 'json',
            data: {
                'payment': zffs,
                'num': num,
                'amount':amount,
                'currency':default_currency,
                'symbol':default_symbol_name,
                'trade_type':0
            },
            success: function (res) {
                if(res.code == 1){
                    layer.msg(res.msg);

                    if(res.match == 1){
                        window.location.href = '/index/user/qfk?id='+res.id;

                    }else{
                        window.location.href = '/index/User/optional';

                    }

                }else{
                    layer.msg(res.msg);
                    if(res.code == -1){
                        setTimeout("gopage_addpayment()",1000);
                    }
                }
            }
        });
    }



    //我要买出售时选择收款方式
    $(".fabi-qrcs").hide();
    $(".icon-cha").click(function () {

         $(".fabi-qrcs").hide();

    });
    // $(".fbjy-gmje2-boutt").eq(1).click(function () {
    //     var tex =$("#can_sell_num").val();
    //     if(!tex){alert("请输入出售数量"); return;}
    //     if(tex<=0){alert("输入出售的数量不能小于或等于0"); return;}
    //     $(".fabi-qrcs").show();
    // });

    var buy_base = 'num';//购买数额依据
    var sell_base = 'num';//出售数额依据
    function sellonbase(base) {
        sell_base = base;
    }
    function buyonbase(base) {
        buy_base = base;
    }

    function gopage_addpayment() {
        window.location.href = "/index/User/skfs?c="+default_currency;
    }
    //获取收款方式
    function addorder(trade_type){

        if(trade_type === 1){
            var num =$("#can_sell_num").val();
            var amount =$('#can_sell_amount').val();
            if(!num && !amount){layer.msg(fbjy_qsrcsslhje); return;}
            if(num<=0 && amount<=0){layer.msg(fbjy_srcsdslhjebnxyl); return;}
        }else{
            var num =$("#buy_num").val();
            var amount =$('#buy_amount').val();
            if(!num && !amount){layer.msg(fbjy_qsrgmslhje); return;}
            if(num<=0 && amount<=0){layer.msg(fbjy_qsrgmdslhjebn); return;}
        }

        $.ajax({
            url:'/index/Currencytrade/get_payment',
            type:'post',
            dataType:'json',
            data:{
                'currency':default_currency,
                'symbol':default_symbol_name,
            },
            success:function (res) {
                console.log(res);
                var html = '';
                if(res.code === 0 ){

                    if(res.list){
                        $.each(res.list ,function (index,item) {
                            html +=  '<div class="fabi-qrcs-whole-tow">\n' +
                                '                    <div>\n' +
                                '                        <p class="fabi-qrcs-whole-tow-p1"><span>'+item.name+'</span><span>'+currency_icon+sc_price+'</span></p>\n' +
                                '                        <p class="fabi-qrcs-whole-tow-p2"><span>'+fbjy_djzy+'</span></p>\n' +
                                '                    </div>\n' +
                                '                    <div class="fabi-qrcs-whole-tow-div2">\n' +
                                '                        '+fbjy_zwzffs+'\n' +
                                '                    </div>\n' +
                                '                </div>\n' ;
                        })

                    }

                    // html += '<div class="fabi-qrcs-whole-tow">\n' +
                    //     '                    <div>\n' +
                    //     '                        <p class="fabi-qrcs-whole-tow-p1"><span>支付宝</span><span>'+currency_icon+sc_price+'</span></p>\n' +
                    //     '                        <p class="fabi-qrcs-whole-tow-p2"><span>单价最优</span></p>\n' +
                    //     '                    </div>\n' +
                    //     '                    <div class="fabi-qrcs-whole-tow-div2">\n' +
                    //     '                        暂无支付方式\n' +
                    //     '                    </div>\n' +
                    //     '                </div>\n' +
                    //     '                <div class="fabi-qrcs-whole-tow">\n' +
                    //     '                    <div>\n' +
                    //     '                        <p class="fabi-qrcs-whole-tow-p1"><span>微信</span><span>'+currency_icon+sc_price+'</span></p>\n' +
                    //     '                        <p class="fabi-qrcs-whole-tow-p2"><span>单价最优</span></p>\n' +
                    //     '                    </div>\n' +
                    //     '                    <div class="fabi-qrcs-whole-tow-div2">\n' +
                    //     '                        暂无支付方式\n' +
                    //     '                    </div>\n' +
                    //     '                </div>\n' +
                    //     '                <div class="fabi-qrcs-whole-tow">\n' +
                    //     '                    <div>\n' +
                    //     '                        <p class="fabi-qrcs-whole-tow-p1"><span>银行卡</span><span>'+currency_icon+sc_price+'</span></p>\n' +
                    //     '    <!--                    <p class="fabi-qrcs-whole-tow-p2"><span>单价最优</span></p>-->\n' +
                    //     '                    </div>\n' +
                    //     '                    <div class="fabi-qrcs-whole-tow-div2">\n' +
                    //     '                        暂无支付方式\n' +
                    //     '                    </div>\n' +
                    //     '                </div>';
                }
                else{

                    $.each(res.data,function (index,item) {

                        html += '   <div class="fabi-qrcs-whole-tow" id="'+item.id+'" onclick="check_payment('+item.id+')">\n' +
                            '                    <div>\n' +
                            '                        <p class="fabi-qrcs-whole-tow-p1"><span>'+item.type_name+'</span><span>'+currency_icon+sc_price+'</span></p>\n' +
                            '                        <p class="fabi-qrcs-whole-tow-p2"><span>'+fbjy_djzy+'</span></p>\n' +
                            '                    </div>\n' +
                            '                    <div class="fabi-qrcs-whole-tow-div2">\n' +
                            '                       <div></div><span>'+item.account_num+'</span>\n' +
                            '                    </div>\n' +
                            '                </div>';
                    })
                }
                $('#payment_method').html(html);
                $(".fabi-qrcs").show();
            }
        })



    }
    //出售
    function confirm_sell() {
        if(payment == 0){
            layer.msg(fbjy_qxzskfs);return;
        }
        if(sell_base == 'num'){
            var num = $("#can_sell_num").val();
            var amount = 0;
            if(!num ){layer.msg(fbjy_qsrcssl); return;}
            if(num<=0){layer.msg(fbjy_srcsdslbnxyh); return;}
        }else{
            var num = 0;
            var amount =$('#can_sell_amount').val();
            if( !amount){layer.msg(fbjy_qsrcsjesl); return;}
            if( amount<=0){layer.msg(fbjy_sqcsdjebnxy); return;}
        }
        //
        // if(!num && !amount){layer.msg("请输入出售数量或者金额"); return;}
        // if(num<=0 && amount<=0){layer.msg("输入出售的数量或金额不能小于或等于0"); return;}
        $.ajax({
            url: '/index/Currencytrade/addorder',
            type: 'post',
            dataType: 'json',
            data: {
                'payment': payment,
                'num': num,
                'amount':amount,
                'currency':default_currency,
                'symbol':default_symbol_name,
                'trade_type':1
            },
            success: function (res) {
                if(res.code == 1){
                    layer.msg(res.msg);

                    if(res.match == 1){
                        window.location.href = '/index/user/payment?id='+res.id;

                    }else{
                        window.location.href = '/index/User/optional';

                    }

                }else{
                    layer.msg(res.msg);
                }
            }
        });
    }


    function check_payment(id){
        payment = id;
        var clas =$("#"+id+">.fabi-qrcs-whole-tow-div2").attr("class");
        if(clas=="fabi-qrcs-whole-tow-div2"){
            var a = $("#"+id+">.fabi-qrcs-whole-tow-div2").html();
            var a2 =a.indexOf('<i class="iconfont icon-dagou"></i>');
            if (a2==-1){
                $("#"+id+">.fabi-qrcs-whole-tow-div2").html(a+'<i class="iconfont icon-dagou"></i>');
            }
        }
        $(".fabi-qrcs-whole-tow-div2").attr("class","fabi-qrcs-whole-tow-div2");
        $("#"+id+">.fabi-qrcs-whole-tow-div2").addClass("m-xzskfs");

    }

    // $(".fabi-qrcs-whole-tow").on('click',function () {
    //     var id =$(this).attr("id");
    //     console.log(id);
    //     var clas =$("#"+id+">.fabi-qrcs-whole-tow-div2").attr("class");
    //     if(clas=="fabi-qrcs-whole-tow-div2"){
    //         var a = $("#"+id+">.fabi-qrcs-whole-tow-div2").html();
    //         $("#"+id+">.fabi-qrcs-whole-tow-div2").html(a+'<i class="iconfont icon-dagou"></i>')
    //     }
    //
    //
    //     $("#"+id+">.fabi-qrcs-whole-tow-div2").addClass("m-xzskfs");
    //
    // })


    var default_currency = "<?php echo $default_currency; ?>";//默认币种
    var default_currency_price = "<?php echo $default_currency_price; ?>";//默认币种对美元汇率
    var default_symbol_name = "<?php echo $default_symbol['Name']; ?>";//默认交易对名称
    var default_symbol_price = "<?php echo $default_symbol['price']; ?>";//默认交易对价格
    var default_symbol_pid = "<?php echo $default_symbol['pid']; ?>";
    var symbol_money = "<?php echo $default_symbol['sl']; ?>";
    var currency_icon = '<?php echo $default_currency_icon; ?>';//法币图标



    var payment = 0;
    var sc_price = 0;
    //计算单价
    function get_sc_price(){
        sc_price = parseFloat(default_symbol_price) * parseFloat(default_currency_price);
        sc_price = sc_price.toFixed(2);
        $('.sc_price').html(sc_price);

        let can_sell_amount =  parseFloat(symbol_money) * parseFloat(default_symbol_price) * parseFloat(default_currency_price);
        can_sell_amount = can_sell_amount.toFixed(2);
        $('#can_sell_amount').attr('placeholder',fbjy_zdksw+can_sell_amount);



        $('.symbol_name').html(default_symbol_name);
    }

    //计算购买的数量与金额
    function  get_buy_num() {
        if(buy_base == 'num'){

            let num = $('#buy_num').val();
            $('.will_get_num').html(num);

            let amount = num * sc_price;
            $('.buy_case').html(amount);

        }else{

            let amount = $('#buy_amount').val();
            $('.buy_case').html(amount);

            let num = amount/sc_price;
            $('.will_get_num').html(num.toFixed(6));
        }
    }

    //搜索法币币种
    function search_curr(){
        var keyword = $('#search_curr').val();

        if(keyword !== ''){
            $.ajax({
                type:"post",
                url:"<?php echo url('Currencytrade/search_curr'); ?>",
                data:{
                    keyword:keyword,

                },
                dataType:'JSON',
                async:false,
                success:function(msg){
                    if(msg.code == 1){
                        var html = '';
                        html += ' <div class="fabi-xzfb-bt ">'+keyword+'</div>\n' ;

                        html +=    '\n' +
                            '            <ul>\n' ;

                        $.each(msg.data,function (index,item) {
                            html +=   ' <li data-name="'+item.name+'" data-rate="'+item.huilv+'" data-icon="'+item.symbol+'"><span>'+item.symbol+'</span><span>'+item.name+'</span></li>\n' ;
                        })

                        html +=    '            </ul>';

                        $('.new_list').show();
                        $('.old_list').hide();
                        $('.new_list').html(html);

                    }else{
                        $('.new_list').hide();
                        $('.old_list').show();
                        layer.msg("没有该币种的相关搜索结果！",{time:2*1000});

                    }
                },
                error:function(){
                    $('.new_list').hide();
                    $('.old_list').show();
                    layer.msg("网络出错..",{time:2*1000});
                }
            });
        }else{
            $('.new_list').hide();
            $('.old_list').show();
        }
    }

    $(function(){
        get_sc_price();
    });

    $(".fabi-xzfb").hide();
    $(".daohang-zhong>span").click(function () {
        $(".fabi-xzfb").show();
    })
    $(".daohang-zhong>i").click(function () {
        $(".fabi-xzfb").show();
    })
    $(".fabi-fh").click(function () {
        $(".fabi-xzfb").hide();
    });
    //选择 法币
    $(".fabi-xzfb-list2>ul>li").click(function () {
        $(".icon-dagou").css("color","#ffffff");
        //console.log('123');
        default_currency_price = $(this).data('rate');
        default_currency = $(this).data('name');
        let icon = $(this).data('icon');
        currency_icon = icon;
        $('.currency_icon').html(icon);
        $('.cur_name').html(default_currency);
        get_sc_price();
        payment = 0;
        $(".fabi-xzfb").css('display','none');
    });

    $(document).on('click','.fabi-xzfb-list2>ul>li',function () {
        $(".icon-dagou").css("color","#ffffff");
        //console.log('123');
        default_currency_price = $(this).data('rate');
        default_currency = $(this).data('name');
        let icon = $(this).data('icon');
        currency_icon = icon;
        $('.currency_icon').html(icon);
        $('.cur_name').html(default_currency);
        get_sc_price();
        payment = 0;
        $(".fabi-xzfb").css('display','none');
    })


    //选择 交易对
    $(".fbjy-xzbz>ul>li").click(function () {
        var a =$(this).attr("id");
        default_symbol_price = $(this).data('price');
        default_symbol_name = $(this).data('name');
        symbol_money = $(this).data('money');
        $('#can_sell_num').attr('placeholder',fbjy_zdksw+symbol_money);
        get_sc_price();
    });

    function get_all() {
        $('#can_sell_num').val(symbol_money);
    }

</script>
</body>
</html>