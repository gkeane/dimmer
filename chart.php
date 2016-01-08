<?php include('header.html');?>
<?php


$led = isset($_GET['led']) ? $_GET['led'] : 'LED1';
$led= htmlspecialchars($led);
$dim = isset($_GET['dimmer']) ? $_GET['dimmer'] : 'A1';
$dimmer= htmlspecialchars($dim);

$script = ("<script language=\"JavaScript\">
<!-- Begin array
var names= new Array();\n");
$script .= ("dimmer=\"".$dimmer."\"\n");
$script .= ("led=\"".$led."\"\n");
$script .= ('// End -->
</script>');
echo $script;





?>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>
    <script type="text/javascript">
$(function() {
  var chart;
  $(document).ready(function() {
    $.getJSON('jsony.php?led='+led+'&dimmer='dimmer, function(data) {
        // Create the chart
        chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'container',
                    type: 'line',
                    marginRight: 130,
                    marginBottom: 25,
                    zoomType: 'xy'
                },

            title : {
                text : 'Dimmer'
            },

            yAxis: [{
              labels: {
                format: '{value}',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
                title: {
                    text: 'Lumens',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, {
              labels: {
                format: '{value}',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
                title: {
                    text: 'Efficiency',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            tooltip: {
              shared: true
            },
            xAxis: {
                categories: ['100','90','80','70','60','50','40','30','20','10'],
                crosshair: true
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                x: 120,
                verticalAlign: 'top',
                y: 100,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            series: [{
                type: 'line',
                name: 'Lumens',
                yAxis: 0,
                data: data[0].data,
            }, {
                type: 'line',
                name: 'Efficiency',
                yAxis: 1,
                data: data[1].data
             }]
    });
   });
 });
});
        </script>
    </head>
    <body>
    <div id="container" style="height: 500px; min-width: 500px"></div>
<?php include('footer.html');?>
