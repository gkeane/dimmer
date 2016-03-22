<?php include('header.html');?>
<?php


$led = isset($_GET['led']) ? $_GET['led'] : 'LED1';
$led= htmlspecialchars($led);
$dim = isset($_GET['dimmer']) ? $_GET['dimmer'] : 'A1';
$dimmer= htmlspecialchars($dim);
$mysqlserver="localhost";
$mysqlusername="dimmer";
$mysqlpassword="8Jx43c8JMnvY7e9Z";
$link=mysqli_connect($localhost, $mysqlusername, $mysqlpassword) or die ("Error connecting to mysql server: ".mysqli_error());

$dbname = 'dimmer';
mysqli_select_db( $link,$dbname) or die ("Error selecting specified database on mysql server: ".mysqli_error());

$get = mysqli_fetch_assoc(mysqli_query($link, "SELECT actual FROM dimmer_names WHERE dimmer = '".$dimmer."'"));
$dimmer_name=$get['actual'];
$get = mysqli_fetch_assoc(mysqli_query($link, "SELECT actual FROM led_names WHERE led = '".$led."'"));
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
