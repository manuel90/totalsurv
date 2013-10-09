jQuery(document).on('ready', init_chart);

function init_chart() {
	var type = "";
	if(graphtype == 'graphbar') {
		type = "column";
	} else {
		type = "pie";
	}
	for(idx in questionsCharts) {
		var item = questionsCharts[idx];
		var configChart = getConfigChart({ renderTo: 'render-graph'+item.id, typegraph: type, categories: categoriesChart, data: dataGraphJson['question'+item.id]});
		var chart = new Highcharts.Chart(configChart);
	}

}

function getConfigChart(params) {
	var total = 0;
	for(idx in params.data) {
		total += params.data[idx].y;
	}
	return {
        chart: {renderTo: params.renderTo,type: params.typegraph},
        xAxis: {categories: params.categories, title: {text: TotalSurvLang.COM_TOTALSURV_LABEL_SCORES}},
        yAxis: {title: {text: TotalSurvLang.VIEW_GRAPHS_TITLE_YAXIS}},
        title: {
        	text: TotalSurvLang.VIEW_GRAPHS_LABEL_TOTAL.replace("%s",total),
        	align: "left",
        	x: 30
        },
        plotOptions: {
            column: {
                dataLabels: {
                    enabled: true,
                    color: "#000000",//4572A7
                    style: {
                        fontWeight: 'bold'
                    },
                    formatter: function() {
                        return this.y;
                    }
                }
            },
            pie: {
                dataLabels: {
                    enabled: true,
                    color: "#this.point.name",
                    style: {
                        fontWeight: 'normal'
                    },
                    formatter: function() {
                        return this.point.name+':<b>'+this.y+'</b>';
                    }
                }
            }
        },
        tooltip: {
            formatter: function() {
                return this.point.name+':<b>'+ this.y +'</b>';
            }
        },
        series: [{name: TotalSurvLang.VIEW_GRAPHS_TITLE_YAXIS,data: params.data}],
        exporting: {enabled: false}
    };
}