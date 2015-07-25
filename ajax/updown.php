<?php

//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//引入公共文件
require substr(dirname(__FILE__),0,-4).'/includes/common.inc.php'; //转换成硬路径，速度更快

$nowgp = $_POST['gp'] + $_POST['type'];

if( $nowgp >= 0 ){
	_query("UPDATE items 
			SET gp='$nowgp'
			WHERE times='{$_POST['date']}' AND fit_id=(	SELECT fit_id
														FROM fit
														WHERE name='{$_POST['fitname']}'
														)
			");
}

echo $nowgp;

?>