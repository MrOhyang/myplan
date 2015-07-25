$(function(){
	InitMap(
		$("#d1"),
		option = {
			xAxis : ['07-10','07-11','07-12','07-13'],
			yAxis : {
				type : '个',
				data : [60,92,70,20]
			}
		}
		);
	function InitMap(mymap,option){
		var w = mymap.css("width").replace("px","");
		var h = mymap.css("height").replace("px","");
		var w0 = 54;
		var h0 = 50;
		var w2 = w-w0;
		var h2 = h-30;
		
		var strtemp = '<canvas width="'+(w-4)+'" height="'+(h-4)+'" style="position:absolute;top:0;left:0;z-index:100;"></canvas>';
		mymap.css("position","relative");
		mymap.append(strtemp);
		strtemp = '<div style="position:absolute;display:none;padding:10px 20px;white-space:nowrap;background-color:#AAA;border-radius:10px;color:#FFF;z-index:1000;"></div>'
		mymap.append(strtemp);
		var can = document.getElementById(mymap.attr("id")).getElementsByTagName("canvas")[0];
		var context = can.getContext("2d");
		context.strokeStyle = "#0000DD";
		context.beginPath();
		context.moveTo(w0,h0);
		context.lineTo(w0,h2);
		context.lineTo(w2,h2);
		context.stroke();

		var yMax = option.yAxis.data[0];
		for(var i=1;i<option.yAxis.data.length;i++){
			if( yMax < option.yAxis.data[i] )
				yMax = option.yAxis.data[i];
		}
		yMax = Math.ceil(yMax/20.0)*20;

		var arrX = Array();
		for(var i=0;i<option.xAxis.length;i++){
			arrX[i] = w0 + (w2-w0)*((i)/(option.xAxis.length-1));
		}
		var arrY = Array();
		for(var i=0;i<=(yMax/20);i++){
			arrY[i] = h0 + (h2-h0)-(h2-h0)*((i)/(yMax/20));
		}

		// 在 x 轴上写下横坐标
		for(var i=0;i<arrX.length;i++){
			context.beginPath();
			context.font = "12px Arial";
			context.textAlign = "center";
			context.fillStyle = "#222";
			context.fillText(option.xAxis[i],arrX[i],h-12);
		}

		// 在 y 轴上写下横坐标
		for(var i=0;i<arrY.length;i++){
			context.beginPath();
			context.font = "12px Arial";
			context.textAlign = "right";
			context.textBaseline = "middle";
			context.fillStyle = "#222";
			context.fillText(i*20+option.yAxis.type,w0-6,arrY[i]);
		}

		/*
		* 画方格
		* 第1个 for 为横
		* 第2个 for 为纵
		*/
		for(var i=1;i<arrY.length;i++){
			context.beginPath();
			context.strokeStyle = "#CCC";
			context.moveTo(w0+1,arrY[i]+0.5);
			context.lineTo(w2,arrY[i]+0.5);
			context.stroke();
		}
		for(var i=1;i<arrX.length;i++){
			context.beginPath();
			context.strokeStyle = "#CCC";
			context.moveTo(arrX[i]+0.5,h0);
			context.lineTo(arrX[i]-0.5,h2-1);
			context.stroke();
		}

		// 画出折线图
		context.beginPath();
		context.strokeStyle = "#F00";
		context.moveTo(w0+1,h0+(h2-h0-(h2-h0)*(option.yAxis.data[0]/yMax))+0.5);
		for(var i=1;i<option.xAxis.length;i++){
			context.lineTo(w0+(w2-w0)*(i/(option.xAxis.length-1)),h0+(h2-h0-(h2-h0)*(option.yAxis.data[i]/yMax))+0.5);
		}
		context.stroke();




	
		strtemp = '<canvas width="'+(w-4)+'" height="'+(h-4)+'" style="position:absolute;top:0;left:0;z-index:200;"></canvas>';
		mymap.append(strtemp);
		can = document.getElementById(mymap.attr("id")).getElementsByTagName("canvas")[1];
		context = can.getContext("2d");
		context.lineWidth = 2;
		context.strokeStyle = "#8F8";
		// context.beginPath();
		// context.moveTo(w0+(w2-w0)*(1/3),h0);
		// context.lineTo(w0+(w2-w0)*(1/3),h2);
		// context.stroke();

		mymap.children("canvas").eq(1).mousemove(function(e){
			var x = e.clientX - $(this).parent().css("margin-left").replace("px","");
			var y = e.clientY - $(this).parent().css("margin-top").replace("px","");
			for(var i=0;i<option.xAxis.length-1;i++){
				if(arrX[i]<x && arrX[i+1]<x){
				}else{
					if( (x-arrX[i]) > (arrX[i+1]-x) )
						i++;
					break;
				}
			}
			// 清屏 画线
			context.clearRect(0,0,w,h);
			context.beginPath();
			context.moveTo(arrX[i],h0);
			context.lineTo(arrX[i],h2);
			context.stroke();

			// 画出矩形框
			if( i<(arrX.length-1) ){
				$(this).parent().children("div").css({
					display : "block",
					top : y+26,
					left : arrX[i]+10
				});
			}else{
				$(this).parent().children("div").css({
					display : "block",
					top : y+26,
					left : arrX[i] - $(this).parent().children("div").css("width").replace("px","") - 10
				});
			}

			// 写出数值
			$(this).parent().children("div").html(option.xAxis[i]+'<br />'+option.yAxis.data[i]+option.yAxis.type);
		});
	}
})