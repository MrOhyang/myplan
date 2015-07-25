$(function(){

	// 模态框
	$("#d_add").click(function(){
		$("#myModal").modal();
	});

	// 模态框
	$("#d_add2").click(function(){
		$("#myModal2").modal();
	});

	// 设置 modal1 的默认值
	$("input#in_times").val(GetNowTime());

	$("button#btn_today").click(function(){
		$("input#in_times").val(GetNowTime());
	});


	// 设置 提交 函数
	$("button#but1").click(function(){
		$("input#sub1").click();
	});
	$("button#but2").click(function(){
		$("input#sub2").click();
	});

	// 设置 select option 选项的内容
	$("select#sel_fit").change(function(){
		var curIndex = this.selectedIndex;
		document.getElementById("sel_part").options[curIndex].selected = true;
	});

	// 控制 ul li group 样式
	for( var i=0;i<$("ul.ul_toolbar").length;i++ ){
		$("ul.ul_toolbar").eq(i).children("li.li_group:first").css({
			"border-left" : "1px #DDD solid",
			"border-radius" : "6px 0 0 6px"
		});
		$("ul.ul_toolbar").eq(i).children("li.li_group:last").css({
			"border-radius" : "0 6px 6px 0"
		});
	}

});

// 点击 + - 按钮 up 或者 down 组数
$(function(){

	$("table#table_allcont").delegate("em.em_up","click",function(){
		var _gp = $(this).parent().children("p").text();
		var _fitname = $(this).parent().prev().prev().prev().text();
		var _date = $(this).parent().parent().parent().parent().parent().prev().text();
		
		UpDownAjax(_fitname,_gp,_date,1,$(this));		
	});

	$("table#table_allcont").delegate("em.em_down","click",function(){
		var _gp = $(this).parent().children("p").text();
		var _fitname = $(this).parent().prev().prev().prev().text();
		var _date = $(this).parent().parent().parent().parent().parent().prev().text();
		
		UpDownAjax(_fitname,_gp,_date,-1,$(this));
	});

	function UpDownAjax(_fitname,_gp,_date,_type,obj){
		$.ajax({
			type: 'POST',
			url:'ajax/updown.php',
			data:{
				fitname : _fitname,
				gp : _gp,
				date : _date,
				type : _type
			},
			// dataType:'json',
			success:function (response, status, xhr) {
				if( response >=0 ){
					obj.parent().children("p").text(response);
				}else{
					alert("操作失败");
				}
			}
		});
	}

})