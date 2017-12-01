<?php include('header.html');?>
<?php


$led = isset($_GET['led']) ? $_GET['led'] : 'LED1';
if (strlen($led)>6){echo "error"; exit();}
$led= htmlspecialchars($led);
$dim = isset($_GET['dimmer']) ? $_GET['dimmer'] : 'A1';
if (strlen($dim)>6){echo "error"; exit();}
$dimmer= htmlspecialchars($dim);
include 'db.php';
$link=mysqli_connect($mysqlserver, $mysqlusername, $mysqlpassword) or die ("Error connecting to mysql server: ".mysqli_error());

$dbname = 'dimmer';
mysqli_select_db( $link,$dbname) or die ("Error selecting specified database on mysql server: ".mysqli_error());
$sql="SELECT actual FROM dimmer_names WHERE dimmer = ?";
$stmt=$link->prepare($sql);//ho $sql;
$stmt->bind_param('s', $dimmer);
$stmt->execute();
$data = $stmt->get_result();
$get=$data->fetch_assoc();
$dimmer_name=$get['actual'];
$sql="SELECT actual FROM led_names WHERE led = ?";
$stmt=$link->prepare($sql);//ho $sql;
$stmt->bind_param('s', $dimmer);
$stmt->execute();
$data = $stmt->get_result();
$get=$data->fetch_assoc();
$led_name=$get['actual'];
//echo $dimmer_name." stuff".$led_name;

$script = ("<script language=\"JavaScript\">
<!-- Begin array
var names= new Array();\n");
$script .= ("dimmer=\"".$dimmer."\"\n");
$script .= ("led=\"".$led."\"\n");
$script .= ("dimmer_name=\"".$dimmer_name."\"\n");
$script .= ("led_name=\"".$led_name."\"\n");
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
    $.getJSON('jsony.php?led='+led+'&dimmer='+dimmer, function(data) {
        // Create the chart
        chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'container',
                    type: 'spline',
                    marginRight: 130,
                    marginBottom: 25,
                    zoomType: 'xy'
                },

            title : {
                text : 'Dimmer: '+dimmer_name+' Lamp: '+led_name
            },

            yAxis: [{
              labels: {
                format: '{value}',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
                title: {
                    text: 'Lumens',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                }
            }, {
              labels: {
                format: '{value}',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
                title: {
                    text: 'Efficiency',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                opposite: true
            }],
            tooltip: {
              shared: true
            },
            xAxis: {
              title: {
                text: 'Temperature'
            },
                categories: ['100','90','80','70','60','50','40','30','20','10'],
                crosshair: true
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                x: 720,
                verticalAlign: 'top',
                y: 50,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            series: [{
                type: 'spline',
                name: 'Lumens',
                yAxis: 0,
                data: data[0].data,
                marker: {
                   enabled: false
                }
            }, {
                type: 'spline',
                name: 'Efficiency',
                yAxis: 1,
                data: data[1].data,
                marker: {
                   enabled: false
                }
             }]
    });
   });
 });
});
        </script>
    </head>
    <body>
    <div id="container" style="height: 400px; min-width: 500px"></div>
  </div><div style="height:200px;"></div>"
<?php include('footer.html');?>
