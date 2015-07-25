<?php

//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//引入公共文件
require substr(dirname(__FILE__),0,-4).'/includes/common.inc.php'; //转换成硬路径，速度更快

$date_num = 10;

$date_start = date('Y-m-d',time()-24*60*60*$date_num);

$_result = _query("	SELECT 
					");

?>