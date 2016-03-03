<?php
header("Content-type: text/html");
// connect to the database
$mysqlserver="localhost";
$mysqlusername="dimmer";
$mysqlpassword="8Jx43c8JMnvY7e9Z";
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
$led = isset($_GET['led']) ? $_GET['led'] : 'INC';
$led= htmlspecialchars($led);
$dim = isset($_GET['dimmer']) ? $_GET['dimmer'] : 'B1';
$dimmer= htmlspecialchars($dim);
//$dimmer='A1';
//$led='LED1';
$resultf = array();
$strings=array(
array('10per', '10 percent'),
array('20per', '20 percent'),
array('30per', '30 percent'),
array('40per', '40 percent'),
array('50per', '50 percent'),
array('60per', '60 percent'),
array('70per', '70 percent'),
array('80per', '80 percent'),
array('90per', '90 percent'),
array('100per', '100 percent'),
);
//$strings=array('10per','20per','30per','40per','50per','60per','70per','80per','90per','100per');

foreach ($strings as &$string){
  //var_dump($string);
  $SQL = "SELECT nm, ".$string[0]." FROM $tablename WHERE dimmer=\"$dimmer\" and led=\"$led\" ORDER BY nm";
  //echo $SQL;
  $result = mysqli_query($db,$SQL) or die ("Query to get data from dimmer failed: ".mysqli_error($db));
  //$cdresult=mysqli_query($link,$cdquery) or die ("Query to get data from dimmer failed: ".mysqli_error());
  $rows=array();
  $rows['name'] = $string[1];
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
