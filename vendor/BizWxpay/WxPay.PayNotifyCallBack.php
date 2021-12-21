<?php
require_once "WxPay.Api.php";
require_once "WxPay.Notify.php";
require_once "WxPay.Log.php";
class PayNotifyCallBack extends WxPayNotify {

	public function __construct() {
		//初始化日志
		$logHandler= new CLogFileHandler(ROOT_PATH."Public".DIRECTORY_SEPARATOR."_logs".DIRECTORY_SEPARATOR."notify".DIRECTORY_SEPARATOR.date('Y-m-d').'.log');
		Log::Init($logHandler, 15);
	}
	/**
	 * 查询订单
	 */
	public function QueryOrder($transaction_id) {
		$_input = new WxPayOrderQuery();
		$_input->SetTransaction_id($transaction_id);
		$_result = WxPayApi::orderQuery($_input);
		Log::DEBUG("query: ".json_encode($_result));

		if(array_key_exists("return_code", $_result)
			&& array_key_exists("result_code", $_result)
			&& $_result['return_code'] == "SUCCESS"
			&& $_result['result_code'] == "SUCCESS") {
			return true;
		}
		return false;
	}

	/**
	 * 重写回调处理函数
	 */
	public function NotifyProcess($data, &$msg) {
		$_notify_output = array();
		if(!array_key_exists("transaction_id", $data)) {
			Log::DEBUG("call back: 【输入的参数不正确】".json_encode($data));
			return false;
		}
		/* 查询订单，判断订单真实性 */
		if(!$this->QueryOrder($data['transaction_id'])) {
			Log::DEBUG("call back: 【订单查询失败】".json_encode($data));
			return false;
		}
		Log::DEBUG("call back: 【".$msg."】".json_encode($data));
		
		if(!empty($data['out_trade_no'])) {
			/* 微信支付成功回调后 */
			$_out_trade_no = strpos($data['out_trade_no'], '-') ? explode('-', $data['out_trade_no']) : $data['out_trade_no'];
			
			if(M('Order')->where(array('id'=>array('in', $_out_trade_no)))->getField('pay_status') != 'paid'){
				
				/* 这里开始更新程序订单状态 */
				R('Common/Api/repairOrder', array($_out_trade_no, $data['transaction_id'], 'paid', 'wxpay'));
				
				/* 减少库存 */
				R('Common/Api/repairStock', array($_out_trade_no));
				 //计算收益
				R('Common/Api/get_pay_by_oid', array($_out_trade_no));
			}
	        foreach($_out_trade_no as $_no) {
	        	// R('Common/Api/doFenxiao', array($_no));
	        }
		}
		send_mail('', '微信支付回复信', "【".$msg."】".json_encode($data));
		return true;
	}
}