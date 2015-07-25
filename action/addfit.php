<?php

//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//引入公共文件
require substr(dirname(__FILE__),0,-7).'/includes/common.inc.php'; //转换成硬路径，速度更快

_query("SELECT fit_id
		FROM fit
		WHERE name='{$_POST['name']}'
		");

if( _affected_rows() == 1 ){
	_location('已有此项目','../index.php');
}else{
	_query("INSERT INTO fit(name,
	 						part
	 						)
	 		VALUES(	'{$_POST['name']}',
	 				'{$_POST['part']}'
	 				)
			");
	if( _affected_rows() == 1 ){
		_location('添加成功','../index.php');
	}
}

?>