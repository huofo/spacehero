<?php
class WxPayConfig {
	const APPID = 'wxf8094fc62bb3d603';// 公众号APPID
	const MCHID = '1244448802';// 商户号
	const KEY = 'longxiangzijia1234longxiangzijia';// API密钥
	const APPSECRET = 'awoxj5i6aandg8schafn895df24dcajs';// 公众号APPSECRET

	// TODO
	const NOTIFY_URL = 'http://wp.gouxiu.me/weixin/index.php';

	const SSLCERT_PATH = 'D:/wwwroot/longxiang/wwwroot/Public/wxcert/apiclient_cert.pem';
	const SSLKEY_PATH = 'D:/wwwroot/longxiang/wwwroot/Public/wxcert/apiclient_key.pem';

	const CURL_PROXY_HOST = "0.0.0.0";//"10.152.18.220";
	const CURL_PROXY_PORT = 0;//8080;

	const REPORT_LEVENL = 1;
}