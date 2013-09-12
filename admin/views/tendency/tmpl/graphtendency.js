jQuery(document).on('ready', init_graphline);
		
function init_graphline() {

	var lang = kendo.cultures.current.name;
    var textMonths = kendo.cultures[lang].calendar.months.namesAbbr;
    var months = calcMonths(paramsGraph.dstart,paramsGraph.dend);
    var myCategories = [];
    for(i in months) {
        myCategories.push(textMonths[months[i].month-1]+" "+months[i].year);
    }

    var chart = new Highcharts.Chart({
        chart: {
            renderTo: 'render-graph',
            type: 'line',
            marginBottom: 80,
            height: 500
        },
        xAxis: {
            categories: myCategories
        },
        yAxis: {
            title: {
                text: TotalSurvLang.VIEW_TENDENCY_TITLE_YAXIS
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        title: {
        	text: ''
        },
        tooltip: {
            formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+
                    this.x +': '+ this.y;
            }
        },
        series: data_series
    });
}
function calcMonths(dst, den) {

    var part = dst.split("-");
    var dsY = parseInt(part[0]);
    var dsM = parseInt(part[1]);

    part = den.split("-");
    var deY = parseInt(part[0]);
    var deM = parseInt(part[1]);

    var ms = [];
    while(dsY != deY || dsM != deM) {

        ms.push({month: dsM, year: dsY});

        if(dsM%12 == 0) {
            dsY++;
        }
        dsM = dsM%12 + 1;
    }
    ms.push({month: dsM, year: dsY});
    return ms;

}