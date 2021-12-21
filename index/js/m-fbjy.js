$(".fbjy-xzquu").click(function () {
    $(this).hide();
});
//输入框输入事件改变按钮颜色
function butt(bt1,bt2){
    $(bt1).eq(0).bind('input propertychange', function() {
        $(bt2).css("background-color","#f1c025");
        $(bt2).css("color","#000000");
    });
}

// function texts2s(te1) {
//     console.log(te1);return ;
//     if (!te1){layer.msg("输入的值不能为空");return false;}
//     if (te1<=0){layer.msg("输入的值不能小于或等于0"); return false;}
// }


var tpe="";
//计算ul的长度
var lis =$(".fbjy-xzbz>ul>li").children().length;
// lis=lis/2;
lis=lis*115;
$(".fbjy-xzbz>ul").css("width",lis+"px");
$(".fbjy-wym").css("color","rgb(96,186,137)");

//选择币种
$(".fbjy-xzbz>ul>li").click(function () {
    $(".fbjy-xzbz>ul>li").css("color","#999999");
    $(".fbjy-xzbz>ul>li").css("background-color","#e5e5e5");
    $(this).css("background-color","#fffdee");
    $(this).css("color","#d3a140");
});

// 选择买或卖
$(".fbjy-gmje2").eq(1).hide();
$(".fbjy-wym").click(function () {

    $(this).css("color","#5eba89");
    $(".fbjy-wym2").css("color","#999999");
    $(".fbjy-gmje2").eq(0).show();
    $(".fbjy-gmje2").eq(1).hide();
});
$(".fbjy-wym2").click(function () {
    $(this).css("color","#e45360");
    $(".fbjy-wym").css("color","#999999");
    $(".fbjy-gmje2").eq(0).hide();
    $(".fbjy-gmje2").eq(1).show();
})
//卖出选择出售数量还是金额
$(".fbjy-jecs").hide();
$(".fbjy-csje").hide();
$(".fbjy-jecs").click(function () {
    $(".fbjy-jecs").toggle();
    $(".fbjy-slcs").toggle();
    $(".fbjy-csje").toggle();
    $(".fbjy-cssl").toggle();

    $(".fbjy-mcbz").text();
    $(".fbjy-sp1").text(fbjy_cssl);

});
$(".fbjy-slcs").click(function () {
    $(".fbjy-jecs").toggle();
    $(".fbjy-slcs").toggle();
    $(".fbjy-csje").toggle();
    $(".fbjy-cssl").toggle();
    $(".fbjy-sp1").text(fbjy_csje);
});

//买选择按金额还是数量购买
// $(".fbjy-jbgb").hide();
// $(".fbjy-gmsl").hide();
// $(".fbjy-slgm").click(function () {
//     $(".fbjy-slgm").toggle();
//     $(".fbjy-jbgb").toggle();
//     $(".fbjy-gmje5").toggle();
//     $(".fbjy-gmsl").toggle();
//     $(".fbjy-gmje2-p1").text(fbjy_gmsl);
// });
//
// $(".fbjy-jbgb").click(function () {
//     $(".fbjy-slgm").toggle();
//     $(".fbjy-jbgb").toggle();
//     $(".fbjy-gmje5").toggle();
//     $(".fbjy-gmsl").toggle();
//
//     $(".fbjy-gmje2-p1").text(fbjy_gmje);
// });

// 快捷区的颜色的改变
$(".fbjy-xzquu").hide();
$(".fajy-kzq>span").eq(1).hide();
$(".icon-xiangshang1").hide();
$(".fajy-kzq").click(function () {
    $(".icon-xiangshang1").toggle();
    $(".icon-xiangxia1").toggle();
    $(".fajy-kzq>span").eq(1).toggle();
    $(".fajy-kzq>span").eq(0).toggle();
    $(".fbjy-xzquu").toggle();
});


// optional界面
// 购买界面输入框输入数字时购买按钮颜色发生改变
$('.purchase-whole-div-tow>input').eq(0).bind('input propertychange', function() {
    $(".purchase-whole-div-butt").eq(0).css("background-color","#5eba89");
    $(".purchase-whole-div-butt").eq(0).css("color","#ffffff");
    $(".purchase-whole-div-butt").eq(1).css("background-color","#d9dde0");
    $(".purchase-whole-div-butt").eq(1).css("color","#999999");
});
$('.purchase-whole-div-tow>input').eq(1).bind('input propertychange', function() {
    $(".purchase-whole-div-butt").eq(0).css("background-color","#d9dde0");
    $(".purchase-whole-div-butt").eq(0).css("color","#999999");
    $(".purchase-whole-div-butt").eq(1).css("background-color","#5eba89");
    $(".purchase-whole-div-butt").eq(1).css("color","#ffffff");
});
// 出售界面输入框输入数字时购买按钮颜色发生改变
$('.purchase-whole-div-tow>input').eq(2).bind('input propertychange', function() {
    $(".purchase-whole-div-butt").eq(2).css("background-color","#5eba89");
    $(".purchase-whole-div-butt").eq(2).css("color","#ffffff");
    $(".purchase-whole-div-butt").eq(3).css("background-color","#d9dde0");
    $(".purchase-whole-div-butt").eq(3).css("color","#999999");
});
$('.purchase-whole-div-tow>input').eq(3).bind('input propertychange', function() {
    $(".purchase-whole-div-butt").eq(2).css("background-color","#d9dde0");
    $(".purchase-whole-div-butt").eq(2).css("color","#999999");
    $(".purchase-whole-div-butt").eq(3).css("background-color","#5eba89");
    $(".purchase-whole-div-butt").eq(3).css("color","#ffffff");
});

//点击购买打开的页面
$(".purchase").eq(0).hide();
$(".purchase").eq(1).hide();
$(".opti-list-div2-bott1").click(function () {
    $(".purchase").eq(0).show();
});
$(".purchase-hoad>div>a>i").click(function () {
    $(".purchase").eq(0).hide();
});
//点击出售打开的页面
$(".purchase").eq(1).hide();
$(".opti-list-div2-bott2").click(function () {
    $(".purchase").eq(1).show();
});
$(".purchase-hoad>div>a>i").click(function () {
    $(".purchase").eq(1).hide();
});

// 购买页面控制按金币购买还是按数量购买的样式和div的切换
// $(".purchase-whole-div-noe>div").eq(0).css("color","#d1a954");
// $(".purchase-whole-div-noe>div>span").eq(0).css("background-color","#edbb4a");
// $(".purchase-whole").eq(1).hide();
// $(".purchase-whole-div-noe>div").eq(1).click(function () {
//     $(".purchase-whole-div-noe>div").eq(3).css("color","#d1a954");
//     $(".purchase-whole-div-noe>div>span").eq(3).css("background-color","#edbb4a");
//     $(".purchase-whole").eq(0).hide();
//     $(".purchase-whole").eq(1).show();
// });
//
// $(".purchase-whole-div-noe>div").eq(2).click(function () {
//     $(".purchase-whole").eq(1).hide();
//     $(".purchase-whole").eq(0).show();
// });
// 出售页面控制按金币购买还是按数量购买的样式和div的切换
// $(".purchase-whole-div-noe>div").eq(4).css("color","#d1a954");
// $(".purchase-whole-div-noe>div>span").eq(4).css("background-color","#edbb4a");
// $(".purchase-whole").eq(3).hide();
// $(".purchase-whole-div-noe>div").eq(5).click(function () {
//     $(".purchase-whole-div-noe>div").eq(7).css("color","#d1a954");
//     $(".purchase-whole-div-noe>div>span").eq(7).css("background-color","#edbb4a");
//     $(".purchase-whole").eq(2).hide();
//     $(".purchase-whole").eq(3).show();
// });

$(".purchase-whole-div-noe>div").eq(6).click(function () {
    $(".purchase-whole").eq(3).hide();
    $(".purchase-whole").eq(2).show();
});

$(".opti-mm>div>span").eq(0).css("color","#5eba89");
$(".opti-list").eq(1).hide();

$(".opti-mm>div>span").eq(1).click(function () {
    $(".opti-mm>div>span").eq(0).css("color","#999999");
    $(".opti-mm>div>span").eq(1).css("color","#e45360");
    $(".opti-list").eq(0).hide();
    $(".opti-list").eq(1).show();
});
$(".opti-mm>div>span").eq(0).click(function () {
    $(".opti-mm>div>span").eq(1).css("color","#999999");
    $(".opti-mm>div>span").eq(0).css("color","#5eba89");
    $(".opti-list").eq(1).hide();
    $(".opti-list").eq(0).show();
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
$(".fabi-xzfb-list2>ul>li").click(function () {
    $(".icon-dagou").css("color","#ffffff");

});

var sl1 =$(".opti-bz>ul>li").length;
sl1=sl1*80;
$(".opti-bz>ul").css("width",sl1+"px");


var nul = $(".fbjyfh-btms2s").attr("class");
if (!nul){
    $(".opti-bz>ul>li").click(function () {
        $(".opti-bz>ul>li").css("background-color","#ffffff")
        $(this).css("background-color","#f9e9ac")
    });
}else{
    $(".opti-bz>ul>li").click(function () {
        $(".opti-bz>ul>li").css("background-color","#00002f")
        $(this).css("background-color","#666666")
    });
}


//curordes页面点击输入框弹出div
$("#olist_0").click(function () {
    $(".cur-xs1").toggle();
    $(".cur-xx1").toggle();
    $(".curinputdiv1").hide();
})
$("#olist_1").click(function () {
    $(".cur-xs2").toggle();
    $(".cur-xx2").toggle();
    $(".curinputdiv2").hide();
})
$("#olist_1").click(function () {
    $(".cur-xs3").toggle();
    $(".cur-xx3").toggle();
    $(".curinputdiv3").hide();
})
$(".curinputdiv1>ul>li").click(function () {
    $(".cur-xs1").toggle();
    $(".cur-xx1").toggle();
    $(".curinputdiv1").hide();
});
$(".curinputdiv2>ul>li").click(function () {
    $(".cur-xs2").toggle();
    $(".cur-xx2").toggle();
    $(".curinputdiv2").hide();
});
$(".curinputdiv3>ul>li").click(function () {
    $(".cur-xs3").toggle();
    $(".cur-xx3").toggle();
    $(".curinputdiv3").hide();
});
$(".cur-xs1").hide();
$(".curinputdiv1").hide();
$(".Search-input1").click(function () {
    $(".cur-xs1").show();
    $(".cur-xx1").hide();
    $(".curinputdiv1").show();
});
$(".cur-xs2").hide();
$(".curinputdiv2").hide();
$(".Search-input2").click(function () {
    $(".cur-xs2").show();
    $(".cur-xx2").hide();
    $(".curinputdiv2").show();
});
$(".cur-xs3").hide();
$(".curinputdiv3").hide();
$(".Search-input3").click(function () {
    $(".cur-xs3").show();
    $(".cur-xx3").hide();
    $(".curinputdiv3").show();
});

$(".Search1").show();
$(".Search2").hide();
$(".Search3").hide();
$(".head_div_0").click(function () {
    $(".cur-xs1").hide();
    $(".cur-xx1").show();
    $(".Search1").show();
    $(".Search2").hide();
    $(".Search3").hide();
});

$(".head_div_1").click(function () {
    $(".cur-xs2").hide();
    $(".cur-xx2").show();
    $(".Search1").hide();
    $(".Search2").show();
    $(".Search3").hide();
});
$(".head_div_2").click(function () {
    $(".cur-xs3").hide();
    $(".cur-xx3").show();
    $(".Search1").hide();
    $(".Search2").hide();
    $(".Search3").show();
});


