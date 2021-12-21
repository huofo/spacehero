<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/fastpay/Fast_Cofig.php';

//$pay_openid=get_openid();



		 
		 $data_post= array(
			'appkey'=>'5775_7163be8da86067cee474fd582d605099',
			'pay_way'=>'alipay',
			'payee_account'=> "975507660@qq.com",
			'payer_show_name'=>"fastpay",
			'payee_real_name'=>"蒋琼勇",
			'amount'=>40,
			'billno'=>time(),
			'desc'=>time(),
			'uid'=>time()
			
			);
		 
		 $res = fast_pay_alipay($data_post);
		  print_r($res);exit;
		 $result  = json_decode($res,true);
		  
		 if ($result['return_code']=='SUCCESS' && $result['result_code']=='SUCCESS')
        {
            
            
        }

     


?>