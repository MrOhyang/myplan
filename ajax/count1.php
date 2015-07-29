<?php

//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//引入公共文件
require substr(dirname(__FILE__),0,-4).'/includes/common.inc.php'; //转换成硬路径，速度更快

$temp = "(";

foreach ($_POST['parts'] as $value) {
	$temp = $temp . '\'' . $value . '\'' . ',';
}

$temp = substr($temp, 0,strlen($temp)-1) . ')';

$datenum = intval($_POST['datenum'])-1;

$_row = _fetch_array("	SELECT DISTINCT times
						FROM items
						ORDER BY times DESC
						LIMIT $datenum,1
						");

$_result = _query("	SELECT items.times,items.num,items.gp,fit.part
					FROM items,fit
					WHERE items.fit_id=fit.fit_id AND 
						  fit.part in ".$temp." AND
						  items.times>='{$_row['times']}'
					ORDER BY times DESC
					");

$arrDate = array();
$arrPart = array();
foreach ($_POST['parts'] as $value) {
	$arrPart[$value] = array();
}
$i = 0;

if( !!$_row = mysql_fetch_array($_result,MYSQL_ASSOC) ){
	// 以下 4 行 相当于新 date 的 new
	$arrDate[$i] = $_row['times'];
	foreach ($_POST['parts'] as $value) {
		$arrPart[$value][$i] = 0;
	}
	$arrPart[$_row['part']][$i] += ($_row['num'] * $_row['gp']);
}

// 循环计算数组
while( !!$_row = mysql_fetch_array($_result,MYSQL_ASSOC) ){
	// 如果日期不相同，就新建一个
	if( $_row['times'] != $arrDate[$i] ){
		$i++;
		$arrDate[$i] = $_row['times'];
		foreach ($_POST['parts'] as $value) {
			$arrPart[$value][$i] = 0;
		}
	}
	$arrPart[$_row['part']][$i] += ($_row['num'] * $_row['gp']);
}

$data = array();
$data['arrDate'] = array_reverse($arrDate);
foreach ($_POST['parts'] as $value) {
	$arrPart[$value] = array_reverse($arrPart[$value]);
}
$data['arrPart'] = $arrPart;

echo json_encode($data);

?>