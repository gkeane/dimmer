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
    $(document).ready(function() {
        var options = {
            chart: {
                renderTo: 'container',
                type: 'line',
                events: {
                load: function() {
                    this.renderer.image('Capture3.JPG',65,0,770,345).add();  // add image(url, x, y, w, h)
                }
            }
            },
            title : {
                text : 'Dimmer: '+dimmer_name+' Lamp: '+led_name
            },
            plotOptions: {
                line: {
                    marker: {
                        enabled: false
                    }
                }
            },
            xAxis:{
              title:{text:'Wavelength (nm)'}
            },
            yAxis:{
              title:{text:'Luminous power'}
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: []
        };
        $.getJSON('jsons.php?led='+led+'&dimmer='+dimmer, function(list) {
            options.series = list; // <- just assign the data to the series property.
            var chart = new Highcharts.Chart(options);
        });
    });
        </script>
    </head>
    <body>
    <div id="container" style="height: 400px; min-width: 500px"></div>
  </div><div style="height:200px;"></div>"
<?php include('footer.html');?>
