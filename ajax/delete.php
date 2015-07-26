<?php

//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//引入公共文件
require substr(dirname(__FILE__),0,-4).'/includes/common.inc.php'; //转换成硬路径，速度更快

_query("DELETE FROM items
		WHERE items.num='{$_POST['num']}' AND
			  items.gp='{$_POST['gp']}' AND
			  items.times='{$_POST['date']}' AND
			  items.fit_id=(SELECT fit.fit_id FROM fit WHERE name='{$_POST['fitname']}')
		");

echo 1;

?>