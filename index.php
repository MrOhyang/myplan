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
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<script type="text/javascript" src="js/myjs.js"></script>
<script type="text/javascript" src="js/index.js"></script>


<!-- css -->
<link rel="stylesheet" type="text/css" href="style/basic.css">
<style type="text/css">
*{
	font-family: "微软雅黑";
}
</style>


</head>
<body>

<?php

// $array = array('肱二头肌','肱三头肌');
// array_push($array, "this");
// print_r($array);

// echo implode(",",$array);

// for modal
$arr1 = array();
$arr2 = array();
$arr3 = array();
$alen = 0;
$alen2 = 0;
$_result = _query("	SELECT name,part
					FROM fit
					");
while( !!$_rows=mysql_fetch_array($_result,MYSQL_ASSOC) ){
	$arr1[$alen] = $_rows['name'];
	$arr2[$alen] = $_rows['part'];
	$alen++;
}
$_result = _query("	SELECT name
					FROM place
					ORDER BY clicknum DESC
					");
while( !!$_rows=mysql_fetch_array($_result,MYSQL_ASSOC) ){
	$arr3[$alen2] = $_rows['name'];
	$alen2++;
}

// for data
class myData{
	public $_date = "";
	public $_items = array();
	function myRever(){
		$this->_items = array_reverse($this->_items);
	}
}
$_result = _query("	SELECT items.it_id,items.num,items.gp,items.times,fit.name as fit_name,fit.part,place.name as place
					FROM items,fit,place
					WHERE items.fit_id=fit.fit_id AND items.wh_id=place.wh_id
					ORDER BY items.it_id DESC
					");
$_data = array();
$i = 0;
if( !!$_rows=mysql_fetch_array($_result,MYSQL_ASSOC) ){
	$_data[$i] = new myData();
	$_data[$i]->_date = $_rows['times'];
	$_data[$i]->_items[0] = array(	'fit_name' => $_rows['fit_name'],
									'part' => $_rows['part'],
									'num' => $_rows['num'],
									'gp' => $_rows['gp'],
									'place' => $_rows['place']
									 );
	// print_r($_data[0]);
}
while( !!$_rows=mysql_fetch_array($_result,MYSQL_ASSOC) ){
	if( $_data[$i]->_date == $_rows['times'] ){
		$_data[$i]->_items[count($_data[$i]->_items)] = array(	'fit_name' => $_rows['fit_name'],
																'part' => $_rows['part'],
																'num' => $_rows['num'],
																'gp' => $_rows['gp'],
																'place' => $_rows['place']
																 );
	}else{
		$_data[$i]->myRever();
		$i++;
		$_data[$i] = new myData();
		$_data[$i]->_date = $_rows['times'];
		$_data[$i]->_items[count($_data[$i]->_items)] = array(	'fit_name' => $_rows['fit_name'],
																'part' => $_rows['part'],
																'num' => $_rows['num'],
																'gp' => $_rows['gp'],
																'place' => $_rows['place']
																 );
	}
}
$_data[$i]->myRever();
// print_r($_data);

?>

<!-- modal 1 -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">添加一条锻炼项目</h4>
			</div>
			<div class="modal-body">
				<form class="form_add" class="form-horizontal" method="post" action="action/additems.php">
					<table class="table1">
						<tr>
							<td>锻炼项目名称</td>
							<td>
								<select name="fitname" id="sel_fit" class="form-control">
									<?php for( $i=0;$i<$alen;$i++ ){ ?>

									<option value="<?php echo $arr1[$i]; ?>"><?php echo $arr1[$i]; ?></option>
									<?php } ?>

								</select>
							</td>
						</tr>
						<tr>
							<td>锻炼部位</td>
							<td>
								<select name="fitpart" id="sel_part" class="form-control">
									<?php for( $i=0;$i<$alen;$i++ ){ ?>

									<option value="<?php echo $arr2[$i]; ?>"><?php echo $arr2[$i]; ?></option>
									<?php } ?>

								</select>
							</td>
						</tr>
					</table>
					<table class="table2">
						<tr>
							<td><input class="form-control" type="text" name="num" /></td>
							<td>个</td>
							<td><input class="form-control" type="text" name="gp" /></td>
							<td>组</td>
						</tr>
					</table>
					<table class="table3">
						<tr>
							<td>地点</td>
							<td>
								<select name="placename" id="sel_place" class="form-control">
									<?php for( $i=0;$i<$alen2;$i++ ){ ?>

									<option value="<?php echo $arr3[$i]; ?>"><?php echo $arr3[$i]; ?></option>
									<?php } ?>
									
								</select>
							</td>
						</tr>
					</table>
					<table class="table4">
						<tr>
							<td>日期（yyyy-mm-dd）</td>
							<td><input id="in_times" class="form-control" type="text" name="times" /></td>
							<td>
								<button id="btn_today" type="button" class="btn btn-default">今天</button>
							</td>
						</tr>
					</table>
					<input id="sub1" type="submit" value="提交">
				</form>
			</div>
			<div class="modal-footer">
				<button id="but1" class="btn btn-primary" type="button">Submit</button>
			</div>
		</div>
	</div>
</div>

<!-- modal 2 -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">添加锻炼项目</h4>
			</div>
			<div class="modal-body">
				<form class="form_add" class="form-horizontal" method="post" action="action/addfit.php">
					<table class="table1">
						<tr>
							<td>锻炼项目名称</td>
							<td>
								<input class="form-control" type="text" name="name">
							</td>
						</tr>
						<tr>
							<td>锻炼部位</td>
							<td>
								<input class="form-control" type="text" name="part">
							</td>
						</tr>
					</table>
					<input id="sub2" type="submit" value="提交">
				</form>
			</div>
			<div class="modal-footer">
				<button id="but2" type="button" class="btn btn-primary">Submit</button>
			</div>
		</div>
	</div>
</div>


<!-- top btn 按钮 -->
<div id="d_top">
	<div id="d_add">
		<img src="images/pencil_48.png" alt="add new">
		<p>add new</p>
	</div>
	<div id="d_add2">
		<img src="images/paper_content_pencil_48.png" alt="add new">
		<p>add new fitness name</p>
	</div>
	<div class="d_clear"></div>
</div>

<!-- 中间 mid -->
<div id="mid">
	<div id="d_title">
		<h1>My fitness plan and completion</h1>
	</div>
	<div id="d_cont">
		<div id="cont_top" class="row">
			<div class="col-xs-2">日期</div>
			<div class="col-xs-5">项目名称</div>
			<div class="col-xs-2">锻炼部位</div>
			<div class="col-xs-1">个数</div>
			<div class="col-xs-1">组数</div>
			<div class="col-xs-1">地点</div>
		</div>
		<!-- 1天1块的显示 -->
		<?php
		foreach ($_data as $variable) {
		?>

		<div class="d_record row">
			<div class="col-xs-2 vdate"><?php echo $variable->_date ?></div>
			<div class="col-xs-10">
				<table id="table_allcont" class="table table-striped">
					<!-- 将1天所有的信息输出 -->
					<?php
					foreach ($variable->_items as $variable2) {
					?>

					<tr>
						<td class="td1"><?php echo $variable2['fit_name']; ?></td>
						<td class="td2"><?php echo $variable2['part']; ?></td>
						<td class="td3"><?php echo $variable2['num']; ?></td>
						<td class="td4">
							<em class="em_down">-</em>
							<p><?php echo $variable2['gp']; ?></p>
							<em class="em_up">+</em>
						</td>
						<td class="td5"><?php echo $variable2['place']; ?></td>
					</tr>
					<?php } ?>

				</table>
			</div>
		</div>
		<?php } ?>

	</div>
	此处为页码，待开发
	<div id="d_page">
		<ul class="ul_toolbar">
			<li class="li_group"><a href="#">1</a></li>
			<li class="li_group"><a href="#">2</a></li>
			<li class="li_group"><a href="#">3</a></li>
		</ul>
	</div>
</div>

<!-- 统计 -->
<div id="d_count">
	<div id="d_count_title">
		<h1>Statistical data analysis</h1>
	</div>
	<div id="d_count_cont">
		<div class="row">
			<div id="dcount1" class="col-xs-6">
			</div>
			<div id="dcount2" class="col-xs-6">
			</div>
			<div id="dcount3" class="col-xs-12">
			</div>
		</div>
		<!-- <div class="row">
			<div id="dcount_bot" class="col-xs-12">
			</div>
		</div> -->
	</div>
</div>

<?php echo 'open this web cost '.round((_runtime() - START_TIME),4).'s.'?>

<script type="text/javascript" src="build/dist/echarts.js"></script>
<script type="text/javascript" src="js/echarts_count.js"></script>

</body>
</html>