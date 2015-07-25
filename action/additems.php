<?php

//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//引入公共文件
require substr(dirname(__FILE__),0,-7).'/includes/common.inc.php'; //转换成硬路径，速度更快

// echo $_POST['fitname'];
// echo $_POST['fitpart'];
// echo $_POST['num'];
// echo $_POST['gp'];
// echo $_POST['placename'];
// echo $_POST['times'];

_query("INSERT INTO items(	fit_id,
		                  	wh_id,
		                  	num,
		                  	gp,
		                  	times
		    				)
		VALUES ((SELECT fit_id FROM fit WHERE fit.name='{$_POST['fitname']}'),
		        (SELECT wh_id FROM place WHERE place.name='{$_POST['placename']}'),
		        '{$_POST['num']}',
		        '{$_POST['gp']}',
		        '{$_POST['times']}'
		    	)
		");

$r1 = _affected_rows();

$_row = _fetch_array("	SELECT clicknum
						FROM place
						WHERE name='{$_POST['placename']}'
						");
$num = 0;
if( !!$_row ){
	$num = $_row['clicknum'] + 1;
	_query("UPDATE place
			SET clicknum=$num
			WHERE name='{$_POST['placename']}'
			");
	$r2 = _affected_rows();
}else{
	$r2 = 0;
}

// _query("UPDATE place
// 		SET clicknum=(SELECT clicknum FROM place WHERE name='{$_POST['placename']}')
// 		WHERE name='{$_POST['placename']}'
// 		");

if ( $r1 == 1 && $r2 == 1) {
	_location('添加成功','../index.php');
}else{
}

?>