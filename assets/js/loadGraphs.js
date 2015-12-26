var loadCharts = function () {
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    })
    
    getPieData(loadPieChart);
    getBarData(loadBarChart);
    getProgressData(loadProgressChart);

};



var getPieData = function(callback){
    $.get( "/CI/Api/getPieData", function(data) {
        console.log(data)
        data = JSON.parse(data)
        // var data = [
                // ['Walking',   12.7],
                // ['Still',       74.6],
                // {
                    // name: 'Running',
                    // y: 12.8,
                    // sliced: true,
                    // selected: true
                // },
                // ['Cycling',    1.2],
                // ['Car',   15.6]
            // ];
    callback(data)
    })
}

var loadPieChart = function(graphData){
    $("#pieDiv").highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'Exercise Levels'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Browser share',
            data: graphData
        }]
    })
}

var getBarData = function(callback){
    $.get( "/CI/Api/getBarData", function(data) {
        data = JSON.parse(data)
        // var data = [
            // {
                // name: 'Still',
                // data: [25, 25, 25, 25]
            // } , {
                // name: 'Walking',
                // data: [25, 25, 25, 25]
            // }, {
                // name: 'Running',
                // data: [new Date(), 25, 25, 25, 25]
            // }, {
                // name: 'Cycling',
                // data: [new Date(), 25, 25, 25, 25]
            // }, {
                // name: 'Car',
                // data: [new Date(), 25, 25, 25, 25]
            // }
        // ]
    callback(data)
    })
}

var loadBarChart = function(graphData){
    pieChart = $("#barDiv").highcharts({
        chart: {
            type: 'column',
            options3d: {
                enabled: true,
                alpha: 6,
                beta: 7
            }
        },
        title: {
            text: 'Daily Exercise Distribution'
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: { // don't display the dummy year
                month: '%e. %b',
                year: '%b'
            },
            title: {
                text: 'Date'
            }
        },
        yAxis: {
            min: 0,
            max: 100,
            title: {
                text: 'Exercise Distribution'
            },
            stackLabels: {
                enabled: false,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>'
            }
        },
        plotOptions: {
            column: {
                pointStart: Date.UTC(graphData.date.year, graphData.date.month, graphData.date.day),
                pointInterval: 24 * 3600 * 1000,
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 3px black'
                    }
                }
            }
        },
        series: graphData.serie
    })
}

var getProgressData = function(callback){
    $.get( "/CI/Api/getProgressData", function(data) {
        data = JSON.parse(data)
    callback(data)
    })
}

var loadProgressChart = function(graphData){
    pieChart = $("#progressDiv").highcharts({
        chart: {
            type: 'line',
            options3d: {
                enabled: true,
                alpha: 6,
                beta: 7
            }
        },
        title: {
            text: 'Daily Walking average'
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: { // don't display the dummy year
                month: '%e. %b',
                year: '%b'
            },
            title: {
                text: 'Date'
            },
            gridLineWidth:1
        },
        yAxis: {
            min: 0,
            max: 100,
            title: {
                text: 'Walking Average'
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            },
        },
        legend: {
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>' +
                    'Total: ' + this.point.stackTotal;
            }
        },
        plotOptions: {
            line: {
                pointStart: Date.UTC(graphData.date.year, graphData.date.month, graphData.date.day),
                pointInterval: 24 * 3600 * 1000,
                stacking: 'normal',
                dataLabels: {
                    enabled: false,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 3px black'
                    }
                }
            }
        },
        series: graphData.serie
    })
}

$(document).ready(loadCharts)