<?php

//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php'; //转换成硬路径，速度更快

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta http-equiv="expires" content="0">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">

<meta name="viewport" content="width=device-width, initial-scale=1">
<title>我的健身计划</title>


<!-- Bootstrap -->
<link rel="stylesheet" type="text/css" href="style/bootstrap.css" media="screen">


<!-- js -->
<script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="js/mydatamap.js"></script>


<!-- css -->
<style type="text/css">
*{
	font-family: "微软雅黑";
}
#d1{
	margin: 0 auto;
	margin-top: 100px;
	width: 600px;
	height: 300px;
	border: 2px #5F5 solid;
}
</style>


</head>
<body>


<div id="d1">
</div>


<script type="text/javascript">

</script>

</body>
</html>