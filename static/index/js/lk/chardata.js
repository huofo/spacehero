



var selltime = 0;
option = null;
var order_data = {};
var timer = '';
var resorderlist = {};
var timer_orderlist= '';
var _sell_time = 0;
var _ftime = 0;



function getdata(pid) {
    var url = "/index/goods/ajaxpro/pid/"+pid;
    $.get(url,function(data){


        var old_price = $('.data-price').html();
        if(old_price*10 < data.Price*10){
            $('.data-price').removeClass('fall');
            $('.data-price').addClass('rise');
        }else if(old_price*10 > data.Price*10){
            $('.data-price').addClass('fall');
            $('.data-price').removeClass('rise');
        }
        $('.data-price').html(data.Price);
        $('.col-nowprice').html(data.Price);
        $('.newprice').html(data.Price);
        newprice = data.Price;
    });
}


function judge(obj){
    var judge = $('.close-position-view .active').attr('data-sen');
    console.log(judge);
    // if(judge == 1){
        addorder();
    // }else{
    //     addorders();
    // }
}




$('.close-position').click(function(){
    var close_sen = $(this).attr('data-sen');
    var money = $('.amount-box.active').attr('data-price');
    if(close_sen == "2"){
        var number = $('.onumber input[type="number"]').val();
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
        $('#money').html(' $'+numprice*number);
        // setInterval("RangePointSpread()",1000);
    }else{
        $('.second').css({'display':'block'});
        $('.investment-amount').css({'display':'block'});
        $('.scroll-xxs').css({'width':'75%'});
        $('.expect_profit').css({'display':'block'});
        $('.stop-win').css({'display':'none'});
        $('.stop-loss').css({'display':'none'});
		 $('.jixings').css({'display':'block'});

		 $('.jinjies').css({'display':'none'});
        $('.onumber').css({'display':'none'});
        $('.ng-other').css({'display':'block'});
        $('#money').html(' $'+money);
    }
    $('.btn_confirm .button').attr({'ak':close_sen});
    $('.close-position').removeClass('active');
    $(this).addClass('active');
});



//选择时间
$('.period-widget').click(function(){

    $('.period-widget').removeClass('active');
    $(this).addClass('active');
    order_sen = $(this).attr('data-sen');
    order_shouyi = $(this).attr('data-shouyi');
    var yuqi = (( (order_shouyi*0.01*order_price)*10+order_price*10) /10).toFixed(2);
    $('#yuqi').html(yuqi)
});
//选择金额
$('.amount-box').click(function(){

    $('.amount-box').removeClass('active');
    // $('.other-amount').removeClass('active');
    $(this).addClass('active');
    order_price = $(this).attr('data-price');
    $('#money').html(' $'+order_price);
    if(my_money < order_price){
        $('.no-money').removeClass('ng-hide');
    }else{
        $('.no-money').addClass('ng-hide');
    }
    $('.no-min').addClass('ng-hide');
    $('.no-max').addClass('ng-hide');
    var yuqi = (( (order_shouyi*0.01*order_price)*10+order_price*10) /10).toFixed(2);
    $('#yuqi').html(yuqi)
});

$('.ng-win').click(function(){
    $('.never-win').removeClass('active');
    $(this).addClass('active');
});

$('.ng-loss').click(function(){
    $('.never-loss').removeClass('active');
    $(this).addClass('active');
});

$('.never-loss').click(function(){
    $('.never-loss').removeClass('active');
    $('.ng-loss').removeClass('active');
    $(this).addClass('active');
})

$('.never-win').click(function(){
    $('.never-win').removeClass('active');
    $('.ng-win').removeClass('active');
    $(this).addClass('active');
})

$('.other-amount input').bind('input propertychange', function() {
    var inputdata = $('.other-amount input').val();
    if(inputdata*10 < order_min_price*10){
        $('.no-min').removeClass('ng-hide');
        $('.no-money').addClass('ng-hide');
        // $('.button').attr('disabled','disabled');
    }else if(inputdata*10 > order_max_price*10){
        $('.no-max').removeClass('ng-hide');
        $('.no-money').addClass('ng-hide');
        // $('.button').attr('disabled','disabled');
    }else{

        $('.no-min').addClass('ng-hide');
        $('.no-max').addClass('ng-hide');
        // $('.button').removeAttr('disabled');
    }
    order_price = inputdata;
    if($(this).parent().hasClass('ng-win') || $(this).parent().hasClass('ng-loss')){
        var num = $('.move-share input[type="number"]').val();
        $('#money').html(' $'+num*numprice);
    }else{
        $('#money').html(' $'+order_price);
    }
});

$('.move-share input[type="number"]').bind('input propertychange', function() {
    var num = $(this).val();
    $('#money').html(' $'+num*numprice);
});

function toggle_order_confirm_panel(type) {

  if(type == 'lookup'){
    var typename = iin_mz;
    order_type = 0;

    $('.order_type').removeClass('fall');
    $('.order_type').addClass('rise');
  }else{
    var typename = gs_md;
    order_type = 1;

    $('.order_type').addClass('fall');
    $('.order_type').removeClass('rise');
  }

   RangePointSpread();
  $('.order_type').html(typename);
  $('.pro_mengban').addClass('glass_mask');
  $('.order-confirm-panel').addClass('open');

}

function RangePointSpread(){
    var posturl = "/index/order/getspread/";
    var postdata = "order_type="+order_type+"&order_pid="+order_pid;
    $.post(posturl,postdata,function(resdata){
        $('#getspread').text(resdata);
    });
}


function changeshare(obj){
    var num = obj.val();
    // var order_price = $('.amount-view .active').attr('data-price');
    if(!(/^(\+|-)?\d+$/.test( num )) || num <= 0){
        obj.val('1');
        obj.attr({'value':1});
        $('#money').html(' $'+numprice);
    }else{
        obj.attr({'value':num});
        obj.val(num);
        $('#money').html(' $'+numprice*num);
        var yuqi = (( (order_shouyi*0.01*numprice*num)*10+numprice*10*num) /10).toFixed(2);
        $('#yuqi').html(yuqi);
        if(my_money < numprice){
            $('.no-money').removeClass('ng-hide');
        }else{
            $('.no-money').addClass('ng-hide');
        }
    }
}


function redshare(obj){
    var num = obj.parent().find('input').val();
    // var order_price = $('.amount-view .active').attr('data-price');
    if(num>1){
        num--;
        obj.parent().find('input').attr({'value':num});
        obj.parent().find('input').val(num);
        $('#money').html(' $'+numprice*num);
        var yuqi = ((order_shouyi*0.01*numprice*10*num+numprice*10*num) /10).toFixed(2);
        $('#yuqi').html(yuqi);
        if(my_money < numprice){
            $('.no-money').removeClass('ng-hide');
        }else{
            $('.no-money').addClass('ng-hide');
        }
    }else{
        obj.parent().find('input').attr({'value':1});
        obj.parent().find('input').val(1);
    }
}

function addshare(obj){
    var num = obj.parent().find('input').val();
    // var order_price = $('.amount-view .active').attr('data-price');
    if(num>=1){
        num++;
        obj.parent().find('input').attr({'value':num});
        obj.parent().find('input').val(num);
        $('#money').html(' $'+numprice*num);
        var yuqi = ((order_shouyi*0.01*10*num+numprice*10*num) /10).toFixed(2);
        $('#yuqi').html(yuqi);
        if(my_money < numprice){
            $('.no-money').removeClass('ng-hide');
        }else{
            $('.no-money').addClass('ng-hide');
        }
    }else{
        obj.parent().find('input').attr({'value':1});
        obj.parent().find('input').val(1);
    }
}

/**
 * 下单
 * @author lukui  2017-06-30
 * @return {[type]} [description]
 */
function addorder(){



    var postdata = "order_type="+order_type+"&order_pid="+order_pid+"&order_price="+order_price+"&order_sen="+order_sen+"&order_shouyi="+order_shouyi+"&newprice="+newprice;
    var posturl = "/index/order/addorder";

    toggle_order_close_panel()

    $('.order_mengban').addClass('glass_mask');
    $('.paysuccess').hide();

    $('.order-state-panel').show();
    $('.order-state-panel .wait').removeClass('ng-hide');




    if(order_price > my_money){
        //console.log(gs_md);
        err_info(od_ndyebzqcz);
        return;
    }

    if(order_price < order_min_price){
        err_info(jin_zxxzjew+order_min_price);
        return;
    }
    if(order_price > order_max_price){
        err_info(le_zdxzjew+order_max_price);
        return;
    }



    $.post(posturl,postdata,function(resdata){

        if(resdata.type == 1){

            resdata.data = jQuery.parseJSON(Base64.decode(resdata.data));

            //倒计时
            $('.pay_order_sen').html(resdata.data.endprofit);
            $('.img_circle_right').attr('style','-webkit-animation: run '+resdata.data.endprofit+'s linear;')
            $('.img_circle_lift').attr('style','-webkit-animation: runaway '+resdata.data.endprofit+'s linear;')

            //下方提示
            if(resdata.data.ostyle == 0){
                $('.pay_order_type').html(iin_mz);
                $('.pay_order_type').addClass('rise');
                $('.pay_order_type').removeClass('fall');
            }else{
                $('.pay_order_type').html(gs_md);
                $('.pay_order_type').addClass('fall');
                $('.pay_order_type').removeClass('rise');
            }

            //$('.order-state-panel').hide();
            $('.order-state-panel .wait').addClass('ng-hide');

            $('.pay_order_price').html(resdata.data.fee);
            $('.pay_order_buypricee').html(resdata.data.buyprice);

            $('.order-state-panel .wait').addClass('ng-hide');
            $('.order-state-panel .paysuccess').removeClass('ng-hide');
            $('.order-state-panel .paysuccess').addClass('success');
            //余额
            $('.pay_mymoney').html(resdata.data.commission);
            //转盘倒计时


            selltime = resdata.data.selltime;
            order_data = resdata.data;
            $('.paysuccess').show();
            _sell_time = order_data.selltime - order_data.buytime;
            timer = setInterval("endtimes()",1000);
        }else{
            err_info(resdata.data);
        }
    });
}

function addorders(){
    var move_share = $('.move-share input[type="number"]').val();
    var never_win = $('.never-win.active').attr('data-sen');
    var never_loss = $('.never-loss.active').attr('data-sen');
    var ng_win = $('.ng-win.active input[type="number"]').val();
    var ng_loss = $('.ng-loss.active input[type="number"]').val();
    var postdata = "order_type="+order_type+"&order_pid="+order_pid+"&newprice="+newprice+"&move_share="+move_share+"&never_win="+never_win+"&never_loss="+never_loss+"&ng_win="+ng_win+"&ng_loss="+ng_loss;
    var posturl = "/index/order/addorders";
    toggle_order_close_panel();

    $('.order_mengban').addClass('glass_mask');
    $('.paysuccess').hide();

    $('.order-state-panel').show();
    $('.order-state-panel .wait').removeClass('ng-hide');

    if(order_price*move_share > my_money){
        err_info(jin_zjbzqxcz);
        return;
    }

    if(ng_win<0 || ng_win>999){
        err_info(cd_srzyzydjjzj);
        return;
    }
    if(ng_loss<0 || ng_loss>100){
        err_info(cd_srzszydybzj);
        return;
    }
    $.post(posturl,postdata,function(resdata){
        $('.wait .col.ng-binding').text(resdata.data);
        $('.row.button_row').append('<button class="button right" onClick="return_orderlist()">cd_ckdd</button>');
        $('.row.button_row .button.left').css({'width':'70%'});
        $('.row.button_row .button.right').css({'width':'44%'});
        $('.row.button_row .button.right').css({'right':'0'});
        $('.row.button_row .button.right').css({'margin-left':'10%'});
    });
}

function addordersheyue(type){

    var move_share = $('.move-share input[type="number"]').val();

    var never_win = $('.never-wins.actives').attr('data-sen');

    var never_loss = $('.never-losss.actives').attr('data-sen');

    var ng_win = $('#ng-wins').val();

    var ng_loss = $('#ng_losss').val();

    /*var never_win = 100;

    var never_loss = 100;

    var ng_win = 100;

    var ng_loss = 100;*/

    var code = $('.code.actives').attr('data-sen');


    var postdata = "order_type="+type+"&order_pid="+order_pid+"&newprice="+newprice+"&move_share="+move_share+"&never_win="+never_win+"&never_loss="+never_loss+"&ng_win="+ng_win+"&ng_loss="+ng_loss+"&code="+code;


    var posturl = "/index/order/addorders";
    if(move_share<0||move_share=='' ){

        layer.msg(cd_qsrxdss);
        return;
    }


    if(ng_win<0 || ng_win>999){

        layer.msg(cd_srzyzydjjzj);
        return;
    }
    if(ng_loss<0 || ng_loss>100){

        layer.msg(cd_srzszydybzj);
        return;
    }
    $.post(posturl,postdata,function(resdata){

        
        
        
        layer.msg(resdata.data, resdata.data == od_xdcg && {
			time: 1500,
			end: function(){
				window.location.reload();
			}
		});
		
        
        /*
        layer.msg(resdata.data);
        if(resdata.data=='下单成功'){
            window.location.reload();
        }*/
        

    });
}




function addorderlever(type){

    var move_share = $('#num').val();//数量
    var price_type = $('#place_type').html()//市价、限价
    var jiage = $('#bibi-text').val();//价格
    var code = $('#ganggan').html();//杠杆

    if(move_share<0||move_share=='' ){

        layer.msg(qsrjysl);
        return;
    }

    if(price_type == bi_xj){
        if(jiage<0||jiage=='' ){

            layer.msg(bi_qsrjyjg);
            return;
        }
    }


    var postdata = "order_type="+type+"&order_pid="+order_pid+"&newprice="+jiage+"&move_share="+move_share+"&code="+code+"&price_type="+price_type;
    var posturl = "/index/order/addorderslever";
    $.post(posturl,postdata,function(resdata){

        layer.msg(resdata.data, resdata.data == od_xdcg && {
            time: 1500,
            end: function(){

                window.location.reload();
            }
        });

    });
}

function addordersbibi(type){

   
     var price_type = $('#place_type').html()//市价、限价
     
     var move_share = $('#num').val();//数量
     
     var jiage = $('#bibi-text').val();//价格
     
     if(move_share<0||move_share=='' ){
        // var qsrjysl = cd_qsrjysl;
        layer.msg(qsrjysl);
        return;
    }
    
    if(price_type == '限价'){
        if(jiage<0||jiage=='' ){

            layer.msg(bi_qsrjyjg);
            return;
        }
    }

     



    var postdata = "order_type="+type+"&order_pid="+order_pid+"&newprice="+jiage+"&move_share="+move_share+"&price_type="+price_type;

    var posturl = "/index/order/addordersbibi";
 
   
    $.post(posturl,postdata,function(resdata){

        layer.msg(resdata.data, resdata.data == od_xdcg && {
            time: 1500,
            end: function(){
                window.location.reload();
            }
        });

    });
}


function return_orderlist(){
    window.location.href='/index/order/hold/token/';
}

//转盘倒计时
function endtimes() {
    var timestamp = Date.parse(new Date());
    timestamp = timestamp / 1000;
    _sell_time--;
    var newsen = _sell_time;
    $('.pay_order_sen').html(newsen);

    var old_price = $('.data-price').html();

    var yuce_case = 0;
    if(order_data.buyprice*10 < newprice*10){
        $('.data-price').removeClass('fall');
        $('.data-price').addClass('rise');




        if(order_data.ostyle == 0){     //买涨
            yuce_case = '+'+(order_data.fee*1 + (order_data.fee*order_data.endloss/100));
            $('.yuce').removeClass('fall');
            $('.yuce').addClass('rise');
        }else{
            yuce_case = order_data.fee*-1;
            $('.yuce').removeClass('rise');
            $('.yuce').addClass('fall');
        }

    }else if(order_data.buyprice*10 > newprice*10){
        $('.data-price').addClass('fall');
        $('.data-price').removeClass('rise');



        if(order_data.ostyle == 0){     //买涨
            yuce_case = order_data.fee*-1;
            $('.yuce').removeClass('rise');
            $('.yuce').addClass('fall');
        }else{
            yuce_case = '+'+(order_data.fee*1 + (order_data.fee*order_data.endloss/100));
            $('.yuce').removeClass('fall');
            $('.yuce').addClass('rise');
        }
    }else{
        yuce_case = order_data.fee;
    }
    $('.yuce').html('$'+yuce_case);

    if(newsen <= 0){
        $('.paysuccess').addClass('ng-hide');
        $('.paysuccess').removeClass('success');
        $('.order-state-panel .wait').removeClass('ng-hide');
        //请求检测订单
        //get_this_order();
        clearInterval(timer)
        //停止ajax
        clearTimeout(ccout);
        //go order
        goorder();
     }


}

function goorder() {

    var posturl = '/index/order/goorder';
    var postdata = 'price='+newprice+"&oid="+order_data.oid+"&order_rand="+order_data.order_rand;
    $.post(posturl,postdata,function(res){
        if(res == 1 || res == 3){
            get_this_order();
        }else if(res == 2||res == 0){
            setTimeout('goorder()',100);
        }
    });
}


function get_this_order() {
    var tourl = "/index/order/get_this_order/oid/"+order_data.oid;
    $.get(tourl,function(resdata){
        if(resdata){
            resdata = jQuery.parseJSON(Base64.decode(resdata));
            $('.order-state-panel .wait').addClass('ng-hide');
            $('.ordersuccess').removeClass('ng-hide');
            $('.ordersuccess').addClass('success');


            if(resdata.is_win == 1){
                $('.result_profit').addClass('rise')
                $('.result_profit').removeClass('fall')
                var _ploss = (resdata.ploss*10+resdata.fee*10)/10;
                $('.result_profit').html('$'+_ploss);

                $('.endprice').addClass('rise')
                $('.endprice').removeClass('fall')
            }else if(resdata.is_win == 2){
                $('.result_profit').addClass('fall')
                $('.result_profit').removeClass('rise')
                $('.result_profit').html('$'+resdata.ploss);
                $('.endprice').addClass('fall')
                $('.endprice').removeClass('rise')
            }else{
                $('.result_profit').removeClass('rise')
                $('.result_profit').removeClass('fall')
                $('.result_profit').html('$'+resdata.ploss);
                $('.endprice').removeClass('rise')
                $('.endprice').removeClass('fall')

            }
            $('.endprice').html('$'+resdata.sellprice);
            ccout=setTimeout("getonedata()",1000);

        }else{
            // $('.ordersuccess').addClass('ng-hide');
            // $('.ordersuccess').removeClass('success');
            // err_info('获取失败，请在订单列表查看');
            get_this_order();
        }
    });
}
/**
 * 继续下单
 * @author lukui  2017-06-30
 * @return {[type]} [description]
 */
function continue_order() {

    close_order();
    if(order_type == 0){
        var _type = 'lookup';
    }else{
        var _type = 'lookdown';
    }
    $('.row.button_row').find('.button.right').remove();
    toggle_order_confirm_panel(_type);
}

/**
 * 关闭窗口
 * @author lukui  2017-06-30
 * @return {[type]} [description]
 */
function close_order() {
    clearInterval(timer)
    $('.order_mengban').removeClass('glass_mask');
    $('.order-state-panel').hide();
    $('.ordersuccess').removeClass('success');
    $('.ordersuccess').addClass('ng-hide');
    $('.order_fail').addClass('ng-hide');


}

/**
 * 持仓明细
 */
function toggle_history_order_panel() {
      window.location.href="/index/order/hold/token/";
}
/**
 * 订单列表
 * @return {[type]} [description]
 */
function show_order_list() {
    var  html = '';

    if(resorderlist.length == 0){
        $('.trade_history_list ul').html(' ');
        return false;
    }

_ftime++;
    $.each(resorderlist,function(k,v){
        var timestamp = Date.parse(new Date());
        var  _end_time = (v.selltime - _ftime);
        var baifenbi = (_end_time/v.endprofit)*100;
        if(_end_time >0 && v.is_timing == 0){
            var chaprice = newprice-v.buyprice;
            var closeprice = 0;
            var closeprice_class = '';
            if(v.ostyle == 0){
                var ostyle_class = "buytop";
                var ostyle_class2 = 'in_money';
                var ostyle_name = iin_mz;
                if(chaprice >0){
                    closeprice = v.fee*(100*10+v.endloss*10)/1000;
                    closeprice_class = 'in_money';
                }else if(chaprice <0){
                    closeprice = v.fee*(-1);
                    closeprice_class = 'out_money';
                }else{
                    closeprice = v.fee;
                    closeprice_class = '';
                }
            }else{
                var ostyle_class = "buydown";
                var ostyle_name = gs_md;
                var ostyle_class2 = 'out_money';

                if(chaprice <0){
                    closeprice = v.fee*(100*10+v.endloss*10)/1000;
                    closeprice_class = 'in_money';
                }else if(chaprice >0){
                    closeprice = v.fee*(-1);
                    closeprice_class = 'out_money';
                }else{
                    closeprice = v.fee;
                    closeprice_class = '';
                }

            }

            html += '<li ng-repeat="o in trade_order_list" class="">\
                        <section>\
                            <p style="margin: 0">\
                                <span class="ng-binding">'+v.ptitle+'</span>\
                                <span class="ng-binding '+ostyle_class2+'"><i class="'+ostyle_class+'"></i>'+ostyle_name+'（$'+v.fee+'）</span>\
                            </p>\
                            <p style="margin: 0" class="ng-binding">\
                                '+v.buyprice+'-<span  class="ng-binding '+closeprice_class+'">'+newprice+'</span>\
                            </p>\
                            <p style="margin: 0" class="ng-binding">'+getLocalTime(v.buytime)+'</p>\
                        </section><section>\
                            <p style="margin: 0px;" class="ng-binding '+closeprice_class+'">'+closeprice+'</p>\
                            <p style="margin: 0" class="ng-binding">'+formatSeconds2(_end_time)+'</p>\
                        </section>\
                        <article class="">\
                        <span class="move_width" style="width: '+baifenbi+'%; transition-duration: 1s;">\
                        </span>\
                        <i>\
                            <em></em>\
                        </i>\
                        </article>\
                    </li>';

            $('.trade_history_list ul').html(html);

        }
        if(v.is_timing == 1){
            var chaprice = newprice-v.buyprice;
            var closeprice = 0;
            var closeprice_class = '';
            var is_close = le_pc;
            if(v.ostyle == 0){
                var ostyle_class = "buytop";
                var ostyle_class2 = 'in_money';
                var ostyle_name = iin_mz;
                if(chaprice >0){
                    closeprice = v.fee*(100*10+v.endloss*10)/1000;
                    closeprice_class = 'in_money';
                }else if(chaprice <0){
                    closeprice = v.fee*(-1);
                    closeprice_class = 'out_money';
                }else{
                    closeprice = v.fee;
                    closeprice_class = '';
                }
            }else{
                var ostyle_class = "buydown";
                var ostyle_name = gs_md;
                var ostyle_class2 = 'out_money';

                if(chaprice <0){
                    closeprice = v.fee*(100*10+v.endloss*10)/1000;
                    closeprice_class = 'in_money';
                }else if(chaprice >0){
                    closeprice = v.fee*(-1);
                    closeprice_class = 'out_money';
                }else{
                    closeprice = v.fee;
                    closeprice_class = '';
                }

            }
            html += '<li ng-repeat="o in trade_order_list" class="">\
                        <section>\
                            <p style="margin: 0">\
                                <span class="ng-binding">'+v.ptitle+'</span>\
                                <span class="ng-binding '+ostyle_class2+'"><i class="'+ostyle_class+'"></i>'+ostyle_name+'（$'+v.fee*v.onumber+'）</span>\
                            </p>\
                            <p style="margin: 0" class="ng-binding">\
                                '+v.buyprice+'-<span  class="ng-binding '+closeprice_class+'">'+newprice+'</span>\
                            </p>\
                            <p style="margin: 0" class="ng-binding">'+getLocalTime(v.buytime)+'</p>\
                        </section><section>\
                            <div class="is_close"><button onclick="CloseAPosition('+v.oid+',$(this))">'+is_close+'</button></div>\
                        </section>\
                        <article class="">\
                        <span class="move_width" style="width: '+baifenbi+'%; transition-duration: 1s;">\
                        </span>\
                        <i>\
                            <em></em>\
                        </i>\
                        </article>\
                    </li>';

            $('.trade_history_list ul').html(html);
        }
    })

}

/**
 * 订单错误提示
 * @param  {[type]} data 错误信息
 * @return {[type]}      [description]
 */

function CloseAPosition(id,obj){
    if(confirm('确定要平仓么')){
        $.ajax({
            type:'POST',
            url:'/index/api/free_order',
            data:{id:id},
            success: function(msg){
                var msg = eval("(" + msg + ")");
                if(msg.error){
                    alert(msg.error);
                }
                if(msg.success){
                    obj.parents('li').remove();
                }
            }
        })
    }
}

function err_info(data) {
    $('.order-state-panel .paysuccess').addClass('ng-hide');
    $('.order-state-panel .paysuccess').removeClass('success');
    $('.order-state-panel .ordersuccess').addClass('ng-hide');
    $('.order-state-panel .ordersuccess').removeClass('success');

    $('.order-state-panel .wait').addClass('ng-hide');
    $('.fail-info').html(data);
    $('.order_fail').removeClass('ng-hide');
}
