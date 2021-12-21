
var ctype = "l";
var ccout;

$(function () {
	ccout=setTimeout("getonedata()",1000);
    autoHeight();
	getMaindata(ctype);

})
setInterval("getklines()",1000);
function getklines() {
	var nowdate=new Date();
	var s=nowdate.getSeconds();
	if(s == 0){

		getMaindata(ctype)
	}
}

var obj={
		start:20,
		end:100
	}
var minQiya,maxQiya;
$(window).resize(function(e){
	autoHeight();
})

//时间戳转成时：分：00形式   1700以来的秒数（非毫秒）
function getDateHM(tm){
	NWh=new Date(parseInt(tm) * 1000).getHours(tm);
	NWm=new Date(parseInt(tm) * 1000).getMinutes(tm);
	if(NWh<10){
		NWh="0"+NWh;
	}
	if(NWm<10){
		NWm="0"+NWm;
	}
  var tt=NWh+":"+NWm
  return tt;
}



//自动高度
function autoHeight(){
    var headerH=$(".headerbar").height();
	var headerbarH=$(".shuju").height();
	
	var NavH=$(".pull-left").height();
	
	var bottomH=$(".bottom-nav").height();
	var WinHss=$(window).height();
console.log(headerH);
   


//	$("footer").height(WinHss-headerbarH-NavH-bottomH-headerH);
//	$("#ecKx").height(WinHss-headerbarH-NavH-bottomH-headerH);
}




function splitData(rawData) {
    var categoryData = [];
    var values = []
    for (var i = 0; i < rawData.length; i++) {
        categoryData.push(getDateHM(rawData[i].splice(0, 1)[0]));
        values.push(rawData[i])
    }
    return {
        categoryData: categoryData,
        values: values
    };
}

function calculateMA(dayCount) {
    var result = [];
    for (var i = 0, len = data0.values.length; i < len; i++) {
        if (i < dayCount) {
            result.push('-');
            continue;
        }
        var sum = 0;
        for (var j = 0; j < dayCount; j++) {
            sum += Number(data0.values[i - j][1]);
        }
        result.push(sum / dayCount);
    }
	//alert(result)
    return result;
}

function kTl(KDS){
	K2line=new Array();
	for(p=0;p<KDS.length;p++){
		K2line.push(KDS[p][3])
		if (p == KDS.length-1) {
			K2line[p] = KDS[p][1];
		}
	}
	//alert(JSON.stringify(K2line))
	return K2line;
}

function calculateMA2(numb,dts) {
    var result2 = [];
    for (var y= 0, len = dts.length;y < len;y++) {
        if (y < numb) {
            result2.push('-');
            continue;
        }
        var sum = 0;
        for (var jj = 0; jj < numb; jj++) {
            sum += Number(dts[y - jj]);
        }
        result2.push(sum / numb);
    }
	//alert(result)
    return result2;
}
function funPoor(ds){
	fPoor=new Array();
	for(x=0;x<ds.length;x++){
		fPoor.push(ds[x][1])
	}
	return fPoor;
}
//求数的差
function getPoor(d){
	nPoor=new Array();
	nPoor.push("-");
	for(i=0;i<d.length;i++){
		if(i>0){
			nPoor.push((d[i]-d[i-1]).toString())
		}
	}
	return nPoor;
}

var  cldata;

//AJAX请求
function getMaindata(ctype){


	Vtype='1M';
	switch (Vtype){
		case "1M":
		  interval="1";
		  break;
		case "5M":
		  interval="5";
		  break;
		case "15M":
		  interval="15";
		  break;
		case "30M":
		  interval="30";
		  break;
		case "1H":
		  interval="60";
		  break;
		case "1D":
		  interval="d";
		  break;
	}
	//ajax
	clearTimeout(ccout);
	$.ajax({
		url:"/index/api/getkdata",
		type: "get",
		dataType: "json",
		async:true,
		contentType: "application/json",
		data:{
			"pid":order_pid,
			"num":150,
			"interval":interval
		},
		success: function(_jdatadata) {

    		var jdatadata = jQuery.parseJSON(Base64.decode(_jdatadata));

			localStorage.setItem("data",'');
			localStorage.setItem("data",JSON.stringify(jdatadata));
			gotoecharts(jdatadata)
			ccout=setTimeout("getonedata()",1000);
			getonedata();
			minQiya = jdatadata.items[jdatadata.items.length-1][2];
			maxQiya = jdatadata.items[jdatadata.items.length-1][3];
			},
			error:function(data){

			}
	})

}
/*
 */

build_diff_data = function (m_short, m_long, data) {
        var result = [];
        var pre_emashort = 0;
        var pre_emalong = 0;
        for (var i = 0, len = data.length; i < len; i++) {
            var ema_short = data[i][1];
            var ema_long = data[i][1];

            if (i != 0) {
                ema_short = (1.0 / m_short) * data[i][1] + (1 - 1.0 / m_short) * pre_emashort;
                ema_long = (1.0 / m_long) * data[i][1] + (1 - 1.0 / m_long) * pre_emalong;
            }

            pre_emashort = ema_short;
            pre_emalong = ema_long;
            var diff = ema_short - ema_long;

            result.push(diff);
        }

        return result;
    }

    build_dea_data = function (m, diff) {
        var result = [];
        var pre_ema_diff = 0;
        for (var i = 0, len = diff.length; i < len; i++) {
            var ema_diff = diff[i];

            if (i != 0) {
                ema_diff = (1.0 / m) * diff[i] + (1 - 1.0 / m) * pre_ema_diff;
            }
            pre_ema_diff = ema_diff;

            result.push(ema_diff);
        }

        return result;
    }

    build_macd_data = function (data, diff, dea) {
        var result = [];

        for (var i = 0, len = data.length; i < len; i++) {
            var macd = 2 * (diff[i] - dea[i]);
            result.push(macd);
        }

        return result;
    }


/*
 */

function gotoecharts(data){

	var ecKxId = document.getElementById("ecKx");
	//var ecKx = echarts.init(ecKxId);
    var ecKx = echarts.getInstanceByDom(ecKxId);
    if (ecKx === undefined) {
        ecKx = echarts.init(ecKxId);
    }


	cldata=data.topdata.now;

	$("footer").data("nowk",cldata);


	var diff =build_diff_data(12, 26, data.items);
        var dea =build_dea_data(9, diff);
        var macd =build_macd_data(data.items, diff, dea);
	diffL=diff.length-1;
	deaL=dea.length-1;
	macdL=macd.length-1;


	 data0 = splitData(data.items);
	  var ecKdata = {
		  legend: {
				//data: ['日K', 'MA5', 'MA10', 'MA20', 'MA30']
			},
			/*
			tooltip: {
				trigger: 'axis'
			},
*/
			grid: [
					 {
						   left: 10,
							right:60,
							top:'3%',
							bottom:110
						},
						{
							left: 20,
							right:70,
							bottom:'5%',
							height: 50
						}
			   ],
			xAxis:[{
					type: 'category',
					data: data0.categoryData,
					scale: true,
					boundaryGap : true,
					splitLine: {show: false},
					axisTick: {show: false},
						splitLine: {show: false},
					axisLine:{
						show:false,
						lineStyle:{
							color:'#5f5f5f'
						}
					},
					min: 'dataMin',
					max: 'dataMax',
					//show:false
				},
				{  gridIndex: 1,
						type: 'category',
						data: data0.categoryData,
						scale: true,
						boundaryGap : true,
						//axisLine: {onZero: false},
							axisTick: {show: false},
							splitLine: {show: false},
							axisLabel: {show: false},
						min: 'dataMin',
						max: 'dataMax',
						show:false
					}
				],
			yAxis:[
			 {   type:'value',
				position:"right",
				scale: true,
				splitNumber:5,
				boundaryGap : false,
				splitLine: {
					show: true,
					lineStyle:{
						color:'#292929'
					}
					},
				axisLine:{
					show:false,
					lineStyle:{
						color:'#5f5f5f'
					}
				},
				axisTick:{
				  show:false
				},
				axisLabel:{
					show:true,
					formatter: function (value, index) {
						return value.toFixed(5)
					}
				},
			},
			{   gridIndex: 1,
				position:"right",
				scale: true,
				splitNumber:3,
				boundaryGap : false,
				splitLine: {show: false},
				axisLine:{
				   show:false,
					onZero: true,
					lineStyle:{
						color:'#5f5f5f'
					}
				},
				axisTick:{
				  show:false
				},
				axisLabel:{
					show:true,
					formatter: function (value, index) {

						if(value>0){
							return "+"+value.toFixed(5)
						}
						if(value<0){
							return value.toFixed(5)
						}
						if(value==0){
							return '-'+value.toFixed(5)
						}
					}
				},
			  }
			],
			dataZoom:[
					{
							type: 'inside',
							xAxisIndex: [0, 1],
							start: obj.start,
							end: obj.end
							//start: 50,
						},
						{
							show: false,
							xAxisIndex: [0, 1],
							type: 'slider',
							top: '1%',
							start: 0,
							end: 50
						}
				],
			series: [
				{
					name: '日K',
					type: 'candlestick',
					data: data0.values,
					barWidth:'60%',



					markLine: {
						data: [
							{yAxis:data.topdata.now}
						],
						symbol:'',
						lineStyle:{
							normal:{
								color:'#c23531',
							}

						},
						label:{
							normal:{
							formatter: '{c}'
							}
						},
					animationDuration:0
					},
					itemStyle:{
						normal:{
							//color:'#c23531',
							//color0:'rgba(19,233,236,1)',
							//borderColor:'#c23531',
							//borderColor0:'rgba(19,233,236,1)',
							color:'#00b464',
							color0:'#c23531',
							borderColor:'#00b464',
							borderColor0:'#c23531',
						}
					},
					animationDuration:0

				},
				{
					name: 'MA5',
					type: 'line',
					data: calculateMA(5),
					smooth: true,
					lineStyle: {
						normal: {opacity: 1}
					},
					animationDuration:0,
                            itemStyle:{
                                normal:{
                                    opacity:0,

                                }
                            }
				},
				{
					name: 'MA10',
					type: 'line',
					data: calculateMA(10),
					smooth: true,
					lineStyle: {
						normal: {opacity: 1}
					},
					animationDuration:0,
                            itemStyle:{
                                normal:{
                                    opacity:0
                                }
                            }
				},
				{
					name: 'MA20',
					type: 'line',
					data: calculateMA(20),
					smooth: true,
					lineStyle: {
						normal: {opacity: 1}
					},
					animationDuration:0,
                            itemStyle:{
                                normal:{
                                    opacity:0
                                }
                            }
				},
				{
					name: 'MA30',
					type: 'line',
					data: calculateMA(30),
					smooth: true,
					lineStyle: {
						normal: {opacity: 1}
					},
					animationDuration:0,
                            itemStyle:{
                                normal:{
                                    opacity:0
                                }
                            }
				},
				 {
					xAxisIndex: 1,
					yAxisIndex: 1,
					name: 'MACD',
					type: 'bar',
					data:macd,//
					smooth: true,
					symbolSize:1,
					animationDuration:0,
					itemStyle:{
						normal:{
							color:'rgba(31,198,98,1)'
						}
					}
				},
					{
						xAxisIndex: 1,
						yAxisIndex: 1,
						name: 'diff',//快
						type: 'line',
						data: diff,
						smooth: true,
						animationDuration:0,
						symbolSize:1,
						lineStyle:{
							normal:{
								color:"#13E9EC"
							}
						}
					},
					{
						xAxisIndex: 1,
						yAxisIndex: 1,
						name: 'dea',
						type: 'line',
						data: dea,//慢
						smooth: true,
						animationDuration:0,
						symbolSize:1,
						lineStyle:{
							normal:{
								color:"#FA2E42"
							}
						}
					}

			]
		};
	  var ecKdata2 = {
		  legend: {
				//data: ['日K', 'MA5', 'MA10', 'MA20', 'MA30']
			},
			/*
			tooltip: {
				trigger: 'axis'
			},
*/
			grid: [
					 {
						   left: 5,
							right:60,
							top:'3%',
							bottom:35
						},
						{
							left: 20,
							right:70,
							bottom:'5%',
							height: 50
						}
			   ],
			xAxis:[{
					type: 'category',
					data: data0.categoryData,
					scale: true,
					boundaryGap : true,
					splitLine: {show: false},
					axisTick: {show: false},
						splitLine: {show: false},
					axisLine:{
						show:false,
						lineStyle:{
							color:'#5f5f5f'
						}
					},
					min: 'dataMin',
					max: 'dataMax',
					//show:false
				},
				{   gridIndex: 1,
						type: 'category',
						data: data0.categoryData,
						scale: true,
						boundaryGap : true,
						//axisLine: {onZero: false},
							axisTick: {show: false},
							splitLine: {show: false},
							axisLabel: {show: false},
						min: 'dataMin',
						max: 'dataMax',
						show:false
					}
				],
			yAxis:[
			 {   type:'value',
				position:"right",
				scale: true,
				splitNumber:4,
				boundaryGap : false,
				splitLine: {
					show: true,
					lineStyle:{
						color:'#ffffff'
					}
					},
				axisLine:{
					show:false,
					lineStyle:{
						color:'#5f5f5f'
					}
				},
				axisTick:{
				  show:false
				},
				axisLabel:{
					show:true,
					formatter: function (value, index) {
						return value.toFixed(5)
					}
				},
				max:'dataMax',
				min:'dataMin'

			},
			{   gridIndex: 1,
				position:"right",
				scale: true,
				splitNumber:3,
				boundaryGap : false,
				splitLine: {show: false},
				axisLine:{
				   show:false,
					onZero: true,
					lineStyle:{
						color:'#5f5f5f'
					}
				},
				axisTick:{
				  show:false
				},
				axisLabel:{
					show:true,
					formatter: function (value, index) {

						if(value>0){
							return "+"+value.toFixed(5)
						}
						if(value<0){
							return value.toFixed(5)
						}
						if(value==0){
							return '-'+value.toFixed(5)
						}
					}
				},
				max:'dataMax',
				min:'dataMin'
			  }
			],
			dataZoom:[
					{
							type: 'inside',
							xAxisIndex: [0, 1],
							start: obj.start,
							end: obj.end
							//start: 50,
						},
						{
							show: false,
							xAxisIndex: [0, 1],
							type: 'slider',
							top: '1%',
							start: 0,
							end: 50
						}
				],
			series: [
				{
					name: '日K',
					type: 'line',
					data: kTl(data.items),
					markLine: {
						data: [
							{yAxis:data.topdata.now}
						],
						symbol:'',
						lineStyle:{
							normal:{
								color:'#c23531',
							}

						},
						label:{
							normal:{
							formatter: '{c}'
							}
						},
					animationDuration:0
					},
					smooth:false,
					symbol: 'none',
					sampling: 'average',
					itemStyle: {
						normal: {
							color: 'rgb(255, 70, 131)'
						}
					},
					lineStyle:{
						normal:{
							width:1.5,
							color:"#d2c01e"
						}
					},

					areaStyle: {
						normal: {
							color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
								offset: 0,
								color: '#FFFFF7'
							}, {
								offset: 0.1,
								color: '#F7F7C6'
							}])
						}
					},
					animationDuration:0

				},
				 /*{
					xAxisIndex: 1,
					yAxisIndex: 1,
					name: 'MACD',
					type: 'bar',
					data:macd,//
					smooth: true,
					symbolSize:1,
					animationDuration:0,
					itemStyle:{
						normal:{
							color:'rgba(31,198,98,1)'
						}
					}
				},
					{
						xAxisIndex: 1,
						yAxisIndex: 1,
						name: 'diff',//快
						type: 'line',
						data: diff,
						smooth: true,
						animationDuration:0,
						symbolSize:1,
						lineStyle:{
							normal:{
								color:"#13E9EC"
							}
						}
					},
					{
						xAxisIndex: 1,
						yAxisIndex: 1,
						name: 'dea',
						type: 'line',
						data: dea,//慢
						smooth: true,
						animationDuration:0,
						symbolSize:1,
						lineStyle:{
							normal:{
								color:"#FA2E42"
							}
						}
					}*/
			]
		};
     ecKx.clear();
	  if(ctype=="k"){
		  ecKx.setOption(ecKdata);
	  }else{
		   ecKx.setOption(ecKdata2);
	  }

	  ecKx.on("datazoom",function(param){
			obj = param.batch[0];
			// ecKx.setOption(ecKdata);
		})
	ecKxId = null;


}

function bzjgx() {
	var num = $('#num').val();
	if(num==''){
		num=0;
	}
	var code = $('.gg .actives').attr('data-sen');

	$.ajax({
		type:'POST',
		url:'/index/Goods/bzj',
		data:{pid:order_pid,number:num,code},
		success: function(msg){
			var msg = eval("(" + msg + ")");


			$('#bzj').html(msg.bzj);
			$('#pronum').html(msg.pronum);
			$('#proprice').html(msg.proprice);


		}
	})

}
//calculateMA2(5,)
//
function getonedata(){
	var data=JSON.parse(localStorage.getItem("data"));

	clearTimeout(ccout);


    var temp = $.ajax({
        url:"/index/api/getprodata",
        type: "get",
        cache:false,
        dataType: "json",
        async:true,

        data:{
            "pid":order_pid
        },
        success: function(_onedata) {
        	var onedata = jQuery.parseJSON(Base64.decode(_onedata));

            //$("#container .txt1 span.a").text(data.topdata.topdata);

            //	alert(NDAT.topdata.now)
            var a = tempmy(onedata,data);
            a = null;

        },
        error:function(XHR){
            XHR = null
        },
        complete: function (jqXHR , TS) { jqXHR=null;
             }

    })
    //temp.destroy();
    delete temp;
    ccout=setTimeout("getonedata()",1000);
}

function tempmy(onedata,data){



    if(onedata.now>data.topdata.now){
        data.topdata=onedata;
        data.topdata.state="up"
    }

    if(onedata.now<data.topdata.now){
        data.topdata=onedata;
        data.topdata.state="down"
    }

    data.items[data.items.length-1][2] = onedata.now;
    maxQiya = maxQiya>onedata.now?maxQiya:onedata.now;
    minQiya = minQiya<onedata.now?minQiya:onedata.now;
    data.items[data.items.length-1][3] = minQiya;
    data.items[data.items.length-1][4] = maxQiya;
    if(ctype=="l"){
        K2line[data.items.length-1]=data.topdata.now;
    }

    var gotoechartsNew = new gotoecharts(data);
    // gotoechartsNew();
    gotoechartsNew = null;


    newprice = data.topdata.now;

	bzjgx();

	$(".youhezi .lowest").text(data.topdata.lowest);
	$(".youhezi .highest").text(data.topdata.highest);

	$(".youhezi .highest").text(data.topdata.highest);
    var old_price = $(".shuju1 .now").html();


	$("#spread_zhang").text(data.topdata.spread_zhang);
	$("#spread_die").text(data.topdata.spread_die);

	if(data.topdata.chajia>0){
		$('.shuju1s').removeClass('fall');
		$('.shuju1s').addClass('rise');
	}else if(data.topdata.chajia<0){
		$('.shuju1s').addClass('fall');
		$('.shuju1s').removeClass('rise');
	}


	$("#chajia").text(data.topdata.chajia);
	$("#zhangfu").text(data.topdata.zhangfu);

    if(old_price*10 < newprice*10){
        $('.now').removeClass('fall');
        $('.now').addClass('rise');
    }else if(old_price*10 > newprice*10){
        $('.now').addClass('fall');
        $('.now').removeClass('rise');
    }
    $('.now').html(newprice);

    onedata = null ;
    data = null;
}


//setInterval("getMaindata()",60000);
