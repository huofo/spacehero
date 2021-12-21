<?php
	$menulist = array(
		array(
			"id"   =>"104",
			"con"  =>"Goods",
			"act"  =>"",
			"url"  =>"",
			"name" =>"产品管理",
			"icon" =>"icon-btc",
			"arrow"=>"arrow",
			"arr"  =>"",
			"list" =>array(
				array(
					"id"  =>"2",
					"con" =>"Goods",
					"act" =>"prolist",
					"url" =>"/admin/Goods/prolist.html",
					"name"=>"产品列表",
					"arr" =>""
				),
				array(
					"id"  =>"4",
					"con" =>"Goods",
					"act" =>"proclass",
					"url" =>"/admin/Goods/proclass.html",
					"name"=>"产品分类",
					"arr" =>""
				),
				/*array(
					"id"  =>"4",
					"con" =>"Goods",
					"act" =>"proclass",
					"url" =>"/admin/Goods/curslist.html",
					"name"=>"法币币种管理",
					"arr" =>""
				),*/
				/*array(
					"id"  =>"5",
					"con" =>"Goods",
					"act" =>"risk",
					"url" =>"/admin/Goods/risk.html",
					"name"=>"风控管理",
					"arr" =>""
				),*/
				/*array(
					"id"  =>"6",
					"con" =>"Goods",
					"act" =>"huishou",
					"url" =>"/admin/Goods/huishou.html",
					"name"=>"产品回收站",
					"arr" =>""
				)*/
			)
		),
		array(
			"id"   =>"105",
			"con"  =>"Order",
			"act"  =>"",
			"url"  =>"",
			"name" =>"订单管理",
			"icon" =>"icon-paste",
			"arrow"=>"arrow",
			"arr"  =>"",
			"list" =>array(
				array(
					"id"  =>"7",
					"con" =>"Order",
					"act" =>"orderlist",
					"url" =>"/admin/Order/orderlist.html",
					"name"=>"秒合约订单",
					"arr" =>""
				),
			
				array(
					"id"  =>"8",
					"con" =>"Order",
					"act" =>"orderlist_bibi",
					"url" =>"/admin/Order/orderlist_bibi.html",
					"name"=>"币币订单",
					"arr" =>""
				),
				
				array(
					"id"  =>"10",
					"con" =>"Order",
					"act" =>"orderlist_lever",
					"url" =>"/admin/Order/orderlist_lever.html",
					"name"=>"合约订单",
					"arr" =>""
				),

				array(
					"id"  =>"200",
					"con" =>"Order",
					"act" =>"orderlist_shevles",
					"url" =>"/admin/Order/orderlist_shevles.html",
					"name"=>"法币上架订单",
					"arr" =>""
				),
				array(
					"id"  =>"201",
					"con" =>"Order",
					"act" =>"orderlist_trade",
					"url" =>"/admin/Order/orderlist_trade.html",
					"name"=>"法币撮合订单",
					"arr" =>""
				),

				/*array(
					"id"  =>"13",
					"con" =>"Order",
					"act" =>"orderlog",
					"url" =>"/admin/Order/orderlog.html",
					"name"=>"平仓日志",
					"arr" =>""
				)*/
			)
		),
		array(
			"id"   =>"115",
			"con"  =>"User",
			"act"  =>"",
			"url"  =>"",
			"name" =>"用户管理",
			"icon" =>"icon-user",
			"arrow"=>"arrow",
			"arr"  =>array("userlist","useradd","userprice","userinfo","cash","myteam"),
			"list" =>array(
				array(
					"id"  =>"14",
					"con" =>"User",
					"act" =>"userlist",
					"url" =>"/admin/User/userlist.html",
					"name"=>"客户列表",
					"arr" =>array("userlist","useradd")
				),
				array(
					"id"  =>"22",
					"con" =>"User",
					"act" =>"myteam",
					"url" =>"/admin/User/myteam.html",
					"name"=>"我的团队",
					"arr" =>""
				),

                array(
                    "id"  =>"18",
                    "con" =>"User",
                    "act" =>"message",
                    "url" =>"/admin/User/message.html",
                    "name"=>"留言管理",
                    "arr" =>""
                ),

				array(
					"id"  =>"23",
					"con" =>"User",
					"act" =>"userprice",
					"url" =>"/admin/User/userprice.html",
					"name"=>"充值列表",
					"arr" =>""
				),
				array(
					"id"  =>"24",
					"con" =>"User",
					"act" =>"cash",
					"url" =>"/admin/User/cash.html",
					"name"=>"提现列表",
					"arr" =>""
				),

			/*	array(
					"id"  =>"54",
					"con" =>"User",
					"act" =>"account_list",
					"url" =>"/admin/User/account_list.html",
					"name"=>"银行卡列表",
					"arr" =>""
				)*/
			)
		),
		/*array(
			"id"   =>"106",
			"con"  =>"Price",
			"act"  =>"",
			"url"  =>"",
			"name" =>"报表管理",
			"icon" =>"icon-yen",
			"arrow"=>"arrow",
			"arr"  =>"",
			"list" =>array(
				array(
					"id"  =>"25",
					"con" =>"Price",
					"act" =>"allot",
					"url" =>"/admin/Price/allot.html",
					"name"=>"红利报表",
					"arr" =>""
				),
				array(
					"id"  =>"26",
					"con" =>"Price",
					"act" =>"yongjin",
					"url" =>"/admin/Price/yongjin.html",
					"name"=>"佣金报表",
					"arr" =>""
				),
				array(
					"id"  =>"19",
					"con" =>"Price",
					"act" =>"pricelist",
					"url" =>"/admin/Price/pricelist.html",
					"name"=>"资金报表",
					"arr" =>""
				),
				array(
					"id"  =>"20",
					"con" =>"Price",
					"act" =>"myprice",
					"url" =>"/admin/Price/myprice.html",
					"name"=>"个人报表",
					"arr" =>""
				)
			)
		),*/
		array(
			"id"   =>"107",
			"con"  =>"Setup",
			"act"  =>"",
			"url"  =>"",
			"name" =>"参数设置",
			"icon" =>"icon-file-alt",
			"arrow"=>"arrow",
			"arr"  =>"",
			"list" =>array(
				array(
					"id"  =>"27",
					"con" =>"Setup",
					"act" =>"index",
					"url" =>"/admin/Setup/index.html",
					"name"=>"基本设置",
					"arr" =>""
				),
				array(
					"id"  =>"28",
					"con" =>"Setup",
					"act" =>"proportion",
					"url" =>"/admin/Setup/proportion.html",
					"name"=>"参数设置",
					"arr" =>""
				),
				array(
					"id"  =>"29",
					"con" =>"Setup",
					"act" =>"addsetup",
					"url" =>"/admin/Setup/addsetup.html",
					"name"=>"添加配置",
					"arr" =>""
				),
				array(
					"id"  =>"30",
					"con" =>"Setup",
					"act" =>"deploy",
					"url" =>"/admin/Setup/deploy.html",
					"name"=>"配置管理",
					"arr" =>""
				)
			)
		),
		array(
			"id"   =>"108",
			"con"  =>"System",
			"act"  =>"",
			"url"  =>"",
			"name" =>"系统设置",
			"icon" =>"icon-cogs",
			"arrow"=>"arrow",
			"arr"  =>"",
			"list" =>array(
				array(
					"id"  =>"31",
					"con" =>"System",
					"act" =>"grouplist",
					"url" =>"/admin/System/grouplist.html",
					"name"=>"分组权限列表",
					"arr" =>""
				),
				array(
					"id"  =>"33",
					"con" =>"System",
					"act" =>"adminadd",
					"url" =>"/admin/System/adminadd.html",
					"name"=>"添加管理员",
					"arr" =>""
				),
				array(
					"id"  =>"34",
					"con" =>"System",
					"act" =>"adminlist",
					"url" =>"/admin/System/adminlist.html",
					"name"=>"管理员列表",
					"arr" =>""
				),
			/*	array(
					"id"  =>"35",
					"con" =>"System",
					"act" =>"banks",
					"url" =>"/admin/System/banks.html",
					"name"=>"提现银行卡",
					"arr" =>""
				),
				array(
					"id"  =>"36",
					"con" =>"System",
					"act" =>"recharge",
					"url" =>"/admin/System/recharge.html",
					"name"=>"充值配置",
					"arr" =>array("recharge","addrech")
				),
				array(
					"id"  =>"38",
					"con" =>"System",
					"act" =>"setwx",
					"url" =>"/admin/System/setwx.html",
					"name"=>"微信设置",
					"arr" =>""
				),
				array(
					"id"  =>"39",
					"con" =>"System",
					"act" =>"dbbase",
					"url" =>"/admin/System/dbbase.html",
					"name"=>"数据备份",
					"arr" =>""
				)
				*/
			)
		),
		array(
			"id"   =>"109",
			"con"  =>"About",
			"act"  =>"",
			"url"  =>"",
			"name" =>"关于我们",
			"icon" =>"icon-reorder",
			"arrow"=>"arrow",
			"arr"  =>"",
			"list" =>array(
				array(
					"id"  =>"41",
					"con" =>"About",
					"act" =>"aboutlist",
					"url" =>"/admin/About/aboutlist.html",
					"name"=>"栏目列表",
					"arr" =>""
				),
				array(
					"id"  =>"42",
					"con" =>"About",
					"act" =>"aboutadd",
					"url" =>"/admin/About/aboutadd.html",
					"name"=>"添加栏目",
					"arr" =>""
				)
			)
		),
		/*array(
			"id"   =>"110",
			"con"  =>"Operation",
			"act"  =>"",
			"url"  =>"",
			"name" =>"操作指导",
			"icon" =>"icon-move",
			"arrow"=>"arrow",
			"arr"  =>"",
			"list" =>array(
				array(
					"id"  =>"43",
					"con" =>"Operation",
					"act" =>"operationlist",
					"url" =>"/admin/Operation/operationlist.html",
					"name"=>"指导列表",
					"arr" =>""
				),
				array(
					"id"  =>"44",
					"con" =>"Operation",
					"act" =>"operationadd",
					"url" =>"/admin/Operation/operationadd.html",
					"name"=>"添加指导",
					"arr" =>""
				)
			)
		),*/
		/*array(
			"id"   =>"111",
			"con"  =>"Jiameng",
			"act"  =>"",
			"url"  =>"",
			"name" =>"合作加盟",
			"icon" =>"icon-group",
			"arrow"=>"arrow",
			"arr"  =>"",
			"list" =>array(
				array(
					"id"  =>"45",
					"con" =>"Jiameng",
					"act" =>"jiamenglist",
					"url" =>"/admin/Jiameng/jiamenglist.html",
					"name"=>"加盟列表",
					"arr" =>""
				)
			)
		),*/
		/*array(
			"id"   =>"112",
			"con"  =>"Guidance",
			"act"  =>"",
			"url"  =>"",
			"name" =>"名师指导",
			"icon" =>"icon-magic",
			"arrow"=>"arrow",
			"arr"  =>"",
			"list" =>array(
				array(
					"id"  =>"46",
					"con" =>"Guidance",
					"act" =>"guidancelist",
					"url" =>"/admin/Guidance/guidancelist.html",
					"name"=>"名师列表",
					"arr" =>""
				),
				array(
					"id"  =>"47",
					"con" =>"Guidance",
					"act" =>"guidanceadd",
					"url" =>"/admin/Guidance/guidanceadd.html",
					"name"=>"添加名师",
					"arr" =>""
				),
				array(
					"id"  =>"48",
					"con" =>"Guidance",
					"act" =>"articlelist",
					"url" =>"/admin/Guidance/articlelist.html",
					"name"=>"名师文章列表",
					"arr" =>""
				),
				array(
					"id"  =>"49",
					"con" =>"Guidance",
					"act" =>"articleadd",
					"url" =>"/admin/Guidance/articleadd.html",
					"name"=>"添加名师文章",
					"arr" =>""
				)
			)
		),*/
	array(
			"id"   =>"113",
			"con"  =>"Notice",
			"act"  =>"",
			"url"  =>"",
			"name" =>"锁仓挖矿",
			"icon" =>"icon-bell-alt",
			"arrow"=>"arrow",
			"arr"  =>"",
			"list" =>array(
				array(
					"id"  =>"50",
					"con" =>"Notice",
					"act" =>"noticelist",
					"url" =>"/admin/Notice/noticelist.html",
					"name"=>"套餐列表",
					"arr" =>""
				),
				array(
					"id"  =>"51",
					"con" =>"Notice",
					"act" =>"noticeadd",
					"url" =>"/admin/Notice/noticeadd.html",
					"name"=>"添加套餐",
					"arr" =>""
				),
				array(
					"id"  =>"151",
					"con" =>"Notice",
					"act" =>"orderlist",
					"url" =>"/admin/Notice/orderlist.html",
					"name"=>"订单列表",
					"arr" =>""
				)
			)
		),
		array(
			"id"   =>"114",
			"con"  =>"Other",
			"act"  =>"",
			"url"  =>"",
			"name" =>"其他配置",
			"icon" =>"icon-cog",
			"arrow"=>"arrow",
			"arr"  =>"",
			"list" =>array(
				/*array(
					"id"  =>"52",
					"con" =>"Other",
					"act" =>"other",
					"url" =>"/admin/Other/other.html",
					"name"=>"其他配置",
					"arr" =>""
				),*/
				array(
					"id"  =>"53",
					"con" =>"Other",
					"act" =>"touchslider",
					"url" =>"/admin/Other/touchslider.html",
					"name"=>"广告设置",
					"arr" =>""
				)
			)
		)
	);
?>
