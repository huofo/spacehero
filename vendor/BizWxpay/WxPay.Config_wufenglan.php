<?php
class WxPayConfig {
	const APPID = 'wx69411571aec43d70';// 公众号APPID
	const MCHID = '1364199802';// 商户号
	const KEY = '38w91ufengcaoomjiang8lan3crrshan';// API密钥
	const APPSECRET = '059c5a09a027bfbd954f06181e497724';// 公众号APPSECRET

	// TODO
	const NOTIFY_URL = 'http://www.wufenglan.com/wnotify.php';

	const SSLCERT_PATH = '/Public/wxcert/apiclient_cert.pem';
	const SSLKEY_PATH = '/Public/wxcert/apiclient_key.pem';

	const CURL_PROXY_HOST = "0.0.0.0";//"10.152.18.220";
	const CURL_PROXY_PORT = 0;//8080;

	const REPORT_LEVENL = 1;
}