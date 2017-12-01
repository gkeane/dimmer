<?php
header("Content-type: text/html");
// connect to the database
include 'db.php';
$db=mysqli_connect($mysqlserver, $mysqlusername, $mysqlpassword) or die ("Error connecting to mysql server: ".mysqli_error());

$dbname = 'dimmer';
$tablename = "spectral";
$val=0.0;


mysqli_select_db( $db,$dbname) or die ("Error selecting specified database on mysql server: ".mysqli_error());
/*
if (is_numeric($_GET["loc"])){
 $loc = $_GET["loc"];
}
else
$loc = 0;
if (is_numeric($_GET["trap"])){
 $trap = $_GET["trap"];
}
else
$year = 0;
if (is_numeric($_GET["year"])){
 $year = $_GET["year"];
}
else

$year = 0; */
$led = isset($_GET['led']) ? $_GET['led'] : 'LED1';
if (strlen($led)>6){echo "error"; exit();}
$led= htmlspecialchars($led);
$dim = isset($_GET['dimmer']) ? $_GET['dimmer'] : 'A1';
if (strlen($dim)>6){echo "error"; exit();}
$dimmer= htmlspecialchars($dim);
//$dimmer='A1';
//$led='LED1';
$resultf = array();
$strings=array(
array('10per', '10 percent','#7cb5ec'),
array('20per', '20 percent','#91e8e1'),
array('30per', '30 percent','#90ed7d'),
array('40per', '40 percent','#f7a35c'),
array('50per', '50 percent','#8085e9'),
array('60per', '60 percent','#f15c80'),
array('70per', '70 percent','#e4d354'),
array('80per', '80 percent','#8085e8'),
array('90per', '90 percent','#8d4653'),
array('100per', '100 percent','#000000')
);
//$strings=array('10per','20per','30per','40per','50per','60per','70per','80per','90per','100per');

foreach ($strings as &$string){
  //var_dump($string);
  $sql = "SELECT nm, ".$string[0]." FROM $tablename WHERE dimmer=? and led=? ORDER BY nm";
  $stmt=$db->prepare($sql);//ho $sql;
  $stmt->bind_param('ss', $dimmer,$led);
  $stmt->execute();
  //echo $SQL;
  $result = $stmt->get_result();
  //$cdresult=mysqli_query($link,$cdquery) or die ("Query to get data from dimmer failed: ".mysqli_error());
  $rows=array();
  $rows['name'] = $string[1];
  $rows['color'] = $string[2];
  while($r = mysqli_fetch_array($result)) {
      //echo $r['nm'];

      $rt=array($r['nm'],$r[1]);
      $rows['data'][] = $rt;
  }
  //var_dump($rows);
  array_push($resultf,$rows);
}
//var_dump($resultf);
print json_encode($resultf, JSON_NUMERIC_CHECK);


;
?>
