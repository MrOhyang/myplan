$(function(){

	// 路径配置
    require.config({
        paths: {
            echarts: 'build/dist'
        }
    });

    EchartAjax(
    	['肱二头肌','肱三头肌','手部肌肉'],
    	document.getElementById("dcount1"),
    	'line',
    	'macarons'
    );
    EchartAjax(
    	['胸肌','腹肌'],
    	document.getElementById("dcount2"),
    	'line',
    	'macarons'
    );
    EchartAjax(
    	['肱二头肌','肱三头肌','手部肌肉','胸肌','腹肌'],
    	document.getElementById("dcount3"),
    	'bar',
    	'default'
    );

    function NewSeriesArray(partname,arrPart,etype){
		var ReValue = Array();
		for( var i=0;i<partname.length;i++ ){
			ReValue.push( {
				name : partname[i],
				type : etype,
				data : arrPart[partname[i]],
				markPoint : {
					data : [
						{type : 'max', name: '最大值'},
	                	{type : 'min', name: '最小值'}
					]
				}
				// markLine : {
				// 	data : [
				// 		{type : 'average', name: '平均值'}
				// 	]
				// }
			} );
		}
		return ReValue;
	}

	function NewXaxis(arrDate,etype){
		var temp = {
			type : 'category',
            data : arrDate
		};
		if( etype == 'line' )
			temp.boundaryGap = false;
		return temp;
	}

    function EchartAjax(partname,domobj,etype,choosetheme){
    	$.ajax({
			type:'POST',
			url:'ajax/count1.php',
			data:{
				parts : partname
			},
			dataType:'json',
			success:function (response, status, xhr) {

				var arrDate = Array();

				for(var temp in response.arrDate){
					arrDate.push( response.arrDate[temp].substring(5,10) );
				}

				var newseries = NewSeriesArray(partname,response.arrPart,etype);
				var newxaxis = NewXaxis(arrDate,etype);

				console.log(arrDate);

				// 使用
			    require(
			        [
			            'echarts',
			            'echarts/chart/line', // 使用柱状图就加载line模块，按需加载
			            'echarts/chart/bar' // 使用柱状图就加载bar模块，按需加载
			        ],
			        function (ec) {
			            // 基于准备好的dom，初始化echarts图表
			            var myChart = ec.init(domobj);
			            
			            var option = {
			            	title : {
						        text: '肌肉锻炼量',
						        subtext: '计划值'	
						    },
						    tooltip : {
						        trigger: 'axis'
						    },
						    legend : {
						        data: partname
						    },
						    toolbox : {
						        show : true,
						        feature : {
						            // mark : {show: true},
						            // dataView : {show: true, readOnly: false},
						            magicType : {show: true, type: ['line', 'bar']},
						            restore : {show: true}
						            // saveAsImage : {show: true}
						        }
						    },
						    calculable : true,
						    xAxis : [
						        newxaxis
						    ],
						    yAxis : [
						        {
						            type : 'value',
						            axisLabel : {
						                formatter: '{value} 个'
						            }
						        }
						    ],
						    series : newseries
			            };

			            // 为echarts对象加载数据 
			            myChart.setOption(option);

			            myChart.setTheme(choosetheme);
			            // myChart.setTheme('macarons');
			            // myChart.setTheme('helianthus');		// 不可用
			        }
			    );
			}
		});
    }

});