<?php

//防止恶意调用
if (!defined('IN_TG')) {
	exit('Access Defined!');
}

//拒绝PHP低版本
if (PHP_VERSION < '4.1.0') {
	exit('Version is to Low!');
}

//设置字符集编码
header('Content-Type: text/html; charset=utf-8');

//转换硬路径常量
define('ROOT_PATH',substr(dirname(__FILE__),0,-8));

//创建一个自动转义状态的常量
define('GPC', get_magic_quotes_gpc());

//引入函数库
require ROOT_PATH.'includes/global.func.php';
require ROOT_PATH.'includes/mysql.func.php';

// 执行耗时
define('START_TIME',_runtime());

//数据库连接
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PWD','');
define('DB_NAME','fitnessplan');

//初始化数据库
_connect();   //连接MYSQL数据库
_select_db();   //选择指定的数据库
_set_names();   //设置字符集

?>