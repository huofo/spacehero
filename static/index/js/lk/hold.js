/**
 * 持仓&历史明细
 */
var resorderlist = {};
var proprice = {};
var page = 1;
var ispage = 1;
var is_ajax_list = 0;
var timer_get_price = '';
var timer_orderlist = '';
var listionhajax = '';

//hold_order_list();
//change_category(0);
var _sell_time = 0;
var _ftime = 0;
var html_type = 1;


/**
 * 订单列表
 * @author lukui  2017-07-01
 * @return {[type]} [description]
 */
function hold_order_list() {


    var url = "/index/order/ajaxorder_list";
    $.get(url,function(resdata){
        if(resdata){
             resdata = jQuery.parseJSON(Base64.decode(resdata));
        }
        resorderlist = resdata;
       if(resorderlist){
            if(resorderlist.length >= 1){
                _ftime = resorderlist[0]['time'];
            }else{
                var timestamp = Date.parse(new Date());
                _ftime = timestamp/1000;
            }
            show_order_list();
            // get_free_price = setInterval("get_free_price()",1000);
            timer_get_price = setInterval("get_price()",1000);
            timer_orderlist = setInterval("show_order_list()",1000);
       }


    })
}


function get_price() {
    var url = "/index/order/get_price";
    $.get(url,function(resdata){
        if(!resdata){
            proprice = '';
        }else{
            proprice = jQuery.parseJSON(Base64.decode(resdata));
        }
    })
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
        var closeprice = 0;
        var closeprice_class = '';
        var newprice = proprice[v.pid];
        if(v.ostyle == 0){
            var ostyle_class = "buytop";
            var ostyle_class2 = 'in_money';
            var ostyle_name =iin_mz;
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
            var ostyle_name = iin_md;
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
        if(v.is_timing == 1){
            var onumber = hl_gg;
            var total = hl_ccl;
            var floatprice = parseFloat(newprice);
            var abs = Math.abs(v.point);
            var enter = v.buyprice.toFixed(abs);//入
            var flat = floatprice.toFixed(abs);//平
            //var point = (flat*Math.pow(10,abs))-(enter*Math.pow(10,abs));
            var point =flat-enter;
            var win_loss = point*v.code*v.chicang;
            var total_money = Math.abs(win_loss);
            var total_money = total_money.toFixed(2);
            if(v.ostyle == 0){
                var newprice_class = 'in_money';
                var ostyle_class = "buytop";
                if(win_loss>0){
                    var is_close_class = 'in_money';
                    var color = 'red';
                    var symbol = '';
                }else{
                    var is_close_class = 'out_money';
                    var color = 'green';
                    var symbol = '-';
                }
            }else{
                var ostyle_class = "buydown";
                var newprice_class = 'out_money';
                if(win_loss>0){
                    var is_close_class = 'out_money';
                    var color = 'green';
                    var symbol = '-';
                }else{
                    var is_close_class = 'in_money';
                    var color = 'red';
                    var symbol = '';
                }
            }
            if(v.isopen == 0){
                var no = 'disabled="disabled"';
                var is_close = iin_xs;
                var color = 'gray';
            }else{
                var is_close = le_pc;
            }
            html += '<li ng-repeat="o in trade_order_list" class="hidden-attribute">\
                        <section class="hold_data">\
                            <div class="hold-left-data">\
                                <span class="ng-binding title_font">'+v.ptitle+'</span>\
                                <p style="margin: 0" class="ng-binding">\
                                '+v.buyprice+'-<span class="ng-binding  new_font '+newprice_class+'">'+newprice+'</span>\
                                </p>\
                                <p style="margin: 0; color:#696969;" class="ng-binding">'+getLocalTime(v.buytime)+'</p>\
                            </div>\
                            <div class="hold-right-data">\
                                <span class="ng-binding '+ostyle_class2+'"><i class="'+ostyle_class+'"></i>'+ostyle_name+'（'+v.fee+'U）</span>\
                                <span class="ng-binding '+ostyle_class2+'">'+onumber+'（'+v.code+'）</span>\
                                <span class="ng-binding '+ostyle_class2+'">'+total+'（'+v.chicang+v.procode+'）</span>\
                            </div>\
                            <div class="is_close">\
                            <button '+no+' style="background:'+color+';" onclick="CloseAPosition('+v.oid+',$(this))">'+is_close+'</button>\
                            <span style="color:'+color+';" class="'+is_close_class+'">'+symbol+total_money+'</span>\
                            </div>\
                        </section>\
                    </li>';
        }else{
            if(v.ostyle == 0){
                newprice_class = 'in_money';
            }else{
                newprice_class = 'out_money';
            }
            var timestamp = Date.parse(new Date());
            if(typeof(v.selltime)=="undefined"){v.selltime = 0}
            var  _end_time = (v.selltime*1 - _ftime*1);
            var baifenbi = (_end_time/v.endprofit)*100;
            if(!_end_time){
                _end_time = 0;
            }
            var chaprice = newprice-v.buyprice;
            html += '<li ng-repeat="o" class="hidden-attribute">\
                        <section>\
                            <p style="margin: 0">\
                                <span class="ng-binding">'+v.ptitle+'</span>\
                                <span class="ng-binding '+ostyle_class2+'"><i class="'+ostyle_class+'"></i>'+ostyle_name+'（'+v.fee+'U）</span>\
                            </p>\
                            <p style="margin: 0" class="ng-binding">\
                                '+v.buyprice+'-<span  class="ng-binding '+newprice_class+'">'+newprice+'</span>\
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
        }
        $('.trade_history_list ul').html(html);
    })

}


function CloseAPosition(id,obj){

    layer.confirm(le_qdypcm, {
      btn: [bi_qd,or_qx] //按钮
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
                     layer.msg(le_pccg, {icon: 1});

                     setTimeout(function () {

                         window.location.reload();

                    }, 1000);

                }
            }
        })


    }, function(){

    });


    /*if(confirm('确定要平仓么')){
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
                    window.location.reload();
                }
            }
        })
    }*/
}

/**
 * 切换按钮
 * @param  {[type]} type [description]
 * @return {[type]}      [description]
 */
function change_category(type){

  $('.slider-right').css('transition-duration','300ms');
  $('.slider-left').css('transition-duration','300ms');
  if(type == 0){
    page = 1;
    get_price();
    hold_order_list()
    $('.uls').html(' ');
    $('.slider-left').css('transform','translate(0px, 0px) translateZ(0px)');
    $('.slider-right').css('transform','translate(100%, 0px) translateZ(0px)');
    $('.hidden-attribute').css({'display':'block'});
    $('.left-table').addClass('active');
    $('.right-table').removeClass('active');
  }

  if(type == 1){

    clearInterval(timer_get_price);
    clearInterval(timer_orderlist);
    listionhajax = setInterval("listionh()",1000);
    is_ajax_list = 0;
    orderedlist();
    $('.slider-left').css('transform','translate(-100%, 0px) translateZ(0px)');
    $('.slider-right').css('transform','translate(0px, 0px) translateZ(0px)');
    $('.hidden-attribute').css({'display':'none'});
    $('.right-table').addClass('active');
    $('.left-table').removeClass('active');
  }

}



function orderedlist() {
    if(ispage != 1){
        return;
    }

    setolist(html_type);
    html_type = 1;
}



function setolist(types) {
    var url = "/index/order/orderlist?page="+page;
    var html = '';
    if(is_ajax_list == 1){
        return ;
    }
    is_ajax_list = 1;
    $.get(url,function(resdata){
        resdata = jQuery.parseJSON(Base64.decode(resdata));
        var res_list = resdata.data;
        if(res_list.length == 0){
            clearInterval(listionhajax);
            is_ajax_list = 1;
            return;
        }
        $.each(res_list,function(k,v){
            var closeprice = 0;
            var closeprice_class = '';

            if(v.ostyle == 0){
                var ostyle_class = "buytop";
                var ostyle_name = iin_mz;
            }else{
                var ostyle_class = "buydown";
                var ostyle_name =iin_md;
            }
            /*if(v.system == 1){
                systemclose = '合约交易';
            }else{*/
               if(v.is_timing == 1){
                    systemclose = ind_hyjy;
               }else{
                    systemclose = gs_mhy;
               }
           /* }*/
            if(v.is_win == 1){
                if(v.is_timing == 1){
                    closeprice = v.ploss;
                }else{
                    closeprice = v.fee*(100*10+v.endloss*10)/1000;
                }
                win_loss = '';
                closeprice_class = 'in_money';
            }else if(v.is_win == 2){
                if(v.is_timing == 1){
                    closeprice = v.ploss;
                }else{
                    closeprice = v.fee*(-1);
                }
                closeprice_class = 'out_money';
            }else{
                closeprice = 0;
                closeprice_class = '';
            }
            if(v.is_timing == 1){
                total = v.fee;
            }else{
                total = v.fee;
            }
            html += '<li ng-repeat="o" onclick="get_hold_order('+v.oid+')" >\
                        <section style="overflow: hidden;">\
                            <p>\
                                <span class="ng-binding">'+v.ptitle+'</span>\
                                <span  class="ng-binding '+closeprice_class+'">\
                                <i  class="'+ostyle_class+'"></i>'+ostyle_name+'（'+total+'U）</span>\
                            </p>\
                            <p class="ng-binding" style="float:left;">\
                                '+v.buyprice+'-<span  class="ng-binding '+closeprice_class+'">'+v.sellprice+'</span>\
                            </p>\
                            <span class="ng-binding">'+systemclose+'</span>\
                            <p class="ng-binding">'+getLocalTime(v.buytime)+'</p>\
                        </section><section>\
                            <p class="ng-binding '+closeprice_class+'">'+closeprice+'</p>\
                            <p class="ng-binding">'+getLocalTime(v.selltime)+'</p>\
                        </section>\
                    </li>';
    })
    if(types == 0){
        $('.trade_history_list .slider-right .uls').html(html);
    }else{
        $('.trade_history_list .slider-right .uls').append(html);
    }
    html = '';
    page++;
    is_ajax_list = 0;
    })

}





    listionhajax = setInterval("listionh()",1000);

    /**
     * 监听高度
     * @author lukui  2017-07-05
     * @return {[type]} [description]
     */
    function listionh() {
        if($(".uls li:last").attr('ng-repeat')){
            var ScrollTop = $(".uls li:last").offset().top;

            if(ScrollTop <1000 ){
                setolist(1);
            }
        }

    }




    function get_hold_order(oid) {
        var url = "/index/order/get_hold_order/oid/"+oid;
        $.get(url,function(data){
            var data = jQuery.parseJSON(Base64.decode(data));
            var html = '';
                html += '<li class="item item-input">\
                            <span class="input-label" aria-label='+hl_sp+' id="_label-0">'+hl_sp+'</span>\
                            <span class="input-content ng-binding">'+data.ptitle+'</span>\
                        </li>';
                html += '<li class="item item-input">\
                            <span class="input-label" aria-label="'+gs_cjj+'" id="_label-1">'+gs_cjj+'</span>\
                            <span class="input-content ng-binding">'+data.buyprice+'</span>\
                        </li>';
                html += '<li class="item item-input">\
                            <span class="input-label" aria-label="'+hl_jsj+'" id="_label-2">'+hl_jsj+'</span>\
                            <span class="input-content ng-binding">'+data.sellprice+'</span>\
                        </li>';
                html += '<li class="item item-input">\
                            <span class="input-label" aria-label="'+hl_pclx+'" id="_label-3">'+hl_pclx+'</span>';
                html +=  '<span class="input-content ng-binding">';
                     if(data.is_timing == 1){
                        html += ind_hyjy;
                     }else{
                            html += gs_mhy;
                     }
                html += '</span></li>';
                html += '<li class="item item-input">\
                            <span class="input-label" aria-label="'+or_bzj+'" id="_label-4">or_bzj</span>\
                            <span class="input-content ng-binding">'+data.fee+'</span>\
                        </li>';
                html += '<li class="item item-input">\
                            <span class="input-label" aria-label="'+hl_gmss+'" id="_label-5">'+hl_gmss+'</span>';
                html +=  '<span class="input-content ng-binding">';
                        if(data.is_timing == 1){
                            html += data.onumber;
                        }else{
                            html += hl_wu;
                        }
                html += '</span></li>';
                html += '<li class="item item-input">\
                            <span class="input-label" aria-label="'+gs_zfy+'" id="_label-6">'+gs_zfy+'</span>';
                html +=  '<span class="input-content ng-binding">';
                        if(data.is_timing == 1){
                            html += data.fee;
                        }else{
                            html += data.fee;
                        }
                html += '</span></li>';
                html += '<li class="item item-input">\
                            <span class="input-label" aria-label="'+gs_syf+'" id="_label-7">'+gs_syf+'</span>\
                            <span class="input-content ng-binding">'+data.sx_fee+'</span>\
                        </li>';
                html += '<li class="item item-input">\
                            <span class="input-label" aria-label="'+hl_yk+'" id="_label-8">'+hl_yk+'</span>';
                        if(data.ploss<0){
                html +=  '<span class="input-content ng-binding fall">'+data.ploss+'</span>';
                        }else{
                html +=  '<span class="input-content ng-binding rise">'+data.ploss+'</span>';
                        }
                html += '</li>';
                html += '<li class="item item-input">\
                            <span class="input-label" aria-label="'+gs_zy+'" id="_label-9">'+gs_zy+'</span>';
                html +=  '<span class="input-content ng-binding">';
                        if(data.is_timing == 1){
                            html += data.stop_win+'%';
                        }else{
                            html += hl_wu;
                        }
                html += '</span></li>';
                html += '<li class="item item-input">\
                            <span class="input-label" aria-label="'+gs_zs+'" id="_label-10">'+gs_zs+'</span>';
                html +=  '<span class="input-content ng-binding">';
                        if(data.is_timing == 1){
                            html += data.stop_loss+'%';
                        }else{
                            html += hl_wu;
                        }
                html += '</span></li>';
                html += '<li class="item item-input">\
                            <span class="input-label" aria-label="' + hl_cjsj + '" id="_label-11">' + hl_cjsj + '</span>\
                            <span class="input-content ng-binding">'+getLocalTime(data.buytime)+'</span>\
                        </li>';
                html += '<li class="item item-input">\
                            <span class="input-label" aria-label="'+gb_jssj+'" id="_label-12">'+gb_jssj+'</span>\
                            <span class="input-content ng-binding">'+getLocalTime(data.selltime)+'</span>\
                        </li>';
                $('#hold_order_info').html(html);
                $('.modal-backdrop').removeClass('ng-hide');
                $('.modal-backdrop').addClass('active');
                $('.tab-nav').hide();
        });
    }

    function close_order_modal() {
        $('.modal-backdrop').addClass('ng-hide');
        $('.modal-backdrop').removeClass('active');
        $('.tab-nav').show();
    }

