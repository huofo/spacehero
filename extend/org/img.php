<?php
//http://localhost/paydemo/img.php?url=http://t1.mmxdbw.cn/Home/Index
	include 'phpqrcode.php';

	$url = $_GET["url"];
	
	$errorCorrectionLevel = 'L';//容错级别 

	$matrixPointSize = 6;//生成图片大小 

	//生成二维码图片 
	
	$imgName = time().'.png';

	QRcode::png($url, $imgName, $errorCorrectionLevel, $matrixPointSize, 2); 
	
	echo '/extend/org/'.$imgName;
?>