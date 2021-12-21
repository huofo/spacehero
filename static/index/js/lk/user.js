var listionhajax = '';
var is_ajax_list = '';
var page = 2;
var regs = '';

function update_user() {
	
	var bankno = $('.bankno').val();
	var province = $('.province').val();
	var city = $('.city').val();
	var address = $('.address').val();
	var accntnm = $('.accntnm').val();
	var accntno = $('.accntno').val();
	var scard = $('.scard').val();
	var phone = $('.phone').val();
	var usdt_url = $('.usdt_url').val();
	var id = $('.id').val();


	if(!bankno){layer.msg(jse_qxzyh);return false;}
	if(!province){layer.msg(jse_qxsf);return false;}
	if(!city){layer.msg(jse_qxzcs);return false;}
	if(!address){layer.msg(jse_qxsrzhdz);return false;}
	if(!accntnm){layer.msg(jse_qsrxm);return false;}
	if(!accntno){layer.msg(jse_qsrkh);return false;}
	if(!scard){layer.msg(jse_qsrsfzh);return false;}
	if(!phone){layer.msg(jse_qsryx);return false;}
	if(!usdt_url){layer.msg(jse_qsrsbdz);return false;}

	var postdata = 'bankno='+bankno+"&provinceid="+province+"&cityno="+city+"&address="+address+"&accntnm="+accntnm+"&accntno="+accntno+"&scard="+scard+"&phone="+phone+"&usdt_url="+usdt_url;
	
	//var postdata = "&accntnm="+accntnm+"&scard="+scard+"&phone="+phone+"&usdt_url="+usdt_url;
	
	if(id){
		postdata += "&id="+id
	}
	var posturl = "/index/user/dobanks";
	$.post(posturl,postdata,function(resdata){
		layer.msg(resdata.data);

		if(resdata.type == 1){
			setTimeout('gourl()',1000);
		}

	})

	
}



function gourl() {
	
	history.go(0);
}


/**
 * 出金申请
 * @author lukui  2017-07-04
 * @return {[type]} [description]
 */
function out_withdraw() {
	
	var price = $('.cash-price').val();
	var cash_min = $('.cash_min').html();
	var cash_max = $('.cash_min').attr('attrmax');
	
	var leixing =  $('.tb_listbox .active').attr('data-type');
	
	var usdt_url = $('.usdt-url').val();
	if(usdt_url==''){
	    layer.msg(jse_qsrtbdz);
		return false;
	}
	if(price*10 < cash_min*10){
		layer.msg(jse_zdtbslw+cash_min);
		return false;
	}

	if(price*10 > cash_max*10){
		layer.msg(jse_zgtbslw+cash_max);
		return false;
	}

	var postdata = 'price='+price+"&usdt_type="+leixing+"&usdt_url="+usdt_url;
	var posturl = '/index/user/cash';
	$.post(posturl,postdata,function(resdata){

		layer.msg(resdata.data);
		if(resdata.type == 1){
			setTimeout('gourl()',1000);
		}

	})

	




}

	/**
	 * 监听输入提现金额
	 * @author lukui  2017-07-05
	 * @param  {[type]} ) {		var       price [description]
	 * @return {[type]}   [description]
	 */
	$('.cash input').bind('input propertychange', function() {
		var price = $('.cash-price').val();
		
		var reg_par = $('.reg_par').attr('attrdata');
		
		
		var true_price = (price*(100-reg_par)/100).toFixed(2);
		$('.true_price').html(true_price);
	

	});


/**
 * 资金流水
 * @author lukui  2017-07-05
 * @param  {[type]} ){	var isshow        [description]
 * @return {[type]}         [description]
 */
$(document).on("click",'.price_list li',function(){

	var isshow = $(this).attr('isshow');
	if(isshow == 0){

		$('.today_list_footer').hide();
		$('.price_list li').attr('isshow',0);
		$('.clickshow').addClass('ion-ios-arrow-up');
		$('.clickshow').removeClass('ion-ios-arrow-down');


		$(this).find('.clickshow').removeClass('ion-ios-arrow-up');
		$(this).find('.clickshow').addClass('ion-ios-arrow-down');

		$(this).find('.today_list_footer').show();
		$(this).attr('isshow',1);

	}else{

		$(this).find('.clickshow').addClass('ion-ios-arrow-up');
		$(this).find('.clickshow').removeClass('ion-ios-arrow-down');

		$(this).find('.today_list_footer').hide();
		$(this).attr('isshow',0);

	}
	

});



listionhajax = setInterval("listionh()",1000);
/**
 * 监听高度
 * @author lukui  2017-07-05
 * @return {[type]} [description]
 */
function listionh() {
    if($(".price_list li:last").attr('ng-repeat')){
        var ScrollTop = $(".price_list li:last").offset().top; 

        if(ScrollTop <1000 ){
        	ajax_price_list();
        }
    }
    
}

/**
 * ajax加载资金流水
 * @author lukui  2017-07-05
 * @return {[type]} [description]
 */
function ajax_price_list() {
	

	var url = "/index/user/ajax_price_list?page="+page;
    var html = '';
    if(is_ajax_list == 1){
        return ;
    }
    is_ajax_list = 1;


    $.get(url,function(resdata){
        
        console.log(resdata);
        

        var res_list = resdata.data;
        if(res_list.length == 0){
            clearInterval(listionhajax);
            is_ajax_list = 1;
            return;
        }
        $.each(res_list,function(k,v){
        	if(v.type == 2){
        		var other_money = v.account*-1;
        	}else{
        		var other_money = v.account;
        	}
        	html += '<li ng-repeat="c in moneyList" class="" isshow="0">\
                	<div class="money_list_header">\
                		<section class="other_money_bg">\
                		</section><section>\
                			<p class="ng-binding other_money">'+v.title+'</p>\
                			<p>\
                				<i class="iconfont icon--1 "></i>\
                				<i class="iconfont icon-30 ng-hide"></i>\
                				<span class="ng-binding">'+v.nowmoney+'</span></p>\
                			<p>\
                				<i class="iconfont icon--2 pay_blue"></i>\
                				<span class="ng-binding">'+getLocalTime(v.time)+'</span>\
                			</p>\
                		</section><section class="ng-binding other_money">\
                			'+other_money+'                		</section><section class="icon clickshow ion-ios-arrow-up">\
                		</section>\
                	</div>\
                	<article class="today_list_footer" style="display: none;">\
                		<p class="ng-binding">jse_xq：'+v.content+'</p>\
                	</article>\
                </li>';

        
        
    	})
        $('.price_list').append(html);
        page++;
        is_ajax_list = 0;

    })




}


/**
 * 发送验证码
 * @return {[type]} [description]
 */
function get_svg() {
	
	
	var phone = $('.username').val();
/*
	if(!(/^1[3456789]\d{9}$/.test(phone))){
        layer.msg("请正确输入邮箱！");
        return false;
    }*/
	
	var url = "/index/login/sendmsm/phone/"+phone;
	$.get(url,function(resdata){
		layer.msg(resdata.data);
		if(resdata.type == 1){
			$(".code_btn").attr('onclick',"return false;");
			listion_sendmsm();
		}
	})
	return false;
}

function listion_sendmsm(){

	 var time= 61;
    setTime=setInterval(function(){
        if(time<=1){
            clearInterval(setTime);
            var vau=jse_zfyc;
            $(".code_btn").val(vau);
            $(".code_btn").attr('onclick',"return get_svg();");
            return;
        }
        time--;
        $(".code_btn").val(time+"s");

    },1000);
}

/**
 * 充值
 * @return {[type]} [description]
 */
function submit_deposit() {
	
	can_balance(0);
	
	if(pay_type == ''){
		layer.msg(jse_qxzzflx);
		can_balance(1);
		return false;
		//pay_type='syt_alipay'
		//pay_type='bank_deposit'
	}
	 if(pay_type == 'qtb_wx_wap'){
		layer.msg(jse_wlcwqcs);
		can_balance(1);
		return false;
	}
	var bpprice = $('.bpprice').val();
	
	if(!bpprice || isNaN(bpprice)){
		layer.msg(jse_qsrczje);
		can_balance(1);
		return false;
	}
     if(bpprice < 50){
		layer.msg(jse_zdczjewws);
		can_balance(1);
		return false;
	}
	
	var posturl = "/index/user/addbalance";

    var postdata = "pay_type="+pay_type+"&bpprice="+bpprice;
	
	can_balance(1);

	window.location.href="/index/user/addbalance?"+postdata;

	//$.post(posturl,postdata);
	
}


function submit_deposit_usdt() {
	
	can_balance(0);
	

	var bpprice = $('.bpprice').val();
	
	if(!bpprice || isNaN(bpprice)){
		alert(jse_qsrczje);
		can_balance(1);
		return false;
	}
     if(bpprice < 50){
		alert(jse_zdczwsu);
		can_balance(1);
		return false;
	}
	
	var posturl = "/index/user/addbalance";

    var postdata = "pay_type=bank_deposit&bpprice="+bpprice;
	
	can_balance(1);

	window.location.href="/index/user/addbalance?"+postdata;

	//$.post(posturl,postdata);
	
}



function check_payid(id) {
	
	if(id=='qtb_pay_wxpay_code'){
		
		$('.payimg').show();
	}else{
		$('.payimg').hide();
		
	}
	pay_type = id;

}


//调用微信JS api 支付
function jsApiCall(obj)
{
	
    WeixinJSBridge.invoke(
        'getBrandWCPayRequest',
        obj,
        function(res){
            WeixinJSBridge.log(res.err_msg);
            //alert(res.err_code+'|'+res.err_desc+'|'+res.err_msg);
            if(res.err_msg.indexOf('ok')>0){
            	layer.msg(jur_czcg);
                window.location.href=returnrul;
            }
        }
    );
}

function callpay(obj)
{
    if (typeof WeixinJSBridge == "undefined"){
        if( document.addEventListener ){
            document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
        }else if (document.attachEvent){
            document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
            document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
        }
    }else{
        jsApiCall(obj);
    }
}


function sQrcode(qdata,classname){
	console.log(qdata);
	$("."+classname).empty().qrcode({		// 调用qQcode生成二维码
			render : "canvas",    			// 设置渲染方式，有table和canvas，使用canvas方式渲染性能相对来说比较好
			text : qdata,    				// 扫描了二维码后的内容显示,在这里也可以直接填一个网址或支付链接
			width : "165",              	// 二维码的宽度
			height : "165",             	// 二维码的高度
			background : "#ffffff",     	// 二维码的后景色
			foreground : "#000000",     	// 二维码的前景色
			src: ""    						// 二维码中间的图片
		});	
		
}	


/**
 * 扫码支付区域
 * @return {[type]} [description]
 */
function pay_code_area(type) {
	if(type == 0){
		$('.pay_code_area').hide();
	}else if(type == 1){
		$('.pay_code_area').show();
		can_balance(1);
	}
}


function can_balance(type) {
	if(type == 0){
		$('.reg_btn').attr('onclick',' ');
		$('.reg_btn').html(gs_qsh);
	}else if(type == 1){
		$('.reg_btn').attr('onclick','submit_deposit()');
		$('.reg_btn').html(gs_qrhdfh);
	}
}

//充值配置 
function reg_push(num) {
	if(!num){
		return false;
	}
	//var mon = num*6.8;
	var mon = num;
	$('.bpprice').val(mon);
}